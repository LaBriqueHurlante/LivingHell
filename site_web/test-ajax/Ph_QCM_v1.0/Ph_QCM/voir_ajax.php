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
/* Cette page gère les requêtes envoyées avec Ajax depuis la page de visualisation de QCM.
Variables :
$_SESSION['qcm'] => Identifiant du QCM.
$_SESSION['rep'] => Réponses de l'utilisateur.
$_SESSION['q'] => Numéro de la question actuelle.
$_SESSION['nb_q'] => Nombre de questions dans le QCM (pour ne pas avoir à la lire tout le temps dans le fichier XML).
$_SESSION['fini'] => Indique si le QCM est fini. On montre alors la correction.
*/

session_start();
require_once 'fonctions.php';


$fichier_xml = simplexml_load_file('qcm/'.$_SESSION['qcm'].'/qcm.xml');

if ($_SESSION['fini'] != 1)
{
	// Le QCM n'est pas encore terminé et se poursuit normalement.

	// Si $_SESSION['q'] == -1, l'utilisateur n'a pas encore répondu a une question
	// Si $_SESSION['q'] >= 0, l'utilisateur a répondu à la question $_SESSION['q'] et on doit sauvegarder sa réponse.
	if ($_SESSION['q'] >= 0 && isset($_POST['rep'])) $_SESSION['rep'][] = (int)$_POST['rep'];

	// On peut alors passer à la question suivante, si le QCM n'est pas terminé.
	if ($_SESSION['q'] < $_SESSION['nb_q'] - 1)
	{
		$_SESSION['q'] ++;
		// On envoie la nouvelle question.
		$qxml = $fichier_xml->question[$_SESSION['q']];
		$qxml->explic = multi_lignes((string)$qxml->explic);
		foreach ($qxml->reponses->rep as $rep) unset($rep['bonne']); // L'utilisateur ne doit pas pouvoir connître la bonne réponse.
		header("Content-Type: text/xml");
		echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n".XMLpropre($qxml->asXML());
	}
	else
	{
		// Le QCM est terminé, il faut envoyer les résultats.
		$bonnes_reponses = 0;
		$i = 0;
		foreach ($fichier_xml->question as $qxml)
		{
			if (isset($qxml->reponses->rep[$_SESSION['rep'][$i]]) && (int)$qxml->reponses->rep[$_SESSION['rep'][$i]]['bonne'] == 1)
				$bonnes_reponses ++;
			$i ++;
		}
		$_SESSION['fini'] = 1;
		header("Content-Type: text/xml");
		echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n".'<bonnesreponses>'.$bonnes_reponses.'</bonnesreponses>';
	}
}
else
{
	// Le QCM est fini, on affiche le corrigé. Le numéro de la question à afficher est envoyé dans la variable $_POST['q'].
	// La numérotation commence à 1 pour le client, et à 0 côté serveur.
	$q = 0;
	if (isset($_POST['q'])) $q = (int)$_POST['q'] - 1;
	if (!isset($fichier_xml->question[$q])) exit(0); // Erreur : la question n'existe pas.
	$qxml = $fichier_xml->question[$q];
	$qxml->explic = multi_lignes((string)$qxml->explic);
	$i = 0;
	foreach ($qxml->reponses->rep as $rep)
	{
		if ((int)$rep['bonne'] == 1) $rep->addAttribute('coul', 'vert');
		elseif ($_SESSION['rep'][$q] == $i) $rep->addAttribute('coul', 'rouge');
		else $rep->addAttribute('coul', 'blanc');
		unset($rep['bonne']);
		$i ++;
	}
	header("Content-Type: text/xml");
	echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n".XMLpropre($qxml->asXML());
}

?>