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
- Диспетчер `Pages/Internal.cshtml.cs` (~600 строк): портированы B1-бутстрап и 7 из ~44 action
  (internalCompanyChoose+factionChoose, internalSkylab со всеми subaction, Start/Gates/JPA/Payment —
  render-заглушки, internalHallofFame с реальной логикой Rank); остальные ветки — заглушки;
- ✅ созданы и заполнены `Models/Clan.cs` (865), `Skylab.cs` (1325), `Inventory.cs` (2165),
  `Shop.cs` (736), `Rank.cs` (685) + `RankPager.cs` (154), `GalaxyGate.cs` (668), `Ships.cs` (54);
- ✅ A7.3: xajax/sajax хендлеры — `Services/XajaxResponse.cs` (72) + `Services/AjaxHandlers.cs` (363),
  зарегистрированы в Program.cs (`POST /xajaxAPI.php`, `/Ajax/xajax`, `/sajaxAPI.php`, `/Ajax/sajax`);
- портированы также: Core, DB, Encryption, SessionManager, Users, AppConfig, TemplateManager,
  Unity(685), Auction(642), Factory(545), Base(515), DailyBonus, Voucher, Hangar, Signup, News,
  PlayerLog, IxrServer, PhpMailer/UnityMailer, JsonUtil, RegisterProvisioning.

---

## Фаза A — Классы-зависимости диспетчера internal 🔶 (~90%)

Диспетчер `indexInternal.es.php` вызывает эти классы напрямую; без них ветки
`action` не собрать. Большие классы режем по связным группам методов.

### A1. `Class.clan.php` (757 стр.) → `Models/Clan.cs` (865 стр.) — ✅ (остатки сверить)
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

## Фаза B — Диспетчер internal 🔶 (~25%: 7 из ~44 action)

Порт `indexInternal.es.php` (732 стр.) живёт в `Pages/Internal.cshtml(.cs)`.
Зависит от фазы A (минимум A1, A2; остальное — по мере подключения веток).

### B1. Бутстрап + общие guard'ы (стр. 1–65 оригинала) — ✅
- POST→GET `action`, бутстрап в `Program.cs`/`AppConfig`;
- `checkSession()` → `Users.CheckSession` (есть);
- установка `$_SESSION['fact']`;
- ветка `internalCompanyChoose` + `factionChoose` (UPDATE factionId/mapId/x/y, редиректы) — реализована.

### B2. Механизм рендеринга оболочки — ⬜
PHP повторяет один и тот же набор require на каждой ветке:
`internalDoc.php → internalDocEnd.php → sajax.php → xajax.php → headerEndJS.php → internalMenu.php → internalHeader.php → <Body-шаблон> → ads.php`.
В C# — единый `RenderShell(string bodyTemplate, IDictionary<string,string> vars)` в
`TemplateManager`/новом `PhpTemplateRenderer.cs`: парсинг HTML-оболочки + токен-подстановка тела.
Сейчас вместо него — ad-hoc `RenderInternalPage(...)` с legacy-заготовками в `wwwroot` (3 TODO).
Порт шаблонных GLOBALS-фрагментов (`internalDoc*`, `internalMenu`, `internalHeader`,
`sajax/xajax`, итого ~1100 стр., см. `Files/en_US/GLOBAL/`) — внутри этого куска, по одному файлу за коммит.
(xajax/sajax серверная часть уже готова — A7.3; клиентские bootstrap-скрипты подключаются здесь.)

### B3–B10. Ветки `action` — по группе связанных экшенов
| Кусок | Экшены (строки оригинала) | Зависимости | Статус |
|---|---|---|---|
| B3 Start/Gates/JPA/Payment/HoF | `internalStart` (66–77), `internalGalaxyGates` (78–89, 116–126), `internalJPA`, `internalJPA-list` (90–115), `internalPayment` (127–137), `internalHallofFame`+view (138–160) | Rank ✅, GalaxyGate ✅ | 🔶 HallofFame — реальная логика; Start/Gates/JPA/Payment — render-заглушки (ждут C1/C-шаблоны) |
| B4 Balance/Evoucher | `internalBalance` (161–171), `internalEvoucher` (172–188) | Voucher ✅ | ⬜ |
| B5 Clan-группа | `internalNewClanDetails` (189–206), `internalNewClan` (207–240), `internalClan` (241–286), `internalClanList` (287–297) | Clan ✅ | ⬜ |
| B6 Messaging/PilotSheet/UserData/Upgrade | `internalMessaging` (298–308), `internalPilotSheet` (309–340), `internalUserDataChange` (341–351), `internalItemUpgradeSystem` (352–362) | Base ✅, Inventory ✅ (+ Users.changeUsername — остаток A) | ⬜ |
| B7 Skylab/Board/NanoTechFactory | `internalSkylab`+subactions (363–391), `internalBoard`+subaction (392–406), `internalNanoTechFactory`+subactions (407–454) | Skylab ✅, Factory ✅ | 🔶 internalSkylab — реализован (без шаблона Body, C4); Board/NanoTechFactory — ⬜ (AJAX-часть NTF готова: A7.3) |
| B8 External/History/Promo/Logout | `externalPassword` (455–465), `internalPaymentProxy` (466–469), `externalLogout` (470–480), `internalHistory` (481–491), `internalPaymentPartnerPromotion` (492–502) | Unity ✅ | ⬜ |
| B9 Auction | `internalAuction` (503–571) | Auction ✅ | ⬜ |
| B10 Dock + MapRevolution + burnme | `internalDock` (572–717, под-экшены ship/ammo/laser/drone/generator/booster/special/equipment/model), `internalMapRevolution` (718–726), `burnme` (727–732) | Shop ✅, Inventory ✅, Hangar ✅ | ⬜ |

