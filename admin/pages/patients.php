<?php
$title = "Gestion des patients";

require 'include/header.php';
require 'include/header-elements.php';

require 'include/menu.php';

if(array_key_exists('ajout_patient', $_POST)) {
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
                </div>
                <div>
                    <label class="form-label">Prénom :</label>
                    <input class="form-control" type="text" name="prenom_patient"/>
                </div>
                <div>
                    <label class="form-label">Email :</label>
                    <input class="form-control" type="text" name="email_patient"/>
                </div>
                <div>
                    <label class="form-label">Mot de passe :</label>
                    <input class="form-control" type="password" name="pwd_patient"/>
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
</section>


</main>
<?php

require 'include/footer.php';