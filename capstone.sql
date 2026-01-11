-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 11 Jan 2026 pada 06.43
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstone`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `baps`
--

CREATE TABLE `baps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `mata_kuliah` varchar(255) NOT NULL,
  `kode_mk` varchar(255) NOT NULL,
  `ruang_ujian` varchar(255) NOT NULL,
  `tahun_ajaran` varchar(255) NOT NULL,
  `hari_ujian` varchar(255) NOT NULL,
  `tanggal_ujian` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `jumlah_peserta` int(11) NOT NULL,
  `jumlah_tidak_hadir` int(11) NOT NULL,
  `catatan_peristiwa` text NOT NULL,
  `pengawas_1` varchar(255) NOT NULL,
  `pengawas_2` varchar(255) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `status` enum('DRAFT','PENDING','APPROVED','REJECTED') DEFAULT 'PENDING',
  `catatan_admin` text DEFAULT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `prodi_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `baps`
--

INSERT INTO `baps` (`id`, `user_id`, `mata_kuliah`, `kode_mk`, `ruang_ujian`, `tahun_ajaran`, `hari_ujian`, `tanggal_ujian`, `waktu_mulai`, `waktu_selesai`, `jumlah_peserta`, `jumlah_tidak_hadir`, `catatan_peristiwa`, `pengawas_1`, `pengawas_2`, `lampiran`, `status`, `catatan_admin`, `verified_by`, `verified_at`, `created_at`, `updated_at`, `prodi_id`) VALUES
(1, 2, 'Algoritma dan Pemrograman', 'INF101', 'Lab Komputer 1', '2025/2026 Ganjil', 'Rabu', '2025-01-15', '08:00:00', '10:00:00', 45, 4, 'asdawd', 'Dr. Ahmad Fauzi, M.Kom', 'Dr. Siti Rahma, M.T', 'lampiran_bap/5YObcYxNtmEEhMLxqgLbAuDLSw5hxRoe4jn9RhOJ.png', 'REJECTED', 'AWD', 1, '2026-01-04 07:06:02', '2026-01-04 07:02:11', '2026-01-04 07:06:02', NULL),
(2, 2, 'Algoritma dan Pemrograman', 'INF101', 'Lab Komputer 1', '2025/2026 Ganjil', 'Rabu', '2025-01-15', '08:00:00', '10:00:00', 4, 4, 'Ujian berjalan dengan lancar. Tidak ada kecurangan atau pelanggaran yang terjadi.', 'Dr. Ahmad Fauzi, M.Kom', 'Dr. Siti Rahma, M.T', 'lampiran_bap/8DPMz4J3a4H6jy8C1Rphybui10OUMonZZE6jIrIQ.png', 'APPROVED', NULL, 1, '2026-01-04 07:05:55', '2026-01-04 07:03:38', '2026-01-04 07:05:55', NULL),
(3, 2, 'Algoritma dan Pemrograman', 'INF101', 'Lab Komputer 1', '2025/2026 Ganjil', 'Rabu', '2025-01-15', '08:00:00', '10:00:00', 45, 5, 'Ujian berjalan dengan lancar. Tidak ada kecurangan atau pelanggaran yang terjadi.', 'Dr. Ahmad Fauzi, M.Kom', 'Dr. Siti Rahma, M.T', 'lampiran_bap/Ai6SRiX1ShSpWBbWDsByxkST4q4ktmZaagqZX8BZ.png', 'REJECTED', 'Upload ulang karena ada kesalahan data', 1, '2026-01-05 23:59:18', '2026-01-04 07:40:02', '2026-01-05 23:59:18', NULL),
(4, 2, 'Algoritma dan Pemrograman', 'INF101', 'Lab Komputer 1', '2025/2026 Ganjil', 'Rabu', '2025-01-15', '08:00:00', '10:00:00', 45, 3, 'Ujian berjalan dengan lancar. Tidak ada kecurangan atau pelanggaran yang terjadi.', 'Dr. Ahmad Fauzi, M.Kom', 'Dr. Siti Rahma, M.T', NULL, 'APPROVED', NULL, 1, '2026-01-04 07:45:38', '2026-01-04 07:40:13', '2026-01-04 07:45:38', NULL),
(5, 2, 'Algoritma dan Pemrograman', 'INF101', 'Lab Komputer 1', '2025/2026 Ganjil', 'Rabu', '2025-01-15', '08:00:00', '10:00:00', 45, 3, 'Ujian berjalan dengan lancar. Tidak ada kecurangan atau pelanggaran yang terjadi.', 'Dr. Ahmad Fauzi, M.Kom', 'Dr. Siti Rahma, M.T', NULL, 'REJECTED', 'aWD', 1, '2026-01-04 08:23:28', '2026-01-04 07:46:43', '2026-01-04 08:23:28', NULL),
(6, 2, 'Algoritma', 'C5123', 'GKU-23', 'Ganjil 2025/2026', 'Senin', '2026-01-04', '08:00:00', '10:00:00', 40, 2, '-AWdAWDAWD', 'Dr. Ahmad Fauzi', 'AWDAWD', 'lampiran_bap/mh2pbfqoMqk46jBii2ox36Lni3RuAYyrAqS5M4BF.png', 'APPROVED', NULL, 1, '2026-01-04 08:18:25', '2026-01-04 08:06:35', '2026-01-04 08:18:25', NULL),
(7, 2, 'COBA NIH', 'SC213', 'GKU2', 'Ganjil 2025/2026', 'Senin', '2026-01-04', '08:00:00', '10:00:00', 23, 1, 'Agnes butuk cangat kecayangan aku', 'Dr. Ahmad Fauzi', 'FIKRI GANTENG', NULL, 'PENDING', NULL, NULL, NULL, '2026-01-04 08:58:51', '2026-01-04 09:00:12', NULL),
(8, 2, 'AWDAWD', 'awd213', 'FGGAD123', 'Ganjil 2025/2026', 'Senin', '2026-01-04', '08:00:00', '10:00:00', 23, 1, '-AWDAWD', 'Dr. Ahmad Fauzi', 'awdawd', 'lampiran_bap/RnsLR2SFkYRXL5yc4BILzEYxSbX7txiH9812zNSQ.png', 'APPROVED', NULL, 1, '2026-01-05 23:59:01', '2026-01-04 09:03:03', '2026-01-05 23:59:01', NULL),
(9, 2, 'AWDADW', 'awd213', 'awda', 'Ganjil 2025/2026', 'Senin', '2026-01-04', '08:00:00', '10:00:00', 23, 1, 'dAWDAWD', 'Dr. Ahmad Fauzi', 'AWDAWD', 'lampiran_bap/esxZ9I1JHN3IwaroxEUXQCdDSFxX2VGZpe0BJdXa.png', 'APPROVED', NULL, 1, '2026-01-05 23:57:14', '2026-01-04 09:07:50', '2026-01-05 23:57:14', 4),
(10, 2, 'Kalibrasi', 'AWD213', 'awda', 'Ganjil 2025/2026', 'Senin', '2026-01-04', '08:00:00', '10:00:00', 23, 1, '-AWDAWD', 'Dr. Ahmad Fauzi', 'ADWADW', 'lampiran_bap/MJveKS7la5Sqrt3xo8epFu65gOI5UnU7QVU8fVzt.png', 'REJECTED', 'AWD', 1, '2026-01-04 09:34:48', '2026-01-04 09:24:40', '2026-01-04 09:34:48', 5),
(11, 4, 'PPI', 'DC21', 'JKI2', 'Ganjil 2025/2026', 'Senin', '2026-01-05', '08:00:00', '10:00:00', 21, 2, '-AD', 'Fikri', 'AWDADW', 'lampiran_bap/deGrTWPafA3Ct2vVD8ZMZZmkl6BHASaRa9K7mXAi.png', 'REJECTED', 'ada data yang tidak valid', 1, '2026-01-05 23:57:10', '2026-01-05 07:17:18', '2026-01-05 23:57:10', 1),
(12, 2, 'Algoritma', 'ASD2', 'awd', 'Ganjil 2025/2026', 'Senin', '2026-01-06', '08:00:00', '10:00:00', 23, 1, '-', 'Dr. Ahmad Fauzi', NULL, 'lampiran_bap/ZsuPBvRzu3CIzSVwwJkYy3KHT7EEnHCfH07ZQnzd.png', 'APPROVED', NULL, 1, '2026-01-05 23:22:42', '2026-01-05 23:21:11', '2026-01-05 23:22:42', 2),
(13, 6, 'Algoritma', 'CS-10', 'TULT', 'Ganjil 2025/2026', 'Senin', '2026-01-06', '10:00:00', '11:00:00', 30, 1, 'tidak hadir satu orang', 'sisil', 'Joharis', 'lampiran_bap/vRGog21QcJWjRKYGLwsAsfxpBfPJxqrAy5GqEtIS.png', 'APPROVED', NULL, 1, '2026-01-06 00:06:24', '2026-01-06 00:04:58', '2026-01-06 00:06:24', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bap_absents`
--

