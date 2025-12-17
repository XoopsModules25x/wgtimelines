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
 * @version        $Id: 1.0 update.php 13070 Sat 2016-10-01 05:42:17Z XOOPS Development Team $
 */

use XoopsModules\Wgtimelines;
use XoopsModules\Wgtimelines\Helper;
use XoopsModules\Wgtimelines\Common\ {
    Configurator,
    Migrate,
    MigrateHelper
};

/**
 * Prepares system prior to attempting to install module
 * @param \XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_update_wgtimelines(\XoopsModule $module): bool
{
    $utility = new Wgtimelines\Utility();

    $xoopsSuccess = $utility::checkVerXoops($module);
    $phpSuccess   = $utility::checkVerPhp($module);

    return $xoopsSuccess && $phpSuccess;
}

/**
 * @param      $module
 * @param null $prev_version
 *
 * @return bool|null
 */
function xoops_module_update_wgtimelines(&$module, $prev_version = null): ?bool
{
    require \dirname(__DIR__) . '/preloads/autoloader.php';

    $moduleDirName = $module->dirname();
    
    $ret = null;

    //$ret = wgtimelines_check_db($module);
    
    include_once __DIR__ . '/oninstall.php';
    $ret = xoops_module_install_wgtimelines($module);

    if (compareVersion((string)$prev_version,  '1.0.7')) {
        $ret = update_wgtimelines_v107($module);
    }

    if (compareVersion((string)$prev_version,  '1.0.8')) {
        $ret = update_wgtimelines_v108($module);
    }

    // update DB corresponding to sql/mysql.sql
    $configurator = new Configurator();
    $migrate = new Migrate($configurator);

    $fileSql = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/sql/mysql.sql';
    // ToDo: add function setDefinitionFile to .\class\libraries\vendor\xoops\xmf\src\Database\Migrate.php
    // Todo: once we are using setDefinitionFile this part has to be adapted
    //$fileYaml = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/sql/update_' . $moduleDirName . '_migrate.yml';
    //try {
    //$migrate->setDefinitionFile('update_' . $moduleDirName);
    //} catch (\Exception $e) {
    // as long as this is not done default file has to be created
    $moduleVersionOld = $module->getInfo('version');
    $moduleVersionNew = \str_replace(['.', '-'], '_', $moduleVersionOld);
    $fileYaml = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . "/sql/{$moduleDirName}_{$moduleVersionNew}_migrate.yml";
    //}

    // create a schema file based on sql/mysql.sql
    $migratehelper = new MigrateHelper($fileSql, $fileYaml);
    if (!$migratehelper->createSchemaFromSqlfile()) {
        \xoops_error('Error: creation schema file failed!');
        return false;
    }

    //create copy for XOOPS 2.5.11 Beta 1 and older versions
    $fileYaml2 = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . "/sql/{$moduleDirName}_{$moduleVersionOld}_migrate.yml";
    \copy($fileYaml, $fileYaml2);

    // run standard procedure for db migration
    $migrate->synchronizeSchema();

    // create table 'wgtimelines_tplsetsdefault' in any case
    $ret = update_tplsetsdefault($module);
    
    $errors = $module->getErrors();

    if (!empty($errors)) {
        print_r($errors);
    }

    return $ret;
}

/** function to compare two versions
 * handling old versioning and semantic versioning
 * @param $version1
 * @param $version2
 * @param string $type
 * @return bool
 */
function compareVersion ($version1, $version2, string $type = '<'): bool
{

    $arrVersion1 = getVersionArray($version1);
    $arrVersion2 = getVersionArray($version2);

    if ('=' === $type) {
        return ($arrVersion1[0] === $arrVersion2[0] &&
                $arrVersion1[1] === $arrVersion2[1] &&
                $arrVersion1[2] === $arrVersion2[2]);
    }
    if ('<' === $type) {#
        if ($arrVersion1[0] > $arrVersion2[0]) {
            return false;
        }
        if ($arrVersion1[0] < $arrVersion2[0]) {
            return true;
        } else {
            if ($arrVersion1[1] > $arrVersion2[1]) {
                return false;
            }
            if ($arrVersion1[1] < $arrVersion2[1]) {
                return true;
            } else {
                if ($arrVersion1[2] > $arrVersion2[2]) {
                    return false;
                }
                if ($arrVersion1[2] < $arrVersion2[2]) {
                    return true;
                }
            }
        }
        return false;
    }

    return false;
}
/** function to check whether semantic versioning is used
 * semver: must have 2 times a dot
 * @param $version
 * @return array
 */
