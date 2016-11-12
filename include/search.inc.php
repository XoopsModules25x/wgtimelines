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
 * @version        $Id: 1.0 search.inc.php 13070 Sat 2016-10-01 05:42:17Z XOOPS Development Team $
 */

// search callback functions
function wgtimelines_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;
    $sql = "SELECT 'tpl_id', 'tpl_name' FROM ".$xoopsDB->prefix('wgtimelines_templates') . ' WHERE tpl_id != 0';
    if ( $userid != 0 ) {
        $sql .= ' AND tpl_submitter=' . (int)$userid;
    }
    if ( is_array($queryarray) && $count = count($queryarray) )
    {
        $sql .= ' AND (';
        for($i = 1; $i < $count; ++$i)
        {
            $sql .= " $andor ";
            $sql .= '';
        }
        $sql .= ')';
    }
    $sql .= " ORDER BY 'tpl_id' DESC";
    $result = $xoopsDB->query($sql,$limit,$offset);
    $ret = array();
    $i = 0;
    while($myrow = $xoopsDB->fetchArray($result))
    {
        $ret[$i]['image'] = 'assets/icons/32/blank.gif';
        $ret[$i]['link'] = 'templates.php?tpl_id='.$myrow['tpl_id'];
        $ret[$i]['title'] = $myrow['tpl_name'];
        ++$i;
    }
    unset($i);
}
