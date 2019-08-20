-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 15, 2019 at 08:39 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `analisis_sentimen`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_crawling`
--

CREATE TABLE `data_crawling` (
  `id_crawling` int(10) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `tweet_id` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `tweet` mediumtext COLLATE utf8mb4_bin,
  `tgl_tweet` date DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_bin DEFAULT NULL COMMENT '0 = data training, 1 = data testing',
  `proses` enum('0','1') COLLATE utf8mb4_bin DEFAULT NULL COMMENT '0 = belum diproses, 1 = sudah diproses',
  `id_sentimen` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `data_testing`
--

CREATE TABLE `data_testing` (
  `id_testing` int(10) NOT NULL,
  `id_crawling` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_training`
--

CREATE TABLE `data_training` (
  `id_training` int(10) NOT NULL,
  `id_crawling` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hasil`
--

CREATE TABLE `hasil` (
  `id_hasil` int(10) NOT NULL,
  `vmap` varchar(50) DEFAULT NULL,
  `id_sentimen` int(10) DEFAULT NULL,
  `id_testing` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `klasifikasi`
--

CREATE TABLE `klasifikasi` (
  `id_klasifikasi` int(10) NOT NULL,
  `id_testing` int(10) DEFAULT NULL,
  `id_hasil` int(10) DEFAULT NULL,
  `id_sentimen` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `proses`
--

CREATE TABLE `proses` (
  `id_testing` int(10) DEFAULT NULL,
  `id_training` int(10) DEFAULT NULL,
  `kemunculan_kata` varchar(50) DEFAULT NULL,
  `nilai_proses` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sentimen`
--

CREATE TABLE `sentimen` (
  `id_sentimen` int(10) NOT NULL,
  `kategori` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sentimen`
--

INSERT INTO `sentimen` (`id_sentimen`, `kategori`) VALUES
(1, 'Positif'),
(2, 'Negatif'),
(3, 'Netral');

-- --------------------------------------------------------

--
-- Table structure for table `term_frequency`
--

CREATE TABLE `term_frequency` (
  `id_term` int(10) NOT NULL,
  `kata` varchar(50) DEFAULT NULL,
  `id_sentimen` int(10) DEFAULT NULL,
  `jumlah` int(10) DEFAULT NULL,
  `id_training` int(10) DEFAULT NULL,
  `id_testing` int(10) DEFAULT NULL,
  `nilai_bobot` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_crawling`
--
ALTER TABLE `data_crawling`
  ADD PRIMARY KEY (`id_crawling`),
  ADD KEY `kategori` (`id_sentimen`);

--
-- Indexes for table `data_testing`
--
ALTER TABLE `data_testing`
  ADD PRIMARY KEY (`id_testing`),
  ADD KEY `id_crawling` (`id_crawling`);

--
-- Indexes for table `data_training`
--
ALTER TABLE `data_training`
  ADD PRIMARY KEY (`id_training`),
  ADD KEY `id_crawling` (`id_crawling`);

--
-- Indexes for table `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `id_testing` (`id_testing`),
  ADD KEY `kelas` (`id_sentimen`);

--
-- Indexes for table `klasifikasi`
--
ALTER TABLE `klasifikasi`
  ADD PRIMARY KEY (`id_klasifikasi`),
  ADD KEY `id_testing` (`id_testing`),
  ADD KEY `prediksi` (`id_sentimen`),
  ADD KEY `id_hasil` (`id_hasil`);

--
-- Indexes for table `proses`
--
ALTER TABLE `proses`
  ADD KEY `id_testing` (`id_testing`),
  ADD KEY `proses_ibfk_2` (`id_training`);

--
-- Indexes for table `sentimen`
--
ALTER TABLE `sentimen`
  ADD PRIMARY KEY (`id_sentimen`);

--
-- Indexes for table `term_frequency`
--
ALTER TABLE `term_frequency`
  ADD PRIMARY KEY (`id_term`),
  ADD KEY `id_training` (`id_training`),
  ADD KEY `kategori` (`id_sentimen`),
  ADD KEY `id_testing` (`id_testing`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_crawling`
--
ALTER TABLE `data_crawling`
  MODIFY `id_crawling` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8474;

--
-- AUTO_INCREMENT for table `data_testing`
--
ALTER TABLE `data_testing`
  MODIFY `id_testing` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2128;

--
-- AUTO_INCREMENT for table `data_training`
--
ALTER TABLE `data_training`
  MODIFY `id_training` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3646;

--
-- AUTO_INCREMENT for table `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id_hasil` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6382;

--
-- AUTO_INCREMENT for table `klasifikasi`
--
ALTER TABLE `klasifikasi`
  MODIFY `id_klasifikasi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2128;

--
-- AUTO_INCREMENT for table `sentimen`
--
ALTER TABLE `sentimen`
  MODIFY `id_sentimen` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `term_frequency`
--
ALTER TABLE `term_frequency`
  MODIFY `id_term` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37303;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_crawling`
--
ALTER TABLE `data_crawling`
  ADD CONSTRAINT `data_crawling_ibfk_1` FOREIGN KEY (`id_sentimen`) REFERENCES `sentimen` (`id_sentimen`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_testing`
--
ALTER TABLE `data_testing`
  ADD CONSTRAINT `data_testing_ibfk_1` FOREIGN KEY (`id_crawling`) REFERENCES `data_crawling` (`id_crawling`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_training`
--
ALTER TABLE `data_training`
  ADD CONSTRAINT `data_training_ibfk_1` FOREIGN KEY (`id_crawling`) REFERENCES `data_crawling` (`id_crawling`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hasil`
--
ALTER TABLE `hasil`
  ADD CONSTRAINT `hasil_ibfk_1` FOREIGN KEY (`id_testing`) REFERENCES `data_testing` (`id_testing`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hasil_ibfk_2` FOREIGN KEY (`id_sentimen`) REFERENCES `sentimen` (`id_sentimen`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `klasifikasi`
--
ALTER TABLE `klasifikasi`
  ADD CONSTRAINT `klasifikasi_ibfk_1` FOREIGN KEY (`id_testing`) REFERENCES `data_testing` (`id_testing`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `klasifikasi_ibfk_2` FOREIGN KEY (`id_sentimen`) REFERENCES `sentimen` (`id_sentimen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `klasifikasi_ibfk_3` FOREIGN KEY (`id_hasil`) REFERENCES `hasil` (`id_hasil`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `proses`
--
ALTER TABLE `proses`
  ADD CONSTRAINT `proses_ibfk_1` FOREIGN KEY (`id_testing`) REFERENCES `data_testing` (`id_testing`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proses_ibfk_2` FOREIGN KEY (`id_training`) REFERENCES `data_training` (`id_training`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `term_frequency`
--
ALTER TABLE `term_frequency`
  ADD CONSTRAINT `term_frequency_ibfk_1` FOREIGN KEY (`id_training`) REFERENCES `data_training` (`id_training`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `term_frequency_ibfk_3` FOREIGN KEY (`id_sentimen`) REFERENCES `sentimen` (`id_sentimen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `term_frequency_ibfk_4` FOREIGN KEY (`id_testing`) REFERENCES `data_testing` (`id_testing`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
