<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * wgTimelines module for xoops
 *
 * @copyright      module for xoops
 * @license        GPL 3.0 or later
 * @package        wgtimelines
 * @since          1.0
 * @min_xoops      2.5.7
 * @author         goffy (wedega.com) - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 * @version        $Id: 1.0 modinfo.php 13070 Sat 2016-10-01 05:42:16Z XOOPS Development Team $
 */

require_once __DIR__ . '/common.php';

// ---------------- Admin Main ----------------
define('_MI_WGTIMELINES_NAME', 'wgTimelines');
define('_MI_WGTIMELINES_DESC', 'This module creates a chronicle/timeline and display it in various ways.');
// ---------------- Admin Menu ----------------
define('_MI_WGTIMELINES_ADMENU1', 'Dashboard');
define('_MI_WGTIMELINES_ADMENU2', 'Timelines');
define('_MI_WGTIMELINES_ADMENU3', 'Items');
define('_MI_WGTIMELINES_ADMENU4', 'Templates');
define('_MI_WGTIMELINES_FEEDBACK', 'Feedback');
define('_MI_WGTIMELINES_ABOUT', 'About');
// Blocks
define('_MI_WGTIMELINES_TIMELINES_BLOCK_TIMELINE', 'Timelines block');
define('_MI_WGTIMELINES_TIMELINES_BLOCK_TIMELINE_DESC', 'Show a list of timelines');
define('_MI_WGTIMELINES_ITEMS_BLOCK_ITEM', 'Items block');
define('_MI_WGTIMELINES_ITEMS_BLOCK_ITEM_DESC', 'Show a list of items');
// Config
define('_MI_WGTIMELINES_ADMIN_PAGER', 'Admin pager');
define('_MI_WGTIMELINES_ADMIN_PAGER_DESC', 'Admin per page list');
define('_MI_WGTIMELINES_USER_PAGER', 'User pager');
define('_MI_WGTIMELINES_USER_PAGER_DESC', 'User per page list');
define('_MI_WGTIMELINES_KEYWORDS', 'Keywords');
define('_MI_WGTIMELINES_KEYWORDS_DESC', 'Insert here the keywords (separate by comma)');
define('_MI_WGTIMELINES_KEYWORDS_DEFAULT', 'wgtimelines, timelines, chronicles, items, template based, bootstrap, XOOPS');
define('_MI_WGTIMELINES_EDITOR', 'Editor');
define('_MI_WGTIMELINES_EDITOR_DESC', 'Please select an editor for edit items');
define('_MI_WGTIMELINES_MAXSIZE', 'Max size');
define('_MI_WGTIMELINES_MAXSIZE_DESC', 'Please define the maximum file size for uploads file. You have to enter the value for bytes (10485760 = 1 MB)');
define('_MI_WGTIMELINES_MIMETYPES', 'Mime Types');
define('_MI_WGTIMELINES_MIMETYPES_DESC', 'Define which mime-types are allowed for file upload.');
define('_MI_WGTIMELINES_BREADCRUMBS', 'Breadcrumbs');
define('_MI_WGTIMELINES_BREADCRUMBS_DESC', 'Please define, whether breadcrumbs should be shown on user side or not');
define('_MI_WGTIMELINES_WELCOME', 'Welcome message');
define('_MI_WGTIMELINES_WELCOME_DESC', 'This welcome message will be shown on the top of your timeline');
define('_MI_WGTIMELINES_WELCOME_DEFAULT', 'Welcome to timeline on ' . $xoopsConfig['sitename']);
define('_MI_WGTIMELINES_TIMELINE_NAME', 'Show name timeline');
define('_MI_WGTIMELINES_TIMELINE_NAME_DESC', 'Please decide, whether the name of the timeline should be shown on the top of the timeline');
define('_MI_WGTIMELINES_STARTPAGE', 'Start page');
define('_MI_WGTIMELINES_STARTPAGE_DESC', 'Define, what should be shown when calling the module (index.php)');
define('_MI_WGTIMELINES_STARTPAGE_LIST', 'An overview with all timelines (but without items)');
define('_MI_WGTIMELINES_STARTPAGE_ALL', 'All timelines with all items');
define('_MI_WGTIMELINES_STARTPAGE_FIRST', 'The first timeline');
define('_MI_WGTIMELINES_TLDESC', 'Timeline description');
define('_MI_WGTIMELINES_TLDESC_DESC', 'Define, whether and where the description should be shown');
define('_MI_WGTIMELINES_TLDESC_NONE', 'Never');
define('_MI_WGTIMELINES_TLDESC_ONLYLIST', 'Only on list of timelines');
define('_MI_WGTIMELINES_TLDESC_ALL', 'On list of timelines and the timeline himself');
define('_MI_WGTIMELINES_RATINGBARS', 'Show rating');
define('_MI_WGTIMELINES_RATINGBARS_DESC', 'Define, whether a rating of the items should be possible and shown');
define('_MI_WGTIMELINES_RATINGBAR_GROUPS', 'Groups with permission to rate');
define('_MI_WGTIMELINES_RATINGBAR_GROUPS_DESC', 'Please define the groups, which have the permission to rate a timeline item');
// ---------------- End ----------------
//Help
define('_MI_WGTIMELINES_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_WGTIMELINES_HELP_HEADER', __DIR__.'/help/helpheader.html');
define('_MI_WGTIMELINES_BACK_2_ADMIN', 'Back to Administration of ');
define('_MI_WGTIMELINES_OVERVIEW', 'Overview');
//help multi-page
define('_MI_WGTIMELINES_DISCLAIMER', 'Disclaimer');
define('_MI_WGTIMELINES_LICENSE', 'License');
define('_MI_WGTIMELINES_SUPPORT', 'Support');
