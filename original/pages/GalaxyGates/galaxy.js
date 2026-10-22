$(document).ready(function(){
	

$("#start_gg_btn").on("click",function(){
	$.ajax({ type: "GET", url:'./pages/GalaxyGates/rand.php', cache : false, success: function(data){
    $("#GalaxyBody").html(data);
}, dataType: "html"});

});

});
