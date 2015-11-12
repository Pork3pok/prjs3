<?php

require_once "inc/config.inc.php";

/**
 * Classe représentant une Entreprise
 */
class Entreprise {
  /* Attributs d'instance */
  private $login;
  private $sha1mdp;
  private $idEnt;
  private $nomEnt;
  private $codeEnt;
  private $villeEnt;
  private $CPEnt;
  private $numRueEnt;
  private $rueEnt;
  private $complAdrEnt;
  private $siteWebEnt;
  private $description;

  private $offresProposees = array();
  private $stages = null;

  private function __construct() {}

  /**
  * Usine à fabriquer des Entreprise.
  * @param int $id : l'ID de l'Entreprise
  */
  public static function createFromID($id) {
    $pdo = myPDO::getInstance();
    $stmt = $pdo->prepare(<<<SQL
    SELECT *
    FROM ENTREPRISE
    WHERE idEnt = :id
SQL
    );
    $stmt->execute(array("id" => $id));

    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Entreprise');

    if(($object = $stmt->fetch()) !== false) {
      return $object;
    }
  }

  /**
   * Méthode statique. Crée une Entreprise dans la BD
   * @param  String  $login       : le login de connexion
   * @param  String  $sha1mdp     : le mdp crypté en sha1
   * @param  String  $nom         : le nom de l'entreprise
   * @param  String  $code        : le code de l'entreprise
   * @param  String  $ville       : la ville de l'entreprise
   * @param  String  $codepostal  : le CP de l'entreprise
   * @param  String  $numrue      : le numéro de la rue de l'entreprise
   * @param  String  $nomrue      : le nom de la rue de l'entreprise
   * @param  String  $complAdr    : un éventuel complément d'adresse
   * @param  String  $siteWeb     : le site web de l'entreprise
   * @param  String  $description : description de l'entreprise
   * @return void
   */
  public static function nvEntreprise($login, $sha1mdp, $nom, $code, $ville, $codepostal, $numrue, $nomrue, $complAdr, $siteWeb, $description) {
  }

  /**
   * Crée une Offre dans la BD, correspondant à cette entreprise
   * @param  $_REQUEST $formulaire : les données de l'offre, entrées dans le formulaire par l'entreprise
   * @return void
   */
  public function creerOffre($formulaire) {
    OffreStage::creerOffre($formulaire, $this->id);
  }

  /**
   * Faire accepter un stage à cette entreprise
   * @param  Stage $s : le stage à accepter
   * @return void
   */
  public function accepterStage($s) {
    //TODO
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
