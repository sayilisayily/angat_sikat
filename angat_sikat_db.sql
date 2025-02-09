-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 30, 2025 at 03:29 AM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u263707854_angatccat`
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
(4, 'Marc Joshua', 'Prudente', 'mj.jpg', 7, 'Junior Adviser', 0),
(5, 'Aira Cleoffanie', 'Vergara', 'aira.jpg', 5, 'Senior Adviser', 1);

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
(43, 1, 25000.00, '2025-01-29 17:17:23', 9),
(44, 1, 21000.00, '2025-01-29 17:38:53', 9),
(45, 1, 42000.00, '2025-01-29 18:03:28', 10),
(46, 1, 46000.00, '2025-01-29 18:05:25', 10),
(47, 8, 100000.00, '2025-01-30 02:59:44', 15),
(48, 8, 91000.00, '2025-01-30 03:11:11', 15);

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
(21, 1, 25000, 'ref_679a62a312d96.pdf', '2025-01-29 17:17:23', '2025-01-29 17:17:23', 9),
(22, 1, 50000, 'ref_679a6d7020125.pdf', '2025-01-29 18:03:28', '2025-01-29 18:03:28', 10),
(23, 8, 100000, 'ref_679aeb20781bc.pdf', '2025-01-30 02:59:44', '2025-01-30 02:59:44', 15);

-- --------------------------------------------------------

--
-- Table structure for table `beginning_balance_summary`
--

CREATE TABLE `beginning_balance_summary` (
  `summary_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `total_profit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `beginning_balance_summary`
--

INSERT INTO `beginning_balance_summary` (`summary_id`, `organization_id`, `title`, `total_profit`, `created_at`, `updated_at`) VALUES
(4, 1, 'Membership Fee (First Semester)', 14500.00, '2025-01-29 17:19:40', '2025-01-29 17:53:02');

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
(31, 1, 'Activities', 35000.00, 4000.00, '2025-01-29 17:17:57', '2025-01-29 23:42:55'),
(32, 1, 'Purchases', 0.00, 0.00, '2025-01-29 17:18:10', '2025-01-29 23:50:13'),
(33, 1, 'Maintenance and Other Expenses', 5000.00, 0.00, '2025-01-29 17:18:21', '2025-01-29 17:18:21'),
(34, 8, 'Activities', 75000.00, 9000.00, '2025-01-30 03:00:48', '2025-01-30 03:11:11'),
(35, 8, 'Maintenance and Other Expenses', 20000.00, 0.00, '2025-01-30 03:00:58', '2025-01-30 03:00:58'),
(36, 8, 'Purchases', 5000.00, 0.00, '2025-01-30 03:01:14', '2025-01-30 03:01:14');

-- --------------------------------------------------------

--
-- Table structure for table `budget_approvals`
--

CREATE TABLE `budget_approvals` (
  `approval_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` enum('Activities','Purchases','Maintenance') NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `status` enum('Pending','Approved','Disapproved') DEFAULT 'Pending',
  `archived` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget_approvals`
--

