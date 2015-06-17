// JavaScript Document

$(document).ready(function() {
    $(".nav a").click(function(){
		page=$(this).attr("href");
		$.ajax({
			url: "core/pages/"+page,
			cache:false,
			success:function(html){
				afficher(html);
				/*cacheVignette( event);*/
				
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(textStatus);
			}
		})
		return false;
	});
});

function afficher(data){
	
$("#vignette").hide("slide", { direction: "left" }, "fast", function(){
	$("#vignette").empty();
	$("#vignette").append(data);
	$('#tabs').tabulous({});	
	$("#vignette").show("slide", { direction: "right" }, "fast");
	//$("#tabs ul").prepend('<li><button id="but_cancel"><img src="css/media/img/wrong.png" /></button></li>');	
})
}



/*function cacheVignette() {
	$( "#but_cancel" ).click(function( event ) {
  event.preventDefault();
  $( "#vignette" ).hide("slide", { direction: "right" }, "fast");
});
	}*/