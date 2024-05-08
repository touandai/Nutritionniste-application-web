<?php
$title = "Gestion des patients";

require 'include/header.php';
require 'include/header-elements.php';

require 'include/menu.php';


if(array_key_exists('supprimer',$_POST)){
       
    $id = $_POST['id'];
    $req = 'DELETE FROM cabinet_diet.patient WHERE id = :id';
    $reqsupp = $conn -> prepare($req);
    $reqsupp -> Bindvalue(':id',$id);
    $result = $reqsupp -> execute();
    
    if ($result){
        header('location:?pages=gestion-patients&succes=1');die;
    }else{
        header('location:?pages=gestion-patients&succes=0');die;
    }
}



if(array_key_exists('ajouter', $_POST)) {

    if(isset($_POST['nom_patient']) && empty($_POST['nom_patient'])){
        header("location:?pages=gestion-patients&nom_patient=1");die;
    }
    if(isset($_POST['prenom_patient']) && empty($_POST['prenom_patient'])){
        header("location:?pages=gestion-patients&prenom_patient=1");die;
    }
    if(isset($_POST['email_patient']) && empty($_POST['email_patient'])){
        header("location:?pages=gestion-patients&email_patient=1");die;
    }
    if(isset($_POST['pwd_patient']) && empty($_POST['pwd_patient'])){
        header("location:?pages=gestion-patients&pwd_patient=1");die;
    }
    if(isset($_POST['type_regime']) && empty($_POST['type_regime'])){
        header("location:?pages=gestion-patients&type_regime=1");die;
    }
    
    function validationDonnees($donnees){

        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);
        return $donnees;
    }
            $nom = validationDonnees($_POST['nom_patient']);
            $prenom = validationDonnees($_POST['prenom_patient']);
            $email = validationDonnees($_POST['email_patient']);
            $password = validationDonnees($_POST['pwd_patient']);
            $tpeRegime = ($_POST['type_regime']);
           

    $reqInsertPatient = "INSERT INTO cabinet_diet.patient(nom, prenom, email, mot_de_pass, date_creation, statut)
    VALUES (:nom, :prenom, :email, :pwd, :date_creation, :statut)";

    $statutReqInsertion = $conn -> prepare($reqInsertPatient);
    if($statutReqInsertion -> execute([
        ':nom'      =>  $_POST['nom_patient'],
        ':prenom'   =>  $_POST['prenom_patient'],
        ':email'      =>  $_POST['email_patient'],
        ':pwd'              =>  $_POST['pwd_patient'],
        ':date_creation'    =>  date('Y-m-d h:i:s'),
        ':statut'           =>  1,
    ]))
    {
        /**
         * Enregistre les informations du type de régime du patient 
         *
         * Pour cela, on doit récupérupère l'ID du dernier patient ajouté
         * */
        /* Requête de récupération du dernier patient ajouté */
        $reqDonneesDernierPatient = "SELECT MAX(id) AS dernier_id FROM cabinet_diet.patient";
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
        header('location:?pages=gestion-patients&enregistre=1');
    } else {
        header('location:?pages=gestion-patients&enregistre=0');
    }


}
?>
<h1 class="text-center"> Gestion des patients </h1>
<br>


<main class="container content">
<?php
    if(isset($_GET['succes']) && ($_GET['succes']== 1)) {
    ?>
    <div style="padding: 20px;color: #ffffff;background: red;text-align:center;">
    <b>Le Patient a été supprimé !</b></div>
    <?php
    }
    ?>
<section class="container">

    <table class="table table-sm">
        <thead>
            <tr class="table-primary text-center">
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Date Inscription</th>
                <th>Actions</th>
            </tr>
        </thead>
<?php
$reqaffich ='SELECT * FROM cabinet_diet.patient ORDER BY id LIMIT 7';
$resultat = $conn -> prepare($reqaffich);
$resultat -> execute();
foreach($resultat as $key => $value){
?>
        <tbody>
            <tr class="text-center">
                <td><?php echo $value['id'] ?> </td>
                <td><?php echo $value['nom']?> </td>
                <td><?php echo $value['email']?> </td>
                <td><?php 
                setlocale(LC_TIME,'fr');
                $datefr = strftime('%d/%m/%Y',strtotime($value['date_creation']));
                echo $datefr ?>
                </td>
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


<section class="container ajout-patient">
   

        <form class="form" method="post">
        <?php if(isset($_GET['enregistre']) && ($_GET['enregistre'] ==1)) {
            ?>
        <div style="padding: 20px;color: #ffffff;background: green;text-align:center;"><b>Ajouter avec succès!</b></div>
            <?php
             }
            ?>
            <fieldset>
            <legend>Ajouter des Patients</legend>
                <br>
                <div>
                    <label class="form-label">Nom :</label>
                    <input class="form-control" type="text" name="nom_patient"/>
                    <?php
                    if(isset($_GET['nom_patient'])==1){
                    echo '<strong> Veuillez saisir un nom ! </strong>';
                    }
                    ?>
                </div>
                <div>
                    <label class="form-label">Prénom :</label>
                    <input class="form-control" type="text" name="prenom_patient"/>
                    <?php
                    if(isset($_GET['prenom_patient'])==1){
                    echo '<strong class="red"> Veuillez saisir un prenom ! </strong>';
                    }
                    ?>
                </div>
                <div>
                    <label class="form-label">Email :</label>
                    <input class="form-control" type="text" name="email_patient"/>
                    <?php
                    if(isset($_GET['email'])==1){
                    echo '<strong> Ce email existe déjà ! </strong>';
                    }
                    ?>
                </div>
                <div>
                    <label class="form-label">Mot de passe :</label>
                    <input class="form-control" type="password" name="pwd_patient"/>
                    <?php
                    if(isset($_GET['pwd_patient'])==1){
                    echo '<strong> Veuillez saisir un mot de pass! </strong>';
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
                    <button class="btn btn-success" type="submit" name="ajouter">Valider</button>
                </div>
            </fieldset>
        </form>
</section>

</main>
<?php

require 'include/footer.php';