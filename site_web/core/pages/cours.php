
<div id="tabs" class="tabs_rouge">
		<ul>
			<li><a href="#tabs-1" title="">Cours!</a></li>
			<li><a href="#tabs-2" title="">Chercher un cours</a></li>
            <li><button id="but_cancel"><img src="css/media/img/wrong.png" /></button></li>
		</ul>

		<div id="tabs_container">
			

			<div id="tabs-1" class="tabs_rouge">
				<aside class="tabs_aside"><p>Chaque cours propose une oeuvre à découvrir afin d'en apprendre plus sur nos amis les Zombies.</p></aside>
                <h1>Cours au hasard</h1>
			</div>

			<div id="tabs-2" class="tabs_rouge">
				   Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus.
		
			</div>
            
		</div><!--End tabs container-->
		
	</div><!--End tabs-->
<script>
$(document).ready(function() {
$( "#but_cancel" ).click(function( event ) {
  event.preventDefault();
  $( "#vignette" ).hide("slide", { direction: "right" }, "fast");
});
})
</script>