<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>DarkOrbit | CMS</title>
    <meta http-equiv="X-UA-Compatible" content="IE=9">

    <meta name="keywords" content="Jeux par navigateur, DarkOrbit, jeu de tir spatial, Jeux, Jeux, gratuit, jeux en ligne, jeu d&#39;action, jeu de tir">
    <meta name="robots" content="">

    <meta http-equiv="Content-Language" content="fr">
    <meta name="language" content="fr">
    <meta name="Content-Type" content="text/html; charset=utf-8">

    <meta name="author" content="Linkpad">
    <meta name="publisher" content="Linkpad">
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <link rel="SHORTCUT ICON" href="./public/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" media="all" href="./public/css/login_page.css">
    <link rel="stylesheet" media="all" href="../public/css/register.css">
    <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.js"></script>
    <style>
        .ui-widget {
        font-family: Verdana,Arial,sans-serif;
        font-size: 10px;
        }
    </style>
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
    <noscript>
        <style type="text/css">
            #pagecontainer {display:none;}
            .noscriptmsg
            {
                width: 100%;
                height: 100%;
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
        <div class="noscriptmsg">
            <div class="msg">
                You don't have javascript enabled. Please turn it on !
            </div>
        </div>
    </noscript>
</head>
<body>
<div id="pagecontainer">
 
<div style="display: none">
<div id="test_inline" style="padding: 10px 0 10px 0">
<p class="singup_errorMessage"></p>
</div>
</div>

<div id="do_globalContent">

    <div id="do_flash_background">
        <div id="do_flash_nyx">
            <img src="./public/images/nyx.png" alt="nyx fallback" style="margin-top: 14px; margin-left: 18px; ">
        </div>
        
    	<div id="do_flash_trailer">
            <object width="424" height="235" id="_5916623175" name="_5916623175" data="../public/swf/trailer.swf" type="application/x-shockwave-flash"><param name="allowfullscreen" value="true">
                <param name="allowscriptaccess" value="always">
                <param name="quality" value="high">
                <param name="wmode" value="transparent">
                <param name="flashvars" value="&amp;ordner=../swf/trailer_do.f4v">
            </object>
        </div>

    </div>

    <div class="server_status">
        Hey
    </div>

    <div class="do_login_container">
        <!-- contains login -->
        <input type="hidden" id="autoFocus" value="loginForm">
    
        <div id="loginForm_default_container">

            <form id="loginForm_default" method="post" action="index/run/" name="loginForm_default">

<!--                 <div id="loginForm_default_link_forgot_password_container">
                    <a id="loginForm_default_link_forgot" href="#">Mot de passe oublié&nbsp;?</a>
                </div> -->

                <div id="loginForm_default_label_username_container">
                    <label id="loginForm_default_label_username" for="loginForm_default_input_username">Pseudonyme</label>
                </div>

                <div id="loginForm_default_input_username_container">
                    <input type="text" id="loginForm_default_input_username" class="loginForm_default_input" name="loginForm_default_username"  value="Pseudonyme" onblur="if (this.value == '') {this.value = 'Pseudonyme';}" onfocus="if (this.value == 'Pseudonyme') {this.value = '';}">
                </div>

                <div id="loginForm_default_label_password_container">
                    <label id="loginForm_default_label_password" for="loginForm_default_input_password">Mot&nbsp;de&nbsp;passe</label>
                </div>

                <div id="loginForm_default_input_password_container">
                    <input type="password" id="loginForm_default_input_password" class="loginForm_default_input clearFieldBlurred" name="loginForm_default_password" value="password" onblur="if (this.value == '') {this.value = 'password';}" onfocus="if (this.value == 'password') {this.value = '';}">
                </div>
                
                <div id="loginForm_bookmark_container">
                </div>
                
                <div id="loginForm_default_loginButton_container">
                    <input type="submit" value="Connexion" id="loginForm_default_loginButton" class="loginForm_default_button" name="loginForm_default_login_submit">
                </div>
                <div id="loginForm_default_signupButton_container">
                    <input type="submit" value="Inscription" id="loginForm_default_signupButton" class="loginForm_default_button" name="loginForm_default_signup_submit">
                </div>
            </form>

        </div>
    </div>


    <div style="clear: both;"></div>



    <div class="do_screenshot">
        <script type="text/javascript">
            
            $(document).ready(function(){
                $('.screenshotLink').colorbox({transition:'none', rel:'ScreenRel'});
            });
            
        </script>

        <a href="./public/images/screenshot-01.jpg" rel="ScreenRel" class="screenshotLink cboxElement">
            <img style="width: 166px; height: 114px; margin: 9px 0 0 11px;" src="./public/images/screenshot-01-thumbnail.jpg" alt="thumbnail">
        </a>

        <a href="./public/images/screenshot-02.jpg" rel="ScreenRel" class="screenshotLink cboxElement">
            <img style="width: 166px; height: 114px; margin-left: 15px;" src="./public/images/screenshot-02-thumbnail.jpg" alt="thumbnail">
        </a>
    </div>

    <!-- Box NEWS -->

    <!-- <div class="do_like_box" >
        <img id="do_like_box_titel" src="./public/images/txt_newsstream.png" alt="Like Box" />
        <iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fdarkorbit&amp;width=360&amp;height=198&amp;colorscheme=dark&amp;show_faces=true&amp;border_color=%23333333&amp;stream=true&amp;header=false" scrolling="no" frameborder="0" style=" border:none; overflow:hidden; width:360px; height:198px; margin-top: 17px; margin-left: 19px;" allowTransparency="true"></iframe>
    </div> -->


    <div class="do_footer">

        <div class="do_footer_logos">
            <div class="followUs"></div>
            <a target="_blank" href="http://www.elitepvpers.com/" id="do_footer_logo_facebook">
                <img src="http://easyelo.com/images/elitee.png" style="width: 50%">
            </a>
<!--             <a target="_blank" href="#" id="do_footer_logo_twitter">
                <img src="./public/images/logo_twitter.png" alt="Twitter">
            </a>
            <a target="_blank" href="#" id="do_footer_logo_youtube">
                <img src="./public/images/logo_youtube.png" alt="Youtube">
            </a> -->
        </div>
    
        <div class="gl_footer">
            <div id="footerContainer">
                <div id="footer">
                    <!--gl footer-->
                    <div id="gl_footer">
                    	<span id="gl_footer_element_copyright" class="gl_footer_element">© Old darkorbit by Linkpad</span>
                    	<span class="gl_footer_element_separator">&nbsp;·&nbsp;</span>
                    	<span id="gl_footer_element_allrights" class="gl_footer_element"></span>
    				</div>
                </div>
            </div>
        </div>

    </div>

    <div class="do_registration_container">

        <img class="regformBackground" id="do_regform_background" src="./public/images/formular_part.png" alt="regform Background">
        <img class="regformBackground" id="do_regform_background_extension" src="./public/images/regform_overlay.jpg" alt="regform Background">

        
        <div style="position: relative;" class="signup_container" id="signup_container_id">
            <table class="signup">
                <tbody>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <form id="signupxhr" action="index/register/" method="post">
                                <input type="hidden" name="aid" value="829">
                                <input type="hidden" name="acm" value=""><input type="hidden" name="acr" value="576">
                                <input type="hidden" name="aip" value=""><input type="hidden" name="locale" value="fr">

                                <table class="signup signup_right">
                                    <tbody>

                                        <tr>
                                            <td class="signup_label label_username">
                                                Username
                                            </td>
                                            <td>
                                                <input type="text" id="signup_username" maxlength="20" name="signup_username" value="" class="input_text">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="signup_label label_password">
                                                Password
                                            </td>
                                            <td>
                                                <input type="password" maxlength="20" name="signup_password" value="" class="input_text">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="signup_label label_passwordRepeat">
                                                Confirm password
                                            </td>
                                            <td>
                                                <input type="password" maxlength="20" name="signup_passwordRepeat" value="" class="input_text">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="signup_label label_email">
                                                Email
                                            </td>
                                            <td>
                                                <input type="text" name="signup_email" value="" class="input_textLong">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="signup_label label_instances">
                                                Server
                                            </td>
                                            <td>
                                                <select name="signup_instance" onchange="changeInstance(this.value);" class="input_selectInstance" tabindex="32767">
                                                    <option value="1">Old darkorbit</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="signup_label label_instances">
                                                Company
                                            </td>
                                            <td>
                                                <select name="signup_company" onchange="changeInstance(this.value);" class="input_selectInstance" tabindex="32767">
                                                    <option value="1">MMO</option>
                                                    <option value="2">EIC</option>
                                                    <option value="3">VRU</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="signup_label label_birthday">
                                                Birthday
                                            </td>
                                            <td>
                                                <select name="signup_birthdayDay" class="input_selectDay">
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
                                                </select>

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
                                                </select>

                                                <select name="signup_birthdayYear" class="input_selectYear">
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

                                        <input type="hidden" name="signup_country" value="FR">
                                        <input type="hidden" name="signup_province" value="">
                                        <input type="hidden" id="signup_winnings" name="signup_winnings" value="0">

                                        <tr>
                                            <td class="align_buttonRegister">
                                                <input type="button" name="signup_button_back" id="signup_button_back" value="Retour" class="input_button signup_back" onclick="location.href=#;">
                                            </td>
                                            <td class="align_buttonRegister">
                                                <input class="bgc_button bgc_signup_form_register" name="signup_submit" id="signup_submit" type="submit" value="Register">
                                            </td>
                                            <!-- <input type="submit" /> -->
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
</div>
</body>
</html>