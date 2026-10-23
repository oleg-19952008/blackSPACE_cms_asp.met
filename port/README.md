# План портирования по «кускам» (chunk-by-chunk porting plan)

Единица работы = **один целый класс** (если он небольшой, ≤ ~300 строк PHP) либо
**одна группа методов большого класса** (если класс огромный). Каждый кусок —
отдельный коммит с проверкой компиляции в CI (`dotnet build port/CoreCore.csproj`).

Платформа порта: **ASP.NET Core 8** (Razor Pages + minimal API, `port/CoreCore.csproj`, `net8.0`).
Классы лежат в `port/Models/`, страницы — `port/Pages/`, AJAX/API-эндпоинты — `port/Services/`.

Обозначения статусов:
- ✅ — уже портировано
- ⬜ — не портировано
- 🔶 — портировано частично / требует доделки

Отправная точка (обновлено 2026-10-23, проверено по факту в репозитории):
- Диспетчер `Pages/Internal.cshtml.cs` (**1136 строк**): переведены с заглушек на реальную логику +
  единый рендер через `PhpTemplateRenderer.RenderShell` **все ~45 ветвей action** оригинала
  (`internalStart…internalDock*`, Clan-группа c подветками Administrate/ChangeFirm/Diplomacy/Member,
  Skylab/Board/NanoTechFactory, Auction, Balance/Evoucher, Messaging/PilotSheet/UserDataChange/
  ItemUpgradeSystem, External/History/Promo, Dock + MapRevolution/burnme; `internalHandelClosed` —
  корректно помечен мёртвым и не рендерится); в файле осталось 2 TODO — оба фаза C
  (шаблоны CompanyChoose_Body, internalSkylab_Body);
- ✅ B2 выполнена: `Services/PhpTemplateRenderer.cs` (163 стр.) — `RenderShell`/`RenderBody`;
  GLOBALS-фрагменты перенесены в `templates/legacy/en_US/GLOBAL/` (ads, headerEndJS, internalDoc,
  internalDocEnd, internalHeader, internalMenu, sajax, xajax — 8 файлов); ad-hoc `RenderInternalPage` удалён;
- ✅ созданы и заполнены `Models/Clan.cs` (870), `Skylab.cs` (1325), `Inventory.cs` (2165),
  `Shop.cs` (736), `Rank.cs` (685) + `RankPager.cs` (154), `GalaxyGate.cs` (668), `Ships.cs` (54);
- ✅ A7.3: xajax/sajax хендлеры — `Services/XajaxResponse.cs` (72) + `Services/AjaxHandlers.cs` (385),
  зарегистрированы в Program.cs (`POST /xajaxAPI.php`, `/Ajax/xajax`, `/sajaxAPI.php`, `/Ajax/sajax`);
- портированы также: Core, DB, Encryption, SessionManager, Users, AppConfig, TemplateManager,
  Unity(685), Auction(642), Factory(545), Base(515), DailyBonus, Voucher, Hangar, Signup, News,
  PlayerLog, IxrServer, PhpMailer/UnityMailer, JsonUtil, RegisterProvisioning.

---

## Фаза A — Классы-зависимости диспетчера internal 🔶 (~90%)

Диспетчер `indexInternal.es.php` вызывает эти классы напрямую; без них ветки
`action` не собрать. Большие классы режем по связным группам методов.

### A1. `Class.clan.php` (757 стр.) → `Models/Clan.cs` (870 стр.) — ✅ (остатки сверить)
| Кусок | Методы (строки оригинала) | Статус |
|---|---|---|
| A1.1 Каркас + деньги/поиск | `__construct`, `setId`, `money`, `getUser`, `clanVoid`, `getClans`, `getMyClan`, `GetClanLeader`, `getClanName`, `getClanTag`, `getType` | ✅ |
| A1.2 Основание/роспуск клана | `foundClan`, `regClan`, `regMyClan`, `getMyNewClan`, `deleteClan`, `deleteClanNow`, `deleteClanDiplomacy`, `deleteAps`, `changeFirm`, `pullUri` | ✅ |
| A1.3 Состав | `join`, `applyMember`, `deleteMember`, `runNewInfo`, `indentNewMember`, `setUsersClan`, `reUsersClan`, `updateMembers`, `removeMembers`, `loadMembers`, `getMembers`, `GetApplicantNames`, `getApplicants`, `getPending` | ✅ |
| A1.4 Дипломатия | `postDiplomacy`, `setDiplomacy`, `stopWarRequest`, `acceptRequest` и remainder | 🔶 51/53 метода сверены, remainder проверить |

