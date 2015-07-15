using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using NUnit.Framework;
using WatiN.Core;
using System.Collections;


namespace SL360Test_Iris
{

    [TestFixture]

    public class Testcase_code01: Testbase
    {
        string sFilePath = "E:\\My Document\\Visual Studio 2008\\Projects\\SL360Test_Iris\\SL360Test_Iris\\Testcases\\";

        [Test]
        public void Testcase_01_001()
        {            
            para.sFileName = sFilePath + "Testcase_data01_001.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_01_002()
        {
            para.sFileName = sFilePath + "Testcase_data01_002.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_02_001()
        {
            para.sFileName = sFilePath + "Testcase_data02_001.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_02_002()
        {
            para.sFileName = sFilePath + "Testcase_data02_002.xml";
            TestcaseProcess();
        }


        [Test]
        public void Testcase_03_001()
        {
            para.sFileName = sFilePath + "Testcase_data03_001.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_04_001()
        {
            para.sFileName = sFilePath + "Testcase_data04_001.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_04_002()
        {
            para.sFileName = sFilePath + "Testcase_data04_002.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_04_003()
        {
            para.sFileName = sFilePath + "Testcase_data04_003.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_04_004()
        {
            para.sFileName = sFilePath + "Testcase_data04_004.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_04_005()
        {
            para.sFileName = sFilePath + "Testcase_data04_005.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_04_006()
        {
            para.sFileName = sFilePath + "Testcase_data04_006.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_04_007()
        {
            para.sFileName = sFilePath + "Testcase_data04_007.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_04_008()
        {
            para.sFileName = sFilePath + "Testcase_data04_008.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_04_009()
        {
            para.sFileName = sFilePath + "Testcase_data04_009.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_05_001()
        {
            para.sFileName = sFilePath + "Testcase_data05_001.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_05_002()
        {
            para.sFileName = sFilePath + "Testcase_data05_002.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_05_003()
        {
            para.sFileName = sFilePath + "Testcase_data05_003.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_05_004()
        {
            para.sFileName = sFilePath + "Testcase_data05_004.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_05_005()
        {
            para.sFileName = sFilePath + "Testcase_data05_005.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_05_006()
        {
            para.sFileName = sFilePath + "Testcase_data05_006.xml";
            TestcaseProcess();
        }

        [Test]
        public void Testcase_05_007()
        {
            para.sFileName = sFilePath + "Testcase_data05_007.xml";
            TestcaseProcess();
        }

        public void TestcaseProcess()
        {
            FileOpts readFile = new FileOpts();
            readFile.readXML(para);
            
            // Goto the website
            int iIndex = this.para.aKey.IndexOf("website address");
            FF.GoTo((string)this.para.aValue[iIndex]);

            // Login
            Login m_login = new Login();
            m_login.UserLogin(this);

            // Select DataSource
            DataSource Lead = new DataSource();
            Lead.SelectDataSource(this);

            // Select Area type and get areas
            SelectAreas AreaType = new SelectAreas();
            AreaType.AreaTypeSelect(this);

            // Select Audience
            SelectAudience Audience = new SelectAudience();
            Audience.AudienceSelect(this);

            // Review count and quote
            PlaceOrder placeAnOrder = new PlaceOrder();
            placeAnOrder.JudgeCounting(this);

        }

    }
}
