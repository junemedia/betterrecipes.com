/*
SQLyog Ultimate v11.42 (64 bit)
MySQL - 5.6.16-64.1-56-log : Database - betterrecipes
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`betterrecipes` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `betterrecipes`;

/*Table structure for table `actions` */

DROP TABLE IF EXISTS `actions`;

CREATE TABLE `actions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_type` enum('recipe','contest','poll') CHARACTER SET latin1 DEFAULT NULL,
  `action_description` varchar(255) CHARACTER SET latin1 NOT NULL,
  `action_message` varchar(500) CHARACTER SET latin1 NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `action_description` (`action_description`) USING BTREE,
  KEY `action_type` (`action_type`) USING BTREE,
  KEY `action_id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Table structure for table `article` */

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `slug` varchar(100) NOT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `content` text,
  `image` varchar(150) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `title_tag` varchar(255) DEFAULT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `sponsor_id` int(10) unsigned DEFAULT NULL,
  `views` int(10) unsigned DEFAULT '0',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `FK_article_user` (`user_id`),
  KEY `FK_article_category` (`category_id`),
  KEY `FK_article_sponsor` (`sponsor_id`),
  CONSTRAINT `FK_article_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `FK_article_sponsor` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsor` (`id`),
  CONSTRAINT `FK_article_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `title_tag` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` text,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `onesite_id` int(10) DEFAULT NULL,
  `sequence` int(10) unsigned DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `source` enum('nw','br','mb') NOT NULL DEFAULT 'nw',
  `legacy_id` varchar(255) DEFAULT NULL,
  `daily_dish_tag` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_category_user` (`user_id`),
  KEY `parent_id_idx` (`parent_id`),
  KEY `slug_idx` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=294 DEFAULT CHARSET=utf8;

/*Table structure for table `category_recipe` */

DROP TABLE IF EXISTS `category_recipe`;

CREATE TABLE `category_recipe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `recipe_id` int(10) unsigned NOT NULL,
  `sequence` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_category_recipe_category` (`category_id`),
  KEY `FK_category_recipe_recipe` (`recipe_id`),
  CONSTRAINT `FK_category_recipe_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_category_recipe_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=148213 DEFAULT CHARSET=utf8;

/*Table structure for table `category_wonders` */

DROP TABLE IF EXISTS `category_wonders`;

CREATE TABLE `category_wonders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `slot_one_cat_id` int(10) unsigned NOT NULL,
  `slot_one_subcat_one` int(10) unsigned DEFAULT NULL,
  `slot_one_subcat_two` int(10) unsigned DEFAULT NULL,
  `slot_one_description` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `slot_two_cat_id` int(10) unsigned NOT NULL,
  `slot_two_subcat_one` int(10) unsigned DEFAULT NULL,
  `slot_two_subcat_two` int(10) unsigned DEFAULT NULL,
  `slot_two_description` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `slot_three_cat_id` int(10) unsigned NOT NULL,
  `slot_three_subcat_one` int(10) unsigned DEFAULT NULL,
  `slot_three_subcat_two` int(10) DEFAULT NULL,
  `slot_three_description` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `slot_four_cat_id` int(10) unsigned NOT NULL,
  `slot_four_subcat_one` int(10) unsigned DEFAULT NULL,
  `slot_four_subcat_two` int(10) unsigned DEFAULT NULL,
  `slot_four_description` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_wonders_id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `collection` */

DROP TABLE IF EXISTS `collection`;

CREATE TABLE `collection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `description` text,
  `tags` varchar(255) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `sequence` int(10) unsigned NOT NULL DEFAULT '0',
  `recommendations` int(10) unsigned DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `source` enum('nw','br','mb') NOT NULL DEFAULT 'nw',
  `legacy_id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_collection_user` (`user_id`),
  CONSTRAINT `FK_collection_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3918 DEFAULT CHARSET=utf8;

/*Table structure for table `collection_recipe` */

DROP TABLE IF EXISTS `collection_recipe`;

