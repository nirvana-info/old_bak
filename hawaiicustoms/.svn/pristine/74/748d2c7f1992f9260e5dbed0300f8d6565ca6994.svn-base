<html>

<head>

<title>%%LNG_DesignMode%%</title>

<style>

	* { font-family:Arial; font-size:11px; }

	body { margin:0px; padding:0px; }

	textarea { width:550px; height:346px; font-family:courier; }

	select { width:250px; height:347px; }

	.DesignModeMenu { background-color:#EFEDDE; border-bottom: solid 1px #928F82; width:800; height:28px; }

	.DesignModeButton { margin:3px; cursor:pointer; border:solid 1px #EFEDDE; }

	.DesignModeButtonOver { margin:3px; cursor:pointer; background-color:#C1D2EE; border:solid 1px #316AC5; }

	.Notice { background-color:#808080; color:white; padding:5px; font-weight:bold; }

</style>

</head>

<body>

	<form id="dm_form" name="dm_form" action="designmode.php" method="post">

	<input type="hidden" name="ToDo" value="saveUpdatedFile">

	<input type="hidden" name="File" value="%%GLOBAL_FileName%%">

	<div id="design_mode_menu" class="DesignModeMenu">

		<div style="float:right; padding:8px 10px 0px 0px">%%LNG_Editing%% %%GLOBAL_FileName%%</div>

		<table border="0" cellpadding="0" cellspacing="0">

			<tr>

				<td><img title="%%LNG_SaveDesignMode%%" src="%%GLOBAL_TPL_PATH%%/images/IcoDesignModeSave.gif" class="DesignModeButton" onmouseover="this.className='DesignModeButtonOver'" onmouseout="this.className='DesignModeButton'" onclick="document.forms['dm_form'].submit()" /></td>

				<td><img title="%%LNG_CancelDesignMode%%" src="%%GLOBAL_TPL_PATH%%/images/IcoDesignModeCancel.gif" class="DesignModeButton" onmouseover="this.className='DesignModeButtonOver'" onmouseout="this.className='DesignModeButton'" onclick="design_mode_cancel()" /></td>

				<td><img title="%%LNG_UpdateDesignMode%%" src="%%GLOBAL_TPL_PATH%%/images/IcoDesignModeUpdate.gif" class="DesignModeButton" onmouseover="this.className='DesignModeButtonOver'" onmouseout="this.className='DesignModeButton'" onclick="design_mode_update()" /></td>

			</tr>

		</table>

	</div>

	<table width="800" height="370" border="0" cellspacing="0" cellpadding="0">

		<tr>

			<td width="250" valign="top">

				<div class="Notice">%%LNG_FilesUsedByTemplate%%:</div>

				<select id="filelist" name="filelist" size="3" title="%%LNG_SnippetsInPanel%%" onDblClick="load_file(this.options[this.selectedIndex].value)">

					<optgroup class="stylegroup" label="%%LNG_Stylesheets%%">

						%%GLOBAL_StyleSheetFileList%%

					</optgroup>

					<optgroup class="stylegroup" label="%%LNG_Layouts%%">

						%%GLOBAL_LayoutFileList%%

					</optgroup>

					<optgroup class="stylegroup" label="%%LNG_Panels%%">

						%%GLOBAL_PanelFileList%%

					</optgroup>

					<optgroup class="stylegroup" label="%%LNG_Snippets%%">

						%%GLOBAL_SnippetFileList%%

					</optgroup>

				</select>

			</td>

			<td width="550">

				<div class="Notice">%%LNG_ContentsOfFile%% %%GLOBAL_FileName%%:</div>

				<textarea id="FileContent" name="FileContent" onKeyDown="made_changes=true">%%GLOBAL_FileContent%%</textarea>

			</td>

		</tr>

	</table>

	</form>



	<script type="text/javascript">



		var made_changes = false;



		function load_file(file) {

			var url = "%%GLOBAL_ShopPath%%/admin/designmode.php?ToDo=editFile&File=" + file;



			if(made_changes) {

				if(confirm("%%LNG_DesignModeChangeFile%%"))

					document.location.href = url;

			}

			else {

				document.location.href = url;

			}

		}



		function design_mode_cancel() {

			if(confirm("%%LNG_DesignModeConfirmCancel%%")) {

				window.close();

			}

		}



		function design_mode_update() {

			update = false;



			if(made_changes) {

				if(confirm("%%LNG_DesignModeChangeFile%%"))

					update = true;

			}

			else {

				update = true;

			}



			if(update) {

				if(opener) {

					open_loc = opener.document.location.href;

					open_loc = open_loc.replace("#design_mode_done", "");

					opener.document.location.href = open_loc;

				}

				window.close();

			}

		}



		// If a file was just saved, shown a confirmation alert

		%%GLOBAL_SavedOKAlert%%



	</script>

</body>

</html>