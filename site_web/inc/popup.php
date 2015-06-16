
<div id="vignette">
<?php

$d="core/pages/";
if(isset($_GET['p'])){
	$p=strtolower($_GE['p']);
	if(preg_match("/^[a-z0-9\-]+$/",$p) && file_exists($d.$p.".php")){
		include $d.$p.".php";
	}
	else{
		include $d."404.php";
	}
}
else{
	include $d."index.php";
}

?>
 </div><!--Vignette tabs-->
 
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