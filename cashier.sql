-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Nov 2024 pada 07.49
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cashier`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detailpenjualan`
--

CREATE TABLE `detailpenjualan` (
  `id_detail` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah_produk` int(11) DEFAULT NULL,
  `bayar` decimal(10,2) DEFAULT NULL,
  `kembalian` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detailpenjualan`
--

INSERT INTO `detailpenjualan` (`id_detail`, `id_penjualan`, `id_produk`, `jumlah_produk`, `bayar`, `kembalian`, `subtotal`) VALUES
(11, 57, 27, 4, '200000.00', '80000.00', '120000.00'),
(12, 58, 25, 1, NULL, NULL, '23000.00'),
(13, 59, 26, 15, '10000.00', '-665000.00', '675000.00'),
(14, 60, 29, 2, '300000.00', '232000.00', '68000.00'),
(15, 61, 31, 3, '40000000.00', '39400000.00', '600000.00'),
(16, 62, 41, 10, NULL, NULL, '80000.00'),
(17, 63, 41, 3, '60000.00', '36000.00', '24000.00'),
(18, 64, 33, 1, '20000.00', '-480000.00', '500000.00'),
(19, 65, 24, 3, '100000.00', '55000.00', '45000.00'),
(20, 66, 31, 2, '400000.00', '0.00', '400000.00'),
(21, 67, 24, 10000, '99999999.99', '99999999.99', '99999999.99'),
(22, 68, 24, 1, '100000.00', '85000.00', '15000.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(30) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `alamat`, `no_telepon`) VALUES
(12, 'Yoga Mousepad', 'Mars', '90909090'),
(13, 'Iwran Spakbor', 'Sawah Ikopin', '+6287660925534'),
(14, 'Aldi Sapulidi', 'Ntahlah', '82977615008'),
(15, 'Adhit Kayuputih', 'Deket Masjid', '+62576934674'),
(19, 'Dwina Andini', 'Denpasar', '91019181799');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `tanggal_penjualan` date DEFAULT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL,
  `id_pelanggan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `tanggal_penjualan`, `total_harga`, `id_pelanggan`) VALUES
(65, '2024-11-06', '45000.00', 14),
(66, '2024-11-06', '400000.00', 15),
(67, '2024-11-06', '99999999.99', 12),
(68, '2024-11-06', '15000.00', 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(30) DEFAULT NULL,
  `kategori` varchar(30) NOT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `diskon` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `kategori`, `harga`, `stok`, `diskon`) VALUES
(24, 'Sapu Lantai', 'Peralatan', '15000.00', 2, ''),
(25, 'Jam Dinding Bima X', 'Elektronik', '23000.00', 34, ''),
(26, 'Sepatu Warrior', 'Fashion', '45000.00', 497, ''),
(27, 'Baju Merah Putih', 'Fashion', '30000.00', 21, ''),
(29, 'Pel Lantai', 'Peralatan', '34000.00', 58, ''),
(31, 'Headset Gaming', 'Elektronik', '200000.00', 66, ''),
(32, 'Obat Pusing', 'Obat', '35000.00', 25, ''),
(33, 'Tulang Manusia Palsu', 'Peralatan', '500000.00', 50, ''),
(41, 'Marimas', 'Minuman', '8000.00', 87, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Petugas','Pembeli') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(2, 'ahmad', '$2y$10$L5m4Vh9DTMq7EtG1aWkW7e4sqVmyAhnMLR4u1UqeUB1Fq6Jfhix.G', 'Admin'),
(3, 'aldi', '$2y$10$12Q6n0VkH1yLkw17cBuULe6T102/As6C51bAa5jLB2EphaWw.Qu0O', 'Petugas'),
(16, 'unyil', '$2y$10$el/OZixZNgxRF6dN/KNb0Om037503nRmYMKnnICfq487t6R5qom/q', 'Pembeli'),
(17, 'pembeli', '$2y$10$eqYdiyfQ0XGvikYbRSfc4ui.RHfZcoFRG1QzVKLnmiX55SsYeewLK', 'Pembeli'),
(18, 'admin', '$2y$10$CnGBTDnFA64X7ghKuogipezqgE3W17h4yWvAJwgsulGBKWho5.WS6', 'Admin'),
(19, 'petugas', '$2y$10$Pd.sPee/p1gS0.S3fVHqqOReMnbl3Ew4lx1YPER2yBJrWHfEUlccq', 'Petugas'),
(22, 'admin2', '$2y$10$1HBIr1iQMFA8o28Rh7sLIuW49G9npuqTEL1ezbviyUjch9qGi1vSS', 'Pembeli'),
(23, 'miakhalifa', '$2y$10$HJIJvWq/C7hZpx/9eoctUOtYUnW0nK7exauf3fSDfVJh6aTrqHg5.', 'Admin'),
(24, 'yoga', '$2y$10$v9Ot/k28zBuhsTDihw9VxOdJUWMl/5ZshlXT.Ab29sktn09t3bD/q', 'Pembeli'),
(25, 'andin', '$2y$10$l/goaUbLDzXNmme9H9f9Ye6L5htWWbRuNoqRXlEeJaOXfCZjO6x0O', 'Pembeli');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detailpenjualan`
--
ALTER TABLE `detailpenjualan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `fk_penjualan` (`id_penjualan`),
  ADD KEY `fk_produk` (`id_produk`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `fk_pelanggan` (`id_pelanggan`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detailpenjualan`
--
ALTER TABLE `detailpenjualan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
