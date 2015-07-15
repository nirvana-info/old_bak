<form enctype="multipart/form-data" onsubmit="return ValidateForm(CheckForm);" action="index.php?ToDo=saveRedirectSettings" name="frmSettings" id="frmSettings" method="post">
    
    <div class="BodyContainer">
    <table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
        <tr>
            <td class="Heading1">%%LNG_RedirectSettings%%</td>
        </tr>
        <tr>
        <td class="Intro">
            <p>%%LNG_RedirectSettingsIntro%%</p>
            
            %%GLOBAL_Message%%
                
        </td>
        </tr>
       
    </table>
    
    <table width="100%" class="Panel" style="%%GLOBAL_HideProxyFields%%">
                   
                    <tr>
                        <td class="FieldLabel">
                            
                        </td>
                        
                         <table>
   <tr><td>  <b>Source URL</b>  </td>  <td > <b>Destination URL</b> </td>  <td > <b>Record Locator Number</b> </td>  <td >  </td>       
   </tr>
            %%GLOBAL_urlgrid%% 
            
       <tr>
        <tr>
        <td colspan="3">
            <br>
            %%LNG_RedirectSettingsHelp%%   
                
        </td>
        </tr> 
         
         
      <td>   <input type="text" name="newsource_url" id="newsource_url" value="" class="Field400"> </td>  <td>   <input type="text" name="newdestination_url" id="newdestination_url" value="" class="Field400">  </td>     <td>   <input type="text" name="RecordLocatorNumber" id="RecordLocatorNumber" value="" class="Field50">  </td>    <td>
     
      </td> 
       </tr>         
         
</table>
  </div> 
<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain"  align="left">
                <tr>
                    <td width="10">
                        &nbsp;
                    </td>
                    <td align="left">
                        <input type="submit"  value="%%LNG_Save%%" class="FormButton" />
                        <input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
                    </td>
                </tr>
            </table>
 </div>
    </form>   
    
<script type="text/javascript">      
     function ConfirmCancel()
    {
        if(confirm("%%LNG_ConfirmCancelSettings%%"))
            document.location.href = "index.php";
    }
    
    function CheckForm(){
        var valid = true;
        $.each($('input[type=text]','td:first-child'),function(index){
            var source_url = $.trim($(this).val());
            var dest_url = $.trim($(this).parent().next().find(':first-child').val());
            if(source_url.length > 0 && source_url === dest_url){
                valid = false;
                this.focus();
                return false;
            }
        });
        
        if(!valid){
            alert('The destination url is same with the source url !');
            return false;
        }
        
        return true;
    }
</script>