<?php
//partie php
   session_start();
   @$login=$_POST["login"];
   @$pass=md5($_POST["pass"]);
   @$valider=$_POST["valider"];
   $erreur="";
   //oN gère les erreurs
   if(isset($valider)){ //si valider est défini
      include("connexion.php"); //on se connecte a la bdd
      $sel=$pdo->prepare("select * from utilisateurs where login=? and pass=? limit 1");// encore une fois on crée la requete avec prepare() pour éviter les infjetcions
      $sel->execute(array($login,$pass));//execute la requête préparé en passant un tableau de valeurs(ayant comme clé le login et comme valeur le mdp)
      $tab=$sel->fetchAll();//retourne le tableau
      if(count($tab)>0){
         $_SESSION["prenomNom"]=ucfirst(strtolower($tab[0]["prenom"]))." ".strtoupper($tab[0]["nom"]);// pour des raisons de design et facilté, on met la premier lettres du prénom en grand et le nom en majuscule
         $_SESSION["autoriser"]="oui"; //on la valeur oui
         header("location:session.php"); // puis en mete en entete la session
      }
      else // sinon erreur
         $erreur="Mauvais login ou mot de passe!";
   }
?>
<!---------------------partie html et css---------------------->
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
         input{
            border:solid 1px #2222AA;
            margin-bottom:10px;
            padding:16px;
            outline:none;
            border-radius:6px;
         }
         .erreur{
            color:#CC0000;
            margin-bottom:10px;
         }
         a{
            font-size:12pt;
            color:#EE6600;
            text-decoration:none;
            font-weight:normal;
         }
         a:hover{
            text-decoration:underline;
         }
      </style>
   </head>
   <body onLoad="document.fo.login.focus()">
      <h1>Authentification  <a href="inscription.php">Créer un compte</a></h1>
      <div class="erreur"><?php echo $erreur ?></div>
      <form name="fo" method="post" action="">
         <input type="text" name="login" placeholder="Login" required="required"/><br />
         <input type="password" name="pass" placeholder="Mot de passe" required="required"/><br />
         <input  type="submit" name="valider" value="S'authentifier" />
      </form>
   </body>
</html>
