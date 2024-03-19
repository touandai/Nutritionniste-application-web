<?php

$title = "Gestion Recettes";

$ajout ="";

require 'include/header.php';
require 'include/header-elements.php';

require 'include/menu.php';
?>


<h1 class="text-center">Gestion Recettes</h1>

<main class="container gestion-recette">

    <section class="container recette">

        <form class="form" action="" Method="POST" >

            <fieldset>
              <legend>Ajouter des recettes</legend>
                <div>
                    <label>Titre :</label>
                    <input class="form-control" type="text" name="nom_patient"/>
                </div>
                <div>
                    <label>Description :</label>
                    <input class="form-control" type="text" name="prenom_patient"/>
                </div>
                <div>
                    <label>Temps de preparation :</label>
                    <input class="form-control" type="text" name="email_patient"/>
                </div>
                <div>
                    <label>Temps de repos</label>
                    <input class="form-control" type="password" name="pwd_patient"/>
                </div>
                    <label>Ingrédients :</label>
                    <input class="form-control" type="text" name="nom_patient"/>
                </div>
                <div>
                    <label>Etapes :</label>
                    <input class="form-control" type="text" name="prenom_patient"/>
                </div>
                <div>
                    <label>Allergènes :</label>
                    <input class="form-control" type="text" name="email_patient"/>
                </div>
                <div>
                    <label>Type de régime :</label>
                    <input class="form-control" type="text" name="email_patient"/>
                </div>
                    <br>
                    <button class="btn btn-success" type="submit">Valider </button>
                </div>
            </fieldset>    
        </form>
    </section>
    <section class="container recette">
        <table class="table table-striped table-bordered">
            <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Temps de preparation</th>
                        <th>Temps de repos</th>
                        <th>Ingrédients</th>
                        <th>Etapes</th>
                        <th>Allergènes</th>
                        <th>Date publication</th>
                        <th>Actions</th>
                    </tr>
            </thead>
            <tbody>
            <?php 

                $req = "SELECT * FROM cabinet_diet.recettes";
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
                    <td><?php echo $value['date_creation']; ?></td>
                    <td>
                    <a href="?page=avis&action=ajouter&id=<?php echo $value['id']; ?>"><button class="btn btn-warning" type="submit">Modifier</button></a>
                    <a href="?page=avis&action=supprimer&id=<?php echo $value['id']; ?>"><button class="btn btn-danger" type="submit">Supprimer</button></a>
                    </td>
                </tr>   
            <?php
                }

            ?>
            </tbody>
        </table>
    </section>       

</main>

<?php

require 'include/footer.php';