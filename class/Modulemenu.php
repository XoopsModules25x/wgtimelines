<?php

namespace XoopsModules\Wgtimelines;

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       Goffy - XOOPS Development Team
 */
//\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Modulemenu
 */
class Modulemenu
{

    /** function to create an array for XOOPS main menu
     *
     * @param bool $includeUrl
     * @return array
     */
    public function getMenuitemsDefault($includeUrl = false)
    {

        $moduleDirName = \basename(\dirname(__DIR__));
        $pathname      = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/';

        $urlModule = '';
        if ($includeUrl) {
            $urlModule = \XOOPS_URL . '/modules/' . $moduleDirName . '/';
        }

        require_once $pathname . 'include/common.php';

        // start creation of link list as array
        $items = [];
        $pathname = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName;
        include_once $pathname . '/include/common.php';
        // Get instance of module
        $helper = \XoopsModules\Wgtimelines\Helper::getInstance();
        // versions
        $timelinesHandler = $helper->getHandler('Timelines');
        $timelines_crit   = new \CriteriaCompo();
        $timelines_crit->setSort('tl_weight ASC, tl_name');
        $timelines_crit->setOrder('ASC');
        $timelines_crit->add(new \Criteria('tl_online', '1'));
        $timelines_rows = $timelinesHandler->getCount($timelines_crit);
        $timelines_arr  = $timelinesHandler->getAll($timelines_crit);

        if ($timelines_rows > 1) {
            foreach (\array_keys($timelines_arr) as $i) {
                $items[] = [
                    'name' => $timelines_arr[$i]->getVar('tl_name'),
                    'url'  => $urlModule . 'index.php?tl_id=' . $timelines_arr[$i]->getVar('tl_id'),
                ];
            }
        }
        // end creation of link list as array

        return $items;
    }

    /** function to create a list of nested sublinks
     *
     * @return array
     */
    public function getMenuitemsSbadmin5()
    {
        return $this->getMenuitemsDefault(true);
    }

}
