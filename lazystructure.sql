-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 04, 2012 at 12:24 AM
-- Server version: 5.1.61
-- PHP Version: 5.4.1RC1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lazystructure`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `key`, `name`, `description`, `url`) VALUES
(1, 'CONTENT_EDIT', 'Content Editing', 'The ability to update web pages.', NULL),
(2, 'USERS', 'Manage Users', 'Add, edit, delete users', 'admin/users.php'),
(3, 'GROUPS', 'Manage Groups', 'Create groups and assign them to users', 'admin/groups.php'),
(4, 'PAGES', 'Manage Pages', 'Add, edit, delete pages', 'admin/pages.php');

-- --------------------------------------------------------

--
-- Table structure for table `actions_to_groups`
--

CREATE TABLE IF NOT EXISTS `actions_to_groups` (
  `action_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`action_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `actions_to_groups`
--

INSERT INTO `actions_to_groups` (`action_id`, `group_id`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'guest', 'Base level group of which every visitor is a member.  Give permissions to this group for whatever pages you want to be publicly visible to everyone.'),
(2, 'admin', 'Should always have all permissions.');

-- --------------------------------------------------------

--
-- Table structure for table `groups_to_pages`
--

CREATE TABLE IF NOT EXISTS `groups_to_pages` (
  `group_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groups_to_pages`
--

INSERT INTO `groups_to_pages` (`group_id`, `page_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `groups_to_users`
--

CREATE TABLE IF NOT EXISTS `groups_to_users` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groups_to_users`
--

INSERT INTO `groups_to_users` (`group_id`, `user_id`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `main_menu`
--

CREATE TABLE IF NOT EXISTS `main_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `position` smallint(6) NOT NULL,
  `is_ajax` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `main_menu`
--

INSERT INTO `main_menu` (`id`, `user_id`, `title`, `link`, `parent_id`, `position`, `is_ajax`) VALUES
(1, 0, 'Home', '/LazyStructure/1/home', NULL, 1, 0),
(2, 0, 'Members', '/LazyStructure/4/Login', NULL, 2, 0),
(3, 0, 'Login', '/LazyStructure/4/login', 2, 1, 0),
(4, 0, 'Join', '/LazyStructure/3/join', 2, 2, 0),
(5, 0, 'Google', 'http://google.com', 4, 1, 0),
(6, 0, 'Logout', '/LazyStructure/do/doLogout.php', 2, 3, 0),
(7, 0, 'Testing', '/LazyStructure/1/Home', NULL, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `heading` varchar(100) DEFAULT NULL,
  `content` longtext,
  `editable` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `heading`, `content`, `editable`) VALUES
