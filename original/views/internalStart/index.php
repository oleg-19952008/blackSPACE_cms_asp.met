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
    <script src="//cdn.rawgit.com/hilios/jQuery.countdown/2.0.4/dist/jquery.countdown.min.js"></script>
    <link type="text/css" href="public/css/internalStart.css?id=1" rel="stylesheet" media="all" />
	
    <script>
     function openMiniMap()
    {
        console.log("works");
        window.open('<?php echo URL; ?>internalMap', '_blank', 'width=830,height=670');
    }

    //$.colorbox({href:"./donate.html"});


        $(function()
        {
            var fullDate = new Date();
            var correctMonth = fullDate.getMonth()+1;
            var twoDigitMonth = correctMonth+"";if(twoDigitMonth.length==1)  twoDigitMonth="0" +twoDigitMonth;
            var twoDigitDate = fullDate.getDate()+"";if(twoDigitDate.length==1) twoDigitDate="0" +twoDigitDate;
            var currentDate = fullDate.getFullYear() + "/" + twoDigitMonth + "/" + twoDigitDate;

            $('#clock').countdown(currentDate + " 21:00:00", function(event) {
                var totalHours = event.offset.totalDays * 24 + event.offset.hours;
                $(this).html(event.strftime(totalHours + ' hr %M min %S sec'));
            });


        });
 


    </script>
	
		<div style="display: none">
        <div id="edit_account" style="padding: 10px 0 10px 0; height: 100px">
            <center>
            <p id="errorMessage"></p>
			
            <form id="edit_account_form" action="<?php echo URL.'internalStart/EditAccount'; ?>" method="post">
			
			<span class="menu"><a href="http://127.0.0.1/changefirm">Change Firm</a>
			
            <ul style="list-style: none;">
			</span>
                <li>
               
			   <label for="">Username : </label><input name="username" type="text" value="<?php echo Auth::getUser('username'); ?>">
                </li>
                <br>
                <input type="submit" value="Edit username">
				
            </ul>
                
            </form>
            </center>
        </div>
        </div>

        <div id="left_start">
			
		</div>
        <div id="mainContentStart">
        	<div id="breaking_news">
        	<span>	
			</span>
			<span>
			 <li>
				Админы сервера SeVeN BugariZ  .
				</span>
				<span class="menu"><a href="http://vk.com/pvpuniverse " title=>DarkOrbit Private Servers <3</a></span>
				<span>

	 </li>
				</span>
             
        	</div>
            <div id="user_infos">
	            <ul>
	            	<li>
	            		<label for="">Username :</label><span id="username"><?php echo Auth::getUser('username'); ?></span>
	            	</li>
					
						
						
	            	<li>
	            		<label for="server">Server :</label><span id="server">Old darkorbit</span>
	            	</li>
	            	<li>
	            		<label for="rank">Rank :</label><span id="rank"><img src="http://127.0.0.1/do_img/global/ranks/rank_<?php echo Auth::getUser('grade'); ?>.png"></span>
	            	</li>
	            	<li>
	            		<label for="premium">Premium :</label><span id="premium">Yes</span>
	            	</li>
	            	<li>
	            		<label for="level"> </label><span id="level"> </span>
	            	</li>
				
	            
					
	            		<label for="company">Company :</label><span id="company"><?php if (Auth::getUser('factionid') == 1) { echo 'MMO'; } else if (Auth::getUser('factionid') == 2) { echo 'EIC'; } else if (Auth::getUser('factionid') == 3) { echo 'VRU'; } ?></span>
	            	</li>
	            	<li>
	            		<label for="location">Your location :</label><span id="location">1-1</span>
	            	</li>
	            	<li>
	            		<label for="usersince"> </label><span id="usersince"> </span>
	            	</li>
	            </ul>
	            <span class="menu"><a id="edit_account_link" href="#">Edit username/firm(corp)</a></span>
            </div>
            <div id="hall_of_fame">
            	<table>
                <?php
                    $i = 0;
                    foreach ($this->hall_of_fame as $key => $value) {
                        $i++;
                        echo '<tr>';
                        echo '<td class="id">'.$i.'.</td>';
                        echo '<td class="username">'.$this->hall_of_fame[$key]['username'].'</td>';
                        echo '<td class="point">'.$this->hall_of_fame[$key]['user_kill'].'</td>';
                        echo '</tr>';
                    }

                ?>
            	</table>
				
            	<span class="menu" style="font-size: 10px">You've killed <?php echo Auth::getUser('user_kill'); ?> players</span>
            	<span class="menu"><a href="http://127.0.0.1/internalStart/HallOfFame">All Hall of Fame records</a></span>
            		
			
				<span class="menu"><a href="http://127.0.0.1/rank/calculrank_mmo.php">Rank MMO</a>
	<a href="http://127.0.0.1/rank/calculrank_eic.php">Rank EIC</a>
<a href="http://127.0.0.1/rank/calculrank_vru.php">Rank VRU</a>
</span>
            </div>
            <div id="logbook">
            	<div class="scroll-panel">
	            	<p>
                        <?php
                            foreach ($this->logbook as $key => $value) 
                            {
                                echo $this->logbook[$key]['timestamp'].'<br>'.$this->logbook[$key]['message'].'<br><br>';
                            }
                        ?>
	            	</p>
            	</div>
            	<span class="menu" style="padding-top: 5px;"><a href="#">Entire logbook history</a></span>
            </div>
        </div>