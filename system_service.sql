-- phpMyAdmin SQL Dump
-- version 5.2.0-rc1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 01, 2022 at 11:49 PM
-- Server version: 10.3.31-MariaDB-0+deb10u1
-- PHP Version: 8.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `system_service`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_customer` bigint(20) UNSIGNED NOT NULL,
  `booking_date` date NOT NULL DEFAULT current_timestamp(),
  `complaint` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_type` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `id_customer`, `booking_date`, `complaint`, `service_type`, `status`, `created_at`, `updated_at`) VALUES
(13, 3, '2022-04-01', 'Servis ringan', 1, 1, '2022-04-01 09:03:01', '2022-04-01 09:03:01');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_plate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `address`, `email`, `password`, `phone`, `vehicle_type`, `license_plate`, `otp`, `created_at`, `updated_at`) VALUES
(1, 'name', 'address', 'email', NULL, '', 'type', 'plate', NULL, '2022-03-13 00:55:51', '2022-03-16 20:46:59'),
(3, 'erwin', 'erwin', 'erwinmail94@gmail.com', '$2y$10$5N48EOjIplyVLxJasPWDDOXLiJZRdOoJx.nXO9ZJ9NNw1hoBkJ4JC', '6281297180628', 'erwin', 'erwin', '6128', '2022-03-17 07:20:03', '2022-04-01 08:42:20'),
(4, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, '7581', '2022-03-19 21:36:56', '2022-03-29 07:52:46'),
(5, NULL, NULL, 'asd', NULL, NULL, NULL, NULL, '7458', '2022-03-20 06:21:30', '2022-03-20 06:21:30'),
(6, 'asd', 'asd', 'erwin_esgs@yahoo.com', '$2y$10$uwXNo9do/ojPMZKsGrvhguwz0M5vh/v.NTZ5Rsth9Zt3WzxsWK..W', 'asd', 'asd', 'asd', '3606', '2022-03-22 08:53:19', '2022-04-01 08:25:14'),
(7, NULL, NULL, 'erwin@ptunique.com', NULL, NULL, NULL, NULL, '5571', '2022-03-29 08:53:20', '2022-03-29 08:53:20');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2022_03_13_072202_create_customer', 2),
(3, '2022_03_13_090955_create_stock', 3),
(7, '2022_03_17_131110_create_booking', 4),
(8, '2022_03_20_090723_create_transaction', 5);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `name`, `qty`, `code`, `price`, `created_at`, `updated_at`) VALUES
(2, 'barang', 2169, 'BRG11', 8000, '2022-03-16 08:21:59', '2022-03-29 09:38:43'),
(4, 'Ban', 22184, 'B123', 4000, '2022-03-20 04:32:24', '2022-03-29 09:38:43'),
(5, 'Satu', 122, 'B320', 5000, '2022-03-24 07:53:32', '2022-03-29 09:38:43'),
(6, 'qwe', 122, 'qwe', 0, '2022-03-29 07:26:17', '2022-03-29 09:38:43');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_booking` bigint(20) UNSIGNED NOT NULL,
  `id_mechanic` bigint(20) UNSIGNED NOT NULL,
  `stock_used` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` int(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `otp`, `created_at`, `updated_at`) VALUES
(2, 'admin', 'erwin_esgs@yahoo.com', NULL, '$2y$10$MG26lCdGABKf4GucG5T9IOW3db7TUyu2qiI8Rb0mhpkZjsbH7OQZq', 0, '1Z66JYwmaWM5dnaZzvWL7cn6pta0kLGCkG9leSZzDNGADBTHT1VHCgri0X27', 3009, '2022-03-12 22:41:44', '2022-03-26 08:22:54'),
(3, 'mekanik', 'mekanik', NULL, '$2y$10$RlCPoCvM8yRhH306Zb3bUu4G97313f6/ZKG1nhG2kFWC49f7vzD2m', 1, 'zvEa979W9x5KnEFbGsjejkLg2CNXRfeiXKyAPEFaaMmUyH5416lVFXPrBv8E', NULL, NULL, '2022-03-20 06:51:07'),
(4, 'Mekanik2', 'mekanik2', NULL, '$2y$10$Gw/hMUhrVRYh78MFj8Nq1.EdDVClubeh8KxAYZGwsFsLt803haKgG', 1, '070CBrQVvIcTgcbJ14q9OJjOWCx37MOeyd4iAPwxgMrzk8cpBI67e7KXlNcO', NULL, '2022-03-23 08:47:20', '2022-03-23 08:47:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_booking` (`id_booking`),
  ADD KEY `id_mechanic` (`id_mechanic`);

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
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`id_mechanic`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