(1, 'Home', 'Welcome', '\n    <p class="info">Welcome to the <strong><em>LazyStructure</em></strong> system.<br /></p>\n<p style="margin-left:40px;"><em>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In quis suscipit tellus. Cras ligula mi, gravida ac consectetur eget, venenatis sed turpis. Pellentesque id massa ut ipsum eleifend dignissim non ac massa. Duis nec nibh velit. Aliquam erat volutpat. In id turpis at sapien viverra pellentesque non in odio. Nulla aliquam fermentum congue. Nulla facilisi. Suspendisse porta pellentesque eros. Cras in risus nisi. Nam fermentum neque aliquam ante varius vitae tincidunt neque tempor. Sed vulputate, nunc non lacinia consequat, nisi eros condimentum risus, vitae porta magna arcu quis tellus. Donec ac diam at magna ullamcorper facilisis nec vel elit. Quisque sapien enim, blandit id vestibulum non, luctus rutrum nulla. Donec lorem elit, ultrices eget placerat et, iaculis in magna. Proin id nunc diam, at dignissim dolor. Maecenas eu sapien eget dolor tempor volutpat a et elit. Etiam vel ipsum erat, ut fermentum tellus. Quisque sollicitudin pretium massa id sagittis.</em></p>\n<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam dolor sapien, faucibus ut tempor quis, dapibus a risus. Nam fermentum sapien quis nunc semper vulputate pharetra in purus. Maecenas accumsan iaculis dolor, quis ultrices erat viverra quis. Pellentesque sollicitudin posuere semper. Duis tincidunt eros non nunc euismod consequat. Cras cursus ante eu odio congue sollicitudin. Vivamus at ipsum eu lacus gravida auctor sit amet suscipit elit. Quisque luctus semper felis in euismod. Quisque dolor odio, interdum vel placerat lacinia, pellentesque quis nulla. Curabitur volutpat pellentesque nisi, eget consequat ligula tempus in. Sed nunc urna, gravida et pellentesque ut, sollicitudin non lectus. Aliquam erat volutpat. Nullam eleifend auctor metus, eget dignissim tellus varius nec. Etiam urna ipsum, mattis vitae ultrices vel, molestie quis neque. Morbi nulla nisl, tincidunt a aliquam eu, sodales sed neque. Sed quis felis nec enim sodales tempor.</p>\n<p>Duis dui orci, ullamcorper in fermentum sit amet, imperdiet eu odio. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur leo nunc, semper eget consequat ac, eleifend egestas ligula. Sed adipiscing, est ut egestas cursus, mauris est bibendum nunc, sit amet interdum velit justo eget dui. Integer ornare, neque non commodo hendrerit, purus est pulvinar orci, sit amet euismod leo leo eget velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam leo lectus, fermentum eget euismod sit amet, tempor non tortor. Nullam vestibulum lobortis convallis. Nulla facilisi. Phasellus pellentesque leo posuere ante rutrum quis imperdiet neque volutpat. Fusce posuere, sapien ac tempor fermentum, felis orci volutpat metus, eu fringilla ipsum leo vel velit. Suspendisse augue quam, auctor eu ultrices sit amet, molestie et nisi. Suspendisse potenti.</p>\n<p>Proin ut elit ac massa imperdiet congue. Maecenas bibendum quam sit amet lorem aliquam elementum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce metus nunc, pellentesque ut luctus quis, elementum quis metus. Vivamus luctus nisl aliquam sapien porta vestibulum. Nullam fringilla sagittis elit ac varius. Quisque ut sem libero. Donec tristique purus vitae purus semper nec sodales lacus vestibulum. Sed sit amet lorem sapien. Etiam adipiscing ultrices purus consequat hendrerit. Fusce vehicula posuere vestibulum. Maecenas placerat massa massa, eget commodo tortor. Nullam tortor nibh, lacinia quis ultrices quis, cursus sit amet lectus. Vivamus sodales elit in ligula rutrum aliquam. Sed mattis pellentesque leo non imperdiet. Mauris gravida risus id dolor vestibulum lobortis. Donec velit tortor, porttitor in dictum ut, euismod non eros. Quisque sagittis, libero sit amet venenatis pulvinar, dui purus blandit massa, at placerat enim lorem ut eros. Morbi accumsan lacinia blandit. Proin in lorem at dolor sollicitudin auctor.</p>\n', 1),
(2, 'Alpha', 'Alpha', '<p>\r\nCum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam dolor sapien, faucibus ut tempor quis, dapibus a risus. Nam fermentum sapien quis nunc semper vulputate pharetra in purus. Maecenas accumsan iaculis dolor, quis ultrices erat viverra quis. Pellentesque sollicitudin posuere semper. Duis tincidunt eros non nunc euismod consequat. Cras cursus ante eu odio congue sollicitudin. Vivamus at ipsum eu lacus gravida auctor sit amet suscipit elit. Quisque luctus semper felis in euismod. Quisque dolor odio, interdum vel placerat lacinia, pellentesque quis nulla. Curabitur volutpat pellentesque nisi, eget consequat ligula tempus in. Sed nunc urna, gravida et pellentesque ut, sollicitudin non lectus. Aliquam erat volutpat. Nullam eleifend auctor metus, eget dignissim tellus varius nec. Etiam urna ipsum, mattis vitae ultrices vel, molestie quis neque. Morbi nulla nisl, tincidunt a aliquam eu, sodales sed neque. Sed quis felis nec enim sodales tempor. \r\n</p>\r\n\r\n<p>\r\nDuis dui orci, ullamcorper in fermentum sit amet, imperdiet eu odio. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur leo nunc, semper eget consequat ac, eleifend egestas ligula. Sed adipiscing, est ut egestas cursus, mauris est bibendum nunc, sit amet interdum velit justo eget dui. Integer ornare, neque non commodo hendrerit, purus est pulvinar orci, sit amet euismod leo leo eget velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam leo lectus, fermentum eget euismod sit amet, tempor non tortor. Nullam vestibulum lobortis convallis. Nulla facilisi. Phasellus pellentesque leo posuere ante rutrum quis imperdiet neque volutpat. Fusce posuere, sapien ac tempor fermentum, felis orci volutpat metus, eu fringilla ipsum leo vel velit. Suspendisse augue quam, auctor eu ultrices sit amet, molestie et nisi. Suspendisse potenti. \r\n</p>\r\n\r\n<p>\r\nProin ut elit ac massa imperdiet congue. Maecenas bibendum quam sit amet lorem aliquam elementum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce metus nunc, pellentesque ut luctus quis, elementum quis metus. Vivamus luctus nisl aliquam sapien porta vestibulum. Nullam fringilla sagittis elit ac varius. Quisque ut sem libero. Donec tristique purus vitae purus semper nec sodales lacus vestibulum. Sed sit amet lorem sapien. Etiam adipiscing ultrices purus consequat hendrerit. Fusce vehicula posuere vestibulum. Maecenas placerat massa massa, eget commodo tortor. Nullam tortor nibh, lacinia quis ultrices quis, cursus sit amet lectus. Vivamus sodales elit in ligula rutrum aliquam. Sed mattis pellentesque leo non imperdiet. Mauris gravida risus id dolor vestibulum lobortis. Donec velit tortor, porttitor in dictum ut, euismod non eros. Quisque sagittis, libero sit amet venenatis pulvinar, dui purus blandit massa, at placerat enim lorem ut eros. Morbi accumsan lacinia blandit. Proin in lorem at dolor sollicitudin auctor.\r\n</p>', 1),
(3, 'Join', 'Join', '    <form action="do/doJoin.php" method="post" onsubmit="return formSubmit(this);">\r\n<table id="join">\r\n<tbody><tr>\r\n<td><span class="required">*</span>Username:</td>\r\n<td><input type="text" name="username" id="username" maxlength="20" /></td>\r\n</tr>\r\n<tr>\r\n<td><span class="required">*</span>Password:</td>\r\n<td><input type="password" name="password" id="password" /></td>\r\n</tr>\r\n<tr>\r\n<td><span class="required">*</span>Confirm Password:</td>\r\n<td><input type="password" name="passwordConfirm" id="passwordConfirm" /></td>\r\n</tr>\r\n<tr>\r\n<td><span class="required">*</span>Email:</td>\r\n<td><input type="text" name="email" id="email" maxlength="100" /></td>\r\n</tr>\r\n<tr>\r\n<td>Name:</td>\r\n<td><input type="text" name="name" id="name" maxlength="30" /></td>\r\n</tr>\r\n<tr>\r\n<td>Surname:</td>\r\n<td><input type="text" name="surname" id="surname" maxlength="30" /></td>\r\n</tr>\r\n<tr>\r\n<td><span class="required">*</span>Phone:</td>\r\n<td><input type="text" name="phone" id="phone" /></td>\r\n</tr>\r\n<tr>\r\n<td rowspan="2">Address:</td>\r\n<td><input type="text" name="address1" maxlength="100" /></td>\r\n</tr>\r\n<tr>\r\n<td><input type="text" name="address2" maxlength="100" /></td>\r\n</tr>\r\n<tr>\r\n<td colspan="2"><input type="submit" value="Submit" /></td>\r\n</tr>\r\n</tbody></table>\r\n</form>\r\n', 0),
(4, 'Login', 'Login', '    <form action="../do/doLogin.php" method="post" onsubmit="return formSubmit(this);">\r\n        <table>\r\n            <tr>\r\n\r\n                <td>Username</td>\r\n                <td>\r\n                    <input type="text" id="username" name="username" value="" />\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td>Password</td>\r\n                <td>\r\n\r\n                    <input type="password" id="password" name="password" value="" />\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td>Remember Me</td>\r\n                <td>\r\n                    <input type="checkbox" id="remember" name="remember" checked="checked" />\r\n                </td>\r\n\r\n            </tr>\r\n            <tr>\r\n                <td colspan="2">\r\n                    <input type="submit" value="Log In" />\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>', 0);

