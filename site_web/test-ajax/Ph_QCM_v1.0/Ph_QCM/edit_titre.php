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
/* Cette page charge et affiche l'interface de modification du titre et de la description d'un qcm.
Les données sont renvoyées sur cette page par un formulaire. */

session_start ();

require_once 'admin_verif.php';
require_once 'fonctions.php';

// Cette page n'est accessible que si une session admin est ouverte.
if ($admin == 0)
{
	header('Location: index.php');
	exit(0);
}

if (isset($_POST['titre']))
{
	// Les données ont été envoyées par le formulaire. On les enregistre dans le fichier xml.
	$fichier_xml = simplexml_load_file('qcm/'.$_SESSION['qcm'].'/qcm.xml');

	$fichier_xml->titre = encode($_POST['titre']);
	$fichier_xml->description = encode($_POST['description']);

	$f = fopen('qcm/'.$_SESSION['qcm'].'/qcm.xml', 'w');
	fwrite($f, $fichier_xml->asXML());
	fclose($f);

	header('Location: index.php');
	exit(0);
}
elseif (!isset($_GET['qcm']) || !file_exists('qcm/'.$_GET['qcm']))
{
	header('Location: index.php'); // Le qcm n'existe pas.
	exit(0);
}

$_SESSION['qcm'] = $_GET['qcm']; // On sauvegarde l'identifiant du qcm dans les variables de session.

// On affiche l'interface avec le formulaire pour modifier les données.
$fichier_xml = simplexml_load_file('qcm/'.$_SESSION['qcm'].'/qcm.xml');
$html = motif('edit_titre', array('[[TITRE]]', '[[DESCRIPTION]]'), array((string)$fichier_xml->titre, (string)$fichier_xml->description));

echo $html;

?>