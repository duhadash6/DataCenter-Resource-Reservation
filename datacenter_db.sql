-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2026 at 07:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datacenter_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `actor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `target_type` varchar(255) DEFAULT NULL,
  `target_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `changes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`changes`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `actor_id`, `action`, `target_type`, `target_id`, `ip_address`, `changes`, `created_at`, `updated_at`) VALUES
(1, 2, 'user_login', 'user', 2, '127.0.0.1', '{\"session_started\":\"2026-01-16T21:35:58+00:00\"}', '2026-01-16 20:35:58', '2026-01-16 20:35:58'),
(2, 4, 'user_login', 'user', 4, '127.0.0.1', '{\"session_started\":\"2026-01-16T21:38:30+00:00\"}', '2026-01-16 20:38:30', '2026-01-16 20:38:30'),
(3, 5, 'user_login', 'user', 5, '127.0.0.1', '{\"session_started\":\"2026-01-16T21:43:59+00:00\"}', '2026-01-16 20:43:59', '2026-01-16 20:43:59'),
(4, 5, 'user_login', 'user', 5, '127.0.0.1', '{\"session_started\":\"2026-01-16T21:50:18+00:00\"}', '2026-01-16 20:50:18', '2026-01-16 20:50:18'),
(5, 5, 'reservation_approve', 'reservation', 1, '127.0.0.1', '{\"action\":\"approved\"}', '2026-01-16 20:50:23', '2026-01-16 20:50:23'),
(6, 2, 'user_login', 'user', 2, '127.0.0.1', '{\"session_started\":\"2026-01-16T21:50:35+00:00\"}', '2026-01-16 20:50:35', '2026-01-16 20:50:35'),
(7, 2, 'reservation_create', 'reservation', 4, '127.0.0.1', '{\"created\":{\"resource_id\":5,\"start_at\":\"2026-01-20T22:51:00.000000Z\",\"end_at\":\"2026-01-21T22:51:00.000000Z\"}}', '2026-01-16 20:51:31', '2026-01-16 20:51:31'),
(8, 4, 'user_login', 'user', 4, '127.0.0.1', '{\"session_started\":\"2026-01-16T21:52:16+00:00\"}', '2026-01-16 20:52:16', '2026-01-16 20:52:16'),
(9, 4, 'reservation_create', 'reservation', 5, '127.0.0.1', '{\"created\":{\"resource_id\":3,\"start_at\":\"2026-01-17T22:52:00.000000Z\",\"end_at\":\"2026-01-24T22:52:00.000000Z\"}}', '2026-01-16 20:53:04', '2026-01-16 20:53:04'),
(10, 2, 'user_login', 'user', 2, '127.0.0.1', '{\"session_started\":\"2026-01-16T21:53:29+00:00\"}', '2026-01-16 20:53:29', '2026-01-16 20:53:29'),
(11, 2, 'user_login', 'user', 2, '127.0.0.1', '{\"session_started\":\"2026-01-17T17:29:34+00:00\"}', '2026-01-17 16:29:34', '2026-01-17 16:29:34'),
(12, 2, 'user_login', 'user', 2, '127.0.0.1', '{\"session_started\":\"2026-01-17T19:33:32+00:00\"}', '2026-01-17 18:33:32', '2026-01-17 18:33:32'),
(13, 2, 'user_login', 'user', 2, '127.0.0.1', '{\"session_started\":\"2026-01-17T19:36:40+00:00\"}', '2026-01-17 18:36:40', '2026-01-17 18:36:40'),
(14, 2, 'user_login', 'user', 2, '127.0.0.1', '{\"session_started\":\"2026-01-17T19:45:37+00:00\"}', '2026-01-17 18:45:37', '2026-01-17 18:45:37'),
(15, 4, 'user_login', 'user', 4, '127.0.0.1', '{\"session_started\":\"2026-01-17T19:57:55+00:00\"}', '2026-01-17 18:57:55', '2026-01-17 18:57:55'),
(16, 2, 'user_login', 'user', 2, '127.0.0.1', '{\"session_started\":\"2026-01-17T19:59:37+00:00\"}', '2026-01-17 18:59:37', '2026-01-17 18:59:37'),
(17, 2, 'user_login', 'user', 2, '127.0.0.1', '{\"session_started\":\"2026-01-17T20:31:18+00:00\"}', '2026-01-17 19:31:18', '2026-01-17 19:31:18'),
(18, 2, 'reservation_approve', 'reservation', 5, '127.0.0.1', '{\"action\":\"approved\"}', '2026-01-17 19:39:36', '2026-01-17 19:39:36'),
(19, 4, 'user_login', 'user', 4, '127.0.0.1', '{\"session_started\":\"2026-01-17T20:40:03+00:00\"}', '2026-01-17 19:40:03', '2026-01-17 19:40:03'),
(20, 4, 'user_login', 'user', 4, '127.0.0.1', '{\"session_started\":\"2026-01-17T21:11:18+00:00\"}', '2026-01-17 20:11:18', '2026-01-17 20:11:18'),
(21, 6, 'reservation_approve', 'reservation', 3, '127.0.0.1', '{\"action\":\"approved\"}', '2026-01-17 20:24:49', '2026-01-17 20:24:49');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_15_175954_create_resources_table', 1),
(5, '2026_01_15_180009_create_reservations_table', 1),
(6, '2026_01_15_182242_add_role_to_users_table', 1),
(7, '2026_01_15_220000_create_activity_logs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `resource_id` bigint(20) UNSIGNED NOT NULL,
  `start_at` datetime NOT NULL,
  `end_at` datetime NOT NULL,
  `status` enum('pending','approved','rejected','active','finished','cancelled') NOT NULL DEFAULT 'pending',
  `justification` text DEFAULT NULL,
  `admin_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `resource_id`, `start_at`, `end_at`, `status`, `justification`, `admin_note`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2026-01-16 23:08:19', '2026-01-17 01:08:19', 'approved', 'Test reservation 1', NULL, '2026-01-16 20:08:19', '2026-01-16 20:50:23'),
