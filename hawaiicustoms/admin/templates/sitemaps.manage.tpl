<style type="text/css">
#ConfigurePanel fieldset{
	padding:10px;
	margin:10px;
	width:600px;
	color:#333;
	border:#06c dashed 1px;
}

#ConfigurePanel legend{
	color:#06c;
	font-weight:800;
	background:#fff;
	border:#b6b6b6 solid 1px;
	padding:3px 6px;
}

#ConfigureTable td{
	vertical-align: top;
}

.panelContent{
	padding: 10px;
}

.ResultPanel{
	padding: 10px 0px;
}
</style>
<div class="BodyContainer">
	<form method="post" id="sitemapForm" action="index.php?ToDo=createSitemapIndex">
	<input type="hidden" name="currentTab" id="currentTab" value="%%GLOBAL_CurrentTab%%"/>
	<input type="hidden" name="sitemapId" id="sitemapId" value="%%GLOBAL_SitemapId%%"/>
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_ManageSitemaps%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_ManageSitemapsIntro%%</p>
				%%GLOBAL_Message%%
			</td>
		</tr>
		<tr>
			<td>
				<ul id="tabnav">
					<li><a href="#" class="active" id="tab0">%%LNG_IndexMap%%</a></li>
					<li><a href="#" id="tab1">%%LNG_CategoryBrand%%</a></li>
					<li><a href="#" id="tab2">%%LNG_MixCategoryBrand%%</a></li>
					<li><a href="#" id="tab3">%%LNG_ProductBrand%%</a></li>
					<li><a href="#" id="tab4">%%LNG_DynamicPage%%</a></li>
					<li><a href="#" id="tab5">%%LNG_StaticPage%%</a></li>
					<li><a href="#" id="tab6">%%LNG_BasicConfigure%%</a></li>
				</ul>
			</td>
		</tr>
		<tr id="div0">
			<td>
				<div class="panelContent">
					<div id="IndexMapResult" class="ResultPanel">
						%%GLOBAL_IndexMapResult%%
					</div>
				</div>
				<input type="button" id="IndexMapPreviewBtn" value="%%LNG_Preview%%" class="SmallButton" />
				<input type="button" id="IndexMapBtn" value="%%LNG_Generate%%" class="SmallButton" />
			</td>
		</tr>
		<tr id="div1" style="display: none">
			<td>
				<div class="panelContent">
					<div id="CatBrandResult" class="ResultPanel">
						%%GLOBAL_CatBrandResult%%
					</div>
				</div>
				<input type="button" id="CatBrandPreviewBtn" value="%%LNG_Preview%%" class="SmallButton" />
				<input type="button" id="CatBrandBtn" value="%%LNG_Generate%%" class="SmallButton" />
			</td>
		</tr>
		<tr id="div2" style="display: none">
			<td>
				<div class="panelContent">
					<div>
						Popular Categories: <input type='text' name="popularCats" value="%%GLOBAL_PopularCategories%%" class='Field750'/>
					</div>
					<div id="MixCatBrandResult" class="ResultPanel">
						%%GLOBAL_MixCatBrandResult%%
					</div>
				</div>
				<input type="button" id="MixCatBrandPreviewBtn" value="%%LNG_Preview%%" class="SmallButton" />
				<input type="button" id="MixCatBrandBtn" value="%%LNG_Generate%%" class="SmallButton" />
			</td>
		</tr>
		<tr id="div3" style="display: none">
			<td>
				<div class="panelContent">
					<!--div>
						Popular Categories: <input type='text' name="popularCats" value="%%GLOBAL_PopularCategories%%" class='Field750'/>
					</div-->
					<div id="ProdBrandResult" class="ResultPanel">
						%%GLOBAL_ProdBrandResult%%
					</div>
				</div>
				<input type="button" id="BrandProdPreviewBtn" value="%%LNG_Preview%%" class="SmallButton" />
				<input type="button" id="BrandProdBtn" value="%%LNG_Generate%%" class="SmallButton" />
			</td>
		</tr>
		<tr id="div4" style="display: none">
			<td>
				<div class="panelContent">
					<table id="DynmicPageTable" cellSpacing="0" cellPadding="0" width="100%">
						<tr>
							<td width="100px">Popular Years:</td>
							<td>
								<input type='text' name="popularYearsStart" class='Field50' value="%%GLOBAL_PopularYearsStart%%"/> 
								to 
								<input type='text' name="popularYearsEnd" class='Field50' value="%%GLOBAL_PopularYearsEnd%%"/>
							</td>
						</tr>
						<tr>
							<td>Popular Makes:</td>
							<td><input type='text' name="popularMakes" class='Field750' value="%%GLOBAL_PopularMakes%%"/></td>
						</tr>
					</table>
					<div id="DynmicPageResult" class="ResultPanel">
						%%GLOBAL_DynmicPageResult%%
					</div>
				</div>
				<input type="hidden" name="pageCount" value="%%GLOBAL_PageCateBrand%%"/>
				<input type="hidden" name="pageCount2" value="%%GLOBAL_PageYMM%%"/>
				<input type="hidden" name="dynamic_filename" value="%%GLOBAL_DynamicFileName%%"/>
				<input type="button" id="DynmicPagePreviewBtn" value="%%LNG_Preview%%" class="SmallButton" />
				<input type="button" id="DynmicPageBtn" value="%%GLOBAL_GenerateLabel%%" class="SmallButton" />
			</td>
		</tr>
		<tr id="div5" style="display: none">
			<td>
				<div class="panelContent">
					<div id="StaticPageResult" class="ResultPanel">
						<!--textarea name='staticItems' id='staticItems' cols='100' rows='10' readonly>%%GLOBAL_StaticPageResult%%</textarea-->
						<select multiple="multiple" style='width: 745px; height: 200px;' id='staticItems' name='staticItems'>
							%%GLOBAL_StaticPageResult%%
					    </select>
					    <input type='hidden' id='staticULRs' name='staticULRs'/>
					</div>
					<div>
						<input type='text' id='staticItem' size='64'/>
						<input type='button' value='Add' id='addStaticBtn'/>
						<input type='button' value='Remove' id='removeStaticBtn'/>
						<input type='button' value='Restore' id='restoreStaticBtn'/>
					</div>
				</div>
				<input type="button" id="StaticPagePreviewBtn" value="%%LNG_Preview%%" class="SmallButton" />
				<input type="button" id="StaticPageBtn" value="%%LNG_Generate%%" class="SmallButton" />
			</td>
		</tr>
		<tr id="div6" style="display: none">
			<td>
				<div id="ConfigurePanel">
					<fieldset>
					    <legend align="center">%%LNG_NoramlConfigure%%</legend>
					    <div>
					    	<div>System Memory Limit: 100M</div>
					    	<div>Maxmum of records a file: <input type='text' name='maxRecord' class='Field50' value="%%GLOBAL_MaxmumRecords%%"/></div>
				    		<!--div>Auto-update Frequency: 
					    		<select>
					    			<option value="0">always</option>
					    			<option value="1">hourly</option>
					    			<option value="2">daily</option>
					    			<option value="3">monthly</option>
					    			<option value="4">yearly</option>
					    			<option value="5" selected="selected">never</option>
					    		</select>
					    	</div-->
					    </div>
					</fieldset>
					
					<fieldset>
					    <legend align="center">%%LNG_XMLStructure%%</legend>
					    <table id="ConfigureTable" cellSpacing="0" cellPadding="0" width="100%">
							<tr>
								<td width="200px">Root node of index map:</td>
								<td><input type='text' name="indexRootName" class='Field200' value="%%GLOBAL_IndexRootName%%"/></td>
							</tr>
							<tr>
								<td>Root node of normal map:</td>
								<td><input type='text' name="normalRootName" class='Field200' value="%%GLOBAL_NormalRootName%%"/></td>
							</tr>
							<tr>
								<td>URL node of index map:</td>
								<td><input type='text' name="indexUrlName" class='Field200' value="%%GLOBAL_IndexUrlName%%"/></td>
							</tr>
							<tr>
								<td>URL node of normal map:</td>
								<td><input type='text' name="normalUrlName" class='Field200' value="%%GLOBAL_NormalUrlName%%"/></td>
							</tr>
							<tr>
								<td>ChildNodes of URL node:</td>
								<td>
									<select size="5" id="UrlChildNodes" name="urlChildNodes" class="Field200 ISSelectReplacement" multiple="multiple" style="height: 140px;">
										%%GLOBAL_UrlChildOption%%
									</select>
								</td>
							</tr>
						</table>
					</fieldset>
				</div>
				<input type="button" id="SaveBtn" value="%%LNG_Save%%" class="SmallButton" />
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
	</form>
