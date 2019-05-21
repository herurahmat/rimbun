-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2019 at 02:38 AM
-- Server version: 5.7.14-log
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rimbundb`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `ID` int(11) NOT NULL,
  `menu_code` varchar(20) NOT NULL,
  `menu_title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menu_access`
--

CREATE TABLE `menu_access` (
  `ID` bigint(20) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `menu_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menu_detail`
--

CREATE TABLE `menu_detail` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `menu_id` int(11) NOT NULL,
  `menu_title` varchar(50) NOT NULL,
  `icon` varchar(40) NOT NULL,
  `s1` varchar(20) NOT NULL,
  `s2` varchar(20) DEFAULT NULL,
  `s3` varchar(20) DEFAULT NULL,
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `url` varchar(50) DEFAULT NULL,
  `menu_parent` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `ID` int(11) NOT NULL,
  `meta_key` varchar(50) NOT NULL,
  `meta_value` text,
  `is_sistem` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`ID`, `meta_key`, `meta_value`, `is_sistem`) VALUES
(1, 'app_theme', 'adminlte', 1),
(2, 'rb_logo', 'logo.png', 1),
(3, 'rb_favicon', 'favicon.png', 1),
(4, 'app_name', 'TEST PROJECT', 1),
(5, 'app_version', 'BETA2', 1),
(6, 'app_year', '2019', 1),
(7, 'app_footer_custom', '', 1),
(8, 'company_name', 'Contoh Perusahaan', 1),
(9, 'company_address', '-', 1),
(10, 'company_phone', '-', 1),
(11, 'company_email', '-', 1),
(12, 'company_fax', '-', 1),
(13, 'company_web', '-', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_token` varchar(40) NOT NULL,
  `user_role_id` int(11) DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(60) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `nick_name` varchar(20) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `user_token`, `user_role_id`, `username`, `password`, `email`, `full_name`, `nick_name`, `avatar`, `status`) VALUES
(1, '7YebsuCKDS', 1, 'super', '$2a$08$8K2RmcdEqK2gcn7SGJtuveX6oBJhwr3YJp4EbyZTENh3lhNfcUq4y', 'adminsuper@gmail.com', 'Super Administrator', 'admin', 'ava-c4ca4238a0b923820dcc509a6f75849b.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `time` int(11) NOT NULL,
  `message` text NOT NULL,
  `log_data` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`ID`, `user_id`, `time`, `message`, `log_data`) VALUES
