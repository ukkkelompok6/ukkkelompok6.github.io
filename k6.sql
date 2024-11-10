-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2024 at 01:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `k6`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_penjualan`
--

CREATE TABLE `tb_detail_penjualan` (
  `DetailID` int(11) NOT NULL,
  `PenjualanID` varchar(11) NOT NULL,
  `ProdukID` int(11) NOT NULL,
  `JumlahProduk` int(11) NOT NULL,
  `SubTotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `PelangganID` int(11) NOT NULL,
  `NamaPelanggan` varchar(255) NOT NULL,
  `Alamat` text NOT NULL,
  `NomorTelepon` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`PelangganID`, `NamaPelanggan`, `Alamat`, `NomorTelepon`) VALUES
(9, 'Aul', 'kadipaten', '081245367287'),
(10, 'edrick', 'kalimantan', '081354678394'),
(11, 'adin', 'genteng', '081238950483'),
(12, 'galih', 'karangsambung', '082378494873'),
(15, 'Neng Fatimah', 'Liangjulang', '089344121234'),
(16, 'Jefrie', 'Putat', '089123654189'),
(17, 'Rahadiansyah', 'Gandu', '087845554429'),
(18, 'Noval', 'Cibaduyut', '087234987435'),
(19, 'Fajar', 'Karayunan', '086156243907'),
(20, 'Siti', 'Sumedang', '083123098647'),
(27, 'none', '-', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tb_penjualan`
--

CREATE TABLE `tb_penjualan` (
  `PenjualanID` varchar(11) NOT NULL,
  `TanggalPenjualan` date NOT NULL,
  `TotalHarga` decimal(10,2) NOT NULL,
  `JumlahPembayaran` decimal(15,2) NOT NULL,
  `Kembalian` decimal(15,2) NOT NULL,
  `PelangganID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `ProdukID` int(11) NOT NULL,
  `NamaProduk` varchar(25) NOT NULL,
  `Harga` decimal(10,2) NOT NULL,
  `Stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_produk`
--

INSERT INTO `tb_produk` (`ProdukID`, `NamaProduk`, `Harga`, `Stok`) VALUES
(7, 'T-shirt SKAONE GD', 100000.00, 80),
(8, 'T-shirt NORTHERN LADS P', 100000.00, 80),
(9, 'T-shirt SKAONE Lotus', 135000.00, 140),
(10, 'T-shirt SKAONE SPEZIAL', 80000.00, 65),
(11, 'T-shirt SKAONE HOURS', 135000.00, 165),
(12, 'Jersey SLC', 150000.00, 120),
(13, 'POLO NORTHERN LADS', 110000.00, 100),
(14, 'KAOS FORCEONE', 100000.00, 100),
(27, 'KAOS FOOTBALL HARDCORE', 100000.00, 90),
(28, 'JERSEY SKAONE FC', 185000.00, 50);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `UserID` int(11) NOT NULL,
  `NamaUser` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`UserID`, `NamaUser`, `username`, `password`, `role`) VALUES
(1, 'barok', 'admin', '202cb962ac59075b964b07152d234b70', 'Admin'),
(11, 'Yudhistira', 'petugas', '202cb962ac59075b964b07152d234b70', 'Petugas'),
(12, 'Alucardy', 'cardi', '202cb962ac59075b964b07152d234b70', 'Petugas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_detail_penjualan`
--
ALTER TABLE `tb_detail_penjualan`
  ADD PRIMARY KEY (`DetailID`);

--
-- Indexes for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`PelangganID`);

--
-- Indexes for table `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
  ADD PRIMARY KEY (`PenjualanID`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`ProdukID`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_detail_penjualan`
--
ALTER TABLE `tb_detail_penjualan`
  MODIFY `DetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  MODIFY `PelangganID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `ProdukID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
