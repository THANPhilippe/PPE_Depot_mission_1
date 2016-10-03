-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 03 Octobre 2016 à 14:42
-- Version du serveur :  5.5.52-0+deb8u1
-- Version de PHP :  5.6.24-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `pthan`
--

-- --------------------------------------------------------

--
-- Structure de la table `visiteur`
--

CREATE TABLE IF NOT EXISTS `visiteur` (
  `id` char(4) NOT NULL,
  `nom` char(30) DEFAULT NULL,
  `prenom` char(30) DEFAULT NULL,
  `login` char(20) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `adresse` char(30) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL,
  `ville` char(30) DEFAULT NULL,
  `dateEmbauche` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `visiteur`
--

INSERT INTO `visiteur` (`id`, `nom`, `prenom`, `login`, `mdp`, `adresse`, `cp`, `ville`, `dateEmbauche`) VALUES
('a131', 'Villechalane', 'Louis', 'lvillachane', '92eb980737f1854076b2e34933286d8e', '8 rue des Charmes', '46000', 'Cahors', '2005-12-21'),
('a17', 'Andre', 'David', 'dandre', '37f2381c9a729782c38410b1ea5b8191', '1 rue Petit', '46200', 'Lalbenque', '1998-11-23'),
('a55', 'Bedos', 'Christian', 'cbedos', '26ec3c585ee973005c2744742d920dc3', '1 rue Peranud', '46250', 'Montcuq', '1995-01-12'),
('a93', 'Tusseau', 'Louis', 'ltusseau', 'f85f3127fc55f0ad7433b6879bc05f4e', '22 rue des Ternes', '46123', 'Gramat', '2000-05-01'),
('b13', 'Bentot', 'Pascal', 'pbentot', 'ae5d0d7637be4083a245f980a2189d97', '11 allée des Cerises', '46512', 'Bessines', '1992-07-09'),
('b16', 'Bioret', 'Luc', 'lbioret', '566ea5a9b3a6f186928cc20711f13fa8', '1 Avenue gambetta', '46000', 'Cahors', '1998-05-11'),
('b19', 'Bunisset', 'Francis', 'fbunisset', '969c2fe5ac918a86a664b2041d5bc295', '10 rue des Perles', '93100', 'Montreuil', '1987-10-21'),
('b25', 'Bunisset', 'Denise', 'dbunisset', '03b01d4e2f53d838a2228e6cd57b8578', '23 rue Manin', '75019', 'paris', '2010-12-05'),
('b28', 'Cacheux', 'Bernard', 'bcacheux', 'f6b78ee75c60c4becd5ed3daaca14127', '114 rue Blanche', '75017', 'Paris', '2009-11-12'),
('b34', 'Cadic', 'Eric', 'ecadic', '36b98727aece53010ddde58639294427', '123 avenue de la République', '75011', 'Paris', '2008-09-23'),
('b4', 'Charoze', 'Catherine', 'ccharoze', 'fce14894825737b9850d2bfccf0adf02', '100 rue Petit', '75019', 'Paris', '2005-11-12'),
('b50', 'Clepkens', 'Christophe', 'cclepkens', '9ac1d70eef6e5f225b1db64eabaa4374', '12 allée des Anges', '93230', 'Romainville', '2003-08-11'),
('b59', 'Cottin', 'Vincenne', 'vcottin', 'e509e3ed6ac643ac405aba9c40ebc591', '36 rue Des Roches', '93100', 'Monteuil', '2001-11-18'),
('c14', 'Daburon', 'François', 'fdaburon', '44fda4ffdcf80a5f0c07fd0c82dafa4b', '13 rue de Chanzy', '94000', 'Créteil', '2002-02-11'),
('c3', 'De', 'Philippe', 'pde', 'd5d01f0959b81d8e99e0ff5ecec858f7', '13 rue Barthes', '94000', 'Créteil', '2010-12-14'),
('c54', 'Debelle', 'Michel', 'mdebelle', '5583dc317a2427151176da897d02847c', '181 avenue Barbusse', '93210', 'Rosny', '2006-11-23'),
('d13', 'Debelle', 'Jeanne', 'jdebelle', 'b7d60232b71cf9cbbfffa53cac58c2b6', '134 allée des Joncs', '44000', 'Nantes', '2000-05-11'),
('d51', 'Debroise', 'Michel', 'mdebroise', '7101579c34d26bb94798fa096c577a8b', '2 Bld Jourdain', '44000', 'Nantes', '2001-04-17'),
('e22', 'Desmarquest', 'Nathalie', 'ndesmarquest', '77f0798fb878eba2d41a92187db41370', '14 Place d Arc', '45000', 'Orléans', '2005-11-12'),
('e24', 'Desnost', 'Pierre', 'pdesnost', 'f22a9af3e65d9b3942f242cb559374ae', '16 avenue des Cèdres', '23200', 'Guéret', '2001-02-05'),
('e39', 'Dudouit', 'Frédéric', 'fdudouit', '09723e8247fbdda4d2dda2d15d160dfd', '18 rue de l église', '23120', 'GrandBourg', '2000-08-01'),
('e49', 'Duncombe', 'Claude', 'cduncombe', '4b66fd37213456e6d58e79993a446241', '19 rue de la tour', '23100', 'La souteraine', '1987-10-10'),
('e5', 'Enault-Pascreau', 'Céline', 'cenault', '8c2cfac2fc5e3b1100842b3573720cc8', '25 place de la gare', '23200', 'Gueret', '1995-09-01'),
('e52', 'Eynde', 'Valérie', 'veynde', 'ea33b05db1515b43c387050ef64e687b', '3 Grand Place', '13015', 'Marseille', '1999-11-01'),
('f21', 'Finck', 'Jacques', 'jfinck', 'ec5014f6a2f2631952b6c677409a29fe', '10 avenue du Prado', '13002', 'Marseille', '2001-11-10'),
('f39', 'Frémont', 'Fernande', 'ffremont', '8774099cc05fd213276773425739ed85', '4 route de la mer', '13012', 'Allauh', '1998-10-01'),
('f4', 'Gest', 'Alain', 'agest', '8167f1d92b7c2666aaf0d6f77cbc761d', '30 avenue de la mer', '13025', 'Berre', '1985-11-01');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `visiteur`
--
ALTER TABLE `visiteur`
 ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
