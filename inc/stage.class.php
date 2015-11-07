<?php

require_once "config.inc.php";

/**
 * Classe représentant un Stage.
 * Un stage est crée quand une candidature a été acceptée par une entreprise.
 * Il faut alors y assigner un tuteur, et attendre que les trois parties (enseignant tuteur, entreprise, étudiant) valident le stage.
 */
class Stage {
  // Attributs d'instance
  private $idEtu;
  private $idOffre;
  private $idEnseignant;
  private $accepteEtudiant = false;
  private $accepteEntreprise = false;
  private $accepterEnseignant = false;
  private $entrepriseCorrespondante;

  private function __construct() {}

  /**
   * Usine à fabriquer des Stage
   * @param  int  $idEtudiant   : l'ID de l'étudiant
   * @param  int  $idEntreprise : l'ID de l'entreprise
   * @param  int  $idEnseignant : l'ID de l'enseignant
   * @return Stage
   */
  public static function createFromIDs($idEtudiant, $idOffre, $idEnseignant) {
    //TODO
  }
}
