-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 21 juil. 2024 à 18:56
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `soignemoi_spn`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id` int(11) UNSIGNED NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `date_avis` date NOT NULL,
  `description` text NOT NULL,
  `medecin_id` int(11) UNSIGNED NOT NULL,
  `sejour_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `libelle`, `date_avis`, `description`, `medecin_id`, `sejour_id`) VALUES
(1, 'Avis test', '2024-07-10', 'Ceci est un avis de test.', 12, 23);

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

CREATE TABLE `medecin` (
  `id` int(11) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `matricule` varchar(255) NOT NULL,
  `specialite_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `medecin`
--

INSERT INTO `medecin` (`id`, `nom`, `prenom`, `email`, `matricule`, `specialite_id`) VALUES
(1, 'Dupont', 'Jean', '', 'MD001', 1),
(2, 'Martin', 'Marie', '', 'MD002', 2),
(3, 'Nguyen', 'Thierry', '', 'MD003', 3),
(9, 'Lefèvre', 'Pierre', '', 'M004', 6),
(12, 'Rose', 'Thibault', 'test_rt@gmail.com', 'MD005', 4);

-- --------------------------------------------------------

--
-- Structure de la table `medicaments`
--

CREATE TABLE `medicaments` (
  `id` int(11) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `medicaments`
--

INSERT INTO `medicaments` (`id`, `nom`, `description`) VALUES
(1, 'Aspirine', 'Analgésique, antipyrétique et anti-inflammatoire.'),
(2, 'Amoxicilline', 'Antibiotique utilisé pour traiter diverses infections bactériennes.'),
(3, 'Atorvastatine', 'Médicament utilisé pour traiter les taux élevés de cholestérol.'),
(4, 'Lisinopril', 'Inhibiteur de l\'enzyme de conversion de l\'angiotensine (ECA) utilisé pour traiter l\'hypertension artérielle et l\'insuffisance cardiaque.'),
(5, 'Ibuprofène', 'Anti-inflammatoire non stéroïdien (AINS) utilisé pour réduire la fièvre et traiter la douleur ou l\'inflammation causée par diverses conditions médicales.');

-- --------------------------------------------------------

--
-- Structure de la table `planning_medecins`
--

CREATE TABLE `planning_medecins` (
  `id` int(11) UNSIGNED NOT NULL,
  `medecin_id` int(11) UNSIGNED NOT NULL,
  `sejour_id` int(11) UNSIGNED NOT NULL,
  `date_i` date NOT NULL,
  `nombre_patients` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `planning_medecins`
--

INSERT INTO `planning_medecins` (`id`, `medecin_id`, `sejour_id`, `date_i`, `nombre_patients`) VALUES
(1, 1, 8, '2024-07-02', 1),
(3, 1, 9, '2024-07-02', 1),
(4, 1, 10, '2024-07-02', 1),
(5, 1, 11, '2024-07-02', 1),
(7, 1, 12, '2024-07-02', 1),
(9, 1, 13, '2024-07-02', 1),
(11, 1, 14, '2024-07-04', 1),
(13, 1, 15, '2024-07-05', 1),
(15, 1, 16, '2024-07-05', 1),
(17, 1, 17, '2024-07-05', 1),
(19, 1, 18, '2024-07-05', 1),
(21, 1, 19, '2024-07-05', 1),
(23, 1, 20, '2024-07-19', 4),
(24, 1, 20, '2024-07-20', 2),
(25, 1, 20, '2024-07-21', 1),
(26, 1, 20, '2024-07-22', 1),
(27, 1, 20, '2024-07-23', 1),
(28, 1, 20, '2024-07-24', 1),
(29, 1, 20, '2024-07-25', 1),
(30, 1, 21, '2024-07-19', 1),
(31, 1, 21, '2024-07-20', 1),
(32, 1, 21, '2024-07-21', 1),
(33, 1, 21, '2024-07-22', 1),
(34, 1, 21, '2024-07-23', 1),
(35, 1, 21, '2024-07-24', 1),
(36, 1, 21, '2024-07-25', 1),
(37, 1, 22, '2024-08-16', 2),
(38, 1, 22, '2024-08-17', 1),
(39, 1, 22, '2024-08-18', 1),
(40, 1, 22, '2024-08-19', 1),
(41, 1, 22, '2024-08-20', 1),
(42, 1, 22, '2024-08-21', 1),
(43, 1, 22, '2024-08-22', 1),
(44, 12, 23, '2024-07-12', 2),
(45, 12, 23, '2024-07-13', 1),
(46, 12, 23, '2024-07-14', 1),
(47, 1, 24, '2024-07-18', 2),
(48, 1, 25, '2024-07-19', 1),
(49, 1, 26, '2024-07-20', 1);

-- --------------------------------------------------------

--
-- Structure de la table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) UNSIGNED NOT NULL,
  `date_prescription` date NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `medecin_id` int(11) UNSIGNED NOT NULL,
  `sejour_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `date_prescription`, `libelle`, `description`, `medecin_id`, `sejour_id`) VALUES
