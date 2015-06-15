<!DOCTYPE html>
<html lang="fr">
<?php require "includes/header.php"; ?>									  <!-- J'appelle mon header.php du dossier includes -->
<body>
	<div id="main_wrapper">
		<header id="top_header" style="margin-top: 40px">
			<hgroup>
				<h1><span style="color:red">Puck</span>  Sama IV </h1>
				<h2> Test inscription	 !</h2>
			</hgroup>
		</header>
		<div id="content">
		
<!-- 1] mon formulaire : -->

			<section id="inscription">
				<h1>Formulaire d'inscription !</h1>
				<form id="register_form" onsubmit="return false;">
					<!-- le return false fait que l'on appel pas de page comme en php, tout ici sera traité en background via ajax. -->
					<p>
						<label for="nom">Nom:</label>
						<input type="text" placeholder="Entrez votre nom" id="nom" name="nom" required/> 
						<!-- placeholder est un message apparaissant lorsque le champs est vide -->
						<br><br>

						<label for="prenom">Prénom:</label>
						<input type="text" placeholder="Entrez votre prénom" id="prenom" name="prenom" required/>
						<br><br>

						<label for="pseudo">Pseudo:</label>
						<input type="text" placeholder="Entrez votre pseudo" id="pseudo" name="pseudo" maxlength="16" required/>
						<small id="output_checkuser"></small>
						<br><br>
						<!-- ce output_checkuser permet de renvoyer en sortie si oui ou non ce pseudo existe déja dans la base -->

						<label for="pass1">Mot de passe:</label>
						<input type="password" id="pass1" name="pass1" required/>
						<!-- password pour ne pas qu'il s'affiche sur l'écran -->
						<small id="output_pass1"></small>
						<br><br>
						<!-- le output_pass1 permet d'afficher le résultat de la vérification du mot de passe -->

						<label for="pass2">Confirmer votre mot de passe:</label>
						<input type="password" id="pass2" name="pass2" required/> 
						<small id="output_pass2"></small>
						<br><br>

						<label for="email">Adresse électronique:</label>
						<input type="email" placeholder="johndoe@exemple.com" id="email" name="email" required/>
						<small id="output_email"></small>
						<br><br>
						<!-- ce output_checkuser permet de renvoyer en sortie si oui ou non cette adresse existe déja dans la base -->

						<div id="status">
							Remplir tous les champs
						</div>
						<br><br>
						<input type="submit" id="bRegister" class="btn btn-success" value="Inscription" />
						<!-- la class du bouton correspond à une class css bootstrap non implémenté pour le moment -->
					</p>
				</form>
			</section>

