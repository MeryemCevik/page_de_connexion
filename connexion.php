<?php
//on se connecte à la bdd qui sappelle formulaireauthentification avec un login et mdp 'root'
// en utilise la programmation objet pour se connecter, on crer une instance PDO qui represente une connexion a la base
$pdo=new PDO("mysql:host=localhost;dbname=formulaireauthentification","root","root");  
?>