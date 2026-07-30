-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2026 at 12:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loan_saas_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `current_balance` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `company_id`, `name`, `current_balance`) VALUES
(4, 1, 'Opening Account', 0.00),
(5, 1, 'Gcash', 583.00),
(6, 1, 'Maya', 0.00),
(7, 1, 'Gotyme', 3067.00),
(8, 1, 'Cash', 4150.00),
(9, 1, 'Coins', 0.00),
(10, 1, 'Maribank', 59273.00),
(11, 1, 'BPI', 80.00);

-- --------------------------------------------------------

--
-- Table structure for table `account_transactions`
--

CREATE TABLE `account_transactions` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `type` enum('payment','transfer_in','transfer_out') NOT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_transactions`
--

INSERT INTO `account_transactions` (`id`, `company_id`, `account_id`, `loan_id`, `amount`, `type`, `reference_id`, `notes`, `created_at`) VALUES
(55, 1, 4, 30, -40000.00, '', NULL, 'Loan #30 Approved', '2026-06-27 20:13:26'),
(56, 1, 4, 31, -26000.00, '', NULL, 'Loan #31 Approved', '2026-06-27 20:23:18'),
(57, 1, 4, 32, -26000.00, '', NULL, 'Loan #32 Approved', '2026-06-27 20:25:50'),
(58, 1, 4, 34, -38146.00, '', NULL, 'Loan #34 Approved', '2026-06-27 20:43:18'),
(59, 1, 4, 35, -12196.00, '', NULL, 'Loan #35 Approved', '2026-06-27 20:43:24'),
(60, 1, 4, 33, -3543.48, '', NULL, 'Loan #33 Approved', '2026-06-27 20:43:28'),
(61, 1, 4, 36, -7000.00, '', NULL, 'Loan #36 Approved', '2026-06-27 20:53:36'),
(62, 1, 4, 37, -800.00, '', NULL, 'Loan #37 Approved', '2026-06-27 20:54:39'),
(63, 1, 4, 38, -10000.00, '', NULL, 'Loan #38 Approved', '2026-06-27 20:57:22'),
(64, 1, 4, 34, 38146.00, '', NULL, 'Reversing loan #34 for edit', '2026-06-27 20:59:08'),
(65, 1, 4, 34, -39176.00, '', NULL, 'Loan #34 re-issued with updated amount', '2026-06-27 20:59:08'),
(66, 1, 4, 39, -3000.00, '', NULL, 'Loan #39 Approved', '2026-06-27 21:00:47'),
(67, 1, 8, NULL, 2850.00, '', NULL, 'Add', '2026-06-27 21:05:23'),
(68, 1, 8, NULL, 1000.00, '', NULL, 'Shelou ONhand', '2026-06-27 21:05:44'),
(69, 1, 8, NULL, 300.00, '', NULL, 'Sold Juice', '2026-06-27 21:06:01'),
(70, 1, 10, NULL, 16273.00, '', NULL, 'Adjustment', '2026-06-27 21:06:36'),
(71, 1, 7, NULL, 3067.00, '', NULL, 'Adjustment', '2026-06-27 21:07:15'),
(72, 1, 5, NULL, 583.00, '', NULL, '-', '2026-06-27 21:08:01'),
(73, 1, 10, 40, -3000.00, '', NULL, 'Loan #40 Approved', '2026-06-28 12:15:59'),
(75, 1, 4, 44, -100.00, '', NULL, 'Loan #44 Approved', '2026-06-28 18:35:20'),
(76, 1, 4, 33, 3543.48, '', NULL, 'Reversing loan #33 for edit', '2026-06-28 18:45:08'),
(77, 1, 4, 33, -8326.48, '', NULL, 'Loan #33 re-issued with updated amount', '2026-06-28 18:45:08'),
(78, 1, 4, NULL, 4383.00, '', NULL, 'Add', '2026-06-28 18:48:40'),
(79, 1, 4, 45, -1000.00, '', NULL, 'Loan #45 Approved', '2026-07-30 18:52:28');

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `table_name` varchar(50) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `company_id`, `user_id`, `action`, `table_name`, `record_id`, `description`, `ip_address`, `created_at`) VALUES
(1, 1, 1, 'UPDATE_LOAN', 'loans', 33, 'Updated loan #33', '::1', '2026-06-28 18:13:05'),
(2, 1, 1, 'UPDATE_LOAN', 'loans', 33, 'Updated loan #33', '::1', '2026-06-28 18:14:06'),
(3, 1, 1, 'UPDATE_LOAN', 'loans', 33, 'Updated loan #33', '::1', '2026-06-28 18:14:19'),
(4, 1, 1, 'CREATE_LOAN', 'loans', 44, 'Created new loan #44', '::1', '2026-06-28 18:16:59'),
(5, 1, 1, 'APPROVE_LOAN', 'loans', 44, 'Approved loan #44', '::1', '2026-06-28 18:35:20'),
(6, 1, 1, 'UPDATE_LOAN', 'loans', 44, 'Updated loan #44', '::1', '2026-06-28 18:38:16'),
(7, 1, 1, 'UPDATE_LOAN', 'loans', 33, 'Updated loan #33', '::1', '2026-06-28 18:39:01'),
(8, 1, 1, 'UPDATE_LOAN', 'loans', 44, 'Updated loan #44', '::1', '2026-06-28 18:39:14'),
(9, 1, 1, 'UPDATE_LOAN', 'loans', 33, 'Updated loan #33', '::1', '2026-06-28 18:45:08'),
(10, 1, 1, 'UPDATE_LOAN', 'loans', 33, 'Updated loan #33', '::1', '2026-06-28 18:46:39'),
(11, 1, 1, 'UPDATE_LOAN', 'loans', 44, 'Updated loan #44', '::1', '2026-06-28 18:46:54'),
(12, 1, 1, 'UPDATE_LOAN', 'loans', 38, 'Updated loan #38', '::1', '2026-06-28 18:47:06'),
(13, 1, 1, 'ADJUST_BALANCE', 'accounts', 4, 'Adjusted account balance: add ₱4,383.00 | Note: Add', '::1', '2026-06-28 18:48:40'),
(14, 1, 1, 'UPDATE_LOAN', 'loans', 33, 'Updated loan #33', '::1', '2026-06-28 18:55:08'),
(15, 1, 1, 'UPDATE_LOAN', 'loans', 33, 'Updated loan #33', '::1', '2026-06-28 19:00:42'),
(16, 1, 1, 'UPDATE_LOAN', 'loans', 38, 'Updated loan #38', '::1', '2026-06-28 19:00:50'),
(17, 1, 1, 'APPLY_PENALTY', 'penalties', 44, 'Applied penalty of ₱10 to loan #44. Reason: Late Payment', '::1', '2026-06-28 20:22:11'),
(18, 1, 1, 'CREATE_LOAN', 'loans', 45, 'Created new loan #45', '::1', '2026-07-12 17:23:39'),
(19, 1, 1, 'UPDATE_BUSINESS_NAME', 'companies', 1, 'Updated business name to: Marldohn Financial', '::1', '2026-07-12 20:40:58'),
(20, 1, 1, 'CREATE_LOAN', 'loans', 46, 'Created new loan #46', '::1', '2026-07-30 18:52:23'),
(21, 1, 1, 'APPROVE_LOAN', 'loans', 45, 'Approved loan #45', '::1', '2026-07-30 18:52:28'),
(22, 1, 1, 'UPDATE_LOAN', 'loans', 45, 'Updated loan #45', '::1', '2026-07-30 18:53:12'),
(23, 1, 1, 'UPDATE_LOAN', 'loans', 45, 'Updated loan #45', '::1', '2026-07-30 18:58:05'),
(24, 1, 1, 'UPDATE_LOAN', 'loans', 45, 'Updated loan #45', '::1', '2026-07-30 19:00:47'),
(25, 1, 1, 'UPDATE_LOAN', 'loans', 45, 'Updated loan #45', '::1', '2026-07-30 19:02:41'),
(26, 1, 1, 'UPDATE_LOAN', 'loans', 45, 'Updated loan #45', '::1', '2026-07-30 19:02:46'),
(27, 1, 1, 'UPDATE_BORROWER', 'borrowers', 8, 'Updated profile for: Myles Batayola', '::1', '2026-07-30 19:48:37');

-- --------------------------------------------------------

--
-- Table structure for table `borrowers`
--

CREATE TABLE `borrowers` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text NOT NULL,
  `valid_id` varchar(150) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `occupation` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrowers`
