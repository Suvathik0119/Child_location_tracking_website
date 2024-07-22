-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2024 at 04:06 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `location_tracking`
--

-- --------------------------------------------------------

--
-- Table structure for table `parent_child_relation`
--

CREATE TABLE `parent_child_relation` (
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parent_child_relation`
--

INSERT INTO `parent_child_relation` (`parent_id`, `child_id`) VALUES
(10, 11),
(12, 11);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('parent','child') DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `location`) VALUES
(10, 'Suvathik', 'suvathik@gmail.com', '$2y$10$zT1GyX0kQnAAg5PI6zMemuB3UlhZl78mqLK7J.ZrUv/dVq/k84tdO', 'parent', NULL),
(11, 'Suvathik Son', 'son@gmail.com', '$2y$10$yyjySIY14l3P04PEggp9ueAkSGts32Gok07WNakb5X/q.4zNFjOnC', 'child', '7.2171951,81.8462902'),
(12, 'Suvathik parent', 'suvathik1@gmail.com', '$2y$10$/eamt7Q8dTf/1YxlZooaX.EC7B3E7RlkvFy4FNk4vYjhIy308864O', 'parent', NULL),
(13, 'son ', 'son1@gmail.com', '$2y$10$gVayngktpj6Yuvd9ZQwChOMJ2tRvjv8PyEYmPp.ngrrv12rnJT.r6', 'child', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `parent_child_relation`
--
ALTER TABLE `parent_child_relation`
  ADD PRIMARY KEY (`parent_id`,`child_id`),
  ADD KEY `child_id` (`child_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `parent_child_relation`
--
ALTER TABLE `parent_child_relation`
  ADD CONSTRAINT `parent_child_relation_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `parent_child_relation_ibfk_2` FOREIGN KEY (`child_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
