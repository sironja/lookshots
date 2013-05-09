-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 09, 2013 at 03:37 AM
-- Server version: 5.0.96-community
-- PHP Version: 5.3.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lookshot_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE IF NOT EXISTS `brand` (
  `id` int(11) NOT NULL auto_increment,
  `brand_name` varchar(100) NOT NULL,
  `brand_photo` varchar(250) NOT NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  `deleted` tinyint(1) NOT NULL default '0',
  `brand_created_time` datetime NOT NULL,
  `brand_updated_time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand_name`, `brand_photo`, `is_active`, `deleted`, `brand_created_time`, `brand_updated_time`) VALUES
(17, 'Tiffany & Co. ', '/images/brand/1366204162.jpg', 1, 0, '2013-04-17 09:09:22', '2013-04-17 09:09:22'),
(18, 'Mac Cosmetic ', '/images/brand/ExampleLogo.jpg', 1, 0, '2013-04-17 21:22:12', '2013-04-17 21:22:12'),
(19, 'Bath & Body Works', '/images/brand/Bath-and-Body-WOrks1.jpg', 1, 0, '2013-04-18 00:57:24', '2013-04-18 00:57:24'),
(20, 'J Crew', '/images/brand/normal_Liya_Kebede_JCrew_April_SP09_2.jpg', 1, 0, '2013-04-23 06:09:43', '2013-04-23 06:09:43'),
(21, 'dolce and gabbana ', '/images/brand/Dolce-and-Gabbana-Spring-Summer-2011-Preview-2.jpg', 1, 0, '2013-04-29 11:22:29', '2013-04-29 11:22:29'),
(22, 'anonymous_brand', '/images/brand/default_brand_photo.jpg', 1, 0, '2013-05-08 13:09:17', '2013-05-08 13:09:17');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL auto_increment,
  `comment_on` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_by` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  `deleted` int(11) NOT NULL default '0',
  `comment_created_time` datetime NOT NULL,
  `comment_updated_time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment_on`, `comment_text`, `comment_by`, `is_active`, `deleted`, `comment_created_time`, `comment_updated_time`) VALUES
(30, 32, 'This #dog is my style', 47, 1, 0, '2013-05-06 07:10:31', '2013-05-06 07:10:31');

-- --------------------------------------------------------

--
-- Table structure for table `flag_media`
--

CREATE TABLE IF NOT EXISTS `flag_media` (
  `id` int(11) NOT NULL auto_increment,
  `media_id` int(11) NOT NULL,
  `flag_user_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL default '1',
  `deleted` int(11) NOT NULL default '0',
  `created_time` datetime NOT NULL,
  `reason` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE IF NOT EXISTS `follow` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `following` int(11) NOT NULL,
  `is_active` int(11) NOT NULL default '1',
  `deleted` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`id`, `user_id`, `following`, `is_active`, `deleted`) VALUES
