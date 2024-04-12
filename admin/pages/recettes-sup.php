<?php
$title = "Gestion Recettes";

require 'include/header.php';

                       if(array_key_exists('valider',$_POST)){
                        //var_dump(date('Y-m-d h:m:s'));die;
                            $erreur = []; 
                            if(empty($_POST['nom'])){
                              $erreur['champ_nom']="Votre Pseudo est obligatoire!";
                            }
                            if(empty($_POST["note"])){
                              $erreur['champ_note']="Veuillez choisir une note!";
                            }
                            if(empty($_POST['commentaire'])){
                                $erreur['champ_commentaire']="Veuillez écrire votre commentaire !";
                              }
                           if(!empty($erreur)){
                           $_SESSION['erreur']=$erreur;
                           echo '<pre>';var_dump($erreur);die;
                           header("Location:?page=recettes&erreur=1");
                           }
                            $reqInsert = "INSERT INTO cabinet_diet.avis (auteur, note, commentaire, , date_avis) 
                            values (:auteur, :note, :message, :date)";

                            $tbr = $conn -> prepare($reqInsert);
                            $save = $tbr -> execute ([

                            ":nom"=>$_POST['nom'],
                            ":note"=> (!empty($_POST['note'])) ? $_POST['note'] : 0,
                            ":message"=>$_POST['commentaire'],
                            ":date"=>date('Y-m-d h:m:s'),
                            ]);
                        }
                    
                        
                    
?>


<h1 class="text-center">Recettes patients </h1>

<!--barre de recherche recettes-->
<?php
        $reqSearch = new PDO($dsn,$username,$password);
            if($reqSearch){
            //echo "Connexion ok";
            }
        $allRecettes =  $reqSearch -> query ('SELECT * FROM cabinet_diet.recettes ORDER BY id DESC');
           if(isset($_GET['chercher']) AND empty($_GET['chercher'])){

        $recherche = htmlspecialchars($_GET['chercher']);
        $allRecettes =  $reqSearch -> query ('SELECT titre FROM cabinet_diet.recettes WHERE titre "%'.$recherche.'"% ORDER BY id DESC' );

}

?>
<!--zone de recherche-->

<div class="container input-group">
   <div class="form-outline" data-mdb-input-init>
       <input type="search" id="recherche" class="form-control" name="chercher"  placeholder="recherche"/>
  </div>
       <button type="submit" class="btn btn-primary" data-mdb-ripple-init name="valider">
       <i class="bi bi-search"></i>
       </button>
</div>
<!--zone d'affichage resultat-->
<aside class="container resultat-recherche">
    <?php  
    if($allRecettes->rowCount() > 0 ){
        while($recettes = $allRecettes->fetch()){
            ?>
            <p><?php $recettes['titre']; ?></p>
            <?php
        }
    }else{
        ?>
        <p>aucune recette ne correspond à votre recherche</p>
        <?php
    }
    ?>

</aside>



<!--contenu principal-->
<main id="recettes" class="container">


    
        <section class="container recette-patient">
            <h2>Végétarien</h2>
            <br>
            <div>
                <ul>
                    <li>Titre: <?php  ?></li>
                    <li>Description: Le Lorem Ipsum est...</li>
                    <li>Temps de préparation : 90, ..</li>
                    <li>Temps de repos: 30 miutes</li>
                    <li>Ingrédients: Le Lorem Ipsum...</li>
                    <li>Etapes: 6 </li>
                    <li>Allergènes: Le Lorem Ipsum </li>
                </ul>
            </div>  
            <br>
            <div>
                <img src="images/recette1.png" alt="recette1"/>
            </div>      
        </section>      
        <section class="container recette-patient">
            <h2>Frugivore</h2>
            <br>
            <div>
                <ul>
                    <li>Titre:<?php ?></li>
                    <li>Description: <?php ?></li>
                    <li>Temps de préparation : <?php ?></li>
                    <li>Temps de repos: <?php ?></li>
                    <li>Ingrédients: <?php ?></li>
                    <li>Etapes: <?php ?></li>
                    <li>Allergènes: <?php ?></li>
                </ul>
            </div> 
            <br>
            <div>
                <img src="images/fruit.png" alt="recette1"/>
            </div>      
        </section> 
        <section class="container recette-patient">
            <h2>Omnivore</h2>
            <br>
            <div>
                <ul>
                    <li>Titre:<?php ?></li>
                    <li>Description: <?php ?></li>
                    <li>Temps de préparation : <?php ?></li>
                    <li>Temps de repos: <?php ?></li>
                    <li>Ingrédients: <?php ?></li>
                    <li>Etapes: <?php ?></li>
                    <li>Allergènes: <?php ?></li>
                </ul>
            </div> 
            </div>  
            <br> 

            <div>
                <img src="images/recette2.png" alt="recette2"/>
            </div>  

        </section>         

        // formulaire ajout avis //

        <section class="container">
             <div class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <form class="form" method="POST" action="">              
                    <fieldset>
                        <legend>Laissez-nous votre avis</legend>
                        <br>
                        <div>
                            <label class="form-label">Pseudo/Nom :</label>
                            <input class="form-control" type="text" name="nom"/>
                            <?php
                            if(isset($_SESSION['erreur']) && isset($_SESSION['erreur']['test_champ_nom']) ){
                            echo '<strong>'.$_SESSION['erreur']['test_champ_nom'].'</strong>';
                            }
                            ?>
                        </div>
                        <div>
                            <label class="form-label">Note :</label>
                            <input class="form-control" type="number" min="0" max="10" name="note" placeholder="choisir une note entre 0 et 10"/>
                            <?php  
                            if(isset($_SESSION['erreur']) && isset($_SESSION['erreur']['test_champ_note']) ){
                            echo '<strong>'.$_SESSION['erreur']['test_champ_note'].'</strong>';
                            }
                            ?>
                        </div>
                        <div>
                            <label class="form-label">Commentaire :</label>
                            <input class="form-control" type="text" name="commentaire"/>

                            <?php
                            if(isset($_SESSION['erreur']) && isset($_SESSION['erreur']['test_champ_commentaire']) ){
                            echo '<strong>'.$_SESSION['erreur']['test_champ_commentaire'].'</strong>';
                            }
                            ?>
                        </div>
                        <br>
                            <button class="btn btn-primary" name="valider" type="submit">Envoyer</button>
                        </div>
                         
                    </fieldset>
                </form> 
             </div>   
        </section>  
    </main>


<?php
require 'include/footer.php';

?>