# План портирования по «кускам» (chunk-by-chunk porting plan)

Единица работы = **один целый класс** (если он небольшой, ≤ ~300 строк PHP) либо
**одна группа методов большого класса** (если класс огромный). Каждый кусок —
отдельный коммит с проверкой компиляции на Windows-CI.

Обозначения статусов:
- ✅ — уже портировано в `port/App_Code/`
- ⬜ — не портировано
- 🔶 — портировано частично / требует доделки

Отправная точка (проверено по факту в репозитории):
- `internal.aspx.cs` — заглушка на 37 строк (только checkSession + shell), диспетчер НЕ перенесён;
- `App_Code/Clan.cs`, `Skylab.cs`, `Shop.cs`, `Rank.cs`, `GalaxyGate.cs`, `Inventory.cs` — ОТСУТСТВУЮТ;
- портированы: Core, DB, Encryption, SessionManager, Users, AppConfig, TemplateManager,
  Unity(685), Auction(642), Factory(545), Base(515), DailyBonus, Voucher, Hangar, Signup, News,
  PlayerLog, IxrServer, PhpMailer, JsonUtil, RegisterProvisioning.

---

## Фаза A — Классы-зависимости диспетчера internal (порядок обязателен)

Диспетчер `indexInternal.es.php` вызывает эти классы напрямую; без них ветки
`action` не собрать. Большие классы режем по связным группам методов.

### A1. `Class.clan.php` (757 стр.) → `App_Code/Clan.cs` — 4 куска
| Кусок | Методы (строки оригинала) | Примерный объём C# |
|---|---|---|
| A1.1 Каркас + деньги/поиск | `__construct`, `setId`, `money`, `getUser`, `clanVoid`, `getClans`, `getMyClan`, `GetClanLeader`, `getClanName`, `getClanTag`, `getType` (~250 стр.) | ~300 стр. |
| A1.2 Основание/роспуск клана | `foundClan`, `regClan`, `regMyClan`, `getMyNewClan`, `deleteClan`, `deleteClanNow`, `deleteClanDiplomacy`, `deleteAps`, `changeFirm`, `pullUri` (~200 стр.) | ~250 стр. |
| A1.3 Состав | `join`, `applyMember`, `deleteMember`, `runNewInfo`, `indentNewMember`, `setUsersClan`, `reUsersClan`, `updateMembers`, `removeMembers`, `loadMembers`, `getMembers`, `GetApplicantNames`, `getApplicants`, `getPending` (~200 стр.) | ~250 стр. |
| A1.4 Дипломатия | `postDiplomacy`, `setDiplomacy`, `stopWarRequest`, `acceptRequest` и remainder (~100 стр.) | ~150 стр. |

### A2. `Class.Skylab.php` (2212 стр.) → `App_Code/Skylab.cs` — 6 кусков (крупнейший класс)
| Кусок | Методы (строки оригинала) | Комментарий |
|---|---|---|
| A2.1 Каркас + init | `__construct`, `getSiteData`, `getOutput`, `setId`, `money`, `initSkylab` (1–358) | состояние модулей/уровней в полях |
| A2.2 Ресурсы | `ressupdate` (359–520) | арифметика хранения/добычи, целая функция |
| A2.3 UI-логика сборки | `displayBuild`, `setStatus` (521–683) | `setStatus` вызывается из subaction'ов диспетчера |
| A2.4 Стоимость апгрейдов | `req_ress`, `showModule` (684–1202) | самые «табличные» методы |
| A2.5 Данные | `getAllData` (1203–1404) | отдаёт массив для шаблона |
| A2.6 Формулы | `energy_production`, `ressource_generation`, `energy_usage`, `energy_all_usage`, `storage`, `pretty_time`, `upgrade_time`, `upgrade_cost` (1405–2212) | чистые функции — легко тестировать |

