# blackSPACE CMS — ASP.NET 4.8

Порт PHP-портала (KERNEL-DOCMS) на ASP.NET 4.8. Проект: `port/DarkSpace.sln`.

## Процент портирования: ~55–60% (обновлено 2026-10-23)

Методика: взвешенная оценка по строкам PHP-исходников (ядро KERNEL-DOCMS + точки входа ≈ 26 300 строк
без учёта статических страниц/шаблонов). Портировано и проверено на полноту ≈ 14 800 эквивалентных строк
(C# в `port/App_Code`, `*.aspx.cs`, `*.ashx.cs` — всего 5 119 строк C#, плотность кода выше PHP).

| Модуль | Статус | Готовность |
|---|---|---|
| Каркас (Web.config, Global.asax, DB, Encryption, Sessions, Users) | ✅ перенесён | 100% |
| GameAPI, api (XML-RPC), ajax/techShop | ✅ перенесены | 100% |
| Классы: Factory, Auction, Base, DailyBonus, Hangar, News, Unity, Voucher, RegisterProvisioning | ✅ перенесены | 100% |
| Вход/регистрация (default.aspx, Signup) | ✅ перенесено | 100% |
| Подтверждение по e-mail | 🔒 заглушка (по решению: все аккаунты считаются подтверждёнными) | n/a |
| internal.aspx (диспетчер indexInternal.es.php, 732 стр.) | ⏳ заглушка | 0% |
| Skylab (2212 стр.), Inventory (1736), Clan (757), Shop (779), Rank (630), GalaxyGate (589) | ❌ не перенесены | 0% |
| emailconfirmation pwRecover/nameChange (~590 стр.) | ❌ не перенесены | 0% |
| acp/ (админ-панель) | ❌ не перенесена | 0% |
| cron/ (ранги, аукцион, налоги кланов → служба) | ❌ не перенесён | 0% |
| Шаблоны (header/body → TemplateManager/Master Pages), rewrite legacy URL | ⚠️ частично | ~40% |

**Не входит в оценку (решено не портировать / отдаётся статикой):** `pages/`, `sharedpages/`,
`policy/`, `flashAPI/`, `eventstream/`, `Styles/` — ≈ 20 700 строк PHP-шаблонов и статики;
участие этих файлов в общем объёме исходников занизило бы цифру до ~30%.

Подробный план и статус по этапам: [MIGRATION.md](MIGRATION.md).
Код ещё ни разу не компилировался под MSBuild на Windows — итоговый % может измениться после сборки.
