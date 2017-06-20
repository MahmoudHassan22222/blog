-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2017 at 06:53 PM
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
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `descr` text NOT NULL,
  `art_user` int(11) NOT NULL,
  `art_cat` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `imgs` varchar(150) NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `name`, `descr`, `art_user`, `art_cat`, `active`, `imgs`, `created`, `updated`) VALUES
(1, 'How buying from internet', 'ssssssssssssssss', 39, 2, 0, '80503_p4.jpg', '2017-06-19 20:22:23', '2017-06-19 18:22:23');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `catname` varchar(50) NOT NULL,
  `catdesc` varchar(75) NOT NULL,
  `catstatus` int(11) NOT NULL DEFAULT '0',
  `cat_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `catname`, `catdesc`, `catstatus`, `cat_user`) VALUES
(2, 'Computer', 'PC, Laptop', 1, 0),
(3, 'Internet', 'Websites, Last news and updates', 1, 0);

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
  `active` int(11) NOT NULL DEFAULT '0',
  `user_concat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`, `created`, `updated`, `groups`, `active`, `user_concat`) VALUES
(39, 'abdElgwad', '202cb962ac59075b964b07152d234b70', 'AbdElgwad Hassan', 'abdo@gmail.com', '2017-06-14 22:40:14', '2017-06-17 19:34:59', 0, 1, 0),
(45, 'mahmoud556d', '202cb962ac59075b964b07152d234b70', 'Ramadan Hassan', 'ramadan@gmail.com', '2017-06-14 22:50:25', '2017-06-16 20:25:36', 0, 1, 0),
(46, 'fth', '202cb962ac59075b964b07152d234b70', 'Fatihy Ali', 'fth@gmail.com', '2017-06-14 22:53:02', '2017-06-16 20:16:40', 0, 0, 0),
(47, 'demo', '202cb962ac59075b964b07152d234b70', 'MAHMOUD HASSAN', 'admin@links4net.net', '2017-06-15 22:39:59', '2017-06-15 20:39:59', 0, 0, 0),
(52, 'rmdnhsn', '202cb962ac59075b964b07152d234b70', 'Ramadan', 'mh@m.com', '2017-06-16 21:25:32', '2017-06-17 21:16:06', 0, 1, 0),
(54, 'admin', '202cb962ac59075b964b07152d234b70', 'MAHMOUD HASSAN', 'm@m.net', '2017-06-17 22:04:03', '2017-06-17 20:11:59', 1, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `con_users` (`art_user`),
  ADD KEY `con_cats` (`art_cat`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `con_users` (`cat_user`);

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
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `con_cats` FOREIGN KEY (`art_cat`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `con_users` FOREIGN KEY (`art_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
