<?php

declare(strict_types=1);

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
 * @version        $Id: 1.0 xoops_version.php 13070 Sat 2016-10-01 05:42:19Z XOOPS Development Team $
 */

//
$moduleDirName      = \basename(__DIR__);
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

// ------------------- Informations ------------------- //
$modversion['name']                = \_MI_WGTIMELINES_NAME;
$modversion['version']             = '1.2.0';
$modversion['module_status']       = 'Beta 1';
$modversion['description']         = \_MI_WGTIMELINES_DESC;
$modversion['author']              = 'goffy (wedega.com)';
$modversion['author_mail']         = 'webmaster@wedega.com';
$modversion['author_website_url']  = 'https://xoops.wedega.com';
$modversion['author_website_name'] = 'XOOPS on Wedega';
$modversion['credits']             = 'XOOPS Development Team';
$modversion['license']             = 'GPL 3.0 or later';
$modversion['license_url']         = 'http://www.gnu.org/licenses/gpl-3.0.en.html';
$modversion['help']                = 'page=help';
$modversion['release_info']        = 'release_info';
$modversion['release_file']        = \XOOPS_URL . '/modules/wgtimelines/docs/release_info file';
$modversion['release_date']        = '2021/12/29';
$modversion['manual']              = 'link to manual file';
$modversion['manual_file']         = \XOOPS_URL . '/modules/wgtimelines/docs/install.txt';
$modversion['min_php']             = '7.4';
$modversion['min_xoops']           = '2.5.11 Beta1';
$modversion['min_admin']           = '1.1';
$modversion['min_db']              = ['mysql' => '5.1', 'mysqli' => '5.1'];
$modversion['image']               = 'assets/images/wgtimelines_logo.png';
$modversion['dirname']             = $moduleDirName;
$modversion['dirmoduleadmin']      = 'Frameworks/moduleclasses/moduleadmin';
$modversion['sysicons16']          = '../../Frameworks/moduleclasses/icons/16';
$modversion['sysicons32']          = '../../Frameworks/moduleclasses/icons/32';
$modversion['modicons16']          = 'assets/icons/16';
$modversion['modicons32']          = 'assets/icons/32';
$modversion['demo_site_url']       = 'https://xoops.wedega.com';
$modversion['demo_site_name']      = 'Wedega Xoops Site';
$modversion['support_url']         = 'http://xoops.org/modules/newbb';
$modversion['support_name']        = 'Support Forum';
$modversion['module_website_url']  = 'xoops.wedega.com';
$modversion['module_website_name'] = 'XOOPS on Wedega';
$modversion['release']             = '12/29/2021'; // mm/dd/yyyy
$modversion['system_menu']         = 1;
$modversion['hasAdmin']            = 1;
$modversion['hasMain']             = 1;
$modversion['adminindex']          = 'admin/index.php';
$modversion['adminmenu']           = 'admin/menu.php';
$modversion['onInstall']           = 'include/oninstall.php';
$modversion['onUpdate']            = 'include/onupdate.php';
$modversion['onUninstall']         = 'include/onuninstall.php';
// ------------------- Help files ------------------- //
$modversion['helpsection'] = [
    ['name' => \_MI_WGTIMELINES_OVERVIEW, 'link' => 'page=help'],
    ['name' => \_MI_WGTIMELINES_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => \_MI_WGTIMELINES_LICENSE, 'link' => 'page=license'],
    ['name' => \_MI_WGTIMELINES_SUPPORT, 'link' => 'page=support'],
];