(2, 3, 2, '2026-01-17 00:08:19', '2026-01-17 02:08:19', 'pending', 'Test reservation 2', NULL, '2026-01-16 20:08:19', '2026-01-16 20:08:19'),
(3, 3, 3, '2026-01-17 01:08:19', '2026-01-17 03:08:19', 'approved', 'Test reservation 3', NULL, '2026-01-16 20:08:19', '2026-01-17 20:24:49'),
(4, 2, 5, '2026-01-20 22:51:00', '2026-01-21 22:51:00', 'pending', 'yes', NULL, '2026-01-16 20:51:31', '2026-01-16 20:51:31'),
(5, 4, 3, '2026-01-17 22:52:00', '2026-01-24 22:52:00', 'approved', 'oui', NULL, '2026-01-16 20:53:04', '2026-01-17 19:39:36');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('server','vm','storage','network') NOT NULL,
  `status` enum('available','reserved','maintenance','down') NOT NULL DEFAULT 'available',
  `location` varchar(255) DEFAULT NULL,
  `specs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`specs`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `name`, `type`, `status`, `location`, `specs`, `created_at`, `updated_at`) VALUES
(1, 'Server-01', 'server', 'available', 'Rack 1 / DC A', '\"{\\\"cpu\\\":\\\"Intel Xeon E5-2680\\\",\\\"ram\\\":\\\"256GB\\\",\\\"storage\\\":\\\"2TB SSD\\\"}\"', '2026-01-16 20:04:25', '2026-01-16 20:04:25'),
(2, 'Server-02', 'server', 'available', 'Rack 2 / DC A', '\"{\\\"cpu\\\":\\\"Intel Xeon E5-2690\\\",\\\"ram\\\":\\\"512GB\\\",\\\"storage\\\":\\\"4TB SSD\\\"}\"', '2026-01-16 20:04:25', '2026-01-16 20:04:25'),
(3, 'VM-Cluster-01', 'vm', 'available', 'Host Server 1', '\"{\\\"cpu\\\":\\\"8 vCPU\\\",\\\"ram\\\":\\\"64GB\\\",\\\"storage\\\":\\\"500GB\\\"}\"', '2026-01-16 20:04:25', '2026-01-16 20:04:25'),
(4, 'VM-Cluster-02', 'vm', 'reserved', 'Host Server 3', '\"{\\\"cpu\\\":\\\"16 vCPU\\\",\\\"ram\\\":\\\"128GB\\\",\\\"storage\\\":\\\"1TB\\\"}\"', '2026-01-16 20:04:25', '2026-01-16 20:04:25'),
(5, 'Storage-Array-01', 'storage', 'available', 'Room 201', '\"{\\\"type\\\":\\\"SAN\\\",\\\"capacity\\\":\\\"50TB\\\",\\\"raid\\\":\\\"RAID 6\\\"}\"', '2026-01-16 20:04:25', '2026-01-16 20:04:25'),
(6, 'Storage-Array-02', 'storage', 'maintenance', 'Room 202', '\"{\\\"type\\\":\\\"NAS\\\",\\\"capacity\\\":\\\"100TB\\\",\\\"raid\\\":\\\"RAID 10\\\"}\"', '2026-01-16 20:04:25', '2026-01-16 20:51:05'),
(7, 'Network-Switch-01', 'network', 'available', 'Floor 1', '\"{\\\"ports\\\":\\\"48 x 10GbE\\\",\\\"bandwidth\\\":\\\"1.9Tbps\\\"}\"', '2026-01-16 20:04:25', '2026-01-16 20:04:25'),
(8, 'Network-Switch-02', 'network', 'available', 'Floor 2', '\"{\\\"ports\\\":\\\"32 x 25GbE\\\",\\\"bandwidth\\\":\\\"3.2Tbps\\\"}\"', '2026-01-16 20:04:25', '2026-01-16 20:04:25'),
(9, 'Network-Switch-03', 'network', 'maintenance', 'Floor 2', '\"{\\\"ports\\\":\\\"48 x 10GbE\\\",\\\"bandwidth\\\":\\\"1.9Tbps\\\"}\"', '2026-01-16 20:04:25', '2026-01-16 20:04:25'),
(10, 'Server-Legacy-04', 'server', 'down', 'Rack 5 / DC B', '\"{\\\"cpu\\\":\\\"Intel Xeon E5-1650\\\",\\\"ram\\\":\\\"128GB\\\",\\\"storage\\\":\\\"1TB\\\"}\"', '2026-01-16 20:04:25', '2026-01-16 20:04:25');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2IAGKmzAw0vMDjq7z47omDAF8XuY14XYon1ZsvUP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.108.1 Chrome/142.0.7444.235 Electron/39.2.7 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRE0wREw5V1Z2U2xqRk5xRlZWS21BZWs5U0diNkd1M0l5VW50b2RISSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbj9pZD1mOTBhZDE4Yi1hYTI5LTQ4NDgtYWIwNi0xNWI1ZWZkOTEwYzAmdnNjb2RlQnJvd3NlclJlcUlkPTE3Njg2Nzg1NDg0NjUiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoxMDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbj9pZD1mOTBhZDE4Yi1hYTI5LTQ4NDgtYWIwNi0xNWI1ZWZkOTEwYzAmdnNjb2RlQnJvd3NlclJlcUlkPTE3Njg2Nzg1NDg0NjUiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768678548),
('ek2aWt4X88959rgM5rkZkqdhOZRh6a7gUlJNWJd6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.108.1 Chrome/142.0.7444.235 Electron/39.2.7 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicnIweEk1aVVvbFBQS3NmeWJvRGh0NXFleVpDSEJRcTRnR1hsMFVNdiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbj9pZD1mOTBhZDE4Yi1hYTI5LTQ4NDgtYWIwNi0xNWI1ZWZkOTEwYzAmdnNjb2RlQnJvd3NlclJlcUlkPTE3Njg2Nzg1NDkwNTAiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoxMDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbj9pZD1mOTBhZDE4Yi1hYTI5LTQ4NDgtYWIwNi0xNWI1ZWZkOTEwYzAmdnNjb2RlQnJvd3NlclJlcUlkPTE3Njg2Nzg1NDkwNTAiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768678549),
('EQmxwYVu8KGwIJksGQJxbzhzQUJNPfv2llY44Hkc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.108.1 Chrome/142.0.7444.235 Electron/39.2.7 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMHdyWkt6d2VQY1RBcXVFQlJCY0w3TmI1bGdlQmx4bXh0WkE0U1F1NyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768678494),
('KUEcX0eRCC8He3D1tDagJfhVw3mSQORKAUlC3Z8y', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.108.1 Chrome/142.0.7444.235 Electron/39.2.7 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidXRkS1VGbE9aSzdGWjVLMG5tYlNETTRmUEc2ZDNndW9hQmFKdmZ3VSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbj9pZD1mOTBhZDE4Yi1hYTI5LTQ4NDgtYWIwNi0xNWI1ZWZkOTEwYzAmdnNjb2RlQnJvd3NlclJlcUlkPTE3Njg2Nzg0OTMwMDkiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoxMDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbj9pZD1mOTBhZDE4Yi1hYTI5LTQ4NDgtYWIwNi0xNWI1ZWZkOTEwYzAmdnNjb2RlQnJvd3NlclJlcUlkPTE3Njg2Nzg0OTMwMDkiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768678493),
('m45n2frOlz9vtJyRafrD4XOmdxOeC3imlPLeXMhV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.108.1 Chrome/142.0.7444.235 Electron/39.2.7 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0FoSTFaclZkVUtQck5McUZHc0k1MGZ1RUttMDdMNTJzM1ZvR2NZZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768678549),
('qO3bnzmYcdboF9R0MlkXLs5UDxkQ7CQbZzk2AgzD', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibWVrd0VEMFhFcjlZeEtHcExsSFFmbTVtckw1V2txOXNCbUlpZU5xWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4uZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Njt9', 1768685644),
('UXjL0bJeGZ0H5NFqV7xmRe4FLOgBYeApVnU336qW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.108.1 Chrome/142.0.7444.235 Electron/39.2.7 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQzFHVHNGaDlmcWprN0FuWldtanZNZk83S0FHeVMwdXRobElmWm9FVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768678549),
('wL5Y2ptWspaksm0TqBD8y5yJ1MZ0cvynLOPTmGYh', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.108.1 Chrome/142.0.7444.235 Electron/39.2.7 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYWQ3YlFRTXM0NFREVXJoRmgwZWpyYmxJOWpFNHZmQ0g5Y1ZIZzJOQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768678551),
('yt9A001m5pAAQPtYZMPwFU89vhJ8muRhe217BvDx', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.108.1 Chrome/142.0.7444.235 Electron/39.2.7 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM3dlNXFCNk9RUVgzVGd4QkU3Y0tPbWZhYlRBRloza3VRdHM2YlNpMSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbj9pZD1mOTBhZDE4Yi1hYTI5LTQ4NDgtYWIwNi0xNWI1ZWZkOTEwYzAmdnNjb2RlQnJvd3NlclJlcUlkPTE3Njg2Nzg1NTA3NTEiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoxMDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbj9pZD1mOTBhZDE4Yi1hYTI5LTQ4NDgtYWIwNi0xNWI1ZWZkOTEwYzAmdnNjb2RlQnJvd3NlclJlcUlkPTE3Njg2Nzg1NTA3NTEiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768678551);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('user','manager','admin') NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', 'user', '2026-01-16 20:03:52', '$2y$12$0SVR0Po0WISjumfjQDJ3q.I.xwhdOt3t73C07opvZHrRxg.oBG.lm', 'WTKw9G0z4E', '2026-01-16 20:03:53', '2026-01-16 20:03:53'),
(2, 'Admin User', 'admin@test.com', 'admin', NULL, '$2y$12$kd/HXXi98Mh18VnyfP5C9ulaS/ieeMfnwrJz2ebkLo3h/EEBY1exO', NULL, '2026-01-16 20:08:15', '2026-01-16 20:08:15'),
(3, 'Test User', 'test@test.com', 'user', NULL, '$2y$12$WEI.Az02hizre5OjL/o4v.HP4GSIadEF5ADg1RsT4G1EeSHIjjn.u', NULL, '2026-01-16 20:08:19', '2026-01-16 20:08:19'),
(4, 'test1', 'test1@test.com', 'user', NULL, '$2y$12$2EsiRawnbdQ50K0Tz9BxBe459Kz3z1EPLANd1oLUavgJZhbjiO9l.', NULL, '2026-01-16 20:38:05', '2026-01-16 20:38:05'),
(5, 'test2', 'test2@test.com', 'manager', NULL, '$2y$12$i.hDIRPiLM/kCzZLglIsjuZ6hDE8VXVBQtJcRzeQYNuxy09546VTO', NULL, '2026-01-16 20:43:47', '2026-01-16 20:43:47'),
(6, 'test3', 'test3@test.com', 'manager', NULL, '$2y$12$FHKbIliE8EuICiYO/IiO/e1XYsW5f94sIuJ1/jkFo6IEktPcc.nnO', NULL, '2026-01-17 20:24:02', '2026-01-17 20:24:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_actor_id_action_created_at_index` (`actor_id`,`action`,`created_at`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_user_id_foreign` (`user_id`),
  ADD KEY `reservations_resource_id_foreign` (`resource_id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `resources_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_actor_id_foreign` FOREIGN KEY (`actor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_resource_id_foreign` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