### A2. `Class.Skylab.php` (2212 стр.) → `Models/Skylab.cs` (1325 стр.) — ✅ (кроме pretty_time)
| Кусок | Методы (строки оригинала) | Статус |
|---|---|---|
| A2.1 Каркас + init | `__construct`, `getSiteData`, `getOutput`, `setId`, `money`, `initSkylab` (1–358) | ✅ |
| A2.2 Ресурсы | `ressupdate` (359–520) | ✅ |
| A2.3 UI-логика сборки | `displayBuild`, `setStatus` (521–683) | ✅ |
| A2.4 Стоимость апгрейдов | `req_ress`, `showModule` (684–1202) | ✅ |
| A2.5 Данные | `getAllData` (1203–1404) | ✅ |
| A2.6 Формулы | `energy_production`, `ressource_generation`, `energy_usage`, `energy_all_usage`, `storage`, `pretty_time`, `upgrade_time`, `upgrade_cost` (1405–2212) | 🔶 кроме `pretty_time` |

### A3. `Class.inventory.php` (1736 стр.) → `Models/Inventory.cs` (2165 стр.) — ✅ (50/52 метода)
| Кусок | Методы (строки оригинала) | Статус |
|---|---|---|
| A3.1 Каркас/транзакции | `__construct`, `setId`, `init`, `CompleteTrans`, `errorTrans`, `checkMinus`, геттеры | ✅ |
| A3.2 Продажа | `renamePet`, `setName`, `cashOut`, `checkDB`, `sell`, `checkItemsOwnerShip`, `DelDrone`, `sellDrone`, `wipeDrone`, `wipeConfigs`, `changeShipModel` | ✅ |
| A3.3 БД-оперы/валидация | `addToDB`, `delFromDb`, `checkInput`, `extrasExits` | ✅ |
| A3.4 CPU-слоты/полнота проверки | `cpuSlots`, `fullSystemCheck`, `shipspace`, `NotEmptyDrone`, `EmptyDrone`, `NotEmptyShip`, `EmptyShip`, `checkExtrasService` | ✅ |
| A3.5 Конфиги | `editDB`, `editJson`, `checkInConfig`, `ifExistsPet`, `ifExistsDrone`, `GetPet`, `droneconfigsGenerator`, `petconfigsGenerator`, `shipconfigsGenerator` | ✅ |
| A3.6 Ангар | `getdrone`, `allDesigns`, `hangarGeneral`, `hangarGenerator`, `itemLootIdGenerator`, `getTypes`, `getMoney`, `getMainInfo`, `getFacInfo` | ✅ |
| — | `Class.inventory_backup.php` НЕ портировать (мёртвый код) | n/a |

### A4. `Class.shop.php` (779 стр.) → `Models/Shop.cs` (736 стр.) — ✅ (30/30 public-методов)
A4.1 каркас/расчёты, A4.2 покупка юнитов, A4.3 питомцы/дроны/предметы — все куски перенесены.

### A5. `Class.rank.php` (630 стр.) → `Models/Rank.cs` (685) + `Models/RankPager.cs` (154) — ✅
A5.1 расчёт очков, A5.2 списки/ранги — ✅; A5.3 пагинатор — вынесен в `RankPager` ✅
(приватный `cust_sort` не портирован — некритично).

### A6. `Class.GalaxyGate.php` (589 стр.) → `Models/GalaxyGate.cs` (668 стр.) — ✅ (18/18 методов)
A6.1 каркас/гейты, A6.2 спиннер/мультипликаторы — перенесены.

