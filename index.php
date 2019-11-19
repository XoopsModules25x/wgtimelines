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
 * @author         goffy (wedega.com) - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 * @version        $Id: 1.0 timelines.php 13070 Sat 2016-10-01 05:42:14Z XOOPS Development Team $
 */

use XoopsModules\Wgtimelines;
use XoopsModules\Wgtimelines\Constants;
use Xmf\Request;

include __DIR__ . '/header.php';
// get timeline id
$tl_id = Request::getInt('tl_id', 0);
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('userpager'));

$startpage = $helper->getConfig('startpage', 0);

$criteria = new \CriteriaCompo();
$criteria->add(new \Criteria('tl_online', 1));
if ($tl_id > 0) {
    $criteria->add(new \Criteria('tl_id', $tl_id));
}
$criteria->setSort('tl_weight ASC, tl_id');
$criteria->setOrder('ASC');
if ($startpage == 3) {
    $criteria->setLimit('1');
}
$timelinesCount = $timelinesHandler->getCount($criteria);
if ($limit > 0  && $tl_id == 0) {
    $criteria->setStart($start);
    $criteria->setLimit($limit);
}
$timelinesAll = $timelinesHandler->getAll($criteria);

if ($tl_id == 0 && $startpage == 3 && $timelinesCount > 0) {
    // Get first timeline
    foreach (array_keys($timelinesAll) as $t) {
        $tl_id  = $timelinesAll[$t]->getvar('tl_id');
    }
}

