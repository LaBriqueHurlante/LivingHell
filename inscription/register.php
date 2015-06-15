<?php 
// vérification du pseudo : FONCTION AJAX : check_pseudo ---------------------------------------
if(!empty($_POST['pseudo_check'])){ 
	$pseudo = $_POST['pseudo_check'];
	// pour chaquere caractere que l'utilisateur a entré, on vérifie si :
	// 1. c'est une lettre de l'alphabet, ou un chiffre dans le cas contraire on remplace ce caractere par un caractere vide.
	// 2. si la taille du pseudonyme est entre 3 est 16 sinon on le prévient.
	// 3. si le premer caractere du long est bien une lettre.
	$pseudo = preg_replace('#[^a-z0-9]#i', '', $pseudo); 
	if(strlen($pseudo) < 3 || strlen($pseudo) > 16){
		echo '<br/>3 à 16 caractètres SVP.';
		exit();
		// Si on trouve une erreur on sort du script sans vérifier le reste.
	}
	
	if(is_numeric($pseudo[0])){
		echo '<br/>Le pseudo doit commencer par une lettre.';
		exit();
	}
	// si les deux conditions sont passées, on se connecte à la base de donnée via le fichier connect.
	require "includes/connect_db.php";
	
	// on vérifie si dans la base de donnée un utilisateur ne possede pas déja ce pseudo.
	$q = $db->prepare('SELECT id_uti FROM utilisateur WHERE pseudo = ?');
	$q->execute(array($pseudo));
	
	// on compte dans le tableau des pseudos le nombre de fois on l'on trouve une répetition d'un pseudo.
	$numRows = $q->rowCount();
	// si on trouve que ce pseudo est déja dans la base on affiche l'erreur.
	if($numRows > 0){
		echo '<br/>Pseudo déjà utilisé !';
		exit();
	} else {
		echo 'success';
		exit();
	}
}
//Vérification des mots de passe (check_password)---------------------------------------------------
if(!empty($_POST['pass1_check']) && !empty($_POST['pass2_check'])){
// si le contenu du pass1_check ET du pass2_check n'est pas vide:
	if(strlen($_POST['pass1_check']) < 6 || strlen($_POST['pass1_check'])  < 6){
		// on test si la longeur du mot de passe est inférieur à 6 caracteres, si oui on affiche:
		echo '<br/>Trop court (6 caractères minimum)';
		exit();
	} else if($_POST['pass1_check'] == $_POST['pass2_check']){
		// si on a passé les conditions précédentes, on test si le contenu du champ 1 correspond au contenu du champ 2
		// si oui on affiche success
		echo 'success';
		exit();
	} else {
		// sinon cela veut dire que les contenus des mdp 1 et 2 sont différents.
		echo '<br/>Les deux mots de passe sont différents';
		exit();
	}


}
//Vérification de l'email (check_email)-------------------------------------------------------------
if(!empty($_POST['email_check'])){
	$email = $_POST['email_check'];
	
	//Vérifier l'adresse mail
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){  
		echo '<br/>Adresse email invalide !';
		exit();
	}
	//Connexion à la base de données
	require "includes/connect_db.php";
	
	$q = $db->prepare('SELECT id_uti FROM utilisateur WHERE email = ?');
	$q->execute(array($email));
	
	$numRows = $q->rowCount();
	if($numRows > 0){
		echo '<br/>Adresse email déjà utilisée !';
		exit();
	} else {
		echo 'success';
		exit();
	}
}
//Traitement de l'inscription ----------------------------------------------------------------------
if(isset($_POST['pseudo'])){
// si l'utilisateur à soumis un pseudo, on créé une connexion à la base de donnée.
	require "includes/connect_db.php"; 
	extract($_POST);
	// extract sert à retirer le $post pour avoir des noms de variables plus simple
	// exemple $_POST[pseudo] deviens $pseudo.
	$pseudo = preg_replace('#[^a-z0-9]#i', '', $pseudo); 
	// si le contenu de peuso n'est pas une lettre de l'alphabet ou un chiffre on le remplace par un vide.
	
	// on cherche si le pseudo existe déja dans la base de données
	$q = $db->prepare('SELECT id_uti FROM utilisateur WHERE pseudo = ?');
	$q->execute(array($pseudo));
	$pseudo_check = $q->rowCount();

	// on cherche si le mail existe déja dans la base de données
	$q = $db->prepare('SELECT id_uti FROM utilisateur WHERE email = ?');
	$q->execute(array($email));
	$email_check = $q->rowCount();
	
	// on test si les contenus des variables sont vides
	// on effectue les tests nécessaires :
	if(empty($nom) || empty($prenom) || empty($pseudo)|| empty($pass1) || empty($pass2) || empty($email)){
		echo "Tous les champs n'ont pas été remplis.";
	} else if($pseudo_check > 0) {
		echo "Pseudo déjà utilisé";
	} else if($email_check > 0) {
		echo "Cette adresse mail est déjà utilisée";
	} else if(strlen($pseudo) < 3 || strlen($pseudo) > 16) {
		echo "Pseudo éronné !";
	}  else if(is_numeric($pseudo[0])) {
		echo "Le pseudo doit commencer par une lettre.";
	}  else if($pass1 != $pass2) {
		echo "Les mots de passe ne correspondent pas.";
	} else {
		// on hache le mdp pour le rendre crypté.
		$hash_pass = sha1($pass1);

		// si tout se passe bien on insére dans la bdd les données suivantes :
		$q = $db->prepare('INSERT INTO utilisateur(pseudo, email, password, ip, created, niveau, xp)
						   VALUES(:pseudo, :email, :password, :ip, now(), 1, 1)');
		$q->execute(array(
			'pseudo' => $pseudo,
			'email' => $email,
			'password' => $hash_pass,
			'ip' => $_SERVER['REMOTE_ADDR']
		));	
		
		// on cré un dossier au nom de l'id de l'utilisateur. On vérifie si le dossier existe déja
		$user_id = $db->lastInsertId();

		if(!file_exists( "members/$utilisateur_id_uti")){
			mkdir("members/$utilisateur_id_uti", 0755);
		}
		
		$to = $email;
		$from = "Alexandre.pain78@gmail.com";
		$subject = "Test inscription - Activation de votre compte";
		$message = "<!DOCTYPE html>
					<html>
						<head>	
							<meta charset=\"UTF-8\" />
						</head>
						<body>
							Hi $pseudo,<br/><br/>

						   <h2>Complétez cette dernière étape pour activer votre compte <strong></strong>!</h2>
						   <p>Pour ce faire, il suffit de cliquez sur le lien suivant:<br/>

						   http://teachersdunet.com/activation.php?id=$user_id&amp;u=$pseudo&amp;e=$email&amp;ssl=$hash_pass<br/>
						   Si l'URL n'apparait pas comme un lien actif, veuillez SVP copier/coller ce 
						   dernier dans la barre d'adresse de votre navigateur internet.</p>

						   <h2>Indentifiants de connexion:</h2>  
						   <p>
								Adresse e-mail: $email<br/> 
								Mot de passe:       $pass1<br/>
						   </p> 
						   <p>Rendez-vous sur le site <a href=\" test \"></a></p>
						</body>
					</html>";

		$headers = "From: $from\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		if(mail($to, $subject, $message, $headers)){
			echo 'register_success';
		/*else {
			//On supprime le compte de la bdd vu qu'il ne sert plus à rien
			$q = $db->prepare("DELETE FROM users WHERE id = ?");
			$q->execute(array($user_id));
			echo "Erreur lors de l'envoi du mail.";*/
		}
		exit();
	}
	exit();
}
?>