-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 18, 2018 at 10:36 PM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webmob-blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `avatars`
--

CREATE TABLE `avatars` (
  `id` int(11) NOT NULL,
  `path` varchar(80) NOT NULL,
  `type` set('male','female','other','') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `col` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `avatars`
--

INSERT INTO `avatars` (`id`, `path`, `type`, `created_at`, `updated_at`, `col`) VALUES
(1, '/images/avatars/avatar-1.png', 'male', '2018-07-03 07:13:32', '2018-07-03 07:13:32', 0),
(2, '/images/avatars/avatar-2.png', 'male', '2018-07-03 07:14:21', '2018-07-03 07:14:21', 0),
(3, '/images/avatars/avatar-3.png', 'male', '2018-07-03 07:14:31', '2018-07-03 07:14:31', 0),
(4, '/images/avatars/avatar-4.png', 'male', '2018-07-03 07:14:38', '2018-07-03 07:14:38', 0),
(5, '/images/avatars/avatar-5.png', 'male', '2018-07-03 07:14:46', '2018-07-03 07:14:46', 0),
(6, '/images/avatars/avatar-6.png', 'male', '2018-07-03 07:14:55', '2018-07-03 07:14:55', 0),
(7, '/images/avatars/avatar-7.png', 'male', '2018-07-03 07:15:04', '2018-07-03 07:15:04', 0),
(8, '/images/avatars/avatar-8.png', 'male', '2018-07-03 07:15:12', '2018-07-03 07:15:12', 0),
(9, '/images/avatars/avatar-9.png', 'male', '2018-07-03 07:15:20', '2018-07-03 07:15:20', 0),
(10, '/images/avatars/avatar-10.png', 'male', '2018-07-03 07:15:32', '2018-07-03 07:15:32', 0),
(11, '/images/avatars/avatar-11.png', 'male', '2018-07-03 07:15:41', '2018-07-03 07:15:41', 0),
(12, '/images/avatars/avatar-12.png', 'male', '2018-07-03 07:15:49', '2018-07-03 07:15:49', 0),
(13, '/images/avatars/avatar-13.png', 'male', '2018-07-03 07:15:59', '2018-07-03 07:15:59', 0),
(14, '/images/avatars/avatar-14.png', 'female', '2018-07-03 07:16:15', '2018-07-03 07:16:15', 0),
(15, '/images/avatars/avatar-15.png', 'female', '2018-07-03 07:16:53', '2018-07-03 07:16:53', 0),
(16, '/images/avatars/avatar-16.png', 'female', '2018-07-03 07:17:05', '2018-07-03 07:17:05', 0),
(17, '/images/avatars/avatar-17.png', 'other', '2018-07-03 07:17:13', '2018-07-03 07:17:13', 0),
(18, '/images/avatars/avatar-18.png', 'female', '2018-07-03 07:17:20', '2018-07-03 07:17:20', 0),
(19, '/images/avatars/avatar-19.png', 'female', '2018-07-03 07:17:28', '2018-07-03 07:17:28', 0),
(20, '/images/avatars/avatar-20.png', 'female', '2018-07-03 07:17:36', '2018-07-03 07:17:36', 0),
(21, '/images/avatars/avatar-21.png', 'female', '2018-07-03 07:17:44', '2018-07-03 07:17:44', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Core Java', '2018-07-17 18:30:00', '2018-07-17 18:30:00'),
(2, 'Core Php', NULL, '2018-07-17 18:30:00'),
(3, 'Laravel', '2018-07-17 18:30:00', '2018-07-17 18:30:00'),
(4, 'JavaScript', '2018-07-17 18:30:00', '2018-07-17 18:30:00'),
(5, 'Vue JS', '2018-07-17 18:30:00', '2018-07-17 18:30:00'),
(6, 'MySQL', '2018-07-17 18:30:00', '2018-07-17 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `email`, `name`, `comment`, `created_at`, `updated_at`) VALUES
(13, 20, 'karan@gmail.com', 'Karan', 'Wow it is amazing.', '2018-07-18 08:52:54', '2018-07-18 08:52:54');

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
(17, '2014_10_12_000000_create_users_table', 1),
(18, '2014_10_12_100000_create_password_resets_table', 1),
(20, '2018_07_17_063637_create_categories_table', 2),
(28, '2018_07_17_074527_create_posts_table', 3),
(29, '2018_07_17_074552_create_comments_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `heading` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seen` int(11) NOT NULL DEFAULT '0',
  `comments` int(11) NOT NULL DEFAULT '0',
  `likes` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `can_comment` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `heading`, `category_id`, `user_id`, `description`, `seen`, `comments`, `likes`, `status`, `can_comment`, `created_at`, `updated_at`) VALUES
(17, 'What is Java ?', 1, 12, 'Java is a programming language and computing platform first released by Sun Microsystems in 1995. There are lots of applications and websites that will not work unless you have Java installed, and more are created every day. Java is fast, secure, and reliable. From laptops to datacenters, game consoles to scientific supercomputers, cell phones to the Internet, Java is everywhere!', 4, 0, 0, 1, 1, '2018-07-18 08:42:03', '2018-07-18 10:07:09'),
(18, 'What is JVM ?', 1, 12, 'A Java virtual machine (JVM), an implementation of the Java Virtual Machine Specification, interprets compiled Java binary code (called bytecode) for a computer\'s processor (or "hardware platform") so that it can perform a Java program\'s instructions. Java was designed to allow application programs to be built that could be run on any platform without having to be rewritten or recompiled by the programmer for each separate platform. A Java virtual machine makes this possible because it is aware of the specific instruction lengths and other particularities of the platform.', 3, 0, 0, 1, 1, '2018-07-18 08:44:01', '2018-07-18 09:06:10'),
(19, 'What is type casting in Java ?', 1, 12, 'Type casting in Java is to cast one type, a class or interface, into another type i.e. another class or interface. Since Java is an Object oriented programming language and supports both Inheritance and Polymorphism, It’s easy that Super class reference variable is pointing to SubClass object but the catch here is that there is no way for Java compiler to know that a Superclass variable is pointing to SubClass object. Which means you can not call a method which is declared in the subclass. In order to do that, you first need to cast the Object back into its original type. This is called type casting in Java. You can type cast both primitive and reference type in Java. The concept of casting will be clearer when you will see an example of type casting in next section.', 4, 0, 0, 1, 0, '2018-07-18 08:48:22', '2018-07-18 10:08:58'),
(20, 'What is Php ?', 2, 12, 'PHP stands for Hypertext Preprocessor. PHP is a powerful and widely-used open source server-side scripting language to write dynamically generated web pages. PHP scripts are executed on the server and the result is sent to the browser as plain HTML.\n\nPHP can be integrated with the number of popular databases, including MySQL, PostgreSQL, Oracle, Sybase, Informix, and Microsoft SQL Server.\n\nPHP can be embedded within a normal HTML web pages. That means inside your HTML documents you\'ll have PHP statements.', 4, 1, 0, 1, 1, '2018-07-18 08:50:54', '2018-07-18 08:54:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_activated` tinyint(1) NOT NULL DEFAULT '0',
  `image_path` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activation_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `gender`, `email`, `is_activated`, `image_path`, `activation_token`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(12, 'Ramesh', 'Kumar', 'male', 'rameshgodara80@gmail.com', 1, '/images/avatars/avatar-8.png', 'vgdX0SpMxzohKndl8PicbX4qV', '$2y$10$.3JWS0grt19Fv1k7MDnYE.g4MU8/MPeMKY1KTbJYFZJyJwPr.aghW', 'oKtTRRcw1QIncd9ARNTsiG73n5skucCO0e99GVzb7NwarYZkvevb77G4Wi4G', '2018-07-18 08:20:45', '2018-07-18 08:20:45'),
(17, 'Ramesh', 'Godara', 'male', 'inforameshgodara351@gmail.com', 1, '/images/avatars/avatar-2.png', '', '$2y$10$4trkTWZH.HheZ3qddQrUCO29TQ/yAs0KWS8VtHKB9uGKXGBt2yj2q', 'TJ1tYu63jHUVa4JvN3KOi6zUwU1iWZyKJZCiwW8PCvv1OjMWH7mToEgrOSgb', '2018-07-18 09:56:08', '2018-07-18 09:56:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avatars`
--
ALTER TABLE `avatars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_post_id_foreign` (`post_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_category_id_foreign` (`category_id`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

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
-- AUTO_INCREMENT for table `avatars`
--
ALTER TABLE `avatars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