--

INSERT INTO `borrowers` (`id`, `company_id`, `first_name`, `middle_name`, `last_name`, `gender`, `birthdate`, `phone`, `email`, `address`, `valid_id`, `status`, `created_at`, `occupation`) VALUES
(6, 1, 'Janice', '', 'Olan-Olan', 'Female', '0001-01-01', '-', '', 'Leyte, Philippines', '', 1, '2026-06-27 19:55:44', NULL),
(7, 1, 'Anne', '', 'Hilded', 'Female', '0000-00-00', '-', '', 'Sikatuna Street Cebu City, Cebu', '', 1, '2026-06-27 20:03:41', NULL),
(8, 1, 'Myles', '', 'Batayola', '', '0000-00-00', '-', 'marldohncrubinos11@gmail.com', 'Sikatuna Street Cebu City, Cebu', '', 1, '2026-06-27 20:04:14', NULL),
(9, 1, 'Marldohn', '', 'Rubinos', 'Male', '0000-00-00', '09061941138', 'marldohncrubinos11@gmail.com', 'Jakosalem Street Cebu City, Cebu', 'G06-24-008078', 1, '2026-06-27 20:05:12', NULL),
(10, 1, 'Kitkit', '', 'Olan-olan', 'Female', '0000-00-00', '-', '', 'Leyte Philippines', '', 1, '2026-06-27 20:28:39', NULL),
(11, 1, 'Noli', '', 'Absin', 'Female', '0000-00-00', '-', '', 'Mevisa Cebu City, Cebu', '', 1, '2026-06-27 20:29:04', NULL),
(12, 1, 'March Shelou', 'Goc-ong', 'Ardillo', 'Female', '0000-00-00', '09059626063', 'ardillomarch@gmail.com', 'Balamban, Cebu', '', 1, '2026-06-27 20:29:41', NULL),
(13, 1, 'Jerry ', '', 'Lauronal', 'Male', '0000-00-00', '-', '', 'Sikatuna Street Cebu City, Cebu', '', 1, '2026-06-27 20:52:14', NULL),
(14, 1, 'Marilyn ', '', 'Rubinos', 'Female', '0000-00-00', '09754171178', '', 'Jakosalem Street Cebu City, Cebu', '', 1, '2026-06-27 20:54:15', NULL),
(15, 1, 'Cheyanne', '', 'Jumilla', 'Male', '0000-00-00', '-', '', 'Bohol Philippines', '', 1, '2026-06-27 20:56:44', NULL),
(16, 1, 'Test', '', 'User0', '', '0000-00-00', '1818410841', '', '0', '', 1, '2026-06-28 13:28:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `company_id`, `type`, `name`, `description`, `created_at`) VALUES
(9, 1, 'loan', 'Emergency', 'Emergency', '2026-06-27 20:07:03'),
(10, 1, 'expense', 'Food', 'Food', '2026-06-28 13:13:22');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `plan_tier` varchar(20) DEFAULT 'free',
  `subscription_status` varchar(20) DEFAULT 'active',
  `expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `plan_tier`, `subscription_status`, `expires_at`, `created_at`) VALUES
(1, 'Marldohn Financial', 'free', 'active', NULL, '2026-06-27 19:39:21'),
(5, 'AZPIRED LENDING GROUP', 'free', 'active', NULL, '2026-06-28 21:40:45');

-- --------------------------------------------------------

--
-- Table structure for table `company_funds`
--

CREATE TABLE `company_funds` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `balance` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `category` varchar(100) DEFAULT 'General',
  `category_id` int(11) DEFAULT NULL,
  `expense_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `borrower_id` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `interest_rate` decimal(5,2) NOT NULL,
  `total_payable` decimal(12,2) NOT NULL,
  `status` varchar(30) DEFAULT 'pending',
  `released_date` date DEFAULT NULL,
  `due_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `term_months` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `term_type` varchar(20) DEFAULT 'month',
  `fee` decimal(15,2) DEFAULT 0.00,
  `category_id` int(11) DEFAULT NULL,
  `loan_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `company_id`, `account_id`, `borrower_id`, `amount`, `interest_rate`, `total_payable`, `status`, `released_date`, `due_date`, `created_at`, `term_months`, `notes`, `term_type`, `fee`, `category_id`, `loan_type`) VALUES
