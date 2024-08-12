-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 12, 2024 at 01:13 AM
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
-- Database: `perpustakaan_digital`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int NOT NULL,
  `id_user` int NOT NULL,
  `cover` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `id_kategori` int NOT NULL,
  `jumlah` int NOT NULL,
  `deskripsi` text NOT NULL,
  `file_buku` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `id_user`, `cover`, `judul`, `id_kategori`, `jumlah`, `deskripsi`, `file_buku`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, '1723399025_1d97b7b34474c5e66aa4.jpg', 'Berserk (edited)', 6, 34, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1723399025_54c574f2e1bfd35094ad.pdf', '2024-08-11 17:57:05', '2024-08-11 13:02:07', NULL),
(2, 1, '1723399079_0377250a1773250ab225.jpg', 'Harry Potter', 3, 543, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', '1723399079_e130a7cb88cd4cb32595.pdf', '2024-08-11 17:57:59', '2024-08-11 10:57:59', NULL),
(3, 2, '1723399658_ffc6a1f74400eb3eaea7.jpg', 'A Brief History of Time', 7, 234, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', '1723399658_99b9ffcc622cf7e8c726.pdf', '2024-08-11 18:07:38', '2024-08-11 11:07:38', NULL),
(4, 2, '1723405864_b675e904cc2f96ae6cf2.jpg', 'Atomic Habits', 8, 342, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1723405864_a42db54306a830e0b86d.pdf', '2024-08-11 19:51:04', '2024-08-11 12:51:04', NULL),
(5, 2, '1723406629_40c3bba4d564416e7c14.jpg', 'test', 6, 3234, 'rwerwer', '1723406629_e0b21cbc47004bc61bfb.pdf', '2024-08-11 20:03:49', '2024-08-11 13:03:56', '2024-08-11 13:03:56'),
(6, 2, '1723423640_125cca585aefc3ec32be.jpg', 'Jujutsu Kaisen', 6, 213, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', '1723423640_936d73cffc4886298df5.pdf', '2024-08-12 00:47:20', '2024-08-11 17:47:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `id_user` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `id_user`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 1, 'Fiksi', '2024-08-11 17:34:09', '2024-08-11 10:35:51', NULL),
(4, 1, 'Manga', '2024-08-11 17:34:18', '2024-08-11 10:34:18', NULL),
(5, 1, 'Manhwa', '2024-08-11 17:36:03', '2024-08-11 10:36:03', NULL),
(6, 2, 'Manga', '2024-08-11 17:56:38', '2024-08-11 10:56:38', NULL),
(7, 2, 'Non-fiksi', '2024-08-11 18:07:01', '2024-08-11 11:07:01', NULL),
(8, 2, 'Productivity', '2024-08-11 19:47:57', '2024-08-11 17:32:58', NULL),
(9, 2, 'test', '2024-08-11 20:04:14', '2024-08-11 13:04:17', '2024-08-11 13:04:17'),
(10, 1, 'Ilmiah', '2024-08-11 20:13:28', '2024-08-12 01:08:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(512) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `email`, `username`, `password`, `role`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin@gmail.com', 'admin', '$2y$10$5ppZYQyiu12s341WKfwNv.YptFIptoqD3naD9hVwx3VuJAWxFyrzC', 'admin', '2024-08-11 05:58:46', '2024-08-10 22:58:46', NULL),
(2, 'testing@gmail.com', 'Edward', '$2y$10$jygdnz5r9JU2Pz3HBup6Xu6XG9h/23189PsCXfLN/EpypwSFwkMkS', 'user', '2024-08-11 13:52:54', '2024-08-11 06:52:54', NULL),
(3, 'waduh@gmail.com', 'Testing', '$2y$10$yYhEIcyFRQAqC.DaunUv5e3lvkZAkiDqyRSQrfCUh1yJ4iS7SjFAm', 'user', '2024-08-12 00:27:41', '2024-08-11 17:30:30', '2024-08-11 17:30:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `idx_judul` (`judul`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD KEY `idx_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `kategori`
--
ALTER TABLE `kategori`
  ADD CONSTRAINT `kategori_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
