

<nav class="nav-bar menu">
    <a href="?pages=tableau-de-bord">Tableau de bord</a>
    <?php if(in_array($_SESSION['user_data']['statut'], ['Admin'])) : ?>
    <a href="?pages=gestion-patients">Gérer les Patients</a>
    <?php endif; ?>
    <a href="?pages=gestion-recettes">Gérer les Recettes</a>
    <a href="?pages=avis">Gerer les Avis</a>
</nav>