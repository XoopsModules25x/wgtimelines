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
 * @version        $Id: 1.0 timelines.php 13070 Sat 2016-10-01 05:42:14Z XOOPS Development Team $
 */

use XoopsModules\Wgtimelines;
use XoopsModules\Wgtimelines\Constants;
use XoopsModules\Wgtimelines\Helper;

include_once \XOOPS_ROOT_PATH.'/modules/wgtimelines/include/common.php';
// Function show block
function b_wgtimelines_timelines_show($options)
{
    $helper = \XoopsModules\Wgtimelines\Helper::getInstance();
    include_once \XOOPS_ROOT_PATH.'/modules/wgtimelines/class/Timelines.php';
    $myts = MyTextSanitizer::getInstance();
    $GLOBALS['xoopsTpl']->assign('wgtimelines_upload_url', \WGTIMELINES_UPLOAD_URL);
    $block       = [];
    // $typeBlock   = $options[0];
    $lenghtTitle = (int)$options[1];
    $timelinesHandler = $helper->getHandler('Timelines');
    $criteria = new \CriteriaCompo();
    \array_shift($options);
    \array_shift($options);
    $criteria->add(new \Criteria('tl_online', 1));
    $criteria->setSort('tl_weight');
    $criteria->setOrder('ASC');
    $timelinesAll = $timelinesHandler->getAll($criteria);
    unset($criteria);
    foreach (\array_keys($timelinesAll) as $i) {
        $block[$i]['id'] = $myts->htmlSpecialChars($timelinesAll[$i]->getVar('tl_id'));
        $tl_name = $myts->htmlSpecialChars($timelinesAll[$i]->getVar('tl_name'));
        if ($lenghtTitle > 0) {
            $tl_name = \substr($tl_name, 0, $lenghtTitle);
        }
        $block[$i]['name'] = $tl_name;
        $block[$i]['url'] = \WGTIMELINES_URL;
    }
    return $block;
}

// Function edit block
function b_wgtimelines_timelines_edit($options)
{
    include_once \XOOPS_ROOT_PATH.'/modules/wgtimelines/class/Timelines.php';
    $helper = \XoopsModules\Wgtimelines\Helper::getInstance();
    $timelinesHandler = $helper->getHandler('Timelines');
    $GLOBALS['xoopsTpl']->assign('wgtimelines_upload_url', \WGTIMELINES_UPLOAD_URL);
    $form = "<input type='hidden' name='options[0]' value='".$options[0] . '\' />';
    $form .= \_MB_WGTIMELINES_TITLE_LENGTH." : <input type='text' name='options[1]' size='5' maxlength='255' value='".$options[1] . '\' /><br><br>';
    \array_shift($options);
    \array_shift($options);
    $criteria = new \CriteriaCompo();
    $criteria->add(new \Criteria('tl_id', 0, '!='));
    $criteria->setSort('tl_weight');
    $criteria->setOrder('ASC');
    $timelinesAll = $timelinesHandler->getAll($criteria);
    unset($criteria);
    $form .= \_MB_WGTIMELINES_TIMELINES_TO_DISPLAY."<br><select name='options[]' multiple='multiple' size='5'>";
    $form .= "<option value='0' " . (!\in_array(0, $options) ? '' : "selected='selected'") . '>' . \_MB_WGTIMELINES_ALL_TIMELINES . '</option>';
    foreach (\array_keys($timelinesAll) as $i) {
        $tl_id = $timelinesAll[$i]->getVar('tl_id');
        $form .= "<option value='" . $tl_id . '\' ' . (!\in_array($tl_id, $options) ? '' : "selected='selected'") . '>'
                 . $timelinesAll[$i]->getVar('tl_name') . '</option>';
    }
    $form .= '</select>';
    return $form;
}
