$(document).ready(function(){
	$(".dropdown").hide();
	$("#drop").click(function(){
		var X=$(this).attr('id');
		if(X==1){
			$(".dropdown").toggle( "slide", {direction: "up"}, 400 );
			$(this).attr('id', '0');
		} else {
			$(".dropdown").toggle( "slide", {direction: "up"}, 400 );
			$(this).attr('id', '1');
		}
	});
	$(".dropdown").mouseup(function(){
		return false
	});
	$("#drop").mouseup(function(){
		return false
	});
	$(document).mouseup(function(){
		$(".dropdown").hide( "slide", {direction: "up"}, 400 );
		$("#drop").attr('id', '');
	});
});

$(document).ready(function(){
	$(".div_warning").hide();
	$("#warning_kick").mouseover(function(){
		$(".div_warning").toggle( "slide", {direction: "up"}, 400 );
	});
	$("#warning_kick").mouseout(function(){
		$(".div_warning").hide( "slide", {direction: "up"}, 400 );
	});
});

$(document).ready(function() {
	$('.item_show').hide();
	$('.item_title').click(function(){
		$('#jsitem' + this.id).toggle( "slide", {direction: "up"}, 400)
		$('#' + this.id).toggleClass( " isactiv" );
	});
});