
CREATE TABLE IF NOT EXISTS `wp_access_token` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `access_token` varchar(255) NOT NULL,
  `expires` varchar(32) NOT NULL,
  `remote_addr` varchar(64) NOT NULL,
  `insert_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