CREATE TABLE `collection_recipe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `collection_id` int(10) unsigned NOT NULL,
  `recipe_id` int(10) unsigned NOT NULL,
  `sequence` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_collection_recipe_recipe` (`recipe_id`),
  KEY `FK_collection_recipe_collection` (`collection_id`),
  CONSTRAINT `FK_collection_recipe_collection` FOREIGN KEY (`collection_id`) REFERENCES `collection` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_collection_recipe_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13512 DEFAULT CHARSET=utf8;

/*Table structure for table `contest` */

DROP TABLE IF EXISTS `contest`;

CREATE TABLE `contest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `title_tag` varchar(255) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `prize` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `rules` longtext,
  `rules_url` varchar(255) DEFAULT NULL,
  `sequence` int(10) unsigned DEFAULT NULL,
  `sponsor_id` int(10) unsigned DEFAULT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_open_to_public` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `timezone` varchar(25) NOT NULL DEFAULT 'CST',
  `weeks` int(11) NOT NULL DEFAULT '0',
  `slideshow_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_contest_user` (`user_id`),
  KEY `FK_contest_sponsor` (`sponsor_id`),
  KEY `slug_idx` (`slug`),
  CONSTRAINT `FK_contest_sponsor` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsor` (`id`),
  CONSTRAINT `FK_contest_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8;

/*Table structure for table `contest_image` */

DROP TABLE IF EXISTS `contest_image`;

CREATE TABLE `contest_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `timezone` varchar(25) NOT NULL DEFAULT 'CST',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Table structure for table `contest_period` */

DROP TABLE IF EXISTS `contest_period`;

CREATE TABLE `contest_period` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `week_start_date` date NOT NULL,
  `week_end_date` date NOT NULL,
  `contest_id` int(10) unsigned DEFAULT NULL,
  `unofficial_winner_id` int(10) unsigned DEFAULT NULL,
  `official_winner_id` int(10) unsigned DEFAULT NULL,
  `editor_winner_id` int(10) unsigned DEFAULT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `week_offset` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_contest_user` (`user_id`),
  KEY `FK_contest_period_contest` (`contest_id`),
  KEY `FK_contest_period_unoffical_winner` (`unofficial_winner_id`),
  KEY `FK_contest_period_offical_winner` (`official_winner_id`),
  KEY `FK_editor_winner` (`editor_winner_id`),
  CONSTRAINT `FK_contest_period_contest` FOREIGN KEY (`contest_id`) REFERENCES `contest` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_contest_period_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=244 DEFAULT CHARSET=utf8;

/*Table structure for table `contestant` */

DROP TABLE IF EXISTS `contestant`;

CREATE TABLE `contestant` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recipe_id` int(10) unsigned NOT NULL,
  `contest_id` int(10) unsigned NOT NULL,
  `vote_count` int(10) unsigned NOT NULL DEFAULT '0',
  `rank` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL,
  `email_status` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_contestant_recipe` (`recipe_id`),
  KEY `FK_contestant_contest` (`contest_id`),
  KEY `FK_contestant_user` (`user_id`),
  CONSTRAINT `FK_contestant_contest` FOREIGN KEY (`contest_id`) REFERENCES `contest` (`id`),
  CONSTRAINT `FK_contestant_contest_period` FOREIGN KEY (`contest_id`) REFERENCES `contest_period` (`contest_id`) ON DELETE CASCADE,
  CONSTRAINT `FK_contestant_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`),
  CONSTRAINT `FK_contestant_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10533 DEFAULT CHARSET=utf8;

/*Table structure for table `daily_dish` */

DROP TABLE IF EXISTS `daily_dish`;

CREATE TABLE `daily_dish` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=682 DEFAULT CHARSET=utf8;

/*Table structure for table `discussion` */

DROP TABLE IF EXISTS `discussion`;

CREATE TABLE `discussion` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(11) unsigned NOT NULL COMMENT 'assume it refers to a onesite ID or recipe ID',
  `content_type` enum('slideshow','article','video','photo','recipe','journal','daily-dish','raves') NOT NULL DEFAULT 'recipe',
  `discussion_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1290 DEFAULT CHARSET=utf8;

/*Table structure for table `group` */

DROP TABLE IF EXISTS `group`;

