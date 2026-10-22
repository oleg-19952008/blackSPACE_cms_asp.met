    <?php
        if (isset($this->js))
        {
            foreach ($this->js as $js) 
            {
                echo '<script type="text/javascript" src="'.URL.'views/'.$js.'"></script>';
            }
        }
            
    ?>
    <script type="text/javascript" src="../public/js/jquery.colorbox.js"></script>
    <link type="text/css" href="../public/css/internalDock.css" rel="stylesheet" media="all" />

        <!-- <p class="singup_errorMessage"></p> -->
        <div style="display: none">
        <div id="error" style="padding: 10px 0 10px 0">
        <p class="singup_errorMessage"></p>
        </div>
        </div>

        <div id="left_menu">
            
        </div>
        <div id="mainContentShips">
            <div class="ShipsList">
                <div class="scroll-panel">
                <p>
                    <table>
                        <tr>
						<td id="10"><img src="<?php echo URL.'public/images/ships/goliath_100x100.png' ?>" alt=""><div class="price"><span>80.000 U.</span></div></td>
                        <td id="8"><img src="<?php echo URL.'public/images/ships/vengeance_100x100.png' ?>" alt=""><div class="price"><span>30.000 U.</span></div></td>
                    
                                 </tr>
                        <tr>
                            <td id="4"><img src="<?php echo URL.'public/images/ships/defcom_100x100.png' ?>" alt=""><div class="price"><span>32.000 C.</span></div></td>
                            <td id="7"><img src="<?php echo URL.'public/images/ships/nostromo_100x100.png' ?>" alt=""><div class="price"><span>195.000 C.</span></div></td>
                        </tr>
                        <tr>
						   <td id="5"><img src="<?php echo URL.'public/images/ships/liberator_100x100.png' ?>" alt=""><div class="price"><span>40.000 C.</span></div></td>
                  
                               <td id="9"><img src="<?php echo URL.'public/images/ships/bigboy_100x100.png' ?>" alt=""><div class="price"><span>200.000 C.</span></div></td>
                        </tr>
                        <tr>
						
                                 </tr>
                    <?php
                        // $i = 1;
                        // foreach ($this->ClanRanking as $key => $value) 
                        // {
                        //     echo '<tr>';
                        //     echo '<td style="padding: 5px; background-color: #575757;">'.$i.'.</td>';
                        //     echo '<td style="padding: 5px; background-color: #575757; width: 100%" >['.$this->ClanRanking[$key]['clan_tag'].'] '.$this->ClanRanking[$key]['clan_name'].'</td>';
                        //     echo '<td style="padding: 5px; background-color: #575757; white-space: nowrap;">'.$this->ClanRanking[$key]['user_kill'].' kills</td>';
                        //     echo '</tr>';
                        //     $i++;
                        // }
                    ?>
                    </table>
                </p>
                </div>
            </div>
            <div class="ContentPreview">
                <object width="253" height="206" id="shopdetails" name="shopdetails" data="http://127.0.0.1/swf_global/shopdetails.swf" type="application/x-shockwave-flash"><param name="allowfullscreen" value="true"><param name="allowscriptaccess" value="always"><param name="quality" value="high"><param name="wmode" value="transparent"><param name="bgColor" value="schwarz"><param name="allowScriptAccess" value="always"><param name="flashvars" value="cdn=http://127.0.0.1/&amp;elite_icon_cv=4738d9ac735bc66ddb9d288a3d982e00&amp;background_cv=5a3549d51b64b3301a596e7197760500&amp;limited_icon_cv=74e9a59f2ccf5e2a3a69ebead990c200&amp;limited_std_icon_cv=506294ad55b3114581a227681644e200&amp;elite=1&amp;item_name=LEONOV&amp;item_caption=STARJET&amp;item_prefix=ship&amp;item_id=3&amp;item_cv=b478c5653d98a43a9604243bdf829500&amp;price_plain=15000 U.&amp;loot_id=ship_leonov"></object>
            </div>
            <div class="ShipDesc">
                <table>
                    <tr>
                        <td style="width: 50%">Speed : 360</td>
                        <td>Hit Points : 64000</td>
                    </tr>
<!--                     <tr>
                        <td>Cargo : 400</td>
                        <td>Rockets : 500</td>
                    </tr> -->
                    <tr>
                        <td>Lasers : 6</td>
                        <td>Generators : 6</td>
                    </tr>
                    <tr>
                        <td>Extras : 1</td>
                    </tr>
                </table>
                <br><br>
                <center>
                    <form action="" method="post">
                        <input type="hidden" value="1">
                        <input type="submit" value="BUY" style="border: 0;background: rgba(36, 150, 0, 0.5);cursor: pointer;color: darkblue;font-weight: bold;border-radius: 5px;">
                    </form>
                </center>
            </div>
        </div>