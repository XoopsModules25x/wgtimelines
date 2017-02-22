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
 * @author         goffy (wedega.com) - Email:<webmaster@wedega.com> - Website:<http://xoops.wedega.com>
 * @version        $Id: 1.0 admin.php 13070 Sat 2016-10-01 05:42:16Z XOOPS Development Team $
 */
// ---------------- Admin Index ----------------
define('_AM_WGTIMELINES_STATISTICS', 'Statistics');
// There are
define('_AM_WGTIMELINES_THEREARE_TIMELINES', "There are <span class='bold'>%s</span> timelines in the database");
define('_AM_WGTIMELINES_THEREARE_ITEMS', "There are <span class='bold'>%s</span> items in the database");
define('_AM_WGTIMELINES_THEREARE_TEMPLATES', "There are <span class='bold'>%s</span> templates in the database");
// ---------------- Admin Files ----------------
// There aren't
define('_AM_WGTIMELINES_THEREARENT_TIMELINES', "There aren't timelines");
define('_AM_WGTIMELINES_THEREARENT_ITEMS', "There aren't items");
define('_AM_WGTIMELINES_THEREARENT_TEMPLATES', "There aren't templates");
// Save/Delete
define('_AM_WGTIMELINES_FORM_OK', 'Successfully saved');
define('_AM_WGTIMELINES_FORM_DELETE_OK', 'Successfully deleted');
define('_AM_WGTIMELINES_FORM_SURE_DELETE', "Are you sure to delete: <b><span style='color : Red;'>%s </span></b>");
define('_AM_WGTIMELINES_FORM_SURE_RENEW', "Are you sure to update: <b><span style='color : Red;'>%s </span></b>");
define('_AM_WGTIMELINES_FORM_UPLOAD_IMAGE', 'Upload images');
define('_AM_WGTIMELINES_SUBMITTER', 'Submitter');
define('_AM_WGTIMELINES_DATE_CREATE', 'Date create');
define('_AM_WGTIMELINES_ONLINE', 'Online');
define('_AM_WGTIMELINES_COPY', 'Copy');
// Lists
define('_AM_WGTIMELINES_TIMELINES_LIST', 'List of Timelines');
define('_AM_WGTIMELINES_ITEMS_LIST', 'List of Items');
define('_AM_WGTIMELINES_TEMPLATES_LIST', 'List of Templates');
// ---------------- Admin Classes ----------------
// Timeline add/edit
define('_AM_WGTIMELINES_TIMELINE_ADD', 'Add Timeline');
define('_AM_WGTIMELINES_TIMELINE_EDIT', 'Edit Timeline');
// Elements of Timeline
define('_AM_WGTIMELINES_TIMELINE_ID', 'Id');
define('_AM_WGTIMELINES_TIMELINE_NAME', 'Name');
define('_AM_WGTIMELINES_TIMELINE_DESC', 'Description');
define('_AM_WGTIMELINES_TIMELINE_IMAGE', 'Image');
define('_AM_WGTIMELINES_TIMELINE_TEMPLATE', 'Template');
define('_AM_WGTIMELINES_TIMELINE_SORTBY', 'Sort by');
define('_AM_WGTIMELINES_TIMELINE_SORTBY_Y_ASC', 'Year/Date ascending');
define('_AM_WGTIMELINES_TIMELINE_SORTBY_Y_DESC', 'Year/Date descending');
define('_AM_WGTIMELINES_TIMELINE_SORTBY_ADMIN', 'Sort order in admin area');
define('_AM_WGTIMELINES_TIMELINE_LIMIT', 'Limit of characters');
define('_AM_WGTIMELINES_TIMELINE_LIMIT_DESC', '0 = complete text will be shown, otherwise you can display the full text with "Read more"');
define('_AM_WGTIMELINES_TIMELINE_DATETIME', 'Show date/time');
define('_AM_WGTIMELINES_TIMELINE_DATETIME_DESC', ' (if supported by template)');
define('_AM_WGTIMELINES_TIMELINE_DATETIME_NO', 'None');
define('_AM_WGTIMELINES_TIMELINE_DATETIME_ONLY_D', 'Only date');
define('_AM_WGTIMELINES_TIMELINE_DATETIME_ONLY_T', 'Only time');
define('_AM_WGTIMELINES_TIMELINE_DATETIME_BOTH', 'Date and time');
define('_AM_WGTIMELINES_TIMELINE_MAGNIFIC', 'Use magnific popup');
define('_AM_WGTIMELINES_TIMELINE_MAGNIFIC_DESC', 'Please define, whether you want to use jquery magnific-popup for zooming the item images');
// Template add/edit
define('_AM_WGTIMELINES_TEMPLATE_ADD', 'Add Template');
define('_AM_WGTIMELINES_TEMPLATE_EDIT', 'Edit Template');
// Elements of Template
define('_AM_WGTIMELINES_TEMPLATE_ID', 'Id');
define('_AM_WGTIMELINES_TEMPLATE_NAME', 'Name');
define('_AM_WGTIMELINES_TEMPLATE_DESC', 'Description');
define('_AM_WGTIMELINES_TEMPLATE_FILE', 'File');
define('_AM_WGTIMELINES_TEMPLATE_OPTIONS', 'Options');
define('_AM_WGTIMELINES_TEMPLATE_VERSION', 'Version');
define('_AM_WGTIMELINES_TEMPLATE_AUTHOR', 'Autor');
define('_AM_WGTIMELINES_TEMPLATE_NEWVERSION', 'A new version is available');
define('_AM_WGTIMELINES_TEMPLATE_SURE_UPDATE', 'Update to new version will also reset to default values. Do you want to continue?');
define('_AM_WGTIMELINES_TEMPLATE_RESETVERSION', 'Reset to default values');
define('_AM_WGTIMELINES_TEMPLATE_SURE_RESET', 'With the reset all your personal settings will be deleted. Do you want to continue?');
define('_AM_WGTIMELINES_TEMPLATE_NOTSUPPORTED', "This template isn't supported anymore by the developer's team");
define('_AM_WGTIMELINES_TEMPLATE_NEWTEMPLATE', 'A new template is available');
// Elements of Template options
define('_AM_WGTIMELINES_TEMPLATE_NONE', 'None');
define('_AM_WGTIMELINES_TEMPLATE_LEFT', 'Left');
define('_AM_WGTIMELINES_TEMPLATE_RIGHT', 'Right');
define('_AM_WGTIMELINES_TEMPLATE_ALTERNATE', 'Alternately');
define('_AM_WGTIMELINES_TEMPLATE_TOP', 'Top');
define('_AM_WGTIMELINES_TEMPLATE_BOTTOM', 'Bottom');
define('_AM_WGTIMELINES_TEMPLATE_VALID', 'Apply');
define('_AM_WGTIMELINES_TEMPLATE_ADDOPT', 'Add Option after saving');
define('_AM_WGTIMELINES_TEMPLATE_PANELPOS', 'Panel position');
define('_AM_WGTIMELINES_TEMPLATE_IMGPOS', 'Image position on panel');
define('_AM_WGTIMELINES_TEMPLATE_IMGSTYLE', 'Image style');
define('_AM_WGTIMELINES_TEMPLATE_IMGSTYLE_ROUNDED', 'Rounded');
define('_AM_WGTIMELINES_TEMPLATE_IMGSTYLE_CIRCLE', 'Circle');
define('_AM_WGTIMELINES_TEMPLATE_IMGSTYLE_THUMB', 'Thumbnail');
define('_AM_WGTIMELINES_TEMPLATE_TABLETYPE', 'Table type');
define('_AM_WGTIMELINES_TEMPLATE_TABLEBORDERED', 'Bordered');
define('_AM_WGTIMELINES_TEMPLATE_TABLESTRIPED', 'Striped');
define('_AM_WGTIMELINES_TEMPLATE_TABLEHOVER', 'Hover');
define('_AM_WGTIMELINES_TEMPLATE_TABLECONDENSED', 'Condensed');
define('_AM_WGTIMELINES_TEMPLATE_BGCOLOR', 'Background Color');
define('_AM_WGTIMELINES_TEMPLATE_FONTCOLOR', 'Font Color');
define('_AM_WGTIMELINES_TEMPLATE_BGCOLOR2', '2nd Background Color');
define('_AM_WGTIMELINES_TEMPLATE_FONTCOLOR2', '2nd Font Color');
define('_AM_WGTIMELINES_TEMPLATE_BGCOLOR3', '3rd Background Color');
define('_AM_WGTIMELINES_TEMPLATE_FONTCOLOR3', '3rd Font Color');
define('_AM_WGTIMELINES_TEMPLATE_BGCOLOR4', '4th Background Color');
define('_AM_WGTIMELINES_TEMPLATE_FONTCOLOR4', '4th Font Color');
define('_AM_WGTIMELINES_TEMPLATE_BADGESTYLE', 'Badgestyle');
define('_AM_WGTIMELINES_TEMPLATE_BADGESTYLE_FULL', 'Full');
define('_AM_WGTIMELINES_TEMPLATE_BADGESTYLE_CIRCLE', 'Circle');
define('_AM_WGTIMELINES_TEMPLATE_BADGECONTENT', 'Badge content');
define('_AM_WGTIMELINES_TEMPLATE_BADGECONTENT_YEAR', 'Use year');
define('_AM_WGTIMELINES_TEMPLATE_BADGECONTENT_GLYPH', 'Use glyphicons');
define('_AM_WGTIMELINES_TEMPLATE_BADGECOLOR', 'Badge Color');
define('_AM_WGTIMELINES_TEMPLATE_BADGEFONTCOLOR', 'Badge font color');
define('_AM_WGTIMELINES_TEMPLATE_ORIENTATION', 'Orientation');
define('_AM_WGTIMELINES_TEMPLATE_ORIENTATION_V', 'vertical');
define('_AM_WGTIMELINES_TEMPLATE_ORIENTATION_H', 'horizontal');
define('_AM_WGTIMELINES_TEMPLATE_DATESSPEED', 'Speed changing date');
define('_AM_WGTIMELINES_TEMPLATE_ISSUESSPEED', 'Appearing speed of items');
define('_AM_WGTIMELINES_TEMPLATE_ISSUESTRANSPARENCY', 'Transparency of items');
define('_AM_WGTIMELINES_TEMPLATE_ISSUESTRANSPARENCYSPEED', 'Speed of transparency');
define('_AM_WGTIMELINES_TEMPLATE_AUTOPLAY', 'Autoplay');
define('_AM_WGTIMELINES_TEMPLATE_AUTOPLAY_DIRECTION', 'Autoplay direction');
define('_AM_WGTIMELINES_TEMPLATE_AUTOPLAY_DIRECTION_FW', 'forward');
define('_AM_WGTIMELINES_TEMPLATE_AUTOPLAY_DIRECTION_BW', 'backward');
define('_AM_WGTIMELINES_TEMPLATE_AUTOPLAY_PAUSE', 'Autoplay pause');
define('_AM_WGTIMELINES_TEMPLATE_ARROWKEYS', 'Use arrow keys');
define('_AM_WGTIMELINES_TEMPLATE_STARTAT', 'Start at item');
define('_AM_WGTIMELINES_TEMPLATE_LINECOLOR', 'Line color');
define('_AM_WGTIMELINES_TEMPLATE_BORDERRADIUS', 'Panel border radius');
define('_AM_WGTIMELINES_TEMPLATE_BORDERWIDTH', 'Panel border width');
define('_AM_WGTIMELINES_TEMPLATE_BORDERSTYLE', 'Panel border style');
define('_AM_WGTIMELINES_TEMPLATE_BORDERCOLOR', 'Panel border color');
define('_AM_WGTIMELINES_TEMPLATE_BOXSHADOW', 'Box shadow');
define('_AM_WGTIMELINES_TEMPLATE_BOXSHADOW_H', 'Horizontal');
define('_AM_WGTIMELINES_TEMPLATE_BOXSHADOW_V', 'Vertical');
define('_AM_WGTIMELINES_TEMPLATE_BOXSHADOW_BLUR', 'Blur');
define('_AM_WGTIMELINES_TEMPLATE_BOXSHADOW_SPREAD', 'Spread');
define('_AM_WGTIMELINES_TEMPLATE_BOXSHADOW_COLOR', 'Shadow color');
define('_AM_WGTIMELINES_TEMPLATE_FADEIN', 'Fade-Effect');
define('_AM_WGTIMELINES_TEMPLATE_FADEIN_FLY', 'Fly in');
define('_AM_WGTIMELINES_TEMPLATE_FADEIN_APPEAR', 'Appear');
define('_AM_WGTIMELINES_TEMPLATE_SHOWYEAR', 'Show year');
define('_AM_WGTIMELINES_TEMPLATE_SHOWYEAR_CHANGED', 'Only if changed');
define('_AM_WGTIMELINES_TEMPLATE_SHOWYEAR_ALL', 'Show always');

