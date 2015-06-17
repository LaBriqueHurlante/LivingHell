
<div id="tabs" class="tabs_jaune">
		<ul>
			<li><a href="#tabs-1" title="">Atelier!</a></li>
			<li><a href="#tabs-2" title="">Images</a></li>
			<li><a href="#tabs-3" title="">Textes</a></li>
            <li><button id="but_cancel"><img src="css/media/img/wrong.png" /></button></li>
		</ul>

		<div id="tabs_container">
			

			<div id="tabs-1" class="tabs_jaune">
				<aside class="tabs_aside"><p>Les arts plastique, c'est par ici!</p></aside>
			</div>

			<div id="tabs-2" class="tabs_jaune">
				   Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus.
		
			</div>

			<div id="tabs-3" class="tabs_jaune">
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
