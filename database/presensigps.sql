-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 10 Des 2023 pada 15.31
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presensigps`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisi`
--

CREATE TABLE `divisi` (
  `kode_divisi` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_divisi` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `divisi`
--

INSERT INTO `divisi` (`kode_divisi`, `nama_divisi`) VALUES
('bali', 'Bali'),
('bengkulu', 'bengkulu'),
('jabodetabek', 'jabodetabek'),
('jawa_barat', 'jawa barat'),
('jawa_tengah', 'jawa tengah'),
('jawa_timur', 'jawa timur'),
('papua', 'papua'),
('Sumatera_Selatan', 'Sumatera Selatan'),
('sumatra_barat', 'sumatra barat'),
('sumatra_utara', 'sumatra utara');

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `nik` char(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jabatan` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(13) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kode_divisi` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`nik`, `nama_lengkap`, `jabatan`, `no_hp`, `password`, `remember_token`, `foto`, `kode_divisi`) VALUES
('12345', 'zaki12345', 'driver', '08123456789', '$2y$10$VUtpSPpcuq8n/NfsiPBsgu9yQ8r3Ab1dL9qtVV1dHXGXyIzTtF34G', NULL, '12345.png', 'jawa_barat'),
('6789', 'latip', 'driver', '08987654321', '$2y$10$VUtpSPpcuq8n/NfsiPBsgu9yQ8r3Ab1dL9qtVV1dHXGXyIzTtF34G', NULL, NULL, 'jawa_timur'),
('1969', 'ibnu', 'manager', '08765682', '$2y$10$lq556cKsSEoQLlJq3G67J.U2wscQ69FJbT6W6stWrvnw7dzMEctT.', NULL, NULL, 'jabodetabek'),
('1999', 'novia', 'mitra', '08777777', '$2y$10$BmujTM6sYdlrf4gCJKl2R.qq9Md9Nl0BwQSBO2.4HoDjNhnJkPviq', NULL, '1999.png', 'jabodetabek'),
('1111', 'citra', 'IT', '08643726', '$2y$10$L4HngmaN2/O4N8U2TOnT4uXe6EQkDwGQMxuo3PYyG.EiiAVfp9tQ2', NULL, '1111.jpeg', 'jabodetabek'),
('2222', 'Toni', 'IT', '081242322', '$2y$10$nwamOPqahk2vdZyiLTgMRO3Do7hu1xdE2BCfKcqWqnvF28Jod98FW', NULL, '2222.png', 'jabodetabek'),
('0000', 'yafie', 'MANAGER', '08775343', '$2y$10$0o7PoJACnsjUaWtQ7.TNX.R8j7t80fKgjK3Kkwc1XBwUy.IqSDor2', NULL, '0000.jpeg', 'jabodetabek'),
('3333', 'yafie', 'MANAGER', '08123134', '$2y$10$93sRbncSEqulpt3ypFNPsuIKTLU9LExSAZg//q.16T2Pk.sWInsgW', NULL, '3333.jpeg', 'jabodetabek'),
('4444', 'farhan', 'MEDSOS', '083421342', '$2y$10$A2I47gl2z0fxekHQMF2x5OMboSYhky6fok2ZmpLZgv3Z/TB.aScgm', NULL, '4444.jpeg', 'jabodetabek'),
('5555', 'sekar', 'sekretaris', '0867345234', '$2y$10$muIiPDpiB3eoutCkGxpXReYuVGdRkET4.iKZKx40BeyXfaJnxF/h2', NULL, '5555.png', 'jabodetabek');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id` int DEFAULT NULL,
  `nik` char(5) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_presensi` date NOT NULL,
  `jam_in` time NOT NULL,
  `jam_out` time DEFAULT NULL,
  `foto_in` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `foto_out` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lokasi_in` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lokasi_out` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `keterangan_in` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keterangan_out` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id`, `nik`, `tgl_presensi`, `jam_in`, `jam_out`, `foto_in`, `foto_out`, `lokasi_in`, `lokasi_out`, `keterangan_in`, `keterangan_out`) VALUES
(NULL, '12345', '2023-12-04', '10:48:03', '11:01:36', '12345-2023-12-04.jam10-48-03.png', '12345-2023-12-04.jam11-01-36.png', '-6.2801401,107.0121582', '-6.2087634,106.845599', 'tes gp', NULL),
(NULL, '12345', '2023-12-04', '10:50:26', NULL, '12345-2023-12-04.jam10-50-26.png', NULL, '-6.2801401,107.0121525', NULL, '123', NULL),
(NULL, '2000', '2023-12-04', '22:40:55', '22:41:18', '2000-2023-12-04.jam22-40-55.png', '2000-2023-12-04.jam22-41-18.png', '-6.2193349,106.8384576', '-6.2193319,106.8384624', 'asdasdas', 'asdasdas'),
(NULL, '12345', '2023-12-07', '11:09:22', '11:09:35', '12345-2023-12-07.jam11-09-22.png', '12345-2023-12-07.jam11-09-35.png', '-6.2193331,106.8384626', '-6.2193331,106.8384626', 'asdasdas', '123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'zaki', '123@gmail.com', NULL, '$2y$10$VUtpSPpcuq8n/NfsiPBsgu9yQ8r3Ab1dL9qtVV1dHXGXyIzTtF34G', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`kode_divisi`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
