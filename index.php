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
// get timeline id
$tl_id = XoopsRequest::getInt('tl_id', 0);
$timeline_rows = $timelinesHandler->getCountTimelines();
if ( $tl_id == 0 ) {
    if ($timeline_rows > 0) {
        $timelinesAll = $timelinesHandler->getAllTimelines(0, 1);
        // Get first timeline
        foreach(array_keys($timelinesAll) as $i) {
            $tl_id = $timelinesAll[$i]->getVar('tl_id');
        }
    }
}
if ($timeline_rows > 0) {
    // get timeline
    $timeline_obj = $timelinesHandler->get($tl_id);
    $tl_template  = $timeline_obj->getVar('tl_template');
    $tl_name      = $timeline_obj->getVar('tl_name');
    $tl_sortby    = $timeline_obj->getVar('tl_sortby');

    // get template and template options
    $template_obj = $templatesHandler->get($tl_template);
    $template     = $template_obj->getValuesTemplates();
    $options      = $template['options'];
	// read necessaoptions
    $tplpanel_pos = 'none';
    $tplshowyear  = 'none';
	$badgecontent  = 'none';
	foreach ($options as $option) {
		if ($option['name'] === 'panel_pos' && $option['valid'] > 0) $tplpanel_pos = $option['value'];
		if ($option['name'] === 'showyear'  && $option['valid'] > 0) $tplshowyear  = $option['value'];
		if ($option['name'] === 'badgecontent'  && $option['valid'] > 0) $badgecontent  = $option['value'];
	}

    $GLOBALS['xoopsOption']['template_main'] = $template['file'];

    include_once XOOPS_ROOT_PATH .'/header.php';

    // get pagenav options
    $start = XoopsRequest::getInt('start', 0);
    $limit = XoopsRequest::getInt('limit', $wgtimelines->getConfig('userpager'));
    if ($wgtimelines->getConfig('userpager') > 0) {
        $start = XoopsRequest::getInt('start', 0);
        $limit = XoopsRequest::getInt('limit', $wgtimelines->getConfig('userpager'));
    }

    // Define Stylesheet
    $GLOBALS['xoTheme']->addStylesheet( $style, null );
    // 
    $GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
    $GLOBALS['xoopsTpl']->assign('wgtimelines_url', WGTIMELINES_URL);
    // get items
    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('item_tl_id', $tl_id));
    if ( $limit > 0 ) {
        $criteria->setStart( $start );
        $criteria->setLimit( $limit );
    }
    if ($tl_sortby == 1) {
        $criteria->setSort('item_year DESC, item_date');
        $criteria->setOrder('DESC');
    } else if ($tl_sortby == 2) {
        $criteria->setSort('item_year ASC, item_date');
        $criteria->setOrder('ASC');
    } else {
        $criteria->setSort('item_weight');
        $criteria->setOrder('ASC');
    }
    $itemsCount = $itemsHandler->getCount($criteria);
    $itemsAll = $itemsHandler->getAll($criteria);
    $keywords = array();
    if($itemsCount > 0) {
        $items = array();

        // Get All Items
        $year = '';
        $alternate = 0;
        $j = 0;
        $inverted = 0;
        $crazycolors = 0;
        foreach(array_keys($itemsAll) as $i) {
            $j++;
            $items[$j] = $itemsAll[$i]->getValuesItems();
			// option panel pos
            if ($tplpanel_pos === 'alternate') {
                $alternate = $alternate == 0 ? 1 : 0;
                $items[$j]['alternate'] = $alternate;
            }
			if ($badgecontent === 'year') {
				// option show year
				if ($tplshowyear === 'changed') {
					if ( $year == $itemsAll[$i]->getVar('item_year')) {
						$items[$j]['badgecontent'] = '';
					} else {
						$year = $itemsAll[$i]->getVar('item_year');
						$items[$j]['badgecontent'] = $itemsAll[$i]->getVar('item_year');
					}
				} else if ($tplshowyear === 'all') {
					$items[$j]['badgecontent'] = $itemsAll[$i]->getVar('item_year');
				} else {
					$items[$j]['badgecontent'] = '';
				}
			} else if ($badgecontent === 'glyphicon') {
				$items[$j]['badgecontent'] = "<i class='glyphicon glyphicon-" .$itemsAll[$i]->getVar('item_icon') . "'></i> ";
			} else {
				// badgecontent = none
			}
			// specials for crazy colors
            if ($template['name']=== 'Crazy Colors') {
                $crazycolors++;
                if ($crazycolors == 5) $crazycolors = 1;
                $items[$j]['crazycolors'] = $crazycolors;
            }
			// inverted or not
            $items[$j]['inverted'] = $inverted;
            $inverted = $inverted == 0 ? 1 : 0;
			// misc
			if ($items[$j]['image'] === 'blank.gif') $items[$j]['image'] = '';
            $keywords[] = $itemsAll[$i]->getVar('item_title');
        }
        $GLOBALS['xoopsTpl']->assign('items', $items);
        unset($items);
        if ($wgtimelines->getConfig('tl_name') == 1) $GLOBALS['xoopsTpl']->assign('timeline_name', $tl_name);
        // set template options
        foreach ($options as $option) {
            if ($option['valid'] > 0) $GLOBALS['xoopsTpl']->assign($option['name'], $option['value']);
        }
        
        // Display Navigation
        if($itemsCount > $limit) {
            include_once XOOPS_ROOT_PATH .'/class/pagenav.php';
            $pagenav = new XoopsPageNav($itemsCount, $limit, $start, 'start', 'op=list&limit=' . $limit . '&tl_id=' . $tl_id);
            $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
        }
    }
    // Breadcrumbs
    if ( $wgtimelines->getConfig('breadcrumbs') ) {
        $xoBreadcrumbs[] = array('title' => $tl_name);
        $GLOBALS['xoopsTpl']->assign('breadcrumbs', 1);
    }
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
