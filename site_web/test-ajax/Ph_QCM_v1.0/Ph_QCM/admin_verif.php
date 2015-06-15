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
/* Cette page permet de vérifiée si l'admin est bien connecté.
$admin == 1 => session admin.
$admin == 0 => simple utilisateur.
Cette page sera utilisée pour déterminer si les éléments réservés à l'admin doivent être affichés sur les autres pages.
 */

require_once '_config.php';

// on teste si une session admin est ouverte.

if (isset($_SESSION['passe']))
{
	// une session admin est ouverte, on vérifie le mot de passe.
	if ($_SESSION['passe'] == $passe) $admin = 1; // bon mot de passe.
	else $admin = 0; // mauvais mot de passe.
}
else $admin = 0;

?>