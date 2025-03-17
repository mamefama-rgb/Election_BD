

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
);

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'maimouna@ndao', '1234', '2025-03-04 04:46:59'),
(2, 'halima@thiam', '12345', '2025-03-04 04:46:59'),
(3, 'fama@fall', '1234', '2025-03-04 04:46:59'),
(4, 'amy@gueye', '12345', '2025-03-04 04:46:59'),
(5, 'oumoul@sall', '1234', '2025-03-04 04:46:59'),
(10, 'awaoumou', '12345', '2025-03-04 06:14:43');

-- --------------------------------------------------------

--
-- Structure de la table `candidats`
--

DROP TABLE IF EXISTS `candidats`;
CREATE TABLE IF NOT EXISTS `candidats` (
  `id_candidat` int NOT NULL AUTO_INCREMENT,
  `cin` varchar(20) NOT NULL,
  `numero_electeur` varchar(20) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `parti_politique` varchar(50) DEFAULT NULL,
  `slogan` text,
  `photo` blob,
  `couleurs` varchar(100) DEFAULT NULL,
  `url_information` varchar(255) DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `code` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`id_candidat`),
  UNIQUE KEY `numero_electeur` (`numero_electeur`)
);

--
-- Déchargement des données de la table `candidats`
--

INSERT INTO `candidats` (`id_candidat`, `cin`, `numero_electeur`, `nom`, `prenom`, `date_naissance`, `email`, `telephone`, `parti_politique`, `slogan`, `photo`, `couleurs`, `url_information`, `date_creation`, `code`) VALUES
(3, '', '234567', 'DIOUM', 'Marie', '1990-11-20', 'bintrokhaya65@gmail.com', '777541752', 'allezoumou', 'GOGOGO', 0x75706c6f6164732f576861747341707020496d61676520323032352d30322d323820617420352e30352e353920504d2e6a706567, 'bleu', 'https://www.google.com/search?sca_esv=e7c63961e4743ad0&sxsrf=AHTn8zr0N6aMKuhWdoSdP_43CpbJE34olw:1740185640737&q=photo+diomaye+faye&udm', '2025-03-04 04:40:34', NULL),
(4, '', '567890', 'Dupond', 'Luc', '2000-12-10', 'bintrokhaya65@gmail.com', '777541752', 'abc', 'guem rek door', 0x75706c6f6164732f65786f786d6c2e4a5047, 'bleu', 'https://www.google.com/search?sca_esv=e7c63961e4743ad0&sxsrf=AHTn8zr0N6aMKuhWdoSdP_43CpbJE34olw:1740185640737&q=photo+diomaye+faye&udm', '2025-03-04 21:49:56', '5621e1c7'),
(5, '', '345678', 'Leclerc', 'Paul', '1975-02-25', 'bintrokhaya65@gmail.com', '777689098', 'abc', 'free', 0x75706c6f6164732f312c342e4a5047, 'bleu', 'https://www.google.com/search?sca_esv=e7c63961e4743ad0&sxsrf=AHTn8zr0N6aMKuhWdoSdP_43CpbJE34olw:1740185640737&q=photo+diomaye+faye&udm', '2025-03-04 21:57:03', NULL),
(7, '', '2024', 'Faye', 'Bassirou Diomaye', '2025-02-02', 'bintrokhaya65@gmail.com', '781360949', 'abc', 'kop', 0x75706c6f6164732f6167726963756c746575722e4a5047, 'bleu', 'https://www.google.com/search?sca_esv=e7c63961e4743ad0&sxsrf=AHTn8zr0N6aMKuhWdoSdP_43CpbJE34olw:1740185640737&q=photo+diomaye+faye&udm', '2025-03-04 22:16:11', 'edc265e3');

-- --------------------------------------------------------

--
-- Structure de la table `dates_parrainages`
--

