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
 * @version        $Id: 1.0 index.php 13070 Sat 2016-10-01 05:42:16Z XOOPS Development Team $
 */

use XoopsModules\Wgtimelines;

include __DIR__ . '/header.php';
// Count elements
$countTimelines = $timelinesHandler->getCount();
$countItems     = $itemsHandler->getCount();
$countTemplates = $templatesHandler->getCount();
if ($countTemplates == 0) {
    // check default template set after install
    $tplsetsdefaultHandler->checkTplsetsdefault();
    $countTemplates = $templatesHandler->getCount();
}
// Template Index
$templateMain = 'wgtimelines_admin_index.tpl';
// InfoBox Statistics
$adminObject->addInfoBox(_AM_WGTIMELINES_STATISTICS);
// Info elements
$adminObject->addInfoBoxLine(sprintf('<label>'._AM_WGTIMELINES_THEREARE_TIMELINES.'</label>', $countTimelines));
$adminObject->addInfoBoxLine(sprintf('<label>'._AM_WGTIMELINES_THEREARE_ITEMS.'</label>', $countItems));
$adminObject->addInfoBoxLine(sprintf('<label>'._AM_WGTIMELINES_THEREARE_TEMPLATES.'</label>', $countTemplates));
// Upload Folders
$folder = array(
    WGTIMELINES_UPLOAD_PATH,
    WGTIMELINES_UPLOAD_PATH . '/images/',
    WGTIMELINES_UPLOAD_PATH . '/images/timelines/',
    WGTIMELINES_UPLOAD_PATH . '/images/items/'
);
// Uploads Folders Created
foreach(array_keys($folder) as $i) {
    $adminObject->addConfigBoxLine($folder[$i], 'folder');
    $adminObject->addConfigBoxLine(array($folder[$i], '777'), 'chmod');
}
// Render Index
$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('index.php'));

//------------- Test Data ----------------------------

if ($helper->getConfig('displaySampleButton')) {
    xoops_loadLanguage('admin/modulesadmin', 'system');
    require dirname(__DIR__) . '/testdata/index.php';

    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA'), '__DIR__ . /../../testdata/index.php?op=load', 'add');

    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA'), '__DIR__ . /../../testdata/index.php?op=save', 'add');

    //    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA'), '__DIR__ . /../../testdata/index.php?op=exportschema', 'add');

    $adminObject->displayButton('left', '');
}

//------------- End Test Data ----------------------------

$GLOBALS['xoopsTpl']->assign('index', $adminObject->displayIndex());
include __DIR__ . '/footer.php';
