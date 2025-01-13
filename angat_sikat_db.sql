-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2025 at 03:28 PM
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
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advisers`
--

INSERT INTO `advisers` (`adviser_id`, `first_name`, `last_name`, `picture`, `organization_id`, `position`) VALUES
(1, 'Renato', 'Bautista', 'renato.jpg', 1, 'Senior Adviser'),
(2, 'Janessa', 'Cruz', 'janessa.jpg', 1, 'Junior Adviser');

-- --------------------------------------------------------

--
-- Table structure for table `balance_history`
--

CREATE TABLE `balance_history` (
  `history_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `balance` decimal(15,2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `balance_history`
--

INSERT INTO `balance_history` (`history_id`, `organization_id`, `balance`, `updated_at`) VALUES
(5, 3, 24600.00, '2025-01-13 09:16:45'),
(6, 1, 104000.00, '2025-01-13 11:25:17'),
(7, 1, 79000.00, '2025-01-13 11:25:49');

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
(11, 1, 'Activities', 75000.00, 25000.00, '2025-01-13 05:49:36', '2025-01-13 11:25:49'),
(12, 1, 'Purchases', 10000.00, 0.00, '2025-01-13 05:49:57', '2025-01-13 05:49:57'),
(13, 1, 'Maintenance and Other Expenses', 15000.00, 0.00, '2025-01-13 05:50:09', '2025-01-13 05:50:09'),
(14, 3, 'Activities', 10000.00, 400.00, '2025-01-13 09:05:55', '2025-01-13 09:16:45'),
(15, 3, 'Purchases', 3000.00, 0.00, '2025-01-13 09:06:12', '2025-01-13 09:06:12'),
(16, 3, 'Maintenance and Other Expenses', 3000.00, 0.00, '2025-01-13 09:06:47', '2025-01-13 09:06:47');

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
  `archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget_approvals`
--

INSERT INTO `budget_approvals` (`approval_id`, `title`, `category`, `attachment`, `status`, `organization_id`, `created_at`, `archived`) VALUES
(5, 'Oplan Alisin ang mga Bading', 'Activities', 'Budget_Request_CyberCon 2025_1736416068.pdf', 'Approved', 3, '2025-01-13 09:13:10', 0),
(6, 'CyberCon', 'Activities', 'example_014.pdf', 'Approved', 1, '2025-01-13 11:21:38', 0);

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
(1, 1, 'TechFusion', 'DCS', '2025-01-12', '2025-01-12', 'Expense', 'Approved', 1, 1000.00, 0.00, 1, NULL, '2025-01-11 06:36:04', 0),
(2, 2, 'CyberCon', 'Court I', '2025-01-20', '2025-01-24', 'Expense', 'Approved', 0, 5890.00, 0.00, 1, NULL, '2025-01-11 06:36:48', 0),
(3, 4, 'Merchandise Sale', 'DCS', '2025-01-18', '2025-01-25', 'Income', 'Approved', 1, 20000.00, 4000.00, 1, NULL, '2025-01-11 06:53:06', 0),
(4, 3, 'AI Seminar', 'DCS', '2025-02-03', '2025-02-06', 'Expense', 'Approved', 0, 20000.00, 0.00, 1, NULL, '2025-01-12 12:35:05', 0),
(5, 7, 'Film Festival', 'Court I', '2025-01-16', '2025-01-17', 'Income', 'Approved', 1, 0.00, 0.00, 1, NULL, '2025-01-12 13:09:44', 0),
(6, 8, 'Oplan Alisin ang mga Bading', 'Diyan lang', '2025-01-14', '2025-01-15', 'Expense', 'Approved', 1, 400.00, 0.00, 3, NULL, '2025-01-13 09:09:00', 0);

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
(1, 1, 'TechFusion', 'DCS', '2025-01-12', '2025-01-12', 'Expense', 1, 750.00, 0.00, 'Approved', NULL, 0, '2025-01-11 06:43:17', '2025-01-11 06:48:22'),
(2, 3, 'Merchandise Sale', 'DCS', '2025-01-18', '2025-01-25', 'Income', 1, 20000.00, 4000.00, 'Approved', NULL, 0, '2025-01-11 06:59:17', '2025-01-11 06:59:36'),
(3, 4, 'AI Seminar', 'DCS', '2025-02-03', '2025-02-06', 'Expense', 1, 25000.00, 0.00, 'Approved', NULL, 0, '2025-01-12 12:46:05', '2025-01-12 12:47:02'),
(4, 5, 'Film Festival', 'Court I', '2025-01-16', '2025-01-17', 'Income', 1, 10000.00, 2000.00, 'Approved', NULL, 0, '2025-01-12 13:16:30', '2025-01-12 13:17:17'),
(5, 6, 'Oplan Alisin ang mga Bading', 'Diyan lang', '2025-01-14', '2025-01-15', 'Expense', 3, 400.00, 0.00, 'Approved', NULL, 0, '2025-01-13 09:15:05', '2025-01-13 09:15:29');

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
(1, 1, 'Food', 5, '1', 200.00, 1000.00, 0.00, 0.00, 'expense'),
(2, 3, 'BYTE Lanyard', 200, '1', 80.00, 20000.00, 20.00, 4000.00, 'expense'),
(3, 2, 'Vellum Board', 10, '1', 50.00, 500.00, 0.00, 0.00, 'expense'),
(4, 2, 'Ink', 4, '1', 285.00, 1140.00, 0.00, 0.00, 'expense'),
(5, 2, 'Food for Judges', 5, '1', 250.00, 1250.00, 0.00, 0.00, 'expense'),
(6, 2, 'Food for Officers', 10, '1', 150.00, 1500.00, 0.00, 0.00, 'expense'),
(7, 2, 'Champion', 1, '1', 1500.00, 1500.00, 0.00, 0.00, 'expense'),
(8, 2, 'Registration Fee', 500, '1', 90.00, 45000.00, 90.00, 45000.00, 'revenue'),
(9, 4, 'Food for Participants', 100, '1', 200.00, 20000.00, 0.00, 0.00, 'revenue'),
(10, 6, 'jsqjdjiwq', 2, '1', 200.00, 400.00, 0.00, 0.00, 'revenue');

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
(1, 1, 'Food', 5, 1, 150.00, 0.00, 750.00, 0.00, 'example_014.pdf', '2025-01-18'),
(2, 3, 'BYTE Lanyard', 200, 1, 80.00, 20.00, 20000.00, 4000.00, 'example_014.pdf', '2025-01-04'),
(3, 4, 'Food for Participants', 100, 1, 250.00, 0.00, 25000.00, 0.00, 'Budget_Request_General Assembly1736368948.pdf', '2025-01-13'),
(4, 5, 'Ticket', 100, 1, 80.00, 20.00, 10000.00, 2000.00, 'Budget_Request_General Assembly1736368948.pdf', '2025-01-13'),
(5, 6, 'jsqjdjiwq', 2, 1, 200.00, 0.00, 400.00, 0.00, 'example_014.pdf', '2025-01-14');

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
(3, 3, 5, 'Activities', 'Oplan Alisin ang mga Bading', 400.00, 'Budget_Request_CyberCon 2025_1736416068.pdf', '2025-01-13 09:16:45', 0),
(4, 1, 3, 'Activities', 'AI Seminar', 25000.00, 'example_014.pdf', '2025-01-13 11:25:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `expense_history`
--

CREATE TABLE `expense_history` (
  `history_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `expense` decimal(10,2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense_history`
--

INSERT INTO `expense_history` (`history_id`, `organization_id`, `expense`, `updated_at`) VALUES
(1, 1, 750.00, '2025-01-11 06:49:44'),
(2, 1, 25000.00, '2025-01-12 12:55:36'),
(3, 3, 400.00, '2025-01-13 09:16:45'),
(4, 1, 25000.00, '2025-01-13 11:25:49');

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
(1, 'TechFusion', 'Activities', 1, 'Expense', '2025-01-12', 1000.00),
(2, 'CyberCon', 'Activities', 1, 'Expense', '2025-01-20', 45000.00),
(3, 'AI Seminar', 'Activities', 1, 'Expense', '2025-02-03', 20000.00),
(4, 'Merchandise Sale', '', 1, 'Income', '2025-01-18', 100000.00),
(5, 'Printing', 'Purchases', 1, 'Expense', '0000-00-00', 5000.00),
(6, 'Transportation', 'Purchases', 1, 'Expense', '0000-00-00', 10000.00),
(7, 'Film Festival', '', 1, 'Income', '2025-01-16', 30000.00),
(8, 'Oplan Alisin ang mga Bading', 'Activities', 3, 'Expense', '2025-01-14', 10000.00);

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
(3, 1, 2, '', 'Merchandise Sale', 4000.00, 'example_014.pdf', '2025-01-13 11:25:17', 0);

-- --------------------------------------------------------

--
-- Table structure for table `income_history`
--

CREATE TABLE `income_history` (
  `history_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `income` decimal(10,2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income_history`
--

INSERT INTO `income_history` (`history_id`, `organization_id`, `income`, `updated_at`) VALUES
(3, 1, 4000.00, '2025-01-13 11:25:17');

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
(1, 3, 0, 'A new budget approval request for \'TechFusion\' has been submitted.', 0, '2025-01-11 14:40:10'),
(2, 3, 1, 'Your budget request for \'TechFusion\' has been approved.', 0, '2025-01-11 14:40:41'),
(3, 9, 1, 'Your budget request for \'TechFusion\' has been approved.', 0, '2025-01-11 14:40:41'),
(5, 3, 1, 'The total amount for the event \'TechFusion\' has exceeded the allocated budget.', 0, '2025-01-11 14:48:22'),
(6, 9, 1, 'The total amount for the event \'TechFusion\' has exceeded the allocated budget.', 0, '2025-01-11 14:48:22'),
(8, 3, 0, 'A new budget approval request for \'Merchandise Sale\' has been submitted.', 0, '2025-01-11 14:53:44'),
(9, 3, 1, 'Your budget request for \'Merchandise Sale\' has been approved.', 0, '2025-01-11 14:57:18'),
(10, 9, 1, 'Your budget request for \'Merchandise Sale\' has been approved.', 0, '2025-01-11 14:57:18'),
(11, 3, 0, 'A new budget approval request for \'AI Seminar\' has been submitted.', 0, '2025-01-12 20:45:13'),
(12, 3, 1, 'Your budget request for \'AI Seminar\' has been approved.', 0, '2025-01-12 20:45:31'),
(13, 9, 1, 'Your budget request for \'AI Seminar\' has been approved.', 0, '2025-01-12 20:45:31'),
(14, 10, 1, 'Your budget request for \'AI Seminar\' has been approved.', 0, '2025-01-12 20:45:31'),
(15, 3, 1, 'The total amount for the event \'AI Seminar\' has exceeded the allocated budget.', 0, '2025-01-12 20:47:02'),
(16, 9, 1, 'The total amount for the event \'AI Seminar\' has exceeded the allocated budget.', 0, '2025-01-12 20:47:02'),
(17, 10, 1, 'The total amount for the event \'AI Seminar\' has exceeded the allocated budget.', 0, '2025-01-12 20:47:02'),
(18, 3, 0, 'A new budget approval request for \'Film Festival\' has been submitted.', 0, '2025-01-12 21:12:14'),
(19, 3, 1, 'Your budget request for \'Film Festival\' has been approved.', 0, '2025-01-12 21:15:22'),
(20, 9, 1, 'Your budget request for \'Film Festival\' has been approved.', 0, '2025-01-12 21:15:22'),
(21, 10, 1, 'Your budget request for \'Film Festival\' has been approved.', 0, '2025-01-12 21:15:22'),
(22, 3, 0, 'A new budget approval request for \'Oplan Alisin ang mga Bading\' has been submitted.', 0, '2025-01-13 17:13:10'),
(23, 11, 3, 'Your budget request for \'Oplan Alisin ang mga Bading\' has been approved.', 0, '2025-01-13 17:14:24'),
(24, 3, 0, 'A new budget approval request for \'CyberCon\' has been submitted.', 0, '2025-01-13 19:21:38'),
(25, 3, 1, 'Your budget request for \'CyberCon\' has been approved.', 0, '2025-01-13 19:22:07'),
(26, 9, 1, 'Your budget request for \'CyberCon\' has been approved.', 0, '2025-01-13 19:22:07'),
(27, 10, 1, 'Your budget request for \'CyberCon\' has been approved.', 0, '2025-01-13 19:22:07');

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
(1, 'Beacon of Youth Technology Enthusiasts', 'BYTE', 'logo_67820e1e2686b9.12993510.png', 500, 'Level I', '#2d473a', 0, '2025-01-11 06:22:22', 79000.00, 100000.00, 104000.00, 25000.00, 0.00, 0.00),
(2, 'Computer Scientists and Developers Society', 'CO:DE', 'logo_67849b259beea0.69837837.png', 300, 'Level I', '#247cdb', 0, '2025-01-13 04:48:37', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(3, 'Future Educators Organization', 'FEO', 'logo_6784d61999de24.21054574.png', 500, 'Level I', '#22b2e2', 0, '2025-01-13 09:00:09', 24600.00, 25000.00, 25000.00, 400.00, 15000.00, 0.00),
(4, 'Junior Marketing Association', 'JMA', 'logo_67851d7cf1e3e2.73446431.jpg', 700, 'Level I', '#001865', 0, '2025-01-13 14:04:44', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(5, 'Society of Industrial Technology Students', 'SITS', 'logo_67851de043f9f9.89451503.jpg', 1000, 'Level I', '#e0aa3d', 0, '2025-01-13 14:06:24', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(6, 'Sikat E-Sports Club', 'SITS', 'logo_67851e4104a265.31041356.jpg', 100, 'Level I', '#3679ec', 0, '2025-01-13 14:08:01', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(7, 'Association of Computer Engineering Students', 'ACES', 'logo_67851ee89fd7a0.37440779.jpg', 300, 'Level I', '#64b98f', 0, '2025-01-13 14:10:48', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(8, 'Institute of Integrated Electrical Engineers', 'IIEE', 'logo_6785205cdd1aa5.70397214.jpg', 400, 'Level I', '#fdb81d', 0, '2025-01-13 14:17:00', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(9, 'Artrads Dance Crew', 'Artrads', 'logo_678520faca4db4.43978443.png', 30, 'Level I', '#e9bf0f', 0, '2025-01-13 14:19:38', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(10, 'CCAT Chorale', 'Chorale', 'logo_678521a13bc1d0.72249552.jpg', 35, 'Level I', '#039ce2', 0, '2025-01-13 14:22:25', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00);

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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
  `position` enum('President','Treasurer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `profile_picture`, `first_name`, `last_name`, `email`, `role`, `organization_id`, `archived`, `created_at`, `position`) VALUES
(3, 'admin', '$2y$10$ZhjHxFaq77LMDZK1WSfss.w6QvlSROnTpjIE9Gov/wb7soNaNY/f6', 'uploads/guill.jpg', 'Guilier', 'Parulan', 'admin@mail.com', 'admin', 1, 0, '2024-12-23 16:21:49', 'President'),
(9, 'Maphil', '$2y$10$rgoeHdju14TjzSh9meKP1exVzAiisOuKU6rFvSVtRtc/j0qtcp3N6', 'uploads/maphil.jpg', 'Maphil Grace', 'Alquizola', 'maphil.grace.alquizola@cvsu.edu.ph', 'officer', 1, 0, '2025-01-11 06:23:48', 'Treasurer'),
(10, 'Joshua', '$2y$10$rSt1JzKaU1lLchnwDqCA7e89aXsEw7PkX0VmAy2ppBgr7vboNQH3K', '', 'Joshua', 'Sanchez', 'joshua.sanchez@cvsu.edu.ph', 'officer', 1, 0, '2025-01-11 16:20:23', 'President'),
(11, 'cervyramos', '$2y$10$RaSN1K8P67YgLny2bWjO/.VPlsDIKgost6p44iEgakxxF1/WyJAny', '', 'Cervy', 'Ramos', 'cervy.ramos@cvsu.edu.ph', 'officer', 3, 0, '2025-01-13 09:01:56', 'President');

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
  ADD KEY `organization_id` (`organization_id`);

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
  MODIFY `adviser_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `balance_history`
--
ALTER TABLE `balance_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `budget_allocation`
--
ALTER TABLE `budget_allocation`
  MODIFY `allocation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `budget_approvals`
--
ALTER TABLE `budget_approvals`
  MODIFY `approval_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `events_summary`
--
ALTER TABLE `events_summary`
  MODIFY `summary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event_items`
--
ALTER TABLE `event_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_summary_items`
--
ALTER TABLE `event_summary_items`
  MODIFY `summary_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expense_history`
--
ALTER TABLE `expense_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `financial_plan`
--
ALTER TABLE `financial_plan`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `income_history`
--
ALTER TABLE `income_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `maintenance_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchases_summary`
--
ALTER TABLE `purchases_summary`
  MODIFY `summary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchase_summary_items`
--
ALTER TABLE `purchase_summary_items`
  MODIFY `summary_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`);

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
