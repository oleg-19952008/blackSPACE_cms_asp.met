# blackSPACE CMS — ASP.NET Core 8

Порт PHP-портала (KERNEL-DOCMS) на **ASP.NET Core 8** (Razor Pages + minimal API).
Проект: `port/CoreCore.csproj` (`net8.0`). Приложение: `port/Program.cs`, страницы — `port/Pages/`,
классы — `port/Models/`, AJAX/API-эндпоинты — `port/Services/`.

> Исторически порт начинался как ASP.NET 4.8 WebForms; впоследствии проект мигрирован
> на ASP.NET Core 8 Razor Pages. Устаревшие упоминания WebForms в старых заметках игнорировать.

## Процент портирования: ~50% (обновлено 2026-10-23)

Методика: взвешенная оценка по строкам PHP-исходников ядра и точек входа (≈ 26 300 строк
без статических страниц/шаблонов). На сегодня в C# ≈ 13 000 строк (`port/Models` ≈ 11 200,
`port/Services` + `port/Pages` + `Program.cs` ≈ 1 800).

| Модуль | Статус | Готовность |
|---|---|---|
| Каркас (Program.cs, AppConfig, DB, Encryption, SessionManager, Users) | ✅ перенесён | 100% |
| GameAPI, api (XML-RPC), ajax/techShop | ✅ перенесены | 100% |
| xajax/sajax AJAX-эндпоинты (A7.3): `Services/XajaxResponse.cs`, `Services/AjaxHandlers.cs` (nanoTechFactoryShowApis, nanoTechFactoryShowBuff, searchUser) | ✅ перенесены | 100% |
| Классы: Factory, Auction, Base, DailyBonus, Hangar, News, Unity, Voucher, RegisterProvisioning | ✅ перенесены | 100% |
| Классы фазы A: Clan(865), Skylab(1325), Inventory(2165), Shop(736), Rank(685)+RankPager, GalaxyGate(668), Ships | ✅ перенесены | ~90% (не портированы Users.changeUsername/checkName/ChangeNow, Skylab.pretty_time, Clan remainder) |
| Вход/регистрация (Pages/Index, Signup) | ✅ перенесено | 100% |
| Подтверждение по e-mail | 🔒 заглушка (по решению: все аккаунты считаются подтверждёнными) | n/a |
| Диспетчер internal (`Pages/Internal.cshtml.cs`, порт indexInternal.es.php, 732 стр.) | 🔶 портировано 7 из ~44 action (CompanyChoose, Skylab, Start/Gates/JPA/Payment — render-заглушки, HallofFame) | ~25% |
| emailconfirmation pwRecover/nameChange (~590 стр.) | ❌ не перенесены | 0% |
| acp/ (админ-панель) | ❌ не перенесена | 0% |
| cron/ (ранги, аукцион, налоги кланов → служба) | ❌ не перенесён | 0% |
| Шаблоны Body (`templates/INDEXINTERNAL/*`) | ❌ каталог не создан (фаза C) | ~0% |
| Rewrite legacy URL (`indexInternal.es.php` → `/Internal`) | ✅ есть в Program.cs | 100% |

**Не входит в оценку (решено не портировать / отдаётся статикой):** `pages/`, `sharedpages/`,
`policy/`, `flashAPI/`, `eventstream/`, `Styles/` — ≈ 20 700 строк PHP-шаблонов и статики;
участие этих файлов в общем объёме исходников занизило бы цифру до ~30%.

Подробный план и статус по этапам: [MIGRATION.md](MIGRATION.md), чанк-план: [PORTING-PLAN.md](PORTING-PLAN.md).
Код ни разу не собирался (dotnet SDK отсутствует в контейнере разработки) — итоговый % может
измениться после первой сборки и parity-тестов.
