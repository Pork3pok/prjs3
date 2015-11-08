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
    WHERE id = :id
SQL
    );
    $stmt->execute(array("id" => $id));

    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Entreprise');

    if(($object = $stmt->fetch()) !== false) {
      return $object;
    }
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
    $token = $_SESSION["token"];
    $pdo = myPDO::getInstance();
    $stmt = $pdo->prepare(<<<SQL
      SELECT SHA1(CONCAT(SHA1(login), sha1mdp, :token)) AS chaine
      FROM ENTREPRISE
      WHERE id = :id
SQL
    );
    $stmt->execute(array(
      "token" => $token,
      "id" => $this->id
    ));
    $data = $stmt->fetch();
    return ($data["chaine"]);
  }
}
