<?php
/* On démarre la session */
session_start();


require '../connexion.php';


/* Racine du projet */
$document_root = "ECF-Nutritionniste";

$page = (isset($_GET['page'])) ? $_GET['page'] : "connexion";


/* Si l'utilisateur n'est pas connecté */
if(isset($_SESSION['user_data'])) {
  
  $userConnecte = $_SESSION['user_data'];

} 



switch($page) {
  /* Tableau de bord */
  case 'tableau-de-bord':
  default:   
    require 'pages/tableau-de-bord.php';
    break;
  /* Déconnexion */
  case 'deconnexion';
    require 'pages/deconnexion.php';
    break;
  /* connexion */
  case 'connexion';
  require 'pages/connexion.php';
  break;
  /* Ajout patients*/
    case 'patients':
      require 'pages/patients.php';
       break;
  /* Avis*/
  case 'avis':
    require 'pages/avis.php';
    break;
  /* Gestion recettes supplementaires*/
  case 'gestion-recettes':
    require 'pages/gestion-recettes.php';
     break;
  /*  page recettes sup uniquement consulter par patient*/
 case 'ajout-modif-avis.php':
    require 'pages/ajout-modif-avis.php';
     break;
     
}