INSERT INTO `budget_approvals` (`approval_id`, `organization_id`, `title`, `category`, `attachment`, `created_at`, `created_by`, `status`, `archived`) VALUES
(8, 1, 'Techfest', 'Activities', 'Budget_Request_AI Seminar_1736685544.pdf', '2025-01-29 17:29:34', 9, 'Approved', 0),
(9, 1, 'Merchandise', 'Activities', 'ProjectProposal.pdf', '2025-01-29 17:42:12', 9, 'Approved', 0),
(10, 8, 'IIEE Day', 'Activities', 'Budget_Request_IIEE Day_January 30, 2025.pdf', '2025-01-30 03:06:51', 15, 'Approved', 0);

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
(10, 1, 46000, 'ref_679abcddc631b.pdf', '2025-01-29 23:42:21', '2025-01-29 23:42:21', 10),
(11, 8, 100000, 'ref_679aeb5323598.pdf', '2025-01-30 03:00:35', '2025-01-30 03:00:35', 15);

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
(27, 35, 'Techfest', 'Department of Industrial Technology', '2025-02-08', '2025-02-28', 'Expense', 'Approved', 1, 4500.00, 0.00, 1, NULL, '2025-01-29 17:21:58', 0),
(28, 36, 'Merchandise', 'Department of Computer Studies', '2025-02-01', '2025-02-28', 'Income', 'Approved', 1, 14000.00, 4000.00, 1, NULL, '2025-01-29 17:41:43', 0),
(29, 37, 'IIEE Day', 'Department of Engineering', '2025-02-03', '2025-02-03', 'Expense', 'Approved', 1, 9000.00, 0.00, 8, NULL, '2025-01-30 03:02:32', 0);

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
(20, 27, 'Techfest', 'Department of Industrial Technology', '2025-02-08', '2025-02-28', 'Expense', 1, 4000.00, 0.00, 'Approved', NULL, 0, '2025-01-29 17:31:32', '2025-01-29 17:37:01'),
(21, 28, 'Merchandise', 'Department of Computer Studies', '2025-02-01', '2025-02-28', 'Income', 1, 14000.00, 4000.00, 'Approved', NULL, 0, '2025-01-29 18:04:09', '2025-01-29 18:05:02'),
(22, 29, 'IIEE Day', 'Department of Engineering', '2025-02-03', '2025-02-03', 'Expense', 8, 9000.00, 0.00, 'Approved', NULL, 0, '2025-01-30 03:07:48', '2025-01-30 03:08:54');

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
(45, 27, 'Food', 10, NULL, 40.00, 400.00, 0.00, 0.00, 'expense'),
(46, 27, 'Water', 10, NULL, 10.00, 100.00, 0.00, 0.00, 'expense'),
(47, 27, 'Vellum Board', 1, NULL, 3500.00, 3500.00, 0.00, 0.00, 'expense'),
(48, 27, 'Souns System', 1, NULL, 500.00, 500.00, 0.00, 0.00, 'expense'),
(49, 28, 'BYTE Lanyard', 100, NULL, 100.00, 14000.00, 40.00, 4000.00, 'revenue'),
(50, 29, 'Food for Officers', 10, NULL, 150.00, 1500.00, 0.00, 0.00, 'expense'),
(51, 29, 'Food for Participants', 100, NULL, 75.00, 7500.00, 0.00, 0.00, 'expense');

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
(45, 27, 'Food', 10, 0, 40.00, 0.00, 400.00, 0.00, 'basic-basic-receipt-template.pdf', '2025-01-31'),
(46, 27, 'Water', 10, 0, 10.00, 0.00, 100.00, 0.00, 'basic-basic-receipt-template.pdf', '2025-02-01'),
(47, 27, 'Vellum Board', 1, 0, 3500.00, 0.00, 3500.00, 0.00, 'basic-basic-receipt-template.pdf', '2025-01-31'),
(49, 28, 'BYTE Lanyard', 100, 0, 100.00, 40.00, 14000.00, 4000.00, 'main_savings-passbook-template.pdf', '2025-01-31'),
(50, 29, 'Food for Officers', 10, 0, 150.00, 0.00, 1500.00, 0.00, 'basic-basic-receipt-template.pdf', '2025-03-01'),
(51, 29, 'Food for Participants', 100, 0, 75.00, 0.00, 7500.00, 0.00, 'basic-basic-receipt-template.pdf', '2025-03-01');

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
(17, 1, 20, 'Activities', 'Techfest', 4000.00, 'LR 1.pdf', '2025-01-29 17:38:53', 0),
(18, 8, 22, 'Activities', 'IIEE Day', 9000.00, 'basic-basic-receipt-template.pdf', '2025-01-30 03:11:11', 0);

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
(17, 1, 4000.00, '2025-01-29 17:38:53', 9),
(18, 8, 9000.00, '2025-01-30 03:11:11', 15);

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
(35, 'Techfest', 'Activities', 1, 'Expense', '2025-02-08', 4500.00),
(36, 'Merchandise', '', 1, 'Income', '2025-02-01', 4000.00),
(37, 'IIEE Day', 'Activities', 8, 'Expense', '2025-02-03', 10000.00);

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
(10, 1, 21, '', 'Merchandise', 4000.00, 'main_savings-passbook-template.pdf', '2025-01-29 18:05:25', 0);

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
(21, 1, 25000.00, '2025-01-29 18:03:28', 10),
(22, 1, 4000.00, '2025-01-29 18:05:25', 10),
(23, 8, 100000.00, '2025-01-30 02:59:44', 15);

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
(125, 10, 1, 'Your budget request for \'CyberCon 2025\' has been approved.', 1, '2025-01-28 12:34:59'),
(127, 3, 0, 'A new budget approval request for \'TechnoFest\' has been submitted.', 0, '2025-01-28 15:21:48'),
(128, 9, 1, 'Your budget request for \'TechnoFest\' has been approved.', 1, '2025-01-28 15:22:28'),
(129, 10, 1, 'Your budget request for \'TechnoFest\' has been approved.', 1, '2025-01-28 15:22:28'),
(131, 9, 1, 'The total amount for the event \'TechnoFest\' has exceeded the allocated budget.', 1, '2025-01-28 15:37:13'),
(132, 10, 1, 'The total amount for the event \'TechnoFest\' has exceeded the allocated budget.', 1, '2025-01-28 15:37:13'),
(134, 9, 1, 'The total amount for the event \'TechnoFest\' has exceeded the allocated budget.', 1, '2025-01-28 15:50:31'),
(135, 10, 1, 'The total amount for the event \'TechnoFest\' has exceeded the allocated budget.', 1, '2025-01-28 15:50:31'),
(137, 9, 1, 'The total amount for the event \'TechnoFest\' has exceeded the allocated budget.', 1, '2025-01-28 15:50:31'),
(138, 10, 1, 'The total amount for the event \'TechnoFest\' has exceeded the allocated budget.', 1, '2025-01-28 15:50:31'),
(140, 9, 1, 'The total amount for the event \'TechnoFest\' has exceeded the allocated budget.', 1, '2025-01-28 15:51:39'),
(141, 10, 1, 'The total amount for the event \'TechnoFest\' has exceeded the allocated budget.', 1, '2025-01-28 15:51:39'),
(143, 9, 1, 'The total amount for the event \'TechnoFest\' has exceeded the allocated budget.', 1, '2025-01-28 15:51:39'),
(144, 10, 1, 'The total amount for the event \'TechnoFest\' has exceeded the allocated budget.', 1, '2025-01-28 15:51:39'),
(146, 3, 0, 'A new budget approval request for \'BYTE DAY\' has been submitted.', 0, '2025-01-29 13:03:06'),
(147, 9, 1, 'Your budget request for \'BYTE DAY\' has been approved.', 0, '2025-01-29 13:03:41'),
(148, 10, 1, 'Your budget request for \'BYTE DAY\' has been approved.', 1, '2025-01-29 13:03:41'),
(150, 9, 1, 'Your budget request for \'BYTE DAY\' has been approved.', 0, '2025-01-29 13:03:44'),
(151, 10, 1, 'Your budget request for \'BYTE DAY\' has been approved.', 1, '2025-01-29 13:03:44'),
(153, 3, 0, 'A new budget approval request for \'Techfest\' has been submitted.', 0, '2025-01-29 17:29:34'),
(154, 9, 1, 'Your budget request for \'Techfest\' has been approved.', 0, '2025-01-29 17:30:16'),
(155, 10, 1, 'Your budget request for \'Techfest\' has been approved.', 1, '2025-01-29 17:30:16'),
(157, 9, 1, 'The total amount for the event \'Techfest\' has exceeded the allocated budget.', 0, '2025-01-29 17:35:29'),
(158, 10, 1, 'The total amount for the event \'Techfest\' has exceeded the allocated budget.', 1, '2025-01-29 17:35:29'),
(160, 3, 0, 'A new budget approval request for \'Merchandise\' has been submitted.', 0, '2025-01-29 17:42:12'),
(161, 9, 1, 'Your budget request for \'Merchandise\' has been approved.', 0, '2025-01-29 17:42:35'),
(162, 10, 1, 'Your budget request for \'Merchandise\' has been approved.', 1, '2025-01-29 17:42:35'),
(164, 9, 1, 'The total amount for the event \'Merchandise\' has exceeded the allocated budget.', 0, '2025-01-29 18:05:02'),
(165, 10, 1, 'The total amount for the event \'Merchandise\' has exceeded the allocated budget.', 1, '2025-01-29 18:05:02'),
(167, 3, 0, 'A new budget approval request for \'IIEE Day\' has been submitted.', 0, '2025-01-30 03:06:51'),
(168, 15, 8, 'Your budget request for \'IIEE Day\' has been approved.', 0, '2025-01-30 03:07:00');

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
(1, 'Beacon of Youth Technology Enthusiasts', 'BYTE', 'logo_67820e1e2686b9.12993510.png', 500, 'Level I', '#39a291', 0, '2025-01-11 06:22:22', 50000.00, 50000.00, 54000.00, 4000.00, 46000.00, 0.00),
(2, 'Computer Scientists and Developers Society', 'CO:DE', 'logo_67849b259beea0.69837837.png', 300, 'Level I', '#247cdb', 0, '2025-01-13 04:48:37', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(3, 'Future Educators Organization', 'FEO', 'logo_6784d61999de24.21054574.png', 500, 'Level I', '#22b2e2', 0, '2025-01-13 09:00:09', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(4, 'Junior Marketing Association', 'JMA', 'logo_67851d7cf1e3e2.73446431.jpg', 700, 'Level I', '#001865', 0, '2025-01-13 14:04:44', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(5, 'Society of Industrial Technology Students', 'SITS', 'logo_67851de043f9f9.89451503.jpg', 1000, 'Level I', '#e0aa3d', 0, '2025-01-13 14:06:24', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(6, 'Sikat E-Sports Club', 'SITS', 'logo_67851e4104a265.31041356.jpg', 100, 'Level I', '#3679ec', 0, '2025-01-13 14:08:01', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(7, 'Association of Computer Engineering Students', 'ACES', 'logo_67851ee89fd7a0.37440779.jpg', 300, 'Level I', '#64b98f', 0, '2025-01-13 14:10:48', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(8, 'Institute of Integrated Electrical Engineers', 'IIEE', 'logo_6785205cdd1aa5.70397214.jpg', 400, 'Level I', '#fdb81d', 0, '2025-01-13 14:17:00', 91000.00, 100000.00, 100000.00, 9000.00, 100000.00, 0.00),
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
(10, 'Joshua', '$2y$10$rSt1JzKaU1lLchnwDqCA7e89aXsEw7PkX0VmAy2ppBgr7vboNQH3K', 'uploads/josh.jpeg', 'Joshua', 'Sanchez', 'joshua.sanchez@cvsu.edu.ph', 'officer', 1, 0, '2025-01-11 16:20:23', 'President', 0, 0, NULL),
(11, 'cervyramos', '$2y$10$RaSN1K8P67YgLny2bWjO/.VPlsDIKgost6p44iEgakxxF1/WyJAny', '', 'Cervy', 'Ramos', 'cervy.ramos@cvsu.edu.ph', 'officer', 3, 0, '2025-01-13 09:01:56', 'President', 0, 0, NULL),
(12, 'norwin_erni', '$2y$10$FrUvu6dBe/xlIGzdj..4leK48PHsfnSspNeAwbW2hfZbecjC1gqO6', '', 'Norwin', 'Erni', 'norwin.erni@cvsu.edu.ph', 'officer', 7, 0, '2025-01-14 05:58:30', 'President', 0, 0, NULL),
(13, 'Apocalyptic', '$2y$10$XQtf.aG6ab42ACI0R0NdxeDcNWoY1r7A4lkjl7ZR4.H/4WB3BCllK', '', 'Ouen', 'Villaranda', 'rc.ouen.villaranda@cvsu.edu.ph', 'officer', 7, 0, '2025-01-14 06:00:39', 'Treasurer', 0, 0, NULL),
(14, 'JerichoPao', '$2y$10$TV/QfUIXXnwEuprft/BH0OJIe8tR2PLxEncKbGnSgMIo0.dvEJH6m', '', 'Jericho', 'Ramos', 'jericho.ramos@cvsu.edu.ph', 'officer', 10, 1, '2025-01-20 06:18:08', 'President', 0, 0, NULL),
(15, 'lmer', '$2y$10$1CSXGv3C1Ibl01S/G8M.D.FzXswhXis6V4TUiUZpD9NI.vGpZp5NC', 'uploads/471601308_1387021592463494_1292666475845805289_n.jpg', 'Elmer', 'Hernandez', 'elmer.hernandez@cvsu.edu.ph', 'officer', 8, 0, '2025-01-21 17:46:26', 'Treasurer', 0, 0, NULL),
(16, 'Efren', '$2y$10$TBHhhA.5Y6pjKpBEyhvlnObhZZa/iGSXlJXM/mpFhFhp7pXv8vZHO', '', 'Efren', 'Roño', 'efren.rono@cvsu.edu.ph', 'officer', 8, 0, '2025-01-30 03:24:55', 'President', 0, 0, NULL);

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
-- Indexes for table `beginning_balance_summary`
--
ALTER TABLE `beginning_balance_summary`
  ADD PRIMARY KEY (`summary_id`),
  ADD KEY `organization_id` (`organization_id`);

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
  ADD KEY `organization_id` (`organization_id`),
  ADD KEY `created_by` (`created_by`);

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
  MODIFY `adviser_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `balance_history`
--
ALTER TABLE `balance_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `beginning_balance_history`
--
ALTER TABLE `beginning_balance_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `beginning_balance_summary`
--
ALTER TABLE `beginning_balance_summary`
  MODIFY `summary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `budget_allocation`
--
ALTER TABLE `budget_allocation`
  MODIFY `allocation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `budget_approvals`
--
ALTER TABLE `budget_approvals`
  MODIFY `approval_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cash_on_bank_history`
--
ALTER TABLE `cash_on_bank_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `events_summary`
--
ALTER TABLE `events_summary`
  MODIFY `summary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `event_items`
--
ALTER TABLE `event_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `event_summary_items`
--
ALTER TABLE `event_summary_items`
  MODIFY `summary_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `expense_history`
--
ALTER TABLE `expense_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `financial_plan`
--
ALTER TABLE `financial_plan`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `income_history`
--
ALTER TABLE `income_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `maintenance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
-- Constraints for table `beginning_balance_summary`
--
ALTER TABLE `beginning_balance_summary`
  ADD CONSTRAINT `beginning_balance_summary_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `budget_allocation`
--
ALTER TABLE `budget_allocation`
  ADD CONSTRAINT `budget_allocation_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `budget_approvals`
--
ALTER TABLE `budget_approvals`
  ADD CONSTRAINT `budget_approvals_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `budget_approvals_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

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
