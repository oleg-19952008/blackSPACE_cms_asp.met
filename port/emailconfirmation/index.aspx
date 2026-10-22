<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="emailconfirmation/index.aspx.cs" Inherits="DarkSpace.EmailConfirmationIndex" EnableViewStateMac="false" ValidateRequest="false" %>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head runat="server">
    <title>Dark Space Email Verification</title>
</head>
<body>
    <div style="width: 600px ; margin: 0 auto;">
        <table border="0" cellpadding="0" cellspacing="0" width="600">
            <tbody>
                <tr>
                    <td style="background-color: #ffffff;"></td>
                    <td width="600">
                        <table border="0" cellpadding="0" cellspacing="0" height="315" width="602">
                            <tbody>
                                <tr>
                                    <td width="600">
                                        <img height="315" style="display: block; border: 0px solid;" width="598" src="http://darkorbit.tv/DarkSpace/DPMailHeader.jpg" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" style="background-color: rgb(242, 242, 242); text-align: center;" width="600">
                            <tbody>
                                <tr>
                                    <td valign="top" width="376">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td align="left" height="50" style="height: 50px; font-size: 22px; line-height: 20px; font-family: Arial, Helvetica, sans-serif; vertical-align: middle;">
                                                        <span style="font-family: arial,helvetica,sans-serif;"><strong>
                                                            <span style="color: #CE0C0A;"><asp:Literal ID="litResult" runat="server" /></span>
                                                        </strong></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" width="600">
            <tbody>
                <tr>
                    <td width="600">
                        <div style="text-align: center;">
                            <asp:Literal ID="litYear" runat="server" /> Dark Space | <a href="http://127.0.0.1/legal/" style="text-decoration: none; color: #000000;" target="_blank">Data Protection</a><br />
                        </div>
                        <div style="text-align: center;">.</div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
