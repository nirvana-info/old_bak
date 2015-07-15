using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Xml;
using System.Collections;
using SL360Test_Iris;

namespace SL360Test_Iris
{
    public class FileOpts
    {
        public void readXML(PublicPara para)
        {
            string sXMLName = para.sFileName;

            // Load XML file
            XmlDocument m_Doc = new XmlDocument();
            m_Doc.Load(sXMLName);
            XmlNodeList tableList = m_Doc.DocumentElement.ChildNodes;             
            XmlNodeList paralist = tableList.Item(tableList.Count - 1).ChildNodes;

            // Intiate all public parameters
            para.InitiateParas();

            // Add these parameters to public arrays
            for (int i = 0; i < paralist.Count; i++)
            {
                para.aName.Add(paralist[i].Attributes["name"].Value);
                para.aType.Add(paralist[i].Attributes["type"].Value);
                para.aValue.Add(paralist[i].Attributes["value"].Value);
                para.aKey.Add(paralist[i].Attributes["key"].Value);
                para.aAddress.Add(paralist[i].Attributes["address"].Value);                
            }
       
        } 

    }
}

////////////////////////
