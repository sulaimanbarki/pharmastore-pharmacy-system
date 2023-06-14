-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 14, 2023 at 05:46 PM
-- Server version: 5.7.36
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmastore`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Tablet', 1, NULL, NULL, NULL, NULL),
(2, 'Capsule', 1, NULL, NULL, NULL, NULL),
(3, 'Syrup', 1, NULL, NULL, NULL, NULL),
(4, 'Drop', 1, NULL, NULL, NULL, NULL),
(5, 'Injection', 1, NULL, NULL, NULL, NULL),
(6, 'Saline', 1, NULL, NULL, NULL, NULL),
(7, 'Suppository', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`client_id`),
  UNIQUE KEY `clients_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
CREATE TABLE IF NOT EXISTS `discounts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `categories` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `minPurchase` double(8,2) NOT NULL DEFAULT '0.00',
  `description` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `image` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `generic_names`
--

DROP TABLE IF EXISTS `generic_names`;
CREATE TABLE IF NOT EXISTS `generic_names` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `generic_names_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `generic_names`
--

INSERT INTO `generic_names` (`id`, `name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Paracetamol', 1, NULL, NULL, NULL, NULL),
(2, 'Omeprazole', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_groups`
--

DROP TABLE IF EXISTS `medicine_groups`;
CREATE TABLE IF NOT EXISTS `medicine_groups` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `medicine_groups_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `medicine_groups`
--

INSERT INTO `medicine_groups` (`id`, `name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Allopathy', 1, NULL, NULL, NULL, NULL),
(2, 'Homeopathy', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_26_130355_create_test2s_table', 1),
(4, '2019_08_29_053641_create_categories_table', 1),
(5, '2019_09_11_035549_create_medicine_groups_table', 1),
(6, '2019_09_11_125320_create_product_table', 1),
(7, '2019_09_12_070636_create_generic_names_table', 1),
(8, '2019_09_12_070656_create_supplier_table', 1),
(9, '2019_09_17_154454_create_discounts_table', 1),
(10, '2019_09_24_1022412_create_supplier_invoices_table', 1),
(11, '2019_09_24_163620_create_supplier_invoice_productinfo_table', 1),
(12, '2019_09_25_045536_create_settings_table', 1),
(13, '2019_09_25_063430_create_users_roles_table', 1),
(14, '2019_09_25_082012_create_payment_methods_table', 1),
(15, '2019_10_04_073817_create_shipping_methods_table', 1),
(16, '2019_10_06_034350_create_orders_table', 1),
(17, '2019_11_27_125602_create_order_products_table', 1),
(18, '2020_01_08_155255_create_wish_lists_table', 1),
(19, '2020_01_22_025421_create_jobs_table', 1),
(20, '2020_05_13_153202_create_order_policy_table', 1),
(21, '2020_08_15_203632_create_clients_table', 1),
(22, '2020_08_25_153458_create_payments_table', 1),
(23, '2020_09_10_031530_create_publish_names_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_number` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_type` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtotal` int(11) NOT NULL,
  `total_discount` int(11) DEFAULT NULL,
  `tax_pct` int(11) DEFAULT NULL,
  `total_tax` int(11) DEFAULT NULL,
  `delivery_charge` int(11) DEFAULT NULL,
  `grandtotal` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `payment_status` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `order_by` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_number`, `customer_id`, `payment_type`, `subtotal`, `total_discount`, `tax_pct`, `total_tax`, `delivery_charge`, `grandtotal`, `status`, `payment_status`, `payment_id`, `order_by`, `created_at`, `updated_at`) VALUES
(1, 'ORD-657543', NULL, 'Cash On Delivery', 90, 9, NULL, NULL, 0, 81, 3, 'paid', NULL, '1', '2022-10-09 20:34:32', '2022-10-15 00:02:03'),
(2, 'ORD-670787', NULL, 'Cash On Delivery', 135, 10, NULL, NULL, 0, 125, 1, 'paid', NULL, '1', '2022-10-09 20:36:04', '2022-10-09 20:36:04'),
(3, 'ORD-297217', NULL, 'Cash On Delivery', 90, 5, NULL, NULL, 0, 85, 1, 'paid', NULL, '1', '2022-10-09 20:37:28', '2022-10-09 20:37:28'),
(4, 'ORD-475746', NULL, 'Cash On Delivery', 21600, 432, NULL, NULL, 0, 21168, 1, 'paid', NULL, '1', '2022-10-09 20:39:29', '2022-10-09 20:39:29'),
(5, 'ORD-817418', NULL, 'Cash On Delivery', 90, 2, NULL, NULL, 0, 88, 1, 'paid', NULL, '1', '2022-10-09 20:40:08', '2022-10-09 20:40:08'),
(6, 'ORD-764688', NULL, 'Cash On Delivery', 90, 2, NULL, NULL, 0, 88, 1, 'paid', NULL, '1', '2022-10-09 20:44:13', '2022-10-09 20:44:13'),
(7, 'ORD-281478', NULL, 'Cash On Delivery', 1530, 0, NULL, NULL, 0, 1530, 1, 'paid', NULL, '1', '2022-10-09 21:21:47', '2022-10-09 21:21:47'),
(8, 'ORD-128889', NULL, 'Cash On Delivery', 17325, 489, NULL, NULL, 0, 16836, 1, 'paid', NULL, '1', '2022-10-09 21:28:36', '2022-10-09 21:28:36'),
(9, 'ORD-467522', NULL, 'Cash On Delivery', 54000, 5, NULL, NULL, 0, 53995, 2, 'paid', NULL, '1', '2022-10-14 21:55:51', '2022-10-15 02:13:15'),
(10, 'ORD-178121', NULL, 'Cash On Delivery', 109, 2, NULL, NULL, 0, 107, 2, 'paid', NULL, '1', '2022-10-15 02:45:49', '2022-10-15 02:46:57'),
(11, 'ORD-592697', NULL, 'Cash On Delivery', 218000, 2, NULL, NULL, 0, 222358, 1, 'paid', NULL, '1', '2022-10-15 02:52:25', '2022-10-15 02:52:25');

-- --------------------------------------------------------

--
-- Table structure for table `order_policy`
--

DROP TABLE IF EXISTS `order_policy`;
CREATE TABLE IF NOT EXISTS `order_policy` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `policy` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

DROP TABLE IF EXISTS `order_products`;
CREATE TABLE IF NOT EXISTS `order_products` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `total` double(8,2) NOT NULL,
  `discount_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `grand_total` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_products_order_id_foreign` (`order_id`),
  KEY `order_products_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `qty`, `price`, `total`, `discount_type`, `discount`, `grand_total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 45.00, 90.00, 'percentage', 10.00, 81.00, '2022-10-09 20:34:32', '2022-10-09 20:34:32'),
(2, 2, 1, 3, 45.00, 135.00, 'fixed', 10.00, 125.00, '2022-10-09 20:36:04', '2022-10-09 20:36:04'),
(3, 3, 1, 2, 45.00, 90.00, 'fixed', 5.00, 85.00, '2022-10-09 20:37:28', '2022-10-09 20:37:28'),
(4, 4, 2, 4, 5400.00, 21600.00, 'percentage', 2.00, 21168.00, '2022-10-09 20:39:29', '2022-10-09 20:39:29'),
(5, 5, 1, 2, 45.00, 90.00, 'percentage', 2.00, 88.20, '2022-10-09 20:40:08', '2022-10-09 20:40:08'),
(6, 6, 1, 2, 45.00, 90.00, 'fixed', 2.00, 88.00, '2022-10-09 20:44:13', '2022-10-09 20:44:13'),
(7, 7, 1, 34, 45.00, 1530.00, 'fixed', NULL, 1530.00, '2022-10-09 21:21:47', '2022-10-09 21:21:47'),
(8, 8, 1, 23, 45.00, 1035.00, 'fixed', NULL, 1035.00, '2022-10-09 21:28:36', '2022-10-09 21:28:36'),
(9, 8, 2, 3, 5400.00, 16200.00, 'percentage', 3.00, 15714.00, '2022-10-09 21:28:36', '2022-10-09 21:28:36'),
(10, 8, 1, 2, 45.00, 90.00, 'fixed', 3.00, 87.00, '2022-10-09 21:28:36', '2022-10-09 21:28:36'),
(11, 9, 2, 10, 5400.00, 54000.00, 'fixed', 5.00, 53995.00, '2022-10-14 21:55:51', '2022-10-14 21:55:51'),
(12, 10, 3, 1, 109.00, 109.00, 'fixed', 2.00, 107.00, '2022-10-15 02:45:49', '2022-10-15 02:45:49'),
(13, 11, 3, 2000, 109.00, 218000.00, 'fixed', 2.00, 217998.00, '2022-10-15 02:52:25', '2022-10-15 02:52:25');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `card_customer` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `card_charge_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `card_paid` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `card_payment_method` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE IF NOT EXISTS `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_methods_type_unique` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `type`, `image`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Card', 'projectImage/payments/card.jpg', 1, NULL, NULL, NULL, NULL),
(2, 'Cash On Delivery', 'projectImage/payments/cash.png', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `purchasePrice` double(8,2) NOT NULL,
  `sellingPrice` double(8,2) NOT NULL,
  `storeBox` int(11) NOT NULL,
  `itemsNumber` int(11) NOT NULL,
  `itemsSaleCount` int(11) DEFAULT NULL,
  `generic_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` tinyint(4) NOT NULL,
  `totalPurchedItem` int(11) NOT NULL,
  `expireDate` date NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_name_unique` (`name`),
  KEY `product_category_id_foreign` (`category_id`),
  KEY `product_group_id_foreign` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `group_id`, `name`, `image`, `purchasePrice`, `sellingPrice`, `storeBox`, `itemsNumber`, `itemsSaleCount`, `generic_id`, `supplier_id`, `description`, `status`, `totalPurchedItem`, `expireDate`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 2, 1, 'Amoxil', 'projectImage/product/3dog.png', 100.00, 109.00, 100, 100, NULL, 2, 1, 'some', 1, 10000, '2022-10-31', 1, 1, '2022-10-15 02:12:12', '2022-10-15 02:12:12'),
(2, 1, 1, 'Gincosan', 'projectImage/product/2cheque.jpg', 5000.00, 5400.00, 20, 100000, NULL, 1, 1, 'some', 1, 2000000, '2022-10-27', 1, 1, '2022-10-09 20:37:06', '2022-10-15 01:51:29');

-- --------------------------------------------------------

--
-- Table structure for table `publish_names`
--

DROP TABLE IF EXISTS `publish_names`;
CREATE TABLE IF NOT EXISTS `publish_names` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `publish_names`
--

INSERT INTO `publish_names` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Publish', NULL, NULL),
(2, 'Unpublish', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `delivery_charge` int(11) NOT NULL,
  `currency_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `currency_symbol` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_name_unique` (`name`),
  UNIQUE KEY `settings_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `email`, `phone`, `website`, `address`, `delivery_charge`, `currency_name`, `currency_symbol`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Ali Store', 'ali@gmail.com', '+923468278345', 'barki@gmail.com', 'peshawar', 20, 'Pkr', 'Rs', '1665378225WhatsApp Image 2022-10-10 at 8.28.08 AM.jpeg', '2022-10-09 20:24:45', '2022-10-10 09:22:11');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_methods`
--

DROP TABLE IF EXISTS `shipping_methods`;
CREATE TABLE IF NOT EXISTS `shipping_methods` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shipping_methods_type_unique` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `supplier_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `phone`, `email`, `address`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Provider 1', '+923468278349', 'ali@gmail.com', 'Peshawar', 1, 1, 1, '2022-10-09 20:31:24', '2022-10-09 20:31:24');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_invoices`
--

DROP TABLE IF EXISTS `supplier_invoices`;
CREATE TABLE IF NOT EXISTS `supplier_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(11) NOT NULL,
  `sum_subtotal` double(8,2) NOT NULL,
  `sum_discount` double(8,2) NOT NULL,
  `sum_grandtotal` double(8,2) NOT NULL,
  `tax_percent` int(11) NOT NULL,
  `tax_amount` double(8,2) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_invoice_productinfo`
--

DROP TABLE IF EXISTS `supplier_invoice_productinfo`;
CREATE TABLE IF NOT EXISTS `supplier_invoice_productinfo` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `invoice_no` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty_product` int(11) NOT NULL,
  `unit_price` double(8,2) NOT NULL,
  `subtotal_product` double(8,2) NOT NULL,
  `discount_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `discount_product` double(8,2) NOT NULL,
  `grandtotal_product` double(8,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test2s`
--

DROP TABLE IF EXISTS `test2s`;
CREATE TABLE IF NOT EXISTS `test2s` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `users_role_id` int(11) NOT NULL,
  `isAdmin` tinyint(4) DEFAULT NULL,
  `firstname` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `postcode` text COLLATE utf8_unicode_ci,
  `address` text COLLATE utf8_unicode_ci,
  `city` text COLLATE utf8_unicode_ci,
  `country` text COLLATE utf8_unicode_ci,
  `image` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `users_role_id`, `isAdmin`, `firstname`, `lastname`, `email`, `email_verified_at`, `password`, `phone`, `dob`, `postcode`, `address`, `city`, `country`, `image`, `status`, `created_by`, `updated_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'Super', 'Admin', 'super@admin.com', NULL, '$2y$10$q6iShBk.BVsQ8COUK9lL.uxlGd1bJ8t5/0dyrEgKRt0w1ESvw85Aa', '+923468278234', NULL, '25000', 'some', 'Peshawar', 'Pakistan', 'projectImage/users/1WhatsApp Image 2022-10-10 at 8.28.08 AM.jpeg', 1, NULL, 1, 'P77GWGA26uEJsc2STZhCYdVTFDPEF6tQdiCLiGaSiGv4CfGV6jm2vcmDboXL', NULL, '2022-10-10 09:18:34'),
(2, 2, 0, 'admin', 'admin', 'admin@admin.com', NULL, '$2y$10$8hIywUo3vNUNuCg6kQeX3OF9wKTRUbniKk5S2Ezj1DZL/rqnLZ2/G', '03211234567', '2022-10-05', '25000', 'some', 'Peshawar', 'Pakistan', 'projectImage/users/2cat.PNG', 1, 1, NULL, NULL, '2022-10-15 01:57:44', '2022-10-15 01:57:44');

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE IF NOT EXISTS `users_roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin', NULL, '2022-10-11 09:35:24'),
(2, 'admin', 'admin', NULL, '2022-10-11 06:15:43');

-- --------------------------------------------------------

--
-- Table structure for table `wish_lists`
--

DROP TABLE IF EXISTS `wish_lists`;
CREATE TABLE IF NOT EXISTS `wish_lists` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `is_delete` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
