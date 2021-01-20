-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2021 at 02:51 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_zidan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `email`, `nama_lengkap`, `no_hp`, `alamat`) VALUES
('ADMN.000001', 'admin@gmail.com', 'Admin', '089', 'Panguragan');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` varchar(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
('KTGR.000001', 'Tidak Berkategori'),
('KTGR.000002', 'plastik');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` varchar(11) NOT NULL,
  `id_pembeli` varchar(11) NOT NULL,
  `id_produk` varchar(11) NOT NULL,
  `jumlah` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `id_pembeli`, `id_produk`, `jumlah`) VALUES
('CART.000001', 'PMBL.000001', 'PROD.000003', 1);

-- --------------------------------------------------------

--
-- Table structure for table `komplain`
--

CREATE TABLE `komplain` (
  `id_komplain` varchar(11) NOT NULL,
  `no_invoice` varchar(30) NOT NULL,
  `jenis_komplain` varchar(100) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `bukti_komplain` varchar(255) NOT NULL,
  `id_pembeli` varchar(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `solusi` varchar(100) DEFAULT NULL,
  `keterangan2` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `komplain`
--

INSERT INTO `komplain` (`id_komplain`, `no_invoice`, `jenis_komplain`, `keterangan`, `bukti_komplain`, `id_pembeli`, `status`, `solusi`, `keterangan2`) VALUES
('COMP.000001', 'INV20210118000000008', 'Produk tidak sesuai dengan deskripsi', 'p', '41Permadi Eka Permana-1.png', 'PMBL.000005', 'Selesai', 'Refund Dana', 'refund aja yah');

-- --------------------------------------------------------

--
-- Table structure for table `konfirm_bayar`
--

CREATE TABLE `konfirm_bayar` (
  `no_invoice` varchar(30) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `bank_asal` varchar(30) NOT NULL,
  `nama_pemilik` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `bukti_transfer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `konfirm_bayar`
--

INSERT INTO `konfirm_bayar` (`no_invoice`, `tgl_bayar`, `bank_asal`, `nama_pemilik`, `jumlah`, `bukti_transfer`) VALUES
('INV20201102000000001', '2020-11-02', 'BCA', 'Restu', 37000, '83ttt.jpg'),
('INV20201102000000002', '2020-11-05', 'BCA', 'Restu', 69000, '96p.jpg'),
('INV20201102000000003', '2020-11-05', 'BCA', 'Restu', 37000, '59p.jpg'),
('INV20201104000000004', '2020-11-04', 'BCA', 'abdul kholik', 45, '411.png'),
('INV20201108000000006', '2020-11-08', 'BRI', 'YANDI', 45000, '43akta 4.jpg'),
('INV20210118000000008', '2021-01-20', 'BCA', '1', 5, '99Permadi Eka Permana-1.png');

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE `kota` (
  `id_kota` varchar(11) NOT NULL,
  `nama_kota` varchar(50) NOT NULL,
  `ongkir` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kota`
--

INSERT INTO `kota` (`id_kota`, `nama_kota`, `ongkir`) VALUES
('KOTA.000001', 'Kabupaten Cirebon', '12000'),
('KOTA.000002', 'Kota Cirebon', '12000'),
('KOTA.000003', 'Kabupaten Majalengka', '15000');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `no_invoice` varchar(30) NOT NULL,
  `status_order` varchar(100) NOT NULL,
  `tgl_order` date NOT NULL,
  `total_tagihan` int(15) NOT NULL,
  `jam_order` time NOT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `no_resi` varchar(100) DEFAULT NULL,
  `nama_penerima` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` varchar(250) NOT NULL,
  `id_kota` varchar(11) NOT NULL,
  `pesan` varchar(250) NOT NULL,
  `id_pembeli` varchar(11) NOT NULL,
  `id_penjual` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`no_invoice`, `status_order`, `tgl_order`, `total_tagihan`, `jam_order`, `tgl_bayar`, `no_resi`, `nama_penerima`, `no_hp`, `alamat`, `id_kota`, `pesan`, `id_pembeli`, `id_penjual`) VALUES
('INV20201102000000001', 'Selesai', '2020-11-02', 25000, '15:44:55', '2020-11-02', '1', 'Pembeli', '08944477788', 'Plumbon 21 Kab. Cirebon', 'KOTA.000002', '', 'PMBL.000001', 'PNJL.000002'),
('INV20201102000000002', 'Pesanan Diterima', '2020-11-02', 82000, '16:12:12', '2020-11-05', '3', 'Pembeli', '08944477788', 'Plumbon', 'KOTA.000002', 'jangan pake lama', 'PMBL.000001', 'PNJL.000001'),
('INV20201102000000003', 'Ditolak', '2020-11-02', 82000, '16:12:12', '2020-11-05', NULL, 'Pembeli', '08944477788', 'Plumbon', 'KOTA.000002', 'jangan pake lama', 'PMBL.000001', 'PNJL.000002'),
('INV20201104000000004', 'Pesanan Dikirim', '2020-11-04', 45000, '14:32:17', '2020-11-04', '2', 'abdul kholik', '0897654320', 'ds.panguragan wetan blok v', 'KOTA.000001', 'benar', 'PMBL.000004', 'PNJL.000003'),
('INV20201104000000005', 'Menunggu Pembayaran', '2020-11-04', 45000, '14:33:57', NULL, NULL, 'abdul kholik', '0897654320', 'ds.panguragan wetan blok v', 'KOTA.000001', 'benar', 'PMBL.000004', 'PNJL.000003'),
('INV20201108000000006', 'Pesanan Diproses', '2020-11-08', 45000, '14:59:16', '2020-11-08', NULL, 'Pembeli', '0896445225', 'Plumbon', 'KOTA.000001', '', 'PMBL.000001', 'PNJL.000003'),
('INV20201108000000007', 'Menunggu Pembayaran', '2020-11-08', 45000, '15:08:58', NULL, NULL, 'Pembeli', '0895555343', 'Plumbon', 'KOTA.000003', '', 'PMBL.000001', 'PNJL.000003'),
('INV20210118000000008', 'Komplain Selesai', '2021-01-18', 25000, '07:58:39', '2021-01-20', '00998', 'Permadi Eka Permana', '6289660771166', 'plumbon 99', 'KOTA.000001', '', 'PMBL.000005', 'PNJL.000003');

-- --------------------------------------------------------

--
-- Table structure for table `orders_detail`
--

CREATE TABLE `orders_detail` (
  `no_invoice` varchar(30) NOT NULL,
  `id_produk` varchar(11) NOT NULL,
  `jumlah` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders_detail`
--

INSERT INTO `orders_detail` (`no_invoice`, `id_produk`, `jumlah`) VALUES
('INV20201102000000001', 'PROD.000001', 1),
('INV20201102000000002', 'PROD.000002', 1),
('INV20201102000000002', 'PROD.000001', 1),
('INV20201102000000003', 'PROD.000002', 1),
('INV20201102000000003', 'PROD.000001', 1),
('INV20210118000000008', 'PROD.000003', 1),
('INV20210120000000009', 'PROD.000001', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pembeli`
--

CREATE TABLE `pembeli` (
  `id_pembeli` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `id_keranjang` varchar(11) NOT NULL,
  `id_kota` varchar(11) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembeli`
--

INSERT INTO `pembeli` (`id_pembeli`, `email`, `id_keranjang`, `id_kota`, `nama_lengkap`, `no_hp`, `alamat`) VALUES
('PMBL.000001', 'pembeli@gmail.com', '', '', 'Pembeli', '089', 'Plumbon'),
('PMBL.000002', 'zidan@gmail.com', '', '', 'aufazidan', '089506173030', 'ds.panguragan wetan blok v'),
('PMBL.000003', 'aufazidan@gmail.com', '', '', 'aufazidan', '089506173030', 'ds.panguragan wetan blok v'),
('PMBL.000004', 'kholik@gmail.com', '', '', 'abdul kholik', '0897654320', 'ds.panguragan wetan blok v'),
('PMBL.000005', 'permadiekapermana@gmail.com', '', 'KOTA.000001', 'Permadi Eka Permana', '6289660771166', 'plumbon 99');

-- --------------------------------------------------------

--
-- Table structure for table `penjual`
--

CREATE TABLE `penjual` (
  `id_penjual` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` varchar(250) NOT NULL,
  `nomor_rekening` varchar(30) NOT NULL,
  `nama_toko` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjual`
--

INSERT INTO `penjual` (`id_penjual`, `email`, `nama_lengkap`, `no_hp`, `alamat`, `nomor_rekening`, `nama_toko`) VALUES
('PNJL.000001', 'penjual@gmail.com', 'Penjual', '089', 'Kemlaka', '000', 'Muhidin Store'),
('PNJL.000002', 'Doni22@gmail.com', 'Doni', '087342567999', 'Panguragan Blok V Kec. Panguragan Kab. Cirebon', '123456789', 'Donies'),
('PNJL.000003', 'mufalikha@gmail.com', 'mufalikha', '08985139620', 'ds.panguragan wetan kecamatan panguragan', '1234', 'toko kelapa');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` varchar(11) NOT NULL,
  `id_kategori` varchar(11) NOT NULL,
  `id_penjual` varchar(11) DEFAULT NULL,
  `nama_produk` varchar(100) DEFAULT NULL,
  `harga` int(10) DEFAULT NULL,
  `stok` int(10) DEFAULT NULL,
  `gambar` varchar(250) DEFAULT NULL,
  `keterangan` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `id_penjual`, `nama_produk`, `harga`, `stok`, `gambar`, `keterangan`) VALUES
('PROD.000001', 'KTGR.000002', 'PNJL.000002', 'Ember', 25000, 12, '42aaa.png', 'Ember anti pecah'),
('PROD.000002', 'KTGR.000001', 'PNJL.000001', 'Alumunium', 57000, 5, '36Untitled 1.png', 'Alumunium khusus untuk kanopi'),
('PROD.000003', 'KTGR.000001', 'PNJL.000003', 'Alumunium', 25000, 4, '36Screenshot (14).png', 'alumunium');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(50) NOT NULL,
  `password` varchar(35) NOT NULL,
  `hak_akses` varchar(10) NOT NULL,
  `aktif` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `password`, `hak_akses`, `aktif`) VALUES
('admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'Admin', '1'),
('aufazidan@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', 'Pembeli', '1'),
('Doni22@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Penjual', '1'),
('kholik@gmail.com', '508df4cb2f4d8f80519256258cfb975f', 'Pembeli', '1'),
('mufalikha@gmail.com', '48c7be1154efa6bedf27e6e9d55d1104', 'Penjual', '1'),
('pembeli@gmail.com', 'a9f8bbb8cb84375f241ce3b9da6219a1', 'Pembeli', '1'),
('penjual@gmail.com', '08634230004f9098ef63bfabef63a407', 'Penjual', '1'),
('permadiekapermana@gmail.com', 'b69d343badb19f8e0311aa62b844a06c', 'Pembeli', '1'),
('zidan@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Pembeli', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_pembeli` (`id_pembeli`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `komplain`
--
ALTER TABLE `komplain`
  ADD PRIMARY KEY (`id_komplain`),
  ADD KEY `no_invoice` (`no_invoice`),
  ADD KEY `id_pembeli` (`id_pembeli`);

--
-- Indexes for table `konfirm_bayar`
--
ALTER TABLE `konfirm_bayar`
  ADD KEY `no_invoice` (`no_invoice`);

--
-- Indexes for table `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id_kota`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`no_invoice`),
  ADD KEY `id_kota` (`id_kota`),
  ADD KEY `id_pembeli` (`id_pembeli`),
  ADD KEY `id_penjual` (`id_penjual`);

--
-- Indexes for table `orders_detail`
--
ALTER TABLE `orders_detail`
  ADD KEY `no_invoice` (`no_invoice`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `pembeli`
--
ALTER TABLE `pembeli`
  ADD PRIMARY KEY (`id_pembeli`),
  ADD KEY `email` (`email`),
  ADD KEY `id_keranjang` (`id_keranjang`),
  ADD KEY `id_kota` (`id_kota`);

--
-- Indexes for table `penjual`
--
ALTER TABLE `penjual`
  ADD PRIMARY KEY (`id_penjual`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_penjual` (`id_penjual`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`);

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`),
  ADD CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`id_pembeli`) REFERENCES `pembeli` (`id_pembeli`);

--
-- Constraints for table `konfirm_bayar`
--
ALTER TABLE `konfirm_bayar`
  ADD CONSTRAINT `konfirm_bayar_ibfk_1` FOREIGN KEY (`no_invoice`) REFERENCES `orders` (`no_invoice`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_pembeli`) REFERENCES `pembeli` (`id_pembeli`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`id_kota`) REFERENCES `kota` (`id_kota`);

--
-- Constraints for table `orders_detail`
--
ALTER TABLE `orders_detail`
  ADD CONSTRAINT `orders_detail_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`id_penjual`) REFERENCES `penjual` (`id_penjual`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
