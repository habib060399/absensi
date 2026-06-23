-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jun 2026 pada 10.42
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `absensi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_siswa` varchar(32) NOT NULL,
  `tanggal` varchar(255) DEFAULT NULL,
  `waktu` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `broadcast`
--

CREATE TABLE `broadcast` (
  `id` bigint(20) NOT NULL,
  `wa_group` text DEFAULT NULL,
  `template_bc` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `token_account_wa` varchar(255) DEFAULT NULL,
  `token_api_wa` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `broadcast`
--

INSERT INTO `broadcast` (`id`, `wa_group`, `template_bc`, `token_account_wa`, `token_api_wa`, `created_at`, `updated_at`) VALUES
(1, '', '{\"data\":[{\"title\":\"hadir\",\"message\":\"Salam\\r\\n\\r\\nBapak\\/Ibu Orangtua siswa\\r\\n\\r\\n{nama} Telah hadir di sekolah SMK PAB 12 SAENTIS\\r\\n\\r\\n==============================\\r\\n\\r\\nNote : Pesan ini adalah pesan sistem tidak perlu membalas pesan ini\"},{\"title\":\"sakit\",\"message\":null},{\"title\":\"absen\",\"message\":null},{\"title\":\"izin\",\"message\":null}]}', NULL, NULL, '2026-03-28 00:43:53', '2026-03-31 11:29:11'),
(280326100206, NULL, '{\"data\":[{\"title\":\"hadir\",\"message\":null},{\"title\":\"sakit\",\"message\":null},{\"title\":\"absen\",\"message\":null},{\"title\":\"izin\",\"message\":null}]}', NULL, NULL, '2026-03-28 03:02:06', '2026-03-28 03:02:06');

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
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_sekolah` bigint(20) NOT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `id_jurusan` text DEFAULT NULL,
  `id_kelas` text NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_wa` varchar(20) NOT NULL,
  `foto` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoice`
--

CREATE TABLE `invoice` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `serial_number` varchar(100) NOT NULL,
  `id_paket` varchar(100) NOT NULL,
  `id_sekolah` varchar(100) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `jml_siswa` varchar(100) NOT NULL,
  `kuantiti` varchar(100) NOT NULL,
  `harga` varchar(100) NOT NULL,
  `total` varchar(100) NOT NULL,
  `paket_detail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`paket_detail`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `invoice`
--

INSERT INTO `invoice` (`id`, `serial_number`, `id_paket`, `id_sekolah`, `nama_paket`, `jml_siswa`, `kuantiti`, `harga`, `total`, `paket_detail`, `created_at`, `updated_at`) VALUES
(1, 'INV-0000001', '1', '280326100206', 'A', '100', '1', '3000', '300000', '{\"data\":[{\"text\":\"notifikasi Whatsapp\",\"status\": \"active\"},{\"text\":\"10.000 pesan/bulan\",\"status\":\"active\"},{\"text\":\"kirim pesan whatsapp\",\"status\":\"inactive\"},{\"text\":\"sms\",\"status\":\"inactive\"},{\"text\":\"support mesin absen\",\"status\":\"inactive\"},{\"text\":\"support mobile app\",\"status\":\"inactive\"}]}', '2026-03-28 03:02:06', '2026-03-28 03:02:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_sekolah` varchar(255) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id` bigint(20) NOT NULL,
  `id_sekolah` bigint(20) NOT NULL,
  `nama_jurusan` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id`, `id_sekolah`, `nama_jurusan`, `created_at`, `updated_at`) VALUES
(8900, 112233, 'Teknik Komputer Jaringan', '2026-03-28 00:43:53', '2026-03-28 00:43:53'),
(89000, 112233, 'Teknik Kendaraan Ringan', '2026-03-28 00:43:53', '2026-03-28 00:43:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `id_sekolah` varchar(100) NOT NULL,
  `id_jurusan` bigint(20) DEFAULT NULL,
  `kelas` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `id_user`, `id_sekolah`, `id_jurusan`, `kelas`, `created_at`, `updated_at`) VALUES
(1, 2, '112233', 8900, 'X', NULL, NULL),
(2, 3, '112233', 89000, 'XI', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mesin`
--

CREATE TABLE `mesin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_mesin` varchar(17) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Not Used',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mesin`
--

INSERT INTO `mesin` (`id`, `id_mesin`, `status`, `created_at`, `updated_at`) VALUES
(1, '12345ff', 'Used', '2026-03-28 00:43:53', '2026-03-28 00:43:53'),
(2, 'NQZ2aKE6IrwTwNld', 'Used', '2026-03-28 00:45:05', '2026-03-28 03:02:07');

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
(1, '0000_00_00_000000_create_websockets_statistics_entries_table', 1),
(2, '2014_10_12_000000_create_broadcast_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(5, '2014_12_10_000000_create_sekolah_tables', 1),
(6, '2014_12_11_000000_create_jurusan_tables', 1),
(7, '2014_12_12_000000_create_kelas_tables', 1),
(8, '2014_12_13_000000_create_gurus_table', 1),
(9, '2019_02_17_000002_create_siswa_tables', 1),
(10, '2019_08_19_000000_create_failed_jobs_table', 1),
(11, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(12, '2023_11_29_203930_create_absensi_table', 1),
(13, '2024_02_16_224754_create_permission_tables', 1),
(14, '2024_02_17_091715_create_mesin_tables', 1),
(15, '2024_10_18_202141_create_jabatans_table', 1),
(16, '2024_12_03_181939_create_paket_table', 1),
(17, '2024_12_08_162701_create_invoice_table', 1),
(18, '2025_01_23_205041_create_report_tables', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 0),
(2, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 280326100206),
(3, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket`
--

CREATE TABLE `paket` (
  `id` bigint(20) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `siswa` varchar(100) NOT NULL,
  `active` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `detail` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `paket`
--

INSERT INTO `paket` (`id`, `type`, `nama_paket`, `siswa`, `active`, `price`, `detail`, `created_at`, `updated_at`) VALUES
(1, 'unit', 'A', '1', '1', '3000', '{\"data\":[{\"text\":\"notifikasi Whatsapp\",\"status\": \"active\"},{\"text\":\"10.000 pesan/bulan\",\"status\":\"active\"},{\"text\":\"kirim pesan whatsapp\",\"status\":\"inactive\"},{\"text\":\"sms\",\"status\":\"inactive\"},{\"text\":\"support mesin absen\",\"status\":\"inactive\"},{\"text\":\"support mobile app\",\"status\":\"inactive\"}]}', '2026-03-28 00:43:54', '2026-03-28 00:43:54');

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
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'message wa', 'web', '2026-03-28 00:43:51', '2026-03-28 00:43:51'),
(2, 'sms', 'web', '2026-03-28 00:43:51', '2026-03-28 00:43:51'),
(3, 'jurusan', 'web', '2026-03-28 00:43:51', '2026-03-28 00:43:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `id_sekolah` varchar(255) DEFAULT NULL,
  `id_kelas` varchar(255) DEFAULT NULL,
  `device` varchar(255) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `stateid` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `report`
--

INSERT INTO `report` (`id`, `id_sekolah`, `id_kelas`, `device`, `target`, `message`, `stateid`, `status`, `state`) VALUES
(150254853, '112233', '1', NULL, '6282169376803', 'Salam\r\n\r\nBapak/Ibu Orangtua siswa\r\n\r\nAraceli Little Telah hadir di sekolah SMK PAB 12 SAENTIS\r\n\r\n==============================\r\n\r\nNote : Pesan ini adalah pesan sistem tidak perlu membalas pesan ini', NULL, 'pending', NULL),
(160836569, '112233', '1', NULL, '6282169376803', 'Salam\r\n\r\nBapak/Ibu Orangtua siswa\r\n\r\nAraceli Little Telah hadir di sekolah SMK PAB 12 SAENTIS\r\n\r\n==============================\r\n\r\nNote : Pesan ini adalah pesan sistem tidak perlu membalas pesan ini', NULL, 'pending', NULL),
(160837004, '112233', '1', NULL, '6282169376803', 'Salam\r\n\r\nBapak/Ibu Orangtua siswa\r\n\r\nAraceli Little Telah hadir di sekolah SMK PAB 12 SAENTIS\r\n\r\n==============================\r\n\r\nNote : Pesan ini adalah pesan sistem tidak perlu membalas pesan ini', NULL, 'pending', NULL),
(160841234, '112233', '1', NULL, '6282169376803', 'Salam\r\n\r\nBapak/Ibu Orangtua siswa\r\n\r\nAraceli Little Telah hadir di sekolah SMK PAB 12 SAENTIS\r\n\r\n==============================\r\n\r\nNote : Pesan ini adalah pesan sistem tidak perlu membalas pesan ini', NULL, 'pending', NULL),
(160875373, '112233', '1', NULL, '6282169376803', 'Salam\r\n\r\nBapak/Ibu Orangtua siswa\r\n\r\nAraceli Little Telah hadir di sekolah SMK PAB 12 SAENTIS\r\n\r\n==============================\r\n\r\nNote : Pesan ini adalah pesan sistem tidak perlu membalas pesan ini', NULL, 'pending', NULL),
(160876142, '112233', '1', NULL, '6282169376803', 'Salam\r\n\r\nBapak/Ibu Orangtua siswa\r\n\r\nAraceli Little Telah hadir di sekolah SMK PAB 12 SAENTIS\r\n\r\n==============================\r\n\r\nNote : Pesan ini adalah pesan sistem tidak perlu membalas pesan ini', NULL, 'pending', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-03-28 00:43:51', '2026-03-28 00:43:51'),
(2, 'sekolah', 'web', '2026-03-28 00:43:51', '2026-03-28 00:43:51'),
(3, 'kelas', 'web', '2026-03-28 00:43:51', '2026-03-28 00:43:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 3),
(2, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sekolah`
--

CREATE TABLE `sekolah` (
  `id` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `id_wa` bigint(20) DEFAULT NULL,
  `id_paket` bigint(20) DEFAULT NULL,
  `id_mesin` varchar(17) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `id_slug_user` varchar(50) NOT NULL,
  `token_account_wa` varchar(100) DEFAULT NULL,
  `token_api_wa` varchar(100) DEFAULT NULL,
  `nama_sekolah` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(100) NOT NULL,
  `pendidikan` varchar(100) NOT NULL,
  `npsn` varchar(100) NOT NULL,
  `limit_siswa` varchar(100) DEFAULT NULL,
  `pesan_wa` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`pesan_wa`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sekolah`
--

INSERT INTO `sekolah` (`id`, `id_user`, `id_wa`, `id_paket`, `id_mesin`, `secret`, `id_slug_user`, `token_account_wa`, `token_api_wa`, `nama_sekolah`, `email`, `no_hp`, `pendidikan`, `npsn`, `limit_siswa`, `pesan_wa`, `created_at`, `updated_at`) VALUES
(112233, 1, 1, 1, '12345ff', 'NQZ2aKE6IrwTwNld', 'PAB12', '6NqoS5Dro54s6mYHSLszsjHKhGygf4Jknv5hpUd', 'atayMoT2W1pZUZ2AXAZe', 'SMK SWASTA PAB 12', 'smkpab12@gmail.com', '233453453', 'SMK', '122434', '100', '{\"data\":[{\"title\":\"hadir\",\"message\":\"Salam\\r\\n\\r\\nBapak\\/Ibu Orangtua siswa\\r\\n\\r\\n{nama} Telah hadir di sekolah SMK PAB 12 SAENTIS\\r\\n\\r\\n==============================\\r\\n\\r\\nNote : Pesan ini adalah pesan sistem tidak perlu membalas pesan ini\"},{\"title\":\"sakit\",\"message\":null},{\"title\":\"absen\",\"message\":null},{\"title\":\"izin\",\"message\":null}]}', NULL, NULL),
(280326100206, 280326100206, 280326100206, 1, '2', '', 'PAB10', NULL, NULL, 'SMK SWASTA PAB 10', 'meryaalvanda@gmail.com', '890879777', 'SMA', '122434', '100', '{\"data\":[{\"title\":\"hadir\",\"message\":\"Salam\\r\\n\\r\\nBapak\\/Ibu Orangtua siswa\\r\\n\\r\\n{nama} Telah hadir di sekolah SMK PAB 12 SAENTIS\\r\\n\\r\\n==============================\\r\\n\\r\\nNote : Pesan ini adalah pesan sistem tidak perlu membalas pesan ini\"},{\"title\":\"sakit\",\"message\":null},{\"title\":\"absen\",\"message\":null},{\"title\":\"izin\",\"message\":null}]}', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` char(36) NOT NULL,
  `id_sekolah` varchar(100) NOT NULL,
  `id_jurusan` varchar(100) DEFAULT NULL,
  `id_kelas` varchar(100) NOT NULL,
  `nama_siswa` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `rfid` varchar(100) DEFAULT NULL,
  `no_hp` varchar(100) NOT NULL,
  `no_hp_ortu` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `id_sekolah`, `id_jurusan`, `id_kelas`, `nama_siswa`, `email`, `foto`, `rfid`, `no_hp`, `no_hp_ortu`, `created_at`, `updated_at`) VALUES
('1kEmyFoa6a', '112233', '8900', '1', 'Araceli Little', 'conroy.chasity@gmail.com', '20260623064927.png', 'C5:7A:0B:8E', '082169376803', '082169376803', '2026-03-28 00:43:54', '2026-06-22 23:49:27'),
('20XiU2916w', '112233', '8900', '1', 'Mrs. Lori Goodwin', 'nkiehn@lehner.com', NULL, '73:67:2E:F8', '29472', '37453', '2026-03-28 00:43:54', '2026-06-21 11:24:55'),
('a0o3XdxoLy', '112233', '8900', '1', 'Miss Juanita Prohaska', 'cstokes@pfeffer.org', NULL, '76477', '22870', '21203', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('al08WqDmPj', '112233', '8900', '1', 'Arch Mayert', 'julianne37@stark.com', NULL, '91893', '88751', '70089', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('bh7bdSAT9a', '112233', '8900', '1', 'Dedrick Lubowitz', 'kimberly.lowe@keebler.com', NULL, '94822', '12191', '51328', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('crVplqjDuq', '112233', '8900', '1', 'Xander Ondricka', 'aimee.baumbach@hotmail.com', NULL, '78687', '83307', '33145', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('eL7zlyHUky', '112233', '8900', '1', 'Julie Anderson', 'lucas.brekke@ortiz.com', NULL, '80885', '76573', '68690', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('eLAmF6AsgU', '112233', '8900', '1', 'Emilie Leuschke', 'adalberto.gleichner@gmail.com', NULL, '40721', '12443', '95598', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('f7srRdb6vA', '112233', '8900', '1', 'Kurt Jacobi I', 'gabe.krajcik@gmail.com', NULL, '33976', '93198', '16429', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('GKSQFcCd6E', '112233', '8900', '1', 'Kailyn Thompson', 'margarita70@gottlieb.org', NULL, '85663', '85242', '47710', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('h7tePkDkRz', '112233', '8900', '1', 'Prof. Ramiro Metz V', 'domingo.dietrich@cruickshank.com', NULL, '74701', '97220', '52751', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('hbkzFcTSkQ', '112233', '8900', '1', 'Prof. Alan Kris', 'tshields@heidenreich.biz', NULL, '97647', '79657', '17056', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('hnTKoKfGd6', '112233', '8900', '1', 'Elena Champlin', 'jonatan57@gmail.com', NULL, '51221', '88025', '59158', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('Irn7It5QWi', '112233', '8900', '1', 'Palma Roob', 'pkoelpin@abernathy.info', NULL, '56813', '73092', '55994', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('ITXTtufdGw', '112233', '8900', '1', 'Mr. Sigurd Dickinson', 'alivia.mayert@weissnat.com', NULL, '12476', '43964', '50225', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('jcgYmletfA', '112233', '8900', '1', 'Vesta Klein', 'yrobel@streich.com', NULL, '44922', '10101', '41779', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('luQ4QXRqk1', '112233', '8900', '1', 'Rosalee Kemmer', 'abreitenberg@gmail.com', NULL, '68327', '61481', '31929', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('NnZAbL5bPG', '112233', '8900', '1', 'Lisette Dach', 'syble18@hotmail.com', NULL, '62422', '26473', '73317', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('NT4Oxac0qv', '112233', '8900', '1', 'Mrs. Amie Bednar II', 'hprohaska@collins.com', NULL, '83771', '94210', '12027', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('Q3K7TXktYC', '112233', '8900', '1', 'Dr. Magnolia Glover', 'kiel03@rice.com', NULL, '54934', '96664', '35307', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('qgSAgwtC1A', '112233', '8900', '1', 'Mrs. Valentina Reilly I', 'junior65@hotmail.com', NULL, '16170', '65998', '82970', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('rvcBF9VFuO', '112233', '8900', '1', 'Olen Douglas III', 'meredith.morissette@skiles.com', NULL, '74274', '84918', '19025', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('S8O2dKDcri', '112233', '8900', '1', 'Leora Cole', 'maude08@harber.com', NULL, '58276', '65256', '41770', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('sS0GhHQa7q', '112233', '8900', '1', 'Mrs. Asa Schumm', 'ykshlerin@gmail.com', NULL, '78100', '20012', '44418', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('UvMXc9Vgnf', '112233', '8900', '1', 'Miss Jennie Monahan II', 'lou40@ebert.biz', NULL, '85920', '85837', '43062', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('uwyQPWoDx7', '112233', '8900', '1', 'Lyla Anderson', 'janessa21@leuschke.org', NULL, '20843', '49844', '41952', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('YBwF41TLdd', '112233', '8900', '1', 'Conrad Kihn', 'wolff.marcos@vonrueden.com', NULL, '48348', '58391', '64830', '2026-03-28 00:43:54', '2026-03-28 00:43:54'),
('zWXs5ciMf8', '112233', '8900', '1', 'Prof. Regan Smitham', 'terry.easton@gmail.com', NULL, '29880', '51264', '33561', '2026-03-28 00:43:54', '2026-03-28 00:43:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `expiry_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `expiry_date`) VALUES
(0, 'admin', 'admin', '$2y$12$4ntgPkXMyZ9OuIrCiotgm.ivz3msHl932/I3nCW3L2ppYCSdke0ea', NULL),
(1, '123', '123', '$2y$12$/zIsQKQOqMbXBeN1KD/F3e5H2o9ORPUUuuhX5JBNsehpwCvWYQw3m', '2027-05-29 01:38:24'),
(2, '321', '321', '$2y$12$mBKczzLCn2vB2GRicMvy8uG21f43FLFshl7LB1XXhZrVO8inWzFma', '2027-05-29 01:38:24'),
(3, '111', '111', '$2y$12$aAc4khrMIO3L8dHYvZy79er2aBGsjx.sPiLNZ4MiyPMwpSC0TGfwW', '2027-05-29 01:38:24'),
(280326100206, NULL, '444', '$2y$12$oOwLPUijklQtFXm7ywfUYe2HMuAJ9w2dAh2lodU5eE8.u/OIgFMq6', '2026-04-28 03:02:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `websockets_statistics_entries`
--

CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` varchar(255) NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_absen` (`id_siswa`,`tanggal`);

--
-- Indeks untuk tabel `broadcast`
--
ALTER TABLE `broadcast`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guru_id_sekolah_foreign` (`id_sekolah`);

--
-- Indeks untuk tabel `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jurusan_id_sekolah_foreign` (`id_sekolah`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_id_user_foreign` (`id_user`),
  ADD KEY `kelas_id_jurusan_foreign` (`id_jurusan`);

--
-- Indeks untuk tabel `mesin`
--
ALTER TABLE `mesin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sekolah_id_user_foreign` (`id_user`),
  ADD KEY `sekolah_id_wa_foreign` (`id_wa`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indeks untuk tabel `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `mesin`
--
ALTER TABLE `mesin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_id_sekolah_foreign` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD CONSTRAINT `jurusan_id_sekolah_foreign` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_id_jurusan_foreign` FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kelas_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  ADD CONSTRAINT `sekolah_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sekolah_id_wa_foreign` FOREIGN KEY (`id_wa`) REFERENCES `broadcast` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
