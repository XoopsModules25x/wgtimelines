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
  `tl_desc` TEXT NOT NULL,
  `tl_image` VARCHAR(200) NOT NULL DEFAULT '',
  `tl_weight` INT(8) NOT NULL DEFAULT '0',
  `tl_template` INT(8) NOT NULL DEFAULT '0',
  `tl_sortby` INT(1) NOT NULL DEFAULT '0',
  `tl_limit` INT(8) NOT NULL DEFAULT '0',
  `tl_datetime` INT(1) NOT NULL DEFAULT '0',
  `tl_magnific` INT(1) NOT NULL DEFAULT '0',
  `tl_expired` int(1) NOT NULL DEFAULT '0',
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
  `item_year` VARCHAR(50) NOT NULL DEFAULT '',
  `item_icon` VARCHAR(200) NOT NULL DEFAULT '',
  `item_reads` INT(8) NOT NULL DEFAULT '0',
  `item_weight` INT(8) NOT NULL DEFAULT '0',
  `item_online` INT(1) NOT NULL DEFAULT '0',
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
  `tpl_options` TEXT NOT NULL,
  `tpl_weight` INT(8) NOT NULL DEFAULT '0',
  `tpl_version` VARCHAR(10) NOT NULL DEFAULT '1',
  `tpl_author` VARCHAR(200) NOT NULL DEFAULT '',
  `tpl_date_create` INT(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tpl_id`)
) ENGINE=InnoDB;

#
# Structure table for `wgtimelines_tplsetsdefault` 7
#

CREATE TABLE `wgtimelines_tplsetsdefault` (
  `tpl_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tpl_name` VARCHAR(100) NOT NULL DEFAULT '',
  `tpl_desc` TEXT NOT NULL,
  `tpl_file` VARCHAR(100) NOT NULL DEFAULT '',
  `tpl_options` TEXT NOT NULL,
  `tpl_weight` INT(8) NOT NULL DEFAULT '0',
  `tpl_version` VARCHAR(10) NOT NULL DEFAULT '1',
  `tpl_author` VARCHAR(200) NOT NULL DEFAULT '',
  `tpl_date_create` INT(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tpl_id`)
) ENGINE=InnoDB;


#
# Structure table for `wgtimelines_ratings` 6
#

CREATE TABLE `wgtimelines_ratings` (
  `rate_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rate_itemid` INT(8) NOT NULL DEFAULT '0',
  `rate_value` INT(1) NOT NULL DEFAULT '0',
  `rate_uid` INT(8) NOT NULL DEFAULT '0',
  `rate_ip` VARCHAR(60) NOT NULL DEFAULT '',
  `rate_date` INT(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rate_id`)
) ENGINE=InnoDB;
