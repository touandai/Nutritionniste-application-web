<?php
$title = 'Contact';
require 'header.php';
require 'connexion.php';

$erreur = "Les champs précédés d'astérix sont obligatoires";

    if(array_key_exists('envoyer',$_POST)){

            if(isset($_POST['civilite']) && empty($_POST['civilite'])){
            header("location:?civilite=1");
            exit();
            }

           if(isset($_POST['nom']) && empty($_POST['nom'])){
           header("location:?nom=1");
           exit();
           }

           if(isset($_POST['email']) && empty($_POST['email'])){
            header("location:?email=1");
            exit();
            }

           if(isset($_POST['message']) && empty($_POST['message'])){
           header("location:?message=1");
           exit();
           }

           function validationDonnees($donnees){

            $donnees = trim($donnees);
            $donnees = stripslashes($donnees);
            $donnees = htmlspecialchars($donnees);
            return $donnees;
            }
           
            $civilite = validationDonnees($_POST['civilite']);
            $nom = validationDonnees($_POST['nom']);
            $email = validationDonnees($_POST['email']);
			$message = validationDonnees($_POST['message']);
 
            $reqInsert = "INSERT INTO cabinet_diet.contact(civilite, nom, email, message, date_contact)
            values (:civilite, :nom, :email, :message, :date_contact)";
            
            $tbr = $conn -> prepare($reqInsert);
            $tbr -> execute ([

            ":civilite" => $_POST['civilite'],
            ":nom" => $_POST['nom'],
            ":email" => $_POST['email'],
            ":message" => $_POST['message'],
            ":date_contact" => date('Y-m-d h:m:s'),

            ]);
            $valider = $tbr;
            if($valider){
                header('location:succes-validation.php');
            }


    }
?>

<h1 class="text-centre"> Nous-Contactez </h1>
    <main class="container">

        <div class="formulaire">
            <form class="style-form" id="contact" method="POST" action="">
                <fieldset>
                         <legend>Champs précédés d'asterix obligatoires!</legend>

                           <div class="mb-3">
                                <label class="form-label">Civilité : *</label>
                                <select class="form-control" name="civilite" id="civilite">
                                        <option value="">-- civilite --</option>
                                        <option value="1">Monsieur</option>
                                        <option value="2">Madame</option>
                                </select>
                                <?php
                                if(isset($_GET['civilite']) && ($_GET['civilite']==1)){
                                echo '<strong> Merci d\'indiquer votre civilité </strong>';
                                }
                                ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nom : *</label>
                                <input class="form-control" type="text" name="nom" id="nom" placeholder="Dupont">
                                <?php
                                if(isset($_GET['nom']) && ($_GET['nom']==1)){
                                echo '<strong> Veuillez saisir votre nom </strong>';
                                }
                                ?>
                                <span id="erreurnom"></span>

                            <div class="mb-3">
                                <label class="form-label">E-mail: *</label>
                                <input class="form-control" type="email" name="email" id="email" placeholder="monadresse@.....">
                                <span id="erreuremail"></span>
                                <?php
                                if(isset($_GET['email']) && ($_GET['email']==1)){
                                echo '<strong> Veuillez saisir votre email </strong>';
                                }
                                ?>
                               
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Message: </label>
                                <textarea class="form-control" name="message" id="message" placeholder=" Ecrivez ici votre message..."></textarea>
                                <?php
                                if(isset($_GET['message']) && ($_GET['message']==1)){
                                echo '<strong> Veuillez saisir le message </strong>';
                                }
                                ?>
                            </div>
                            
                                <button class="btn btn-primary" name="envoyer" type="submit" id="envoyer">Envoyer</button>
                </fieldset>
            </form>
        </div>
    </main>

<?php
require 'footer.php';

?>