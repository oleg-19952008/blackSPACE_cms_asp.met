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
        <div id="mainContentClanRanking">
            <div class="ClanRanking">
                <div class="scroll-panel">
                <p>
                    <table>
                    <?php
                        $i = 1;
                        foreach ($this->ClanRanking as $key => $value) 
                        {
                            echo '<tr>';
                            echo '<td style="padding: 5px; background-color: #575757;">'.$i.'.</td>';
                            echo '<td style="padding: 5px; background-color: #575757; width: 100%" >['.$this->ClanRanking[$key]['clan_tag'].'] '.$this->ClanRanking[$key]['clan_name'].'</td>';
                            echo '<td style="padding: 5px; background-color: #575757; white-space: nowrap;">'.$this->ClanRanking[$key]['user_kill'].' kills</td>';
                            echo '</tr>';
                            $i++;
                        }
                    ?>
                    </table>
                </p>
                </div>
            </div>
        </div>