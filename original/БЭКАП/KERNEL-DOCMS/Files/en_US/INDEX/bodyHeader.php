    <body>
        
        <script>
	function checkMyCookies() {

	    var cookieLeMess = 'Please activate cookies for your browser.';

		var cookieEnabled=(navigator.cookieEnabled)? '' : cookieLeMess

		//if not IE4+ nor NS6+
		if (typeof navigator.cookieEnabled =="undefined" && !cookieEnabled){

			cookieEnabled=(document.cookie.indexOf("testcookie")!=-1)? '' : cookieLeMess
		}

		return cookieEnabled;
	}
</script>
        <noscript><div id="noScript">Please activate Java Script for your browser.</div></noscript>
        
        <script type="text/javascript">
            
            var cookieMessage = checkMyCookies()
            if("" != cookieMessage) {
                document.write('<div id="noCookie">' + cookieMessage + '</div>');
            }
            
        </script>
        <div id="busy_layer"></div>

        <!-- affiliateStartTag -->
