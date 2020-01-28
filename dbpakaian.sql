-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2020 at 03:53 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbpakaian`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `barcode` varchar(15) NOT NULL,
  `namabrg` varchar(50) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `id_tipe` int(11) NOT NULL,
  `id_sup` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `hpp` int(11) NOT NULL,
  `hjual` int(11) NOT NULL,
  `grosir` int(11) NOT NULL,
  `partai` int(11) NOT NULL,
  `tgl` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bazar`
--

CREATE TABLE `bazar` (
  `id` int(11) NOT NULL,
  `nama_bazar` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `tgl` date NOT NULL,
  `potongan` int(11) NOT NULL DEFAULT '0',
  `is_aktif` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1: aktif, 0 tidak aktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `id` int(11) NOT NULL,
  `nama_jenis` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `keluar_bazar`
--

CREATE TABLE `keluar_bazar` (
  `id` int(11) NOT NULL,
  `id_bazar` int(11) NOT NULL,
  `date` date NOT NULL,
  `barcode` varchar(15) NOT NULL,
  `jml` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_bazar`
--

CREATE TABLE `penjualan_bazar` (
  `id` int(11) NOT NULL,
  `id_bazar` int(11) NOT NULL,
  `tgl` int(11) NOT NULL,
  `barcode` varchar(15) NOT NULL,
  `hpp` int(11) NOT NULL,
  `hjual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff_bazar`
--

CREATE TABLE `staff_bazar` (
  `id_bazar` int(11) NOT NULL,
  `username` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `telp` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tipe`
--

CREATE TABLE `tipe` (
  `id` int(11) NOT NULL,
  `nama_tipe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `telp` varchar(20) NOT NULL,
  `role` enum('Pegawai','Admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`barcode`),
  ADD KEY `id_jenis` (`id_jenis`),
  ADD KEY `id_tipe` (`id_tipe`),
  ADD KEY `id_sup` (`id_sup`);

--
-- Indexes for table `bazar`
--
ALTER TABLE `bazar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keluar_bazar`
--
ALTER TABLE `keluar_bazar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan_bazar`
--
ALTER TABLE `penjualan_bazar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bazar` (`id_bazar`),
  ADD KEY `barcode` (`barcode`);

--
-- Indexes for table `staff_bazar`
--
ALTER TABLE `staff_bazar`
  ADD KEY `username` (`username`),
  ADD KEY `id_bazar` (`id_bazar`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipe`
--
ALTER TABLE `tipe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bazar`
--
ALTER TABLE `bazar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `keluar_bazar`
--
ALTER TABLE `keluar_bazar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `penjualan_bazar`
--
ALTER TABLE `penjualan_bazar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tipe`
--
ALTER TABLE `tipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`id_jenis`) REFERENCES `jenis` (`id`),
  ADD CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`id_tipe`) REFERENCES `tipe` (`id`),
  ADD CONSTRAINT `barang_masuk_ibfk_3` FOREIGN KEY (`id_sup`) REFERENCES `supplier` (`id`);

--
-- Constraints for table `penjualan_bazar`
--
ALTER TABLE `penjualan_bazar`
  ADD CONSTRAINT `penjualan_bazar_ibfk_1` FOREIGN KEY (`id_bazar`) REFERENCES `bazar` (`id`),
  ADD CONSTRAINT `penjualan_bazar_ibfk_3` FOREIGN KEY (`barcode`) REFERENCES `barang_   masuk` (`barcode`);

--
-- Constraints for table `staff_bazar`
--
ALTER TABLE `staff_bazar`
  ADD CONSTRAINT `staff_bazar_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `staff_bazar_ibfk_2` FOREIGN KEY (`id_bazar`) REFERENCES `bazar` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
