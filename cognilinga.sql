-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2019 at 08:51 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

create database `cognilinga`;
use `cognilinga`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cognilinga`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `favourite_sets`
--

CREATE TABLE `favourite_sets` (
  `user` bigint(20) NOT NULL,
  `study_set` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flashcards`
--

CREATE TABLE `flashcards` (
  `id` bigint(20) NOT NULL,
  `term` varchar(255) NOT NULL,
  `definition` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `lang` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `learning_history`
--

CREATE TABLE `learning_history` (
  `user` bigint(20) NOT NULL,
  `study_set` bigint(20) NOT NULL,
  `progress` int(11) NOT NULL,
  `earned_points` int(11) NOT NULL,
  `finished_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `register_codes`
--

CREATE TABLE `register_codes` (
  `code` varchar(20) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `study_sets`
--

CREATE TABLE `study_sets` (
  `id` bigint(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `flashcard_count` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `term_lang` int(11) NOT NULL,
  `definition_lang` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `visibility` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `study_set_flashcards`
--

CREATE TABLE `study_set_flashcards` (
  `flashcard` bigint(20) NOT NULL,
  `study_set` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `status` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `score` bigint(20) DEFAULT NULL,
  `score_week` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visibilities`
--

CREATE TABLE `visibilities` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*DANE WyPEŁNIAJĄCE PANEL GŁÓWNY*/
INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'informatyka');

INSERT INTO `flashcards` (`id`, `term`, `definition`) VALUES
(1, 'Term 1', 'Definicja 1'),
(2, 'Term 2', 'Definicja 2'),
(3, 'Term 3', 'Definicja 3'),
(4, 'Term 4', 'Definicja 4'),
(9, 'Term 1', 'Definicja 1'),
(10, 'Term 2', 'Definicja 2'),
(11, 'Term 3', 'Definicja 3');

INSERT INTO `languages` (`id`, `lang`) VALUES
(1, 'angielski'),
(2, 'polski');

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'user'),
(2, 'admin');

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'active'),
(2, 'deleted');

INSERT INTO `study_sets` (`id`, `title`, `created_by`, `flashcard_count`, `description`, `term_lang`, `definition_lang`, `category`, `visibility`, `created_date`, `points`) VALUES
(1, 'Zestaw 1', 1, 4, 'Zestaw 1', 1, 2, 1, 2, '2020-02-03 12:39:13', 12),
(4, 'Zestaw 4', 1, 3, 'Zestaw 4', 1, 2, 1, 1, '2020-02-03 12:57:41', 9);

INSERT INTO `study_set_flashcards` (`flashcard`, `study_set`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(9, 4),
(10, 4),
(11, 4);

INSERT INTO `users` (`id`, `login`, `password`, `status`, `role`, `score`, `score_week`) VALUES
(1, 'akokot', '$argon2id$v=19$m=65536,t=4,p=1$eVhLM2tiUjltMzRxUVp2TA$mkg/HaJ/lI/prIXG6u9FcHo9yWq9yDgwAptvoqKy8tA', 1, 1, NULL, NULL);

INSERT INTO `visibilities` (`id`, `name`) VALUES
(1, 'prywatny'),
(2, 'publiczny');


--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favourite_sets`
--
ALTER TABLE `favourite_sets`
  ADD KEY `favourite_sets_fk0` (`user`),
  ADD KEY `favourite_sets_fk1` (`study_set`);

--
-- Indexes for table `flashcards`
--
ALTER TABLE `flashcards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learning_history`
--
ALTER TABLE `learning_history`
  ADD KEY `learning_history_fk0` (`user`),
  ADD KEY `learning_history_fk1` (`study_set`);

--
-- Indexes for table `register_codes`
--
ALTER TABLE `register_codes`
  ADD PRIMARY KEY (`code`),
  ADD KEY `register_codes_fk0` (`role`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `study_sets`
--
ALTER TABLE `study_sets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `study_set_fk1` (`created_by`),
  ADD KEY `study_set_fk2` (`term_lang`),
  ADD KEY `study_set_fk3` (`definition_lang`),
  ADD KEY `study_set_fk4` (`category`),
  ADD KEY `study_set_fk5` (`visibility`);

--
-- Indexes for table `study_set_flashcards`
--
ALTER TABLE `study_set_flashcards`
  ADD KEY `study_set_flashcard_fk0` (`flashcard`),
  ADD KEY `study_set_flashcard_fk1` (`study_set`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `user_fk0` (`status`),
  ADD KEY `user_fk1` (`role`);

--
-- Indexes for table `visibilities`
--
ALTER TABLE `visibilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flashcards`
--
ALTER TABLE `flashcards`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visibilities`
--
ALTER TABLE `visibilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `study_sets` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favourite_sets`
--
ALTER TABLE `favourite_sets`
  ADD CONSTRAINT `favourite_sets_fk0` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `favourite_sets_fk1` FOREIGN KEY (`study_set`) REFERENCES `study_sets` (`id`);

--
-- Constraints for table `learning_history`
--
ALTER TABLE `learning_history`
  ADD CONSTRAINT `learning_history_fk0` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `learning_history_fk1` FOREIGN KEY (`study_set`) REFERENCES `study_sets` (`id`);

--
-- Constraints for table `register_codes`
--
ALTER TABLE `register_codes`
  ADD CONSTRAINT `register_codes_fk0` FOREIGN KEY (`role`) REFERENCES `roles` (`id`);

--
-- Constraints for table `study_sets`
--
ALTER TABLE `study_sets`
  ADD CONSTRAINT `study_set_fk1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `study_set_fk2` FOREIGN KEY (`term_lang`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `study_set_fk3` FOREIGN KEY (`definition_lang`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `study_set_fk4` FOREIGN KEY (`category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `study_set_fk5` FOREIGN KEY (`visibility`) REFERENCES `visibilities` (`id`);

--
-- Constraints for table `study_set_flashcards`
--
ALTER TABLE `study_set_flashcards`
  ADD CONSTRAINT `study_set_flashcard_fk0` FOREIGN KEY (`flashcard`) REFERENCES `flashcards` (`id`),
  ADD CONSTRAINT `study_set_flashcard_fk1` FOREIGN KEY (`study_set`) REFERENCES `study_sets` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_fk0` FOREIGN KEY (`status`) REFERENCES `statuses` (`id`),
  ADD CONSTRAINT `user_fk1` FOREIGN KEY (`role`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;