CREATE TABLE `bap_absents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bap_id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bap_absents`
--

INSERT INTO `bap_absents` (`id`, `bap_id`, `nim`, `nama`, `created_at`, `updated_at`) VALUES
(1, 1, '1301210001', 'Ahmad Rizki', '2026-01-04 07:02:11', '2026-01-04 07:02:11'),
(2, 1, '1301210025', 'Siti Nurhaliza', '2026-01-04 07:02:11', '2026-01-04 07:02:11'),
(3, 1, '1301210087', 'Budi Santoso', '2026-01-04 07:02:11', '2026-01-04 07:02:11'),
(4, 1, '123123123', 'Fikri', '2026-01-04 07:02:11', '2026-01-04 07:02:11'),
(5, 2, '1301210001', 'Ahmad Rizki', '2026-01-04 07:03:38', '2026-01-04 07:03:38'),
(6, 2, '1301210025', 'Siti Nurhaliza', '2026-01-04 07:03:38', '2026-01-04 07:03:38'),
(7, 2, '1301210087', 'Budi Santoso', '2026-01-04 07:03:38', '2026-01-04 07:03:38'),
(8, 2, '123', 'Fikri', '2026-01-04 07:03:38', '2026-01-04 07:03:38'),
(9, 3, '1301210001', 'Ahmad Rizki', '2026-01-04 07:40:02', '2026-01-04 07:40:02'),
(10, 3, '1301210025', 'Siti Nurhaliza', '2026-01-04 07:40:02', '2026-01-04 07:40:02'),
(11, 3, '1301210087', 'Budi Santoso', '2026-01-04 07:40:02', '2026-01-04 07:40:02'),
(12, 3, '12312', 'AWED', '2026-01-04 07:40:02', '2026-01-04 07:40:02'),
(13, 3, '123123', 'ADWAWD', '2026-01-04 07:40:02', '2026-01-04 07:40:02'),
(14, 4, '1301210001', 'Ahmad Rizki', '2026-01-04 07:40:13', '2026-01-04 07:40:13'),
(15, 4, '1301210025', 'Siti Nurhaliza', '2026-01-04 07:40:13', '2026-01-04 07:40:13'),
(16, 4, '1301210087', 'Budi Santoso', '2026-01-04 07:40:13', '2026-01-04 07:40:13'),
(17, 5, '1301210001', 'Ahmad Rizki', '2026-01-04 07:46:43', '2026-01-04 07:46:43'),
(18, 5, '1301210025', 'Siti Nurhaliza', '2026-01-04 07:46:43', '2026-01-04 07:46:43'),
(19, 5, '1301210087', 'Budi Santoso', '2026-01-04 07:46:43', '2026-01-04 07:46:43'),
(24, 6, '123123AWD', 'AWDAWD', '2026-01-04 08:07:07', '2026-01-04 08:07:07'),
(25, 6, '12312', 'AWDAWd', '2026-01-04 08:07:07', '2026-01-04 08:07:07'),
(27, 7, '123123', 'Agnes tidak hadir', '2026-01-04 08:59:57', '2026-01-04 08:59:57'),
(31, 8, '123123', 'Agnes butuk', '2026-01-04 09:03:58', '2026-01-04 09:03:58'),
(35, 9, '123123', 'AWDAWd', '2026-01-04 09:11:47', '2026-01-04 09:11:47'),
(37, 10, '123', 'AWD', '2026-01-04 09:24:57', '2026-01-04 09:24:57'),
(40, 11, '12312', 'agnes', '2026-01-05 07:17:44', '2026-01-05 07:17:44'),
(41, 11, '123123', 'jua', '2026-01-05 07:17:44', '2026-01-05 07:17:44'),
(44, 12, '12312', 'adawd', '2026-01-05 23:21:35', '2026-01-05 23:21:35'),
(47, 13, '21123311', 'Agnes D Aulia', '2026-01-06 00:05:40', '2026-01-06 00:05:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bap_seats`
--

CREATE TABLE `bap_seats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bap_id` bigint(20) UNSIGNED NOT NULL,
  `seat_number` int(11) NOT NULL,
  `nim` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bap_seats`
--

INSERT INTO `bap_seats` (`id`, `bap_id`, `seat_number`, `nim`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(2, 1, 3, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(3, 1, 4, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(4, 1, 5, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(5, 1, 6, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(6, 1, 7, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(7, 1, 8, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(8, 1, 9, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(9, 1, 10, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(10, 1, 11, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(11, 1, 12, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(12, 1, 13, '123123123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(13, 1, 14, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(14, 1, 15, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(15, 1, 16, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(16, 1, 17, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(17, 1, 18, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(18, 1, 19, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(19, 1, 20, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(20, 1, 21, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(21, 1, 22, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(22, 1, 23, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(23, 1, 24, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(24, 1, 25, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(25, 1, 26, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(26, 1, 27, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(27, 1, 28, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(28, 1, 29, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(29, 1, 30, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(30, 1, 31, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(31, 1, 32, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(32, 1, 33, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(33, 1, 34, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(34, 1, 35, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(35, 1, 36, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(36, 1, 37, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(37, 1, 38, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(38, 1, 39, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(39, 1, 40, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(40, 1, 41, '123123', '2026-01-04 07:02:58', '2026-01-04 07:02:58'),
(41, 2, 2, '123123', '2026-01-04 07:24:29', '2026-01-04 07:24:29'),
(42, 2, 3, '123123', '2026-01-04 07:24:29', '2026-01-04 07:24:29'),
(43, 2, 4, '123', '2026-01-04 07:24:29', '2026-01-04 07:24:29'),
(44, 4, 2, '123123', '2026-01-04 07:40:21', '2026-01-04 07:40:21'),
(45, 4, 3, '123123', '2026-01-04 07:40:21', '2026-01-04 07:40:21'),
(46, 4, 4, '123123123', '2026-01-04 07:40:21', '2026-01-04 07:40:21'),
(47, 6, 1, '12312', '2026-01-04 08:06:40', '2026-01-04 08:06:40'),
(48, 6, 2, '3123123', '2026-01-04 08:06:40', '2026-01-04 08:06:40'),
(49, 6, 3, '21123123', '2026-01-04 08:06:40', '2026-01-04 08:06:40'),
(50, 7, 1, '123123', '2026-01-04 08:58:59', '2026-01-04 08:58:59'),
(51, 7, 2, '12312312', '2026-01-04 08:58:59', '2026-01-04 08:58:59'),
(52, 7, 3, '312312', '2026-01-04 08:58:59', '2026-01-04 08:58:59'),
(53, 7, 4, '31231231', '2026-01-04 08:58:59', '2026-01-04 08:58:59'),
(54, 7, 5, '31231232', '2026-01-04 08:58:59', '2026-01-04 08:58:59'),
(55, 8, 6, '1231', '2026-01-04 09:03:07', '2026-01-04 09:03:07'),
(56, 8, 7, '231231223', '2026-01-04 09:03:07', '2026-01-04 09:03:07'),
(57, 9, 1, '23423424', '2026-01-04 09:08:02', '2026-01-04 09:08:02'),
(58, 9, 2, '123123', '2026-01-04 09:08:02', '2026-01-04 09:08:02'),
(59, 9, 7, '123123', '2026-01-04 09:08:02', '2026-01-04 09:08:02'),
(60, 9, 12, '123', '2026-01-04 09:08:02', '2026-01-04 09:08:02'),
(61, 10, 1, '123123', '2026-01-04 09:24:45', '2026-01-04 09:24:45'),
(62, 10, 2, '23123', '2026-01-04 09:24:45', '2026-01-04 09:24:45'),
(63, 10, 12, '123213', '2026-01-04 09:24:45', '2026-01-04 09:24:45'),
(64, 11, 1, '123123', '2026-01-05 07:17:26', '2026-01-05 07:17:26'),
(65, 11, 2, '21312', '2026-01-05 07:17:26', '2026-01-05 07:17:26'),
(66, 11, 3, '213', '2026-01-05 07:17:26', '2026-01-05 07:17:26'),
(67, 11, 4, '12312', '2026-01-05 07:17:26', '2026-01-05 07:17:26'),
(68, 11, 5, '123123', '2026-01-05 07:17:26', '2026-01-05 07:17:26'),
(69, 11, 6, '12321', '2026-01-05 07:17:26', '2026-01-05 07:17:26'),
(73, 12, 2, '12312', '2026-01-05 23:21:17', '2026-01-05 23:21:17'),
(74, 12, 6, '123123', '2026-01-05 23:21:17', '2026-01-05 23:21:17'),
(75, 12, 7, '12312312', '2026-01-05 23:21:17', '2026-01-05 23:21:17'),
(76, 13, 1, '12233', '2026-01-06 00:05:16', '2026-01-06 00:05:16'),
(77, 13, 2, '122331', '2026-01-06 00:05:16', '2026-01-06 00:05:16'),
(78, 13, 3, '13123', '2026-01-06 00:05:16', '2026-01-06 00:05:16'),
(79, 13, 4, '13123', '2026-01-06 00:05:16', '2026-01-06 00:05:16'),
(80, 13, 5, '12123', '2026-01-06 00:05:16', '2026-01-06 00:05:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0000_01_01_000000_create_prodis_table', 1),
(2, '0001_01_01_000000_create_users_table', 1),
(3, '0001_01_01_000001_create_cache_table', 1),
(4, '0001_01_01_000002_create_jobs_table', 1),
(5, '2026_01_04_133238_create_baps_table', 1),
(6, '2026_01_04_133239_create_bap_absents_table', 1),
(7, '2026_01_04_133239_create_bap_seats_table', 1),
(8, '2026_01_04_134151_add_force_change_password_to_users_table', 2),
(9, '2026_01_04_145243_modify_status_in_baps_table', 3),
(10, '2026_01_04_155403_add_prodi_to_baps_table', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `prodis`
--

CREATE TABLE `prodis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `prodis`
--

INSERT INTO `prodis` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'S1 Teknik Industri', '2026-01-04 06:36:06', '2026-01-04 06:36:06'),
(2, 'S1 Sistem Informasi', '2026-01-04 06:36:06', '2026-01-04 06:36:06'),
(3, 'S1 Teknik Informatika', '2026-01-04 06:36:06', '2026-01-04 06:36:06'),
(4, 'S1 Teknik Logistik', '2026-01-04 06:36:06', '2026-01-04 06:36:06'),
(5, 'S1 Manajemen Rekayasa', '2026-01-04 06:36:06', '2026-01-04 06:36:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5gjB3E1ueM9BwnDGt2KeifYA8uzNeGyIRnFOSvJe', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSkpMWmlieGtyUlo2d0JRVHkyNjlZS0NWbGlHeEVPN0F5SDZBZ0RjRSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sYWEvcmVrYXAvZXhwb3J0P2plbmlzPWRldGFpbCZwcm9kaV9pZD0xJnR5cGU9cGRmIjtzOjU6InJvdXRlIjtzOjE2OiJsYWEucmVrYXAuZXhwb3J0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1767683240),
('86Nttg9OIQ5saaBc30Lo6KYFKbB6jQFOVRxshyt7', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoia0h2QzhlbmZ5bVE2dTBMMnlHRHM4b1BydmtEMktONFBvbWIyYW1aSCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767682430),
('eiJ5VM3zdJ3yFssXf7gt5oSsAAT6PqavD2IJRW12', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidkhiVEp2YW9LcGRIeThFNURCYXFyRU00U2RQNDNLSGh1ZnlEUXNhQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMDoibG9naW4ucGFnZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1767681724),
('m8tdBql63bjWubW0BL351GGOWIuuOcygTe7zm42H', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ2p1VGFaUTB2aUY3RWM5RXlBcWVRNVkxSzFIMzdJWDFDV3piM2l2RCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMDoibG9naW4ucGFnZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1767682430),
('xg86DqzlTIVRZsgxNQoIVAZaYEfR5CQDFFNzprj7', 2, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTkd2ZEd5Tm1mOVVkZk5JNWlrWk1CWDNPYmVzc2x4STdXMTZLMXZMOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMDoibG9naW4ucGFnZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1767682965);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `force_change_password` tinyint(1) NOT NULL DEFAULT 0,
  `role` enum('LAA','PENGAWAS') NOT NULL DEFAULT 'PENGAWAS',
  `status` enum('AKTIF','NONAKTIF') NOT NULL DEFAULT 'AKTIF',
  `prodi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `nip`, `email`, `email_verified_at`, `password`, `force_change_password`, `role`, `status`, `prodi_id`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin LAA', '12345678', 'admin@telu.ac.id', NULL, '$2y$12$WFv6SmEhBWwN0SXDDrrDUOSRCZGq0SHqoGT2Fo8Gy6tOPazVvzOHi', 0, 'LAA', 'AKTIF', NULL, NULL, NULL, '2026-01-04 06:36:07', '2026-01-04 06:36:07'),
(2, 'Dr. Ahmad Fauzi', '1301210001', 'ahmad@telu.ac.id', NULL, '$2y$12$2hcNnaqWjHs6Zw3yEC.O4.t518NfULxhxsZ76mrBpj6f.UtWtlace', 0, 'PENGAWAS', 'AKTIF', 1, NULL, NULL, '2026-01-04 06:36:07', '2026-01-05 23:20:01'),
(3, 'AWd', '19822', 'ad@telu.ac.id', NULL, '$2y$12$2L5QRjl3eD7pRq1/jse8N.P/5Wy37xl8V/CvfAZ8fpkVOBRrAvfQy', 0, 'PENGAWAS', 'AKTIF', 1, NULL, NULL, '2026-01-04 06:53:33', '2026-01-04 07:29:33'),
(4, 'Fikri', '12345', 'fikri@telu.ac.id', NULL, '$2y$12$IwiY7dR/4zZTdJfvp2AnY.PZzcp2sISZ5q3EYwiiLYInk.sPoFyaq', 0, 'PENGAWAS', 'AKTIF', 1, NULL, NULL, '2026-01-04 07:30:15', '2026-01-05 07:16:34'),
(5, 'Agnes Aulia', '1223345', 'agnes@gmail.com', NULL, '$2y$12$GTksJexePsdv8xzP8ul68ut7LtWJqlNWpnxBj/GCQezmTL.d1AHBG', 0, 'PENGAWAS', 'AKTIF', 1, NULL, NULL, '2026-01-05 23:55:39', '2026-01-06 00:01:21'),
(6, 'sisil', '1332323', 'sisil@gmail.com', NULL, '$2y$12$bx5nPvMpjOc4QL01Py7vFeipgyFs7Sd9f4tFITpWwxp14KEiMl232', 0, 'PENGAWAS', 'AKTIF', 2, NULL, NULL, '2026-01-06 00:01:02', '2026-01-06 00:01:37');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `baps`
--
ALTER TABLE `baps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `baps_user_id_foreign` (`user_id`),
  ADD KEY `baps_verified_by_foreign` (`verified_by`),
  ADD KEY `baps_prodi_id_foreign` (`prodi_id`);

--
-- Indeks untuk tabel `bap_absents`
--
ALTER TABLE `bap_absents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bap_absents_bap_id_foreign` (`bap_id`);

--
-- Indeks untuk tabel `bap_seats`
--
ALTER TABLE `bap_seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bap_seats_bap_id_foreign` (`bap_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `prodis`
--
ALTER TABLE `prodis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nip_unique` (`nip`),
  ADD KEY `users_prodi_id_foreign` (`prodi_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `baps`
--
ALTER TABLE `baps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `bap_absents`
--
ALTER TABLE `bap_absents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT untuk tabel `bap_seats`
--
ALTER TABLE `bap_seats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `prodis`
--
ALTER TABLE `prodis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `baps`
--
ALTER TABLE `baps`
  ADD CONSTRAINT `baps_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodis` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `baps_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `baps_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `bap_absents`
--
ALTER TABLE `bap_absents`
  ADD CONSTRAINT `bap_absents_bap_id_foreign` FOREIGN KEY (`bap_id`) REFERENCES `baps` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `bap_seats`
--
ALTER TABLE `bap_seats`
  ADD CONSTRAINT `bap_seats_bap_id_foreign` FOREIGN KEY (`bap_id`) REFERENCES `baps` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodis` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
