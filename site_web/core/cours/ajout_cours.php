<?php
session_start();
$id=(isset($_SESSION['id']))?(int) $_SESSION['id']:0;
$pseudo=(isset($_SESSION['pseudo']))?$_SESSION['pseudo']:'';
if ($id>0) 
{
    echo $_SESSION['pseudo'];
    echo '    -     ';
}
require "includes/connexBDD.php"; 
// récupération des variables du formulaire.
$titre = $_POST["titre"] ;
$genre = $_POST["genre"] ;
$tag1 = $_POST["tag1"] ;
$tag2 = $_POST["tag2"] ;
$tag3 = $_POST["tag3"] ;
$contenu = $_POST["contenu"] ;

// Partie upload / vérification de l'avatar.
$dossier = '../../css/media/img/imgAvatar/';
$fichier = basename($_FILES['avatar']['name']);
$taille_maxi = 100000;
$taille = filesize($_FILES['avatar']['tmp_name']);
$extensions = array('.png', '.gif', '.jpg', '.jpeg');
$extension = strrchr($_FILES['avatar']['name'], '.'); 
                                       //Début des vérifications de sécurité...
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
     $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
}
if($taille>$taille_maxi)
{
     $erreur = 'Le fichier est trop gros...';
}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
     //On formate le nom du fichier ici...
     $fichier = strtr($fichier, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
     if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
          echo 'Upload effectué avec succès !';
     }
     else //Sinon (la fonction renvoie FALSE).
     {
          echo 'Echec de l\'upload !';
     }
}
else
{
     echo $erreur;
}
$req = $db->prepare("INSERT INTO cours (titre, genre, tag1, tag2, tag3, contenu, photo ) 
                     VALUES( '$titre','$genre','$tag1','$tag2','$tag3','$contenu', '$fichier'  )");
$req->execute();  
$donnees = $req->fetch();

  //affichage des résultats, pour savoir si l'insertion a marchée:
  if($req)
  {
    echo("L'insertion a été correctement effectuée") ;
  }
  else
  {
    echo("L'insertion à échouée") ;
  }
?>