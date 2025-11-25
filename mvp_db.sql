-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2025 at 02:40 PM
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
-- Database: `mvp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `hasil_balapan`
--

CREATE TABLE `hasil_balapan` (
  `id` int(11) NOT NULL,
  `nama_event` varchar(100) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `id_pembalap` int(11) NOT NULL,
  `posisi_finish` int(11) DEFAULT NULL,
  `poin_didapat` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil_balapan`
--

INSERT INTO `hasil_balapan` (`id`, `nama_event`, `tanggal`, `id_pembalap`, `posisi_finish`, `poin_didapat`) VALUES
(1, 'GP Bahrain', '2024-03-02', 2, 1, 25),
(2, 'GP Bahrain', '2024-03-02', 4, 2, 18),
(3, 'GP Bahrain', '2024-03-02', 5, 2, 15),
(4, 'GP Bahrain', '2024-03-02', 7, 4, 12),
(5, 'GP Bahrain', '2024-03-02', 1, 7, 6),
(6, 'GP Bahrain', '2024-03-02', 10, 8, 2),
(7, 'GP Arab Saudi', '2024-03-09', 2, 1, 25),
(8, 'GP Arab Saudi', '2024-03-09', 4, 2, 18),
(9, 'GP Arab Saudi', '2024-03-09', 7, 3, 15),
(10, 'GP Arab Saudi', '2024-03-09', 8, 8, 4),
(11, 'GP Arab Saudi', '2024-03-09', 1, 9, 2),
(12, 'GP Arab Saudi', '2024-03-09', 3, 15, 0),
(13, 'GP Australia', '2024-03-24', 5, 1, 25),
(14, 'GP Australia', '2024-03-24', 7, 2, 18),
(15, 'GP Australia', '2024-03-24', 8, 3, 15),
(16, 'GP Australia', '2024-03-24', 4, 5, 10),
(17, 'GP Australia', '2024-03-24', 10, 8, 4),
(18, 'GP Australia', '2024-03-24', 2, 0, 0),
(19, 'GP Bandung', '2025-11-05', 5, 4, 32);

-- --------------------------------------------------------

--
-- Table structure for table `pembalap`
--

CREATE TABLE `pembalap` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tim` varchar(255) NOT NULL,
  `negara` varchar(255) NOT NULL,
  `poinMusim` int(11) DEFAULT 0,
  `jumlahMenang` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembalap`
--

INSERT INTO `pembalap` (`id`, `nama`, `tim`, `negara`, `poinMusim`, `jumlahMenang`) VALUES
(1, 'Lewis Hamilton', 'Mercedes', 'United Kingdom', 347, 11),
(2, 'Max Verstappen', 'Red Bull', 'Netherlands', 335, 10),
(3, 'Valtteri Bottas', 'Mercedes', 'Finland', 203, 2),
(4, 'Sergio Perez', 'Red Bull', 'Mexico', 190, 1),
(5, 'Carlos Sainz', 'Ferrari', 'Spain', 150, 0),
(6, 'Daniel Ricciardo', 'McLaren', 'Australia', 115, 1),
(7, 'Charles Leclerc', 'Ferrari', 'Monaco', 95, 0),
(8, 'Lando Norris', 'McLaren', 'United Kingdom', 90, 0),
(9, 'Pierre Gasly', 'AlphaTauri', 'France', 75, 0),
(10, 'Fernando Alonso', 'Alpine', 'Spain', 65, 0),
(15, 'Kim Minjeong', 'aespa', 'South Korea', 342, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hasil_balapan`
--
ALTER TABLE `hasil_balapan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pembalap` (`id_pembalap`);

--
-- Indexes for table `pembalap`
--
ALTER TABLE `pembalap`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hasil_balapan`
--
ALTER TABLE `hasil_balapan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pembalap`
--
ALTER TABLE `pembalap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hasil_balapan`
--
ALTER TABLE `hasil_balapan`
  ADD CONSTRAINT `hasil_balapan_ibfk_1` FOREIGN KEY (`id_pembalap`) REFERENCES `pembalap` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
