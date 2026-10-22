            $(function() 
            {
            	$('#login').on('submit', function() {
            			var url  = $(this).attr('action');
            			var data = $(this).serialize();
            			console.log(data);

            			$.post(url, data, function(o) {
            			for(i in o)
            			{
            				if (o[i] == 'logged')
            				{
            					location.href = '/internalStart';
            					return false;
            				}
            				else
            				{
            					$('#login input[type="text"], #login input[type="password"]').css("background", "rgb(255, 169, 169)");
            					console.log("error");
            				}
            			}

            			}, 'json');

            			return false;

        		});

                $('#signup').on('submit', function() {
                    var url  = $(this).attr('action');
                    var data = $(this).serialize();
                    console.log(data);

                    $.post(url, data, function(o) {

                    if ($('.error').css("display") == "none")
                    {
                    	$('.error').fadeIn(1000);
                    }

                    $('.error ul').empty();
                    for(i in o)
                    {
                    	if(i == "result")
                    	{
                    		$('.error').css("border", "1px solid rgb(92, 146, 49)");
                    		$('.error').css("background-color", "#166823");
                    	}
                        $('.error ul').append('<li>' + o[i] + '</li>');
                    }

                    }, 'json');

                    return false;

                });


                $(".button").click(function() 
                {
                    console.debug('work');
                    $('.button').fadeOut();
                    $('.register_form').slideDown(800);
                });

            });