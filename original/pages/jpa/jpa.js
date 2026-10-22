$(document).ready(function(){
	

$("#jpaSubmit").on("click",function(){
	$.ajax({ type: "GET", url:'./pages/jpa/jack.php', cache : false, success: function(data){
    $("#GalaxyBody").html(data);
}, dataType: "html"});

});

});
