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
 * @version        $Id: 1.0 update.php 13070 Sat 2016-10-01 05:42:17Z XOOPS Development Team $
 */
/**
 * @param      $module
 * @param null $prev_version
 *
 * @return bool|null
 */
function xoops_module_update_wgtimelines(&$module, $prev_version = null)
{
    require dirname(__DIR__) . '/preloads/autoloader.php';
    
    $ret = null;
    if ($prev_version < 10) {
        $ret = update_wgtimelines_v10($module);
    }
    
    $ret = wgtimelines_check_db($module);
    
    include_once __DIR__ . '/oninstall.php';
    $ret = xoops_module_install_wgtimelines($module);

    if ($prev_version < 107) {
        $ret = update_wgtimelines_v107($module);
    }
    
    if ($prev_version < 108) {
        $ret = update_wgtimelines_v108($module);
    }

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
    $sql_file_path = WGTIMELINES_PATH . '/sql/update.sql';
    if (!file_exists($sql_file_path)) {
        $module->setErrors("error: update file '" . $sql_file_path . '\' not found');
        return false;
    } else {
        // delete existing table
        $sql = 'DROP TABLE IF EXISTS `' . $db->prefix('wgtimelines_tplsetsdefault') . '`;';
        if (!$db->queryF($sql)) {
            $module->setErrors($db->error());
            return false;
        } else {
            include_once XOOPS_ROOT_PATH . '/class/database/sqlutility.php';
            $sql_query = fread(fopen($sql_file_path, 'r'), filesize($sql_file_path));
            $sql_query = trim($sql_query);
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
function wgtimelines_check_db(&$module)
{
    $ret = true;
    
    // add field table 'wgtimelines_items'
    $table   = $GLOBALS['xoopsDB']->prefix('wgtimelines_items');
    $field   = 'item_icon';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` VARCHAR(200) NOT NULL DEFAULT '' AFTER `item_year`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    // add field table 'wgtimelines_templates'
    $table   = $GLOBALS['xoopsDB']->prefix('wgtimelines_templates');
    $field   = 'tpl_version';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` VARCHAR(10) NOT NULL DEFAULT '' AFTER `tpl_weight`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }
    
    // add field table 'wgtimelines_templates'
    $table   = $GLOBALS['xoopsDB']->prefix('wgtimelines_templates');
    $field   = 'tpl_author';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` VARCHAR(200) NOT NULL DEFAULT '' AFTER `tpl_version`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }
    
    // add field table 'wgtimelines_templates'
    $table   = $GLOBALS['xoopsDB']->prefix('wgtimelines_templates');
    $field   = 'tpl_date_create';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` INT(8) NOT NULL DEFAULT '0' AFTER `tpl_author`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }
     
    // add field table 'wgtimelines_items'
    $table   = $GLOBALS['xoopsDB']->prefix('wgtimelines_items');
    $field   = 'item_online';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` INT(1) NOT NULL DEFAULT '1' AFTER `item_weight`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }
    
    // add field table 'wgtimelines_items'
    $table   = $GLOBALS['xoopsDB']->prefix('wgtimelines_items');
    $field   = 'item_reads';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` int(8) NOT NULL DEFAULT '0' AFTER `item_icon`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

        
    // add field table 'wgtimelines_timelines'
    $table   = $GLOBALS['xoopsDB']->prefix('wgtimelines_timelines');
    $field   = 'tl_desc';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` TEXT NOT NULL AFTER `tl_name`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }
    
    // add field table 'wgtimelines_timelines'
    $table   = $GLOBALS['xoopsDB']->prefix('wgtimelines_timelines');
    $field   = 'tl_image';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` VARCHAR(200) NOT NULL DEFAULT 'blank.gif' AFTER `tl_desc`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    // add field table 'wgtimelines_timelines'
    $table   = $GLOBALS['xoopsDB']->prefix('wgtimelines_timelines');
    $field   = 'tl_limit';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` int(8) NOT NULL DEFAULT '0' AFTER `tl_sortby`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    $table   = $GLOBALS['xoopsDB']->prefix('wgtimelines_ratings');
    $check   = $GLOBALS['xoopsDB']->queryF("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='$table'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        // create new table 'wggallery_categories'
        $sql = "CREATE TABLE `$table` (
                  `rate_id`     INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `rate_itemid` INT(8) NOT NULL DEFAULT '0',
                  `rate_value`  INT(1) NOT NULL DEFAULT '0',
                  `rate_uid`    INT(8) NOT NULL DEFAULT '0',
                  `rate_ip`     VARCHAR(60) NOT NULL DEFAULT '',
                  `rate_date`   INT(8) NOT NULL DEFAULT '0',
                  PRIMARY KEY (`rate_id`)
                ) ENGINE=InnoDB;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when creating table '$table'.");
            $ret = false;
        }
    }
    
    // update table 'wgtimelines_items'
    $table   = $GLOBALS['xoopsDB']->prefix('wgtimelines_items');
    $field   = 'item_time';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if ($numRows) {
         $sql = "ALTER TABLE `$table` CHANGE `item_year` `item_year` VARCHAR(50) NULL DEFAULT NULL;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when when changing fieldtype of '$field' to varchar in table '$table'.");
            $ret = false;
        }
    }
    
    // add field table 'wgtimelines_timelines'
    $table   = $GLOBALS['xoopsDB']->prefix('wgtimelines_timelines');
    $field   = 'tl_datetime';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` int(1) NOT NULL DEFAULT '1' AFTER `tl_limit`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    // add field table 'wgtimelines_timelines'
    $table   = $GLOBALS['xoopsDB']->prefix('wgtimelines_timelines');
    $field   = 'tl_magnific';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` int(1) NOT NULL DEFAULT '0' AFTER `tl_datetime`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }
    
    // add field table 'wgtimelines_timelines'
    $table   = $GLOBALS['xoopsDB']->prefix('wgtimelines_timelines');
    $field   = 'tl_expired';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` int(1) NOT NULL DEFAULT '0' AFTER `tl_magnific`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }
     
    // drop field table 'wgtimelines_items'
    $table   = $GLOBALS['xoopsDB']->prefix('wgtimelines_items');
    $field   = 'item_time';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if ($numRows) {
        $sql = "ALTER TABLE `$table` DROP `$field`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when dropping field '$field' from table '$table'.");
            $ret = false;
        }
    }

    return $ret;
}

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
    foreach(array_keys($itemsAll) as $i) {
        $item_date = $itemsAll[$i]->getVar('item_date');
        if($item_date > 0) {
            $itemsObj = $itemsHandler->get($itemsAll[$i]->getVar("item_id"));
            $itemsObj->setVar("item_date", mktime(0, 0, 0, date("m", $item_date), date("d", $item_date), date("Y", $item_date)));
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

// irmtfan bug fix: solve templates duplicate issue
/**
 * @param $module
 *
 * @return bool
 */
function update_wgtimelines_v10(&$module)
{
    global $xoopsDB;
    $result = $xoopsDB->query(
        'SELECT t1.tpl_id FROM ' . $xoopsDB->prefix('tplfile') . ' t1, ' . $xoopsDB->prefix('tplfile')
        . ' t2 WHERE t1.tpl_refid = t2.tpl_refid AND t1.tpl_module = t2.tpl_module AND t1.tpl_tplset=t2.tpl_tplset AND t1.tpl_file = t2.tpl_file AND t1.tpl_type = t2.tpl_type AND t1.tpl_id > t2.tpl_id'
    );
    $tplids = array();
    while (list($tplid) = $xoopsDB->fetchRow($result)) {
        $tplids[] = $tplid;
    }
    if (count($tplids) > 0) {
        $tplfile_handler = xoops_getHandler('tplfile');
        $duplicate_files = $tplfile_handler->getObjects(
            new \Criteria('tpl_id', '(' . implode(',', $tplids) . ')', 'IN')
        );

        if (count($duplicate_files) > 0) {
            foreach (array_keys($duplicate_files) as $i) {
                $tplfile_handler->delete($duplicate_files[$i]);
            }
        }
    }
    $sql = 'SHOW INDEX FROM ' . $xoopsDB->prefix('tplfile') . " WHERE KEY_NAME = 'tpl_refid_module_set_file_type'";
    if (!$result = $xoopsDB->queryF($sql)) {
        xoops_error($this->db->error() . '<br>' . $sql);
        return false;
    }
    $ret = array();
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $ret[] = $myrow;
    }
    if (!empty($ret)) {
        $module->setErrors('\'tpl_refid_module_set_file_type\' unique index is exist. Note: check \'tplfile\' table to be sure this index is UNIQUE because XOOPS CORE need it.'
        );
        return true;
    }
    $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tplfile')
           . ' ADD UNIQUE tpl_refid_module_set_file_type ( tpl_refid, tpl_module, tpl_tplset, tpl_file, tpl_type )';
    if (!$result = $xoopsDB->queryF($sql)) {
        xoops_error($xoopsDB->error() . '<br>' . $sql);
        $module->setErrors('\'tpl_refid_module_set_file_type\' unique index is not added to \'tplfile\' table. Warning: do not use XOOPS until you add this unique index.'
        );
        return false;
    }
    return true;
}
// irmtfan bug fix: solve templates duplicate issue
