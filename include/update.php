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
    $ret = null;
    if ($prev_version < 10) {
        $ret = update_wgtimelines_v10($module);
    }
    $errors = $module->getErrors();
    if ($prev_version < 102) {
        $ret = update_wgtimelines_v102($module);
    }
    $errors = $module->getErrors();
    if ($prev_version < 103) {
        $ret = update_wgtimelines_v103($module);
    }
	$errors = $module->getErrors();
    if ($prev_version < 104) {
        $ret = update_wgtimelines_v104($module);
    }
	$errors = $module->getErrors();
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
	include_once 'common.php';
	$db = $GLOBALS['xoopsDB'];
	$sql_file_path = WGTIMELINES_PATH . '/sql/update.sql';
	if (!file_exists($sql_file_path)) {
		$module->setErrors("error: update file '" . $sql_file_path . "' not found");
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
function update_wgtimelines_v104(&$module)
{
 	$sql = "ALTER TABLE `" . $GLOBALS['xoopsDB']->prefix('wgtimelines_items') . "` ADD `item_online` INT(1) NOT NULL DEFAULT '0' AFTER `item_weight`;";
	if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
        xoops_error($GLOBALS['xoopsDB']->error() . '<br />' . $sql);
        $module->setErrors("error when adding new field item_online to table wgtimelines_items");
        return false;
    }	
    return true;
}

/**
 * @param $module
 *
 * @return bool
 */
function update_wgtimelines_v103(&$module)
{
 	$sql = "ALTER TABLE `" . $GLOBALS['xoopsDB']->prefix('wgtimelines_templates') . "` ADD `tpl_version` VARCHAR(10) NOT NULL DEFAULT '' AFTER `tpl_weight`;";
	if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
        xoops_error($GLOBALS['xoopsDB']->error() . '<br />' . $sql);
        $module->setErrors("error when adding new field tpl_version to table wgtimelines_templates");
        return false;
    }	
	$sql = "ALTER TABLE `" . $GLOBALS['xoopsDB']->prefix('wgtimelines_templates') . "` ADD `tpl_author` VARCHAR(200) NOT NULL DEFAULT '' AFTER `tpl_version`;";
	if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
        xoops_error($GLOBALS['xoopsDB']->error() . '<br />' . $sql);
        $module->setErrors("error when adding new field tpl_author to table wgtimelines_templates");
        return false;
    }
	$sql = "ALTER TABLE `" . $GLOBALS['xoopsDB']->prefix('wgtimelines_templates') . "` ADD `tpl_date_create` INT(8) NOT NULL DEFAULT '0' AFTER `tpl_author`;";
	if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
        xoops_error($GLOBALS['xoopsDB']->error() . '<br />' . $sql);
        $module->setErrors("error when adding new field tpl_date_create to table wgtimelines_templates");
        return false;
    }	
    return true;
}

/**
 * @param $module
 *
 * @return bool
 */
function update_wgtimelines_v102(&$module)
{
	$sql = "ALTER TABLE `" . $GLOBALS['xoopsDB']->prefix('wgtimelines_items') . "` ADD `item_icon` VARCHAR(200) NOT NULL DEFAULT '' AFTER `item_year`;";

	if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
        xoops_error($GLOBALS['xoopsDB']->error() . '<br />' . $sql);
        $module->setErrors("error when adding new field item_icon to table wgtimelines_items");
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
            new Criteria('tpl_id', '(' . implode(',', $tplids) . ')', 'IN')
        );

        if (count($duplicate_files) > 0) {
            foreach (array_keys($duplicate_files) as $i) {
                $tplfile_handler->delete($duplicate_files[$i]);
            }
        }
    }
    $sql = 'SHOW INDEX FROM ' . $xoopsDB->prefix('tplfile') . " WHERE KEY_NAME = 'tpl_refid_module_set_file_type'";
    if (!$result = $xoopsDB->queryF($sql)) {
        xoops_error($this->db->error() . '<br />' . $sql);

        return false;
    }
    $ret = array();
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $ret[] = $myrow;
    }
    if (!empty($ret)) {
        $module->setErrors(
            "'tpl_refid_module_set_file_type' unique index is exist. Note: check 'tplfile' table to be sure this index is UNIQUE because XOOPS CORE need it."
        );

        return true;
    }
    $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tplfile')
           . ' ADD UNIQUE tpl_refid_module_set_file_type ( tpl_refid, tpl_module, tpl_tplset, tpl_file, tpl_type )';
    if (!$result = $xoopsDB->queryF($sql)) {
        xoops_error($xoopsDB->error() . '<br />' . $sql);
        $module->setErrors(
            "'tpl_refid_module_set_file_type' unique index is not added to 'tplfile' table. Warning: do not use XOOPS until you add this unique index."
        );

        return false;
    }

    return true;
}
// irmtfan bug fix: solve templates duplicate issue
