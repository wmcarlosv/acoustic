-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2021 at 02:42 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acoustic_empty`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_language`
--

CREATE TABLE `admin_language` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_language`
--

INSERT INTO `admin_language` (`id`, `name`, `file`, `image`, `direction`, `status`, `created_at`, `updated_at`) VALUES
(1, 'English', 'English.json', 'English.jpg', 'ltr', 1, NULL, NULL),
(2, 'Arabic', 'Arabic.json', 'Arabic.jpg', 'rtl', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `advertisement`
--

CREATE TABLE `advertisement` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `network` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `interval` int(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `all_reports`
--

CREATE TABLE `all_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_user`
--

CREATE TABLE `app_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'noimage.jpg',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bdate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_verify` tinyint(1) NOT NULL DEFAULT 0,
  `device_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` int(11) DEFAULT NULL,
  `follower_request` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'private =1, public = 0',
  `mention_not` tinyint(1) NOT NULL DEFAULT 1,
  `like_not` tinyint(1) NOT NULL DEFAULT 1,
  `comment_not` tinyint(1) NOT NULL DEFAULT 1,
  `follow_not` tinyint(1) NOT NULL DEFAULT 1,
  `request_not` tinyint(1) NOT NULL DEFAULT 1,
  `not_interested` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report` int(10) NOT NULL DEFAULT 0,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audio`
--

CREATE TABLE `audio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blocked`
--

CREATE TABLE `blocked` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blocked_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `challenge`
--

CREATE TABLE `challenge` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashtags` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `name`, `order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Hindi', 3, 1, '2020-12-09 23:05:59', '2021-01-19 06:57:07'),
(2, 'English', 2, 1, '2020-12-09 23:06:27', '2021-01-19 06:57:07'),
(3, 'Panjabi', 6, 1, '2020-12-09 23:06:58', '2021-01-19 06:57:07'),
(4, 'Gujarati', 7, 1, '2020-12-09 23:07:26', '2021-01-19 06:57:00'),
(5, 'Tamil', 4, 1, '2020-12-09 23:07:39', '2021-01-19 06:57:07'),
(6, 'Telugu', 5, 1, '2020-12-09 23:07:48', '2021-01-19 06:57:07'),
(7, 'Marathi', 1, 1, '2020-12-09 23:08:12', '2021-01-19 06:57:07'),
(8, 'Bengali', 8, 1, '2020-12-09 23:08:26', '2021-01-19 06:56:51');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'user_id',
  `likeable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `likeable_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_12_04_051632_create_settings_table', 2),
(5, '2020_12_04_102507_create_permission_tables', 3),
(6, '2020_12_05_090108_create_banner_table', 4),
(7, '2020_12_05_124643_create_app_user_table', 5),
(8, '2016_06_01_000001_create_oauth_auth_codes_table', 6),
(9, '2016_06_01_000002_create_oauth_access_tokens_table', 6),
(10, '2016_06_01_000003_create_oauth_refresh_tokens_table', 6),
(11, '2016_06_01_000004_create_oauth_clients_table', 6),
(12, '2016_06_01_000005_create_oauth_personal_access_clients_table', 6),
(13, '2020_12_08_052428_create_challenge_table', 7),
(14, '2020_12_08_085045_create_song_table', 8),
(15, '2020_12_08_085532_create_song_section_table', 8),
(16, '2020_12_09_061049_create_comments_table', 9),
(17, '2020_04_04_000000_create_user_follower_table', 10),
(18, '2018_12_14_000000_create_likes_table', 11),
(19, '2020_12_09_111613_create_reports_table', 12),
(20, '2020_12_10_041739_create_language_table', 13),
(21, '2020_12_10_054139_create_video_table', 14),
(22, '2020_12_11_050134_create_notification_template_table', 15),
(23, '2020_12_11_124134_create_problem_table', 16),
(24, '2020_12_14_111951_create_audio_table', 17),
(25, '2017_03_04_000000_create_bans_table', 18),
(26, '2020_12_15_085808_add_banned_at_column_to_app_user_table', 19),
(27, '2020_12_15_091225_create_blocked_table', 20),
(28, '2020_12_15_120354_create_notification_table', 21),
(29, '2020_12_17_093132_create_saved_video_table', 22),
(30, '2020_12_29_040502_create_all_reports_table', 23),
(31, '2021_01_01_112734_create_song_favorite_table', 24),
(32, '2021_01_04_061732_create_song_admin_language_table', 25),
(35, '2021_01_16_081051_create_views_table', 26),
(36, '2021_07_01_051053_create_advertisement_table', 26);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'auth',
  `friend_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'whose',
  `video_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'video_id',
  `comment_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_template`
--

CREATE TABLE `notification_template` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_template`
--

