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
/* Cette page crée un nouveau QCM et renvoie sur la page principale.
On crée simplement un dossier et on copie le fichier qcm.xml dedans.
qcm.xml contient la structure de base du qcm. */

session_start ();

require_once 'admin_verif.php';

// Cette page n'est accessible que si une session admin est ouverte.
if ($admin == 0)
{
	header('Location: index.php');
	exit(0);
}

$qcm = uniqid(); // Nom du dossier du qcm, chosi de manière unique.
mkdir('qcm/'.$qcm);
copy('qcm.xml', 'qcm/'.$qcm.'/qcm.xml'); // On copie le fichier xml de base.

header('Location: index.php');

?>