//#*****************************************************************************
//# Purpose: ViewProfile.
//# Author:  Christie Duan
//# Create Date: April 07, 2009
//# Modify History: 
//#*****************************************************************************

using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;

namespace MaiaRegression.Appobjects.App01_HomePage
{
    public class MessageCenter : SignIn
    {
        public void ComposeMessage(string title, string msg)
        {
            UserSignIn(UN1, PW1, false, 0);
            browser.Link(Find.ById("uxMessages")).WaitUntilExists(20);
            browser.Link(Find.ById("uxMessages")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxComposemessage")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRecipient")).TypeText(UN2);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).TypeText(title);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMessage")).TypeText(msg);
        }

        public void ComposeSupportMessage(string msg)
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxMessages")).WaitUntilExists(20);
            browser.Link(Find.ById("uxMessages")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxComposeSupportmessage")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMessage")).TypeText(msg);
        }

        public void DeleteMessage(int type)
        {
            UserSignIn(UN1, PW1, false, 0);
            browser.Link(Find.ById("uxMessages")).WaitUntilExists(20);
            browser.Link(Find.ById("uxMessages")).Click();
            //browser.Link(Find.ByText("Inbox")).Click();
            if (type == 1)
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxSelectMail")).WaitUntilExists(10);
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxSelectMail")).Checked = true;
                browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxDeleteSelectedLink")).Click();
            }
            else if (type == 2)
            {
                browser.Image(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxDeleteItemButton")).WaitUntilExists(10);
                browser.Image(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxDeleteItemButton")).Click();
            }
        }

        public void ChangeReadStatus()
        {
            UserSignIn(UN1, PW1, false, 0);
            browser.Link("uxMessages").WaitUntilExists(20);
            browser.Link("uxMessages").Click();
            //browser.Link(Find.ByText("Inbox")).Click();
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxSelectMail")).WaitUntilExists();
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxSelectMail")).Checked = true;
            System.Threading.Thread.Sleep(2000);
        }

        public void ChooseSortType(int type)
        {
            //browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxRadComboBoxSortType_Arrow")).Click();
            switch (type)
            {
                case 0:
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxRadComboBoxSortType_Input")).Option("---").Select();
                    break;
                case 1:
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxRadComboBoxSortType_Input")).Option("All").Select();
                    break;
                case 2:
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxRadComboBoxSortType_Input")).Option("None").Select();
                    break;
                case 3:
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxRadComboBoxSortType_Input")).Option("Read").Select();
                    break;
                case 4:
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxRadComboBoxSortType_Input")).Option("Unread").Select();
                    break;
                default:
                    break;
            }
        }

        public void ViewAndReply()
        {
            UserSignIn(UN1, PW1, false, 0);
            browser.Link(Find.ById("uxMessages")).WaitUntilExists(20);
            browser.Link(Find.ById("uxMessages")).Click();
            //browser.Link(Find.ByText("Inbox")).Click();
            //browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxRadTabStripDisplayMessage")).Links[1].Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxSubject")).WaitUntilExists(10);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxSubject")).Click();
        }
    }
}
