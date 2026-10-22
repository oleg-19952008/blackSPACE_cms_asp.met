<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="default.aspx.cs" Inherits="DarkSpace._Default" EnableViewStateMac="false" ValidateRequest="false" %>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head runat="server">
    <meta charset="utf-8" />
    <title>Dark Space - Private Server</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <form id="frmMain" runat="server">
        <!-- Port of index.php skeleton.
             The legacy template includes (FILES/GLOBALS constants from Init.php,
             INDEX/header.php + INDEX/body.php) are re-attached in migration step 4. -->
        <div id="errorData"><asp:Literal ID="litError" runat="server" /></div>

        <!-- loginForm_default_* block from index.php -->
        <div class="loginForm">
            <h2>Login</h2>
            <input type="text" name="loginForm_default_username" id="loginForm_default_username" runat="server" />
            <input type="password" name="loginForm_default_password" id="loginForm_default_password" runat="server" />
            <input type="submit" name="loginForm_default_login_submit" value="Login" />
        </div>

        <!-- recoverTrue / recoverPw block -->
        <div class="recoverForm">
            <input type="text" name="recoverPw" id="recoverPw" runat="server" />
            <input type="submit" name="recoverTrue" value="Recover" />
        </div>
    </form>
</body>
</html>