// ------------------- Templates ------------------- //
// Admin
$modversion['templates'][] = ['file' => 'wgtimelines_admin_about.tpl', 'description' => '', 'type' => 'admin'];
$modversion['templates'][] = ['file' => 'wgtimelines_admin_header.tpl', 'description' => '', 'type' => 'admin'];
$modversion['templates'][] = ['file' => 'wgtimelines_admin_index.tpl', 'description' => '', 'type' => 'admin'];
$modversion['templates'][] = ['file' => 'wgtimelines_admin_timelines.tpl', 'description' => '', 'type' => 'admin'];
$modversion['templates'][] = ['file' => 'wgtimelines_admin_items.tpl', 'description' => '', 'type' => 'admin'];
$modversion['templates'][] = ['file' => 'wgtimelines_admin_templates.tpl', 'description' => '', 'type' => 'admin'];
$modversion['templates'][] = ['file' => 'wgtimelines_admin_footer.tpl', 'description' => '', 'type' => 'admin'];
$modversion['templates'][] = ['file' => 'wgtimelines_admin_image_editor.tpl', 'description' => '', 'type' => 'admin'];
// User
$modversion['templates'][] = ['file' => 'wgtimelines_header.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_index.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_item_default.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_item_table.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_timelines_table.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_timelines_simple.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_timelines_colorful.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_timelines_cleanhtml.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_timelines_animated.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_timelines_bigpicture.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_timelines_slider.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_timelines_extended.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_timelines_facebook.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_timelines_crazycolors.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_timelines_animated_2.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_timelines_single.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_breadcrumbs.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_ratingbar.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_rss.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_search.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgtimelines_footer.tpl', 'description' => ''];
// ------------------- Mysql ------------------- //
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables
$modversion['tables'][1] = 'wgtimelines_timelines';
$modversion['tables'][2] = 'wgtimelines_items';
$modversion['tables'][3] = 'wgtimelines_templates';
$modversion['tables'][4] = 'wgtimelines_tplsetsdefault';
$modversion['tables'][5] = 'wgtimelines_ratings';

// ------------------- Search ------------------- //
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'wgtimelines_search';
// ------------------- Submenu ------------------- //
$currdirname = isset($GLOBALS['xoopsModule']) && \is_object($GLOBALS['xoopsModule']) ? $GLOBALS['xoopsModule']->getVar('moduleDirName') : 'system';
if ($moduleDirName == $currdirname) {
    $subcount = 1;
    $pathname = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName;
    include_once $pathname . '/include/common.php';
    // Get instance of module
    $helper = \XoopsModules\Wgtimelines\Helper::getInstance();
    // versions
    $timelinesHandler = $helper->getHandler('Timelines');
    $timelines_crit   = new \CriteriaCompo();
    $timelines_crit->setSort('tl_weight ASC, tl_name');
    $timelines_crit->setOrder('ASC');
    $timelines_crit->add(new \Criteria('tl_online', '1'));
    $timelines_rows = $timelinesHandler->getCount($timelines_crit);
    $timelines_arr  = $timelinesHandler->getAll($timelines_crit);

    if ($timelines_rows > 1) {
        foreach (\array_keys($timelines_arr) as $i) {
            $modversion['sub'][$subcount]['name']  = $timelines_arr[$i]->getVar('tl_name');
            $modversion['sub'][$subcount++]['url'] = 'index.php?tl_id=' . $timelines_arr[$i]->getVar('tl_id');
        }
    }
}

// ------------------- Blocks ------------------- //
$b = 1;
// Timelines
$modversion['blocks'][$b]['file']        = 'timelines.php';
$modversion['blocks'][$b]['name']        = \_MI_WGTIMELINES_TIMELINES_BLOCK_TIMELINE;
$modversion['blocks'][$b]['description'] = \_MI_WGTIMELINES_TIMELINES_BLOCK_TIMELINE_DESC;
$modversion['blocks'][$b]['show_func']   = 'b_wgtimelines_timelines_show';
$modversion['blocks'][$b]['edit_func']   = 'b_wgtimelines_timelines_edit';
$modversion['blocks'][$b]['template']    = 'wgtimelines_block_timelines.tpl';
$modversion['blocks'][$b]['options']     = 'tl|25|0';
++$b;
// Items
$modversion['blocks'][$b]['file']        = 'items.php';
$modversion['blocks'][$b]['name']        = \_MI_WGTIMELINES_ITEMS_BLOCK_ITEM;
$modversion['blocks'][$b]['description'] = \_MI_WGTIMELINES_ITEMS_BLOCK_ITEM_DESC;
$modversion['blocks'][$b]['show_func']   = 'b_wgtimelines_items_show';
$modversion['blocks'][$b]['edit_func']   = 'b_wgtimelines_items_edit';
$modversion['blocks'][$b]['template']    = 'wgtimelines_block_items.tpl';
$modversion['blocks'][$b]['options']     = 'item|5|25|last|0';
unset($b);
// ------------------- Config ------------------- //
// Keywords
$modversion['config'][] = [
    'name'        => 'keywords',
    'title'       => '\_MI_WGTIMELINES_KEYWORDS',
    'description' => '\_MI_WGTIMELINES_KEYWORDS_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => \_MI_WGTIMELINES_KEYWORDS_DEFAULT
];

