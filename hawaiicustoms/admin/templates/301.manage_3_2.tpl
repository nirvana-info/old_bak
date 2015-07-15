<form enctype="multipart/form-data" action="index.php?ToDo=saveRedirectSettings" name="frmSettings" id="frmSettings" method="post">
    
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
   <tr><td>  <b>Source URL</b>  </td>  <td > <b>Destination URL</b> </td>    <td></td>
   </tr>
            %%GLOBAL_urlgrid%% 
       <tr>
         
      <td>   <input type="text" name="newsource_url" id="newsource_url" value="" class="Field250"> </td>  <td>   <input type="text" name="newdestination_url" id="newdestination_url" value="" class="Field250">  </td>       <td><b>Add New </b>
      <img onmouseout="HideHelp('hp4');" onmouseover="ShowHelp('hp4', '%%LNG_RedirectSettings%%', '%%LNG_RedirectSettingsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
                            <div style="display:none" id="hp4"></div>
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
</script>