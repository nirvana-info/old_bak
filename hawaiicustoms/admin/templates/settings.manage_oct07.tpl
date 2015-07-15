	<form enctype="multipart/form-data" action="index.php?ToDo=saveUpdatedSettings" name="frmSettings" id="frmSettings" method="post">
	<input id="currentTab" name="currentTab" value="0" type="hidden" />
	<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
	<tr>
		<td class="Heading1">%%LNG_StoreSettings%%</td>
	</tr>
	<tr>
		<td class="Intro" style="padding-bottom:10px">
			<p>%%LNG_SettingsIntro%%</p>
			%%GLOBAL_Message%%
			<p>
				<input type="submit" disabled="disabled" value="%%LNG_Save%%" class="FormButton" />
				<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
			</p>
		</td>
	</tr>
	<tr>
		<td>
			<ul id="tabnav">
				<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_WebsiteSettings%%</a></li>
				<li><a href="#" id="tab1" onclick="ShowTab(1)">%%LNG_LocalizationSettings%%</a></li>
				<li><a href="#" id="tab2" onclick="ShowTab(2)">%%LNG_DisplaySettings%%</a></li>
				<li style="display: %%GLOBAL_HideBackupSettings%%"><a href="#" id="tab3" onclick="ShowTab(3)">%%LNG_BackupSettings%%</a></li>
				<li><a href="#" id="tab4" onclick="ShowTab(4)" style="%%GLOBAL_HideLoggingSettingsTab%%" >%%LNG_LoggingSettings%%</a></li>
				<li><a href="#" id="tab5" onclick="ShowTab(5)" style="%%GLOBAL_HideVendorOptions%%">%%LNG_VendorSettings%%</a></li>
				<li><a href="#" id="tab6" onclick="ShowTab(6)">%%LNG_MiscellaneousSettings%%</a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			<div id="div0" style="padding-top: 10px;">
				<table width="100%" class="Panel">
				<tr>
					<td class="Heading2" colspan="2">%%LNG_SiteSettings%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="StoreName">%%LNG_StoreName%%:</label>
					</td>
					<td>
						<input type="text" name="StoreName" id="StoreName" value="%%GLOBAL_StoreName%%" class="Field250" />
						<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_StoreName%%', '%%LNG_StoreNameHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="d1"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="StoreName">%%LNG_StoreAddress%%:</label>
					</td>
					<td>
						<textarea name="StoreAddress" id="StoreAddress" class="Field250" rows="4">%%GLOBAL_StoreAddress%%</textarea>
						<img onmouseout="HideHelp('d38');" onmouseover="ShowHelp('d38', '%%LNG_StoreAddress%%', '%%LNG_StoreAddressHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="d38"></div>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="EmptyRow">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td class="Heading2" colspan="2">%%LNG_SiteSecuritySettings%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp; <label for="StoreName">%%LNG_UseSSLDuringCheckout%%?</label>
					</td>
					<td>
						<input type="checkbox" name="UseSSL" id="UseSSL" value="ON" %%GLOBAL_IsSSLEnabled%% /> <label for="UseSSL">%%LNG_YesUseSSLDuringCheckout%%</label>
						<img onmouseout="HideHelp('d37');" onmouseover="ShowHelp('d37', '%%LNG_UseSSLDuringCheckout%%', '%%LNG_UseSSLDuringCheckoutHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="d37"></div>
						<div style="margin-top:3px; padding-left:20px"><a style="color:gray" href="#" onclick="LaunchHelp(715)">%%LNG_SSLWontLoad%%</a></div>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="EmptyRow">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td class="Heading2" colspan="2">%%LNG_AdvancedStoreSettings%%</td>
				</tr>
				<tr style="%%GLOBAL_HideStoreUrlField%%">
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="ShopPath">%%LNG_ShopPath%%:</label>
					</td>
					<td>
						<input type="text" name="ShopPath" id="ShopPath" value="%%GLOBAL_ShopPathNormal%%" class="Field250" />
						<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_ShopPath%%', '%%LNG_ShopPathHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="d2"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="CharacterSet">%%LNG_CharacterSet%%:</label>
					</td>
					<td>
						<input type="text" name="CharacterSet" id="CharacterSet" value="%%GLOBAL_CharacterSet%%" class="Field250" />
						<img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_CharacterSet%%', '%%LNG_CharacterSetHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="d3"></div>
					</td>
				</tr>
				<tr style="%%GLOBAL_HidePathFields%%">
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="DownloadDirectory">%%LNG_DownloadDirectory%%:</label>
					</td>
					<td>
						<input type="text" name="DownloadDirectory" id="DownloadDirectory" value="%%GLOBAL_DownloadDirectory%%" class="Field250" />
						<img onmouseout="HideHelp('d6');" onmouseover="ShowHelp('d6', '%%LNG_DownloadDirectory%%', '%%LNG_DownloadDirectoryHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="d6"></div>
					</td>
				</tr>
				<tr style="%%GLOBAL_HidePathFields%%">
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="ImageDirectory">%%LNG_ImageDirectory%%:</label>
					</td>
					<td class="PanelBottom">
						<input type="text" name="ImageDirectory" id="ImageDirectory" value="%%GLOBAL_ImageDirectory%%" class="Field250" />
						<img onmouseout="HideHelp('d7');" onmouseover="ShowHelp('d7', '%%LNG_ImageDirectory%%', '%%LNG_ImageDirectoryHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="d7"></div>
					</td>
				</tr>
                <!--Added by Simha-->
                <tr style="%%GLOBAL_HidePathFields%%">
                    <td class="FieldLabel">
                        <span class="Required">*</span> <label for="InstallImageDirectory">%%LNG_InstallImageDirectory%%:</label>
                    </td>
                    <td class="PanelBottom">
                        <input type="text" name="InstallImageDirectory" id="InstallImageDirectory" value="%%GLOBAL_InstallImageDirectory%%" class="Field250" />
                        <img onmouseout="HideHelp('ii7');" onmouseover="ShowHelp('ii7', '%%LNG_InstallImageDirectory%%', '%%LNG_InstallImageDirectoryHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
                        <div style="display:none" id="ii7"></div>
                    </td>
                </tr>
                <tr style="%%GLOBAL_HidePathFields%%">
                    <td class="FieldLabel">
                        <span class="Required">*</span> <label for="VideoDirectory">%%LNG_VideoDirectory%%:</label>
                    </td>
                    <td class="PanelBottom">
                        <input type="text" name="VideoDirectory" id="VideoDirectory" value="%%GLOBAL_VideoDirectory%%" class="Field250" />
                        <img onmouseout="HideHelp('ii8');" onmouseover="ShowHelp('ii8', '%%LNG_VideoDirectory%%', '%%LNG_VideoDirectoryHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
                        <div style="display:none" id="ii8"></div>
                    </td>
                </tr>
                <tr style="%%GLOBAL_HidePathFields%%">
                    <td class="FieldLabel">
                        <span class="Required">*</span> <label for="InstallVideoDirectory">%%LNG_InstallVideoDirectory%%:</label>
                    </td>
                    <td class="PanelBottom">
                        <input type="text" name="InstallVideoDirectory" id="InstallVideoDirectory" value="%%GLOBAL_InstallVideoDirectory%%" class="Field250" />
                        <img onmouseout="HideHelp('ii9');" onmouseover="ShowHelp('ii9', '%%LNG_InstallVideoDirectory%%', '%%LNG_InstallVideoDirectoryHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
                        <div style="display:none" id="ii9"></div>
                    </td>
                </tr>
                <!--Added by Simha-->
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp; <label for="StoreName">%%LNG_AllowPurchasing%%?</label>
					</td>
					<td>
						<input type="checkbox" name="AllowPurchasing" id="AllowPurchasing" value="ON" %%GLOBAL_IsPurchasingEnabled%% /> <label for="AllowPurchasing">%%LNG_YesAllowPurchasing%%</label>
						<img onmouseout="HideHelp('dpurchasing');" onmouseover="ShowHelp('dpurchasing', '%%LNG_AllowPurchasing%%', '%%LNG_AllowPurchasingHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="dpurchasing"></div>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="EmptyRow">
						&nbsp;
					</td>
				</tr>
				<tr style="%%GLOBAL_HideLicenseKey%%">
					<td class="Heading2" colspan="2">%%LNG_LicenseSettings%%</td>
				</tr>
				<tr style="%%GLOBAL_HideLicenseKey%%">
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="ShopPath">%%LNG_LicenseKey%%:</label>
					</td>
					<td>
						<input type="text" name="serverStamp" id="serverStamp" value="%%GLOBAL_serverStamp%%" class="Field250" />
					</td>
				</tr>
				<tr style="%%GLOBAL_HideLicenseKey%%">
					<td colspan="2" class="EmptyRow">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td class="Heading2" colspan="2">%%LNG_EmailSettings%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="AdminEmail">%%LNG_AdminEmail%%:</label>
					</td>
					<td>
						<input type="text" name="AdminEmail" id="AdminEmail" value="%%GLOBAL_AdminEmail%%" class="Field250" />
						<img onmouseout="HideHelp('d8');" onmouseover="ShowHelp('d8', '%%LNG_AdminEmail1%%', '%%LNG_AdminEmailHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="d8"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="OrderEmail">%%LNG_OrderEmail%%:</label>
					</td>
					<td>
						<input type="text" name="OrderEmail" id="OrderEmail" value="%%GLOBAL_OrderEmail%%" class="Field250" />
						<img onmouseout="HideHelp('d9');" onmouseover="ShowHelp('d9', '%%LNG_OrderEmail%%', '%%LNG_OrderEmailHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="d9"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel" valign="top">
						<span class="Required">&nbsp;</span> <label for="LowInventoryEmails">%%LNG_LowInventoryEmails%%:</label>
					</td>
					<td class="PanelBottom">
						<label> <input type="checkbox" name="LowInventoryEmails" onclick="if(this.checked) { $('.LowInventoryNotificationToggle').show(); } else { $('.LowInventoryNotificationToggle').hide(); }" value="1" %%GLOBAL_LowInventoryEmailsEnabledCheck%% /> %%LNG_YesEnableLowInventoryEmails%%</label>
						<img onmouseout="HideHelp('lowinventory');" onmouseover="ShowHelp('lowinventory', '%%LNG_LowInventoryEmails%%', '%%LNG_LowInventoryEmailsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="lowinventory"></div>
						<div style="margin-top: 3px; display: %%GLOBAL_HideLowInventoryNotification%%" class="LowInventoryNotificationToggle">
							<img src="images/nodejoin.gif" style="vertical-align: middle;" />
							%%LNG_EmailAddress%%: <input type="text" name="LowInventoryNotificationAddress" id="LowInventoryNotificationAddress" class="Field250" value="%%GLOBAL_LowInventoryNotificationAddress%%" />
						</div>
					</td>
				</tr>
					<tr>
						<td class="FieldLabel" valign="top">
							<span class="Required">&nbsp;</span> <label for="ForwardInvoiceEmails">%%LNG_ForwardInvoiceEmails%%:</label>
						</td>
						<td class="PanelBottom">
							<label> <input type="checkbox" name="ForwardInvoiceEmailsCheck" onclick="if(this.checked) { $('.ForwardInvoiceEmailsToggle').show(); } else { $('.ForwardInvoiceEmailsToggle').hide(); }" value="1" %%GLOBAL_ForwardInvoiceEmailsCheck%% /> %%LNG_YesEnableForwardInvoiceEmails%%</label>
							<img onmouseout="HideHelp('invoiceemailshelp');" onmouseover="ShowHelp('invoiceemailshelp', '%%LNG_ForwardInvoiceEmails%%', '%%LNG_ForwardInvoiceEmailsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="invoiceemailshelp"></div>
							<div style="margin-top: 3px; display: %%GLOBAL_HideForwardInvoiceEmails%%" class="ForwardInvoiceEmailsToggle">
								<img src="images/nodejoin.gif" style="vertical-align: middle;" />
								<input type="text" name="ForwardInvoiceEmails" id="ForwardInvoiceEmails" class="Field250" value="%%GLOBAL_ForwardInvoiceEmails%%" /><br />
								<span class="Disabled" style='text-decoration: none; padding-left: 25px;'>%%LNG_ForwardOrderInvoicesDesc%%</span>
							</div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">&nbsp;</span>
							%%LNG_UseSMTPServer%%:
						</td>
						<td>
							<label for="MailUsePHP">
								<input type="radio" name="MailUseSMTP" id="MailUsePHP" value="0" onclick="ToggleMailSettings()" %%GLOBAL_MailUsePHPChecked%% />
								%%LNG_UseDefaultMailSettings%%
							</label>
							<img onmouseout="HideHelp('ssK6vhkyjO');" onmouseover="ShowHelp('ssK6vhkyjO', '%%LNG_UseDefaultMailSettings%%', '%%LNG_UseDefaultMailSettingsHelp%%');" src="images/help.gif" width="24" height="16" border="0"><div style="display:none" id="ssK6vhkyjO"></div>
							<br />
							<label for="MailUseSMTP">
								<input type="radio" name="MailUseSMTP" id="MailUseSMTP" onclick="ToggleMailSettings()" value="1" %%GLOBAL_MailUseSMTPChecked%% />
								%%LNG_SpecifyOwnSMTPDetails%%
							</label>
							<img onmouseout="HideHelp('ssv0NUivAU');" onmouseover="ShowHelp('ssv0NUivAU', '%%LNG_SpecifyOwnSMTPDetails%%', '%%LNG_SpecifyOwnSMTPDetailsHelp%%');" src="images/help.gif" width="24" height="16" border="0" /><div style="display:none" id="ssv0NUivAU"></div>
						</td>
					</tr>
					<tr class="SMTPOptions" style="display: %%GLOBAL_HideMailSMTPSettings%%">
						<td class="FieldLabel">
							<span class="Required">*</span>
							%%LNG_SMTPHostname%%:
						</td>
						<td>
							<img width="20" height="20" src="images/nodejoin.gif"/>
							<input type="text" name="MailSMTPServer" id="MailSMTPServer" value="%%GLOBAL_MailSMTPServer%%" class="Field250 smtpSettings"> <img onmouseout="HideHelp('ssdR2a1s2Y');" onmouseover="ShowHelp('ssdR2a1s2Y', '%%LNG_SMTPHostname%%', '%%LNG_SMTPHostnameHelp%%');" src="images/help.gif" width="24" height="16" border="0" /><div style="display:none" id="ssdR2a1s2Y"></div>
						</td>
					</tr>

					<tr class="SMTPOptions" style="display: %%GLOBAL_HideMailSMTPSettings%%">
						<td class="FieldLabel">
							<span class="Required">&nbsp;</span>
							%%LNG_SMTPUsername%%:
						</td>
						<td>
							<img width="20" height="20" src="images/blank.gif"/>
							<input type="text" name="MailSMTPUsername" id="MailSMTPUsername" value="%%GLOBAL_MailSMTPUsername%%" class="Field250 smtpSettings"> <img onmouseout="HideHelp('ssL1nZ3ajD');" onmouseover="ShowHelp('ssL1nZ3ajD', '%%LNG_SMTPUsername%%', '%%LNG_SMTPUsernameHelp%%');" src="images/help.gif" width="24" height="16" border="0" /><div style="display:none" id="ssL1nZ3ajD"></div>
						</td>
					</tr>
					<tr class="SMTPOptions" style="display: %%GLOBAL_HideMailSMTPSettings%%">
						<td class="FieldLabel">
							<span class="Required">&nbsp;</span>
							%%LNG_SMTPPassword%%:
						</td>
						<td>
							<img width="20" height="20" src="images/blank.gif"/>
							<input type="password" name="MailSMTPPassword" id="MailSMTPPassword" value="%%GLOBAL_MailSMTPPassword%%" class="Field250 smtpSettings"> <img onmouseout="HideHelp('ss7ELh2UVn');" onmouseover="ShowHelp('ss7ELh2UVn', '%%LNG_SMTPPassword%%', '%%LNG_SMTPPasswordHelp%%');" src="images/help.gif" width="24" height="16" border="0" /><div style="display:none" id="ss7ELh2UVn"></div>
						</td>
					</tr>
					<tr class="SMTPOptions" style="display: %%GLOBAL_HideMailSMTPSettings%%">
						<td class="FieldLabel">
							<span class="Required">&nbsp;</span>
							%%LNG_SMTPPort%%:
						</td>
						<td>
							<img width="20" height="20" src="images/blank.gif"/>
							<input type="text" name="MailSMTPPort" id="MailSMTPPort" value="%%GLOBAL_MailSMTPPort%%" class="Field250 smtpSettings"> <img onmouseout="HideHelp('ssKz8SUyDX');" onmouseover="ShowHelp('ssKz8SUyDX', '%%LNG_SMTPPort%%', '%%LNG_SMTPPortHelp%%');" src="images/help.gif" width="24" height="16" border="0" /><div style="display:none" id="ssKz8SUyDX"></div>
						</td>
					</tr>
					<tr class="SMTPOptions" style="display: %%GLOBAL_HideMailSMTPSettings%%">
						<td class="FieldLabel">
							&nbsp;
						</td>
						<td>
							<img width="20" height="20" src="images/blank.gif"/>
							<input type="button" name="cmdTestSMTP" value="%%LNG_TestSMTPSettings%%" id="TestSMTPSettings" class="SmallButton" onclick="TestSMTPMailSettings();" style="width: 120px;" /> &nbsp;&nbsp;<img src="images/ajax-loader.gif" style="vertical-align: middle; display: none;" id="TestSMTPSettingsLoading" alt="" />
						</td>
					</tr>
				<tr>
					<td colspan="2" class="EmptyRow">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td class="Heading2" colspan="2">%%LNG_SearchEngineOptimization%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">&nbsp;</span>  <label for="MetaDesc">%%LNG_SearchEngineFriendlyURLs%%:</label>
					</td>
					<td>
						<select name="EnableSEOUrls" id="EnableSEOUrls" class="Field250">
							<option value="2" %%GLOBAL_IsEnableSEOUrlsAuto%%>%%LNG_SearchEngineFriendlyURLsAuto%%</option>
							<option value="1" %%GLOBAL_IsEnableSEOUrlsEnabled%%>%%LNG_SearchEngineFriendlyURLsEnabled%%</option>
							<option value="0" %%GLOBAL_IsEnableSEOUrlsDisabled%%>%%LNG_SearchEngineFriendlyURLsDisabled%%</option>
						</select>
						<img onmouseout="HideHelp('seo1');" onmouseover="ShowHelp('seo1', '%%LNG_SearchEngineFriendlyURLs%%:', '%%LNG_SearchEngineFriendlyURLsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="seo1"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">&nbsp;</span> %%LNG_HomePagePageTitle%%:
					</td>
					<td>
						<input type="text" id="HomePagePageTitle" name="HomePagePageTitle" class="Field250" value="%%GLOBAL_HomePagePageTitle%%" />
						<img onmouseout="HideHelp('pagetitle');" onmouseover="ShowHelp('pagetitle', '%%LNG_HomePagePageTitle%%', '%%LNG_HomePagePageTitleHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="pagetitle"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">&nbsp;</span>  <label for="MetaKeywords">%%LNG_MetaKeywords%%:</label>
					</td>
					<td>
						<input type="text" name="MetaKeywords" id="MetaKeywords" value="%%GLOBAL_MetaKeywords%%" class="Field250" />
						<img onmouseout="HideHelp('d4');" onmouseover="ShowHelp('d4', '%%LNG_MetaKeywords%%', '%%LNG_SettingsMetaKeywordsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="d4"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">&nbsp;</span>  <label for="MetaDesc">%%LNG_MetaDescription%%:</label>
					</td>
					<td>
						<input type="text" name="MetaDesc" id="MetaDesc" value="%%GLOBAL_MetaDesc%%" class="Field250" />
						<img onmouseout="HideHelp('d5');" onmouseover="ShowHelp('d5', '%%LNG_MetaDescription%%', '%%LNG_SettingsMetaDescriptionHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="d5"></div>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="EmptyRow">
						&nbsp;
					</td>
				</tr>
				<tr style="%%GLOBAL_HideDatabaseDetails%%">
					<td class="Heading2" colspan="2">%%LNG_DatabaseSettings%%</td>
				</tr>
				<tr style="%%GLOBAL_HideDatabaseDetails%%">
					<td class="FieldLabel">
						<span class="Required">&nbsp;</span> %%LNG_DatabaseType%%:
					</td>
					<td>
						<input type="text" value="%%GLOBAL_dbType%%" class="Field250" disabled readonly />
					</td>
				</tr>
				<tr style="%%GLOBAL_HideDatabaseDetails%%">
					<td class="FieldLabel">
						<span class="Required">&nbsp;</span> %%LNG_DatabaseUser%%:
					</td>
					<td>
						<input type="text" value="%%GLOBAL_dbUser%%" class="Field250" disabled readonly />
					</td>
				</tr>
				<tr style="%%GLOBAL_HideDatabaseDetails%%">
					<td class="FieldLabel">
						<span class="Required">&nbsp;</span> %%LNG_DatabasePassword%%:
					</td>
					<td>
						<input type="text" value="" class="Field250" disabled readonly />
					</td>
				</tr>
				<tr style="%%GLOBAL_HideDatabaseDetails%%">
					<td class="FieldLabel">
						<span class="Required">&nbsp;</span> %%LNG_DatabaseHostname%%:
					</td>
					<td>
						<input type="text" value="%%GLOBAL_dbServer%%" class="Field250" disabled readonly />
					</td>
				</tr>
				<tr style="%%GLOBAL_HideDatabaseDetails%%">
					<td class="FieldLabel">
						<span class="Required">&nbsp;</span> %%LNG_DatabaseTablePrefix%%:
					</td>
					<td>
						<input type="text" value="%%GLOBAL_tablePrefix%%" class="Field250" disabled readonly />
					</td>
				</tr>
				<tr style="%%GLOBAL_HideDatabaseDetails%%">
					<td class="FieldLabel">
						<span class="Required">&nbsp;</span> %%LNG_DatabaseVersion%%:
					</td>
					<td class="PanelBottom">
						%%GLOBAL_dbVersion%%
					</td>
				</tr>
				</table>
			</div>
			<div id="div1" style="padding-top: 10px;">
				<table width="100%" class="Panel">
				<tr>
					<td class="Heading2" colspan="2">%%LNG_LanguageSettings%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="Lanauge">%%LNG_Language%%:</label>
					</td>
					<td>
						<select name="Language" id="Lanauge" class="Field100">
							%%GLOBAL_LanguageOptions%%
						</select>
						<img onmouseout="HideHelp('lang_setting');" onmouseover="ShowHelp('lang_setting', '%%LNG_Language%%', '%%LNG_LanguageHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="lang_setting"></div>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="EmptyRow">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td class="Heading2" colspan="2">%%LNG_PhysicalDimensionSettings%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="WeightMeasurement">%%LNG_WeightMeasurement%%:</label>
					</td>
					<td>
						<select name="WeightMeasurement" id="WeightMeasurement" class="Field100">
							<option value="LBS" %%GLOBAL_IsPounds%%>%%LNG_Pounds%%</option>
							<option value="Ounces" %%GLOBAL_IsOunces%%>%%LNG_Ounces%%</option>
							<option value="KGS" %%GLOBAL_IsKilos%%>%%LNG_Kilograms%%</option>
							<option value="Grams" %%GLOBAL_IsGrams%%>%%LNG_Grams%%</option>
							<option value="Tonnes" %%GLOBAL_IsTonnes%%>%%LNG_Tonnes%%</option>
						</select>
						<img onmouseout="HideHelp('d17');" onmouseover="ShowHelp('d17', '%%LNG_WeightMeasurement%%', '%%LNG_WeightMeasurementHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="d17"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="LengthMeasurement">%%LNG_LengthMeasurement%%:</label>
					</td>
					<td class="PanelBottom">
						<select name="LengthMeasurement" id="LengthMeasurement" class="Field100">
							<option value="Inches" %%GLOBAL_IsInches%%>%%LNG_Inches%%</option>
							<option value="Centimeters" %%GLOBAL_IsCentimeters%%>%%LNG_Centimeters%%</option>
						</select>
						<img onmouseout="HideHelp('d18');" onmouseover="ShowHelp('d18', '%%LNG_LengthMeasurement%%', '%%LNG_LengthMeasurementHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="d18"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="DimensionsDecimalToken">%%LNG_DimensionsDecimalToken%%:</label>
					</td>
					<td>
						<input type="text" name="DimensionsDecimalToken" value="%%GLOBAL_DimensionsDecimalToken%%" id="DimensionsDecimalToken" class="Field40" maxlenght="1" />
						<img onmouseout="HideHelp('decimaltoken');" onmouseover="ShowHelp('decimaltoken', '%%LNG_DimensionsDecimalToken%%', '%%LNG_DimensionsDecimalTokenHelp%%');" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display: none;" id="decimaltoken"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="DimensionsThousandsToken">%%LNG_DimensionsThousandsToken%%:</label>
					</td>
					<td>
						<input type="text" name="DimensionsThousandsToken" value="%%GLOBAL_DimensionsThousandsToken%%" id="DimensionsThousandsToken" class="Field40" maxlenght="1" />
						<img onmouseout="HideHelp('thousandstoken');" onmouseover="ShowHelp('thousandstoken', '%%LNG_DimensionsThousandsToken%%', '%%LNG_DimensionsThousandsTokenHelp%%');" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display: none;" id="thousandstoken"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="DimensionsDecimalPlaces">%%LNG_DimensionsDecimalPlaces%%:</label>
					</td>
					<td>
						<input type="text" name="DimensionsDecimalPlaces" value="%%GLOBAL_DimensionsDecimalPlaces%%" id="DimensionsDecimalPlaces" class="Field40" maxlenght="1" />
						<img onmouseout="HideHelp('decimalplaces');" onmouseover="ShowHelp('decimalplaces', '%%LNG_DimensionsDecimalPlaces%%', '%%LNG_DimensionsDecimalPlacesHelp%%');" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display: none;" id="decimalplaces"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="ShippingFactoringDimension">%%LNG_ShippingFactoringDimension%%:</label>
					</td>
					<td>
						<select name="ShippingFactoringDimension" id="ShippingFactoringDimension" class="Field120">
							<option value="depth" %%GLOBAL_ShippingFactoringDimensionDepthSelected%%>%%LNG_ShippingFactoringDimensionDepth%%</option>
							<option value="height" %%GLOBAL_ShippingFactoringDimensionHeightSelected%%>%%LNG_ShippingFactoringDimensionHeight%%</option>
							<option value="width" %%GLOBAL_ShippingFactoringDimensionWidthSelected%%>%%LNG_ShippingFactoringDimensionWidth%%</option>
						</select>
						<img onmouseout="HideHelp('dshipfactdimension');" onmouseover="ShowHelp('dshipfactdimension', '%%LNG_ShippingFactoringDimension%%', '%%LNG_ShippingFactoringDimensionHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="dshipfactdimension"></div>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="EmptyRow">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td class="Heading2" colspan="2">%%LNG_DateSettings%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="StoreTimezone">%%LNG_StoreTimeZone%%:</label>
					</td>
					<td>
						<select name="StoreTimeZone" id="StoreTimeZone" class="Field300">
							%%GLOBAL_TimeZoneOptions%%
						</select>
						<img onmouseout="HideHelp('tz_h');" onmouseover="ShowHelp('tz_h', '%%LNG_StoreTimeZone%%', '%%LNG_StoreTimeZoneHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="tz_h"></div>
					</td>
				</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; %%LNG_EnableDSTCorrection%%?
						</td>
						<td>
							<label for="StoreDSTCorrection"><input %%GLOBAL_IsDSTCorrectionEnabled%% type="checkbox" name="StoreDSTCorrection" id="StoreDSTCorrection" value="1" />%%LNG_YesEnableDSTCorrection%%</label>
							<img onmouseout="HideHelp('dst');" onmouseover="ShowHelp('dst', '%%LNG_EnableDSTCorrection%%?', '%%LNG_EnableDSTCorrectionHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="dst"></div>
						</td>
					</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="DisplayDateFormat">%%LNG_DisplayDateFormat%%:</label>
					</td>
					<td>
						<input type="text" name="DisplayDateFormat" id="DisplayDateFormat" value="%%GLOBAL_DisplayDateFormat%%" class="Field100" />
						<img onmouseout="HideHelp('d19');" onmouseover="ShowHelp('d19', '%%LNG_DisplayDateFormat%%', '%%LNG_DisplayDateFormatHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="d19"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="ExportDateFormat">%%LNG_ExportDateFormat%%:</label>
					</td>
					<td>
						<input type="text" name="ExportDateFormat" id="ExportDateFormat" value="%%GLOBAL_ExportDateFormat%%" class="Field100" />
						<img onmouseout="HideHelp('d20');" onmouseover="ShowHelp('d20', '%%LNG_ExportDateFormat%%', '%%LNG_ExportDateFormatHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="d20"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span> <label for="ExtendedDisplayDateFormat">%%LNG_ExtendedDisplayDateFormat%%:</label>
					</td>
					<td class="PanelBottom">
						<input type="text" name="ExtendedDisplayDateFormat" id="ExtendedDisplayDateFormat" value="%%GLOBAL_ExtendedDisplayDateFormat%%" class="Field100" />
						<img onmouseout="HideHelp('d21');" onmouseover="ShowHelp('d21', '%%LNG_ExtendedDisplayDateFormat%%', '%%LNG_ExtendedDisplayDateFormatHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
						<div style="display:none" id="d21"></div>
					</td>
				</tr>
				</table>
			</div>
			<div id="div2" style="padding-top: 10px;">
				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_DisplaySettings%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span> <label for="AutoThumbSize">%%LNG_AutoThumbSize%%:</label>
						</td>
						<td>
							<input type="text" name="AutoThumbSize" id="AutoThumbSize" value="%%GLOBAL_AutoThumbSize%%" class="Field40" />
							<img onmouseout="HideHelp('d22');" onmouseover="ShowHelp('d22', '%%LNG_AutoThumbSize%%', '%%LNG_AutoThumbSizeHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d22"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span> <label for="HomeFeaturedProducts">%%LNG_HomeFeaturedProducts%%:</label>
						</td>
						<td>
							<input type="text" name="HomeFeaturedProducts" id="HomeFeaturedProducts" value="%%GLOBAL_HomeFeaturedProducts%%" class="Field40" />
							<img onmouseout="HideHelp('d23');" onmouseover="ShowHelp('d23', '%%LNG_HomeFeaturedProducts%%', '%%LNG_HomeFeaturedProductsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d23"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span> <label for="HomeNewProducts">%%LNG_HomeNewProducts%%:</label>
						</td>
						<td>
							<input type="text" name="HomeNewProducts" id="HomeNewProducts" value="%%GLOBAL_HomeNewProducts%%" class="Field40" />
							<img onmouseout="HideHelp('d25');" onmouseover="ShowHelp('d25', '%%LNG_HomeNewProducts%%', '%%LNG_HomeNewProductsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d25"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span> <label for="HomeBlogPosts">%%LNG_HomeBlogPosts%%:</label>
						</td>
						<td>
							<input type="text" name="HomeBlogPosts" id="HomeBlogPosts" value="%%GLOBAL_HomeBlogPosts%%" class="Field40" />
							<img onmouseout="HideHelp('d27');" onmouseover="ShowHelp('d27', '%%LNG_HomeBlogPosts%%', '%%LNG_HomeBlogPostsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d27"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span> <label for="CategoryProductsPerPage">%%LNG_CategoryProductsPerPage%%:</label>
						</td>
						<td>
							<input type="text" name="CategoryProductsPerPage" id="CategoryProductsPerPage" value="%%GLOBAL_CategoryProductsPerPage%%" class="Field40" />
							<img onmouseout="HideHelp('d28');" onmouseover="ShowHelp('d28', '%%LNG_CategoryProductsPerPage%%', '%%LNG_CategoryProductsPerPageHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d28"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span> <label for="CategoryListDepth">%%LNG_CategoryListDepth%%:</label>
						</td>
						<td>
							<input type="text" name="CategoryListDepth" id="CategoryListDepth" value="%%GLOBAL_CategoryListDepth%%" class="Field40" />
							<img onmouseout="HideHelp('d28');" onmouseover="ShowHelp('d28', '%%LNG_CategoryListDepth%%', '%%LNG_CategoryListDepthHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d28"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span> <label for="ProductReviewsPerPage">%%LNG_ProductReviewsPerPage%%:</label>
						</td>
						<td>
							<input type="text" name="ProductReviewsPerPage" id="ProductReviewsPerPage" value="%%GLOBAL_ProductReviewsPerPage%%" class="Field40" />
							<img onmouseout="HideHelp('d30');" onmouseover="ShowHelp('d30', '%%LNG_ProductReviewsPerPage%%', '%%LNG_ProductReviewsPerPageHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d30"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="TagCartQuantityBoxes">%%LNG_CartQuantityBoxes%%:</label>
						</td>
						<td>
							<select name="TagCartQuantityBoxes" id="TagCartQuantityBoxes" class="Field150">
								<option value="dropdown"  %%GLOBAL_IsDropdown%%>%%LNG_DropdownList%%</option>
								<option value="textbox"  %%GLOBAL_IsTextbox%%>%%LNG_TextBox%%</option>
							</select>
							<img onmouseout="HideHelp('d32');" onmouseover="ShowHelp('d32', '%%LNG_CartQuantityBoxes%%', '%%LNG_CartQuantityBoxesHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d32"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="AddToCartButtonPosition">%%LNG_AddToCartButtonPosition%%:</label>
						</td>
						<td>
							<select name="AddToCartButtonPosition" id="AddToCartButtonPosition" class="Field150">
								<option value="middle"  %%GLOBAL_IsMiddle%%>%%LNG_MiddleOfThePage%%</option>
								<option value="side"  %%GLOBAL_IsSide%%>%%LNG_SideOfThePage%%</option>
							</select>
							<img onmouseout="HideHelp('d36');" onmouseover="ShowHelp('d36', '%%LNG_AddToCartButtonPosition%%', '%%LNG_AddToCartButtonPositionHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d36"></div>
						</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="ShowAddToCartQtyBox">%%LNG_ShowAddToCartQtyBox%%:</label>
						</td>
						<td>
							<input type="checkbox" name="ShowAddToCartQtyBox" id="ShowAddToCartQtyBox" value="ON" %%GLOBAL_IsShownAddToCartQtyBox%% /> <label for="ShowAddToCartQtyBox">%%LNG_YesShowAddToCartQtyBox%%</label>
							<img onmouseout="HideHelp('d31');" onmouseover="ShowHelp('d31', '%%LNG_ShowAddToCartQtyBox%%', '%%LNG_ShowAddToCartQtyBoxHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d31"></div>
						</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="TagCloudsEnabled">%%LNG_TagCloudsEnabled%%</label>
						</td>
						<td>
							<input type="checkbox" name="TagCloudsEnabled" id="TagCloudsEnabled" value="ON" %%GLOBAL_IsTagCloudsEnabled%% /> <label for="TagCloudsEnabled">%%LNG_YesTagCloudsEnabled%%</label>
							<img onmouseout="HideHelp('d31');" onmouseover="ShowHelp('d31', '%%LNG_TagCloudsEnabled%%', '%%LNG_TagCloudsEnabledHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d31"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="CaptchaEnabled">%%LNG_CaptchaEnabled%%</label>
						</td>
						<td>
							<input type="checkbox" name="CaptchaEnabled" id="CaptchaEnabled" value="ON" %%GLOBAL_IsCaptchaEnabled%% /> <label for="CaptchaEnabled">%%LNG_YesCaptchaEnabled%%</label>
							<img onmouseout="HideHelp('d32');" onmouseover="ShowHelp('d32', '%%LNG_CaptchaEnabled%%', '%%LNG_CaptchaEnabledHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d32"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="SearchSuggest">%%LNG_EnableSearchSuggest%%</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="SearchSuggest" id="SearchSuggest" value="ON" %%GLOBAL_IsSearchSuggest%% /> <label for="SearchSuggest">%%LNG_YesSearchSuggest%%</label>
							<img onmouseout="HideHelp('d35');" onmouseover="ShowHelp('d35', '%%LNG_SearchSuggest%%', '%%LNG_SearchSuggestHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d35"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="ShowThumbsInCart">%%LNG_ShowThumbsInCart%%</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="ShowThumbsInCart" id="ShowThumbsInCart" value="ON" %%GLOBAL_IsShowThumbsInCart%% /> <label for="ShowThumbsInCart">%%LNG_YesShowThumbsInCart%%</label>
							<img onmouseout="HideHelp('d33');" onmouseover="ShowHelp('d33', '%%LNG_ShowThumbsInCart%%', '%%LNG_ShowThumbsInCartHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d33"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="ShowCartSuggestions">%%LNG_ShowCartSuggestions%%</label>
						</td>
						<td>
							<input type="checkbox" name="ShowCartSuggestions" id="ShowCartSuggestions" value="ON" %%GLOBAL_IsShowCartSuggestions%% /> <label for="ShowCartSuggestions">%%LNG_YesShowCartSuggestions%%</label>
							<img onmouseout="HideHelp('d34');" onmouseover="ShowHelp('d34', '%%LNG_ShowCartSuggestions%%', '%%LNG_ShowCartSuggestionsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d34"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="EnableProductReviews">%%LNG_EnableProductReviews%%</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="EnableProductReviews" id="EnableProductReviews" value="1" %%GLOBAL_IsEnableProductReviews%% onclick="if(this.checked) { $('.HideIfReviewsDisabled').show(); } else { $('.HideIfReviewsDisabled').hide(); }" /> <label for="EnableProductReviews">%%LNG_YesEnableProductReviews%%</label>
							<img onmouseout="HideHelp('EnableProductReviewsHelp');" onmouseover="ShowHelp('EnableProductReviewsHelp', '%%LNG_EnableProductReviews%%', '%%LNG_EnableProductReviewsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="EnableProductReviewsHelp"></div>
						</td>
					</tr>
					<tr class="HideIfReviewsDisabled">
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="AutoApproveReviews">%%LNG_AutoApproveReviews%%</label>
						</td>
						<td>
							<input type="checkbox" name="AutoApproveReviews" id="AutoApproveReviews" value="ON" %%GLOBAL_IsAutoApproveReviews%% /> <label for="AutoApproveReviews">%%LNG_YesAutoApproveReviews%%</label>
							<img onmouseout="HideHelp('AutoApproveRevHelp');" onmouseover="ShowHelp('AutoApproveRevHelp', '%%LNG_AutoApproveReviews%%', '%%LNG_AutoApproveReviewsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="AutoApproveRevHelp"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="QuickSearch">%%LNG_EnableQuickSearch%%</label>
						</td>
						<td>
							<input type="checkbox" name="QuickSearch" id="QuickSearch" value="ON" %%GLOBAL_IsQuickSearch%% /> <label for="QuickSearch">%%LNG_YesQuickSearch%%</label>
							<img onmouseout="HideHelp('d43');" onmouseover="ShowHelp('d43', '%%LNG_EnableQuickSearch%%', '%%LNG_QuickSearchHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d43"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="ShowInventory">%%LNG_ShowInventory%%</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="ShowInventory" id="ShowInventory" value="ON" %%GLOBAL_IsShowInventory%% /> <label for="ShowInventory">%%LNG_YesShowInventory%%</label>
							<img onmouseout="HideHelp('ShowInvHelp');" onmouseover="ShowHelp('ShowInvHelp', '%%LNG_ShowInventory%%', '%%LNG_ShowInventoryHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="ShowInvHelp"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="ShowCartSuggestions">%%LNG_EnableWishlist%%?</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="EnableWishlist" id="EnableWishlist" value="ON" %%GLOBAL_IsWishlistEnabled%% /> <label for="EnableWishlist">%%LNG_YesEnableWishlist%%</label>
							<img onmouseout="HideHelp('ShowWishlistHelp');" onmouseover="ShowHelp('ShowWishlistHelp', '%%LNG_EnableWishlist%%?', '%%LNG_EnableWishlistHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="ShowWishlistHelp"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="EnableProductComparisons">%%LNG_EnableProductComparisons%%?</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="EnableProductComparisons" id="EnableProductComparisons" value="1" %%GLOBAL_IsEnableProductComparisons%% /> <label for="EnableProductComparisons">%%LNG_YesEnableProductComparisons%%</label>
							<img onmouseout="HideHelp('EnableProductComparisonsHelp');" onmouseover="ShowHelp('EnableProductComparisonsHelp', '%%LNG_EnableProductComparisons%%', '%%LNG_EnableProductComparisonsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="EnableProductComparisonsHelp"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="EnableAccountCreation">%%LNG_EnableAccountCreation%%?</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="EnableAccountCreation" id="EnableAccountCreation" value="ON" %%GLOBAL_IsEnableAccountCreation%% /> <label for="EnableAccountCreation">%%LNG_YesEnableAccountCreation%%</label>
							<img onmouseout="HideHelp('AccountCreationHelp');" onmouseover="ShowHelp('AccountCreationHelp', '%%LNG_EnableAccountCreation%%?', '%%LNG_EnableAccountCreationHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="AccountCreationHelp"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="BulkDiscountEnabled">%%LNG_BulkDiscountEnabled%%?</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="BulkDiscountEnabled" id="BulkDiscountEnabled" value="ON" %%GLOBAL_IsBulkDiscountEnabled%% /> <label for="BulkDiscountEnabled">%%LNG_YesBulkDiscountEnabled%%</label>
							<img onmouseout="HideHelp('bulkdiscountenabled');" onmouseover="ShowHelp('bulkdiscountenabled', '%%LNG_BulkDiscountEnabled%%', '%%LNG_BulkDiscountEnabledHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="bulkdiscountenabled"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="EnableProductTabs">%%LNG_EnableProductTabs%%?</label>
						</td>
						<td>
							<input type="checkbox" name="EnableProductTabs" id="EnableProductTabs" value="ON" %%GLOBAL_IsProductTabsEnabled%% /> <label for="EnableProductTabs">%%LNG_YesEnableProductTabs%%</label>
							<img onmouseout="HideHelp('EnableProductTabsHelp');" onmouseover="ShowHelp('EnableProductTabsHelp', '%%LNG_EnableProductTabs%%', '%%LNG_EnableProductTabsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="EnableProductTabsHelp"></div>
						</td>
					</tr>
						<td class="FieldLabel">
							<span class="Required">*</span> Default Product Image:
						</td>
						<td class="PanelBottom">
							<label><input type="radio" class="DefaultProductImage" name="DefaultProductImage" value="none" %%GLOBAL_DefaultProductImageNoneChecked%% /> %%LNG_DefaultProductImageNone%%</label>
							<img onmouseout="HideHelp('DefaultProductImageHelp');" onmouseover="ShowHelp('DefaultProductImageHelp', '%%LNG_DefaultProductImage%%', '%%LNG_DefaultProductImageHelp%%')" src="images/help.gif" />
							<div style="display:none" id="DefaultProductImageHelp"></div>
							<label style="display: block;"><input type="radio" class="DefaultProductImage" name="DefaultProductImage" value="template" %%GLOBAL_DefaultProductImageTemplateChecked%% />  %%LNG_DefaultProductImageTemplate%% (<a href="%%GLOBAL_AppPath%%/templates/%%GLOBAL_template%%/images/ProductDefault.gif" target="_blank">templates/%%GLOBAL_template%%/images/ProductDefault.gif</a>)</label>
							<label style="display: block;"><input type="radio" class="DefaultProductImage" name="DefaultProductImage" value="custom" %%GLOBAL_DefaultProductImageCustomChecked%% /> %%LNG_DefaultProductImageCustom%%</label>
							<div id="DefaultProductImageCustomContainer" style="margin-top: 5px;">
								<img src="images/nodejoin.gif" alt="" style="vertical-align: top;" /> <input type="file" name="DefaultProductImageCustom" id="DefaultProductImageCustom" />
								<span style="%%GLOBAL_HideCurrentDefaultProductImage%%" id="DefaultProductImageCustomCurrent">&nbsp;&nbsp;&nbsp; %%LNG_CurrentDefaultImage%%: <a href="%%GLOBAL_AppPath%%/%%GLOBAL_DefaultProductImage%%" target="_blank">%%GLOBAL_DefaultProductImage%%</span>
							</div>
						</td>
					</tr>
					<tr>
						<td class="Heading2" colspan="2">%%LNG_CategoryAndBrandImages%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span> <label for="CategoryPerRow">%%LNG_CatItemPerRow%%:</label>
						</td>
						<td>
							<input type="text" name="CategoryPerRow" id="CategoryPerRow" value="%%GLOBAL_CategoryPerRow%%" class="Field40" />
							<img onmouseout="HideHelp('d_catper');" onmouseover="ShowHelp('d_catper', '%%LNG_CatItemPerRow%%', '%%LNG_CatItemPerRowHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d_catper"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span> <label for="BrandPerRow">%%LNG_BrandItemPerRow%%:</label>
						</td>
						<td>
							<input type="text" name="BrandPerRow" id="BrandPerRow" value="%%GLOBAL_BrandPerRow%%" class="Field40" />
							<img onmouseout="HideHelp('d_brandper');" onmouseover="ShowHelp('d_brandper', '%%LNG_BrandItemPerRow%%', '%%LNG_BrandItemPerRowHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d_brandper"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span> <label for="CategoryImageWidth">%%LNG_CatImageDimSetting%%:</label>
						</td>
						<td>
							<input type="text" name="CategoryImageWidth" id="CategoryImageWidth" value="%%GLOBAL_CategoryImageWidth%%" class="Field40" /> x <input type="text" name="CategoryImageHeight" id="CategoryImageHeight" value="%%GLOBAL_CategoryImageHeight%%" class="Field40" />
							<img onmouseout="HideHelp('d_catdim');" onmouseover="ShowHelp('d_catdim', '%%LNG_CatImageDimSetting%%', '%%LNG_CatImageDimSettingHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d_catdim"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span> <label for="BrandImageWidth">%%LNG_BrandImageDimSetting%%:</label>
						</td>
						<td>
							<input type="text" name="BrandImageWidth" id="BrandImageWidth" value="%%GLOBAL_BrandImageWidth%%" class="Field40" /> x <input type="text" name="BrandImageHeight" id="BrandImageHeight" value="%%GLOBAL_BrandImageHeight%%" class="Field40" />
							<img onmouseout="HideHelp('d_branddim');" onmouseover="ShowHelp('d_branddim', '%%LNG_BrandImageDimSetting%%', '%%LNG_BrandImageDimSettingHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d_branddim"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="CategoryDefaultImage">%%LNG_CatImageDefaultSetting%%:</label>
						</td>
						<td>
							<input type="file" id="CategoryDefaultImage" name="CategoryDefaultImage" class="Field" />
							<img onmouseout="HideHelp('d_catdimg');" onmouseover="ShowHelp('d_catdimg', '%%LNG_CatImageDefaultSetting%%', '%%LNG_CatImageDefaultSettingHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d_catdimg"></div>%%GLOBAL_CatImageDefaultSettingMessage%%
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="BrandDefaultImage">%%LNG_BrandImageDefaultSetting%%:</label>
						</td>
						<td>
							<input type="file" id="BrandDefaultImage" name="BrandDefaultImage" class="Field" />
							<img onmouseout="HideHelp('d_brandimg');" onmouseover="ShowHelp('d_brandimg', '%%LNG_BrandImageDefaultSetting%%', '%%LNG_BrandImageDefaultSettingHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d_brandimg"></div>%%GLOBAL_BrandImageDefaultSettingMessage%%
						</td>
					</tr>
					<tr>
						<td class="Heading2" colspan="2">%%LNG_ControlPanelDisplaySettings%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="ShowCartSuggestions">%%LNG_UseWYSIWYGEditor%%</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="UseWYSIWYG" id="UseWYSIWYG" value="ON" %%GLOBAL_IsWYSIWYGEnabled%% /> <label for="UseWYSIWYG">%%LNG_YesEnableWYSIWYGEditor%%</label>
							<img onmouseout="HideHelp('d39');" onmouseover="ShowHelp('d39', '%%LNG_UseWYSIWYGEditor%%', '%%LNG_UseWYSIWYGEditorHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d39"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="ShowCartSuggestions">%%LNG_ShowProductThumbnails%%</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="ShowThumbsInControlPanel" id="ShowThumbsInControlPanel" value="ON" %%GLOBAL_IsProductThumbnailsEnabled%% /> <label for="ShowThumbsInControlPanel">%%LNG_YesShowProductThumbnails%%</label>
							<img onmouseout="HideHelp('d42');" onmouseover="ShowHelp('d42', '%%LNG_ShowProductThumbnails%%', '%%LNG_ShowProductThumbnailsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d42"></div>
						</td>
					</tr>
				</table>

				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_ProductSettings%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="ShowCartSuggestions">%%LNG_ShowProductPrice%%?</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="ShowProductPrice" id="ShowProductPrice" value="ON" %%GLOBAL_IsProductPriceShown%% /> <label for="ShowProductPrice">%%LNG_YesShowProductPrice%%</label>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="ShowCartSuggestions">%%LNG_ShowProductSKU%%?</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="ShowProductSKU" id="ShowProductSKU" value="ON" %%GLOBAL_IsProductSKUShown%% /> <label for="ShowProductSKU">%%LNG_YesShowProductSKU%%</label>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="ShowCartSuggestions">%%LNG_ShowProductWeight%%?</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="ShowProductWeight" id="ShowProductWeight" value="ON" %%GLOBAL_IsProductWeightShown%% /> <label for="ShowProductWeight">%%LNG_YesShowProductWeight%%</label>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="ShowCartSuggestions">%%LNG_ShowProductBrand%%?</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="ShowProductBrand" id="ShowProductBrand" value="ON" %%GLOBAL_IsProductBrandShown%% /> <label for="ShowProductBrand">%%LNG_YesShowProductBrand%%</label>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="ShowCartSuggestions">%%LNG_ShowProductShipping%%?</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="ShowProductShipping" id="ShowProductShipping" value="ON" %%GLOBAL_IsProductShippingShown%% /> <label for="ShowProductShipping">%%LNG_YesShowProductShipping%%</label>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="ShowProductRating">%%LNG_ShowProductRating%%?</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="ShowProductRating" id="ShowProductRating" value="ON" %%GLOBAL_IsProductRatingShown%% /> <label for="ShowProductRating">%%LNG_YesShowProductRating%%</label>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="ShowAddToCartLink">%%LNG_ShowAddToCartLink%%?</label>
						</td>
						<td class="PanelBottom">
							<input type="checkbox" name="ShowAddToCartLink" id="ShowAddToCartLink" value="ON" %%GLOBAL_IsAddToCartLinkShown%% /> <label for="ShowAddToCartLink">%%LNG_YesShowAddToCartLink%%</label>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="ProductImageMode">%%LNG_ProductImageMode%%:</label>
						</td>
						<td class="PanelBottom">
							<select name="ProductImageMode" id="ProductImageMode" class="Field300">
								<option value="popup" %%GLOBAL_ProductImageModePopup%%>%%LNG_ProductImageModePopup%%</option>
								<option value="lightbox" %%GLOBAL_ProductImageModeLightbox%%>%%LNG_ProductImageModeLightbox%%</option>
							</select>
							<img onmouseout="HideHelp('imagemodehelp');" onmouseover="ShowHelp('imagemodehelp', '%%LNG_ProductImageMode%%', '%%LNG_ProductImageModeHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="imagemodehelp"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span> <label for="CategoryListMode">%%LNG_CategoryListMode%%:</label>
						</td>
						<td>
							<label><input type="radio" name="CategoryListingMode" value="single" %%GLOBAL_CategoryListModeSingle%% /> %%LNG_CategoryListModeSingle%%</label> <img onmouseout="HideHelp('categorylistmodehelp');" onmouseover="ShowHelp('categorylistmodehelp', '%%LNG_CategoryListMode%%', '%%LNG_CategoryListModeHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="categorylistmodehelp"></div>
							<br />
							<label><input type="radio" name="CategoryListingMode" value="emptychildren" %%GLOBAL_CategoryListModeEmptyChildren%% /> %%LNG_CategoryListModeEmptyChildren%%</label><br />
							<label><input type="radio" name="CategoryListingMode" value="children" %%GLOBAL_CategoryListModeChildren%% /> %%LNG_CategoryListModeChildren%%</label>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="CategoryDisplayMode">%%LNG_CategoryDisplayMode%%:</label>
						</td>
						<td>
							<select name="CategoryDisplayMode" id="CategoryDisplayMode" class="Field300">
								<option value="grid" %%GLOBAL_CategoryDisplayModeGrid%%>%%LNG_CategoryDisplayModeGrid%%</option>
								<option value="list" %%GLOBAL_CategoryDisplayModeList%%>%%LNG_CategoryDisplayModeList%%</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span> %%LNG_TagCloudFontSize%%:
						</td>
						<td>
							<label>%%LNG_From%% <input type="text" name="TagCloudMinSize" id="TagCloudMinSize" value="%%GLOBAL_TagCloudMinSize%%" class="Field50" />%</label>
							<label>%%LNG_SearchTo%% <input type="text" name="TagCloudMaxSize" id="TagCloudMaxSize" value="%%GLOBAL_TagCloudMaxSize%%" class="Field50" />%</label>
							<img onmouseout="HideHelp('tagsizehelp');" onmouseover="ShowHelp('tagsizehelp', '%%LNG_TagCloudFontSize%%', '%%LNG_TagCloudFontSizeHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="tagsizehelp"></div>
						</td>
					</tr>
				</table>
				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_RSSSettings%%</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="RSSNewProducts">%%LNG_RSSNewProductsEnabled%%</label>
						</td>
						<td>
							<input type="checkbox" name="RSSNewProducts" id="RSSNewProducts" value="ON" %%GLOBAL_IsRSSNewProductsEnabled%% /> <label for="RSSNewProducts">%%LNG_YesRSSNewProductsEnabled%%</label>
							<img onmouseout="HideHelp('rss1');" onmouseover="ShowHelp('rss1', '%%LNG_RSSNewProductsEnabled%%', '%%LNG_RSSNewProductsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="rss1"></div>
						</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="RSSPopularProducts">%%LNG_RSSPopularProductsEnabled%%</label>
						</td>
						<td>
							<input type="checkbox" name="RSSPopularProducts" id="RSSPopularProducts" value="ON" %%GLOBAL_IsRSSPopularProductsEnabled%% /> <label for="RSSPopularProducts">%%LNG_YesRSSPopularProductsEnabled%%</label>
							<img onmouseout="HideHelp('rss2');" onmouseover="ShowHelp('rss2', '%%LNG_RSSPopularProductsEnabled%%', '%%LNG_RSSPopularProductsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="rss2"></div>
						</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="RSSCategories">%%LNG_RSSCategoriesEnabled%%</label>
						</td>
						<td>
							<input type="checkbox" name="RSSCategories" id="RSSCategories" value="ON" %%GLOBAL_IsRSSCategoriesEnabled%% /> <label for="RSSCategories">%%LNG_YesRSSCategoriesEnabled%%</label>
							<img onmouseout="HideHelp('rss3');" onmouseover="ShowHelp('rss3', '%%LNG_RSSCategoriesEnabled%%', '%%LNG_RSSCategoriesHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="rss3"></div>
						</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="RSSProductSearches">%%LNG_RSSProductSearchesEnabled%%</label>
						</td>
						<td>
							<input type="checkbox" name="RSSProductSearches" id="RSSProductSearches" value="ON" %%GLOBAL_IsRSSProductSearchesEnabled%% /> <label for="RSSProductSearches">%%LNG_YesRSSProductSearchesEnabled%%</label>
							<img onmouseout="HideHelp('rss4');" onmouseover="ShowHelp('rss4', '%%LNG_RSSProductSearchesEnabled%%', '%%LNG_RSSProductSearchesHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="rss4"></div>
						</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="RSSLatestBlogEntries">%%LNG_RSSLatestBlogEntriesEnabled%%</label>
						</td>
						<td>
							<input type="checkbox" name="RSSLatestBlogEntries" id="RSSLatestBlogEntries" value="ON" %%GLOBAL_IsRSSLatestBlogEntriesEnabled%% /> <label for="RSSLatestBlogEntries">%%LNG_YesRSSLatestBlogEntriesEnabled%%</label>
							<img onmouseout="HideHelp('rss5');" onmouseover="ShowHelp('rss5', '%%LNG_RSSLatestBlogEntriesEnabled%%', '%%LNG_RSSLatestBlogEntriesHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="rss5"></div>
						</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="RSSSyndicationIcons">%%LNG_RSSSyndicationIconsEnabled%%</label>
						</td>
						<td>
							<input type="checkbox" name="RSSSyndicationIcons" id="RSSSyndicationIcons" value="ON" %%GLOBAL_IsRSSSyndicationIconsEnabled%% /> <label for="RSSSyndicationIcons">%%LNG_YesRSSSyndicationIconsEnabled%%</label>
							<img onmouseout="HideHelp('rss6');" onmouseover="ShowHelp('rss6', '%%LNG_RSSSyndicationIconsEnabled%%', '%%LNG_RSSSyndicationIconsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="rss6"></div>
						</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span> <label for="RSSItemsLimit">%%LNG_RSSItemsLimit%%:</label>
						</td>
						<td>
							<input type="text" name="RSSItemsLimit" id="RSSItemsLimit" value="%%GLOBAL_RSSItemsLimit%%" class="Field40" />
							<img onmouseout="HideHelp('rss7');" onmouseover="ShowHelp('rss7', '%%LNG_RSSItemsLimit%%', '%%LNG_RSSItemsLimitHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="rss7"></div>
						</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span> <label for="RSSCacheTime">%%LNG_RSSCacheTime%%:</label>
						</td>
						<td>
							<input type="text" name="RSSCacheTime" id="RSSCacheTime" value="%%GLOBAL_RSSCacheTime%%" class="Field40" />%%LNG_RSSMinutes%%
							<img onmouseout="HideHelp('rss8');" onmouseover="ShowHelp('rss8', '%%LNG_RSSCacheTime%%', '%%LNG_RSSCacheTimeHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="rss8"></div>
						</td>
					</tr>

				</table>
			</div>

			<div id="div3" style="padding-top: 10px;  display: %%GLOBAL_HideBackupSettings%%">
				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_BackupSettings%%</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="BackupsLocal">%%LNG_EnableLocalBackups%%</label>
						</td>
						<td>
							<input type="checkbox" name="BackupsLocal" id="BackupsLocal" onclick="ToggleLocalBackups();" value="ON" %%GLOBAL_IsBackupsLocalEnabled%% /> <label for="BackupsLocal">%%LNG_YesEnableLocalBackups%%</label>
							<img onmouseout="HideHelp('backups1');" onmouseover="ShowHelp('backups1', '%%LNG_EnableLocalBackups%%', '%%LNG_EnableLocalBackupsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="backups1"></div>
						</td>
					</tr>

					<tr id="BackupsRemoteFTPContainer" style="display: %%FTPBackupsHide%%">
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="BackupsRemoteFTP">%%LNG_EnableRemoteFTPBackups%%</label>
						</td>
						<td>
							<input type="checkbox" name="BackupsRemoteFTP" id="BackupsRemoteFTP" onclick="ToggleFTPBackups();" value="ON" %%GLOBAL_IsBackupsRemoteFTPEnabled%% /> <label for="BackupsRemoteFTP">%%LNG_YesEnableRemoteFTPBackups%%</label>
							<img onmouseout="HideHelp('backups2');" onmouseover="ShowHelp('backups2', '%%LNG_EnableRemoteFTPBackups%%', '%%LNG_EnableRemoteFTPBackupsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="backups2"></div>
						</td>
					</tr>
					<tr id="BackupsRemoteFTPSettings" style="display: none;">
						<td class="FieldLabel">
							&nbsp;&nbsp; %%LNG_FTPServerDetails%%:
						</td>
						<td>
							<table>
								<tr>
									<td><span class="Required">*</span> %%LNG_FTPHostName%%:</td>
									<td>
										<input type="text" name="BackupsRemoteFTPHost" id="BackupsRemoteFTPHost" value="%%GLOBAL_BackupsRemoteFTPHost%%" class="Field150" />
										<img onmouseout="HideHelp('backups3');" onmouseover="ShowHelp('backups3', '%%LNG_FTPServerDetails%%', '%%LNG_FTPServerDetailsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
										<div style="display:none" id="backups3"></div>
									</td>
								</tr>
								<tr>
									<td><span class="Required">*</span> %%LNG_FTPUsername%%:</td>
									<td><input type="text" name="BackupsRemoteFTPUser" id="BackupsRemoteFTPUser" value="%%GLOBAL_BackupsRemoteFTPUser%%" class="Field150" /></td>
								</tr>
								<tr>
									<td><span class="Required">*</span> %%LNG_FTPPassword%%:</td>
									<td><input type="password" name="BackupsRemoteFTPPass" id="BackupsRemoteFTPPass" value="%%GLOBAL_BackupsRemoteFTPPass%%" class="Field150" /></td>
								</tr>
								<tr>
									<td>&nbsp;&nbsp; %%LNG_FTPPath%%:</td>
									<td><input type="text" name="BackupsRemoteFTPPath" id="BackupsRemoteFTPPath" value="%%GLOBAL_BackupsRemoteFTPPath%%" class="Field150" /></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td><input type="button" value="%%LNG_TestFTPSettings%%" class="SmallButton" onclick="DoTestFTPSettings()" id="TestFTPSettings" /> &nbsp;&nbsp;<img src="images/ajax-loader.gif" style="vertical-align: middle; display: none;" id="TestFTPSettingsLoading" alt="" />
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="EmptyRow">
							&nbsp;
						</td>
					</tr>
					<tr>
						<td class="Heading2" colspan="2">%%LNG_AutomaticBackups%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="BackupsAutomatic">%%LNG_EnableAutomaticBackups%%</label>
						</td>
						<td>
							<input type="checkbox" name="BackupsAutomatic" id="BackupsAutomatic" onclick="ToggleAutomaticBackups();" value="ON" %%GLOBAL_IsBackupsAutomaticEnabled%% /> <label for="BackupsAutomatic">%%LNG_YesEnableAutomaticBackups%%</label>
							<img onmouseout="HideHelp('backups4');" onmouseover="ShowHelp('backups4', '%%LNG_EnableAutomaticBackups%%', '%%LNG_EnableAutomaticBackupsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="backups4"></div>
						</td>
					</tr>
					<tr class="BackupsAutomaticContainer">
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="BackupsAutomaticPath">%%LNG_BackupCronPath%%:</label>
						</td>
						<td>
							<input type="text" class="Field250" name="BackupsAutomaticPath" id="BackupsAutomaticPath" value="%%GLOBAL_BackupsAutomaticPath%%" />
							<img onmouseout="HideHelp('backups6');" onmouseover="ShowHelp('backups6', '%%LNG_BackupCronPath%%', '%%LNG_BackupCronPathHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="backups6"></div>
						</td>
					</tr>
					<tr class="BackupsAutomaticContainer">
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="BackupsAutomaticMethod">%%LNG_AutomaticBackupMethod%%:</label>
						</td>
						<td>
							<select name="BackupsAutomaticMethod" id="BackupsAutomaticMethod" class="Field250">
								<option value="local" %%GLOBAL_IsBackupsAutomaticMethodLocal%% id="BackupsAutomaticLocal">%%LNG_AutomaticBackupLocal%%</option>
								<option value="ftp" %%GLOBAL_IsBackupsAutomaticMethodFTP%% id="BackupsAutomaticFTP">%%LNG_AutomaticBackupRemoteFTP%%</option>
							</select>
							<img onmouseout="HideHelp('backups5');" onmouseover="ShowHelp('backups5', '%%LNG_AutomaticBackupMethod%%', '%%LNG_AutomaticBackupMethodHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="backups5"></div>
						</td>
					</tr>
					<tr class="BackupsAutomaticContainer">
						<td class="FieldLabel">
							&nbsp;&nbsp; %%LNG_BackupSettings%%:
						</td>
						<td>
							<label><input type="checkbox" name="BackupsAutomaticDatabase" id="BackupsAutomaticDatabase" value="ON" %%GLOBAL_IsBackupsAutomaticDatabaseEnabled%% /> %%LNG_SettingsBackupDatabase%%</label><br />
							<label><input type="checkbox" name="BackupsAutomaticImages" id="BackupsAutomaticImages" value="ON" %%GLOBAL_IsBackupsAutomaticImagesEnabled%% /> %%LNG_SettingsBackupProductImages%%</label><br />
							<label><input type="checkbox" name="BackupsAutomaticDownloads" id="BackupsAutomaticDownloads" value="ON" %%GLOBAL_IsBackupsAutomaticDownloadsEnabled%% /> %%LNG_SettingsBackupDigitalProducts%%</label>
						</td>
					</tr>
				</table>
			</div>

			<div id="div4" style="padding-top: 10px; %%GLOBAL_HideLoggingSettingsTab%%">
				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_SystemLogging%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; %%LNG_EnableSystemLogging%%?
						</td>
						<td>
							<label style="padding-left: 4px;" for="EnableSystemLogging"><input %%GLOBAL_IsSystemLoggingEnabled%% type="checkbox" name="SystemLogging" id="EnableSystemLogging" value="ON" onclick="ToggleSystemLogging()" />%%LNG_YesEnableSystemLogging%%</label>
							<img onmouseout="HideHelp('logging1');" onmouseover="ShowHelp('logging1', '%%LNG_EnableSystemLogging%%?', '%%LNG_EnableSystemLoggingHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="logging1"></div>
						</td>
					</tr>
					<tr class="SystemLoggingToggle">
						<td class="FieldLabel">
							&nbsp;&nbsp; %%LNG_ActionsToLog%%:
						</td>
						<td style="padding-left: 28px">
							<select name="SystemLogTypes[]" id="SystemLogTypes" multiple="multiple" size="10" class="Field250 ISSelectReplacement">
								<option value="general" %%GLOBAL_IsGeneralLoggingEnabled%%>%%LNG_ActionsToLogGeneral%%</option>
								<option value="payment" %%GLOBAL_IsPaymentLoggingEnabled%%>%%LNG_ActionsToLogPayment%%</option>
								<option value="shipping" %%GLOBAL_IsShippingLoggingEnabled%%>%%LNG_ActionsToLogShipping%%</option>
								<option value="notification" %%GLOBAL_IsNotificationLoggingEnabled%%>%%LNG_ActionsToLogNotification%%</option>
								<option value="ssnx" %%GLOBAL_IsSendStudioLoggingEnabled%%>%%LNG_ActionsToLogSendStudio%%</option>
								<option value="sql" %%GLOBAL_IsSQLLoggingEnabled%%>%%LNG_ActionsToLogSQL%%</option>
								<option value="php" %%GLOBAL_IsPHPLoggingEnabled%%>%%LNG_ActionsToLogPHP%%</option>
							</select>
						</td>
					</tr>
					<tr class="SystemLoggingToggle">
						<td class="FieldLabel">
							&nbsp;&nbsp; %%LNG_TypesOfMessages%%:
						</td>
						<td style="padding-left: 28px">
							<select name="SystemLogSeverity[]" id="SystemLogSeverity" multiple="multiple" size="7" class="Field250 ISSelectReplacement">
								<option value="errors" %%GLOBAL_IsLoggingSeverityErrors%%>%%LNG_TypesOfMessagesErrors%%</option>
								<option value="warnings" %%GLOBAL_IsLoggingSeverityWarnings%%>%%LNG_TypesOfMessagesWarnings%%</option>
								<option value="success" %%GLOBAL_IsLoggingSeveritySuccesses%%>%%LNG_TypesOfMessagesSuccesses%%</option>
								<option value="notices" %%GLOBAL_IsLoggingSeverityNotices%%>%%LNG_TypesOfMessagesNotices%%</option>
								<option value="debug" %%GLOBAL_IsLoggingSeverityDebug%%>%%LNG_TypesOfMessagesDebug%%</option>
							</select>
						</td>
					</tr>
					<tr class="SystemLoggingToggle">
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="SystemLogMaxLength">%%LNG_RestrictLogTo%%:</label>
						</td>
						<td style="padding-left: 28px">
							<input type="text" name="SystemLogMaxLength" id="SystemLogMaxLength" value="%%GLOBAL_SystemLogMaxLength%%" class="Field40" /> %%LNG_MostRecentEntries%%
							<img onmouseout="HideHelp('logging2');" onmouseover="ShowHelp('logging2', '%%LNG_RestrictLogTo%%', '%%LNG_RestrictLogToHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="logging2"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; %%LNG_HidePHPErrors%%?
						</td>
						<td>
							<label style="padding-left: 4px;" for="HidePHPErrors"><input %%GLOBAL_IsHidePHPErrorsEnabled%% type="checkbox" name="HidePHPErrors" id="HidePHPErrors" value="1" />%%LNG_YesHidePHPErrors%%</label>
							<img onmouseout="HideHelp('logging22');" onmouseover="ShowHelp('logging22', '%%LNG_HidePHPErrors%%?', '%%LNG_HidePHPErrorsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="logging22"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; %%LNG_EnableDebugMode%%?
						</td>
						<td>
							<label style="padding-left: 4px;" for="DebugMode"><input %%GLOBAL_IsDebugModeEnabled%% type="checkbox" name="DebugMode" id="DebugMode" value="1" />%%LNG_YesEnableDebugMode%%</label>
							<img onmouseout="HideHelp('logging23');" onmouseover="ShowHelp('logging23', '%%LNG_EnableDebugMode%%?', '%%LNG_EnableDebugModeHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="logging23"></div>
						</td>
					</tr>
				</table>

				<table width="100%" class="Panel" style="display: %%GLOBAL_HideStaffLogs%%">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_AdministratorLogging%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; %%LNG_EnableAdministratorLogging%%?
						</td>
						<td>
							<label style="padding-left: 4px;" for="EnableAdministratorLogging"><input %%GLOBAL_IsAdministratorLoggingEnabled%% type="checkbox" name="AdministratorLogging" id="EnableAdministratorLogging" value="ON" onclick="ToggleAdministratorLogging()" /> %%LNG_YesEnableAdministratorLogging%%</label>
							<img onmouseout="HideHelp('logging3');" onmouseover="ShowHelp('logging3', '%%LNG_EnableAdministratorLogging%%?', '%%LNG_EnableAdministratorLoggingHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="logging3"></div>
						</td>
					</tr>
					<tr class="AdministratorLoggingToggle">
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="AdministratorLogMaxLength">%%LNG_RestrictLogTo%%:</label>
						</td>
						<td>
							<span style="padding-left: 28px;"><input type="text" name="AdministratorLogMaxLength" id="AdministratorLogMaxLength" value="%%GLOBAL_AdministratorLogMaxLength%%" class="Field40" /> %%LNG_MostRecentEntries%%
							</span>
							<img onmouseout="HideHelp('RestrictLogHelp');" onmouseover="ShowHelp('RestrictLogHelp', '%%LNG_RestrictLogTo%%', '%%LNG_RestrictLogToHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="RestrictLogHelp"></div>
						</td>
					</tr>

				</table>
			</div>

			<div id="div5" style="padding-top: 10px; display: none">
				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_VendorSettings%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; %%LNG_VendorLogoUploading%%:
						</td>
						<td>
							<label>
								<input type="checkbox" name="VendorLogoUploading" id="VendorLogoUploading" value="1" %%GLOBAL_VendorLogoUploadingChecked%% onclick="$(this).parent().siblings('.CheckToggle').toggle();" /> %%LNG_YesAllowVendorLogoUploading%%
							</label>
							<img onmouseout="HideHelp('VendorLogoUploadingHelp');" onmouseover="ShowHelp('VendorLogoUploadingHelp', '%%LNG_VendorLogoUploading%%', '%%LNG_VendorLogoUploadingHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="VendorLogoUploadingHelp"></div>
							<div style="%%GLOBAL_HideVendorLogoUploading%%" class="CheckToggle">
								<img src="images/nodejoin.gif" alt="" />
								%%LNG_MaximumImageDimensions%%:
								<input type="text" name="VendorLogoSizeW" id="VendorLogoSizeW" value="%%GLOBAL_VendorLogoSizeW%%" class="Field40" />
								x
								<input type="text" name="VendorLogoSizeH" id="VendorLogoSizeH" value="%%GLOBAL_VendorLogoSizeH%%" class="Field40" />
							</div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel" style="vertical-align: top">
							&nbsp;&nbsp; %%LNG_VendorPhotoUploading%%:
						</td>
						<td>
							<label>
								<input type="checkbox" name="VendorPhotoUploading" id="VendorPhotoUploading" value="1" %%GLOBAL_VendorPhotoUploadingChecked%% onclick="$(this).parent().siblings('.CheckToggle').toggle();" /> %%LNG_YesAllowVendorPhotoUploading%%
							</label>
							<img onmouseout="HideHelp('VendorPhotoUploadingHelp');" onmouseover="ShowHelp('VendorPhotoUploadingHelp', '%%LNG_VendorPhotoUploading%%', '%%LNG_VendorPhotoUploadingHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="VendorPhotoUploadingHelp"></div>
							<div style="%%GLOBAL_HideVendorPhotoUploading%%" class="CheckToggle">
								<img src="images/nodejoin.gif" alt="" />
								%%LNG_MaximumImageDimensions%%:
								<input type="text" name="VendorPhotoSizeW" id="VendorPhotoSizeW" value="%%GLOBAL_VendorPhotoSizeW%%" class="Field40" />
								x
								<input type="text" name="VendorPhotoSizeH" id="VendorPhotoSizeH" value="%%GLOBAL_VendorPhotoSizeH%%" class="Field40" />
							</div>
						</td>
					</tr>
				</table>
			</div>

			<div id="div6" style="padding-top: 10px;">
				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_NewsletterSettings%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; %%LNG_ShowMailingListDuringCheckout%%?
						</td>
						<td>
							<input %%GLOBAL_IsShowMailingListInvite%% type="checkbox" name="ShowMailingListInvite" id="ShowMailingListInvite" value="1" /> <label for="ShowMailingListInvite">%%LNG_YesShowMailingListDuringCheckout%%</label>
							<img onmouseout="HideHelp('shml');" onmouseover="ShowHelp('shml', '%%LNG_ShowMailingListDuringCheckout%%?', '%%LNG_ShowMailingListDuringCheckoutHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="shml"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; %%LNG_AutomaticallyTickDuringCheckout%%?
						</td>
						<td>
							<input %%GLOBAL_IsNewsletterBoxTicked%% type="checkbox" name="MailAutomaticallyTickNewsletterBox" id="MailAutomaticallyTickNewsletterBoxYes" value="ON" /> <label for="MailAutomaticallyTickNewsletterBoxYes">%%LNG_YesTickNewsletterBox%%</label>
							<img onmouseout="HideHelp('d40');" onmouseover="ShowHelp('d40', '%%LNG_AutomaticallyTickDuringCheckout%%?', '%%LNG_AutomaticallyTickDuringCheckoutHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="d40"></div>
						</td>
					</tr>
					<tr style="display:%%GLOBAL_HideSpecialOffersBox%%">
						<td class="FieldLabel">
							&nbsp;&nbsp; %%LNG_AutomaticallyTickOrderDuringCheckout%%?
						</td>
						<td>
							<input %%GLOBAL_IsOrderBoxTicked%% type="checkbox" name="MailAutomaticallyTickOrderBox" id="MailAutomaticallyTickOrderBoxYes" value="ON" /><label for="MailAutomaticallyTickOrderBoxYes">%%LNG_YesTickSpecialOffersBox%%</label>
							<img onmouseout="HideHelp('MailAutoTickHelp');" onmouseover="ShowHelp('MailAutoTickHelp', '%%LNG_AutomaticallyTickOrderDuringCheckout%%?', '%%LNG_AutomaticallyTickOrderDuringCheckoutHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="MailAutoTickHelp"></div>
						</td>
					</tr>
				</table>
				<br />
				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_CustomerGroupsSettings%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="GuestCustomerGroup">%%LNG_GuestCustomerGroup%%:</label>
						</td>
						<td>
							<select name="GuestCustomerGroup" id="GuestCustomerGroup" size="5" class="Field250">
								<option value="0">%%LNG_GuestCustomerGroupNone%%</option>
								%%GLOBAL_CustomerGroupOptions%%
							</select>
							<img onmouseout="HideHelp('GuestCustomerGroupHelp');" onmouseover="ShowHelp('GuestCustomerGroupHelp', '%%LNG_GuestCustomerGroup%%', '%%LNG_GuestCustomerGroupHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="GuestCustomerGroupHelp"></div>
						</td>
					</tr>
				</table>
				<br />
				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_GoogleMapsSettings%%</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp; <label for="BackupsLocal">%%LNG_GoogleMapsAPIKey%%:</label>
						</td>
						<td>
							<input type="text" name="GoogleMapsAPIKey" id="GoogleMapsAPIKey" value="%%GLOBAL_GoogleMapsAPIKey%%" class="Field250" />
							<img onmouseout="HideHelp('gmapapikey');" onmouseover="ShowHelp('gmapapikey', '%%LNG_GoogleMapsAPIKey%%', '%%LNG_GoogleMapsAPIKeyHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="gmapapikey"></div>
							<div style="padding-top:2px">
								<a href="http://www.google.com/apis/maps/signup.html" target="_blank" style="color:gray">%%LNG_GoogleMapsAPILinkText%%</a>
							</div>
						</td>
					</tr>
				</table>
				<table width="100%" class="Panel" style="%%GLOBAL_HideProxyFields%%">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_HTTPProxySettings%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">&nbsp;</span> <label for="ShopPath">%%LNG_HTTPProxyServer%%:</label>
						</td>
						<td>
							<input type="text" name="HTTPProxyServer" id="HTTPProxyServer" value="%%GLOBAL_HTTPProxyServer%%" class="Field250" />
							<img onmouseout="HideHelp('hp1');" onmouseover="ShowHelp('hp1', '%%LNG_HTTPProxyServer%%', '%%LNG_HTTPProxyServerHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="hp1"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">&nbsp;</span> <label for="ShopPath">%%LNG_HTTPProxyPort%%:</label>
						</td>
						<td>
							<input type="text" name="HTTPProxyPort" id="HTTPProxyPort" value="%%GLOBAL_HTTPProxyPort%%" class="Field250" />
							<img onmouseout="HideHelp('hp2');" onmouseover="ShowHelp('hp2', '%%LNG_HTTPProxyPort%%', '%%LNG_HTTPProxyPortHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="hp2"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">&nbsp;</span> <label for="ShopPath">%%LNG_HTTPSSLVerifyPeer%%:</label>
						</td>
						<td>
						<input %%GLOBAL_IsHTTPSSLVerifyPeerEnabled%% type="checkbox" name="HTTPSSLVerifyPeer" id="HTTPSSLVerifyPeer" value="ON" /> <label for="HTTPSSLVerifyPeer">%%LNG_YesHTTPSSLVerifyPeer%%</label>
							<img onmouseout="HideHelp('hp3');" onmouseover="ShowHelp('hp3', '%%LNG_HTTPSSLVerifyPeer%%', '%%LNG_HTTPSSLVerifyPeerHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
							<div style="display:none" id="hp3"></div>
						</td>
					</tr>
				</table>
			</div>

			<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
				<tr>
					<td width="200" class="FieldLabel">
						&nbsp;
					</td>
					<td>
						<input type="submit" disabled="disabled" value="%%LNG_Save%%" class="FormButton" />
						<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
					</td>
				</tr>
			</table>

	</tr>
	</table>
	</div>
	</form>

	<script type="text/javascript">

	function ShowTab(T) {
		i = 0;
		while (document.getElementById("tab" + i) != null) {
			document.getElementById("div" + i).style.display = "none";
			document.getElementById("tab" + i).className = "";
			i++;
		}

		document.getElementById("div" + T).style.display = "";
		document.getElementById("tab" + T).className = "active";

		document.getElementById("currentTab").value = T;
	}

	function ToggleDefaultProductImage()
	{
		if($('.DefaultProductImage:checked').val() == 'custom') {
			$('#DefaultProductImageCustomContainer').show();
		}
		else {
			$('#DefaultProductImageCustomContainer').hide();
		}
	}

	function ToggleSystemLogging() {
		var siblings = $('.SystemLoggingToggle');
		if(g('EnableSystemLogging').checked) {
			siblings.show();
		}
		else {
			siblings.hide();
		}
	}
	ToggleSystemLogging();

	function ToggleAdministratorLogging() {
		var siblings = $('.AdministratorLoggingToggle');
		if(g('EnableAdministratorLogging').checked) {
			siblings.show();
		}
		else {
			siblings.hide();
		}
	}
	ToggleAdministratorLogging();

	function ConfirmCancel()
	{
		if(confirm("%%LNG_ConfirmCancelSettings%%"))
			document.location.href = "index.php?ToDo=viewSettings";
	}

	$('#frmSettings').submit(function() {
		var StoreName = g("StoreName");
		var StoreAddress = g("StoreAddress");
		var ShopPath = g("ShopPath");
		var CharacterSet = g("CharacterSet");
		var MetaKeywords = g("MetaKeywords");
		var MetaDesc = g("MetaDesc");
		var DownloadDirectory = g("DownloadDirectory");
		var ImageDirectory = g("ImageDirectory");
		var serverStamp = g("serverStamp");
		var AdminEmail = g("AdminEmail");
		var OrderEmail = g("OrderEmail");
		var DefaultTaxRate = g("DefaultTaxRate");
		var WeightMeasurement = g("WeightMeasurement");
		var LengthMeasurement = g("LengthMeasurement");
		var DisplayDateFormat = g("DisplayDateFormat");
		var ExportDateFormat = g("ExportDateFormat");
		var ExtendedDisplayDateFormat = g("ExtendedDisplayDateFormat");
		var AutoThumbSize = g("AutoThumbSize");
		var CategoryPerRow = g("CategoryPerRow");
		var CategoryImageWidth = g("CategoryImageWidth");
		var CategoryImageHeight = g("CategoryImageHeight");
		var CategoryDefaultImage = g("CategoryDefaultImage");
		var BrandPerRow = g("BrandPerRow");
		var BrandImageWidth = g("BrandImageWidth");
		var BrandImageHeight = g("BrandImageHeight");
		var BrandDefaultImage = g("BrandDefaultImage");
		var HomeFeaturedProducts = g("HomeFeaturedProducts");
		var HomeNewProducts = g("HomeNewProducts");
		var HomeBlogPosts = g("HomeBlogPosts");
		var CategoryProductsPerPage = g("CategoryProductsPerPage");
		var CategoryListDepth = g("CategoryListDepth");
		var ProductReviewsPerPage = g("ProductReviewsPerPage");
		var TagCartQuantityBoxes = g("TagCartQuantityBoxes");
		var AddToCartButtonPosition = g("AddToCartButtonPosition");
		var TagCloudsEnabled = g("TagCloudsEnabled");
		var ShowAddToCartQtyBox = g("ShowAddToCartQtyBox");
		var CaptchaEnabled = g("CaptchaEnabled");
		var ShowThumbsInCart = g("ShowThumbsInCart");
		var ShowCartSuggestions = g("ShowCartSuggestions");
		var AutoApproveReviews = g("AutoApproveReviews");
		var RSSItemsLimit = g("RSSItemsLimit");
		var RSSCacheTime = g("RSSCacheTime");

		if(StoreName.value == "") {
			ShowTab(0);
			alert("%%LNG_EnterStoreName%%");
			StoreName.focus();
			return false;
		}

		if(StoreAddress.value == "") {
			ShowTab(0);
			alert("%%LNG_EnterStoreAddress%%");
			StoreAddress.focus();
			return false;
		}

		if(ShopPath.value == "" || ShopPath.value == "http://") {
			ShowTab(0);
			alert("%%LNG_EnterShopPath%%");
			ShopPath.focus();
			ShopPath.select();
			return false;
		}

		if(CharacterSet.value == "") {
			ShowTab(0);
			alert("%%LNG_EnterCharacterSet%%");
			CharacterSet.focus();
			return false;
		}

		if(DownloadDirectory.value == "") {
			ShowTab(0);
			alert("%%LNG_EnterDownloadDirectory%%");
			DownloadDirectory.focus();
			return false;
		}

		if(ImageDirectory.value == "") {
			ShowTab(0);
			alert("%%LNG_EnterImageDirectory%%");
			ImageDirectory.focus();
			return false;
		}

		if(serverStamp.value == "") {
			ShowTab(0);
			alert("%%LNG_EnterLicenseKey%%");
			serverStamp.focus();
			return false;
		}

		if(AdminEmail.value.indexOf("@") == -1 || AdminEmail.value.indexOf(".") == -1) {
			ShowTab(0);
			alert("%%LNG_EnterValidAdminEmail%%");
			AdminEmail.focus();
			AdminEmail.select();
			return false;
		}

		ValidateSMTPSettings();

		if(OrderEmail.value.indexOf("@") == -1 || OrderEmail.value.indexOf(".") == -1) {
			ShowTab(0);
			alert("%%LNG_EnterValidOrderEmail%%");
			OrderEmail.focus();
			OrderEmail.select();
			return false;
		}

		if(!$('#DimensionsDecimalToken').val()) {
			alert('%%LNG_EnterDecimalToken%%');
			$('#DimensionsDecimalToken').focus();
			$('#DimensionsDecimalToken').select();
			return false;
		}

		if(!$('#DimensionsThousandsToken').val()) {
			alert('%%LNG_EnterThousandsToken%%');
			$('#DimensionsThousandsToken').focus();
			$('#DimensionsThousandsToken').select();
			return false;
		}

		if(!$('#DimensionsDecimalPlaces').val() || isNaN($('#DimensionsDecimalPlaces').val())) {
			alert('%%LNG_EnterDecimalPlaces%%');
			$('#DimensionsDecimalPlaces').focus();
			$('#DimensionsDecimalPlaces').select();
			return false;
		}

		if(DisplayDateFormat.value == "") {
			ShowTab(1);
			alert("%%LNG_EnterDisplayDateFormat%%");
			DisplayDateFormat.focus();
			return false;
		}

		if(ExportDateFormat.value == "") {
			ShowTab(1);
			alert("%%LNG_EnterExportDateFormat%%");
			ExportDateFormat.focus();
			return false;
		}

		if(ExtendedDisplayDateFormat.value == "") {
			ShowTab(1);
			alert("%%LNG_EnterExtendedDisplayDateFormat%%");
			ExtendedDisplayDateFormat.focus();
			return false;
		}

		if(isNaN(AutoThumbSize.value) || AutoThumbSize.value == "") {
			ShowTab(2);
			alert("%%LNG_EnterAutoThumbSize%%");
			AutoThumbSize.focus();
			AutoThumbSize.select();
			return false;
		}

		if(isNaN(HomeFeaturedProducts.value) || HomeFeaturedProducts.value == "") {
			ShowTab(2);
			alert("%%LNG_EnterHomeFeaturedProducts%%");
			HomeFeaturedProducts.focus();
			HomeFeaturedProducts.select();
			return false;
		}

		if(isNaN(HomeNewProducts.value) || HomeNewProducts.value == "") {
			ShowTab(2);
			alert("%%LNG_EnterHomeNewProducts%%");
			HomeNewProducts.focus();
			HomeNewProducts.select();
			return false;
		}

		if(isNaN(HomeBlogPosts.value) || HomeBlogPosts.value == "") {
			ShowTab(2);
			alert("%%LNG_EnterHomeBlogPosts%%");
			HomeBlogPosts.focus();
			HomeBlogPosts.select();
			return false;
		}

		if($('.DefaultProductImage:checked').val() == 'custom') {
			if(($('#DefaultProductImageCustomCurrent').css('display') == 'none' || $('#DefaultProductImageCustom').val()) && !IsValidImageExtension($('#DefaultProductImageCustom').val())) {
				ShowTab(2);
				alert('%%LNG_ChooseDefaultProductImageUpload%%');
				$('#DefaultProductImageCustom').focus();
				return false;
			}
		}

		if(isNaN(CategoryProductsPerPage.value) || CategoryProductsPerPage.value == "") {
			ShowTab(2);
			alert("%%LNG_EnterCategoryProductsPerPage%%");
			CategoryProductsPerPage.focus();
			CategoryProductsPerPage.select();
			return false;
		}

		if(isNaN(CategoryListDepth.value) || CategoryListDepth.value == "" || CategoryListDepth.value<=0) {
			ShowTab(2);
			alert("%%LNG_EnterCategoryListDepth%%");
			CategoryListDepth.focus();
			CategoryListDepth.select();
			return false;
		}

		if(isNaN(ProductReviewsPerPage.value) || ProductReviewsPerPage.value == "") {
			ShowTab(2);
			alert("%%LNG_EnterProductReviewsPerPage%%");
			ProductReviewsPerPage.focus();
			ProductReviewsPerPage.select();
			return false;
		}

		if(isNaN(CategoryPerRow.value) || CategoryPerRow.value == "" || CategoryPerRow.value <= 0) {
			ShowTab(2);
			alert("%%LNG_EnterCategoryPerRow%%");
			CategoryPerRow.focus();
			CategoryPerRow.select();
			return false;
		}

		if(isNaN(BrandPerRow.value) || BrandPerRow.value == "" || BrandPerRow.value <= 0) {
			ShowTab(2);
			alert("%%LNG_EnterBrandPerRow%%");
			BrandPerRow.focus();
			BrandPerRow.select();
			return false;
		}

		if(isNaN(CategoryImageWidth.value) || CategoryImageWidth.value == "") {
			ShowTab(2);
			alert("%%LNG_EnterCategoryImageWidth%%");
			CategoryImageWidth.focus();
			CategoryImageWidth.select();
			return false;
		}

		if(isNaN(CategoryImageHeight.value) || CategoryImageHeight.value == "") {
			ShowTab(2);
			alert("%%LNG_EnterCategoryImageHeight%%");
			CategoryImageHeight.focus();
			CategoryImageHeight.select();
			return false;
		}

		if(isNaN(BrandImageWidth.value) || BrandImageWidth.value == "") {
			ShowTab(2);
			alert("%%LNG_EnterBrandImageWidth%%");
			BrandImageWidth.focus();
			BrandImageWidth.select();
			return false;
		}

		if(isNaN(BrandImageHeight.value) || BrandImageHeight.value == "") {
			ShowTab(2);
			alert("%%LNG_EnterBrandImageHeight%%");
			BrandImageHeight.focus();
			BrandImageHeight.select();
			return false;
		}

		if(CategoryDefaultImage.value != "") {
			// Make sure it has a valid extension
			img = CategoryDefaultImage.value.split(".");
			ext = img[img.length-1].toLowerCase();

			if(ext != "jpg" && ext != "png" && ext != "gif") {
				ShowTab(2);
				alert("%%LNG_ChooseValidImage%%");
				CategoryDefaultImage.focus();
				CategoryDefaultImage.select();
				return false;
			}
		}

		if(BrandDefaultImage.value != "") {
			// Make sure it has a valid extension
			img = BrandDefaultImage.value.split(".");
			ext = img[img.length-1].toLowerCase();

			if(ext != "jpg" && ext != "png" && ext != "gif") {
				ShowTab(2);
				alert("%%LNG_ChooseValidImage%%");
				BrandDefaultImage.focus();
				BrandDefaultImage.select();
				return false;
			}
		}

		if(isNaN($('#TagCloudMinSize').val()) || $('#TagCloudMinSize').val() == '') {
			ShowTab(2);
			alert('%%LNG_EnterTagCloudMinSize%%');
			$('#TagCloudMinSize').focus();
			$('#TagCloudMinSize').select();
			return false;
		}

		if(isNaN($('#TagCloudMaxSize').val()) || $('#TagCloudMaxSize').val() == '') {
			ShowTab(2);
			alert('%%LNG_EnterTagCloudMaxSize%%');
			$('#TagCloudMaxSize').focus();
			$('#TagCloudMaxSize').select();
			return false;
		}

		if(isNaN(RSSItemsLimit.value) || RSSItemsLimit.value == "") {
			ShowTab(2);
			alert("%%LNG_EnterRSSItemsLimit%%");
			RSSItemsLimit.focus();
			RSSItemsLimit.select();
			return false;
		}

		if(isNaN(RSSCacheTime.value)) {
			ShowTab(2);
			alert("%%LNG_EnterValidRSSCacheTime%%");
			RSSCacheTime.focus();
			RSSCacheTime.select();
			return false;
		}

		if(ValidateFTPSettings() == false)
		{
			return false;
		}

		if($("#BackupsAutomatic:checked").val() && !$("#BackupsAutomaticDatabase:checked").val() && !$("#BackupsAutomaticImages:checked").val() && !$("#BackupsAutomaticDownloads:checked").val()) {
			alert("%%LNG_AtLeastOnAutomaticBackup%%");
			return false;
		}

		if($('#tab4').css('display') != 'none') {
			if(g('EnableSystemLogging').checked == true) {
				var f = g('SystemLogTypes');
				if(f.selectedIndex == -1) {
					ShowTab(4);
					alert('%%LNG_SelectOneMoreLoggingTypes%%');
					g('SystemLogTypes').focus();
					return false;
				}
				var f = g('SystemLogSeverity');
				if(f.selectedIndex == -1) {
					ShowTab(4);
					alert('%%LNG_SelectOneMoreLoggingSeverities%%');
					g('SystemLogSeverity').focus();
					return false;
				}
				if(isNaN(g('SystemLogMaxLength').value) && g('SystemLogMaxLength').value != '') {
					ShowTab(4);
					alert('%%LNG_EnterValidSystemLogLength%%');
					g('SystemLogMaxLength').focus();
					g('SystemLogMaxLength').select();
					return false;
				}
			}

			if(g('EnableAdministratorLogging').checked == true) {
				if(isNaN(g('AdministratorLogMaxLength').value) && g('AdministratorLogMaxLength').value != '') {
					ShowTab(4);
					alert('%%LNG_EnterValidAdministratorLogLength%%');
					g('AdministratorLogMaxLength').focus();
					g('AdministratorLogMaxLength').select();
					return false;
				}
			}
		}
		if($('#tab5').css('display') != 'none') {
			if($('#VendorLogoUploading:checked').val()) {
				if(isNaN($('#VendorLogoSizeW').val()) && $('#VendorLogoSizeW').val() != '') {
					alert('%%LNG_EnterVendorLogoSizeDimensions%%');
					ShowTab(5);
					$('#VendorLogoSizeW').focus();
					$('#VendorLogoSizeW').select();
					return false;
				}

				if(isNaN($('#VendorLogoSizeH').val()) && $('#VendorLogoSizeH').val() != '') {
					alert('%%LNG_EnterVendorLogoSizeDimensions%%');
					ShowTab(5);
					$('#VendorLogoSizeH').focus();
					$('#VendorLogoSizeH').select();
					return false;
				}
			}

			if($('#VendorPhotoUploading:checked').val()) {
				if(isNaN($('#VendorPhotoSizeW').val()) && $('#VendorPhotoSizeW').val() != '') {
					alert('%%LNG_EnterVendorPhotoSizeDimensions%%');
					ShowTab(5);
					$('#VendorPhotoSizeW').focus();
					$('#VendorPhotoSizeW').select();
					return false;
				}

				if(isNaN($('#VendorPhotoSizeH').val()) && $('#VendorPhotoSizeH').val() != '') {
					alert('%%LNG_EnterVendorPhotoSizeDimensions%%');
					ShowTab(5);
					$('#VendorPhotoSizeH').focus();
					$('#VendorPhotoSizeH').select();
					return false;
				}
			}
		}

		return true;
	});

	function TestSSL() {
		// See if the site is capable of handling HTTPS requests
		var https_url = "%%GLOBAL_HTTPSUrl%%";

		alert("%%LNG_TestSSLText%%");
		window.open(https_url);
	}

	function ToggleLocalBackups()
	{
		if($('#BackupsLocal:checked').val()) {
			$('#BackupsAutomaticLocal').attr('disabled', false);
			CheckAutomaticBackups();
		}
		else {
			$('#BackupsAutomaticLocal').attr('disabled', true);
			CheckAutomaticBackups();
		}
	}

	function CheckAutomaticBackups()
	{
		if(!$('#BackupsLocal:checked').val() && (!$('#BackupsRemoteFTPContainer:visible') || !$('#BackupsRemoteFTP:checked').val())) {
			$('#BackupsAutomatic').attr('disabled', true);
			$('#BackupsAutomatic').attr('checked', false);
			$('.BackupsAutomaticContainer').hide();
		}
		else {
			$('#BackupsAutomatic').attr('disabled', false);
			ToggleAutomaticBackups();
		}
	}

	function ToggleFTPBackups()
	{
		if($('#BackupsRemoteFTPContainer:visible')) {
			if($('#BackupsRemoteFTP:checked').val()) {
				$('#BackupsRemoteFTPSettings').show();
				$('#BackupsAutomaticFTP').attr('disabled', false);
			}
			else {
				$('#BackupsRemoteFTPSettings').hide();
				$('#BackupsAutomaticFTP').attr('disabled', true);
				$('#BackupsAutomaticMethod').get()[0].selectedIndex = 0;
			}
		}
		else {
			$('#BackupsAutomaticFTP').attr('disabled', true);
			$('#BackupsAutomaticMethod').get()[0].selectedIndex = 0;
		}
		CheckAutomaticBackups();
	}

	function ToggleAutomaticBackups()
	{
		if($('#BackupsAutomatic:checked').val()) {
			$('.BackupsAutomaticContainer').show();
		} else {
			$('.BackupsAutomaticContainer').hide();
		}
	}

	ToggleLocalBackups();
	ToggleAutomaticBackups();
	ToggleFTPBackups();

	function DoTestFTPSettings() {
		result = ValidateFTPSettings();
		if(result == false) return false;

		var host = $('#BackupsRemoteFTPHost').val();
		var user = $('#BackupsRemoteFTPUser').val();
		var pass = $('#BackupsRemoteFTPPass').val();
		var path = $('#BackupsRemoteFTPPath').val();

		$('#TestFTPSettings').attr('disabled', true);
		$('#TestFTPSettings').val('%%LNG_TestingFTPSettings%%');
		$('#TestFTPSettingsLoading').show();

		jQuery.ajax({
			type: 'POST',
			url: 'remote.php?w=TestFTPSettings',
			data: 'host='+host+'&user='+user+'&pass='+pass+'&path='+path,
			dataType: 'script',
			success: function() {
				$('#TestFTPSettings').attr('disabled', false);
				$('#TestFTPSettings').val('%%LNG_TestFTPSettings%%');
				$('#TestFTPSettingsLoading').hide();
			}
		});
	}

	function ValidateFTPSettings()
	{
		if($('#BackupsRemoteFTPContainer:visible') && $('#BackupsRemoteFTP:checked').val()) {
			if($('#BackupsRemoteFTPHost').val() == '') {
				ShowTab(3);
				alert('%%LNG_EnterFTPHostname%%');
				$('#BackupsRemoteFTPHost').focus();
				$('#BackupsRemoteFTPHost').select();
				return false;
			}
			if($('#BackupsRemoteFTPUser').val() == '') {
				ShowTab(3);
				alert('%%LNG_EnterFTPUsername%%');
				$('#BackupsRemoteFTPUser').focus();
				$('#BackupsRemoteFTPUser').select();
				return false;
			}
			if($('#BackupsRemoteFTPPass').val() == '') {
				ShowTab(3);
				alert('%%LNG_EnterFTPPassword%%');
				$('#BackupsRemoteFTPPass').focus();
				$('#BackupsRemoteFTPPass').select();
				return false;
			}
		}
		return true;
	}

	$(document).ready(function() {
		ShowTab(%%GLOBAL_CurrentTab%%);

		$('input[type=submit]').attr('disabled', '');

		if($('#EnableProductReviews:checked').val()) {
			$('.HideIfReviewsDisabled').show();
		}
		else {
			$('.HideIfReviewsDisabled').hide();
		}

		ToggleDefaultProductImage();
		$('.DefaultProductImage[type=radio]').click(ToggleDefaultProductImage);
	});

	function ToggleMailSettings() {
		if($('#MailUseSMTP').attr('checked') == true) {
			$('.SMTPOptions').show();
		}
		else {
			$('.SMTPOptions').hide();
		}
	}

	function TestSMTPMailSettings() {
		if(!ValidateSMTPSettings()) {
			return;
		}

		$('#TestSMTPSettings').attr('disabled', true);
		$('#TestSMTPSettings').val('%%LNG_TestingSMTPSettings%%');
		$('#TestSMTPSettingsLoading').show();

		var email = $('#AdminEmail').val();
		var host = $('#MailSMTPServer').val();
		var user = $('#MailSMTPUsername').val();
		var pass = $('#MailSMTPPassword').val();
		var port = $('#MailSMTPPort').val();

		jQuery.ajax({
			type: 'POST',
			url: 'remote.php?w=TestSMTPSettings',
			data: 'AdminEmail='+escape(email)+'&MailSMTPServer='+escape(host)+'&MailSMTPUsername='+escape(user)+'&MailSMTPPassword='+escape(pass)+'&MailSMTPPort='+escape(port),
			dataType: 'xml',
			success: function(xml) {
				$('#TestSMTPSettings').attr('disabled', false);
				$('#TestSMTPSettings').val('%%LNG_TestSMTPSettings%%');
				$('#TestSMTPSettingsLoading').hide();
				var message = $('message', xml).text();
				message = message.replace('\\n', '\n');
				message = message.replace('\\n', '\n');
				if($('status', xml).text() == 1) {
					alert(message);
				}
				else {
					alert(message);
				}
			}
		});
	}

	function ValidateSMTPSettings() {
		if($('#MailUseSMTP').attr('checked') == true) {
			if(!$('#MailSMTPServer').val()) {
				alert('%%LNG_EnterSMTPServer%%');
				$('#MailSMTPServer').focus();
				return false;
			}
		}

		return true;
	}</script>