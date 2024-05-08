<?php
$title = 'Tableau de bord Patient';
session_start();

if(!isset($_SESSION['info_patients'])) {
    header('location:monespace.php');
}
$userPatient = $_SESSION['info_patients'];

require 'header.php';
require 'connexion.php';
                                 
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
        <div class="container input-group center">
            <div class="form-outline" data-mdb-input-init>
                <input type="search" id="recherche" class="form-control" name="chercher"  placeholder="recherche"/>
            </div>
                <button type="submit" class="btn btn-primary" data-mdb-ripple-init name="valider">
                    <i class="bi bi-search"></i>
                </button>
        </div>
    
    <div class="container">
    <?php
        if(isset($_SESSION['info_patients'])) {
    ?>
    <div class="information-user">
        <span>Bonjour <?=  $userPatient['nom'] ?></span>
        <span class="btn-deconnexion"><a href="deconnexion.php">Me déconnecter? <img src="../images/logout.png" alt="Déconnexion"/></a></span>
    </div>
    <?php
    }
    ?>
</section>


<main id="recettesup" class="container">
    <!--contenu principal-->
    <?php
                $req = "SELECT * FROM cabinet_diet.recettes ORDER BY date_creation ASC";
                    $tdr = $conn -> query($req);

                $resultat = $tdr -> fetchAll();
                foreach($resultat as $key => $recette) {
                ?>
    <div class="row">
            <h2 class="text-centre"><em><?php echo $recette['titre']; ?></em></h2>
            <br>
            <div class="col">
                <ul>
                    <li>Titre: <em><?php  echo $recette['titre']; ?></em></li>
                    <li>Description: <strong><?php  echo $recette['description']; ?></strong></li>
                    <li>Temps de préparation : <strong class="vert"><?php  echo $recette['temps_preparation']; ?></strong></li>
                    <li>Temps de repos: <strong class="vert"><?php  echo $recette['temps_repos']; ?></strong></li>
                    <li>Ingrédients: <strong class="vert"><?php  echo $recette['ingredients']; ?></strong></li>
                    <li>Etapes: <strong class="vert"><?php  echo $recette['etapes']; ?></strong></li>
                    <li>Allergènes: <strong class="vert"> <?php  echo $recette['allergene']; ?></strong></li>
                </ul>
            </div>
            <br>
            
            <div class="col text-centre">
                <img class="rounded" src="../images/dietetic.png" alt="recette2"/>
            </div>

            <div class="col=2 text-center"><a class="ancre" href="ajoutavis.php?id_recette=<?php echo $recette['id']; ?>">Laisser un avis</a>
           
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
                    <div>Note : <em><?php echo $avis['note']; ?></em></div>
                    <div>Commentaire : <em><?php echo $avis['commentaire']; ?></em></div>
                    <div>Posté le : <em><?php echo $avis['date_avis']; ?></em></div>
                </div>
           
            <?php
            }
            ?>
            </div>

    <?php
    }
    ?>
    </div>
</main>


<?php
require 'footer.php';

?>
    
    