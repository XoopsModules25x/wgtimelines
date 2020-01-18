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
 * @version        $Id: 1.0 menu.php 13070 Sat 2016-10-01 05:42:16Z XOOPS Development Team $
 */
$dirname = basename(dirname(__DIR__));
$moduleHandler = xoops_getHandler('module');
$xoopsModule = XoopsModule::getByDirname($dirname);
$moduleInfo = $moduleHandler->get($xoopsModule->getVar('mid'));
$sysPathIcon32 = $moduleInfo->getInfo('sysicons32');

$adminmenu[] = [
    'title' => _MI_WGTIMELINES_ADMENU1,
    'link'  => 'admin/index.php',
    'icon'  => $sysPathIcon32 .'/dashboard.png',
];

$adminmenu[] = [
    'title' => _MI_WGTIMELINES_ADMENU2,
    'link'  => 'admin/timelines.php',
    'icon'  => 'assets/icons/32/timelines.png',
];

$adminmenu[] = [
    'title' => _MI_WGTIMELINES_ADMENU3,
    'link'  => 'admin/items.php',
    'icon'  => 'assets/icons/32/items.png',
];

$adminmenu[] = [
    'title' => _MI_WGTIMELINES_ADMENU4,
    'link'  => 'admin/templates.php',
    'icon'  => 'assets/icons/32/templates.png',
];

$adminmenu[] = [
    'title' => _MI_WGTIMELINES_FEEDBACK,
    'link'  => 'admin/feedback.php',
    'icon'  => 'assets/icons/32/feedback.png',
];

$adminmenu[] = [
    'title' => _MI_WGTIMELINES_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $sysPathIcon32 .'/about.png',
];