DROP TABLE IF EXISTS `dates_parrainages`;
CREATE TABLE IF NOT EXISTS `dates_parrainages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- Déchargement des données de la table `dates_parrainages`
--

INSERT INTO `dates_parrainages` (`id`, `date_debut`, `date_fin`) VALUES
(1, '2025-11-04', '2026-07-04'),
(2, '2025-12-04', '2026-10-05'),
(3, '2025-10-04', '2026-06-04'),
(4, '2025-10-06', '2026-09-23');

-- --------------------------------------------------------

--
-- Structure de la table `electeurs`
--

DROP TABLE IF EXISTS `electeurs`;
CREATE TABLE IF NOT EXISTS `electeurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero_electeur` varchar(50) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `sexe` enum('M','F') NOT NULL,
  `carte_identite` varchar(50) NOT NULL,
  `adresse_ip` varchar(50) DEFAULT NULL,
  `upload_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_electeur` (`numero_electeur`)
);

--
-- Déchargement des données de la table `electeurs`
--

INSERT INTO `electeurs` (`id`, `numero_electeur`, `nom`, `prenom`, `date_naissance`, `sexe`, `carte_identite`, `adresse_ip`, `upload_time`) VALUES
(1, 'numero_electeur', 'nom', 'prenom', '0000-00-00', '', 'carte_identite', 'upload_time', '0000-00-00 00:00:00'),
(2, '123456', 'Durand', 'Jean', '1980-05-15', 'M', 'AB1234567', '2025-02-20 10:00:00', '2019-02-16 08:01:10'),
(3, '234567', 'Martin', 'Marie', '1990-11-20', 'F', 'CD2345678', '2025-02-20 10:05:00', '2019-02-16 08:01:11'),
(4, '345678', 'Leclerc', 'Paul', '1975-02-25', 'M', 'EF3456789', '2025-02-20 10:10:00', '2019-02-16 08:01:12'),
(5, '456789', 'Moreau', 'Sophie', '1985-08-30', 'F', 'GH4567890', '2025-02-20 10:15:00', '2019-02-16 08:01:13'),
(6, '567890', 'Dupond', 'Luc', '2000-12-10', 'M', 'IJ5678901', '2025-02-20 10:20:00', '2019-02-16 08:01:14'),
(7, '', 'nom', 'prenom', '0000-00-00', '', 'carte_identite', 'upload_time', '0000-00-00 00:00:00'),
(10, '1234', 'GUEYE', 'AMY', '2024-08-06', 'F', '123419803000', '2345', '2025-03-04 01:11:24'),
(11, '2024', 'Faye', 'Bassirou Diomaye', '2025-02-02', 'M', '3870', NULL, '2025-03-04 22:15:37');

-- --------------------------------------------------------

--
-- Structure de la table `historiqueupload`
--

c
-- --------------------------------------------------------

--
-- Structure de la table `tempelecteurs`
--

DROP TABLE IF EXISTS `tempelecteurs`;
CREATE TABLE IF NOT EXISTS `tempelecteurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero_electeur` varchar(50) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `sexe` enum('M','F') NOT NULL,
  `carte_identite` varchar(50) NOT NULL,
  `adresse_ip` varchar(50) DEFAULT NULL,
  `upload_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

-- --------------------------------------------------------

--
-- Structure de la table `temperrors`
--

DROP TABLE IF EXISTS `temperrors`;
CREATE TABLE IF NOT EXISTS `temperrors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero_parrain` varchar(50) DEFAULT NULL,
  `error_message` varchar(255) DEFAULT NULL,
  `upload_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

-- --------------------------------------------------------

--
-- Structure de la table `tempproblemeelecteurs`
--

DROP TABLE IF EXISTS `tempproblemeelecteurs`;
CREATE TABLE IF NOT EXISTS `tempproblemeelecteurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero_electeur` varchar(50) NOT NULL,
  `carte_identite` varchar(50) NOT NULL,
  `error_message` varchar(255) NOT NULL,
  `upload_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
