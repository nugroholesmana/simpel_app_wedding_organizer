-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2017 at 01:09 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_datapelanggan`
--

CREATE TABLE IF NOT EXISTS `tbl_datapelanggan` (
`id_pelanggan` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `no_telpon` varchar(15) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `token` varchar(15) NOT NULL,
  `alamat` tinytext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_datapelanggan`
--

INSERT INTO `tbl_datapelanggan` (`id_pelanggan`, `id_user`, `nama_pelanggan`, `jenis_kelamin`, `no_telpon`, `tgl_lahir`, `token`, `alamat`) VALUES
(1, 3, 'eko rujito ', 'Pria', '0827372722', '2017-10-23', 'IgJajk25zyEDJ0o', 'Jln Garuda sakti'),
(2, 4, 'rudi martin', 'Pria', '08526437777', '1990-11-07', 'vUyADyHjelfIvzP', 'Jln Arengka');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_datapesanan`
--

CREATE TABLE IF NOT EXISTS `tbl_datapesanan` (
`id_pesanan` bigint(20) NOT NULL,
  `id_pelanggan` bigint(20) NOT NULL,
  `id_vendor` bigint(20) NOT NULL,
  `jumlah_tamu` int(10) NOT NULL,
  `tgl_resepsi` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_datapesanan`
--

INSERT INTO `tbl_datapesanan` (`id_pesanan`, `id_pelanggan`, `id_vendor`, `jumlah_tamu`, `tgl_resepsi`) VALUES
(8, 1, 1, 50, '2017-10-30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_datapesananpaket`
--

CREATE TABLE IF NOT EXISTS `tbl_datapesananpaket` (
  `id_paket` int(10) NOT NULL,
  `id_pesanan` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_datapesananpaket`
--

INSERT INTO `tbl_datapesananpaket` (`id_paket`, `id_pesanan`) VALUES
(3, 8),
(4, 8),
(1, 8),
(2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_datauser`
--

CREATE TABLE IF NOT EXISTS `tbl_datauser` (
`id_user` bigint(20) NOT NULL,
  `username` varchar(35) NOT NULL,
  `password` varchar(100) NOT NULL,
  `hak_akses` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `aktif` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_datauser`
--

INSERT INTO `tbl_datauser` (`id_user`, `username`, `password`, `hak_akses`, `email`, `aktif`) VALUES
(1, 'admin', '$2y$10$H8KOLJNCF2IUrsekUaHOwOa44VY2fv3SVykeuW7NLj0L4T9vsI/ya', 'admin', 'admin@gmail.com', 1),
(2, 'vendor', '$2y$10$bT/5V89cvIuRGYxDmx2uE.djoFflygYZIszZREWygh5cY2C5wPoAi', 'admin_wo', 'laksamana@gmail.com', 1),
(3, 'pelanggan', '$2y$10$x5M2GjpLw0HPUW/k50jcTeYXGNWFtTkAcQPK7shWhkK900fHjkC8.', 'pelanggan', 'pelanggan2@gmail.com', 1),
(4, 'pelanggan2', '$2y$10$WOhFUL86OllCyehZ.bVdyeOzoAUFa1piv4OzhHsbgojIKwLbUnoky', 'pelanggan', 'pelanggan3@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_galeri`
--

CREATE TABLE IF NOT EXISTS `tbl_galeri` (
`id_galeri` bigint(20) NOT NULL,
  `id_vendor` bigint(20) NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_galeri`
--

INSERT INTO `tbl_galeri` (`id_galeri`, `id_vendor`, `gambar`) VALUES
(1, 1, '1-35.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_paket`
--

CREATE TABLE IF NOT EXISTS `tbl_paket` (
`id_konten` bigint(20) NOT NULL,
  `id_vendor` bigint(20) NOT NULL,
  `nama_konten` varchar(100) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `tipe` tinyint(1) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_paket`
--

INSERT INTO `tbl_paket` (`id_konten`, `id_vendor`, `nama_konten`, `harga`, `tipe`, `foto`, `keterangan`) VALUES
(1, 1, 'Paket Utama 1', 30000000, 1, 'Paket Utama 1-1-98.jpg', '<p>test aja paket utama</p>'),
(2, 1, 'CATERING A', 25000, 2, 'CATERING A-1-93.jpg', '<p>1. Nasi putih</p>\r\n<p>2. Ikan bakar</p>\r\n<p>3. Teh Manis panas</p>\r\n<p>3. Pisang</p>'),
(3, 1, 'Fotografi', 5000000, 3, 'Fotografi-1-38.jpg', '<p>fotografi termasuk video dokumentasi dan cetak ukuran 20 inchi 1&nbsp; pcs</p>'),
(4, 1, 'Organ Tunggal', 2500000, 3, 'Organ Tunggal-1-28.jpg', '<p>Musik dan biduan&nbsp;</p>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pembayaran`
--

CREATE TABLE IF NOT EXISTS `tbl_pembayaran` (
`id_pembayaran` bigint(20) NOT NULL,
  `id_pesanan` bigint(20) NOT NULL,
  `total_pembayaran` bigint(20) NOT NULL,
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pembayaran`
--

INSERT INTO `tbl_pembayaran` (`id_pembayaran`, `id_pesanan`, `total_pembayaran`, `status`) VALUES
(7, 8, 38750000, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendor`
--

CREATE TABLE IF NOT EXISTS `tbl_vendor` (
`id_vendor` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `nama_vendor` varchar(50) NOT NULL,
  `nama_pemilik_vendor` varchar(50) NOT NULL,
  `no_telpon` varchar(15) NOT NULL,
  `no_telp_vendor` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_vendor`
--

INSERT INTO `tbl_vendor` (`id_vendor`, `id_user`, `nama_vendor`, `nama_pemilik_vendor`, `no_telpon`, `no_telp_vendor`, `alamat`) VALUES
(1, 2, 'Laksamana Jaya Riau', 'Johan Su', '08526493822', '07618544', 'Jln Arengka Komplek Bringin indah no 43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_datapelanggan`
--
ALTER TABLE `tbl_datapelanggan`
 ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `tbl_datapesanan`
--
ALTER TABLE `tbl_datapesanan`
 ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `tbl_datauser`
--
ALTER TABLE `tbl_datauser`
 ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tbl_galeri`
--
ALTER TABLE `tbl_galeri`
 ADD PRIMARY KEY (`id_galeri`);

--
-- Indexes for table `tbl_paket`
--
ALTER TABLE `tbl_paket`
 ADD PRIMARY KEY (`id_konten`);

--
-- Indexes for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
 ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `tbl_vendor`
--
ALTER TABLE `tbl_vendor`
 ADD PRIMARY KEY (`id_vendor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_datapelanggan`
--
ALTER TABLE `tbl_datapelanggan`
MODIFY `id_pelanggan` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_datapesanan`
--
ALTER TABLE `tbl_datapesanan`
MODIFY `id_pesanan` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_datauser`
--
ALTER TABLE `tbl_datauser`
MODIFY `id_user` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_galeri`
--
ALTER TABLE `tbl_galeri`
MODIFY `id_galeri` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_paket`
--
ALTER TABLE `tbl_paket`
MODIFY `id_konten` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
MODIFY `id_pembayaran` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_vendor`
--
ALTER TABLE `tbl_vendor`
MODIFY `id_vendor` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