### A3. `Class.inventory.php` (1736 стр.) → `App_Code/Inventory.cs` — 6 кусков
| Кусок | Методы (строки оригинала) |
|---|---|
| A3.1 Каркас/транзакции | `__construct`, `setId`, `init`, `CompleteTrans`, `errorTrans`, `checkMinus`, геттеры (`getItemInfo`, `getItemsList`, `getLootIds`, `getJson`, `submitParams`, `droneEquip`) (1–177) |
| A3.2 Продажа | `renamePet`, `setName`, `cashOut`, `checkDB`, `sell`, `checkItemsOwnerShip`, `DelDrone`, `sellDrone`, `wipeDrone`, `wipeConfigs`, `changeShipModel` (178–372) |
| A3.3 БД-оперы/валидация | `addToDB`, `delFromDb`, `checkInput`, `extrasExits` (373–515) |
| A3.4 CPU-слоты/полнота проверки | `cpuSlots`, `fullSystemCheck`, `shipspace`, `NotEmptyDrone`, `EmptyDrone`, `NotEmptyShip`, `EmptyShip`, `checkExtrasService` (516–1014) — ядро equip-логики Dock |
| A3.5 Конфиги | `editDB`, `editJson`, `checkInConfig`, `ifExistsPet`, `ifExistsDrone`, `GetPet`, `droneconfigsGenerator`, `petconfigsGenerator`, `shipconfigsGenerator` (1015–1534) |
| A3.6 Ангар | `getdrone`, `allDesigns`, `hangarGeneral`, `hangarGenerator`, `itemLootIdGenerator`, `getTypes`, `getMoney`, `getMainInfo`, `getFacInfo` (1268–1736, остаток) |
| — | `Class.inventory_backup.php` НЕ портировать (мёртвый код) |

### A4. `Class.shop.php` (779 стр.) → `App_Code/Shop.cs` — 3 куска
| Кусок | Методы (строки оригинала) |
|---|---|
| A4.1 Каркас/расчёты | `__construct`, `setId`, `checkExistence`, `HangarId`, `mXac`, `spaceleft`, `currentShip`, `countAllAmmoLaser`, `GetAmmoPrice`, `cPT`, `priceCal` (1–349) |
| A4.2 Покупка юнитов | `ship`, `model`, `dronePrice`, `guns`, `blockIDs`, `updateAmmo`, `battery`, `special`, `generator` (199–574) |
| A4.3 Питомцы/дроны/предметы | `petPet`, `regPet`, `CreateConfigPet`, `my_pet_id`, `CreatePet`, `droneReg`, `CreateConfig`, `CreateDrone`, `drone`, `money`, `itemReg` (449–779) |

### A5. `Class.rank.php` (630 стр.) → `App_Code/Rank.cs` — 3 куска
| Кусок | Методы (строки оригинала) |
|---|---|
| A5.1 Расчёт очков | `__construct`, `setId`, `money`, `getIdFrom`, `getShipID`, `shipNameFromNumber`, `calculateNpcs`, `calculatePlayer`, `updatePlayerpoints`, `updateNPCpoints`, `getNpcInfo`, `gePlayerKills`, `getNpcKill`, `cr_cache_data` (1–205) |
| A5.2 Списки/ранги | `cr_allplayers`, `ur_exp`, `ur_hnr`, `getAllPlayers`, `setOverAll`, `secureSetOverAll`, `allRanks`, `calculateRanks`, `giveFactionRanks`, `getAllRankingPlayers`, `getMyRanking`, `getApprox`, `getRankBesideMe`, `totalDays` (206–492) |
| A5.3 Пагинатор | `getCurrentPage`…`paginate` (493–630) — отдельный helper `Paginator.cs` вместо методов класса |

### A6. `Class.GalaxyGate.php` (589 стр.) → `App_Code/GalaxyGate.cs` — 2 куска
| Кусок | Методы (строки оригинала) |
|---|---|
| A6.1 Каркас/гейты | `__construct`, `setInfo`, `reloadUri`, `proberbiliteis`, `multipliersShow`, `getIt`, `checkExistence`, `addItems`, `gatesInfos`, `GetGates`, `AllGates`, `CheckGateCount`, `UserGates`, `setMulti`, `AddGates` (1–216) |
| A6.2 Спиннер/мультипликаторы | `spinerUri`, `MultiplierUpdate`, `WhereMulti`, `currentGate` (217–589) |

### A7. Мелкие классы — целиком одним куском каждый
| Кусок | Оригинал | Строк | В порт |
|---|---|---|---|
| A7.1 | `Class.Ships.php` | 15 | `Ships.cs` |
| A7.2 | `Class.log.php` | 58 | ✅ `PlayerLog.cs` (сверить покрытие) |
| A7.3 | xajax/sajax API-эндпоинты (`GLOBAL/xajax.php` 58 + `sajax.php` 198 + `ajax/nanoTechfactory/*`) | ~300 | `AjaxHandlers.ashx` — только после A2/A3 (вызывают Skylab/inventory) |

Уже портированные крупные классы (✅) сверить на полноту public-методов,
используемых диспетчером; доделки — мелкими PR.

---

## Фаза B — Диспетчер `internal.aspx` (порт `indexInternal.es.php`, 732 стр.)

Зависит от фазы A (минимум A1, A2; остальное — по мере подключения веток).

