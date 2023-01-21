-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2023 at 02:55 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_project_akbar`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_m_client`
--

CREATE TABLE `tb_m_client` (
  `client_id` int(11) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `client_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_m_client`
--

INSERT INTO `tb_m_client` (`client_id`, `client_name`, `client_address`) VALUES
(1, 'NEC', 'Jakarta'),
(2, 'TAM', 'Jakarta'),
(3, 'TUA', 'Bandung');

-- --------------------------------------------------------

--
-- Table structure for table `tb_m_project`
--

CREATE TABLE `tb_m_project` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `client_id` int(11) NOT NULL,
  `project_start` date NOT NULL,
  `project_end` date NOT NULL,
  `Project_status` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_m_project`
--

INSERT INTO `tb_m_project` (`project_id`, `project_name`, `client_id`, `project_start`, `project_end`, `Project_status`) VALUES
(1, 'WMS', 1, '2022-07-28', '2022-08-28', 'OPEN'),
(2, 'FILMS', 2, '2022-06-01', '2022-08-31', 'DOING'),
(3, 'DOC', 2, '2022-01-01', '2022-04-30', 'DONE'),
(4, 'POS', 3, '2022-05-01', '2022-08-31', 'DOING');

-- --------------------------------------------------------

--
-- Table structure for table `tb_m_users`
--

CREATE TABLE `tb_m_users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_m_users`
--

INSERT INTO `tb_m_users` (`id`, `nama`, `email`, `password`) VALUES
(1, 'tes', 'tes@gmail.com', '12345678');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_m_client`
--
ALTER TABLE `tb_m_client`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `tb_m_project`
--
ALTER TABLE `tb_m_project`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `clientid` (`client_id`);

--
-- Indexes for table `tb_m_users`
--
ALTER TABLE `tb_m_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_m_client`
--
ALTER TABLE `tb_m_client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_m_project`
--
ALTER TABLE `tb_m_project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_m_users`
--
ALTER TABLE `tb_m_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_m_project`
--
ALTER TABLE `tb_m_project`
  ADD CONSTRAINT `clientid` FOREIGN KEY (`client_id`) REFERENCES `tb_m_client` (`client_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
