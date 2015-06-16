
<div id="tabs">
		<ul>
			<li><a href="#tabs-1" title="">Tab 1</a></li>
			<li><a href="#tabs-2" title="">Tab 2</a></li>
			<li><a href="#tabs-3" title="">Tab 3</a></li>
		</ul>

		<div id="tabs_container">
			

			<div id="tabs-1">
				Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus.
			</div>

			<div id="tabs-2">
				   Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus.
		
			</div>

			<div id="tabs-3">
				    Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus.
			</div>

		</div><!--End tabs container-->
		
	</div><!--End tabs-->

 
 <script>
$('#tabs').tabulous({});
$('#vignette').hide();

function ouvrir_fermer(ouvrir,fermer)
{
$(document).ready(function()
{
$('#'+fermer).hide("slide", { direction: "left" }, "fast");
$('#'+ouvrir).show("slide", { direction: "left" }, "fast");

});
}
</script>