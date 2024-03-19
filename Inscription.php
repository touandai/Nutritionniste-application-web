<?php
$title = 'Inscription';
include 'header.php';

include 'connexion.php';


    if(array_key_exists('envoyer',$_POST)){
        
            if(isset($_POST['nom']) && empty($_POST['nom'])){
            header("location:?nom=1");
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
           header("location:?existe=1");
           }
			
		
            $reqInsert ='INSERT INTO cabinet_diet.patient(nom, email, mot_de_pass, date_creation) 
            values (:nom, :email, :password, :date)';
            
            $tbr = $conn -> prepare ($reqInsert);
            $tbr -> execute([
			
            ":nom" => ($_POST['nom']),
            ":email" => ($_POST['email']),
            ":password" => $_POST['password'],
            ":date" => date('Y-m-d h:m:s'),

            ]);
			header("location:succes-validation.php");


    } 
    
?>


    <main id ="inscription" class="container">

        <div class="inscription">

            <form id="form" action="" method="POST">
               
                <fieldset>

                       <legend> M'inscrire </legend>

                             <div class="mb-3">
                                <label class="form-label" for="nom">Nom* :</label>
                               <input class="form-control" type="text" name="nom">
                                <?php
                                if(isset($_GET['nom']) && ($_GET['nom']==1)){
                                echo '<strong> Veuillez saisir votre nom </strong>';
                                }
                                ?>
                             </div>

                             <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" type="email" name="email" id="email">
                                <span id="erreur"><span>
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
                               <input class="form-control" type="password" name="password">
                                <?php
                                if(isset($_GET['mot_de_pass']) && ($_GET['mot_de_pass']==1)){
                                echo '<strong> Vous devez enregistrer un mot de pass </strong>';
                                }
                                ?>
                             </div>
                             
                                 <button type="submit" name="envoyer" class="btn btn-primary">Valider</button> 
                             <br><br>
                             Déjà inscrit(e)? <a href="monespace.php">Je m'identifie</a>
                </fieldset> 

            </form>

        </div>

    </main>
   
   <script>
  
    
    let Form = document.getElementById('form')
    Form.addEventListener('submit',function(e){
    
        let Email = document.getElementById('email')
        let Erreur = document.getElementById('erreur')
        let RegexEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
    
        if (RegexEmail.test(Email.value) == true){
        Erreur.innerHTML = "adresse email valide";
        Error.style.color ="red";
        }else {
        Erreur.innerHTML = "adresse email invalide! ne respect pas le format";
        Error.style.color ="#00ff00";
        e.preventDefault();
        }

    })
   
   </script>
<?php
include 'footer.php';
?>
    