// Item add/edit
define('_AM_WGTIMELINES_ITEM_ADD', 'Add Item');
define('_AM_WGTIMELINES_ITEM_EDIT', 'Edit Item');
// Elements of Item
define('_AM_WGTIMELINES_ITEM_ID', 'Id');
define('_AM_WGTIMELINES_ITEM_TL_ID', 'Timeline');
define('_AM_WGTIMELINES_ITEM_TITLE', 'Title');
define('_AM_WGTIMELINES_ITEM_CONTENT', 'Content');
define('_AM_WGTIMELINES_ITEM_IMAGE', 'Image');
define('_AM_WGTIMELINES_ITEM_DATE', 'Date');
define('_AM_WGTIMELINES_ITEM_YEAR', 'Year');
define('_AM_WGTIMELINES_ITEM_ICON', 'Icon');
define('_AM_WGTIMELINES_ITEM_READS', 'Reads');
define('_AM_WGTIMELINES_ITEM_YEAR_ICON_DESC', "Will be only used, if option '"._AM_WGTIMELINES_TEMPLATE_BADGECONTENT . '\' is set corresponding');
define('_AM_WGTIMELINES_ITEM_NONE', 'None');
// General
define('_AM_WGTIMELINES_FORM_UPLOAD', 'Upload file');
define('_AM_WGTIMELINES_FORM_IMAGE_PATH', 'Files in %s ');
define('_AM_WGTIMELINES_FORM_ACTION', 'Action');
define('_AM_WGTIMELINES_FORM_EDIT', 'Modification');
define('_AM_WGTIMELINES_FORM_DELETE', 'Clear');
// ---------------- Admin Others ----------------
define('_AM_WGTIMELINES_MAINTAINEDBY', ' is maintained by ');
// ---------------- End ----------------

define('_AM_WGTIMELINES_RATING_ADD', 'Add Rating');
define('_AM_WGTIMELINES_RATING_EDIT', 'Edit Rating');
define('_AM_WGTIMELINES_RATING_ITEMID', 'Item ID');
define('_AM_WGTIMELINES_RATING_VALUE', 'Value');
define('_AM_WGTIMELINES_RATING_UID', 'User ID');
define('_AM_WGTIMELINES_RATING_IP', 'IP');
define('_AM_WGTIMELINES_RATING_DATE', 'Date');
