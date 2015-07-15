/**
 * JQuery shiftcheckbox plugin
 *
 * shiftcheckbox provides a simpler and faster way to select multiple checkboxes within a given range with just two clicks
 *
 * Just call $.shiftcheckbox.init(<class-name>) in $(document).ready
 *
 * @name shiftcheckbox
 * @type jquery
 * @cat Plugin/Form
 * @return JQuery
 * @author Aditya Mooley <adityamooley@sanisoft.com>, Nina Trujillo
 *
 * Modified by Chris Boulton to add simple support directly for ISC.
 * - We match anything in .GridPanel rather than the old class based names because it means
 *   that jQuery can use the native browser functions if possible, rather than the slower
 *   jQuery parsed matching. It also means the implementation is fully automagic.
 */

jQuery.shiftcheckbox =  {
	prevChecked: null,
	eleName: '',

	init: function(en) {
		jQuery.shiftcheckbox.eleName = en;

		/*jQuery("input[@type=checkbox][@class*="+jQuery.shiftcheckbox.eleName+"]").each(function(i) {
			jQuery(this).bind("click", jQuery.shiftcheckbox.handleClick);
		}); */
	   jQuery(".GridPanel input[@type=checkbox]").each(function(i) {
			jQuery(this).bind("click", jQuery.shiftcheckbox.handleClick);
		});
	},

	handleClick: function (event)
	{
		var val = this.value;
		var checkStatus = this.checked;
		//get the checkbox number which the user has checked

		//check whether user has pressed shift
		if (event.shiftKey && checkStatus) {
			if (jQuery.shiftcheckbox.prevChecked != 'null') {
				//get the current checkbox number
				var ind = 0, found = 0, currentChecked;
				currentChecked = jQuery.shiftcheckbox.getSelected(val);

				//Uncheck all the checkboxes first
				jQuery.shiftcheckbox.uncheckAll();

				ind = 0;
				if (currentChecked < jQuery.shiftcheckbox.prevChecked) {
					//jQuery("input[@type=checkbox][@class*="+jQuery.shiftcheckbox.eleName+"]").each(function(i) {
					jQuery(".GridPanel input[@type=checkbox]").each(function(i) {
						if (ind >= currentChecked && ind <= jQuery.shiftcheckbox.prevChecked) {
							this.checked = true;
						}
						ind++;
					});
				} else {
					//jQuery("input[@type=checkbox][@class*="+jQuery.shiftcheckbox.eleName+"]").each(function(i) {
					jQuery(".GridPanel input[@type=checkbox]").each(function(i) {
						if (ind >= jQuery.shiftcheckbox.prevChecked && ind <= currentChecked) {
							this.checked = true;
						}
						ind++;
					});
				}
			}
		} else {
			if (checkStatus) {
				jQuery.shiftcheckbox.prevChecked = jQuery.shiftcheckbox.getSelected(val);
			}
		}
	},

	getSelected: function (val)
	{
		var ind = 0, found = 0, checkedIndex;

		//jQuery("input[@type=checkbox][@class*="+jQuery.shiftcheckbox.eleName+"]").each(function(i) {
			jQuery(".GridPanel input[@type=checkbox]").each(function(i) {
			if (val == this.value && found != 1) {
				checkedIndex = ind;
				found = 1;
			}
			ind++;
		});

		return checkedIndex;
	},

	uncheckAll: function()
	{
		//jQuery("input[@type=checkbox][@name*="+jQuery.shiftcheckbox.eleName+"]").each(function(i) {this.checked = false;});
		jQuery(".GridPanel input[@type=checkbox]").each(function(i) {this.checked = false;});
	}
};