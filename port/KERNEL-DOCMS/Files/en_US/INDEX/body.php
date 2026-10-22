
<body itemscope="" itemtype="http://schema.org/Article" class="frontpage" data-twttr-rendered="true">

    <!-- Google Tag Manager -->
    <script>dataLayer = [{}];</script>
    
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({' .start': new Date().getTime(), event: ' .js'});
            var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = '//www. .com/ .js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', ' -NWZ6XP');
        
        <?php 
		 if(isset($_GET['calmdown']) && $_GET['calmdown']=99){
				?>
				jQuery(document).ready(function() {
                    document.getElementById('busy_layer').style.display = 'block';
                    document.getElementById('errorBox').style.display = 'block';
                }); 
                function errorBoxClose() {
                    document.getElementById('busy_layer').style.display = 'none';
                    document.getElementById('errorBox').style.display = 'none';
                }
				<?php
		 }
	
        if(!empty($_SESSION['errorData'])){
            ?>
               jQuery(document).ready(function() {
                    document.getElementById('busy_layer').style.display = 'block';
                    document.getElementById('errorBox').style.display = 'block';
                }); 
                function errorBoxClose() {
                    document.getElementById('busy_layer').style.display = 'none';
                    document.getElementById('errorBox').style.display = 'none';
                }
            <?php
        }
        ?>
		function pwRecover(){
			document.getElementById('logBox').style.display = 'none';
			document.getElementById('pwRecover').style.display = 'block';
		}
		function closeRecover(){
	      document.getElementById('pwRecover').style.display = 'none';
		  document.getElementById('busy_layer').style.display = 'none';
		}
        function closeReg() {
            document.getElementById('busy_layer').style.display = 'none';
            document.getElementById('regBox').style.display = 'none';
        }
        function showReg() {
            document.getElementById('busy_layer').style.display = 'block';
            document.getElementById('regBox').style.display = 'block';
        }
        function closeLog() {
            document.getElementById('busy_layer').style.display = 'none';
            document.getElementById('logBox').style.display = 'none';
        }
        function showLog() {
            document.getElementById('busy_layer').style.display = 'block';
            document.getElementById('logBox').style.display = 'block';
        }
    </script>



    <!-- End Google Tag Manager -->

    <div id="container">
	<?php if(isset($_GET['calmdown']) && $_GET['calmdown']=99){
	?>
		<div id="busy_layer" style="visibility: visible; display: block;"></div>
        <div id="errorBox" style="display: block; width: 500px;">
            <div id="errorBox_close">
                <a href="javascript:void(0);" onclick="errorBoxClose();"><img src="./do_img/global/clan/close.jpg?"></a>
            </div>
			<br />
             <img src="./acp/css/images/banned.gif">
            <?php if(isset($_GET['until'])): echo 'Banned until: '.date("M d, Y H:i:s", strtotime(str_replace("-","/", $_GET['until']))); endif;?>
        </div>
	<?php
	}
	?>
        <div id="busy_layer" style="visibility: visible; display: none;"></div>
        <div id="errorBox" style="display: none;">
            <div id="errorBox_close">
                <a href="javascript:void(0);" onclick="errorBoxClose();"><img src="./do_img/global/clan/close.jpg?"></a>
            </div>
             <?php 
                if(!empty($_SESSION['errorData'])){
                    echo $_SESSION['errorData'];
                    unset($_SESSION['errorData']);

                }
            ?>
            
        </div>
		<div id="pwRecover">
            <div id="recover_close">
                <a href="javascript:void(0);" onclick="closeRecover();"><img src="./do_img/global/clan/close.jpg?"></a>
            </div>
            <form style="padding: 15px; margin-top: 20px;"  method="POST" action="/?locale=us&amp;aid=1" name="loginForm_default">
				<div id="loginForm_default_label_username_container">
                    <label id="recoverPw_lable" for="recoverPw">Email:</label>
                </div>
				<div id="recoverPw_div">
                    <input type="text" id="recoverPw" class="recoverPw" name="recoverPw" />
                </div>
				<input type="hidden" name="recoverTrue" value="true" />
				<div style="margin-top: 10px;" id="loginForm_default_loginButton_container">
                    <input type="submit" value="Recover Password" id="loginForm_default_loginButton" class="loginForm_default_button" name="loginForm_default_login_submit"  />
                </div>
            </form>
        </div>

