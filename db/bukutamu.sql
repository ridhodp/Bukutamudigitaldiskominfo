-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bukutamu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_instansi`
--

CREATE TABLE `tb_instansi` (
  `no` int(5) NOT NULL,
  `tanggal` date NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_instansi`
--

INSERT INTO `tb_instansi` (`no`, `tanggal`, `nama`, `alamat`) VALUES
(4, '2025-10-19', 'Karno', '0812345678910'),
(5, '2025-10-19', 'Pak Parul', '0812345678910'),
(6, '2025-10-20', 'Pak Amri', '0812345678910');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_tamu`
--

CREATE TABLE `tb_tamu` (
  `id` int(5) NOT NULL,
  `tanggal` date NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `instansi` varchar(50) NOT NULL,
  `tujuan` varchar(100) NOT NULL,
  `perihal` varchar(50) NOT NULL,
  `bidang` varchar(100) NOT NULL,
  `bukti` varchar(100) DEFAULT NULL,
  `foto_profil` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_tamu`
--

INSERT INTO `tb_tamu` (`id`, `tanggal`, `nama`, `alamat`, `instansi`, `tujuan`, `perihal`, `bidang`) VALUES
(14, '2025-10-19', 'Pak Parul', '0812345678910', 'Diskominfo Bid Staper', 'Konsultasi TTE', '', 'Bidang Statistik & Persandian'),
(15, '2025-10-20', 'Pak Amri', '0812345678910', 'Kepsi persandian', 'Konsultasi TTE', '', 'Bidang Statistik & Persandian');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `username` varchar(25) NOT NULL,
  `paswd` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `level` int(1) NOT NULL,
  `ket` varchar(50) NOT NULL,
  `last_activity` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `foto_profil` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`username`, `paswd`, `email`, `nama`, `level`, `ket`, `foto_profil`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'adminstaper@gmail.com', 'Admin Staper', 1, 'Staff Staper', 'uploads/1760579530_mrridho.jpeg'),
('adminbktamu', '7488e331b8b64e5794da3fa4eb10ad5d', '2200018201@webmail.uad.ac.id', 'adminbktamu', 1, 'Staff Staper', NULL),
('adminbktm1', '7488e331b8b64e5794da3fa4eb10ad5d', 'adminbukutamu@gmail.com', 'adminbktm1', 1, 'Staff Staper', NULL),
('adminstaper1', '7488e331b8b64e5794da3fa4eb10ad5d', 'ridhopakpahan@gmail.com', 'adminstaper1', 1, 'Staff Staper', NULL),
('Hadiadmin', '1c3a6a97a81f0b5123d9925776724f34', 'hadiadmin@gmail.com', 'Hadi Khairullah', 1, 'Staff staper', 'uploads/1760877633_SWOT KWU.png');

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_instansi`
--
ALTER TABLE `tb_instansi`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `tb_tamu`
--
ALTER TABLE `tb_tamu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

-- --------------------------------------------------------

--
-- AUTO_INCREMENT untuk tabel yang dibuang (sudah diperbaiki)
--

--
-- AUTO_INCREMENT untuk tabel `tb_instansi`
--
ALTER TABLE `tb_instansi`
  MODIFY `no` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_tamu`
--
ALTER TABLE `tb_tamu`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
