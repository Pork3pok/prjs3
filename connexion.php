
<?php
require_once "inc/config.inc.php";
require_once  "gestionnaire.class.php";
session_start();
/**
 * Récupère les données d'une formulaire de connexion, les traite puis redirige vers la page d'accueil
 */

if (isset($_post['login']) && isset($_POST['challenge'])){

	if(connexion($_post['login'], $_POST['challenge'])){
		$type = gestionnaire::typeUtilisateur($_post['login']);
		echo "<script type='text/javascript'>document.location.replace('" . $type . ".php');</script>";

	}
	else{
		echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
	}
}
