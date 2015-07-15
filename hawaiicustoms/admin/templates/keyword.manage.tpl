<div style='padding: 0px 15px;'>
	<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_ProductKeywords%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_ManageKeywordsIntro%%</p>
				%%GLOBAL_Message%%
			</td>
		</tr>
		<tr>
			<td>
				<div id='keywordsContent'>
					<table class="Panel">
						<tr>
							<td class="Heading2">
								%%LNG_TitleCategory%%
							</td>
						</tr>
						<tr>
							<td>%%GLOBAL_AllCategoryKeywords%%</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="Heading2">
								%%LNG_TitleBrand%%
							</td>
						</tr>
						<tr>
							<td>%%GLOBAL_AllBrandKeywords%%</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
</div>
<script>
	lang.NoKeywordDefined = '%%LNG_NoKeywordDefined%%';
	var duplicatedWords = '%%GLOBAL_DuplicatedWords%%';
	var highlightWords = duplicatedWords.split('_');	
	function urlencode(str) 
	{
		str = (str+'').toString();
		return encodeURIComponent(str).replace(/!/g, '%21')
		        .replace(/'/g, '%27')
		        .replace(/\(/g, '%28')
			.replace(/\)/g, '%29')
			.replace(/\*/g, '%2A')
			.replace(/%20/g, '+');
	}
	//Shirley modified 2011/3/2	
	function hignlight_text(id, key, color, bold)
	{
	       var text = key;
	
	       //if(text.length > 0)
	       //{
		    $(id+":contains('"+text+"')").each(function (i){
			var b = $(this).html();
			var words = b.split(',');
			var strWordlist = "";			
			var markWord=false;
			//alert(words.length);			
			for(var i=0;i<words.length;i++)
			{
				if(trim(words[i])==trim(text))
				{
					var text_a = words[i].fontcolor(color);
					text_a = bold == true ? text_a.bold () : text_a;
					strWordlist=strWordlist+text_a+",";
					markWord=true;
				}
				else strWordlist=strWordlist+words[i]+",";
			}	
			$(this).html(strWordlist.substring(0,strWordlist.length-1));
			var idWordlist=$(this).attr("id");
			var idWord=idWordlist.split('_');
			if(markWord)
			{
				if(idWord[0]=="subcategory"||idWord[0]=="series")
				{
				    //$(this).parent().parent().prepend("<li>"+$(this).parent().html()+"</li>");
				    //$(this).parent().remove();					
				}				
			}
			//var re = eval('/'+'\b'+text+'\b'+'/g');
			//var re="\,\b"+text+"\\b";
			//var re2="\\b"+text+"\\b,";			
		    });
	       //}
	}
	/*//Shirley 2011/3/1
	function highlight_Shirley()
	{		
		var keywordsTextEles=$('#keywordsContent a[class$=editableItem]');		
		for(var i=0;i<keywordsTextEles.length;i++)
		{
			var keywordsText=keywordsTextEles[i].innerHTML;			
			if(keywordsText.length>0)
			{
				var keywords = keywordsText.split(',');
				for(var j=0;j<keywords.length;j++)
				{
					var color = '#'+(Math.random()*0xffffff<<0).toString(16);
					var text = "";
					for(var k=j+1;k<keywords.length;k++)
					{
						if(keywords[k].length>0&&trim(keywords[k])==trim(keywords[j]))
						{							
							text=trim(keywords[k]);							
						}
						
					}
					if(text!="")
					{
						var b = keywordsTextEles[i].innerHTML;
						var text_a = text.fontcolor(color);
						text_a = text_a.bold ();				
						var re = eval('/'+text+'/g');						
						keywordsTextEles[i].innerHTML=b.replace(re,text_a);
						text="";
					}
				}				
			
			}
		}		
					
	}*/
	
	$(function(){
		/*$("#LoadingKeywords").ajaxSend(function(){
			$(this).html("<font style='background:#990000;color:#FFFFFF;'>loading...</font>");			
			});*/
		
		//$.get();
		/*$.ajax({
			type: "GET",
			url:"index.php?ToDo=viewKeywords&ajax=1",
			data:{},
			success:function(data){
				//$(this).html("<font style='background:#990000;color:#FFFFFF;'>loading sucess...</font>");			
				
			}
			});*/
		//alert("keywords page");
		/*$.each(highlightWords, function(){
			hignlight_text('#keywordsContent a', this, '#'+(Math.random()*0xffffff<<0).toString(16), true);
		});*/
		//highlight_Shirley();		
		//alert($('#keywordsContent font')[0]);
		
		$('img:first', '.keywordItem').click(function (){
		    var imgObj = $(this);
		    var listObj = $('.itemList', $(this).parent().parent().parent());
		    if (listObj.is(":hidden")) {
			listObj.slideDown();
			imgObj.attr('src','%%GLOBAL_ShopPath%%/admin/images/minus.gif');
		    } else {
			listObj.slideUp();
			imgObj.attr('src','%%GLOBAL_ShopPath%%/admin/images/plus.gif');
		    }
		});
		
		$('.editableItem').click(function(){
			var linkName = $.trim(this.id);
			var keyword = $(this).html()== lang.NoKeywordDefined ? '' : $(this).attr('name');
			if(linkName.length > 0){
				var optionArr = linkName.split('_');
				var type = optionArr[0];
				var sid = optionArr[1];
				var nameStr = $(this).prev().html();
				var name = urlencode(nameStr.substr(0, nameStr.length-1));
				var keyword = urlencode(keyword);
				
				$.iModal({
					type: 'ajax',
					url: 'index.php?ToDo=editKeyword&type='+type+'&sid='+sid+'&keyword='+keyword+'&name='+name
				});
			}else{
				alert("You've selected a wrong link!");
			}
		});
		
		$('.no_dup_class').each(function(){
			$(this).find('.itemList').hide();
			$(this).find('img').attr('src','%%GLOBAL_ShopPath%%/admin/images/plus.gif');
		});
	});
</script>