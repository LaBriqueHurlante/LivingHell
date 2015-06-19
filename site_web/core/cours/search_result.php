<?php
include_once 'includes/connexBDD.php';
if(isset($_GET['motclef'])){
    $motclef = $_GET['motclef'];
    $q = array('motclef'=>$motclef. '%');
    $sql = 'SELECT titre,contenu FROM cours WHERE titre like :motclef or contenu like :motclef';
    $req = $db->prepare($sql);
    $req->execute($q);
    $count = $req->rowCount($sql);

    if($count){
        while ($result = $req->fetch(PDO::FETCH_OBJ)){
            echo " Titre :".$result->titre."<br/>Message:".$result->contenu."<br/>";
        }
    }else{
         echo "Aucun resultat pour :".$motclef;
    }
}


?>