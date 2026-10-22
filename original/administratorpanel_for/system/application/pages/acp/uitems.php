<?php

class Subpage {

    static $data = array
        (
        'message' => 'You can manage your users here.',
        'color' => 'green',
        'user' => array(),
        'kinds' => array(),
        'all' => array(),
        'uitems' => array(),
        'type' => 'username',
        'search' => '',
        'results' => array(),
    );

    static function Build() {
        if (User::$isAdmin == FALSE) {
            redirect();
        }
        if (isset($_GET['RestrictedApi'])) {
            define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
            if (!IS_AJAX) {
                die('Restricted');
            }
            if (isset($_GET['add']) && $_GET['add'] == "yes") {
                echo self::addItem($_GET['lootid'], $_GET['pid'], $_GET['uid']);
            } elseif (isset($_GET['delete']) && $_GET['delete'] == "yes") {
                echo self::delItem($_GET['lootid'], $_GET['pid'], $_GET['uid']);
            } else {
                $encode = '{"status":"error"}';
                echo $encode;
            }
        } else {
            if (User::$isAdmin == FALSE) {
                redirect();
            }

            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                DB::query("SELECT * FROM server_1_player_all_items INNER JOIN server_shop_items ON server_shop_items.lootId=server_1_player_all_items.lootid WHERE server_1_player_all_items.playerID = '{$_GET['id']}'");

                if (DB::num_rows() > 0) {
                    $mess = DB::fetch_array();
                    $sort = array();
                    foreach ($mess as $k => $v):
                        if (array_key_exists($v['C'], $sort)):
                            array_push($sort[$v['C']], $v);
                        else:
                            $sort[$v['C']] = array();
                            array_push($sort[$v['C']], $v);
                        endif;
                    endforeach;
                    self::$data['uitems'] = $sort;

                    if (isset($_POST['edit'])) {
                        self::edit_user();
                    }
                    self::$data['message'] = "You're editing Items";
                }
                DB::query("SELECT C FROM server_shop_items");
                if (DB::num_rows() > 0) {
                    $C = DB::fetch_array();
                    $once = array();
                    foreach ($C as $k => $v):
                        if (in_array($v['C'], $once)):

                        else:
                            array_push($once, $v['C']);
                        endif;
                    endforeach;
                    self::$data['kinds'] = $once;
                }

                DB::query("SELECT * FROM server_shop_items");
                if (DB::num_rows() > 0) {
                    $mess = DB::fetch_array();
                    $sort = array();
                    foreach ($mess as $k => $v):
                        if (array_key_exists($v['C'], $sort)):
                            array_push($sort[$v['C']], $v);
                        else:
                            $sort[$v['C']] = array();
                            array_push($sort[$v['C']], $v);
                        endif;
                    endforeach;
                    self::$data['all'] = $sort;
                }
                else {
                    $_GET['id'] = 'text';
                }
            } elseif (isset($_GET['type']) && isset($_GET['search'])) {
                self::$data['type'] = $_GET['type'];
                self::$data['search'] = $_GET['search'];
                self::search();
            }

            Load::view('uitems', self::$data, TRUE);
        }
    }
        static function delItem($lootid, $pid, $uid) {
            $loot = self::checkItemLoot($lootid, $pid, $uid);
            if($loot[0]['lootid']=="pet_pet10"){
                return '{"status":"true", "id":"0"}';
            }else{
                $del = DB::query("DELETE FROM server_1_player_all_items WHERE id = '$lootid' && playerID='$pid' && userID='$uid'");
                if($del) { 
                   self::Wipe($lootid, $pid, $uid);
                $encode = '{"status":"true", "id":"' . $_GET['lootid'] . '"}';
                }else{    
                $encode = '{"status":"false", "id":"' . $_GET['lootid'] . '"}';
                }
                return $encode;
            }
            }
            
            static function Wipe($lootid, $pid, $uid){
                $sqli = "UPDATE server_1_hangar_config_ship AS s SET s.lasers = '', s.generators = '', s.heavy_guns = '', s.extras = '' WHERE ";
                $sqli .= " s.playerID='$pid' && s.userID='$uid' ";
                DB::query($sqli);
                
                $sql = "UPDATE server_1_hangar_config_drones SET EQ = '', EQ2 = '', design2 = '', design = '' WHERE ";
                $sql .= "playerID='$pid' && userID='$uid'";
                DB::query($sqli);
            }
            static function checkItemLoot($lootid, $pid, $uid){
                 DB::query("SELECT * FROM server_1_player_all_items WHERE id = '$lootid'");
                    if (DB::num_rows() > 0) {
                        $item = DB::fetch_array();
                        return $item;
                    }
            }
    static function addItem($lootid, $pid, $uid) {
        DB::query("SELECT * FROM server_shop_items WHERE lootId = '$lootid'");
        if (DB::num_rows() > 0) {
            $item = DB::fetch_array();
            if($item[0]['C']=="ship"){
                self::Wipe($lootid, $pid, $uid);
                return self::itemReg($lootid, $uid, $pid, 1, 1);
            }elseif($item[0]['C']=="drone" && $lootid=="drone_flax" OR $lootid=="drone_iris" OR $lootid=="drone_apis" OR $lootid=="drone_zeus"){
                self::Wipe($lootid, $pid, $uid);
            }else{
                self::Wipe($lootid, $pid, $uid);
                return self::itemReg($lootid, $uid, $pid, 0, 1);
            }
            $encode = '{"status":"true", "id":"' . $pid . '"}';
        } else {
            $encode = '{"status":"false", "id":"' . $uid . '"}';
        }

        return $encode;
    }

    static function itemReg($lid, $uid, $pid, $inter, $am) {
        $id = DB::query("INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES ('$lid', '$am', '$inter', '$pid', '$uid')", FALSE, TRUE);
        return '{"status":"true", "id":"' . $id . '"}';
    }

    static function search() {
        $search = $_GET['search'];
        $type = $_GET['type'];
        if ($type == "playerID"):
            DB::query("SELECT * FROM server_1_players INNER JOIN users ON server_1_players.userID=users.ID WHERE server_1_players.playerID='$search'");
        else:
            DB::query("SELECT * FROM users INNER JOIN server_1_players ON users.ID=server_1_players.userID WHERE $type LIKE '%$search%'");
        endif;
        if (DB::num_rows() > 0) {
            self::$data['results'] = DB::fetch_array();
        }
    }

    static function getRank($rank) {
        DB::select('rank', ' id = ' . $rank . '');
        if (DB::num_rows() > 0) {
            $re = DB::fetch_row();
            return $re['name'];
        }
        return "unknown";
    }

    static function edit_user() {
        self::$data['color'] = 'red';

        $id = $_GET['id'];
        if ($_POST['factionId'] == "Is Premium"):
            $pre = 1;
        else:
            $pre = 0;
        endif;
        $q = "UPDATE server_1_players SET ";
        $q .= "`factionId`='" . $_POST['factionId'] . "', `premium`='" . $pre . "', `jackpot` = '" . $_POST['jackpot'] . "', `honor` = '" . $_POST['honor'] . "', `uri` = '" . $_POST['uri'] . "', `credits` = '" . $_POST['credits'] . "', `GGspins` = '" . $_POST['GGspins'] . "' ";

        self::$data['color'] = 'green';
        self::$data['message'] = 'Successfully saved settings';
        $q .= " WHERE `playerID` = " . trim($_POST['playerID']) . " LIMIT 1";
        DB::query($q);

        //Now, we need to update the info
        DB::query("SELECT * FROM users INNER JOIN server_1_players ON users.ID=server_1_players.userID WHERE users.ID= '" . $_GET['id'] . "' LIMIT 1");
//		DB::query("SELECT * FROM users WHERE id = '".$_GET['id']."' LIMIT 1");
        self::$data['user'] = DB::fetch_row();
    }

    static function message($message, $color = 'red') {
        self::$data['message'] = '<b style=\'color:' . $color . ';\'>' . $message . '</b>';
    }

}