function getVersionArray ($version): array
{
    $arrVersion = [];
    $arrTemp = \explode('.', $version);
    $arrVersion[0] = (int)$arrTemp[0];
    if (substr_count($version, '.') > 1) {
        // is semantic
        $arrVersion[1] = (int)$arrTemp[1];
        $arrVersion[2] = (int)$arrTemp[2];
    } else {
        // turn 1.01 into [1][0][1]
        // turn 1.1  into [1][1][0]
        if ('0' === $arrTemp[1]) {
        //if (\str_starts_with((string)$arrTemp[1], '0')) {
            $arrVersion[1] = 0;
            $arrVersion[2] = (int)(\substr($arrTemp[1], 1));
        } else {
            $arrVersion[1] = (int)$arrTemp[1];
            $arrVersion[2] = 0;
        }
    }

    return $arrVersion;
}

/**
 * @param $module
 *
 * @return bool
 */
function update_tplsetsdefault($module): bool
{
    include_once __DIR__ . '/common.php';
    $db = $GLOBALS['xoopsDB'];
    $sql_file_path = \WGTIMELINES_PATH . '/sql/update.sql';
    if (!\file_exists($sql_file_path)) {
        $module->setErrors("error: update file '" . $sql_file_path . '\' not found');
        return false;
    } else {
        // delete existing table
        $sql = 'DROP TABLE IF EXISTS `' . $db->prefix('wgtimelines_tplsetsdefault') . '`;';
        if (!$db->queryF($sql)) {
            $module->setErrors($db->error());
            return false;
        } else {
            include_once \XOOPS_ROOT_PATH . '/class/database/sqlutility.php';
            $sql_query = fread(fopen($sql_file_path, 'r'), filesize($sql_file_path));
            $sql_query = \trim($sql_query);
            SqlUtility::splitMySqlFile($pieces, $sql_query);
            foreach ($pieces as $piece) {
                $prefixed_query = SqlUtility::prefixQuery($piece, $db->prefix());
                if (!$prefixed_query) {
                    $module->setErrors("error: invalid sql in file 'update.sql' found");
                    return false;
                }
                if (!$db->queryF($prefixed_query[0])) {
                    $module->setErrors($db->error());
                    return false;
                }
            }
        }
    }

    return true;
}

/**
 * @param $module
 *
 * @return bool
 */
/*
function wgtimelines_check_db(&$module)
{
    $ret = true;

    return $ret;
}
*/

/**
 * @param $module
 *
 * @return bool
 */
function update_wgtimelines_v108(&$module): bool
{
    //require \dirname(__DIR__) . '/preloads/autoloader.php';
    $helper                = \XoopsModules\Wgtimelines\Helper::getInstance();
    $itemsHandler          = $helper->getHandler('Items');
    // update existing data
    //$itemsHandler          = xoops_getModuleHandler('Items', 'wgtimelines');
    $itemsAll = $itemsHandler->getAll();
    foreach(\array_keys($itemsAll) as $i) {
        $item_date = $itemsAll[$i]->getVar('item_date');
        if($item_date > 0) {
            $itemsObj = $itemsHandler->get($itemsAll[$i]->getVar("item_id"));
            $itemsObj->setVar("item_date", \mktime(0, 0, 0, (int)date("m", $item_date), (int)date("d", $item_date), (int)date("Y", $item_date)));
            $itemsHandler->insert($itemsObj);
            unset($itemsObj);
        }
    }
   
    return true;
}

/**
 * @param $module
 *
 * @return bool
 */
function update_wgtimelines_v107($module): bool
{
    $sql = "UPDATE `" . $GLOBALS['xoopsDB']->prefix('wgtimelines_items') . "` SET `item_year` = '' WHERE `" . $GLOBALS['xoopsDB']->prefix('wgtimelines_items') . "`.`item_year` = 0;";
    if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
        xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
        $module->setErrors('error when changing fieldtype of item_year to varchar');
        return false;
    }    
    return true;
}