### B11. Routing и завершение — 🔶
- Legacy URL `indexInternal.es.php?action=X` → страница `/Internal` — реализовано в `Program.cs` ✅;
- smoke-тест всех action через HTTP-запросы на staging — ⬜ (ждёт завершения B3–B10);
- сборка в CI (`dotnet build`) — ни разу не выполнялась (SDK недоступен в dev-контейнере) ⬜.

---

## Фаза C — Шаблоны Body ⬜ (не начата)

Рендерятся диспетчером; идут за своими ветками B. Каталог `templates/INDEXINTERNAL/` в порту не создан.
Каждый файл = один кусок (HTML+PHP-вставки → `.html`-шаблон с токенами `{...}` + кодоген в `PhpTemplateRenderer`):

| Приоритет | Шаблон (`FILES/INDEXINTERNAL/`) | Строк | Привязка |
|---|---|---|---|
| C1 | `internalStart_Body.php` | 685 | B3 |
| C2 | `CompanyChoose_Header/_Body.php` | ~200 | B1 |
| C3 | `internalClan_Body.php`, `internalNewClan_Body.php`, `internalNewClanDetails_Body.php`, `internalClanList_Body.php` | ~1900 | B5 |
| C4 | `internalSkylab_Body.php` | 1601 | B7 (крупнейший живой шаблон — резать по таб-секциям: overview/modules/resources/upgrades) |
| C5 | `internalDock_Body.php` + `internalDock{Ships,Ammo,Laser,Drones,Generator,Booster,Specials,Equipment,ShipModel,PetGear,PetProtocols}_Body.php` | ~7000 суммарно | B10, по одному файлу за коммит |
| C6 | `internalAuction_Body.php`, `internalBoard.php`, `internalPilotSheet_Body.php`, `internalMessaging_Body.php`, `internalBalance_Body.php`, `internalEvoucher_Body.php`, `internalHistory_Body.php`, `internalPayment*_Body.php`, `internalHallofFame_*` (5 файлов), `internalGalaxyGates_Body.php`, `internalJPA*_Body.php`, `internalNanoTechFactory_Body.php`, `internalClanAdministrate/ChangeFirm/Diplomacy/Member_Body.php`, `internalUserDataChange_Body.php`, `internalItemUpgradeSystem_Body.php` | 300–970 каждый | соответствующие B3–B9 |
| C-исключения | `internalHandelClosed_Body.php` (6758 — закрытый раздел, не портировать), `_NE_ISPOLZUETSJA/**`, файлы с суффиксами `— копия`, `- Copy`, `_old`, `internaltest.php`, `internalMaptest.php`, `internalDockEquipment_Bod2y.php`, `internalDockLaser_Body2.php`, `internalGalaxyGates_Body1.php` | — | удалить из плана |

---

## Порядок выполнения (сжатый roadmap)

1. ~~A1 (Clan) → A2 (Skylab) → A3–A6~~ — выполнены (остатки: Users.change*, pretty_time, Clan remainder)
2. ~~B1~~ + **B2 (RenderShell/PhpTemplateRenderer)** — следующий приоритет; заглушки нераскрытых action → 404 как в PHP-else
3. B3–B10 строго по готовности их классов (все классы A уже готовы → узкое место — B2 и шаблоны C)
4. C-шаблоны синхронно с каждой B-веткой (ветка считается готовой только с рендером)
5. ~~A7 (xajax/sajax handlers)~~ ✅ после B7 подключить клиентские bootstrap в оболочку (B2); B11 (smoke) в конце
6. MIGRATION.md / README.md: обновлять статусы Часть 2/3 по факту merge каждого куска

Критерии приёмки куска: компиляция в CI (`dotnet build port/CoreCore.csproj`) + parity-тест метода против PHP
(одинаковые входные данные → одинаковый SQL/вывод) + отсутствие `TODO` в публичном API.
