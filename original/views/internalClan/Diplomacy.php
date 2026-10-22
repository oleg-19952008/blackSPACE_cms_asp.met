    <?php
        if( Auth::getUser('clanid') <= 1)
        {
        	header('location: '.URL.'index');
        	exit;
        }

        if (isset($this->js))
        {
            foreach ($this->js as $js) 
            {
                echo '<script type="text/javascript" src="'.URL.'views/'.$js.'"></script>';
            }
        }
            
    ?>
    <script type="text/javascript" src="../public/js/jquery.colorbox.js"></script>
    <link type="text/css" href="../public/css/internalClan.css" rel="stylesheet" media="all" />
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

        <div id="left_menu">
            <?php include('menu.php'); ?>
        </div>
        <div id="mainContentClanDiplomacy">
			<div class="headline"><img src="http://en.darkorbit.bigpoint.com/do_img/global/text.esg?l=en&s=9&t=clan_hl_clan_diplomatie&f=eurostyle_clan" alt=""></div>
            <div class="DiplomacyList">
                <div class="scroll-panel">
                <p>
                    <table>
                    <?php
                        foreach ($this->ListDiplomacy as $key => $value) 
                        {
                            echo '<tr>';
                            echo '<td style="padding: 5px; background-color: #575757;" width="100%">['.$this->ListDiplomacy[$key]['clan_tag'].'] '.$this->ListDiplomacy[$key]['clan_name'].'</td>';
                            echo '<td style="padding: 5px; background-color: #575757;">War</td>';
                            if ($this->isAdmin == 1)
                            {
                                echo '<form id="CancelDiplomacy" action="'.URL.'internalClan/CancelDiplomacy" method="post">';
                                echo '<input type="hidden" name="diplomacy_id" value="'.$this->ListDiplomacy[$key]['id'].'"/>';
                                echo '<td style="padding: 5px; background-color: #575757;"><input type="submit" style="background: 0; border: 0; margin: 0; color: lightblue;" value="Cancel"/></td>';
                                echo '</form>';
                            }
                            else
                            {
                                echo '<td></td>';
                            }
                            echo '</tr>';
                        }
                    ?>
                    <?php
                        foreach ($this->ListSecondDiplomacy as $key => $value) 
                        {
                            echo '<tr>';
                            echo '<td style="padding: 5px; background-color: #575757;" width="100%">['.$this->ListSecondDiplomacy[$key]['clan_tag'].'] '.$this->ListSecondDiplomacy[$key]['clan_name'].'</td>';
                            echo '<td style="padding: 5px; background-color: #575757;">War</td>';
                            echo '<td style="background-color: #575757;"></td>';
                            echo '</tr>';
                        }
                    ?>
                    </table>
                </p>
                </div>
            </div>
            <div class="second_headline"><img src="http://en.darkorbit.bigpoint.com/do_img/global/text.esg?l=en&s=9&t=clan_hl_anfragen&f=eurostyle_clan" alt=""></div>
            <?php 
            if ($this->isAdmin == 1)
            {
            ?>
            <div class="DiplomacyRequest">
                <div class="scroll-panel">
                <p>
                    <table>
                    </table>
                </p>
                </div>
            </div>
            <div class="third_headline"><img src="http://en.darkorbit.bigpoint.com/do_img/global/text.esg?l=en&s=9&t=clan_hl_diplo_beantragen&f=eurostyle_clan" alt=""></div>
            <div class="DiplomacyApply">
            <form action="<?php echo URL.'internalClan/DiplomacyRequest'?>" method="post">
                <select name="clan_id" id="" class="text-search">
                    <?php
                        foreach ($this->ListClan as $key => $value) 
                        {
                            echo '<option value="'.$this->ListClan[$key]['id'].'">['.$this->ListClan[$key]['clan_tag'].'] '.$this->ListClan[$key]['clan_name'].'</option>';
                        }
                    ?>
                </select>
                <select name="diplomacy_type" id="" class="text-search">
                    <option value="1">War</option>
                    <option value="2">Non-Aggression Pact</option>
                </select>
                <input type="submit" value="send">
            </form>
            </div>
            <?php               
            }
            ?>
        </div>