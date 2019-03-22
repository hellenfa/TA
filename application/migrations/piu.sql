-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2018 at 05:11 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `piu`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_document`
--

CREATE TABLE `access_document` (
  `id_access_doc` int(11) NOT NULL,
  `id_doc` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `download_permission` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `access_logbook`
--

CREATE TABLE `access_logbook` (
  `id_access_lb` int(11) NOT NULL,
  `id_logbook` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id_activity` int(11) NOT NULL,
  `activity_name` varchar(191) NOT NULL,
  `create_date` datetime NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

CREATE TABLE `attachment` (
  `id_attach` int(11) NOT NULL,
  `attach_name` int(11) NOT NULL,
  `id_logbook` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id_doc` int(11) NOT NULL,
  `doc_name` varchar(191) NOT NULL,
  `upload_date` datetime NOT NULL,
  `id_folder` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_subactivity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `folder`
--

CREATE TABLE `folder` (
  `id_folder` int(11) NOT NULL,
  `folder_name` varchar(191) NOT NULL,
  `create_date` datetime NOT NULL,
  `parent` varchar(191) NOT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `folder`
--

INSERT INTO `folder` (`id_folder`, `folder_name`, `create_date`, `parent`, `id_user`) VALUES
(2, 'folder 1', '2018-12-08 00:00:00', '0', NULL),
(3, 'dokumentasi', '2018-12-11 00:00:00', '0', NULL),
(4, 'administrasi', '2018-12-09 00:00:00', '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logbook`
--

CREATE TABLE `logbook` (
  `id_logbook` int(11) NOT NULL,
  `logbook_name` varchar(191) NOT NULL,
  `id_user` int(11) NOT NULL,
  `access_date` datetime NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subactivity`
--

CREATE TABLE `subactivity` (
  `id_subactivity` int(11) NOT NULL,
  `subactivity_name` varchar(191) NOT NULL,
  `plan_start` date NOT NULL,
  `plan_finish` date NOT NULL,
  `actual_start` date NOT NULL,
  `actual_finish` date NOT NULL,
  `status` varchar(191) NOT NULL,
  `create_date` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `type` varchar(191) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `type`, `username`, `password`, `email`) VALUES
(1, 'staff', 'keuangan1', '123', 'keuangan@mail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_document`
--
ALTER TABLE `access_document`
  ADD PRIMARY KEY (`id_access_doc`);

--
-- Indexes for table `access_logbook`
--
ALTER TABLE `access_logbook`
  ADD PRIMARY KEY (`id_access_lb`);

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id_activity`);

--
-- Indexes for table `attachment`
--
ALTER TABLE `attachment`
  ADD PRIMARY KEY (`id_attach`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id_doc`);

--
-- Indexes for table `folder`
--
ALTER TABLE `folder`
  ADD PRIMARY KEY (`id_folder`);

--
-- Indexes for table `logbook`
--
ALTER TABLE `logbook`
  ADD PRIMARY KEY (`id_logbook`);

--
-- Indexes for table `subactivity`
--
ALTER TABLE `subactivity`
  ADD PRIMARY KEY (`id_subactivity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_document`
--
ALTER TABLE `access_document`
  MODIFY `id_access_doc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `access_logbook`
--
ALTER TABLE `access_logbook`
  MODIFY `id_access_lb` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id_activity` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attachment`
--
ALTER TABLE `attachment`
  MODIFY `id_attach` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id_doc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `folder`
--
ALTER TABLE `folder`
  MODIFY `id_folder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `logbook`
--
ALTER TABLE `logbook`
  MODIFY `id_logbook` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subactivity`
--
ALTER TABLE `subactivity`
  MODIFY `id_subactivity` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
