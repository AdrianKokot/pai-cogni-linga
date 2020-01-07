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
-- Table structure for table `category`
--

CREATE TABLE `category` (
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
-- Table structure for table `flashcard`
--

CREATE TABLE `flashcard` (
  `id` bigint(20) NOT NULL,
  `term` varchar(255) NOT NULL,
  `definition` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
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
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `study_set`
--

CREATE TABLE `study_set` (
  `id` bigint(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `flashcard_count` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `term_lang` int(11) NOT NULL,
  `definition_lang` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `visibility` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `study_set_flashcard`
--

CREATE TABLE `study_set_flashcard` (
  `flashcard` bigint(20) NOT NULL,
  `study_set` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
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
-- Table structure for table `visibility`
--

CREATE TABLE `visibility` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favourite_sets`
--
ALTER TABLE `favourite_sets`
  ADD KEY `favourite_sets_fk0` (`user`),
  ADD KEY `favourite_sets_fk1` (`study_set`);

--
-- Indexes for table `flashcard`
--
ALTER TABLE `flashcard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
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
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `study_set`
--
ALTER TABLE `study_set`
  ADD PRIMARY KEY (`id`),
  ADD KEY `study_set_fk1` (`created_by`),
  ADD KEY `study_set_fk2` (`term_lang`),
  ADD KEY `study_set_fk3` (`definition_lang`),
  ADD KEY `study_set_fk4` (`category`),
  ADD KEY `study_set_fk5` (`visibility`);

--
-- Indexes for table `study_set_flashcard`
--
ALTER TABLE `study_set_flashcard`
  ADD KEY `study_set_flashcard_fk0` (`flashcard`),
  ADD KEY `study_set_flashcard_fk1` (`study_set`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `user_fk0` (`status`),
  ADD KEY `user_fk1` (`role`);

--
-- Indexes for table `visibility`
--
ALTER TABLE `visibility`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flashcard`
--
ALTER TABLE `flashcard`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visibility`
--
ALTER TABLE `visibility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favourite_sets`
--
ALTER TABLE `favourite_sets`
  ADD CONSTRAINT `favourite_sets_fk0` FOREIGN KEY (`user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `favourite_sets_fk1` FOREIGN KEY (`study_set`) REFERENCES `study_set` (`id`);

--
-- Constraints for table `learning_history`
--
ALTER TABLE `learning_history`
  ADD CONSTRAINT `learning_history_fk0` FOREIGN KEY (`user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `learning_history_fk1` FOREIGN KEY (`study_set`) REFERENCES `study_set` (`id`);

--
-- Constraints for table `register_codes`
--
ALTER TABLE `register_codes`
  ADD CONSTRAINT `register_codes_fk0` FOREIGN KEY (`role`) REFERENCES `role` (`id`);

--
-- Constraints for table `study_set`
--
ALTER TABLE `study_set`
  ADD CONSTRAINT `study_set_fk1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `study_set_fk2` FOREIGN KEY (`term_lang`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `study_set_fk3` FOREIGN KEY (`definition_lang`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `study_set_fk4` FOREIGN KEY (`category`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `study_set_fk5` FOREIGN KEY (`visibility`) REFERENCES `visibility` (`id`);

--
-- Constraints for table `study_set_flashcard`
--
ALTER TABLE `study_set_flashcard`
  ADD CONSTRAINT `study_set_flashcard_fk0` FOREIGN KEY (`flashcard`) REFERENCES `flashcard` (`id`),
  ADD CONSTRAINT `study_set_flashcard_fk1` FOREIGN KEY (`study_set`) REFERENCES `study_set` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_fk0` FOREIGN KEY (`status`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `user_fk1` FOREIGN KEY (`role`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