### B1. Бутстрап + общие guard'ы (стр. 1–65 оригинала) — один кусок
- POST→GET `action` (стр. 3–5), `require Init.php` → существующий `Global.asax`/`AppConfig`;
- `checkSession()` → `Users.CheckSession(Session)` (есть);
- установка `$_SESSION['fact']` (стр. 24);
- ветка `internalCompanyChoose` + `factionChoose` (UPDATE factionId/mapId/x/y, редиректы) — стр. 36–64.

### B2. Механизм рендеринга оболочки — один кусок
PHP повторяет один и тот же набор require на каждой ветке:
`internalDoc.php → internalDocEnd.php → sajax.php → xajax.php → headerEndJS.php → internalMenu.php → internalHeader.php → <Body-шаблон> → ads.php`.
В C# — единый `RenderShell(string bodyTemplate, IDictionary<string,string> vars)` в
`TemplateManager`/новом `PhpTemplateRenderer.cs`: парсинг HTML-оболочки + токен-подстановка тела.
Порт шаблонных GLOBALS-фрагментов (`internalDoc*`, `internalMenu`, `internalHeader`,
`sajax/xajax`, итого ~1100 стр., см. `Files/en_US/GLOBAL/`) — внутри этого куска, по одному файлу за коммит.

### B3–B10. Ветки `action` — по группе связанных экшенов
| Кусок | Экшены (строки оригинала) | Зависимости |
|---|---|---|
| B3 Start/Gates/JPA/Payment/HoF | `internalStart` (66–77), `internalGalaxyGates` (78–89, 116–126), `internalJPA`, `internalJPA-list` (90–115), `internalPayment` (127–137), `internalHallofFame`+view Faction/User/daily/exp/honor (138–160) | Rank (A5), GalaxyGate (A6) |
| B4 Balance/Evoucher | `internalBalance` (161–171), `internalEvoucher` (172–188) | Voucher ✅ |
| B5 Clan-группа | `internalNewClanDetails` (189–206), `internalNewClan` (207–240), `internalClan` (241–286), `internalClanList` (287–297) | Clan (A1) |
| B6 Messaging/PilotSheet/UserData/Upgrade | `internalMessaging` (298–308), `internalPilotSheet` (309–340), `internalUserDataChange` (341–351), `internalItemUpgradeSystem` (352–362) | Base ✅, Inventory (A3) |
| B7 Skylab/Board/NanoTechFactory | `internalSkylab`+subactions setInactive/upgrade/setActive/instantUpgrade (363–391), `internalBoard`+subaction (392–406), `internalNanoTechFactory`+subactions deleteAllBuffs/expandHall/buildBuff/cancelProductin/buynow (407–454) | Skylab (A2), Factory ✅ |
| B8 External/History/Promo/Logout | `externalPassword` (455–465), `internalPaymentProxy` (466–469), `externalLogout` (470–480), `internalHistory` (481–491), `internalPaymentPartnerPromotion` (492–502) | Unity ✅ |
| B9 Auction | `internalAuction` (503–571) | Auction ✅ |
| B10 Dock + MapRevolution + burnme | `internalDock` (572–717 — самая большая ветка, под-экшены ship/ammo/laser/drone/generator/booster/special/equipment/model), `internalMapRevolution` (718–726), `burnme` (727–732) | Shop (A4), Inventory (A3), Hangar ✅ |

### B11. Routing и завершение — один кусок
- URL Rewrite в `web.config`: `indexInternal.es.php?action=X` → `internal.aspx?a=X` (сохранить legacy-ссылки Flash-клиента);
- обновление `DarkSpace.csproj` (Compile Include новых классов);
- smoke-тест всех action через HTTP-запросы на staging.

---

## Фаза C — Шаблоны Body (рендерятся диспетчером; идут за своими ветками B)

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

1. A1 (Clan, 4 куска) → A2 (Skylab, 6 кусков)
2. B1 + B2 (диспетчер-каркас: бутстрап + RenderShell; заглушки нераскрытых action → 404 как в PHP-else)
3. B3–B10 строго по готовности их классов (A3 Inventory → B6/B10; A4 Shop → B10; A5 Rank → B3; A6 GalaxyGate → B3)
4. C-шаблоны синхронно с каждой B-веткой (ветка считается готовой только с рендером)
5. A7 (xajax/sajax handlers) после B7; B11 (rewrite+csproj+smoke) в конце
6. MIGRATION.md: отметить Часть 2/3 выполненными по факту merge каждого куска

Критерии приёмки куска: компиляция на Windows-CI + parity-тест метода против PHP
(одинаковые входные данные → одинаковый SQL/вывод) + отсутствие `TODO` в публичном API.
