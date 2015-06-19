<?php
session_start();
$lvl=(isset($_SESSION['level']))?(int) $_SESSION['level']:1;
$id=(isset($_SESSION['id']))?(int) $_SESSION['id']:0;
$pseudo=(isset($_SESSION['pseudo']))?$_SESSION['pseudo']:'';
if ($id>0) 
{
	echo $_SESSION['pseudo'];
	echo '    -     ';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//FR" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>Recherche de Cours </title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" href="style.css" type="text/css" charset="utf-8"/>
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="search_script.js"></script>
</head>
<body>
    <div class="wrap">
        <div class="search">
            <input type="text" name="recherche" class="text" id="recherche"/>
        </div>
        <div class="resultat" id="resultat"></div>
    </div>
</body>
</html>