// Editor
\xoops_load('xoopseditorhandler');
$editorHandler            = XoopsEditorHandler::getInstance();
$modversion['config'][] = [
    'name'        => 'wgtimelines_editor',
    'title'       => '\_MI_WGTIMELINES_EDITOR',
    'description' => '\_MI_WGTIMELINES_EDITOR_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'options'     => \array_flip($editorHandler->getList()),
    'default'     => 'dhtmltextarea'
];

// Welcome text
$modversion['config'][] = [
    'name'        => 'welcome',
    'title'       => '\_MI_WGTIMELINES_WELCOME',
    'description' => '\_MI_WGTIMELINES_WELCOME_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => \_MI_WGTIMELINES_WELCOME_DEFAULT
];

// Admin pager
$modversion['config'][] = [
    'name'        => 'adminpager',
    'title'       => '\_MI_WGTIMELINES_ADMIN_PAGER',
    'description' => '\_MI_WGTIMELINES_ADMIN_PAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10
];

// User pager
$modversion['config'][] = [
    'name'        => 'userpager',
    'title'       => '\_MI_WGTIMELINES_USER_PAGER',
    'description' => '\_MI_WGTIMELINES_USER_PAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10
];

// Breadcrumbs
$modversion['config'][] = [
    'name'        => 'breadcrumbs',
    'title'       => '\_MI_WGTIMELINES_BREADCRUMBS',
    'description' => '\_MI_WGTIMELINES_BREADCRUMBS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1
];

// Rating bar
$modversion['config'][] = [
    'name'        => 'ratingbars',
    'title'       => '\_MI_WGTIMELINES_RATINGBARS',
    'description' => '\_MI_WGTIMELINES_RATINGBARS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1
];

$group_handler = \xoops_getHandler('group');
$group_arr     = $group_handler->getObjects();
$ratingbar_groups = [];
foreach (\array_keys($group_arr) as $i) {
    $ratingbar_groups[$group_arr[$i]->getVar('name')] = $group_arr[$i]->getVar('groupid');
}
$modversion['config'][] = [
    'name'        => 'ratingbar_groups',
    'title'       => '\_MI_WGTIMELINES_RATINGBAR_GROUPS',
    'description' => '\_MI_WGTIMELINES_RATINGBAR_GROUPS_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'array',
    'default'     => ['1'],
    'options'     => $ratingbar_groups
];

// Timeline name
$modversion['config'][] = [
    'name'        => 'tl_name',
    'title'       => '\_MI_WGTIMELINES_TIMELINE_NAME',
    'description' => '\_MI_WGTIMELINES_TIMELINE_NAME_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1
];

// show timeline description
$modversion['config'][] = [
    'name'        => 'tl_description',
    'title'       => '\_MI_WGTIMELINES_TLDESC',
    'description' => '\_MI_WGTIMELINES_TLDESC_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 1,
    'options'     => [\_MI_WGTIMELINES_TLDESC_NONE => 1, \_MI_WGTIMELINES_TLDESC_ONLYLIST => 2, \_MI_WGTIMELINES_TLDESC_ALL => 3]
];

