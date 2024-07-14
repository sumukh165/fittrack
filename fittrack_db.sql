-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2024 at 03:57 PM
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
-- Database: `fittrack_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `calories` int(11) NOT NULL,
  `protein` float NOT NULL,
  `carbs` float NOT NULL,
  `fats` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `food_name`, `calories`, `protein`, `carbs`, `fats`) VALUES
(1, 'Chapati', 70, 3, 15, 1),
(2, 'Rice', 130, 2.5, 28, 0.3),
(3, 'Dal', 120, 9, 18, 3),
(4, 'Chicken Curry', 250, 20, 10, 15),
(5, 'Paneer Butter Masala', 300, 12, 15, 25),
(7, 'Dosa', 150, 4, 30, 3),
(8, 'Idli', 70, 2, 12, 0.5),
(9, 'Poha', 180, 4, 27, 6),
(10, 'Biryani', 350, 20, 45, 10),
(11, 'Aloo Paratha', 220, 5, 35, 8),
(13, 'Pav Bhaji', 400, 10, 50, 15),
(14, 'Palak Paneer', 250, 12, 20, 15),
(17, 'Chole Bhature', 450, 15, 60, 20),
(19, 'Bhindi Masala', 150, 3, 10, 10),
(20, 'Rajma', 220, 12, 35, 5),
(21, 'Upma', 180, 5, 25, 6),
(22, 'Sambar', 150, 6, 20, 5),
(23, 'Masala Dosa', 200, 5, 35, 6),
(26, 'Pongal', 180, 5, 30, 5),
(30, 'Aloo Gobi', 170, 4, 15, 10),
(31, 'Vegetable Pulao', 250, 6, 45, 7),
(32, 'Mutter Paneer', 300, 12, 25, 18),
(33, 'Fish Curry', 200, 22, 10, 10),
(34, 'Shrikhand', 180, 6, 30, 5),
(35, 'Baingan Bharta', 150, 3, 12, 9),
(36, 'Pesarattu', 120, 7, 18, 4),
(37, 'Misal Pav', 350, 10, 40, 15),
(38, 'Moong Dal Halwa', 250, 8, 35, 10),
(39, 'Aloo Tikki', 200, 4, 25, 8),
(40, 'Chicken Tikka', 150, 25, 5, 5),
(41, 'Egg Bhurji', 150, 12, 2, 10),
(42, 'Egg Curry', 250, 12, 5, 20),
(43, 'Paneer Tikka', 200, 15, 5, 15),
(44, 'Chicken Biryani', 350, 20, 45, 15),
(45, 'Keema', 300, 25, 10, 20),
(46, 'Mutton Curry', 350, 20, 8, 28),
(47, 'Grilled Fish', 200, 25, 0, 10),
(48, 'Prawn Curry', 220, 20, 5, 12),
(49, 'Tofu Stir Fry', 150, 12, 10, 7),
(50, 'Chickpea Salad', 180, 10, 25, 5),
(51, 'Lentil Soup', 120, 9, 20, 3),
(52, 'Quinoa Salad', 180, 8, 30, 4),
(53, 'Oats', 150, 5, 27, 3),
(54, 'Soybean Curry', 200, 18, 15, 8),
(55, 'Greek Yogurt', 100, 10, 6, 3),
(56, 'Peanut Butter', 180, 8, 7, 15),
(57, 'Almonds', 160, 6, 6, 14),
(58, 'Walnuts', 180, 4, 4, 18),
(59, 'Sunflower Seeds', 160, 5, 7, 14),
(60, 'Mixed Nuts', 170, 6, 8, 15),
(61, 'Pumpkin Seeds', 150, 7, 6, 12),
(62, 'Flax Seeds', 150, 5, 8, 11),
(63, 'Chia Seeds', 140, 5, 12, 9),
(64, 'Protein Shake', 150, 28, 10, 5),
(65, 'Ragi Mudde', 97, 2.7, 20.3, 0.4),
(66, 'Curd Rice', 140, 3, 23, 4),
(67, 'Lemon Rice', 180, 4, 30, 5),
(68, 'Tomato Rice', 200, 4.5, 38, 5),
(69, 'Egg Dosa', 210, 8, 36, 5),
(70, 'Fish Fry', 230, 25, 2, 12),
(71, 'Mutton Sukka', 300, 22, 5, 20),
(72, 'Rasam', 50, 2, 8, 1),
(73, 'Semiya Upma', 200, 5, 35, 5),
(74, 'Puliyogare', 170, 4, 30, 4);

-- --------------------------------------------------------

--
-- Table structure for table `nutrition`
--

CREATE TABLE `nutrition` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_name` varchar(255) DEFAULT NULL,
  `calories_consumed` int(11) DEFAULT NULL,
  `protein` float DEFAULT NULL,
  `carbs` float DEFAULT NULL,
  `fats` float DEFAULT NULL,
  `log_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nutrition`
