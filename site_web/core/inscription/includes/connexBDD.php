<?php
try
{
		$db = new PDO('mysql:host=localhost;dbname=zombieacademy_bdd', 'root', '');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>