(5, '2024-07-10', 'Traitement contre l\'hypertension', 'Prescription pour le traitement de l\'hypertension.', 12, 23);

-- --------------------------------------------------------

--
-- Structure de la table `prescriptions_medicaments`
--

CREATE TABLE `prescriptions_medicaments` (
  `id` int(11) UNSIGNED NOT NULL,
  `prescription_id` int(11) UNSIGNED NOT NULL,
  `medicament_id` int(11) UNSIGNED NOT NULL,
  `posologie` varchar(255) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `prescriptions_medicaments`
--

INSERT INTO `prescriptions_medicaments` (`id`, `prescription_id`, `medicament_id`, `posologie`, `date_debut`, `date_fin`) VALUES
(1, 5, 1, '1 comprimé matin et soir', '2024-07-10', '2024-07-23');

-- --------------------------------------------------------

--
-- Structure de la table `sejours`
--

CREATE TABLE `sejours` (
  `id` int(11) UNSIGNED NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `motif` varchar(255) NOT NULL,
  `specialite_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `medecin_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sejours`
--

INSERT INTO `sejours` (`id`, `date_debut`, `date_fin`, `motif`, `specialite_id`, `user_id`, `medecin_id`) VALUES
(6, '2024-06-24', '2024-06-24', 'Consultation1', 1, 1, 1),
(7, '2024-06-24', '2024-06-24', 'Consultation 2', 2, 1, 2),
(8, '2024-07-02', '2024-07-02', 'Consultation3', 1, 1, 1),
(9, '2024-07-02', '2024-07-02', 'Consultation4', 1, 1, 1),
(10, '2024-07-02', '2024-07-02', 'Consultation4', 1, 1, 1),
(11, '2024-07-02', '2024-07-02', 'Consultation4', 1, 1, 1),
(12, '2024-07-02', '2024-07-02', 'Consultation fin juillet', 1, 1, 1),
(13, '2024-07-02', '2024-07-02', 'Consultation août', 1, 1, 1),
(14, '2024-07-04', '2024-07-04', 'consultation 12 juillet', 1, 1, 1),
(15, '2024-07-05', '2024-07-05', 'Consultation 25 juillet', 1, 1, 1),
(16, '2024-07-05', '2024-07-05', 'Consultation 30 juillet', 1, 1, 1),
(17, '2024-07-05', '2024-07-05', 'Consultation 19 juillet', 1, 1, 1),
(18, '2024-07-05', '2024-07-05', 'Consultation 19 juillet', 1, 1, 1),
(19, '2024-07-05', '2024-07-05', 'Consultation 19 juillet', 1, 1, 1),
(20, '2024-07-19', '2024-07-25', 'Consultation 19 juillet', 1, 1, 1),
(21, '2024-07-19', '2024-07-25', 'Consultation 19 juillet', 1, 1, 1),
(22, '2024-08-16', '2024-08-22', 'Consultation 16 août', 1, 1, 1),
(23, '2024-07-12', '2024-07-14', 'Consultation pédiatrie', 4, 1, 12),
(24, '2024-07-18', '2024-07-18', 'Consultation 18 juillet', 1, 1, 1),
(25, '2024-07-19', '2024-07-19', 'consultation sortie 19 juillet', 1, 1, 1),
(26, '2024-07-20', '2024-07-20', 'consultation 20 juillet', 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `specialites`
--

CREATE TABLE `specialites` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `specialites`
--

INSERT INTO `specialites` (`id`, `name`) VALUES
(1, 'Cardiologie'),
(2, 'Chirurgie'),
(3, 'Dermatologie'),
(4, 'Pédiatrie'),
(5, 'Gynécologie'),
(6, 'Neurologie');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `prenom`, `nom`, `email`, `password`, `adress`, `role`) VALUES
(1, 'Test', 'test', 'test@gmail.com', '$2y$10$CmnXnPigFyRCyPQC/ATxrOW3bpDKn.QyVJMMle1n7i4vO.x6C4dDO', '', 'user'),
(8, 'Paul', 'Durand', 'paul.durand@gmail.com', '$2y$10$6r1gWRSolwVaXUs9MLF/1eliKHTKJk092McBhN.MgtMHbodbSi1.K', '78 Rue des Patients, 59000 Lille', 'user'),
(9, 'Marion', 'Girond', 'admin@test.com', '$2y$10$p8G8ZnbP/cT57k8y.0nR4uN5XBdx13Zz8MWQrBylpGhb8/04M2Qg2', '', 'admin'),
(12, 'Thibault', 'Rose', 'test_rt@gmail.com', '$2y$10$jAXvyMyopECyRjMKb/AcTOkua0la.GQaia3MAXmjYpMponxNWRNe.', '', 'medecin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medecin_id` (`medecin_id`),
  ADD KEY `sejour_id` (`sejour_id`);

--
-- Index pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `specialite_id` (`specialite_id`);

--
-- Index pour la table `medicaments`
--
ALTER TABLE `medicaments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `planning_medecins`
--
ALTER TABLE `planning_medecins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medecin_id` (`medecin_id`),
  ADD KEY `sejour_id` (`sejour_id`);

--
-- Index pour la table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medecin_id` (`medecin_id`),
  ADD KEY `sejour_id` (`sejour_id`);

--
-- Index pour la table `prescriptions_medicaments`
--
ALTER TABLE `prescriptions_medicaments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicament_id` (`medicament_id`),
  ADD KEY `prescription_id` (`prescription_id`);

--
-- Index pour la table `sejours`
--
ALTER TABLE `sejours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `medecin_id` (`medecin_id`),
  ADD KEY `specialite_id` (`specialite_id`);

--
-- Index pour la table `specialites`
--
ALTER TABLE `specialites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `medecin`
--
ALTER TABLE `medecin`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `medicaments`
--
ALTER TABLE `medicaments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `planning_medecins`
--
ALTER TABLE `planning_medecins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `prescriptions_medicaments`
--
ALTER TABLE `prescriptions_medicaments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `sejours`
--
ALTER TABLE `sejours`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `specialites`
--
ALTER TABLE `specialites`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`medecin_id`) REFERENCES `medecin` (`id`),
  ADD CONSTRAINT `avis_ibfk_2` FOREIGN KEY (`sejour_id`) REFERENCES `sejours` (`id`);

--
-- Contraintes pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD CONSTRAINT `medecin_ibfk_1` FOREIGN KEY (`specialite_id`) REFERENCES `specialites` (`id`);

--
-- Contraintes pour la table `planning_medecins`
--
ALTER TABLE `planning_medecins`
  ADD CONSTRAINT `planning_medecins_ibfk_1` FOREIGN KEY (`medecin_id`) REFERENCES `medecin` (`id`),
  ADD CONSTRAINT `planning_medecins_ibfk_2` FOREIGN KEY (`sejour_id`) REFERENCES `sejours` (`id`);

--
-- Contraintes pour la table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_ibfk_1` FOREIGN KEY (`medecin_id`) REFERENCES `medecin` (`id`),
  ADD CONSTRAINT `prescriptions_ibfk_2` FOREIGN KEY (`sejour_id`) REFERENCES `sejours` (`id`);

--
-- Contraintes pour la table `prescriptions_medicaments`
--
ALTER TABLE `prescriptions_medicaments`
  ADD CONSTRAINT `prescriptions_medicaments_ibfk_1` FOREIGN KEY (`medicament_id`) REFERENCES `medicaments` (`id`),
  ADD CONSTRAINT `prescriptions_medicaments_ibfk_2` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`);

--
-- Contraintes pour la table `sejours`
--
ALTER TABLE `sejours`
  ADD CONSTRAINT `sejours_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `sejours_ibfk_2` FOREIGN KEY (`medecin_id`) REFERENCES `medecin` (`id`),
  ADD CONSTRAINT `sejours_ibfk_3` FOREIGN KEY (`specialite_id`) REFERENCES `specialites` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
