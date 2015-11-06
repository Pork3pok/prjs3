<?php

require_once "config.inc.php";

/**
 * Classe représentant un Enseignant
 */
class Enseignant {
  // Attributs d'instance
  private $id;
  private $nom;
  private $prenom;
  private $sexe;
  private $telF;
  private $telP;
  private $email;
  private $ville;
  private $codePostal;
  private $numRue;
  private $rue;
  private $complAdr;
  private $stagesTutores = array();

  private function __construct() {}

  /**
  * Usine à fabriquer des Enseignant.
  * @param int $id : l'ID de l'Enseignant
  */
  public static function createFromID($id) {
    // D'abord on crée l'instance à partir des données de la BD
    $pdo = myPDO::getInstance();
    $stmt = $pdo->prepare(<<<SQL
    SELECT *
    FROM ENSEIGNANT
    WHERE id = :id
SQL
    );
    $stmt->execute(array("id" => $id));

    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Enseignant');

    if(($object = $stmt->fetch()) !== false) {
      return $object;
    }
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
    $token = $_SESSION["token"];
    $pdo = myPDO::getInstance();
    $stmt = $pdo->prepare(<<<SQL
      SELECT SHA1(CONCAT(SHA1(email), mdpSHA1, :token)) AS chaine
      FROM ENSEIGNANT
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
