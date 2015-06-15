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
/* Fonctions générales */

function multi_lignes($ch)
{
	// Remplace les retours à la ligne d'une chaîne par des <br />.
	return str_replace(array("\n"), '<br />', $ch);
}

function motif($fichier_interface, $motifs, $valeurs)
{
	// Ouvre un fichier du dossier interface et change les motifs passés en arguments par leur valeur.
	$fnom = 'interface/'.$fichier_interface.'.html';
	$f = fopen($fnom, 'rb');
	$html = fread($f, filesize ($fnom));
	$html = str_replace($motifs, $valeurs, $html);
	fclose($f);
	return $html;
}

function encode($ch)
{
	// Cette fonction est appliquée sur les chaînes de caractères qui vont être utilisées avec SimpleXML.
	if (get_magic_quotes_gpc()) $ch = stripslashes($ch);
	return htmlspecialchars($ch, ENT_COMPAT);
}

function det_img($qcm, $num_quest)
{
	// Supprime, si elle existe l'image liée à une question d'un QCM.
	// L'image à supprimer est qcm/$qcm/imgq_$numquest.***

	$dossier_qcm = opendir('qcm/'.$qcm);
	while (( ($fichier = readdir($dossier_qcm)) ) != false)
	{
		if (substr($fichier, 0, strlen('imgq_'.$num_quest)) == 'imgq_'.$num_quest)
		{
			unlink('qcm/'.$qcm.'/'.$fichier);
			break;
		}
	}
	closedir($dossier_qcm);
}

function XMLpropre($xml)
{
	// Retire les retours à la ligne et les espaces d'un document XML afin qu'il soit lu correctement par javascript.
	return preg_replace('/>\n*\s*</', '><', $xml);
}

?>