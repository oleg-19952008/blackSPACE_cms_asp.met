<meta charset="utf-8">
<link rel="stylesheet" media="all" href="../public/css/register.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

    <script type="text/javascript">
        $_jq=jQuery.noConflict(true);
    </script>

<script type="text/javascript" src="../public/js/colorbox.js"></script>
    <script type="text/javascript">
		$.get('dashboard/xhrGetListings', function(o) {
			
			for (var i = 0; i < o.length; i++)
			{
				$('#listInserts').append('<div>' + o[i].text + '<a class="del" rel="'+ o[i].id +'" href="#">X</a></div>');
			}
		$('#test_inline').ready( function() {
			var url  = $(this).attr('action');
			var data = $(this).serialize();
			console.log(data);

			$.post(url, data, function(o) {

				$('#signup_signup').append('<p class="singup_errorMessage">' + o[1] + '</p>');

			}, 'json');

			return false;
		});

        $_jq(document).ready(function(){
            $_jq('.inline').colorbox({inline: true, width: "480px"});
        });

    </script>
<a href="#test_inline" class="inline cboxElement">
	ci
<a/>
<div style="display: none">
<div id="test_inline" style="padding: 10px 0 10px 0">
<p class="singup_errorMessage"></p>
</div>
</div>