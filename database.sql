DROP TABLE IF EXISTS `adjacency_groups`;

#
# Table structure for table 'adjacency_groups'
#

CREATE TABLE `adjacency_groups` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

#
# Dumping data for table 'adjacency_groups'
#

INSERT INTO `adjacency_groups` (`id`, `name`, `slug`) VALUES
(1, 'Languages', 'languages');



DROP TABLE IF EXISTS `adjacency_lists`;

#
# Table structure for table 'adjacency_lists'
#

CREATE TABLE IF NOT EXISTS `adjacency_lists` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `url` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `position` mediumint(8) unsigned NOT NULL DEFAULT '100',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `group_id` smallint(4) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

#
# Dumping data for table 'adjacency_lists'
#

INSERT INTO `adjacency_lists` (`id`, `name`, `url`, `position`, `parent_id`, `group_id`) VALUES
(1, 'PHP', 'http://php.net', 100, 0, 1),
(2, 'Python', 'http://python.org', 100, 0, 1),
(3, 'Ruby', 'http://www.ruby-lang.org', 100, 0, 1),
(4, 'CodeIgniter', 'http://ellislab.com/codeigniter', 100, 1, 1),
(5, 'Laravel', 'http://laravel.com', 100, 1, 1),
(6, 'Django', 'https://www.djangoproject.com/', 100, 2, 1),
(7, 'Pylons', 'http://www.pylonsproject.org/', 100, 2, 1),
(8, 'Ruby on Rails', 'http://rubyonrails.org', 100, 3, 1),
(9, 'Sinatra', 'http://www.sinatrarb.com', 100, 3, 1);