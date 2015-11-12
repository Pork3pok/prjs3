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
    $pdo = myPDO::getInstance();
    // On récupère d'abord la Personne
    $stmt = $pdo->prepare(<<<SQL
    SELECT *
    FROM PERSONNE
    WHERE idPers = :id
SQL
    );

    $stmt->execute(array(':id' => $id));

    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Enseignant');

    if(($object = $stmt->fetch()) !== false) {
      // On récupère maintenant l'Enseignant
      $stmt2 = $pdo->prepare(<<<SQL
      SELECT *
      FROM ENSEIGNANT
      WHERE idEns = :id
SQL
      );
      $stmt2->execute(array(':id' => $id));
      $stmt2->setFetchMode(PDO::FETCH_CLASS, '');
      if(($obj = $stmt2->fetch()) !== false) {
        // On ajoute les informations manquantes
        $object->idEns = $obj['idEns'];
        $object->domainePredom = $obj['domainPredom'];
        return $object;
      }
    }

  }

  /**
   * Méthode statique. Crée un enseignant dans la BD
   * @param  String  $login    : le login de connexion
   * @param  String  $sha1mdp  : le mot de passe crypté en sha1
   * @param  String  $nom      : le nom de l'enseignant
   * @param  String  $prenom   : le prénom de l'enseignant
   * @param  char    $sexe     : le sexe de l'enseignant (H/F)
   * @param  String  $telFixe  : le num de tel fixe de l'enseignant
   * @param  String  $telPort  : le num de tel port de l'enseignant
   * @param  String  $email    : l'email de l'enseignant
   * @param  String  $ville    : la ville de l'enseignant
   * @param  String  $CP       : le code postal de l'enseignant
   * @param  String  $numRue   : le numéro de la rue de l'enseignant
   * @param  String  $nomRue   : le nom de la rue
   * @param  String  $complAdr : un éventuel complément d'adresse
   * @param  String  $domaine  : le domaine de prédilection de l'enseignant
   * @return void
   */
  public static function nvEnseignant($login, $sha1mdp, $nom, $prenom, $sexe, $telFixe, $telPort, $email, $ville, $CP, $numRue, $nomRue, $complAdr, $domaine) {
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

    // Insertion dans la table "Enseignant"
    $idCree = $pdo->lastInsertId();
    $stmt2 = $pdo->prepare(<<<SQL
      INSERT INTO
      ETUDIANT(idEns, domainePredom)
      VALUES(:idEns, :domaine)
SQL
    );
    $stmt2->execute(array(
      "idEns" => $idCree,
      "domaine" => $domaine
    ));
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
