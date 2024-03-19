<?php 
$title ='Espace Admin';

require 'include/header.php';
require 'include/header-elements.php';



//romaric.nganas@yahoo.fr
//Romaric10

if(array_key_exists('connexion',$_POST)){
    if(isset($_POST['email']) && empty($_POST['email'])){
        //var_dump($_POST);die;
        header("location:?email=1");
        exit();
    }
    if(isset($_POST['password']) && empty($_POST['password'])){
            header("location:?pwd=1");
         exit();
    }
     
       $reqselect = "SELECT * FROM  cabinet_diet.administrateur WHERE email = :email AND mot_de_pass = :password";
       $tbr = $conn -> prepare($reqselect);
       
       $tbr -> execute ([
         ":email"    =>$_POST['email'],
         ":password" =>$_POST['password'],
       ]);
       
       $user = $tbr ->fetch();
       if(!empty($user)){
            $_SESSION['user_data'] = $user; 
            //header("location:?connexion=success");
            header("location:?page=tableau-de-bord");
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


    <h1 class="text-center">Accès Espace Admin</h1>

     <main id="connexion" class="container">
        <section>
            <form id="connecte" class="form" method="POST" action="">  
                <fieldset>
                    <legend>Identifiez-vous, pour profiter de nos differents services.</legend> 
                    <div class="input-row">
                     <label class="form-label" for="name">Nom / Email : *</label>
                     <input class="form-control form-control-sm" type="email" name="email" id="email" placeholder="Dupont">
                     <?php
                        if(isset($_GET['email']) && ($_GET['email']==1)){
                        echo '<span><font color="red">Votre email est obligatoire</font></span>';
                        }
                      ?>
                    </div>
                    <div class="input-row">
                     <label class="form-label" for="password">Password: *</label>
                     <input  class="form-control form-control-sm" type="password" name="password" id="password" placeholder="mot de pass">
                     <?php
                        if(isset($_GET['pwd']) && ($_GET['pwd']==1)){
                        echo '<span><font color="red">Le mot de pass est obligatoire</font></span>';
                        }
                        if(isset($_GET['nouveau']) && ($_GET['nouveau']==1)){
                            echo "<span><font color='red'>Vous n'êtes pas encore inscrit </font></span>";
                            }
                      ?>                   
                    </div>
                     <br>
                     <button class="btn btn-primary" name="connexion" type="submit" id="connect">Connexion</button>
                     mot de pass oublié ? <a href="#">Réinitialisé votre mot de pass</a>
                     <p style = color:red; id="erreur">
                </fieldset>
            </form> 
        <section>      
     </main>

     <!--footer-->
     <?php include 'include/footer.php'; ?> 
          
     