(30, 1, 4, 6, 40000.00, 15.00, 46000.00, 'Approved', '2026-05-15', '2026-05-30', '2026-06-27 20:13:09', 15, '', 'day', 0.00, 9, 'fixed'),
(32, 1, 4, 7, 26000.00, 0.00, 26000.00, 'Approved', '2026-05-15', '2026-10-15', '2026-06-27 20:25:45', 5, '', 'month', 0.00, 9, 'fixed'),
(33, 1, 4, 8, 8326.48, 15.00, 9575.45, 'Approved', '2026-06-27', '2026-06-30', '2026-06-27 20:41:30', 1, '', 'semi_monthly', 0.00, 9, ''),
(34, 1, 4, 9, 39176.00, 0.00, 39176.00, 'Approved', '2026-06-27', '2859-09-27', '2026-06-27 20:42:16', 9999, '', 'month', 0.00, 9, ''),
(35, 1, 4, 12, 12196.00, 0.00, 12196.00, 'Approved', '2026-06-27', '2859-09-27', '2026-06-27 20:43:12', 9999, '', 'month', 0.00, 9, 'fixed'),
(36, 1, 4, 13, 7000.00, 15.00, 8050.00, 'Approved', '2026-06-15', '2026-06-30', '2026-06-27 20:53:31', 15, '', 'day', 0.00, 9, 'fixed'),
(37, 1, 4, 14, 800.00, 0.00, 800.00, 'Approved', '2026-06-27', '2859-09-27', '2026-06-27 20:54:34', 9999, '', 'month', 0.00, 9, ''),
(38, 1, 4, 15, 10000.00, 11.00, 11100.00, 'Approved', '2026-06-15', '2026-06-30', '2026-06-27 20:57:17', 15, '', 'one_time', 0.00, 9, ''),
(39, 1, 4, 10, 3000.00, 15.00, 3450.00, 'Approved', '2026-06-15', '2026-06-30', '2026-06-27 21:00:43', 15, '', 'day', 0.00, 9, 'fixed'),
(40, 1, 10, 13, 3000.00, 15.00, 3450.00, 'Approved', '2026-06-28', '2026-07-13', '2026-06-28 12:15:54', 15, '', 'day', 0.00, 9, 'fixed'),
(44, 1, 4, 16, 100.00, 10.00, 120.00, 'Approved', '2026-06-28', '2026-06-29', '2026-06-28 18:16:59', 2, '', 'semi_monthly', 0.00, 9, ''),
(45, 1, 4, 16, 1000.00, 10.00, 1100.00, 'Approved', '2026-07-31', '2026-08-10', '2026-07-12 17:23:39', 10, 'NA', 'one_time', 10.00, 9, ''),
(46, 1, 4, 7, 1000.00, 10.00, 1100.00, 'Pending', '2026-07-30', '2026-08-09', '2026-07-30 18:52:23', 10, '', 'one_time', 0.00, 9, 'standard');

