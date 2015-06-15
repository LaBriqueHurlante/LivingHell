<?php
/*
Ph_QCM v1.0
Copyright 2006 Tollitte Pierre-Nicolas

    This file is part of Ph_QCM.

    Ph_QCM is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    Ph_QCM is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Ph_QCM; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/* Cette page gère les requêtes envoyées avec Ajax depuis la page d'édition de QCM. */

session_start ();

require_once 'admin_verif.php';
require_once 'fonctions.php';

// cette page n'est accessible que si une session admin est ouverte.
if ($admin == 0) exit(0);


/* Données reçues, à enregistrer dans le fichier qcm.xml.
Les données sont envoyées en POST et qe ou qs est le numéro de la question.
Si qe et envoyé, on modifie ou on ajoute une question au qcm, alors que si qs est envoyé, on supprime cette question. */
if (isset($_POST['qe']))
{

	// on récupère les données envoyées.
	$nbq = (int)$_POST['qe'];
	$question = $_POST['question'];
	$image = $_POST['image'];
	$explic = $_POST['explic'];
	$nb_rep = $_POST['nbrep'];
	$bonne_rep = $_POST['bonne_rep'];

	// Si il n'y a pas d'image, elle a pu être enlevée, il faut donc dédruire l'éventuel fichier envoyé avant que l'utilisateur décoche la case image.
	if ($image == '') det_img($_SESSION['qcm'], $nbq);

	$fichier_xml = simplexml_load_file('qcm/'.$_SESSION['qcm'].'/qcm.xml');

	if (!isset($fichier_xml->question[$nbq]))
	{
		// La question n'existe pas encore, on l'ajoute au qcm.
		$fichier_xml->addChild('question');
		$fichier_xml->question[$nbq]->addChild('q');
		$fichier_xml->question[$nbq]->addChild('image');
		$fichier_xml->question[$nbq]->addChild('explic');
		$fichier_xml->question[$nbq]->addChild('reponses');
	}

	// On remplie la question avec les données envoyées. La fonction encode permet de supprimer les caractères spéciaux des chaînes
	// de caractères (< > " & ...), afin qu'elles puissent être enregistrées dans le fichier xml.
	$qxml = $fichier_xml->question[$nbq];
	$qxml->q = encode($question);
	$qxml->image = $image;
	$qxml->explic = encode($explic);

	// Le nombre des réponses pouvant varier, on supprime toutes les réponses puis on les re-enregistre toutes de nouveau.
	unset($qxml->reponses);
	$qxml->addChild('reponses');
	for ($i = 0; $i < $nb_rep; $i ++)
	{
		$qxml->reponses->addChild('rep');
		$qxml->reponses->rep[$i] = encode($_POST['rep'.$i]);
		if ($i == $bonne_rep) $qxml->reponses->rep[$i]->addAttribute('bonne', '1');
		else $qxml->reponses->rep[$i]->addAttribute('bonne', '0');
	}

	// Enregistrement du qcm modifié dans le fichier qcm.xml.
	$f = fopen('qcm/'.$_SESSION['qcm'].'/qcm.xml', 'w');
	fwrite($f, $fichier_xml->asXML());
	fclose($f);
}
elseif (isset($_POST['qs']))
{
	// On supprime simplement la qs ème question du qcm.
	$nbq = (int)$_POST['qs'];
	$fichier_xml = simplexml_load_file('qcm/'.$_SESSION['qcm'].'/qcm.xml');

	unset($fichier_xml->question[$nbq]);

	$f = fopen('qcm/'.$_SESSION['qcm'].'/qcm.xml', 'w');
	fwrite($f, $fichier_xml->asXML());
	fclose($f);

	// Si une image était attachée à la question, on la supprime également.
	det_img($_SESSION['qcm'], (int)$_POST['qs']);
}

/* Données envoyées.
Après avoir reçu et sauvegarder les données d'une question, cette page peut envoyer les données d'une question au script côté client.
Ainsi, en un appel à cette page, le script côté client peut sauvegarder une question, et afficher les données de la question suivante.
Le numéro de la question dont il faut envoyer les données est contenu dans la variable q.
Les données seront envoyer sous la forme d'un fichier xml. Si le client ne demande pas de données ($_POST['q'] n'existe pas),
on renvoie un fichier xml vide. */
if (isset($_POST['q']))
{
	$nbq = '0';
	$q = '';
	$image = '';
	$explic = '';
	$reponses = '';

	// on recherche les données correspondant à la question voulue.
	$fichier_xml = simplexml_load_file('qcm/'.$_SESSION['qcm'].'/qcm.xml');

	// On envoie également à chaque fois le nombre de questions dans le QCM.
	// Cela permet au client d'afficher "Question XX/XX".
	$nbq = count($fichier_xml->question);
	if (isset($fichier_xml->question[(int)$_POST['q']]))
	{
		$qxml = $fichier_xml->question[(int)$_POST['q']];
		if (isset($qxml->q)) $q = encode((string)$qxml->q);
		if (isset($qxml->image)) $image = (string)$qxml->image;
		if (isset($qxml->explic)) $explic = encode((string)$qxml->explic);
		foreach ($qxml->reponses->rep as $rep) $reponses .= '<rep bonne="'.(string)$rep['bonne'].'">'.encode((string)$rep).'</rep>';
	}

	// Envoie du fichier XML.
	header("Content-Type: text/xml");
	$xml = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
	$xml .= '<reponse nbq="'.$nbq.'"><q>'.$q.'</q><image>'.$image.'</image><explic>'.$explic.'</explic><reponses>'.$reponses.'</reponses></reponse>';
	echo $xml;
}
else
{
	header("Content-Type: text/xml");
	echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n".'<reponse></reponse>';
}

?>