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
/* Page principale : affiche la liste des QCM et les boutons pour les modifier. */

session_start ();

require_once 'fonctions.php';

// Test de la session admin. On commence par tester si une session admin est ouverte, ou si on est en train d'en ouvrir une (par le formulaire du bas de la page).
require_once 'admin_verif.php';
if ($admin == 0 && isset($_POST['passe']))
{
	// L'utilisateur a cliqué sur le bouton pour s'identifier en tant qu'admin.
	if ($_POST['passe'] == $passe)
	{
		$admin = 1; // Bon mot de passe.
		$_SESSION['passe'] = $passe; // On sauvegarde le mot de passe dans les variables de la session.
	}
}

// On recherche la liste des qcm pour en afficher la liste.
$html_cadres = ''; // contient le code html correspondant aux cadres des albums.
$dossier_qcm = opendir('qcm');
while (( ($fichier = readdir($dossier_qcm)) ) != false)
{
	if ($fichier != '.' && $fichier != '..')
	{
		// fichier est un dossier contenant les données d'un QCM.
		// On lit les infos dans le fichier qcm/$fichier/qcm.xml pour en savoir plus sur le QCM.
		$fichier_xml = simplexml_load_file('qcm/'.$fichier.'/qcm.xml');
		$titre = (string)$fichier_xml->titre;
		$description = multi_lignes((string)$fichier_xml->description);
		$boutons_admin = '';
		if ($admin == 1) $boutons_admin = motif('index_cadre_boutons', '[[QCM]]', $fichier);

		// On génère le code html correspondant au cadre du qcm.
		$html_cadres .= motif('index_cadre', array('[[TITRE]]', '[[QCM]]', '[[DESCRIPTION]]', '[[BOUTONS_ADMIN]]'), array($titre, $fichier, $description, $boutons_admin));
	}
}
closedir($dossier_qcm);

// Code pour afficher le bas de la page : formulaire pour s'identifier en admin ou ajouter un nouveau QCM.
if ($admin == 1) $admin_index = motif('index_admin', '', '');
else $admin_index = motif('index_admin_id', '', '');

// On génère le code html de la page principale.
$html = motif('index', array('[[CADRES]]', '[[ADMIN_INDEX]]'), array($html_cadres, $admin_index));

echo $html;

?>