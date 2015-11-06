<?php

require_once "config.inc.php";

/**
 * Classe représentant une Offre de stage, créée par une entreprise.
 */
class OffreStage {
  // Attributs d'instance
  private $id;
  private $intitule;
  private $domaine;
  private $datePublication;
  private $nbPlaces;
  private $description;
  private $compRequis;
  private $dateDebut;
  private $dateFin;

  private $entrepriseProposant; // l'entreprise qui propose cette offre
  private $stagesCorrespondants = array();

  private function __construct() {}

  /**
  * Usine à fabriquer des OffreStage.
  * @param int $id : l'ID de l'offre
  */
  public static function createFromID($id) {
    //TODO
    // Fait une requete sur la BD et renvoie une instance de OffreStage correspondante, grâce à PDO_FETCH_CLASS
  }
}
