using System;
using System.Collections.Generic;
using System.Data;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.news.php.
    /// Reads the 7 latest rows of `news` (via the PDO singleton channel $GLOBALS['DB'])
    /// and renders icon/text/image/js-array fragments for the header breaking-news widget.
    /// </summary>
    public class News
    {
        // data[1..cnt] — PHP array_combine(range(1,count),...) keeps 1-based indexes.
        private List<DataRow> _rows = new List<DataRow>();
        private int _cnt = 0;

        /// <summary>news::init() — returns TRUE when at least one news row exists.</summary>
        public bool Init()
        {
            _rows = new List<DataRow>();
            _cnt = 0;
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT * FROM news ORDER BY nID DESC LIMIT 7", con))
            using (var da = new MySqlDataAdapter(cmd))
            {
                var dt = new DataTable();
                try
                {
                    da.Fill(dt);
                }
                catch (Exception e)
                {
                    // PDO ERRMODE_SILENT parity: execute() failure -> return FALSE.
                    System.Diagnostics.Debug.WriteLine(e.Message);
                    return false;
                }
                foreach (DataRow r in dt.Rows) _rows.Add(r);
                _cnt = _rows.Count;
                return _cnt != 0;
            }
        }

        private string Col(int i, string name)
        {
            object v = _rows[i - 1][name];
            return v == DBNull.Value ? "" : Convert.ToString(v, System.Globalization.CultureInfo.InvariantCulture);
        }

        /// <summary>news::get($type) — types: icons | news | images | jsarray | jsarray2.</summary>
        public string Get(string type)
        {
            string ret = "";
            for (int i = 1; i <= _cnt; i++)
            {
                string newsID = Col(i, "newsID");
                if (type == "icons")
                {
                    string spc = (i != 1) ? "style=\"margin-left: 6px;\"" : "";
                    ret += "<img id=\"newsIcon_" + newsID + "\" class=\"breakingNewsIcon\" src=\"./do_img/global/events/icons/" + Col(i, "icon") + "\" width=\"21\" height=\"21\" " + spc + ">";
                }
                else if (type == "news")
                {
                    string spc = (i != 1) ? "style=\"display: none;\"" : "";
                    ret += "<div id=\"newsText_" + newsID + "\" class=\"newsTextContainer\" " + spc + "><h3>" + Col(i, "headline") + "</h3>" + Col(i, "text") + "</div>";
                }
                else if (type == "images")
                {
                    string spc = (i != 1) ? "style=\"display: none;\"" : "style=\"display: block;\"";
                    ret += "<img id=\"newsImage_" + newsID + "\" src=\"./do_img/global/events/" + Col(i, "image") + "\" class=\"newsImage oldNews\" " + spc + ">";
                }
                else if (type == "jsarray")
                {
                    ret += "newsItemIds.push('" + newsID + "');";
                }
                else if (type == "jsarray2")
                {
                    ret += "uploadedNewsIds.push('" + Col(1, "newsID") + "');";
                    break;
                }
            }
            return ret;
        }
    }
}
