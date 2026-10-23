using System;
using Microsoft.AspNetCore.Http;

namespace DarkSpace
{
    /// <summary>
    /// ASP.NET Core replacement for the legacy static ambient accessors of the
    /// WebForms port (System.Web.HttpContext.Current / HttpSessionState).
    /// Registered as a singleton in Program.cs; the ambient Current property is
    /// set at the beginning of every request by AppEnvironmentMiddleware.
    /// </summary>
    public class AppEnvironment
    {
        private static AppEnvironment _current;

        public AppEnvironment()
        {
            _current = this;
        }

        public static AppEnvironment Current => _current;

        /// <summary>Эквивалент System.Web.HttpContext.Current.</summary>
        public HttpContext Context { get; set; }

        public HttpRequest Request => Context?.Request;
        public HttpResponse Response => Context?.Response;

        /// <summary>Эквивалент HttpSessionState (Session[] -> Session.GetString/SetString).</summary>
        public ISession Session => Context?.Session;

        /// <summary>
        /// Безопасное чтение значения из POST-формы текущего запроса: возвращает null,
        /// если запроса нет, контент не form-data или ключ отсутствует.
        /// (Обращение к Request.Form без HasFormContentType бросает InvalidOperationException.)
        /// </summary>
        public string GetFormValue(string key)
        {
            var r = Request;
            if (r == null || !r.HasFormContentType) return null;
            return r.Form.TryGetValue(key, out var v) ? v.ToString() : null;
        }

        /// <summary>Безопасное чтение значения из query-строки текущего запроса.</summary>
        public string GetQueryValue(string key)
        {
            var r = Request;
            if (r == null) return null;
            return r.Query.TryGetValue(key, out var v) ? v.ToString() : null;
        }

        /// <summary>Эквивалент Request.ServerVariables["SERVER_NAME"].</summary>
        public string ServerName => Context != null && Context.Request.Host.HasValue
            ? Context.Request.Host.Host
            : Environment.MachineName;

        /// <summary>Эквивалент Request.UserHostAddress / REMOTE_ADDR.</summary>
        public string RemoteAddr => Context?.Connection?.RemoteIpAddress?.ToString() ?? "";

        /// <summary>Эквивалент Request.ServerVariables[name] для HTTP_* и REMOTE_ADDR.</summary>
        public string GetServerVariable(string name)
        {
            if (Context == null) return null;
            if (name == "REMOTE_ADDR") return RemoteAddr;
            if (name == "SERVER_NAME") return ServerName;
            if (name != null && name.StartsWith("HTTP_"))
            {
                string header = name.Substring(5).Replace('_', '-');
                return Context.Request.Headers.TryGetValue(header, out var v) ? v.ToString() : null;
            }
            return null;
        }

        /// <summary>Эквивалент Server.MapPath("~/relative/path").</summary>
        public string MapPath(string virtualPath)
        {
            if (string.IsNullOrEmpty(virtualPath)) return virtualPath;
            string rel = virtualPath.Replace("~/", "").Replace('/', System.IO.Path.DirectorySeparatorChar);
            return System.IO.Path.Combine(AppDomain.CurrentDomain.BaseDirectory, rel);
        }
    }

    /// <summary>Записывает AppEnvironment.Current.Context на каждый запрос (аналог Global.asax-контекста).</summary>
    public class AppEnvironmentMiddleware
    {
        private readonly RequestDelegate _next;

        public AppEnvironmentMiddleware(RequestDelegate next)
        {
            _next = next;
        }

        public async System.Threading.Tasks.Task Invoke(HttpContext context, AppEnvironment env)
        {
            env.Context = context;
            await _next(context);
        }
    }
}
