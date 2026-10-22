$(function() {

	$('#edit_account_form').on('submit', function() {
		var url  = $(this).attr('action');
		var data = $(this).serialize();
		console.log(data);

		$.post(url, data, function(o) {
		$('#errorMessage').empty();
		for(i in o)
		{
			$('#errorMessage').append(o[i]);
			if (i == 'result')
			{
				$('#username').empty();
				$('#username').append(o['username']);
			}

		}

		}, 'json');

		return false;

	});

	$('#edit_account_link').click( function() {

		$.colorbox({width:"500px", inline:true, href:"#edit_account"});

		return false;

	});




});