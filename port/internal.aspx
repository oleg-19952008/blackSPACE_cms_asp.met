<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="internal.aspx.cs" Inherits="DarkSpace.Internal" EnableViewStateMac="false" ValidateRequest="false" %>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head runat="server">
    <meta charset="utf-8" />
    <title>Dark Space - Internal</title>
    <link rel="stylesheet" href="Styles/darkspace.css" />
</head>
<body class="internalStart">
    <form id="frmInternal" runat="server">
        <!-- Port of indexInternal.es.php (step 3). Full game UI is Flash-driven;
             this page exposes the session bootstrap and action dispatch. -->
        <div id="errorData"><asp:Literal ID="litError" runat="server" /></div>
        <asp:PlaceHolder ID="phContent" runat="server" />
    </form>
</body>
</html>