CREATE TABLE `group` (
  `id` int(10) unsigned NOT NULL,
  `blog_id` int(10) unsigned DEFAULT NULL,
  `forum_id` int(10) unsigned DEFAULT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `group_slug` varchar(255) DEFAULT NULL,
  `sponsor_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_group_category` (`category_id`),
  KEY `FK_group_sponsor` (`sponsor_id`),
  KEY `group_slug_idx` (`group_slug`),
  CONSTRAINT `FK_group_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `FK_group_sponsor` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsor` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `group_recipe` */

DROP TABLE IF EXISTS `group_recipe`;

CREATE TABLE `group_recipe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `recipe_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `recipe_id` (`recipe_id`),
  CONSTRAINT `FK_group_recipe_group` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_group_recipe_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=404560 DEFAULT CHARSET=utf8;

/*Table structure for table `interest` */

DROP TABLE IF EXISTS `interest`;

CREATE TABLE `interest` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_idx` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Table structure for table `madeit` */

DROP TABLE IF EXISTS `madeit`;

CREATE TABLE `madeit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recipe_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_madeit_recipe` (`recipe_id`),
  KEY `FK_madeit_user` (`user_id`),
  CONSTRAINT `FK_madeit_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`),
  CONSTRAINT `FK_madeit_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `message` */

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `message_type` enum('member','non-member') NOT NULL DEFAULT 'member',
  `recipient_email` text,
  `recipient_name` text,
  `recipient_id` text,
  `comment` text,
  `sent` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

/*Table structure for table `meta` */

DROP TABLE IF EXISTS `meta`;

CREATE TABLE `meta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `keywords` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `FK_meta_user` (`user_id`),
  KEY `slug` (`slug`),
  CONSTRAINT `FK_meta_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Table structure for table `override` */

DROP TABLE IF EXISTS `override`;

CREATE TABLE `override` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module` enum('recipe','category','article','slideshow') NOT NULL DEFAULT 'recipe',
  `category_id` int(10) unsigned DEFAULT NULL,
  `is_global` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_mobile` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_override_category` (`category_id`),
  KEY `FK_override_user` (`user_id`),
  KEY `is_global_idx` (`is_global`),
  KEY `start_date_idx` (`start_date`),
  KEY `end_date_idx` (`end_date`),
  CONSTRAINT `FK_override_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_override_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;

/*Table structure for table `photo` */

DROP TABLE IF EXISTS `photo`;

CREATE TABLE `photo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(150) DEFAULT NULL,
  `thumb` varchar(150) DEFAULT NULL,
  `sequence` int(10) unsigned DEFAULT '1',
  `recipe_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `source` enum('nw','br','mb') NOT NULL DEFAULT 'nw',
  `legacy_id` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_photo_recipe` (`recipe_id`),
  KEY `FK_photo_user` (`user_id`),
  CONSTRAINT `FK_photo_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE SET NULL,
  CONSTRAINT `FK_photo_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47791 DEFAULT CHARSET=utf8;

/*Table structure for table `poll` */

DROP TABLE IF EXISTS `poll`;

CREATE TABLE `poll` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `homepage_featured` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `poll_title` varchar(255) DEFAULT NULL,
  `total_votes` int(4) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `homepage_featured` (`homepage_featured`)
) ENGINE=InnoDB AUTO_INCREMENT=262246 DEFAULT CHARSET=utf8;

/*Table structure for table `poll_option` */

DROP TABLE IF EXISTS `poll_option`;

CREATE TABLE `poll_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `poll_id` int(10) unsigned NOT NULL,
  `recipe_id` int(10) unsigned DEFAULT NULL,
  `photo_id` int(10) unsigned DEFAULT NULL,
  `option_title` varchar(255) DEFAULT NULL,
  `votes` int(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_poll_option_poll` (`poll_id`),
  KEY `FK_poll_option_recipe` (`recipe_id`),
  KEY `FK_poll_option_photo` (`photo_id`),
  CONSTRAINT `FK_poll_option_photo` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id`) ON DELETE SET NULL,
  CONSTRAINT `FK_poll_option_poll` FOREIGN KEY (`poll_id`) REFERENCES `poll` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_poll_option_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

/*Table structure for table `position_count` */

DROP TABLE IF EXISTS `position_count`;

CREATE TABLE `position_count` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `override_id` int(10) unsigned NOT NULL,
  `count` tinyint(2) unsigned NOT NULL DEFAULT '5',
  PRIMARY KEY (`id`),
  KEY `FK_position_count_override` (`override_id`),
  CONSTRAINT `FK_position_count_override` FOREIGN KEY (`override_id`) REFERENCES `override` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;

/*Table structure for table `rate` */

DROP TABLE IF EXISTS `rate`;

CREATE TABLE `rate` (
  `recipe_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `rating` int(1) unsigned NOT NULL,
  PRIMARY KEY (`recipe_id`,`user_id`),
  KEY `FK_rate_user` (`user_id`),
  CONSTRAINT `FK_rate_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rate_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `recipe` */

DROP TABLE IF EXISTS `recipe`;

CREATE TABLE `recipe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `introduction` text,
  `ingredients` text,
  `description` text,
  `servings` varchar(150) DEFAULT NULL,
  `preptime` varchar(150) DEFAULT NULL,
  `cooktime` varchar(150) DEFAULT NULL,
  `totaltime` varchar(255) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `title_tag` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `notes` text,
  `quick_recipe` varchar(1) DEFAULT NULL,
  `rating` decimal(5,4) DEFAULT '0.0000',
  `rating_count` int(10) NOT NULL DEFAULT '0',
  `main_ingredient` varchar(100) DEFAULT NULL,
  `course` enum('desserts','side dish','breakfast brunch','main dish','appetizer','beverages','other') DEFAULT 'other',
  `origin` varchar(150) DEFAULT NULL,
  `instructions` text,
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `recommendations` int(10) unsigned DEFAULT NULL,
  `sponsor_id` int(10) unsigned DEFAULT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `updated_by_id` int(10) unsigned DEFAULT NULL,
  `onesite_id` int(10) DEFAULT NULL,
  `initial_cat_id` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `source` enum('nw','br','mb') NOT NULL DEFAULT 'nw',
  `legacy_id` varchar(40) DEFAULT NULL,
  `is_featured` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_recipe_sponsor` (`sponsor_id`),
  KEY `FK_recipe` (`user_id`),
  KEY `is_active_idx` (`is_active`),
  KEY `views_idx` (`views`),
  KEY `slug_idx` (`slug`),
  KEY `FK_recipe_updated_by` (`updated_by_id`),
  CONSTRAINT `FK_recipe` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_recipe_sponsor` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102741 DEFAULT CHARSET=utf8;

/*Table structure for table `recipe_like` */

DROP TABLE IF EXISTS `recipe_like`;

CREATE TABLE `recipe_like` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `recipe_id` int(10) unsigned NOT NULL,
  `is_liked` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `recipe_id` (`recipe_id`),
  CONSTRAINT `recipe_like_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE,
  CONSTRAINT `recipe_like_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

/*Table structure for table `saved` */

DROP TABLE IF EXISTS `saved`;

CREATE TABLE `saved` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recipe_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_saved_user` (`user_id`),
  KEY `FK_saved_recipe` (`recipe_id`),
  CONSTRAINT `FK_saved_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`),
  CONSTRAINT `FK_saved_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1420063 DEFAULT CHARSET=utf8;

/*Table structure for table `slideshow` */

DROP TABLE IF EXISTS `slideshow`;

CREATE TABLE `slideshow` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` text,
  `slug` varchar(255) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `title_tag` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `photo_id` int(10) unsigned DEFAULT NULL,
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `views` int(10) unsigned DEFAULT '0',
  `category_id` int(10) unsigned DEFAULT NULL,
  `sponsor_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_slideshow_user` (`user_id`),
  KEY `FK_slideshow_sponsor` (`sponsor_id`),
  KEY `FK_slideshow_category` (`category_id`),
  KEY `slug_idx` (`slug`),
  CONSTRAINT `FK_slideshow_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `FK_slideshow_sponsor` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsor` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `FK_slideshow_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=utf8;

/*Table structure for table `slideshow_medium` */

DROP TABLE IF EXISTS `slideshow_medium`;

CREATE TABLE `slideshow_medium` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slideshow_id` int(10) unsigned NOT NULL,
  `medium_type` enum('recipe-photo') DEFAULT 'recipe-photo',
  `medium_id` int(10) unsigned NOT NULL,
  `sequence` int(10) unsigned NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `FK_slideshow_medium_slideshow` (`slideshow_id`),
  CONSTRAINT `FK_slideshow_medium_slideshow` FOREIGN KEY (`slideshow_id`) REFERENCES `slideshow` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6786 DEFAULT CHARSET=utf8;

/*Table structure for table `sponsor` */

DROP TABLE IF EXISTS `sponsor`;

CREATE TABLE `sponsor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `url` varchar(255) DEFAULT NULL,
  `adtag` text,
  `image` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sponsor_user` (`user_id`),
  CONSTRAINT `FK_sponsor_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Table structure for table `tip` */

DROP TABLE IF EXISTS `tip`;

CREATE TABLE `tip` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `updated_by` int(11) unsigned NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_tip_updated_by` (`updated_by`),
  CONSTRAINT `FK_tip_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `tip_contest` */

DROP TABLE IF EXISTS `tip_contest`;

CREATE TABLE `tip_contest` (
  `tip_id` int(11) unsigned NOT NULL,
  `contest_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`tip_id`,`contest_id`),
  KEY `FK_tip_contest_contest` (`contest_id`),
  CONSTRAINT `FK_tip_contest_contest` FOREIGN KEY (`contest_id`) REFERENCES `contest` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_tip_contest_tip` FOREIGN KEY (`tip_id`) REFERENCES `tip` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `onesite_id` int(10) DEFAULT NULL,
  `blog_id` int(10) DEFAULT NULL,
  `profile_id` varchar(40) DEFAULT NULL,
  `fb_id` varchar(255) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `subdir` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `avatar` varchar(50) NOT NULL DEFAULT '1',
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_super_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_premium` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `fb_share` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_active` tinyint(1) unsigned DEFAULT '1',
  `reg_source` smallint(6) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `source` enum('nw','br','mb') DEFAULT NULL,
  `legacy_id` varchar(40) DEFAULT NULL,
  `website_name` varchar(25) DEFAULT NULL,
  `website_address` varchar(255) DEFAULT NULL,
  `is_featured_blogger` tinyint(1) unsigned DEFAULT '0',
  `about_me` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fb_id_idx` (`fb_id`),
  KEY `profile_id` (`profile_id`),
  KEY `source` (`source`),
  KEY `subdir_idx` (`subdir`),
  KEY `legacy_id` (`legacy_id`),
  KEY `onesite_id_idx` (`onesite_id`),
  KEY `display_name` (`display_name`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=365778 DEFAULT CHARSET=utf8;

/*Table structure for table `user_actions` */

DROP TABLE IF EXISTS `user_actions`;

CREATE TABLE `user_actions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `fb_user_id` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `fb_object_id` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `action_id` int(10) unsigned NOT NULL,
  `recipe_id` int(10) unsigned DEFAULT NULL,
  `poll_option_id` int(10) unsigned DEFAULT NULL,
  `contestant_id` int(10) unsigned DEFAULT NULL,
  `message` varchar(500) CHARACTER SET latin1 DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_actions_user` (`user_id`),
  KEY `user_actions_action` (`action_id`),
  KEY `user_action_id` (`id`) USING BTREE,
  KEY `user_action_fb` (`fb_user_id`) USING BTREE,
  KEY `user_action_recipe` (`recipe_id`) USING BTREE,
  KEY `user_action_poll` (`poll_option_id`) USING BTREE,
  KEY `user_action_contest` (`contestant_id`) USING BTREE,
  CONSTRAINT `FK_user_actions_contestant` FOREIGN KEY (`contestant_id`) REFERENCES `contestant` (`id`),
  CONSTRAINT `FK_user_actions_poll_option` FOREIGN KEY (`poll_option_id`) REFERENCES `poll_option` (`id`),
  CONSTRAINT `user_actions_action` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_actions_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_actions_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=475776 DEFAULT CHARSET=utf8;

/*Table structure for table `user_interest` */

DROP TABLE IF EXISTS `user_interest`;

CREATE TABLE `user_interest` (
  `user_id` int(10) unsigned NOT NULL,
  `interest_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`interest_id`),
  KEY `interest_id` (`interest_id`),
  CONSTRAINT `user_interest_interest` FOREIGN KEY (`interest_id`) REFERENCES `interest` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_interest_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `user_provider` */

DROP TABLE IF EXISTS `user_provider`;

CREATE TABLE `user_provider` (
  `user_id` int(11) unsigned NOT NULL,
  `provider` varchar(64) NOT NULL DEFAULT '',
  `provider_uid` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`provider`),
  KEY `provider_uid_idx` (`provider_uid`),
  CONSTRAINT `user_provider_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vote` */

DROP TABLE IF EXISTS `vote`;

CREATE TABLE `vote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contestant_id` int(10) unsigned NOT NULL,
  `ip_address` int(10) unsigned NOT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `uid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vote_contestant` (`contestant_id`),
  KEY `FK_vote_user` (`user_id`),
  CONSTRAINT `FK_vote_contestant` FOREIGN KEY (`contestant_id`) REFERENCES `contestant` (`id`),
  CONSTRAINT `FK_vote_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=119674 DEFAULT CHARSET=utf8;

/*Table structure for table `weight` */

DROP TABLE IF EXISTS `weight`;

CREATE TABLE `weight` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `override_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `rank` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_weight_override` (`override_id`),
  KEY `item_id_idx` (`item_id`),
  KEY `rank_idx` (`rank`),
  CONSTRAINT `FK_weight_override` FOREIGN KEY (`override_id`) REFERENCES `override` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8;

/*Table structure for table `wonders` */

DROP TABLE IF EXISTS `wonders`;

CREATE TABLE `wonders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `homepage_featured` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `slot_one_title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `slot_one_url` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `slot_one_img` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `slot_two_title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `slot_two_url` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `slot_two_img` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `slot_three_title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `slot_three_url` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `slot_three_img` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `slot_four_title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `slot_four_url` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `slot_four_img` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `slot_five_title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `slot_five_url` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `slot_five_img` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/* Procedure structure for procedure `deleteDuplicateUser` */

/*!50003 DROP PROCEDURE IF EXISTS  `deleteDuplicateUser` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `deleteDuplicateUser`(source INT UNSIGNED, target INT UNSIGNED)
BEGIN
 
UPDATE article SET user_id = target WHERE user_id = source;
UPDATE category SET user_id = target WHERE user_id = source;
UPDATE collection SET user_id = target WHERE user_id = source;
UPDATE madeit SET user_id = target WHERE user_id = source;
UPDATE override SET user_id = target WHERE user_id = source;
UPDATE photo SET user_id = target WHERE user_id = source;
UPDATE rate SET user_id = target WHERE user_id = source;
UPDATE recipe SET user_id = target WHERE user_id = source;
UPDATE saved SET user_id = target WHERE user_id = source;
UPDATE slideshow SET user_id = target WHERE user_id = source;
UPDATE user_interest SET user_id = target WHERE user_id = source;
UPDATE user_provider SET user_id = target WHERE user_id = source;
DELETE FROM `betterrecipes`.`user` WHERE `id` = source;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `deleteInactiveRecipeContestants` */

/*!50003 DROP PROCEDURE IF EXISTS  `deleteInactiveRecipeContestants` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `deleteInactiveRecipeContestants`()
BEGIN
DELETE vt FROM 
 vote vt
INNER JOIN contestant ON vt.contestant_id = contestant.id
  INNER JOIN recipe
    ON recipe.id = contestant.recipe_id
  INNER JOIN contest_period
    ON contestant.contest_id = contest_period.contest_id
  INNER JOIN contest
    ON contestant.contest_id = contest.id
WHERE recipe.is_active = 0
    AND (contestant.id != contest_period.official_winner_id
          OR contestant.id != contest_period.unofficial_winner_id
          OR contestant.id != contest_period.editor_winner_id);
DELETE cst
  
FROM contestant cst
  INNER JOIN recipe
    ON recipe.id = cst.recipe_id
  INNER JOIN contest_period
    ON cst.contest_id = contest_period.contest_id
  INNER JOIN contest
    ON cst.contest_id = contest.id
WHERE recipe.is_active = 0
    AND (cst.id != contest_period.official_winner_id
          OR cst.id != contest_period.unofficial_winner_id
          OR cst.id != contest_period.editor_winner_id);
CALL deleteInactiveRecipes();
END */$$
DELIMITER ;

/* Procedure structure for procedure `deleteInactiveRecipes` */

/*!50003 DROP PROCEDURE IF EXISTS  `deleteInactiveRecipes` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `deleteInactiveRecipes`()
BEGIN
DELETE rt FROM betterrecipes.rate rt INNER JOIN betterrecipes.recipe ON (recipe.id = rt.recipe_id) LEFT JOIN betterrecipes.contestant ON (contestant.recipe_id = recipe.id) WHERE (recipe.is_active =0 AND contestant.id IS NULL);
DELETE mi FROM betterrecipes.madeit mi INNER JOIN betterrecipes.recipe ON (recipe.id = mi.recipe_id) LEFT JOIN betterrecipes.contestant ON (contestant.recipe_id = recipe.id) WHERE (recipe.is_active =0 AND contestant.id IS NULL);
DELETE clr FROM betterrecipes.collection_recipe clr INNER JOIN betterrecipes.recipe ON (recipe.id = clr.recipe_id) LEFT JOIN betterrecipes.contestant ON (contestant.recipe_id = recipe.id) WHERE (recipe.is_active = 0 AND contestant.id IS NULL);
DELETE svd FROM betterrecipes.saved svd INNER JOIN betterrecipes.recipe ON (recipe.id = svd.recipe_id) LEFT JOIN betterrecipes.contestant ON (contestant.recipe_id = recipe.id) WHERE (recipe.is_active = 0 AND contestant.id IS NULL);
DELETE lmr FROM betterrecipes.legacy_mb_recipe lmr INNER JOIN betterrecipes.recipe ON (recipe.id = lmr.recipe_id) LEFT JOIN betterrecipes.contestant ON (contestant.recipe_id = recipe.id) WHERE (recipe.is_active = 0 AND contestant.id IS NULL);
DELETE shm FROM betterrecipes.slideshow_medium shm INNER JOIN betterrecipes.recipe ON (recipe.id = shm.medium_id) LEFT JOIN betterrecipes.contestant ON (contestant.recipe_id = recipe.id) WHERE (recipe.is_active = 0 AND contestant.id IS NULL AND shm.medium_type="recipe-photo");
DELETE pht FROM betterrecipes.photo pht INNER JOIN betterrecipes.recipe ON (recipe.id = pht.recipe_id) LEFT JOIN betterrecipes.contestant ON (contestant.recipe_id = recipe.id) WHERE (recipe.is_active = 0 AND contestant.id IS NULL);
DELETE gr FROM betterrecipes.group_recipe gr INNER JOIN betterrecipes.recipe ON (recipe.id = gr.recipe_id) LEFT JOIN betterrecipes.contestant ON (contestant.recipe_id = recipe.id) WHERE (recipe.is_active = 0 AND contestant.id IS NULL);
DELETE cr FROM betterrecipes.category_recipe cr INNER JOIN betterrecipes.recipe ON (recipe.id = cr.recipe_id) LEFT JOIN betterrecipes.contestant ON (contestant.recipe_id = recipe.id) WHERE (recipe.is_active = 0 AND contestant.id IS NULL);
DELETE wgt FROM betterrecipes.weight wgt INNER JOIN override ON (override.id = wgt.override_id) INNER JOIN betterrecipes.recipe ON (recipe.id = wgt.item_id) LEFT JOIN betterrecipes.contestant ON (contestant.recipe_id = recipe.id) WHERE (override.module = "recipe" AND recipe.is_active = 0 AND contestant.id IS NULL);
DELETE rcp FROM betterrecipes.recipe rcp LEFT JOIN betterrecipes.contestant ON (contestant.recipe_id = rcp.id) WHERE (contestant.id IS NULL AND rcp.is_active =0);
END */$$
DELIMITER ;

/* Procedure structure for procedure `getMonthlyStats` */

/*!50003 DROP PROCEDURE IF EXISTS  `getMonthlyStats` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `getMonthlyStats`(IN in_date CHAR(10))
BEGIN
SET @sql_stmt = CONCAT('
SELECT
(SELECT COUNT(1) FROM rate) AS `Total Number of Ratings`,
(SELECT COUNT(1) FROM vote WHERE created_at LIKE "',DATE_FORMAT(in_date,"%Y-%m"),'%") AS `Total Number of Votes in ',date_format(in_date, "%M %Y") ,'`,
(SELECT COUNT(1) FROM recipe WHERE created_at < "',DATE_FORMAT(DATE_ADD(in_date,INTERVAL 1 MONTH),"%Y-%m"),'") AS `Total Number of Recipes (as off ',DATE_FORMAT(in_date, "%M %e") ,')`,
(SELECT COUNT(1) FROM recipe WHERE created_at < "',DATE_FORMAT(DATE_ADD(in_date,INTERVAL 1 MONTH),"%Y-%m"),'" AND is_active = 1) AS `Total Number of Active Recipes (as off ',DATE_FORMAT(in_date, "%M %e") ,')`,
(SELECT COUNT(1) FROM recipe WHERE created_at LIKE "',DATE_FORMAT(in_date, "%Y-%m"),'%") AS `Total Number of Recipes created in ',DATE_FORMAT(in_date, "%M %Y") ,'`,
(SELECT COUNT(1) FROM recipe WHERE created_at LIKE "',DATE_FORMAT(in_date, "%Y-%m"),'%" AND is_active = 1) AS `Total Number of Active Recipes created in ',DATE_FORMAT(in_date, "%M %Y") ,'`;'
);
  PREPARE stmt FROM @sql_stmt;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;
END */$$
DELIMITER ;

/* Procedure structure for procedure `mergeDuplicateUser` */

/*!50003 DROP PROCEDURE IF EXISTS  `mergeDuplicateUser` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `mergeDuplicateUser`(source INT UNSIGNED, target INT UNSIGNED)
BEGIN
 
UPDATE article SET user_id = target WHERE user_id = source;
UPDATE category SET user_id = target WHERE user_id = source;
UPDATE collection SET user_id = target WHERE user_id = source;
UPDATE madeit SET user_id = target WHERE user_id = source;
UPDATE override SET user_id = target WHERE user_id = source;
UPDATE photo SET user_id = target WHERE user_id = source;
UPDATE rate SET user_id = target WHERE user_id = source;
UPDATE recipe SET user_id = target WHERE user_id = source;
UPDATE saved SET user_id = target WHERE user_id = source;
UPDATE slideshow SET user_id = target WHERE user_id = source;
UPDATE user_interest SET user_id = target WHERE user_id = source;
UPDATE user_provider SET user_id = target WHERE user_id = source;
UPDATE `user` SET `email` = CONCAT(`email`, '_inactive_dup'),
  `is_active` = '0'
WHERE `id` = source;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `reverseDuplicateUser` */

/*!50003 DROP PROCEDURE IF EXISTS  `reverseDuplicateUser` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `reverseDuplicateUser`(source INT UNSIGNED, target INT UNSIGNED)
BEGIN
 
UPDATE article SET user_id = target WHERE user_id = source;
UPDATE category SET user_id = target WHERE user_id = source;
UPDATE collection SET user_id = target WHERE user_id = source;
UPDATE madeit SET user_id = target WHERE user_id = source;
UPDATE override SET user_id = target WHERE user_id = source;
UPDATE photo SET user_id = target WHERE user_id = source;
UPDATE rate SET user_id = target WHERE user_id = source;
UPDATE recipe SET user_id = target WHERE user_id = source;
UPDATE saved SET user_id = target WHERE user_id = source;
UPDATE slideshow SET user_id = target WHERE user_id = source;
UPDATE user_interest SET user_id = target WHERE user_id = source;
UPDATE user_provider SET user_id = target WHERE user_id = source;
UPDATE `user` SET `email` = REPLACE(email, '_inactive_dup', ''),
  `is_active` = '1'
WHERE `id` = target;
UPDATE `user` SET `email` = CONCAT(`email`, '_inactive_dup'),
  `is_active` = '0'
WHERE `id` = source;
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
