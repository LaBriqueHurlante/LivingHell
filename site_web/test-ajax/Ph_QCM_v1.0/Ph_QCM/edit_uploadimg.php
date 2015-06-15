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
/* Cette page gère l'upload d'images. Elle affiche d'abord le formulaire d'envoie, puis lorsque les données sont envoyées,
elle enregistre l'image au bon endroit. */

session_start ();

require_once 'admin_verif.php';
require_once 'fonctions.php';

// Cette page n'est accessible que si une session admin est ouverte.
if ($admin == 0)
{
	header('Location: index.php');
	exit(0);
}

if (isset($_GET['q']))
{
	// La page est appelée depuis la page d'édition de QCM, on affiche le formulaire pour envoyer l'image.
	// On garde aussi le numéro de la question dans les variables de session pour pouvoir enregistrer l'image au bon endroit après reception.
	$_SESSION['q'] = $_GET['q'];
	$html = motif('edit_uploadimg', '', '');
}
elseif (!empty($_FILES['fichierimg']['tmp_name']))
{
	// Une image a été envoyée. on doit l'enregistrer dans qcm/[id_qcm]/imgq_[nb_question].*
	if(!is_uploaded_file($_FILES['fichierimg']['tmp_name']))
	{
		// Erreur lors de la reception.
		echo 'Erreur lors de la reception du fichier ...';
		exit(0);
	}

	// On détruit l'ancienne image.
	det_img($_SESSION['qcm'], $_SESSION['q']);

	// On cherche l'extension du fichier.
	$ext = substr($_FILES['fichierimg']['name'], strrpos($_FILES['fichierimg']['name'], '.'));

	move_uploaded_file($_FILES['fichierimg']['tmp_name'], 'qcm/'.$_SESSION['qcm'].'/imgq_'.$_SESSION['q'].$ext);
	$html = motif('edit_uploadimg_fini', '[[IMAGE]]', 'imgq_'.$_SESSION['q'].$ext);
}
echo $html;

?>