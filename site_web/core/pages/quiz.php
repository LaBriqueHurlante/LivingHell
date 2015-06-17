
<div id="tabs" class="tabs_orange">
		<ul>
			<li><a href="#tabs-1" title="">Quiz!</a></li>
			<li><a href="#tabs-2" title="">Chercher un quiz</a></li>
            <li><button id="but_cancel"><img src="css/media/img/wrong.png" /></button></li>
		</ul>

		<div id="tabs_container">
			

			<div id="tabs-1" class="tabs_orange">
			<aside class="tabs_aside"><p>Ici on passe des examens!</p></aside>
			</div>

			<div id="tabs-2" class="tabs_orange">
				  <aside class="tabs_aside"><p>Choisissez votre Quiz</p></aside>
		
			</div>

		</div><!--End tabs container-->
<img id="imgTest" src="../site_web/css/media/img/zombie2.png" />			
	</div><!--End tabs-->
<script>
	
$('#imgTest').hide();
$(document).ready(function() {
	$('#imgTest').show().delay( 100 ).animate({
		top:'140px'
		});	
	
$( "#but_cancel" ).click(function( event ) {
  event.preventDefault();
  $( "#vignette" ).hide("slide", { direction: "right" }, "fast");
});
})
</script>