INSERT INTO `notification_template` (`id`, `title`, `subject`, `mail_content`, `msg_content`, `created_at`, `updated_at`) VALUES
(1, 'Mention Video', 'Mention Video', '123', '{UserId} mention you in a video.', '2020-12-11 05:12:40', '2020-12-22 22:23:43'),
(2, 'Mention Comment', 'Mention Comment', '123', '{UserId} mention you in a comment.', '2020-12-11 05:22:07', '2020-12-22 22:23:48'),
(3, 'Like Video', 'Like Video', '123', '{UserId} liked your video.', '2020-12-11 01:23:45', '2020-12-22 22:23:54'),
(4, 'Like Comment', 'Like Comment', '<p>123</p>', '{UserId} liked your comment.', '2020-12-22 06:57:00', '2020-12-22 07:33:28'),
(5, 'Video Comment', 'Video Comment', '<p>123</p>', '{UserId} commented on your video.', '2020-12-22 06:57:45', '2020-12-22 22:24:03'),
(6, 'Follow', 'Follow', '<p>123</p>', '{UserId} started following you.', '2020-12-22 06:58:17', '2020-12-22 22:24:12'),
(7, 'Request', 'Request', '<p>123</p>', '{UserId} requested to follow you.', '2020-12-22 06:58:18', '2020-12-22 22:24:08'),
(8, 'User Verification', 'User Verification', '<p>Dear {UserName},</p><p>Your Verification code is {OTP}.</p><p>From {AdminName}.<br></p>', 'Dear {UserName}, Your Verification code is {OTP}. From {AdminName}.', '2021-01-02 03:16:21', '2021-01-02 03:17:09');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('65b68d773f792ffeae0ada6c9b50dd746181e0e2703ee4ec290a5240733858314f143e0ec473b6dd', 1, 1, 'Acoustic', '[]', 0, '2021-06-20 23:40:30', '2021-06-20 23:40:30', '2022-06-21 05:10:30'),
('cf1af1e5de787ff53354dda8d073c6aad7c75ba4e0f193f63a618891522892af2c02b0edacfddeb4', 2, 1, 'Acoustic', '[]', 0, '2021-06-21 00:02:56', '2021-06-21 00:02:56', '2022-06-21 05:32:56');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Acoustic Personal Access Client', 'O7tbmNMxa5REe4os3scoYGFvQoaTZEyACwnRJt8m', NULL, 'http://localhost', 1, 0, 0, '2020-12-07 23:33:59', '2020-12-07 23:33:59'),
(2, NULL, 'Acoustic Password Grant Client', 'fxJa92uCsMJVU9xZVB7i5RoPBF1ZVAjD6a3ECpi9', 'users', 'http://localhost', 0, 1, 0, '2020-12-07 23:33:59', '2020-12-07 23:33:59');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-12-07 23:33:59', '2020-12-07 23:33:59');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin_dashboard', 'web', '2020-12-04 05:00:20', '2020-12-04 05:00:20'),
(2, 'role_access', 'web', '2020-12-04 06:33:50', '2020-12-04 06:33:50'),
(3, 'role_create', 'web', '2020-12-04 06:34:07', '2020-12-04 06:34:07'),
(4, 'role_edit', 'web', '2020-12-04 06:34:40', '2020-12-04 06:34:40'),
(5, 'role_delete', 'web', '2020-12-04 06:34:54', '2020-12-04 06:34:54'),
(6, 'banner_access', 'web', '2020-12-05 03:22:20', '2020-12-05 03:22:20'),
(7, 'banner_create', 'web', '2020-12-05 03:22:20', '2020-12-05 03:22:20'),
(8, 'banner_edit', 'web', '2020-12-05 03:22:20', '2020-12-05 03:22:20'),
(9, 'banner_delete', 'web', '2020-12-05 03:22:20', '2020-12-05 03:22:20'),
(10, 'challenge_access', 'web', '2020-12-07 23:59:36', '2020-12-07 23:59:36'),
(11, 'challenge_create', 'web', '2020-12-07 23:59:36', '2020-12-07 23:59:36'),
(12, 'challenge_edit', 'web', '2020-12-07 23:59:36', '2020-12-07 23:59:36'),
(13, 'challenge_delete', 'web', '2020-12-07 23:59:36', '2020-12-07 23:59:36'),
(14, 'song_section_access', 'web', '2020-12-08 03:34:20', '2020-12-08 03:34:20'),
(15, 'song_section_create', 'web', '2020-12-08 03:34:20', '2020-12-08 03:34:20'),
(16, 'song_section_edit', 'web', '2020-12-08 03:34:20', '2020-12-08 03:34:20'),
(17, 'song_section_delete', 'web', '2020-12-08 03:34:20', '2020-12-08 03:34:20'),
(18, 'song_access', 'web', '2020-12-08 03:34:37', '2020-12-08 03:34:37'),
(19, 'song_create', 'web', '2020-12-08 03:34:37', '2020-12-08 03:34:37'),
(20, 'song_edit', 'web', '2020-12-08 03:34:37', '2020-12-08 03:34:37'),
(21, 'song_delete', 'web', '2020-12-08 03:34:38', '2020-12-08 03:34:38'),
(22, 'comment_access', 'web', '2020-12-09 04:08:10', '2020-12-09 04:08:10'),
(23, 'comment_create', 'web', '2020-12-09 04:08:10', '2020-12-09 04:08:10'),
(24, 'comment_edit', 'web', '2020-12-09 04:08:10', '2020-12-09 04:08:10'),
(25, 'comment_delete', 'web', '2020-12-09 04:08:10', '2020-12-09 04:08:10'),
(26, 'comment_report_access', 'web', '2020-12-09 04:09:29', '2020-12-09 04:09:29'),
(27, 'comment_report_create', 'web', '2020-12-09 04:09:29', '2020-12-09 04:09:29'),
(28, 'comment_report_edit', 'web', '2020-12-09 04:09:29', '2020-12-09 04:09:29'),
(29, 'comment_report_delete', 'web', '2020-12-09 04:09:29', '2020-12-09 04:09:29'),
(30, 'report_reason_access', 'web', '2020-12-09 05:40:25', '2020-12-09 05:40:25'),
(31, 'report_reason_create', 'web', '2020-12-09 05:40:25', '2020-12-09 05:40:25'),
(32, 'report_reason_edit', 'web', '2020-12-09 05:40:25', '2020-12-09 05:40:25'),
(33, 'report_reason_delete', 'web', '2020-12-09 05:40:25', '2020-12-09 05:40:25'),
(34, 'app_user_access', 'web', '2020-12-09 07:34:48', '2020-12-09 07:34:48'),
(35, 'app_user_create', 'web', '2020-12-09 07:34:48', '2020-12-09 07:34:48'),
(36, 'app_user_edit', 'web', '2020-12-09 07:34:48', '2020-12-09 07:34:48'),
(37, 'app_user_delete', 'web', '2020-12-09 07:34:48', '2020-12-09 07:34:48'),
(38, 'language_access', 'web', '2020-12-09 22:50:17', '2020-12-09 22:50:17'),
(39, 'language_create', 'web', '2020-12-09 22:50:17', '2020-12-09 22:50:17'),
(40, 'language_edit', 'web', '2020-12-09 22:50:17', '2020-12-09 22:50:17'),
(41, 'language_delete', 'web', '2020-12-09 22:50:17', '2020-12-09 22:50:17'),
(42, 'video_access', 'web', '2020-12-10 01:37:18', '2020-12-10 01:37:18'),
(43, 'video_create', 'web', '2020-12-10 01:37:18', '2020-12-10 01:37:18'),
(44, 'video_edit', 'web', '2020-12-10 01:37:18', '2020-12-10 01:37:18'),
(45, 'video_delete', 'web', '2020-12-10 01:37:18', '2020-12-10 01:37:18'),
(46, 'notification_access', 'web', '2020-12-10 23:30:18', '2020-12-10 23:30:18'),
(47, 'notification_create', 'web', '2020-12-10 23:30:18', '2020-12-10 23:30:18'),
(48, 'notification_edit', 'web', '2020-12-10 23:30:18', '2020-12-10 23:30:18'),
(49, 'notification_delete', 'web', '2020-12-10 23:30:18', '2020-12-10 23:30:18'),
(50, 'settings_access', 'web', '2020-12-11 01:32:35', '2020-12-11 01:32:35'),
(51, 'settings_edit', 'web', '2020-12-11 01:32:35', '2020-12-11 01:32:35'),
(52, 'user_problem_access', 'web', '2020-12-13 22:23:16', '2020-12-13 22:23:16'),
(53, 'user_problem_edit', 'web', '2020-12-13 22:23:16', '2020-12-13 22:23:16'),
(54, 'user_problem_delete', 'web', '2020-12-13 22:23:16', '2020-12-13 22:23:16'),
(55, 'app_user_report_access', 'web', '2020-12-28 23:29:28', '2020-12-28 23:29:28'),
(56, 'app_user_report_create', 'web', '2020-12-28 23:29:28', '2020-12-28 23:29:28'),
(57, 'app_user_report_edit', 'web', '2020-12-28 23:29:28', '2020-12-28 23:29:28'),
(58, 'app_user_report_delete', 'web', '2020-12-28 23:29:28', '2020-12-28 23:29:28'),
(59, 'video_report_access', 'web', '2020-12-29 01:32:09', '2020-12-29 01:32:09'),
(60, 'video_report_create', 'web', '2020-12-29 01:32:09', '2020-12-29 01:32:09'),
(61, 'video_report_edit', 'web', '2020-12-29 01:32:09', '2020-12-29 01:32:09'),
(62, 'video_report_delete', 'web', '2020-12-29 01:32:09', '2020-12-29 01:32:09'),
(63, 'admin_user_access', 'web', '2021-01-06 00:19:14', '2021-01-06 00:19:14'),
(64, 'admin_user_create', 'web', '2021-01-06 00:19:14', '2021-01-06 00:19:14'),
(65, 'admin_user_edit', 'web', '2021-01-06 00:19:14', '2021-01-06 00:19:14'),
(66, 'admin_user_delete', 'web', '2021-01-06 00:19:14', '2021-01-06 00:19:14'),
(67, 'report_access', 'web', '2021-01-06 03:47:19', '2021-01-06 03:47:19'),
(68, 'advertisement_access', 'web', '2021-06-30 22:17:55', '2021-06-30 22:17:55'),
(69, 'advertisement_create', 'web', '2021-06-30 22:18:45', '2021-06-30 22:18:45'),
(70, 'advertisement_edit', 'web', '2021-06-30 22:19:15', '2021-06-30 22:19:15'),
(71, 'advertisement_delete', 'web', '2021-06-30 22:19:27', '2021-06-30 22:19:27');

