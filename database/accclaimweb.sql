-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 19, 2022 at 01:56 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accclaimweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `Incidents`
--

CREATE TABLE `Incidents` (
  `incident_id` int(11) NOT NULL,
  `driver_licence` varchar(15) NOT NULL,
  `driver_name` varchar(40) NOT NULL,
  `vehicle_number` varchar(15) NOT NULL,
  `cause_of_accident` varchar(40) NOT NULL,
  `incident_province` varchar(30) NOT NULL,
  `incident_city` varchar(30) NOT NULL,
  `address_nearby` varchar(80) NOT NULL,
  `landmarks_nearby` varchar(80) NOT NULL,
  `incident_date` date NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `user_id` int(11) NOT NULL,
  `entry_datetime` datetime NOT NULL,
  `rda_status` varchar(30) NOT NULL DEFAULT 'Processing',
  `police_status` varchar(30) NOT NULL DEFAULT 'Processing',
  `insurance_status` varchar(30) NOT NULL DEFAULT 'Processing',
  `proof_image1` varchar(40) NOT NULL,
  `proof_image2` varchar(40) NOT NULL,
  `proof_image3` varchar(40) DEFAULT NULL,
  `proof_image4` varchar(40) DEFAULT NULL,
  `proof_image5` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `fname` varchar(40) NOT NULL,
  `lname` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `nic` varchar(15) NOT NULL,
  `pwd` varchar(40) NOT NULL,
  `role` varchar(15) NOT NULL DEFAULT 'user',
  `regdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `fname`, `lname`, `email`, `mobile`, `dob`, `nic`, `pwd`, `role`, `regdate`) VALUES
(1, 'John', 'Doe', 'admin@gmail.com', '0777123456', '2022-05-06', '200012345678', '5f4dcc3b5aa765d61d8327deb882cf99', 'super_admin', '2022-05-19 13:55:41');

-- --------------------------------------------------------

--
-- Table structure for table `Vehicles`
--

CREATE TABLE `Vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `vehicle_registration` varchar(40) NOT NULL,
  `chassis_number` varchar(30) NOT NULL,
  `registered_province` varchar(20) NOT NULL,
  `vehicle_type` varchar(20) NOT NULL,
  `insurance_registration` varchar(30) NOT NULL,
  `insurance_expiry_date` date NOT NULL,
  `insurance_provider` varchar(40) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Incidents`
--
ALTER TABLE `Incidents`
  ADD PRIMARY KEY (`incident_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nic` (`nic`);

--
-- Indexes for table `Vehicles`
--
ALTER TABLE `Vehicles`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Incidents`
--
ALTER TABLE `Incidents`
  MODIFY `incident_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Vehicles`
--
ALTER TABLE `Vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
