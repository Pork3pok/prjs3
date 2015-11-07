-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 07 Novembre 2015 à 12:42
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `prjs3`
--

-- --------------------------------------------------------

--
-- Structure de la table `candidature`
--

CREATE TABLE IF NOT EXISTS `candidature` (
  `idEtu` int(10) DEFAULT NULL,
  `idOffre` int(10) DEFAULT NULL,
  `lettreMotiv` text,
  `refuse` tinyint(1) DEFAULT NULL,
  KEY `fk_idEtudiant` (`idEtu`),
  KEY `fk_idOffre` (`idOffre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `idEnt` int(10) DEFAULT NULL,
  `idPers` int(10) DEFAULT NULL,
  `descrEns` text,
  KEY `fk_idEntrepriseComm` (`idEnt`),
  KEY `fk_idEnseignantComm` (`idPers`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `enseignant`
--

CREATE TABLE IF NOT EXISTS `enseignant` (
  `idEns` int(10) DEFAULT NULL,
  `domainPredom` varchar(30) DEFAULT NULL,
  KEY `fk_idEns` (`idEns`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE IF NOT EXISTS `entreprise` (
  `idEnt` int(10) NOT NULL,
  `login` varchar(20) DEFAULT NULL,
  `sha1mdp` varchar(40) DEFAULT NULL,
  `nomEnt` varchar(50) DEFAULT NULL,
  `codeEnt` varchar(20) DEFAULT NULL,
  `villeEnt` varchar(20) DEFAULT NULL,
  `CPEnt` varchar(5) DEFAULT NULL,
  `numRueEnt` int(3) DEFAULT NULL,
  `rueEnt` varchar(30) DEFAULT NULL,
  `complAdrEnt` varchar(20) DEFAULT NULL,
  `siteWebEnt` varchar(70) DEFAULT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`idEnt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE IF NOT EXISTS `etudiant` (
  `idEtu` int(10) DEFAULT NULL,
  `cheminCV` varchar(100) DEFAULT NULL,
  KEY `fk_idEtud` (`idEtu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `offrestage`
--

CREATE TABLE IF NOT EXISTS `offrestage` (
  `idOffre` int(10) NOT NULL,
  `idEnt` int(10) NOT NULL,
  `intitule` varchar(20) DEFAULT NULL,
  `datePublication` date NOT NULL,
  `domaine` varchar(30) DEFAULT NULL,
  `nbPlaces` int(3) DEFAULT NULL,
  `descOffre` text,
  `cptRequis` text,
  `dateDeb` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  PRIMARY KEY (`idOffre`),
  KEY `fk_idEnt` (`idEnt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE IF NOT EXISTS `personne` (
  `idPers` int(10) NOT NULL,
  `login` varchar(20) DEFAULT NULL,
  `sha1mdp` varchar(40) DEFAULT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `sexe` char(1) DEFAULT NULL,
  `telF` varchar(10) DEFAULT NULL,
  `telP` varchar(10) DEFAULT NULL,
  `email` char(70) DEFAULT NULL,
  `ville` varchar(30) DEFAULT NULL,
  `CP` varchar(5) DEFAULT NULL,
  `numRue` int(3) DEFAULT NULL,
  `rue` varchar(30) DEFAULT NULL,
  `complAdr` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idPers`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `stage`
--

CREATE TABLE IF NOT EXISTS `stage` (
  `idEtu` int(10) DEFAULT NULL,
  `idOffre` int(10) DEFAULT NULL,
  `idEns` int(10) DEFAULT NULL,
  `acceptEnt` tinyint(1) DEFAULT NULL,
  `acceptEtu` tinyint(1) DEFAULT NULL,
  `acceptEns` tinyint(1) DEFAULT NULL,
  KEY `fk_idEnseignantStage` (`idEtu`),
  KEY `fk_idOffreStage` (`idOffre`),
  KEY `fk_idEtudiantStage` (`idEns`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `candidature`
--
ALTER TABLE `candidature`
  ADD CONSTRAINT `fk_idEtudiant` FOREIGN KEY (`idEtu`) REFERENCES `etudiant` (`idEtu`),
  ADD CONSTRAINT `fk_idOffre` FOREIGN KEY (`idOffre`) REFERENCES `offrestage` (`idOffre`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `fk_idEntrepriseComm` FOREIGN KEY (`idEnt`) REFERENCES `entreprise` (`idEnt`),
  ADD CONSTRAINT `fk_idEnseignantComm` FOREIGN KEY (`idPers`) REFERENCES `enseignant` (`idEns`);

--
-- Contraintes pour la table `enseignant`
--
ALTER TABLE `enseignant`
  ADD CONSTRAINT `fk_idEns` FOREIGN KEY (`idEns`) REFERENCES `personne` (`idPers`);

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `fk_idEtud` FOREIGN KEY (`idEtu`) REFERENCES `personne` (`idPers`);

--
-- Contraintes pour la table `offrestage`
--
ALTER TABLE `offrestage`
  ADD CONSTRAINT `fk_idEnt` FOREIGN KEY (`idEnt`) REFERENCES `entreprise` (`idEnt`);

--
-- Contraintes pour la table `stage`
--
ALTER TABLE `stage`
  ADD CONSTRAINT `fk_idEnseignantStage` FOREIGN KEY (`idEtu`) REFERENCES `etudiant` (`idEtu`),
  ADD CONSTRAINT `fk_idOffreStage` FOREIGN KEY (`idOffre`) REFERENCES `offrestage` (`idOffre`),
  ADD CONSTRAINT `fk_idEtudiantStage` FOREIGN KEY (`idEns`) REFERENCES `enseignant` (`idEns`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