</div>
<script type="text/javascript">
	$(function(){
		var staticPages = $('#staticItems').html();
	
		$("#tabnav > li a").click(function(){
        	var T = this.id.replace("tab", "");
        	setTab(T);
        });
        
        function setTab(T){
        	var i = 0;
			while (document.getElementById("tab" + i) != null) {
				$('#div'+i).hide();
				$('#tab'+i).removeClass('active');
				 ++i;
			} 
			
        	$('#div'+T).show();
			$('#tab'+T).addClass('active');
			$('#currentTab').val(T); 
        }
        
        setTab($('#currentTab').val());
        
        $('#SaveBtn').click(function(){
        	if($('#sitemapId').val() == ''){
        		submitSitemapForm('index.php?ToDo=saveSitemapConfig');
        	}else{
        		submitSitemapForm('index.php?ToDo=updateSitemapConfig');
        	}
        });
        
        $('#CatBrandBtn').click(function(){
        	submitSitemapForm('index.php?ToDo=createCbSitemap');
        	$('#CatBrandBtn').attr('disabled', true);
        });
        
        $('#MixCatBrandBtn').click(function(){
        	submitSitemapForm('index.php?ToDo=createMixCbSitemap');
        	$('#MixCatBrandBtn').attr('disabled', true);
        });
        
        $('#BrandProdBtn').click(function(){
        	submitSitemapForm('index.php?ToDo=createPbSitemap');
        	$('#BrandProdBtn').attr('disabled', true);
        });
        
        $('#DynmicPageBtn').click(function(){
        	submitSitemapForm('index.php?ToDo=createDynamicSitemap');
        	$('#DynmicPageBtn').attr('disabled', true);
        });
        
        $('#StaticPageBtn').click(function(){
        	submitSitemapForm('index.php?ToDo=createStaticSitemap');
        	$('#StaticPageBtn').attr('disabled', true);
        });
        
        $('#IndexMapBtn').click(function(){
        	submitSitemapForm('index.php?ToDo=createSitemapIndex');
        	$('#IndexMapBtn').attr('disabled', true);
        });

        $('#CatBrandPreviewBtn').click(function(){
        	PreviewSitemap('Category-Brand');
        });
        
        $('#MixCatBrandPreviewBtn').click(function(){
        	PreviewSitemap('Mix-Category-Brand');
        });
        
        $('#BrandProdPreviewBtn').click(function(){
        	PreviewSitemap('Brand-Product');
        });
        
        $('#DynmicPagePreviewBtn').click(function(){
        	PreviewSitemap('Dynamic-Page');
        });
        
        $('#StaticPagePreviewBtn').click(function(){
        	PreviewSitemap('Static-Page');
        });
        
        $('#IndexMapPreviewBtn').click(function(){
        	PreviewSitemap('Index-Map');
        });
        
        $('#addStaticBtn').click(function(){
        	/*
        	var oldValue = $('#staticItems').val();
        	$('#staticItems').text(oldValue + $('#staticItem').val() + '\r');
        	*/
        	$('#staticItems').append('<option>'+$('#staticItem').val()+'</option>');
        	$('#staticItems').scrollTop(9999);
        	$('option','#staticItems').dblclick(function(){
	        	$('#staticItem').val($('option:selected','#staticItems').text());
	        });
        });
        
        $('#removeStaticBtn').click(function(){
        	/*
        	var oldValue = $('#staticItems').val();
        	var matchStr = oldValue.split(/\n/g);
			var matchLen = matchStr.length - 2;
        	var brIndex = oldValue.lastIndexOf(matchStr[matchLen]);
        	$('#staticItems').text(oldValue.substring(0, brIndex));
        	*/
        	if($('#staticItems').attr('selectedIndex') == -1)
        		$('#staticItems').children(':last').remove();
        	else
        		$('option:selected','#staticItems').remove();
        	$('#staticItems').scrollTop(9999);
        });
        
        $('#restoreStaticBtn').click(function(){
        	$('#staticItems').html(staticPages);
        });
        
        $('option','#staticItems').dblclick(function(){
        	$('#staticItem').val($('option:selected','#staticItems').text());
        });
        
        function PreviewSitemap(type){
        	$.iModal({
				type: 'ajax',
				url: 'index.php?ToDo=prevSitemap&MapType='+type
			});
        }
	});
	
	function submitSitemapForm(actionUrl){
		if($('#staticItems').children().length > 0){
			var staticUrl = [];
			$('option', '#staticItems').each(function(){
				staticUrl.push($(this).text());
			});
			
			$('#staticULRs').attr('value', staticUrl.join(','));
		}
    	$('#sitemapForm').attr('action', actionUrl);
    	$('#sitemapForm').submit();
    }
</script>