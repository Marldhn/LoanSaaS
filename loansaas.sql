-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2026 at 12:30 AM
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
  `current_balance` decimal(15,2) DEFAULT 0.00,
  `icon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `company_id`, `name`, `current_balance`, `icon`) VALUES
(1, 1, 'Gcash', 3920.00, 'account_1785951150_9771.png'),
(2, 1, 'Maribank - DONSS', 13621.00, 'account_1785950259_3333.webp'),
(3, 1, 'BPI', 4000.00, NULL),
(4, 1, 'Gotyme', 0.00, NULL),
(5, 1, 'Maribank - SHE', 11517.00, 'account_1785951226_4901.webp'),
(6, 1, 'Initial Balance', 0.00, NULL);

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
(1, 1, 6, 1, -40049.00, '', NULL, 'Loan #1 Approved', '2026-08-05 17:45:15'),
(2, 1, 6, 2, -10000.00, '', NULL, 'Loan #2 Approved', '2026-08-05 18:20:35'),
(3, 1, 6, 3, -8090.00, '', NULL, 'Loan #3 Approved', '2026-08-05 18:30:30'),
(4, 1, 6, 4, -50000.00, '', NULL, 'Loan #4 Approved', '2026-08-05 18:33:04'),
(5, 1, 6, 5, -14500.00, '', NULL, 'Loan #5 Approved', '2026-08-05 19:07:14'),
(6, 1, 6, 6, -5000.00, '', NULL, 'Loan #6 Approved', '2026-08-05 19:09:54'),
(7, 1, 2, 7, -2000.00, '', NULL, 'Loan #7 Approved', '2026-08-05 19:10:00'),
(8, 1, 6, 8, -800.00, '', NULL, 'Loan #8 Approved', '2026-08-05 19:13:44'),
(9, 1, 6, 9, -13036.00, '', NULL, 'Loan #9 Approved', '2026-08-05 19:13:47'),
(10, 1, 6, 10, -10000.00, '', NULL, 'Loan #10 Approved', '2026-08-05 19:14:59'),
(11, 1, 6, 11, -2750.00, '', NULL, 'Loan #11 Approved', '2026-08-05 19:19:06'),
(12, 1, 6, 12, -3000.00, '', NULL, 'Loan #12 Approved', '2026-08-05 19:19:31'),
(13, 1, 6, 1, 40049.00, '', NULL, 'Reversing loan #1 for edit', '2026-08-05 19:28:14'),
(14, 1, 6, 1, -41877.00, '', NULL, 'Loan #1 re-issued with updated amount', '2026-08-05 19:28:14'),
(15, 1, 6, 2, 10000.00, '', NULL, 'Reversing loan #2 for edit', '2026-08-05 19:29:52'),
(16, 1, 6, 2, -11724.00, '', NULL, 'Loan #2 re-issued with updated amount', '2026-08-05 19:29:52'),
(17, 1, 4, NULL, -8344.00, 'transfer_out', NULL, 'Transfer to Maribank - DONSS', '2026-08-06 15:51:38'),
(18, 1, 2, NULL, 8344.00, 'transfer_in', NULL, 'Transfer from Gotyme', '2026-08-06 15:51:38'),
(19, 1, 2, NULL, -4660.00, 'transfer_out', NULL, 'Transfer to BPI', '2026-08-06 15:53:51'),
(20, 1, 3, NULL, 4660.00, 'transfer_in', NULL, 'Transfer from Maribank - DONSS', '2026-08-06 15:53:51'),
(21, 1, 3, NULL, -743.00, 'transfer_out', NULL, 'Transfer to Gcash', '2026-08-06 15:54:54'),
(22, 1, 1, NULL, 743.00, 'transfer_in', NULL, 'Transfer from BPI', '2026-08-06 15:54:54');

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
(1, 1, 1, 'CREATE_ACCOUNT', 'accounts', 0, 'Created new account: Gcash', '::1', '2026-08-05 16:10:18'),
(2, 1, 1, 'CREATE_ACCOUNT', 'accounts', 0, 'Created new account: Maribank', '::1', '2026-08-05 16:10:42'),
(3, 1, 1, 'CREATE_ACCOUNT', 'accounts', 0, 'Created new account: BPI', '::1', '2026-08-05 16:10:50'),
(4, 1, 1, 'CREATE_ACCOUNT', 'accounts', 0, 'Created new account: Gotyme', '::1', '2026-08-05 16:11:01'),
(5, 1, 1, 'CREATE_ACCOUNT', 'accounts', 0, 'Created new account: Maribank - SHE', '::1', '2026-08-05 16:11:24'),
(6, 1, 1, 'UPDATE_ACCOUNT', 'accounts', 2, 'Updated account name to: Maribank - DONSS', '::1', '2026-08-05 16:35:36'),
(7, 1, 1, 'UPDATE_ACCOUNT', 'accounts', 2, 'Updated account details for: Maribank - DONSS', '::1', '2026-08-05 17:17:39'),
(8, 1, 1, 'UPDATE_ACCOUNT', 'accounts', 1, 'Updated account details for: Gcash', '::1', '2026-08-05 17:32:30'),
(9, 1, 1, 'UPDATE_ACCOUNT', 'accounts', 5, 'Updated account details for: Maribank - SHE', '::1', '2026-08-05 17:33:46'),
(10, 1, 1, 'CREATE_BORROWER', 'borrowers', 1, 'Added new borrower: Marldohn Rubinos', '::1', '2026-08-05 17:34:45'),
(11, 1, 1, 'CREATE_ACCOUNT', 'accounts', 0, 'Created new account: Initial Balance', '::1', '2026-08-05 17:35:42'),
(12, 1, 1, 'CREATE_CATEGORY', 'categories', 0, 'Created new category: Emergency', '::1', '2026-08-05 17:37:03'),
(13, 1, 1, 'CREATE_CATEGORY', 'categories', 0, 'Created new category: Allowance', '::1', '2026-08-05 17:37:11'),
(14, 1, 1, 'CREATE_LOAN', 'loans', 1, 'Created new loan #1', '::1', '2026-08-05 17:37:46'),
(15, 1, 1, 'APPROVE_LOAN', 'loans', 1, 'Approved loan #1', '::1', '2026-08-05 17:45:15'),
(16, 1, 1, 'CREATE_BORROWER', 'borrowers', 1, 'Added new borrower: Myles  Batayola', '::1', '2026-08-05 17:46:38'),
(17, 1, 1, 'CREATE_LOAN', 'loans', 2, 'Created new loan #2', '::1', '2026-08-05 18:18:03'),
(18, 1, 1, 'APPROVE_LOAN', 'loans', 2, 'Approved loan #2', '::1', '2026-08-05 18:20:35'),
(19, 1, 1, 'CREATE_BORROWER', 'borrowers', 1, 'Added new borrower: Jerryniel  Lauronal', '192.168.8.100', '2026-08-05 18:27:47'),
(20, 1, 1, 'CREATE_LOAN', 'loans', 3, 'Created new loan #3', '192.168.8.100', '2026-08-05 18:30:24'),
(21, 1, 1, 'APPROVE_LOAN', 'loans', 3, 'Approved loan #3', '192.168.8.100', '2026-08-05 18:30:30'),
(22, 1, 1, 'CREATE_BORROWER', 'borrowers', 1, 'Added new borrower: Janice Olan-olan', '192.168.8.100', '2026-08-05 18:31:49'),
(23, 1, 1, 'CREATE_LOAN', 'loans', 4, 'Created new loan #4', '192.168.8.100', '2026-08-05 18:32:59'),
(24, 1, 1, 'APPROVE_LOAN', 'loans', 4, 'Approved loan #4', '192.168.8.100', '2026-08-05 18:33:04'),
(25, 1, 1, 'CREATE_BORROWER', 'borrowers', 1, 'Added new borrower: March Shelou Ardillo', '192.168.8.100', '2026-08-05 19:01:15'),
(26, 1, 1, 'CREATE_BORROWER', 'borrowers', 1, 'Added new borrower: Cheyanne  Jumilla', '192.168.8.100', '2026-08-05 19:03:04'),
(27, 1, 1, 'CREATE_BORROWER', 'borrowers', 1, 'Added new borrower: Allen Jayme', '192.168.8.100', '2026-08-05 19:03:50'),
(28, 1, 1, 'CREATE_BORROWER', 'borrowers', 1, 'Added new borrower: Marilyn Rubinos', '192.168.8.100', '2026-08-05 19:04:54'),
(29, 1, 1, 'CREATE_BORROWER', 'borrowers', 1, 'Added new borrower: Anne Hildred Olan-Olan', '192.168.8.100', '2026-08-05 19:05:35'),
(30, 1, 1, 'CREATE_LOAN', 'loans', 5, 'Created new loan #5', '192.168.8.100', '2026-08-05 19:07:05'),
(31, 1, 1, 'APPROVE_LOAN', 'loans', 5, 'Approved loan #5', '192.168.8.100', '2026-08-05 19:07:14'),
(32, 1, 1, 'CREATE_LOAN', 'loans', 6, 'Created new loan #6', '192.168.8.100', '2026-08-05 19:09:31'),
(33, 1, 1, 'CREATE_LOAN', 'loans', 7, 'Created new loan #7', '192.168.8.100', '2026-08-05 19:09:50'),
(34, 1, 1, 'APPROVE_LOAN', 'loans', 6, 'Approved loan #6', '192.168.8.100', '2026-08-05 19:09:54'),
(35, 1, 1, 'APPROVE_LOAN', 'loans', 7, 'Approved loan #7', '192.168.8.100', '2026-08-05 19:10:00'),
(36, 1, 1, 'CREATE_LOAN', 'loans', 8, 'Created new loan #8', '192.168.8.100', '2026-08-05 19:12:57'),
(37, 1, 1, 'CREATE_LOAN', 'loans', 9, 'Created new loan #9', '192.168.8.100', '2026-08-05 19:13:40'),
(38, 1, 1, 'APPROVE_LOAN', 'loans', 8, 'Approved loan #8', '192.168.8.100', '2026-08-05 19:13:44'),
(39, 1, 1, 'APPROVE_LOAN', 'loans', 9, 'Approved loan #9', '192.168.8.100', '2026-08-05 19:13:47'),
(40, 1, 1, 'CREATE_LOAN', 'loans', 10, 'Created new loan #10', '192.168.8.100', '2026-08-05 19:14:55'),
(41, 1, 1, 'APPROVE_LOAN', 'loans', 10, 'Approved loan #10', '192.168.8.100', '2026-08-05 19:14:59'),
(42, 1, 1, 'CREATE_BORROWER', 'borrowers', 1, 'Added new borrower: John Bert', '192.168.8.100', '2026-08-05 19:17:48'),
(43, 1, 1, 'CREATE_LOAN', 'loans', 11, 'Created new loan #11', '192.168.8.100', '2026-08-05 19:18:05'),
(44, 1, 1, 'APPROVE_LOAN', 'loans', 11, 'Approved loan #11', '192.168.8.100', '2026-08-05 19:19:06'),
(45, 1, 1, 'CREATE_LOAN', 'loans', 12, 'Created new loan #12', '192.168.8.100', '2026-08-05 19:19:26'),
(46, 1, 1, 'APPROVE_LOAN', 'loans', 12, 'Approved loan #12', '192.168.8.100', '2026-08-05 19:19:31'),
(47, 1, 1, 'UPDATE_LOAN', 'loans', 1, 'Updated loan #1', '::1', '2026-08-05 19:28:14'),
(48, 1, 1, 'UPDATE_LOAN', 'loans', 2, 'Updated loan #2', '::1', '2026-08-05 19:29:52'),
(49, 1, 1, 'CREATE_CATEGORY', 'categories', 0, 'Created new category: Salaries & Wages', '::1', '2026-08-05 19:32:11'),
(50, 1, 1, 'CREATE_CATEGORY', 'categories', 0, 'Created new category: Rent', '::1', '2026-08-05 19:32:20'),
(51, 1, 1, 'CREATE_CATEGORY', 'categories', 0, 'Created new category: Utilities', '::1', '2026-08-05 19:32:32'),
(52, 1, 1, 'CREATE_CATEGORY', 'categories', 0, 'Created new category: Loan Loss / Bad Debt', '::1', '2026-08-05 19:32:48'),
(53, 1, 1, 'CREATE_CATEGORY', 'categories', 0, 'Created new category: Miscellaneous', '::1', '2026-08-05 19:33:02'),
(54, 1, 1, 'CREATE_CATEGORY', 'categories', 0, 'Created new category: Rent', '::1', '2026-08-05 19:33:56'),
(55, 1, 1, 'CREATE_CATEGORY', 'categories', 0, 'Created new category: Internet', '::1', '2026-08-05 19:34:03'),
(56, 1, 1, 'CREATE_EXPENSE', 'expenses', 1, 'Created new expense: Wifi - Amount: ₱899.00', '192.168.8.100', '2026-08-06 15:29:49'),
(57, 1, 1, 'CREATE_EXPENSE', 'expenses', 2, 'Created new expense: Wifi - Amount: ₱899.00', '::1', '2026-08-06 15:45:12'),
(58, 1, 1, 'TRANSFER_FUNDS', 'accounts', 0, 'Transferred ₱8,344.00 from Gotyme to Maribank - DONSS', '::1', '2026-08-06 15:51:38'),
(59, 1, 1, 'TRANSFER_FUNDS', 'accounts', 0, 'Transferred ₱4,660.00 from Maribank - DONSS to BPI', '::1', '2026-08-06 15:53:51'),
(60, 1, 1, 'TRANSFER_FUNDS', 'accounts', 0, 'Transferred ₱743.00 from BPI to Gcash', '::1', '2026-08-06 15:54:54'),
(61, 1, 1, 'CREATE_EXPENSE', 'expenses', 3, 'Created new expense: Birthday Gift to Noli - Amount: ₱108.00', '::1', '2026-08-06 15:56:02');

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
(1, 1, 'Marldohn', 'Codizar', 'Rubinos', 'Male', '2002-11-04', '09061941138', 'marldohncrubinos11@gmail.com', 'Jakosalem Street Cebu City', '0000', 1, '2026-08-05 17:34:45', NULL),
(2, 1, 'Myles ', '', 'Batayola', 'Male', '0001-01-01', '-', 'test@test.com', 'Sikatuna Street Cebu City', '-', 1, '2026-08-05 17:46:38', NULL),
(3, 1, 'Jerryniel ', '', 'Lauronal', 'Male', '0001-01-01', '-', 'test@test.com', 'Sikatuna Street Cebu City', '00000', 1, '2026-08-05 18:27:47', NULL),
(4, 1, 'Janice', '', 'Olan-olan', 'Female', '0001-01-01', '-', 'test@test.com', 'Leyte, Philippines', '0000', 1, '2026-08-05 18:31:49', NULL),
(5, 1, 'March Shelou', '', 'Ardillo', 'Female', '2004-05-19', '09059626063', 'marchshelou@gmail.com', 'Balamban, Cebu', '0000', 1, '2026-08-05 19:01:15', NULL),
(6, 1, 'Cheyanne ', '', 'Jumilla', 'Male', '0001-01-01', '000000', 'test@test.com', 'Bohol, Philippines', '0000', 1, '2026-08-05 19:03:04', NULL),
(7, 1, 'Allen', '', 'Jayme', 'Male', '0001-01-01', '00000', 'test@test.com', 'Jakosalem Street Cebu City, Cebu', '000000', 1, '2026-08-05 19:03:50', NULL),
(8, 1, 'Marilyn', '', 'Rubinos', 'Female', '1978-12-18', '09754171178', 'marilynrubinos@gmail.com', 'Jakosalem Street Cebu City, Cebu', '0000', 1, '2026-08-05 19:04:54', NULL),
(9, 1, 'Anne Hildred', '', 'Olan-Olan', 'Female', '0001-01-01', '000', 'test@test.com', 'Sikatuna Street Cebu City, Cebu', '00000', 1, '2026-08-05 19:05:35', NULL),
(10, 1, 'John', '', 'Bert', 'Male', '0001-01-01', '0000', 'test@test.com', 'Sikatuna Street Cebu City, Cebu', '0000', 1, '2026-08-05 19:17:48', NULL);

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
(1, 1, 'loan', 'Emergency', '', '2026-08-05 17:37:03'),
(2, 1, 'loan', 'Allowance', '', '2026-08-05 17:37:11'),
(3, 1, 'expense', 'Salaries & Wages', 'Salaries & Wages', '2026-08-05 19:32:11'),
(4, 1, 'expense', 'Rent', 'Rent', '2026-08-05 19:32:20'),
(5, 1, 'expense', 'Utilities', 'Utilities', '2026-08-05 19:32:31'),
(6, 1, 'expense', 'Loan Loss / Bad Debt', 'Loan Loss / Bad Debt', '2026-08-05 19:32:48'),
(7, 1, 'expense', 'Miscellaneous', 'Miscellaneous', '2026-08-05 19:33:02'),
(8, 1, 'loan', 'Rent', 'Rent', '2026-08-05 19:33:56'),
(9, 1, 'loan', 'Internet', 'Internet', '2026-08-05 19:34:03');

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
(1, 'Marldohn Financial', 'free', 'active', NULL, '2026-08-05 16:05:51');

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

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `company_id`, `account_id`, `title`, `amount`, `category`, `category_id`, `expense_date`, `notes`, `created_at`) VALUES
(1, 1, 5, 'Wifi', 899.00, 'General', 5, '2026-08-06', NULL, '2026-08-06 15:29:49'),
(2, 1, 4, 'Wifi', 899.00, 'General', 5, '2026-08-06', NULL, '2026-08-06 15:45:12'),
(3, 1, 3, 'Birthday Gift to Noli', 108.00, 'General', 7, '2026-08-06', NULL, '2026-08-06 15:56:02');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
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
(1, 1, 6, 1, 41877.00, 0.00, 41877.00, 'Approved', '2026-08-05', '4764-07-01', '2026-08-05 17:37:45', 999999, '', 'one_time', 0.00, 2, ''),
(2, 1, 6, 2, 11724.00, 15.00, 13482.60, 'Approved', '2026-08-05', '2026-08-15', '2026-08-05 18:18:03', 10, '', 'one_time', 0.00, 2, ''),
(3, 1, 6, 3, 8090.00, 15.00, 9300.00, 'Approved', '2026-08-05', '2026-08-15', '2026-08-05 18:30:24', 10, '', 'one_time', -3.50, 1, 'standard'),
(4, 1, 6, 4, 50000.00, 15.00, 57500.00, 'Approved', '2026-07-25', '2026-08-07', '2026-08-05 18:32:59', 13, '', 'one_time', 0.00, 1, 'standard'),
(5, 1, 6, 9, 14500.00, 0.00, 14500.00, 'Approved', '2026-08-05', '2026-09-30', '2026-08-05 19:07:05', 56, '', 'one_time', 0.00, 1, 'standard'),
(6, 1, 6, 7, 5000.00, 15.00, 5750.00, 'Approved', '2026-08-05', '2026-08-15', '2026-08-05 19:09:31', 10, '', 'one_time', 0.00, 2, 'standard'),
(7, 1, 2, 7, 2000.00, 15.00, 2300.00, 'Approved', '2026-08-05', '2026-08-15', '2026-08-05 19:09:50', 10, '', 'one_time', 0.00, 2, 'standard'),
(8, 1, 6, 8, 800.00, 0.00, 800.00, 'Approved', '2026-08-05', '2053-12-20', '2026-08-05 19:12:57', 9999, '', 'one_time', 0.00, 1, 'standard'),
(9, 1, 6, 5, 13036.00, 0.00, 13036.00, 'Approved', '2026-08-05', '2053-12-20', '2026-08-05 19:13:40', 9999, '', 'one_time', 0.00, 2, 'standard'),
(10, 1, 6, 6, 10000.00, 11.00, 11100.00, 'Approved', '2026-08-05', '2026-08-15', '2026-08-05 19:14:55', 10, '', 'one_time', 0.00, 1, 'standard'),
(11, 1, 6, 10, 2750.00, 15.00, 3162.50, 'Approved', '2026-08-05', '2026-08-15', '2026-08-05 19:18:05', 10, '', 'one_time', 0.00, 2, 'standard'),
(12, 1, 6, 3, 3000.00, 15.00, 3450.00, 'Approved', '2026-08-05', '2026-08-15', '2026-08-05 19:19:26', 10, '', 'one_time', 0.00, 2, 'standard');

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
(1, 1, 'mrubinos@admin.net', '$2y$10$/DhJJCjKBhl./meP.7NkiebnAojnXPOppxye5HfYdAYRJqRZJpAPy', 'admin', '2026-05-27 05:22:38', 1),
(2, 1, 'superadmin', '$2y$10$Aer/QH7qOQrYCwqCopAkzOggT.pz5sAOehC/aU6ZbPv2k2rxhn5Iq', 'superadmin', '2026-05-29 22:49:23', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `account_transactions`
--
ALTER TABLE `account_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `borrowers`
--
ALTER TABLE `borrowers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_funds`
--
ALTER TABLE `company_funds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `loan_collaterals`
--
ALTER TABLE `loan_collaterals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_installments`
--
ALTER TABLE `loan_installments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penalties`
--
ALTER TABLE `penalties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
