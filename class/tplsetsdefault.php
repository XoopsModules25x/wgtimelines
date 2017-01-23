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
 * @version        $Id: 1.0 templates.php 13070 Sat 2016-10-01 05:42:15Z XOOPS Development Team $
 */
 
/**
 * Class Object WgtimelinesTplsetsdefault
 */
class WgtimelinesTplsetsdefault extends XoopsObject
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('tpl_id', XOBJ_DTYPE_INT);
        $this->initVar('tpl_name', XOBJ_DTYPE_TXTBOX);
        $this->initVar('tpl_desc', XOBJ_DTYPE_TXTAREA);
        $this->initVar('tpl_file', XOBJ_DTYPE_TXTBOX);
        $this->initVar('tpl_options', XOBJ_DTYPE_TXTAREA);
        $this->initVar('tpl_weight', XOBJ_DTYPE_TXTBOX);
        $this->initVar('tpl_version', XOBJ_DTYPE_TXTBOX);
        $this->initVar('tpl_author', XOBJ_DTYPE_TXTBOX);
        $this->initVar('tpl_date_create', XOBJ_DTYPE_TXTBOX);
    }

    /**
     * @static function &getInstance
     *
     * @param null
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
    }

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesTplsetsdefault($keys = null, $format = null, $maxDepth = null)
    {
        $wgtimelines = WgtimelinesHelper::getInstance();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id'] = $this->getVar('tpl_id');
        $ret['name'] = $this->getVar('tpl_name');
        return $ret;
    }
}

/**
 * Class Object Handler WgtimelinesTplsetsdefault
 */
class WgtimelinesTplsetsdefaultHandler extends XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param null|XoopsDatabase $db
     */
    public function __construct(XoopsDatabase $db)
    {
        parent::__construct($db, 'wgtimelines_tplsetsdefault', 'wgtimelinestplsetsdefault', 'tpl_id', 'tpl_name');
    }

    /**
     * retrieve a field
     *
     * @param int  $i field id
     * @param null $fields
     * @return mixed reference to the <a href='psi_element://Get'>Get</a> object
     *                object
     */
    public function get($i = null, $fields = null)
    {
        return parent::get($i, $fields);
    }

    /**
     * Get Count Tplsetsdefault in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountTplsetsdefault($start = 0, $limit = 0, $sort = 'tpl_id ASC, tpl_name', $order = 'ASC')
    {
        $crCountTplsetsdefault = new CriteriaCompo();
        $crCountTplsetsdefault = $this->getTplsetsdefaultCriteria($crCountTplsetsdefault, $start, $limit, $sort, $order);
        return parent::getCount($crCountTplsetsdefault);
    }

    /**
     * Get All Tplsetsdefault in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllTplsetsdefault($start = 0, $limit = 0, $sort = 'tpl_id ASC, tpl_name', $order = 'ASC')
    {
        $crAllTplsetsdefault = new CriteriaCompo();
        $crAllTplsetsdefault = $this->getTplsetsdefaultCriteria($crAllTplsetsdefault, $start, $limit, $sort, $order);
        return parent::getAll($crAllTplsetsdefault);
    }

    /**
     * Get Criteria Tplsetsdefault
     * @param $crTplsetsdefault
     * @param $start
     * @param $limit
     * @param $sort
     * @param $order
     * @return
     */
    private function getTplsetsdefaultCriteria($crTplsetsdefault, $start, $limit, $sort, $order)
    {
        $crTplsetsdefault->setStart($start);
        $crTplsetsdefault->setLimit($limit);
        $crTplsetsdefault->setSort($sort);
        $crTplsetsdefault->setOrder($order);
        return $crTplsetsdefault;
    }

    /**
     * check Tplsetsdefault, whether there are new templates in
     *
     * @param null
     * @return bool
     */

    public function checkTplsetsdefault()
    {
        $tplsetsdefaultCount = $this->getCountTplsetsdefault();
        if ($tplsetsdefaultCount == 0) {
            // should be only after installing module
            $module_handler  = xoops_getHandler('module');
            $module          = $module_handler->getByDirname(WGTIMELINES_DIRNAME);
            include_once WGTIMELINES_PATH . '/include/update.php';
            if (!update_tplsetsdefault($module)) {
                echo 'Error update_tplsetsdefault in checkTplsetsdefault';
                return false;
            }
        }
        $templatesCount = WgtimelinesHelper::getInstance()->getHandler('templates')->getCountTemplates();
        if ($tplsetsdefaultCount > $templatesCount) {
            $db = $GLOBALS['xoopsDB'];
            $sql = 'INSERT INTO `' . $db->prefix('wgtimelines_templates') . '` SELECT `' . $db->prefix('wgtimelines_tplsetsdefault') . '`.* FROM `' . $db->prefix('wgtimelines_tplsetsdefault') . '` LEFT JOIN `' . $db->prefix('wgtimelines_templates') . '` ON `' . $db->prefix('wgtimelines_tplsetsdefault') . '`.tpl_id = `' . $db->prefix('wgtimelines_templates') . '`.tpl_id WHERE (((`' . $db->prefix('wgtimelines_templates') . '`.tpl_id) Is Null));';
            if ($db->queryF($sql)) {
                $sql = 'UPDATE `' . $GLOBALS['xoopsDB']->prefix('wgtimelines_templates') . '` SET `' . $GLOBALS['xoopsDB']->prefix('wgtimelines_templates') . '`.`tpl_date_create` = ' . time();
                if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
                    echo 'Error updating date for new in checkTplsetsdefault:';
                    return false;
                }
            } else {
                echo 'Error insert new in checkTplsetsdefault:';
                return false;
            }
        }
        return true;
    }
}
