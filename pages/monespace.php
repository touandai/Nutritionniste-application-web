<?php
session_start();
$title = 'Mon Espace client';

require 'header.php';
require 'connexion.php';


if(isset($_SESSION['info_patients'])){
    header("location:dashboard-patients.php");die;
}

if(array_key_exists('connexion',$_POST)){
    
        if(isset($_POST['email']) && empty($_POST['email'])){
            $email = htmlspecialchars($_POST['email']);
          header("location:?email=1");
          exit();
        }
        if(isset($_POST['password']) && empty($_POST['password'])){
            $password = htmlspecialchars($_POST['password']);
              header("location:?pwd=1");
           exit();
        }
            
            $reqInsert = "SELECT * FROM  cabinet_diet.patient WHERE email = :email AND mot_de_pass = :password";

            $tbr = $conn -> prepare($reqInsert);
            $tbr -> execute ([
                ":email"    =>$_POST['email'],
                ":password" =>$_POST['password'],
            ]);

            $user = $tbr ->fetch();
            
            if(!empty($user)){
                echo '<pre>';
                var_dump($user);
                $_SESSION['info_patients'] = $user;
                header("location:dashboard-patients.php");
            }  else{
                header("location:?erreur=1");
            }
            $echec="ce compte n'existe pas, enregistrer-vous d'abord";

            if (empty($user)){
                $_SESSION['echec'] = $echec;
                header("location:?nouveau=1");
            }
}
?>

<h1 class="text-centre"> Espace Client </h1>

    <main class="container">
         <div class="formulaire">
               <form class="style-form" method="POST" action="">
                     <fieldset>
                              <legend>Connexion Patient</legend>

                              <div class="mb-3">

                              <label class="form-label" for="email">Identifiant/Email </label>
                              <input type="email" class="form-control" name="email" id="email">
                              <?php
                              if(isset($_GET['email']) && ($_GET['email']==1)){
                              echo '<strong> Votre email est obligatoire ! </strong>';
                              }
                              ?>
                              </div>

                              <div class="mb-3">

                              <label class="form-label" for="password">Mot de pass</label>
                              <input type="password" class="form-control" name="password" id="password">

                              <?php
                              if(isset($_GET['email']) && ($_GET['email']==1)){
                              echo '<strong> Le mot de pass est obligatoire !</strong>';
                              }
                              ?>
                              </div>
                              <?php
                              if(isset($_GET['erreur']) && ($_GET['erreur']==1)){
                              echo '<strong> Login ou mot de pass incorrect !</strong>';
                              }
                              ?>
                              <button type="submit" name="connexion" id="connexion" class="btn btn-primary">Connexion</button> 
                              <br>

                              <?php
                              if(isset($_GET['nouveau']) && ($_GET['nouveau']==1)){
                              echo '<strong> identifiants ou mot de pass incorrect !</strong>';
                              }
                              ?>
                              <br>
                              Nouveau? <a href="Inscription.php">inscrivez-vous d'abord</a>
                     </fieldset>
               </form>
         </div> 
    </main>
    
    <aside id="aside" class="container">
            <ul>
               <li><a href="politiqueconfidentialite.html">Politique de confidentialité</a></li>
               <li><a href="mentionslegales.html">Mentions Légales</a></li>
               <li><a href="contact.php">Contact</a></li>
               <hr>
            </ul>
</aside>
    <footer class="container">
        <p>Tout droit réservé copyright</p>
    </footer>
</body>
</html>