<?php

require_once "config.inc.php";

/**
 * Classe représentant une Entreprise
 */
class Entreprise {
  /* Attributs d'instance */
  private $id_entreprise;
  private $nom_entreprise;
  private $code_entreprise; // SIRET ?
  private $ville_entreprise;
  private $codePostal_entreprise;
  private $numRue_entreprise;
  private $rue_entreprise;
  private $complAdr_entreprise;
  private $siteWeb_entreprise;
  private $nom_contact;
  private $prenom_contact;
  private $sexe_contact;
  private $email_contact;
  private $tel_contact;

  private $offresProposees = array();
  private $stages = null;

  private function __construct() {}

  /**
  * Usine à fabriquer des Entreprise.
  * @param int $id : l'ID de l'Entreprise
  */
  public static function createFromID($id) {
    //TODO
    // Fait une requete sur la BD et renvoie une instance de Stage correspondante, grâce à PDO_FETCH_CLASS
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
      SELECT SHA1(CONCAT(SHA1(email), mdpSHA1, :token)) AS chaine
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
