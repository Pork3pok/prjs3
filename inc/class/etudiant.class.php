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
   * Méthode statique. Crée un étudiant dans la BD
   * @param  String  $login    : le login de connexion
   * @param  String  $sha1mdp  : le mot de passe crypté en sha1
   * @param  String  $nom      : le nom de l'étudiant
   * @param  String  $prenom   : le prénom de l'étudiant
   * @param  char    $sexe     : le sexe de l'étudiant (H/F)
   * @param  String  $telFixe  : le num de tel fixe de l'étudiant
   * @param  String  $telPort  : le num de tel port de l'étudiant
   * @param  String  $email    : l'email de l'étudiant
   * @param  String  $ville    : la ville de l'étudiant
   * @param  String  $CP       : le code postal de l'étudiant
   * @param  String  $numRue   : le numéro de la rue de l'étudiant
   * @param  String  $nomRue   : le nom de la rue
   * @param  String  $complAdr : un éventuel complément d'adresse
   * @return void
   */
  public static function nvEtudiant($login, $sha1mdp, $nom, $prenom, $sexe, $telFixe, $telPort, $email, $ville, $CP, $numRue, $nomRue, $complAdr) {
    // Insertion dans la table "Personne"
    $pdo = myPDO::getInstance();
    $stmt = $pdo->prepare(<<<SQL
      INSERT INTO
      PERSONNE(login, sha1mdp, nom, prenom, sexe, telF, telP, email, ville, CP, numRue, rue, complAdr)
      VALUES(:login, :sha1mdp, :nom, :prenom, :sexe, :telF, :telP, :email, :ville, :CP, :numRue, :nomRue, :complAdr)
SQL
    );
    $stmt->execute(array(
      "login" => $login,
      "sha1mdp" => $sha1mdp,
      "nom" => $nom,
      "prenom" => $prenom,
      "sexe" => $sexe,
      "telF" => $telFixe,
      "telP" => $telPort,
      "email" => $email,
      "ville" => $ville,
      "CP" => $CP,
      "numRue" => $numRue,
      "nomRue" => $nomRue,
      "complAdr" => $complAdr
    ));

    // Insertion dans la table "Etudiant"
    $idCree = $pdo->lastInsertId();
    $stmt2 = $pdo->prepare(<<<SQL
      INSERT INTO
      ETUDIANT(idEtu)
      VALUES(:idEtu)
SQL
    );
    $stmt2->execute(array(
      "idEtu" => $idCree
    ));
  }

  /**
   * Accesseur au login
   * @return String  : login
   */
  public function getLogin() {
    return $this->login;
  }

  /**
   * Accesseur au numéro de téléphone fixe
   * @return String  : num de tel fixe
   */
  public function getTelFixe() {
    return $this->telF;
  }

  /**
   * Accesseur au numéro de téléphone portable
   * @return String  : num de tel portable
   */
  public function getTelPortable() {
    return $this->telP;
  }

  /**
   * Accesseur à l'adresse email
   * @return String  : email
   */
  public function getEmail() {
    return $this->email;
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