(1, 1, 1555762557, 'Role has been Deleted', '{\"user_id\":\"1\",\"tanggal\":\"19:15:57\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(2, 1, 1555762581, 'Role has been Deleted', '{\"user_id\":\"1\",\"tanggal\":\"19:16:21\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(3, 1, 1555762626, 'Role has been Deleted', '{\"user_id\":\"1\",\"tanggal\":\"19:17:06\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(4, 1, 1555762650, 'Role has been Deleted', '{\"user_id\":\"1\",\"tanggal\":\"19:17:30\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(5, 1, 1555762680, 'Role has been Deleted', '{\"user_id\":\"1\",\"tanggal\":\"19:18:00\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(6, 1, 1555763340, 'Role has been Deleted', '{\"user_id\":\"1\",\"tanggal\":\"19:29:00\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(7, 1, 1555764230, 'Failed delete Meta role', '{\"user_id\":\"1\",\"tanggal\":\"19:43:50\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(8, 1, 1555764259, 'Meta Role has been Deleted', '{\"user_id\":\"1\",\"tanggal\":\"19:44:19\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(9, 1, 1555764261, 'Meta Role has been Deleted', '{\"user_id\":\"1\",\"tanggal\":\"19:44:21\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(10, 1, 1555764507, 'Meta Role has been Deleted', '{\"user_id\":\"1\",\"tanggal\":\"19:48:27\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(11, 1, 1555764950, 'Role has been Deleted', '{\"user_id\":\"1\",\"tanggal\":\"19:55:50\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(12, 1, 1555768189, 'Gagal mengubah user. Username dan Email sudah ada', '{\"user_id\":\"1\",\"tanggal\":\"20:49:49\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(13, 1, 1555768527, 'Berhasil mengubah user Heru Rahmat Akhnuari', '{\"user_id\":\"1\",\"tanggal\":\"20:55:27\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(14, 1, 1555768534, 'Berhasil mengubah user Heru Rahmat Akhnuari', '{\"user_id\":\"1\",\"tanggal\":\"20:55:34\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(15, 1, 1555768646, 'Failed delete user', '{\"user_id\":\"1\",\"tanggal\":\"20:57:26\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(16, 1, 1555768651, 'User has beed deleted', '{\"user_id\":\"1\",\"tanggal\":\"20:57:31\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(17, 1, 1555771489, 'Role has been Deleted', '{\"user_id\":\"1\",\"tanggal\":\"21:44:49\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(18, 1, 1555771544, 'Berhasil menambahkan user Operator', '{\"user_id\":\"1\",\"tanggal\":\"21:45:44\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/73.0.3683.103 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(19, 1, 1556822168, 'Successed Add Config Item', '{\"user_id\":\"1\",\"tanggal\":\"01:36:08\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/74.0.3729.131 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(20, 1, 1556822237, 'Successed remove Config Item', '{\"user_id\":\"1\",\"tanggal\":\"01:37:17\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/74.0.3729.131 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(21, 1, 1556822241, 'Successed Add Config Item', '{\"user_id\":\"1\",\"tanggal\":\"01:37:21\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/74.0.3729.131 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(22, 1, 1556822538, 'Successed Change Config Item', '{\"user_id\":\"1\",\"tanggal\":\"01:42:18\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/74.0.3729.131 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(23, 1, 1556822543, 'Successed Change Config Item', '{\"user_id\":\"1\",\"tanggal\":\"01:42:23\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/74.0.3729.131 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(24, 1, 1556822547, 'Successed remove Config Item', '{\"user_id\":\"1\",\"tanggal\":\"01:42:27\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/74.0.3729.131 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(25, 1, 1557605055, 'Berhasil menambahkan user Operator', '{\"user_id\":\"1\",\"tanggal\":\"03:04:15\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/74.0.3729.131 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(26, 1, 1557816836, 'Role has been Deleted', '{\"user_id\":\"1\",\"tanggal\":\"13:53:56\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/74.0.3729.131 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}'),
(27, 1, 1557816855, 'Berhasil menambahkan user Customer Service', '{\"user_id\":\"1\",\"tanggal\":\"13:54:15\",\"ip\":\"::1\",\"agen\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/74.0.3729.131 Safari\\/537.36\",\"host\":\"HADES-LAPTOP\"}');

-- --------------------------------------------------------

--
-- Table structure for table `user_meta`
--

CREATE TABLE `user_meta` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `meta_key` varchar(50) NOT NULL,
  `meta_value` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `ID` int(11) NOT NULL,
  `role_key` varchar(20) NOT NULL,
  `role_value` varchar(50) NOT NULL,
  `is_enable` tinyint(1) NOT NULL DEFAULT '1',
  `is_add` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`ID`, `role_key`, `role_value`, `is_enable`, `is_add`) VALUES
(1, 'admin', 'Super Administrator', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_role_meta`
--

CREATE TABLE `user_role_meta` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `meta_key` varchar(50) NOT NULL,
  `meta_value` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `menu_access`
--
ALTER TABLE `menu_access`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_role_id` (`user_role_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `menu_detail`
--
ALTER TABLE `menu_detail`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `menu_parent` (`menu_parent`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `meta_key` (`meta_key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_role_id` (`user_role_id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_meta`
--
ALTER TABLE `user_meta`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_key` (`meta_key`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `role_key` (`role_key`);

--
-- Indexes for table `user_role_meta`
--
ALTER TABLE `user_role_meta`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_role_id` (`user_role_id`),
  ADD KEY `meta_key` (`meta_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_access`
--
ALTER TABLE `menu_access`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_detail`
--
ALTER TABLE `menu_detail`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user_meta`
--
ALTER TABLE `user_meta`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_role_meta`
--
ALTER TABLE `user_role_meta`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
