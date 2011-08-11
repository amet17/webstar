CREATE TABLE IF NOT EXISTS `#__sk_configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_key` varchar(50) DEFAULT NULL,
  `config_value` text,
  PRIMARY KEY (`id`)
);

-- --------------------------------------------------------

--
-- Table structure for table `#__sk_messages`
--

CREATE TABLE IF NOT EXISTS `#__sk_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- --------------------------------------------------------

--
-- Table structure for table `#__sk_users`
--

CREATE TABLE IF NOT EXISTS `#__sk_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `block` tinyint(3) DEFAULT '0',
  `hide` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);