<?php

$title = "Gestion Recettes";

require 'include/header.php';
require 'include/header-elements.php';

require 'include/menu.php';

if(array_key_exists('supprimer',$_POST)){
       
    $id = $_POST['id'];
    $req = 'DELETE FROM cabinet_diet.recettes WHERE id = :id';
    $reqsupp = $conn -> prepare($req);
    $reqsupp -> Bindvalue(':id',$id);
    $supp = $reqsupp -> execute();
    
    if ($supp){
        header('location:?pages=gestion-recettes&succes=1');die;
    }else{
        header('location:?pages=gestion-recettes&succes=0');die;
    }
}



if(array_key_exists('ajouter', $_POST)) {

    if(isset($_POST['titre']) && empty($_POST['titre'])){
        header("location:?pages=gestion-recettes&titre=1");die;
    }
    if(isset($_POST['description']) && empty($_POST['description'])){
        header("location:?pages=gestion-recettes&description=1");die;
    }
    if(isset($_POST['temps_prepa']) && empty($_POST['temps_prepa'])){
        header("location:?pages=gestion-recettes&temps_prepa=1");die;
    }
    if(isset($_POST['temps_repos']) && empty($_POST['temps_repos'])){
        header("location:?pages=gestion-recettes&temps_repos=1");die;
    }
    if(isset($_POST['ingredients']) && empty($_POST['ingredients'])){
        header("location:?pages=gestion-recettes&ingredients=1");die;
    }
    if(isset($_POST['etapes']) && empty($_POST['etapes'])){
        header("location:?pages=gestion-recettes&etapes=1");die;
    }
    if(isset($_POST['allergenes']) && empty($_POST['allergenes'])){
        header("location:?pages=gestion-recettes&allergenes=1");die;
    }
    
    function validationDonnees($donnees){

        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);
        return $donnees;
    }
            $titre = validationDonnees($_POST['titre']);
            $description = validationDonnees($_POST['description']);
            $temps_preparation = validationDonnees($_POST['temps_prepa']);
            $temps_repos = validationDonnees($_POST['temps_repos']);
            $ingredients = ($_POST['ingredients']);
            $etapes = validationDonnees($_POST['etapes']);
            $allergenes = validationDonnees($_POST['allergenes']);
            $auteur_id = validationDonnees($_POST['auteur_id']);

    $reqinsert = "INSERT INTO cabinet_diet.recettes (titre, description, temps_preparation, temps_repos, ingredients, etapes, allergene, auteur_id, date_creation)
    VALUES (:titre, :description, :temps_preparation, :temps_repos, :ingredients, :etapes, :allergene, :auteur_id, :date)";

    $InsertRecette = $conn -> prepare($reqinsert);
    $resultat = $InsertRecette -> execute([
        ':titre'      =>  $_POST['titre'],
        ':description'   =>  $_POST['description'],
        ':temps_preparation'      =>  $_POST['temps_prepa'],
        ':temps_repos'              =>  $_POST['temps_repos'],
        ':ingredients'      =>  $_POST['ingredients'],
        ':etapes'   =>  $_POST['etapes'],
        ':allergene'      =>  $_POST['allergenes'],
        ':auteur_id'      =>  $_POST['auteur_id'],
        ':date'   => date('Y-m-d h:i:s'),
    ]);
    if ($resultat){
    header('location:?pages=gestion-recettes&enregistre=1');die;
    } else {
   header('location:?pages=gestion-recettes&enregistre=0');die;
    }
}


?>

<h1 class="text-center">Gestion Recettes</h1>

