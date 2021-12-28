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
 * wgBlocks module for xoops
 *
 * @copyright    2021 XOOPS Project (https://xoops.org)
 * @license      GPL 2.0 or later
 * @package      wgblocks
 * @since        1.0
 * @min_xoops    2.5.11 Beta1
 * @author       Goffy - Wedega.com - Email:webmaster@wedega.com - Website:https://xoops.wedega.com
 */

/**
 * return object
 */

$moduleDirName  = \basename(\dirname(__DIR__));
$moduleDirNameUpper  = \mb_strtoupper($moduleDirName);
return (object)[
    'name'           => \mb_strtoupper($moduleDirName) . ' Module Configurator',
    'paths'          => [
        'dirname'    => $moduleDirName,
        'admin'      => \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/admin',
        'modPath'    => \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName,
        'modUrl'     => \XOOPS_URL . '/modules/' . $moduleDirName,
        'uploadPath' => \XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        'uploadUrl'  => \XOOPS_UPLOAD_URL . '/' . $moduleDirName,
    ],
    'uploadFolders'  => [
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images/items',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images/timelines',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/temp',
    ],
    'copyBlankFiles' => [
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images/items',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images/timelines',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/temp',
    ],

    'copyTestFolders' => [
        [
            XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/testdata/uploads',
            XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        ],
    ],

    'templateFolders' => [
        '/templates/',
        '/templates/blocks/',
        '/templates/admin/'
    ],
    'oldFiles'        => [
        '/include/install.php',
        '/include/update.php',
    ],
    'oldFolders'      => [
    ],
    'renameTables'  => [
        //'tablename_old' => 'tablename_new'
    ],
    'renameColumns'  => [
        //'tablename' => ['columnname_old' => 'columnname_new'],
    ],
    'moduleStats'  => [
    ],
    'modCopyright' => "<a href='https://xoops.wedega.com' title='XOOPS on Wedega - Webdesign Gabor' target='_blank'>
                     <img src='" . \XOOPS_URL . '/modules/' . $moduleDirName . "/assets/images/wedega.png' alt='XOOPS on Wedega - Webdesign Gabor' /></a>",
];






