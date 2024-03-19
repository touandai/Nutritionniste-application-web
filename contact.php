<?php
$title = 'Contact';
require_once 'header.php';
require_once 'connexion.php';

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


    } 
    
?>
    <main id="contact" class="container">

        <div class="contact">
            <form method="POST" action="">
                <fieldset>
                         <legend>Nous-contactez ?</legend>   

                           <div class="mb-3">
                                <label class="form-label">Civilité : *</label>
                                <select class="form-control" name="civilite" id="civilite">
                                        <option value="">-- civilite --</option>
                                        <option value="1">Monsieur</option>
                                        <option value="2">Madame</option>
                                </select>    
                                <?php
                                if(isset($_GET['civilite']) && ($_GET['civilite']==1)){
                                echo '<strong> Veuillez indiquer votre civilité </strong>';
                                }
                                ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nom : *</label>
                                <input class="form-control" type="text" name="nom" id="name" placeholder="Dupont">
                                <?php
                                if(isset($_GET['nom']) && ($_GET['nom']==1)){
                                echo '<strong> Veuillez saisir votre nom </strong>';
                                }
                                ?>
                            <div class="mb-3">
                                <label class="form-label">E-mail: *</label>
                                <input class="form-control" type="email" name="email" id="email" placeholder="monadresse@.....">
                                <?php
                                if(isset($_GET['email']) && ($_GET['email']==1)){
                                echo '<strong> Veuillez indiquer votre civilité </strong>';
                                }
                                ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Message: </label>
                                <textarea class="form-control" name="message" id="message"placeholder=" Ecrivez ici votre message..."></textarea>
                                <?php
                                if(isset($_GET['message']) && ($_GET['message']==1)){
                                echo '<strong> Veuillez saisir un message </strong>';
                                }
                                else{
                                    
                                }
                                ?>
                            </div>
                            
                                <button class="btn btn-primary" name="envoyer" type="submit" id="envoyer">Envoyer</button>
                </fieldset>
            </form>  
        </div>  
    </main>

<?php
include 'footer.php';

?>