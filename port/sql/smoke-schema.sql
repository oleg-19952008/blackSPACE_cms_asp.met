-- ============================================================
-- port/sql/smoke-schema.sql
-- Минимальная схема БД для smoke-теста порта (фаза B11).
-- Таблицы и колонки извлечены grep'ом по SQL-строкам в
-- port/Models, port/Services, port/Pages (см. PORTING-PLAN.md B11).
-- Только для тестовой базы `darkorbit`; НЕ продакшн-схема.
-- Запуск:  mysql darkorbit < port/sql/smoke-schema.sql
-- ============================================================
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS users (
  ID INT AUTO_INCREMENT PRIMARY KEY,
  Email VARCHAR(255) NOT NULL DEFAULT '',
  Name VARCHAR(64) NOT NULL DEFAULT '',
  pwHash VARCHAR(255) NOT NULL DEFAULT '',
  Servers VARCHAR(32) NOT NULL DEFAULT '1',
  sessionId VARCHAR(64) DEFAULT NULL,
  accountnote TEXT,
  regDate BIGINT NOT NULL DEFAULT 0,
  lastvisit BIGINT DEFAULT 0,
  banned TINYINT NOT NULL DEFAULT 0,
  verified TINYINT NOT NULL DEFAULT 1,
  change_password VARCHAR(64) DEFAULT NULL,
  change_username VARCHAR(64) DEFAULT NULL,
  UNIQUE KEY uq_email (Email),
  KEY idx_session (sessionId)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_players (
  playerID INT PRIMARY KEY,
  userID INT NOT NULL DEFAULT 0,
  uri BIGINT NOT NULL DEFAULT 0,
  credits BIGINT NOT NULL DEFAULT 100000,
  honor BIGINT NOT NULL DEFAULT 0,
  jackpot BIGINT NOT NULL DEFAULT 0,
  level INT NOT NULL DEFAULT 1,
  exp BIGINT NOT NULL DEFAULT 0,
  rank INT NOT NULL DEFAULT 1,
  premium TINYINT NOT NULL DEFAULT 0,
  dbonus INT NOT NULL DEFAULT 0,
  health INT NOT NULL DEFAULT 1000,
  repairvouchers INT NOT NULL DEFAULT 0,
  clanId INT NOT NULL DEFAULT 0,
  factionId INT NOT NULL DEFAULT 1,
  mapId INT NOT NULL DEFAULT 1,
  x INT NOT NULL DEFAULT 0,
  y INT NOT NULL DEFAULT 0,
  shipId INT NOT NULL DEFAULT 1,
  GGspins INT NOT NULL DEFAULT 3,
  overallRank INT NOT NULL DEFAULT 0,
  rankPosition INT NOT NULL DEFAULT 0,
  rankpoints BIGINT NOT NULL DEFAULT 0,
  npcPoints BIGINT NOT NULL DEFAULT 0,
  playerkills BIGINT NOT NULL DEFAULT 0,
  settings TEXT,
  KEY idx_userid (userID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS rank (
  id INT PRIMARY KEY,
  name VARCHAR(64) NOT NULL DEFAULT '',
  rankPoints BIGINT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ships (
  Id INT AUTO_INCREMENT PRIMARY KEY,
  type VARCHAR(64) NOT NULL DEFAULT '',
  Name VARCHAR(64) NOT NULL DEFAULT '',
  HP BIGINT NOT NULL DEFAULT 0,
  Shield BIGINT NOT NULL DEFAULT 0,
  shieldAbsorb DOUBLE NOT NULL DEFAULT 0,
  Speed BIGINT NOT NULL DEFAULT 0,
  Generators BIGINT NOT NULL DEFAULT 0,
  rankPoints BIGINT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ships_designs (
  Id INT AUTO_INCREMENT PRIMARY KEY,
  ShipId INT NOT NULL DEFAULT 0,
  type VARCHAR(64) NOT NULL DEFAULT '',
  Name VARCHAR(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_item_types (
  id INT AUTO_INCREMENT PRIMARY KEY,
  item_type_name VARCHAR(96) NOT NULL DEFAULT ''
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_shop_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lootId VARCHAR(96) NOT NULL DEFAULT '',
  type INT NOT NULL DEFAULT 0,
  price BIGINT NOT NULL DEFAULT 0,
  currency VARCHAR(16) NOT NULL DEFAULT 'credits',
  KEY idx_lootid (lootId)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS news (
  nID INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) DEFAULT '',
  body MEDIUMTEXT,
  created BIGINT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ip_bans (
  id INT AUTO_INCREMENT PRIMARY KEY,
  IP VARCHAR(64) NOT NULL DEFAULT '',
  period BIGINT NOT NULL DEFAULT 0,
  KEY idx_ip (IP)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS clans (
  clanID INT AUTO_INCREMENT PRIMARY KEY,
  clanName VARCHAR(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_clan (
  clanID INT AUTO_INCREMENT PRIMARY KEY,
  clanName VARCHAR(64) NOT NULL DEFAULT '',
  leader INT NOT NULL DEFAULT 0,
  tagName VARCHAR(16) NOT NULL DEFAULT '',
  members TEXT,
  memberCount INT NOT NULL DEFAULT 1,
  company INT NOT NULL DEFAULT 1,
  recruiting TINYINT NOT NULL DEFAULT 1,
  clandescription TEXT,
  visible TINYINT NOT NULL DEFAULT 1,
  KEY idx_clanname (clanName)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_clan_join (
  autoID INT AUTO_INCREMENT PRIMARY KEY,
  clanID INT NOT NULL DEFAULT 0,
  playerID INT NOT NULL DEFAULT 0,
  application TEXT,
  KEY idx_cid (clanID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_clan_diplomacy (
  autoID INT AUTO_INCREMENT PRIMARY KEY,
  fromID INT NOT NULL DEFAULT 0,
  toID INT NOT NULL DEFAULT 0,
  type INT NOT NULL DEFAULT 0,
  descr TEXT,
  accepted TINYINT NOT NULL DEFAULT 0,
  request TINYINT NOT NULL DEFAULT 0,
  request2 TINYINT NOT NULL DEFAULT 0,
  KEY idx_from (fromID),
  KEY idx_to (toID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS skylab (
  LabID INT PRIMARY KEY,
  UserID INT NOT NULL DEFAULT 0,
  lastvisit BIGINT NOT NULL DEFAULT 0,
  basicmod VARCHAR(32) NOT NULL DEFAULT '1|1|0',
  solarmod VARCHAR(32) NOT NULL DEFAULT '1|1|0',
  storagemod VARCHAR(32) NOT NULL DEFAULT '1|1|0',
  prometiumcol VARCHAR(32) NOT NULL DEFAULT '0|0|0',
  enduriumcol VARCHAR(32) NOT NULL DEFAULT '0|0|0',
  terbiumcol VARCHAR(32) NOT NULL DEFAULT '0|0|0',
  prometidref VARCHAR(32) NOT NULL DEFAULT '0|0|0',
  duraniumref VARCHAR(32) NOT NULL DEFAULT '0|0|0',
  promeriumref VARCHAR(32) NOT NULL DEFAULT '0|0|0',
  xenogen VARCHAR(32) NOT NULL DEFAULT '0|0|0',
  sepromref VARCHAR(32) NOT NULL DEFAULT '0|0|0',
  KEY idx_userid (UserID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS skylab_ressources (
  LabID INT PRIMARY KEY,
  prometium BIGINT NOT NULL DEFAULT 0,
  endurium BIGINT NOT NULL DEFAULT 0,
  terbium BIGINT NOT NULL DEFAULT 0,
  prometid BIGINT NOT NULL DEFAULT 0,
  duranium BIGINT NOT NULL DEFAULT 0,
  xenomit BIGINT NOT NULL DEFAULT 0,
  promerium BIGINT NOT NULL DEFAULT 0,
  seprom BIGINT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_voucher (
  id INT AUTO_INCREMENT PRIMARY KEY,
  vkey VARCHAR(64) NOT NULL DEFAULT '',
  vtype VARCHAR(64) NOT NULL DEFAULT '',
  vvalue BIGINT NOT NULL DEFAULT 0,
  vuser INT NOT NULL DEFAULT 0,
  vused INT NOT NULL DEFAULT 0,
  UNIQUE KEY uq_vkey (vkey)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_galaxygate (
  galaxygate_id INT AUTO_INCREMENT PRIMARY KEY,
  galaxygate_name VARCHAR(96) NOT NULL DEFAULT '',
  galaxygate_part VARCHAR(255) NOT NULL DEFAULT '',
  galaxygate_totalWave INT NOT NULL DEFAULT 1,
  galaxygate_multipliers VARCHAR(64) NOT NULL DEFAULT '1',
  lifePrice BIGINT NOT NULL DEFAULT 0,
  ammunition VARCHAR(255) DEFAULT '',
  resource VARCHAR(255) DEFAULT '',
  voucher VARCHAR(255) DEFAULT '',
  logfile VARCHAR(255) DEFAULT ''
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_players_galaxygate (
  autoID INT AUTO_INCREMENT PRIMARY KEY,
  playerID INT NOT NULL DEFAULT 0,
  userID INT NOT NULL DEFAULT 0,
  galaxygate_id INT NOT NULL DEFAULT 0,
  galaxygate_current_parts BIGINT NOT NULL DEFAULT 0,
  galaxygate_prepared TINYINT NOT NULL DEFAULT 0,
  livesLeft INT NOT NULL DEFAULT 0,
  state INT NOT NULL DEFAULT 0,
  galaxygate_current_wave INT NOT NULL DEFAULT 0,
  galaxygate_multipliers VARCHAR(64) NOT NULL DEFAULT '1',
  KEY idx_player (playerID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_hangar (
  hangarID INT AUTO_INCREMENT PRIMARY KEY,
  hangar_is_active TINYINT NOT NULL DEFAULT 0,
  hangar_is_selected TINYINT NOT NULL DEFAULT 0,
  name VARCHAR(64) NOT NULL DEFAULT '',
  userID INT NOT NULL DEFAULT 0,
  playerID INT NOT NULL DEFAULT 0,
  KEY idx_player (playerID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_player_all_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lootid VARCHAR(96) NOT NULL DEFAULT '',
  Q BIGINT NOT NULL DEFAULT 0,
  LV INT NOT NULL DEFAULT 0,
  properties VARCHAR(255) DEFAULT '0',
  interactive TINYINT NOT NULL DEFAULT 0,
  charge BIGINT NOT NULL DEFAULT 0,
  playerID INT NOT NULL DEFAULT 0,
  userID INT NOT NULL DEFAULT 0,
  KEY idx_player_loot (playerID, lootid)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_player_ammunation (
  playerID INT PRIMARY KEY,
  ammunition_laser_lcb BIGINT NOT NULL DEFAULT 0,
  ammunition_laser_mcb BIGINT NOT NULL DEFAULT 0,
  ammunition_laser_ucb BIGINT NOT NULL DEFAULT 0,
  ammunition_laser_rsb BIGINT NOT NULL DEFAULT 0,
  ammunition_laser_sab BIGINT NOT NULL DEFAULT 0,
  ammunition_rocket_r BIGINT NOT NULL DEFAULT 0,
  ammunition_rocket_plt BIGINT NOT NULL DEFAULT 0,
  ammunition_rocketlauncher_eco BIGINT NOT NULL DEFAULT 0,
  ammunition_rocketlauncher_hstrm BIGINT NOT NULL DEFAULT 0,
  ammunition_rocketlauncher_ubr BIGINT NOT NULL DEFAULT 0,
  ammunition_mine_acm BIGINT NOT NULL DEFAULT 0,
  ammunition_mine_ddm BIGINT NOT NULL DEFAULT 0,
  ammunition_mine_empm BIGINT NOT NULL DEFAULT 0,
  ammunition_mine_sabm BIGINT NOT NULL DEFAULT 0,
  ammunition_specialammo_dcr BIGINT NOT NULL DEFAULT 0,
  ammunition_specialammo_emp BIGINT NOT NULL DEFAULT 0,
  ammunition_specialammo_pld BIGINT NOT NULL DEFAULT 0,
  ammunition_specialammo_wiz BIGINT NOT NULL DEFAULT 0,
  ammunition_firework_fwx BIGINT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_player_drones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  item_sale_id INT NOT NULL DEFAULT 0,
  drone_currency VARCHAR(16) NOT NULL DEFAULT 'u',
  drone_kind INT NOT NULL DEFAULT 0,
  drone_design VARCHAR(96) NOT NULL DEFAULT '',
  userID INT NOT NULL DEFAULT 0,
  playerID INT NOT NULL DEFAULT 0,
  KEY idx_player (playerID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_player_pet10 (
  pet_id INT AUTO_INCREMENT PRIMARY KEY,
  pet_name VARCHAR(64) NOT NULL DEFAULT '',
  pet_hp BIGINT NOT NULL DEFAULT 100,
  pet_level INT NOT NULL DEFAULT 1,
  lockedSlots INT NOT NULL DEFAULT 0,
  item_id INT NOT NULL DEFAULT 0,
  userID INT NOT NULL DEFAULT 0,
  playerID INT NOT NULL DEFAULT 0,
  KEY idx_player (playerID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_player_settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  userID INT NOT NULL DEFAULT 0,
  playerID INT NOT NULL DEFAULT 0,
  res VARCHAR(255) DEFAULT '',
  KEY idx_player (playerID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_player_nanotech (
  autoID INT AUTO_INCREMENT PRIMARY KEY,
  playerID INT NOT NULL DEFAULT 0,
  equipment_weapon_laser_lf BIGINT NOT NULL DEFAULT 0,
  equipment_extra_cpu_jp BIGINT NOT NULL DEFAULT 0,
  equipment_extra_cpu_sle BIGINT NOT NULL DEFAULT 0,
  equipment_extra_repbot_rep BIGINT NOT NULL DEFAULT 0,
  KEY idx_player (playerID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_player_hangar_general_ship (
  id INT AUTO_INCREMENT PRIMARY KEY,
  hangarID INT NOT NULL DEFAULT 0,
  playerID INT NOT NULL DEFAULT 0,
  ship_internal_id INT NOT NULL DEFAULT 1,
  ship_hp BIGINT NOT NULL DEFAULT 4000,
  ship_selected_model VARCHAR(96) NOT NULL DEFAULT '',
  KEY idx_player (playerID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_hangar_config_ship (
  id INT AUTO_INCREMENT PRIMARY KEY,
  hangarID INT NOT NULL DEFAULT 0,
  playerID INT NOT NULL DEFAULT 0,
  userID INT NOT NULL DEFAULT 0,
  configNum INT NOT NULL DEFAULT 0,
  slot0 INT DEFAULT 0, slot1 INT DEFAULT 0, slot2 INT DEFAULT 0, slot3 INT DEFAULT 0,
  slot4 INT DEFAULT 0, slot5 INT DEFAULT 0, slot6 INT DEFAULT 0, slot7 INT DEFAULT 0,
  KEY idx_player_cfg (playerID, hangarID, configNum)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_hangar_config_drones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  hangarID INT NOT NULL DEFAULT 0,
  playerID INT NOT NULL DEFAULT 0,
  userID INT NOT NULL DEFAULT 0,
  item_id INT NOT NULL DEFAULT 0,
  slot0 INT DEFAULT 0, slot1 INT DEFAULT 0, slot2 INT DEFAULT 0, slot3 INT DEFAULT 0,
  KEY idx_player_hangar (playerID, hangarID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_hangar_config_pet10 (
  id INT AUTO_INCREMENT PRIMARY KEY,
  hangarID INT NOT NULL DEFAULT 0,
  petID INT NOT NULL DEFAULT 0,
  playerID INT NOT NULL DEFAULT 0,
  userID INT NOT NULL DEFAULT 0,
  configNum INT NOT NULL DEFAULT 0,
  KEY idx_player_hangar (playerID, hangarID)
) ENGINE=InnoDB;

-- NB: MySQL хранит имена колонок без учёта регистра — HBidder/hBidder
-- это одна колонка в оригинале; здесь оставлена только "HBidder".
CREATE TABLE IF NOT EXISTS server_1_auction_hour (
  autoID INT AUTO_INCREMENT PRIMARY KEY,
  ItemName VARCHAR(96) NOT NULL DEFAULT '',
  amount BIGINT NOT NULL DEFAULT 0,
  apply BIGINT NOT NULL DEFAULT 0,
  HBidder INT NOT NULL DEFAULT 0,
  cBud BIGINT NOT NULL DEFAULT 0,
  helpers INT NOT NULL DEFAULT 0,
  KEY idx_item (ItemName)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_auction_daily (
  autoID INT AUTO_INCREMENT PRIMARY KEY,
  ItemName VARCHAR(96) NOT NULL DEFAULT '',
  amount BIGINT NOT NULL DEFAULT 0,
  apply BIGINT NOT NULL DEFAULT 0,
  HBidder INT NOT NULL DEFAULT 0,
  cBud BIGINT NOT NULL DEFAULT 0,
  helpers INT NOT NULL DEFAULT 0,
  KEY idx_item (ItemName)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS server_1_log (
  id INT AUTO_INCREMENT PRIMARY KEY,
  playerID INT NOT NULL DEFAULT 0,
  descrip TEXT,
  ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_player (playerID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pmc_log (
  id INT AUTO_INCREMENT PRIMARY KEY,
  playerID INT NOT NULL DEFAULT 0,
  descrip TEXT,
  location VARCHAR(64) DEFAULT '',
  ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_player (playerID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS player_kills_count (
  playerID INT PRIMARY KEY,
  count BIGINT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS npc_kills (
  playerID INT PRIMARY KEY,
  npc_phoe BIGINT NOT NULL DEFAULT 0,
  npc_biog BIGINT NOT NULL DEFAULT 0,
  npc_stre BIGINT NOT NULL DEFAULT 0,
  npc_deva BIGINT NOT NULL DEFAULT 0,
  npc_yolo BIGINT NOT NULL DEFAULT 0,
  npc_meca BIGINT NOT NULL DEFAULT 0,
  npc_resi BIGINT NOT NULL DEFAULT 0,
  npc_sict BIGINT NOT NULL DEFAULT 0,
  npc_manu BIGINT NOT NULL DEFAULT 0,
  npc_orca BIGINT NOT NULL DEFAULT 0,
  npc_lava BIGINT NOT NULL DEFAULT 0,
  npc_preo BIGINT NOT NULL DEFAULT 0,
  npc_retr BIGINT NOT NULL DEFAULT 0,
  npc_pres BIGINT NOT NULL DEFAULT 0,
  npc_proo BIGINT NOT NULL DEFAULT 0,
  npc_sere BIGINT NOT NULL DEFAULT 0,
  npc_seco BIGINT NOT NULL DEFAULT 0,
  npc_piri BIGINT NOT NULL DEFAULT 0,
  npc_refu BIGINT NOT NULL DEFAULT 0,
  npc_chef BIGINT NOT NULL DEFAULT 0,
  npc_croc BIGINT NOT NULL DEFAULT 0,
  npc_drug BIGINT NOT NULL DEFAULT 0,
  npc_mara BIGINT NOT NULL DEFAULT 0,
  npc_pira BIGINT NOT NULL DEFAULT 0,
  npc_roba BIGINT NOT NULL DEFAULT 0,
  npc_stat BIGINT NOT NULL DEFAULT 0,
  npc_mini BIGINT NOT NULL DEFAULT 0,
  npc_osir BIGINT NOT NULL DEFAULT 0,
  npc_isis BIGINT NOT NULL DEFAULT 0,
  npc_anub BIGINT NOT NULL DEFAULT 0,
  npc_horc BIGINT NOT NULL DEFAULT 0,
  npc_kron BIGINT NOT NULL DEFAULT 0,
  npc_epic BIGINT NOT NULL DEFAULT 0,
  npc_naga BIGINT NOT NULL DEFAULT 0,
  npc_fact BIGINT NOT NULL DEFAULT 0,
  npc_obsi BIGINT NOT NULL DEFAULT 0,
  npc_obsd BIGINT NOT NULL DEFAULT 0,
  npc_obse BIGINT NOT NULL DEFAULT 0,
  npc_hr1e BIGINT NOT NULL DEFAULT 0,
  npc_hr2e BIGINT NOT NULL DEFAULT 0,
  npc_hr3e BIGINT NOT NULL DEFAULT 0,
  npc_hr4e BIGINT NOT NULL DEFAULT 0,
  npc_hr5e BIGINT NOT NULL DEFAULT 0,
  npc_hr6e BIGINT NOT NULL DEFAULT 0,
  npc_qsar BIGINT NOT NULL DEFAULT 0,
  npc_qmaj BIGINT NOT NULL DEFAULT 0,
  npc_qmin BIGINT NOT NULL DEFAULT 0,
  npc_synr BIGINT NOT NULL DEFAULT 0,
  npc_synt BIGINT NOT NULL DEFAULT 0,
  npc_synq BIGINT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Тестовые данные: пользователь + игрок.
-- sessionId ('smoke-session-0001') — заглушка: реальный sid
-- выдаёт ASP.NET session cookie; smoke-скрипт логинется через
-- POST /indexInternal.es.php (login) и затем делает
-- UPDATE users SET sessionId='<реальный sid>' WHERE ID=1;
-- ------------------------------------------------------------
INSERT INTO users (ID, Email, Name, pwHash, Servers, sessionId, regDate, verified)
VALUES (1, 'smoke@test.local', 'SmokePilot', '', '1', 'smoke-session-0001', UNIX_TIMESTAMP(), 1)
ON DUPLICATE KEY UPDATE sessionId='smoke-session-0001';

INSERT INTO server_1_players (playerID, userID, uri, credits, honor, level, exp, rank, factionId, mapId, x, y, shipId, GGspins, dbonus, health, clanId)
VALUES (1, 1, 500000, 1000000, 50000, 5, 0, 1, 1, 1, 0, 0, 1, 3, 0, 1000, 0)
ON DUPLICATE KEY UPDATE credits=1000000;

INSERT INTO rank (id, name, rankPoints) VALUES
 (1,'Recruit',0),(2,'Commander',0),(3,'Warlord',0)
ON DUPLICATE KEY UPDATE name=VALUES(name);

INSERT INTO ships (Id, type, Name, HP, Shield, shieldAbsorb, Speed, Generators, rankPoints) VALUES
 (1,'ship_phoenix','Phoenix',4000,1000,0.5,220,20000,1)
ON DUPLICATE KEY UPDATE Name=VALUES(Name);

INSERT INTO ships_designs (Id, ShipId, type, Name) VALUES (1,1,'ship_phoenix','Phoenix')
ON DUPLICATE KEY UPDATE Name=VALUES(Name);

INSERT INTO server_item_types (item_type_name) VALUES
 ('ship'),('equipment'),('ammunition'),('resource'),('drone'),('pet10')
ON DUPLICATE KEY UPDATE item_type_name=VALUES(item_type_name);

INSERT INTO server_shop_items (lootId, type, price) VALUES
 ('prometium',2,0),('endurium',2,0),('terbium',2,0),
 ('prometid',2,0),('duranium',2,0),('xenomit',2,0),('promerium',2,0),('seprom',2,0),
 ('ship_phoenix',0,100000),('ship_probe',0,50000),
 ('equipment_weapon_laser_lcb',1,1000),('equipment_extra_cpu_jp',1,2000),
 ('ammunition_laser_ucb',3,10),('ammunition_rocket_r',3,20),
 ('drone_shield_u',4,50000),('drone_attack_u',4,50000),
 ('pet_prometium',5,10000),
 ('voucher_xp',6,0),('repair_voucher',6,0)
ON DUPLICATE KEY UPDATE price=VALUES(price);

INSERT INTO server_galaxygate (galaxygate_id, galaxygate_name, galaxygate_part, galaxygate_totalWave, lifePrice) VALUES
 (1,'First Galaxy Gate','prometium|endurium|terbium',3,100000)
ON DUPLICATE KEY UPDATE galaxygate_name=VALUES(galaxygate_name);

INSERT INTO server_1_voucher (vkey, vtype, vvalue) VALUES
 ('SMOKE-VOUCHER-1','credits',100000)
ON DUPLICATE KEY UPDATE vvalue=VALUES(vvalue);

INSERT INTO server_1_hangar (hangarID, hangar_is_active, hangar_is_selected, name, userID, playerID) VALUES
 (1,1,1,'Hangar 1',1,1)
ON DUPLICATE KEY UPDATE name=VALUES(name);

INSERT INTO server_1_player_hangar_general_ship (hangarID, playerID, ship_internal_id, ship_hp, ship_selected_model) VALUES
 (1,1,1,4000,'ship_phoenix')
ON DUPLICATE KEY UPDATE ship_selected_model=VALUES(ship_selected_model);

INSERT INTO server_1_hangar_config_ship (hangarID, playerID, userID, configNum) VALUES (1,1,1,0)
ON DUPLICATE KEY UPDATE configNum=VALUES(configNum);

INSERT INTO server_1_player_settings (userID, playerID) VALUES (1,1)
ON DUPLICATE KEY UPDATE playerID=VALUES(playerID);

INSERT INTO server_1_player_nanotech (playerID) VALUES (1)
ON DUPLICATE KEY UPDATE playerID=VALUES(playerID);

INSERT INTO server_1_player_ammunation (playerID) VALUES (1)
ON DUPLICATE KEY UPDATE playerID=VALUES(playerID);

INSERT INTO player_kills_count (playerID) VALUES (1)
ON DUPLICATE KEY UPDATE playerID=VALUES(playerID);

INSERT INTO npc_kills (playerID) VALUES (1)
ON DUPLICATE KEY UPDATE playerID=VALUES(playerID);

INSERT INTO news (title, body, created) VALUES ('Smoke test news','Hello',UNIX_TIMESTAMP());

INSERT INTO server_1_auction_hour (ItemName, amount, apply) VALUES ('prometium',1000,1)
ON DUPLICATE KEY UPDATE amount=VALUES(amount);

INSERT INTO server_1_auction_daily (ItemName, amount, apply) VALUES ('endurium',1000,1)
ON DUPLICATE KEY UPDATE amount=VALUES(amount);
