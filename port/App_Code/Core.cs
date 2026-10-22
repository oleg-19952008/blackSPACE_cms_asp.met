using System;
using System.Text;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.Core.php.
    /// NOTE: PHP code called $Core::GenerateRandom(...) (capital G) while the class
    /// defines generateRandom(); we expose a single PascalCase API and keep the
    /// same character set / behaviour.
    /// </summary>
    public static class Core
    {
        private static readonly Random Rng = new Random();
        private static readonly object Sync = new object();

        public static string GenerateRandom(int length, bool numbers = true, bool letters = true, string otherChars = "")
        {
            var chars = new StringBuilder();
            if (numbers) chars.Append("0123456789");
            if (letters) chars.Append("QWERTYUIOPASDFGHJKLLZXCVBNMqwertyuiopasdfghjklzxcvbnm");
            chars.Append(otherChars);

            if (chars.Length == 0) return string.Empty;

            var str = new StringBuilder(length);
            string pool = chars.ToString();
            for (int c = 0; c < length; c++)
            {
                int idx;
                lock (Sync) { idx = Rng.Next(pool.Length); } // rand(0, strlen-1)
                str.Append(pool[idx]);
            }
            return str.ToString();
        }
    }
}
