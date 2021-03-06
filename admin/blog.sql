-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2017 at 05:47 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `groups` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`, `created`, `updated`, `groups`, `active`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', 'Mahmoud Hassan', 'mahmoudhassan9933@gmail.com', '2017-06-14 04:09:05', '2017-06-15 19:01:59', 0, 1),
(39, 'abdElgwad', '202cb962ac59075b964b07152d234b70', 'AbdElgwad Hassan', 'abdo@gmail.com', '2017-06-14 22:40:14', '2017-06-15 16:21:01', 0, 0),
(45, 'mahmoud556dd', '202cb962ac59075b964b07152d234b70', 'Ramadan Hassan', 'saas@gmail.com', '2017-06-14 22:50:25', '2017-06-15 16:19:28', 0, 1),
(46, 'fth', '202cb962ac59075b964b07152d234b70', 'Fatihy Ali', 'fth@gmail.com', '2017-06-14 22:53:02', '2017-06-15 16:21:11', 0, 0),
(47, 'demo', '202cb962ac59075b964b07152d234b70', 'MAHMOUD HASSAN', 'admin@links4net.net', '2017-06-15 22:39:59', '2017-06-15 20:39:59', 0, 0);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
