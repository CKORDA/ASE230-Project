-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2024 at 05:03 AM
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
-- Database: `triptinder`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `Username`, `Email`, `Password`) VALUES
(1, 'admin1', 'admin1@example.com', 'password_hash1'),
(2, 'admin2', 'admin2@example.com', 'password_hash2'),
(3, 'admin3', 'admin3@example.com', 'password_hash3');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `BookingID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `VacationID` int(11) NOT NULL,
  `DateBooked` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`BookingID`, `UserID`, `VacationID`, `DateBooked`) VALUES
(1, 1, 1, '2024-11-17 10:00:00'),
(2, 2, 2, '2024-11-17 12:30:00'),
(3, 3, 3, '2024-11-17 14:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Preferences` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`Preferences`)),
  `Role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Email`, `Password`, `DateOfBirth`, `Preferences`, `Role`) VALUES
(1, 'user1', 'user1@example.com', 'user1password', '1990-01-01', '{\"destination\": \"Paris\", \"category\": \"Adventure\"}', 'user'),
(2, 'user2', 'user2@example.com', 'user2password', '1985-06-15', '{\"destination\": \"Tokyo\", \"category\": \"Relaxation\"}', 'user'),
(3, 'user3', 'user3@example.com', 'user3password', '2000-03-22', '{\"destination\": \"New York\", \"category\": \"Cultural\"}', 'user'),
(7, 'signater1', 'rsignate8@gmail.com', '$2y$10$NfSFinsuv/9oaKaS7yAiNOQGWq4tDwL7.FDRmpWXTRsD5L9qxzKI6', NULL, NULL, 'user'),
(8, 'signater1', 'signater1@nku.edu', '$2y$10$FKmRCKrpoeGd.8YmRKV2nOUkKEEop4leXMdmpdTmWMqzP8SzMQyPG', NULL, NULL, 'admin'),
(9, 'alpha', 'diallo@gmail.com', '$2y$10$rB7RGaD62dtpLqhbWRDABuz7TT8tVPNgamhjkajTRwiYgj54vsY7.', NULL, NULL, 'admin'),
(11, 'alpha', 'diallo6@gmail.com', '$2y$10$LHp3Df9uMUa70vSRduIZ2.Quf3cwiaoBzJZFbnTGQvf6jKsTdNcli', NULL, NULL, 'admin'),
(12, 'alpha', 'diallo8@gmail.com', '$2y$10$j9LaxGyfrlm9kCqHrAon2euzSSXPn9JsHJMnvVqIqUurPLmWp/Jfy', NULL, NULL, 'user'),
(13, 'alpha', 'adiallo986@gmail.com', '$2y$10$Z7zhh9tKMO/ONVKhyxb9neW6EWozTlOWCZjICOxZee9ZdRPRhhhiS', NULL, NULL, 'user'),
(15, 'rama', 'adiallo8@gmail.com', '$2y$10$D73fXUGFUtV.5wJpSm9KmONzg8rvLzbPWRMN3Es.L09xSZXzwZHdK', NULL, NULL, 'user'),
(16, 'admin1', 'admin1@example.com', 'password_hash1', NULL, NULL, 'admin'),
(17, 'admin2', 'admin2@example.com', 'password_hash2', NULL, NULL, 'admin'),
(18, 'admin3', 'admin3@example.com', 'password_hash3', NULL, NULL, 'admin'),
(19, 'alpha', 'dialloo@gmail.com', '$2y$10$Lv5MInLTf872NWiAOygun.juedsOpUS0Torpy1/VUBIw6ORNx/isW', NULL, NULL, 'user'),
(20, 'alpha', 'adialo@gmail.com', '$2y$10$PbASgWwAeesuOaraczkCieVl1DdDvUuaEOo.a559DgPFK8xkVdA2a', NULL, '{\"destination\":\"Beach\",\"category\":\"Adventure\"}', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `vacation`
--

CREATE TABLE `vacation` (
  `VacationID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Destination` varchar(100) NOT NULL,
  `Itinerary` text DEFAULT NULL,
  `Activities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `AvailableDates` date DEFAULT NULL,
  `Category` varchar(50) DEFAULT NULL,
  `AdminID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vacation`
--

INSERT INTO `vacation` (`VacationID`, `Title`, `Description`, `Price`, `Destination`, `Itinerary`, `Activities`, `AvailableDates`, `Category`, `AdminID`) VALUES
(1, 'Paris Adventure', 'A thrilling trip to Paris with lots of activities.', 1500.00, 'Paris', 'Day 1: Eiffel Tower, Day 2: Louvre Museum', 'Eiffel Tower, Louvre, Seine River Cruise', '2024-12-01', 'Adventure', 1),
(2, 'Relax in Tokyo', 'A peaceful getaway in Tokyo with a focus on relaxation.', 1200.00, 'Tokyo', 'Day 1: Zen Gardens, Day 2: Spa Experience', 'Zen Gardens, Onsen Spa', '2025-01-15', 'Relaxation', 2),
(3, 'Cultural New York', 'Explore the rich culture of New York City.', 1800.00, 'New York', 'Day 1: Broadway Show, Day 2: Central Park', 'Broadway, Central Park, Museums', '2024-11-20', 'Cultural', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `VacationID` (`VacationID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Email_2` (`Email`),
  ADD UNIQUE KEY `Email_3` (`Email`);

--
-- Indexes for table `vacation`
--
ALTER TABLE `vacation`
  ADD PRIMARY KEY (`VacationID`),
  ADD KEY `AdminID` (`AdminID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vacation`
--
ALTER TABLE `vacation`
  MODIFY `VacationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`VacationID`) REFERENCES `vacation` (`VacationID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vacation`
--
ALTER TABLE `vacation`
  ADD CONSTRAINT `vacation_ibfk_1` FOREIGN KEY (`AdminID`) REFERENCES `admin` (`AdminID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
