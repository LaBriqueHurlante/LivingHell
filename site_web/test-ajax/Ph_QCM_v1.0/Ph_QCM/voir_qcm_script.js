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
/* Script utilisant Ajax */

// Variables globales.
var qcm = ''; // Dossier du QCM.
var nb_q = 0; // nombre de questions dans le QCM.
var q = 1; // numéro de la question actuelle.
var rep = 0; // numéro de la réponse actuelle.
var fini = 0; // indique si le QCM est terminé (affichage du corrigé.

function reception()
{
	if (http_request.readyState == 4 && http_request.status == 200)
	{
		var fichierxml = http_request.responseXML;

		if (fini == 1) // Affichage du corrigé.
		{
			var question, image, explic, reponses;
			var xml = fichierxml.getElementsByTagName('question').item(0);
			if (xml.childNodes[0].firstChild) question = xml.childNodes[0].firstChild.data;
			else question = '';
			if (xml.childNodes[1].firstChild) image = xml.childNodes[1].firstChild.data;
			else image = '';
			if (xml.childNodes[2].firstChild) explic = xml.childNodes[2].firstChild.data;
			else explic = '';
			reponses = new Array;
			for (i = 0; i < xml.childNodes[3].childNodes.length; i++)
			{
				reponses[i] = new Array;
				if (xml.childNodes[3].childNodes[i].firstChild)
					reponses[i][0] = xml.childNodes[3].childNodes[i].firstChild.data;
				else
					reponses[i][0] = '';
				reponses[i][1] = xml.childNodes[3].childNodes[i].getAttribute('coul');
			}

			// remplissage de la page avec les données lues.
			document.getElementById('c_titre').innerHTML = ':. Correction : Question '+q+'/'+nb_q+' .:';
			var html = '<div id="voir_question">'+question+'</div>';
			if (image != '') html += '<div id="voir_image"><img alt="" src="qcm/'+qcm+'/'+image+'" /></div>';
			if (explic != '') html += '<div id="voir_explic">'+explic+'</div>';
			html += '<div id="voir_reponses">';
			rep = 0;
			for (i = 0; i < reponses.length; i++)
			{
				html += '&gt; <a class="'+reponses[i][1]+'">'+reponses[i][0]+'</a><br />';
			}
			html += '</div>';
			document.getElementById('c_cadre').innerHTML = html;
			if (q > 1) document.getElementById('bout_0').innerHTML = '<a href="javascript:c_prec();">Question précédante</a>';
			else  document.getElementById('bout_0').innerHTML = 'Question précédante';
			if (q < nb_q) document.getElementById('bout_1').innerHTML = '<a href="javascript:c_suiv();">Question suivante</a>';
			else  document.getElementById('bout_1').innerHTML = 'Question suivante';
			return 0;
		}


		if (fichierxml.getElementsByTagName('bonnesreponses').item(0) != null)
		{
			// Le QCM est fini, on affiche le nombre de bonnes réponses.
			var bonnes_rep = fichierxml.getElementsByTagName('bonnesreponses').item(0).firstChild.data;
			document.getElementById('c_cadre').innerHTML = '<div id="voir_result"><img src="interface/vert.gif" alt="" height="15" width="'+Math.floor(bonnes_rep*200/nb_q)+'" class="no_border_droite" /><img src="interface/rouge.gif" alt="" height="15" width="'+Math.floor((nb_q-bonnes_rep)*200/nb_q)+'" class="no_border_gauche" /><br /><br />Bonnes réponses : '+bonnes_rep+'/'+nb_q+'</div>';
			document.getElementById('c_titre').innerHTML = ':. Résultats .:';
			document.getElementById('bout_1').innerHTML = '<a href="javascript:corrige();">Voir le corrigé</a>';
			return 0;
		}

		// On récupère les données de la question.
		var question, image, explic, reponses;
		var xml = fichierxml.getElementsByTagName('question').item(0);
		if (xml.childNodes[0].firstChild) question = xml.childNodes[0].firstChild.data;
		else question = '';
		if (xml.childNodes[1].firstChild) image = xml.childNodes[1].firstChild.data;
		else image = '';
		if (xml.childNodes[2].firstChild) explic = xml.childNodes[2].firstChild.data;
		else explic = '';
		reponses = new Array;
		for (i = 0; i < xml.childNodes[3].childNodes.length; i++)
		{
			if (xml.childNodes[3].childNodes[i].firstChild) reponses[i] = xml.childNodes[3].childNodes[i].firstChild.data;
			else reponses[i] = '';
		}

		// remplissage de la page avec les données lues.
		document.getElementById('c_titre').innerHTML = ':. Question '+q+'/'+nb_q+' .:';
		var html = '<div id="voir_question">'+question+'</div>';
		if (image != '') html += '<div id="voir_image"><img alt="" src="qcm/'+qcm+'/'+image+'" /></div>';
		if (explic != '') html += '<div id="voir_explic">'+explic+'</div>';
		html += '<div id="voir_reponses">';
		rep = 0;
		for (i = 0; i < reponses.length; i++)
		{
			html += '<input type="radio" name="rep"'+((i == rep) ? ' checked="checked"' : '')+' onclick="javascript:rep='+i+';" /> '+reponses[i]+'<br />';
		}
		html += '</div>';
		document.getElementById('c_cadre').innerHTML = html;
		document.getElementById('bout_1').innerHTML = '<a href="javascript:suiv();">Valider</a>';
	}
}

function envoie_req(req)
{
	// création du XMLHttpRequest et envoie d'une requête.
	if (window.XMLHttpRequest)
	{
		http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) http_request.overrideMimeType('text/xml');
	}
	else if (window.ActiveXObject)
	{
		try { http_request = new ActiveXObject("Msxml2.XMLHTTP") }
		catch (e)
		{
			try { http_request = new ActiveXObject("Microsoft.XMLHTTP") }
			catch (e) {}
		}
	}
	if (!http_request) alert('Erreur : Impossible d&#039;initialiser XMLHttpRequest.');

	http_request.onreadystatechange = reception;
	http_request.open('POST', 'voir_ajax.php', true);
	http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

	http_request.send(req);
}

function init(nb_questions, dossier_qcm)
{
	nb_q = nb_questions;
	qcm = dossier_qcm;
	document.getElementById('bout_1').innerHTML = 'Valider'; // On masque le bouton jusqu'à reception des données.
	envoie_req(null);
}

function suiv()
{
	q ++;
	document.getElementById('bout_1').innerHTML = 'Valider'; // On masque le bouton jusqu'à reception des données.
	envoie_req('rep='+rep);
}

function corrige()
{
	q = 1;
	fini = 1;
	document.getElementById('bout_1').innerHTML = ''; // On masque le bouton jusqu'à reception des données.
	envoie_req('q='+q);
}

function c_suiv()
{
	q ++;
	document.getElementById('bout_0').innerHTML = 'Question précédante'; // On masque le bouton jusqu'à reception des données.
	document.getElementById('bout_1').innerHTML = 'Question suivante'; // On masque le bouton jusqu'à reception des données.
	envoie_req('q='+q);
}

function c_prec()
{
	q --;
	document.getElementById('bout_0').innerHTML = 'Question précédante'; // On masque le bouton jusqu'à reception des données.
	document.getElementById('bout_1').innerHTML = 'Question suivante'; // On masque le bouton jusqu'à reception des données.
	envoie_req('q='+q);
}

