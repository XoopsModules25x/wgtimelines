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
 * @param $queryarray
 * @param $andor
 * @param $limit
 * @param $offset
 * @param $userid
 * @copyright      module for xoops
 * @license        GPL 3.0 or later
 * @package        wgtimelines
 * @since          1.0
 * @min_xoops      2.5.7
 * @author         goffy (wedega.com) - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 * @version        $Id: 1.0 search.inc.php 13070 Sat 2016-10-01 05:42:17Z XOOPS Development Team $
 */

// search callback functions
function wgtimelines_search($queryarray, $andor, $limit, $offset, $userid): array
{
    global $xoopsDB;

    $ret = [];

    $sql = "SELECT tl_id, tl_name, tl_date_create FROM ".$xoopsDB->prefix('wgtimelines_timelines') . ' WHERE tl_id != 0';
    if ($userid !== 0) {
        $sql .= ' AND tl_submitter=' . (int)$userid;
    }
    if (\is_array($queryarray) && $count = \count($queryarray)) {
        $sql .= ' AND (';
        for ($i = 1; $i < $count; ++$i) {
            $sql .= " $andor ";
            $sql .= '';
        }
        $sql .= ')';
    }
    $sql .= " ORDER BY tl_id DESC";
    $result = $xoopsDB->query($sql, $limit, $offset);
    $i = 0;
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $ret[$i]['image'] = 'assets/icons/32/timelines.png';
        $ret[$i]['link']  = 'timelines.php?tl_id='.$myrow['tl_id'];
        $ret[$i]['title'] = $myrow['tl_name'];
        $ret[$i]['time']  = $myrow['tl_date_create'];
        ++$i;
    }

    $sql = "SELECT item_id, item_title, item_date_create FROM ".$xoopsDB->prefix('wgtimelines_items') . ' WHERE item_id != 0';
    if ($userid !== 0) {
        $sql .= ' AND item_submitter=' . (int)$userid;
    }
    if (\is_array($queryarray) && $count = \count($queryarray)) {
        $sql .= ' AND (';
        for ($i = 1; $i < $count; ++$i) {
            $sql .= " $andor ";
            $sql .= '';
        }
        $sql .= ')';
    }
    $sql .= " ORDER BY item_id DESC";
    $result = $xoopsDB->query($sql, $limit, $offset);
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $ret[$i]['image'] = 'assets/icons/32/items.png';
        $ret[$i]['link']  = 'items.php?item_id='.$myrow['item_id'];
        $ret[$i]['title'] = $myrow['item_title'];
        $ret[$i]['time']  = $myrow['item_date_create'];
        ++$i;
    }
    unset($i);

    return $ret;
}
