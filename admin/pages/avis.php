<?php
$title = "Avis";

require 'include/header.php';
require 'include/header-elements.php';

require 'include/menu.php';
?>


<h1 class="text-center">Avis</h1>

<main class="container content">


        <table class="table table-striped table-bordered">
          <caption>Moderation des avis</caption>
            <thead>
                    <tr>
                        <th>Id</th>
                        <th>Note</th>
                        <th>Commentaires</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
            </thead>
            <tbody>
            <?php 

                $req = "SELECT * FROM  cabinet_diet.avis  ORDER BY date_avis ASC ";
                
                $tdr = $conn -> query($req);
                $resultat = $tdr -> fetchAll();

                foreach($resultat as $key => $value) {
            ?>
                <tr>
                    <td><?php echo $value['id'];?></td>
                    <td><?php echo $value['note'];?></td>
                    <td><?php echo $value['commentaire'];?></td>
                    <td><?php echo $value['date_avis'];?></td>
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
</main>

<?php

require 'include/footer.php';