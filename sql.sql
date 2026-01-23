-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table social.address_barangays
CREATE TABLE IF NOT EXISTS `address_barangays` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `city_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `address_barangays_city_id_name_unique` (`city_id`,`name`),
  CONSTRAINT `address_barangays_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `address_cities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table social.address_barangays: ~13 rows (approximately)
INSERT INTO `address_barangays` (`id`, `city_id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Barangay Cogon', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(2, 1, 'Barangay Dao', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(3, 1, 'Barangay Canlumia', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(4, 2, 'Guinacot', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(5, 2, 'Canhaway', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(6, 2, 'Sawang', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(7, 3, 'Barangay Caballero', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(8, 3, 'Barangay Maribojoc', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(9, 4, 'Barangay Baclayon', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(10, 5, 'Barangay Tangnan', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(11, 5, 'Barangay Lourdes', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(12, 6, 'Barangay Anda', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(13, 7, 'Barangay Corella', '2026-01-14 22:57:04', '2026-01-14 22:57:04');

-- Dumping structure for table social.address_cities
CREATE TABLE IF NOT EXISTS `address_cities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `province_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `address_cities_province_id_name_unique` (`province_id`,`name`),
  CONSTRAINT `address_cities_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `address_provinces` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table social.address_cities: ~7 rows (approximately)
INSERT INTO `address_cities` (`id`, `province_id`, `name`, `zip_code`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Tagbilaran City', '6310', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(2, 1, 'Guindulman', '6311', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(3, 1, 'Cebu City', '6000', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(4, 1, 'Baclayon', '6312', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(5, 1, 'Panglao', '6340', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(6, 1, 'Anda', '6342', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(7, 1, 'Corella', '6319', '2026-01-14 22:57:04', '2026-01-14 22:57:04');

-- Dumping structure for table social.address_provinces
CREATE TABLE IF NOT EXISTS `address_provinces` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `address_provinces_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table social.address_provinces: ~0 rows (approximately)
INSERT INTO `address_provinces` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Bohol', '2026-01-14 22:57:04', '2026-01-14 22:57:04');

-- Dumping structure for table social.address_puroks
CREATE TABLE IF NOT EXISTS `address_puroks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `barangay_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `address_puroks_barangay_id_name_unique` (`barangay_id`,`name`),
  CONSTRAINT `address_puroks_barangay_id_foreign` FOREIGN KEY (`barangay_id`) REFERENCES `address_barangays` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table social.address_puroks: ~33 rows (approximately)
