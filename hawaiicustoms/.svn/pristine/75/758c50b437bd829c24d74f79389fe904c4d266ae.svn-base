<script type="text/javascript" src="../javascript/jquery.blockUI.js"> </script>
	<div class="BodyContainer">
		<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_ImportProductsStep3%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_ImportProductsStep3Desc%%
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<input type="button" value="%%LNG_StartImport%%" id="StartImport" onclick="startImport(); return false;" class="FormButton" />
			</td>
		</tr>
		</table>
	</div>
	
	<div id="modelMsg" style="display:none;"><iframe id="testIframe" src="" width="429" height="252" frameborder="0" scrolling="no" hsapce="0"></iframe></div>
	
	<script type="text/javascript">
		function ConfirmCancel()
		{
			if(confirm('%%LNG_ConfirmCancelImport%%'))
				window.location = 'index.php?ToDo=importProducts';
		}

		function startImport()
		{
			tb_show('', 'index.php?ToDo=importProducts&Step=ImportFrame&ImportSession=%%GLOBAL_ImportSession%%&keepThis=true&x='+Math.random()+'&TB_iframe=tue&height=240&width=400&modal=true', '');
			document.getElementById('StartImport').disabled = true;
			document.getElementById('StartImport').value = '%%LNG_ImportRunning%%';
		}

		function startImport3()
		{
			window.location = 'index.php?ToDo=importProducts&Step=4&ImportSession=%%GLOBAL_ImportSession%%&keepThis=true&TB_iframe=tue&height=240&width=400&modal=true';
		}

		function startImport2()
		{
            document.getElementById('testIframe').src="index.php?ToDo=importProducts&Step=ImportFrame&ImportSession=%%GLOBAL_ImportSession%%&x="+Math.random();
			//window.location = 'index.php?ToDo=importProducts&Step=ImportFrame&ImportSession=%%GLOBAL_ImportSession%%&keepThis=true&TB_iframe=tue&height=240&width=400&modal=true';
            document.getElementById('modelMsg').style.display='';
		    $.blockUI({ 
			    message: $('#modelMsg'),
			    overlayCSS : 
			    {
				   //opacity : '0.75',
				    backgroundColor : 'Black'
			    },
			    css : 
			    {
				    //border : 'solid gray 1px',
				   // opacity : '0.9',
				    cursor : 'default',
				    top:'230px'
				    
				    //left: leftDis,
				    //width: widDis+'px'
			    },
			    baseZ : 10000
			    
		    });
		    document.getElementById('StartImport').disabled = true;
			document.getElementById('StartImport').value = '%%LNG_ImportRunning%%';
		}
	</script>