<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="default.aspx.cs" Inherits="DarkSpace._Default" EnableViewStateMac="false" ValidateRequest="false" %>
<%--
    Migration step 4: the page markup is no longer inline. index.php ended with
        require FILES . 'INDEX/header.php';
        require FILES . 'INDEX/body.php';
    and default.aspx.cs now streams those legacy templates through TemplateManager
    (KERNEL-DOCMS/Files/en_US/INDEX/*) with {{SERVER}}/{{ERRORDATA}}/{{MODALSCRIPT}}/{{BANBOX}}
    token substitution. This file intentionally renders nothing itself.
--%>
