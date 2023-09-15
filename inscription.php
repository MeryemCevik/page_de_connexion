<?php
//------------------------------------------------------------------------partie php-------------------------------------------------------------------------------
   session_start();
   //on récupère les champs écrit par l'utilisateurs
   @$nom=$_POST["nom"];
   @$prenom=$_POST["prenom"];
   @$login=$_POST["login"];
   @$pass=$_POST["pass"];
   @$repass=$_POST["repass"];
   @$valider=$_POST["valider"];
   $erreur="";
   //ici je gère les erreurs, si l'utilisateurs ne tape rien dans les champs j'aafiche une erreur
   if(isset($valider)){
      if(empty($nom)) $erreur="Nom laissé vide!";
      elseif(empty($prenom)) $erreur="Prénom laissé vide!";
      elseif(empty($prenom)) $erreur="Prénom laissé vide!";
      elseif(empty($login)) $erreur="Login laissé vide!";
      elseif(empty($pass)) $erreur="Mot de passe laissé vide!";
      else{ //je vérifie si le login existe ou pas
         include("connexion.php");
         //je fait la sélection($sel) la requete de cette façon pour éviter une injection
         $sel=$pdo->prepare("select id from utilisateurs where login=? limit 1");// on fait la requête preparé pour éviter une éventeuelle injectiçn
         $sel->execute(array($login));
         $tab=$sel->fetchAll(); //les met dasn un tableau
         //si elle existe on met une erreur
         if(count($tab)>0)
            $erreur="Login existe déjà!";
        //sinon on fait un isert avec les valeurs saisi
        // en encode le mdp pour plus de sécurité et encore une fois en utilise la fonction prepare() pour éviter les injections
         else{
            $ins=$pdo->prepare("insert into utilisateurs(nom,prenom,login,pass) values(?,?,?,?)");
            if($ins->execute(array($nom,$prenom,$login,md5($pass))))
               header("location:login.php");//renvoie l'entete login pour ensuite faire un login
         }   
      }
   }
?>
<!--------------------------------------------------------------------Partie html-------------------------------------------------------------------------------->
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <!-------petite partie css------------>
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
         table,
         td {
            border: 1px solid #333;
            color:lightgray;
         }

         thead,
         tfoot {
            background-color: #333;
            color: #fff;
         }

      </style>
   </head>
   <body>
      <h1>Inscription</h1>
      <div class="erreur"><?php echo $erreur ?></div>
      <form name="fo" method="post" action="">
         <input type="text" name="nom"  required="required" placeholder="Nom" value="<?php echo $nom?>" /><br />
         <input type="text" name="prenom" required="required" placeholder="Prénom" value="<?php echo $prenom?>" /><br />
         <input type="text" name="login" required="required" placeholder="Login" value="<?php echo $login?>" /><br />
         <input id="password1" type="password" name="pass" required="required" placeholder="Mot de passe" /><br />
         <input id="password2" type="password" name="repass" required="required" placeholder="Confirmer Mot de passe" /><br />
         <input id="submit" type="submit" name="valider" value="S'authentifier" />
         <table>
    <thead>
        <tr>
            <th colspan="2">Contrainte mot de passe</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td id="long">Longueur</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td  id="min">Minuscule</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td id="maj">Majuscule</td>
        </tr>
    </tbody>
    </tbody>
    <tbody>
        <tr>
            <td id="chif">Chiffre</td>
        </tr>
    </tbody>
    </tbody>
    <tbody>
        <tr>
            <td id="car">Caractère spécial</td>
        </tr>
    </tbody>
</table>
         <br>
         
      </form>
   </body>
</html>
<!------------------------------------------------- Partie js------------------------------------------------------------------------------------------>
<script>
/* Réponse au question  
La taille recommandée par l’ANSSI pour des mots de passe plus sûrs est de 82 bits minimum.
Le mot de passe doit être de 16 caractères dans un alphabet de 36 symboles

Par contre si on veut que la force soit de optimale, il faut un mot de passe de
20 caractères dans un alphabet de 90 symboles. Donc qui contient au moins une lettre minuscule, une 
lettre majuscule, un chiffre et un caractère spécial.
*/


