-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 18, 2026 at 08:46 AM
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
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `record_id` bigint UNSIGNED DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `module`, `record_id`, `description`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 3, 'permissions_updated', 'Authorization', NULL, 'Updated page permissions matrix', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-13 06:47:03'),
(2, 3, 'permissions_updated', 'Authorization', NULL, 'Updated page permissions matrix', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-13 06:47:50'),
(3, 3, 'created', 'ItemRequest', 2, 'Submitted request for 90 Kg of [RM010] Icodextrin: test1', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-13 06:49:25'),
(4, 3, 'permissions_updated', 'Authorization', NULL, 'Saved page permissions (no changes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-13 06:52:00'),
(5, 3, 'permissions_updated', 'Authorization', NULL, 'Updated page permissions for 7 screen(s)', '{\"Item Master – View\": \"Supervisor: Yes, Operator: Yes\", \"My Requests – View\": \"Supervisor: Yes, Operator: Yes\", \"Stock Received – View\": \"Supervisor: Yes, Operator: Yes\", \"My Requests – Submit New Request\": \"Supervisor: Yes, Operator: Yes\", \"Manage Requests – Approve / Reject\": \"Supervisor: Yes, Operator: No\", \"Stock Received – Record New Receipt\": \"Supervisor: Yes, Operator: Yes\", \"Item Master – Create / Edit / Delete\": \"Supervisor: Yes, Operator: No\"}', '{\"Item Master – View\": \"Supervisor: No, Operator: No\", \"My Requests – View\": \"Supervisor: No, Operator: No\", \"Stock Received – View\": \"Supervisor: No, Operator: No\", \"My Requests – Submit New Request\": \"Supervisor: No, Operator: No\", \"Manage Requests – Approve / Reject\": \"Supervisor: No, Operator: No\", \"Stock Received – Record New Receipt\": \"Supervisor: No, Operator: No\", \"Item Master – Create / Edit / Delete\": \"Supervisor: No, Operator: No\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-13 06:53:36'),
(6, 3, 'permissions_updated', 'Authorization', NULL, 'Saved page permissions (no changes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-13 06:54:02'),
(7, 3, 'permissions_updated', 'Authorization', NULL, 'Saved page permissions (no changes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-13 06:57:26'),
(8, 3, 'permissions_updated', 'Authorization', NULL, 'Saved page permissions (no changes)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-13 06:57:30'),
(9, 3, 'permissions_updated', 'Authorization', NULL, 'Updated page permissions for 1 screen(s)', '{\"Item Master – Create / Edit / Delete\": \"Supervisor: Yes, Operator: No\"}', '{\"Item Master – Create / Edit / Delete\": \"Supervisor: No, Operator: No\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-13 06:57:34'),
(10, 3, 'permissions_updated', 'Authorization', NULL, 'Updated page permissions for 1 screen(s)', '{\"Item Master – Create / Edit / Delete\": \"Supervisor: No, Operator: No\"}', '{\"Item Master – Create / Edit / Delete\": \"Supervisor: Yes, Operator: No\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-13 06:57:44'),
(11, 3, 'created', 'StockReceipt', 4, 'Received 50 Pcs of [PM057-02] Pouch-Clean room HDPE Bag(365x520x0.11mm)-5L from Tako (Batch: B1441)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-13 08:41:27'),
(12, 3, 'created', 'StockReceipt', 5, 'Received 115 Pcs of [PM057-02] Pouch-Clean room HDPE Bag(365x520x0.11mm)-5L from Tip Corporation (Batch: B1442)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-13 08:42:07'),
(13, 3, 'created', 'StockReceipt', 6, 'Received 50 Pcs of [PM057-02] Pouch-Clean room HDPE Bag(365x520x0.11mm)-5L from Tako (Batch: B1443)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-13 09:36:00'),
(14, 3, 'created', 'StockReceipt', 7, 'Production return: 10 Kg of [RM001B] Dextrose Anhydrous (from request #1)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-13 10:15:42'),
(15, 1, 'login', 'Auth', NULL, 'User logged in: ADM000 (adm000@test.com)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-14 00:01:47'),
(16, 1, 'logout', 'Auth', NULL, 'User logged out: ADM000 (adm000@test.com)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-14 00:02:06'),
(17, 2, 'login', 'Auth', NULL, 'User logged in: ADM111 (yusuf@peritone-health.com)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-14 00:02:20'),
(18, 2, 'logout', 'Auth', NULL, 'User logged out: ADM111 (yusuf@peritone-health.com)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-14 00:02:36'),
(19, 3, 'login', 'Auth', NULL, 'User logged in: Admin User (admin@inventory.test)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-14 00:02:44'),
(20, 3, 'created', 'StockReceipt', 8, 'Received 200 Pcs of [PM024B] Tube Clip ( 2L) from PT Adventa Biotech — Lot: TC20260514 — 200 batches generated', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-14 04:07:16'),
(21, 3, 'login', 'Auth', NULL, 'User logged in: Admin User (admin@inventory.test)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-14 08:13:59'),
(22, 3, 'login', 'Auth', NULL, 'User logged in: Admin User (admin@inventory.test)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 OPR/130.0.0.0', '2026-05-15 00:37:56'),
(23, 3, 'login', 'Auth', NULL, 'User logged in: Admin User (admin@inventory.test)', NULL, NULL, '192.168.0.81', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Mobile Safari/537.36', '2026-05-15 01:19:15'),
(24, 3, 'login', 'Auth', NULL, 'User logged in: Admin User (admin@inventory.test)', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0', '2026-05-18 04:17:42');

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
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pcs',
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_by` bigint UNSIGNED NOT NULL,
  `archived_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `code`, `name`, `description`, `unit`, `quantity`, `created_by`, `archived_at`, `created_at`, `updated_at`) VALUES
(35, 'RM001B', 'Dextrose Anhydrous', NULL, 'Kg', '1960.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-13 02:15:42'),
(36, 'RM002D', 'Sodium Lactate 60% FCC', NULL, 'Kg', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(37, 'RM003D', 'Sodium Chloride BP', NULL, 'Kg', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(38, 'RM004A', 'Calcium Chloride Dihydrate BP', NULL, 'Kg', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(39, 'CS-00155', 'Potassium Chloride', NULL, 'Kg', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(40, 'RM005A', 'Magnesium Chloride Hexahydrate BP', NULL, 'Kg', '500.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 20:49:37'),
(41, 'RM010', 'Icodextrin', NULL, 'Kg', '1000.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 20:48:56'),
(42, 'PM003', 'Polypropylene tube (APP107-S-8,10 x 6,10) * 445M/Roll', NULL, 'Roll', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(43, 'PM004B', 'Advance printing Film APF-Black-185 (1.5%) * 610M/Roll', NULL, 'Roll', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(44, 'PM005', 'PCPA Injection port 6.8mm - Type A', NULL, 'Pcs', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(45, 'PM006(B)', 'Break Plug Type B ( Transperant )', NULL, 'Pcs', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(46, 'PM011B', 'Advanced printing film APF-Blue-185 (2.5%) * 610M/Roll', NULL, 'Roll', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(47, 'PM012', 'Advanced printing film APF-Red-185 (4.25%) * 610M/Roll', NULL, 'Roll', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(48, 'PM012B', 'Advanced printing film APF-Red-185 (4.25%) * 610M/Roll', NULL, 'Roll', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(49, 'PM015', 'Polypropylene Film SC ( APP114-S-413-200-F) - 5L * 570M/Roll', NULL, 'Roll', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(50, 'PM015B', 'Polypropylene Film SC ( APP114-S-413-200-F) - 5L * 570M/Roll', NULL, 'Roll', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(51, 'PM018C', 'Break Plug Type B c/w (Clear Light Blue)', NULL, 'Pcs', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(52, 'PM21D', 'Capd Bag Sets', NULL, 'Pcs', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(53, 'PM21E', 'CAPD Drain bag set DAHUA', NULL, 'Pcs', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(54, 'PM022-02', 'Pouch-Clean room HDPE Bag(250x490x0.11mm)-2L', NULL, 'Pcs', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(55, 'PM022B', 'Pouch-Clean room HDPE Bag(250x490x0.11mm)-2L', NULL, 'Pcs', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(56, 'PM024B', 'Tube Clip ( 2L)', NULL, 'Pcs', '200.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-13 20:07:16'),
(57, 'PM031B', 'APD Connector Dark Purple', NULL, 'Pcs', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(58, 'PM031C', 'APD Connector Dark Purple', NULL, 'Pcs', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(59, 'PM032C', 'SMALL SIZE WHITE TPE CAP', NULL, 'Pcs', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(60, 'PM0051', 'Polypropylene Film SC 2.5L', NULL, 'Roll', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(61, 'PM057-02', 'Pouch-Clean room HDPE Bag(365x520x0.11mm)-5L', NULL, 'Pcs', '215.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-13 01:36:00'),
(62, 'PM058', 'Polypropylene Film (2L)', NULL, 'Roll', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(63, 'PM065-01', 'Advance printing Film APF-Black-185 (1.5%) * 610M/Roll - Core 3\"', NULL, 'Roll', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(64, 'PM066', 'Advance printing Film APF-Blue-185 (1.5%) * 610M/Roll- Core 3\"', NULL, 'Roll', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(65, 'PM067', 'Advance printing Film APF-Red-185 (1.5%) * 610M/Roll- Core 3\"', NULL, 'Roll', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(66, 'PM068', 'PP Film 2L 570m* (L) 328mm (W) X 200mm (T)', NULL, 'Roll', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(67, 'PC032', 'Plain LDPE Plastic Bag', NULL, 'Kg', '0.00', 2, NULL, '2026-05-12 17:27:08', '2026-05-12 17:27:08');

-- --------------------------------------------------------

--
-- Table structure for table `item_requests`
--

CREATE TABLE `item_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `requested_by` bigint UNSIGNED NOT NULL,
  `quantity_requested` decimal(10,2) NOT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `vendor_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reviewed_by` bigint UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_requests`
--

INSERT INTO `item_requests` (`id`, `item_id`, `requested_by`, `quantity_requested`, `purpose`, `notes`, `vendor_name`, `expiry_date`, `status`, `reviewed_by`, `reviewed_at`, `created_at`, `updated_at`) VALUES
(1, 35, 2, '50.00', 'test', NULL, NULL, NULL, 'approved', 2, '2026-05-12 20:50:23', '2026-05-12 20:50:13', '2026-05-12 20:50:23'),
(2, 41, 3, '90.00', 'test1', NULL, NULL, NULL, 'pending', NULL, NULL, '2026-05-12 22:49:25', '2026-05-12 22:49:25');

-- --------------------------------------------------------

--
-- Table structure for table `item_suppliers`
--

CREATE TABLE `item_suppliers` (
  `id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `supplier_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_suppliers`
--

INSERT INTO `item_suppliers` (`id`, `item_id`, `supplier_name`, `created_at`, `updated_at`) VALUES
(1, 35, 'SV Pharmachem (WEIFANG SHENGTAI)', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(2, 36, 'SV Pharmachem (HENAN JINDAN)', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(3, 37, 'Prima Interchem (Dominion Salt)', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(4, 38, 'Prima Interchem (Anish)', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(5, 39, 'SV Pharmachem', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(6, 40, 'Anish (Prima Int)', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(7, 41, 'SHANDONG ASIA-EUROPE GLOBAL IMPORT & EXPORT CO.,LTD', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(8, 42, 'Polycine GMBH (Germany)', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(9, 43, 'Zhoulin', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(10, 44, 'Shanghai Ze Ji (China)', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(11, 45, 'Leowena International', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(12, 46, 'Zhoulin', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(13, 47, 'Polycine GMBH (Germany)', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(14, 48, 'Zhoulin', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(15, 49, 'Polycine GMBH (Germany)', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(16, 50, 'SR TECHNOPACK (KOREA)', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(17, 51, 'PT Adventa Biotech', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(18, 52, 'Leowena International', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(19, 53, 'Wenda International', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(20, 54, 'Tip Corporation', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(21, 55, 'Tako', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(22, 56, 'PT Adventa Biotech', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(23, 57, 'Leowena International', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(24, 58, 'ONE PLASTIC', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(25, 59, 'PT Adventa Biotech', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(26, 60, 'Polycine GMBH (Germany)', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(28, 62, 'Polycine GMBH (Germany)', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(29, 63, 'Zhoulin', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(30, 64, 'Zhoulin', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(31, 65, 'Zhoulin', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(32, 66, 'SR TECHNOPACK (KOREA)', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(33, 67, 'Local', '2026-05-12 17:27:08', '2026-05-12 17:27:08'),
(34, 61, 'Tako', '2026-05-12 17:27:44', '2026-05-12 17:27:44'),
(35, 61, 'Tip Corporation', '2026-05-12 17:27:44', '2026-05-12 17:27:44');

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
(5, '2024_01_01_000010_create_items_table', 1),
(6, '2024_01_01_000020_create_stock_receipts_table', 1),
(7, '2024_01_01_000030_create_item_requests_table', 1),
(8, '2024_01_01_000011_add_supplier_name_to_items_table', 2),
(9, '2024_01_01_000012_create_item_suppliers_table', 3),
(10, '2024_01_01_000013_drop_supplier_name_from_items_table', 3),
(11, '2024_01_01_000001_add_role_to_users_table', 4),
(12, '2024_01_01_000002_create_page_permissions_table', 5),
(13, '2024_01_01_000003_create_audit_logs_table', 6),
(14, '2024_01_01_000004_add_archived_at_to_items_table', 7),
(15, '2024_01_01_000021_add_batch_number_to_stock_receipts_table', 8),
(16, '2024_01_01_000022_add_expiry_date_to_stock_receipts_table', 9),
(17, '2024_01_01_000031_add_vendor_expiry_to_item_requests_table', 10),
(18, '2024_01_01_000023_add_type_to_stock_receipts_table', 11),
(19, '2024_01_01_000032_add_stock_card_permission', 12),
(20, '2024_01_01_000033_add_lot_number_to_stock_receipts_table', 13),
(21, '2024_01_01_000034_create_stock_batches_table', 14),
(22, '2024_01_01_000035_add_stock_batches_permission', 15),
(23, '2024_01_01_000036_add_tunnel_to_stock_batches_table', 16),
(24, '2026_05_18_064822_widen_tunnel_column_on_stock_batches', 17);

-- --------------------------------------------------------

--
-- Table structure for table `page_permissions`
--

CREATE TABLE `page_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '1',
  `supervisor` tinyint(1) NOT NULL DEFAULT '0',
  `operator` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_permissions`
--

INSERT INTO `page_permissions` (`id`, `key`, `label`, `description`, `admin`, `supervisor`, `operator`, `created_at`, `updated_at`) VALUES
(1, 'items.view', 'Item Master – View', 'View list and details of items in the master list.', 1, 1, 1, '2026-05-12 22:26:10', '2026-05-12 22:57:12'),
(2, 'items.manage', 'Item Master – Create / Edit / Delete', 'Add new items, edit existing ones, bulk import, and delete items.', 1, 1, 0, '2026-05-12 22:26:10', '2026-05-12 22:57:44'),
(3, 'stock-receipts.view', 'Stock Received – View', 'View list and details of stock received from suppliers.', 1, 1, 1, '2026-05-12 22:26:10', '2026-05-12 22:57:12'),
(4, 'stock-receipts.create', 'Stock Received – Record New Receipt', 'Record new stock received from a supplier.', 1, 1, 1, '2026-05-12 22:26:10', '2026-05-12 22:57:12'),
(5, 'item-requests.view', 'My Stock Issues – View', 'View own item request history.', 1, 1, 1, '2026-05-12 22:26:10', '2026-05-13 16:45:56'),
(6, 'item-requests.create', 'My Stock Issues – Submit New Issue', 'Submit a new item request for approval.', 1, 1, 1, '2026-05-12 22:26:10', '2026-05-13 16:45:56'),
(7, 'item-requests.manage', 'Manage Stock Issues – Approve / Reject', 'View all user requests and approve or reject them.', 1, 1, 0, '2026-05-12 22:26:10', '2026-05-13 16:45:56'),
(8, 'stock-card.view', 'Stock Card – View', 'View stock card report showing item movement history.', 1, 1, 0, '2026-05-13 16:45:56', '2026-05-13 16:45:56'),
(9, 'stock-batches.view', 'Stock Batches – View', 'Browse and search all batch numbers across lots.', 1, 1, 0, '2026-05-13 20:15:00', '2026-05-13 20:15:00');

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

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(3, 'App\\Models\\User', 3, 'mobile-app', '5dc0063a8dc99a63d56a9c5f643007e58bc266d70c09dfd8a15d0cd604a4767a', '[\"*\"]', '2026-05-14 20:02:58', NULL, '2026-05-14 19:49:29', '2026-05-14 20:02:58');

-- --------------------------------------------------------

--
-- Table structure for table `stock_batches`
--

CREATE TABLE `stock_batches` (
  `id` bigint UNSIGNED NOT NULL,
  `stock_receipt_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `lot_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `status` enum('available','issued') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `tunnel` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_code` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_batches`
--

INSERT INTO `stock_batches` (`id`, `stock_receipt_id`, `item_id`, `lot_number`, `batch_number`, `expiry_date`, `status`, `tunnel`, `qr_code`, `created_at`, `updated_at`) VALUES
(1, 8, 56, 'TC20260514', 'PM024B-000008-0001', '2029-11-22', 'available', 'P7', NULL, '2026-05-13 20:07:16', '2026-05-17 23:04:28'),
(2, 8, 56, 'TC20260514', 'PM024B-000008-0002', '2029-11-22', 'available', 'C', NULL, '2026-05-13 20:07:16', '2026-05-17 20:18:02'),
(3, 8, 56, 'TC20260514', 'PM024B-000008-0003', '2029-11-22', 'available', 'C', NULL, '2026-05-13 20:07:16', '2026-05-14 20:01:39'),
(4, 8, 56, 'TC20260514', 'PM024B-000008-0004', '2029-11-22', 'available', 'B', NULL, '2026-05-13 20:07:16', '2026-05-17 20:18:14'),
(5, 8, 56, 'TC20260514', 'PM024B-000008-0005', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(6, 8, 56, 'TC20260514', 'PM024B-000008-0006', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(7, 8, 56, 'TC20260514', 'PM024B-000008-0007', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(8, 8, 56, 'TC20260514', 'PM024B-000008-0008', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(9, 8, 56, 'TC20260514', 'PM024B-000008-0009', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(10, 8, 56, 'TC20260514', 'PM024B-000008-0010', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(11, 8, 56, 'TC20260514', 'PM024B-000008-0011', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(12, 8, 56, 'TC20260514', 'PM024B-000008-0012', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(13, 8, 56, 'TC20260514', 'PM024B-000008-0013', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(14, 8, 56, 'TC20260514', 'PM024B-000008-0014', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(15, 8, 56, 'TC20260514', 'PM024B-000008-0015', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(16, 8, 56, 'TC20260514', 'PM024B-000008-0016', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(17, 8, 56, 'TC20260514', 'PM024B-000008-0017', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(18, 8, 56, 'TC20260514', 'PM024B-000008-0018', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(19, 8, 56, 'TC20260514', 'PM024B-000008-0019', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(20, 8, 56, 'TC20260514', 'PM024B-000008-0020', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(21, 8, 56, 'TC20260514', 'PM024B-000008-0021', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(22, 8, 56, 'TC20260514', 'PM024B-000008-0022', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(23, 8, 56, 'TC20260514', 'PM024B-000008-0023', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(24, 8, 56, 'TC20260514', 'PM024B-000008-0024', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(25, 8, 56, 'TC20260514', 'PM024B-000008-0025', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(26, 8, 56, 'TC20260514', 'PM024B-000008-0026', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(27, 8, 56, 'TC20260514', 'PM024B-000008-0027', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(28, 8, 56, 'TC20260514', 'PM024B-000008-0028', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(29, 8, 56, 'TC20260514', 'PM024B-000008-0029', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(30, 8, 56, 'TC20260514', 'PM024B-000008-0030', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(31, 8, 56, 'TC20260514', 'PM024B-000008-0031', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(32, 8, 56, 'TC20260514', 'PM024B-000008-0032', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(33, 8, 56, 'TC20260514', 'PM024B-000008-0033', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(34, 8, 56, 'TC20260514', 'PM024B-000008-0034', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(35, 8, 56, 'TC20260514', 'PM024B-000008-0035', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(36, 8, 56, 'TC20260514', 'PM024B-000008-0036', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(37, 8, 56, 'TC20260514', 'PM024B-000008-0037', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(38, 8, 56, 'TC20260514', 'PM024B-000008-0038', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(39, 8, 56, 'TC20260514', 'PM024B-000008-0039', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(40, 8, 56, 'TC20260514', 'PM024B-000008-0040', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(41, 8, 56, 'TC20260514', 'PM024B-000008-0041', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(42, 8, 56, 'TC20260514', 'PM024B-000008-0042', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(43, 8, 56, 'TC20260514', 'PM024B-000008-0043', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(44, 8, 56, 'TC20260514', 'PM024B-000008-0044', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(45, 8, 56, 'TC20260514', 'PM024B-000008-0045', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(46, 8, 56, 'TC20260514', 'PM024B-000008-0046', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(47, 8, 56, 'TC20260514', 'PM024B-000008-0047', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(48, 8, 56, 'TC20260514', 'PM024B-000008-0048', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(49, 8, 56, 'TC20260514', 'PM024B-000008-0049', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(50, 8, 56, 'TC20260514', 'PM024B-000008-0050', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(51, 8, 56, 'TC20260514', 'PM024B-000008-0051', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(52, 8, 56, 'TC20260514', 'PM024B-000008-0052', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(53, 8, 56, 'TC20260514', 'PM024B-000008-0053', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(54, 8, 56, 'TC20260514', 'PM024B-000008-0054', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(55, 8, 56, 'TC20260514', 'PM024B-000008-0055', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(56, 8, 56, 'TC20260514', 'PM024B-000008-0056', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(57, 8, 56, 'TC20260514', 'PM024B-000008-0057', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(58, 8, 56, 'TC20260514', 'PM024B-000008-0058', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(59, 8, 56, 'TC20260514', 'PM024B-000008-0059', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(60, 8, 56, 'TC20260514', 'PM024B-000008-0060', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(61, 8, 56, 'TC20260514', 'PM024B-000008-0061', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(62, 8, 56, 'TC20260514', 'PM024B-000008-0062', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(63, 8, 56, 'TC20260514', 'PM024B-000008-0063', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(64, 8, 56, 'TC20260514', 'PM024B-000008-0064', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(65, 8, 56, 'TC20260514', 'PM024B-000008-0065', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(66, 8, 56, 'TC20260514', 'PM024B-000008-0066', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(67, 8, 56, 'TC20260514', 'PM024B-000008-0067', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(68, 8, 56, 'TC20260514', 'PM024B-000008-0068', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(69, 8, 56, 'TC20260514', 'PM024B-000008-0069', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(70, 8, 56, 'TC20260514', 'PM024B-000008-0070', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(71, 8, 56, 'TC20260514', 'PM024B-000008-0071', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(72, 8, 56, 'TC20260514', 'PM024B-000008-0072', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(73, 8, 56, 'TC20260514', 'PM024B-000008-0073', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(74, 8, 56, 'TC20260514', 'PM024B-000008-0074', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(75, 8, 56, 'TC20260514', 'PM024B-000008-0075', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(76, 8, 56, 'TC20260514', 'PM024B-000008-0076', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(77, 8, 56, 'TC20260514', 'PM024B-000008-0077', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(78, 8, 56, 'TC20260514', 'PM024B-000008-0078', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(79, 8, 56, 'TC20260514', 'PM024B-000008-0079', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(80, 8, 56, 'TC20260514', 'PM024B-000008-0080', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(81, 8, 56, 'TC20260514', 'PM024B-000008-0081', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(82, 8, 56, 'TC20260514', 'PM024B-000008-0082', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(83, 8, 56, 'TC20260514', 'PM024B-000008-0083', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(84, 8, 56, 'TC20260514', 'PM024B-000008-0084', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(85, 8, 56, 'TC20260514', 'PM024B-000008-0085', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(86, 8, 56, 'TC20260514', 'PM024B-000008-0086', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(87, 8, 56, 'TC20260514', 'PM024B-000008-0087', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(88, 8, 56, 'TC20260514', 'PM024B-000008-0088', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(89, 8, 56, 'TC20260514', 'PM024B-000008-0089', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(90, 8, 56, 'TC20260514', 'PM024B-000008-0090', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(91, 8, 56, 'TC20260514', 'PM024B-000008-0091', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(92, 8, 56, 'TC20260514', 'PM024B-000008-0092', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(93, 8, 56, 'TC20260514', 'PM024B-000008-0093', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(94, 8, 56, 'TC20260514', 'PM024B-000008-0094', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(95, 8, 56, 'TC20260514', 'PM024B-000008-0095', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(96, 8, 56, 'TC20260514', 'PM024B-000008-0096', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(97, 8, 56, 'TC20260514', 'PM024B-000008-0097', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(98, 8, 56, 'TC20260514', 'PM024B-000008-0098', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(99, 8, 56, 'TC20260514', 'PM024B-000008-0099', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(100, 8, 56, 'TC20260514', 'PM024B-000008-0100', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(101, 8, 56, 'TC20260514', 'PM024B-000008-0101', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(102, 8, 56, 'TC20260514', 'PM024B-000008-0102', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(103, 8, 56, 'TC20260514', 'PM024B-000008-0103', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(104, 8, 56, 'TC20260514', 'PM024B-000008-0104', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(105, 8, 56, 'TC20260514', 'PM024B-000008-0105', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(106, 8, 56, 'TC20260514', 'PM024B-000008-0106', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(107, 8, 56, 'TC20260514', 'PM024B-000008-0107', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(108, 8, 56, 'TC20260514', 'PM024B-000008-0108', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(109, 8, 56, 'TC20260514', 'PM024B-000008-0109', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(110, 8, 56, 'TC20260514', 'PM024B-000008-0110', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(111, 8, 56, 'TC20260514', 'PM024B-000008-0111', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(112, 8, 56, 'TC20260514', 'PM024B-000008-0112', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(113, 8, 56, 'TC20260514', 'PM024B-000008-0113', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(114, 8, 56, 'TC20260514', 'PM024B-000008-0114', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(115, 8, 56, 'TC20260514', 'PM024B-000008-0115', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(116, 8, 56, 'TC20260514', 'PM024B-000008-0116', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(117, 8, 56, 'TC20260514', 'PM024B-000008-0117', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(118, 8, 56, 'TC20260514', 'PM024B-000008-0118', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(119, 8, 56, 'TC20260514', 'PM024B-000008-0119', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(120, 8, 56, 'TC20260514', 'PM024B-000008-0120', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(121, 8, 56, 'TC20260514', 'PM024B-000008-0121', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(122, 8, 56, 'TC20260514', 'PM024B-000008-0122', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(123, 8, 56, 'TC20260514', 'PM024B-000008-0123', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(124, 8, 56, 'TC20260514', 'PM024B-000008-0124', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(125, 8, 56, 'TC20260514', 'PM024B-000008-0125', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(126, 8, 56, 'TC20260514', 'PM024B-000008-0126', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(127, 8, 56, 'TC20260514', 'PM024B-000008-0127', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(128, 8, 56, 'TC20260514', 'PM024B-000008-0128', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(129, 8, 56, 'TC20260514', 'PM024B-000008-0129', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(130, 8, 56, 'TC20260514', 'PM024B-000008-0130', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(131, 8, 56, 'TC20260514', 'PM024B-000008-0131', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(132, 8, 56, 'TC20260514', 'PM024B-000008-0132', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(133, 8, 56, 'TC20260514', 'PM024B-000008-0133', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(134, 8, 56, 'TC20260514', 'PM024B-000008-0134', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(135, 8, 56, 'TC20260514', 'PM024B-000008-0135', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(136, 8, 56, 'TC20260514', 'PM024B-000008-0136', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(137, 8, 56, 'TC20260514', 'PM024B-000008-0137', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(138, 8, 56, 'TC20260514', 'PM024B-000008-0138', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(139, 8, 56, 'TC20260514', 'PM024B-000008-0139', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(140, 8, 56, 'TC20260514', 'PM024B-000008-0140', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(141, 8, 56, 'TC20260514', 'PM024B-000008-0141', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(142, 8, 56, 'TC20260514', 'PM024B-000008-0142', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(143, 8, 56, 'TC20260514', 'PM024B-000008-0143', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(144, 8, 56, 'TC20260514', 'PM024B-000008-0144', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(145, 8, 56, 'TC20260514', 'PM024B-000008-0145', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(146, 8, 56, 'TC20260514', 'PM024B-000008-0146', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(147, 8, 56, 'TC20260514', 'PM024B-000008-0147', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(148, 8, 56, 'TC20260514', 'PM024B-000008-0148', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(149, 8, 56, 'TC20260514', 'PM024B-000008-0149', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(150, 8, 56, 'TC20260514', 'PM024B-000008-0150', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(151, 8, 56, 'TC20260514', 'PM024B-000008-0151', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(152, 8, 56, 'TC20260514', 'PM024B-000008-0152', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(153, 8, 56, 'TC20260514', 'PM024B-000008-0153', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(154, 8, 56, 'TC20260514', 'PM024B-000008-0154', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(155, 8, 56, 'TC20260514', 'PM024B-000008-0155', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(156, 8, 56, 'TC20260514', 'PM024B-000008-0156', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(157, 8, 56, 'TC20260514', 'PM024B-000008-0157', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(158, 8, 56, 'TC20260514', 'PM024B-000008-0158', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(159, 8, 56, 'TC20260514', 'PM024B-000008-0159', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(160, 8, 56, 'TC20260514', 'PM024B-000008-0160', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(161, 8, 56, 'TC20260514', 'PM024B-000008-0161', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(162, 8, 56, 'TC20260514', 'PM024B-000008-0162', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(163, 8, 56, 'TC20260514', 'PM024B-000008-0163', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(164, 8, 56, 'TC20260514', 'PM024B-000008-0164', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(165, 8, 56, 'TC20260514', 'PM024B-000008-0165', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(166, 8, 56, 'TC20260514', 'PM024B-000008-0166', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(167, 8, 56, 'TC20260514', 'PM024B-000008-0167', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(168, 8, 56, 'TC20260514', 'PM024B-000008-0168', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(169, 8, 56, 'TC20260514', 'PM024B-000008-0169', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(170, 8, 56, 'TC20260514', 'PM024B-000008-0170', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(171, 8, 56, 'TC20260514', 'PM024B-000008-0171', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(172, 8, 56, 'TC20260514', 'PM024B-000008-0172', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(173, 8, 56, 'TC20260514', 'PM024B-000008-0173', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(174, 8, 56, 'TC20260514', 'PM024B-000008-0174', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(175, 8, 56, 'TC20260514', 'PM024B-000008-0175', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(176, 8, 56, 'TC20260514', 'PM024B-000008-0176', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(177, 8, 56, 'TC20260514', 'PM024B-000008-0177', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(178, 8, 56, 'TC20260514', 'PM024B-000008-0178', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(179, 8, 56, 'TC20260514', 'PM024B-000008-0179', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(180, 8, 56, 'TC20260514', 'PM024B-000008-0180', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(181, 8, 56, 'TC20260514', 'PM024B-000008-0181', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(182, 8, 56, 'TC20260514', 'PM024B-000008-0182', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(183, 8, 56, 'TC20260514', 'PM024B-000008-0183', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(184, 8, 56, 'TC20260514', 'PM024B-000008-0184', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(185, 8, 56, 'TC20260514', 'PM024B-000008-0185', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(186, 8, 56, 'TC20260514', 'PM024B-000008-0186', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(187, 8, 56, 'TC20260514', 'PM024B-000008-0187', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(188, 8, 56, 'TC20260514', 'PM024B-000008-0188', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(189, 8, 56, 'TC20260514', 'PM024B-000008-0189', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(190, 8, 56, 'TC20260514', 'PM024B-000008-0190', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(191, 8, 56, 'TC20260514', 'PM024B-000008-0191', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(192, 8, 56, 'TC20260514', 'PM024B-000008-0192', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(193, 8, 56, 'TC20260514', 'PM024B-000008-0193', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(194, 8, 56, 'TC20260514', 'PM024B-000008-0194', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(195, 8, 56, 'TC20260514', 'PM024B-000008-0195', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(196, 8, 56, 'TC20260514', 'PM024B-000008-0196', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(197, 8, 56, 'TC20260514', 'PM024B-000008-0197', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(198, 8, 56, 'TC20260514', 'PM024B-000008-0198', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(199, 8, 56, 'TC20260514', 'PM024B-000008-0199', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16'),
(200, 8, 56, 'TC20260514', 'PM024B-000008-0200', '2029-11-22', 'available', NULL, NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16');

-- --------------------------------------------------------

--
-- Table structure for table `stock_receipts`
--

CREATE TABLE `stock_receipts` (
  `id` bigint UNSIGNED NOT NULL,
  `type` enum('supplier','production') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'supplier',
  `item_id` bigint UNSIGNED NOT NULL,
  `received_by` bigint UNSIGNED NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `supplier_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lot_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `batch_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `received_date` date NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `item_request_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_receipts`
--

INSERT INTO `stock_receipts` (`id`, `type`, `item_id`, `received_by`, `quantity`, `supplier_name`, `lot_number`, `batch_number`, `expiry_date`, `received_date`, `notes`, `created_at`, `updated_at`, `item_request_id`) VALUES
(1, 'supplier', 41, 2, '1000.00', 'SHANDONG ASIA-EUROPE GLOBAL IMPORT & EXPORT CO.,LTD', NULL, NULL, NULL, '2026-05-13', NULL, '2026-05-12 20:48:55', '2026-05-12 20:48:55', NULL),
(2, 'supplier', 35, 2, '2000.00', 'SV Pharmachem (WEIFANG SHENGTAI)', NULL, NULL, NULL, '2026-05-13', NULL, '2026-05-12 20:49:20', '2026-05-12 20:49:20', NULL),
(3, 'supplier', 40, 2, '500.00', 'Anish (Prima Int)', NULL, NULL, NULL, '2026-05-13', NULL, '2026-05-12 20:49:37', '2026-05-12 20:49:37', NULL),
(4, 'supplier', 61, 3, '50.00', 'Tako', NULL, 'B1441', NULL, '2026-05-13', NULL, '2026-05-13 00:41:27', '2026-05-13 00:41:27', NULL),
(5, 'supplier', 61, 3, '115.00', 'Tip Corporation', NULL, 'B1442', NULL, '2026-05-13', NULL, '2026-05-13 00:42:06', '2026-05-13 00:42:06', NULL),
(6, 'supplier', 61, 3, '50.00', 'Tako', NULL, 'B1443', '2026-06-05', '2026-05-13', NULL, '2026-05-13 01:36:00', '2026-05-13 01:36:00', NULL),
(7, 'production', 35, 3, '10.00', NULL, NULL, NULL, NULL, '2026-05-13', NULL, '2026-05-13 02:15:42', '2026-05-13 02:15:42', 1),
(8, 'supplier', 56, 3, '200.00', 'PT Adventa Biotech', 'TC20260514', NULL, '2029-11-22', '2026-05-14', NULL, '2026-05-13 20:07:16', '2026-05-13 20:07:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','supervisor','operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'operator',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ADM000', 'adm000@test.com', 'operator', '2026-05-12 08:50:16', '$2y$12$aiko24qlsk.HVaDOdWNZZOC/HlRN6iljhZT9n9I7eL0gJkFTCEkga', NULL, '2026-05-11 23:46:53', '2026-05-12 22:18:45'),
(2, 'ADM111', 'yusuf@peritone-health.com', 'operator', NULL, '$2y$12$EAjDO0oJT.vDhukRI/kXXeW5dPRBUEBhLNRRhk1s4mpLUpdANhmjC', NULL, '2026-05-12 16:35:27', '2026-05-12 16:35:27'),
(3, 'Admin User', 'admin@inventory.test', 'admin', NULL, '$2y$12$0aHsEEhpeyjV.shQmS2ZWOHlcPbiZIgTM6.wSZkaKPOfJHPae3OSa', NULL, '2026-05-12 22:16:16', '2026-05-12 22:57:12'),
(4, 'Supervisor User', 'supervisor@inventory.test', 'supervisor', NULL, '$2y$12$ABwI90YZGuRI56oD.mDAAeqtYuX8.kn6PXSbq7yiaZ/wQz1iX1CxW', NULL, '2026-05-12 22:16:16', '2026-05-12 22:57:12'),
(5, 'Operator User', 'operator@inventory.test', 'operator', NULL, '$2y$12$5G2T7oZK6KRmIdnNtbzdJ.VoAqpKNYwRdmOuR/aNqqsSzGhzU68nq', NULL, '2026-05-12 22:16:16', '2026-05-12 22:57:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `audit_logs_module_action_index` (`module`,`action`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `items_code_unique` (`code`),
  ADD KEY `items_created_by_foreign` (`created_by`);

--
-- Indexes for table `item_requests`
--
ALTER TABLE `item_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_requests_item_id_foreign` (`item_id`),
  ADD KEY `item_requests_requested_by_foreign` (`requested_by`),
  ADD KEY `item_requests_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `item_suppliers`
--
ALTER TABLE `item_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_suppliers_item_id_foreign` (`item_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_permissions`
--
ALTER TABLE `page_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_permissions_key_unique` (`key`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `stock_batches`
--
ALTER TABLE `stock_batches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_batches_batch_number_unique` (`batch_number`),
  ADD KEY `stock_batches_stock_receipt_id_foreign` (`stock_receipt_id`),
  ADD KEY `stock_batches_item_id_status_index` (`item_id`,`status`),
  ADD KEY `stock_batches_lot_number_index` (`lot_number`);

--
-- Indexes for table `stock_receipts`
--
ALTER TABLE `stock_receipts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_receipts_item_id_foreign` (`item_id`),
  ADD KEY `stock_receipts_received_by_foreign` (`received_by`),
  ADD KEY `stock_receipts_item_request_id_foreign` (`item_request_id`);

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
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `item_requests`
--
ALTER TABLE `item_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `item_suppliers`
--
ALTER TABLE `item_suppliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `page_permissions`
--
ALTER TABLE `page_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_batches`
--
ALTER TABLE `stock_batches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `stock_receipts`
--
ALTER TABLE `stock_receipts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `item_requests`
--
ALTER TABLE `item_requests`
  ADD CONSTRAINT `item_requests_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_requests_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `item_requests_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `item_suppliers`
--
ALTER TABLE `item_suppliers`
  ADD CONSTRAINT `item_suppliers_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_batches`
--
ALTER TABLE `stock_batches`
  ADD CONSTRAINT `stock_batches_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_batches_stock_receipt_id_foreign` FOREIGN KEY (`stock_receipt_id`) REFERENCES `stock_receipts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_receipts`
--
ALTER TABLE `stock_receipts`
  ADD CONSTRAINT `stock_receipts_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_receipts_item_request_id_foreign` FOREIGN KEY (`item_request_id`) REFERENCES `item_requests` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_receipts_received_by_foreign` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
