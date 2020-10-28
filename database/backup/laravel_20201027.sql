-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for laravel
CREATE DATABASE IF NOT EXISTS `laravel` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `laravel`;

-- Dumping structure for table laravel.articles
CREATE TABLE IF NOT EXISTS `articles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `FK_articles_users` (`user_id`),
  CONSTRAINT `FK_articles_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.articles: ~15 rows (approximately)
DELETE FROM `articles`;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` (`id`, `user_id`, `title`, `excerpt`, `body`, `created_at`, `updated_at`) VALUES
	(1, 4, 'Getting to Know Laravel', 'This is very interesting book', 'Getting to Knoe Us is a very interessting book. A must read', '2020-09-30 12:23:53', '2020-10-05 11:06:02'),
	(2, 4, 'Visual Foxpro ', 'This is very nice book.', 'Visual Foxpro is a very interessting book. A must read', '2020-09-30 13:23:54', '2020-10-05 11:07:31'),
	(3, 1, 'PC Software Made Simple', 'This is very beautiful book', 'PC Software Made Simple is a very interessting book. A must read', '2020-09-30 14:23:56', '2020-10-04 18:10:05'),
	(4, 1, 'Laravel Book', 'A lovely book', 'Laravel Book  is a very interessting book. A must read', '2020-09-30 16:23:57', '2020-10-04 18:10:09'),
	(5, 5, 'Laravel Articles', 'A good book', 'Laravel Articles  is a very interessting book. A must read', '2020-09-30 16:23:57', '2020-10-04 18:10:21'),
	(6, 1, 'My New Article', 'How to enable the snippets on a file other than html?', 'How to enable the snippets on a file other than html? The easiest way is to start a git issue, I will attempt to answer ASAP else I hope someone else will answer.', '2020-10-01 19:52:24', '2020-10-04 18:10:24'),
	(14, 5, 'Est iure neque ut voluptatem accusantium ex blanditiis.', 'Eos ea saepe architecto doloremque optio ut eligendi.', 'Voluptatem alias optio veritatis mollitia. Officia ut quae molestiae assumenda minus et quos. Harum suscipit et error enim.', '2020-10-05 13:44:16', '2020-10-05 13:44:16'),
	(15, 5, 'Per-defined Article', 'Voluptas facilis laborum suscipit culpa.', 'Quae iure rerum numquam eaque iste molestiae impedit. Doloremque dolorem quam sit aut. Provident nostrum provident eveniet consequatur nulla earum sed quasi.', '2020-10-05 13:48:37', '2020-10-05 13:48:37'),
	(16, 5, 'New Title', 'Article with hardcoded userID 5', 'Article with hardcoded userID 5', '2020-10-06 15:27:11', '2020-10-06 15:27:11'),
	(19, 5, 'Article with Tags 3', 'Article with Tags', 'Article with Tags', '2020-10-06 16:52:38', '2020-10-06 16:52:38'),
	(21, 5, 'adsf asdfadsf', 'CZXc', 'zxcZXc', '2020-10-06 21:08:38', '2020-10-06 21:08:38'),
	(22, 5, 'Trough only method', 'EX Trough only method', 'Trough only method body', '2020-10-06 21:09:42', '2020-10-06 21:09:42'),
	(26, 5, 'Dayle', 'Dayle Excerpt', NULL, '2020-10-13 17:12:31', '2020-10-13 17:12:31'),
	(27, 5, 'Dayle', 'Dayle Excerpt', NULL, '2020-10-13 17:40:41', '2020-10-13 17:40:41'),
	(28, 5, 'Dayle', 'Dayle Excerpt', NULL, '2020-10-13 17:44:36', '2020-10-13 17:44:36'),
	(29, 5, 'Dayle', 'Dayle Excerpt', NULL, '2020-10-13 17:45:45', '2020-10-13 17:45:45');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;

-- Dumping structure for table laravel.article_tag
CREATE TABLE IF NOT EXISTS `article_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `article_id` (`article_id`,`tag_id`),
  KEY `FK_article_tag_tag` (`tag_id`),
  CONSTRAINT `FK_article_tag_articles` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  CONSTRAINT `FK_article_tag_tag` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COMMENT='many to many relationship table to link articles with tags';

