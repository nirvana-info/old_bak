	<div class="BodyContainer">

	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">
				%%LNG_View%%: <a href="#" style="color:#005FA3" id="ViewsMenuButton" class="PopDownMenu">%%GLOBAL_ViewName%% <img width="8" height="5" src="images/arrow_blue.gif" border="0" /></a>
			</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_ManageGiftCertificatesIntro%%</p>
			<div id="GiftCertificatesStatus">
				%%GLOBAL_Message%%
			</div>
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			<td class="Intro" valign="top">
				<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
			</td>
			<td class="SmallSearch" align="right">
				<table id="Table16" style="display:%%GLOBAL_DisplaySearch%%">
				<tr>
					<td class="text" nowrap align="right">
						<form name="frmGiftCertificates" id="frmGiftCertificates" action="index.php?%%GLOBAL_SortURL%%" method="get">
						<input type="hidden" name="ToDo" value="viewGiftCertificates" />
						<input name="searchQuery" id="searchQuery" type="text" value="%%GLOBAL_Query%%" id="SearchQuery" class="SearchBox" style="width:150px" />&nbsp;
						<select name="certificateStatus" id="certificateStatus">
							<option value="">%%LNG_AllStatuses%%</option>
							%%GLOBAL_GiftCertificateStatusList%%
						</select>
						<input type="image" name="SearchButton" style="padding-left: 10px; vertical-align: top;" id="SearchButton" src="images/searchicon.gif" border="0" />
						</form>
					</td>
				</tr>
				<tr>
					<td nowrap>
						<a href="index.php?ToDo=searchGiftCertificates">%%LNG_AdvancedSearch%%</a>
						<span style="display:%%GLOBAL_HideClearResults%%">| <a id="SearchClearButton" href="index.php?ToDo=viewGiftCertificates">%%LNG_ClearResults%%</a></span>
					</td>
				</tr>
				</table>
			</td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<form name="frmGiftCertificates1" id="frmGiftCertificates1" method="post" action="index.php?ToDo=deleteGiftCertificates">
				<div class="GridContainer">
					%%GLOBAL_GiftCertificatesDataGrid%%
				</div>
			</form>
		</td></tr>
	</table>
	</div>
		<div id="ViewsMenu" class="DropDownMenu DropShadow" style="display: none; width:200px">
				<ul>
					%%GLOBAL_CustomSearchOptions%%
				</ul>
				<hr />
				<ul>
					<li><a href="index.php?ToDo=createGiftCertificateView" style="background-image:url('images/view_add.gif'); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px">%%LNG_CreateANewView%%</a></li>
					<li style="display:%%GLOBAL_HideDeleteViewLink%%"><a onclick="$('#ViewsMenu').hide(); ConfirmDeleteCustomSearch('%%GLOBAL_CustomSearchId%%')" href="javascript:void(0)" style="background-image:url('images/view_del.gif'); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px">%%LNG_DeleteThisView%%</a></li>
				</ul>
			</div>
		</div>
		</div>
		</div>
	</div>

<div id="UpdateGiftCertificateActiveStatusArea" style="">
    <form>
        <input type="text" id="gcExpiryDate" /><br/>
        <input readOnly type="hidden" name="giftcertid"/>
        <input type="hidden" name="statusid"/>
        <div><label><input type="checkbox" name="noExcpire"/>Do not expire</label></div>
    </form>
</div>

	<script type="text/javascript">
		function ConfirmDeleteSelected()
		{
			if($('.DeleteCheck:checked').length == 0) {
				alert('%%LNG_ChooseGiftCertificatesToDelete%%');
			}
			else {
				if(confirm('%%LNG_ConfirmDeleteGiftCertificates%%')) {
					$('#frmGiftCertificates1').submit();
				}
			}
		}

		function ConfirmDeleteCustomSearch(id) {
			if(confirm('%%LNG_ConfirmDeleteCustomSearch%%')) {
				document.location.href = "index.php?ToDo=deleteCustomGiftCertificateSearch&searchId="+search_id;
			}
		}

		function QuickGiftCertificateView(id) {
			var tr = document.getElementById("tr"+id);
			var trQ = document.getElementById("trQ"+id);
			var tdQ = document.getElementById("tdQ"+id);
			var img = document.getElementById("expand"+id);

			if(img.src.indexOf("plus.gif") > -1)
			{
				img.src = "images/minus.gif";

				for(i = 0; i < tr.childNodes.length; i++)
				{
					if(tr.childNodes[i].style != null)
						tr.childNodes[i].style.backgroundColor = "#dbf3d1";
				}

				$(trQ).find('.QuickView').load('remote.php?w=giftCertificateQuickView&giftCertificateId='+id, {}, function() {
					trQ.style.display = "";
				});
			}
			else
			{
				img.src = "images/plus.gif";

				for(i = 0; i < tr.childNodes.length; i++)
				{
					if(tr.childNodes[i].style != null)
						tr.childNodes[i].style.backgroundColor = "";
				}
				trQ.style.display = "none";
			}
		}
