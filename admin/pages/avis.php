<?php
$title = "Avis";

require 'include/header.php';
require 'include/header-elements.php';

require 'include/menu.php';

if(array_key_exists('valider',$_POST)){

    function validationDonnees($donnees){
        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);
        return $donnees;
        }

        $id = validationDonnees($_POST['id']);
        $statut = validationDonnees($_POST['statut']);
        $date = date('Y-m-d h:m:s');

         $req = 'UPDATE cabinet_diet.avis SET statut = :statut, date_validation =:date WHERE id = :id';
         $statement = $conn -> prepare($req);
         $statement -> Bindvalue(':id',$id);
         $statement -> Bindvalue(':statut',$statut);
         $statement -> Bindvalue(':date',$date);
        
         $valider = $statement -> execute();

         if($valider){
            header('location:?pages=avis&validation=1');die;
         }else{
         header('location:?pages=avis&validation=0');die;
         }

}

?>

<h1 class="text-center">Avis</h1>

<main class="container content">
    <?php
    if(isset($_GET['validation']) && ($_GET['validation']==1)) {
    ?>
    <div style="padding: 20px;color: #ffffff;background: green;text-align:center;">
    <b>Cet avis client est bien validé ! </b></div>
    <?php
    }
    ?>
        <table class="table table-striped table-sm table-bordered">
          <caption>Moderation des avis</caption>
            <thead>
                    <tr class="text-centre table-success">
                        <th>Id</th>
                        <th>Note</th>
                        <th>Commentaires</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
            </thead>
            <tbody>
            <?php 
                $req = "SELECT * FROM  cabinet_diet.avis  ORDER BY date_avis DESC ";
                
                $tdr = $conn -> query($req);
                $resultat = $tdr -> fetchAll();

                foreach($resultat as $key => $value) {
            ?>
                <tr class="text-centre">
                    <td><?php echo $value['id'];?></td>
                    <td><?php echo $value['note'];?></td>
                    <td><?php echo $value['commentaire'];?></td>
                    <td><?php echo $value['date_avis'];?></td>
                    <td><?php echo $value['statut'];?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo $value['id'];?>" readonly=true>
                            <select name="statut">
                                <option value="">Modifier</option>
                                <option value="confirmé">confirmé</option>
                            </select>
                            <button class="btn btn-success btn-sm" type="submit" name="valider" onclick="return confirm('Confirmez-vous cette mise à jour? <?php echo $value['id']; ?> ?')">Valider</button>
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
       </table>
</main>

<?php

require 'include/footer.php';