-- --------------------------------------------------------

--
-- Table structure for table `loan_collaterals`
--

CREATE TABLE `loan_collaterals` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `estimated_value` decimal(15,2) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_collaterals`
--

INSERT INTO `loan_collaterals` (`id`, `company_id`, `loan_id`, `item_name`, `description`, `estimated_value`, `file_path`, `created_at`) VALUES
(4, 1, 45, 'Gold Ring', NULL, 10000.00, NULL, '2026-07-12 17:23:39');

-- --------------------------------------------------------

--
-- Table structure for table `loan_installments`
--

CREATE TABLE `loan_installments` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `installment_no` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `due_date` date NOT NULL,
  `is_paid` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `reference_number` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `principal_amount` decimal(15,2) DEFAULT 0.00,
  `interest_amount` decimal(15,2) DEFAULT 0.00,
  `fees_amount` decimal(15,2) DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `account_id`, `company_id`, `loan_id`, `amount`, `payment_date`, `payment_method`, `reference_number`, `created_at`, `principal_amount`, `interest_amount`, `fees_amount`, `notes`, `category_id`) VALUES
(5, 10, 1, 30, 46000.00, '2026-06-28', NULL, NULL, '2026-06-27 20:14:57', 0.00, 0.00, 0.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `penalties`
--

CREATE TABLE `penalties` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `date_applied` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penalties`
--

