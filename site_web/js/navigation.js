// JavaScript Document

$(document).ready(function() {
    $("#menu a").click(function(){
		page=$(this).attr("href");
		$.ajax({
			url: "core/pages/"+page,
			cache:false,
			success:function(html){
				afficher(html);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(textStatus);
			}
		})
		return false;
	});
});

function afficher(data){
$("#vignette").fadeOut('fast', function(){
	$("#vignette").empty();
	$("#vignette").append(data);
	$("#vignette").fadeIn("fast");
})
}