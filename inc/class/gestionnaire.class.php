<?php

require_once "inc/config.inc.php";

/**
 * Singleton permettant d'accéder à toutes les données de l'application
 */
class Gestionnaire {
  // Attributs d'instance
  private $listeEtudiants = array();
  private $listeEntreprises = array();
  public $listeEnseignants = array();
  private $listeOffres = array();
  private $listeStages = array();
  private static $instance = null;

  /**
  * Constructeur de Gestionnaire
  * Charge toutes les données depuis la BD et les stocke dans cet objet
  */
  private function __construct() {
    $pdo = myPDO::getInstance();

    // Affecte les enseignants
    $stmt = $pdo->prepare(<<<SQL
      SELECT MAX(idPers) AS maxPersonne
      FROM PERSONNE
SQL
    );
    $stmt->execute();
    $data = $stmt->fetch();
    $maxPersonne = $data["maxPersonne"];
    for ($i = 1; $i <= $maxPersonne; $i++) {
      $this->listeEnseignants[] = Enseignant::createFromID($i);
    }

    // Affecte les entreprises
    $stmt = $pdo->prepare(<<<SQL
      SELECT MAX(idEnt) AS maxEntreprise
      FROM ENTREPRISE
SQL
    );
    $stmt->execute();
    $data = $stmt->fetch();
    $maxEntreprise = $data["maxEntreprise"];
    for ($i = 1; $i <= $maxEntreprise; $i++) {
      $this->listeEntreprises[] = Entreprise::createFromID($i);
    }

    $stmt = $pdo->prepare(<<<SQL
      SELECT MAX(idPers) AS maxPersonne
      FROM PERSONNE
SQL
    );
    $stmt->execute();
    $data = $stmt->fetch();
    $maxPersonne = $data["maxPersonne"];
    for ($i = 1; $i <= $maxPersonne; $i++) {
      $this->listeEtudiants[] = Etudiant::createFromID($i);
    }

    // Affecte les offres
    $stmt = $pdo->prepare(<<<SQL
      SELECT MAX(idOffre) AS maxOffre
      FROM OFFRESTAGE
SQL
    );
    $stmt->execute();
    $data = $stmt->fetch();
    $maxOffre = $data["maxOffre"];
    for ($i = 1; $i <= $maxOffre; $i++) {
      $this->listeOffres[] = OffreStage::createFromID($i);
    }

    // Affecte les stages
    $stmt = $pdo->prepare(<<<SQL
      SELECT idEtu, idOffre, idEns
      FROM STAGE
SQL
    );
    $stmt->execute();
    while (($ligne = $stmt->fetch()) !== false) {
      $this->listeStages[] = Stage::createFromIDs($ligne["idEtu"], $ligne["idOffre"], $ligne["idEns"]);
    }
  }

  /**
   * Accesseur à l'unique instance du Singleton
   * @return Gestionnaire : singleton
   */
  public static function getInstance() {
    if (is_null(self::$instance)) {
      self::$instance = new Gestionnaire();
    }
    return self::$instance;
  }

  /**
  * Retourne la liste des offres, formatée en html
  * @return html
  */
  public function offres() {
    //TODO
  }

  /**
  * Retourne la liste des stages, formatée en html
  * @return html
  */
  public function stages() {
    //TODO
  }

  /**
  * Retourne la liste des entreprises, formatée en html
  * @return html
  */
  public function entreprises() {
    //TODO
  }

  /**
  * Retourne la liste des étudiants, formatée en html
  * @return html
  */
  public function etudiants() {
    //TODO
  }

  /**
  * Retourne la liste des enseignants, formatée en html
  * @return html : tous les enseignants
  */
  public function enseignants() {
    //TODO
  }

  /**
   * Retourne une liste (formatée en HTML) des x dernières offres
   * @param  int    $nb : le nombre d'offre à retourner
   * @return html
   */
  public function dernieresOffres($nb) {
    //TODO
    //Trier l'attribut d'instance $listeOffres par date de publication, et renvoyer les $nb derniers
  }

  /**
   * Ajoute une offre dans le gestionnaire, et dans la BD
   * @param int        $idEntreprise : l'ID de l'entreprise qui souhaite ajouter une offre
   * @param $_REQUEST $formulaire   : le contenu des données envoyées par l'entreprise dans le formulaire de création d'offre
   * @return void
   */
  public function ajouterOffre($idEntreprise, $formulaire) {
    //TODO
    // Appelle la méthode d'instance creerOffre($formulaire) sur l'entreprise correspondant à l'id passé en paramètre
  }

  /**
   * Crée un stage dans le gestionnaire, et dans la BD
   * @param int $idOffre    : l'ID de l'offre en question
   * @param int $idEtudiant : l'ID de l'étudiant accepté en stage
   * @return Stage : le stage crée
   */
  public function creerStage($idOffre, $idEtudiant) {
    //TODO
    // Cette méthode est appelée quand une entreprise a accepté une candidature d'un étudiant. A ce moment là, il faut créer le stage dans la BD, et y affecter un enseignant pour tutorer, en appelant la méthode calculTuteur
    // Ne pas oublier d'enlever 1 place à l'offre, et de la supprimer si c'était la dernière place.
  }

  /**
   * Détermine l'enseignant le plus proche de cette entreprise
   * @param  int $idEntreprise : l'ID de l'entreprise dont on souhaite un tuteur proche
   * @return void
   */
  public function calculTuteur($idEntreprise) {
    //TODO
    // Va chercher l'adresse de l'entreprise (avec les getters d'Entreprise), et compare avec l'adresse de tous les enseignants de l'attribut d'instance $listeEnseignants
    // Il faut aussi regarder le nombre de stages déjà tutorés par l'enseignant (méthode d'instance nbStagesTutores()), pour éviter de surcharger certains enseignants
  }

  /**
   * Essaye de connecter un utilisateur
   * @param  String $login         : le login de l'utilisateur
   * @param  String $chaineCryptee : la chaine cryptée envoyée par le formulaire de connexion
   * @return boolean               : true/false selon la réussite ou l'échec de la connexion
   */
  public function connexion($login, $chaineCryptee) {
    $type = $this->typeUtilisateur($login);

    switch ($type) {
      case "etudiant": // connexion d'un étudiant
        foreach ($this->listeEtudiants as $e) {
          if ($e->getCrypt() == $chaineCryptee) {
            $_SESSION["membre"] = $e;
            return true;
          }
        }
        break;

      case "entreprise": // connexion d'une entreprise
        foreach ($this->listeEntreprises as $e) {
          if ($e->getCrypt() == $chaineCryptee) {
            $_SESSION["membre"] = $e;
            return true;
          }
        }
        break;

      default: // connexion d'un enseignant
        foreach ($this->listeEnseignants as $e) {
          if ($e->getCrypt() == $chaineCryptee) {
            $_SESSION["membre"] = $e;
            return true;
          }
        }
        break;
    }

    return false;
  }

  /**
   * Détermine le type d'un utilisateur
   * @param  String $login : le login de l'utilisateur
   * @return String : le type de l'utilisateur
   */
  private function typeUtilisateur($login) {
    //TODO
    //// renvoie "etudiant", "enseignant", ou "entreprise"
  }
}
