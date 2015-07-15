<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link href="%%GLOBAL_TPL_PATH%%/Styles/popup.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="%%GLOBAL_ShopPath%%/javascript/jquery.js"></script>
        <!--Added by Simha-->              
        <link href="%%GLOBAL_ShopPath%%/templates/default/Styles/basic.css" type="text/css" rel="stylesheet" />  
        <link href="%%GLOBAL_ShopPath%%/templates/default/Styles/galleriffic.css" type="text/css" rel="stylesheet" />  
        <!--Added by Simha-->
		<script type="text/javascript">
			///
            function savedAssoc(catid)   {
                alert('Association saved successfully');   
                window.opener.listUpdatedQualifiers("quals-"+catid, catid);
                window.close();
            }
            
            function validate() {
                var dp = document.getElementById('qualifier');
                if(dp.value=="")  {
                    alert('Please select valid qualifier name'); 
                    return false;
                }      
                return true; 
            }
            
		</script>
	</head>
	<body>
         <form id="frm" method="post" onsubmit="return validate();" action="assignqualifiers.php?Todo=saveassigning">
             <input value="%%GLOBAL_CategoryId%%" id="categoryid" name="categoryid" type="hidden">
		     <div id="FullTab" style="%%GLOBAL_DisplayDiv%%">
                <table>
                    <tr>  
                        <td colspan="4">    
                            &nbsp; 
                        </td>
                    </tr>
                    <tr>  
                        <td>    
                            &nbsp; 
                        </td>
                        <td>    
                            Qualifier Name : 
                        </td>
                        <td colspan="2">    
                            %%GLOBAL_DDQualifiers%% 
                        </td>
                    </tr>
                    <tr>  
                        <td colspan="4">    
                            &nbsp; 
                        </td>  
                    </tr>
                    <tr>  
                    
                        <td colspan="2">
                            &nbsp;
                        </td>
                        <td colspan="1" align="right">    
                            <input value="Save" type="submit"> 
                        </td>
                        <td align="left">    
                            <input value="Cancel" type="button" onclick="javascript:window.close();"> 
                        </td>
                    </tr>
                 </table>
             </div>
         </form>
	</body>
</html>