//on récupère les valeurs des id
var password1 = document.getElementById('password1'); 
var password2 = document.getElementById('password2');
var obj2 = document.getElementById("password2");
var c1 = document.getElementById("long");
var c2 = document.getElementById("min");
var c3 = document.getElementById("maj");
var c4 = document.getElementById("chif");
var c5 = document.getElementById("car");

// ce sont les boolean des contrainte du mdp
var Vc1 = false;
var Vc2 = false;
var Vc3 = false;
var Vc4 = false;
var Vc5 = false;

//on ne peut pas écrire dans le 2 ieme champ
const p2 = document.getElementById("password2");
p2.disabled = true;

const button = document.getElementById("submit");
button.disabled = true; //désactiver le bouton

 // checkPasswordValidity est une fonction qui vérifie la validité
var checkPasswordValidity = function() {
    if (password1.value != password2.value) { //on vérifie s'ils ne sont pas égaux
        password2.setCustomValidity('Mot de passe non identiques');
        obj2.setAttribute("style", "border:3px solid #a00;");//on ajoute une contrainte css
    } else {
        password2.setCustomValidity('');
        obj2.setAttribute("style", "border:3px solid #0a0;");//on ajoute une contrainte css
        button.disabled = false; //activer le bouton
    }   
};
var texte='';
var checkPasswordValidity2 = function() {
      if (password1.value.length >= 16) { //on vérifie qu'on a 16 caractères ou plus
         password1.setAttribute("style", "background-color:#a00;");
         c1.setAttribute("style", "color:green;");
         Vc1=true;
      } else {
         //password1.setCustomValidity('Utilisez 8 caractères ou plus pour votre mot de passe.');
         c1.setAttribute("style", "color:red;");
      }
      if(/[a-z]/.test(password1.value)) { //on vérifie qu'on a un minuscule
         password1.setAttribute("style", "background-color:#a00;");
         c2.setAttribute("style", "color:green;");
         Vc2=true;
      } else {
         texte='Utilisez au moins un lettre minuscule pour votre mot de passe.';
         c2.setAttribute("style", "color:red;");
      }
      if (/[A-Z]/.test(password1.value)) { //on vérifie qu'on a un majuscule
         password1.setAttribute("style", "background-color:#a00;");
         c3.setAttribute("style", "color:green;");
         Vc3=true;
      } else {
         texte='Utilisez au moins un lettre majuscule pour votre mot de passe.';
         c3.setAttribute("style", "color:red;");
      }
      if (/[0-9]/.test(password1.value)) { //on vérifie qu'on a un chiffre
         password1.setAttribute("style", "background-color:#a00;");
         c4.setAttribute("style", "color:green;");
         Vc4=true;
      }  else {
         texte='Utilisez au moins un chiffre pour votre mot de passe.';
         c4.setAttribute("style", "color:red;");
      }
      if (/[$@!%*#&]/.test(password1.value)) { //on vérifie qu'on a un caractère spécial
         password1.setAttribute("style", "background-color:#a00;");
         c5.setAttribute("style", "color:green;");
         Vc5=true;
      } else {
         texte='Utilisez au moins un caractère spécial pour votre mot de passe.';
         c5.setAttribute("style", "color:red;");
      }
      //si tout les contraintes sont vraie, on est bon
      if (Vc1===true)
         if(Vc2===true)
            if (Vc3===true)
               if (Vc4===true)
                  if (Vc5===true){
                     password1.setAttribute("style", "background-color:green;");
                     //on peut écrire dans le 2ieme champ
                     p2.disabled = false;
                  }
                      
};

password1.addEventListener('keyup', checkPasswordValidity2, false);//quand la touche été appuyer en déclenche l'évènement
password1.addEventListener('keyup', checkPasswordValidity, false);// idem
password2.addEventListener('keyup', checkPasswordValidity, false);// idem

</script>