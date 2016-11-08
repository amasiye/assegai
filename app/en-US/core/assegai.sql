-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2016 at 02:28 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assegai`
--

-- --------------------------------------------------------

--
-- Table structure for table `assg_activities`
--

CREATE TABLE `assg_activities` (
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `activity_who` bigint(20) UNSIGNED NOT NULL,
  `activity_what` text NOT NULL,
  `activity_when` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assg_api_keys`
--

CREATE TABLE `assg_api_keys` (
  `key_id` bigint(20) NOT NULL,
  `key_hash` varchar(64) NOT NULL,
  `key_author` enum('website','app','other') NOT NULL DEFAULT 'app',
  `key_registration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `key_modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `assg_api_keys`
--

INSERT INTO `assg_api_keys` (`key_id`, `key_hash`, `key_author`, `key_registration`, `key_modified`) VALUES
(1, 'e3760bc1b657baa8fd3dd855205e14ca863cc99f1df8675787006a3ec7d4f7d8', 'website', '2016-09-05 00:05:29', '2016-09-05 05:33:54'),
(2, '62e6d9098e445936d4e7d1b7971cd38bc2dc86edde2b8d194c66f187a9df5d7f', 'app', '2016-09-06 00:41:22', '2016-09-06 00:41:22'),
(3, 'd4f317c9dab9f15d4810d3e5cfc6601fff110266e92ccf745184526ee3c27d5d', 'app', '2016-09-06 00:41:22', '2016-09-06 00:41:22');

-- --------------------------------------------------------

--
-- Table structure for table `assg_categories`
--

CREATE TABLE `assg_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(20) NOT NULL,
  `category_info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `assg_categories`
--

INSERT INTO `assg_categories` (`category_id`, `category_name`, `category_info`) VALUES
(1, 'image', 'media'),
(2, 'audio', 'media'),
(3, 'video', 'media'),
(4, 'article', 'post'),
(5, 'container', 'element'),
(6, 'row', 'element'),
(7, 'nav', 'element'),
(8, 'menu', 'element'),
(9, 'jumbotron', 'element'),
(10, 'carousel', 'element'),
(11, 'header', 'element'),
(12, 'footer', 'element'),
(13, 'blogroll', 'element'),
(14, 'list', 'element'),
(15, 'panel', 'element'),
(16, 'form', 'element'),
(17, 'text', 'element'),
(18, 'dropdown', 'element'),
(19, 'button', 'element'),
(20, 'breadcrumb', 'element'),
(21, 'aside', 'element'),
(22, 'alert', 'element');

-- --------------------------------------------------------

--
-- Table structure for table `assg_groups`
--

CREATE TABLE `assg_groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(20) NOT NULL,
  `group_permissions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `assg_groups`
--

INSERT INTO `assg_groups` (`group_id`, `group_name`, `group_permissions`) VALUES
(1, 'Administrator', '{"pages":"red","sermons":"red","layouts":"red","newsletters":"red","profiles":"red","settings":"red","permissions":"red"}'),
(2, 'Editor', '{"pages":"re","sermons":"re","layouts":"re","newsletters":"re","profiles":"re","settings":"r","permissions":"r"}'),
(3, 'User', '{"pages":"r","sermons":"r","layouts":"r","newsletters":"r","profiles":"r","settings":"r","permissions":""}'),
(4, 'Media Team', '{"pages":"re","sermons":"re","layouts":"re","newsletters":"re","profiles":"re","settings":"r","permissions":""}'),
(5, 'Worship Team', '{"pages":"","sermons":"","layouts":"","newsletters":"","profiles":"re","settings":"","permissions":""}');

-- --------------------------------------------------------

--
-- Table structure for table `assg_options`
--

CREATE TABLE `assg_options` (
  `option_id` bigint(20) NOT NULL,
  `option_name` varchar(64) NOT NULL,
  `option_value` text NOT NULL,
  `option_autoload` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `assg_options`
--

INSERT INTO `assg_options` (`option_id`, `option_name`, `option_value`, `option_autoload`) VALUES
(1, 'site_name', 'Assegai Test', 'yes'),
(2, 'site_tagline', 'This is the site tag line.', 'yes'),
(3, 'site_description', 'The site''s description goes here.', 'yes'),
(4, 'site_keywords', 'Christian, Church, Gospel, Jesus, Pray, Hope, God', 'yes'),
(5, 'site_owner', 'Owner Name', 'yes'),
(6, 'default_datetime_format', 'Y-m-d H:i:s', 'yes'),
(7, 'default_date_format', 'Y-m-d', 'yes'),
(8, 'default_time_format', 'H:i:s', 'yes'),
(9, 'default_max_revisions', '10', 'yes'),
(10, 'site_url', 'http://yoursite.domain', 'yes'),
(11, 'site_status', 'unpublished', 'yes'),
(12, 'site_cookie_notification', 'off', 'yes'),
(13, 'default_timezone', 'America/Halifax', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `assg_posts`
--

CREATE TABLE `assg_posts` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `post_name` varchar(200) NOT NULL,
  `post_author` bigint(20) UNSIGNED NOT NULL,
  `post_editors` text NOT NULL,
  `post_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_content` longtext NOT NULL,
  `post_status` enum('publish','draft','auto-draft','trash','inherit') NOT NULL DEFAULT 'inherit',
  `post_type` enum('page','article','sermon','event','newsletter','media','element','layout','other') NOT NULL DEFAULT 'other',
  `post_tags` text NOT NULL,
  `post_meta` text NOT NULL,
  `post_trashed` int(2) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `assg_posts`
--

INSERT INTO `assg_posts` (`post_id`, `post_name`, `post_author`, `post_editors`, `post_created`, `post_modified`, `post_title`, `post_excerpt`, `post_content`, `post_status`, `post_type`, `post_tags`, `post_meta`, `post_trashed`) VALUES
(1, 'hello-world', 2, '', '2016-09-21 02:11:26', '2016-09-26 14:09:19', 'Hello World', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean tristique lacus et eros mollis lobortis. Nulla cursus ante quis ipsum mattis, ut blandit ante molestie. Morbi ornare sapien ut eros tincidunt condimentum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean tristique lacus et eros mollis lobortis. Nulla cursus ante quis ipsum mattis, ut blandit ante molestie. Morbi ornare sapien ut eros tincidunt condimentum. Pellentesque blandit aliquet ornare. Donec eget justo lobortis, dictum nibh a, ultrices velit. Phasellus sodales, eros sed scelerisque fermentum, massa augue commodo arcu, in condimentum diam mauris sit amet nibh. Quisque pellentesque cursus dolor.\r\n\r\nAenean et tellus gravida, dapibus metus eget, pellentesque mauris. Donec risus tortor, fringilla ac facilisis non, efficitur at nisl. Quisque ut risus ac metus blandit luctus. Nulla iaculis massa molestie odio maximus tristique. Morbi arcu augue, pharetra a risus ac, interdum imperdiet lectus. Vivamus pellentesque facilisis orci sed eleifend. Integer bibendum nibh id quam porttitor, et condimentum neque fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc nibh ipsum, euismod ac sem nec, rutrum maximus diam. Etiam nec condimentum nisl, eu rutrum ante. Cras tincidunt diam sed nisl tincidunt elementum. Fusce tristique metus ac magna sagittis mattis. Fusce bibendum auctor augue, id aliquet enim faucibus aliquet. In quis urna quis massa tempus dignissim eget non dui. Cras in condimentum lacus. Fusce pellentesque aliquet sodales.', 'publish', 'article', '', '', 0),
(2, 'default-profile', 1, '', '2016-09-21 20:43:30', '2016-09-23 01:36:03', 'Default Profile Pic', '', '', 'inherit', 'media', '', '{\n  "href":"app/en-US/content/resources/images/default-profile.jpg",\n  "source":"",\n  "thumb":"app/en-US/content/resources/images/default-profile.jpg",\n  "filename":"default-profile.jpg",\n  "media_type":"image"\n}', 0),
(3, '2-rev-1', 1, '', '2016-09-23 01:05:39', '2016-09-23 01:36:13', 'Default Profile Pic', '', '', 'inherit', 'media', '', '{\n  "href":"app/en-US/content/resources/images/default-profile.jpg",\n  "source":"",\n  "thumb":"app/en-US/content/resources/images/default-profile.jpg",\n  "filename":"default-profile.jpg",\n  "media_type":"image"\n}', 0),
(4, 'element-container', 1, '', '2016-09-23 05:23:24', '2016-10-26 06:46:52', 'Container', '', '<div class=''container''></div>', 'inherit', 'element', '', '{\r\n  "element_type":"container",\r\n  "class":"container"\r\n}', 0),
(5, 'element-row', 1, '', '2016-09-23 05:23:24', '2016-09-23 10:09:20', 'Row', '', '', 'inherit', 'element', '', '{\r\n  "element_type":"row",\r\n  "class":"row"\r\n}', 0),
(6, 'layout-blog', 1, '1, 2', '2016-09-23 06:58:11', '2016-11-06 12:41:02', 'Blog', '', '', 'inherit', 'layout', '', '{\n  "children":""\n}', 0),
(7, 'page-home', 1, '', '2016-09-23 08:17:13', '2016-11-06 12:41:02', 'Home', '', '', 'inherit', 'page', '', '{\n  "parent":"",\n  "children":"",\n  "head":"",\n  "body":"",\n  "layout":"6",\n  "styles":""\n}', 0),
(8, 'element-blogroll', 1, '', '2016-10-26 05:03:47', '2016-11-06 13:17:09', 'Blogroll', '', '<div class="media">\r\n  <div class="media-left">\r\n    <a href="#">\r\n      <img class="media-object" src="..." alt="...">\r\n    </a>\r\n  </div>\r\n  <div class="media-body">\r\n    <h4 class="media-heading">Media heading</h4>\r\n    ...\r\n  </div>\r\n</div>', 'inherit', 'element', '', '{\r\n  "element_type":"blogroll",\r\n  "class":"media"\r\n}', 0),
(9, 'element-header', 1, '', '2016-10-27 02:35:05', '2016-11-06 13:17:09', 'Header', '', '', 'inherit', 'element', '', '{\r\n  "element_type":"header",\r\n  "class":"header",\r\n  "tag":"header",\r\n  "empty_tag":false\r\n}', 0),
(10, 'element-footer', 1, '', '2016-10-27 02:35:05', '2016-11-06 13:17:09', 'Footer', '', '', 'inherit', 'element', '', '{\r\n  "element_type":"header",\r\n  "class":"header",\r\n  "tag":"header",\r\n  "empty_tag":false\r\n}', 0),
(25, 'post-test-1', 1, '', '2016-11-06 09:19:03', '2016-11-06 13:19:03', 'Post Test 1', '', '', 'inherit', 'other', '', '', 1),
(26, 'post-test-2', 1, '', '2016-11-06 09:19:03', '2016-11-06 13:19:03', 'Post Test 2', '', '', 'inherit', 'other', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `assg_users`
--

CREATE TABLE `assg_users` (
  `user_id` bigint(20) NOT NULL,
  `user_login` varchar(20) NOT NULL,
  `user_password` varchar(64) NOT NULL,
  `user_salt` varchar(32) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_joined` datetime NOT NULL,
  `user_group` int(11) NOT NULL,
  `user_meta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `assg_users`
--

INSERT INTO `assg_users` (`user_id`, `user_login`, `user_password`, `user_salt`, `user_name`, `user_joined`, `user_group`, `user_meta`) VALUES
(1, 'Admin', '$2y$10$TJL9R/Zd1X9yKZ3q9e/GMu5PIqnRGTddXBm3cpO48vNku56AcGi4u', 'i3]t bWM>s{Y^/<_Cc,g_g$I+M` G|{9', 'Administrator', '2016-08-17 11:44:35', 1, '{&amp;quot;primary_email&amp;quot;:&amp;quot;admin@atatusoft.com&amp;quot;,&amp;quot;emails&amp;quot;:&amp;quot;webmaster@atatusoft.com&amp;quot;,&amp;quot;address&amp;quot;:&amp;quot;Halifax Nova Scotia, Canada&amp;quot;,&amp;quot;phones&amp;quot;:&amp;quot;9023621706, 7058744377&amp;quot;,&amp;quot;preferences&amp;quot;:&amp;quot;&amp;quot;,&amp;quot;display_name&amp;quot;:&amp;quot;Administrator&amp;quot;,&amp;quot;profile_image&amp;quot;:&amp;quot;&amp;quot;}'),
(2, 'Editor', '$2y$10$TJL9R/Zd1X9yKZ3q9e/GMu5PIqnRGTddXBm3cpO48vNku56AcGi4u', 'i3]t bWM>s{Y^/<_Cc,g_g$I+M` G|{9', 'Editor', '2016-08-30 20:48:35', 2, '{&amp;quot;primary_email&amp;quot;:&amp;quot;editor@atatusoft.com&amp;quot;,&amp;quot;emails&amp;quot;:&amp;quot;editor.second@atatusoft.com&amp;quot;,&amp;quot;address&amp;quot;:&amp;quot;Halifax Nova Scotia, Canada&amp;quot;,&amp;quot;phones&amp;quot;:&amp;quot;9023621706, 7058744377&amp;quot;,&amp;quot;preferences&amp;quot;:&amp;quot;&amp;quot;,&amp;quot;display_name&amp;quot;:&amp;quot;The Editor&amp;quot;}');

-- --------------------------------------------------------

--
-- Table structure for table `assg_users_sessions`
--

CREATE TABLE `assg_users_sessions` (
  `session_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `session_hash` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assg_activities`
--
ALTER TABLE `assg_activities`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `assg_api_keys`
--
ALTER TABLE `assg_api_keys`
  ADD PRIMARY KEY (`key_id`),
  ADD UNIQUE KEY `key_hash` (`key_hash`);

--
-- Indexes for table `assg_categories`
--
ALTER TABLE `assg_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `assg_groups`
--
ALTER TABLE `assg_groups`
  ADD PRIMARY KEY (`group_id`),
  ADD UNIQUE KEY `group_name` (`group_name`);

--
-- Indexes for table `assg_options`
--
ALTER TABLE `assg_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `option_name` (`option_name`);

--
-- Indexes for table `assg_posts`
--
ALTER TABLE `assg_posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_name` (`post_name`);

--
-- Indexes for table `assg_users`
--
ALTER TABLE `assg_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_login` (`user_login`);

--
-- Indexes for table `assg_users_sessions`
--
ALTER TABLE `assg_users_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assg_activities`
--
ALTER TABLE `assg_activities`
  MODIFY `activity_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `assg_api_keys`
--
ALTER TABLE `assg_api_keys`
  MODIFY `key_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `assg_categories`
--
ALTER TABLE `assg_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `assg_groups`
--
ALTER TABLE `assg_groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `assg_options`
--
ALTER TABLE `assg_options`
  MODIFY `option_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `assg_posts`
--
ALTER TABLE `assg_posts`
  MODIFY `post_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `assg_users`
--
ALTER TABLE `assg_users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `assg_users_sessions`
--
ALTER TABLE `assg_users_sessions`
  MODIFY `session_id` bigint(20) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
