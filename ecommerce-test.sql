-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 07, 2024 at 04:21 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce-test`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `slug`, `photo`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Lorem Ipsum is', 'lorem-ipsum-is', '/storage/photos/1/Banner/banner-01.jpg', '<h2><span style=\"font-weight: bold; color: rgb(99, 99, 99);\">Up to 10%</span></h2>', 'active', '2020-08-13 18:47:38', '2020-08-13 18:48:21'),
(2, 'Lorem Ipsum', 'lorem-ipsum', '/storage/photos/1/Banner/banner-07.jpg', '<p>Up to 90%</p>', 'active', '2020-08-13 18:50:23', '2020-08-13 18:50:23'),
(4, 'Banner', 'banner', '/storage/photos/1/Banner/banner-06.jpg', '<h2><span style=\"color: rgb(156, 0, 255); font-size: 2rem; font-weight: bold;\">Up to 40%</span><br></h2><h2><span style=\"color: rgb(156, 0, 255);\"></span></h2>', 'active', '2020-08-17 13:46:59', '2020-08-17 13:46:59');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `title`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Adidas', 'adidas', 'active', '2020-08-13 21:23:00', '2020-08-13 21:23:00'),
(2, 'Nike', 'nike', 'active', '2020-08-13 21:23:08', '2020-08-13 21:23:08'),
(3, 'Kappa', 'kappa', 'active', '2020-08-13 21:23:48', '2020-08-13 21:23:48'),
(4, 'Prada', 'prada', 'active', '2020-08-13 21:24:08', '2020-08-13 21:24:08'),
(6, 'Brand', 'brand', 'active', '2020-08-17 13:50:31', '2020-08-17 13:50:31');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `product_id`, `user_id`, `quantity`, `created_at`, `updated_at`) VALUES
(3, 1, 2, 5, '2024-01-07 08:53:45', '2024-01-07 08:54:01');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_parent` tinyint(1) DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `summary`, `photo`, `is_parent`, `status`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Men\'s Fashion', 'mens-fashion', NULL, '/storage/photos/1/Category/mini-banner1.jpg', 1, 'active', NULL, '2020-08-13 21:26:15', '2020-08-13 21:26:15'),
(2, 'Women\'s Fashion', 'womens-fashion', NULL, '/storage/photos/1/Category/mini-banner2.jpg', 1, 'active', NULL, '2020-08-13 21:26:40', '2020-08-13 21:26:40'),
(3, 'Kid\'s', 'kids', NULL, '/storage/photos/1/Category/mini-banner3.jpg', 1, 'active', NULL, '2020-08-13 21:27:10', '2020-08-13 21:27:42'),
(4, 'T-shirt\'s', 't-shirts', NULL, NULL, 0, 'active', 1, '2020-08-13 21:32:14', '2020-08-13 21:32:14'),
(5, 'Jeans pants', 'jeans-pants', NULL, NULL, 0, 'active', 1, '2020-08-13 21:32:49', '2020-08-13 21:32:49'),
(6, 'Sweater & Jackets', 'sweater-jackets', NULL, '0', 1, 'active', NULL, '2020-08-13 21:33:37', '2020-08-13 21:33:37'),
(7, 'Rain Coats & Trenches', 'rain-coats-trenches', NULL, '0', 1, 'active', NULL, '2020-08-13 21:34:04', '2020-08-13 21:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('fixed','percent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `value` decimal(20,2) NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `user_id`, `code`, `type`, `value`, `status`, `expiry_date`, `created_at`, `updated_at`) VALUES
(1, NULL, 'COUPON-659aca2a30495', 'fixed', '10000.00', 'inactive', '2024-04-07', '2024-01-07 08:58:34', '2024-01-07 08:58:34'),
(2, NULL, 'COUPON-659acb3f6a5c4', 'fixed', '10000.00', 'inactive', '2024-04-07', '2024-01-07 09:03:11', '2024-01-07 09:03:11'),
(3, NULL, 'COUPON-659acebd69d5e', 'fixed', '10000.00', 'inactive', '2024-04-07', '2024-01-07 09:18:05', '2024-01-07 09:18:05');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_01_06_133417_create_settings_table', 1),
(6, '2024_01_06_135917_create_permission_tables', 1),
(7, '2024_01_06_135957_create_brands_table', 1),
(8, '2024_01_06_140035_create_banners_table', 1),
(9, '2024_01_06_143024_create_categories_table', 1),
(10, '2024_01_06_145001_create_products_table', 1),
(11, '2024_01_06_145356_create_messages_table', 1),
(12, '2024_01_06_145619_create_carts_table', 1),
(13, '2024_01_06_145810_create_coupons_table', 1),
(14, '2024_01_06_145942_create_wishlists_table', 1),
(15, '2024_01_06_150019_create_reviews_table', 1),
(16, '2024_01_06_172144_create_notifications_table', 1),
(17, '2024_01_07_101632_create_orders_table', 1),
(18, '2024_01_07_101853_create_payments_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` double(10,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('paid','unpaid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `status` enum('new','process','delivered','cancel') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `coupon_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `total_amount`, `payment_method`, `payment_status`, `status`, `user_id`, `coupon_id`, `created_at`, `updated_at`) VALUES
(1, 'ORD-659ac63362b96', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:41:39', '2024-01-07 08:41:39'),
(2, 'ORD-659ac6a4326e3', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:43:32', '2024-01-07 08:43:32'),
(3, 'ORD-659ac6b1aba90', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:43:45', '2024-01-07 08:43:45'),
(4, 'ORD-659ac6c8b2142', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:44:08', '2024-01-07 08:44:08'),
(5, 'ORD-659ac6d36b150', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:44:19', '2024-01-07 08:44:19'),
(6, 'ORD-659ac6f2b9bd3', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:44:50', '2024-01-07 08:44:50'),
(7, 'ORD-659ac70ad5929', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:45:14', '2024-01-07 08:45:14'),
(8, 'ORD-659ac71c71f3a', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:45:32', '2024-01-07 08:45:32'),
(9, 'ORD-659ac72a63f66', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:45:46', '2024-01-07 08:45:46'),
(10, 'ORD-659ac730ece00', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:45:52', '2024-01-07 08:45:52'),
(11, 'ORD-659ac78c34ce6', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:47:24', '2024-01-07 08:47:24'),
(12, 'ORD-659ac79286380', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:47:30', '2024-01-07 08:47:30'),
(13, 'ORD-659ac7a9a276f', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:47:53', '2024-01-07 08:47:53'),
(14, 'ORD-659ac7b90cd90', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:48:09', '2024-01-07 08:48:09'),
(15, 'ORD-659ac7bfd8cf3', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:48:15', '2024-01-07 08:48:15'),
(16, 'ORD-659ac7d60dfd9', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:48:38', '2024-01-07 08:48:38'),
(17, 'ORD-659ac7f340a35', 500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:49:07', '2024-01-07 08:49:07'),
(18, 'ORD-659ac8b47249a', 2500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:52:20', '2024-01-07 08:52:20'),
(19, 'ORD-659ac8d3dd4bc', 2500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:52:51', '2024-01-07 08:52:51'),
(20, 'ORD-659ac92950d90', 2500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:54:17', '2024-01-07 08:54:17'),
(21, 'ORD-659aca0262ba3', 2500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:57:54', '2024-01-07 08:57:54'),
(22, 'ORD-659aca1b4cd29', 2500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:58:19', '2024-01-07 08:58:19'),
(23, 'ORD-659aca29034ad', 2500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 08:58:33', '2024-01-07 08:58:33'),
(24, 'ORD-659acb3eaf839', 2500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 09:03:10', '2024-01-07 09:03:10'),
(25, 'ORD-659acebcd7724', 2500000.00, 'OVO', 'unpaid', 'new', 2, NULL, '2024-01-07 09:18:04', '2024-01-07 09:18:04');

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` double(8,2) NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`id`, `quantity`, `price`, `order_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 1, 500000.00, 17, 1, '2024-01-07 08:49:07', '2024-01-07 08:49:07'),
(2, 5, 500000.00, 19, 1, '2024-01-07 08:52:52', '2024-01-07 08:52:52'),
(3, 5, 500000.00, 20, 1, '2024-01-07 08:54:18', '2024-01-07 08:54:18'),
(4, 5, 500000.00, 21, 1, '2024-01-07 08:57:55', '2024-01-07 08:57:55'),
(5, 5, 500000.00, 22, 1, '2024-01-07 08:58:19', '2024-01-07 08:58:19'),
(6, 5, 500000.00, 23, 1, '2024-01-07 08:58:34', '2024-01-07 08:58:34'),
(7, 5, 500000.00, 24, 1, '2024-01-07 09:03:11', '2024-01-07 09:03:11'),
(8, 5, 500000.00, 25, 1, '2024-01-07 09:18:05', '2024-01-07 09:18:05');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merchant_ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `order_id`, `reference`, `method`, `merchant_ref`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 15, 'DEV-T20738137767VMZHP', 'OVO', NULL, 500000, 'UNPAID', '2024-01-07 08:48:16', '2024-01-07 08:48:16'),
(2, 2, 16, 'DEV-T20738137768HCJZD', 'OVO', NULL, 500000, 'UNPAID', '2024-01-07 08:48:38', '2024-01-07 08:48:38'),
(3, 2, 17, 'DEV-T20738137769MDVXI', 'OVO', NULL, 500000, 'UNPAID', '2024-01-07 08:49:07', '2024-01-07 08:49:07'),
(4, 2, 19, 'DEV-T207381377716I4HV', 'OVO', NULL, 2500000, 'UNPAID', '2024-01-07 08:52:52', '2024-01-07 08:52:52'),
(5, 2, 20, 'DEV-T20738137772O8MBV', 'OVO', NULL, 2500000, 'UNPAID', '2024-01-07 08:54:18', '2024-01-07 08:54:18'),
(6, 2, 21, 'DEV-T20738137773ZFJCL', 'OVO', NULL, 2500000, 'UNPAID', '2024-01-07 08:57:55', '2024-01-07 08:57:55'),
(7, 2, 22, 'DEV-T20738137774HSRRU', 'OVO', NULL, 2500000, 'UNPAID', '2024-01-07 08:58:19', '2024-01-07 08:58:19'),
(8, 2, 23, 'DEV-T20738137775K9DYO', 'OVO', NULL, 2500000, 'UNPAID', '2024-01-07 08:58:34', '2024-01-07 08:58:34'),
(9, 2, 24, 'DEV-T207381377762EKK2', 'OVO', NULL, 2500000, 'UNPAID', '2024-01-07 09:03:11', '2024-01-07 09:03:11'),
(10, 2, 25, 'DEV-T20738137780DQ6T1', 'OVO', NULL, 2500000, 'UNPAID', '2024-01-07 09:18:05', '2024-01-07 09:18:05');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `photo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int NOT NULL DEFAULT '1',
  `condition` enum('default','new','hot') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `price` double NOT NULL,
  `is_featured` tinyint(1) NOT NULL,
  `brand_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `slug`, `summary`, `description`, `photo`, `stock`, `condition`, `status`, `price`, `is_featured`, `brand_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Baju', 'baju', '<p>Baju</p>', '<p>Baju</p>', 'http://localhost:8000/storage/photos/1/Products/1d60f-2.jpg', 100, 'default', 'active', 500000, 1, 6, 7, '2024-01-07 08:35:37', '2024-01-07 08:35:37');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2024-01-07 08:30:37', '2024-01-07 08:30:37'),
(2, 'user', 'web', '2024-01-07 08:30:37', '2024-01-07 08:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_des` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `description`, `short_des`, `logo`, `photo`, `address`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.', 'logo.png', 'photo.png', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.', '1234567890', 'eshop@gmail.com', '2024-01-07 08:30:38', '2024-01-07 08:30:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `address` text COLLATE utf8mb4_unicode_ci,
  `post_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `photo`, `phone`, `status`, `address`, `post_code`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Admin', 'admin@gmail.com', NULL, '$2y$12$4oQOcpzRj9iJlJv/MHGEF.04ktB9hOHF/qGnLVjJgSHBxrs8CauA6', NULL, NULL, 'active', NULL, NULL, NULL, '2024-01-07 08:30:37', '2024-01-07 08:30:37'),
(2, 'Horas', 'Siregar', 'amsalsiregar12@gmail.com', NULL, '$2y$12$.Qa1IuSnJB4RNT/mJR9rB.NsDAdlgoDI7CYlswPGgsh.Ay8G7RfdS', NULL, '082386143124', 'active', 'JL Segar No 178', '28281', NULL, '2024-01-07 08:30:38', '2024-01-07 09:03:10');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `banners_slug_unique` (`slug`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`),
  ADD KEY `coupons_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_coupon_id_foreign` (`coupon_id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_products_order_id_foreign` (`order_id`),
  ADD KEY `order_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_user_id_foreign` (`user_id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
