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
 * @version        $Id: 1.0 install.php 13070 Sat 2016-10-01 05:42:17Z XOOPS Development Team $
 */

use XoopsModules\Wgtimelines;
use XoopsModules\Wgtimelines\Common;

/**
 * @param  \XoopsModule $module
 * @return bool
 */
function xoops_module_pre_install_wgtimelines(\XoopsModule $module): bool
{
    require \dirname(__DIR__) . '/preloads/autoloader.php';
    $utility = new Wgtimelines\Utility();

    //check for minimum XOOPS version
    $xoopsSuccess = $utility::checkVerXoops($module);

    // check for minimum PHP version
    $phpSuccess = $utility::checkVerPhp($module);

    if (false !== $xoopsSuccess && false !== $phpSuccess) {
        $moduleTables = &$module->getInfo('tables');
        foreach ($moduleTables as $table) {
            $GLOBALS['xoopsDB']->queryF('DROP TABLE IF EXISTS ' . $GLOBALS['xoopsDB']->prefix($table) . ';');
        }
    }

    return $xoopsSuccess && $phpSuccess;
}

/**
 * @param XoopsModule $module
 *
 * @return bool|string
 */
function xoops_module_install_wgtimelines(\XoopsModule $module): bool|string
{
    require \dirname(__DIR__) . '/preloads/autoloader.php';
    
    $moduleDirName = \basename(\dirname(__DIR__));

    /** @var Wgtimelines\Helper $helper */
    /** @var Wgtimelines\Utility $utility */
    /** @var Common\Configurator $configurator */
    $helper       = Wgtimelines\Helper::getInstance();
    $utility      = new Wgtimelines\Utility();
    $configurator = new Common\Configurator();

    // Load language files
    $helper->loadLanguage('admin');
    $helper->loadLanguage('modinfo');
    $helper->loadLanguage('common');

    //  ---  CREATE FOLDERS ---------------
    if ($configurator->uploadFolders && \is_array($configurator->uploadFolders)) {
        //    foreach (\array_keys($GLOBALS['uploadFolders']) as $i) {
        foreach (\array_keys($configurator->uploadFolders) as $i) {
            $utility::createFolder($configurator->uploadFolders[$i]);
        }
    }

    //  ---  COPY blank.gif FILES ---------------
    if ($configurator->copyBlankFiles && \is_array($configurator->copyBlankFiles)) {
        $file = \dirname(__DIR__) . '/assets/images/blank.gif';
        foreach (\array_keys($configurator->copyBlankFiles) as $i) {
            $dest = $configurator->copyBlankFiles[$i] . '/blank.gif';
            $utility::copyFile($file, $dest);
        }
    }
    
    //  ---  DELETE OLD FILES ---------------
    if (\count($configurator->oldFiles) > 0) {
        //    foreach (\array_keys($GLOBALS['uploadFolders']) as $i) {
        foreach (\array_keys($configurator->oldFiles) as $i) {
            $tempFile = $GLOBALS['xoops']->path('modules/' . $moduleDirName . $configurator->oldFiles[$i]);
            if (\is_file($tempFile)) {
                \unlink($tempFile);
            }
        }
    }

    //  ---  DELETE OLD FOLDERS ---------------
    \xoops_load('XoopsFile');
    if (\count($configurator->oldFolders) > 0) {
        //    foreach (\array_keys($GLOBALS['uploadFolders']) as $i) {
        foreach (\array_keys($configurator->oldFolders) as $i) {
            $tempFolder = $GLOBALS['xoops']->path('modules/' . $moduleDirName . $configurator->oldFolders[$i]);
            /* @var $folderHandler XoopsObjectHandler */
            $folderHandler = XoopsFile::getHandler('folder', $tempFolder);
            $folderHandler->delete($tempFolder);
        }
    }

    return true;
}
