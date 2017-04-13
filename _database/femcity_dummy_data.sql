-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2017 at 06:13 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `femcity`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_requests`
--

CREATE TABLE `account_requests` (
  `request_id` int(255) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `business_name` varchar(256) NOT NULL,
  `business_description` text COMMENT 'Description of what the business does',
  `cat_id` int(255) UNSIGNED NOT NULL COMMENT 'Category id',
  `email` varchar(256) NOT NULL,
  `phone` varchar(20) DEFAULT NULL COMMENT 'Phone number of the admin',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `subbed` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'If the account request is subscribed to the email newsletter'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_accounts`
--

CREATE TABLE `admin_accounts` (
  `acc_id` int(255) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `business_name` varchar(256) NOT NULL,
  `business_description` text COMMENT 'Description of what the business does',
  `logo` varchar(512) NOT NULL COMMENT 'Company logo',
  `cat_id` int(255) UNSIGNED NOT NULL COMMENT 'Category id',
  `email` varchar(256) NOT NULL,
  `phone` varchar(20) DEFAULT NULL COMMENT 'Phone number of the admin',
  `password` varchar(512) NOT NULL,
  `subbed` tinyint(1) NOT NULL DEFAULT '1',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_activated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_expires` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_banned` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'True if the account is banned and false if it is not. Only accounts that have not been banned can log in'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_accounts`
--

INSERT INTO `admin_accounts` (`acc_id`, `first_name`, `last_name`, `business_name`, `business_description`, `logo`, `cat_id`, `email`, `phone`, `password`, `subbed`, `date_created`, `date_activated`, `date_expires`, `is_banned`) VALUES
(2, 'Allan', 'Jeremy', 'Allan''s business', '', '', 7, 'allan@jeremy.com', NULL, '$2y$10$cal7ij8DL91xVbQBAKaWpe.WQyIIQJco0sGb4e6w78R4fyOKIOIe2', 1, '2017-04-07 15:40:12', '2017-04-07 15:40:12', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(255) UNSIGNED NOT NULL,
  `cat_name` varchar(256) NOT NULL,
  `cat_description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Categories for the various business types';

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_description`) VALUES
(2, 'Salons', ''),
(3, 'Nail Bars', NULL),
(4, 'Cosmetics', NULL),
(5, 'African Print and Ankara', NULL),
(6, 'Household items', NULL),
(7, 'Interiors', NULL),
(8, 'Clothing', NULL),
(9, 'Bags', NULL),
(10, 'Shoes', NULL),
(11, 'Anything', '');

-- --------------------------------------------------------

--
-- Table structure for table `featured_items`
--

CREATE TABLE `featured_items` (
  `feature_id` int(255) UNSIGNED NOT NULL COMMENT 'Featured item id',
  `item_id` int(255) UNSIGNED NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains the items featured in the home page';

--
-- Dumping data for table `featured_items`
--

INSERT INTO `featured_items` (`feature_id`, `item_id`, `description`) VALUES
(2, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(255) UNSIGNED NOT NULL,
  `item_name` varchar(256) NOT NULL,
  `type` enum('service','product','','') NOT NULL DEFAULT 'service',
  `description` text,
  `price` int(255) UNSIGNED NOT NULL DEFAULT '10',
  `quantity` int(10) DEFAULT '1',
  `discount` int(255) UNSIGNED NOT NULL DEFAULT '0',
  `acc_id` int(255) UNSIGNED NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Products or services provided by business owners';

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `type`, `description`, `price`, `quantity`, `discount`, `acc_id`, `date_added`) VALUES
(1, 'some random item', 'service', 'random description', 10, 1, 0, 2, '2017-04-07 15:27:24'),
(2, 'Special service', 'service', 'A test service', 10, 1, 0, 2, '2017-04-07 15:27:24'),
(3, 'Another random', 'service', 'random description', 10, 1, 0, 2, '2017-04-07 15:27:24'),
(4, 'just a test item', 'service', 'A test service', 10, 1, 0, 2, '2017-04-07 15:27:24');

-- --------------------------------------------------------

--
-- Table structure for table `item_images`
--

CREATE TABLE `item_images` (
  `img_id` int(255) UNSIGNED NOT NULL,
  `img_path` varchar(512) NOT NULL,
  `img_name` varchar(512) NOT NULL,
  `img_type` varchar(512) NOT NULL,
  `item_id` int(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Stores the list of the images that have been uploaded to db';

--
-- Dumping data for table `item_images`
--

INSERT INTO `item_images` (`img_id`, `img_path`, `img_name`, `img_type`, `item_id`) VALUES
(1, 'uploads/product7.jpg', 'Random image', 'img/jpeg', 1),
(2, 'uploads/product8.jpg', 'Random image', 'img/jpeg', 1),
(3, 'uploads/product9.jpg', 'Random image', 'img/jpeg', 2),
(4, 'uploads/product10.jpg', 'Random image', 'img/jpeg', 2),
(5, 'uploads/product9.jpg', 'Random image', 'img/jpeg', 3),
(6, 'uploads/product10.jpg', 'Random image', 'img/jpeg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `offer_id` int(255) NOT NULL,
  `offer_text` varchar(512) NOT NULL,
  `description` text,
  `cat_id` int(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains promotions currently being displayed on banners';

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`offer_id`, `offer_text`, `description`, `cat_id`) VALUES
(3, 'Sample offer', '', 2),
(4, 'Get 10% off on something', '', 2),
(5, 'Get your hair done 20% off', 'My company is offering you this unbelievable deal valid for the next 24 hours', 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_messages`
--

CREATE TABLE `product_messages` (
  `msg_id` int(255) UNSIGNED NOT NULL,
  `item_id` int(255) UNSIGNED NOT NULL,
  `message_text` text NOT NULL,
  `sender_name` varchar(256) NOT NULL COMMENT 'name of the sender',
  `sender_contact` varchar(256) NOT NULL COMMENT 'a means to contact the sender. email, phone etc.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `superuser_accounts`
--

CREATE TABLE `superuser_accounts` (
  `acc_id` int(255) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(512) NOT NULL,
  `subbed` tinyint(1) NOT NULL DEFAULT '1',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_requests`
--
ALTER TABLE `account_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD PRIMARY KEY (`acc_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `featured_items`
--
ALTER TABLE `featured_items`
  ADD PRIMARY KEY (`feature_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `item_images`
--
ALTER TABLE `item_images`
  ADD PRIMARY KEY (`img_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`offer_id`),
  ADD KEY `item_id` (`cat_id`);

--
-- Indexes for table `product_messages`
--
ALTER TABLE `product_messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `superuser_accounts`
--
ALTER TABLE `superuser_accounts`
  ADD PRIMARY KEY (`acc_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_requests`
--
ALTER TABLE `account_requests`
  MODIFY `request_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  MODIFY `acc_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `featured_items`
--
ALTER TABLE `featured_items`
  MODIFY `feature_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Featured item id', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `item_images`
--
ALTER TABLE `item_images`
  MODIFY `img_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `offer_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `product_messages`
--
ALTER TABLE `product_messages`
  MODIFY `msg_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `superuser_accounts`
--
ALTER TABLE `superuser_accounts`
  MODIFY `acc_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_requests`
--
ALTER TABLE `account_requests`
  ADD CONSTRAINT `fk_acc_requests_categories` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`);

--
-- Constraints for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD CONSTRAINT `fk_admin_acc_category` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`);

--
-- Constraints for table `featured_items`
--
ALTER TABLE `featured_items`
  ADD CONSTRAINT `fk_featured_id` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `item_images`
--
ALTER TABLE `item_images`
  ADD CONSTRAINT `fk_item_images` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `fk_promo_item_id` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
