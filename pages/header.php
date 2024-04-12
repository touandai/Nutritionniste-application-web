<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="site web Sandrine Brecy">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="../assets/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../index.css">
</head>
<body>
    <header class="container">
        <img src="../images/dieteticienne.png" alt="logo de l'entreprise"/>
    </header>

    <nav id="menu" class="navbar navbar-expand-sm">

            <ul class="navbar-nav id="navbarContent">
                <li class="menu nav-item"><a href="../index.php">Accueil</a></li>
                <li class="menu nav-item"><a href="consultation.html">Consultations/Tarifs</a>
                <li class="menu nav-item"><a href="recettes.html">Recettes de base</a></li>
                <li class="menu nav-item">
                    <?php
                        if(isset($_SESSION['info_patients'])) {
                            //Si l'utilisateur est connecté
                    ?>
                    <a href="dashboard-patients.php">Mon compte</a>
                    <?php
                    } else {
                            //Si l'utilisateur n'est pas connecté
                    ?>
                    <a href="monespace.php">Espace client</a>
                    <?php
                    }
                    ?>
                    <!--  -->
                </li>
            </ul>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="navbarContent" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
            </button>

    </nav>

    <nav id="nav2" class="container">
        <h7>Sandrine Brecy Diététicienne-Nutritionniste sur Marseille.Tel : 0622334455</h7>
    </nav>