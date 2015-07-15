<div>
	<div id="ModalTitle">
		%%LNG_EditKeyword%%
	</div>
	<div id="ModalContent" style="min-height: 100px; max-height: 400px; overflow: auto;">
		<p class="MessageBox MessageBoxInfo" id='resultMessage'>%%GLOBAL_AltMessage%%</p>
		<br />
		<div style="min-height: 100px; max-height: 250px; overflow: auto;" align='center'>
			<label>%%LNG_Keywords%%: </label>
			<input type="text" id='keyword' name='keyword' value='%%GLOBAL_Keyword%%' size='60'/>
			<input type="hidden" id='keywordType' name='keywordType' value='%%GLOBAL_KeywordType%%'/>
			<input type="hidden" id='oldword' name='oldword' value='%%GLOBAL_Keyword%%'/>
			<input type="hidden" id='sid' name='sid' value='%%GLOBAL_Sid%%'/>
		</div>
	</div>
	<div id="ModalButtonRow">
		<div class="FloatLeft"><input class="CloseButton" type="button" value="%%LNG_Close%%"/></div>
		<img src="images/loading.gif" alt="" style="display: none" class="LoadingIndicator" />
		<input type="button" id='SaveBtn' class="Submit SubmitButton" value="%%LNG_Save%%" style="display:%%GLOBAL_ShowSaveBtn%%"/>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.CloseButton', '#ModalButtonRow').click( function(){
			$('#ModalContainer').remove();
			$('#ModalLoadingIndicator').remove();
			$('#ModalOverlay').remove();
			$('#ModalTempiFrame').remove();
	});

	setTimeout(function(){$('#keyword').focus();}, 100);
	$('#SaveBtn').click(function(){
		var oldword = $('#oldword').val();
		var keyword = $('#keyword').val();
		var sid =  $('#sid').val();
		var type =  $('#keywordType').val();
		//trim space of $keyword
		var words = keyword.split(',');
		var strWordlist = "";
		for(var i=0;i<words.length;i++)
		{
		     strWordlist=strWordlist+trim(words[i])+",";
		}	
		keyword=strWordlist.substring(0,strWordlist.length-1);		
		$.ajax({
				type	: "POST",
				url: "index.php?ToDo=saveKeyword&ajax=1",
				data: {
		        	'type': type,
		        	'sid': sid,
		        	'keyword': keyword,
		        	'oldword': oldword
		        },
				success: function(data){
					$('#resultMessage').html(data);
					$('#SaveBtn').attr('disabled', true);
					$.ajax({
						type	: "GET",
						url: "index.php?ToDo=viewKeywords&ajax=0",
						//url: "index.php?ToDo=prodKeywords",
						data: {},
						success: function(data){
							$('#keywordsContent').html(data);
							    
							$('.no_dup_class').each(function(){
								$(this).find('.itemList').hide();
								$(this).find('img').attr('src','%%GLOBAL_ShopPath%%/admin/images/plus.gif');
							});
							
							//$(document).scrollTop(0);
						}
					});
				}
		});
	});
});
</script>