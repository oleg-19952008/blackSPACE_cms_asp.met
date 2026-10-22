<h3 class="no_ind">Website  <span>details</span></h3>
<div id="middlebtopa">
<small>
<span style="font-size: 12px; font-family:Verdana;">

 <div class="menu_block">
        	<div class="container">
                <nav>
                    <ul class="sf-menu">
                        <li><a href="?ucp" id="leftmostitem">Main edit</a></li>
            <li><a href="?edit=details">Website details</a></li>
            <li><a href="?edit=screenshots">Upload screenshots</a></li>
            <li><a href="?edit=membership">Gold membership</a></li>
            <li><a href="?edit=htmlcode">Get HTML code</a></li>
            <li><a href="?logout">Logout!</a></li>

                    </ul>
                    <div class="clear"></div>
                </nav>
            </div>
        </div>

<br style="clear: left" />
<br />


		<form method="POST" action="?edit=details" style="display: inline;" name="detail">
		<div id="boxy">
		<ul>	
		<li>When updating your site details for the first time you will receive <b>7 days free gold membership</b>.</li><br />
		<li>There's a minimum and a maximum letters you can type in, 400 letters is minimum and 15 000 is maximum</b>.</li><br />
		<li>By typing a long text you will <b>drastically</b> inscrease the number of visitors from our top list.</b>.</li><br />
		<li><b>Note that changes might take up to 5 minutes before it gets updated in your site details.</b></b>.</li><br />
		</ul>
		</div><br /><br />

		<b><span style="color: red;"></span></b><br /><br />		
		<b>How to type your website details:</b><br /><br />

		This can feel like a waste of time but it truely isnt, by typing a text about your website/server the search engines will eventually index your websites site detail page.
		This will bring you quite alot of more visitors to your webpage.<br /><br />

		Its however important that the content is unique this means that you can not copy a text from another webpage 
		on the internet or else your site detail page will be ignored by the search engines.<br /><br />

		This is called duplicate content in SEO (search engine optimization) terms, The search engine will see the content as duplicate and there for ignore the information so its 
		highly important that you make it as unique as possible.<br /><br />

		But this text/information is not just for the search engine, This is a way to simply reach the visitors on xtremetop100.com.<br /> If they find a website in the listing that looks
		intresting they can simply click on the <b>Details</b> link at the rank number in the top list to read about your webpage, the small description in the top list is just not enough sometimes.<br /><br />

		There's a few commands you can use to structure up a nice information text which you can below the text box.<br /><br />

		<br /><br />
		<div style="float: left; font-weight: bold;">Website details:</div><div id="counter" style="float: right;">15000 letters left.</div> <br />
		<textarea rows="25" name="details" cols="86" onChange="check();" onfocus="check();" onblur="check();" onKeyup="check();"><?php echo $details; ?></textarea>
		<br /><br />
		<input type="submit" value="Update site details" name="update" style="float:right;"><br />
		</form>
		<br /><br />
		



		<b>Available commands:</b>
		<div id="boxy">
		<ul>	
		<b>[b]</b>...<b>[/b]</b> for bold text.<br />
		<b>[u]</b>...<b>[/u] </b>for underlining text.<br />
		<b>[i]</b>...<b>[/i]</b> for italicizing text.<br />
		<b>[url]</b>...<b>[/url]</b> for creating url's.<br />
		<b>[s]</b>...<b>[/s]</b> for creating line through.<br>
		<b>[C]</b>...<b>[/C] </b>Center text.<br />
		</ul>
		</div>
<br />		
</span>
</small>
</div>


<script language="JavaScript">
<!--
	chec();
	function check() {

		cntl = document.detail;
		if(eval(15000-cntl.details.value.length) < 0) {
			cntl.sitedetails.value = cntl.details.value.slice(0,15000);
		}
		ChrLeft = 15000-cntl.details.value.length + " letters left.";
		
		document.getElementById("counter").innerHTML = ChrLeft;
	}
		 
//-->
</script>