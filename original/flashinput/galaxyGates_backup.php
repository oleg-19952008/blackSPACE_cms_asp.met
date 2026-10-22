<?php
 require_once '../../KERNEL-DOCMS/Init.php';
if(isset($_SESSION['server1']['user']['sessionId'])){
//     require_once '../../KERNEL-DOCMS/Init.php';
    $Users->checkSession();
    $GalaxyGate->GetGates($Users->DataRow['playerID'], $Users->DataRow['ID']);
//    $GalaxyGate->proberbiliteis();
    $discount = 0;
    $useCredits = 0;
    if($useCredits != 0){
        $credits = 10;
    }else{
        $credits = 1;
    }
    if($Users->DataRow['premium']==1){
        if($discount==1){
            $cost = 70;
        }else{
            $cost = 95;
        }
    }else{
        if($discount==1){
            $cost = 75;
        }else{
            $cost = 100;
        }
    }
     if(isset($_GET['saveSpinAmount'])){
         $_SESSION['spinamount']=$_GET['value'];
     }elseif(isset($_GET['spinamount'])){
         $_SESSION['spinamount']=$_GET['spinamount'];
     }else{ 
         $_SESSION['spinamount']=1;
     }
    
     
     if(isset($_GET['gateID']) && !empty($_GET['gateID'])){
         $_SESSION['gateID'] = $_GET['gateID'];
     }elseif($_SESSION['gateID']!=1 OR $_SESSION['gateID']!=0){
         $_SESSION['gateID'] = $_SESSION['gateID'];
     }else{
        $_SESSION['gateID']=1; 
     }
//    print_r($GalaxyGate->dataCon);
//    print_r($GalaxyGate->dataGates);
//    print_r($_SESSION['spinamount']);
//    print_r($_SESSION['gateID']);
//    print_r($GalaxyGate->spinerUri($Users->DataRow['uri'], $_SESSION['spinamount'], $cost, $Users->DataRow['playerID'], $Users->DataRow['ID'], $_SESSION['gateID']));
?>
<?xml version="1.0" encoding="utf-8" ?>
<jumpgate>
<mode>standard</mode>
<money><?php echo $Users->DataRow['uri']; ?></money>
<samples><?php echo $Users->DataRow['GGspins']; ?></samples>
<spinamount_selected><?php echo $_SESSION['spinamount']; ?></spinamount_selected>
<energy_cost mode="standard"><?php echo $cost * $credits; ?></energy_cost>
<hadesGateDialog>0</hadesGateDialog>
<multipliers>
    <?php 
//        if(isset($_GET['multiplier'])){
//            $_SESSION['multiplier'] = 3;
//         }else{
//           $_SESSION['multiplier'] = 0;
//       }
    function runGateOnce(){
         return $GalaxyGate->AllGat;
    }
    echo $GalaxyGate->AllGat;
//    foreach($GalaxyGate->AllGat as $keysw => $valuesw){
////        print_r($valuesw);
//echo '<multiplier mode="'.$valuesw->galaxygate_name.'" value="'.$valuesw->galaxygate_multipliers.'" state="'.$valuesw->galaxygate_multipliers.'" />
//';
//    }
    ?>
</multipliers>
<probabilities>
<probability mode="alpha">
<cat id="ammunition" percentage="67" />
<cat id="resource" percentage="12" />
<cat id="voucher" percentage="3" />
<cat id="logfile" percentage="1" />
<cat id="part" percentage="13" />
<cat id="ammo_x2" percentage="35" />
<cat id="ammo_x3" percentage="25" />
<cat id="ammo_x4" percentage="10" />
<cat id="ammo_abs" percentage="20" />
<cat id="ammo_rocket" percentage="5" />
<cat id="ammo_mine" percentage="5" />
<cat id="gate_1" percentage="0" />
<cat id="gate_2" percentage="0" />
<cat id="gate_3" percentage="0" />
<cat id="gate_4" percentage="100" />
<cat id="gate_5" percentage="0" />
<cat id="gate_6" percentage="0" />
<cat id="gate_7" percentage="0" />
<cat id="gate_8" percentage="0" />
<cat id="gate_13" percentage="0" />
<cat id="special" percentage="4" />
<cat id="special_hitpoints" percentage="100" />
</probability>
<probability mode="beta">
<cat id="ammunition" percentage="67" />
<cat id="resource" percentage="12" />
<cat id="voucher" percentage="3" />
<cat id="logfile" percentage="1" />
<cat id="part" percentage="13" />
<cat id="ammo_x2" percentage="35" />
<cat id="ammo_x3" percentage="25" />
<cat id="ammo_x4" percentage="10" />
<cat id="ammo_abs" percentage="20" />
<cat id="ammo_rocket" percentage="5" />
<cat id="ammo_mine" percentage="5" />
<cat id="gate_1" percentage="0" />
<cat id="gate_2" percentage="0" />
<cat id="gate_3" percentage="0" />
<cat id="gate_4" percentage="100" />
<cat id="gate_5" percentage="0" />
<cat id="gate_6" percentage="0" />
<cat id="gate_7" percentage="0" />
<cat id="gate_8" percentage="0" />
<cat id="gate_13" percentage="0" />
<cat id="special" percentage="4" />
<cat id="special_hitpoints" percentage="100" />
</probability>
<probability mode="gamma">
<cat id="ammunition" percentage="67" />
<cat id="resource" percentage="12" />
<cat id="voucher" percentage="3" />
<cat id="logfile" percentage="1" />
<cat id="part" percentage="13" />
<cat id="ammo_x2" percentage="35" />
<cat id="ammo_x3" percentage="25" />
<cat id="ammo_x4" percentage="10" />
<cat id="ammo_abs" percentage="20" />
<cat id="ammo_rocket" percentage="5" />
<cat id="ammo_mine" percentage="5" />
<cat id="gate_1" percentage="0" />
<cat id="gate_2" percentage="0" />
<cat id="gate_3" percentage="0" />
<cat id="gate_4" percentage="100" />
<cat id="gate_5" percentage="0" />
<cat id="gate_6" percentage="0" />
<cat id="gate_7" percentage="0" />
<cat id="gate_8" percentage="0" />
<cat id="gate_13" percentage="0" />
<cat id="special" percentage="4" />
<cat id="special_hitpoints" percentage="100" />
</probability>
<probability mode="delta">
<cat id="ammunition" percentage="67" />
<cat id="resource" percentage="12" />
<cat id="voucher" percentage="3" />
<cat id="logfile" percentage="1" />
<cat id="part" percentage="13" />
<cat id="ammo_x2" percentage="35" />
<cat id="ammo_x3" percentage="25" />
<cat id="ammo_x4" percentage="10" />
<cat id="ammo_abs" percentage="20" />
<cat id="ammo_rocket" percentage="5" />
<cat id="ammo_mine" percentage="5" />
<cat id="gate_1" percentage="0" />
<cat id="gate_2" percentage="0" />
<cat id="gate_3" percentage="0" />
<cat id="gate_4" percentage="100" />
<cat id="gate_5" percentage="0" />
<cat id="gate_6" percentage="0" />
<cat id="gate_7" percentage="0" />
<cat id="gate_8" percentage="0" />
<cat id="gate_13" percentage="0" />
<cat id="special" percentage="4" />
<cat id="special_hitpoints" percentage="100" />
</probability>
<probability mode="epsilon">
<cat id="ammunition" percentage="67" />
<cat id="resource" percentage="12" />
<cat id="voucher" percentage="3" />
<cat id="logfile" percentage="1" />
<cat id="part" percentage="13" />
<cat id="ammo_x2" percentage="35" />
<cat id="ammo_x3" percentage="25" />
<cat id="ammo_x4" percentage="10" />
<cat id="ammo_abs" percentage="20" />
<cat id="ammo_rocket" percentage="5" />
<cat id="ammo_mine" percentage="5" />
<cat id="gate_1" percentage="0" />
<cat id="gate_2" percentage="0" />
<cat id="gate_3" percentage="0" />
<cat id="gate_4" percentage="0" />
<cat id="gate_5" percentage="100" />
<cat id="gate_6" percentage="0" />
<cat id="gate_7" percentage="0" />
<cat id="gate_8" percentage="0" />
<cat id="gate_13" percentage="0" />
<cat id="special" percentage="4" />
<cat id="special_hitpoints" percentage="100" />
</probability>
<probability mode="zeta">
<cat id="ammunition" percentage="67" />
<cat id="resource" percentage="12" />
<cat id="voucher" percentage="3" />
<cat id="logfile" percentage="1" />
<cat id="part" percentage="13" />
<cat id="ammo_x2" percentage="35" />
<cat id="ammo_x3" percentage="25" />
<cat id="ammo_x4" percentage="10" />
<cat id="ammo_abs" percentage="20" />
<cat id="ammo_rocket" percentage="5" />
<cat id="ammo_mine" percentage="5" />
<cat id="gate_1" percentage="0" />
<cat id="gate_2" percentage="0" />
<cat id="gate_3" percentage="0" />
<cat id="gate_4" percentage="0" />
<cat id="gate_5" percentage="0" />
<cat id="gate_6" percentage="100" />
<cat id="gate_7" percentage="0" />
<cat id="gate_8" percentage="0" />
<cat id="gate_13" percentage="0" />
<cat id="special" percentage="4" />
<cat id="special_hitpoints" percentage="100" />
</probability>
<probability mode="kappa">
<cat id="ammunition" percentage="67" />
<cat id="resource" percentage="12" />
<cat id="voucher" percentage="3" />
<cat id="logfile" percentage="1" />
<cat id="part" percentage="13" />
<cat id="ammo_x2" percentage="35" />
<cat id="ammo_x3" percentage="25" />
<cat id="ammo_x4" percentage="10" />
<cat id="ammo_abs" percentage="20" />
<cat id="ammo_rocket" percentage="5" />
<cat id="ammo_mine" percentage="5" />
<cat id="gate_1" percentage="0" />
<cat id="gate_2" percentage="0" />
<cat id="gate_3" percentage="0" />
<cat id="gate_4" percentage="0" />
<cat id="gate_5" percentage="0" />
<cat id="gate_6" percentage="0" />
<cat id="gate_7" percentage="100" />
<cat id="gate_8" percentage="0" />
<cat id="gate_13" percentage="0" />
<cat id="special" percentage="4" />
<cat id="special_hitpoints" percentage="100" />
</probability>
<probability mode="lambda">
<cat id="ammunition" percentage="67" />
<cat id="resource" percentage="12" />
<cat id="voucher" percentage="3" />
<cat id="logfile" percentage="1" />
<cat id="part" percentage="13" />
<cat id="ammo_x2" percentage="35" />
<cat id="ammo_x3" percentage="25" />
<cat id="ammo_x4" percentage="10" />
<cat id="ammo_abs" percentage="20" />
<cat id="ammo_rocket" percentage="5" />
<cat id="ammo_mine" percentage="5" />
<cat id="gate_1" percentage="0" />
<cat id="gate_2" percentage="0" />
<cat id="gate_3" percentage="0" />
<cat id="gate_4" percentage="0" />
<cat id="gate_5" percentage="0" />
<cat id="gate_6" percentage="0" />
<cat id="gate_7" percentage="0" />
<cat id="gate_8" percentage="100" />
<cat id="gate_13" percentage="0" />
<cat id="special" percentage="4" />
<cat id="special_hitpoints" percentage="100" />
</probability>
<probability mode="hades">
<cat id="ammunition" percentage="67" />
<cat id="resource" percentage="12" />
<cat id="voucher" percentage="3" />
<cat id="logfile" percentage="1" />
<cat id="part" percentage="13" />
<cat id="ammo_x2" percentage="35" />
<cat id="ammo_x3" percentage="25" />
<cat id="ammo_x4" percentage="10" />
<cat id="ammo_abs" percentage="20" />
<cat id="ammo_rocket" percentage="5" />
<cat id="ammo_mine" percentage="5" />
<cat id="gate_1" percentage="0" />
<cat id="gate_2" percentage="0" />
<cat id="gate_3" percentage="0" />
<cat id="gate_4" percentage="0" />
<cat id="gate_5" percentage="0" />
<cat id="gate_6" percentage="0" />
<cat id="gate_7" percentage="0" />
<cat id="gate_8" percentage="0" />
<cat id="gate_13" percentage="100" />
<cat id="special" percentage="4" />
<cat id="special_hitpoints" percentage="100" />
</probability>
</probabilities>
<gates>
<?php 
$i = 0;
 foreach($GalaxyGate->dataGates as $conf){

     echo '<gate total="'.$conf['galaxygate_part'].'" current="'.$GalaxyGate->dataCon[$i]['galaxygate_current_parts'].'" id="'.$conf['galaxygate_id'].'" prepared="'.$GalaxyGate->dataCon[$i]['galaxygate_prepared'].'" totalWave="'.$conf['galaxygate_totalWave'].'" currentWave="'.$GalaxyGate->dataCon[$i]['galaxygate_current_wave'].'" state="'.$GalaxyGate->dataCon[$i]['state'].'" livesLeft="'.$GalaxyGate->dataCon[$i]['livesLeft'].'" lifePrice="'.$conf['lifePrice'].'" />';
     $i++;
     
 }
?>
</gates>
<spinamounts>
<spinamount>1</spinamount>
<spinamount>5</spinamount>
<spinamount>10</spinamount>
<spinamount>100</spinamount>
<spinamount>1000</spinamount>
</spinamounts>
<boosts>
</boosts>
<items>
    <?php
    
    if(isset($_GET['multiplier']) && !empty($_GET['multiplier']) && $_GET['multiplier']!=0){
         $GalaxyGate->setMulti(1);
     }else{
        $GalaxyGate->setMulti(0);
     }
    if(isset($_GET['action']) && $_GET['action']=="multiEnergy"){
            echo $GalaxyGate->spinerUri($Users->DataRow['uri'], $_SESSION['spinamount'], $cost, $Users->DataRow['playerID'], $Users->DataRow['ID'], $_SESSION['gateID']);
//         print_r($GalaxyGate->spinerUri($Users->DataRow['uri'], $_SESSION['spinamount'], $cost, $Users->DataRow['playerID'], $Users->DataRow['ID'], $_SESSION['gateID']));
            
            
    }
    ?>
</items>
</jumpgate>
<?php
}else{
    header('Location: ../index.php');
}
?>