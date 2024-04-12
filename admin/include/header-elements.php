<?php
session_start();


if(isset($_SESSION['user_data'])) {

?>
<header>
    <div class="logo">
        <img src="images/diete3.png" alt="logo"/>
    </div>
    <div class="information-user">
        <span>Bonjour <?= $_SESSION['user_data']['nom'] ?></span>
        <span class="btn-deconnexion"><a href="?pages=deconnexion">Me déconnecter?
            <img src="/<?= $document_root ?>/admin/images/logout.png" alt="Déconnexion"/></a></span>
    </div>
    <?php
    }
    ?>
    <div class="clear"></div>
</header>