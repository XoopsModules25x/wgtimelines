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
 * @version        $Id: 1.0 menu.php 13070 Sat 2016-10-01 05:42:16Z XOOPS Development Team $
 */
$dirname = basename(dirname(__DIR__));
$moduleHandler = xoops_getHandler('module');
$xoopsModule = XoopsModule::getByDirname($dirname);
$moduleInfo = $moduleHandler->get($xoopsModule->getVar('mid'));
$sysPathIcon32 = $moduleInfo->getInfo('sysicons32');
$i = 1;
$adminmenu[$i]['title'] = _MI_WGTIMELINES_ADMENU1;
$adminmenu[$i]['link'] = 'admin/index.php';
$adminmenu[$i]['icon'] = $sysPathIcon32.'/dashboard.png';
++$i;
$adminmenu[$i]['title'] = _MI_WGTIMELINES_ADMENU2;
$adminmenu[$i]['link'] = 'admin/timelines.php';
$adminmenu[$i]['icon'] = 'assets/icons/32/timelines.png';
++$i;
$adminmenu[$i]['title'] = _MI_WGTIMELINES_ADMENU3;
$adminmenu[$i]['link'] = 'admin/items.php';
$adminmenu[$i]['icon'] = 'assets/icons/32/items.png';
++$i;
$adminmenu[$i]['title'] = _MI_WGTIMELINES_ADMENU4;
$adminmenu[$i]['link'] = 'admin/templates.php';
$adminmenu[$i]['icon'] = 'assets/icons/32/templates.png';
++$i;
$adminmenu[$i]['title'] = _MI_WGTIMELINES_ABOUT;
$adminmenu[$i]['link'] = 'admin/about.php';
$adminmenu[$i]['icon'] = $sysPathIcon32.'/about.png';
unset($i);
