<?php
   session_start();
   //réf a login.php, si le login a été bien fait en va a la page login
   if($_SESSION["autoriser"]!="oui"){
      header("location:login.php");
      exit();
   }
   if(date("H")<18) //si lheure est plus petit que 18 cest le matin
      $bienvenue="Bonjour et bienvenue ".
      $_SESSION["prenomNom"].
      " dans votre espace personnel";
   else //siono on est le soir
      $bienvenue="Bonsoir et bienvenue ".
      $_SESSION["prenomNom"].
      " dans votre espace personnel";
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <style>
         *{
            font-family:arial;
         }
         body{
            margin:20px;
         }
         a{
            color:#EE6600;
            text-decoration:none;
         }
         a:hover{
            text-decoration:underline;
         }
      </style>
   </head>
   <body onLoad="document.fo.login.focus()"><!--on execute le formulaire fo de la page login.php-->
      <h2><?php echo $bienvenue?></h2>
      <a href="deconnexion.php">Se déconnecter</a> <!--un lien qui réference à la page deonnexion-->
   </body>
</html>