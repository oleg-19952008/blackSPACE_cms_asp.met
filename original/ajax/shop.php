<?php
require_once '../KERNEL-DOCMS/Init.php';
if (isset($_SESSION['server1']['user']['sessionId'])) {
    if (isset($_SESSION['pid']) && isset($_SESSION['uid'])) {
        $shop->setId($_SESSION['uid'], $_SESSION['pid'], $Users->DataRow['premium']);
        $base->setId($_SESSION['uid'], $_SESSION['pid'], $Users->DataRow['premium']);
    } else {
        $Users->checkSession();
        $_SESSION['pid'] = $Users->DataRow['playerID'];
        $_SESSION['uid'] = $Users->DataRow['ID'];
        $shop->setId($_SESSION['uid'], $_SESSION['pid'], $Users->DataRow['premium']);
        $base->setId($_SESSION['uid'], $_SESSION['pid'], $Users->DataRow['premium']);
    }
    if (isset($_POST['action']) && $_POST['action'] == "purchase") {
        $shop->HangarId();
        if (isset($_POST['category']) && $_POST['category'] == "ship") {
            if($_POST['itemId']==13):                
                echo $shop->ship(70);
            elseif($_POST['itemId']==12):
                echo $shop->ship(49);
            elseif($_POST['itemId']==11):
                echo $shop->ship(69);
            else:                
                echo $shop->ship($_POST['itemId']);
            endif;
        }elseif(isset($_POST['category']) && $_POST['category'] == "weapon"){
            echo $shop->guns($_POST['amount'], $_POST['itemId']);
        }elseif(isset($_POST['category']) && $_POST['category'] == "battery" OR $_POST['category'] == "rocket"){
            echo $shop->battery($_POST['amount'], $_POST['itemId']);
        }elseif(isset($_POST['category']) && $_POST['category'] == "pet" OR $_POST['itemId'] == "pet_pet10"){
            echo $shop->petPet($_POST['amount'], $_POST['itemId'], $_POST['selectedName']);
        }elseif(isset($_POST['category']) && $_POST['category'] == "model"){
            echo $shop->model($_POST['amount'], $_POST['itemId']);
        }elseif(isset($_POST['category']) && $_POST['category'] == "drone"){
            $w = $base->currentDrones();
            if($w>=10){
                    $shop->money();
                    $noacc = '{"result":"error","message":"You can not buy more than 10 drones","userBalance":{"uridium":'.$shop->uridium.',"credits":'.$shop->credits.'},"userShip":{"laserAmmunitionSpace":3420,"rocketSpace":100},"isShipDumpEmpty":true,"itemId":"","hasPet":"true","category":false}';
                    echo $noacc;
            }else{           
                echo $shop->drone($_POST['itemId']);
            }
        }elseif(isset($_POST['category']) && $_POST['category'] == "generator"){
            echo $shop->generator($_POST['amount'], $_POST['itemId']);
        }elseif(isset($_POST['category']) && $_POST['category'] == "special"){
            echo $shop->special($_POST['amount'], $_POST['itemId']);
        }
//        $data = '{"result":"success","message":"Generator purchased You have free slots in your ship. Do you want to auto-equip them or send them to your inventory?","showEquipOption":true,"userBalance":{"uridium":'.$Users->DataRow['uri'].',"credits":'.$Users->DataRow['credits'].'},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":true,"itemId":"equipment_generator_speed_g3n-1010","category":"generator"}';
//        echo $data;
    } else {
        $shop->money();
        $noacc = '{"result":"error","message":"No or invalid itemId!","userBalance":{"uridium":'.$shop->uridium.',"credits":'.$shop->credits.'},"userShip":{"laserAmmunitionSpace":3420,"rocketSpace":100},"isShipDumpEmpty":true,"itemId":"","hasPet":"true","category":false}';
        echo $noacc;
    }
//    $data2 = '{"result":"error","message":"No or invalid itemId!","userBalance":{"uridium":0,"credits":100500},"userShip":{"laserAmmunitionSpace":3420,"rocketSpace":100},"isShipDumpEmpty":true,"itemId":"","hasPet":"true","category":false}';
//    $data = '{"result":"error","message":"No or invalid itemId!","userBalance":{"uridium":'.$Users->DataRow['uri'].',"credits":'.$Users->DataRow['credits'].'},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"userPet":{"level":8,"fuel":43156,"maxFuel":50000},"itemId":"","category":false}';
//      
} else {
    echo 'eyJpc0Vycm9yIjoxLCAiZXJyb3IiOnsibWVzc2FnZSI6IkVycm9yIn19';
}
?>