<?php
if(isset($_POST['change_name']) && !empty($_POST['change_name']) && isset($_POST['password']) && !empty($_POST['password'])){
    echo $Users->changeUsername($_POST['change_name'], $_POST['password'], $Users->DataRow['ID'], $Users->DataRow['playerID']);
}
?>

<html>
<head>
        <title>DarkOrbit | Private Server</title>
<style type="text/css" media="screen">    @import "http://127.0.0.1/css/cdn/darkorbit.css?__cv=17facec4ca2479025a9d5cf6f10afc00"; </style>
<style type="text/css" media="screen">    @import "http://127.0.0.1/css/cdn/do_registration.css?__cv=d23ba47be6bdac84ecd7665d04384c00"; </style>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="googlebot" content="NOODP" />
<meta name="msnbot" content="NOODP" />
<meta name="ROBOTS" content="NOYDIR" />
<meta name="Slurp" content="NOYDIR" />
<script src="http://127.0.0.1/js/function.js?__cv=9c40cf987f6122148901dc2811fba100" type="text/javascript"></script>
<script>

function choose(welche) {
        document.registerform.firma.value = welche;
        document.forms['registerform'].submit();
}

</script>

<script type="text/javascript">if (top != self) top.location = self.location;</script><!-- affiliateHeadTag -->
<link rel="meta" href="http://us4.darkorbit.bigpoint.com/sharedpages/icra/labels.php" type="application/rdf+xml" title="ICRA labels" />
<meta http-equiv="pics-Label" content='(pics-1.1 "http://www.icra.org/pics/vocabularyv03/" l gen true for "http://us4.darkorbit.bigpoint.com" r (n 0 s 0 v 0 l 1 oa 0 ob 0 oc 0 od 1 oe 0 of 0 og 0 oh 0 c 1))' />

</head>

<body>

<!-- affiliateStartTag -->



<script>

function showInfo() {
//	var win = window;
//	width_x = win.innerWidth ? win.innerWidth : win.document.body.clientWidth;
//	container_x = document.getElementById("infoPopUpContainer").style.width.substr(0,document.getElementById("infoPopUpContainer").style.width.length-2);
//	document.getElementById("infoPopUpContainer").style.left = ((width_x/2) - (container_x/2))+"px";
//	document.getElementById("infoPopUpContainer").style.top = "230px";
	document.getElementById("infoPopUpContainer").style.display = "block";
    showBusyLayer();
}

function closeAll() {
    document.getElementById("infoPopUpContainer").style.display = "none";
    hideBusyLayer();
}

</script>
<div id="infoPopUpContainer" style="position:absolute;left:50%;top:280px;width:350px;margin-left:-175px;display:none;z-index:2;">


<iframe src="indexInternal.es?action=popIF&layer=&phead=&pcont=&dosid=ea5317180d7d9fbc860f38092d789ee6" name="Bildframe" width="386" height="349" align="left" scrolling="no" marginheight="0" marginwidth="0" frameborder="0">
</iframe>

</div>
<div class="reg_container changeContainer">
	<div class="reg_top"></div>
    <div class="reg_bg">
        <div class="reg_main">
            <div style="position: relative;">
<table class="signup">
<tr>
<td>
<table class="signup signup_left">
<tr><td class="signup_label label_description">
To change your login info, complete the following steps.<br />
<br />
Step 1: Change your login info.<br />
Step 2: Open the e-mail we sent you.<br />
Step 3: Click on the security link in the e-mail.<br />
<br />
To change your e-mail address, we will send an e-mail with a security link to your old address. Once you've clicked on the security link in this e-mail, another e-mail with a security link will be sent to your new e-mail account.<br />
<br />
Please click on that link to confirm your new e-mail address. These steps are necessary to complete in order to ensure maximum account security.<br />
<br />
Security tip: A good password contains lower-case and upper-case letters as well as numbers, and is at least 6 characters long!</td></tr>
</table>
</td>
<td>
<form name="userDataChangeForm" id="userDataChangeForm" method="post" action="/indexInternal.es?action=internalUserDataChange">
<table class="signup signup_right">
<tr>
<td class="signup_label label_info" colspan="2">Please enter your e-mail address to change your username, password or e-mail address. To ensure account security and prevent any unauthorized persons from changing your login data, we will send a confirmation link to this e-mail address. Just open the e-mail and click on the link to confirm the changes.<br /><br /></td>
</tr>
<tr>
<td class="signup_label label_email">
E-mail:</td>
<td>
<input type="text" name="change_email" value="<?php echo $Users->DataRow['Email']; ?>" class="input_text" /></td>
</tr>
<tr>
<td class="signup_label label_password">
Current password:</td>
<td>
<input type="password" name="password" value="" class="input_text" /></td>
</tr>
<tr>
<td class="align_buttonRegister">
<input type="button" value="Back" class="input_button signup_back" onclick="location.href='/indexInternal.es?action=internalStart'"/></td>
<td class="align_buttonRegister">
<input type="submit" name="change_submit" value="Next" class="input_button change_resendSubmit" /></td>
</tr>
</table>
</form>
</td>
</tr>
</table>
</div>
        </div>
    </div>
    <div class="reg_foot"></div>
</div>

<script>
</script>

<!-- affiliateEndTag -->
<!-- SEMGOOGLE RTPixel START --><!-- Google Code for DO All Visitors Remarketing List -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 987297406;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "jcNlCILztAIQ_uzj1gM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
 


</body>
</html>