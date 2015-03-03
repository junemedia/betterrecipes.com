CREATE TABLE `article` (`id` INT UNSIGNED AUTO_INCREMENT, `name` VARCHAR(100) NOT NULL, `slug` VARCHAR(100) NOT NULL, `summary` VARCHAR(255), `content` TEXT, `image` VARCHAR(150), `keywords` VARCHAR(255), `category_id` INT UNSIGNED, `sponsor_id` INT UNSIGNED, `views` INT UNSIGNED DEFAULT '0', `is_active` TINYINT UNSIGNED DEFAULT '1' NOT NULL, `user_id` INT UNSIGNED NOT NULL, `created_at` DATETIME, `updated_at` DATETIME, INDEX `category_id_idx` (`category_id`), INDEX `sponsor_id_idx` (`sponsor_id`), INDEX `user_id_idx` (`user_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `category` (`id` INT UNSIGNED AUTO_INCREMENT, `name` VARCHAR(255) NOT NULL, `slug` VARCHAR(255) NOT NULL, `parent_id` INT UNSIGNED, `summary` VARCHAR(255), `keywords` VARCHAR(255), `description` TEXT, `is_active` TINYINT UNSIGNED DEFAULT '1' NOT NULL, `user_id` INT UNSIGNED NOT NULL, `onesite_id` INT, `sequence` INT UNSIGNED DEFAULT '1', `created_at` DATETIME, `updated_at` DATETIME, `source` ENUM('nw', 'br', 'mb') DEFAULT 'nw' NOT NULL, `legacy_id` VARCHAR(255), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `category_mapping_csv` (`id` BIGINT AUTO_INCREMENT, `old_id` INT UNSIGNED, `new_id` INT UNSIGNED, PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `category_recipe` (`id` INT UNSIGNED AUTO_INCREMENT, `category_id` INT UNSIGNED NOT NULL, `recipe_id` INT UNSIGNED NOT NULL, `sequence` INT UNSIGNED DEFAULT '1' NOT NULL, INDEX `category_id_idx` (`category_id`), INDEX `recipe_id_idx` (`recipe_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `collection` (`id` INT UNSIGNED AUTO_INCREMENT, `name` VARCHAR(60) NOT NULL, `description` TEXT, `tags` VARCHAR(255), `user_id` INT UNSIGNED NOT NULL, `sequence` INT UNSIGNED DEFAULT '0' NOT NULL, `recommendations` INT UNSIGNED DEFAULT '0', `updated_at` DATETIME, `created_at` DATETIME, `source` ENUM('nw', 'br', 'mb') DEFAULT 'nw' NOT NULL, `legacy_id` VARCHAR(20), INDEX `user_id_idx` (`user_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `collection_recipe` (`id` INT UNSIGNED AUTO_INCREMENT, `collection_id` INT UNSIGNED NOT NULL, `recipe_id` INT UNSIGNED NOT NULL, `sequence` INT UNSIGNED DEFAULT '0' NOT NULL, INDEX `collection_id_idx` (`collection_id`), INDEX `recipe_id_idx` (`recipe_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `content` (`id` INT UNSIGNED AUTO_INCREMENT, `type` ENUM('slideshow', 'article', 'video', 'photo') DEFAULT 'slideshow' NOT NULL, `title` VARCHAR(150) NOT NULL, `description` TEXT, `slug` VARCHAR(255), `keywords` VARCHAR(255), `photo_id` INT UNSIGNED, `is_active` TINYINT UNSIGNED DEFAULT '1' NOT NULL, `sporsor_id` INT UNSIGNED, `user_id` INT UNSIGNED NOT NULL, `created_at` DATETIME DEFAULT '0000-00-00 00:00:00', `updated_at` DATETIME DEFAULT '0000-00-00 00:00:00', INDEX `sporsor_id_idx` (`sporsor_id`), INDEX `user_id_idx` (`user_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `content_medium` (`id` INT UNSIGNED AUTO_INCREMENT, `content_id` INT UNSIGNED NOT NULL, `medium_id` INT UNSIGNED NOT NULL, `sequence` INT UNSIGNED NOT NULL, INDEX `content_id_idx` (`content_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `contest` (`id` INT UNSIGNED AUTO_INCREMENT, `name` VARCHAR(255) NOT NULL, `description` TEXT, `title_tag` VARCHAR(255), `summary` VARCHAR(255), `prize` VARCHAR(255), `keywords` VARCHAR(255), `image` VARCHAR(150), `rules` TEXT, `rules_url` VARCHAR(255), `sequence` INT UNSIGNED, `sponsor_id` INT UNSIGNED, `is_active` TINYINT UNSIGNED DEFAULT '1' NOT NULL, `user_id` INT UNSIGNED NOT NULL, `created_at` DATETIME, `updated_at` DATETIME, `start_date` DATETIME, `end_date` DATETIME, INDEX `sponsor_id_idx` (`sponsor_id`), INDEX `user_id_idx` (`user_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `contest_period` (`id` INT UNSIGNED AUTO_INCREMENT, `start_date` DATETIME NOT NULL, `end_date` DATETIME NOT NULL, `contest_id` INT UNSIGNED, `winner_id` INT UNSIGNED, `editor_winner_id` INT UNSIGNED, `sponsor_id` INT UNSIGNED, `is_active` TINYINT UNSIGNED DEFAULT '1' NOT NULL, `user_id` INT UNSIGNED NOT NULL, `created_at` DATETIME, `updated_at` DATETIME, INDEX `user_id_idx` (`user_id`), INDEX `contest_id_idx` (`contest_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `contestant` (`id` INT UNSIGNED AUTO_INCREMENT, `legacy_id` VARCHAR(20), `contest_period_id` INT UNSIGNED NOT NULL, `recipe_id` INT UNSIGNED NOT NULL, `vote_count` INT UNSIGNED DEFAULT '0' NOT NULL, `is_winner` TINYINT UNSIGNED DEFAULT '0' NOT NULL, `is_editor_winner` TINYINT UNSIGNED DEFAULT '0' NOT NULL, `is_finalist` TINYINT UNSIGNED DEFAULT '0' NOT NULL, INDEX `contest_period_id_idx` (`contest_period_id`), INDEX `recipe_id_idx` (`recipe_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `daily_dish` (`id` INT UNSIGNED AUTO_INCREMENT, `slug` TEXT NOT NULL, PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `discussion` (`id` INT UNSIGNED AUTO_INCREMENT, `content_id` INT UNSIGNED NOT NULL, `content_type` ENUM('slideshow', 'article', 'video', 'photo', 'recipe', 'journal', 'daily-dish', 'raves') DEFAULT 'recipe' NOT NULL, `discussion_id` INT UNSIGNED NOT NULL, PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `group` (`id` INT UNSIGNED, `blog_id` INT UNSIGNED, `forum_id` INT UNSIGNED, `category_id` INT UNSIGNED, `group_slug` VARCHAR(255), `sponsor_id` INT UNSIGNED, INDEX `category_id_idx` (`category_id`), INDEX `sponsor_id_idx` (`sponsor_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `group_recipe` (`id` INT UNSIGNED AUTO_INCREMENT, `group_id` INT UNSIGNED NOT NULL, `recipe_id` INT UNSIGNED NOT NULL, INDEX `group_id_idx` (`group_id`), INDEX `recipe_id_idx` (`recipe_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `groupmessage` (`groupid` INT, `messageid` INT, `memberid` INT, `reftypeid` CHAR(1), `srcgroupid` INT, `creationdt` DATETIME, `groupmessagecategoryid` INT, `emailssent` TINYINT DEFAULT '0', `groupmessageid` INT NOT NULL, `parentpath` TEXT NOT NULL, `subject` VARCHAR(200), `messagebody` TEXT, `status` CHAR(1), `targetgroupid` INT, PRIMARY KEY(`groupid`, `messageid`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `interest` (`id` INT UNSIGNED AUTO_INCREMENT, `name` VARCHAR(128) DEFAULT '' NOT NULL, `description` TEXT, PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `legacy_mb_recipe` (`recipe_id` INT UNSIGNED NOT NULL, `message_id` INT UNSIGNED, `group_id` INT UNSIGNED, INDEX `recipe_id_idx` (`recipe_id`), PRIMARY KEY(`message_id`, `group_id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `madeit` (`id` INT UNSIGNED AUTO_INCREMENT, `recipe_id` INT UNSIGNED NOT NULL, `user_id` INT UNSIGNED NOT NULL, INDEX `recipe_id_idx` (`recipe_id`), INDEX `user_id_idx` (`user_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `message` (`id` INT UNSIGNED AUTO_INCREMENT, `message_type` ENUM('member', 'non-member') DEFAULT 'member' NOT NULL, `recipient_email` TEXT, `recipient_name` TEXT, `recipient_id` TEXT, `comment` TEXT, `sent` TINYINT UNSIGNED DEFAULT '0' NOT NULL, `created_at` DATETIME, `updated_at` DATETIME, PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `override` (`id` INT UNSIGNED AUTO_INCREMENT, `module` ENUM('recipe', 'category', 'article') DEFAULT 'recipe' NOT NULL, `category_id` INT UNSIGNED, `is_global` TINYINT UNSIGNED DEFAULT '0' NOT NULL, `start_date` DATETIME NOT NULL, `end_date` DATETIME NOT NULL, `user_id` INT UNSIGNED NOT NULL, `created_at` DATETIME, `updated_at` DATETIME, INDEX `category_id_idx` (`category_id`), INDEX `user_id_idx` (`user_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `photo` (`id` INT UNSIGNED AUTO_INCREMENT, `name` VARCHAR(255) NOT NULL, `description` TEXT, `image` VARCHAR(150), `thumb` VARCHAR(150), `sequence` INT UNSIGNED DEFAULT '1', `recipe_id` INT UNSIGNED, `user_id` INT UNSIGNED, `created_at` DATETIME, `updated_at` DATETIME, `source` ENUM('nw', 'br', 'mb') DEFAULT 'nw' NOT NULL, `legacy_id` VARCHAR(40), INDEX `recipe_id_idx` (`recipe_id`), INDEX `user_id_idx` (`user_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `position_count` (`id` INT UNSIGNED AUTO_INCREMENT, `override_id` INT UNSIGNED NOT NULL, `count` TINYINT UNSIGNED DEFAULT '5' NOT NULL, INDEX `override_id_idx` (`override_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `rate` (`recipe_id` INT UNSIGNED, `user_id` INT UNSIGNED, `rating` INT UNSIGNED NOT NULL, PRIMARY KEY(`recipe_id`, `user_id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `recipe` (`id` INT UNSIGNED AUTO_INCREMENT, `name` VARCHAR(100) NOT NULL, `slug` VARCHAR(100) NOT NULL, `introduction` TEXT, `ingredients` TEXT, `description` TEXT, `servings` VARCHAR(150), `preptime` VARCHAR(150), `cooktime` VARCHAR(150), `totaltime` VARCHAR(255), `summary` VARCHAR(255), `keywords` VARCHAR(255), `notes` TEXT, `quick_recipe` VARCHAR(1), `rating` DECIMAL(5, 4) DEFAULT 0.0000, `rating_count` INT DEFAULT '0' NOT NULL, `main_ingredient` VARCHAR(100), `course` ENUM('desserts', 'side dish', 'breakfast brunch', 'main dish', 'appetizer', 'beverages', 'other') DEFAULT 'other', `origin` VARCHAR(150), `instructions` TEXT, `views` INT UNSIGNED DEFAULT '0' NOT NULL, `recommendations` INT UNSIGNED, `sponsor_id` INT UNSIGNED, `is_active` TINYINT UNSIGNED DEFAULT '1' NOT NULL, `user_id` INT UNSIGNED NOT NULL, `onesite_id` INT, `created_at` DATETIME, `updated_at` DATETIME, `source` ENUM('nw', 'br', 'mb') DEFAULT 'nw' NOT NULL, `legacy_id` VARCHAR(40), INDEX `user_id_idx` (`user_id`), INDEX `sponsor_id_idx` (`sponsor_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `recipe_category` (`id` INT UNSIGNED AUTO_INCREMENT, `name` VARCHAR(255) NOT NULL, `slug` VARCHAR(255) NOT NULL, `parent_id` INT UNSIGNED DEFAULT '0' NOT NULL, `description` TEXT, `created_at` DATETIME DEFAULT '0000-00-00 00:00:00', `updated_at` DATETIME DEFAULT '0000-00-00 00:00:00', `legacy_id` VARCHAR(255), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `saved` (`id` INT UNSIGNED AUTO_INCREMENT, `recipe_id` INT UNSIGNED NOT NULL, `user_id` INT UNSIGNED NOT NULL, INDEX `recipe_id_idx` (`recipe_id`), INDEX `user_id_idx` (`user_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `slideshow` (`id` INT UNSIGNED AUTO_INCREMENT, `name` VARCHAR(150) NOT NULL, `description` TEXT, `slug` VARCHAR(255), `summary` VARCHAR(255), `keywords` VARCHAR(255), `photo_id` INT UNSIGNED, `start_date` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL, `end_date` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL, `is_active` TINYINT UNSIGNED DEFAULT '1' NOT NULL, `views` INT UNSIGNED DEFAULT '0', `category_id` INT UNSIGNED, `sponsor_id` INT UNSIGNED, `user_id` INT UNSIGNED NOT NULL, `created_at` DATETIME DEFAULT '0000-00-00 00:00:00', `updated_at` DATETIME DEFAULT '0000-00-00 00:00:00', UNIQUE INDEX `slideshow_sluggable_idx` (`slug`), INDEX `category_id_idx` (`category_id`), INDEX `sponsor_id_idx` (`sponsor_id`), INDEX `user_id_idx` (`user_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `slideshow_medium` (`id` INT UNSIGNED AUTO_INCREMENT, `slideshow_id` INT UNSIGNED NOT NULL, `medium_type` ENUM('recipe-photo') DEFAULT 'recipe-photo', `medium_id` INT UNSIGNED NOT NULL, `sequence` INT UNSIGNED NOT NULL, `name` VARCHAR(150), `content` TEXT, INDEX `slideshow_id_idx` (`slideshow_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `sponsor` (`id` INT UNSIGNED AUTO_INCREMENT, `name` VARCHAR(255) NOT NULL, `description` TEXT, `url` VARCHAR(255), `adtag` TEXT, `image` VARCHAR(255), `logo` VARCHAR(255), `is_active` TINYINT UNSIGNED DEFAULT '1' NOT NULL, `user_id` INT UNSIGNED NOT NULL, `created_at` DATETIME, `updated_at` DATETIME, INDEX `user_id_idx` (`user_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `user` (`id` INT UNSIGNED AUTO_INCREMENT, `onesite_id` INT, `blog_id` INT, `profile_id` VARCHAR(40), `display_name` VARCHAR(50), `subdir` VARCHAR(255), `email` VARCHAR(255), `is_admin` TINYINT UNSIGNED DEFAULT '0' NOT NULL, `is_super_admin` TINYINT UNSIGNED DEFAULT '0' NOT NULL, `is_active` TINYINT UNSIGNED DEFAULT '1', `created_at` DATETIME, `updated_at` DATETIME, `source` ENUM('nw', 'br', 'mb'), `legacy_id` VARCHAR(40), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `user_interest` (`user_id` INT UNSIGNED, `interest_id` INT UNSIGNED, PRIMARY KEY(`user_id`, `interest_id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `user_provider` (`user_id` INT UNSIGNED, `provider` VARCHAR(64), `provider_uid` VARCHAR(255) DEFAULT '' NOT NULL, `created_at` DATETIME NOT NULL, PRIMARY KEY(`user_id`, `provider`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `vote` (`id` INT UNSIGNED AUTO_INCREMENT, `contestant_id` INT UNSIGNED NOT NULL, `ip_address` INT UNSIGNED DEFAULT '0' NOT NULL, `is_active` TINYINT UNSIGNED DEFAULT '1' NOT NULL, `user_id` INT UNSIGNED NOT NULL, `created_at` DATETIME NOT NULL, INDEX `contestant_id_idx` (`contestant_id`), INDEX `user_id_idx` (`user_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
CREATE TABLE `weight` (`id` INT UNSIGNED AUTO_INCREMENT, `override_id` INT UNSIGNED NOT NULL, `item_id` INT UNSIGNED NOT NULL, `rank` TINYINT UNSIGNED DEFAULT '1' NOT NULL, INDEX `override_id_idx` (`override_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;
ALTER TABLE `article` ADD CONSTRAINT `article_user_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
ALTER TABLE `article` ADD CONSTRAINT `article_sponsor_id_sponsor_id` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsor`(`id`);
ALTER TABLE `article` ADD CONSTRAINT `article_category_id_category_id` FOREIGN KEY (`category_id`) REFERENCES `category`(`id`);
ALTER TABLE `category_recipe` ADD CONSTRAINT `category_recipe_recipe_id_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipe`(`id`);
ALTER TABLE `category_recipe` ADD CONSTRAINT `category_recipe_category_id_category_id` FOREIGN KEY (`category_id`) REFERENCES `category`(`id`);
ALTER TABLE `collection` ADD CONSTRAINT `collection_user_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
ALTER TABLE `collection_recipe` ADD CONSTRAINT `collection_recipe_recipe_id_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipe`(`id`);
ALTER TABLE `collection_recipe` ADD CONSTRAINT `collection_recipe_collection_id_collection_id` FOREIGN KEY (`collection_id`) REFERENCES `collection`(`id`);
ALTER TABLE `content` ADD CONSTRAINT `content_user_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
ALTER TABLE `content` ADD CONSTRAINT `content_sporsor_id_sponsor_id` FOREIGN KEY (`sporsor_id`) REFERENCES `sponsor`(`id`);
ALTER TABLE `content_medium` ADD CONSTRAINT `content_medium_content_id_content_id` FOREIGN KEY (`content_id`) REFERENCES `content`(`id`);
ALTER TABLE `contest` ADD CONSTRAINT `contest_user_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
ALTER TABLE `contest` ADD CONSTRAINT `contest_sponsor_id_sponsor_id` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsor`(`id`);
ALTER TABLE `contest_period` ADD CONSTRAINT `contest_period_user_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
ALTER TABLE `contest_period` ADD CONSTRAINT `contest_period_contest_id_contest_id` FOREIGN KEY (`contest_id`) REFERENCES `contest`(`id`);
ALTER TABLE `contestant` ADD CONSTRAINT `contestant_recipe_id_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipe`(`id`);
ALTER TABLE `contestant` ADD CONSTRAINT `contestant_contest_period_id_contest_period_id` FOREIGN KEY (`contest_period_id`) REFERENCES `contest_period`(`id`);
ALTER TABLE `group` ADD CONSTRAINT `group_sponsor_id_sponsor_id` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsor`(`id`);
ALTER TABLE `group` ADD CONSTRAINT `group_category_id_category_id` FOREIGN KEY (`category_id`) REFERENCES `category`(`id`);
ALTER TABLE `group_recipe` ADD CONSTRAINT `group_recipe_recipe_id_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipe`(`id`);
ALTER TABLE `group_recipe` ADD CONSTRAINT `group_recipe_group_id_group_id` FOREIGN KEY (`group_id`) REFERENCES `group`(`id`);
ALTER TABLE `legacy_mb_recipe` ADD CONSTRAINT `legacy_mb_recipe_recipe_id_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipe`(`id`);
ALTER TABLE `madeit` ADD CONSTRAINT `madeit_user_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
ALTER TABLE `madeit` ADD CONSTRAINT `madeit_recipe_id_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipe`(`id`);
ALTER TABLE `override` ADD CONSTRAINT `override_user_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
ALTER TABLE `override` ADD CONSTRAINT `override_category_id_category_id` FOREIGN KEY (`category_id`) REFERENCES `category`(`id`);
ALTER TABLE `photo` ADD CONSTRAINT `photo_user_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
ALTER TABLE `photo` ADD CONSTRAINT `photo_recipe_id_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipe`(`id`);
ALTER TABLE `position_count` ADD CONSTRAINT `position_count_override_id_override_id` FOREIGN KEY (`override_id`) REFERENCES `override`(`id`);
ALTER TABLE `rate` ADD CONSTRAINT `rate_user_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
ALTER TABLE `rate` ADD CONSTRAINT `rate_recipe_id_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipe`(`id`);
ALTER TABLE `recipe` ADD CONSTRAINT `recipe_user_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
ALTER TABLE `recipe` ADD CONSTRAINT `recipe_sponsor_id_sponsor_id` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsor`(`id`);
ALTER TABLE `saved` ADD CONSTRAINT `saved_user_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
ALTER TABLE `saved` ADD CONSTRAINT `saved_recipe_id_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipe`(`id`);
ALTER TABLE `slideshow` ADD CONSTRAINT `slideshow_user_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
ALTER TABLE `slideshow` ADD CONSTRAINT `slideshow_sponsor_id_sponsor_id` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsor`(`id`);
ALTER TABLE `slideshow` ADD CONSTRAINT `slideshow_category_id_category_id` FOREIGN KEY (`category_id`) REFERENCES `category`(`id`);
ALTER TABLE `slideshow_medium` ADD CONSTRAINT `slideshow_medium_slideshow_id_slideshow_id` FOREIGN KEY (`slideshow_id`) REFERENCES `slideshow`(`id`);
ALTER TABLE `sponsor` ADD CONSTRAINT `sponsor_user_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
ALTER TABLE `user_interest` ADD CONSTRAINT `user_interest_user_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
ALTER TABLE `user_interest` ADD CONSTRAINT `user_interest_interest_id_interest_id` FOREIGN KEY (`interest_id`) REFERENCES `interest`(`id`);
ALTER TABLE `user_provider` ADD CONSTRAINT `user_provider_user_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
ALTER TABLE `vote` ADD CONSTRAINT `vote_user_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);
ALTER TABLE `vote` ADD CONSTRAINT `vote_contestant_id_contestant_id` FOREIGN KEY (`contestant_id`) REFERENCES `contestant`(`id`);
ALTER TABLE `weight` ADD CONSTRAINT `weight_override_id_override_id` FOREIGN KEY (`override_id`) REFERENCES `override`(`id`);
