using System;
using System.Globalization;

namespace DarkSpace
{

    /// <summary>
    /// PORTING-PLAN A5.3 — Class.rank.php lines 493–630 (getCurrentPage…paginate) extracted
    /// into a standalone pager helper class, as the plan requires ("отдельный helper
    /// Paginator.cs вместо методов класса"). Lives in its own file Paginator.cs per the
    /// plan; same DarkSpace namespace as Rank (App_Code compiles into one assembly).
    ///
    /// Quirks preserved:
    ///  - getCurrentPage(): PHP computed clamped values but RETURNED (int)$this-&gt;page
    ///    regardless — reproduced exactly (the clamping had no effect unless page was set);
    ///  - getPager() reads $_GET['page'] (0 when absent); constructor also called getPager();
    ///  - setLimitPerPage threw "Execption" (sic) on non-int — ArgumentException here;
    ///  - paginate(): the two elseif proximity branches emitted identical markup — merged;
    ///  - getTotalOfPages(): PHP divided ints then ceil() — C# uses double division + ceil.
    /// </summary>
    public class RankPager
    {
        private int _count;                 // private $count (from getAllRankingPlayers etc.)
        private int _paginator = 0;         // private $paginator
        private int _limitPerPage = 100;    // private $_limit_per_page = 100
        private int _range = 100;           // private $range
        private int _page = 1;              // private $page
        private string _url = "";           // private $url

        public RankPager()
        {
            GetPager();
            string p = AppEnvironment.Current?.Request?.Query["page"].ToString();
            long pl;
            _page = (p != null && long.TryParse(p, NumberStyles.Any, CultureInfo.InvariantCulture, out pl))
                ? (int)pl : 1;
        }

        /// <summary>rank::getPager() — $_GET['page'] → $paginator (0 when missing).</summary>
        public void GetPager()
        {
            string p = AppEnvironment.Current?.Request?.Query["page"].ToString();
            _paginator = p != null ? (int)ToLong(p) : 0;
        }

        /// <summary>rank::getCurrentPage().</summary>
        public int GetCurrentPage()
        {
            int totalOfPages = (int)GetTotalOfPages();
            int currentPage = IsNumeric(_paginator.ToString(CultureInfo.InvariantCulture)) ? _paginator : 1;
            if (currentPage > totalOfPages) currentPage = totalOfPages;
            if (currentPage < 1) currentPage = 1;
            return _page; // PHP quirk: returned (int)$this->page, ignoring the clamped local
        }

        /// <summary>rank::getLimitPerPage().</summary>
        public int GetLimitPerPage() { return _limitPerPage; }

        /// <summary>rank::getTotalOfResults().</summary>
        public int GetTotalOfResults() { return _count; }

        /// <summary>rank::getTotalOfPages().</summary>
        public double GetTotalOfPages()
        {
            return Math.Ceiling((double)_count / _limitPerPage);
        }

        /// <summary>rank::getPaginator().</summary>
        private int GetPaginator() { return _paginator; }

        /// <summary>rank::setLimitPerPage($limit).</summary>
        public void SetLimitPerPage(int limit)
        {
            _limitPerPage = limit; // PHP threw on non-int; C# type system enforces int
        }

        /// <summary>Feed the private $count that PHP set inside queries (rowCount()).</summary>
        public void SetTotalOfResults(int count) { _count = count; }

        /// <summary>rank::getRange().</summary>
        public int GetRange() { return _range; }

        /// <summary>rank::setUrl($url).</summary>
        public void SetUrl(string url) { _url = url ?? ""; }

        /// <summary>rank::paginate($cl=null) — HTML navigation bar.</summary>
        public string Paginate(string cl = null)
        {
            string c = cl != null ? cl : "";
            int currentPage = GetCurrentPage();
            int totalOfPages = (int)GetTotalOfPages();
            int range = GetRange();
            var navReturn = new System.Text.StringBuilder();

            var q = AppEnvironment.Current?.Request?.Query;
            string sortv = q != null ? q["sort"].ToString() : null;
            string dirv = q != null ? q["direction"].ToString() : null;
            string so = "";
            if (!string.IsNullOrEmpty(sortv) && !string.IsNullOrEmpty(dirv))
                so = "&sort=" + System.Net.WebUtility.UrlEncode(sortv) + "&direction=" + System.Net.WebUtility.UrlEncode(dirv);

            if (_count > 0)
            {
                navReturn.Append("<div id=\"navigation-bar\">");
                if (currentPage > 1)
                {
                    int previous = currentPage - 1;
                    navReturn.Append(" <a href=\"" + _url + "&page=" + previous + so +
                                     "\" class=\"previous hof_pages_prev " + c + "\">Previous</a> ");
                }
                navReturn.Append("<div class=\"hof_pages\">");
                for (int x = currentPage - range; x < currentPage + range + 1; x++)
                {
                    if (x > 0 && x <= totalOfPages)
                    {
                        if (x == currentPage)
                        {
                            navReturn.Append(" <span class=\"current " + c + "\">" + x + "</span> ");
                        }
                        else if (x + 3 == currentPage || x + 2 == currentPage || x + 1 == currentPage ||
                                 x - 3 == currentPage || x - 2 == currentPage || x - 1 == currentPage)
                        {
                            // PHP had two identical elseif branches (xs+1..3 / xs-1..3) — merged.
                            navReturn.Append(" <a href=\"" + _url + "&page=" + x + so +
                                             "\" class=\"others " + c + "\">" + x + "</a> ");
                        }
                        // else: link emission was commented out in PHP — nothing rendered.
                    }
                }
                navReturn.Append("</div>");
                if (currentPage != totalOfPages)
                {
                    int next = currentPage + 1;
                    navReturn.Append(" <a href=\"" + _url + "&page=" + next + so +
                                     "\" class=\"next hof_pages_next " + c + "\">Next</a> ");
                }
                navReturn.Append("</div>");
            }
            return navReturn.ToString();
        }

        private static bool IsNumeric(string s)
        {
            double d;
            return s != null && double.TryParse(s, NumberStyles.Any, CultureInfo.InvariantCulture, out d);
        }

        private static long ToLong(string s)
        {
            long v;
            return long.TryParse(s, NumberStyles.Any, CultureInfo.InvariantCulture, out v) ? v : 0;
        }
    }
}