//Uploads : max size for image upload
include_once __DIR__ . '/include/xoops_version.inc.php';
$iniPostMaxSize = wgtimelinesReturnBytes(\ini_get('post_max_size'));
$iniUploadMaxFileSize = wgtimelinesReturnBytes(\ini_get('upload_max_filesize'));
$maxSize = min($iniPostMaxSize, $iniUploadMaxFileSize);
if ($maxSize > 10000 * 1048576) {
    $increment = 500;
}
if ($maxSize <= 10000 * 1048576){
    $increment = 200;
}
if ($maxSize <= 5000 * 1048576){
    $increment = 100;
}
if ($maxSize <= 2500 * 1048576){
    $increment = 50;
}
if ($maxSize <= 1000 * 1048576){
    $increment = 20;
}
if ($maxSize <= 500 * 1048576){
    $increment = 10;
}
if ($maxSize <= 100 * 1048576){
    $increment = 2;
}
if ($maxSize <= 50 * 1048576){
    $increment = 1;
}
if ($maxSize <= 25 * 1048576){
    $increment = 0.5;
}
$optionMaxsize = [];
$i = $increment;
while ($i* 1048576 <= $maxSize) {
    $optionMaxsize[$i . ' ' . \_MI_WGTIMELINES_SIZE_MB] = $i * 1048576;
    $i += $increment;
}
$modversion['config'][] = [
    'name' => 'maxsize',
    'title' => '\_MI_WGTIMELINES_MAXSIZE',
    'description' => '\_MI_WGTIMELINES_MAXSIZE_DESC',
    'formtype' => 'select',
    'valuetype' => 'int',
    'default' => 3145728,
    'options' => $optionMaxsize,
];

//Uploads : mimetypes of images
$modversion['config'][] = [
    'name'        => 'mimetypes',
    'title'       => '\_MI_WGTIMELINES_MIMETYPES',
    'description' => '\_MI_WGTIMELINES_MIMETYPES_DESC',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'default'     => ['image/gif', 'image/jpeg', 'image/png', 'image/jpg'],
    'options'     => [
        'bmp'   => 'image/bmp',
        'gif'   => 'image/gif',
        'pjpeg' => 'image/pjpeg',
        'jpeg'  => 'image/jpeg',
        'jpg'   => 'image/jpg',
        'jpe'   => 'image/jpe',
        'png'   => 'image/png'
    ]
];

// Uploads : max width of images for upload
$modversion['config'][] = [
    'name'        => 'maxwidth',
    'title'       => '\_MI_WGTIMELINES_MAXWIDTH',
    'description' => '\_MI_WGTIMELINES_MAXWIDTH_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 5000,
];

// Uploads : max height of images for upload
$modversion['config'][] = [
    'name'        => 'maxheight',
    'title'       => '\_MI_WGTIMELINES_MAXHEIGHT',
    'description' => '\_MI_WGTIMELINES_MAXHEIGHT_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 5000,
];
// Uploads : max width of images for upload
$modversion['config'][] = [
    'name'        => 'maxwidth_imgeditor',
    'title'       => '\_MI_WGTIMELINES_MAXWIDTH_IMGEDITOR',
    'description' => '\_MI_WGTIMELINES_MAXWIDTH_IMGEDITOR_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 400,
];

// Uploads : max height of images for upload
$modversion['config'][] = [
    'name'        => 'maxheight_imgeditor',
    'title'       => '\_MI_WGTIMELINES_MAXHEIGHT_IMGEDITOR',
    'description' => '\_MI_WGTIMELINES_MAXHEIGHT_IMGEDITOR_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 400,
];

// start page for module
$modversion['config'][] = [
    'name'        => 'startpage',
    'title'       => '\_MI_WGTIMELINES_STARTPAGE',
    'description' => '\_MI_WGTIMELINES_STARTPAGE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 1,
    'options'     => [\_MI_WGTIMELINES_STARTPAGE_LIST => 1, \_MI_WGTIMELINES_STARTPAGE_FIRST => 3]
];

// use js expander
$modversion['config'][] = [
    'name'        => 'jsexpander',
    'title'       => '\_MI_WGTIMELINES_JSEXPANDER',
    'description' => '\_MI_WGTIMELINES_JSEXPANDER_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1
];

/**
 * Make Sample button visible?
 */
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * Show Developer Tools?
 */
/* $modversion['config'][] = [
    'name'        => 'displayDeveloperTools',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
]; */

