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
 * @version        $Id: 1.0 timelines.php 13070 Sat 2016-10-01 05:42:14Z XOOPS Development Team $
 */
include __DIR__ . '/header.php';

$item_id = XoopsRequest::getInt('item_id', 0);
$tpltype = XoopsRequest::getString('tpltype', 'default');

$crit_item = new CriteriaCompo();
$crit_item->add(new Criteria('item_id', $item_id));
$itemsCount = $itemsHandler->getCount($crit_item);

unset($crit_item);
if ($itemsCount > 0) {
    // get item
    $itemsObj = $itemsHandler->get($item_id);
    // update reads
    $itemsObj->setVar('item_reads', $itemsObj->getVar('item_reads') + 1);
    $itemsHandler->insert($itemsObj, true);
    // get timeline
    $item_tl_id   = $itemsObj->getVar('item_tl_id');
    $timeline_obj = $timelinesHandler->get($item_tl_id);
    $tl_template  = $timeline_obj->getVar('tl_template');
    $tl_name      = $timeline_obj->getVar('tl_name');
    $tl_limit     = $timeline_obj->getVar('tl_limit');

    // get template and template options
    $template_obj = $templatesHandler->get($tl_template);
    $template     = $template_obj->getValuesTemplates();
    $options      = $template['options'];
    
    // read necessary options
    $tplpanel_pos = 'none';
    $tplshowyear  = 'none';
    // $badgecontent  = 'none';
    foreach ($options as $option) {
        if ($option['name'] === 'panel_pos' && $option['valid'] > 0) {
            $tplpanel_pos = $option['value'];
        }
        if ($option['name'] === 'showyear'  && $option['valid'] > 0) {
            $tplshowyear  = $option['value'];
        }
        // if ($option['name'] === 'badgecontent'  && $option['valid'] > 0) $badgecontent  = $option['value'];
    }

    $GLOBALS['xoopsOption']['template_main'] = 'wgtimelines_item_' . $tpltype . '.tpl';

    include_once XOOPS_ROOT_PATH .'/header.php';

    // Define Stylesheet
    $GLOBALS['xoTheme']->addStylesheet($style, null);
    //
    $GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
    $GLOBALS['xoopsTpl']->assign('wgtimelines_url', WGTIMELINES_URL);
    $GLOBALS['xoopsTpl']->assign('wgtimelines_icons_url', WGTIMELINES_ICONS_URL);
    if (isset($GLOBALS['xoopsUser']) && is_object($GLOBALS['xoopsUser']) && $GLOBALS['xoopsUser']->isAdmin()) {
        $GLOBALS['xoopsTpl']->assign('isAdmin', 1);
    }
    if ($wgtimelines->getConfig('ratingbars')) {
        $GLOBALS['xoopsTpl']->assign('rating', $wgtimelines->getConfig('ratingbars'));
        $GLOBALS['xoopsTpl']->assign('save', 'save-item');
    }

    $keywords = array();

    $items = array();
    $year = '';
    $alternate = 0;
    $j = 0;
    $inverted = 0;
    $crazycolors = 0;
    $j++;
    $items[$j] = $itemsObj->getValuesItems();
    if ($wgtimelines->getConfig('ratingbars')) {
        $items[$j]['rating'] = $ratingsHandler->getItemRating($items[$j]['id']);
    }
    
    // misc
    $keywords[] = $itemsObj->getVar('item_title');
    
    $GLOBALS['xoopsTpl']->assign('items', $items);
    $GLOBALS['xoopsTpl']->assign('showreads', $tl_limit > 0);
    unset($items);
    if ($wgtimelines->getConfig('tl_name') == 1) {
        $GLOBALS['xoopsTpl']->assign('timeline_name', $tl_name);
    }
    // set template options
    foreach ($options as $option) {
        if ($option['valid'] > 0) {
            $GLOBALS['xoopsTpl']->assign($option['name'], $option['value']);
        }
    }

    // Breadcrumbs
    if ($wgtimelines->getConfig('breadcrumbs')) {
        $xoBreadcrumbs[] = array('title' => $tl_name, 'link' => 'index.php?tl_id=' . $item_tl_id);
        $xoBreadcrumbs[] = array('title' => $itemsObj->getVar('item_title'));
        $GLOBALS['xoopsTpl']->assign('breadcrumbs', 1);
    }
} else {
    echo 'invalid item id';
}

$GLOBALS['xoopsTpl']->assign('welcome', $wgtimelines->getConfig('welcome'));
// Keywords
wgtimelinesMetaKeywords($wgtimelines->getConfig('keywords').', '. implode(',', $keywords));
unset($keywords);
// Description
wgtimelinesMetaDescription(_MA_WGTIMELINES_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGTIMELINES_URL.'/timelines.php');
$GLOBALS['xoopsTpl']->assign('wgtimelines_upload_url', WGTIMELINES_UPLOAD_URL);
include __DIR__ . '/footer.php';
