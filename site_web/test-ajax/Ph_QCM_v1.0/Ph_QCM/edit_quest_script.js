/* Script utilisant Ajax */

// Variable globales.
var qcm = ''; // dossier du qcm.
var q = 0; // numéro de la question actuelle.
var nb_q = 1; // nombre total de questions.
var question = ''; // question actuelle.
var image = ''; // nom de l'image.
var explic = ''; // explications de la question.
var reponses = new Array; // tableau contenant les réponses.
var bonne_reponse = 0; // numéro de la bonne réponse.
var validation = 0; // cette variable est mise à 1 lorsque l'utilisateur clique sur valider.

function aff_reponses()
{
	// affichage des réponses en fonction du contenu de la variable "reponses".
	var rephtml = '';
	for (i = 0; i < reponses.length; i++)
	{
		rephtml += '<input type="radio" name="bonne_rep"'+((bonne_reponse == i) ? ' checked="checked"' : '')+' onclick="javascript:bonne_reponse='+i+';" /> <input type="text" size="30" id="rep_'+i+'" value="'+reponses[i]+'" onchange="javascript:reponses['+i+']=this.value;" />';
		rephtml += ' [<a href="javascript:suppr_rep('+i+')">Supprimer cette réponse</a>]<br />';
	}
	document.getElementById('rep').innerHTML = rephtml;
}

function reception()
{
	// fonction appelée lors du retour d'une requête XMLHttpRequest;

	if (validation == 1)
	{
		window.location.href = 'index.php';
		return 0;
	}

	// on reçoit les données d'une question dans un fichier xml et on les affiche.
	if (http_request.readyState == 4 && http_request.status == 200)
	{
		// lecture des données du fichier XML.
		var xml = http_request.responseXML;
		var rep = xml.getElementsByTagName('reponse').item(0);
		nb_q = rep.getAttribute('nbq');
		if (nb_q < q + 1) nb_q = q + 1;
		if (rep.childNodes[0].firstChild) question = rep.childNodes[0].firstChild.data;
		else question = '';
		if (rep.childNodes[1].firstChild) image = rep.childNodes[1].firstChild.data;
		else image = '';
		if (rep.childNodes[2].firstChild) explic = rep.childNodes[2].firstChild.data;
		else explic = '';
		reponses = new Array;
		bonne_reponse = 0;
		for (i = 0; i < rep.childNodes[3].childNodes.length; i++)
		{
			if (rep.childNodes[3].childNodes[i].firstChild) reponses[i] = rep.childNodes[3].childNodes[i].firstChild.data;
			else reponses[i] = '';
			if (rep.childNodes[3].childNodes[i].getAttribute('bonne') == 1) bonne_reponse = i;
		}

		// remplissage de la page avec les données lues.
		document.getElementById('nbq').innerHTML = ':. Question '+(q+1)+'/'+nb_q+' .:';
		document.getElementById('question').value = question;
		if (image != '') // une image est attachée à la question.
		{
			document.getElementById('image').checked = true;
			document.getElementById('dimage').innerHTML = '<img src="qcm/'+qcm+'/'+image+'" alt="" id="img" /><br />[<a href="javascript:ch_image();">Changer l&#039;image</a>]';
		}
		else // aucune image.
		{
			document.getElementById('image').checked = false;
			document.getElementById('dimage').innerHTML = '';
		}
		document.getElementById('texplic').value = explic;
		aff_reponses();

		// affichage des boutons du bas.
		if (nb_q > 1) document.getElementById('bout_suppr').innerHTML = '<a href="javascript:suppr_quest();">Supprimer cette question</a>';
		else document.getElementById('bout_suppr').innerHTML = 'Supprimer cette question';
		if (q > 0) document.getElementById('bout_prec').innerHTML = '<a href="javascript:quest_prec();">Question précédante</a>';
		else document.getElementById('bout_prec').innerHTML = 'Question précédante';
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
	http_request.open('POST', 'edit_ajax.php', true);
	http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

	http_request.send(req);
}

function init(dossier_qcm)
{
	// fonction appelée au chargment de la page, initiatisation, et chargement de la première question.
	qcm = dossier_qcm;

	envoie_req('q=0');
}

function q_change()
{
	question = document.getElementById('question').value;
}

function image_click()
{
	if (document.getElementById('image').checked)
		document.getElementById('dimage').innerHTML = '<img src="" alt="" id="img" /><br />[<a href="javascript:ch_image();">Changer l&#039;image</a>]';
	else
	{
		document.getElementById('dimage').innerHTML = '';
		image = '';
	}
}

function ch_image()
{
	// ouvre une fenêtre permettant l'upload d'une nouvelle image.
	fenimage = window.open('edit_uploadimg.php?q='+q, 'upload_img', 'menubar=no,location=no,resizable=no,scrollbars=no,status=no,width=600,height=100');
	fenimage.focus();
}

function ch_image_fini(nouv_img)
{
	fenimage.close();
	image = nouv_img;
	var now = new Date();
	// ceci permet d'actualiser l'image même si elle a la meme adresse que la précédente.
	document.getElementById('img').src = 'qcm/'+qcm+'/'+image+'?'+now.getTime(); 
}

function explic_change()
{
	explic = document.getElementById('texplic').value;
}

function suppr_rep(rep)
{
	var reponses_new = new Array();
	for (i = 0; i < rep; i++) reponses_new[i] = reponses[i];
	for (i = rep + 1; i < reponses.length; i++) reponses_new[i - 1] = reponses[i];
	if (bonne_reponse >= rep && bonne_reponse > 0) bonne_reponse --;
	reponses = reponses_new;
	aff_reponses();
}

function aj_rep()
{
	reponses[reponses.length] = 'Nouvelle réponse';
	aff_reponses();
}

function donnees_envoie()
{
	// prépare l'envoie des données d'une question vers la page php.
	var d = 'qe='+q;
	d += '&question='+encodeURIComponent(question);
	d += '&image='+image;
	d += '&explic='+encodeURIComponent(explic);
	d += '&bonne_rep='+bonne_reponse;
	d+= '&nbrep='+reponses.length;
	for (i = 0; i < reponses.length; i++) d += '&rep'+i+'='+encodeURIComponent(reponses[i]);
	return d;
}

function val()
{
	validation = 1;
	envoie_req(donnees_envoie());
}

function quest_prec()
{
	var donnees = donnees_envoie();
	q --;
	envoie_req(donnees+'&q='+q);
}

function quest_suiv()
{
	var donnees = donnees_envoie();
	q ++;
	envoie_req(donnees+'&q='+q);
}

function suppr_quest()
{
	var donnees = 'qs='+q;
	if (q != 0) q--;
	envoie_req(donnees+'&q='+q);
}

