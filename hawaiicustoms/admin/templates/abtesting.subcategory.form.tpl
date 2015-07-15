
    <form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" onSubmit="return ValidateForm(CheckPageForm);" id="frmNews" method="post">
    <input type="hidden" name="pageId" id="pageId" value="%%GLOBAL_PageId%%">
    <div class="BodyContainer">
    <table class="OuterPanel">
        <tr>
            <td class="Heading1" id="tdHeading">%%GLOBAL_Title%%</td>
        </tr>
        <tr>
            <td class="Intro">
                <p>%%LNG_PageIntro%%</p>
                %%GLOBAL_Message%%
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:8px">
                <input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" />
                <input type="submit" name="addAnother" value="%%GLOBAL_SaveAndAddAnother%%" class="FormButton" style="width:130px" />
                <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel();" />
            </td>
        </tr>
        <tr>
            <td>
              <table class="Panel">
                <tr>
                  <td class="Heading2" colspan=2>%%LNG_NewPagesDetails%%</td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        <span class="Required">*</span>&nbsp;%%LNG_PageTitle%%:
                    </td>
                    <td>
                        <input type="text" id="pagetitle" name="pagetitle" class="Field400" value="%%GLOBAL_PageTitle%%">
                        <img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_PageTitle%%', '%%LNG_PageTitleHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d1"></div><br />
                    </td>
                </tr>
                
                <tr>
                    <td class="FieldLabel">
                        <span class="Required">*</span>&nbsp;%%LNG_PageName%%:
                    </td>
                    <td>
                        <input type="text" id="pagename" name="pagename" class="Field400" value="%%GLOBAL_PageName%%">
                        <img onmouseout="HideHelp('d6');" onmouseover="ShowHelp('d6', '%%LNG_PageName%%', '%%LNG_PageNameHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                    <div style="display:none" id="d6"></div><br />
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                         <span class="Required">*</span>&nbsp;%%LNG_Category%%:
                    </td>
                    <td>
                        <select id="category" name="category" onchange="SelectTestingSubCategory(this.value)">%%GLOBAL_Category%%</select>
                    </td>
                </tr>    
                <tr>
                    <td class="FieldLabel">
                         <span class="Required">*</span>&nbsp;%%LNG_SubCategory%%:
                    </td>
                    <td id="tdsubcat">
                        <span style="%%GLOBAL_DisplayCategory%%">
                        <select id="subcategory" name="subcategory">
                            <option value="">%%LNG_SelectSubcategory%%</option>
                        </select>
                        </span>
                        <span style="%%GLOBAL_DynamicCategory%%">
                        %%GLOBAL_SubCategory%%
                        </span>
                    </td>
                </tr>    
                <tr class="HideIfNotPage PageContent">
                    <td class="FieldLabel">
                        %%LNG_HeaderDescription%%:
                    </td>
                    <td>
                        %%GLOBAL_WYSIWYG%%
                    </td>
                </tr>
                <tr class="HideIfNotPage PageContent">
                    <td class="FieldLabel">
                        %%LNG_FooterDescription%%:
                    </td>
                    <td>
                        %%GLOBAL_WYSIWYG1%%
                    </td>
                </tr>
                <tr>
                  <td class="Heading2" colspan=2>%%LNG_TrackingCode%%</td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                    &nbsp;&nbsp;&nbsp;%%LNG_ControlScript%%:
                    </td>
                    <td>
                    <textarea rows="8" cols="75" name="controlscript" id="controlscript">%%GLOBAL_controlscript%%</textarea>
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                    &nbsp;&nbsp;&nbsp;%%LNG_TrackingScript%%:
                    </td>
                    <td>
                    <textarea  rows="8" cols="75" name="trackingscript" id="trackingscript">%%GLOBAL_trackingscript%%</textarea>
                    </td>
                </tr>
                <tr>
                    <td class="Gap">&nbsp;</td>
                    <td class="Gap">
                        <input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" />
                        <input type="submit" name="addAnother" value="%%GLOBAL_SaveAndAddAnother%%" class="FormButton" style="width:130px" />
                        <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
                    </td>
                </tr>
             </table>
            </td>
        </tr>
    </table>

    </div>
    </form>

    <script type="text/javascript">
        function ConfirmCancel()
        {
            if(confirm("%%LNG_ConfirmCancelPage%%"))
                document.location.href = "index.php?ToDo=viewABTesting";
        }

        function CheckPageForm()
        {
            var pagetitle = g("pagetitle");
            var pagename = g("pagename");
            var category = g("category");
            var productsubcat = g("productsubcat");

            if(pagetitle.value == "")
            {
                alert("%%LNG_EnterPageTitle%%");
                pagetitle.focus();
                return false;
            }
            
            if(pagename.value == "")
            {
                alert("%%LNG_EnterPageName%%");
                pagename.focus();
                return false;
            }
            
            if(category.selectedIndex == 0) {
                    alert("%%LNG_NoSelectCategory%%");
                    category.focus();
                    return false;
            }
            
            if(productsubcat.selectedIndex == 0) {
                    alert("%%LNG_NoSelectSubcategory%%");
                    productsubcat.focus();
                    return false;
            }

            
            // Everything is OK
            return true;
        }

    </script>
