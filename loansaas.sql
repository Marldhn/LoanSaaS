-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 02, 2026 at 11:45 PM
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
(1, 2, 'Gcash', 8000.00),
(2, 2, 'Maya', 0.00),
(3, 2, 'Maribank', 3000.00);

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
(5, 2, 1, 4, -11000.00, '', NULL, 'Disbursement for Loan #4', '2026-05-28 20:40:09'),
(6, 2, 2, 4, -2000.00, '', NULL, 'Disbursement for Loan #4', '2026-05-28 20:40:09'),
(7, 2, 3, 5, -2000.00, '', NULL, 'Disbursement for Loan #5', '2026-05-28 20:41:29'),
(8, 0, 1, NULL, 448.00, '', NULL, 'Payment for Loan #5', '2026-05-28 21:53:51'),
(10, 2, 3, 15, 2500.00, '', NULL, 'Reversing loan #15 edit', '2026-05-31 14:58:54'),
(11, 2, 3, 15, -3000.00, '', NULL, 'Loan #15 issued (Edited)', '2026-05-31 14:58:54'),
(12, 2, 3, 15, 3000.00, '', NULL, 'Reversing loan #15 edit', '2026-05-31 15:01:29'),
(13, 2, 3, 15, -3000.00, '', NULL, 'Loan #15 issued (Edited)', '2026-05-31 15:01:29'),
(14, 2, 3, 15, 3000.00, '', NULL, 'Reversing loan #15 for edit', '2026-05-31 15:06:33'),
(15, 2, 3, 15, -3000.00, '', NULL, 'Loan #15 re-issued with updated amount', '2026-05-31 15:06:33'),
(16, 2, 3, 16, 500.00, '', NULL, 'Reversing loan #16 for edit', '2026-05-31 15:49:30'),
(17, 2, 3, 16, -500.00, '', NULL, 'Loan #16 re-issued with updated amount', '2026-05-31 15:49:30'),
(18, 2, 3, 16, 500.00, '', NULL, 'Reversing loan #16 for edit', '2026-05-31 16:58:53'),
(19, 2, 3, 16, -500.00, '', NULL, 'Loan #16 re-issued with updated amount', '2026-05-31 16:58:53'),
(20, 2, 3, 16, 500.00, '', NULL, 'Reversing loan #16 for edit', '2026-05-31 17:04:55'),
(21, 2, 3, 16, -1000.00, '', NULL, 'Loan #16 re-issued with updated amount', '2026-05-31 17:04:55'),
(22, 2, 3, 16, 1000.00, '', NULL, 'Reversing loan #16 for edit', '2026-05-31 17:24:07'),
(23, 2, 3, 16, -500.00, '', NULL, 'Loan #16 re-issued with updated amount', '2026-05-31 17:24:07'),
(24, 2, 3, 16, 1000.00, '', NULL, 'Reversing loan #16 for edit', '2026-05-31 17:28:16'),
(25, 2, 3, 16, -500.00, '', NULL, 'Loan #16 re-issued with updated amount', '2026-05-31 17:28:16'),
(26, 2, 3, NULL, -500.00, 'transfer_out', NULL, 'Transfer to Account #1: ', '2026-05-31 17:32:49'),
(27, 2, 1, NULL, 500.00, 'transfer_in', NULL, 'Transfer from Account #3: ', '2026-05-31 17:32:49'),
(28, 2, 3, NULL, -41000.00, 'transfer_out', NULL, 'Transfer to Account #2: ', '2026-05-31 18:02:16'),
(29, 2, 2, NULL, 41000.00, 'transfer_in', NULL, 'Transfer from Account #3: ', '2026-05-31 18:02:16'),
(30, 2, 2, NULL, -41000.00, 'transfer_out', NULL, 'Transfer to account #3', '2026-05-31 18:03:34'),
(31, 2, 3, NULL, 41000.00, 'transfer_in', NULL, 'Transfer from account #2', '2026-05-31 18:03:34'),
(32, 2, 1, NULL, -100.00, 'transfer_out', NULL, 'Transfer to Maya', '2026-05-31 18:16:04'),
(33, 2, 2, NULL, 100.00, 'transfer_in', NULL, 'Transfer from Gcash', '2026-05-31 18:16:04'),
(34, 2, 2, NULL, -50.00, 'transfer_out', NULL, 'Transfer to Maribank', '2026-05-31 19:41:30'),
(35, 2, 3, NULL, 50.00, 'transfer_in', NULL, 'Transfer from Maya', '2026-05-31 19:41:30'),
(36, 2, 1, 18, -400.00, '', NULL, 'Loan #18 Approved', '2026-05-31 20:05:59'),
(37, 2, 2, 25, -50.00, '', NULL, 'Loan #25 Approved', '2026-05-31 20:24:35'),
(38, 2, 2, 24, -50.00, '', NULL, 'Loan #24 Approved', '2026-05-31 20:24:50'),
(41, 2, 2, 23, -50.00, '', NULL, 'Loan #23 Approved', '2026-05-31 20:31:24'),
(44, 2, 3, NULL, -50.00, 'transfer_out', NULL, 'Transfer to Maya', '2026-06-01 11:58:44'),
(45, 2, 2, NULL, 50.00, 'transfer_in', NULL, 'Transfer from Maribank', '2026-06-01 11:58:44'),
(48, 2, 2, 26, -50.00, '', NULL, 'Loan #26 Approved', '2026-06-01 19:59:02'),
(53, 2, 2, 26, -50.00, '', NULL, 'Loan #26 Approved', '2026-06-01 20:25:23');

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
(1, 2, 2, 'CREATE_BORROWER', 'borrowers', 1, 'Added new borrower: Rolan Cabanos', '::1', '2026-05-31 19:39:04'),
(2, 2, 2, 'TRANSFER_FUNDS', 'accounts', 0, 'Transferred ₱50.00 from Maya to Maribank', '::1', '2026-05-31 19:41:30'),
(3, 2, 2, 'CREATE_LOAN', 'loans', NULL, 'Created new loan #', '::1', '2026-05-31 19:58:25'),
(4, 2, 2, 'CREATE_LOAN', 'loans', 18, 'Created new loan #18', '::1', '2026-05-31 20:03:56'),
(5, 2, 2, 'APPROVE_LOAN', 'loans', 18, 'Approved loan #18', '::1', '2026-05-31 20:05:59'),
(6, 2, 2, 'CREATE_LOAN', 'loans', 19, 'Created new loan #19', '::1', '2026-05-31 20:06:44'),
(7, 2, 2, 'CREATE_LOAN', 'loans', 20, 'Created new loan #20', '::1', '2026-05-31 20:08:39'),
(8, 2, 2, 'CREATE_LOAN', 'loans', 21, 'Created new loan #21', '::1', '2026-05-31 20:09:07'),
(9, 2, 2, 'CREATE_LOAN', 'loans', 22, 'Created new loan #22', '::1', '2026-05-31 20:11:01'),
(10, 2, 2, 'CREATE_LOAN', 'loans', 23, 'Created new loan #23', '::1', '2026-05-31 20:13:10'),
(11, 2, 2, 'CREATE_LOAN', 'loans', 24, 'Created new loan #24', '::1', '2026-05-31 20:15:21'),
(12, 2, 2, 'CREATE_LOAN', 'loans', 25, 'Created new loan #25', '::1', '2026-05-31 20:18:45'),
(13, 2, 2, 'APPROVE_LOAN', 'loans', 25, 'Approved loan #25', '::1', '2026-05-31 20:24:35'),
(14, 2, 2, 'APPROVE_LOAN', 'loans', 24, 'Approved loan #24', '::1', '2026-05-31 20:24:50'),
(15, 2, 2, 'APPROVE_LOAN', 'loans', 23, 'Approved loan #23', '::1', '2026-05-31 20:31:24'),
(16, 2, 2, 'CREATE_PAYMENT', 'payments', 6, 'Received payment of ₱3,000.00 for loan #6', '::1', '2026-05-31 21:22:39'),
(17, 2, 2, 'CREATE_PAYMENT', 'payments', 6, 'Received payment of ₱8,000.00 for loan #6', '::1', '2026-05-31 21:42:55'),
(18, 2, 2, 'TRANSFER_FUNDS', 'accounts', 0, 'Transferred ₱50.00 from Maribank to Maya', '::1', '2026-06-01 11:58:44'),
(19, 2, 2, 'CREATE_LOAN', 'loans', 26, 'Created new loan #26', '::1', '2026-06-01 19:56:24'),
(20, 2, 3, 'APPROVE_LOAN', 'loans', 26, 'Approved loan #26', '::1', '2026-06-01 20:25:23'),
(21, 2, 3, 'CREATE_LOAN', 'loans', 27, 'Created new loan #27', '::1', '2026-06-01 20:26:05'),
(22, 2, 3, 'CREATE_LOAN', 'loans', 28, 'Created new loan #28', '::1', '2026-06-01 20:29:09'),
(23, 2, 3, 'UPDATE_LOAN', 'loans', 28, 'Updated loan #28', '::1', '2026-06-01 20:29:13'),
(24, 2, 3, 'CREATE_LOAN', 'loans', 29, 'Created new loan #29', '::1', '2026-06-01 20:30:07'),
(25, 2, 3, 'REJECT_LOAN', 'loans', 29, 'Rejected loan #29', '::1', '2026-06-01 20:30:11'),
(26, 2, 2, 'UPDATE_BUSINESS_NAME', 'companies', 2, 'Updated business name to: ShelDohnsss', '::1', '2026-06-02 20:38:41'),
(27, 2, 2, 'UPDATE_BUSINESS_NAME', 'companies', 2, 'Updated business name to: ShelDohnssss', '::1', '2026-06-02 20:38:45'),
(28, 2, 2, 'CREATE_CATEGORY', 'categories', 0, 'Created new category: Test', '::1', '2026-06-02 21:23:36');

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
(1, 2, 'Marldohn ', 'Codizar', 'Rubinos', 'Male', '1111-10-10', '09061941138', 'marldohcrubinos11@gmail.com', '8541851weqf', '01010101010101', 1, '2026-05-28 13:17:53', NULL),
(2, 2, 'Marldohnssssasd', 'Codizar', 'Rubinos', 'Male', '2002-11-04', '09061941138', NULL, 'Jakosalem Street Cebu City', NULL, 1, '2026-05-28 19:28:19', NULL),
(3, 2, 'Rolan', '', 'Cabanos', 'Male', '1111-11-11', 'qwfqfqf', 'rcabanos@azpired.net', '651', '15641651651', 1, '2026-05-31 19:39:04', NULL);

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
(1, 2, 'loan', 'Emergency', '-', '2026-06-01 19:54:38'),
(2, 2, 'payment', 'Test', 'qwf', '2026-06-02 21:23:13'),
(3, 2, 'payment', 'Test', 'qwf', '2026-06-02 21:23:36');

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
(1, 'System Platform Root Admin', 'premium', 'active', '2035-12-31 23:59:59', '2026-05-27 21:00:31'),
(2, 'ShelDohnssss', 'basic', 'active', NULL, '2026-05-27 21:22:38'),
(3, 'LoanShark', 'basic', 'active', NULL, '2026-05-30 16:11:17'),
(4, 'Bogorsss', 'basic', 'active', NULL, '2026-05-31 08:07:28');

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

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `sender_id`, `company_id`, `message`, `created_at`, `is_read`, `category_id`) VALUES
(1, 2, 2, 'Hello', '2026-06-01 18:21:28', 0, NULL);

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
  `term_months` int(11),
  `notes` text DEFAULT NULL,
  `term_type` varchar(20) DEFAULT 'month',
  `fee` decimal(15,2) DEFAULT 0.00,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `company_id`, `account_id`, `borrower_id`, `amount`, `interest_rate`, `total_payable`, `status`, `released_date`, `due_date`, `created_at`, `term_months`, `notes`, `term_type`, `fee`, `category_id`) VALUES
