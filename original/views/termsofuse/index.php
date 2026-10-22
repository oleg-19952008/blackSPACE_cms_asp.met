<?php

if(!empty($_POST['submit']))
{
	$value = 1;

	Session::set('term_of_use', $value);

	

	if (Session::get('term_of_use') == 1)
	{
	    echo $_SESSION['term_of_use'];
	}
}

?>

<html>
	<head>
        <style type="text/css">
        	body
        	{
        		background-color: black;
        	}

            .msg
            {
                font-family: Verdana;
                font-size: 10px;
                background-color: rgb(90, 90, 90);
                width: 500px;
                border-radius: 5px;
                margin: auto;
                margin-top: 25%;
                padding: 10px;
                text-align: center;
            }
        </style>
	</head>
	<body>
            <div class="msg">
            	<h1>Term of use</h1>
               <u><b>User eligibility :</b></u>
				<p>The Website is available only to entities and persons who are not affiliated with Bigpoint or Dark Orbit. If You do not qualify, You are not permitted to use the Website.</p>
				<p>By accepting this Agreement, You further agree to be bound by any amendments to the terms and conditions of this Agreement or to such terms and conditions as are incorporated herein by reference.</p>
				<p><b>If you do not accept this agreement, leave this page immediately.</b></p>
				<form method="post" action="">
				<input type="submit" name ="submit" value="I agree">
				</form>
            </div>
	</body>
</html>