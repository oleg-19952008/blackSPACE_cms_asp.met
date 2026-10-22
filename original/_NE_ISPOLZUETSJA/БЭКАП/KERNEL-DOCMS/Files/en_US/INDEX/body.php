



<body itemscope="" itemtype="http://schema.org/Article" class="frontpage" data-twttr-rendered="true">

    <!-- Google Tag Manager -->
    <script>dataLayer = [{}];</script>
    <noscript>
    &lt;iframe src="//www.googletagmanager.com/ns.html?id=GTM-NWZ6XP" height="0" width="0" style="display:none;visibility:hidden"&gt;&lt;/iframe&gt;
    </noscript>
	<div id="footer">
		<div style="color:#1FFF10" align="center"> OrbitReborn & Dark Space is an independent project (nonprofit goal) © 2015. <br>
<a target="_blank" href="http://darkorbit.com/">Dark Orbit</a> is a registered trademark of <a target="_blank" href="http://bigpoint.com/">BigPoint GmbH</a>. All rights reserved to their respective owner(s). <br>
We are not endorsed, affiliated or offered by <a target="_blank" href="http://bigpoint.com/">BigPoint.</a></div><a target="_blank" href="http://bigpoint.com/">
            </a><div class="copyright"><a target="_blank" href="http://bigpoint.com/">
            </div>			
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
            var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = '//www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-NWZ6XP');
        
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
		
        <div id="logBox">
		
            <div id="log_close">
                <a href="javascript:void(0);" onclick="closeLog();"><img src="./do_img/global/clan/close.jpg?"></a>
				
            </div>
			
            <form style="padding: 15px; margin-top: 20px;" id="loginForm_default" method="post" action="/?locale=us&amp;aid=0" name="loginForm_default">

			
                <div id="loginForm_default_label_username_container">
			 
		<div style="color:#FFFF10" align="center"> OrbitReborn & Dark Space is an independent project (nonprofit goal) © 2015. <br>