-- --------------------------------------------------------

--
-- Table structure for table `page_menu`
--

CREATE TABLE IF NOT EXISTS `page_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `position` smallint(6) NOT NULL,
  `is_ajax` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `page_menu`
--

INSERT INTO `page_menu` (`id`, `page_id`, `title`, `link`, `parent_id`, `position`, `is_ajax`) VALUES
(1, 1, 'Xavier', 'http://yahoo.com', NULL, 1, 0),
(2, 1, 'Yosemite', 'http://microsoft.com', NULL, 2, 0),
(3, 1, 'Zebra', 'http://google.ca', NULL, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` char(144) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `loginToken` char(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `name`, `surname`, `phone`, `address1`, `address2`, `city`, `loginToken`) VALUES
(1, 'admin', 'dc72c4eee6e5857f40b3baad21f965f0458a98cb61fb8a264b135a13181ef3fab64fd18ad909808689b32bbe012e452965288d2db0200129de20759ee93a8c10d9a1c38f3ec12c2f', 'none@none.com', 'Admin', 'Adminerston', '9999999998', '', '', '', 'bfbb73001a382c4773b9ea95b921342ff82f4e117e89da37ba610b0fce10e12eec2d4d18e30756b7f91e59ae47fdea773b8f1ae69e5851f8d31ceb484a7222dc'),
(2, 'jdoe', '0ec91c19c77b86a61af3ebdaa05d793bb54da019dead8a04f461086b377eb67da443dadcd72accfaff1cb6fd59fa64a68c3f87c99c3258bc0dd1def5cb93217388f6e50244b7a99b', 'jdoe@example.com', 'John', 'Doe', '9999999999', '326 Main St.', '', 'Janesville', 'f771d9b745aa1e2161e860b92cfc5edf39f1db5886f0bea8c2c18db46f666085e9b92eb2cdb5e47ca3c990ae1edac03f546fc12e54f08e9e2825aadb19bdf859');