### A7. Мелкие классы / эндпоинты
| Кусок | Оригинал | В порт | Статус |
|---|---|---|---|
| A7.1 | `Class.Ships.php` (15) | `Models/Ships.cs` | ✅ |
| A7.2 | `Class.log.php` (58) | `Models/PlayerLog.cs` | ✅ (сверить покрытие) |
| A7.3 | xajax/sajax API-эндпоинты (`GLOBAL/xajax.php` 58 + `sajax.php` 198 + `ajax/nanoTechfactory/*`) | `Services/XajaxResponse.cs` + `Services/AjaxHandlers.cs`, маршруты в `Program.cs`: `POST /xajaxAPI.php`, `/Ajax/xajax`, `/sajaxAPI.php`, `/Ajax/sajax` | ✅ (nanoTechFactoryShowApis, nanoTechFactoryShowBuff, searchUser; протоколы xjx XML и sajax +/-: совместимы) |

Остатки фазы A: `Users.changeUsername/checkName/ChangeNow` — не портированы (нужны для B6 UserDataChange).

Уже портированные крупные классы (✅) сверить на полноту public-методов,
используемых диспетчером; доделки — мелкими PR.

---

## Фаза B — Диспетчер internal 🔶 (~85% кода: все ~45 ветвей action реализованы; приёмка веток ждёт шаблоны C)

Порт `indexInternal.es.php` (732 стр.) живёт в `Pages/Internal.cshtml(.cs)`.
Зависит от фазы A (минимум A1, A2; остальное — по мере подключения веток).

### B1. Бутстрап + общие guard'ы (стр. 1–65 оригинала) — ✅
- POST→GET `action`, бутстрап в `Program.cs`/`AppConfig`;
- `checkSession()` → `Users.CheckSession` (есть);
- установка `$_SESSION['fact']`;
- ветка `internalCompanyChoose` + `factionChoose` (UPDATE factionId/mapId/x/y, редиректы) — реализована.

### B2. Механизм рендеринга оболочки — ✅
PHP повторяет один и тот же набор require на каждой ветке:
`internalDoc.php → internalDocEnd.php → sajax.php → xajax.php → headerEndJS.php → internalMenu.php → internalHeader.php → <Body-шаблон> → ads.php`.
В C# — единый `PhpTemplateRenderer.RenderShell(users, bodyTemplate, cssHref, vars, logMessage, logType)`
(`Services/PhpTemplateRenderer.cs`, 163 стр.): парсинг HTML-оболочки + токен-подстановка тела;
все ветки B3–B10 вызывают его через общий helper в `Internal.cshtml.cs`.
Ad-hoc `RenderInternalPage(...)` с legacy-заготовками в `wwwroot` удалён.
Порт шаблонных GLOBALS-фрагментов выполнен: `templates/legacy/en_US/GLOBAL/` — ads, headerEndJS,
internalDoc, internalDocEnd, internalHeader, internalMenu, sajax, xajax (8 файлов).
(xajax/sajax серверная часть — A7.3; клиентские bootstrap-скрипты подключаются здесь же.)

