<?php
$title = 'Avis';
session_start();

if(!isset($_SESSION['info_patients'])) {
    header('location:monespace.php');
}
$userPatient = $_SESSION['info_patients'];

require 'header.php';
require 'connexion.php';
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
                            $reqInsert = "INSERT INTO cabinet_diet.avis (note, commentaire, recette_id, date_avis, auteur_id, statut) 
                            values (:note, :message, :recette_id, :date_avis, :auteur_id, :statut)";

                            $tbr = $conn -> prepare($reqInsert);
                            if($save = $tbr -> execute ([

                            ":note"=> (!empty($_POST['note'])) ? $_POST['note'] : 0,
                            ":message"     =>$_POST['commentaire'],
                            ":recette_id"  =>$_GET['id_recette'],
                            ":date_avis"   =>date('Y-m-d h:m:s'),
                            ":auteur_id"   =>$userPatient['id'],
                            ":statut"   => "Attente validation",

                            ])) {
                                header('location:dashboard-patients.php?sauvegarde_avis=1');
                            } else {
                                header('location:dashboard-patients.php?id_recette='.$_GET['id_recette'] . '&sauvegarde_avis=0');
                            }
                        }
                    
?>
<!--zone de recherche-->

<section class="container recherche">
    <div id="zone-session" class="container">
    <?php 
        if(isset($_SESSION['info_patients'])) {
    ?>
    <div class="information-user">
        <span>Bonjour, <?=  $userPatient['nom'] ?></span>
        <span class="btn-deconnexion"><strong> Se déconnecter? </strong><a href="deconnexion.php"><img src="../images/logout.png" alt="Déconnexion"/></a></span>
    </div>
    
    <?php
        }
    ?>
    <div class="clear"></div>
    </div>
</section>

<main class="container">
<!--contenu principal-->
    <!--laisser un avis-->
    <section class="container">
        <div class="btn btn-secondary" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <form class="form" method="POST" action="">
                <fieldset>
                    <legend>Laissez-nous votre avis</legend>
                        <div>
                            <label class="form-label">Note :</label>
                            <input class="form-control" type="number" min="0" max="10" name="note" placeholder="choisir une note entre 0 et 10" required/>
                        </div>
                        <div>
                            <label class="form-label">Commentaire :</label>
                            <textarea class="form-control"  name="commentaire" placeholder="votre message ici" required/></textarea>
                        </div>
                        <br>
                        <div>
                            <button class="btn btn-primary" name="valider" type="submit">Envoyer</button>
                        </div>
                    </fieldset>
                </form>
             </div>
    </section>
</main>


<?php
require 'footer.php';

?>