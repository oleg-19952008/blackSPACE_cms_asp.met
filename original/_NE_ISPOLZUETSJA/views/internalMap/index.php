
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
            <title>Old Darkorbit.</title>
    <style type="text/css" media="screen"> 
body {
    margin: 0;
    padding: 0;
    text-align:center;
    background-color: #000000;
    width: 100%;
    height: 100%;
}
    </style>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>

<?php
$string = Auth::getUserSettings('client_resolution');
$str = substr($string, 0, strlen($string)-2);
$exploded = explode(',', $str);
?>
<body bgcolor="#000000"  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <embed src="spacemap/main.swf?id=1"  FlashVars="lang=es&amp;userID=<?php echo Session::get('account_ID'); ?>&amp;factionid=VRU&amp;sessionID=<?php echo $this->sid; ?>&amp;basePath=spacemap&amp;pid=563&amp;resolutionID=<?php echo $exploded[0]; ?>&amp;boardLink=127.0.0.1&amp;helplink=127.0.0.1&amp;loadingClaim=LOADING...&amp;chatHost=127.0.0.1&amp;useHash=0&amp;host=127.0.0.1&amp;gameXmlHash=060b9c86992a12a6d343395f64852876&amp;resourcesXmlHash=4f5d6e23ebb06278f110ba358dde28ec&amp;profileXmlHash=18287bc38698431e80f7cca05e6df2ca&amp;autoStartEnabled=1&amp;mapID=<?php echo Auth::getUser('mapid'); ?>&amp;supportedResolutions=0,1,2,3,4,5&amp;logConfig=0,300,4,5&amp;instantLogEnabled=1&amp;doubleClickAttackEnabled=1&amp;allowChat=1" play="true" loop="true" menu="false" quality="best" width="<?php echo $exploded[1]; ?>" height="<?php echo $exploded[2];?>" name="DFlash" allowScriptAccess="always" allowNetworking="true" swLiveConnect="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"  bgcolor="#000000" wmode="direct" />
    </body>
</html>