<!-- 2] Mes fonctions : -->

			<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
			<!-- J'appelle mon Jquery -->
			<script>

				$(document).ready(function(){
				// Je charge toutes les fonctions suivantes :

					$("#register_form input").focus(function(){
						// Sur les input de notre formulaire(dont l'id est register_form)
						// lorsque l'un de ces champs à le focus on fait :
						$("#status").fadeOut(800);
						// fait disparaitre le contenu du champs : status
						// par exemple : l'utilisateur entre un login incorrect, un message d'erreur apparait dans status,
						// si il corrige son erreur le champs status disparait(à une vitesse de 800ms)
					});
					
					$("#pseudo").keyup(function(){
						// quand l'utilisateur entre un caractre dans le champ pseudo on appel la fonction qui :
						// vérifie si le pseudo est ok ou n'a pas été déjà pris
							check_pseudo();
					});

					

					$("#pass1").keyup(function(){
						//On vérifie si le mot de passe est ok
							if($(this).val().length < 6)
							{
								// this.val correspond à la valeur du contenu du champs pass1
								// si cette valeur est inférieur à 6 (si le mdp comprend donc moins de 6 caracteres) on affiche :
								$("#output_pass1").css("color", "red").html("<br/>Trop court (6 caractères minimum)");
							}
							// la premiere condtion se passe bien on va vérifier si le contenu des champs mdp1 et 2 sont identiques 
								else if($("#pass2").val() != "" && $("#pass2").val() != $("#pass1").val())
								{
									// si ils ne correspondent pas ou les champs sont vides  on affiche dans les champs output_pass les messages suivants
									$("#output_pass1").html("<br/>Les deux mots de passe sont différents");
									$("#output_pass2").html("<br/>Les deux mots de passe sont différents");
								} 
									else
									{
										// si tout s'est bien passé, on affiche notre image de validation.
										$("#output_pass1").html('<img src="img/check.png" class="small_image" alt="" />');
									}
					});

					$("#pass2").keyup(function(){
							//On vérifie si les mots de passe coïncident, si oui on appele la fonction check password.
								check_password();
						});
					
					$("#email").keyup(function(){
						//On vérifie si les mots de passe coïncident
							check_email();
					});
					
					// les fonctions : ----------------------------------------------------------------------

					//fonction check pseudo
					function check_pseudo(){
						// quand l'utilisateur entre un caractre dans le champ pseudo on lance ce code
							$.ajax({
							// on ouvre une requête ajax de type POST, et on appel le fichier register.php
							// c'est dans se fichier que l'on déterminera si OUI ou NON le PSEUDO est valide.
								type: "post",
								url:  "register.php",
								data: {
									'pseudo_check' : $("#pseudo").val()
									// à chaque fois que l'utilisateur entre qqc dans le champ pseudo, on envoit le contenu de celui ci vers le serveur via register.php
								},
								// une fois que register.php a finis de traiter cette requête ajax :
								success: function(data){
								// data correspond au résultat d'un echo (n'importe lequel) du register.php (exemple: Pseudo déja utilisé)
											// si l'écho retourné correspond à un succes :
											if(data == "success"){
												// on affiche l'image check.png (image de validation) dans le champ : output_checkuser.
												$("#output_checkuser").html('<img src="img/check.png" class="small_image" alt="" />');
												return true;
											} 
												else 
												{
													//  on affiche le contenu de data en couleur rouge (le messageur d'erreur)
													$("#output_checkuser").css("color", "red").html(data);
												}
								}
							});
					}
					//fonction check pseudo 

					function check_password(){
							$.ajax({
								type: "post",
								url:  "register.php",
								data: {
									// on met dans les variables pass1 & 2_check les contenus des champs pass1 et 2
									'pass1_check' : $("#pass1").val(),
									'pass2_check' : $("#pass2").val()
								},
								success: function(data){
											if(data == "success"){
												 $("#output_pass2").html('<img src="img/check.png" class="small_image" alt="" />');
												 $("#output_pass1").html('<img src="img/check.png" class="small_image" alt="" />');
											} else {
												$("#output_pass2").css("color", "red").html(data);
											}
										 }
							});
					}
					//fonction check mail 

					function check_email(){
							$.ajax({
								type: "post",
								url:  "register.php",
								data: {
									'email_check' : $("#email").val()
								},
								success: function(data){
											if(data == "success"){
												$("#output_email").html('<img src="img/check.png" class="small_image" alt="" />');
											} else {
												$("#output_email").css("color", "red").html(data);
											}
										 }
							});
					}
					// Traitement du formulaire d'inscription :

					$("#register_form").submit(function(){
						// une fois que l'on submit (envoie) le register form, on récuperer dans des variables les contenus suivants:
						var status = $("#status");
						var nom = $("#nom").val();
						var prenom = $("#prenom").val();
						var pseudo = $("#pseudo").val();
						var pass1 = $("#pass1").val();
						var pass2 = $("#pass2").val();
						var email = $("#email").val();

						// on vérifie si les champs sont vides.
						if(nom == "" || prenom == "" || pseudo == "" || pass1 == "" || pass2 == "" || email == "" )
						{
							status.html("Veuillez remplir tous les champs").fadeIn(400);
						} 
							// si ils ne sont pas vides on test si pass 1 et pass 2 correspondent bien.
							else if(pass1 != pass2)
							{
								status.html("Les deux mots de passe sont différents").fadeIn(400);
							} 
								// sinon en envoie la requête ajax vers register.php
								else 
								{	
								$.ajax({
									type: "post",
									url:  "register.php",
									data: {
										'nom'    : nom,
										'prenom' : prenom,
										'pseudo' : pseudo,
										'pass1' : pass1,
										'pass2' : pass2,
										'email' : email,
									},
									// avant d'envoyer le formulaire on remplace la valeur du champ bregister (inscription) par traitement en cours
									beforeSend: function(){
													$("#bRegister").attr("value", "Traitement en cours...");
												},
									success: function(data){
												if(data != "register_success")
												{
													status.html(data).fadeIn(400);
													$("#bRegister").attr("value", "Inscription");
													$("#bRegister").addClass("btn-primary").css("color", "white");
												} 
												else 
													{
														$("#presentation").hide();
														$("#connexion h1").html("Connexion");
														$("#inscription").html("<strong>Juste une dernière étape " + prenom + " " + nom + " !</strong><br/>Un lien d'activation de votre compte vient de vous être envoyé à l'adresse électronique indiquée lors de l'inscription.<br/>Veuillez tout simplement cliquer ce lien et vous serez définitivement membre du <strong>TDN SOCIAL NETWORK</strong>.<br/><em>(Pensez à vérifier vos spams ou courriers indésirables, si vous ne voyez pas ce mail dans votre boîte de réception)</em><br/><br/>Une fois que ceci est fait, vous n'aurez plus qu'à vous connecter!<br/>Alors, on se dit à très bientôt ;) !").css("width", "inherit").fadeIn(400);
													}
								}
							});
						}
					});
					

			</script>			
			</div>
		</div>
	</body>
</html>