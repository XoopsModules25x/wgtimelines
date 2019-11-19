<?php

namespace XoopsModules\Wgtimelines;

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
 * @version        $Id: 1.0 templates.php 13070 Sat 2016-10-01 05:42:15Z XOOPS Development Team $
 */

use XoopsModules\Wgtimelines;


/**
 * Class Object Tplsetsdefault
 */
class Tplsetsdefault extends \XoopsObject
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
        $helper = \XoopsModules\Wgtimelines\Helper::getInstance();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id'] = $this->getVar('tpl_id');
        $ret['name'] = $this->getVar('tpl_name');
        return $ret;
    }
}
