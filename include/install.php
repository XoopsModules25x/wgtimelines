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
 * @version        $Id: 1.0 install.php 13070 Sat 2016-10-01 05:42:17Z XOOPS Development Team $
 */
// Copy base file
$indexFile = XOOPS_UPLOAD_PATH.'/index.html';
$blankFile = XOOPS_UPLOAD_PATH.'/blank.gif';
// Making of uploads/wgtimelines folder
$wgtimelines = XOOPS_UPLOAD_PATH.'/wgtimelines';
if(!is_dir($wgtimelines)) {
	mkdir($wgtimelines, 0777);
	chmod($wgtimelines, 0777);
}
copy($indexFile, $wgtimelines.'/index.html');
// Making of images folder
$images = $wgtimelines.'/images';
if(!is_dir($images)) {
	mkdir($images, 0777);
	chmod($images, 0777);
}
copy($indexFile, $images.'/index.html');
copy($blankFile, $images.'/blank.gif');
// Making of images/items uploads folder
$items = $images.'/items';
if(!is_dir($items)) {
	mkdir($items, 0777);
	chmod($items, 0777);
}
copy($indexFile, $items.'/index.html');
copy($blankFile, $items.'/blank.gif');
// ------------------- Install Footer ------------------- //
