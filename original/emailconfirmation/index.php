<?php
require '../KERNEL-DOCMS/Init.php';
if(isset($_GET['s'])){  
    $re = $unity->emailVerify(json_decode($Encryption->decrypt($_GET['s'])));
}else{
    if(isset($_GET['calmdown']) && !empty($_GET['calmdown'])){
        $calmdowns = array(21=>'EMAIL VERIFICATION IS MISSING!');
		if(!empty($calmdowns[$_GET['calmdown']])){
		
        $re = $calmdowns[$_GET['calmdown']];
		}else{
		$re = "";
		}
    }else{
        $re = ""; 
    }    
}

?>
<html>
<head>
    <title>Dark Space Email Verification</title>
</head>
<body>    
<div style="width: 600px ; margin: 0 auto;">
    <table border="0" cellpadding="0" cellspacing="0" width="600">
        <tbody>
            <tr>
                <td style="background-color: #ffffff;"></td>
                <td width="600">
                    <table border="0" cellpadding="0" cellspacing="0" width="600">
                        <tbody>
                            <tr>
                            </tr></tbody>
                    </table>
                    <table border="0" cellpadding="0" cellspacing="0" height="315" width="602">
                        <tbody>
                            <tr>
                                <td width="600">
                                    <img height="315" style="display: block; border: 0px solid;" width="598" src="http://darkorbit.tv/DarkSpace/DPMailHeader.jpg">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table border="0" cellpadding="0" cellspacing="0" style="background-color: rgb(225, 225, 225); overflow: hidden;" width="600" height="22" valign="bottom">
                        <tbody>
                            <tr>
                                <td width="600" valign="bottom"></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <table border="0" cellpadding="0" cellspacing="0" style="background-color: rgb(242, 242, 242); text-align: center;" width="600">
                        <tbody>
                            <tr>
                                <td width="12"></td>
                                <td valign="top" width="376">
                                    <table border="0" cellpadding="0" cellspacing="0" width="376">
                                        <tbody>
                                            <tr>
                                                <td><img border="0" height="12" style="display: block; border: none;" width="1" src="http://darkorbit.tv/DarkSpace/spacer.png"></td>
                                            </tr>                                            
                                            <tr>
                                                <td width="376"><img border="0" height="12" style="display: block; border: none;" width="1" src="http://webr.emv2.com/bp_bigpoint/img/spacer.png"></td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="color: #000000; font-size: 12px; line-height: 20px; font-family: Arial, Helvetica,sans-serif;" valign="top" width="276">
                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                        <tbody>
                                                            <tr>
                                                                <td align="left" height="50" style="height: 50px; font-size: 22px; line-height: 20px; font-family: Arial, Helvetica, sans-serif; vertical-align: middle;">
                                                        
                                                                        <span style="font-family: arial,helvetica,sans-serif;">
                                                                            <strong>
                                                                                <span style="color: #CE0C0A;"> 
                                                                                    <?php echo $re; ?>
                                                                                </span>
                                                                            </strong>
                                                                        </span>
                                                                </td>
                                                            </tr></tbody></table></td>
                                            </tr>
                                            <tr>
                                                <td width="376"><img border="0" height="12" style="display: block; border: none;" width="1" src="http://darkorbit.tv/DarkSpace/spacer.png"></td>
                                            </tr>
                                            <tr>
                                                <td width="376" height="100" style="color: #000000; font-size: 12px; line-height: 20px; font-family: Arial, Helvetica, sans-serif; vertical-align: top;">
                                                    
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="12"></td>
                </tr>
        </tbody>
    </table>

    <table border="0" cellpadding="0" cellspacing="0" width="600">
        <tbody>
            <tr>
                <td width="600"><img height="20" style="display: block; border: 0px solid;" width="598" src="http://darkorbit.tv/DarkSpace/separation.jpg"></td>
            </tr>
            <tr>
                <td width="600"><img border="0" height="12" style="display: block; border: none;" width="1" src="http://webr.emv2.com/bp_bigpoint/img/spacer.png"></td>
            </tr>
        </tbody>
    </table>

    <table border="0" cellpadding="0" cellspacing="0" width="600">
        <tbody>
            <tr>
                <td width="12"></td>
                <td valign="top" width="576">
                    <table border="0" cellpadding="0" cellspacing="0" width="576">
                        <tbody>
                            <tr>
                                <td><img border="0" height="12" style="display: block; border: none;" width="1" src="http://webr.emv2.com/bp_bigpoint/img/spacer.png"></td>
                            </tr>
                            <tr>
                                <td align="center" height="176" style="color: #000000; font-size: 12px; line-height: 20px; font-family: Arial,Helvetica, sans-serif; vertical-align: top; height: 176px;" width="576">
                                    <div style="text-align: center;">

                                        <?php echo date("Y");?> Dark Space | <a href="http://127.0.0.1/legal/" style="text-decoration: none; color: #000000;" target="_blank">Data Protection</a> 
                                        <br>
                                    </div>
                                    <div style="text-align: center;">
                                        .
                                    </div></td>
                            </tr>
                            <tr>
                                <td width="576"><img border="0" height="12" style="display: block; border: none;" width="1" src="http://webr.emv2.com/bp_bigpoint/img/spacer.png"></td>
                            </tr>
                        </tbody>
                    </table></td>
                <td width="12"></td>
            </tr>
        </tbody>
    </table>
    </div>
</body>  
</html>
