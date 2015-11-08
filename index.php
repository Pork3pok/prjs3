<?php
/**
 * Exemple d'utilisation finale des classes.
 * Ici : affichage des dernières offres.
 * On passe par le singleton Gestionnaire pour accéder aux données
 * On utilise une instance de la classe Page pour gérer l'affichage
 */
require_once "inc/config.inc.php";
session_start();

$g = Gestionnaire::getInstance();
$dernieresOffres = $g->dernieresOffres(10);

$p = new Page("Accueil");
$p->appendContent($dernieresOffres."TEST"."TEST2");

echo $p->toHTML();
