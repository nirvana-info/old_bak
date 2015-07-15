	<div class="BodyContainer">

	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
		<td class="Heading1" id="tdHeading">%%LNG_ViewOffers%%</td>             	
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_OrderIntro%%</p>
			<div id="OrdersStatus">
				%%GLOBAL_Message%%
			</div>
			      <div style="display: %%GLOBAL_DisplayGrid%%">
                    <select id="OrderActionSelect" name="OrderActionSelect" class="Field200">
                        %%GLOBAL_OrderActionOptions%%
                      
                    </select>
                    <input type="button" id="OrderActionButton" name="OrderActionButton" value="%%LNG_OrderActionButton%%" class="FormButton" style="width:40px;" onclick="HandleOfferAction()" />
                </div>
			</td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<form name="frmOrders1" id="frmOrders1" method="post" action="index.php?ToDo=deleteOffers">
				<div class="GridContainer" id="GridContainer">
					%%GLOBAL_OrderDataGrid%%
				</div>
			</form>
		</td></tr>
	</table>
	</div>
		
		</div>
		</div>
		</div>
	</div>

	<script type="text/javascript">

		var tok = "%%GLOBAL_AuthToken%%";
		var delete_offers_choose_message = "%%LNG_ChooseOrder%%";
		var print_orders_choose_message = "%%LNG_ChooseOrderInvoice%%";
		var confirm_delete_offers_message = "%%LNG_ConfirmDeleteOffers%%";
		var order_status_update_success_message = "%%LNG_OrderStatusUpdated%%";
		var failed_order_status_update_message = "%%LNG_OrderStatusUpdateFailed%%";
		var confirm_update_order_status_message = "%%LNG_ConfirmUpdateOrderStatus%%";
		var trackingno_update_success_message = "%%LNG_TrackingNoUpdated%%";
		var trackingno_update_failed_message = "%%LNG_TrackingNoUpdateFailed%%";
		var delete_custom_search_message = "%%LNG_ConfirmDeleteCustomSearch%%";
		var update_order_status_choose_message = "%%LNG_ChooseOrderUpdateStatus%%";
		var choose_action_option = "%%LNG_ChooseActionFirst%%";
		var delete_orders_choose_message = "%%LNG_ChooseOfferFirst%%";

		lang.ChooseOneMoreItemsToShip = "%%LNG_ChooseOneMoreItemsToShip%%";
		lang.ProblemCreatingShipment = "%%LNG_ProblemCreatingShipment%%";
		lang.SavingNotes = "%%LNG_SavingNotes%%";
		lang.ConfirmDelayCapture = "%%LNG_ConfirmDelayCapture%%";
		lang.ConfirmRefund = "%%LNG_ConfirmRefund%%";
		lang.ConfirmVoid = "%%LNG_ConfirmVoid%%";
		lang.SelectRefundType = "%%LNG_SelectRefundType%%";
		lang.EnterRefundAmount = "%%LNG_EnterRefundAmount%%";
		lang.InvalidRefundAmountFormat = "%%LNG_InvalidRefundAmountFormat%%";

		function ClearCreditCardDetails(orderid) {
			$.ajax({
				url: 'remote.php?w=ClearCreditCardDetails&orderId='+orderid,
				success: function() {
					$('#CCDetails_'+orderid).remove()
				}
			});
		}

		var ExportAction = "%%GLOBAL_ExportAction%%";
        
        function HandleOfferAction()
{
    var sel = $('#OrderActionSelect').val();

    if (sel == '') {
        return;
    } else {
        sel = sel.toLowerCase();
    }

    switch (sel) {
        case 'delete':
            ConfirmDeleteSelected();
            break;
         
        default:
            var matches, regex = /^updatestatus([0-9]+)$/;
            if (matches = sel.match(regex)) {
                BulkUpdateStatus(matches[1]);
            } else {
                alert(choose_action_option);
            }
            break;
    }
}


function ConfirmDeleteSelected()
{
    var fp = document.getElementById("frmOrders1").elements;
    var c = 0;

    for(i = 0; i < fp.length; i++)
    {
        if(fp[i].type == "checkbox" && fp[i].checked)
            c++;
    }

    if(c > 0)
    {
        if(confirm(confirm_delete_offers_message))
            document.getElementById("frmOrders1").submit();
    }
    else
    {
        alert(delete_orders_choose_message);
    }
}


function ToggleDeleteBoxes(Status)
{
    var fp = document.getElementById("frmOrders1").elements;

    for(i = 0; i < fp.length; i++)
        fp[i].checked = Status;
}

function update_offer_status(orderid, statusid, statustext) {

    $('#ajax_status_'+orderid).attr('src', 'images/ajax-loader.gif');
    status_message = statustext.toLowerCase();
    $.ajax({
        url: 'remote.php?w=updateOfferStatus&o='+orderid+'&s='+statusid+'&t='+tok,
        success: function(response) {
            $('#ajax_status_'+orderid).attr('src', 'images/ajax-blank.gif');
            if(response == 1) {

                $('#order_status_column_'+orderid).html(statustext);
		// 2011-07-04 johnny modify for reject action
                if(statustext == 'Rejected'){
			$('#order_action_'+orderid).attr("disabled", "disabled");
			$('#order_status_column_'+orderid).css("border-left-color", "#000000");
		}
                display_success('OrdersStatus', order_status_update_success_message.replace("%d", orderid).replace("%s", status_message));
            }
            else {
                alert(failed_order_status_update_message);
            }
        },
        error: function()
        {
            $('#ajax_status_'+orderid).attr('src', 'images/ajax-blank.gif');
            alert(failed_order_status_update_message);
        }
    });
}


function editOrder(orderid , action) {    
       
        if(!action) {
            return false;
        }
     
        switch(action) {
            case 'editOrder':
               window.location = 'index.php?ToDo=editOffer&orderId='+orderid;                                           
                break;
            case 'approveOrder':
                update_offer_status(orderid, 12, 'Approved')   ;
                break;
            case 'rejectOrder':
                update_offer_status(orderid, 13, 'Rejected')   ;                 
                break;
        }   
  
}




function OfferQuickView(id) {
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

            $(trQ).find('.QuickView').load('remote.php?w=offerQuickView&o='+id, {'cache': false}, function() {
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
