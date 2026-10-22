    <link type="text/css" href="public/css/donate.css" rel="stylesheet" media="all" />
    <script>
    function openMiniMap()
    {
        console.log("works");
        window.open('<?php echo URL; ?>internalMap', '_blank', 'width=830,height=670');
    }

    function openDonation()
    {
        window.open('<?php echo URL; ?>payment_donation', '_blank', 'width=430,height=420');
    }
    </script>
		<div id="left_start">
			
		</div>
        <div id="mainContentDonate">
            <div class="description">
                <center>
                <p style="font-size: 13px; font-weight: bold;">If you want to donate, please click on this button below.</p>
                <p style="font-size: 13px; text-decoration: underline;">What I will get by donating ?</p>
                <p>You will have a design. (Ask linkpad for setting it up).</p>
                </center>
            </div>
            <div class="button">
                <a onclick="openDonation();">I want to donate.</a>
            </div>
        </div>