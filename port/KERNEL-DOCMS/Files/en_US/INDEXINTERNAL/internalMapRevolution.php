<?php
// ============================================================
// 1) ОБРАБОТЧИК СОХРАНЕНИЯ РАЗРЕШЕНИЯ
// ============================================================
if (isset($_POST['save_screen'])) {
    header('Content-Type: text/plain; charset=utf-8');

    $uid = (int)$Users->DataRow['playerID'];
    $sx  = isset($_POST['x']) ? (int)$_POST['x'] : 0;
    $sy  = isset($_POST['y']) ? (int)$_POST['y'] : 0;

    if ($uid <= 0 || $sx < 320 || $sy < 240 || $sx > 8192 || $sy > 8192) {
        http_response_code(400);
        echo 'bad';
        exit;
    }

    $stmt = $MySQLi->prepare(
        "INSERT INTO scr (u_id, screen_x, screen_y)
         VALUES (?, ?, ?)
         ON DUPLICATE KEY UPDATE screen_x = VALUES(screen_x), screen_y = VALUES(screen_y)"
    );
    if ($stmt) {
        $stmt->bind_param('iii', $uid, $sx, $sy);
        $stmt->execute();
        $stmt->close();
        echo 'ok';
    } else {
        $uidE = (int)$uid;
        $sxE  = (int)$sx;
        $syE  = (int)$sy;
        $MySQLi->query(
            "INSERT INTO scr (u_id, screen_x, screen_y) VALUES ($uidE, $sxE, $syE)
             ON DUPLICATE KEY UPDATE screen_x = $sxE, screen_y = $syE"
        );
        echo 'ok';
    }
    exit;
}

// ============================================================
// 2) ЧТЕНИЕ СОХРАНЁННОГО РАЗРЕШЕНИЯ (для flashvars)
// ============================================================
$uid = (int)$Users->DataRow['playerID'];
$resRow = null;
if ($stmt = $MySQLi->prepare("SELECT screen_x, screen_y FROM scr WHERE u_id = ? LIMIT 1")) {
    $stmt->bind_param('i', $uid);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res) {
        $resRow = $res->fetch_assoc();
    }
    $stmt->close();
} else {
    $r = $MySQLi->query("SELECT screen_x, screen_y FROM scr WHERE u_id = $uid LIMIT 1");
    if ($r && $r->num_rows) {
        $resRow = $r->fetch_assoc();
    }
}

$screenX = isset($resRow['screen_x']) ? (int)$resRow['screen_x'] : 0;
$screenY = isset($resRow['screen_y']) ? (int)$resRow['screen_y'] : 0;

$effectiveX = $screenX > 0 ? $screenX : 1024;
$effectiveY = $screenY > 0 ? $screenY : 768;

$resolutionsList = array();
if ($screenX > 0 && $screenY > 0) {
    $resolutionsList[] = array('width' => $screenX, 'height' => $screenY);
}
$defaults = array(
    array(1024, 768), array(1280, 800), array(1280, 1024),
    array(1440, 900), array(1600, 900), array(1680, 1050), array(1920, 1080)
);
foreach ($defaults as $p) {
    if (!($p[0] === $effectiveX && $p[1] === $effectiveY)) {
        $resolutionsList[] = array('width' => $p[0], 'height' => $p[1]);
    }
}
$supportedResolutionsJson = json_encode($resolutionsList);

// ============================================================
// 3) СЕССИЯ
// ============================================================
$sessionId = $Core::GenerateRandom(10, true, false);
$mapid     = $unity->getMapID($Users->DataRow['playerID']);
$MySQLi->query('UPDATE server_1_players SET tokenId = '.$sessionId.' WHERE playerID = '.$Users->DataRow['playerID']);

$factionId = ($Users->DataRow['factionId'] === '1')
    ? 'MMO'
    : (($Users->DataRow['factionId'] === '2') ? 'EIC' : 'VRU');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Dark Space | Private Server</title>
<script type="text/javascript" src="js/jquery-1.4.4.js"></script>
<script type="text/javascript" src="js/jquery.flashembed.js"></script>
</head>
<body>
  <div id="container"></div>

  <script type="text/javascript">
  var DARKSPACE_UID   = <?php echo (int)$Users->DataRow['playerID']; ?>;
  var DARKSPACE_HOST  = "<?php echo HOST; ?>";
  var DARKSPACE_RES_X = <?php echo (int)$effectiveX; ?>;
  var DARKSPACE_RES_Y = <?php echo (int)$effectiveY; ?>;

  function send_screen(x, y) {
      if (!x || !y) return;
      var xhr = new XMLHttpRequest();
     xhr.open("POST", window.location.href, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send("save_screen=1&x=" + encodeURIComponent(x) + "&y=" + encodeURIComponent(y));
  }

  (function () {
      var w = (window.screen && screen.width)  ? screen.width  : window.innerWidth;
      var h = (window.screen && screen.height) ? screen.height : window.innerHeight;
      if (w !== DARKSPACE_RES_X || h !== DARKSPACE_RES_Y) {
          send_screen(w, h);
          DARKSPACE_RES_X = w;
          DARKSPACE_RES_Y = h;
      }
  })();
  </script>

  <script type="text/javascript">
  jQuery(document).ready(function () {
      flashembed("container", {
          "src": "/spacemap/bWFpbg==.swf",
          "width": "100%",
          "height": "100%",
          "wmode": "direct",
          "bgcolor": "#000000",
          "id": "main"
      }, {
          "lang": "en",
          "userID": <?php echo (int)$Users->DataRow['playerID']; ?>,
          "factionID": "<?php echo $factionId; ?>",
          "sessionID": "<?php echo $sessionId; ?>",
          "basePath": "spacemap",
          "pid": 563,
          "resolutionID": 0,
          "boardLink": "<?php echo HOST; ?>",
          "helpLink": "<?php echo HOST; ?>",
          "loadingClaim": "LOADING...",
          "chatHost": "<?php echo HOST; ?>",
          "cdn": "",
          "useHash": 1,
          "host": "<?php echo HOST; ?>",
          "gameXmlHash": "060b9c86992a12a6d343395f64852876",
          "resourcesXmlHash": "4f5d6e23ebb06278f110ba358dde28ec",
          "profileXmlHash": "18287bc38698431e80f7cca05e6df2ca",
          "autoStartEnabled": 1,
          "mapID": <?php echo (int)$mapid; ?>,
          "supportedResolutions": <?php echo $supportedResolutionsJson; ?>,
          "logConfig": "0,300,4,5",
          "instantLogEnabled": 1,
          "doubleClickAttackEnabled": 1,
          "allowChat": 0
      });
  });
  </script>

<style>
body{margin:0;padding:0;font-size:100.01%;font-family:Verdana,Arial,sans-serif;color:#F4E365;text-align:center;background-color:#000;width:100%;height:100%}
</style>
</body>
</html>