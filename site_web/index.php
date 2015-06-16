<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Zombie Academy</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/tabulous.css" rel="stylesheet" type="text/css">
<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/navigation.js"></script>
<script src="js/tabulous/tabulous.min.js"></script>
</head>

<body>
<section id="page">
<?php

include_once ("inc/header.php");
include_once ("inc/map.php");
?>
<div id="vignette">
<?php

$d="core/pages/";
if(isset($_GET['p'])){
	$p=strtolower($_GET['p']);
	if(preg_match("/^[a-z0-9\-]+$/",$p) && file_exists($d.$p.".php")){
		include $d.$p.".php";
	}
	else{
		include $d."404.php";
	}
}
else{
	include $d."bienvenue.php";
}

?>
 </div><!--Vignette tabs-->
 <?php
include_once ("inc/footer.php");

?>
</section>

<script src="js/map.js"></script>

</body>
</html>