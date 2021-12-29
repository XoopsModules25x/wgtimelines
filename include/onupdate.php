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
function xoops_module_pre_update_wgtimelines(\XoopsModule $module)
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
function xoops_module_update_wgtimelines(&$module, $prev_version = null)
{
    require \dirname(__DIR__) . '/preloads/autoloader.php';

    $moduleDirName = $module->dirname();
    
    $ret = null;

    //$ret = wgtimelines_check_db($module);
    
    include_once __DIR__ . '/oninstall.php';
    $ret = xoops_module_install_wgtimelines($module);

    if ($prev_version < 107) {
        $ret = update_wgtimelines_v107($module);
    }
    
    if ($prev_version < 108) {
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
    $moduleVersion = $module->getInfo('version');
    $fileYaml = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . "/sql/{$moduleDirName}_{$moduleVersion}_migrate.yml";
    //}

    // create a schema file based on sql/mysql.sql
    $migratehelper = new MigrateHelper($fileSql, $fileYaml);
    if (!$migratehelper->createSchemaFromSqlfile()) {
        \xoops_error('Error: creation schema file failed!');
        return false;
    };

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

/**
 * @param $module
 *
 * @return bool
 */
function update_tplsetsdefault(&$module)
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
function update_wgtimelines_v108(&$module)
{
    // update existing data
    $itemsHandler          = xoops_getModuleHandler('items', 'wgtimelines');
    $itemsAll = $itemsHandler->getAll();
    foreach(\array_keys($itemsAll) as $i) {
        $item_date = $itemsAll[$i]->getVar('item_date');
        if($item_date > 0) {
            $itemsObj = $itemsHandler->get($itemsAll[$i]->getVar("item_id"));
            $itemsObj->setVar("item_date", \mktime(0, 0, 0, date("m", $item_date), date("d", $item_date), date("Y", $item_date)));
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
function update_wgtimelines_v107(&$module)
{
    $sql = "UPDATE `" . $GLOBALS['xoopsDB']->prefix('wgtimelines_items') . "` SET `item_year` = '' WHERE `" . $GLOBALS['xoopsDB']->prefix('wgtimelines_items') . "`.`item_year` = 0;";
    if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
        xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
        $module->setErrors('error when changing fieldtype of item_year to varchar');
        return false;
    }    
    return true;
}
