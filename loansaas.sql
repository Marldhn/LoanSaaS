-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 31, 2026 at 12:18 AM
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
(1, 2, 'Gcash', 0.00),
(2, 2, 'Maya', 0.00),
(3, 2, 'Maribank', 13500.00);

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
(8, 0, 1, NULL, 448.00, '', NULL, 'Payment for Loan #5', '2026-05-28 21:53:51');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrowers`
--

INSERT INTO `borrowers` (`id`, `company_id`, `first_name`, `middle_name`, `last_name`, `gender`, `birthdate`, `phone`, `email`, `address`, `valid_id`, `status`, `created_at`) VALUES
(1, 2, 'Marldohn ', 'Codizar', 'Rubinos', 'Male', '1111-10-10', '09061941138', 'marldohcrubinos11@gmail.com', '8541851weqf', '01010101010101', 1, '2026-05-28 13:17:53'),
(2, 2, 'Marldohn', 'Codizar', 'Rubinos', 'Male', '2002-11-04', '09061941138', 'marldohncrubinos11@gmail.com', 'Jakosalem Street Cebu City', '-', 1, '2026-05-28 19:28:19');

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
(2, 'Sheldons', 'free', 'active', NULL, '2026-05-27 21:22:38'),
(3, 'LoanShark', 'free', 'active', NULL, '2026-05-30 16:11:17');

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
  `term_months` int(11) DEFAULT 12,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `company_id`, `account_id`, `borrower_id`, `amount`, `interest_rate`, `total_payable`, `status`, `released_date`, `due_date`, `created_at`, `term_months`, `notes`) VALUES
(6, 2, NULL, 1, 10000.00, 10.00, 11000.00, 'Approved', NULL, '2026-05-30', '2026-05-30 20:46:10', 12, NULL),
(7, 2, 1, 1, 48.00, 0.00, 48.00, 'Approved', '2026-05-30', '2026-05-31', '2026-05-30 21:47:18', 12, '-'),
(9, 2, 1, 1, 48.00, 0.00, 48.00, 'Approved', '2026-05-30', '2026-06-02', '2026-05-30 21:53:56', 12, ''),
(10, 2, 1, 1, 400.00, 0.00, 400.00, 'Approved', '2026-05-30', '2026-05-31', '2026-05-30 21:56:44', 12, ''),
(11, 2, 3, 1, 3000.00, 0.00, 3000.00, 'Approved', '2026-05-31', '2026-06-01', '2026-05-30 22:10:06', 12, ''),
(13, 2, 3, 2, 1000.00, 0.00, 1000.00, 'Approved', '2026-05-31', '2026-06-01', '2026-05-30 22:12:30', 12, ''),
(14, 2, 3, 1, 500.00, 0.00, 500.00, 'Approved', '2026-05-31', '2026-06-01', '2026-05-30 22:13:22', 12, '-');

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
(2, 2, 14, 'PC', NULL, 50000.00, 'uploads/collaterals/collateral_14_1780179202.jpg', '2026-05-30 22:13:22');

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
  `notes` text DEFAULT NULL
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
(1, 1, 'super@admin.com', 'password', 'super_admin', '2026-05-27 21:00:31', 1),
(2, 2, 'mrubinos@azpired.net', '$2y$10$aW3cTVhs4SFEl7Ixyo4OKOmqKTjgKL/LeNq6yRWJOLy0tQe2WOSP2', 'admin', '2026-05-27 21:22:38', 1),
(3, 2, 'staff1@gmail.com', '$2y$10$YMp1R.9MH1c.M6s84fwV0un8WowcDZY/1VfTrA2Ud7xWcp0kL6u1u', 'staff', '2026-05-28 18:53:10', 1),
(4, 1, 'superadmin2', '$2y$10$T8ZJ1pC4O6.Ym9G2Fv4Wk.x9eHwK2aT0.iL0P4K/yXzQ4T2oN5.yS', 'superadmin', '2026-05-30 14:49:23', 1),
(5, 1, 'mrubinos11@gmail.com', '$2y$10$uSJ14gku5Fn1jrGMS4WdNOgIIEMcahOw1H/E03t2PRmTpfa7O63lS', 'staff', '2026-05-30 15:02:55', 1),
(6, 1, 'mrubinos@gmail.com', '$2y$10$Is7Ij26lz/wemJongl4oUuQkLRQCyOe3GLalhKsEgbuhNtzwX5YGC', 'staff', '2026-05-30 15:03:11', 1),
(7, 3, 'azpired@gmail.com', '$2y$10$mXFh/wuuuBD3sInxtoVeFuX0awIBI1JAER2rYvNP4hgyh3D6aNNDG', 'admin', '2026-05-30 16:11:17', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_accounts_company` (`company_id`);

--
-- Indexes for table `account_transactions`
--
ALTER TABLE `account_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_trans_account` (`account_id`);

--
-- Indexes for table `borrowers`
--
ALTER TABLE `borrowers`
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
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `borrower_id` (`borrower_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `account_transactions`
--
ALTER TABLE `account_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `borrowers`
--
ALTER TABLE `borrowers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `company_funds`
--
ALTER TABLE `company_funds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `loan_collaterals`
--
ALTER TABLE `loan_collaterals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Constraints for table `borrowers`
--
ALTER TABLE `borrowers`
  ADD CONSTRAINT `borrowers_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_funds`
--
ALTER TABLE `company_funds`
  ADD CONSTRAINT `funds_company_fk` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`borrower_id`) REFERENCES `borrowers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loan_collaterals`
--
ALTER TABLE `loan_collaterals`
  ADD CONSTRAINT `loan_collaterals_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
