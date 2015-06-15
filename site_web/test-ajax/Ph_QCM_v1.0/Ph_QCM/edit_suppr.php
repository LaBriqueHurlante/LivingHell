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
/* Cette page supprime un qcm, puis redirige vers la page principale.
On supprime tous les fichiers présents dans le dossier du qcm puis le dossier lui-mÃªme. */

session_start ();

require_once 'admin_verif.php';

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

$dossier_qcm = 'qcm/'.$_GET['qcm'];

$dossier = opendir($dossier_qcm);
while (( ($fichier = readdir($dossier)) ) != false)
{
	if ($fichier != '.' && $fichier != '..')
		unlink($dossier_qcm.'/'.$fichier);
}
closedir($dossier);

rmdir($dossier_qcm);

header('Location: index.php');

?>