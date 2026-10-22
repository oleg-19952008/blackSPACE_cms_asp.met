$(document).ready(function(){
	

$("#GalaxyG").on("click",function(){
	$.ajax({ type: "GET", url:'./GalaxyGates/rand.php', cache : false, success: function(data){
    $("#GalaxyBody").html(data);
}, dataType: "html"});

});

});