-- Dumping data for table laravel.article_tag: ~13 rows (approximately)
DELETE FROM `article_tag`;
/*!40000 ALTER TABLE `article_tag` DISABLE KEYS */;
INSERT INTO `article_tag` (`id`, `article_id`, `tag_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2020-10-05 11:06:29', '2020-10-05 11:06:29'),
	(2, 1, 2, '2020-10-05 11:06:45', '2020-10-05 11:06:45'),
	(3, 1, 3, '2020-10-05 11:06:50', '2020-10-05 11:06:50'),
	(4, 2, 3, '2020-10-05 11:07:54', '2020-10-05 11:07:54'),
	(5, 2, 7, '2020-10-05 11:08:02', '2020-10-05 11:08:02'),
	(7, 15, 1, '2020-10-06 12:35:39', '2020-10-06 12:35:39'),
	(8, 15, 5, '2020-10-06 12:35:39', '2020-10-06 12:35:39'),
	(9, 19, 1, '2020-10-06 12:52:38', '2020-10-06 12:52:38'),
	(10, 19, 3, '2020-10-06 12:52:38', '2020-10-06 12:52:38'),
	(11, 21, 1, '2020-10-06 17:08:39', '2020-10-06 17:08:39'),
	(12, 21, 3, '2020-10-06 17:08:39', '2020-10-06 17:08:39'),
	(13, 22, 1, '2020-10-06 17:09:42', '2020-10-06 17:09:42'),
	(14, 22, 3, '2020-10-06 17:09:42', '2020-10-06 17:09:42'),
	(15, 22, 4, '2020-10-06 17:09:42', '2020-10-06 17:09:42');
/*!40000 ALTER TABLE `article_tag` ENABLE KEYS */;

-- Dumping structure for table laravel.assignments
CREATE TABLE IF NOT EXISTS `assignments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.assignments: ~3 rows (approximately)
DELETE FROM `assignments`;
/*!40000 ALTER TABLE `assignments` DISABLE KEYS */;
INSERT INTO `assignments` (`id`, `body`, `completed`, `created_at`, `updated_at`, `due_date`) VALUES
	(1, 'Complete this assignment within 7 days', 1, '2020-09-28 19:23:43', '2020-09-28 19:57:35', NULL),
	(3, 'Second Assignment', 1, NULL, '2020-09-28 20:03:48', NULL),
	(4, 'Third Assignment (Big)', 0, NULL, NULL, NULL);
/*!40000 ALTER TABLE `assignments` ENABLE KEYS */;

-- Dumping structure for table laravel.clients
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL COMMENT 'created by user id',
  `update_user_id` bigint(20) unsigned DEFAULT NULL COMMENT 'Id of user who last updated it ',
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postalcode` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_clients_users` (`user_id`),
  KEY `FK_clients_users_2` (`update_user_id`),
  CONSTRAINT `FK_clients_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_clients_users_2` FOREIGN KEY (`update_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.clients: ~9 rows (approximately)
DELETE FROM `clients`;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` (`id`, `user_id`, `update_user_id`, `firstname`, `lastname`, `address`, `city`, `postalcode`, `phone`, `email`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, 'John', 'Lee', '5 XYZ Street', 'Scarborough', 'L7Y 2N6', '4161111222', NULL, '2020-10-22 17:24:28', '2020-10-24 16:27:31'),
	(2, 1, NULL, 'Mary', 'Comb', '9 ABC Street', 'Toronto', 'L7Y 1A4', '4161111345', NULL, '2020-10-22 17:27:42', '2020-10-24 16:27:35'),
	(3, 1, NULL, 'Phil', 'Anderson', '5 Bloor Street', 'Etobicoke', 'L7Y 1A3', '416-1111-456', NULL, '2020-10-22 17:28:06', '2020-10-24 16:27:21'),
	(4, 2, NULL, 'Brian', 'Greenspan', '5 Sample Av', 'North York', 'L7Y 1A2', '416-1111-234', 'brian@brian.com', '2020-10-22 17:28:45', '2020-10-28 01:01:14'),
	(5, 2, NULL, 'Kevin', 'Sanu', '12 Sample Street', 'AnyTown', 'L3R3G2', '1112223333', 'kk@kk.com', '2020-10-22 17:29:02', '2020-10-26 18:28:29'),
	(6, 2, NULL, 'Andrew', 'Lee', '8700 Warden Av', 'Mark', 'L3R3G4', '647-675-1234', 'lee@lee.co', '2020-10-22 17:29:26', '2020-10-26 19:01:26'),
	(7, 1, NULL, 'Lee', 'Lary', '5 ABC Street', NULL, 'L3R 5H5', '1112223333', 'lee@lee.com', '2020-10-23 20:31:48', '2020-10-26 18:57:29'),
	(8, 2, NULL, 'Johny', 'Lever', '133-105 Queen Street', 'Toronto', 'M1M 1M1', '903-123-3434', 'johny@gmail.com', '2020-10-26 16:52:21', '2020-10-26 18:42:23'),
	(9, 2, NULL, 'Raja', 'Kumar', '8 Cheeseman Dr', 'Markham', 'L3R3G2', '9054152420', 'rktaxali@gmail.com', '2020-10-26 16:53:30', '2020-10-26 16:53:30');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;

-- Dumping structure for table laravel.client_notes
CREATE TABLE IF NOT EXISTS `client_notes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `create_user_id` bigint(20) unsigned DEFAULT NULL,
  `update_user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_client_notes_clients` (`client_id`),
  KEY `FK_clients_users` (`create_user_id`) USING BTREE,
  KEY `FK_client_notes_users` (`update_user_id`),
  CONSTRAINT `FK_client_notes_clients` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `FK_client_notes_users` FOREIGN KEY (`update_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `client_notes_ibfk_1` FOREIGN KEY (`create_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='Notes for clients. ';

-- Dumping data for table laravel.client_notes: ~7 rows (approximately)
DELETE FROM `client_notes`;
/*!40000 ALTER TABLE `client_notes` DISABLE KEYS */;
INSERT INTO `client_notes` (`id`, `client_id`, `note`, `create_user_id`, `update_user_id`, `created_at`, `updated_at`) VALUES
	(1, 4, 'Globally in early history, mental illness was viewed as a religious matter. In ancient Greek, Roman, Egyptian, and Indian writings, mental illness was viewed as a personal issue and religious castigation. In the 5th century B.C., Hippocrates was the first pioneer to address mental illness through medication or adjustments in a patient’s environment. \r\n\r\nIn the mid-19th century, William Sweetser was the first to coin the term mental hygiene, which can be seen as the precursor to contemporary approaches to work on promoting positive mental health', 2, 2, '2020-10-22 17:24:28', '2020-10-26 17:57:41'),
	(3, 5, 'First Note Met at his house', 1, NULL, '2020-10-22 17:28:06', '2020-10-24 17:04:34'),
	(4, 2, 'Met for the first time.', 2, NULL, '2020-10-22 17:28:45', '2020-10-24 17:04:52'),
	(5, 6, 'Evaluated', 2, NULL, '2020-10-22 17:29:02', '2020-10-24 17:04:57'),
	(6, 6, 'Discussed plan', 2, NULL, '2020-10-22 17:29:26', '2020-10-24 17:05:26'),
	(7, 6, 'Delivered Medicines', 1, NULL, '2020-10-23 20:31:48', '2020-10-24 17:05:44'),
	(11, 4, 'Met the client at park. <br>He is doing fine for now. <br><br>Will see him again tomorrow.', 2, NULL, '2020-10-27 21:55:10', '2020-10-27 21:55:10'),
	(12, 4, 'Brian has been feeling quite low for many days. <br>I have asked him to visit the Centre on Nov 2.', 2, NULL, '2020-10-27 22:04:55', '2020-10-27 22:04:55'),
	(13, 4, 'Created by Anuj Taxali at Tue Oct 27, 2020 22:06<br><br>Brian is stable now. <br>Asked him to visit centre on Nov 2, 2020 at 10 am<br>Delivered medication.', 2, NULL, '2020-10-27 22:06:45', '2020-10-27 22:06:45'),
	(14, 4, 'Created by Anuj Taxali at Wed Oct 28, 2020 1:03<br><br>I will meet Brian on Nov 1 at 1 pm<br>I will also deliver medication.', 2, NULL, '2020-10-28 01:03:40', '2020-10-28 01:03:40');
/*!40000 ALTER TABLE `client_notes` ENABLE KEYS */;

-- Dumping structure for table laravel.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table laravel.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.jobs: ~0 rows (approximately)
DELETE FROM `jobs`;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;

-- Dumping structure for table laravel.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.migrations: ~7 rows (approximately)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2020_04_03_170309_create_tasks_table', 2),
	(5, '2014_10_12_100000_create_password_resets_table', 3),
	(13, '2020_09_28_175305_create_posts_table', 4),
	(14, '2020_09_28_184617_create_assignments_table', 4),
	(15, '2020_09_30_184053_create_articles_table', 5),
	(17, '2020_10_08_150047_create_products_table', 6),
	(18, '2020_10_15_224452_create_jobs_table', 7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table laravel.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.password_resets: ~2 rows (approximately)
DELETE FROM `password_resets`;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
	('test@test.com', '$2y$10$GbIxX8GgMXiyUULVBElV9eq1WMy4HCSoi5oQuqcgVXJcWuGWvpVDa', '2020-10-07 18:53:40');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table laravel.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `postID` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `uniqueID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'uuid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.posts: ~0 rows (approximately)
DELETE FROM `posts`;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Dumping structure for table laravel.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(22,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.products: ~3 rows (approximately)
DELETE FROM `products`;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `description`, `price`, `created_at`, `updated_at`) VALUES
	(1, 'Paper', 'Paper 1200', 1234567.12, '2020-10-08 12:37:08', NULL),
	(2, 'Pen', 'Pen Blue 2', 9.40, '2020-10-08 12:37:38', '2020-10-09 21:52:18'),
	(4, 'Kumar', NULL, 123.00, '2020-10-09 19:47:03', '2020-10-09 19:47:03');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table laravel.tags
CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COMMENT='tags that may be linked to articles';

-- Dumping data for table laravel.tags: ~9 rows (approximately)
DELETE FROM `tags`;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Laravel', '2020-10-05 11:04:16', '2020-10-05 11:04:16'),
	(2, 'PHP', '2020-10-05 11:04:23', '2020-10-05 11:04:23'),
	(3, 'Education', '2020-10-05 11:04:30', '2020-10-05 11:04:30'),
	(4, 'Personal', '2020-10-05 11:04:38', '2020-10-05 11:04:38'),
	(5, 'JavaScript', '2020-10-05 11:04:51', '2020-10-05 11:04:51'),
	(6, 'Phython', '2020-10-05 11:05:00', '2020-10-05 11:05:00'),
	(7, 'VFP', '2020-10-05 11:07:19', '2020-10-05 11:07:19'),
	(8, 'WordStar', '2020-10-13 17:04:42', '2020-10-13 17:04:42');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;

-- Dumping structure for table laravel.tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.tasks: ~0 rows (approximately)
DELETE FROM `tasks`;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;

-- Dumping structure for table laravel.uploaded_files
CREATE TABLE IF NOT EXISTS `uploaded_files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upload_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mimeType` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.uploaded_files: ~2 rows (approximately)
DELETE FROM `uploaded_files`;
/*!40000 ALTER TABLE `uploaded_files` DISABLE KEYS */;
INSERT INTO `uploaded_files` (`id`, `user_id`, `original_name`, `upload_path`, `mimeType`, `size`, `created_at`, `updated_at`) VALUES
	(40, 2, '1588887711-3886.png', 'public/uploads/eONzSBHegvYbKtMBsy70jGt0k0vOJpgNfMZBA1Y1.png', 'image/png', 685971, '2020-10-24 19:21:13', '2020-10-24 19:21:13'),
	(42, 2, 'Weeks_4_5_6.jpg', 'public/uploads/6qYf820HhoXLBBb497I1YRU8SNxCzOikSNGkTSH5.jpeg', 'image/jpeg', 961770, '2020-10-27 21:05:05', '2020-10-27 21:05:05');
/*!40000 ALTER TABLE `uploaded_files` ENABLE KEYS */;

-- Dumping structure for table laravel.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.users: ~12 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `firstname`, `lastname`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'John Anderson', 'John', 'Anderson', 'ravi@ravitaxali.com', '2020-10-04 21:31:12', '$2y$10$5Y04kRnaYQM6tz6BUVIZZORVGnOhwvE329diqUZ/CFHAsjpFx85S2', 'eiSQ9B83SW5ROv9RmpZuyYn9fnK4C9pF3EU5FwU7AHs613aOxa5nNHuX26Eb', '2020-10-04 21:31:13', '2020-10-07 18:49:35'),
	(2, 'Anuj Taxali', 'Anuj', 'Taxali', 'rktaxali@gmail.com', '2020-10-04 21:32:47', '$2y$10$XSy2rjBG8GESF5dsHN/ikOTs3PcADW8tNc5QBH0jBwur/qkA/rYtu', '1Wb8bmxeHbNatynMaE6W3XLI9D2Eeam8I4j5jFD0HKygQCBReg9lUGfjV02z', '2020-10-04 21:32:47', '2020-10-07 18:55:22'),
	(3, 'Mike Beier II', 'Mike', 'Beier', 'alverta.hansen@example.com', '2020-10-04 21:37:23', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'TYyoynxQLy', '2020-10-04 21:37:23', '2020-10-04 21:37:23'),
	(4, 'Amaya Kuhn', 'Amaya ', 'Kuhn', 'kacey21@example.net', '2020-10-04 21:37:23', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cMX5G4XeH9', '2020-10-04 21:37:23', '2020-10-04 21:37:23'),
	(5, 'Prof. Jose Bernier II', '', '', 'wisoky.vincenzo@example.net', '2020-10-04 21:37:23', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'uy6iENBH9a', '2020-10-04 21:37:23', '2020-10-04 21:37:23'),
	(6, 'Dr. Gloria Barrows', '', '', 'robin10@example.net', '2020-10-04 22:07:27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'BdNkfjyeEw', '2020-10-04 22:07:28', '2020-10-04 22:07:28'),
	(7, 'Marlene Runolfsdottir', '', '', 'swift.enid@example.net', '2020-10-04 22:10:53', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ZBr8EyR15k', '2020-10-04 22:10:53', '2020-10-04 22:10:53'),
	(8, 'Mr. Tyrel Moore', '', '', 'nicola39@example.org', '2020-10-04 22:12:06', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'KEkhlHaFKm', '2020-10-04 22:12:06', '2020-10-04 22:12:06'),
	(9, 'Dr. Niko D\'Amore Sr.', '', '', 'cschmeler@example.com', '2020-10-04 22:12:24', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lKI3kRJ5dB', '2020-10-04 22:12:24', '2020-10-04 22:12:24'),
	(10, 'Mr. Evan McKenzie', '', '', 'adan14@example.com', '2020-10-04 23:42:36', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PtCK5nps3v', '2020-10-04 23:42:37', '2020-10-04 23:42:37'),
	(11, 'Wanda Ferry', '', '', 'zgottlieb@example.net', '2020-10-04 23:42:50', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'KT7dKyCJqB', '2020-10-04 23:42:50', '2020-10-04 23:42:50'),
	(12, 'Jon', '', '', 'test@test.com', NULL, '$2y$10$8Gu3t6yIq/80e2IhPRdCtuVs9GD1WgKsW3NDLzC.BUVg8ckaHUZ2C', 'TXfx37MAbq81DsbZMaf8FfBHsXMH5qgnbwQIV7DqWNGrdfa4YWhmKfrpWHlP', '2020-10-07 16:27:12', '2020-10-07 18:31:08');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table laravel._posts
CREATE TABLE IF NOT EXISTS `_posts` (
  `postID` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) DEFAULT NULL,
  `body` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`postID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table laravel._posts: ~2 rows (approximately)
DELETE FROM `_posts`;
/*!40000 ALTER TABLE `_posts` DISABLE KEYS */;
INSERT INTO `_posts` (`postID`, `slug`, `body`) VALUES
	(1, 'my-first-post', 'This is my first post'),
	(2, 'my-second-post', 'This is my Second post');
/*!40000 ALTER TABLE `_posts` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
