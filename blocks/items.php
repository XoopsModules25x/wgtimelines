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
 * @version        $Id: 1.0 items.php 13070 Mon 2016-12-05 18:41:23Z XOOPS Development Team $
 */

use XoopsModules\Wgtimelines\Helper;

include_once \XOOPS_ROOT_PATH.'/modules/wgtimelines/include/common.php';

// Function show block
function b_wgtimelines_items_show($options)
{
    include_once \XOOPS_ROOT_PATH.'/modules/wgtimelines/class/Items.php';
    $GLOBALS['xoopsTpl']->assign('wgtimelines_upload_url', \WGTIMELINES_UPLOAD_URL);
    $block       = array();
    $limit       = (int)$options[1];
    $lenghtTitle = (int)$options[2];
    $typeBlock   = $options[3];
    $timelines   = $options[4];
    $helper           = Helper::getInstance();
    $timelinesHandler = $helper->getHandler('Timelines');
    $itemsHandler     = $helper->getHandler('Items');
    $criteria = new \CriteriaCompo();
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    switch ($typeBlock) {
        // For the block: items last
        case 'last':
            $criteria->add(new \Criteria('item_online', 1));
            $criteria->setSort('item_date_create');
            $criteria->setOrder('DESC');
        break;
        // For the block: items new
        case 'new':
            $criteria->add(new \Criteria('item_display', 1));
            $criteria->add(new \Criteria('item_date_create', \strtotime(date(_SHORTDATESTRING)), '>='));
            $criteria->add(new \Criteria('item_date_create', \strtotime(date(_SHORTDATESTRING))+86400, '<='));
            $criteria->setSort('item_date_create');
            $criteria->setOrder('ASC');
        break;
        // For the block: items random
        case 'random':
            $criteria->add(new \Criteria('item_online', 1));
            $criteria->setSort('RAND()');
        break;
    }
    if ($timelines > 0) {
        $criteria->add(new \Criteria('item_tl_id', $timelines));
    }
    $criteria->setLimit($limit);
    $itemsAll = $itemsHandler->getAll($criteria);
    unset($criteria);
    foreach (\array_keys($itemsAll) as $i) {
        $block[$i]['id'] = $itemsAll[$i]->getVar('item_id');
        $block[$i]['tl_id'] = $itemsAll[$i]->getVar('item_tl_id');
        $timelineObj = $timelinesHandler->get($itemsAll[$i]->getVar('item_tl_id'));
        $block[$i]['tl_name'] = limitLength($timelineObj->getVar('tl_name'), $lenghtTitle);
        $block[$i]['title'] = limitLength($itemsAll[$i]->getVar('item_title'), $lenghtTitle);
        $block[$i]['image'] = $itemsAll[$i]->getVar('item_image');
        $block[$i]['date'] = \formatTimestamp($itemsAll[$i]->getVar('item_date'));
        $block[$i]['url'] = \WGTIMELINES_URL;
    }
    return $block;
}

function limitLength($text, $lenghtTitle)
{
    if ($lenghtTitle > 0) {
        if (\strlen($text) > $lenghtTitle) {
            return \substr($text, 0, $lenghtTitle) . '...';
        }
    }
    return $text;
}

// Function edit block
function b_wgtimelines_items_edit($options)
{
    include_once \XOOPS_ROOT_PATH.'/modules/wgtimelines/class/items.php';
    $helper = Helper::getInstance();
    $timelinesHandler = $helper->getHandler('Timelines');

    $GLOBALS['xoopsTpl']->assign('wgtimelines_upload_url', \WGTIMELINES_UPLOAD_URL);
    $form  = \_MB_WGTIMELINES_ITEMS_TO_DISPLAY . ': ';
    $form .= "<input type='hidden' name='options[0]' value='".$options[0] . '\' />';
    $form .= "<input type='text' name='options[1]' size='5' maxlength='255' value='".$options[1] . '\' />&nbsp;<br>';
    $form .= \_MB_WGTIMELINES_TITLE_LENGTH.": <input type='text' name='options[2]' size='5' maxlength='255' value='".$options[2] . '\' /><br>';

    $form .= \_MB_WGTIMELINES_ITEMS_DISPLAY_CAT.":<br><select name='options[3]' size='4'>";
    $form .= "<option value='last' " . ('last' === $options[3] ? "selected='selected'" : '') . '>' . \_MB_WGTIMELINES_ITEMS_LAST . '</option>';
    $form .= "<option value='new' " . ('new' === $options[3] ? "selected='selected'" : '') . '>' . \_MB_WGTIMELINES_ITEMS_NEW . '</option>';
    $form .= "<option value='random' " . ('random' === $options[3] ? "selected='selected'" : '') . '>' . \_MB_WGTIMELINES_ITEMS_RANDOM . '</option>';
    $form .= '</select><br><br>';

    $criteria = new \CriteriaCompo();
    $criteria->add(new \Criteria('tl_id', 0, '!='));
    $criteria->setSort('tl_weight');
    $criteria->setOrder('ASC');
    $timelinesAll = $timelinesHandler->getAll($criteria);
    unset($criteria);
    $form .= \_MB_WGTIMELINES_ITEMS_TIMELINES_APPLY.":<br><select name='options[4]' size='5'>";
    $form .= "<option value='0' " . ('0' === $options[4] ? "selected='selected'" : '') . '>' . \_MB_WGTIMELINES_ALL_TIMELINES . '</option>';
    foreach (\array_keys($timelinesAll) as $i) {
        $tl_id = $timelinesAll[$i]->getVar('tl_id');
        $form .= "<option value='" . $tl_id . '\' ' . ($tl_id === $options[4] ? "selected='selected'" : '') . '>'
                 . $timelinesAll[$i]->getVar('tl_name') . '</option>';
    }
    $form .= '</select>';

    \array_shift($options);
    \array_shift($options);
    \array_shift($options);

    return $form;
}
