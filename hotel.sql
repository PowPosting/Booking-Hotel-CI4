-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 25, 2025 at 01:40 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `booking_code` varchar(20) NOT NULL,
  `user_id` int NOT NULL,
  `room_id` int NOT NULL,
  `guest_name` varchar(100) NOT NULL,
  `guest_email` varchar(100) NOT NULL,
  `guest_phone` varchar(20) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `nights` int NOT NULL,
  `guests` int NOT NULL,
  `room_price` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `special_requests` text,
  `booking_status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `payment_method` enum('qris','bank_va','cod') NOT NULL,
  `bank_code` varchar(10) DEFAULT NULL,
  `virtual_account` varchar(50) DEFAULT NULL,
  `qr_code_url` text,
  `payment_proof` text,
  `paid_at` timestamp NULL DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_code`, `user_id`, `room_id`, `guest_name`, `guest_email`, `guest_phone`, `check_in`, `check_out`, `nights`, `guests`, `room_price`, `total_amount`, `special_requests`, `booking_status`, `payment_status`, `payment_method`, `bank_code`, `virtual_account`, `qr_code_url`, `payment_proof`, `paid_at`, `expired_at`, `created_at`, `updated_at`) VALUES
(23, 'HTL2506170518', 10, 61, 'postingpow', 'postingpow@gmail.com', '08123456789', '2025-06-18', '2025-06-19', 1, 2, 800000.00, 880000.00, '', 'confirmed', 'paid', 'cod', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-17 12:10:18', '2025-06-17 12:11:06'),
(24, 'HTL2506172892', 10, 67, 'postingpow', 'postingpow@gmail.com', '08123456789', '2025-06-18', '2025-06-19', 1, 2, 800000.00, 880000.00, '', 'confirmed', 'paid', 'cod', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-17 12:51:27', '2025-06-17 12:52:24'),
(25, 'HTL2506181471', 13, 62, 'powshitposting', 'mukhamaddiva10@gmail.com', '08123456789', '2025-06-19', '2025-06-20', 1, 2, 800000.00, 880000.00, '', 'cancelled', 'refunded', 'cod', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-17 21:49:27', '2025-06-17 21:50:43'),
(26, 'HTL2506187916', 14, 62, 'test', 'test@gmail.com', '08123456789', '2025-06-19', '2025-06-20', 1, 2, 800000.00, 880000.00, '', 'cancelled', 'refunded', 'qris', NULL, NULL, 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=BOOKING%3AHTL2506187916%7CAMOUNT%3A880000', NULL, NULL, '2025-06-17 22:49:56', '2025-06-17 22:19:56', '2025-06-17 22:26:00');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `status` enum('available','occupied','maintenance') DEFAULT 'available',
  `price` decimal(12,2) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `room_type`, `status`, `price`, `description`, `created_at`, `updated_at`) VALUES
(61, 'S101', 'Kamar Standard', 'occupied', 800000.00, 'Kamar nyaman dengan fasilitas dasar untuk penginapan yang menyenangkan.', '2025-05-28 11:22:37', '2025-06-17 19:11:24'),
(62, 'S102', 'Kamar Standard', 'occupied', 800000.00, 'Kamar nyaman dengan fasilitas dasar untuk penginapan yang menyenangkan.', '2025-05-28 11:22:37', '2025-06-18 05:21:51'),
(63, 'S103', 'Kamar Standard', 'maintenance', 800000.00, 'Kamar nyaman dengan fasilitas dasar untuk penginapan yang menyenangkan.', '2025-05-28 11:22:37', '2025-06-11 01:52:36'),
(64, 'S104', 'Kamar Standard', 'available', 800000.00, 'Kamar nyaman dengan fasilitas dasar untuk penginapan yang menyenangkan.', '2025-05-28 11:22:37', '2025-06-17 18:51:59'),
(65, 'S105', 'Kamar Standard', 'available', 800000.00, 'Kamar nyaman dengan fasilitas dasar untuk penginapan yang menyenangkan.', '2025-05-28 11:22:37', '2025-06-17 18:52:10'),
(66, 'S106', 'Kamar Standard', 'available', 800000.00, 'Kamar nyaman dengan fasilitas dasar untuk penginapan yang menyenangkan.', '2025-05-28 11:22:37', '2025-06-17 18:52:18'),
(67, 'S107', 'Kamar Standard', 'occupied', 800000.00, 'Kamar nyaman dengan fasilitas dasar untuk penginapan yang menyenangkan.', '2025-05-28 11:22:37', '2025-06-17 19:52:38'),
(68, 'S108', 'Kamar Standard', 'available', 800000.00, 'Kamar nyaman dengan fasilitas dasar untuk penginapan yang menyenangkan.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(69, 'S109', 'Kamar Standard', 'available', 800000.00, 'Kamar nyaman dengan fasilitas dasar untuk penginapan yang menyenangkan.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(70, 'S110', 'Kamar Standard', 'available', 800000.00, 'Kamar nyaman dengan fasilitas dasar untuk penginapan yang menyenangkan.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(71, 'D201', 'Kamar Deluxe', 'available', 1200000.00, 'Kamar luas dengan pemandangan kota dan fasilitas lengkap.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(72, 'D202', 'Kamar Deluxe', 'available', 1200000.00, 'Kamar luas dengan pemandangan kota dan fasilitas lengkap.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(73, 'D203', 'Kamar Deluxe', 'available', 1200000.00, 'Kamar luas dengan pemandangan kota dan fasilitas lengkap.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(74, 'D204', 'Kamar Deluxe', 'available', 1200000.00, 'Kamar luas dengan pemandangan kota dan fasilitas lengkap.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(75, 'D205', 'Kamar Deluxe', 'available', 1200000.00, 'Kamar luas dengan pemandangan kota dan fasilitas lengkap.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(76, 'D206', 'Kamar Deluxe', 'available', 1200000.00, 'Kamar luas dengan pemandangan kota dan fasilitas lengkap.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(77, 'D207', 'Kamar Deluxe', 'available', 1200000.00, 'Kamar luas dengan pemandangan kota dan fasilitas lengkap.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(78, 'D208', 'Kamar Deluxe', 'available', 1200000.00, 'Kamar luas dengan pemandangan kota dan fasilitas lengkap.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(79, 'D209', 'Kamar Deluxe', 'available', 1200000.00, 'Kamar luas dengan pemandangan kota dan fasilitas lengkap.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(80, 'D210', 'Kamar Deluxe', 'available', 1200000.00, 'Kamar luas dengan pemandangan kota dan fasilitas lengkap.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(81, 'SU301', 'Suite Room', 'available', 2000000.00, 'Kamar mewah dengan ruang tamu terpisah dan fasilitas premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(82, 'SU302', 'Suite Room', 'available', 2000000.00, 'Kamar mewah dengan ruang tamu terpisah dan fasilitas premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(83, 'SU303', 'Suite Room', 'available', 2000000.00, 'Kamar mewah dengan ruang tamu terpisah dan fasilitas premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(84, 'SU304', 'Suite Room', 'available', 2000000.00, 'Kamar mewah dengan ruang tamu terpisah dan fasilitas premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(85, 'SU305', 'Suite Room', 'available', 2000000.00, 'Kamar mewah dengan ruang tamu terpisah dan fasilitas premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(86, 'SU306', 'Suite Room', 'available', 2000000.00, 'Kamar mewah dengan ruang tamu terpisah dan fasilitas premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(87, 'SU307', 'Suite Room', 'available', 2000000.00, 'Kamar mewah dengan ruang tamu terpisah dan fasilitas premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(88, 'SU308', 'Suite Room', 'available', 2000000.00, 'Kamar mewah dengan ruang tamu terpisah dan fasilitas premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(89, 'SU309', 'Suite Room', 'available', 2000000.00, 'Kamar mewah dengan ruang tamu terpisah dan fasilitas premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(90, 'SU310', 'Suite Room', 'available', 2000000.00, 'Kamar mewah dengan ruang tamu terpisah dan fasilitas premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(91, 'F401', 'Kamar Keluarga', 'available', 1800000.00, 'Kamar luas untuk keluarga dengan berbagai fasilitas untuk anak-anak.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(92, 'F402', 'Kamar Keluarga', 'available', 1800000.00, 'Kamar luas untuk keluarga dengan berbagai fasilitas untuk anak-anak.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(93, 'F403', 'Kamar Keluarga', 'available', 1800000.00, 'Kamar luas untuk keluarga dengan berbagai fasilitas untuk anak-anak.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(94, 'F404', 'Kamar Keluarga', 'available', 1800000.00, 'Kamar luas untuk keluarga dengan berbagai fasilitas untuk anak-anak.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(95, 'F405', 'Kamar Keluarga', 'available', 1800000.00, 'Kamar luas untuk keluarga dengan berbagai fasilitas untuk anak-anak.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(96, 'F406', 'Kamar Keluarga', 'available', 1800000.00, 'Kamar luas untuk keluarga dengan berbagai fasilitas untuk anak-anak.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(97, 'F407', 'Kamar Keluarga', 'available', 1800000.00, 'Kamar luas untuk keluarga dengan berbagai fasilitas untuk anak-anak.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(98, 'F408', 'Kamar Keluarga', 'available', 1800000.00, 'Kamar luas untuk keluarga dengan berbagai fasilitas untuk anak-anak.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(99, 'F409', 'Kamar Keluarga', 'available', 1800000.00, 'Kamar luas untuk keluarga dengan berbagai fasilitas untuk anak-anak.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(100, 'F410', 'Kamar Keluarga', 'available', 1800000.00, 'Kamar luas untuk keluarga dengan berbagai fasilitas untuk anak-anak.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(101, 'E501', 'Kamar Eksekutif', 'available', 1500000.00, 'Kamar eksklusif dengan akses lounge eksekutif dan layanan premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(102, 'E502', 'Kamar Eksekutif', 'available', 1500000.00, 'Kamar eksklusif dengan akses lounge eksekutif dan layanan premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(103, 'E503', 'Kamar Eksekutif', 'available', 1500000.00, 'Kamar eksklusif dengan akses lounge eksekutif dan layanan premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(104, 'E504', 'Kamar Eksekutif', 'available', 1500000.00, 'Kamar eksklusif dengan akses lounge eksekutif dan layanan premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(105, 'E505', 'Kamar Eksekutif', 'available', 1500000.00, 'Kamar eksklusif dengan akses lounge eksekutif dan layanan premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(106, 'E506', 'Kamar Eksekutif', 'available', 1500000.00, 'Kamar eksklusif dengan akses lounge eksekutif dan layanan premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(107, 'E507', 'Kamar Eksekutif', 'available', 1500000.00, 'Kamar eksklusif dengan akses lounge eksekutif dan layanan premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(108, 'E508', 'Kamar Eksekutif', 'available', 1500000.00, 'Kamar eksklusif dengan akses lounge eksekutif dan layanan premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(109, 'E509', 'Kamar Eksekutif', 'available', 1500000.00, 'Kamar eksklusif dengan akses lounge eksekutif dan layanan premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(110, 'E510', 'Kamar Eksekutif', 'available', 1500000.00, 'Kamar eksklusif dengan akses lounge eksekutif dan layanan premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(111, 'P1001', 'Penthouse', 'available', 3500000.00, 'Hunian mewah di lantai teratas dengan pemandangan panorama dan fasilitas super premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(112, 'P1002', 'Penthouse', 'available', 3500000.00, 'Hunian mewah di lantai teratas dengan pemandangan panorama dan fasilitas super premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(113, 'P1003', 'Penthouse', 'available', 3500000.00, 'Hunian mewah di lantai teratas dengan pemandangan panorama dan fasilitas super premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(114, 'P1004', 'Penthouse', 'available', 3500000.00, 'Hunian mewah di lantai teratas dengan pemandangan panorama dan fasilitas super premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(115, 'P1005', 'Penthouse', 'available', 3500000.00, 'Hunian mewah di lantai teratas dengan pemandangan panorama dan fasilitas super premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(116, 'P1006', 'Penthouse', 'available', 3500000.00, 'Hunian mewah di lantai teratas dengan pemandangan panorama dan fasilitas super premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(117, 'P1007', 'Penthouse', 'available', 3500000.00, 'Hunian mewah di lantai teratas dengan pemandangan panorama dan fasilitas super premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(118, 'P1008', 'Penthouse', 'available', 3500000.00, 'Hunian mewah di lantai teratas dengan pemandangan panorama dan fasilitas super premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37'),
(119, 'P1009', 'Penthouse', 'maintenance', 3500000.00, 'Hunian mewah di lantai teratas dengan pemandangan panorama dan fasilitas super premium.', '2025-05-28 11:22:37', '2025-06-17 18:52:31'),
(120, 'P1010', 'Penthouse', 'available', 3500000.00, 'Hunian mewah di lantai teratas dengan pemandangan panorama dan fasilitas super premium.', '2025-05-28 11:22:37', '2025-05-28 11:22:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `security_question` varchar(255) DEFAULT NULL,
  `security_answer` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `phone`, `security_question`, `security_answer`, `created_at`, `updated_at`) VALUES
(3, 'admin', 'admin', 'admin@gmail.com', '$2y$10$2Z/1T4yTtO2hYa0hZaAQkuNob/bOZXRO.1sA9Oq3iuMt5dKEhA1nK', '08111111111', NULL, NULL, '2025-05-23 12:28:43', '2025-05-23 19:28:43'),
(6, 'Revanda', 'revanda', 'revanda@gmail.com', '$2y$10$zvbnYITRPkpoQHTM7eaJGuJJhmx7WF7/2xfccjQS43URs/VEp9Ep.', NULL, NULL, NULL, '2025-05-27 21:50:16', '2025-05-28 04:50:16'),
(7, 'sandy', 'sandy', 'sandy@gmail.com', '$2y$10$B/3xoyWCZvNW94FMdeF3euDbccV2QJWCc7LcrPWecsEDE0PiMQYYy', '0812342131', NULL, NULL, '2025-05-27 21:58:57', '2025-05-28 04:58:57'),
(10, 'Diva', 'postingpow', 'postingpow@gmail.com', '$2y$10$/GeeHrtywX9GS7jx154kqetTEAm2qqpq2.dQSrONmqr7WQ8hlq8YC', '081910769679', 'pet_name', 'jony', '2025-06-07 08:09:51', '2025-06-17 19:57:38'),
(11, 'Krieg', 'krieg', 'krieg@gmail.com', '$2y$10$b3Yprny0qJ00NIqdAY5ELutjtqdDpIlwXjlcIQIF9.mTQITzKTb8K', '08192384232', 'birth_city', 'subang', '2025-06-07 12:22:19', '2025-06-07 19:22:19'),
(12, 'diva', 'diva', 'diva@gmail.com', '$2y$10$Oni/9cMv75sTtKMZw2gyNeOg4yzAiIrGu7LHo2mlGdiNHon3S4NKi', '085782222873', 'birth_city', 'subang', '2025-06-10 21:26:08', '2025-06-11 04:26:58'),
(13, 'M Diva Mahardika', 'powshitposting', 'mukhamaddiva10@gmail.com', '$2y$10$zdi1/Ny.gkirTxXEKvxDuucJiax8ZSkxs5EBaiooO6JmrVmiYZqdG', '085782222873', 'pet_name', 'kucing', '2025-06-17 11:12:00', '2025-06-18 04:47:45'),
(14, 'Test User', 'test', 'test@gmail.com', '$2y$10$AJSAstBlg9hA8N0n0jAuCOHd7LPxjFY4KmRIo6LVTTZHjYGtr/DYm', '081910769679', 'pet_name', 'landak', '2025-06-17 22:04:20', '2025-06-18 05:04:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
