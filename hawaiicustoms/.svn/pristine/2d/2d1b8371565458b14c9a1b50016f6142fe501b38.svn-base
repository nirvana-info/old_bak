	<script language=JavaScript>

		function MassActionReviews(action) {
			var sortURL = g('ReviewSortURL').href;
			sortURL = sortURL.substring(sortURL.indexOf('?')+1, sortURL.length);
			$.post('remote.php?'+sortURL+'&w='+action, $('#frmReviews').serialize(), ReviewsMassActioned);
		}

		function ReviewsMassActioned(response) {
			var status = $('status', response).text();
			BindAjaxGridSorting();
			var message = $('message', response).text();
			if(status == 0) {
				display_error('ReviewsStatus', message);
			}
			else {
				display_success('ReviewsStatus', message);
				var grid = $('grid', response).text();
				if(!grid) {
					$('#ReviewGridView').hide();
				}
				else {
					$('.GridContainer').html(grid);
				}
			}
		}                                      
        
        function getSeries()
        {   
            var brandid = document.getElementById("brandlist").value;      
            $('#SeriesDiv').load('index.php?ToDo=loadReviewSeries&brandid='+brandid+'&ajax=1', '', function() {
                FilterReviews();
            });    
        }

        //lguan_20100612: Updated to support filter by categories
        function FilterReviews()
        {
            var brandid = document.getElementById("brandlist").value;
            var seriesid = document.getElementById("serieslist").value;
            var categoryid = $('#categorieslist').val();
            var subcategoryid = $('#subcategorieslist').val();
            var datetype = $('#Calendar').val();
            var datefilter = '&datetype='+datetype + ((datetype=='Custom')?('&from='+$('#fromPicker').val()+'&to='+$('#toPicker').val()):'');
            var ajaxUrl = ($('#filtertypelist').val()==1)
                    		? 'index.php?ToDo=filterReviews&catid='+categoryid+'&subcatid='+subcategoryid+'&ajax=1'+datefilter
                            : 'index.php?ToDo=filterReviews&brandid='+brandid+'&seriesid='+seriesid+'&ajax=1'+datefilter;
            
            $('.GridContainer').load(ajaxUrl, '', function(gridtext) {
                if(gridtext != '')    {
                    $('#ReviewsStatus').html('');
                    $('#ReviewGridView').attr('style', ''); 
                    $('#IndexDeleteButton').attr('disabled', '');
                    $('#IndexApproveButton').attr('disabled', '');
                    $('#IndexDisapproveButton').attr('disabled', '');
                    
                    $('#clearSearchSpan').css('display', '');
                }else{
                	$('#clearSearchSpan').css('display', 'none');
                }                                          
                BindAjaxGridSorting();
            });
        }
        
        //wiyin_20100612: search product reviews by keyword
        function SearchReviews()
        {
        	var skeyword = document.getElementById("searchQuery").value;
        	if(CheckSearchForm()){
	            var brandid = document.getElementById("brandlist").value;
	            var seriesid = document.getElementById("serieslist").value;
	            var categoryid = $('#categorieslist').val();
	            var subcategoryid = $('#subcategorieslist').val();
	            var datetype = $('#Calendar').val();
	            var datefilter = '&datetype='+datetype + ((datetype=='Custom')?('&from='+$('#fromPicker').val()+'&to='+$('#toPicker').val()):'');
	            var ajaxUrl = ($('#filtertypelist').val()==1)
	                    		? 'index.php?ToDo=filterReviews&catid='+categoryid+'&subcatid='+subcategoryid+'&ajax=1'+datefilter
	                            : 'index.php?ToDo=filterReviews&brandid='+brandid+'&seriesid='+seriesid+'&ajax=1'+datefilter;
	            ajaxUrl += '&searchQuery='+encodeURI(skeyword);
	            $('.GridContainer').load(ajaxUrl, '', function(gridtext) {
	                if(gridtext != '')    {
	                    $('#ReviewsStatus').html('');
	                    $('#ReviewGridView').attr('style', ''); 
	                    $('#IndexDeleteButton').attr('disabled', '');
	                    $('#IndexApproveButton').attr('disabled', '');
	                    $('#IndexDisapproveButton').attr('disabled', '');
	                }                                           
	                BindAjaxGridSorting();
	            });
            }
        }
        
	</script>
	
	<div class="BodyContainer">
	<input id="currentTab" name="currentTab" value="0" type="hidden">
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_ManageReviews%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%GLOBAL_ReviewIntro%%</p>
				<div id="ReviewsStatus">%%GLOBAL_Message%%</div>
				<ul id="tabnav">
					<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_ReviewOverview%%</a></li>
					<li><a href="#" id="tab1" onclick="ShowTab(1)">%%LNG_ReviewProducts%%</a></li>
				</ul>
			</td>
		</tr>
		<tr id="content0">
			<td>
				<div style="padding-top:10px; padding-left:10px" class="text">
	                Show By:
	                <select id="showby" name="showby" onchange="submitForm();"> 
	                    <option value="category" %%GLOBAL_CatSel%%>Category</option>
	                    <option value="subcategory" %%GLOBAL_SubcatSel%%>Subcategory</option>
	                    <option value="brand" %%GLOBAL_BrandSel%%>Brand</option> 
	                    <option value="series" %%GLOBAL_SeriesSel%%>Series</option>      
	                </select>
	                 &nbsp;  <input type="button" value="Export Results"  onclick = "exportsearchresults();" style="display:none"/>  
					<div id="productsByNumViewsGrid">
					</div>
				</div>
			</td>
		</tr>
		<tr id="content1">
		<td>
			<br/>
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
            <tr>
            <td>
               <table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
            	<tr>
				<td class="Intro" valign="top">
					<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteReviews1%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% /> &nbsp;
					<input type="button" name="IndexApproveButton" value="%%LNG_ApproveReviews%%" id="IndexApproveButton" class="SmallButton" onclick="ApproveSelected()" %%GLOBAL_DisableApproved%% /> &nbsp;
					<input type="button" name="IndexDisapproveButton" value="%%LNG_DisapproveReviews%%" id="IndexDisapproveButton" class="SmallButton" onclick="DisapproveSelected()" %%GLOBAL_DisableDisapproved%% />
				</td>
				</tr>
	            <tr>
	                <td>
						  <div id='FilterTypeDiv' style="float:left;">
							%%GLOBAL_FiltersList%%
						  </div>					  
						  <div id="categoryFilters" %%GLOBAL_CategoryFilterVisible%%>
						  	<div id='CategoriesDiv' style="float:left;">%%GLOBAL_CategoriesList%%</div> 
						  	<div id='SubCategoriesDiv' style="float:left;">%%GLOBAL_SubCategoriesList%%</div> 
						  </div>
						  <div id='brandFilters' %%GLOBAL_BrandFilterVisible%%>
							<div id='BrandDiv' style="float:left;">%%GLOBAL_BrandsList%%</div> 
							<div id='SeriesDiv'  style="float:left;">%%GLOBAL_SeriesList%%</div>
						  </div>
	                </td>  
	                <td> &nbsp;   
	                </td>   
	            </tr>
	            <tr>
	            	<td colspan='2'> 
		            	<div id="dateBlock" style="padding:5px 0px 5px 10px" class="Text FloatLeft">
							<table border=0 cellspacing=0 cellpadding=0>
								<tr>
									<td style="background: #eee; padding: 3px 5px;" width="1" class="dateField">
										<img src="images/dateicon.gif" />
									</td>
									<td style="background: #eee;" class="dateField">Date Range:</td>
									<td style="background: #eee; padding: 3px 5px;" width="1" class="dateField">       
										<select name="Calendar[DateType]" id="Calendar" class="CalendarSelect" onchange="doCustomDate(this, 7)">
											%%GLOBAL_CalendarDateTypeOptions%%
										</select> 
									</td>
									<td style="background: #eee;" class="dateField">
										<span id=customDate7 style="display:none">&nbsp;
											%%GLOBAL_FromDatePicker%%
											<span class=body>%%LNG_To1%%</span>
											%%GLOBAL_ToDatePicker%%
										</span>&nbsp;
									</td>
									<td style="background: #eee; padding: 3px 5px;"><input type="button" value="Go" onclick="FilterReviews();" class="Text" /></td>
								</tr>
							 </table>
						  </div>
	            	  </td>
	              </tr>
	           </table>
            </td>
            <td class="SmallSearch" align="right">
				<table id="Table16" style="display:%%GLOBAL_DisplaySearch%%">
				<tr>
					<td nowrap>
						<!--<form action="index.php?ToDo=viewReviews%%GLOBAL_SortURL%%" method="get" onsubmit="return ValidateForm(CheckSearchForm)"></form>
							<input type="hidden" name="ToDo" value="viewReviews">-->
							<input name="searchQuery" id="searchQuery" type="text" value="%%GLOBAL_Query%%" id="SearchQuery" class="Button" size="20" />&nbsp;
							<input type="image" name="SearchButton" id="SearchButton" src="images/searchicon.gif" border="0" onclick="SearchReviews()"/>
					</td>
				</tr>
				<tr>
					<td nowrap="nowrap">
						<a href="index.php?ToDo=searchReviews">%%LNG_AdvancedSearch%%</a>
						<span id="clearSearchSpan" style="display:%%GLOBAL_HideClearResults%%">| <a id="SearchClearButton" href="index.php?ToDo=viewReviews&currentTab=1">%%LNG_ClearResults%%</a></span>
					</td>
				</tr>
				<tr>
					<td></td>
				</tr>
				</table>
			</td>
            </tr>
            <tr style="display: %%GLOBAL_DisplayGrid%%" id="ReviewGridView">
			<td colspan='2'>
				<form name="frmReviews" id="frmReviews" method="post" action="index.php?ToDo=deleteReviews">
					<div class="GridContainer">
						%%GLOBAL_ReviewDataGrid%%
					</div>
				</form>
			</td>
			</tr>
			</table>
		</td>
		</tr>
	</table>
	</div>

	<script type="text/javascript">

		function PreviewReview(ReviewId)
		{
			var l = screen.availWidth / 2 - 250;
			var t = screen.availHeight / 2 - 300;
			var win = window.open('index.php?ToDo=previewReview&reviewId='+ReviewId, 'previewReview', 'width=500,height=600,left='+l+',top='+t+',scrollbars=1');
		}

		function CheckSearchForm()
		{
			var query = document.getElementById("searchQuery");

			if(query.value == "")
			{
				alert("%%LNG_EnterSearchTerm%%");
				query.focus();
				return false;
			}

			return true;
		}

		function ConfirmDeleteSelected()
		{
			var fp = document.getElementById("frmReviews").elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				if(confirm("%%LNG_ConfirmDeleteReviews%%"))
					MassActionReviews('deleteReviews');
			}
			else
			{
				alert("%%LNG_ChooseReview1%%");
			}
		}

		function ApproveSelected()
		{
			var frm = document.getElementById("frmReviews");
			var fp = frm.elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				MassActionReviews('approveReviews');
			}
			else
			{
				alert("%%LNG_ChooseReview2%%");
			}
		}

		function DisapproveSelected()
		{
			var frm = document.getElementById("frmReviews");
			var fp = frm.elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				MassActionReviews('disapproveReviews');
			}
			else
			{
				alert("%%LNG_ChooseReview3%%");
			}
		}

		function ToggleDeleteBoxes(Status)
		{
			var fp = document.getElementById("frmReviews").elements;

			for(i = 0; i < fp.length; i++)
				fp[i].checked = Status;
		}

		// Load all subcategories
		function loadSubCategories() 
		{
			var categoryid = document.getElementById("categorieslist").value;      
            $('#SubCategoriesDiv').load('index.php?ToDo=loadreviewcategories&catid='+categoryid+'&ajax=1', '', function() {
                FilterReviews();
            });  
		}

		// Switch filters panel
		function switchFilter(filterType)
		{
			$('#categoryFilters').toggle();
			$('#brandFilters').toggle();
			loadSubCategories();
		}
		
		var productsPerPage = 20;
		var productsByNumViewsCurrentPage = 1;
		var productsByNumViewsLoaded = false;
		var productsByNumViewsSortField = '';
		var productsByNumViewsSortOrder = '';
		
		function submitForm(){                               
            LoadProductsByNumViewsGrid();
        }
		
		function ShowTab(T){

			i = 0;

			while (document.getElementById("tab" + i) != null) {
				document.getElementById("content" + i).style.display = "none";
				document.getElementById("tab" + i).className = "";
				i++;
			}

			document.getElementById("content" + T).style.display = "";
			document.getElementById("tab" + T).className = "active";
			document.getElementById("currentTab").value = T;

			// What should the intro text be?
			switch(T) {
				case 0: {
					//define the 1st tab-content
					if(!productsByNumViewsLoaded) {
						LoadProductsByNumViewsGrid();
						productsByNumViewsLoaded = true;
					}
					break;
				}
				case 1: {
					//define the 2nd tab-content
					
					break;
				}
			}
		}
		
		function ChangeProductsByNumViewsPerPage(ProductsPerPage) {
			// Change how many products are shown per page
			productsPerPage = ProductsPerPage;
			productsByNumViewsCurrentPage = 1;
			LoadProductsByNumViewsGrid();
		}

		function ChangeProductsByNumViewsPage(Page) {
			// Change which page of orders we're viewing
			productsByNumViewsCurrentPage = Page;
			LoadProductsByNumViewsGrid();
		}

		function SortProductsByNumViews(field, order) {
			productsByNumViewsSortField = field;
			productsByNumViewsSortOrder = order;
			LoadProductsByNumViewsGrid();
		}
		
		function LoadProductsByNumViewsGrid() {
            var showby = document.getElementById('showby').value;
			jQuery.ajax({url: 'index.php?ToDo=prodReviewOverviewGrid&Page='+productsByNumViewsCurrentPage+'&Show='+productsPerPage+'&SortBy='+productsByNumViewsSortField+'&SortOrder='+productsByNumViewsSortOrder+'&showby='+showby,
					 success: function(data) {
					$('#productsByNumViewsGrid').html(data);
					 }
				}
			);
		}

		$(function() {
			$('input.datepicker').datepicker({
				changeMonth: true,
				changeYear: true,
				closeAtTop: false,
				mandatory: true
			});
			doCustomDate(document.getElementById('Calendar'), 7);
			
			ShowTab(%%GLOBAL_CurrentTab%%);
			
		});
	</script>
