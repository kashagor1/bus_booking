-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2025 at 10:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nicebus`
--

-- --------------------------------------------------------

--
-- Table structure for table `nusers`
--

CREATE TABLE `nusers` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` varchar(10) DEFAULT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nusers`
--

INSERT INTO `nusers` (`id`, `username`, `password`, `role_id`, `fullname`, `phone`, `email`) VALUES
(1, 'shaom', '81dc9bdb52d04dc20036dbd8313ed055', '', 'Shaom Mia', '123', 'ka@gmil.com'),
(2, '123@gmail.col', '$2y$10$.VLeG5o1LC/tKlBOdx88hOpiJ.3hR5ddFkibmYi24zHNoKsp/0YpG', '', 'shagor', '12345', '123@gmail.col'),
(3, 'admin@test.com', '$2y$10$CRsqAklrTQk9lgGt90di4ufg35T2ykTDwlzmMhU6cVaDogT8Ev6ju', '111', 'shaom', '1234', 'sh@gm.com'),
(4, 'ka@g.com', '$2y$10$icq2kDdFOva89CvZCx08Ie83nfC7TRsCvPyvoMmWn5LvZZxzLRUxS', NULL, 'Shagor', '12345', 'ka@g.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nusers`
--
ALTER TABLE `nusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nusers`
--
ALTER TABLE `nusers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
