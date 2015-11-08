<?php

require_once "inc/config.inc.php";

/**
 * Classe représentant un Etudiant
 */
class Etudiant {
  /* Attributs d'instance */
  private $login;
  private $idEtu;
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
  private $cheminCV;
  private $offresPostulees = array();
  private $stageObtenu = null;

  private function __construct() {}

  /**
  * Usine à fabriquer des Etudiant.
  * @param int $id : l'ID de l'Etudiant
  */
  public static function createFromID($id) {
    //TODO
    // Récupère les données de la table "Personne" correspondantes à l'ID passé en paramètre, et y ajoute les données spécifiques de la table "Etudiant"
  }

  /**
  * Faire postuler cet Etudiant à une offre, passée en paramètre
  * @param OffreStage $o : l'offre à laquelle postuler
  * @return void
  */
  public function candidaterOffre($o) {
    //TODO
  }

  /**
  * Faire participer cet Etudiant à un stage, passé en paramètre
  * @param  Stage $s : le stage auquel participer
  * @return void
  */
  public function participerStage($s) {
    //TODO
  }

  /**
  * Faire accepter à cet Etudiant le stage passé en paramètre
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
      FROM PERSONNE
      WHERE idPers = :id
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
