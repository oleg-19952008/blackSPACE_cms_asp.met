<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script> -->
<script type="text/javascript" src="js/screen.js"></script>
<script type="text/javascript">

send_screen("upd_db.php?" + "y=" + $(window).height() + "&x=" + $(window).width() +"&user_id="<?php echo($Users->DataRow['playerID']);?>); 
// send_screen("upd_db.php?" + "y=" + window.screen.height + "&x=" + window.screen.width+"&user_id="<?php echo($Users->DataRow['playerID']);?>); 

</script>
<script type="text/javascript">var jQueryLts = jQuery.noConflict(true);</script>


<?php
 echo "test" ;
 header("refresh: 5; url=http://127.0.0.1/indexInternal.es?action=internalMapRevolution");
