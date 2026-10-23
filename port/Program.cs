using System;
using Microsoft.AspNetCore.Builder;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Routing;
using Microsoft.Extensions.DependencyInjection;
using Microsoft.Extensions.Hosting;

namespace DarkSpace
{
    /// <summary>
    /// ASP.NET Core 8 (Razor Pages) entry point — rewrite of the WebForms port's
    /// Global.asax + web.config. Legacy routes are preserved via MapFallbackToPage:
    ///   /                      -> Pages/Index.cshtml      (default.aspx / index.php)
    ///   /Internal              -> Pages/Internal.cshtml   (internal.aspx / indexInternal.es.php)
    ///   /api, /GameAPI         -> minimal-API endpoints   (api.ashx / GameAPI.ashx handlers)
    /// </summary>
    public static class Program
    {
        public static void Main(string[] args)
        {
            var builder = WebApplication.CreateBuilder(args);

            // --- Global.asax.Application_Start equivalent ---
            AppConfig.Initialize(builder.Configuration);
            AppConfig.ResolveHostNames(null); // default host from config (per-request override in middleware)
            try { AppConfig.TimeZone = TimeZoneInfo.FindSystemTimeZoneById(AppConfig.Get("TimeZone", "UTC")); }
            catch (TimeZoneNotFoundException) { AppConfig.TimeZone = TimeZoneInfo.Utc; }

            builder.Services.AddRazorPages(o => o.RootDirectory = "/Pages");
            builder.Services.AddDistributedMemoryCache();          // session storage (was InProc SessionState)
            builder.Services.AddSession();
            builder.Services.AddHttpContextAccessor();
            builder.Services.AddSingleton<AppEnvironment>();        // ambient context (was HttpContext.Current)

            var app = builder.Build();

            app.UseStaticFiles();                                   // was IIS static file handler
            app.UseRouting();
            app.UseSession(new SessionOptions
            {
                IdleTimeout = TimeSpan.FromMinutes(20),             // was sessionState timeout="20"
                Cookie = new CookieBuilder
                {
                    Name = "ASPSESSIONIDQSCBTRQT",                 // legacy PHP session cookie name parity
                    HttpOnly = true,
                    IsEssential = true,
                    SameSite = SameSiteMode.Lax
                }
            });
            app.UseMiddleware<AppEnvironmentMiddleware>();          // sets AppEnvironment.Current.Context

            // per-request host resolution (was Init.php using SERVER_NAME each request)
            app.Use(async (ctx, next) =>
            {
                AppConfig.ResolveHostNames(ctx.Request.Host.Host);
                await next();
            });

            // --- URL rewrite rules from web.config (.php/.es.php legacy paths) ---
            app.MapFallbackToPage("/Index");
            app.Map("/indexInternal.es.php", (HttpContext ctx) =>
            {
                ctx.Response.Redirect("/Internal" + ctx.Request.QueryString);
                return System.Threading.Tasks.Task.CompletedTask;
            });

            // api.ashx (XML-RPC IXR_Server) — IHttpHandler -> endpoint
            app.MapPost("/api", ApiEndpoints.ServeAsync);
            app.MapPost("/api.ashx", ApiEndpoints.ServeAsync);

            // GameAPI.ashx — IHttpHandler -> endpoint
            app.Map("/GameAPI", GameAPIEndpoint.Handle);
            app.Map("/GameAPI.ashx", GameAPIEndpoint.Handle);

            // ajax/nanoTechfactory/techShop.ashx -> /Ajax/TechShop
            app.Map("/ajax/nanoTechfactory/techShop.php", TechShopEndpoint.Handle);
            app.Map("/Ajax/TechShop", TechShopEndpoint.Handle);

            app.Run();
        }
    }
}
