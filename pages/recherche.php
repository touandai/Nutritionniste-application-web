<?php
session_start();

$title = 'Recherche de recettes';

require 'header.php';
require 'connexion.php';

        $sqlSearch = 'SELECT * FROM cabinet_diet.recettes WHERE 1=1';

        if(isset($_GET['chercher'])  && !empty(trim($_GET['chercher']))){

            $recherche = htmlspecialchars($_GET['chercher']);
                     
            $sqlSearch .=' AND UPPER(titre) LIKE :titre ORDER BY id DESC';
            $AllRecettes = $conn -> prepare ($sqlSearch);
            $AllRecettes -> bindValue(':titre', "%".strtoupper($recherche) . "%");
            $AllRecettes -> execute();
           
        } else {
                $sqlSearch .= " ORDER BY id DESC";
                $AllRecettes = $conn-> query ($sqlSearch);
                
        }
        
       // @$valider = $_POST['valider'];//


?>
<!--zone de recherche-->
<section class="container recherche">
<div class="container input-group center">
            <form method="GET" action="recherche.php" class="d-flex">
                    <input type="search" id="recherche" class="form-control" name="chercher" placeholder="Recettes"/>
                    <button type="submit" class="btn btn-primary" data-mdb-ripple-init>
                    <i class="bi bi-search"></i>
                    </button>
            </form>
        </div>
</section>

        <section>
        
                <?php if ($AllRecettes -> rowCount() > 0){
                           while ($titre = $AllRecettes->fetch()) {
                                
                                ?>
                                 <p><?= $titre['titre'] ?></p>
                                <?php
                                 }
                                 
                        }else{
                        ?>
                        <p> Aucune recette trouvée</p>
                        <?php
                        }
                        ?>
                        
        </section>

<?php
require 'footer.php';

?>