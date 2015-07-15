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
	<script type="text/javascript" src="../javascript/jquery/plugins/interface.js"></script>
	<script type="text/javascript" src="../javascript/jquery/plugins/inestedsortable.js"></script>
	
	<script type="text/javascript">
	function deleteConfirm(obj){
		if(confirm("Are you sure?"))
		{
			return true;
		}else{
			return false;
		}
	}
	
	function PreviewCustomItem(ItemId)
	{
		var l = screen.availWidth / 2 - 250;
		var t = screen.availHeight / 2 - 300;
		var win = window.open('index.php?ToDo=prevCateabtestingcustom&itemId='+ItemId, 'PreviewCustomItem', 'width=500,height=600,left='+l+',top='+t+',scrollbars=1');
	}
	
	function ToggleDeleteBoxes(Status)
    {
	   $('input[type=checkbox]', '#frmContents').each(function(){
	   	 this.checked = Status;
	   })
    } 
    
    function ConfirmDeleteSelected()
	{
		var checkedCnt = $('input[type=checkbox]', '#frmContents').filter(":checked").length;	
		if(checkedCnt > 0)
		{
			if(confirm("Are you sure?"))
			{
				$("#frmContents").attr('action', 'index.php?ToDo=deletecateabtestingcustommulti&contentId=%%GLOBAL_ContentId%%&catId=%%GLOBAL_CatId%%&pid=%%GLOBAL_PageId%%');
				$("#frmContents").submit();
			}
		}
		else
		{
			alert("Please choose at least one category to delete.");
		}
	 }
	 
	var updatingSortables = false;
	var updateTimeout = null;
	function CreateSortableList() {
		$('#CustomContentList').NestedSortable({
			accept: 'SortableRow',
			noNestingClass: "no-nesting",
			opacity: .8,
			helperclass: 'SortableRowHelper',
			onChange: function(serialized) {
				updatingSortables = true;
				if(updateTimeout != null) window.clearTimeout(updateTimeout);
				//2010-11-09 Ronnie modify other parameter
				//url: 'remote.php?w=updatecustomorders',
				$.ajax({
					url: 'remote.php?w=updateabtestingcustomorders',
					type: 'POST',
					dataType: 'xml',
					data: serialized[0].hash,
					success: function(response) {
						var status = $('status', response).text();
						var message = $('message', response).text();
						if(status == 0) {
							parent_display_error('.Intro', message);
						}
						else {
							parent_display_success('.Intro', message);
						}
						if(document.all) {
							// IE has problems here - it breaks on sortable lists so for now we just
							// refresh the current page
							window.location.reload();
						}
					}
				});
	
			},
			onStop: function() {
				if(document.all && updatingSortables == false) {
					// IE has problems here - it breaks on sortable lists so for now we just
					// refresh the current page
					updateTimeout = window.setTimeout(function() { window.location.reload(); }, 100);
				}
			},
			autoScroll: true,
			handle: '.sort-handle'
		}); 
	 }
	 
	 function parent_display_error(selector,message){
		 if($(parent.document.body).find(selector + ' .MessageBox').get() != "") {
			$(parent.document.body).find(selector + ' .MessageBox').fadeOut('slow');
			$(parent.document.body).find(selector + ' .MessageBox').remove();
		 	$(parent.document.body).find(selector).append('<div class="MessageBox MessageBoxInfo">'+message+'</div>').fadeIn('slow');
		 }
		 else {
		 	$(parent.document.body).find(selector).append('<div class="MessageBox MessageBoxInfo">'+message+'</div>').show('slow');
		 }
 	}

	 function parent_display_success(selector,message){
		 if($(parent.document.body).find(selector + ' .MessageBox').get() != "") {
			 $(parent.document.body).find(selector + ' .MessageBox').fadeOut('slow');
			 $(parent.document.body).find(selector + ' .MessageBox').remove();
			 $(parent.document.body).find(selector).append('<div class="MessageBox MessageBoxSuccess">'+message+'</div>').fadeIn('slow');
		 }
		 else {
		 	$(parent.document.body).find(selector).append('<div class="MessageBox MessageBoxSuccess">'+message+'</div>').show('slow');
		 }
	 }
	 
	 $(function(){
	 	CreateSortableList();
	 	$(parent.document.body).find(".buttonGroup1 > input").each(function(){
	 		if(this.name != 'CancelButton1'){
	 			this.disabled = 'disabled';
	 		}
	 	});
	 	
	 	$('.enableLink > img').click(function(){
	 		var $this = $(this);
	 		var itemId = $this.parent().attr('name').replace('enableLink', '');
	 		var enabled = false;
	 		var enableImg = '';
	 		var enableMsg = '';
	 		if($(this).attr('src').indexOf('tick.gif') == -1){
	 			enabled = true;
	 			enableImg = 'images\/tick.gif';
	 			titleMsg = 'Click here to disable this item.';
	 			enableMsg = 'This item has been enabled!';
	 		}else{
	 			enabled = false;
	 			enableImg = 'images\/cross.gif';
	 			titleMsg = 'Click here to enable this item.';
	 			enableMsg = 'This item has been disabled!';
	 		}
	 		
	 		$.ajax({
                    url: 'index.php?ToDo=enableCateCustomContent',
                    type: 'POST', 
                    cache: false,
                    dataType: 'text',
                    data: { 
                    		itemId: itemId,
                           enabled: enabled 
                          },
                    beforeSend: function(){
                    	parent.window.ShowLoadingIndicator();
                    },
                    error: function(){
                        //  alert('Error loading XML document');
                    },
                    success: function(html)
                    {
                    	parent_display_success('.Intro', enableMsg);
                    	parent.window.HideLoadingIndicator();
                    	$this.attr('src', enableImg);
                    	$this.attr('title', titleMsg);
                    }
            });
	 	});
	 });
	</script>
</head>
<body style="padding:0px;">
<div class="BodyContainer">
	<table class="OuterPanel">
	<tr>
		<td class="Intro" style="padding-bottom:10px">
			<input type="button" onclick="document.location.href='index.php?ToDo=%%GLOBAL_CreateCustomItemAction%%'" name="createNewPage" value="%%LNG_CreateCustomPage%%..." class="Button"> &nbsp;
			<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% /> 
	    </td>
	</tr>
	<tr>
		<td style="padding-top: 10px;">
			<form method="post" id="frmContents" onSubmit="return false" action="index.php?ToDo=%%GLOBAL_FormAction%%">
				<table class="GridPanel SortablePanel" cellspacing="0" cellpadding="0" border="0" style="width:100%; display: %%GLOBAL_DisplayGrid%%">
					<tr class="Heading3">
						<td style="padding-left: 5px;" width="1"><input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)"></td>
						<td>%%LNG_ItemTitle%%</td>
						<td width="60">
							%%LNG_VisibleInCustomPage%%
						</td>
						<td width="180">
							%%LNG_Action%%
						</td>
					</tr>
				</table>
                <div id="FullCategoryGrid">                     
				    %%GLOBAL_CustomItemsGrid%%        
                </div>
			</form>
		</td>
	</tr>
	</table>
</div>
</body>
</html>