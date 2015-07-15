<head>
	<title>%%GLOBAL_ControlPanelTitle%%</title>
	<meta http-equiv="Content-Type" content="text/html; charset=%%GLOBAL_CharacterSet%%" />
	<meta name="robots" content="noindex, nofollow" />
	<style type="text/css">
		@import url("Styles/styles.css");
		@import url('Styles/tabmenu.css');
		@import url("Styles/iselector.css");
		@import url('../javascript/jquery/plugins/imodal/imodal.css');
		@import url('Styles/iconsearchbox.css');
		@import url('../javascript/jquery/plugins/stars.rating/ui.stars.css');
		%%GLOBAL_AdditionalStylesheets%%
	</style>
	<link rel="SHORTCUT ICON" href="favicon.ico" />
	<!--[if IE]>
	<style type="text/css">
		@import url("Styles/ie.css");
	</style>
	<![endif]-->
	<link rel="stylesheet" href="Styles/thickbox.css" type="text/css" media="screen" />      
    <link rel="stylesheet" href="Styles/timePicker.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="Styles/ui.datepicker.css" type="text/css" media="screen" /> 

	<script type="text/javascript" src="../javascript/jquery.js"></script>
	<script type="text/javascript" src="script/menudrop.js"></script>
	<script type="text/javascript" src="script/common.js"></script>
	<script type="text/javascript" src="../javascript/adminiselector.js"></script>
	<script type="text/javascript" src="../javascript/thickbox.js"></script>
	<script type="text/javascript" src="../javascript/jquery/plugins/shiftcheckbox.js"></script>
	<script type="text/javascript" src="../javascript/jquery/plugins/ui.core.js"></script>
	<script type="text/javascript" src="../javascript/jquery/plugins/imodal/imodal.js"></script>
	<script type="text/javascript" src="../javascript/jquery/plugins/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="../javascript/jquery/plugins/stars.rating/ui.stars.js"></script>
	
	<script type="text/javascript">
	//wirror_20100728: add tabs on this page
	$(function(){
		if($(parent.document.body).find('.Intro .MessageBox').get() != "") {
			$(parent.document.body).find('.Intro .MessageBox').remove();
		}
	
		if($('#visitURL').val().length == 0)
			$('#visitURL').val('%%GLOBAL_ShopPath%%/'+MakeSafeURL($("#categorybox").find("option:selected").text()));
		var visitObj = {'category': '', 'subcategory': '', 'brand': '', 'series': ''};

	    $("select", ".Panel").change(function(){
	    	switch(this.id){
	    		case "categorybox":
	    		{
					$('#subcategorybox').attr("value", 0);
	    			ShowSubcategories(this.value, 0);
	    			if(this.value != 0)
	    				visitObj.category = $(this).find("option:selected").text();
	    			else
	    				visitObj.category = '';
	    			break;
	    		}
	    		case "subcategorybox":
	    		{
					
	    			if(this.value != 0)
	    				visitObj.subcategory = $(this).find("option:selected").text();
	    			else
	    				visitObj.subcategory = '';
	    			break;
	    		}
	    		case "brandbox":
	    		{
					$('#seriesbox').attr("value", 0);
	    			ShowSeries(this.value, 0);
	    			if(this.value != 0)
	    				visitObj.brand = $(this).find("option:selected").text();
	    			else
	    				visitObj.brand = '';

	    			break;
	    		}
	    		case "seriesbox":
	    		{
	    			if(this.value != 0)
	    				visitObj.series = $(this).find("option:selected").text();
	    			else
	    				visitObj.series = '';
	    			break;
	    		}
	    		default:
	    		{
	    			break;
	    		}
	    	}

			var Category = $("#categorybox").val() == 0 ? "" : $("#categorybox").find("option:selected").text();
			var SubCategory = $("#subcategorybox").val() == 0 ? "" : $("#subcategorybox").find("option:selected").text();
			var Brand = $("#brandbox").val() == 0 ? "" : $("#brandbox").find("option:selected").text();
			var Series = $("#seriesbox").val() == 0 ? "" : $("#seriesbox").find("option:selected").text();

	    	var category = '', subcategory = '', brand = '', series = '';

	    	if(Category != ''){
	    		category = MakeSafeURL(Category);
	    	}
	    	if(SubCategory != ''){
	    		subcategory = '/subcategory/' + MakeSafeURL(SubCategory);
	    	}
	    	if(Brand != ''){
	    		brand = '/brand/' + MakeSafeURL(Brand);
	    	}
	    	if(Series != ''){
	    		series = '/series/' + MakeSafeURL(Series);
	    	}
	    	$('#visitURL').val('%%GLOBAL_ShopPath%%/' + category + subcategory + brand + series);
	    	$('#'+this.id.replace('box','name')).val($(this).find("option:selected").text());
	    	//ShowProductResults();
	    });

	    function MakeSafeURL(str){
	    	var newStr =str.toLowerCase().replace(/\s+/g, '-');
	    	return newStr;
	    }
	    
	    function ShowSubcategories(cid, selectedSub){
	    	var phpUrl = 'getsubcategoryoptions.php';
		    $.ajax({
		        url: phpUrl,
		        type: 'GET', 
		        cache: false,
		        dataType: 'text',
		        data: { cid: cid },
		        error: function(){
		            //  alert('Error loading XML document');
		        },
		        success: function(data)
		        {
		        	var defaultOption = $('#subcategorybox').children(":first");
		            $('#subcategorybox').html(data);
		            $('#subcategorybox').prepend(defaultOption);
		            //$('#subcategorybox').attr("selectedIndex", selectedSub);
		            $('#subcategorybox').attr("value", selectedSub);
		        }
		    }); 
	    }
	    
	    function ShowSeries(bid, selectedSeries){
	    	var phpUrl = 'getseriesoptions.php';
		    $.ajax({
		        url: phpUrl,
		        type: 'GET', 
		        cache: false,
		        dataType: 'text',
		        data: { bid: bid },
		        error: function(){
		            //  alert('Error loading XML document');
		        },
		        success: function(data)
		        {
		        	var defaultOption = $('#seriesbox').children(":first");
		            $('#seriesbox').html(data);
		            $('#seriesbox').prepend(defaultOption);
		            //$('#seriesbox').attr("selectedIndex", selectedSeries);
		            $('#seriesbox').attr("value", selectedSeries);
		        }
		    }); 
	    }
	    
	    function ShowProductResults(){
	    	var phpUrl = "index.php?ToDo=getCategoryProds";
	    	var selCate = $("#categorybox").val();
	    	var selSubcate = $("#subcategorybox").val();
	    	var selBrand = $("#brandbox").val();
	    	var selSeries = $("#seriesbox").val();
	    	
	    	$.ajax({
		        url: phpUrl,
		        type: 'GET', 
		        cache: false,
		        dataType: 'text',
		        data: { 
					'category' : selCate,
					'subscategory': selSubcate,
					'brand' : selBrand,
					'series' : selSeries
	            },
		        error: function(){
		            //  alert('Error loading XML document');
		        },
		        success: function(data)
		        {
		        	if($('#productResults_old').length != 0){
		        		$('#productResults').remove();
		        		$('#productResults_old').attr("id", "productResults");
		        		$('#productResults').show();
		        	}
		        	
		        	var defaultOption = $('#productResults').children(":first");
		            $('#productResults').html(data);
		            $('#productResults').prepend(defaultOption);
		            ISSelectReplacement.replace_select($('#productResults').get(0));
		            
				    $('input[type=checkbox]', '#productResults').filter(':first').click(function(){
				    	var checkStat = this.checked;
				    	$('input[type=checkbox]', '#productResults').each(function(){
				    		this.checked = checkStat;
				    	});
				    });
		        }
		    });
	    } 

	    setTimeout(function(){
		    $('input[type=checkbox]', '#productResults').filter(':first').click(function(){
		    	var checkStat = this.checked;
		    	$('input[type=checkbox]', '#productResults').each(function(){
		    		this.checked = checkStat;
		    	});
	    	});
	     }, 1000);
	    
	 	$(parent.document.body).find(".buttonGroup1 > input").each(function(){
	 			this.disabled = false;
	 	});

	 	if(%%GLOBAL_Enabled%% == 0){
	 		$('#enabled').attr('checked', false);
	 	}else{
	 		$('#enabled').attr('checked', true);
	 	}
	 	
	 	if(%%GLOBAL_CatId%% != 0){
	 		ShowSubcategories(%%GLOBAL_CatId%%, %%GLOBAL_SubCatId%%);
	 	}
	 	
	 	if(%%GLOBAL_BrandId%% != 0){
	 		ShowSeries(%%GLOBAL_BrandId%%, %%GLOBAL_SeriesId%%);
	 	}
	});
	
	</script>
</head>
<body style="padding:0px;">
<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" onsubmit="return ValidateForm(CheckCustomForm)" name="frmAddCustom" method="post">
<input type="hidden" name="categoryname" id="categoryname"/>
<input type="hidden" name="subcategoryname" id="subcategoryname"/>
<input type="hidden" name="brandname" id="brandname"/>
<input type="hidden" name="seriesname" id="seriesname"/>
<input type="hidden" name="contentId" id="contentId" value="%%GLOBAL_ContentId%%"/>
<input type='hidden' name="itemId" value="%%GLOBAL_CustomItemId%%"/>
<input type='hidden' name="catId" value="%%GLOBAL_CatId%%"/>
<input type='hidden' name="pid" value="%%GLOBAL_PageId%%"/>
<table class="Panel">
	<tr>
		<td class="Heading2" colspan=2>%%LNG_CustomContent%%</td>
	</tr>
	%%GLOBAL_SnippetCustomPageItem%%
</table>
</form>
</body>
</html>