### B3–B10. Ветки `action` — по группе связанных экшенов
| Кусок | Экшены (строки оригинала) | Зависимости | Статус |
|---|---|---|---|
| B3 Start/Gates/JPA/Payment/HoF | `internalStart` (66–77), `internalGalaxyGates` (78–89, 116–126), `internalJPA`, `internalJPA-list` (90–115), `internalPayment` (127–137), `internalHallofFame`+view (138–160) | Rank ✅, GalaxyGate ✅ | 🔶 все ветки через RenderShell + логика; Body-шаблоны ждут C1/C6 |
| B4 Balance/Evoucher | `internalBalance` (161–171), `internalEvoucher` (172–188) | Voucher ✅ | 🔶 логика есть, ждёт C-шаблоны |
| B5 Clan-группа | `internalNewClanDetails` (189–206), `internalNewClan` (207–240), `internalClan` (241–286), `internalClanList` (287–297) + подветки Administrate/ChangeFirm/Diplomacy/Member | Clan ✅ | 🔶 логика есть, ждёт C-шаблоны |
| B6 Messaging/PilotSheet/UserData/Upgrade | `internalMessaging` (298–308), `internalPilotSheet` (309–340), `internalUserDataChange` (341–351), `internalItemUpgradeSystem` (352–362) | Base ✅, Inventory ✅ (+ Users.changeUsername — остаток A) | 🔶 логика есть, ждёт C-шаблоны |
| B7 Skylab/Board/NanoTechFactory | `internalSkylab`+subactions (363–391), `internalBoard`+subaction (392–406), `internalNanoTechFactory`+subactions (407–454) | Skylab ✅, Factory ✅ | 🔶 все три реализованы через RenderShell (Body-шаблоны — C4/C6); AJAX-часть NTF готова: A7.3 |
| B8 External/History/Promo/Logout | `externalPassword` (455–465), `internalPaymentProxy` (466–469), `externalLogout` (470–480), `internalHistory` (481–491), `internalPaymentPartnerPromotion` (492–502) | Unity ✅ | 🔶 логика есть, ждёт C-шаблоны |
| B9 Auction | `internalAuction` (503–571) | Auction ✅ | 🔶 логика есть, ждёт C-шаблоны |
| B10 Dock + MapRevolution + burnme | `internalDock` (572–717, под-экшены ship/ammo/laser/drone/generator/booster/special/equipment/model), `internalMapRevolution` (718–726), `burnme` (727–732) | Shop ✅, Inventory ✅, Hangar ✅ | 🔶 логика есть, ждёт C-шаблоны |

### B11. Routing и завершение — 🔶
- Legacy URL `indexInternal.es.php?action=X` → страница `/Internal` — реализовано в `Program.cs` ✅;
- smoke-тест всех action через HTTP-запросы на staging — 🔶 (схема `port/sql/smoke-schema.sql` + тестовый пользователь/сессия — см. ниже);
- сборка в CI (`dotnet build port/CoreCore.csproj`) — ✅ (.NET 8 SDK, 0 ошибок, 13 предупреждений —
  CS0168/CS0169/CS0649/CS0414 неиспользуемые поля в Inventory/Skylab/Factory + SYSLIB0021 AesManaged
  в Encryption; фикс Clan.GetPager: чтение формы только при `request.HasFormContentType`,
  хелперы `AppEnvironment.GetFormValue/GetQueryValue`).

---

## Фаза C — Шаблоны Body 🔶 (начата: C1 + PilotSheet из C6 перенесены; схема подтверждена)

Рендерятся диспетчером через `PhpTemplateRenderer.RenderShell`; идут за своими ветками B.
Каталог `templates/legacy/en_US/INDEXINTERNAL/` создан; схема подтверждена на C1: чистый HTML-шаблон
(verbatim из оригинала, PHP-вставки → токены `{{TOKEN}}`, positionальные require GLOBALS → токены
`{{HELP_NEWS_INCLUDE}}`/`{{HEADER_INTERN_INCLUDE}}`, заполняются через `FillFragment`) + токен-префиксы
в C# (`HandleInternalStart` и пр.). Остальные Body-рендеры — заглушка «Template pending phase C»
(`PhpTemplateRenderer.cs:108`).