-- --------------------------------------------------------

--
-- Table structure for table `problem`
--

CREATE TABLE `problem` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ss` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ans` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `reason`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Spam or misleading', '[\"Comment\",\"Video\"]', 1, '2020-12-09 06:35:48', '2020-12-23 23:49:25'),
(2, 'Captions issues', '[\"Comment\",\"Video\"]', 1, '2020-12-09 06:38:13', '2020-12-23 23:49:32'),
(3, 'Violent or repulsive content', '[\"Video\"]', 1, '2020-12-09 06:40:21', '2020-12-23 23:50:48'),
(4, 'Hateful or abusive content', '[\"Comment\",\"Video\"]', 1, '2020-12-09 06:41:23', '2020-12-23 23:51:06'),
(5, 'Harmful dangerous acts', '[\"Video\"]', 1, '2020-12-09 06:43:54', '2020-12-24 00:01:07'),
(6, 'Child abuse', '[\"Video\"]', 1, '2020-12-09 06:44:23', '2020-12-24 00:01:15'),
(8, 'Other', '[\"User\",\"Comment\",\"Video\"]', 1, '2020-12-09 07:15:36', '2020-12-09 07:15:36'),
(9, 'Promotes terrorism', '[\"User\",\"Comment\",\"Video\"]', 1, '2020-12-10 07:03:24', '2020-12-10 07:03:24'),
(10, 'Pretend to be someone else', '[\"User\"]', 1, '2020-12-23 23:31:39', '2020-12-24 00:01:52');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2021-07-06 12:39:58', '2021-07-06 12:39:58');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saved_video`
--

CREATE TABLE `saved_video` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guest_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_footer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bg_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `white_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `black_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `splash_screen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mapkey` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `radius` int(11) NOT NULL,
  `trending_challenge` int(20) DEFAULT NULL,
  `terms_of_use` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privacy_policy` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification` tinyint(1) NOT NULL,
  `app_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_key` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_key` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_no` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_host` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_port` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_encryption` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twilio_acc_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twilio_phone_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twilio_auth_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_client_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_status` tinyint(1) NOT NULL DEFAULT 0,
  `auto_approve` tinyint(1) DEFAULT NULL,
  `is_verify` tinyint(1) DEFAULT NULL,
  `verify_email` tinyint(1) NOT NULL,
  `verify_sms` tinyint(1) NOT NULL,
  `is_watermark` tinyint(1) NOT NULL DEFAULT 0,
  `watermark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vid_qty` int(20) NOT NULL,
  `share_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admob` tinyint(1) NOT NULL DEFAULT 0,
  `android_admob_app_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `android_banner` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `android_interstitial` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `android_native` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ios_admob_app_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ios_banner` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ios_interstitial` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ios_native` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` tinyint(1) NOT NULL DEFAULT 0,
  `facebook_init` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `guest_user`, `app_name`, `app_version`, `app_footer`, `bg_img`, `color`, `white_logo`, `black_logo`, `color_logo`, `favicon`, `splash_screen`, `currency_code`, `currency_symbol`, `mapkey`, `radius`, `trending_challenge`, `terms_of_use`, `privacy_policy`, `notification`, `app_id`, `api_key`, `auth_key`, `project_no`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `sender_email`, `main_encryption`, `twilio_acc_id`, `twilio_phone_no`, `twilio_auth_token`, `license_code`, `license_client_name`, `license_status`, `auto_approve`, `is_verify`, `verify_email`, `verify_sms`, `is_watermark`, `watermark`, `vid_qty`, `share_url`, `created_at`, `updated_at`, `admob`, `android_admob_app_id`, `android_banner`, `android_interstitial`, `android_native`, `ios_admob_app_id`, `ios_banner`, `ios_interstitial`, `ios_native`, `facebook`, `facebook_init`, `facebook_banner`) VALUES
(1, '0', 'Acoustic', '1.0.0', 'Copyright © 2021 Acoustic. All Rights Reserved', 'bg_img.jpg', '#36446B', 'White_Logo_5fd34d2dd742d.png', NULL, 'Color_Logo_5fd34c32e6924.png', 'Favicon_60bb76da05fa0.png', NULL, NULL, NULL, NULL, 0, 20, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit ametLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscingLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit ametLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscingLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0, 1, 'Watermark_60cdbc6a06429.png', 30, 'https://google.com/', NULL, '2021-07-06 07:20:04', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `song`
--

CREATE TABLE `song` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `audio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `artist` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `movie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `song_favorite`
--

CREATE TABLE `song_favorite` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `song_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `song_section`
--

CREATE TABLE `song_section` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'noimage.jpg',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `image`, `status`, `remember_token`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@gmail.com', NULL, '$2y$10$xY6Ejw1d68yqkWSZZadnQu6YppZZpQAjibZH16L7QW8AaqTYvpAJy', 'noimage.jpg', 1, NULL, NULL, '2021-07-06 12:37:38', '2021-07-06 12:37:38');

-- --------------------------------------------------------

--
-- Table structure for table `user_follower`
--

CREATE TABLE `user_follower` (
  `id` int(10) UNSIGNED NOT NULL,
  `following_id` bigint(20) UNSIGNED NOT NULL,
  `follower_id` bigint(20) UNSIGNED NOT NULL,
  `accepted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `song_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audio_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hashtags` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_tags` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `screenshot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `view` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'public, private, followers',
  `is_duet` tinyint(1) NOT NULL DEFAULT 1,
  `is_comment` tinyint(1) NOT NULL DEFAULT 1,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `viewable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `viewable_id` bigint(20) UNSIGNED NOT NULL,
  `visitor` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_language`
--
ALTER TABLE `admin_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advertisement`
--
ALTER TABLE `advertisement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `all_reports`
--
ALTER TABLE `all_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_user`
--
ALTER TABLE `app_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app_user_email_unique` (`email`);

--
-- Indexes for table `audio`
--
ALTER TABLE `audio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blocked`
--
ALTER TABLE `blocked`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `challenge`
--
ALTER TABLE `challenge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `likes_likeable_type_likeable_id_index` (`likeable_type`,`likeable_id`),
  ADD KEY `likes_user_id_index` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_template`
--
ALTER TABLE `notification_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `problem`
--
ALTER TABLE `problem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `saved_video`
--
ALTER TABLE `saved_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `song_favorite`
--
ALTER TABLE `song_favorite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `song_section`
--
ALTER TABLE `song_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_follower`
--
ALTER TABLE `user_follower`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_follower_following_id_index` (`following_id`),
  ADD KEY `user_follower_follower_id_index` (`follower_id`),
  ADD KEY `user_follower_accepted_at_index` (`accepted_at`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `views_viewable_type_viewable_id_index` (`viewable_type`,`viewable_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_language`
--
ALTER TABLE `admin_language`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `advertisement`
--
ALTER TABLE `advertisement`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `all_reports`
--
ALTER TABLE `all_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_user`
--
ALTER TABLE `app_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audio`
--
ALTER TABLE `audio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blocked`
--
ALTER TABLE `blocked`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `challenge`
--
ALTER TABLE `challenge`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_template`
--
ALTER TABLE `notification_template`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `problem`
--
ALTER TABLE `problem`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `saved_video`
--
ALTER TABLE `saved_video`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `song`
--
ALTER TABLE `song`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `song_favorite`
--
ALTER TABLE `song_favorite`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `song_section`
--
ALTER TABLE `song_section`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_follower`
--
ALTER TABLE `user_follower`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