--

INSERT INTO `nutrition` (`id`, `user_id`, `food_name`, `calories_consumed`, `protein`, `carbs`, `fats`, `log_date`) VALUES
(1, 1, 'Protein Shake', 150, 28, 10, 5, '2024-06-28'),
(4, 1, 'Paneer wrap', 400, 20, 50, 10, '2024-06-30'),
(6, 1, 'Oatmeal', 400, 20, 60, 50, '2024-07-01'),
(7, 1, 'Biryani', 350, 20, 45, 10, '2024-07-07');

-- --------------------------------------------------------

--
-- Table structure for table `personal_details`
--

CREATE TABLE `personal_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `height` float DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_details`
--

INSERT INTO `personal_details` (`id`, `user_id`, `height`, `weight`, `age`, `gender`) VALUES
(1, 1, 165, 80, 20, 'Male'),
(2, 2, 170, 70, 20, 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `goal` enum('weight_loss','muscle_gain','maintenance') DEFAULT 'maintenance'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `goal`) VALUES
(1, 'Sumukh', 'email@gmail.com', '123abc', '$2y$10$WsJlAxdmtV95urD5ZMcSeuL.bsbAZ93oTYYHaggFNzSWwl5nqkSyy', 'maintenance'),
(2, 'admin', 'admin@email.com', 'admin', '$2y$10$50qhB9Gi6BhWD4akjxHQC.hdeeGpi54qplqnar76JR5p0N.Ox/ira', 'maintenance');

-- --------------------------------------------------------

--
-- Table structure for table `workouts`
--

CREATE TABLE `workouts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exercise_name` varchar(255) DEFAULT NULL,
  `muscle_group` varchar(255) DEFAULT NULL,
  `sets` int(11) DEFAULT NULL,
  `reps` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `distance` float DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `workout_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workouts`
--

INSERT INTO `workouts` (`id`, `user_id`, `exercise_name`, `muscle_group`, `sets`, `reps`, `weight`, `distance`, `duration`, `workout_date`) VALUES
(1, 1, 'Lat pulldown', 'Lats', 3, 12, 30, NULL, NULL, '2024-06-28'),
(4, 1, 'Shoulder press', 'Shoulder', 3, 12, 20, NULL, NULL, '2024-07-01'),
(8, 1, 'Treadmill', NULL, NULL, NULL, NULL, 2, '00:20:00', '2024-07-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nutrition`
--
ALTER TABLE `nutrition`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `personal_details`
--
ALTER TABLE `personal_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `workouts`
--
ALTER TABLE `workouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `nutrition`
--
ALTER TABLE `nutrition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_details`
--
ALTER TABLE `personal_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `workouts`
--
ALTER TABLE `workouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nutrition`
--
ALTER TABLE `nutrition`
  ADD CONSTRAINT `nutrition_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `personal_details`
--
ALTER TABLE `personal_details`
  ADD CONSTRAINT `personal_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `workouts`
--
ALTER TABLE `workouts`
  ADD CONSTRAINT `workouts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