unset($criteria);
if ($timelinesCount > 0) {
    if ($tl_id > 0) {
        // display one timeline
        foreach (array_keys($timelinesAll) as $t) {
            $tl_template  = $timelinesAll[$t]->getVar('tl_template');
            $tl_name      = $timelinesAll[$t]->getVar('tl_name');
            $tl_desc      = $timelinesAll[$t]->getVar('tl_desc', 'show');
            $tl_sortby    = $timelinesAll[$t]->getVar('tl_sortby');
            $tl_limit     = $timelinesAll[$t]->getVar('tl_limit');
            $tl_magnific  = $timelinesAll[$t]->getVar('tl_magnific');
			$tl_expired   = $timelinesAll[$t]->getVar('tl_expired');
            // get template and template options
            $template_obj = $templatesHandler->get($tl_template);
            $template     = $template_obj->getValuesTemplates();
            $options      = $template['options'];
            // read necessary options
            $tplpanel_pos = 'none';
            $tplshowyear  = 'none';
            $badgecontent  = 'none';
            foreach ($options as $option) {
                if ($option['name'] === 'panel_pos' && $option['valid'] > 0) {
                    $tplpanel_pos = $option['value'];
                }
                if ($option['name'] === 'showyear'  && $option['valid'] > 0) {
                    $tplshowyear  = $option['value'];
                }
                if ($option['name'] === 'badgecontent'  && $option['valid'] > 0) {
                    $badgecontent  = $option['value'];
                }
            }

            $GLOBALS['xoopsOption']['template_main'] = $template['file'];
            include_once XOOPS_ROOT_PATH .'/header.php';

            // Define Stylesheet
            $GLOBALS['xoTheme']->addStylesheet($style, null);
            // assets for magnific popup
            if ($tl_magnific == 1) {
                $GLOBALS['xoTheme']->addStylesheet(WGTIMELINES_URL . '/assets/css/magnific-popup.css');
                $GLOBALS['xoTheme']->addStylesheet(WGTIMELINES_URL . '/assets/css/wgtimelines.magnific.css');
                $GLOBALS['xoTheme']->addScript(WGTIMELINES_URL . '/assets/js/jquery.magnific-popup.min.js', array('type' => 'text/javascript'));
                $GLOBALS['xoTheme']->addScript(WGTIMELINES_URL . '/assets/js/wgtimelines.magnific.js', array('type' => 'text/javascript'));
                $GLOBALS['xoopsTpl']->assign('use_magnific', true);
            }
            //
            $GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
            $GLOBALS['xoopsTpl']->assign('wgtimelines_url', WGTIMELINES_URL);
            if (isset($GLOBALS['xoopsUser']) && is_object($GLOBALS['xoopsUser']) && $GLOBALS['xoopsUser']->isAdmin()) {
                $GLOBALS['xoopsTpl']->assign('isAdmin', 1);
            }
            if ($helper->getConfig('ratingbars')) {
                $GLOBALS['xoopsTpl']->assign('rating', $helper->getConfig('ratingbars'));
                $GLOBALS['xoopsTpl']->assign('save', 'save-index');
            }
            // get items
            $criteria = new \CriteriaCompo();
            $criteria->add(new \Criteria('item_tl_id', $tl_id));
            $criteria->add(new \Criteria('item_online', 1));
			if ( Constants::WGTIMELINES_TIMELINE_EXPIRED_HIDE == $tl_expired ) { //=== does not work
				$criteria->add(new \Criteria('item_date', time(), '>'));
			}
            if ($limit > 0) {
                $criteria->setStart($start);
                $criteria->setLimit($limit);
            }
            if ($tl_sortby == 1) {
                $criteria->setSort('item_year DESC, item_date');
                $criteria->setOrder('DESC');
            } elseif ($tl_sortby == 2) {
                $criteria->setSort('item_year ASC, item_date');
                $criteria->setOrder('ASC');
            } else {
                $criteria->setSort('item_weight');
                $criteria->setOrder('ASC');
            }
            $itemsCount = $itemsHandler->getCount($criteria);
            $itemsAll = $itemsHandler->getAll($criteria);
            $keywords = array();
            if ($itemsCount > 0) {
                $items = array();

                // Get All Items
                $year = '';
                $alternate = 0;
                $j = 0;
                $inverted = 0;
                $crazycolors = 0;
                foreach (array_keys($itemsAll) as $i) {
                    $j++;
                    $items[$j] = $itemsAll[$i]->getValuesItems($timelinesAll[$t]);
                    // option panel pos
                    if ($tplpanel_pos === 'alternate') {
                        $alternate = $alternate == 0 ? 1 : 0;
                        $items[$j]['alternate'] = $alternate;
                    }
                    // option show year
                    if ($tplshowyear === 'changed') {
                        if ($year == $itemsAll[$i]->getVar('item_year')) {
                            $items[$j]['showyear'] = '';
                        } else {
                            $year = $itemsAll[$i]->getVar('item_year');
                            $items[$j]['showyear'] = $itemsAll[$i]->getVar('item_year');
                        }
                    } elseif ($tplshowyear === 'all') {
                        $items[$j]['showyear'] = $itemsAll[$i]->getVar('item_year');
                    } else {
                        $items[$j]['showyear'] = '';
                    }
                    if ($badgecontent === 'year') {
                        $items[$j]['badgecontent'] = $items[$j]['showyear'];
                    } elseif ($badgecontent === 'glyphicon') {
                        $items[$j]['badgecontent'] = "<i class='glyphicon glyphicon-" .$itemsAll[$i]->getVar('item_icon') . '\'></i> ';
                    }

                    // specials for crazy colors
                    if ($template['name']=== 'Crazy Colors') {
                        $crazycolors++;
                        if ($crazycolors == 5) {
                            $crazycolors = 1;
                        }
                        $items[$j]['crazycolors'] = $crazycolors;
                    }
                    // inverted or not
                    $items[$j]['inverted'] = $inverted;
                    $inverted = $inverted == 0 ? 1 : 0;
                    // misc
                    if ($items[$j]['image'] === 'blank.gif') {
                        $items[$j]['image'] = '';
                    }
                    if ($items[$j]['content_summary'] != '') {
                        $items[$j]['content'] = $items[$j]['content_summary'];
                        $items[$j]['readmore'] = 1;
                    }
                    if ($helper->getConfig('ratingbars')) {
                        $items[$j]['rating'] = $ratingsHandler->getItemRating($items[$j]['id']);
                    }
                    $keywords[] = $itemsAll[$i]->getVar('item_title');
                }
                $GLOBALS['xoopsTpl']->assign('items', $items);
                $GLOBALS['xoopsTpl']->assign('showreads', $tl_limit > 0);
                unset($items);

                // set template options
                foreach ($options as $option) {
                    if ($option['valid'] > 0) {
                        $GLOBALS['xoopsTpl']->assign($option['name'], $option['value']);
                    }
                }

                // Display Navigation
                if ($itemsCount > $limit) {
                    include_once XOOPS_ROOT_PATH .'/class/pagenav.php';
                    $pagenav = new XoopsPageNav($itemsCount, $limit, $start, 'start', 'op=list&limit=' . $limit . '&tl_id=' . $tl_id);
                    $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
                }
            } else {
                $GLOBALS['xoopsTpl']->assign('error', _MA_WGTIMELINES_THEREARENT_ITEMS);
            }
            if ($helper->getConfig('tl_name') == 1) {
                $GLOBALS['xoopsTpl']->assign('timeline_name', $tl_name);
            }
            if ($helper->getConfig('tl_description') == 3) {
                $GLOBALS['xoopsTpl']->assign('timeline_desc', $tl_desc);
            }
            // Breadcrumbs
            if ($helper->getConfig('breadcrumbs')) {
                $xoBreadcrumbs[] = array('title' => $tl_name);
                $GLOBALS['xoopsTpl']->assign('breadcrumbs', 1);
            }
        }
    } else {
        // show list
        $GLOBALS['xoopsOption']['template_main'] = 'wgtimelines_index.tpl';
        include_once XOOPS_ROOT_PATH .'/header.php';
        
        $templatesAll = $templatesHandler->getAll();
        
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        foreach (array_keys($timelinesAll) as $i) {
            $timelines[$i] = $timelinesAll[$i]->getValuesTimelines();
            if ($helper->getConfig('tl_description') > 1) {
                $timelines[$i]['timeline_desc'] = $timelines[$i]['desc'];
            }
            // $timelines[$i]['timeline_desc'] = $timelines[$i]['desc'];
            $keywords[] = $timelinesAll[$i]->getVar('tl_name');
        }
        $GLOBALS['xoopsTpl']->assign('timelines', $timelines);

        //
        $GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
        $GLOBALS['xoopsTpl']->assign('wgtimelines_url', WGTIMELINES_URL);

        // Display Navigation
        if ($timelinesCount > $limit) {
            include_once XOOPS_ROOT_PATH .'/class/pagenav.php';
            $pagenav = new XoopsPageNav($timelinesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
            $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
        }
    }

    $GLOBALS['xoopsTpl']->assign('welcome', $helper->getConfig('welcome'));


    // Keywords
    wgtimelinesMetaKeywords($helper->getConfig('keywords').', '. implode(',', $keywords));
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
