using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using System.Data.Sql;
using System.Data.SqlClient;

namespace CWAdmin
{
    public class DBInterface
    {
        SqlConnection sqlCon = null;

        public void ConnectDB()
        {
            string conStr = System.Configuration.ConfigurationManager.AppSettings["SqlConn"];
            this.sqlCon = new SqlConnection(conStr);
            this.sqlCon.Open();
        }

        public void GetData(string spTest)
        {
            SqlCommand cmd = sqlCon.CreateCommand();
            cmd.CommandType = CommandType.StoredProcedure;
            cmd.CommandText = spTest;
            cmd.Parameters.Add("", SqlDbType.Char, 20, "");
        }

        public void DisconnectDB()
        {
            this.sqlCon.Close();
        }
    }
}