INSERT INTO `address_puroks` (`id`, `barangay_id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Purok 1', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(2, 1, 'Purok 2', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(3, 1, 'Purok 3', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(4, 2, 'Purok 1', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(5, 2, 'Purok 2', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(6, 2, 'Purok 7', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(7, 3, 'Purok I', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(8, 3, 'Purok II', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(9, 4, 'Purok 1', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(10, 4, 'Purok 3', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(11, 4, 'Purok 7', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(12, 5, 'Purok 1', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(13, 5, 'Purok 2', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(14, 5, 'Purok 3', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(15, 6, 'Purok A', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(16, 6, 'Purok B', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(17, 7, 'Purok 1', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(18, 7, 'Purok 2', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(19, 8, 'Purok A', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(20, 8, 'Purok B', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(21, 9, 'Purok Central', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(22, 9, 'Purok East', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(23, 9, 'Purok West', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(24, 10, 'Purok 1', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(25, 10, 'Purok 2', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(26, 10, 'Purok 3', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(27, 11, 'Purok A', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(28, 11, 'Purok B', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(29, 12, 'Purok 1', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(30, 12, 'Purok 2', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(31, 13, 'Purok Central', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(32, 13, 'Purok Norte', '2026-01-14 22:57:04', '2026-01-14 22:57:04'),
	(33, 13, 'Purok Sur', '2026-01-14 22:57:04', '2026-01-14 22:57:04');

-- Dumping structure for table social.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `user_type` enum('admin','treasurer','secretary','auditor') DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `image` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table social.admin: ~3 rows (approximately)
INSERT INTO `admin` (`id`, `username`, `user_type`, `address`, `password`, `image`) VALUES
	(1, 'admin', 'admin', 'Boholssss', '123', 'uploads/cat-dancing-gif-dancing-cat3.gif'),
	(2, 'test', 'treasurer', 'Testsdgg', 'test', 'uploads/cat-annoyed8.gif'),
	(3, 't', 'secretary', 'Testsd', '123', 'uploads/ogdotaa.jpg');

-- Dumping structure for table social.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table social.cache: ~0 rows (approximately)

-- Dumping structure for table social.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table social.cache_locks: ~0 rows (approximately)

-- Dumping structure for table social.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table social.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table social.fund
CREATE TABLE IF NOT EXISTS `fund` (
  `bal` decimal(10,2) DEFAULT NULL,
  `rental_bal` decimal(10,2) DEFAULT NULL,
  `loan_bal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table social.fund: ~1 rows (approximately)
INSERT INTO `fund` (`bal`, `rental_bal`, `loan_bal`) VALUES
	(26762.00, 12760.00, 16752.00);

-- Dumping structure for table social.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table social.jobs: ~0 rows (approximately)

-- Dumping structure for table social.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table social.job_batches: ~0 rows (approximately)

-- Dumping structure for table social.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table social.migrations: ~4 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(5, '0001_01_01_000000_create_users_table', 1),
	(6, '0001_01_01_000001_create_cache_table', 1),
	(7, '0001_01_01_000002_create_jobs_table', 1),
	(8, '2026_01_15_000000_create_address_tables', 1);

-- Dumping structure for table social.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table social.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table social.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table social.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('ULNzjJwdVyoXY66CCAK23olFp1fEjxQnEy1BIUsr', 1001, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ2FYZ016d2t3RVV5aVd3YWEza29rbGRMS1ZncnNiODVWeVVGenlEOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvcHVyb2tzLzQiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEwMDE7fQ==', 1768961119);

-- Dumping structure for table social.tbl_charge_info
CREATE TABLE IF NOT EXISTS `tbl_charge_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mort_amt` int DEFAULT '150',
  `early_interest` decimal(5,2) NOT NULL DEFAULT '0.05',
  `late_interest` decimal(20,6) NOT NULL DEFAULT '0.100000',
  `total_bal` decimal(20,6) NOT NULL,
  `rental_bal` decimal(20,6) NOT NULL,
  `loan_bal` decimal(20,6) NOT NULL,
  `investment_bal` decimal(20,6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table social.tbl_charge_info: ~1 rows (approximately)
INSERT INTO `tbl_charge_info` (`id`, `mort_amt`, `early_interest`, `late_interest`, `total_bal`, `rental_bal`, `loan_bal`, `investment_bal`) VALUES
	(1, 150, 0.05, 0.100000, 103870.000000, 1720.000000, 500.000000, 0.000000);

-- Dumping structure for table social.tbl_death_fund
CREATE TABLE IF NOT EXISTS `tbl_death_fund` (
  `df_id` int NOT NULL AUTO_INCREMENT,
  `dd_id` int NOT NULL,
  `hd_id` int DEFAULT NULL,
  `amt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending','paid') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`df_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table social.tbl_death_fund: ~9 rows (approximately)
INSERT INTO `tbl_death_fund` (`df_id`, `dd_id`, `hd_id`, `amt`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 150.00, 'paid', '2026-01-23 05:43:30', '2026-01-23 05:43:41'),
	(2, 1, 2, 0.00, '', '2026-01-23 05:43:30', '2026-01-23 05:43:30'),
	(3, 2, 1, 150.00, 'paid', '2026-01-23 06:07:04', '2026-01-23 06:07:17'),
	(4, 2, 2, 150.00, 'paid', '2026-01-23 06:07:04', '2026-01-23 06:41:06'),
	(5, 2, 6, 0.00, '', '2026-01-23 06:07:04', '2026-01-23 06:07:04'),
	(6, 3, 1, 150.00, 'paid', '2026-01-23 06:44:05', '2026-01-23 06:44:20'),
	(7, 3, 2, 0.00, '', '2026-01-23 06:44:05', '2026-01-23 06:44:05'),
	(8, 3, 6, 0.00, '', '2026-01-23 06:44:05', '2026-01-23 06:44:05'),
	(9, 3, 7, 0.00, '', '2026-01-23 06:44:05', '2026-01-23 06:44:05');

-- Dumping structure for table social.tbl_deceased
CREATE TABLE IF NOT EXISTS `tbl_deceased` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hd_id` int NOT NULL,
  `date_died` date DEFAULT NULL,
  `total_amt` decimal(10,2) DEFAULT '0.00',
  `amt_rcv` decimal(10,2) DEFAULT '0.00',
  `dead_line` date DEFAULT NULL,
  `status` enum('pending','partial','settled') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table social.tbl_deceased: ~3 rows (approximately)
INSERT INTO `tbl_deceased` (`id`, `hd_id`, `date_died`, `total_amt`, `amt_rcv`, `dead_line`, `status`, `created_at`, `updated_at`) VALUES
	(1, 6, '2026-01-23', 300.00, 150.00, '2026-01-26', 'settled', '2026-01-23 05:43:30', '2026-01-23 06:37:03'),
	(2, 7, '2026-02-28', 450.00, 300.00, '2026-03-03', 'settled', '2026-01-23 06:07:04', '2026-01-23 06:41:06'),
	(3, 8, '2026-01-24', 600.00, 150.00, '2026-01-27', 'pending', '2026-01-23 06:44:05', '2026-01-23 06:44:20');

-- Dumping structure for table social.tbl_interest_payment
CREATE TABLE IF NOT EXISTS `tbl_interest_payment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `loan_id` int NOT NULL,
  `month` tinyint NOT NULL,
  `interest_rate` enum('5%','10%') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `interest_amt` decimal(20,6) NOT NULL,
  `payment_date` date NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table social.tbl_interest_payment: ~0 rows (approximately)

-- Dumping structure for table social.tbl_loan
CREATE TABLE IF NOT EXISTS `tbl_loan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `loan_amt` decimal(20,6) NOT NULL,
  `status` enum('ongoing','completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'ongoing',
  `user_id` int NOT NULL,
  `loan_date` date NOT NULL,
  `return_date` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table social.tbl_loan: ~0 rows (approximately)

-- Dumping structure for table social.tbl_released_fund
CREATE TABLE IF NOT EXISTS `tbl_released_fund` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dd_id` int DEFAULT NULL,
  `fullname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `amt_rel` decimal(10,2) DEFAULT '0.00',
  `date_rel` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table social.tbl_released_fund: ~5 rows (approximately)
INSERT INTO `tbl_released_fund` (`id`, `dd_id`, `fullname`, `amt_rel`, `date_rel`, `created_at`, `updated_at`) VALUES
	(1, 2, 'Test', 225.00, '2026-01-23', '2026-01-23 06:28:20', '2026-01-23 06:28:20'),
	(2, 2, '1213', 112.50, '2026-01-23', '2026-01-23 06:32:13', '2026-01-23 06:32:13'),
	(3, 2, 'Tests', 112.50, '2026-01-17', '2026-01-23 06:32:32', '2026-01-23 06:32:32'),
	(5, 1, 'Gege', 150.00, '2026-01-23', '2026-01-23 06:36:51', '2026-01-23 06:36:51'),
	(6, 1, 'Hehe', 150.00, '2026-01-16', '2026-01-23 06:37:03', '2026-01-23 06:37:03');

-- Dumping structure for table social.tbl_rental_asset
CREATE TABLE IF NOT EXISTS `tbl_rental_asset` (
  `id` int NOT NULL AUTO_INCREMENT,
  `desc` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `vacant_qty` int DEFAULT NULL,
  `rent_period` int DEFAULT NULL,
  `std_amt` decimal(10,2) DEFAULT '0.00',
  `mem_amt` decimal(10,2) DEFAULT '0.00',
  `penalty_amt` decimal(10,2) DEFAULT '0.00',
  `damage_qty` int DEFAULT '0',
  `damage_amt` decimal(10,2) DEFAULT '0.00',
  `date_purch` date DEFAULT NULL,
  `status` enum('good','damaged') DEFAULT 'good',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table social.tbl_rental_asset: ~2 rows (approximately)
INSERT INTO `tbl_rental_asset` (`id`, `desc`, `qty`, `vacant_qty`, `rent_period`, `std_amt`, `mem_amt`, `penalty_amt`, `damage_qty`, `damage_amt`, `date_purch`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Chair', 60, 47, 3, 3.00, 2.00, 5.00, 3, 500.00, '2026-01-23', 'good', '2026-01-23 07:05:16', '2026-01-23 10:13:58'),
	(2, 'Test', 12, 12, 0, 0.00, 0.00, 0.00, 0, 0.00, '2026-01-23', 'good', '2026-01-23 07:07:07', '2026-01-23 07:18:24');

-- Dumping structure for table social.tbl_renter
CREATE TABLE IF NOT EXISTS `tbl_renter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ra_id` int DEFAULT NULL,
  `rent_qty` int unsigned DEFAULT NULL,
  `damage_qty` int DEFAULT '0',
  `total_amt` decimal(10,2) DEFAULT '0.00',
  `rent_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `date_returned` date DEFAULT NULL,
  `status` enum('pending','paid') DEFAULT 'pending',
  `type` enum('standard','member') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table social.tbl_renter: ~4 rows (approximately)
INSERT INTO `tbl_renter` (`id`, `full_name`, `ra_id`, `rent_qty`, `damage_qty`, `total_amt`, `rent_date`, `due_date`, `date_returned`, `status`, `type`, `created_at`, `updated_at`) VALUES
	(1, 'Patrick Henry Bersaluna', 1, 20, 0, 40.00, '2026-01-23', '2026-01-26', '2026-01-23', 'paid', 'member', '2026-01-23 08:15:26', '2026-01-23 09:25:05'),
	(2, 'Test', 1, 40, 1, 640.00, '2026-01-24', '2026-01-27', '2026-01-27', 'paid', 'standard', '2026-01-23 09:25:59', '2026-01-23 09:26:22'),
	(3, 'Tt', 1, 20, 2, 1040.00, '2026-01-23', '2026-01-26', '2026-01-26', 'paid', '', '2026-01-23 09:28:16', '2026-01-23 09:30:59'),
	(4, 'Patrick Henry Bersaluna', 1, 10, 0, 0.00, '2026-01-23', '2026-01-26', NULL, 'pending', 'member', '2026-01-23 10:13:58', '2026-01-23 10:13:58');

-- Dumping structure for table social.tbl_supp_renter
CREATE TABLE IF NOT EXISTS `tbl_supp_renter` (
  `sr_id` int NOT NULL AUTO_INCREMENT,
  `hd_id` int DEFAULT NULL,
  `ra_id` int DEFAULT NULL,
  `sr_rent_qty` int DEFAULT NULL,
  `sr_rent_date` date DEFAULT NULL,
  `sr_due_date` date DEFAULT NULL,
  `sr_date_returned` date DEFAULT NULL,
  `sr_rent_penalty` decimal(10,2) DEFAULT '0.00',
  `sr_total_amount` decimal(10,2) DEFAULT '0.00',
  `sr_status_1` tinyint(1) DEFAULT '0',
  `sr_status_2` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`sr_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table social.tbl_supp_renter: ~0 rows (approximately)

-- Dumping structure for table social.tbl_user_hd
CREATE TABLE IF NOT EXISTS `tbl_user_hd` (
  `hd_id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `mname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `lname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `birthday` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `purok` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `barangay` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `city` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `province` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `zip_code` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `phone1` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '0',
  `phone2` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '0',
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `date_joined` date DEFAULT NULL,
  `image` text,
  `status` enum('active','inactive','deceased') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`hd_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table social.tbl_user_hd: ~5 rows (approximately)
INSERT INTO `tbl_user_hd` (`hd_id`, `fname`, `mname`, `lname`, `birthday`, `age`, `purok`, `barangay`, `city`, `province`, `zip_code`, `phone1`, `phone2`, `username`, `date_joined`, `image`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Patrick Henry', 'Vallejos', 'Bersaluna', '2002-06-14', 23, 'Purok 7', 'Guinacot', 'Guindulman', 'Bohol', '6310', '09977745888', '09558444777', NULL, '2026-01-23', NULL, 'active', '2026-01-23 03:14:49', '2026-01-23 03:21:56'),
	(2, 'John ', 'G', 'Doe', '1974-10-05', 51, 'Purok 7', 'Guinacot', 'Guindulman', 'Bohol', '6310', '09484888444', '09999466644', NULL, '2024-01-04', NULL, 'active', '2026-01-23 03:15:42', '2026-01-23 05:23:47'),
	(6, 'Andrew', '', 'Garfield', '', 0, 'Purok 7', 'Guinacot', 'Guindulman', 'Bohol', '6310', '', '', NULL, '0000-00-00', NULL, 'deceased', '2026-01-23 05:23:14', '2026-01-23 05:43:30'),
	(7, 'Test Header', '', '', '', 0, 'Purok 7', 'Guinacot', 'Guindulman', 'Bohol', '6310', '', '', NULL, '0000-00-00', NULL, 'deceased', '2026-01-23 06:06:55', '2026-01-23 06:07:04'),
	(8, 'Owen', '', '', '', 0, 'Purok 7', 'Guinacot', 'Guindulman', 'Bohol', '6310', '', '', NULL, '0000-00-00', NULL, 'deceased', '2026-01-23 06:43:43', '2026-01-23 06:44:05');

-- Dumping structure for table social.tbl_user_ln
CREATE TABLE IF NOT EXISTS `tbl_user_ln` (
  `ln_id` int NOT NULL AUTO_INCREMENT,
  `hd_id` int NOT NULL,
  `fname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `mname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `lname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `relation` varchar(50) DEFAULT NULL,
  `birthday` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `age` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `purok` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `barangay` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `city` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `province` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `zip_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `phone1` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '0',
  `phone2` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '0',
  `username` varchar(50) DEFAULT NULL,
  `date_joined` date DEFAULT NULL,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ln_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table social.tbl_user_ln: ~1 rows (approximately)
INSERT INTO `tbl_user_ln` (`ln_id`, `hd_id`, `fname`, `mname`, `lname`, `relation`, `birthday`, `age`, `purok`, `barangay`, `city`, `province`, `zip_code`, `phone1`, `phone2`, `username`, `date_joined`, `image`, `status`, `created_at`, `updated_at`) VALUES
	(1, 8, 'Testaa', '', '', NULL, '', '', 'Purok 7', 'Guinacot', 'Guindulman', 'Bohol', '6310', '', '', NULL, '0000-00-00', NULL, '1', '2026-01-23 06:43:49', '2026-01-23 06:43:54');

-- Dumping structure for table social.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table social.users: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
