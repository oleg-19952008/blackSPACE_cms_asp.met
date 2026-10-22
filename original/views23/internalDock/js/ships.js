$(function() {

	$('.ShipsList td').click(function() {
		var currentId = $(this).attr('id');
		console.log('ships id : ' + currentId);
		$('.ContentPreview').load("http://35.164.68.199/flashAPI/shipAnim.php?id=" + currentId);
		$('.ShipDesc').load("http://35.164.68.199/ajaxAPI/ship_infos.php?id=" + currentId);
	});


});