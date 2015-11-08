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
    $pdo = myPDO::getInstance();
    // On récupère d'abord la Personne
    $stmt = $pdo->prepare(<<<SQL
    SELECT *
    FROM PERSONNE
    WHERE idPers = :id
SQL
    );

    $stmt->execute(array(':id' => $id));

    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Etudiant');

    if(($object = $stmt->fetch()) !== false) {
      // On récupère maintenant l'Etudiant
      $stmt2 = $pdo->prepare(<<<SQL
      SELECT *
      FROM ETUDIANT
      WHERE idEtu = :id
SQL
      );
      $stmt2->execute(array(':id' => $id));
      $stmt2->setFetchMode(PDO::FETCH_CLASS, '');
      if(($obj = $stmt2->fetch()) !== false) {
        // On ajoute les informations manquantes
        $object->idEtu = $obj['idEtu'];
        $object->cheminCV = $obj['cheminCV'];
        return $object;
      }
    }
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
    $tokenSHA1 = sha1($_SESSION["token"]);
    $loginSHA1 = sha1($this->login);
    $mdpSHA1 = $this->sha1mdp;
    return sha1($loginSHA1 . $mdpSHA1 . $tokenSHA1);
  }
}
