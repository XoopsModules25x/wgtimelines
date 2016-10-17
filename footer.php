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
 * @version        $Id: 1.0 footer.php 13070 Sat 2016-10-01 05:42:18Z XOOPS Development Team $
 */
if(count($xoBreadcrumbs) > 1) {
	$GLOBALS['xoopsTpl']->assign('xoBreadcrumbs', $xoBreadcrumbs);
}
$GLOBALS['xoopsTpl']->assign('adv', $wgtimelines->getConfig('advertise'));
// 
$GLOBALS['xoopsTpl']->assign('bookmarks', $wgtimelines->getConfig('bookmarks'));
$GLOBALS['xoopsTpl']->assign('fbcomments', $wgtimelines->getConfig('fbcomments'));
// 
$GLOBALS['xoopsTpl']->assign('admin', WGTIMELINES_ADMIN);
$GLOBALS['xoopsTpl']->assign('copyright', $copyright);
// 
include_once XOOPS_ROOT_PATH .'/footer.php';
