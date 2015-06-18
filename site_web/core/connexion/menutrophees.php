<?php
session_start();

$titre="Profil";
include("includes/connexBDD.php");
include("includes/header.php");
define('ERR_IS_NOT_CO','Vous n etes pas connecté');
if ($id==0) erreur(ERR_IS_NOT_CO);
// Récupération de l'avatar ------

$req = $db->prepare("SELECT * FROM trophee WHERE id_uti = '".$_SESSION["id"]."'") or die(mysql_error());
$req->execute();	
$donnees = $req->fetch();
$repertoire = "../../";

?>

<body style="width:800;">

	<div id='menuprofile'>
		<a href='index.php'> index - </a> 
		<a href='profile.php'> Profile global - </a> 
		<a href='menustats.php'> Statistiques - </a>
		<a href='menutrophees.php'> Trophées - </a>
		</br></br>
	</div>

<div id='trophees'>
		<img style="width:100px; height:100px;"src="<?php echo $repertoire.$donnees['contenu']; ?>"/>
</div>


</body>
</html>

