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
 * @version        $Id: 1.0 timelines.php 13070 Sat 2016-10-01 05:42:13Z XOOPS Development Team $
 */
include __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = XoopsRequest::getString('op', 'list');
// Request tl_id
$tlId = XoopsRequest::getInt('tl_id');
switch($op) {
    case 'list':
    default:
        $GLOBALS['xoTheme']->addScript(WGTIMELINES_URL . '/assets/js/sortable-timelines.js');
        $start = XoopsRequest::getInt('start', 0);
        $limit = XoopsRequest::getInt('limit', $wgtimelines->getConfig('adminpager'));
        $templateMain = 'wgtimelines_admin_timelines.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('timelines.php'));
        $adminMenu->addItemButton(_AM_WGTIMELINES_TIMELINE_ADD, 'timelines.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
        $timelinesCount = $timelinesHandler->getCountTimelines();
        $timelinesAll = $timelinesHandler->getAllTimelines($start, $limit);
        $GLOBALS['xoopsTpl']->assign('timelines_count', $timelinesCount);
        $GLOBALS['xoopsTpl']->assign('wgtimelines_url', WGTIMELINES_URL);
        $GLOBALS['xoopsTpl']->assign('wgtimelines_icons_url', WGTIMELINES_ICONS_URL);
        $GLOBALS['xoopsTpl']->assign('wgtimelines_upload_url', WGTIMELINES_UPLOAD_URL);
        // Table view timelines
        if($timelinesCount > 0) {
            foreach(array_keys($timelinesAll) as $i) {
                $timeline = $timelinesAll[$i]->getValuesTimelines();
                if ($timeline['tl_sortby'] == 1) {
                    $timeline['sortby_text'] = _AM_WGTIMELINES_TIMELINE_SORTBY_Y_DESC;
                } else if ($timeline['tl_sortby'] == 2) {
                    $timeline['sortby_text'] = _AM_WGTIMELINES_TIMELINE_SORTBY_Y_ASC;
                } else {
                    $timeline['sortby_text'] = _AM_WGTIMELINES_TIMELINE_SORTBY_ADMIN;
                }
                $GLOBALS['xoopsTpl']->append('timelines_list', $timeline);
                unset($timeline);
            }
            // Display Navigation
            if($timelinesCount > $limit) {
                include_once XOOPS_ROOT_PATH .'/class/pagenav.php';
                $pagenav = new XoopsPageNav($timelinesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', _AM_WGTIMELINES_THEREARENT_TIMELINES);
        }

    break;
    case 'new':
        $templateMain = 'wgtimelines_admin_timelines.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('timelines.php'));
        $adminMenu->addItemButton(_AM_WGTIMELINES_TIMELINES_LIST, 'timelines.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
        // Get Form
        $timelinesObj = $timelinesHandler->create();
        $form = $timelinesObj->getFormTimelines();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

    break;
    case 'save':
        // Security Check
        if(!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('timelines.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if(isset($tlId)) {
            $timelinesObj = $timelinesHandler->get($tlId);
        } else {
            $timelinesObj = $timelinesHandler->create();
        }
        // Set Vars
        $timelinesObj->setVar('tl_name', $_POST['tl_name']);
        //fix for avoid hiding empty paragraphs in some browsers (instead of: $timelinesObj->setVar('tl_desc', $_POST['tl_desc']);
        $timelinesObj->setVar('tl_desc', preg_replace('/<p><\/p>/', '<p>&nbsp;</p>', $_POST['tl_desc']));
        // Set Var tl_image
        include_once XOOPS_ROOT_PATH .'/class/uploader.php';
        $uploader = new XoopsMediaUploader(WGTIMELINES_UPLOAD_IMAGE_PATH.'/timelines/', 
                                            $wgtimelines->getConfig('mimetypes'), 
                                            $wgtimelines->getConfig('maxsize'), null, null);
        if($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            $extension = preg_replace('/^.+\.([^.]+)$/sU', '', $_FILES['attachedfile']['name']);
            $imgName = str_replace(' ', '', $_POST['tl_name']).'.'.$extension;
            $uploader->setPrefix($imgName);
            $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
            if(!$uploader->upload()) {
                $errors = $uploader->getErrors();
                redirect_header('javascript:history.go(-1).php', 3, $errors);
            } else {
                $timelinesObj->setVar('tl_image', $uploader->getSavedFileName());
            }
        } else {
            $timelinesObj->setVar('tl_image', $_POST['tl_image']);
        }
        $timelinesObj->setVar('tl_weight', isset($_POST['tl_weight']) ? $_POST['tl_weight'] : 0);
        $timelinesObj->setVar('tl_template', isset($_POST['tl_template']) ? $_POST['tl_template'] : 0);
        $timelinesObj->setVar('tl_sortby', isset($_POST['tl_sortby']) ? $_POST['tl_sortby'] : 0);
        $timelinesObj->setVar('tl_limit', isset($_POST['tl_limit']) ? $_POST['tl_limit'] : 0);
        $timelinesObj->setVar('tl_online', isset($_POST['tl_online']) ? $_POST['tl_online'] : 0);
        $timelinesObj->setVar('tl_submitter', isset($_POST['tl_submitter']) ? $_POST['tl_submitter'] : 0);
        $timelineDate_create = date_create_from_format(_SHORTDATESTRING, $_POST['tl_date_create']);
        $timelinesObj->setVar('tl_date_create', $timelineDate_create->getTimestamp());
        // Insert Data
        if($timelinesHandler->insert($timelinesObj)) {
            $newCatId = $timelinesObj->getNewInsertedIdTimelines();
            $permId = isset($_REQUEST['tl_id']) ? $tlId : $newTlId;
            $gpermHandler = xoops_getHandler('groupperm');
            // Permission to view
            if(isset($_POST['groups_view'])) {
                foreach($_POST['groups_view'] as $onegroupId) {
                    $gpermHandler->addRight('wgtimelines_view', $permId, $onegroupId, $GLOBALS['xoopsModule']->getVar('mid'));
                }
            }
            // Permission to submit
            if(isset($_POST['groups_submit'])) {
                foreach($_POST['groups_submit'] as $onegroupId) {
                    $gpermHandler->addRight('wgtimelines_submit', $permId, $onegroupId, $GLOBALS['xoopsModule']->getVar('mid'));
                }
            }
            // Permission to approve
            if(isset($_POST['groups_approve'])) {
                foreach($_POST['groups_approve'] as $onegroupId) {
                    $gpermHandler->addRight('wgtimelines_approve', $permId, $onegroupId, $GLOBALS['xoopsModule']->getVar('mid'));
                }
            }
            redirect_header('timelines.php?op=list', 2, _AM_WGTIMELINES_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $timelinesObj->getHtmlErrors());
        $form = $timelinesObj->getFormTimelines();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

    break;
    case 'edit':
        $templateMain = 'wgtimelines_admin_timelines.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('timelines.php'));
        $adminMenu->addItemButton(_AM_WGTIMELINES_TIMELINE_ADD, 'timelines.php?op=new', 'add');
        $adminMenu->addItemButton(_AM_WGTIMELINES_TIMELINES_LIST, 'timelines.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
        // Get Form
        $timelinesObj = $timelinesHandler->get($tlId);
        $form = $timelinesObj->getFormTimelines();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

    break;
    case 'delete':
        $timelinesObj = $timelinesHandler->get($tlId);
        if(isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if(!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('timelines.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            // delete all items first
            $crit_items = new CriteriaCompo();
            $crit_items->add(new Criteria('item_tl_id', $tlId));
            $itemsCount = $itemsHandler->getCount($crit_items);
            if ($itemsCount > 0) {
                if(!$itemsHandler->deleteAll($crit_items, true)) {
                    $GLOBALS['xoopsTpl']->assign('error', $itemsHandler->getHtmlErrors());
                    break;
                }
            }
            // if successful then delete timeline
            if($timelinesHandler->delete($timelinesObj)) {
                redirect_header('timelines.php', 3, _AM_WGTIMELINES_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $timelinesObj->getHtmlErrors());
            }
        } else {
            xoops_confirm(array('ok' => 1, 'tl_id' => $tlId, 'op' => 'delete'), $_SERVER['REQUEST_URI'], sprintf(_AM_WGTIMELINES_FORM_SURE_DELETE, $timelinesObj->getVar('tl_name')));
        }

    break;
    case 'set_onoff':
        if ($tlId > 0) {
            $timelinesObj = $timelinesHandler->get($tlId);
            // get Var team_online
            $tl_online = ($timelinesObj->getVar('tl_online') == 1) ? '0' : '1';
            // Set Var team_online
            $timelinesObj->setVar('tl_online', $tl_online);
            if ($timelinesHandler->insert($timelinesObj, true)) {
                redirect_header('timelines.php?op=list', 2, _AM_WGTIMELINES_FORM_OK);
            }
        } else {
            echo 'invalid params';
        }
        break;

    case 'order':
        $torder = $_POST['torder'];
        echo "torder:$echo";
        for ($i = 0, $iMax = count($torder); $i < $iMax; $i++){
            $timelinesObj = $timelinesHandler->get($torder[$i]);
            $timelinesObj->setVar('tl_weight',$i+1);
            $timelinesHandler->insert($timelinesObj);
        }
        break;
}
include __DIR__ . '/footer.php';
