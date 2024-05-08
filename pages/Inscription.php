<?php
$title = 'Inscription';
require 'header.php';
require 'connexion.php';

    if(array_key_exists('envoyer',$_POST)){
        
            if(isset($_POST['nom']) && empty($_POST['nom'])){
            header("location:?nom=1");
            exit();
            }
            if(isset($_POST['prenom']) && empty($_POST['prenom'])){
                header("location:?prenom=1");
                exit();
                }

           if(isset($_POST['email']) && empty($_POST['email'])){
           header("location:?email=1");
           exit();
           }

           if(isset($_POST['password']) && empty($_POST['password'])){
           header("location:?password=1");
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

           $verifEmail = 'SELECT * FROM cabinet_diet.patient WHERE email = :email';
           $pdoStatement = $conn -> prepare($verifEmail);
           $pdoStatement -> bindValue(':email', $email);
           $result =  $pdoStatement -> execute ();
           
           if($result == "true"){
           header("location:?existe=1");die;
           }
			
		
            $reqInsert ='INSERT INTO cabinet_diet.patient(nom, prenom, email, mot_de_pass, date_creation) 
            values (:nom, :prenom, :email, :password, :date)';
            
            $tbr = $conn -> prepare ($reqInsert);
            $tbr -> execute([
			
            ":nom" => ($_POST['nom']),
            ":prenom" => ($_POST['prenom']),
            ":email" => ($_POST['email']),
            ":password" => $_POST['password'],
            ":date" => date('Y-m-d h:m:s'),

            ]);
			header("location:succes-validation.php");
    }
    
?>

<h1 class="text-centre"> Inscriptions </h1>
    <main class="container content">
        <div class="formulaire">
            <form class="style-form" id="inscription" action="" method="POST">
                <fieldset>
                       <legend><strong class="important">Nouveau?</strong> je m'inscris!</legend>
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
                                <label class="form-label" for="nom">Prenom* :</label>
                               <input class="form-control" type="text" name="prenom" id="prenom">
                                <?php
                                if(isset($_GET['prenom']) && ($_GET['prenom']==1)){
                                echo '<strong> Veuillez saisir votre Prenom </strong>';
                                }
                                ?>
                                <span id="erreurprenom"></span>
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
                                if(isset($_GET['existe']) && $_GET['existe']==1){
                                echo '<strong> Ce email existe déjà ! </strong>';
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
                                <span id="erreurpassword"><span>
                             </div>
                                 <button type="submit" name="envoyer" class="btn btn-primary">Valider</button>
                             <br><br>
                             Déjà inscrit(e)? <a href="monespace.php">J'accede à mon compte!</a>
                </fieldset>
            </form>
        </div>
    </main>
<?php
require 'footer.php';
?>