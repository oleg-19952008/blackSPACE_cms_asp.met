<h3 class="no_ind">Login</span></h3>
<div id="middlebtopa">
<small>
<span style="font-size: 12px; font-family:Verdana;">


		<div style="background-color: #fbfaef; padding-top: 1px; padding-bottom: 5px; padding-right: 8px; border-right-width: 1pt; border-bottom-width: 1pt; border-top-width: 1pt; border-left-width: 1pt; border-right-style: solid; border-bottom-style: solid; border-top-style: solid; border-left-style: solid; border-right-color: #BFBBBA; border-bottom-color: #BFBBBA; border-left-color: #BFBBBA; border-top-color: #BFBBBA;">
		<ul>	
			<li>Please enter your username and password to login.<br /></li>
			<li>If you have forgotten your password, please click <a href="?forgot">here</a>.</li>
			<li>If you don't have an account, please click <a href="?register">here</a>.</li>
		</ul>
		</div>
			<form action="?login" method="post">
				<table border="0" width="734" cellspacing="4" cellpadding="4">
					<tr>
						<td width="147" valign="top"><b>
						<font face="Verdana" size="2">Username:</font></b></td>
						<td valign="top">
						<input type="text" name="username" size="37" value="<?php echo $username; ?>"></td>
					</tr>
					<tr>
						<td width="147" valign="top"><b>
						<font face="Verdana" size="2">Password:</font></b></td>
						<td valign="top">
						<input type="password" name="password" size="37" value="<?php echo $password; ?>">
						<br /><font color="black" size="2"><a href="?forgot">Forgot Your Password ?</a></font><br />
						</td>
					</tr>
					<tr>
						<td width="147">&nbsp;</td>
						<td><input type="submit" value="Login" name="login"><br /></td>
					</tr>
				</table>
			</form>

</span>
</small>
</div>
