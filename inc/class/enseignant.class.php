<?php

require_once "inc/config.inc.php";

/**
 * Classe représentant un Enseignant
 */
class Enseignant {
  // Attributs d'instance
  private $login;
  private $idEns;
  private $sha1mdp;
  private $nom;
  private $prenom;
  private $sexe;
  private $telF;
  private $telP;
  private $email;
  private $ville;
  private $CP;
  private $numRue;
  private $rue;
  private $complAdr;
  private $domainePredom;
  private $stagesTutores = array();

  private function __construct() {}

  /**
  * Usine à fabriquer des Enseignant.
  * @param int $id : l'ID de l'Enseignant
  */
  public static function createFromID($id) {
    // TODO
    // Récupère les données de la table "Personne" correspondantes à l'ID passé en paramètre, et y ajoute les données spécifiques de la table "Enseignant"
  }

  /**
  * Faire écrire une description à cet Enseignant
  * @param  Entreprise $e    : l'Entreprise à laquelle correspond la description
  * @param  String     $desc : le contenu de la description
  * @return void
  */
  public function ecrireDescription ($e, $desc) {
    //TODO
  }

  /**
  * Assigner cet Enseignant à un Stage
  * @param  Stage $s : le stage à tutorer
  * @return void
  */
  public function tutorerStage($s) {
    //TODO
  }

  /**
  * Faire accepter un tutorat à cet Enseignant
  * @param  Stage $s : le stage à accepter
  * @return void
  */
  public function accepterTutorat($s) {
    //TODO
  }

  /**
   *  Retourne le nombre de stages tutorés par cet Enseignant
   * @return int : le nombre de stages tutorés
   */
  public function nbStagesTutores() {
    return count($this->stagesTutores);
  }

  /**
   * Retourne le crypto d'authentification de cet Enseignant, à partir du token passé en paramètrue
   * @param  String $token : le jeton d'authentification courant
   * @return String        : la chaine cryptée
   */
  public function getCrypt() {
    $tokenSHA1 = sha1($_SESSION["token"]);
    $loginSHA1 = sha1($this->login);
    $mdpSHA1 = $this->sha1mdp;
    return sha1($loginSHA1 . $mdpSHA1 . $tokenSHA1);
  }
}
