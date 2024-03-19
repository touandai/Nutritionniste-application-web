<?php
session_start();
$title = 'Mon Espace client';

require_once 'header.php';
require_once 'connexion.php';

if($_SESSION == true){
    header("location:mesinfos.php");
}

if(array_key_exists('connexion',$_POST)){
    
        if(isset($_POST['email']) && empty($_POST['email'])){
            $email = htmlspecialchars($_POST['email']);
          //var_dump($_POST);die;
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
                $_SESSION['info_patients'] = $user; 
                //header("location:?connexion=success");
                header("location:mesinfos.php");
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
    <main id="monespace" class="container">
      
         <div class="login">
            
               <form method="POST" action="">
                     <fieldset>
                              <legend> Patients</legend>

                              <div class="mb-3">

                              <label class="form-label" for="email">Identifiant/Email </label>
                              <input type="email" class="form-control" name="email" id="email">
                              <?php
                              if(isset($_GET['email']) && ($_GET['email']==1)){
                              echo '<strong>Votre email est obligatoire !</strong>';
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
                              echo '<strong> identifiants introuvables !</strong>';
                              }
                              ?>
                              <br>
                              Nouveau? <a href="Inscription.php">inscrivez-vous d'abord</a>
                     </fieldset>
               </form>
         </div> 
    </main>
    
<?php
include 'footer.php';
?>
    
