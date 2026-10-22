<?php

if (isset($_POST['action'])) {
    $_GET['action'] = $_POST['action'];
}
if (isset($_GET['dontShow']) && $_GET['dontShow'] === '1'):
    exit;
endif;

require './KERNEL-DOCMS/Init.php';
if ($unity->checkIpBan($unity->get_client_ip())) {
    header('Location: http://127.0.0.1/?calmdown=99');
} else {
    
}
$Users->checkSession();
if ($Users->DataRow == null):
    header('Location: ' . SERVER);
endif;
//$rns = $base->GetRank($Users->DataRow['ID'], $Users->DataRow['playerID']);
/* if($rns['name']!="Administrator"){
  header('Location: http://DarkSpace.net/?calmdown=66');
  } */
$_SESSION['fact'] = $Users->DataRow['factionId'];
$_SESSION['premium'] = $Users->DataRow['premium'];
//$unity->gDI(array("cryptKeying","eyJwYWNrYWdlIjoidXJpZGl1bSIsImEiOjQ1MDAwLCJwcmljZSI6NSwiY3VycmVuY3kiOiJFVVIiLCJwbGF5ZXJJRCI6MTAyNywiZXJyb3IiOjB9"));
//exit;

$base->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
if ($base->checkBan()) {
    header('Location: http://127.0.0.1/?calmdown=99');
}
$unity->applyRankList($Users->DataRow['playerID']);
$unity->applyRankListNpc($Users->DataRow['playerID']);
if (isset($_GET['action'])):
    if ($_GET['action'] === 'internalCompanyChoose' && $Users->DataRow['factionId'] === '0'):
        $factory->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
        if (isset($_GET['subaction'], $_GET['factionID']) && $_GET['subaction'] === 'factionChoose' && $_GET['factionID'] > 0 && $_GET['factionID'] < 4):
            $mapId = 1;
            if ($_GET['factionID'] === '1') {
                $mapId = 1;
                $x = 1000;
                $y = 1000;
            } elseif ($_GET['factionID'] === '2') {
                $mapId = 5;
                $x = 19800;
                $y = 1000;
            } else {
                $mapId = 9;
                $x = 19600;
                $y = 11900;
            };
            $MySQLi->query('UPDATE server_1_players SET factionId = ' . $_GET['factionID'] . ', mapId = ' . $mapId . ', x = ' . $x . ', y = ' . $y . ' WHERE playerID = ' . $Users->DataRow['playerID']);

            echo 'indexInternal.es.php?action=internalStart';
            exit;
        endif;

        require FILES . 'INDEXINTERNAL/CompanyChoose_Header.php';
        require GLOBALS . 'xajax.php';
        require GLOBALS . 'internalHeader.php';
        require FILES . 'INDEXINTERNAL/CompanyChoose_Body.php';
        echo '</html>'; elseif ($Users->DataRow['factionId'] === '0'):
        header('Location: ' . SERVER . '/indexInternal.es.php?action=internalCompanyChoose');
    else:
        if ($_GET['action'] === 'internalStart'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalStart.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalStart_Body.php';
            require GLOBALS . 'ads.php';
            
elseif ($_GET['action'] === 'internalGalaxyGates'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalGalaxyGates.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalGalaxyGates_Body.php';
            require GLOBALS . 'ads.php';

        elseif ($_GET['action'] === 'internalJPA'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalGalaxyGates.css" />';

            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalJPA_Body.php';
            require GLOBALS . 'ads.php';
            
        elseif ($_GET['action'] === 'internalJPA-list'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalGalaxyGates.css" />';

            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalJPA-list_Body.php';
            require GLOBALS . 'ads.php';

        elseif ($_GET['action'] === 'internalGalaxyGates'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalGalaxyGates.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalGalaxyGates_Body.php';
            require GLOBALS . 'ads.php';
        elseif ($_GET['action'] === 'internalPayment'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalPayment.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalPayment_Body.php';
            require GLOBALS . 'ads.php';
        elseif ($_GET['action'] === 'internalHallofFame'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalHallofFame.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            if (isset($_GET['view']) && $_GET['view'] == "dailyRank"):
                require FILES . 'INDEXINTERNAL/internalHallofFame_dailyRank_Body.php';
            elseif (isset($_GET['view']) && $_GET['view'] == "User"):
                require FILES . 'INDEXINTERNAL/internalHallofFame_User_Body.php';
            elseif (isset($_GET['view']) && $_GET['view'] == "Faction"):
                require FILES . 'INDEXINTERNAL/internalHallofFame_Faction_Body.php';
			elseif (isset($_GET['view']) && $_GET['view'] == "home_exp"):
                require FILES . 'INDEXINTERNAL/internalHallofFame_home_exp_Body.php';
			elseif (isset($_GET['view']) && $_GET['view'] == "home_honor"):
                require FILES . 'INDEXINTERNAL/internalHallofFame_home_honor_Body.php';
            else:
                require FILES . 'INDEXINTERNAL/internalHallofFame_Body.php';
            endif;
            require GLOBALS . 'ads.php';
        elseif ($_GET['action'] === 'internalBalance'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalBalance.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalBalance_Body.php';
            require GLOBALS . 'ads.php';
        elseif ($_GET['action'] === 'internalEvoucher'):
            if (isset($_POST['redeem']) && isset($_POST['evoucher']) && !empty($_POST['evoucher'])) {
                $vouch->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
                $re = $vouch->redeemVoucher($_POST['evoucher']);
//                            exit;
                $log_message = $re['log_message'];
                $type = $re['type'];
            }
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalEvoucher.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalEvoucher_Body.php';
            require GLOBALS . 'ads.php'; elseif ($_GET['action'] === 'internalNewClanDetails'):
            $clan->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
            $clanid = $clan->getMyClan($Users->DataRow['playerID']);
            if ($clanid != 0):
                header('Location: /indexInternal.es.php?action=internalClan');
            endif;
            if (isset($_POST['clanName']) && isset($_POST['clanTag'])) {
                $clan->foundClan($_POST, $Users->DataRow['factionId']);
            }
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="http://127.0.0.1/css/cdn/internalNewClanDetails.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalNewClanDetails_Body.php';
            require GLOBALS . 'ads.php'; elseif ($_GET['action'] === 'internalNewClan'):
            $clan->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
            $clanid = $clan->getMyClan($Users->DataRow['playerID']);
            if ($clanid != 0):
                header('Location: /indexInternal.es.php?action=internalClan');
            endif;
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalNewClan.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalNewClan_Body.php';
            require GLOBALS . 'ads.php';
        elseif (isset($_GET['tpl']) && $_GET['tpl'] === 'internalClanChangeFirm'):
            if (isset($_GET['changefirm']) && !empty($_GET['changefirm'])) {
                if ($_GET['changefirm'] == 1 OR $_GET['changefirm'] == 2 OR $_GET['changefirm'] == 3) {
                    $clan->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
                    $re = $clan->changeFirm($_GET['changefirm']);
                    $log_message = $re['log_message'];
                    $type = $re['type'];
                }
            }
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalClan.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalClanChangeFirm_Body.php';
            require GLOBALS . 'ads.php'; elseif ($_GET['action'] === 'internalClan'):
            $clan->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
            $clanid = $clan->getMyClan($Users->DataRow['playerID']);
            if ($clanid == 0):
                header('Location: /indexInternal.es.php?action=internalNewClan');
            endif;
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalClan.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            if (isset($_GET['tpl']) && $_GET['tpl'] === 'internalClanMember'):
                $clan->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
                $clanid = $clan->getMyClan($Users->DataRow['playerID']);
                $clanInfo = $clan->getClan($clanid);
                if (isset($_POST['subAction']) && $_POST['subAction'] == "applyAccept"):
                    $clan->applyMember($clanid, $_POST['applyID']);
                elseif (isset($_POST['subAction']) && $_POST['subAction'] == "deleteMember"):
                    if ($Users->DataRow['playerID'] == $clanInfo[0]['leader']):
                        $clan->deleteMember($clanid, $_POST['removeUserID']);
                    elseif ($Users->DataRow['playerID'] == $_POST['removeUserID']):
                        $clan->deleteMember($clanid, $Users->DataRow['playerID']);
                    else:
                    endif;
                elseif (isset($_POST['subAction']) && $_POST['subAction'] == "deleteClan"):
                    $clan->deleteClan($clanid);
                else:
                endif;
                $applicants = $clan->getApplicants($clanInfo[0]['clanID']);
                $members = $clan->getMembers($clanInfo[0]['members']);
                if ($clanid == 0):
                    header('Location: /indexInternal.es.php?action=internalNewClan');
                endif;
                require FILES . 'INDEXINTERNAL/internalClanMember_Body.php';
            elseif (isset($_GET['tpl']) && $_GET['tpl'] === 'internalClanDiplomacy'):
                require FILES . 'INDEXINTERNAL/internalClanDiplomacy_Body.php';
			elseif (isset($_GET['tpl']) && $_GET['tpl'] === 'internalClanAdministrate'):
                require FILES . 'INDEXINTERNAL/internalClanAdministrate_Body.php';
            else:
                require FILES . 'INDEXINTERNAL/internalClan_Body.php';
            endif;
            //
            require GLOBALS . 'ads.php';
        elseif ($_GET['action'] === 'internalClanList'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalClan.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalClanList_Body.php';
            require GLOBALS . 'ads.php';
        elseif ($_GET['action'] === 'internalMessaging'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalMessaging.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalMessaging_Body.php';
            require GLOBALS . 'ads.php';
        elseif ($_GET['action'] === 'internalPilotSheet'):
            if (isset($_POST['subAction']) && $_POST['subAction'] == "changeUsername") {
                if ($_POST['userName'] != $Users->DataRow['Name']) {
                    if (strlen($_POST['userName']) < 3):
                        echo '{"status":"ERROR","message":"This Pilot name most be at-least 3 Characters"}';
                        exit;
                    elseif (strlen($_POST['userName']) > 40):
                        echo '{"status":"ERROR","message":"This Pilot name may not be over 40 character."}';
                        exit;
                    elseif (preg_match('/[\'\/`\!@#\$%\&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $_POST['userName'])):
                        echo '{"status":"ERROR","message":"This Pilot name can not be used."}';
                        exit;
                    endif;

                    $unity->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
                    $name = trim(mysqli_real_escape_string($MySQLi, $_POST['userName']));
                    echo $unity->changeName($name);
                    exit;
                }else {
                    echo '{"status":"ERROR","message":"This Pilot name is already in use."}';
                    exit;
                }
            }
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalPilotSheet.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalPilotSheet_Body.php';
            require GLOBALS . 'ads.php'; elseif ($_GET['action'] === 'internalUserDataChange'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/darkorbit.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalUserDataChange_Body.php';
            require GLOBALS . 'ads.php';
        elseif ($_GET['action'] === 'internalItemUpgradeSystem' OR isset($_POST['action']) && $_POST['action'] === 'internalItemUpgradeSystem'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalItemUpgradeSystem.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalItemUpgradeSystem_Body.php';
            require GLOBALS . 'ads.php';
        elseif ($_GET['action'] === 'internalSkylab'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalSkylab.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
			$Skylab->setId($Users->DataRow['ID']);
			$Skylab->initSkylab();
			$Skylab->getAllData(); // including initSkylab
			
			if(isset($_GET['subaction'])){
				if($_GET['subaction'] == "setInactive" && isset($_GET['construction'])){
					$Skylab->setStatus($_GET['construction'], "0", "status");
				}elseif($_GET['subaction'] == "upgrade"){
					$Skylab->setStatus($_GET['construction'], "2", "upthis");
				}elseif($_GET['subaction'] == "setActive"){
					$Skylab->setStatus($_GET['construction'], "1", "status");
				}elseif($_GET['subaction'] == "instantUpgrade"){
					$Skylab->setStatus($_GET['construction'], "1", "instaup");
				}/*elseif($_GET['subaction'] == ""){
				
				}*/
			}
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalSkylab_Body.php';
            require GLOBALS . 'ads.php';
			
        elseif ($_GET['action'] === 'internalBoard'):
            require GLOBALS . 'internalDoc.php';
             echo '<link rel="stylesheet" media="all" href="/css/cdn/internalAuction.css" />';
            require GLOBALS . 'internalDocEnd.php';
			
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
			
			if(isset($_GET['subaction'])){
			}
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalBoard.php';
            require GLOBALS . 'ads.php';
        elseif ($_GET['action'] === 'internalNanoTechFactory'):
            if (isset($_GET['subaction']) && $_GET['subaction'] == "deleteAllBuffs") {
                $factory->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
                $factory->deleteTech($_GET['slot']);
            } elseif (isset($_GET['subaction']) && $_GET['subaction'] == "expandHall") {
                $factory->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
                $re = $factory->expandHall($_GET['facilityID']);
                $log_message = $re['log_message'];
                $type = $re['type'];
            } elseif (isset($_GET['subaction']) && $_GET['subaction'] == "buildBuff") {
                $factory->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
                if (isset($_GET['buff'])) {
                    $buff = $_GET['buff'];
                    if (isset($_GET['instant'])) {
                        $instant = 1;
                    } else {
                        $instant = null;
                    }
                    $re = $factory->produceStart($factory->getPrices($buff, 1), $buff, $instant);
                    $log_message = $re['log_message'];
                    $type = $re['type'];
                }
            } elseif (isset($_GET['subaction']) && $_GET['subaction'] == "cancelProductin") {
                $factory->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
                if (isset($_GET['buff'])) {
                    $buff = $_GET['buff'];
                    $re = $factory->cancelProduction($buff, $_GET['slot']);
                    $log_message = $re['log_message'];
                    $type = $re['type'];
                }
            } elseif (isset($_GET['subaction']) && $_GET['subaction'] == "buynow") {
                $factory->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
                if (isset($_GET['buff'])) {
                    $buff = $_GET['buff'];
                    $re = $factory->buyNow($buff);
                    $log_message = $re['log_message'];
                    $type = $re['type'];
                }
            }
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalNanoTechFactory.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalNanoTechFactory_Body.php';
            require GLOBALS . 'ads.php'; elseif ($_GET['action'] === 'externalPassword'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/do_password.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/externalPassword_Body.php';
            require GLOBALS . 'ads.php';
        elseif ($_GET['action'] === 'internalPaymentProxy'):
            $jos = '{"mail":"' . $Users->DataRow['Email'] . '","name":"' . $Users->DataRow['Name'] . '","playerID":' . $Users->DataRow['playerID'] . '}';
          //  header('Location: http://secure.DarkSpace.net/?internalPaymentProxy=' . urlencode($Encryption->encrypt($jos)) . '');

        elseif ($_GET['action'] === 'externalLogout'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/logout.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/externalLogout_Body.php';
            require GLOBALS . 'ads.php';
        elseif ($_GET['action'] === 'internalHistory'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalHistory.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalHistory_Body.php';
            require GLOBALS . 'ads.php';
		elseif ($_GET['action'] === 'internalPaymentPartnerPromotion'):
			 require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/darkorbit.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalPaymentPartnerPromotion.php';
            require GLOBALS . 'ads.php';
        elseif ($_GET['action'] === 'internalAuction'):
            if ($unity->everisign($Users->DataRow['ID']) == 1 OR $Users->DataRow['rank'] == 21) {
                if (isset($_POST['subAction']) && $_POST['subAction'] == "bid") {
					if(isset($_SESSION['pauseAuction']) && $unity->cPT($_SESSION['pauseAuction'])==FALSE){
						$log_message = "You are not allowed to bid that many times in a row.";
                        $type = "error";
					}else{
                    if (isset($_POST['auctionType']) && $_POST['auctionType'] == "hour") {
					$c = time() + 10;
					$_SESSION['pauseAuction'] = $c;
                        $sl = explode("_", $_POST['itemId']);
                        if ($sl[2] > 100 && $sl[2] < 200) {
                            if ($_POST['credits'] < 0 || strpos($_POST['credits'], '-') !== FALSE || strpos($_POST['credits'], '.') !== FALSE) {
                                $log_message = "Bid can only contain real bids";
                                $type = "error";
                            } else {
                                $arg = $auc->nextCloseTimeDAY();
                                if ($arg['hour'] == 0 && $arg['min'] == 0 && $arg['sec'] < 10) {
                                    $log_message = "I am sorry the auction is disabled for the first 10 seconds.";
                                    $type = "error";
                                } elseif ($arg['hour'] == 23 && $arg['min'] == 59 && $arg['sec'] > 50) {
                                    $log_message = "I am sorry the auction is disabled for the last 10 seconds.";
                                    $type = "error";
                                } else {
                                    $auc->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
                                    $re = $auc->setDayBid($_POST);
                                    $log_message = $re['log_message'];
                                    $type = $re['type'];
                                }
                            }
                        } else {
                            if ($_POST['credits'] < 0 || strpos($_POST['credits'], '-') !== FALSE || strpos($_POST['credits'], '.') !== FALSE) {
                                $log_message = "Bid can only contain real bids";
                                $type = "error";
                            } else {
                                $auc->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
                                $re = $auc->setHourBid($_POST);
                                $log_message = $re['log_message'];
                                $type = $re['type'];
                            }
                        }
                    }
					}
                }
                require GLOBALS . 'internalDoc.php';
                echo '<link rel="stylesheet" media="all" href="/css/cdn/internalAuction.css" />';
                require GLOBALS . 'internalDocEnd.php';
                require GLOBALS . 'sajax.php';
                require GLOBALS . 'xajax.php';
                require GLOBALS . 'headerEndJS.php';
                require GLOBALS . 'internalMenu.php';
                require GLOBALS . 'internalHeader.php';
                require FILES . 'INDEXINTERNAL/internalAuction_Body.php';
                require GLOBALS . 'ads.php';
            } else {
                $verificationcaode = urlencode($Encryption->encrypt('{"userid":' . $Users->DataRow['ID'] . ',"email":"' . $Users->DataRow['Email'] . '"}'));
                $mailer->mailSystem(array('header' => array('mailfrom' => 'no-reply@DarkSpace.net', 'template' => 'confirmemail', 'subject' => 'Dark Space Email Confirmation'), 'content' => array('username' => $Users->DataRow['Name'], 'link' => 'http://127.0.0.1.net/emailconfirmation/?s=' . $verificationcaode, 'reasonforemail' => 'Email Verification', 'author' => 'Best Regards <br /> Dark Space Staff Team', 'year' => date('Y')), 'recivers' => array($Users->DataRow['Email'])));
                header('Location: ' . SERVER . '/emailconfirmation/?calmdown=21');
            } elseif (isset($_GET['tpl']) && $_GET['tpl'] === 'internalHandelClosed'):
            require GLOBALS . 'internalDoc.php';
            echo '<link rel="stylesheet" media="all" href="/css/cdn/internalHandel.css" />';
            require GLOBALS . 'internalDocEnd.php';
            require GLOBALS . 'sajax.php';
            require GLOBALS . 'xajax.php';
            require GLOBALS . 'headerEndJS.php';
            require GLOBALS . 'internalMenu.php';
            require GLOBALS . 'internalHeader.php';
            require FILES . 'INDEXINTERNAL/internalHandelClosed_Body.php';
            require GLOBALS . 'ads.php';
        elseif ($_GET['action'] === 'internalDock'):
            if (isset($_GET['tpl']) && $_GET['tpl'] === 'internalDockEquipment'):
                require GLOBALS . 'internalDoc.php';
                echo '<link rel="stylesheet" media="all" href="/css/cdn/internalDock.css" />';
                require GLOBALS . 'internalDocEnd.php';
                require GLOBALS . 'sajax.php';
                require GLOBALS . 'xajax.php';
                require GLOBALS . 'headerEndJS.php';
                require GLOBALS . 'internalMenu.php';
                require GLOBALS . 'internalHeader.php';
                require FILES . 'INDEXINTERNAL/internalDockEquipment_Body.php';
                require GLOBALS . 'ads.php';
            elseif (isset($_GET['tpl']) && $_GET['tpl'] === 'internalDockShips'):
                require GLOBALS . 'internalDoc.php';
                echo '<link rel="stylesheet" media="all" href="/css/cdn/internalDock.css" />';
                require GLOBALS . 'internalDocEnd.php';
                require GLOBALS . 'sajax.php';
                require GLOBALS . 'xajax.php';
                require GLOBALS . 'headerEndJS.php';
                require GLOBALS . 'internalMenu.php';
                require GLOBALS . 'internalHeader.php';
                require FILES . 'INDEXINTERNAL/internalDockShips_Body.php';
                require GLOBALS . 'ads.php';
            elseif (isset($_GET['tpl']) && $_GET['tpl'] === 'internalDockLaser'):
                require GLOBALS . 'internalDoc.php';
                echo '<link rel="stylesheet" media="all" href="/css/cdn/internalDock.css" />';
                require GLOBALS . 'internalDocEnd.php';
                require GLOBALS . 'sajax.php';
                require GLOBALS . 'xajax.php';
                require GLOBALS . 'headerEndJS.php';
                require GLOBALS . 'internalMenu.php';
                require GLOBALS . 'internalHeader.php';
                require FILES . 'INDEXINTERNAL/internalDockLaser_Body.php';
                require GLOBALS . 'ads.php';
            elseif (isset($_GET['tpl']) && $_GET['tpl'] === 'internalDockPetProtocols'):
                require GLOBALS . 'internalDoc.php';
                echo '<link rel="stylesheet" media="all" href="/css/cdn/internalDock.css" />';
                require GLOBALS . 'internalDocEnd.php';
                require GLOBALS . 'sajax.php';
                require GLOBALS . 'xajax.php';
                require GLOBALS . 'headerEndJS.php';
                require GLOBALS . 'internalMenu.php';
                require GLOBALS . 'internalHeader.php';
                require FILES . 'INDEXINTERNAL/internalDockPetProtocols_Body.php';
                require GLOBALS . 'ads.php';
            elseif (isset($_GET['tpl']) && $_GET['tpl'] === 'internalDockAmmo'):
                require GLOBALS . 'internalDoc.php';
                echo '<link rel="stylesheet" media="all" href="/css/cdn/internalDock.css" />';
                require GLOBALS . 'internalDocEnd.php';
                require GLOBALS . 'sajax.php';
                require GLOBALS . 'xajax.php';
                require GLOBALS . 'headerEndJS.php';
                require GLOBALS . 'internalMenu.php';
                require GLOBALS . 'internalHeader.php';
                require FILES . 'INDEXINTERNAL/internalDockAmmo_Body.php';
                require GLOBALS . 'ads.php';
            elseif (isset($_GET['tpl']) && $_GET['tpl'] === 'internalDockBooster'):
                require GLOBALS . 'internalDoc.php';
                echo '<link rel="stylesheet" media="all" href="/css/cdn/internalDock.css" />';
                require GLOBALS . 'internalDocEnd.php';
                require GLOBALS . 'sajax.php';
                require GLOBALS . 'xajax.php';
                require GLOBALS . 'headerEndJS.php';
                require GLOBALS . 'internalMenu.php';
                require GLOBALS . 'internalHeader.php';
                require FILES . 'INDEXINTERNAL/internalDockBooster_Body.php';
                require GLOBALS . 'ads.php';
            elseif (isset($_GET['tpl']) && $_GET['tpl'] === 'internalDockDrones'):
                require GLOBALS . 'internalDoc.php';
                echo '<link rel="stylesheet" media="all" href="/css/cdn/internalDock.css" />';
                require GLOBALS . 'internalDocEnd.php';
                require GLOBALS . 'sajax.php';
                require GLOBALS . 'xajax.php';
                require GLOBALS . 'headerEndJS.php';
                require GLOBALS . 'internalMenu.php';
                require GLOBALS . 'internalHeader.php';
                require FILES . 'INDEXINTERNAL/internalDockDrones_Body.php';
                require GLOBALS . 'ads.php';
            elseif (isset($_GET['tpl']) && $_GET['tpl'] === 'internalDockGenerator'):
                require GLOBALS . 'internalDoc.php';
                echo '<link rel="stylesheet" media="all" href="/css/cdn/internalDock.css" />';
                require GLOBALS . 'internalDocEnd.php';
                require GLOBALS . 'sajax.php';
                require GLOBALS . 'xajax.php';
                require GLOBALS . 'headerEndJS.php';
                require GLOBALS . 'internalMenu.php';
                require GLOBALS . 'internalHeader.php';
                require FILES . 'INDEXINTERNAL/internalDockGenerator_Body.php';
                require GLOBALS . 'ads.php';
            elseif (isset($_GET['tpl']) && $_GET['tpl'] === 'internalDockLaser'):
                require GLOBALS . 'internalDoc.php';
                echo '<link rel="stylesheet" media="all" href="/css/cdn/internalDock.css" />';
                require GLOBALS . 'internalDocEnd.php';
                require GLOBALS . 'sajax.php';
                require GLOBALS . 'xajax.php';
                require GLOBALS . 'headerEndJS.php';
                require GLOBALS . 'internalMenu.php';
                require GLOBALS . 'internalHeader.php';
                require FILES . 'INDEXINTERNAL/internalDockLaser_Body.php';
                require GLOBALS . 'ads.php';
            elseif (isset($_GET['tpl']) && $_GET['tpl'] === 'internalDockShipModel'):
                require GLOBALS . 'internalDoc.php';
                echo '<link rel="stylesheet" media="all" href="/css/cdn/internalDock.css" />';
                require GLOBALS . 'internalDocEnd.php';
                require GLOBALS . 'sajax.php';
                require GLOBALS . 'xajax.php';
                require GLOBALS . 'headerEndJS.php';
                require GLOBALS . 'internalMenu.php';
                require GLOBALS . 'internalHeader.php';
                require FILES . 'INDEXINTERNAL/internalDockShipModel_Body.php';
                require GLOBALS . 'ads.php';
            elseif (isset($_GET['tpl']) && $_GET['tpl'] === 'internalDockPetGear'):
                require GLOBALS . 'internalDoc.php';
                echo '<link rel="stylesheet" media="all" href="/css/cdn/internalDock.css" />';
                require GLOBALS . 'internalDocEnd.php';
                require GLOBALS . 'sajax.php';
                require GLOBALS . 'xajax.php';
                require GLOBALS . 'headerEndJS.php';
                require GLOBALS . 'internalMenu.php';
                require GLOBALS . 'internalHeader.php';
                require FILES . 'INDEXINTERNAL/internalDockPetGear_Body.php';
                require GLOBALS . 'ads.php';
            elseif (isset($_GET['tpl']) && $_GET['tpl'] === 'internalDockSpecials'):
                require GLOBALS . 'internalDoc.php';
                echo '<link rel="stylesheet" media="all" href="/css/cdn/internalDock.css" />';
                require GLOBALS . 'internalDocEnd.php';
                require GLOBALS . 'sajax.php';
                require GLOBALS . 'xajax.php';
                require GLOBALS . 'headerEndJS.php';
                require GLOBALS . 'internalMenu.php';
                require GLOBALS . 'internalHeader.php';
                require FILES . 'INDEXINTERNAL/internalDockSpecials_Body.php';
			
                require GLOBALS . 'ads.php';
            else:
                require GLOBALS . 'internalDoc.php';
                echo '<link rel="stylesheet" media="all" href="/css/cdn/internalDock.css" />';
                require GLOBALS . 'internalDocEnd.php';
                require GLOBALS . 'sajax.php';
                require GLOBALS . 'xajax.php';
                require GLOBALS . 'headerEndJS.php';
                require GLOBALS . 'internalMenu.php';
                require GLOBALS . 'internalHeader.php';
                require FILES . 'INDEXINTERNAL/internalDock_Body.php';
                 
            endif;
        elseif ($_GET['action'] === 'internalMapRevolution'):
            if ($unity->everisign($Users->DataRow['ID']) == 1) {
       //     require FILES . 'INDEXINTERNAL/res.php';
			 
		 	echo('<html> <head> <body><script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>   <script type="text/javascript" src="js/screen.js"></script>');	
    sleep(2);     require FILES . 'INDEXINTERNAL/internalMapRevolution.php';	     } else {
                $verificationcaode = urlencode($Encryption->encrypt('{"userid":' . $Users->DataRow['ID'] . ',"email":"' . $Users->DataRow['Email'] . '"}'));
                $mailer->mailSystem(array('header' => array('mailfrom' => 'no-reply@DarkSpace.net', 'template' => 'confirmemail', 'subject' => 'Dark Space Email Confirmation'), 'content' => array('username' => $Users->DataRow['Name'], 'link' => 'http://127.0.0.1/emailconfirmation/?s=' . $verificationcaode, 'reasonforemail' => 'Email Verification', 'author' => 'Best Regards <br /> Dark Space Staff Team', 'year' => date('Y')), 'recivers' => array($Users->DataRow['Email'])));
                header('Location: ' . SERVER . '/emailconfirmation/?calmdown=21');
            } elseif ($_GET['action'] === 'burnme'):
            require FILES . 'INDEXINTERNAL/burnme.php';
        endif;
    endif;
endif;
$GLOBALS['DB'] = NULL;
?>