(7, 47, 50, 1, 0),
(10, 47, 51, 0, 0),
(9, 50, 51, 1, 0),
(12, 51, 50, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Hash_tags`
--

CREATE TABLE IF NOT EXISTS `Hash_tags` (
  `hash_tags_id` int(11) NOT NULL auto_increment,
  `comment_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash_tags` varchar(50) NOT NULL,
  `is_active` int(11) NOT NULL default '1',
  `deleted` int(11) NOT NULL default '0',
  PRIMARY KEY  (`hash_tags_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `Hash_tags`
--

INSERT INTO `Hash_tags` (`hash_tags_id`, `comment_id`, `media_id`, `user_id`, `hash_tags`, `is_active`, `deleted`) VALUES
(29, 30, 15, 47, '#dog', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL auto_increment,
  `item_name` varchar(100) NOT NULL,
  `item_photo` varchar(250) NOT NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  `deleted` tinyint(1) NOT NULL default '0',
  `item_created_time` datetime NOT NULL,
  `item_updated_time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `item_name`, `item_photo`, `is_active`, `deleted`, `item_created_time`, `item_updated_time`) VALUES
(15, 'Bag', '/images/item/eye.png', 1, 0, '2013-04-17 21:20:56', '2013-04-17 21:20:56'),
(16, 'Belt', '/images/item/eye.png', 1, 0, '2013-04-18 00:59:08', '2013-04-18 00:59:08'),
(17, 'Booties', '/images/item/eye.png', 1, 0, '2013-04-18 00:59:37', '2013-04-18 00:59:37'),
(18, 'Bow Tie', '/images/item/eye.png', 1, 0, '2013-04-18 01:00:59', '2013-04-18 01:00:59'),
(19, 'BathingSuit', '/images/item/eye.png', 1, 0, '2013-04-18 01:03:58', '2013-04-18 01:03:58'),
(20, 'Blazer', '/images/item/eye.png', 1, 0, '2013-04-23 06:26:35', '2013-04-23 06:26:35'),
(21, 'Boots', '/images/item/1367238901.png', 1, 0, '2013-04-29 08:35:01', '2013-04-29 08:35:01'),
(22, 'Bracelet', '/images/item/1367238916.png', 1, 0, '2013-04-29 08:35:16', '2013-04-29 08:35:16'),
(23, 'Cheecks', '/images/item/1367238931.png', 1, 0, '2013-04-29 08:35:31', '2013-04-29 08:35:31'),
(24, 'Coat', '/images/item/1367238941.png', 1, 0, '2013-04-29 08:35:41', '2013-04-29 08:35:41'),
(25, 'Dress', '/images/item/1367239081.png', 1, 0, '2013-04-29 08:38:01', '2013-04-29 08:38:01'),
(26, 'Earring', '/images/item/1367239098.png', 1, 0, '2013-04-29 08:38:18', '2013-04-29 08:38:18'),
(27, 'Eyes', '/images/item/1367239109.png', 1, 0, '2013-04-29 08:38:29', '2013-04-29 08:38:29'),
(28, 'Face', '/images/item/1367239118.png', 1, 0, '2013-04-29 08:38:38', '2013-04-29 08:38:38'),
(29, 'Flats', '/images/item/1367239130.png', 1, 0, '2013-04-29 08:38:50', '2013-04-29 08:38:50'),
(30, 'Glasses', '/images/item/1367239140.png', 1, 0, '2013-04-29 08:39:00', '2013-04-29 08:39:00'),
(31, 'Gloves', '/images/item/1367239155.png', 1, 0, '2013-04-29 08:39:15', '2013-04-29 08:39:15'),
(32, 'Hair', '/images/item/1367239167.png', 1, 0, '2013-04-29 08:39:27', '2013-04-29 08:39:27'),
(33, 'Hat', '/images/item/1367239172.png', 1, 0, '2013-04-29 08:39:32', '2013-04-29 08:39:32'),
(34, 'Hand Bands', '/images/item/1367239191.png', 1, 0, '2013-04-29 08:39:51', '2013-04-29 08:39:51'),
(35, 'Heels', '/images/item/1367239205.png', 1, 0, '2013-04-29 08:40:05', '2013-04-29 08:40:05'),
(36, 'Intimates', '/images/item/1367239216.png', 1, 0, '2013-04-29 08:40:16', '2013-04-29 08:40:16'),
(37, 'Jacket', '/images/item/1367239230.png', 1, 0, '2013-04-29 08:40:30', '2013-04-29 08:40:30'),
(38, 'Jeans', '/images/item/1367239240.png', 1, 0, '2013-04-29 08:40:40', '2013-04-29 08:40:40'),
(39, 'JumpSuit', '/images/item/1367239252.png', 1, 0, '2013-04-29 08:40:52', '2013-04-29 08:40:52'),
(40, 'Leggings', '/images/item/1367239263.png', 1, 0, '2013-04-29 08:41:03', '2013-04-29 08:41:03'),
(41, 'Lips', '/images/item/1367239275.png', 1, 0, '2013-04-29 08:41:15', '2013-04-29 08:41:15'),
(42, 'Loafers', '/images/item/1367239282.png', 1, 0, '2013-04-29 08:41:22', '2013-04-29 08:41:22'),
(43, 'Nails', '/images/item/1367239294.png', 1, 0, '2013-04-29 08:41:34', '2013-04-29 08:41:34'),
(44, 'Necklace', '/images/item/1367239310.png', 1, 0, '2013-04-29 08:41:50', '2013-04-29 08:41:50'),
(45, 'Overalls', '/images/item/1367239326.png', 1, 0, '2013-04-29 08:42:06', '2013-04-29 08:42:06'),
(46, 'Oxfords', '/images/item/1367239336.png', 1, 0, '2013-04-29 08:42:16', '2013-04-29 08:42:16'),
(47, 'Pants', '/images/item/1367239344.png', 1, 0, '2013-04-29 08:42:24', '2013-04-29 08:42:24'),
(48, 'Rings', '/images/item/1367239349.png', 1, 0, '2013-04-29 08:42:29', '2013-04-29 08:42:29'),
(49, 'Romper', '/images/item/1367239363.png', 1, 0, '2013-04-29 08:42:43', '2013-04-29 08:42:43'),
(50, 'Sandels', '/images/item/1367239371.png', 1, 0, '2013-04-29 08:42:51', '2013-04-29 08:42:51'),
(51, 'Scarf', '/images/item/1367239385.png', 1, 0, '2013-04-29 08:43:05', '2013-04-29 08:43:05'),
(52, 'Shirt', '/images/item/1367239396.png', 1, 0, '2013-04-29 08:43:16', '2013-04-29 08:43:16'),
(53, 'Shorts', '/images/item/1367239427.png', 1, 0, '2013-04-29 08:43:47', '2013-04-29 08:43:47'),
(54, 'Skirt', '/images/item/1367239441.png', 1, 0, '2013-04-29 08:44:01', '2013-04-29 08:44:01'),
(55, 'Sneakers', '/images/item/1367239455.png', 1, 0, '2013-04-29 08:44:15', '2013-04-29 08:44:15'),
(56, 'Socks', '/images/item/1367239465.png', 1, 0, '2013-04-29 08:44:25', '2013-04-29 08:44:25'),
(57, 'Suit', '/images/item/1367239475.png', 1, 0, '2013-04-29 08:44:35', '2013-04-29 08:44:35'),
(58, 'SunGlasses', '/images/item/1367239488.png', 1, 0, '2013-04-29 08:44:48', '2013-04-29 08:44:48'),
(59, 'Sweater', '/images/item/1367239498.png', 1, 0, '2013-04-29 08:44:58', '2013-04-29 08:44:58'),
(60, 'SweaterShirt', '/images/item/1367239507.png', 1, 0, '2013-04-29 08:45:07', '2013-04-29 08:45:07'),
(61, 'Tech Accessories ', '/images/item/1367239537.png', 1, 0, '2013-04-29 08:45:37', '2013-04-29 08:45:37'),
(62, 'Tie', '/images/item/1367239544.png', 1, 0, '2013-04-29 08:45:44', '2013-04-29 08:45:44'),
(63, 'Tights', '/images/item/1367239552.png', 1, 0, '2013-04-29 08:45:52', '2013-04-29 08:45:52'),
(64, 'Umbrella', '/images/item/1367239562.png', 1, 0, '2013-04-29 08:46:02', '2013-04-29 08:46:02');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL auto_increment,
  `like_on` int(11) NOT NULL,
  `like_by` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  `deleted` tinyint(1) NOT NULL default '0',
  `like_created_time` datetime NOT NULL,
  `like_updated_time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `like_on`, `like_by`, `is_active`, `deleted`, `like_created_time`, `like_updated_time`) VALUES
(1, 70, 28, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 71, 32, 1, 0, '2013-04-23 07:26:24', '2013-04-23 07:26:24'),
(10, 15, 32, 1, 0, '2013-04-30 05:46:29', '2013-04-30 05:46:29'),
(11, 15, 32, 1, 0, '2013-04-30 05:48:25', '2013-04-30 05:48:25'),
(12, 16, 32, 1, 0, '2013-04-30 05:48:32', '2013-04-30 05:48:32'),
(13, 16, 32, 1, 0, '2013-04-30 05:48:47', '2013-04-30 05:48:47'),
(14, 16, 32, 1, 0, '2013-04-30 05:48:57', '2013-04-30 05:48:57'),
(15, 17, 32, 1, 0, '2013-04-30 05:49:04', '2013-04-30 05:49:04'),
(16, 17, 32, 1, 0, '2013-04-30 05:49:37', '2013-04-30 05:49:37'),
(17, 18, 32, 1, 0, '2013-04-30 05:55:44', '2013-04-30 05:55:44'),
(18, 18, 32, 0, 0, '2013-04-30 05:55:47', '2013-04-30 05:55:47'),
(19, 18, 32, 1, 0, '2013-04-30 05:56:49', '2013-04-30 05:56:49'),
(20, 18, 32, 1, 0, '2013-04-30 05:57:18', '2013-04-30 05:57:18'),
(21, 36, 52, 0, 1, '2013-05-07 07:26:32', '2013-05-07 07:26:32'),
(22, 35, 32, 1, 0, '2013-05-07 00:00:00', '2013-05-07 00:00:00'),
(29, 30, 47, 1, 0, '2013-05-09 00:31:58', '2013-05-09 00:31:58'),
(30, 27, 47, 1, 0, '2013-05-09 00:32:13', '2013-05-09 00:32:13'),
(31, 47, 47, 0, 1, '2013-05-09 01:18:41', '2013-05-09 01:18:41');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL auto_increment,
  `media_owner` int(11) NOT NULL,
  `media_title` varchar(200) NOT NULL,
  `media_image` varchar(200) NOT NULL,
  `image_type` varchar(20) NOT NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  `deleted` tinyint(1) NOT NULL default '0',
  `media_created_time` datetime NOT NULL,
  `media_updated_time` datetime NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `flag` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `media_owner`, `media_title`, `media_image`, `image_type`, `is_active`, `deleted`, `media_created_time`, `media_updated_time`, `thumb`, `flag`) VALUES
