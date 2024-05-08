<?php
//session_start();//
/* On démarre la session */

require 'pages/connexion.php';


/* Racine du projet */
$document_root = "Nutritionniste-application-web";
$pages = (isset($_GET['pages'])) ? $_GET['pages'] : "espaceadmin";


if(isset($_SESSION['user_data'])) {
  $userConnecte = $_SESSION['user_data'];
}
 //header('location:?pages=espaceadmin.php');//

switch($pages) {

    /* Déconnexion */
    case 'deconnexion';
    require 'pages/deconnexion.php';
    break;

  /* espace admin */
  case 'espaceadmin';
  require 'pages/espaceadmin.php';
  break;
    /* inscription */
    case 'inscription';
    require 'pages/inscription.php';
    break;
   /*tableau de bord*/
  case 'tableau-de-bord':
  default:
    require 'pages/tableau-de-bord.php';
    break;
  /* gestion patients*/
    case 'gestion-patients':
      require 'pages/gestion-patients.php';
       break;
  /* Gestion recettes supplementaires*/
  case 'gestion-recettes':
    require 'pages/gestion-recettes.php';
     break;
       /* Avis*/
  case 'avis':
    require 'pages/avis.php';
    break;
}


