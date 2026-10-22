<?php

$currentFirm = Auth::getUser('factionid');
$array_faction = array(1 => 'Mars Mining Operations (MMO)', 2 => 'Earth Industries Corporation (EIC)', 3 => 'Venus Resources Unlimited (VRU)');

?>
    <link type="text/css" href="public/css/changeFirm.css" rel="stylesheet" media="all" />
    <script>
    function openMiniMap()
    {
        console.log("works");
        window.open('<?php echo URL; ?>internalMap', '_blank', 'width=830,height=670');
    }
    </script>
		<div id="left_start">
			
		</div>
        <div id="mainContentFirm">
        	<div class="title"></div>
            <div class="currentFirm">
            <img src="<?php echo URL;?>public/images/faction<?php echo $currentFirm ?>.jpg">
            <span class="name"><?php echo $array_faction[$currentFirm]; unset($array_faction[$currentFirm]); ?></span>
            </div>
            <div class="infosFirm">
            <?php
                $members_count = 0;
                $kill_count = 0;
                foreach ($this->FirmInfos as $key => $value) {
                    $members_count += 1;
                    $kill_count += $this->FirmInfos[$key]['user_kill'];
                }
            ?>
            <span>Members: <?php echo $members_count; ?></span><br>
            <span>Ships destroyed: <?php echo $kill_count; ?></span>
            </div>
            <div class="changeFirm">
            <?php
                $first = 0;
                foreach ($array_faction as $key => $value) 
                {
                    if ($first == 0)
                    {
                        echo '<form action="'.URL.'changeFirm/Update" method="post">';
                        echo '<input type="hidden" name="factionid" value="'.$key.'">';
                        echo '<input type="submit" class="faction'.$key.'" value="">';
                        echo '</form>';
                        echo '<span>Switch FIRM</span>';
                        $first = 1;
                    }
                    else
                    {
                        echo '<form action="'.URL.'changeFirm/Update" method="post">';
                        echo '<input type="hidden" name="factionid" value="'.$key.'">';
                        echo '<input type="submit" class="faction'.$key.'" value="" style="float: right;">';
                        echo '</form>';
                    }
                }
                ?>
            </div>
        </div>