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
 * @version        $Id: 1.0 templates.php 13070 Sat 2016-10-01 05:42:15Z XOOPS Development Team $
 */

use XoopsModules\Wgtimelines;

\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Handler Templates
 */
class TemplatesHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgtimelines_templates', Templates::class, 'tpl_id', 'tpl_name');
    }

    /**
     * @param $isNew
     *
     * @return Object
     */
    public function create($isNew = true): Object
    {
        return parent::create($isNew);
    }

    /**
     * retrieve a field
     *
     * @param $i field id
     * @param $fields
     * @return mixed reference to the <a href='psi_element://Get'>Get</a> object
     *                object
     */
    public function get($i = null, $fields = null): mixed
    {
        return parent::get($i, $fields);
    }

    /**
     * get inserted id
     *
     * @return integer reference to the {@link Get} object
     */
    public function getInsertId(): int
    {
        return $this->db->getInsertId();
    }

    /**
     * Get Count Templates in the database
     * @param int $start
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountTemplates(int $start = 0, int $limit = 0, string $sort = 'tpl_id', string $order = 'ASC'): int
    {
        $crCountTemplates = new \CriteriaCompo();
        $crCountTemplates = $this->getTemplatesCriteria($crCountTemplates, $start, $limit, $sort, $order);
        return parent::getCount($crCountTemplates);
    }

    /**
     * Get All Templates in the database
     * @param int $start
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllTemplates(int $start = 0, int $limit = 0, string $sort = 'tpl_weight ASC, tpl_name', string $order = 'ASC'): array
    {
        $crAllTemplates = new \CriteriaCompo();
        $crAllTemplates = $this->getTemplatesCriteria($crAllTemplates, $start, $limit, $sort, $order);
        return parent::getAll($crAllTemplates);
    }

    /**
     * Get Criteria Templates
     * @param $crTemplates
     * @param $start
     * @param $limit
     * @param $sort
     * @param $order
     * @return mixed
     */
    private function getTemplatesCriteria($crTemplates, $start, $limit, $sort, $order): mixed
    {
        $crTemplates->setStart($start);
        $crTemplates->setLimit($limit);
        $crTemplates->setSort($sort);
        $crTemplates->setOrder($order);
        return $crTemplates;
    }
}
