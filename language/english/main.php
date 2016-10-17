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
 * @version        $Id: 1.0 main.php 13070 Sat 2016-10-01 05:42:18Z XOOPS Development Team $
 */
// ---------------- Main ----------------
define('_MA_WGTIMELINES_INDEX', "Home");
define('_MA_WGTIMELINES_TITLE', "wgTimelines");
define('_MA_WGTIMELINES_DESC', "This module creates a chronicle/timeline and display it in various ways.");
define('_MA_WGTIMELINES_INDEX_DESC', "Welcome to the homepage of your new module wgTimelines!<br />
As you can see, you've created a page with a list of links at the top to navigate between the pages of your module. This description is only visible on the homepage of this module, the other pages you will see the content you created when you built this module with the module TDMCreate, and after creating new content in admin of this module. In order to expand this module with other resources, just add the code you need to extend the functionality of the same. The files are grouped by type, from the header to the footer to see how divided the source code.<br /><br />If you see this message, it is because you have not created content for this module. Once you have created any type of content, you will not see this message.<br /><br />If you liked the module TDMCreate and thanks to the long process for giving the opportunity to the new module to be created in a moment, consider making a donation to keep the module TDMCreate and make a donation using this button <a href='http://www.txmodxoops.org/modules/xdonations/index.php' title='Donation To Txmod Xoops'><img src='https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif' alt='Button Donations' /></a><br />Thanks!<br /><br />Use the link below to go to the admin and create content.");
define('_MA_WGTIMELINES_NO_PDF_LIBRARY', "Libraries TCPDF not there yet, upload them in root/Frameworks");
define('_MA_WGTIMELINES_NO', "No");
// ---------------- Contents ----------------
// Timeline
define('_MA_WGTIMELINES_TIMELINE', "Timeline");
define('_MA_WGTIMELINES_TIMELINES', "Timelines");
define('_MA_WGTIMELINES_TIMELINES_TITLE', "Timelines title");
define('_MA_WGTIMELINES_TIMELINES_DESC', "Timelines description");
// Caption of Timeline
define('_MA_WGTIMELINES_TIMELINE_ID', "Id");
define('_MA_WGTIMELINES_TIMELINE_NAME', "Name");
define('_MA_WGTIMELINES_TIMELINE_WEIGHT', "Weight");
define('_MA_WGTIMELINES_TIMELINE_TEMPLATE', "Template");
define('_MA_WGTIMELINES_TIMELINE_SUBMITTER', "Submitter");
define('_MA_WGTIMELINES_TIMELINE_DATE_CREATE', "Date_create");
// Item
define('_MA_WGTIMELINES_ITEM', "Item");
define('_MA_WGTIMELINES_ITEMS', "Items");
define('_MA_WGTIMELINES_ITEMS_TITLE', "Items title");
define('_MA_WGTIMELINES_ITEMS_DESC', "Items description");
// Caption of Item
define('_MA_WGTIMELINES_ITEM_ID', "Id");
define('_MA_WGTIMELINES_ITEM_TL_ID', "Timeline");
define('_MA_WGTIMELINES_ITEM_TITLE', "Title");
define('_MA_WGTIMELINES_ITEM_CONTENT', "Content");
define('_MA_WGTIMELINES_ITEM_IMAGE', "Image");
define('_MA_WGTIMELINES_ITEM_DATE', "Date");
define('_MA_WGTIMELINES_ITEM_YEAR', "Year");
define('_MA_WGTIMELINES_ITEM_WEIGHT', "Weight");
define('_MA_WGTIMELINES_ITEM_SUBMITTER', "Submitter");
define('_MA_WGTIMELINES_ITEM_DATE_CREATE', "Date_create");
// Template
define('_MA_WGTIMELINES_TEMPLATE', "Template");
define('_MA_WGTIMELINES_TEMPLATES', "Templates");
define('_MA_WGTIMELINES_TEMPLATES_TITLE', "Templates title");
define('_MA_WGTIMELINES_TEMPLATES_DESC', "Templates description");
// Caption of Template
define('_MA_WGTIMELINES_TEMPLATE_ID', "Id");
define('_MA_WGTIMELINES_TEMPLATE_NAME', "Name");
define('_MA_WGTIMELINES_TEMPLATE_FILE', "File");
define('_MA_WGTIMELINES_TEMPLATE_OPTIONS', "Options");
define('_MA_WGTIMELINES_TEMPLATE_IMGPOSITION', "Imgposition");
define('_MA_WGTIMELINES_TEMPLATE_IMGSTYLE', "Imgstyle");
define('_MA_WGTIMELINES_TEMPLATE_TABLETYPE', "Tabletype");
define('_MA_WGTIMELINES_INDEX_THEREARE', "There are %s Templates");
define('_MA_WGTIMELINES_INDEX_LATEST_LIST', "Last wgTimelines");
// Submit
define('_MA_WGTIMELINES_SUBMIT', "Submit");
define('_MA_WGTIMELINES_SUBMIT_TEMPLATE', "Submit Template");
define('_MA_WGTIMELINES_SUBMIT_ALLPENDING', "All template/script information are posted pending verification.");
define('_MA_WGTIMELINES_SUBMIT_DONTABUSE', "Username and IP are recorded, so please don't abuse the system.");
define('_MA_WGTIMELINES_SUBMIT_ISAPPROVED', "Your template has been approved");
define('_MA_WGTIMELINES_SUBMIT_PROPOSER', "Submit a template");
define('_MA_WGTIMELINES_SUBMIT_RECEIVED', "We have received your template info. Thank you !");
define('_MA_WGTIMELINES_SUBMIT_SUBMITONCE', "Submit your template/script only once.");
define('_MA_WGTIMELINES_SUBMIT_TAKEDAYS', "This will take many days to see your template/script added successfully in our database.");
// Admin link
define('_MA_WGTIMELINES_ADMIN', "Admin");
// ---------------- End ----------------