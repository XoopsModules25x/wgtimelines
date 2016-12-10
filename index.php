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
$start = XoopsRequest::getInt('start', 0);
$limit = XoopsRequest::getInt('limit', $wgtimelines->getConfig('userpager'));
			
$startpage = $wgtimelines->getConfig('startpage', 0);

$criteria = new CriteriaCompo();
$criteria->add(new Criteria('tl_online', 1));
if ($tl_id > 0) {
    $criteria->add(new Criteria('tl_id', $tl_id));
}
$criteria->setSort('tl_weight ASC, tl_id');
$criteria->setOrder('ASC');
if ($startpage == 3) {
    $criteria->setLimit('1');
}
$timelinesCount = $timelinesHandler->getCount($criteria);
if ( $limit > 0  && $tl_id == 0) {
	$criteria->setStart( $start );
	$criteria->setLimit( $limit );
}
$timelinesAll = $timelinesHandler->getAll($criteria);

if ( $tl_id == 0 && $startpage == 3 && $timelinesCount > 0 ) {
    // Get first timeline
	foreach (array_keys($timelinesAll) as $i) {
        $tl_id  = $timelinesAll[$i]->getvar('tl_id');
    }
}

unset($criteria);
if ($timelinesCount > 0) {
	if ( $tl_id > 0 ) {
		// display one timeline
		foreach (array_keys($timelinesAll) as $i) {
			$tl_template  = $timelinesAll[$i]->getVar('tl_template');
			$tl_name      = $timelinesAll[$i]->getVar('tl_name');
			$tl_desc      = $timelinesAll[$i]->getVar('tl_desc', 'n');
			$tl_sortby    = $timelinesAll[$i]->getVar('tl_sortby');
			$tl_limit     = $timelinesAll[$i]->getVar('tl_limit');
			echo $tl_desc;
			// get template and template options
			$template_obj = $templatesHandler->get($tl_template);
			$template     = $template_obj->getValuesTemplates();
			$options      = $template['options'];
			// read necessary options
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

			// Define Stylesheet
			$GLOBALS['xoTheme']->addStylesheet( $style, null );
			// 
			$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
			$GLOBALS['xoopsTpl']->assign('wgtimelines_url', WGTIMELINES_URL);
			if (isset($GLOBALS['xoopsUser']) && is_object($GLOBALS['xoopsUser']) && $GLOBALS['xoopsUser']->isAdmin()) $GLOBALS['xoopsTpl']->assign('isAdmin', 1);
			// get items
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('item_tl_id', $tl_id));
			$criteria->add(new Criteria('item_online', 1));
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
					// option show year
					if ($tplshowyear === 'changed') {
						if ( $year == $itemsAll[$i]->getVar('item_year')) {
							$items[$j]['showyear'] = '';
						} else {
							$year = $itemsAll[$i]->getVar('item_year');
							$items[$j]['showyear'] = $itemsAll[$i]->getVar('item_year');
						}
					} else if ($tplshowyear === 'all') {
						$items[$j]['showyear'] = $itemsAll[$i]->getVar('item_year');
					} else {
						$items[$j]['showyear'] = '';
					}
					if ($badgecontent === 'year') {
						$items[$j]['badgecontent'] = $items[$j]['showyear'];
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
					if ($items[$j]['content_summary'] != '') {
						$items[$j]['content'] = $items[$j]['content_summary'];
						$items[$j]['readmore'] = 1;
					}
					$keywords[] = $itemsAll[$i]->getVar('item_title');
				}
				$GLOBALS['xoopsTpl']->assign('items', $items);
				$GLOBALS['xoopsTpl']->assign('showreads', $tl_limit > 0);
				unset($items);
				
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
			} else {
				$GLOBALS['xoopsTpl']->assign('error', _MA_WGTIMELINES_THEREARENT_ITEMS);
			}
			
			if ($wgtimelines->getConfig('tl_name') == 1) $GLOBALS['xoopsTpl']->assign('timeline_name', $tl_name);
			if ($wgtimelines->getConfig('tl_desc') == 3) $GLOBALS['xoopsTpl']->assign('timeline_desc', $tl_desc);
			// Breadcrumbs
			if ( $wgtimelines->getConfig('breadcrumbs') ) {
				$xoBreadcrumbs[] = array('title' => $tl_name);
				$GLOBALS['xoopsTpl']->assign('breadcrumbs', 1);
			}
		}
	} else {
		// show list
		$GLOBALS['xoopsOption']['template_main'] = 'wgtimelines_index.tpl';
		include_once XOOPS_ROOT_PATH .'/header.php';

		// Define Stylesheet
		$GLOBALS['xoTheme']->addStylesheet( $style, null );
		foreach(array_keys($timelinesAll) as $i)
		{
			$timelines[$i] = $timelinesAll[$i]->getValuesTimelines();
			if ($wgtimelines->getConfig('tl_desc') < 2) $timelines[$i]['tl_desc'] = 'aaa';
			$keywords[] = $timelinesAll[$i]->getVar('tl_name');
		}
		$GLOBALS['xoopsTpl']->assign('timelines', $timelines);

		// 
		$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
		$GLOBALS['xoopsTpl']->assign('wgtimelines_url', WGTIMELINES_URL);
		
		// Display Navigation
		if($timelinesCount > $limit) {
			include_once XOOPS_ROOT_PATH .'/class/pagenav.php';
			$pagenav = new XoopsPageNav($timelinesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
			$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
		}
	}
	$GLOBALS['xoopsTpl']->assign('welcome', $wgtimelines->getConfig('welcome'));
	// Keywords
	wgtimelinesMetaKeywords($wgtimelines->getConfig('keywords').', '. implode(',', $keywords));
	unset($keywords);
} else {
	$GLOBALS['xoopsOption']['template_main'] = 'wgtimelines_index.tpl';
	include_once XOOPS_ROOT_PATH .'/header.php';
	$GLOBALS['xoopsTpl']->assign('error', _MA_WGTIMELINES_THEREARENT_TIMELINES);
}

// Description
wgtimelinesMetaDescription(_MA_WGTIMELINES_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGTIMELINES_URL.'/timelines.php');
$GLOBALS['xoopsTpl']->assign('wgtimelines_upload_url', WGTIMELINES_UPLOAD_URL);
include __DIR__ . '/footer.php';