<a target="_blank" href="http://darkorbit.com/">Dark Orbit</a> is a registered trademark of <a target="_blank" href="http://bigpoint.com/">BigPoint GmbH</a>. All rights reserved to their respective owner(s). <br>
We are not endorsed, affiliated or offered by <a target="_blank" href="http://bigpoint.com/">BigPoint.</a></div><a target="_blank" href="http://bigpoint.com/">
            </a><div class="copyright"><a target="_blank" href="http://bigpoint.com/">
            </div>			
                    <label id="loginForm_default_label_username" for="loginForm_default_input_username">Username</label>
                </div>
                <div id="loginForm_default_input_username_container">
                    <input type="text" id="loginForm_default_input_username" class="loginForm_default_input" name="loginForm_default_username" />
                </div>
                <div id="loginForm_default_label_password_container">
                    <label id="loginForm_default_label_password" for="loginForm_default_input_password">Password</label>
                </div>
				
                <div id="loginForm_default_input_password_container">
                    <input type="password" id="loginForm_default_input_password" class="loginForm_default_input" name="loginForm_default_password" />
                </div>
				
					<p>Forgot your password? <a href="javascript:void(0);" onclick="pwRecover();">Click Here</a></p>

                <div style="margin-top: 10px;" id="loginForm_default_loginButton_container">
                    <input type="submit" value="Login" id="loginForm_default_loginButton" class="loginForm_default_button" name="loginForm_default_login_submit"  />
               
			   </div>
				
            </form>
			
        </div>
		
            
        <div id="regBox">
            <div id="reg_close">
                <a href="javascript:void(0);" onclick="closeReg();"><img src="./do_img/global/clan/close.jpg?"></a>
            </div>
            <form style="padding: 15px; margin-top: 20px;" name="signup_signup" action="<?php echo SERVER; ?>/?aedt=a4b37363a26bea846821b0ba1c704ee3" method="post">
                <input type="hidden" name="aid" value="0" /><input type="hidden" name="acm" value="" /><input type="hidden" name="acr" value="22" /><input type="hidden" name="aip" value="" /><input type="hidden" name="locale" value="us" /><table class="signup signup_right">
                    <tr>
                        <td class="signup_label label_username">
                            Username</td>
                        <td>
                            <input type="text" id="signup_username" maxlength="20" name="signup_username" value="<?php echo (isset($_POST['signup_username'])) ? $_POST['signup_username'] : ''; ?>" class="input_text"/></td>
                    </tr>
                    <tr>
                        <td class="signup_label label_password">
                            Password</td>
                        <td>
                            <input type="password" maxlength="20" name="signup_password" value="" class="input_text"/></td>
                    </tr>
                    <tr>
                        <td class="signup_label label_passwordRepeat">
                            Confirm password</td>
                        <td>
                            <input type="password" maxlength="20" name="signup_passwordRepeat" value="" class="input_text"/></td>
                    </tr>
                    <tr>
                        <td class="signup_label label_email">
                            E-mail</td>
                        <td>
                            <input type="text" name="signup_email" value="<?php echo (isset($_POST['signup_email'])) ? $_POST['signup_email'] : ''; ?>" class="input_textLong" /></td>
                    </tr>
                    <tr>
                        <td class="signup_label label_instances">
                            Game server</td>
                        <td>
                            <select name="signup_instance" onchange="changeInstance(this.value);" class="input_selectInstance" tabindex="32767" >
                                <option value="1" selected="selected">Global</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="signup_label label_birthday">
                            Date of birth</td>
                        <td>
                            <select name="signup_birthdayMonth" class="input_selectMonth">
                                <option value="01" selected="selected">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>/<select name="signup_birthdayDay" class="input_selectDay">
                                <option value="01" selected="selected">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                            </select>/<select name="signup_birthdayYear" class="input_selectYear">
                                <option value="2013">2013</option>
                                <option value="2012">2012</option>
                                <option value="2011">2011</option>
                                <option value="2010">2010</option>
                                <option value="2009">2009</option>
                                <option value="2008">2008</option>
                                <option value="2007">2007</option>
                                <option value="2006">2006</option>
                                <option value="2005">2005</option>
                                <option value="2004">2004</option>
                                <option value="2003">2003</option>
                                <option value="2002">2002</option>
                                <option value="2001">2001</option>
                                <option value="2000">2000</option>
                                <option value="1999">1999</option>
                                <option value="1998">1998</option>
                                <option value="1997">1997</option>
                                <option value="1996">1996</option>
                                <option value="1995">1995</option>
                                <option value="1994">1994</option>
                                <option value="1993">1993</option>
                                <option value="1992">1992</option>
                                <option value="1991">1991</option>
                                <option value="1990">1990</option>
                                <option value="1989">1989</option>
                                <option value="1988">1988</option>
                                <option value="1987">1987</option>
                                <option value="1986">1986</option>
                                <option value="1985">1985</option>
                                <option value="1984">1984</option>
                                <option value="1983">1983</option>
                                <option value="1982">1982</option>
                                <option value="1981">1981</option>
                                <option value="1980">1980</option>
                                <option value="1979">1979</option>
                                <option value="1978">1978</option>
                                <option value="1977">1977</option>
                                <option value="1976">1976</option>
                                <option value="1975">1975</option>
                                <option value="1974">1974</option>
                                <option value="1973">1973</option>
                                <option value="1972">1972</option>
                                <option value="1971">1971</option>
                                <option value="1970" selected="selected">1970</option>
                                <option value="1969">1969</option>
                                <option value="1968">1968</option>
                                <option value="1967">1967</option>
                                <option value="1966">1966</option>
                                <option value="1965">1965</option>
                                <option value="1964">1964</option>
                                <option value="1963">1963</option>
                                <option value="1962">1962</option>
                                <option value="1961">1961</option>
                                <option value="1960">1960</option>
                                <option value="1959">1959</option>
                                <option value="1958">1958</option>
                                <option value="1957">1957</option>
                                <option value="1956">1956</option>
                                <option value="1955">1955</option>
                                <option value="1954">1954</option>
                                <option value="1953">1953</option>
                                <option value="1952">1952</option>
                                <option value="1951">1951</option>
                                <option value="1950">1950</option>
                                <option value="1949">1949</option>
                                <option value="1948">1948</option>
                                <option value="1947">1947</option>
                                <option value="1946">1946</option>
                                <option value="1945">1945</option>
                                <option value="1944">1944</option>
                                <option value="1943">1943</option>
                                <option value="1942">1942</option>
                                <option value="1941">1941</option>
                                <option value="1940">1940</option>
                                <option value="1939">1939</option>
                                <option value="1938">1938</option>
                                <option value="1937">1937</option>
                                <option value="1936">1936</option>
                                <option value="1935">1935</option>
                                <option value="1934">1934</option>
                                <option value="1933">1933</option>
                                <option value="1932">1932</option>
                                <option value="1931">1931</option>
                                <option value="1930">1930</option>
                                <option value="1929">1929</option>
                                <option value="1928">1928</option>
                                <option value="1927">1927</option>
                                <option value="1926">1926</option>
                                <option value="1925">1925</option>
                                <option value="1924">1924</option>
                                <option value="1923">1923</option>
                                <option value="1922">1922</option>
                                <option value="1921">1921</option>
                                <option value="1920">1920</option>
                                <option value="1919">1919</option>
                                <option value="1918">1918</option>
                                <option value="1917">1917</option>
                                <option value="1916">1916</option>
                                <option value="1915">1915</option>
                                <option value="1914">1914</option>
                            </select>
                        </td>
                    </tr>
                    <input type="hidden" name="signup_country" value="ES" /><input type="hidden" name="signup_province" value="" /><input type="hidden" id="signup_winnings" name="signup_winnings" value="0" /><tr>
                        <td colspan="2">
                            <table class="signup signup_input">
                                <tr>
                                    <td class="align_checkbox">
                                        <div class="">
                                            <input type="checkbox" name="signup_termsAndCondition" value="1" class="input_checkbox " <?php echo (isset($_POST['signup_termsAndCondition']) && $_POST['signup_termsAndCondition'] === '1') ? 'checked=checked' : ''; ?>/>
                                        </div>
                                    </td>
                                    <td class="signup_label label_checkbox">
                                        <a class="signup_link" href="/policy/tos" target="_blank" style="text-decoration:underline">
                                            Terms & Conditions</a> and
                                        <a class="signup_link" href="#" target="_blank" style="text-decoration:underline">
                                            Data Privacy Policy</a> read and accepted.
