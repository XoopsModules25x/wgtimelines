<?php

declare(strict_types=1);

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
 * @version        $Id: 1.0 items.php 13070 Sat 2016-10-01 05:42:14Z XOOPS Development Team $
 */

use XoopsModules\Wgtimelines;

\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Handler WgtimelinesItems
 */
class ItemsHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgtimelines_items', Items::class, 'item_id', 'item_content');
    }

    /**
     * @param bool $isNew
     *
     * @return object
     */
    public function create($isNew = true)
    {
        return parent::create($isNew);
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
     * get inserted id
     *
     * @param null
     * @return integer reference to the {@link Get} object
     */
    public function getInsertId()
    {
        return $this->db->getInsertId();
    }

    /**
     * Get Count Items in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountItems($start = 0, $limit = 0, $sort = 'item_id', $order = 'ASC')
    {
        $crCountItems = new \CriteriaCompo();
        $crCountItems = $this->getItemsCriteria($crCountItems, $start, $limit, $sort, $order);
        return parent::getCount($crCountItems);
    }

    /**
     * Get Count Items per timeline in the database
     * @param int $tl_id
     * @return int
     */
    public function getCountItemsTl($tl_id = 0)
    {
        $crCountItems = new \CriteriaCompo();
        $crCountItems->add(new \Criteria('item_tl_id', $tl_id));
        return parent::getCount($crCountItems);
    }

    /**
     * Get All Items in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllItems($start = 0, $limit = 0, $sort = 'item_tl_id ASC, item_weight ASC, item_id', $order = 'ASC')
    {
        $crAllItems = new \CriteriaCompo();
        $crAllItems = $this->getItemsCriteria($crAllItems, $start, $limit, $sort, $order);
        return parent::getAll($crAllItems);
    }

    /**
     * Get Criteria Items
     * @param $crItems
     * @param $start
     * @param $limit
     * @param $sort
     * @param $order
     * @return mixed
     */
    private function getItemsCriteria($crItems, $start, $limit, $sort, $order)
    {
        $crItems->setStart($start);
        $crItems->setLimit($limit);
        $crItems->setSort($sort);
        $crItems->setOrder($order);
        return $crItems;
    }
}