(24, 36, 'hellllloooooooooooo', '/images/media/1367658836.jpg', 'everyday', 1, 0, '2013-05-04 05:13:56', '2013-05-04 05:13:56', '/images/media/t_1367658836.jpg', 0),
(25, 32, 'ddd', '/images/media/1367659351.jpg', 'everyday', 1, 0, '2013-05-04 05:22:31', '2013-05-04 05:22:31', '/images/media/t_1367659351.jpg', 0),
(26, 0, 'dddd', '/images/media/1367675477.jpg', 'work', 1, 0, '2013-05-04 09:51:17', '2013-05-04 09:51:17', '/images/media/t_1367675477.jpg', 0),
(27, 47, 'hj', '/images/media/1367679556.jpg', 'Vacation', 1, 0, '2013-05-04 10:59:16', '2013-05-04 10:59:16', '/images/media/t_1367679556.jpg', 0),
(28, 47, 'at home', '/images/media/1367680061.jpg', 'Vacation', 1, 0, '2013-05-04 11:07:41', '2013-05-04 11:07:41', '/images/media/t_1367680061.jpg', 0),
(29, 47, 'hey mom.......', '/images/media/1367814320.jpg', 'Everyday', 1, 0, '2013-05-06 00:25:20', '2013-05-06 00:25:20', '/images/media/t_1367814320.jpg', 0),
(30, 47, 'hi.......', '/images/media/1367814448.jpg', 'Event', 1, 0, '2013-05-06 00:27:28', '2013-05-06 00:27:28', '/images/media/t_1367814448.jpg', 0),
(31, 47, 'its my style', '/images/media/1367815303.jpg', 'Work', 1, 0, '2013-05-06 00:41:43', '2013-05-06 00:41:43', '/images/media/t_1367815303.jpg', 0),
(32, 47, 'hi......', '/images/media/1367815386.jpg', 'Active', 1, 0, '2013-05-06 00:43:06', '2013-05-06 00:43:06', '/images/media/t_1367815386.jpg', 0),
(33, 47, 'hi......', '/images/media/1367815460.jpg', 'Evening', 1, 0, '2013-05-06 00:44:20', '2013-05-06 00:44:20', '/images/media/t_1367815460.jpg', 0),
(34, 47, 'hi', '/images/media/1367815588.jpg', 'Vacation', 1, 0, '2013-05-06 00:46:28', '2013-05-06 00:46:28', '/images/media/t_1367815588.jpg', 0),
(35, 47, 'in my office', '/images/media/1367815804.jpg', 'Active', 1, 1, '2013-05-06 00:50:04', '2013-05-06 00:50:04', '/images/media/t_1367815804.jpg', 0),
(36, 52, 'vaibhav', '/images/media/1367925740.jpg', 'Evening', 1, 1, '2013-05-07 07:22:20', '2013-05-07 07:22:20', '/images/media/t_1367925740.jpg', 0),
(37, 36, 'GUSTO', '/images/media/1367991248.jpg', 'everyday', 1, 0, '2013-05-08 01:34:08', '2013-05-08 01:34:08', '/images/media/t_1367991248.jpg', 0),
(38, 36, 'GUSTO', '/images/media/1367991265.jpg', 'evening', 1, 0, '2013-05-08 01:34:25', '2013-05-08 01:34:25', '/images/media/t_1367991265.jpg', 0),
(39, 47, 'hi', '/images/media/1367991282.jpg', 'Evening', 1, 1, '2013-05-08 01:34:42', '2013-05-08 01:34:42', '/images/media/t_1367991282.jpg', 0),
(40, 36, 'dfsf', '/images/media/1367992779.jpg', 'everyday', 1, 0, '2013-05-08 01:59:39', '2013-05-08 01:59:39', '/images/media/t_1367992779.jpg', 0),
(41, 90, 'AAAAAA', '/images/media/1367994080.jpg', 'vacation', 1, 0, '2013-05-08 02:21:20', '2013-05-08 02:21:20', '/images/media/t_1367994080.jpg', 0),
(42, 90, 'AAAAAA', '/images/media/1367994295.jpg', 'vacation', 1, 0, '2013-05-08 02:24:55', '2013-05-08 02:24:55', '/images/media/t_1367994295.jpg', 0),
(43, 90, 'AAAAAA', '/images/media/1367994754.jpg', 'vacation', 1, 0, '2013-05-08 02:32:34', '2013-05-08 02:32:34', '/images/media/t_1367994754.jpg', 0),
(44, 51, 'BBB', '/images/media/1367995028.jpg', 'everyday', 1, 0, '2013-05-08 02:37:08', '2013-05-08 02:37:08', '/images/media/t_1367995028.jpg', 0),
(45, 51, 'CCCC', '/images/media/1367995333.jpg', 'everyday', 1, 0, '2013-05-08 02:42:13', '2013-05-08 02:42:13', '/images/media/t_1367995333.jpg', 0),
(46, 51, 'dsada', '/images/media/1367996802.jpg', 'everyday', 1, 0, '2013-05-08 03:06:42', '2013-05-08 03:06:42', '/images/media/t_1367996802.jpg', 0),
(47, 51, 'dsada', '/images/media/1367996858.jpg', 'everyday', 1, 0, '2013-05-08 03:07:38', '2013-05-08 03:07:38', '/images/media/t_1367996858.jpg', 0),
(48, 47, 'cool', '/images/media/1368074129.jpg', 'Vacation', 1, 1, '2013-05-09 00:35:29', '2013-05-09 00:35:29', '/images/media/t_1368074129.jpg', 0),
(49, 47, 'hhhh bbh gh ', '/images/media/1368074423.jpg', 'Work', 1, 1, '2013-05-09 00:40:23', '2013-05-09 00:40:23', '/images/media/t_1368074423.jpg', 0),
(50, 47, '', '/images/media/1368075285.jpg', '', 1, 1, '2013-05-09 00:54:45', '2013-05-09 00:54:45', '/images/media/t_1368075285.jpg', 0),
(51, 47, '', '/images/media/1368075383.jpg', '', 1, 1, '2013-05-09 00:56:23', '2013-05-09 00:56:23', '/images/media/t_1368075383.jpg', 0),
(52, 47, '', '/images/media/1368075518.jpg', '', 1, 1, '2013-05-09 00:58:38', '2013-05-09 00:58:38', '/images/media/t_1368075518.jpg', 0),
(53, 47, '', '/images/media/1368077264.jpg', '', 1, 0, '2013-05-09 01:27:44', '2013-05-09 01:27:44', '/images/media/t_1368077264.jpg', 0),
(54, 47, '', '/images/media/1368077984.jpg', '', 1, 0, '2013-05-09 01:39:44', '2013-05-09 01:39:44', '/images/media/t_1368077984.jpg', 0),
(55, 47, '3 tags with this media', '/images/media/1368078395.jpg', 'Active', 1, 0, '2013-05-09 01:46:35', '2013-05-09 01:46:35', '/images/media/t_1368078395.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `retailer`
--

CREATE TABLE IF NOT EXISTS `retailer` (
  `id` int(11) NOT NULL auto_increment,
  `retailer_name` varchar(100) NOT NULL,
  `retailer_photo` varchar(150) NOT NULL,
  `place` text NOT NULL,
  `lat` varchar(30) NOT NULL,
  `long` varchar(30) NOT NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  `deleted` tinyint(1) NOT NULL default '0',
  `retailer_created_time` datetime NOT NULL,
  `retailer_updated_time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `retailer`
--

INSERT INTO `retailer` (`id`, `retailer_name`, `retailer_photo`, `place`, `lat`, `long`, `is_active`, `deleted`, `retailer_created_time`, `retailer_updated_time`) VALUES
(9, 'U-Turn', '/images/retailer/u-turn-shop.jpg', 'place', '0', '0', 1, 0, '2013-04-17 08:41:57', '2013-04-18 00:00:00'),
(10, 'Big Bazar', '/images/retailer/Big-Bazaar---Bangalore-925040342-77386-1.jpg', 'place', '0', '0', 1, 0, '2013-04-17 08:43:02', '2013-04-17 08:43:58'),
(11, 'Vishal Mega Mart', '/images/item/deal-image-Special-Offer-At-Vishal-Mega-Mart-1093-1333626352603.jpg', 'place', '0', '0', 1, 0, '2013-04-17 00:00:00', '2013-04-18 00:00:00'),
(12, 'Gitanjali Jwellers ', '/images/retailer/yxLtz.jpg', 'place', '0', '0', 1, 0, '2013-04-17 08:47:22', '2013-04-17 08:47:22'),
(13, 'Pakiza ', '/images/retailer/pakiza.png', 'place', '0', '0', 1, 0, '2013-04-17 08:48:52', '2013-04-17 08:48:52'),
(14, 'Mehata Cloths', '/images/retailer/120313_kis11mar13p1088a_01.jpg', 'place', '0', '0', 1, 0, '2013-04-17 09:16:31', '2013-04-17 09:16:31'),
(15, 'Pantaloons ', '/images/retailer/pantaloons.gif', 'place', '0', '0', 1, 0, '2013-04-17 09:16:42', '2013-04-17 09:16:42'),
(16, 'Max ', '/images/retailer/BRANDS @ TI.jpg', 'place', '0', '0', 1, 0, '2013-04-17 09:17:06', '2013-04-17 09:17:06'),
(17, 'Raymonds KS', '/images/retailer/l201500.jpg', 'place', '0', '0', 1, 0, '2013-04-17 09:17:21', '2013-04-17 09:17:21'),
(18, 'Woodland ', '/images/retailer/ProductRear634893846320734213.jpg', 'place', '0', '0', 1, 0, '2013-04-17 09:17:49', '2013-04-17 09:17:49'),
(19, 'reid 7 taylor', '/images/retailer/catalogue-brand-section-27-reid-taylor-at-haiku-mall-8233262754264256331847139301643255938981.jpg', 'place', '0', '0', 1, 0, '2013-04-17 09:20:38', '2013-04-17 09:20:38'),
(20, 'peter england', '/images/retailer/PEter-england-Logo.jpg', 'place', '0', '0', 1, 0, '2013-04-17 09:22:19', '2013-04-17 09:22:19'),
(21, 'John Players', '/images/retailer/hrithik_john_players_1.jpg', 'place', '0', '0', 1, 0, '2013-04-17 09:22:52', '2013-04-17 09:22:52'),
(25, 'Koutons', '1363287939KoutonsKoutons - shops in lucknow - lucknow bazaar - 1.jpg', 'place', '0', '0', 1, 0, '2013-04-18 08:35:19', '2013-04-18 08:35:19'),
(26, 'Baskin Robbins', '/images/retailer/BR.jpg', 'place', '0', '0', 1, 0, '2013-04-18 08:37:18', '2013-04-18 08:37:18'),
(27, 'Provouge', '/images/retailer/925106975-1109226-1_s.jpg', 'place', '0', '0', 1, 0, '2013-04-23 06:10:56', '2013-04-23 06:10:56'),
(28, 'Vodafone', '/images/retailer/vodafone-Logo.jpg', 'place', '0', '74', 1, 0, '2013-04-23 06:13:55', '2013-04-23 06:13:55'),
(29, 'Bata', '/images/retailer/bata-logo.jpg', 'place', '21 left', '33 refgf', 1, 0, '2013-04-23 06:18:01', '2013-04-23 06:18:01'),
(30, 'Mufti', '/images/retailer/coll_logo.jpg', 'place', '0', '0', 1, 0, '2013-04-23 17:33:56', '2013-04-23 17:33:56');

-- --------------------------------------------------------

--
-- Table structure for table `shares`
--

CREATE TABLE IF NOT EXISTS `shares` (
  `id` int(11) NOT NULL auto_increment,
  `share_on` int(11) NOT NULL,
  `share_by` int(11) NOT NULL,
  `is_active` int(11) NOT NULL default '1',
  `deleted` int(11) NOT NULL default '0',
  `share_created_time` datetime NOT NULL,
  `share_update_time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `splash`
--

CREATE TABLE IF NOT EXISTS `splash` (
  `id` int(11) NOT NULL auto_increment,
  `splash_images` varchar(300) NOT NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `splash`
--

INSERT INTO `splash` (`id`, `splash_images`, `is_active`, `deleted`) VALUES
(1, '/images/splash/screen1.jpg', 1, 0),
(2, '/images/splash/screen2.jpg', 1, 0),
(3, '/images/splash/screen3.jpg', 1, 0),
(4, '/images/splash/screen4.jpg', 1, 0),
(5, '/images/splash/screen5.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL auto_increment,
  `tag_on` int(11) NOT NULL,
  `brand_id` varchar(100) NOT NULL,
  `retailer_id` varchar(100) NOT NULL,
  `item_id` varchar(100) NOT NULL,
  `tag_position` varchar(100) NOT NULL,
  `tag_by` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  `deleted` tinyint(1) NOT NULL default '0',
  `tag_created_time` datetime NOT NULL,
  `tag_updated_time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag_on`, `brand_id`, `retailer_id`, `item_id`, `tag_position`, `tag_by`, `is_active`, `deleted`, `tag_created_time`, `tag_updated_time`) VALUES
(13, 28, '17', '13', '40', '156.50X215.00', 47, 1, 0, '2013-05-04 11:07:41', '2013-05-04 11:07:41'),
(14, 29, '18', '16', '52', '23.50X213.00', 47, 1, 0, '2013-05-06 00:25:21', '2013-05-06 00:25:21'),
(15, 30, '17', '15', '37', '76.50X278.00', 47, 1, 0, '2013-05-06 00:27:28', '2013-05-06 00:27:28'),
(16, 31, '18', '9', '58', '121.00X59.00', 47, 1, 0, '2013-05-06 00:41:43', '2013-05-06 00:41:43'),
(17, 32, '17', '18', '33', '155.50X27.50', 47, 1, 0, '2013-05-06 00:43:06', '2013-05-06 00:43:06'),
(18, 33, '19', '15', '40', '212.50X213.50', 47, 1, 0, '2013-05-06 00:44:20', '2013-05-06 00:44:20'),
(19, 34, '20', '14', '45', '145.50X123.50', 47, 1, 0, '2013-05-06 00:46:28', '2013-05-06 00:46:28'),
(20, 35, '21', '17', '39', '91.50X223.00', 47, 1, 0, '2013-05-06 00:50:04', '2013-05-06 00:50:04'),
(21, 36, '17', '15', '52', '89.00X178.50', 53, 1, 0, '2013-05-07 07:22:23', '2013-05-07 07:22:23'),
(22, 39, '19', '16', '33', '135.50X89.00', 47, 1, 0, '2013-05-08 01:34:42', '2013-05-08 01:34:42'),
(37, 46, '20', '9', '45', '345X345', 51, 1, 0, '2013-05-08 03:06:42', '2013-05-08 03:06:42'),
(38, 46, '21', '9', '54', '3345X3345', 51, 1, 0, '2013-05-08 03:06:42', '2013-05-08 03:06:42'),
(39, 47, '20', '9', '45', '345X345', 51, 1, 0, '2013-05-08 03:07:38', '2013-05-08 03:07:38'),
(40, 47, '21', '9', '54', '3345X3345', 51, 1, 0, '2013-05-08 03:07:38', '2013-05-08 03:07:38'),
(41, 48, '17', '29', '36', '180.00X167.00', 47, 1, 0, '2013-05-09 00:35:31', '2013-05-09 00:35:31'),
(42, 49, '19', '12', '33', '197.00X182.50', 47, 1, 0, '2013-05-09 00:40:23', '2013-05-09 00:40:23'),
(43, 55, '17', '16', '41', '94.50X225.00', 47, 1, 0, '2013-05-09 01:46:35', '2013-05-09 01:46:35'),
(44, 55, '17', '25', '40', '76.00X68.50', 47, 1, 0, '2013-05-09 01:46:35', '2013-05-09 01:46:35'),
(45, 55, '19', '21', '46', '28.50X158.00', 47, 1, 0, '2013-05-09 01:46:35', '2013-05-09 01:46:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `fullname` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `cover_photo` varchar(50) NOT NULL,
  `profile_photo` varchar(50) NOT NULL,
  `profile` varchar(10) NOT NULL default 'public',
  `udid` varchar(50) NOT NULL,
  `about` varchar(200) NOT NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  `deleted` tinyint(1) NOT NULL default '0',
  `user_created_time` datetime NOT NULL,
  `user_updated_time` datetime NOT NULL,
  `last_login_time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `user_email`, `cover_photo`, `profile_photo`, `profile`, `udid`, `about`, `is_active`, `deleted`, `user_created_time`, `user_updated_time`, `last_login_time`) VALUES
(32, 'man', 'SHSHSH', '11111', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', '', 'i m simple', 1, 0, '0000-00-00 00:00:00', '2013-05-09 03:05:48', '2013-05-09 03:05:48'),
(36, 'ffff', 'SHSHSH', '7fa8282ad93047a4d6fe6111c93b308a', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'ffdads1234', 'straight forward', 1, 0, '2013-04-17 08:25:38', '2013-04-17 08:25:38', '2013-04-17 08:25:38'),
(37, 'ffff', 'SHSHSH', '7fa8282ad93047a4d6fe6111c93b308a', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'ffdads1234', 'shy', 1, 0, '2013-04-17 08:28:49', '2013-04-17 08:28:49', '2013-04-17 08:28:49'),
(38, 'ffff', 'SHSHSH', '5de51b96f0ce068d74abece2cd57527b', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'ffdads1234', 'i m simple', 1, 0, '2013-04-17 09:01:15', '2013-04-17 09:01:15', '2013-04-17 09:01:15'),
(39, 'ffff', 'SHSHSH', '89defae676abd3e3a42b41df17c40096', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'ffdads1234', 'straight forward', 1, 0, '2013-04-17 09:07:08', '2013-04-17 09:07:08', '2013-04-17 09:07:08'),
(40, 'ffff', 'SHSHSH', 'bea3d9d667eb3d9062bb97950cc4fb8c', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'ffdads1234', 'shy', 1, 0, '2013-04-17 09:11:27', '2013-04-17 09:11:27', '2013-04-17 09:11:27'),
(41, 'ffff', 'SHSHSH', 'e57d835b25a66d1cc3480e7c030dbf2f', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'ffdads1234', 'sweet', 1, 0, '2013-04-17 09:13:38', '2013-04-17 09:13:38', '2013-04-17 09:13:38'),
(42, 'ffff', 'SHSHSH', 'b0baee9d279d34fa1dfd71aadb908c3f', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'ffdads1234', 'i m simple', 1, 0, '2013-04-18 00:24:39', '2013-04-18 00:24:39', '2013-04-18 00:24:39'),
(43, 'ffff', 'SHSHSH', 'b0baee9d279d34fa1dfd71aadb908c3f', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'ffdads1234', 'straight forward', 1, 0, '2013-04-18 00:34:52', '2013-04-18 00:34:52', '2013-04-18 00:34:52'),
(44, 'ffff', 'SHSHSH', 'b0baee9d279d34fa1dfd71aadb908c3f', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'ffdads1234', 'shy', 1, 0, '2013-04-18 00:35:30', '2013-04-18 00:35:30', '2013-04-18 00:35:30'),
(45, 'ffff', 'SHSHSH', 'c1f68ec06b490b3ecb4066b1b13a9ee9', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'ffdads1234', 'sweet', 1, 0, '2013-04-18 00:53:02', '2013-04-18 00:53:02', '2013-04-18 00:53:02'),
(46, 'ffff', 'SHSHSH', '252bcff712003984e9fbe7fdbc8e6f7d', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'ffdads1234', 'i m simple', 1, 0, '2013-04-18 05:57:37', '2013-04-18 05:57:37', '2013-04-18 05:57:37'),
(47, 'rohan', 'rohan.tv', 'e10adc3949ba59abbe56e057f20f883e', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'ffdads1234', 'straight forward', 1, 0, '2013-04-20 01:49:49', '2013-04-20 01:49:49', '2013-04-20 01:49:49'),
(48, 'ffff', 'SHSHSH', 'b0baee9d279d34fa1dfd71aadb908c3f', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'ffdads1234', 'shy', 1, 0, '2013-04-23 05:21:42', '2013-04-23 05:21:42', '2013-04-23 05:21:42'),
(49, 'ffff', 'SHSHSH', '730df268b3082792678ed88be9b5b9f0', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'ffdads1234', 'sweet', 1, 0, '2013-04-23 06:49:50', '2013-04-23 06:49:50', '2013-04-23 06:49:50'),
(50, 'farid', 'farid.shaikh', 'e360bc13bcba071f4746adbb334cd78e', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'unknown_udid_1', 'i m simple', 1, 0, '2013-05-03 07:01:30', '2013-05-03 07:01:30', '2013-05-03 07:01:30'),
(51, 'manoj', 'manoj.tv', 'c4f4b2eb6d63dd4dd8afed001c61c956', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'unknown_udid_1', 'straight forward', 1, 0, '2013-05-03 07:49:56', '2013-05-03 07:49:56', '2013-05-03 07:49:56'),
(52, 'ffff111', 'SHSHSH', 'e10adc3949ba59abbe56e057f20f883e', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', 'unknown_udid_1', '', 1, 0, '2013-05-07 07:13:42', '2013-05-07 07:13:42', '2013-05-07 07:13:42'),
(53, 'ffff', 'SHSHSH', '3e3e7d3a7f8fafce42c101be02e83aef', 'FARID.NEXUS@dsa.cv', '/images/avatars/default_cover_photo.jpg', '/images/avatars/default_profile_photo.jpg', 'private', '', '', 1, 0, '2013-05-09 03:03:42', '2013-05-09 03:03:42', '2013-05-09 03:03:42');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
