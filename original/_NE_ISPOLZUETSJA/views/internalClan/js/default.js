$(function() {


	$('#createclan, #joinclan').on('submit', function() {
		var url  = $(this).attr('action');
		var data = $(this).serialize();
		console.log(data);

		$.post(url, data, function(o) {
		$('#error').empty();
		for(i in o)
		{
			$('#error').append('<p class="singup_errorMessage">' + o[i] + '</p>');
		}

		$.colorbox({width:"500px", inline:true, href:"#error"});

		}, 'json');

		return false;

	});

	$('body').on('submit', '#CancelDiplomacy', function() {
		event.preventDefault();
		var url  = $(this).attr('action');
		var data = $(this).serialize();
		$.post(url, data);

        $(this).parent().fadeOut(400, function(){
            $(this).remove();
        });

	});


	var $rows = $('#table tr');
	console.log($rows);
	$('#search input').keyup(function() {
	    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
	    
	    $rows.show().filter(function() {
	        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
	        return !~text.indexOf(val);
	    }).hide();
	});
});