| Приоритет | Шаблон (`FILES/INDEXINTERNAL/`) | Строк | Привязка | Статус |
|---|---|---|---|---|
| C1 | `internalStart_Body.php` | 685 | B3 | ✅ перенесён (`internalStart_Body.html`, 439 стр., 28 токенов; + GLOBALS internalHelpLayer/internalNews/internalHeaderIntern) |
| C2 | `CompanyChoose_Header/_Body.php` | ~200 | B1 | ⬜ |
| C2b | `externalLogout_Body.php` | 7 | B8 | ✅ verbatim-перенос; `session_destroy()` → `HttpContext.Session.Clear()` в ветке диспетчера (рендерится напрямую, без Shell — как в оригинале) |
| C3 | `internalClan_Body.php`, `internalNewClan_Body.php`, `internalNewClanDetails_Body.php`, ~~`internalClanList_Body.php`~~ ✅ | ~1900 | B5 | 🔶 ClanList ✅ (`internalClanList_Body.html` + `HandleClanListVars`: setId/getClans/paginate('clanlist_navi')/cust_sort по `?sort=`/start-end цикл); остальные ⬜ |
| C4 | `internalSkylab_Body.php` | 1601 | B7 (резать по таб-секциям: overview/modules/resources/upgrades; зависит от остатка A — Skylab.pretty_time) | ⬜ |
| C5 | `internalDock_Body.php` + `internalDock{Ships,Ammo,Laser,Drones,Generator,Booster,Specials,Equipment,ShipModel,PetGear,PetProtocols}_Body.php` | ~7000 суммарно | B10, по одному файлу за коммит | ⬜ |
| C6 | `internalAuction_Body.php`, `internalBoard.php`, ~~`internalPilotSheet_Body.php`~~ ✅, `internalMessaging_Body.php`, `internalBalance_Body.php`, `internalEvoucher_Body.php`, ~~`internalHistory_Body.php`~~ ✅, `internalPayment*_Body.php`, `internalHallofFame_*` (5 файлов), `internalGalaxyGates_Body.php`, ~~`internalJPA*_Body.php`~~ ✅, `internalNanoTechFactory_Body.php`, `internalClanAdministrate/ChangeFirm/Diplomacy/Member_Body.php`, `internalUserDataChange_Body.php`, `internalItemUpgradeSystem_Body.php` | 300–970 каждый | соответствующие B3–B9 | 🔶 PilotSheet ✅ (`internalPilotSheet_Body.html`, 889 стр.; `HandlePilotSheetVars` — порт преамбулы GetRank/getMyRanking/getMyClan + STATION/CLAN_NAME/MYRANKING/EMAIL; credits.php вырезан — нет в наборе GLOBALS); History ✅ (`internalHistory_Body.html` + `HandleHistoryVars`: PlayerLog.SetId/GetLog → `{{HISTORY_ROWS}}`); JPA+JPA-list ✅ (`internalJPA_Body.html`/`internalJPA-list_Body.html` + `HandleJpaVars`/`HandleJpaListVars`: mysqli jackpot/id/war-запросы параметризованы → `{{JPA_BALANCE}}`/`{{JPA_FORM_FIELDS}}`/`{{JPA_LIST_ITEMS}}`); остальные ⬜ |
| C-исключения | `internalHandelClosed_Body.php` (6758 — закрытый раздел, не портировать), `_NE_ISPOLZUETSJA/**`, файлы с суффиксами `— копия`, `- Copy`, `_old`, `internaltest.php`, `internalMaptest.php`, `internalDockEquipment_Bod2y.php`, `internalDockLaser_Body2.php`, `internalGalaxyGates_Body1.php` | — | удалить из плана |

---

## Порядок выполнения (сжатый roadmap)

1. ~~A1 (Clan) → A2 (Skylab) → A3–A6~~ — выполнены (остатки: Users.change*, pretty_time, Clan remainder)
2. ~~B1 + B2 (RenderShell/PhpTemplateRenderer + GLOBALS-фрагменты)~~ — ✅ выполнены
3. ~~B3–B10 логика веток~~ — ✅ все ~45 ветвей реализованы через RenderShell; закрытие веток
   (статус ✅) возможно только вместе с их Body-шаблонами из фазы C
4. **C-шаблоны — текущий приоритет №1** (~~C1 internalStart_Body~~ ✅, ~~internalPilotSheet_Body~~ ✅ →
   далее C4 internalSkylab_Body → C5 Dock → C3/C6 остальное); ветка B считается готовой только с рендером;
   доделать 2 TODO в `Internal.cshtml.cs` (CompanyChoose_Body, internalSkylab_Body)
5. ~~A7 (xajax/sajax handlers)~~ ✅; клиентские bootstrap в оболочке — ✅ (B2); осталось: остаток A
   (Users.changeUsername/checkName/ChangeNow для B6, Skylab.pretty_time для C4) и B11 smoke-прогон всех action
6. MIGRATION.md / README.md: обновлять статусы Часть 2/3 по факту merge каждого куска

Критерии приёмки куска: компиляция в CI (`dotnet build port/CoreCore.csproj`) + parity-тест метода против PHP
(одинаковые входные данные → одинаковый SQL/вывод) + отсутствие `TODO` в публичном API.
