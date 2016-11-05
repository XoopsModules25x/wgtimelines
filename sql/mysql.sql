# SQL Dump for wgtimelines module
# PhpMyAdmin Version: 4.0.4
# http://www.phpmyadmin.net
#
# Host: localhost
# Generated on: Sat Oct 01, 2016 to 05:42:17
# Server version: 5.7.11
# PHP Version: 5.6.19

#
# Structure table for `wgtimelines_timelines` 6
#

CREATE TABLE `wgtimelines_timelines` (
  `tl_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tl_name` VARCHAR(200) NOT NULL DEFAULT '',
  `tl_weight` INT(8) NOT NULL DEFAULT '0',
  `tl_template` INT(8) NOT NULL DEFAULT '0',
  `tl_sortby` INT(1) NOT NULL DEFAULT '0',
  `tl_online` INT(1) NOT NULL DEFAULT '0',
  `tl_submitter` INT(8) NOT NULL DEFAULT '0',
  `tl_date_create` INT(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tl_id`)
) ENGINE=InnoDB;

#
# Structure table for `wgtimelines_items` 10
#

CREATE TABLE `wgtimelines_items` (
  `item_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_tl_id` INT(8) NOT NULL DEFAULT '0',
  `item_title` VARCHAR(200) NOT NULL DEFAULT '',
  `item_content` TEXT NOT NULL,
  `item_image` VARCHAR(200) NOT NULL DEFAULT '',
  `item_date` INT(8) DEFAULT NULL,
  `item_year` INT(8) DEFAULT NULL,
  `item_weight` INT(8) NOT NULL DEFAULT '0',
  `item_submitter` INT(8) NOT NULL DEFAULT '0',
  `item_date_create` INT(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB;

#
# Structure table for `wgtimelines_templates` 7
#

CREATE TABLE `wgtimelines_templates` (
  `tpl_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tpl_name` VARCHAR(100) NOT NULL DEFAULT '',
  `tpl_desc` TEXT NOT NULL,
  `tpl_file` VARCHAR(100) NOT NULL DEFAULT '',
  `tpl_options` VARCHAR(100) NOT NULL DEFAULT '',
  `tpl_weight` INT(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tpl_id`)
) ENGINE=InnoDB;

