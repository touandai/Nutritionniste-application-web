<?php
?>
<header>
    <div class="logo">
        <img src="images/diete3.png"/>
    </div>

    <?php 
        if(isset($_SESSION['user_data'])) {
    ?>
    <div class="information-user">
        
        <span>Bonjour <?= $userConnecte['prenom'] ?></span>
        <span class="btn-deconnexion"><a href="?page=deconnexion">Me déconnecter? <img src="/<?= $document_root  ?>/admin/images/logout.png" title="Déconnexion" alt="Déconnexion"/></a></span>
    </div>
    
    <?php
        }
    ?>
    <div class="clear"></div>
</header>