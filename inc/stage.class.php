<?php

require_once "config.inc.php";

/**
 * Classe représentant un Stage.
 * Un stage est crée quand une candidature a été acceptée par une entreprise.
 * Il faut alors y assigner un tuteur, et attendre que les trois parties (enseignant tuteur, entreprise, étudiant) valident le stage.
 */
class Stage {
  // Attributs d'instance
  private $id;
  private $etudiant;
  private $entreprise;
  private $enseignant;
  private $accepteEtudiant = false;
  private $accepteEntreprise = false;
  private $accepterEnseignant = false;
  private $offreCorrespondante;

  private function __construct() {}

  /**
  * Usine à fabriquer des Stage.
  * @param int $id : l'ID du Stage
  */
  public static function createFromID($id) {
    //TODO
    // Fait une requete sur la BD et renvoie une instance de Stage correspondante, grâce à PDO_FETCH_CLASS
  }
}