INSERT INTO `penalties` (`id`, `company_id`, `loan_id`, `amount`, `reason`, `date_applied`) VALUES
(3, 1, 44, 10.00, 'Late Payment', '2026-06-29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(30) DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `company_id`, `username`, `password`, `role`, `created_at`, `status`) VALUES
(1, 1, 'mrubinos@azpired.net', '$2y$10$/DhJJCjKBhl./meP.7NkiebnAojnXPOppxye5HfYdAYRJqRZJpAPy', 'admin', '2026-05-27 13:22:38', 1),
(2, 1, 'superadmin2', '$2y$10$T8ZJ1pC4O6.Ym9G2Fv4Wk.x9eHwK2aT0.iL0P4K/yXzQ4T2oN5.yS', 'superadmin', '2026-05-30 06:49:23', 1),
(11, 5, 'mardonio@azpired.net', '$2y$10$jl1HqHLWKe.KJAbolV.NwuEmywcN3TMuNQlLI4XXwhoshnKvf3Wba', 'admin', '2026-06-28 21:40:45', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_accounts_company` (`company_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `account_transactions`
--
ALTER TABLE `account_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_trans_account` (`account_id`);

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_company` (`company_id`),
  ADD KEY `fk_log_user` (`user_id`);

--
-- Indexes for table `borrowers`
--
ALTER TABLE `borrowers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_funds`
--
ALTER TABLE `company_funds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_method` (`company_id`,`payment_method`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `borrower_id` (`borrower_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `loan_collaterals`
--
ALTER TABLE `loan_collaterals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_id` (`loan_id`);

--
-- Indexes for table `loan_installments`
--
ALTER TABLE `loan_installments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_id` (`loan_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `penalties`
--
ALTER TABLE `penalties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_id` (`loan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `account_transactions`
--
ALTER TABLE `account_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `borrowers`
--
ALTER TABLE `borrowers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `company_funds`
--
ALTER TABLE `company_funds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `loan_collaterals`
--
ALTER TABLE `loan_collaterals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `loan_installments`
--
ALTER TABLE `loan_installments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penalties`
--
ALTER TABLE `penalties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `fk_accounts_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `account_transactions`
--
ALTER TABLE `account_transactions`
  ADD CONSTRAINT `fk_trans_account` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `fk_log_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `borrowers`
--
ALTER TABLE `borrowers`
  ADD CONSTRAINT `borrowers_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_funds`
--
ALTER TABLE `company_funds`
  ADD CONSTRAINT `funds_company_fk` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`borrower_id`) REFERENCES `borrowers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loans_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `loan_collaterals`
--
ALTER TABLE `loan_collaterals`
  ADD CONSTRAINT `loan_collaterals_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `penalties`
--
ALTER TABLE `penalties`
  ADD CONSTRAINT `penalties_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
