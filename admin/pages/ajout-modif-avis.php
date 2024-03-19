<?php

$title = "Ajouter ou supprimer des avis";

require 'include/header.php';
require 'include/header-elements.php';

require 'include/menu.php';

?>

<main class="container ajout-sup">

    <div class="container ajout-avis">

        <form class="form" method="POST">
            <fieldset>
            <legend>Ajouter des Avis</legend>
            <br>
                <div>
                    <label class="form-label">Nom :</label>
                    <input class="form-control" type="text" name="nom"/>
                </div>
                <div>
                    <label class="form-label">Note :</label>
                    <input class="form-control" type="text" name="note"/>
                </div>
                <div>
                    <label class="form-label">Message :</label>
                    <textarea class="form-control" type="text" name="message"/></textarea>
                </div>
                <div>
                    <label class="form-label">Date :</label>
                    <input class="form-control" type="date" name="date"/>
                </div>
                <div>
                <div>
                <br>
                    <button class="btn btn-success" type="submit" name="ajout_patient"> Valider</button>
                </div>
            
           </fieldset>   
        </form>      
    </div> 

    <div class="container suppression">

        <form class="form" method="post">
            <fieldset>
            <legend>Supprimer des Avis</legend>
                <br>
                <div>
                    <label class="form-label">Nom :</label>
                    <input class="form-control" type="text" name="nom"/>
                </div>

                <div>
                    <label class="form-label">Note :</label>
                    <input class="form-control" type="text" name="note"/>
                </div>

                <div>
                    <label class="form-label">Message :</label>
                    <textarea class="form-control" type="text" name="message"/></textarea>
                </div>

                <div>
                    <label class="form-label">Date :</label>
                    <input class="form-control" type="date" name="date"/>
                </div>

                <div>
                <br>
                    <button class="btn btn-success" type="submit" name="ajout_patient"> Valider</button>
                </div>
            
           </fieldset>  
        </form>      
    </div>      

</main>                    


                <?php

require 'include/footer.php';

