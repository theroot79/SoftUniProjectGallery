-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 10, 2015 at 03:09 PM
-- Server version: 5.5.41-MariaDB-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `aid` int(10) unsigned NOT NULL COMMENT 'Album ID',
  `cid` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Category ID',
  `uid` int(10) unsigned NOT NULL COMMENT 'User ID',
  `name` varchar(150) NOT NULL COMMENT 'Album name',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Album created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users albums';

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cid` int(10) unsigned NOT NULL COMMENT 'Category ID',
  `uid` int(10) unsigned NOT NULL COMMENT 'User ID',
  `name` varchar(250) NOT NULL COMMENT 'Category Name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Categories';

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `cid` int(10) unsigned NOT NULL COMMENT 'Comment ID',
  `aid` int(10) unsigned DEFAULT '0' COMMENT 'Album ID',
  `phid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Photo ID',
  `name` varchar(250) NOT NULL COMMENT 'Commenter Name',
  `comment` text NOT NULL COMMENT 'Comment',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users comments';

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `phid` int(10) unsigned NOT NULL COMMENT 'Photo ID',
  `uid` int(10) unsigned NOT NULL COMMENT 'User ID',
  `aid` int(10) unsigned NOT NULL COMMENT 'Album ID',
  `name` varchar(150) NOT NULL COMMENT 'Name of the Photo',
  `filename` char(20) NOT NULL COMMENT 'Filename',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Upload time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users photos';

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `sessid` varchar(32) NOT NULL COMMENT 'Session ID',
  `sess_data` varchar(535) NOT NULL COMMENT 'Session data',
  `valid_until` int(11) NOT NULL COMMENT 'Session valid until'
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='Sessions';

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(10) unsigned NOT NULL COMMENT 'User ID',
  `email` varchar(250) NOT NULL COMMENT 'User Email address',
  `password` char(32) NOT NULL COMMENT 'User password in MD5',
  `fname` varchar(150) NOT NULL COMMENT 'User First Name',
  `lname` varchar(250) NOT NULL COMMENT 'Last name',
  `role` enum('user','admin') NOT NULL DEFAULT 'user' COMMENT 'User  Roles',
  `state` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0-registered/online, 1-blocked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users';

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `vid` int(10) unsigned NOT NULL COMMENT 'Vote ID',
  `aid` int(10) unsigned NOT NULL COMMENT 'Album ID',
  `ip` int(10) unsigned NOT NULL COMMENT 'IP address',
  `likes` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'number of likes',
  `dislikes` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'numver of dislikes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users Votes';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`aid`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `uid` (`uid`),
  ADD KEY `created` (`created`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cid`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `aid` (`aid`),
  ADD KEY `phid` (`phid`),
  ADD KEY `created` (`created`) USING BTREE;

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`phid`),
  ADD KEY `aid` (`aid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `created` (`created`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`sessid`),
  ADD KEY `valid_until` (`valid_until`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `password` (`password`),
  ADD KEY `state` (`state`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`vid`),
  ADD UNIQUE KEY `aid_2` (`aid`,`ip`),
  ADD KEY `aid` (`aid`),
  ADD KEY `ip` (`ip`),
  ADD KEY `vote` (`likes`),
  ADD KEY `dislike` (`dislikes`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `aid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Album ID';
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Category ID';
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `cid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Comment ID';
--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `phid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Photo ID';
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'User ID';
--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `vid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Vote ID';
--
-- Constraints for dumped tables
--

--
-- Constraints for table `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `cid-categories.cid` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `uid-album.uid` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `uid-categories.uid` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `aid-photo.aid` FOREIGN KEY (`aid`) REFERENCES `albums` (`aid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `uid-photo.uid` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
