<?php

require_once "inc/config.inc.php";

/**
 * Singleton permettant d'accéder à toutes les données de l'application
 */
class Gestionnaire {
  // Attributs d'instance
  private $listeEtudiants = array();
  private $listeEntreprises = array();
  private $listeEnseignants = array();
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
   * Traite un formulaire d'inscription
   * @param  $_REQUEST $formulaire : les données du formulaire d'inscription
   * @return html : le message (erreur ou réussite) correspondant à l'état de l'inscription
   */
  public function inscription($formulaire) {
    // 1ère étape : déterminer le type d'inscription (enseignant/étudiant/entreprise)
    // 2ème étape : vérifier la validité des champs selon le type d'inscription
    // 3ème étape : ajouter dans la BD
    $res = ""; // chaine de caractère retournée
    if ($formulaire != null && isset($formulaire["typeInscription"])) {
      $type = $formulaire["typeInscription"];
      if ($type == "etudiant") {
        /*
         * INSCRIPTION ETUDIANT
         */

        // Vérification de l'existence et du remplissage des champs
        if (!isset($formulaire["nom"]) || empty($formulaire["nom"])) {
          $res .= "Le champ \"nom\" est obligatoire<br>";
        }
        if (!isset($formulaire["prenom"]) || empty($formulaire["prenom"])) {
          $res .= "Le champ \"prénom\" est obligatoire<br>";
        }
        if (!isset($formulaire["login"]) || empty($formulaire["login"])) {
          $res .= "Le champ \"login\" est obligatoire<br>";
        }
        if (!isset($formulaire["mdp"]) || empty($formulaire["mdp"])) {
          $res .= "Le champ \"mot de passe\" est obligatoire<br>";
        }
        if (!isset($formulaire["sexe"]) || empty($formulaire["sexe"]) || ($formulaire["sexe"] != "h" && $formulaire["sexe"] != "f")) {
          $res .= "Le champ \"sexe\" est obligatoire<br>";
        }
        if (!isset($formulaire["tel_fixe"]) || empty($formulaire["tel_fixe"])) {
          $res .= "Le champ \"téléphone fixe\" est obligatoire<br>";
        }
        if (!isset($formulaire["tel_port"]) || empty($formulaire["tel_port"])) {
          $res .= "Le champ \"téléphone portable\" est obligatoire<br>";
        }
        if (!isset($formulaire["email"]) || empty($formulaire["email"])) {
          $res .= "Le champ \"email\" est obligatoire<br>";
        }
        if (!isset($formulaire["ville"]) || empty($formulaire["ville"])) {
          $res .= "Le champ \"ville\" est obligatoire<br>";
        }
        if (!isset($formulaire["code_postal"]) || empty($formulaire["code_postal"])) {
          $res .= "Le champ \"code postal\" est obligatoire<br>";
        }
        if (!isset($formulaire["num_rue"]) || empty($formulaire["num_rue"])) {
          $res .= "Le champ \"numéro de la rue\" est obligatoire<br>";
        }
        if (!isset($formulaire["nom_rue"]) || empty($formulaire["nom_rue"])) {
          $res .= "Le champ \"nom de la rue\" est obligatoire<br>";
        }

        // Valeurs par défaut des champs facultatifs
        if (!isset($formulaire["compl_adr"])) {
          $complAdr = "";
        } else {
          $complAdr = $formulaire["compl_adr"];
        }

        // Vérifications de la validité des champs remplis
        if (!preg_match("/^[0-9]{5,5}$/", $formulaire["code_postal"])) {
          $res .= "Le code postal entré n'est pas valide<br>";
        }
        if (!filter_var($formulaire["email"], FILTER_VALIDATE_EMAIL)) {
          $res .= "L'adresse e-mail entrée n'est pas valide<br>";
        }
        if (!preg_match("/^[0-9]{10,10}$/", $formulaire["tel_fixe"])) {
          $res .= "Le numéro de téléphone fixe entré n'est pas valide<br>";
        }
        if (!preg_match("/^[0-9]{10,10}$/", $formulaire["tel_port"])) {
          $res .= "Le numéro de téléphone portable entré n'est pas valide<br>";
        }

        // Si $res est toujours vide (aucune erreur), on ajoute dans la BD!
        if ($res == "") {
          Etudiant::nvEtudiant(
            htmlspecialchars($formulaire["login"]),
            sha1($formulaire["mdp"]),
            htmlspecialchars($formulaire["nom"]),
            htmlspecialchars($formulaire["prenom"]),
            $formulaire["sexe"],
            $formulaire["tel_fixe"],
            $formulaire["tel_port"],
            $formulaire["email"],
            htmlspecialchars($formulaire["ville"]),
            $formulaire["code_postal"],
            htmlspecialchars($formulaire["num_rue"]),
            htmlspecialchars($formulaire["nom_rue"]),
            $complAdr);
        }
      } else if ($type == "entreprise") {
        /*
         * INSCRIPTION ENTREPRISE
         */

        // Vérification de l'existence et du remplissage des champs
        if (!isset($formulaire["nom"]) || empty($formulaire["nom"])) {
          $res .= "Le champ \"nom\" est obligatoire<br>";
        }
        if (!isset($formulaire["code"]) || empty($formulaire["code"])) {
          $res .= "Le champ \"code\" est obligatoire<br>";
        }
        if (!isset($formulaire["login"]) || empty($formulaire["login"])) {
          $res .= "Le champ \"login\" est obligatoire<br>";
        }
        if (!isset($formulaire["mdp"]) || empty($formulaire["mdp"])) {
          $res .= "Le champ \"mot de passe\" est obligatoire<br>";
        }
        if (!isset($formulaire["email"]) || empty($formulaire["email"])) {
          $res .= "Le champ \"email\" est obligatoire<br>";
        }
        if (!isset($formulaire["ville"]) || empty($formulaire["ville"])) {
          $res .= "Le champ \"ville\" est obligatoire<br>";
        }
        if (!isset($formulaire["code_postal"]) || empty($formulaire["code_postal"])) {
          $res .= "Le champ \"code postal\" est obligatoire<br>";
        }
        if (!isset($formulaire["num_rue"]) || empty($formulaire["num_rue"])) {
          $res .= "Le champ \"numéro de la rue\" est obligatoire<br>";
        }
        if (!isset($formulaire["nom_rue"]) || empty($formulaire["nom_rue"])) {
          $res .= "Le champ \"nom de la rue\" est obligatoire<br>";
        }
        if (!isset($formulaire["description"]) || empty($formulaire["description"])) {
          $res .= "Le champ \"description\" est obligatoire<br>";
        }

        // Valeurs par défaut des champs facultatifs
        if (!isset($formulaire["compl_adr"])) {
          $complAdr = "";
        } else {
          $complAdr = $formulaire["compl_adr"];
        }
        if (!isset($formulaire["site_web"])) {
          $siteWeb = "";
        } else {
          $siteWeb = $formulaire["site_web"];
        }

        // Vérifications de la validité des champs remplis
        if (!preg_match("/^[0-9]{5,5}$/", $formulaire["code_postal"])) {
          $res .= "Le code postal entré n'est pas valide<br>";
        }
        if (!filter_var($formulaire["email"], FILTER_VALIDATE_EMAIL)) {
          $res .= "L'adresse e-mail entrée n'est pas valide<br>";
        }
        if (!preg_match("/^[0-9]{10,10}$/", $formulaire["tel_fixe"])) {
          $res .= "Le numéro de téléphone fixe entré n'est pas valide<br>";
        }
        if (!preg_match("/^[0-9]{10,10}$/", $formulaire["tel_port"])) {
          $res .= "Le numéro de téléphone portable entré n'est pas valide<br>";
        }

        // Si $res est toujours vide (aucune erreur), on ajoute dans la BD!
        if ($res == "") {
          Entreprise::nvEntreprise(
            htmlspecialchars($formulaire["login"]),
            sha1($formulaire["mdp"]),
            htmlspecialchars($formulaire["nom"]),
            htmlspecialchars($formulaire["code"]),
            htmlspecialchars($formulaire["ville"]),
            $formulaire["code_postal"],
            htmlspecialchars($formulaire["num_rue"]),
            htmlspecialchars($formulaire["nom_rue"]),
            $complAdr,
            $siteWeb,
            htmlspecialchars($formulaire["description"]));
        }
      } else if ($type == "enseignant") {
        /*
         * INSCRIPTION ENSEIGNANT
         */

        // Vérification de l'existence et du remplissage des champs
        if (!isset($formulaire["nom"]) || empty($formulaire["nom"])) {
          $res .= "Le champ \"nom\" est obligatoire<br>";
        }
        if (!isset($formulaire["prenom"]) || empty($formulaire["prenom"])) {
          $res .= "Le champ \"prénom\" est obligatoire<br>";
        }
        if (!isset($formulaire["login"]) || empty($formulaire["login"])) {
          $res .= "Le champ \"login\" est obligatoire<br>";
        }
        if (!isset($formulaire["mdp"]) || empty($formulaire["mdp"])) {
          $res .= "Le champ \"mot de passe\" est obligatoire<br>";
        }
        if (!isset($formulaire["sexe"]) || empty($formulaire["sexe"]) || ($formulaire["sexe"] != "h" && $formulaire["sexe"] != "f")) {
          $res .= "Le champ \"sexe\" est obligatoire<br>";
        }
        if (!isset($formulaire["tel_fixe"]) || empty($formulaire["tel_fixe"])) {
          $res .= "Le champ \"téléphone fixe\" est obligatoire<br>";
        }
        if (!isset($formulaire["tel_port"]) || empty($formulaire["tel_port"])) {
          $res .= "Le champ \"téléphone portable\" est obligatoire<br>";
        }
        if (!isset($formulaire["email"]) || empty($formulaire["email"])) {
          $res .= "Le champ \"email\" est obligatoire<br>";
        }
        if (!isset($formulaire["ville"]) || empty($formulaire["ville"])) {
          $res .= "Le champ \"ville\" est obligatoire<br>";
        }
        if (!isset($formulaire["code_postal"]) || empty($formulaire["code_postal"])) {
          $res .= "Le champ \"code postal\" est obligatoire<br>";
        }
        if (!isset($formulaire["num_rue"]) || empty($formulaire["num_rue"])) {
          $res .= "Le champ \"numéro de la rue\" est obligatoire<br>";
        }
        if (!isset($formulaire["nom_rue"]) || empty($formulaire["nom_rue"])) {
          $res .= "Le champ \"nom de la rue\" est obligatoire<br>";
        }

        // Valeurs par défaut des champs facultatifs
        if (!isset($formulaire["compl_adr"])) {
          $complAdr = "";
        } else {
          $complAdr = $formulaire["compl_adr"];
        }
        if (!isset($formulaire["domaine"])) {
          $domaine = "";
        } else {
          $domaine = $formulaire["domaine"];
        }

        // Vérifications de la validité des champs remplis
        if (!preg_match("/^[0-9]{5,5}$/", $formulaire["code_postal"])) {
          $res .= "Le code postal entré n'est pas valide<br>";
        }
        if (!filter_var($formulaire["email"], FILTER_VALIDATE_EMAIL)) {
          $res .= "L'adresse e-mail entrée n'est pas valide<br>";
        }
        if (!preg_match("/^[0-9]{10,10}$/", $formulaire["tel_fixe"])) {
          $res .= "Le numéro de téléphone fixe entré n'est pas valide<br>";
        }
        if (!preg_match("/^[0-9]{10,10}$/", $formulaire["tel_port"])) {
          $res .= "Le numéro de téléphone portable entré n'est pas valide<br>";
        }

        // Si $res est toujours vide (aucune erreur), on ajoute dans la BD!
        if ($res == "") {
          Enseignant::nvEnseignant(
            htmlspecialchars($formulaire["login"]),
            sha1($formulaire["mdp"]),
            htmlspecialchars($formulaire["nom"]),
            htmlspecialchars($formulaire["prenom"]),
            $formulaire["sexe"],
            $formulaire["tel_fixe"],
            $formulaire["tel_port"],
            $formulaire["email"],
            htmlspecialchars($formulaire["ville"]),
            $formulaire["code_postal"],
            htmlspecialchars($formulaire["num_rue"]),
            htmlspecialchars($formulaire["nom_rue"]),
            $complAdr,
            $domaine);
        }
      } else {
        $res = "Erreur dans le formulaire d'inscription";
      }
    } else {
      $res = "Erreur dans le formulaire d'inscription";
    }

    return $res;
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