(6, 2, NULL, 1, 13000.00, 10.00, 11000.00, 'Approved', NULL, '2026-05-30', '2026-05-30 20:46:10', 12, NULL, 'month', 0.00, NULL),
(7, 2, 1, 1, 48.00, 0.00, 48.00, 'Approved', '2026-05-30', '2026-05-31', '2026-05-30 21:47:18', 12, '-', 'month', 0.00, NULL),
(9, 2, 1, 1, 48.00, 0.00, 48.00, 'Approved', '2026-05-30', '2026-06-02', '2026-05-30 21:53:56', 12, '', 'month', 0.00, NULL),
(10, 2, 1, 1, 400.00, 0.00, 400.00, 'Approved', '2026-05-30', '2026-05-31', '2026-05-30 21:56:44', 12, '', 'month', 0.00, NULL),
(11, 2, 3, 1, 3000.00, 0.00, 3000.00, 'Approved', '2026-05-31', '2026-06-01', '2026-05-30 22:10:06', 12, '', 'month', 0.00, NULL),
(13, 2, 3, 2, 1000.00, 0.00, 1000.00, 'Approved', '2026-05-31', '2026-06-01', '2026-05-30 22:12:30', 12, '', 'month', 0.00, NULL),
(14, 2, 3, 1, 500.00, 0.00, 500.00, 'Approved', '2026-05-31', '2026-06-01', '2026-05-30 22:13:22', 12, '-', 'day', 0.00, NULL),
(15, 2, 3, 2, 3000.00, 10.00, 3300.00, 'Approved', '2026-05-31', '2026-06-01', '2026-05-31 14:53:55', 12, '-', 'month', 0.00, NULL),
(16, 2, 3, 2, 500.00, 50.00, 750.00, 'Approved', '2026-05-31', '2026-07-01', '2026-05-31 15:24:22', 12, '', 'month', 0.00, NULL),
(17, 2, 3, 1, 1000.00, 100.00, 2000.00, 'Rejected', '2026-05-31', '2026-07-01', '2026-05-31 15:51:29', 12, '', 'month', 0.00, NULL),
(18, 2, 1, 3, 400.00, 10.00, 455.00, 'Approved', '2026-05-31', '2026-07-01', '2026-05-31 20:03:56', 12, '-', 'month', 15.00, NULL),
(19, 2, 2, 3, 50.00, 0.00, 50.00, 'Rejected', '2026-05-31', '2026-10-31', '2026-05-31 20:06:44', 12, '', 'month', 0.00, NULL),
(20, 2, 2, 3, 50.00, 0.00, 50.00, 'Rejected', '2026-05-31', '2026-06-01', '2026-05-31 20:08:39', 12, '', 'month', 0.00, NULL),
(21, 2, 2, 3, 50.00, 0.00, 50.00, 'Rejected', '2026-05-31', '2026-06-01', '2026-05-31 20:09:07', 12, '', 'month', 0.00, NULL),
(22, 2, 2, 3, 50.00, 0.00, 50.00, 'Rejected', '2026-05-31', '2026-07-01', '2026-05-31 20:11:01', 12, '', 'month', 0.00, NULL),
(23, 2, 2, 3, 50.00, 0.00, 49.99, 'Approved', '2026-05-31', '2026-07-01', '2026-05-31 20:13:10', 0, '', 'month', -0.01, NULL),
(25, 2, 2, 3, 50.00, 0.00, 50.00, 'Approved', '2026-05-31', '2026-07-01', '2026-05-31 20:18:45', 1, '', 'month', 0.00, NULL),
(26, 2, 2, 2, 50.00, 100.00, 100.00, 'Approved', '2026-06-01', '2026-06-04', '2026-06-01 19:56:24', 3, '', 'day', 0.00, 1),
(27, 2, 3, 2, 500.00, 10.00, 550.00, 'Rejected', '2026-06-01', '2026-07-01', '2026-06-01 20:26:05', 1, '', 'month', 0.00, 1),
(28, 2, 3, 2, 3000.00, 0.00, 3000.00, 'Rejected', '2026-06-01', '2026-07-01', '2026-06-01 20:29:09', 1, '', 'month', 0.00, 1),
(29, 2, 1, 2, 1000.00, 0.00, 1000.00, 'Rejected', '2026-06-01', '2026-07-01', '2026-06-01 20:30:07', 1, '', 'month', 0.00, 1);

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
(1, 2, 13, 'Gold Ring', NULL, 10000.00, NULL, '2026-05-30 22:12:30'),
(2, 2, 14, 'PC', NULL, 30000.00, 'uploads/collaterals/collateral_14_1780179202.jpg', '2026-05-30 22:13:22'),
(3, 2, 15, 'qwr', NULL, 123.00, 'uploads/collaterals/collateral_15_1780239235.jpg', '2026-05-31 14:53:55');

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
(3, NULL, 2, 6, 3000.00, '2026-06-01', NULL, NULL, '2026-05-31 21:22:39', 0.00, 0.00, 0.00, NULL, NULL),
(4, 1, 2, 6, 8000.00, '2026-05-31', NULL, NULL, '2026-05-31 21:42:55', 0.00, 0.00, 0.00, NULL, NULL);

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
(1, 1, 'super@admin.com', 'password', 'super_admin', '2026-05-27 21:00:31', 1),
(2, 2, 'mrubinos@azpired.net', '$2y$10$lw71329OuDv7OoCX8rC5wuZee/0VQ9/jz9sKxdKsveeGnLO450j/G', 'admin', '2026-05-27 21:22:38', 1),
(3, 2, 'staff1@gmail.com', '$2y$10$P8kMM293jsQphvzqiuU34ewY0xialKUTiP.R202lsi/bSI2/qYDHK', 'staff', '2026-05-28 18:53:10', 0),
(4, 1, 'superadmin2', '$2y$10$T8ZJ1pC4O6.Ym9G2Fv4Wk.x9eHwK2aT0.iL0P4K/yXzQ4T2oN5.yS', 'superadmin', '2026-05-30 14:49:23', 1),
(5, 1, 'mrubinos11@gmail.com', '$2y$10$uSJ14gku5Fn1jrGMS4WdNOgIIEMcahOw1H/E03t2PRmTpfa7O63lS', 'staff', '2026-05-30 15:02:55', 1),
(6, 1, 'mrubinos@gmail.com', '$2y$10$K3sezJ8u.ug9ZrlwXTupc.2Za1e7BleYcdDo8UWVu/0p7QW6ocnA.', 'staff', '2026-05-30 15:03:11', 1),
(7, 3, 'azpired@gmail.com', '$2y$10$mXFh/wuuuBD3sInxtoVeFuX0awIBI1JAER2rYvNP4hgyh3D6aNNDG', 'admin', '2026-05-30 16:11:17', 1),
(8, 4, 'drubinos@azpired.net', '$2y$10$m404WX5qHOqW4aU1i9LXi.yrTFT9z0Mkyn8Z0vnue9nwDUI1ijKg2', 'admin', '2026-05-31 08:07:28', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `account_transactions`
--
ALTER TABLE `account_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `borrowers`
--
ALTER TABLE `borrowers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `company_funds`
--
ALTER TABLE `company_funds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `loan_collaterals`
--
ALTER TABLE `loan_collaterals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `loan_installments`
--
ALTER TABLE `loan_installments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
