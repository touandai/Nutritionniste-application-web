<?php
$title = "Gestion des patients";

require 'include/header.php';
require 'include/header-elements.php';

require 'include/menu.php';

$nom_patient = htmlspecialchars($_POST['nom']);
$prenom_patient = htmlspecialchars($_POST['prenom_patient']);
$email_patient = htmlspecialchars($_POST['email_patient']);
$pwd_patient = htmlspecialchars($_POST['pwd_patient']);


if(array_key_exists('ajout_patient', $_POST)) {

   if(isset($_POST['nom_patient']) && empty($_POST['nom_patient'])) {
     header("location:?nom_patient=1");
    exit();
   }

   if(isset($_POST['prenom_patient']) && empty($_POST['prenom_patient'])) {
    header("location:?prenom_patient=1");
            exit();
   }
   if(isset($_POST['email_patient']) && empty($_POST['email_patient'])) {
    header("location:?email_patient=1");
            exit();
   }
   if(isset($_POST['pwd_patient']) && empty($_POST['pwd_patient'])) {;
    header("location:?pwd_patient=1");
            exit();
   }

    $reqInsertPatient = "INSERT INTO cabinet_diet.patients (nom, prenom, email, mot_de_pass, date_creation, statut, id_auteur) 
    VALUES (:nom, :prenom, :email, :pwd, :date_creation, :statut, :auteur_id)";

    $statutReqInsertion = $conn -> prepare($reqInsertPatient);
    if($statutReqInsertion -> execute([
        ':nom'      =>  $_POST['nom_patient'],
        ':prenom'   =>  $_POST['prenom_patient'],
        ':email'      =>  $_POST['email_patient'],
        ':pwd'              =>  $_POST['pwd_patient'],
        ':date_creation'    =>  date('Y-m-d h:i:s'),
        ':statut'           =>  1,
        ':auteur_id'        =>  $userConnecte['id']
        ])) {
        /**
         * Enregistre les informations du type de régime du patient 
         * 
         * Pour cela, on doit récupérupère l'ID du dernier patient ajouté
         * */
        /* Requête de récupération du dernier patient ajouté */
        $reqDonneesDernierPatient = "SELECT MAX(id) AS dernier_id FROM cabinet_diet.patients";
        $donneesDernierPatient = $conn -> query($reqDonneesDernierPatient);

        $resultDonneesDernierPatient = $donneesDernierPatient -> fetch();

        /* Enregistres les types de régime dans la table LIEN_TYPE_REGIME_PATIENTS */
        $reqInsertLienTypePatient = "INSERT INTO cabinet_diet.lien_type_regime_patient (id_type_regime, id_patient) 
        VALUES (:id_type_regime, :id_patient)";

        $statutInsertLienTypeRegime = $conn -> prepare($reqInsertLienTypePatient);
        foreach($_POST['type_regime'] as $key => $value) {
            $statutInsertLienTypeRegime -> execute([
                ':id_type_regime' => $value,
                ':id_patient' => $resultDonneesDernierPatient['dernier_id'],
            ]);
        }
        
        /* Redirection vers la page qui doit affiche le message de succès. */
        header('location:?page=patients&enregistre=1');
    } else {
        header('location:?page=patients&enregistre=0');
    }
}

?>

<h1 class="text-center" >Gestion des patients</h1>

<main class="container content">


<section class="container ajout-patient">
        <form class="form" method="post">
            <fieldset>
            <legend>Ajouter des Patients</legend>
                <br>
                <div>
                    <label class="form-label">Nom :</label>
                    <input class="form-control" type="text" name="nom_patient"/>
                    <?php
                    if(isset($_GET['nom_patient']) && ($_GET['nom_patient']==1)){
                    echo '<strong> Veuillez saisir votre nom </strong>';
                     }
                    ?>
                </div>
                <div>
                    <label class="form-label">Prénom :</label>
                    <input class="form-control" type="text" name="prenom_patient"/>
                    <?php
                    if(isset($_GET['prenom_patient']) && ($_GET['prenom_patient']==1)){
                    echo '<strong> Veuillez saisir votre Prenom </strong>';
                     }
                    ?>
                </div>
                <div>
                    <label class="form-label">Email :</label>
                    <input class="form-control" type="text" name="email_patient"/>
                    <?php
                    if(isset($_GET['email_patient']) && ($_GET['email_patient']==1)){
                    echo '<strong> Veuillez saisir votre Email </strong>';
                     }
                    ?>
                </div>
                <div>
                    <label class="form-label">Mot de passe :</label>
                    <input class="form-control" type="password" name="pwd_patient"/>
                    <?php
                    if(isset($_GET['pwd_patient']) && ($_GET['pwd_patient']==1)){
                    echo '<strong> Veuillez saisir un mot de pass </strong>';
                     }
                    ?>
                </div>
                <div>
                    <?php
                        $req = "SELECT * FROM  cabinet_diet.type_regime";
                        $tbr = $conn -> query($req);
                        $type_regime = $tbr ->fetchAll();
                    ?>
                    <label class="form-label">Type de régime du patient</label>
                    <select class="form-select" name="type_regime[]" multiple>
                        <?php
                            foreach($type_regime as $key => $value) {
                        ?>
                        <option value="<?php echo $value['id']; ?>"><?php echo $value['libelle'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <br>
                    <button class="btn btn-success" type="submit" name="ajout_patient"> Valider</button>
                </div>
            </fieldset>
        </form>
        <section>
        <table class="table table-striped table-bordered">
          <caption>Moderation des avis</caption>
            <thead>
                    <tr>
                        <th>id</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Email</th>
                        <th>Mot de pass</th>
                        <th>Type de régime</th>
                        <th>Actions</th>
                    </tr>
            </thead>
            <tbody>
            <?php
                $req = "SELECT * FROM  cabinet_diet.patients  ORDER BY date_avis ASC ";
                
                $tdr = $conn -> query($req);
                $resultat = $tdr -> fetchAll();

                foreach($resultat as $key => $value) {
            ?>
                <tr>
                    <td><?php echo $value['id'];?></td>
                    <td><?php echo $value['nom'];?></td>
                    <td><?php echo $value['prenom'];?></td>
                    <td><?php echo $value['email'];?></td>
                    <td><?php echo $value['mot_de_pass'];?></td>
                    <td><?php echo $value['recette_id'];?></td>
                    <td>
                    <?php ?>
                    <a href="?page=avis&action=ajouter&id=<?php echo $value['id']; ?>"><button class="btn btn-success" type="submit">Valider</button></a>
                    <?php 
                    /*
                    $sup = "DELETE * FROM  cabinet_diet.avis where note=0; ORDER BY date_avis ASC ";
                    $tdr = $conn -> query($sup);
                       */                 
                    ?>
                    <a href="?page=avis&action=supprimer&id=<?php echo $value['id']; ?>"><button class="btn btn-danger"type="submit">Supprimer</button></a>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>

       </table>
        </section>
</section>
</main>
<?php

require 'include/footer.php';