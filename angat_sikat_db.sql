-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2025 at 07:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `angat_sikat_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `advisers`
--

CREATE TABLE `advisers` (
  `adviser_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `position` varchar(255) NOT NULL,
  `archived` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advisers`
--

INSERT INTO `advisers` (`adviser_id`, `first_name`, `last_name`, `picture`, `organization_id`, `position`, `archived`) VALUES
(1, 'Renato', 'Bautista Jr.', 'renato.jpg', 1, 'Senior Adviser', 0),
(2, 'Janessa Marielle', 'Cruz', 'janessa.jpg', 1, 'Junior Adviser', 0),
(3, 'Anthony', 'Belen', 'irhyll.jpg', 7, 'Senior Adviser', 0),
(4, 'Marc Joshua', 'Prudente', 'mj.jpg', 7, 'Junior Adviser', 0);

-- --------------------------------------------------------

--
-- Table structure for table `balance_history`
--

CREATE TABLE `balance_history` (
  `history_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `balance` decimal(15,2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `balance_history`
--

INSERT INTO `balance_history` (`history_id`, `organization_id`, `balance`, `updated_at`, `created_by`) VALUES
(5, 3, 24600.00, '2025-01-13 09:16:45', 0),
(6, 1, 104000.00, '2025-01-13 11:25:17', 0),
(7, 1, 79000.00, '2025-01-13 11:25:49', 0),
(8, 1, 77750.00, '2025-01-14 03:02:09', 0),
(9, 7, 499700.00, '2025-01-14 06:22:27', 0),
(10, 7, 499800.00, '2025-01-14 06:25:05', 0),
(11, 1, 79750.00, '2025-01-14 07:54:02', 0),
(12, 1, 79000.00, '2025-01-14 07:54:39', 0),
(13, 1, 73000.00, '2025-01-14 08:32:24', 0),
(14, 3, 19400.00, '2025-01-15 10:00:42', 0),
(15, 3, 29400.00, '2025-01-15 10:03:52', 0),
(16, 1, 34000.00, '2025-01-15 10:48:07', 0),
(17, 1, 31900.00, '2025-01-15 11:14:12', 0),
(19, 1, 204750.00, '2025-01-16 13:47:36', 0),
(20, 1, 15000.00, '2025-01-17 16:38:17', 9),
(21, 1, 13250.00, '2025-01-17 17:46:08', 0),
(22, 1, 23250.00, '2025-01-17 18:00:20', 0),
(23, 1, 31500.00, '2025-01-20 05:41:08', 9),
(24, 1, 104750.00, '2025-01-20 05:49:44', 9),
(25, 1, 153000.00, '2025-01-20 05:58:42', 9),
(26, 1, 151900.00, '2025-01-20 06:25:33', 0),
(27, 1, 99050.00, '2025-01-20 16:57:57', 9),
(28, 1, 106200.00, '2025-01-20 17:00:05', 9),
(29, 1, 93350.00, '2025-01-20 17:01:26', 9),
(30, 1, 140500.00, '2025-01-20 17:19:09', 9),
(31, 1, 87650.00, '2025-01-20 17:23:03', 9);

-- --------------------------------------------------------

--
-- Table structure for table `beginning_balance_history`
--

CREATE TABLE `beginning_balance_history` (
  `id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `amount` double DEFAULT NULL,
  `reference` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beginning_balance_history`
--

INSERT INTO `beginning_balance_history` (`id`, `organization_id`, `amount`, `reference`, `created_at`, `updated_at`, `created_by`) VALUES
(7, 1, 10000, 'ref_678e86774c4a8.pdf\r\n', '2025-01-17 14:02:55', '2025-01-20 17:24:24', 9),
(8, 1, 5000, 'ref_678e86774c4a8.pdf\r\n', '2025-01-17 14:03:14', '2025-01-20 17:24:15', 9),
(9, 1, 10000, 'ref_678e86774c4a8.pdf\r\n', '2025-01-17 16:32:24', '2025-01-20 17:24:06', 9),
(10, 1, 15000, 'ref_678e86774c4a8.pdf\r\n', '2025-01-17 16:38:17', '2025-01-20 17:23:57', 9),
(11, 1, 25000, 'ref_678e86774c4a8.pdf\r\n', '2025-01-20 05:41:08', '2025-01-20 17:23:49', 9),
(12, 1, 110000, 'ref_678e86774c4a8.pdf\r\n', '2025-01-20 16:57:57', '2025-01-20 17:23:39', 9),
(13, 1, 100000, 'ref_678e86774c4a8.pdf\r\n', '2025-01-20 17:01:26', '2025-01-20 17:23:30', 9),
(14, 1, 100000, 'ref_678e86774c4a8.pdf', '2025-01-20 17:23:03', '2025-01-20 17:23:03', 9);

-- --------------------------------------------------------

--
-- Table structure for table `budget_allocation`
--

CREATE TABLE `budget_allocation` (
  `allocation_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `category` enum('Activities','Purchases','Maintenance and Other Expenses') NOT NULL,
  `allocated_budget` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_spent` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget_allocation`
--

INSERT INTO `budget_allocation` (`allocation_id`, `organization_id`, `category`, `allocated_budget`, `total_spent`, `created_at`, `updated_at`) VALUES
(14, 3, 'Activities', 40000.00, 5600.00, '2025-01-13 09:05:55', '2025-01-16 15:20:20'),
(15, 3, 'Purchases', 3000.00, 0.00, '2025-01-13 09:06:12', '2025-01-13 09:06:12'),
(16, 3, 'Maintenance and Other Expenses', 3000.00, 0.00, '2025-01-13 09:06:47', '2025-01-13 09:06:47'),
(17, 7, 'Purchases', 200000.00, 0.00, '2025-01-14 06:03:16', '2025-01-14 06:03:56'),
(18, 7, 'Maintenance and Other Expenses', 200000.00, 0.00, '2025-01-14 06:03:39', '2025-01-14 06:03:39'),
(19, 7, 'Activities', 100000.00, 300.00, '2025-01-14 06:04:08', '2025-01-14 06:22:26'),
(20, 1, 'Activities', 75000.00, 2850.00, '2025-01-20 05:59:46', '2025-01-20 06:25:33'),
(21, 1, 'Purchases', 20000.00, 0.00, '2025-01-20 05:59:59', '2025-01-20 05:59:59'),
(22, 1, 'Maintenance and Other Expenses', 10000.00, 0.00, '2025-01-20 06:00:15', '2025-01-20 06:00:15');

-- --------------------------------------------------------

--
-- Table structure for table `budget_approvals`
--

CREATE TABLE `budget_approvals` (
  `approval_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Disapproved') DEFAULT 'Pending',
  `organization_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `archived` tinyint(1) DEFAULT 0,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget_approvals`
--

INSERT INTO `budget_approvals` (`approval_id`, `title`, `category`, `attachment`, `status`, `organization_id`, `created_at`, `archived`, `updated_at`, `created_by`) VALUES
(5, 'Oplan Alisin ang mga Bading', 'Activities', 'Budget_Request_CyberCon 2025_1736416068.pdf', 'Approved', 3, '2025-01-13 09:13:10', 1, '2025-01-21 01:54:34', 0),
(8, 'Engineering Day', 'Activities', 'Budget_Request_AI Seminar_1736685544.pdf', 'Approved', 7, '2025-01-14 06:15:33', 0, '2025-01-21 01:54:34', 0),
(9, 'Merch', 'Activities', 'example_014.pdf', 'Approved', 7, '2025-01-14 06:23:41', 0, '2025-01-21 01:54:34', 0),
(14, 'FEO Day', 'Activities', 'Budget_Request_Podcast_January 14, 2025.pdf', 'Approved', 3, '2025-01-15 09:55:55', 0, '2025-01-21 01:54:34', 0),
(15, 'Merchandise Sale', 'Activities', 'example_014.pdf', 'Approved', 3, '2025-01-15 10:02:12', 0, '2025-01-21 01:54:34', 0),
(18, 'CyberCon 2025', 'Activities', 'Budget_Request_CyberCon 2025_January 17, 2025.pdf', 'Approved', 1, '2025-01-17 17:41:02', 0, '2025-01-21 01:54:34', 0),
(19, 'Merchandise Sale', 'Activities', 'Project_Proposal_Merchandise Sale.pdf', 'Approved', 1, '2025-01-17 17:58:22', 0, '2025-01-21 01:54:34', 0),
(20, 'TechFusion', 'Activities', 'main_savings-passbook-template.pdf', 'Approved', 1, '2025-01-20 06:12:59', 0, '2025-01-21 01:54:34', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cash_on_bank_history`
--

CREATE TABLE `cash_on_bank_history` (
  `id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `amount` double DEFAULT NULL,
  `reference` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cash_on_bank_history`
--

INSERT INTO `cash_on_bank_history` (`id`, `organization_id`, `amount`, `reference`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 1, 10000, 'ref_678a8a0ae842c.pdf', '2025-01-17 16:49:14', '2025-01-17 16:49:14', 9),
(2, 1, 3000, 'ref_678a8b5221a4d.pdf', '2025-01-17 16:54:42', '2025-01-17 16:54:42', 9),
(3, 1, 5000, 'ref_678d35877aa59.pdf', '2025-01-19 17:25:27', '2025-01-19 17:25:27', 9),
(4, 1, 50000, 'ref_678de63083e4d.pdf', '2025-01-20 05:59:12', '2025-01-20 05:59:12', 9);

-- --------------------------------------------------------

--
-- Table structure for table `cash_on_hand_history`
--

CREATE TABLE `cash_on_hand_history` (
  `id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `amount` double DEFAULT NULL,
  `reference` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cash_on_hand_history`
--

INSERT INTO `cash_on_hand_history` (`id`, `organization_id`, `amount`, `reference`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 1, -5000, 'ref_678e8ad349f6d.pdf', '2025-01-17 16:53:31', '2025-01-20 17:43:24', 9),
(2, 1, 2000, 'ref_678e8ad349f6d.pdf', '2025-01-17 16:55:18', '2025-01-20 17:43:14', 9),
(3, 1, 10000, 'ref_678e8ad349f6d.pdf', '2025-01-20 17:41:39', '2025-01-20 17:41:39', 9);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category`) VALUES
(1, 'Activities'),
(2, 'Purchases'),
(3, 'Maintenance and Other Expenses');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `event_venue` varchar(255) NOT NULL,
  `event_start_date` date NOT NULL,
  `event_end_date` date NOT NULL,
  `event_type` varchar(100) DEFAULT NULL,
  `event_status` enum('Pending','Approved','Disapproved') NOT NULL,
  `accomplishment_status` tinyint(1) DEFAULT 0,
  `total_amount` decimal(15,2) NOT NULL,
  `total_profit` decimal(15,2) NOT NULL,
  `organization_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `plan_id`, `title`, `event_venue`, `event_start_date`, `event_end_date`, `event_type`, `event_status`, `accomplishment_status`, `total_amount`, `total_profit`, `organization_id`, `created_by`, `created_at`, `archived`) VALUES
(6, 8, 'Oplan Alisin ang mga Bading', 'Diyan lang', '2025-01-14', '2025-01-15', 'Expense', 'Approved', 1, 400.00, 0.00, 3, NULL, '2025-01-13 09:09:00', 1),
(9, 11, 'Engineering Day', 'Bahay ni Norwin', '2025-01-30', '2026-01-14', 'Expense', 'Approved', 1, 3000.00, 0.00, 7, NULL, '2025-01-14 06:07:22', 0),
(10, 12, 'Merch', 'Bahay ni Norwin', '2025-01-16', '2025-01-16', 'Income', 'Approved', 1, 0.00, 0.00, 7, NULL, '2025-01-14 06:23:26', 0),
(11, 14, 'FEO Day', 'Department of Teacher Education', '2025-01-16', '2025-01-24', 'Expense', 'Approved', 1, 600.00, 0.00, 3, NULL, '2025-01-15 09:51:08', 0),
(12, 15, 'Merchandise Sale', 'Department of Teacher Education', '2025-01-17', '2025-01-18', 'Income', 'Approved', 1, 0.00, 0.00, 3, NULL, '2025-01-15 10:01:34', 0),
(16, 20, 'CyberCon 2025', 'Campus Court I', '2025-01-25', '2025-01-31', 'Expense', 'Approved', 1, 1750.00, 0.00, 1, NULL, '2025-01-17 17:38:02', 0),
(17, 21, 'Merchandise Sale', 'Department of Computer Studies', '2025-01-19', '2025-01-20', 'Income', 'Approved', 1, 30000.00, 10000.00, 1, NULL, '2025-01-17 17:47:53', 0),
(18, 22, 'TechFusion', 'Department of Computer Studies', '2025-01-24', '2025-01-25', 'Expense', 'Approved', 1, 1100.00, 0.00, 1, NULL, '2025-01-20 06:04:25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `events_summary`
--

CREATE TABLE `events_summary` (
  `summary_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `venue` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `total_profit` decimal(15,2) NOT NULL,
  `status` enum('Pending','Approved','Disapproved') NOT NULL,
  `accomplishment_status` tinyint(4) DEFAULT NULL,
  `archived` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events_summary`
--

INSERT INTO `events_summary` (`summary_id`, `event_id`, `title`, `venue`, `start_date`, `end_date`, `type`, `organization_id`, `total_amount`, `total_profit`, `status`, `accomplishment_status`, `archived`, `created_at`, `updated_at`) VALUES
(14, 16, 'CyberCon 2025', 'Campus Court I', '2025-01-25', '2025-01-31', 'Expense', 1, 1750.00, 0.00, 'Approved', NULL, 0, '2025-01-17 17:43:24', '2025-01-17 17:44:04'),
(15, 17, 'Merchandise Sale', 'Department of Computer Studies', '2025-01-19', '2025-01-20', 'Income', 1, 30000.00, 10000.00, 'Approved', NULL, 0, '2025-01-17 17:59:00', '2025-01-17 17:59:20'),
(16, 18, 'TechFusion', 'Department of Computer Studies', '2025-01-24', '2025-01-25', 'Expense', 1, 1100.00, 0.00, 'Approved', NULL, 0, '2025-01-20 06:22:53', '2025-01-20 06:24:09');

-- --------------------------------------------------------

--
-- Table structure for table `event_items`
--

CREATE TABLE `event_items` (
  `item_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `profit` decimal(15,2) NOT NULL,
  `total_profit` decimal(15,2) NOT NULL,
  `type` enum('revenue','expense') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_items`
--

INSERT INTO `event_items` (`item_id`, `event_id`, `description`, `quantity`, `unit`, `amount`, `total_amount`, `profit`, `total_profit`, `type`) VALUES
(23, 16, 'Food for Officers', 10, NULL, 100.00, 1000.00, 0.00, 0.00, 'expense'),
(24, 16, 'Food for Judges', 5, NULL, 150.00, 750.00, 0.00, 0.00, 'expense'),
(25, 17, 'BYTE Lanyard', 200, NULL, 100.00, 30000.00, 50.00, 10000.00, 'revenue'),
(26, 18, 'Food', 10, NULL, 100.00, 1000.00, 0.00, 0.00, 'expense'),
(27, 18, 'Water', 10, NULL, 10.00, 100.00, 0.00, 0.00, 'expense');

-- --------------------------------------------------------

--
-- Table structure for table `event_summary_items`
--

CREATE TABLE `event_summary_items` (
  `summary_item_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `profit` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `total_profit` decimal(15,2) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_summary_items`
--

INSERT INTO `event_summary_items` (`summary_item_id`, `event_id`, `description`, `quantity`, `unit`, `amount`, `profit`, `total_amount`, `total_profit`, `reference`, `date`) VALUES
(29, 11, 'food', 10, 0, 60.00, 0.00, 600.00, 0.00, 'basic-basic-receipt-template.pdf', '2025-01-18'),
(30, 16, 'Food for Officers', 10, 0, 100.00, 0.00, 1000.00, 0.00, 'basic-basic-receipt-template.pdf', '2025-01-21'),
(31, 16, 'Food for Judges', 5, 0, 150.00, 0.00, 750.00, 0.00, 'basic-basic-receipt-template.pdf', '2025-01-20'),
(32, 17, 'BYTE Lanyard', 200, 0, 100.00, 50.00, 30000.00, 10000.00, 'basic-basic-receipt-template.pdf', '2025-01-19'),
(33, 18, 'Food', 10, 0, 100.00, 0.00, 1000.00, 0.00, 'basic-basic-receipt-template.pdf', '2025-01-23'),
(34, 18, 'Water', 10, 0, 10.00, 0.00, 100.00, 0.00, 'basic-basic-receipt-template.pdf', '2025-01-21');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `summary_id` int(11) NOT NULL,
  `category` enum('Activities','Purchases','Maintenance and Other Expenses') NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `archived` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `organization_id`, `summary_id`, `category`, `title`, `amount`, `reference`, `created_at`, `archived`) VALUES
(6, 7, 6, 'Activities', 'Engineering Day', 300.00, 'Liquidation_General Assembly_1736370703.pdf', '2025-01-14 06:22:26', 0),
(9, 3, 10, 'Activities', 'FEO Day', 5200.00, 'Budget_Request_Podcast_January 14, 2025.pdf', '2025-01-15 10:00:42', 0),
(12, 1, 14, 'Activities', 'CyberCon 2025', 1750.00, 'LR 1.pdf', '2025-01-17 17:46:08', 0),
(13, 1, 16, 'Activities', 'TechFusion', 1100.00, 'Project_Proposal_Merchandise Sale.pdf', '2025-01-20 06:25:33', 0);

-- --------------------------------------------------------

--
-- Table structure for table `expense_history`
--

CREATE TABLE `expense_history` (
  `history_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `expense` decimal(10,2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense_history`
--

INSERT INTO `expense_history` (`history_id`, `organization_id`, `expense`, `updated_at`, `created_by`) VALUES
(3, 3, 400.00, '2025-01-13 09:16:45', 0),
(6, 7, 300.00, '2025-01-14 06:22:27', 0),
(9, 3, 5200.00, '2025-01-15 10:00:42', 0),
(12, 1, 1750.00, '2025-01-17 17:46:08', 0),
(13, 1, 1100.00, '2025-01-20 06:25:33', 0);

-- --------------------------------------------------------

--
-- Table structure for table `financial_plan`
--

CREATE TABLE `financial_plan` (
  `plan_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` enum('Activities','Purchases','Maintenance and Other Expenses') NOT NULL,
  `organization_id` int(11) NOT NULL,
  `type` enum('Income','Expense') NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `financial_plan`
--

INSERT INTO `financial_plan` (`plan_id`, `title`, `category`, `organization_id`, `type`, `date`, `amount`) VALUES
(8, 'Oplan Alisin ang mga Bading', 'Activities', 3, 'Expense', '2025-01-14', 10000.00),
(11, 'Engineering Day', 'Activities', 7, 'Expense', '2025-01-30', 3000.00),
(12, 'Merch', '', 7, 'Income', '2025-01-16', 15000.00),
(14, 'FEO Day', 'Activities', 3, 'Expense', '2025-01-16', 5000.00),
(15, 'Merchandise Sale', '', 3, 'Income', '2025-01-16', 5000.00),
(20, 'CyberCon 2025', 'Activities', 1, 'Expense', '2025-01-25', 50000.00),
(21, 'Merchandise Sale', '', 1, 'Income', '2025-01-19', 30000.00),
(22, 'TechFusion', 'Activities', 1, 'Expense', '2025-01-24', 10000.00);

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `income_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `summary_id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `archived` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`income_id`, `organization_id`, `summary_id`, `category`, `title`, `amount`, `reference`, `created_at`, `archived`) VALUES
(4, 7, 7, '', 'Merch', 100.00, 'example_014.pdf', '2025-01-14 06:25:05', 0),
(6, 3, 11, '', 'Merchandise Sale', 10000.00, 'example_014.pdf', '2025-01-15 10:03:52', 0),
(7, 1, 15, '', 'Merchandise Sale', 10000.00, 'basic-basic-receipt-template.pdf', '2025-01-17 18:00:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `income_history`
--

CREATE TABLE `income_history` (
  `history_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `income` decimal(10,2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income_history`
--

INSERT INTO `income_history` (`history_id`, `organization_id`, `income`, `updated_at`, `created_by`) VALUES
(4, 7, 100.00, '2025-01-14 06:25:05', 0),
(6, 3, 10000.00, '2025-01-15 10:03:52', 0),
(7, 1, 15000.00, '2025-01-17 16:38:17', 9),
(8, 1, 10000.00, '2025-01-17 18:00:20', 0),
(9, 1, 35000.00, '2025-01-20 05:41:08', 9),
(10, 1, 110000.00, '2025-01-20 05:49:44', 9),
(11, 1, 160000.00, '2025-01-20 05:58:42', 9),
(12, 1, 110000.00, '2025-01-20 16:57:57', 9),
(13, 1, 120000.00, '2025-01-20 17:00:05', 9),
(14, 1, 110000.00, '2025-01-20 17:01:26', 9),
(15, 1, 160000.00, '2025-01-20 17:19:09', 9),
(16, 1, 110000.00, '2025-01-20 17:23:03', 9);

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `maintenance_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) DEFAULT 0.00,
  `maintenance_status` enum('Pending','Approved','Disapproved') DEFAULT 'Pending',
  `completion_status` tinyint(1) DEFAULT 0,
  `organization_id` int(11) NOT NULL,
  `archived` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_items`
--

CREATE TABLE `maintenance_items` (
  `item_id` int(11) NOT NULL,
  `maintenance_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_summary`
--

CREATE TABLE `maintenance_summary` (
  `summary_id` int(11) NOT NULL,
  `maintenance_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `maintenance_status` enum('Pending','Approved','Disapproved') NOT NULL,
  `completion_status` tinyint(4) DEFAULT 0,
  `archived` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_summary_items`
--

CREATE TABLE `maintenance_summary_items` (
  `summary_item_id` int(11) NOT NULL,
  `maintenance_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `reference` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `recipient_id`, `organization_id`, `message`, `is_read`, `created_at`) VALUES
(65, 9, 1, 'The total amount for the event \'AI Seminar\' has exceeded the allocated budget.', 1, '2025-01-15 14:18:56'),
(66, 10, 1, 'The total amount for the event \'AI Seminar\' has exceeded the allocated budget.', 1, '2025-01-15 14:18:56'),
(67, 9, 1, 'The total amount for the event \'AI Seminar\' has exceeded the allocated budget.', 1, '2025-01-15 14:36:21'),
(68, 10, 1, 'The total amount for the event \'AI Seminar\' has exceeded the allocated budget.', 1, '2025-01-15 14:36:21'),
(70, 9, 1, 'The total amount for the event \'AI Seminar\' has exceeded the allocated budget.', 1, '2025-01-15 14:36:21'),
(71, 10, 1, 'The total amount for the event \'AI Seminar\' has exceeded the allocated budget.', 1, '2025-01-15 14:36:21'),
(73, 9, 1, 'The total amount for the event \'AI Seminar\' has exceeded the allocated budget.', 1, '2025-01-15 14:37:31'),
(74, 10, 1, 'The total amount for the event \'AI Seminar\' has exceeded the allocated budget.', 1, '2025-01-15 14:37:31'),
(75, 3, 0, 'A new budget approval request for \'FEO Day\' has been submitted.', 0, '2025-01-15 17:55:55'),
(76, 11, 3, 'Your budget request for \'FEO Day\' has been approved.', 0, '2025-01-15 17:56:33'),
(77, 11, 3, 'The total amount for the event \'FEO Day\' has exceeded the allocated budget.', 0, '2025-01-15 17:59:24'),
(78, 3, 0, 'A new budget approval request for \'Merchandise Sale\' has been submitted.', 0, '2025-01-15 18:02:12'),
(79, 11, 3, 'Your budget request for \'Merchandise Sale\' has been approved.', 0, '2025-01-15 18:02:33'),
(80, 11, 3, 'The total amount for the event \'Merchandise Sale\' has exceeded the allocated budget.', 0, '2025-01-15 18:03:28'),
(81, 3, 0, 'A new budget approval request for \'Accreditation\' has been submitted.', 0, '2025-01-15 18:43:36'),
(82, 9, 1, 'Your budget request for \'Accreditation\' has been approved.', 1, '2025-01-15 18:44:19'),
(83, 10, 1, 'Your budget request for \'Accreditation\' has been approved.', 0, '2025-01-15 18:44:19'),
(85, 9, 1, 'The total amount for the event \'Accreditation\' has exceeded the allocated budget.', 1, '2025-01-15 18:46:34'),
(86, 10, 1, 'The total amount for the event \'Accreditation\' has exceeded the allocated budget.', 0, '2025-01-15 18:46:34'),
(88, 3, 0, 'A new budget approval request for \'TechSpark\' has been submitted.', 0, '2025-01-15 19:09:52'),
(89, 9, 1, 'Your budget request for \'TechSpark\' has been approved.', 1, '2025-01-15 19:10:28'),
(90, 10, 1, 'Your budget request for \'TechSpark\' has been approved.', 0, '2025-01-15 19:10:28'),
(92, 9, 1, 'The total amount for the event \'TechSpark\' has exceeded the allocated budget.', 1, '2025-01-15 19:12:30'),
(93, 10, 1, 'The total amount for the event \'TechSpark\' has exceeded the allocated budget.', 0, '2025-01-15 19:12:30'),
(94, 3, 0, 'A new budget approval request for \'CyberCon 2025\' has been submitted.', 0, '2025-01-18 01:41:02'),
(95, 9, 1, 'Your budget request for \'CyberCon 2025\' has been approved.', 0, '2025-01-18 01:42:47'),
(96, 10, 1, 'Your budget request for \'CyberCon 2025\' has been approved.', 0, '2025-01-18 01:42:47'),
(98, 3, 0, 'A new budget approval request for \'Merchandise Sale\' has been submitted.', 0, '2025-01-18 01:58:22'),
(99, 9, 1, 'Your budget request for \'Merchandise Sale\' has been approved.', 0, '2025-01-18 01:58:43'),
(100, 10, 1, 'Your budget request for \'Merchandise Sale\' has been approved.', 0, '2025-01-18 01:58:43'),
(101, 3, 0, 'A new budget approval request for \'TechFusion\' has been submitted.', 0, '2025-01-20 14:12:59'),
(102, 9, 1, 'Your budget request for \'TechFusion\' has been approved.', 0, '2025-01-20 14:21:29'),
(103, 10, 1, 'Your budget request for \'TechFusion\' has been approved.', 0, '2025-01-20 14:21:29'),
(105, 9, 1, 'The total amount for the event \'TechFusion\' has exceeded the allocated budget.', 0, '2025-01-20 14:23:49'),
(106, 10, 1, 'The total amount for the event \'TechFusion\' has exceeded the allocated budget.', 0, '2025-01-20 14:23:49'),
(108, 9, 1, 'The total amount for the event \'TechFusion\' has exceeded the allocated budget.', 0, '2025-01-20 14:23:49'),
(109, 10, 1, 'The total amount for the event \'TechFusion\' has exceeded the allocated budget.', 0, '2025-01-20 14:23:49');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `organization_id` int(11) NOT NULL,
  `organization_name` varchar(255) NOT NULL,
  `acronym` varchar(100) NOT NULL,
  `organization_logo` varchar(255) DEFAULT NULL,
  `organization_members` int(11) NOT NULL DEFAULT 0,
  `organization_status` enum('Probationary','Level I','Level II') NOT NULL DEFAULT 'Probationary',
  `organization_color` varchar(7) DEFAULT NULL,
  `archived` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `balance` decimal(15,2) DEFAULT 0.00,
  `beginning_balance` decimal(15,2) DEFAULT 0.00,
  `income` decimal(15,2) DEFAULT 0.00,
  `expense` decimal(15,2) DEFAULT 0.00,
  `cash_on_bank` decimal(15,2) DEFAULT 0.00,
  `cash_on_hand` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`organization_id`, `organization_name`, `acronym`, `organization_logo`, `organization_members`, `organization_status`, `organization_color`, `archived`, `created_at`, `balance`, `beginning_balance`, `income`, `expense`, `cash_on_bank`, `cash_on_hand`) VALUES
(1, 'Beacon of Youth Technology Enthusiasts', 'BYTE', 'logo_67820e1e2686b9.12993510.png', 500, 'Level I', '#2d473a', 0, '2025-01-11 06:22:22', 87650.00, 100000.00, 110000.00, 2850.00, 68000.00, 12000.00),
(2, 'Computer Scientists and Developers Society', 'CO:DE', 'logo_67849b259beea0.69837837.png', 300, 'Level I', '#247cdb', 0, '2025-01-13 04:48:37', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(3, 'Future Educators Organization', 'FEO', 'logo_6784d61999de24.21054574.png', 500, 'Level I', '#22b2e2', 0, '2025-01-13 09:00:09', 48800.00, 50000.00, 60000.00, 5600.00, 15000.00, 0.00),
(4, 'Junior Marketing Association', 'JMA', 'logo_67851d7cf1e3e2.73446431.jpg', 700, 'Level I', '#001865', 0, '2025-01-13 14:04:44', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(5, 'Society of Industrial Technology Students', 'SITS', 'logo_67851de043f9f9.89451503.jpg', 1000, 'Level I', '#e0aa3d', 0, '2025-01-13 14:06:24', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(6, 'Sikat E-Sports Club', 'SITS', 'logo_67851e4104a265.31041356.jpg', 100, 'Level I', '#3679ec', 0, '2025-01-13 14:08:01', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(7, 'Association of Computer Engineering Students', 'ACES', 'logo_67851ee89fd7a0.37440779.jpg', 300, 'Level I', '#64b98f', 0, '2025-01-13 14:10:48', 499800.00, 500000.00, 500100.00, 300.00, 0.00, 0.00),
(8, 'Institute of Integrated Electrical Engineers', 'IIEE', 'logo_6785205cdd1aa5.70397214.jpg', 400, 'Level I', '#fdb81d', 0, '2025-01-13 14:17:00', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(9, 'Artrads Dance Crew', 'Artrads', 'logo_678520faca4db4.43978443.png', 30, 'Level I', '#e9bf0f', 0, '2025-01-13 14:19:38', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(10, 'CCAT Chorale', 'Chorale', 'logo_678521a13bc1d0.72249552.jpg', 35, 'Level I', '#039ce2', 0, '2025-01-13 14:22:25', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(11, 'Beacon of Youth Technology Enthusiasts 2', 'BYTE', 'logo_678deb13347732.54117284.jpg', 200, 'Level I', '#c93b3b', 1, '2025-01-20 06:20:03', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) DEFAULT 0.00,
  `purchase_status` enum('Pending','Approved','Disapproved') NOT NULL DEFAULT 'Pending',
  `completion_status` tinyint(1) DEFAULT 0,
  `archived` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `organization_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases_summary`
--

CREATE TABLE `purchases_summary` (
  `summary_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `purchase_status` enum('Pending','Approved','Disapproved') NOT NULL,
  `completion_status` tinyint(4) DEFAULT 0,
  `archived` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `item_id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) GENERATED ALWAYS AS (`quantity` * `amount`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_summary_items`
--

CREATE TABLE `purchase_summary_items` (
  `summary_item_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `reference` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `report_type` enum('Budget Request','Project Proposal','Liquidation','Accomplishment') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `semester_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` enum('First','Second') NOT NULL,
  `year_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`semester_id`, `name`, `type`, `year_id`, `start_date`, `end_date`, `status`) VALUES
(2, 'First Semester AY 2024-2025', 'First', 1, '2024-09-16', '2025-01-16', 'Active'),
(3, 'Second Semester AY 2024-2025', 'Second', 1, '2025-02-03', '2025-06-13', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','officer','member') NOT NULL,
  `organization_id` int(11) DEFAULT NULL,
  `archived` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `position` enum('President','Treasurer') NOT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `is_locked` tinyint(1) DEFAULT 0,
  `last_failed_attempt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `profile_picture`, `first_name`, `last_name`, `email`, `role`, `organization_id`, `archived`, `created_at`, `position`, `failed_attempts`, `is_locked`, `last_failed_attempt`) VALUES
(3, 'admin', '$2y$10$ZhjHxFaq77LMDZK1WSfss.w6QvlSROnTpjIE9Gov/wb7soNaNY/f6', 'uploads/guill.jpg', 'Guillier', 'Parulan', 'guillier@cvsu.edu.ph', 'admin', NULL, 0, '2024-12-23 16:21:49', 'President', 0, 0, NULL),
(9, 'Maphil', '$2y$10$rgoeHdju14TjzSh9meKP1exVzAiisOuKU6rFvSVtRtc/j0qtcp3N6', 'uploads/maphil.jpg', 'Maphil Grace', 'Alquizola', 'maphil.grace.alquizola@cvsu.edu.ph', 'officer', 1, 0, '2025-01-11 06:23:48', 'Treasurer', 0, 0, NULL),
(10, 'Joshua', '$2y$10$rSt1JzKaU1lLchnwDqCA7e89aXsEw7PkX0VmAy2ppBgr7vboNQH3K', '', 'Joshua', 'Sanchez', 'joshua.sanchez@cvsu.edu.ph', 'officer', 1, 0, '2025-01-11 16:20:23', 'President', 0, 0, NULL),
(11, 'cervyramos', '$2y$10$RaSN1K8P67YgLny2bWjO/.VPlsDIKgost6p44iEgakxxF1/WyJAny', '', 'Cervy', 'Ramos', 'cervy.ramos@cvsu.edu.ph', 'officer', 3, 0, '2025-01-13 09:01:56', 'President', 0, 0, NULL),
(12, 'norwin_erni', '$2y$10$FrUvu6dBe/xlIGzdj..4leK48PHsfnSspNeAwbW2hfZbecjC1gqO6', '', 'Norwin', 'Erni', 'norwin.erni@cvsu.edu.ph', 'officer', 7, 0, '2025-01-14 05:58:30', 'President', 0, 0, NULL),
(13, 'Apocalyptic', '$2y$10$XQtf.aG6ab42ACI0R0NdxeDcNWoY1r7A4lkjl7ZR4.H/4WB3BCllK', '', 'Ouen', 'Villaranda', 'rc.ouen.villaranda@cvsu.edu.ph', 'officer', 7, 0, '2025-01-14 06:00:39', 'Treasurer', 0, 0, NULL),
(14, 'JerichoPao', '$2y$10$TV/QfUIXXnwEuprft/BH0OJIe8tR2PLxEncKbGnSgMIo0.dvEJH6m', '', 'Jericho', 'Ramos', 'jericho.ramos@cvsu.edu.ph', 'officer', 10, 0, '2025-01-20 06:18:08', 'President', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `venue_id` int(11) NOT NULL,
  `venue_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`venue_id`, `venue_name`) VALUES
(1, 'Campus Court I'),
(2, 'Campus Court II'),
(3, 'Campus Quadrangle'),
(4, 'Campus Oval'),
(5, 'Technovation Building'),
(6, 'Department of Teacher Education'),
(7, 'Department of Engineering'),
(8, 'Department of Industrial Technology'),
(9, 'Department of Management Studies'),
(10, 'Department of Business Administration'),
(11, 'Department of Computer Studies');

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `year_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`year_id`, `name`, `start_date`, `end_date`, `status`) VALUES
(1, 'AY 2024-2025', '2024-09-16', '2025-06-13', 'Active'),
(2, 'AY 2025-2026', '2025-10-08', '2026-07-16', 'Inactive');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advisers`
--
ALTER TABLE `advisers`
  ADD PRIMARY KEY (`adviser_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `balance_history`
--
ALTER TABLE `balance_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `beginning_balance_history`
--
ALTER TABLE `beginning_balance_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organization_id` (`organization_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `budget_allocation`
--
ALTER TABLE `budget_allocation`
  ADD PRIMARY KEY (`allocation_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `budget_approvals`
--
ALTER TABLE `budget_approvals`
  ADD PRIMARY KEY (`approval_id`),
  ADD KEY `fk_organization` (`organization_id`);

--
-- Indexes for table `cash_on_bank_history`
--
ALTER TABLE `cash_on_bank_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organization_id` (`organization_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `cash_on_hand_history`
--
ALTER TABLE `cash_on_hand_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organization_id` (`organization_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `organization_id` (`organization_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `fk_events_plan_id` (`plan_id`);

--
-- Indexes for table `events_summary`
--
ALTER TABLE `events_summary`
  ADD PRIMARY KEY (`summary_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `event_items`
--
ALTER TABLE `event_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `event_summary_items`
--
ALTER TABLE `event_summary_items`
  ADD PRIMARY KEY (`summary_item_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `expense_history`
--
ALTER TABLE `expense_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `financial_plan`
--
ALTER TABLE `financial_plan`
  ADD PRIMARY KEY (`plan_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `income_history`
--
ALTER TABLE `income_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`maintenance_id`),
  ADD KEY `fk_organization_maintenance` (`organization_id`),
  ADD KEY `fk_maintenance_plan_id` (`plan_id`);

--
-- Indexes for table `maintenance_items`
--
ALTER TABLE `maintenance_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `maintenance_id` (`maintenance_id`);

--
-- Indexes for table `maintenance_summary`
--
ALTER TABLE `maintenance_summary`
  ADD PRIMARY KEY (`summary_id`),
  ADD KEY `maintenance_id` (`maintenance_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `maintenance_summary_items`
--
ALTER TABLE `maintenance_summary_items`
  ADD PRIMARY KEY (`summary_item_id`),
  ADD KEY `maintenance_id` (`maintenance_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipient_id` (`recipient_id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`organization_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `fk_organization_id` (`organization_id`),
  ADD KEY `fk_purchases_plan_id` (`plan_id`);

--
-- Indexes for table `purchases_summary`
--
ALTER TABLE `purchases_summary`
  ADD PRIMARY KEY (`summary_id`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `purchase_id` (`purchase_id`);

--
-- Indexes for table `purchase_summary_items`
--
ALTER TABLE `purchase_summary_items`
  ADD PRIMARY KEY (`summary_item_id`),
  ADD KEY `purchase_id` (`purchase_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `organization_id` (`organization_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`semester_id`),
  ADD KEY `fk_year` (`year_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`venue_id`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`year_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advisers`
--
ALTER TABLE `advisers`
  MODIFY `adviser_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `balance_history`
--
ALTER TABLE `balance_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `beginning_balance_history`
--
ALTER TABLE `beginning_balance_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `budget_allocation`
--
ALTER TABLE `budget_allocation`
  MODIFY `allocation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `budget_approvals`
--
ALTER TABLE `budget_approvals`
  MODIFY `approval_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `cash_on_bank_history`
--
ALTER TABLE `cash_on_bank_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cash_on_hand_history`
--
ALTER TABLE `cash_on_hand_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `events_summary`
--
ALTER TABLE `events_summary`
  MODIFY `summary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `event_items`
--
ALTER TABLE `event_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `event_summary_items`
--
ALTER TABLE `event_summary_items`
  MODIFY `summary_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `expense_history`
--
ALTER TABLE `expense_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `financial_plan`
--
ALTER TABLE `financial_plan`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `income_history`
--
ALTER TABLE `income_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `maintenance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `maintenance_items`
--
ALTER TABLE `maintenance_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_summary`
--
ALTER TABLE `maintenance_summary`
  MODIFY `summary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `maintenance_summary_items`
--
ALTER TABLE `maintenance_summary_items`
  MODIFY `summary_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchases_summary`
--
ALTER TABLE `purchases_summary`
  MODIFY `summary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchase_summary_items`
--
ALTER TABLE `purchase_summary_items`
  MODIFY `summary_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `semester_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `venue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
  MODIFY `year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `advisers`
--
ALTER TABLE `advisers`
  ADD CONSTRAINT `advisers_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `balance_history`
--
ALTER TABLE `balance_history`
  ADD CONSTRAINT `balance_history_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `beginning_balance_history`
--
ALTER TABLE `beginning_balance_history`
  ADD CONSTRAINT `beginning_balance_history_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`),
  ADD CONSTRAINT `beginning_balance_history_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `budget_allocation`
--
ALTER TABLE `budget_allocation`
  ADD CONSTRAINT `budget_allocation_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `budget_approvals`
--
ALTER TABLE `budget_approvals`
  ADD CONSTRAINT `fk_organization` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `cash_on_bank_history`
--
ALTER TABLE `cash_on_bank_history`
  ADD CONSTRAINT `cash_on_bank_history_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`),
  ADD CONSTRAINT `cash_on_bank_history_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `cash_on_hand_history`
--
ALTER TABLE `cash_on_hand_history`
  ADD CONSTRAINT `cash_on_hand_history_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`),
  ADD CONSTRAINT `cash_on_hand_history_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_events_plan_id` FOREIGN KEY (`plan_id`) REFERENCES `financial_plan` (`plan_id`);

--
-- Constraints for table `events_summary`
--
ALTER TABLE `events_summary`
  ADD CONSTRAINT `events_summary_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `events_summary_ibfk_2` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `event_items`
--
ALTER TABLE `event_items`
  ADD CONSTRAINT `event_items_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);

--
-- Constraints for table `event_summary_items`
--
ALTER TABLE `event_summary_items`
  ADD CONSTRAINT `event_summary_items_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `expense_history`
--
ALTER TABLE `expense_history`
  ADD CONSTRAINT `expense_history_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `financial_plan`
--
ALTER TABLE `financial_plan`
  ADD CONSTRAINT `financial_plan_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `income_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `income_history`
--
ALTER TABLE `income_history`
  ADD CONSTRAINT `income_history_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `fk_maintenance_plan_id` FOREIGN KEY (`plan_id`) REFERENCES `financial_plan` (`plan_id`),
  ADD CONSTRAINT `fk_organization_maintenance` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenance_items`
--
ALTER TABLE `maintenance_items`
  ADD CONSTRAINT `maintenance_items_ibfk_1` FOREIGN KEY (`maintenance_id`) REFERENCES `maintenance` (`maintenance_id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenance_summary`
--
ALTER TABLE `maintenance_summary`
  ADD CONSTRAINT `maintenance_summary_ibfk_1` FOREIGN KEY (`maintenance_id`) REFERENCES `maintenance` (`maintenance_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_summary_ibfk_2` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenance_summary_items`
--
ALTER TABLE `maintenance_summary_items`
  ADD CONSTRAINT `maintenance_summary_items_ibfk_1` FOREIGN KEY (`maintenance_id`) REFERENCES `maintenance` (`maintenance_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `fk_organization_id` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_purchases_plan_id` FOREIGN KEY (`plan_id`) REFERENCES `financial_plan` (`plan_id`);

--
-- Constraints for table `purchases_summary`
--
ALTER TABLE `purchases_summary`
  ADD CONSTRAINT `purchases_summary_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`purchase_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_summary_ibfk_2` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD CONSTRAINT `purchase_items_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`purchase_id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_summary_items`
--
ALTER TABLE `purchase_summary_items`
  ADD CONSTRAINT `purchase_summary_items_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`purchase_id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `semesters`
--
ALTER TABLE `semesters`
  ADD CONSTRAINT `fk_year` FOREIGN KEY (`year_id`) REFERENCES `years` (`year_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
