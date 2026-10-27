-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.16.0.7229
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for wedding2026
CREATE DATABASE IF NOT EXISTS `wedding2026` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `wedding2026`;

-- Dumping structure for table wedding2026.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table wedding2026.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table wedding2026.invites
CREATE TABLE IF NOT EXISTS `invites` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `token` text NOT NULL,
  `token_hash` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `first_opened_at` timestamp NULL DEFAULT NULL,
  `last_opened_at` timestamp NULL DEFAULT NULL,
  `open_count` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invites_token_hash_unique` (`token_hash`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table wedding2026.invites: ~6 rows (approximately)
INSERT INTO `invites` (`id`, `token`, `token_hash`, `name`, `first_opened_at`, `last_opened_at`, `open_count`, `created_at`, `updated_at`) VALUES
	(1, 'QVYMWQ5QHlpaWRIgGg5O6aPznlhFUzMKk97zDUUvAAA', '5f894482b980215a6bb4fae2f77274377124b8c01bc6ad9ad2cab5c186943fec', 'Gia đình Việt Anh', NULL, NULL, 0, '2026-10-27 15:52:12', '2026-10-27 16:14:47'),
	(2, 'GgBYCgtZTgtYUxImHQdOYFteWhYLUwYLk97_WSkPAEhBSQ0CDkc', 'be6c4e6d9dce5ba31a7c4168943533d11a0e01081b97620af903b194666f63d0', 'Anh Minh & chị Lan (demo)', '2026-10-24 16:14:47', '2026-10-27 13:14:47', 3, '2026-10-27 16:14:47', '2026-10-27 16:14:47'),
	(3, 'HQMNCllcGF1XBxIgGg5O6aPznlhFUwagxkU2GEVGCg0EQkE', '2b1ff2dd44026231183bd8b5987e746ad174c9c2e76ef9f48695e5f301a84475', 'Gia đình cô Ba (demo)', '2026-10-24 16:14:47', '2026-10-27 15:14:47', 1, '2026-10-27 16:14:47', '2026-10-27 16:14:47'),
	(4, 'GFBaC15bSFELVxIlktXPQxJkR9eX1gtDHoTP4hVOX1ooHEhHBQsKHEY', '6271f588ca8cb9894941bfa3ae59260a120999a74e603172e4833e22d445f6c3', 'Bạn Tuấn lớp 12A1 (demo)', '2026-10-24 16:14:47', '2026-10-27 14:14:47', 2, '2026-10-27 16:14:47', '2026-10-27 16:14:47'),
	(5, 'HQFZXwtdTlAJVRIkG47VphJ48ZYNPwwNGkVcHQADAUE', 'bd7bf046cf7110e9f1c1b89647f6f091996d95647c2fb86e80c2a7106d2a822d', 'Chị Hà Linh (demo)', '2026-10-24 16:14:47', '2026-10-27 15:14:47', 1, '2026-10-27 16:14:47', '2026-10-27 16:14:47'),
	(6, 'TlRZWF0LSAlWUBImHQdOfEfRiadOUyeCyMYbWU0KCwUGBA', 'e44f60857e1851d030523212eb00cd3b4563f13d3b6185d32b14123fbec74d98', 'Anh Quốc Bảo (demo)', NULL, NULL, 0, '2026-10-27 16:14:47', '2026-10-27 16:14:47');

-- Dumping structure for table wedding2026.memory_comments
CREATE TABLE IF NOT EXISTS `memory_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `legacy_id` varchar(64) DEFAULT NULL,
  `memory_post_id` bigint(20) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `ip_address` varchar(45) NOT NULL DEFAULT '',
  `user_agent` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `memory_comments_legacy_id_unique` (`legacy_id`),
  KEY `memory_comments_memory_post_id_foreign` (`memory_post_id`),
  CONSTRAINT `memory_comments_memory_post_id_foreign` FOREIGN KEY (`memory_post_id`) REFERENCES `memory_posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table wedding2026.memory_comments: ~7 rows (approximately)
INSERT INTO `memory_comments` (`id`, `legacy_id`, `memory_post_id`, `name`, `message`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
	(1, 'mzc_seed_1', 1, 'Thảo Vân', 'Nhìn tấm ảnh này là nhớ lại ngay cái ngày hai đứa quen nhau ở quán cafe đó luôn 😍', '', '', '2026-06-20 03:15:00', '2026-10-27 16:14:47'),
	(2, 'mzc_seed_2', 4, 'Minh Khang', 'Chúc mừng hai đứa nha! Đợi ngày 13.12 lắm luôn đó 🎉', '', '', '2026-06-16 01:40:00', '2026-10-27 16:14:47'),
	(3, 'mzc_6a4c6da74404e2.34094908', 1, 'ádasd', 'ádasd', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-06 20:08:23', '2026-10-27 16:14:47'),
	(4, 'mzc_6a4c6dac5299e8.07079308', 1, 'ádasd', 'sfdasf', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-06 20:08:28', '2026-10-27 16:14:47'),
	(5, 'mzc_6a4c6db41f04c7.72815172', 2, 'adfa', 'ádf', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-06 20:08:36', '2026-10-27 16:14:47'),
	(6, 'demo_post_1_c1', 5, 'Bạn thân (demo)', 'Đẹp đôi quá trời luôn! 😍', '127.0.0.1', 'DemoDataSeeder', '2026-10-27 16:14:47', '2026-10-27 16:14:47'),
	(7, 'demo_post_2_c1', 6, 'Bạn thân (demo)', 'Đẹp đôi quá trời luôn! 😍', '127.0.0.1', 'DemoDataSeeder', '2026-10-27 16:14:47', '2026-10-27 16:14:47');

-- Dumping structure for table wedding2026.memory_posts
CREATE TABLE IF NOT EXISTS `memory_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `legacy_id` varchar(64) DEFAULT NULL,
  `posted_at` timestamp NULL DEFAULT NULL,
  `content` text NOT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `likes` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `memory_posts_legacy_id_unique` (`legacy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table wedding2026.memory_posts: ~6 rows (approximately)
INSERT INTO `memory_posts` (`id`, `legacy_id`, `posted_at`, `content`, `images`, `likes`, `created_at`, `updated_at`) VALUES
	(1, 'post_1', '2024-02-14 02:00:00', 'Ngày đầu tiên mình gặp nhau, chẳng ai nghĩ rằng đây sẽ là khởi đầu của một hành trình dài. Cảm ơn vì đã xuất hiện trong cuộc đời anh/em 💕', '["https:\\/\\/hn.ss.bfcplatform.vn\\/talentdad\\/ShareX\\/2026\\/06\\/chrome_iYKOBwJQnw.png"]', 128, '2026-10-27 16:14:47', '2026-10-27 16:14:47'),
	(2, 'post_2', '2024-08-20 11:30:00', 'Chuyến du lịch đầu tiên cùng nhau. Những khoảnh khắc giản dị nhưng đáng nhớ nhất.', '["https:\\/\\/hn.ss.bfcplatform.vn\\/talentdad\\/ShareX\\/2026\\/06\\/chrome_7FJaGtaf0Z.png","https:\\/\\/hn.ss.bfcplatform.vn\\/talentdad\\/ShareX\\/2026\\/06\\/chrome_idfrF4sgD2.png"]', 96, '2026-10-27 16:14:47', '2026-10-27 16:14:47'),
	(3, 'post_3', '2025-12-24 13:00:00', 'Giáng sinh cùng nhau, thêm một mùa lễ hội ngập tràn yêu thương. Mong rằng năm sau sẽ được đón Giáng Sinh cùng nhau với danh phận vợ chồng 🎄', '["https:\\/\\/hn.ss.bfcplatform.vn\\/talentdad\\/ShareX\\/2026\\/06\\/chrome_iYKOBwJQnw.png","https:\\/\\/hn.ss.bfcplatform.vn\\/talentdad\\/ShareX\\/2026\\/06\\/chrome_7FJaGtaf0Z.png","https:\\/\\/hn.ss.bfcplatform.vn\\/talentdad\\/ShareX\\/2026\\/06\\/chrome_idfrF4sgD2.png"]', 210, '2026-10-27 16:14:47', '2026-10-27 16:14:47'),
	(4, 'post_4', '2026-06-15 05:00:00', 'Cầu hôn thành công! Cảm ơn em đã nói "Có" 💍 Hẹn gặp mọi người trong ngày trọng đại 13.12.2026 nhé!', '["https:\\/\\/hn.ss.bfcplatform.vn\\/talentdad\\/ShareX\\/2026\\/06\\/chrome_8rrVQarr8A.jpg"]', 356, '2026-10-27 16:14:47', '2026-10-27 16:14:47'),
	(5, 'demo_post_1', '2025-08-20 12:30:00', 'Chuyến Đà Lạt đầu tiên của hai đứa — sương sớm, cà phê và rất nhiều tiếng cười ☕🌲 (demo)', '["https:\\/\\/hn.ss.bfcplatform.vn\\/talentdad\\/ShareX\\/2026\\/06\\/chrome_iYKOBwJQnw.png"]', 214, '2026-10-27 16:14:47', '2026-10-27 16:14:47'),
	(6, 'demo_post_2', '2026-03-08 13:00:00', 'Ngày anh ngỏ lời, em chỉ kịp gật đầu rồi khóc 💍 (demo)', '["https:\\/\\/hn.ss.bfcplatform.vn\\/talentdad\\/ShareX\\/2026\\/06\\/chrome_iYKOBwJQnw.png"]', 356, '2026-10-27 16:14:47', '2026-10-27 16:14:47');

-- Dumping structure for table wedding2026.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table wedding2026.migrations: ~5 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2026_10_28_000001_create_wedding_tables', 1);

-- Dumping structure for table wedding2026.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table wedding2026.password_resets: ~0 rows (approximately)

-- Dumping structure for table wedding2026.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table wedding2026.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table wedding2026.rsvps
CREATE TABLE IF NOT EXISTS `rsvps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `legacy_id` varchar(64) DEFAULT NULL,
  `token` text DEFAULT NULL,
  `token_hash` varchar(64) DEFAULT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL DEFAULT '',
  `guests` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `attend` varchar(3) NOT NULL,
  `message` text DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL DEFAULT '',
  `user_agent` varchar(255) NOT NULL DEFAULT '',
  `edited_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rsvps_legacy_id_unique` (`legacy_id`),
  UNIQUE KEY `rsvps_token_hash_unique` (`token_hash`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table wedding2026.rsvps: ~5 rows (approximately)
INSERT INTO `rsvps` (`id`, `legacy_id`, `token`, `token_hash`, `fullname`, `phone`, `guests`, `attend`, `message`, `ip_address`, `user_agent`, `edited_at`, `created_at`, `updated_at`) VALUES
	(1, 'rsvp_6ae129e208f189.98258039', NULL, NULL, 'Gia đình anh Chí', 'ádasd', 1, 'yes', 'ádasd', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.143.1 Chrome/150.0.7871.250 Electron/43.7.7 Safari/537.36', NULL, '2026-10-27 15:46:58', '2026-10-27 15:46:58'),
	(2, 'rsvp_6ae12b7c835822.71376915', NULL, NULL, 'Gia đình Việt Anh', 'áds', 1, 'yes', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', NULL, '2026-10-27 15:53:48', '2026-10-27 15:53:48'),
	(3, 'demo_rsvp_79f94665', 'GgBYCgtZTgtYUxImHQdOYFteWhYLUwYLk97_WSkPAEhBSQ0CDkc', 'be6c4e6d9dce5ba31a7c4168943533d11a0e01081b97620af903b194666f63d0', 'Anh Minh & chị Lan (demo)', '0919305922', 2, 'yes', 'Chúc hai bạn trăm năm hạnh phúc, sớm có tin vui nhé! 💕', '127.0.0.1', 'DemoDataSeeder', NULL, '2026-10-27 16:14:47', '2026-10-27 16:14:47'),
	(4, 'demo_rsvp_943f63f5', 'HQMNCllcGF1XBxIgGg5O6aPznlhFUwagxkU2GEVGCg0EQkE', '2b1ff2dd44026231183bd8b5987e746ad174c9c2e76ef9f48695e5f301a84475', 'Gia đình cô Ba (demo)', '0921177686', 4, 'yes', 'Cả nhà cô chúc hai con mãi yêu thương, thuận hòa.', '127.0.0.1', 'DemoDataSeeder', NULL, '2026-10-27 16:14:47', '2026-10-27 16:14:47'),
	(5, 'demo_rsvp_63e69eb1', 'GFBaC15bSFELVxIlktXPQxJkR9eX1gtDHoTP4hVOX1ooHEhHBQsKHEY', '6271f588ca8cb9894941bfa3ae59260a120999a74e603172e4833e22d445f6c3', 'Bạn Tuấn lớp 12A1 (demo)', '0935292590', 1, 'no', 'Tiếc quá hôm đó mình đi công tác, chúc mừng hai bạn nha!', '127.0.0.1', 'DemoDataSeeder', NULL, '2026-10-27 16:14:47', '2026-10-27 16:14:47');

-- Dumping structure for table wedding2026.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `key` varchar(100) NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`value`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table wedding2026.settings: ~1 rows (approximately)
INSERT INTO `settings` (`key`, `value`, `created_at`, `updated_at`) VALUES
	('media', '{"gallery_images":[{"url":"https:\\/\\/i1-vnexpress.vnecdn.net\\/2026\\/10\\/27\\/Vi-tri-Iran-jpeg-4017-1793100477.jpg?w=1020&h=0&q=100&dpr=1&fit=crop&s=TSQmiHAPxpSA8NxwkFP1pg","alt":"\\u1ea2nh kho\\u1ea3nh kh\\u1eafc c\\u01b0\\u1edbi 1","featured":true}],"moments_images":[{"url":"https:\\/\\/hn.ss.bfcplatform.vn\\/talentdad\\/ShareX\\/2026\\/06\\/chrome_iYKOBwJQnw.png","alt":"Kho\\u1ea3nh kh\\u1eafc c\\u1ee7a ch\\u00fang t\\u00f4i 1","featured":false}],"wedding_video":{"title":"Video C\\u01b0\\u1edbi C\\u1ee7a Ch\\u00fang T\\u00f4i","subtitle":"C\\u00f9ng xem l\\u1ea1i nh\\u1eefng kho\\u1ea3nh kh\\u1eafc \\u0111\\u00e1ng nh\\u1edb","youtube_url":"https:\\/\\/youtube.com\\/shorts\\/nVsYiUhuwcY","thumbnail":"https:\\/\\/i.ytimg.com\\/vi\\/nVsYiUhuwcY\\/hqdefault.jpg"},"memorize":{"cover_photo":"https:\\/\\/hn.ss.bfcplatform.vn\\/talentdad\\/ShareX\\/2026\\/06\\/chrome_bxlmb5uezs.png","avatar":"https:\\/\\/hn.ss.bfcplatform.vn\\/talentdad\\/ShareX\\/2026\\/06\\/chrome_iYKOBwJQnw.png"},"last_updated":"2026-10-27 13:57:13"}', '2026-10-27 16:14:47', '2026-10-27 16:14:47');

-- Dumping structure for table wedding2026.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table wedding2026.users: ~0 rows (approximately)

-- Dumping structure for table wedding2026.wishes
CREATE TABLE IF NOT EXISTS `wishes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `legacy_id` varchar(64) DEFAULT NULL,
  `rsvp_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `sent_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL DEFAULT '',
  `user_agent` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wishes_legacy_id_unique` (`legacy_id`),
  UNIQUE KEY `wishes_rsvp_id_unique` (`rsvp_id`),
  CONSTRAINT `wishes_rsvp_id_foreign` FOREIGN KEY (`rsvp_id`) REFERENCES `rsvps` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table wedding2026.wishes: ~5 rows (approximately)
INSERT INTO `wishes` (`id`, `legacy_id`, `rsvp_id`, `name`, `message`, `active`, `sent_at`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
	(1, 'comment_6ae129e2091201.29955497', 1, 'Gia đình anh Chí', 'ádasd', 0, '2026-10-27 15:46:58', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.143.1 Chrome/150.0.7871.250 Electron/43.7.7 Safari/537.36', '2026-10-27 15:46:58', '2026-10-27 16:14:47'),
	(2, 'comment_6ae12b7c838431.58338545', 2, 'Gia đình Việt Anh', '', 0, '2026-10-27 15:53:48', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 15:53:48', '2026-10-27 16:14:47'),
	(3, 'demo_wish_79f94665', 3, 'Anh Minh & chị Lan (demo)', 'Chúc hai bạn trăm năm hạnh phúc, sớm có tin vui nhé! 💕', 1, '2026-10-25 16:14:47', '127.0.0.1', 'DemoDataSeeder', '2026-10-27 16:14:47', '2026-10-27 16:14:47'),
	(4, 'demo_wish_943f63f5', 4, 'Gia đình cô Ba (demo)', 'Cả nhà cô chúc hai con mãi yêu thương, thuận hòa.', 1, '2026-10-25 16:14:47', '127.0.0.1', 'DemoDataSeeder', '2026-10-27 16:14:47', '2026-10-27 16:14:47'),
	(5, 'demo_wish_63e69eb1', 5, 'Bạn Tuấn lớp 12A1 (demo)', 'Tiếc quá hôm đó mình đi công tác, chúc mừng hai bạn nha!', 0, '2026-10-25 16:14:47', '127.0.0.1', 'DemoDataSeeder', '2026-10-27 16:14:47', '2026-10-27 16:14:47');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
