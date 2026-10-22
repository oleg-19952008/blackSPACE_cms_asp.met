<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Language" content="en-us" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Need traffic to your websites articles? join our high articles top list we guarantee you more traffic for free.">
<meta name="keywords" content="Ultima online, ragnarok online, top list, game, games, lineage, world of warcraft, warcraft 3, starcraft, diablo 2, star wars, counter strike, game toplist, lineage 2, game news, game sites, gaming sites, links, 100, 200">
<meta name="author" content="Medianet">
<meta name="revisit-after" content="15 days">
<meta name="robots" content="index,follow">
<meta name="googlebot" content="index,follow">
<title><?php echo Config::item('title'); ?></title>

<link rel="stylesheet" href="templates/Default/css/reset.css" type="text/css" media="screen">
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <link rel="stylesheet" href="templates/Default/css/style.css" type="text/css" media="screen">
    <link rel="stylesheet" href="templates/Default/css/grid.css" type="text/css" media="screen">    
    <script src="templates/Default/js/jquery-1.6.2.min.js" type="text/javascript"></script> 
    <script src="templates/Default/js/jquery.easing.1.3.js" type="text/javascript"></script>
    <script src="templates/Default/js/tms-0.3.js" type="text/javascript"></script>
    <script src="templates/Default/js/tms_presets.js" type="text/javascript"></script>
    <script src="templates/Default/js/cufon-yui.js" type="text/javascript"></script>
    <script src="templates/Default/js/cufon-replace.js" type="text/javascript"></script>
    <script src="templates/Default/js/FF-cache.js" type="text/javascript"></script>
    <script src="templates/Default/js/Kozuka_Gothic_Pro_OpenType_700.font.js" type="text/javascript"></script>        
    <script src="templates/Default/js/Kozuka_Gothic_Pro_OpenType_500.font.js" type="text/javascript"></script>            
    <script src="templates/Default/js/tabs.js" type="text/javascript"></script>      
    <script src="templates/Default/js/superfish.js" type="text/javascript"></script>         
    <script src="templates/Default/js/jquery.mousewheel.js" type="text/javascript"></script>              
    <script src="templates/Default/js/jScrollPane.js" type="text/javascript"></script>         
    <script src="templates/Default/js/script.js" type="text/javascript"></script>    
    
<link href="templates/Default/css/style.css" rel="stylesheet" type="text/css" />

</head>
<body id="page1">
<div class="main">
	<header>	
    	<div class="inner">
        	<div class="container">
                     <h1 class="logo"><a href="?index"><?php echo Config::item('title'); ?></a></h1>
                     <h2 class="slogan"><?php echo Setting::SettingHandler('slogan'); ?></h2>
                <ul class="login_panel">
                    <?php if(User::$isLoggedin == TRUE): ?>
                               <li><a href="?logout" >LOGOUT</a></li>
                               <?php else:?>
                               <li><a id="loginBut" class="loginBut">LOGIN</a></li>
			<?php endif; ?>     
                                <li><a href="?rules" >REGLER</a></li>
                                <li><a href="?sitemap" >SITEMAP</a></li>
                </ul>
                    
            </div>
            <?php if(User::$isLoggedin == TRUE): else:?>
            <script type="text/javascript">
                $("#loginBut" ).click(function() {
                  $( "#hiddenLogin" ).fadeTo( "slow", 1 );
                });
                </script>
            <div id="hiddenLogin" style="display: block; opacity: 0;">
                        <form action="?login" method="post">
                            <label for="username">Brugernavn</label>: <input type="text" name="username" id="username" class="text medium error" value=""/>
                            <label for="password">Password</label>: <input type="password" name="password" id="password" class="text medium error" value=""/>
                            <input type="submit" value="Login" name="login">
                        </form>
            </div>
                    <?php endif; ?>
        </div>
        <div class="menu_block">
        	<div class="container">
                <ul class="links">
                    <?php $first = TRUE; ?>
			<?php foreach(navigation() as $nav):?>
				<?php if($first == FALSE): ?>
				
				<?php endif; ?>
                                <?php  
                                        if(User::$isLoggedin == TRUE):
                                            if($nav['isIN'] == 1):
                                                
                                            else:
                                            ?>
                                             <li class="<?php  if("?".Base::get_page() == $nav['link']): ?>active<?php endif;?>"><a id="<?php echo $nav['link']; ?>" href="<?php echo $nav['link']; ?>" onclick="popup('<?php echo $nav['name']; ?>');" class="bai"><?php echo $nav['name']; ?></a></li>
                                        <?php
                                           endif;
                                           else:
                                               if($nav['isIN'] == 2):
                                                   else:
                                               
                                             ?>  
                                           <li class="<?php  if("?".Base::get_page() == $nav['link']): ?>active<?php endif;?>"><a id="<?php echo $nav['link']; ?>" href="<?php echo $nav['link']; ?>" onclick="popup('<?php echo $nav['name']; ?>');" class="bai"><?php echo $nav['name']; ?></a></li>
<?php
endif;
                                        endif;
                                        ?>
				<?php $first = FALSE; ?>
			<?php endforeach; ?>
			<?php if(User::$isAdmin == TRUE): ?>
                                &nbsp;<li><a href="?acp" class="bai">Admin CP</a></li>
			<?php endif; ?>
                	
                </ul>
            </div>
        </div>
        
    </header>

<section id="content">
    <div id="bannerArea">
        <img src="<?php echo Setting::SettingHandler('banner'); ?>" />
    </div>
    	<div class="container">	
            <div class="wrapper">
    <div class="inner_wrap">