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
 * @version        $Id: 1.0 common.php 13070 Sat 2016-10-01 05:42:18Z XOOPS Development Team $
 */

if (!defined('WGTIMELINES_PATH')) {
    if (!defined('XOOPS_ICONS32_PATH')) {
        define('XOOPS_ICONS32_PATH', XOOPS_ROOT_PATH . '/Frameworks/moduleclasses/icons/32');
    }
    if (!defined('XOOPS_ICONS32_URL')) {
        define('XOOPS_ICONS32_URL', XOOPS_URL . '/Frameworks/moduleclasses/icons/32');
    }
    define('WGTIMELINES_DIRNAME', 'wgtimelines');
    define('WGTIMELINES_PATH', XOOPS_ROOT_PATH.'/modules/'.WGTIMELINES_DIRNAME);
    define('WGTIMELINES_URL', XOOPS_URL.'/modules/'.WGTIMELINES_DIRNAME);
    define('WGTIMELINES_ICONS_PATH', WGTIMELINES_PATH.'/assets/icons');
    define('WGTIMELINES_ICONS_URL', WGTIMELINES_URL.'/assets/icons');
    define('WGTIMELINES_IMAGE_PATH', WGTIMELINES_PATH.'/assets/images');
    define('WGTIMELINES_IMAGE_URL', WGTIMELINES_URL.'/assets/images');
    define('WGTIMELINES_UPLOAD_PATH', XOOPS_UPLOAD_PATH.'/'.WGTIMELINES_DIRNAME);
    define('WGTIMELINES_UPLOAD_URL', XOOPS_UPLOAD_URL.'/'.WGTIMELINES_DIRNAME);
    define('WGTIMELINES_UPLOAD_IMAGE_PATH', WGTIMELINES_UPLOAD_PATH.'/images');
    define('WGTIMELINES_UPLOAD_IMAGE_URL', WGTIMELINES_UPLOAD_URL.'/images');
    define('WGTIMELINES_ADMIN', WGTIMELINES_URL . '/admin/index.php');
}
$localLogo = WGTIMELINES_IMAGE_URL . '/wedega.png';
// Module Information
$copyright = "<a href='https://xoops.wedega.com' title='XOOPS on Wedega' target='_blank'><img src='".$localLogo . '\' alt=\'XOOPS on Wedega\' /></a>';
include_once XOOPS_ROOT_PATH .'/class/xoopsrequest.php';
include_once WGTIMELINES_PATH .'/class/helper.php';
include_once WGTIMELINES_PATH .'/include/functions.php';
// constants
define('WGTIMELINES_TIMELINE_EXPIRED_SHOW', 0);
define('WGTIMELINES_TIMELINE_EXPIRED_HIDE', 1);
