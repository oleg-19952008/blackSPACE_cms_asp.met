    <?php
        if (isset($this->js))
        {
            foreach ($this->js as $js) 
            {
                echo '<script type="text/javascript" src="'.URL.'views/'.$js.'"></script>';
            }
        }
            
    ?>
    <script type="text/javascript" src="./public/js/jquery.colorbox.js"></script>
    <link type="text/css" href="public/css/internalClan.css" rel="stylesheet" media="all" />
    <script>
    function openMiniMap()
    {
        console.log("works");
        window.open('<?php echo URL; ?>internalMap', '_blank', 'width=830,height=670');
    }
    </script>
        <!-- <p class="singup_errorMessage"></p> -->
        <div style="display: none">
        <div id="error" style="padding: 10px 0 10px 0">
        <p class="singup_errorMessage"></p>
        </div>
        </div>
        <?php
        if( Auth::getUser('clanid') <= 1)
        {
        ?>
        <div id="left_start">
			
		</div>
        <div id="mainContentClan">
            <div id="search">Search a clan : <input type="text"></div>
            <div class="clanList">
                <div class="scroll-panel">
                <p>
                    <table id="table">
                        <?php
                            foreach ($this->ListClan as $key => $value) 
                            {
                                echo '<tr>';
                                echo '<td style="padding: 5px; background-color: #575757;">'.$this->ListClan[$key]['clan_tag'].'</td>';
                                echo '<td style="padding: 5px; background-color: #575757;" width="100%">'.$this->ListClan[$key]['clan_name'].'</td>';
                                echo '<form id="joinclan" action="'.URL.'internalClan/join" method="post">';
                                echo '<input type="hidden" name="clan_id" value="'.$this->ListClan[$key]['id'].'"/>';
                                echo '<td style="padding: 5px; background-color: #575757;"><input type="submit" value="Join"/></td>';
                                echo '</form>';
                                echo '</tr>';
                            }
                        ?>
                    </table>
                    </p>
                </div>
            </div>
            <div class="createClan">
            <form id="createclan" action="<?php echo URL; ?>internalClan/create" method="post">
                <label for="">Clan tag :</label><input type="text" name="clan_tag" maxlength="4">
                <label for="">Clan name :</label><input type="text" name="clan_name">
                <br><br><br><br>
                <center><input type="submit" value="Create clan"></center>
            </form>
            </div>
        <?php
        }
        else 
        {
        ?>
        <div id="left_menu">
            <?php include('menu.php'); ?>
        </div>
        <div id="mainContentClan">
            <div class="headline"><img src="http://en.darkorbit.bigpoint.com/do_img/global/text.esg?l=en&s=9&t=clan_hl_mitglieder&f=eurostyle_clan" alt=""></div>
            <div class="clanList">
                <div class="scroll-panel">
                <p>
                    <table>
                        <?php
                            foreach ($this->GetMyClanMembers as $key => $value) 
                            {
                                echo '<tr>';
                                echo '<td style="padding: 5px; background-color: #575757;" width="100%">'.$this->GetMyClanMembers[$key]['username'].'</td>';
                                if ($this->isAdmin == 1)
                                {
                                    if ($this->GetMyClanMembers[$key]['id'] != Session::get('account_ID'))
                                    {
                                    echo '<form action="'.URL.'internalClan/kick" method="post">';
                                    echo '<input type="hidden" name="player_id" value="'.$this->GetMyClanMembers[$key]['id'].'"/>';
                                    echo '<td style="padding: 5px; background-color: #575757;"><input type="submit" value="kick"/></td>';                                      
                                    echo '</form>';
                                    }
                                    else
                                    {
                                        echo '<td style="padding: 5px; background-color: #575757;"><a href="'.URL.'internalClan/destroy">Destroy</a></td>';
                                    }
                                }
                                elseif (Session::get('account_ID') == $this->GetMyClanMembers[$key]['id'])
                                {
                                    echo '<td style="padding: 5px; background-color: #575757;"><a href="'.URL.'internalClan/leave">Leave</a></td>';
                                }
                                else
                                {
                                    echo '<td style="padding: 5px; background-color: #575757;"></td>';
                                }
                                echo '</tr>';
                            }
                        ?>
                    </table>
                </p>
                </div>
            </div>
            <div class="second_headline"><img src="http://en.darkorbit.bigpoint.com/do_img/global/text.esg?l=en&s=9&t=clan_hl_bewerbungen&f=eurostyle_clan" alt=""></div>
            <div class="ClanRequest">
                <div class="scroll-panel">
                <p>
                    <table>
                        <?php
                        if ($this->isAdmin == 1)
                        {
                            foreach ($this->GetMyClanRequest as $key => $value) 
                            {
                                $sth = $this->db->prepare("SELECT username FROM users WHERE id=:id");
                                $sth->execute(array('id' => $this->GetMyClanRequest[$key]['player_id']));
                                $data = $sth->fetch();
                                echo '<tr>';
                                echo '<td style="padding: 5px; background-color: #575757;" width="100%">'.$data['username'].'</td>';
                                echo '<form action="'.URL.'internalClan/accept" method="post">';
                                echo '<input type="hidden" name="player_id" value="'.$this->GetMyClanRequest[$key]['player_id'].'"/>';
                                echo '<td style="padding: 5px; background-color: #575757;"><input type="submit" value="Accept"/></td>';
                                echo '</form>';
                                echo '<form action="'.URL.'internalClan/decline" method="post">';
                                echo '<input type="hidden" name="player_id" value="'.$this->GetMyClanRequest[$key]['player_id'].'"/>';
                                echo '<td style="padding: 5px; background-color: #575757;"><input type="submit" value="Decline"/></td>';
                                echo '</form>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </table>
                </p>
                </div>
            </div>
        <?php
        }
        ?>
        </div>