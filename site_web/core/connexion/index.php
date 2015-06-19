<?php
session_start();
include("includes/header.php");
if ($id>0) 
{
	echo $_SESSION['pseudo'];
	echo ' : ';
	echo '<a href="deconnexion.php">Déconnexion</a>';
	echo ' - ';
	echo '<a href="../profile/profile.php"> Votre profile </a>';
	echo ' - ';

}
if ($id==0) 
{
	echo '<form method="post" action="connexion.php">
		<fieldset>
			<legend>Connexion</legend>
				<p>
					<label for="pseudo">Pseudo :</label><input name="pseudo" type="text" id="pseudo" /><br />
					<label for="password">Mot de Passe :</label><input type="password" name="password" id="password" />
				</p>
		</fieldset>

		<p><input type="submit" value="Connexion" /></p></form>
		<a href="../inscription/inscription.php">Pas encore inscrit ?</a>';
}
$titre = "Zombie Academy accueil";
?>
	<body>

		
	</body>
</html>

