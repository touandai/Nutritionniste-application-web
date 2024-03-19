<?php
$title = 'Avis';
session_start();

if(!isset($_SESSION['info_patients'])) {
    header('location:monespace.php');
}
$userPatient = $_SESSION['info_patients'];

require 'header.php';
require_once 'connexion.php';
//echo '<pre>';var_dump( $_SESSION['erreur']);die;

                       if(array_key_exists('valider',$_POST)){
                        //echo '<pre>';var_dump($_POST);die;
                            $erreur = []; 
                            if(empty($_POST["note"])){
                              $erreur['champ_note']="Veuillez choisir une note!";
                            }
                            if(empty($_POST['commentaire'])){
                                $erreur['champ_commentaire']="Veuillez écrire votre commentaire !";
                              }

                           if(!empty($erreur)){
                           $_SESSION['erreur']=$erreur;
                           
                           header("Location:ajoutavis.php?id_recette=".$_GET['id_recette']."&erreur=1");
                           }
                            $reqInsert = "INSERT INTO cabinet_diet.avis (note, commentaire, recette_id, date_avis, auteur_id) 
                            values (:note, :message, :recette_id, :date_avis, :auteur_id)";

                            $tbr = $conn -> prepare($reqInsert);
                            if($save = $tbr -> execute ([

                            ":note"=> (!empty($_POST['note'])) ? $_POST['note'] : 0,
                            ":message"=>$_POST['commentaire'],
                            ":recette_id"=>$_GET['id_recette'],                            
                            ":date_avis"=>date('Y-m-d h:m:s'),
                            ":auteur_id"=>$userPatient['id']
                            ])) {
                                header('location:mesinfos.php?sauvegarde_avis=1');
                            } else {
                                header('location:ajoutavis.php?id_recette='.$_GET['id_recette'] . '&sauvegarde_avis=0');
                            }
                        }
                    
                    
?>

<!--zone de recherche-->

<section class="container recherche">

    <div id="zone-recherche" class="container">

        <div class="container input-group">
            <div class="form-outline" data-mdb-input-init>
                <input type="search" id="recherche" class="form-control" name="chercher"  placeholder="recherche"/>
            </div>
                <button type="submit" class="btn btn-primary" data-mdb-ripple-init name="valider">
                    <i class="bi bi-search"></i>
                </button>
        </div>
    </div>

    <div id="zone-session" class="container">
    <?php 
        if(isset($_SESSION['info_patients'])) {
    ?>
    <div class="information-user">
        
        <span>Bonjour <?=  $userPatient['nom'] ?></span>
        
        <span class="btn-deconnexion"><a href="deconnexion.php">Me déconnecter? <img src="images/logout.png" title="Déconnexion" alt="Déconnexion"/></a></span>
    </div>
    
    <?php
        }
    ?>
    <div class="clear"></div>
    </div>    



</section>


<main id="recettes-sup" class="container">
    

<!--contenu principal-->
    <!--laisser un avis-->

    <section class="container">
        
        <div class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        
             
            <form class="form" method="POST" action="">
                                         
                <fieldset>
                    <legend>Laissez-nous votre avis</legend>
                        <br>
                        <div>
                            <label class="form-label">Note :</label>
                            <input class="form-control" type="number" min="0" max="10" name="note" placeholder="choisir une note entre 0 et 10" required/>
                        </div>
                        <div>
                            <label class="form-label">Commentaire :</label>
                            <textarea class="form-control"  name="commentaire" placeholder="votre message ici" required/></textarea>

                        </div>
                        <br>
                            <button class="btn btn-primary" name="valider" type="submit">Envoyer</button>
                        </div>
                         
                    </fieldset>
                </form> 
             </div>   
             
             <!--affichers les avis clients requette php-base de données-->

             <div class="avis btn-secondary"> Avis clients</div>  
             <?php 
                $req = "SELECT * FROM cabinet_diet.avis ORDER BY date_avis ASC LIMIT 2";
                $tdr = $conn -> query($req);

               $resultat = $tdr -> fetchAll();
               foreach($resultat as $key => $value) {
             ?>

              <!--affichage des avis clients -->
             <div class="avis-patients">
                
             <p class="post">Commentaire posté par : <?php  echo $value['auteur']; ?> <em class="post">Note : <?php echo $value['note'];  ?> </em><br> <span class="post">Message : <?php echo $value['commentaire']; ?></span>
            </div>
             <?php
             }
            ?>
    </section>  
</main>


<?php
include 'footer.php';

?>
    
    