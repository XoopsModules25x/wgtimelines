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
 * @version        $Id: 1.0 header.php 13070 Sat 2016-10-01 05:42:18Z XOOPS Development Team $
 */
include dirname(dirname(__DIR__)) .'/mainfile.php';
include __DIR__ .'/include/common.php';
$dirname = basename(__DIR__);
// Breadcrumbs
$xoBreadcrumbs = array();
$xoBreadcrumbs[] = array('title' => _MA_WGTIMELINES_TITLE, 'link' => WGTIMELINES_URL . '/');
// Get instance of module
$wgtimelines      = WgtimelinesHelper::getInstance();
$timelinesHandler = $wgtimelines->getHandler('timelines');
$itemsHandler     = $wgtimelines->getHandler('items');
$templatesHandler = $wgtimelines->getHandler('templates');
$ratingsHandler   = $wgtimelines->getHandler('ratings');
// Permission
include_once XOOPS_ROOT_PATH .'/class/xoopsform/grouppermform.php';
$gpermHandler = xoops_getHandler('groupperm');
if(is_object($xoopsUser)) {
	$groups  = $xoopsUser->getGroups();
} else {
	$groups  = XOOPS_GROUP_ANONYMOUS;
}
// 
$myts = MyTextSanitizer::getInstance();
// Default Css Style
$style = WGTIMELINES_URL . '/assets/css/style.css';
if(!file_exists($style)) {
	return false;
}
// Smarty Default
$sysPathIcon16 = $GLOBALS['xoopsModule']->getInfo('sysicons16');
$sysPathIcon32 = $GLOBALS['xoopsModule']->getInfo('sysicons32');
$pathModuleAdmin = $GLOBALS['xoopsModule']->getInfo('dirmoduleadmin');
$modPathIcon16 = $GLOBALS['xoopsModule']->getInfo('modicons16');
$modPathIcon32 = $GLOBALS['xoopsModule']->getInfo('modicons16');
// Load Languages
xoops_loadLanguage('main');
xoops_loadLanguage('modinfo');
