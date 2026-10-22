# Миграция PHP (KERNEL-DOCMS) → ASP.NET 4.8

Порт старого PHP-портала (index.php + KERNEL-DOCMS) на ASP.NET 4.8 (WebForms, classic pipeline).
Исходники PHP остаются в репозитории как reference до завершения миграции.

## План: 4 части

### Часть 1 — Каркас приложения ✅ (текущий коммит)
- `DarkSpace.sln` / `DarkSpace.csproj` — проект ASP.NET 4.8 (net48, IIS-hosted).
- `Web.config` — перенос `Server.Config.php` + `Init.php` (URL/MySQL/session/maintenance) в appSettings;
  cookie сессии названа как PHP-`session.name` (`MTI3LjAuMC4x`).
- `Global.asax(.cs)` — аналог бутстрапа `Init.php`: таймзона Europe/Moscow, maintenance-флаг (503),
  разрешение хостов SERVER/HOST/sSERVER.
- `App_Code/AppConfig.cs` — `$Config['URL'|'MySQL']`, константы DynHost, FILES/GLOBALS (Lang).
- `App_Code/Core.cs` — `Class.Core.php` (GenerateRandom).
- `App_Code/DB.cs` — `Class.db.php`: два канала соединений (PDO-singleton → `GetInstance`, mysqli → `GetMySQLi`),
  setLog/pmc/safe/getUserIP. Все запросы — параметризованные.
- `App_Code/Encryption.cs` — `Class.Encryption.php` (AES-128-ECB, формат base64(IV+ct) сохранён совместимым).
- `App_Code/SessionManager.cs` — структура `$_SESSION['server1']['user']`, `errorData`,
  AntiHTML/SQL санитайзер из конца Init.php.
- `App_Code/Users.cs` — `Class.Users.php::checkSession()` (+ DataRow).
- `default.aspx(.cs)` — каркас index.php: ветки `recoverTrue` и логина `loginForm_default_*` полностью,
  регистрация — в части 3.
- `GameAPI.ashx(.cs)` — полный порт `GameAPI.php`.

### Часть 2 — Доменные классы KERNEL-DOCMS
`Class.unity.php` (cPT, get_client_ip, passwordRecovery, registerNewAccount/updateAccount/regAmmo),
`Class.reg.php`, `Class.shop.php`, `Class.base.php`, `Class.clan.php`, `Class.rank.php`,
`Class.auction.php`, `Class.log.php`, `Class.voucher.php`, `Class.factory.php`, `Class.Hangar.php`,
`Class.Skylab.php`, `Class.GalaxyGate.php`, `Class.dailybonus.php`, `Class.news.php`, `Class.inventory.php`.

### Часть 3 — Страницы и API
`indexInternal.es.php`, `ajax/`, `api/`, `acp/`, `emailconfirmation/`, `pages/`, `sharedpages/`,
`policy/`, `cron/` (→ ConsoleApp/Windows Service), `eventstream/`, `flashAPI/`;
PHPMailer → SmtpClient (учётные данные вынести в Web.config/секретное хранилище).
Ветка регистрации (signup_*) из index.php дорабатывается здесь же.

### Часть 4 — Шаблоны, статика и cutover
Templates `FILES/GLOBALS/*/header|body.php` → Master Pages + .aspx,
проверка css/js/resources/webfonts/swf_global, rewrite-политика (чистые URL убраны — см. комментарий в Web.config),
настройка IIS/Application Pool, приёмочное тестирование, удаление PHP-наследия.

## Детальный план по кускам
См. [PORTING-PLAN.md](PORTING-PLAN.md) — разбивка миграции на атомарные коммиты
(целые небольшие классы либо группы методов огромных классов: Clan, Skylab, Inventory, Shop, Rank, GalaxyGate),
ветки диспетчера `internal.aspx` и шаблоны Body с указанием строк оригинала и зависимостей.

## Известные расхождения / техдолг
- ECB + IV в начале ciphertext унаследован из PHP для совместимости с уже записанными pwHash;
  после сброса паролей пользователей мигрировать на AES-CBC/GCM.
- `DB::safe()` оставлен только для parity; новый код обязан использовать параметры.
- Пароль SMTP был захардкожен в index.php — при портировании (часть 3) перенести в защищённую конфигурацию.
- Тестовой сборки в контейнере нет (dotnet/msbuild отсутствуют); компиляцию проверять на Windows-хосте CI.
