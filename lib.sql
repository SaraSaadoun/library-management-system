-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2022 at 01:23 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lib`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `no` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `edition` varchar(200) DEFAULT NULL,
  `submission_date` datetime DEFAULT current_timestamp(),
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`no`, `title`, `author`, `edition`, `submission_date`, `photo`) VALUES
(3, 'AI book', 'David Peace', '1st', '2022-09-21 00:00:00', 'imgs/books/ai.png'),
(4, 'Business book', 'James Parker', '2nd', '2015-03-07 00:00:00', 'imgs/books/Business bookbus.png'),
(6, 'Flowers book', 'James Parker', '5th', '2017-02-21 00:00:00', 'imgs/books/flower.png'),
(7, 'Recipe book', 'Brian Hunt', '2nd', '2019-06-11 00:00:00', 'imgs/books/kit.png'),
(8, 'Rose book', 'Victor Holton', '2nd', '2020-01-13 00:00:00', 'imgs/books/rose.png'),
(9, 'Think book', 'Said Jacobi', '4th', '2018-08-26 00:00:00', 'imgs/books/think.png'),
(10, 'Future book', 'Henry Booth', '5th', '2019-09-30 00:00:00', 'imgs/books/future.png'),
(11, 'Tech book', 'Henry Booth', '100th', '2021-11-23 00:00:00', 'imgs/books/tech.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `admin` tinyint(4) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'undefined.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `admin`, `avatar`) VALUES
(6, 'new', 'new@new.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 'undefined.jpg'),
(7, 'islam', 'islam@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 'undefined.jpg'),
(8, 'sara', 'sara@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 'undefined.jpg'),
(11, 'admin2', 'admin@admin.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, 'sara.png'),
(12, 'sara', 'sarasara@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 'undefined.jpg'),
(14, 'new', 'new1@new.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 'undefined.jpg'),
(16, 'user333', 'userrr333@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 'undefined.jpg'),
(17, 'user4', 'user4@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 'undefined.jpg'),
(20, 'user1', 'user1@user.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 'undefined.jpg'),
(28, 'userr', 'user@user.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 'undefined.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
