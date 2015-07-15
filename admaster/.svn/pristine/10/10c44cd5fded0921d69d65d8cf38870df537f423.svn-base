/*
Flot plugin for rendering circles charts. The plugin assumes the data is
coming is as a single data value for each series, and each of those 
values is a positive value or zero (negative numbers don't make 
any sense and will cause strange effects). The data values do 
NOT need to be passed in as percentage values because it 
internally calculates the total and percentages.

* Created by Brian Medendorp, June 2009
* Updated November 2009 with contributions from: btburnett3, Anthony Aragues and Xavi Ivars

* Changes:

*/

(function($){
     function init(plot) {
         var canvas = null;
         var target = null;
         var radius = null;
         var centerLeft = null;
		 var centerTop = null;
         var maxRadius = null;
         var y = -Infinity;
         var redraw = true;
         var redrawAttempts = 10;
         var legendWidth = 0;
         var processed = false;
         var raw = false;

         var highlights = [];
         var v = null;

         plot.hooks.processOptions.push(checkCircleEnabled);
         plot.hooks.bindEvents.push(bindEvents);

         function checkCircleEnabled(plot, options) {
             if (options.series.circles.show) {
                 options.grid.show = false;
                 if (options.series.circles.label.show == 'auto')
                     if (options.legend.show) {
                        options.series.circles.label.show = false;
                     } else options.series.circles.label.show = true;
                 plot.hooks.processDatapoints.push(processDatapoints);
                 plot.hooks.drawOverlay.push(draw);
                 plot.hooks.draw.push(draw);
             }
         }

         function bindEvents(plot, eventHolder) {
             var options = plot.getOptions();
             if (options.series.circles.show && options.grid.hoverable)
                 eventHolder.unbind('mousemove').mousemove(onMouseMove);
             if (options.series.circles.show && options.grid.clickable)
                 eventHolder.unbind('click').click(onClick);
         }

         function calcTotal(data)
		 {
			 for (var i = 0; i < data.length; ++i)
			 {
				 var item = parseFloat(data[i].data[0][1]);
				 if (item > y ) y = item;
			 }
		 }

         function setupCircle() {
             centerTop = (canvas.height / 2) + options.series.circles.offset.top;
             centerLeft = (canvas.width / 2);
             legendWidth = target.children().filter('.legend').children().width();

             if (options.series.circles.offset.left == 'auto') {
                 if (options.legend.position.match('w')) {
                     centerLeft += legendWidth / 2;
                 } else
                     centerLeft -= legendWidth / 2;
             } else
                 centerLeft += options.series.circles.offset.left;

             var left = options.series.circles.offset.left;
             if (left == 'auto') left = 0;

             maxRadius = Math.min(canvas.height - options.series.circles.offset.top, canvas.width - legendWidth - left);
         }

         function fixData2(data) {
             for (var i = 0; i < data.length; ++i) {
                 var zm = parseFloat(data[i].data[0][1]);
                 data[i].radius = maxRadius * (options.scalingFunction(zm) / options.scalingFunction(y)) / 2;
                 data[i].centerX = centerLeft;
                 data[i].centerY = canvas.height - data[i].radius;
             }
             return data;
         }

         function processDatapoints(plot, series, data, datapoints) {
             if (!processed) {
                 processed = true;
                 canvas = plot.getCanvas();
                 target = $(canvas).parent();
                 options = plot.getOptions();
             }
         }

         function fixData(data)
		 {
			for (var i = 0; i < data.length; ++i)
			{
				if (typeof(data[i].data)=='number')
					data[i].data = [[1,data[i].data]];
				else if (typeof(data[i].data)=='undefined' || typeof(data[i].data[0])=='undefined')
				{
					if (typeof(data[i].data)!='undefined' && typeof(data[i].data.label)!='undefined')
						data[i].label = data[i].data.label; // fix weirdness coming from flot
					data[i].data = [[1,0]];

				}
			}
			return data;
		 }

         function combine(data) {
            data = fixData(data);
            calcTotal(data);
            setupCircle();
            data = fixData2(data);
            return data;
         }

         function draw(plot, newCtx) {
            if (!target) return;
             ctx = newCtx;

             plot.setData(combine(plot.getData()));
             var slices = plot.getData();

             clear();
             drawCircles();

             function clear() {
                 ctx.clearRect(0, 0, canvas.width, canvas.height);
                 target.children().filter('.circlesLabel, .circlesLabelBackground').remove();
             }

             function drawCircles() {
                 ctx.save();
                 for (var i = 0; i < slices.length; ++i) {
                     drawSlice(slices[i].centerX, slices[i].centerY, slices[i].radius, slices[i].color, true);
                     if (i == v) {
                         var color = "rgba(255, 255, 255, " + options.series.circles.highlight.opacity + ")";
                         drawSlice(slices[i].centerX, slices[i].centerY, slices[i].radius, color, true);
                     }
                 }

                 ctx.restore();
                 ctx.save();
                 ctx.lineWidth = options.series.circles.stroke.width;
                 for (var i = 0; i < slices.length; ++i)
                     drawSlice(slices[i].centerX, slices[i].centerY, slices[i].radius, options.series.circles.stroke.color, false);
                 ctx.restore();

                 if (options.series.circles.label.show) drawLabel();

                 function drawSlice(aX, aY, aStartAngle, color, fill) {
                     if (fill) {
                        ctx.fillStyle = color;
                     } else {
                         ctx.strokeStyle = color;
                         ctx.lineJoin = 'round';
                     }
                     ctx.beginPath();
                     ctx.arc(aX, aY, aStartAngle, 0, Math.PI * 2, true);

                     if (fill) {
                         ctx.fill();
                     } else
                         ctx.stroke();
                 }

                 function drawLabel() {
                    return;
                 }
             }
         }

         function findNearbySlice(mouseX, mouseY) {
             var slices = plot.getData();
             var options = plot.getOptions();
             var zn = null;
             for (var i = 0; i < slices.length; ++i) {
                 var s = slices[i];
                 d = Math.pow(Math.pow(mouseX - s.centerX, 2) + Math.pow(mouseY - s.centerY, 2), .5);
                 if (d <= s.radius)
                     zn = {
                         datapoint: s.data,
                         dataIndex: 0,
                         series: s,
                         seriesIndex: i
                     };
             }
             var zq = v;
             if (zn) {
                v = zn.seriesIndex;
             } else
                 v = null;
             if (zq != v) redraw = true;

             return zn;
         }

         function onMouseMove(options) {
            triggerClickHoverEvent('plothover', options);
         }

         function onClick(options) {
            triggerClickHoverEvent('plotclick', options);
         }

         function triggerClickHoverEvent(eventname, e) {
             var offset = plot.offset();
             var canvasX = parseInt(e.pageX - offset.left);
             var canvasY = parseInt(e.pageY - offset.top);
             var zq = v;
             var item = findNearbySlice(canvasX, canvasY);
             if (zq != v) {
                 redraw = true;
                 plot.triggerRedrawOverlay();
             }
             var pos = {
                 pageX: e.pageX,
                 pageY: e.pageY
             };
             target.trigger(eventname, [pos, item]);
         }
     }

     var options = {
         series: {
             circles: {
                 show: false,
                 offset: {
                     top: 0,
                     left: 'auto'
                 },
                 stroke: {
                     color: '#FFF',
                     width: 1
                 },
                 label: {},
                 highlight: {
                    opacity: .3
                 }
             }
         },

         scalingFunction: function(fixData) {
            return Math.pow(fixData, (1 / 3));
         }
     };

     $.plot.plugins.push({
         init: init,
         options: options,
         name: "circles",
         version: "0.1"
     });
 })(jQuery);