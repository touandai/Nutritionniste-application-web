<?php
$title = "Tableau de bord";

require 'include/header.php';
require 'include/header-elements.php';

require 'include/menu.php';


?>

<h1 class="text-center">Tableau de bord</h1>


<section class="container">
<em class="text-center">Inscrire un nouveau membre Admin ? <a href="?pages=inscription">Inscription</a></em>
</section>

<main class="container">

       <table border=2>
             <legend>Liste des utilisateurs</legend>
             <thead>
                <tr class="text-center">
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Statut</th>
                </tr>
             </thead>

             <tbody>

             <?php
             $req ="SELECT * FROM cabinet_diet.administrateur";
             $pdostatement = $conn -> query ($req);

             foreach ($pdostatement as $key => $value){
             ?>
                <tr class="text-center">
                    <td><b><?php echo $value['nom']; ?></b></td>
                    <td><?php echo $value['email']; ?></td>
                    <td><b><?php echo $value['statut']; ?></b></td>
                </tr>
                <?php
                }
                ?>
             </tbody>
       </table>
</main>

<?php
require 'include/footer.php';
?>