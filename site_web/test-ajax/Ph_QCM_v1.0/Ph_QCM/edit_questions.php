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
/* Cette page charge et affiche l'interface de modification des questions d'un qcm.
Le fichier interface/edit_questions.html contient l'interface
et edit_quest_script.js le script (javascript) qui fait le lien entre l'utilisateur et la page php du serveur (edit_ajax.php). */

session_start ();

require_once 'admin_verif.php';
require_once 'fonctions.php';

// Cette page n'est accessible que si une session admin est ouverte.
if ($admin == 0)
{
	header('Location: index.php');
	exit(0);
}

if (!isset($_GET['qcm']) || !file_exists('qcm/'.$_GET['qcm']))
{
	header('Location: index.php'); // Le qcm n'existe pas.
	exit(0);
}

$_SESSION['qcm'] = $_GET['qcm']; // On sauvegarde l'identifiant du qcm dans les variables de session.

// On affiche la page de modification des questions.
$html = motif('edit_questions', '[[QCM]]', $_GET['qcm']);

echo $html;

?>