<main class="container gestion-recette">
    <?php
    if(isset($_GET['succes']) && ($_GET['succes']==1)) {
    ?>
    <div style="padding: 20px;color: #ffffff;background: red;text-align:center;">
    <b>La recette est bien supprimée !</b></div>
    <?php
    }
    ?>
    <section class="container recette">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                    <tr class="table-success">
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Temps de preparation</th>
                        <th>Temps de repos</th>
                        <th>Ingrédients</th>
                        <th>Etapes</th>
                        <th  class="text-danger">Allergènes</th>
                        <th>Date publication</th>
                        <th>Actions</th>
                    </tr>
            </thead>
            <tbody>
            <?php
                $req = "SELECT 
                    id
                    , titre
                    , description
                    , temps_preparation
                    , temps_repos
                    , ingredients
                    , etapes
                    , allergene
                    , auteur_id
                    , date_creation
                    , to_char(date_creation, 'dd/mm/yyyy') as date_formatage
                    , to_char(date_creation, 'HH24:MI:SS') as heure_formatage
                     FROM cabinet_diet.recettes ORDER BY id LIMIT 5";
                $tdr = $conn -> query($req);
                $resultat = $tdr -> fetchAll();
                foreach($resultat as $key => $value) {
            ?>
                <tr>
                    <td><?php echo $value['titre']; ?></td>
                    <td><?php echo $value['description']; ?></td>
                    <td><?php echo $value['temps_preparation']; ?></td>
                    <td><?php echo $value['temps_repos']; ?></td>
                    <td><?php echo $value['ingredients']; ?></td>
                    <td><?php echo $value['etapes']; ?></td>
                    <td><?php echo $value['allergene']; ?></td>
                    <td><?php echo $value['date_formatage'] . ' ' . $value['heure_formatage']; ?></td>
                    <td>
                    <form method="POST" action="">
                        <input type="hidden" name="id" value="<?php echo $value['id'];?>" readonly="true">
                        <button class="btn btn-danger btn-sm" type="submit" name="supprimer"
                        onclick="return confirm('Vous confirmez cette suppression <?php echo $value['id']; ?> ?')">
                        Supprimer</button>
                    </form>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </section>

    <?php if(isset($_GET['enregistre']) && ($_GET['enregistre']==1)) {
    ?>
    <div style="padding: 20px;color: #ffffff;background: green;text-align:center;">
    <b>La recette est ajoutée avec succès !</b></div>
    <?php
    }
    ?>
    <section class="container recette">
        <form class="form" action="" Method="POST" >
            <fieldset>
              <legend>Ajouter des recettes</legend>
                <div>
                    <label>Titre :</label>
                    <input class="form-control" type="text" name="titre"/>
                    <?php
                    if(isset($_GET['titre'])==1){
                    echo '<strong> Veuillez indiquer un Titre !</strong>';
                    }
                    ?>
                </div>
                <div>
                    <label>Description :</label>
                    <input class="form-control" type="text" name="description"/>
                    <?php
                    if(isset($_GET['description'])==1){
                    echo '<strong> Merci de renseigner la description !</strong>';
                    }
                    ?>
                </div>
                <div>
                    <label>Temps de preparation :</label>
                    <input class="form-control" type="text" name="temps_prepa"/>
                    <?php
                    if(isset($_GET['temps_prepa'])==1){
                    echo '<strong> Champ obligatoire !</strong>';
                    }
                    ?>
                </div>
                <div>
                    <label>Temps de repos</label>
                    <input class="form-control" type="text" name="temps_repos"/>
                    <?php
                    if(isset($_GET['temps_repos'])==1){
                    echo '<strong> Champ obligatoire !</strong>';
                    }
                    ?>
                </div>
                    <label>Ingrédients :</label>
                    <input class="form-control" type="text" name="ingredients"/>
                    <?php
                    if(isset($_GET['ingredients'])==1){
                    echo '<strong> Champs ingrédients obligatoire !</strong>';
                    }
                    ?>
                </div>
                <div>
                    <label>Etapes :</label>
                    <input class="form-control" type="text" name="etapes"/>
                    <?php
                    if(isset($_GET['etapes'])==1){
                    echo '<strong> Veuillez indiquer les étapes! </strong>';
                    }
                    ?>
                </div>
                <div>
                    <label> Allergènes :</label>
                    <input class="form-control" type="text" name="allergenes"/>
                    <?php
                    if(isset($_GET['allergenes'])==1){
                    echo '<strong> Veuillez remplir le champ ! </strong>';
                    }
                    ?>
                </div>
                <div>
                    <input type="hidden" name="auteur_id" value="<?php echo $_SESSION['user_data']['id'];?>" readonly=true>
                </div>
                    <br>
                    <button class="btn btn-success" type="submit" name="ajouter">Valider </button>
                </div>
            </fieldset>
        </form>
    </section>
</main>

<?php

require 'include/footer.php';