</script>

<script type="text/javascript" src="%%GLOBAL_ShopPath%%/javascript/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="%%GLOBAL_ShopPath%%/javascript/jquery-ui-1.7.3.custom.min.js"></script>

<style type="text/css">
@import url("/css/jquery-ui-1.7.3.custom.css");
@import url(/css/jquery-ui-user-defined.css);
</style>

<script type="text/javascript">
    var dadaQuery = jQuery.noConflict(true);
    dadaQuery(function() {
        
        function clearGiftCertificateActiveStatusArea() {
            dadaQuery("#UpdateGiftCertificateActiveStatusArea input[name=giftcertid]").val('');
            dadaQuery("#UpdateGiftCertificateActiveStatusArea input[name=statusid]").val('');
        }

         dadaQuery("#gcExpiryDate").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: new Date(),
            showOn: 'button',
            autoSize: true,
            buttonImage: '%%GLOBAL_ShopPath%%/css/images/calendar.gif',
            buttonImageOnly: true
        });
        dadaQuery("#UpdateGiftCertificateActiveStatusArea").dialog({
            autoOpen: false,
            title: "Set Expiry Date",
            modal: true,
            buttons: {
                "OK": function() {
                    var gcExpiryDate = $("#gcExpiryDate").val();
                    var noExcpire = $("input[name=noExcpire]").attr('checked') ? 1: 0;
                    if (noExcpire || gcExpiryDate) {
                        var giftcertid = $("#UpdateGiftCertificateActiveStatusArea input[name=giftcertid]").val();
                        var statusid = $("#UpdateGiftCertificateActiveStatusArea input[name=statusid]").val();
                        var expiry = noExcpire ? 0 : gcExpiryDate;

                        UpdateGiftCertificateStatus2(giftcertid, statusid, expiry);
                        dadaQuery(this).dialog('close');
                    } else
                        alert("You must input expiry date or check no expiry");
                },
                "Cancel": function() {
                    dadaQuery(this).dialog('close');
                }
            },
            close: function() {
                clearGiftCertificateActiveStatusArea();
            },
        });
    });

    window.UpdateGiftCertificateStatus = function(giftcertid, statusid, statustext) {
        if (statusid == 2) {
            dadaQuery("#UpdateGiftCertificateActiveStatusArea input[name=giftcertid]").val(giftcertid);
            dadaQuery("#UpdateGiftCertificateActiveStatusArea input[name=statusid]").val(statusid);
            dadaQuery("#UpdateGiftCertificateActiveStatusArea").dialog("open");
        } else {
            UpdateGiftCertificateStatus2(giftcertid, statusid, statustext);
        }
    }

    window.UpdateGiftCertificateStatus2 = function(giftcertid, statusid, statustext) {
      $('#ajax_status_'+giftcertid).show();
          $.ajax({
        url: 'remote.php?w=updateGiftCertificateStatus&giftCertificateId='+giftcertid+'&status='+statusid + "&expiry=" + statustext,
        success: function(response) {
          $('#ajax_status_'+giftcertid).hide();
          if(response == 0) {
            alert('%%LNG_FailedUpdateGiftCertificateStatus%%');
          }
          $('.GridContainer').load(CurrentPageLink+'&ajax=1', '', function() {
              BindAjaxGridSorting();
            });
        },
        error: function() {
          alert('%%LNG_FailedUpdateGiftCertificateStatus%%');
        }
      });
    }
</script>