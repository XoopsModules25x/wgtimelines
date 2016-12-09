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
 * @version        $Id: 1.0 index.php 13070 Sat 2016-10-01 05:42:16Z XOOPS Development Team $
 */
include __DIR__ . '/header.php';
// Count elements
$countTimelines = $timelinesHandler->getCount();
$countItems     = $itemsHandler->getCount();
$countTemplates = $templatesHandler->getCount();
// Template Index
$templateMain = 'wgtimelines_admin_index.tpl';
// InfoBox Statistics
$adminMenu->addInfoBox(_AM_WGTIMELINES_STATISTICS);
// Info elements
$adminMenu->addInfoBoxLine(_AM_WGTIMELINES_STATISTICS, '<label>'._AM_WGTIMELINES_THEREARE_TIMELINES.'</label>', $countTimelines);
$adminMenu->addInfoBoxLine(_AM_WGTIMELINES_STATISTICS, '<label>'._AM_WGTIMELINES_THEREARE_ITEMS.'</label>', $countItems);
$adminMenu->addInfoBoxLine(_AM_WGTIMELINES_STATISTICS, '<label>'._AM_WGTIMELINES_THEREARE_TEMPLATES.'</label>', $countTemplates);
// Upload Folders
$folder = array(
	WGTIMELINES_UPLOAD_PATH,
	WGTIMELINES_UPLOAD_PATH . '/images/',
	WGTIMELINES_UPLOAD_PATH . '/images/timelines/',
	WGTIMELINES_UPLOAD_PATH . '/images/items/'
);
// Uploads Folders Created
foreach(array_keys($folder) as $i) {
	$adminMenu->addConfigBoxLine($folder[$i], 'folder');
	$adminMenu->addConfigBoxLine(array($folder[$i], '777'), 'chmod');
}

// Render Index
$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('index.php'));
$GLOBALS['xoopsTpl']->assign('index', $adminMenu->renderIndex());
include __DIR__ . '/footer.php';
