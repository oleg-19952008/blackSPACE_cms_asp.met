# Миграция PHP (KERNEL-DOCMS) → ASP.NET Core 8

Порт старого PHP-портала (index.php + KERNEL-DOCMS) на **ASP.NET Core 8**
(Razor Pages + minimal API, проект `port/CoreCore.csproj`, `net8.0`).
Исходники PHP остаются в репозитории как reference до завершения миграции.

> Исторически порт начинался как ASP.NET 4.8 WebForms (Web.config/Global.asax/.aspx/.ashx);
> впоследствии проект переведён на ASP.NET Core 8 Razor Pages. Структура ниже — фактическая.

## Структура порта
- `port/Program.cs` — бутстрап приложения (аналог Global.asax + Init.php): таймзона Europe/Moscow,
  maintenance-флаг (503), разрешение хостов SERVER/HOST/sSERVER, cookie-сессия с именем PHP-`session.name`
  (`MTI3LjAuMC4x`), legacy-rewrite `indexInternal.es.php` → `/Internal`, регистрация minimal-API эндпоинтов.
- `port/appsettings.json` — перенос `Server.Config.php` + `Init.php` (URL/MySQL/session/maintenance).
- `port/Pages/Index.cshtml(.cs)` — каркас index.php (ветки recoverTrue, логин, signup).
- `port/Pages/Internal.cshtml(.cs)` — диспетчер indexInternal.es.php (в процессе, см. PORTING-PLAN фаза B).
- `port/Models/*.cs` — классы KERNEL-DOCMS (AppConfig, Core, DB, Encryption, SessionManager, Users,
  Unity, Clan, Skylab, Inventory, Shop, Rank+RankPager, GalaxyGate, Ships, Factory, Auction, Base,
  DailyBonus, Hangar, News, Voucher, PlayerLog, IxrServer, PhpMailer/UnityMailer, JsonUtil,
  TemplateManager, RegisterProvisioning).
- `port/Services/*.cs` — точки входа: GameAPIEndpoint, ApiEndpoints (XML-RPC), TechShopEndpoint,
  SignupLogic, AppEnvironment, а также A7.3: XajaxResponse + AjaxHandlers (xajax/sajax).

## План: 4 части

### Часть 1 — Каркас приложения ✅
- AppConfig/DB (PDO-singleton → `GetInstance`, mysqli → `GetMySQLi`; все запросы параметризованы),
  Encryption (AES-128-ECB, формат base64(IV+ct) совместим), SessionManager (структура
  `$_SESSION['server1']['user']`, errorData, AntiHTML/SQL санитайзеры), Users::CheckSession (+ DataRow).
- GameAPI, api (XML-RPC), ajax/techShop — перенесены как minimal-API эндпоинты.

### Часть 2 — Доменные классы KERNEL-DOCMS 🔶 (~90%)
Перенесены: unity, reg/signup, shop, base, clan, rank, auction, log, voucher, factory, Hangar,
Skylab, GalaxyGate, dailybonus, news, inventory. Остатки: Users.changeUsername/checkName/ChangeNow,
Skylab.pretty_time, Clan remainder/diplomacy-хвосты — см. PORTING-PLAN (Фаза A).

### Часть 3 — Страницы и API 🔶 (~30%)
Выполнено: default/Index (вход/регистрация), A7.3 xajax/sajax AJAX-эндпоинты
(`POST /xajaxAPI.php`, `/Ajax/xajax`, `/sajaxAPI.php`, `/Ajax/sajax`), rewrite legacy URL.
В процессе: диспетчер internal (PORTING-PLAN Фаза B, 7 из ~44 action).
Не перенесены: acp/, emailconfirmation/ (pwRecover/nameChange), cron/ (→ BackgroundService/служба),
pages/, sharedpages/, policy/, eventstream/, flashAPI/ (решено: статика/не портировать).
PHPMailer → PhpMailer.cs/UnityMailer.cs (учётные данные SMTP — в конфигурацию/секретное хранилище).

### Часть 4 — Шаблоны, статика и cutover ⬜
Templates `FILES/GLOBALS/*/header|body.php` и `FILES/INDEXINTERNAL/*` → Razor-страницы/парциалы
+ PhpTemplateRenderer (PORTING-PLAN Фаза C — не начата), проверка css/js/resources/webfonts/swf_global,
настройка reverse-proxy/Kestrel, приёмочное тестирование, удаление PHP-наследия.

## Известные расхождения / техдолг
- ECB + IV в начале ciphertext унаследован из PHP для совместимости с уже записанными pwHash;
  после сброса паролей пользователей мигрировать на AES-CBC/GCM.
- `DB::safe()` оставлен только для parity; новый код обязан использовать параметры.
- Пароль SMTP был захардкожен в index.php — перенести в защищённую конфигурацию.
- Тестовой сборки в контейнере нет (dotnet SDK отсутствует); компиляцию проверять в CI
  (`dotnet build port/CoreCore.csproj`).
