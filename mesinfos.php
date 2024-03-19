<?php
$title = 'Recherche';
session_start();

if(!isset($_SESSION['info_patients'])) {
    header('location:monespace.php');
}
$userPatient = $_SESSION['info_patients'];

require 'header.php';
require_once 'connexion.php';


                       
                    
?>


<!--barre de recherche recettes script php-->
<?php
/*
        $allRecettes =  $reqSearch -> query ('SELECT * FROM cabinet_diet.recettes ORDER BY id DESC');
        if(isset($_GET['chercher']) AND empty($_GET['chercher'])){

        $recherche = htmlspecialchars($_GET['chercher']);
        $allRecettes =  $reqSearch -> query ('SELECT titre FROM cabinet_diet.recettes WHERE titre "%'.$recherche.'"% ORDER BY id DESC' );

}
*/
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


    <!--zone d'affichage resultat-->
<?php  
/*
    if($allRecettes ->rowCount() > 0 ){
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
*/
?>

</section>


<main id="recettes-sup" class="container">
    

<!--contenu principal-->

     
    <?php 
                $req = "SELECT * FROM cabinet_diet.recettes ORDER BY date_creation ASC";
                    $tdr = $conn -> query($req);

                $resultat = $tdr -> fetchAll();
                foreach($resultat as $key => $recette) {
                ?>
    <section class="container recette-patient">
            <h2><?php echo $recette['titre']; ?></h2>
            <br>
            <div>
                <ul>
                    <li>Titre:<?php  echo $recette['titre']; ?></li>
                    <li>Description: <?php  echo $recette['description']; ?></li>
                    <li>Temps de préparation : <?php  echo $recette['temps_preparation']; ?></li>
                    <li>Temps de repos: <?php  echo $recette['temps_repos']; ?></li>
                    <li>Ingrédients: <?php  echo $recette['ingredients']; ?></li>
                    <li>Etapes: <?php  echo $recette['etapes']; ?></li>
                    <li>Allergènes: <?php  echo $recette['allergene']; ?></li>
                </ul>
            </div> 
            </div>  
            <br> 
            <div>
                <img src="images/diete4.png" alt="recette2"/>
            </div>
            <div><a href="ajoutavis.php?id_recette=<?php echo $recette['id']; ?>">Laisser un avis</a></div>
            
            <?php 
                $req = "SELECT * FROM cabinet_diet.avis WHERE recette_id = :recette_id ORDER BY date_avis ASC";
                    $tdr = $conn -> prepare($req);
                    $tdr -> execute([
                        ':recette_id' => $recette['id'],
                    ]);
                $resultatAvis = $tdr -> fetchAll();
                foreach($resultatAvis as $key => $avis) {
            ?>
            <div style="border: 1px dashed #000000; padding: 5px; background: #dddddd;">
                <div>Note : <?php echo $avis['note']; ?></div>
                <div>Commentaire : <em><?php echo $avis['commentaire']; ?></em></div>
                <div>Posté le : <?php echo $avis['date_avis']; ?></div>
            </div> 
            <?php
                }
            ?>

    </section>
    <?php
    }
    ?>
        <!--laisser un avis-->

</main>


<?php
include 'footer.php';

?>
    
    