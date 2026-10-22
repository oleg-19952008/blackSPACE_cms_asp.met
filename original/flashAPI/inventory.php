<?php
require_once '../KERNEL-DOCMS/Init.php';
if (isset($_SESSION['server1']['user']['sessionId'])) {
    $Users->checkSession();
    if (isset($_SESSION['pid']) && isset($_SESSION['uid'])) {
        $inventory->setId($_SESSION['uid'], $_SESSION['pid']);
    } else {
        $_SESSION['pid'] = $Users->DataRow['playerID'];
        $_SESSION['uid'] = $Users->DataRow['ID'];
        $inventory->setId($_SESSION['uid'], $_SESSION['pid']);
    }

    if (isset($_POST['action']) && $_POST['action'] == "init") {
        $_SESSION['EQ'] = $inventory->init();
        echo  base64_encode(json_encode($_SESSION['EQ']));      
    } elseif (isset($_POST['action']) && $_POST['action'] == "move") {
        $inventory->getMainInfo();
        $param = base64_decode(urldecode($_POST['params']));
        $inventory->submitParams($param);
        echo $inventory->editJson();
    } elseif (isset($_POST['action']) && $_POST['action'] == "droneEquip") {
        $inventory->getMainInfo();
        $inventory->droneEquip(TRUE);
        $param = base64_decode(urldecode($_POST['params']));
        $inventory->submitParams($param);
        echo $inventory->editJson();
    } elseif (isset($_POST['action']) && $_POST['action'] == "changeShipModel") {
        $inventory->getMainInfo();
        $param = base64_decode(urldecode($_POST['params']));
        $inventory->submitParams($param);
        echo $inventory->changeShipModel();
    } elseif (isset($_POST['action']) && $_POST['action'] == "clearConfig") {
        $inventory->getMainInfo();
        $param = base64_decode(urldecode($_POST['params']));
        $inventory->submitParams($param);
        echo $inventory->wipeConfigs();
    } elseif (isset($_POST['action']) && $_POST['action'] == "sell") {
        $inventory->getMainInfo();
        $param = base64_decode(urldecode($_POST['params']));
        $inventory->submitParams($param);
        echo $inventory->sell();
    } elseif (isset($_POST['action']) && $_POST['action'] == "sellShip") {
        $inventory->getMainInfo();
//          $param = base64_decode(urldecode($_POST['params']));
//          $inventory->submitParams($param);
        echo $inventory->errorTrans("You don't want to sell your ship! Don't argue with a me! ");
    } elseif (isset($_POST['action']) && $_POST['action'] == "sellDrone") {
        $inventory->getMainInfo();
        $param = base64_decode(urldecode($_POST['params']));
        $inventory->submitParams($param);
        echo $inventory->sellDrone();
//        echo $inventory->errorTrans("You don't want to sell your drone! Don't argue with a me! ");
    } elseif (isset($_POST['action']) && $_POST['action'] == "unlockSlot") {
        $inventory->getMainInfo();
//          $param = base64_decode(urldecode($_POST['params']));
//          $inventory->submitParams($param);
        echo $inventory->errorTrans("Buying P.E.T.10 slots is NOT Available yet!");
    } elseif (isset($_POST['action']) && $_POST['action'] == "renamePet") {
        $inventory->getMainInfo();
        $param = base64_decode(urldecode($_POST['params']));
        $inventory->submitParams($param);
        echo $inventory->renamePet();
    } else {
        $inventory->getMainInfo();
         echo $inventory->errorTrans("Doesn't work yet!");
    }
}
?>