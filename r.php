<?php
include_once 'cnx.php';

switch ($_GET["fct"]) {
	case "question":
		getQuestion($bdd);
	break;
	case "uti":
		getUti($bdd);
	break;
	
	default:
		;
	break;
}

function getQuestion($bdd){
	//exécution de la requête
	$reponse = $bdd->query('SELECT * FROM question');
	//récupération des données
	$donnees = $reponse->fetchAll();
	echo json_encode($donnees);
	//on ferme les curseur
	$reponse->closeCursor();	
}

function getUti($bdd){
	
	//exécution de la requête
	$reponse = $bdd->query('SELECT * FROM utilisateur');
	//récupération des données
	$donnees = $reponse->fetchAll();
	echo json_encode($donnees);
	//on ferme les curseur
	$reponse->closeCursor();	
}

?>