<div id="footer">
		<div style="color:#FFFFF0" align="center"> OrbitReborn & Dark Space is an independent project (nonprofit goal) © 2015. <br>
<a target="_blank" href="http://darkorbit.com/">Dark Orbit</a> is a registered trademark of <a target="_blank" href="http://bigpoint.com/">BigPoint GmbH</a>. All rights reserved to their respective owner(s). <br>
We are not endorsed, affiliated or offered by <a target="_blank" href="http://bigpoint.com/">BigPoint.</a></div><a target="_blank" href="http://bigpoint.com/">
            </a><div class="copyright"><a target="_blank" href="http://bigpoint.com/">
            </div>			
            
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table class="signup signup_input"><tr><td class="align_checkbox"><input type="hidden" name="signup_newsletter" value="1" class="input_checkbox"/></td><td class="signup_label label_checkbox"><!--Subscribe to newsletter--></td></tr></table></td>
                    </tr>
                    <tr>
                        <td class="align_buttonRegister">
                        </td>
                        <td class="align_buttonRegister">
                            <input id="register_submit" type="submit" name="signup_submit" id="signup_submit" value="Register" class="input_button signup_submit"  /></td>
                    </tr>
                </table>
                <input type="hidden" name="lang" value="us" /><input type="hidden" name="ref_sid" value="26df87b91c51625e57689496470f89c6" />
                <input type="hidden" name="ref_pid" value="22" />
                <input type="hidden" name="__utma" value="1.104324967.1366912367.1368272288.1368282013.13" />
                <input type="hidden" name="__utmb" value="-" />
                <input type="hidden" name="__utmc" value="1" />
                <input type="hidden" name="__utmx" value="-" />
                <input type="hidden" name="__utmz" value="1.1366912367.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)" />
                <input type="hidden" name="__utmv" value="-" /><input type="hidden" name="__utmk" value="187110952" />
            </form>
        </div>
        <header id="header" role="banner">
            <div>
                <nav class="clearfix">
                  <!--<input type="button"  class="button style2" style="margin-top: 5%;" value="MORE SERVERS" onclick="window.location='http://127.0.0.1/indx/index.html';">-->

                
                    <h1>	<a class="logo" href="http://<?php echo DynHost; ?>/">
                            <img src="./do_img/global/splashpage/logoDP.png"  height="52" alt="Dark Space"></a>
                    </h1>
                    <ul class="clearfix">
                        <li><a href="#"></a>
                            <ul class="i5">
                                <li class="col1"><a href="#"></a></li> 
                            </ul>
                        </li>
                       <li>
                         <input type="button"  class="button style2" style="margin-top: 5%;" value="LOGIN" href="javascript:void(0);" onclick="showLog();">


                           <!--<a href="javascript:void(0);" onclick="showLog();">Login</a>-->
                        </li>
						<li>
					<!-- 	<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FDarkSpaceNET&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=true&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe>
					 -->	</li>
                    </ul>
                </nav>
                <div class="ccp-loginwidget">
                    <div class="ccploginwidget-sites"><a href="#">Dark Space</a>
                        <ul>
                            <li>
                                <a href="http://localhost" class="loginwidget-site-link">Thread <span>Thread for players</span></a>
                            </li>
                        </ul>   
                    </div>


                    <div class="ccploginwidget-languages">
                        <a href="#">Language/Язык: <span class="label">English</span></a>

                        <ul>
                            <li class="en">
                                <a href="#">English</a>
                            </li>
                            <li class="de">
                                <a href="#">Частично Русский</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </header>

        <div id="main" role="main">
            <div id="call-to-action">



            </div>
        
         <div id="hero">
                <div id="front-buttons" class="font-din">
                  <td width="10%">
                    <input type="button"  class="button style2" style="margin-top: 5%;" value="CREATE ACCOUNT" href="javascript:void(0);" onclick="showReg();">
                  </td>
                  <td width="10%">
                    <input type="button"  class="button style2" style="margin-top: 5%;" value="MORE SERVERS" onclick="window.location='http://127.0.0.1/indx/index.html';">
                  </td>

                  <!--
                    <a class="button--arrow clearfix "  href="indx/index.html" onclick=''>
                        <span class="button--arrow-text">More servers </span>
						
                       <a class="button--arrow clearfix "  href="javascript:void(0);" onclick="showReg();">
                        <span class="button--arrow-text">Create Account</span>
					 
                -->
                  <!-- /.button--arrow --><!--

                </div>--><!-- /#front-button --><!--
                <div id="hero-wrapper">
                    <div id="hero-universe">
                        <h2><a href="http://<?php echo DynHost; ?>/"> <span> </span>  </a></h2>
                    </div>
                </div>
            </div>-->

            



            
        </div>

        <div class="push"></div>
    </div>


    <footer id="footer">
        <div class="wrapper clearfix">

            <div class="social-media clearfix">

            </div>

            <ul class="links clearfix">
                <li class="first"><a href="http://<?php echo DynHost; ?>/policy/tos">Terms of Service</a></li>
                <li><a href="http://<?php echo DynHost; ?>/policy/privacy-policy">Privacy Policy</a></li>
                <li><a href="http://<?php echo DynHost; ?>/contact/">Contact</a></li>
                <li><a href="http://<?php echo DynHost; ?>/faq">FAQ</a></li>
            </ul>

        </div>
            <p>Copyright © Dark Space 2014 - <?php echo date("Y"); ?></p>

            <div class="rating">
				
               			
                
            </div>
        </div>
    </footer>

    <script src="./js/plugins-140523113238.min.js"></script>

    <script src="./js/scripts-140523113238.min.js"></script>
</body>
</html>