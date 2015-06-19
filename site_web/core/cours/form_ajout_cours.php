<?php
session_start();
// stockage des données de sessions.
$lvl=(isset($_SESSION['level']))?(int) $_SESSION['level']:1;
$id=(isset($_SESSION['id']))?(int) $_SESSION['id']:0;
$pseudo=(isset($_SESSION['pseudo']))?$_SESSION['pseudo']:'';
// test optionnel (voire si je suis toujours connecté)
if ($id>0) 
{
    echo $_SESSION['pseudo'];
    echo '    -     ';
}
?>
<html>
  <body>
    <section id="inscription">
        <h1> Ajout : </h1>
        <!-- formulaire -->
        <form id="insertioncours" action="ajout_cours.php" method="POST" enctype="multipart/form-data">
          <p>
            <label for="titre">Titre :</label>
            <input type="text" placeholder="Entrez un titre" id="titre" name="titre" required/> 
            <br><br>

             <input type="hidden" name="MAX_FILE_SIZE" value="100000">
            Fichier : <input type="file" name="avatar" id="avatar">

            Genre:
            <SELECT name="genre" id="genre" size="1">
            <OPTION>Film
            <OPTION>Série
            <OPTION selected> Livre
            <OPTION>Jeu-video
            <OPTION>Comics
            </SELECT>
            <br><br>     

            <label for="tag1">Tag :</label>
            <input type="text" placeholder="Entrez tag1" id="tag1" name="tag1" maxlength="16" required/>
            <label for="tag2"></label>
            <input type="text" placeholder="Entrez tag2" id="tag2" name="tag2" maxlength="16" required/>
            <label for="tag3"></label>
            <input type="text" placeholder="Entrez tag3" id="tag3" name="tag3" maxlength="16" required/>
            <br><br>

            <label for="contenu">Contenu du cours :</label>
            <input type="text" style="width:500px; height:200px;" placeholder="Entrez votre contenu" id="contenu" name="contenu" required/> 
            <br><br>
            <br><br>

            <br><br>
            <input type="submit" value="Ajouter" />
          </p>
        </form>
    </section>
  <body>
</html>