<body>
  <link href="css/indexstyle.css" rel="stylesheet">

 <div class="body"></div>
        <div class="grad"></div>
        <div class="header">
            <div>Dark<span>Space</span></div>
        </div>
        <br>

        <div class="login">
            <form  id="loginForm_default" method="post" action="/?locale=us&amp;aid=0" name="loginForm_default">

                <!-- login -->
                <div id="loginForm_default_input_username_container">
                    <input type="text" placeholder="Логин" id="loginForm_default_input_username" class="loginForm_default_input" name="loginForm_default_username" />
                </div>
                <!-- pass -->
                <div id="loginForm_default_input_password_container">
                    <input type="password" placeholder="Пароль" id="loginForm_default_input_password" class="loginForm_default_input" name="loginForm_default_password" />
                </div>
                  <!-- <p>Forgot your password? <a href="javascript:void(0);" onclick="pwRecover();">Click Here</a></p>  -->

              <div>
                    <input type="submit" class="button_" id="loginForm_default_loginButton_container" value="Login"   name="loginForm_default_login_submit"  />
              </div>
            </form>
        </div>
        <br>

        <div class="register">
            
            <form name="signup_signup" action="<?php echo SERVER; ?>/?aedt=a4b37363a26bea846821b0ba1c704ee3" method="post">
               <table class="signup signup_right">
                    <tr>
                            <input type="text" id="signup_username" placeholder="Логин" maxlength="20" name="signup_username" value="<?php echo (isset($_POST['signup_username'])) ? $_POST['signup_username'] : ''; ?>" class="input_text"/></td>
                    </tr>
                    <tr>
                            <input type="password" placeholder="Пароль" maxlength="20" name="signup_password" value="" class="input_text"/></td>
                    </tr>
                    <tr>
                            <input type="password" placeholder="Повторите пароль" maxlength="20" name="signup_passwordRepeat" value="" class="input_text"/></td>
                    </tr>
                    <tr>
                            <input type="Email" name="signup_email" placeholder="E-mail" value="<?php echo (isset($_POST['signup_email'])) ? $_POST['signup_email'] : ''; ?>" class="input_textLong" /></td>
                    </tr> <br>
                    <div class="g-recaptcha"  data-sitekey="6LcNQFUUAAAAAAJzCeTIGrADuBLftF4pZSVXKNhG"></div>


                    <tr>
                        <td class="align_buttonRegister">
                            <input id="register_submit" type="submit" name="signup_submit" id="signup_submit" value="Register" class="input_button signup_submit"  /></td>
                    </tr>
                <input type="hidden" name="aid" value="0" />
                <input type="hidden" name="acm" value="" />
                <input type="hidden" name="acr" value="22" />
                <input type="hidden" name="aip" value="" />
                <input type="hidden" name="locale" value="us" />   
                <input type="hidden" name="signup_instance" value="1" /> <!-- сервер -->
                <input type="hidden" name="signup_birthdayMonth" value="1" /> <!-- месяц -->
                <input type="hidden" name="signup_birthdayDay" value="1" /> <!-- день -->
                <input type="hidden" name="signup_birthdayYear" value="1" /> <!-- год -->
                <input type="hidden" name="signup_birthdayYear" value="1970" />
                <input type="hidden" name="signup_country" value="ES" />
                <input type="hidden" name="signup_province" value="" />
                <input type="hidden" id="signup_winnings" name="signup_winnings" value="0" />
                <input type="hidden" name="signup_termsAndCondition" value="1"/> <!-- соглашение -->
                <input type="hidden" name="signup_newsletter" value="1" class="input_checkbox"/>
                <input type="hidden" name="lang" value="us" />
                <input type="hidden" name="ref_sid" value="26df87b91c51625e57689496470f89c6" />
                <input type="hidden" name="ref_pid" value="22" />
                <input type="hidden" name="__utma" value="1.104324967.1366912367.1368272288.1368282013.13" />
                <input type="hidden" name="__utmb" value="-" />
                <input type="hidden" name="__utmc" value="1" />
                <input type="hidden" name="__utmx" value="-" />
                <input type="hidden" name="__utmz" value="1.1366912367.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)" />
                <input type="hidden" name="__utmv" value="-" /><input type="hidden" name="__utmk" value="187110952" />
                </table>
            </form>


        </div>
        <div class="evpvp">
            <a href="https://www.elitepvpers.com/forum/darkorbit/4469352-beta-test-darkspace-russian-private-server.html" target="_blank">
            <img src="/do_img/en/logo_epvp.png" >
            </a>
        </div>
            
        

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<body>










 

    <script src="./js/plugins-140523113238.min.js"></script>

    <script src="./js/scripts-140523113238.min.js"></script>

   
    <script type="text/javascript">        
        $('#signup_username').on('keypress', function() {
            var that = this;
            setTimeout(function() {
                var res = /[^a-zA-Z0-9-_)(!$#? ]/g.exec(that.value);
                console.log(res);
                that.value = that.value.replace(res, '');
             }, 0);
        });
    </script>
</body>
</html>