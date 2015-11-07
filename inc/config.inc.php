<?php
/**
 * Autoload, connexion BD et divers configs
 */

error_reporting(E_ALL | E_STRICT); // Niveau d'erreur maximal pour développer
date_default_timezone_set("Europe/Paris"); // Fuseau horaire par défaut pour ne pas avoir de problème avec les fonctions sur dates


// Tentative de chargement magique du fichier contenant la classe non définie
spl_autoload_register(function ($_classe) {
    // Nom du fichier = nomdelaclasse.class.php
    $fichier = strToLower($_classe). ".class.php";
    if (file_exists($fichier)) { // le fichier est dans le même répertoire
      require_once($fichier);
	  } else if (file_exists("inc/class/$fichier")) { // le fichier est dans le répertoire inc
      require_once("inc/class/$fichier");
    }
});

// Config de la BD
require_once "class/myPDO.class.php";
myPDO::setConfiguration('mysql:host=localhost;dbname=prjs3;charset=utf8', 'root', '');
