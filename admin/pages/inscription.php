<?php

$title = 'Inscription';
require 'include/header.php';
require 'include/header-elements.php';
require 'include/menu.php';


    if(array_key_exists('envoyer',$_POST)){
        
            if(isset($_POST['nom']) && empty($_POST['nom'])){
            header("location:?pages=inscription&nom=1");
            exit();
            }

           if(isset($_POST['email']) && empty($_POST['email'])){
           header("location:?pages=inscription&email=1");
           exit();
           }

           if(isset($_POST['password']) && empty($_POST['password'])){
           header("location:?pages=inscription&password=1");
           exit();
           }
		   
		    function validationdonnees($donnees){
			$donnees = htmlspecialchars($donnees);
			$donnees = stripslashes($donnees);
            $donnees = trim($donnees);
			return $donnees;
		   }
           $nom = validationdonnees($_POST['nom']);
           $email = validationdonnees($_POST['email']);
           $password = validationdonnees($_POST['password']);
           
           //
		   $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
 

           //verification email //

           $verifEmail = 'SELECT * FROM cabinet_diet.administrateur WHERE email = :email';
           $pdoStatement = $conn -> prepare($verifEmail);
           $pdoStatement -> bindValue(':email', $email);
           $response =  $pdoStatement -> execute ();
           
           if($response == "true"){
           header("location:?pages=inscription&mail=1");die;
           }
		           
            $reqInsert ='INSERT INTO cabinet_diet.administrateur(nom, email, mot_de_pass, date_creation)
            values (:nom, :email, :password, :date)';
            
            $tbr = $conn -> prepare ($reqInsert);
            $tbr -> execute([
			
            ":nom" => ($_POST['nom']),
            ":email" => ($_POST['email']),
            ":password" => $_POST['password'],
            ":date" => date('Y-m-d h:m:s'),

            ]);
			header("location:?pages=inscription&valider=1");die;
    }
    
?>

    <h1 class="text-center">Ajout des Membres</h1>

    <main class="container formulaire">
        <div class="style-form">
            <form id="inscription" action="" method="POST">
            <?php if(isset($_GET['valider']) && ($_GET['valider'] ==1)) {
            ?>
        <div style="padding: 20px;color: #ffffff;background: green;text-align:center;"><b>Ajouter avec succès!</b></div>
            <?php
             }
            ?>
                <fieldset>
                       <legend>Inscrire un Membre</legend>
                             <div class="mb-3">
                                <label class="form-label" for="nom">Nom* :</label>
                               <input class="form-control" type="text" name="nom" id="nom">
                                <?php
                                if(isset($_GET['nom']) && ($_GET['nom']==1)){
                                echo '<strong> Veuillez saisir votre nom </strong>';
                                }
                                ?>
                                <span id="erreurnom"></span>
                             </div>

                             <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" type="email" name="email" id="email">
                                <span id="erreuremail"><span>
                                <?php
                                if(isset($_GET['email']) && ($_GET['email']==1)){
                                echo '<strong> Veuillez saisir votre adresse email </strong>';
                                }
                                ?>
                                <?php
                                if(isset($_GET['mail']) && $_GET['mail']==1){
                                echo '<strong> Cet email existe déjà ! </strong>';
                                }
                                ?>
                             </div>

                             <div class="mb-3">
                                <label class="form-label" for="password">Mot de pass</label>
                               <input class="form-control" type="password" name="password" id="password">
                                <?php
                                if(isset($_GET['mot_de_pass']) && ($_GET['mot_de_pass']==1)){
                                echo '<strong> Vous devez enregistrer un mot de pass </strong>';
                                }
                                ?>
                             </div>
                                 <button type="submit" name="envoyer" class="btn btn-primary">Valider</button>
                             <br><br>
                </fieldset>
            </form>
        </div>

    </main>

     <!--footer-->
