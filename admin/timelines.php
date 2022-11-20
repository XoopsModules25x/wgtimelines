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
 * @version        $Id: 1.0 timelines.php 13070 Sat 2016-10-01 05:42:13Z XOOPS Development Team $
 */

use XoopsModules\Wgtimelines;
use XoopsModules\Wgtimelines\Constants;
use Xmf\Request;

include __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getString('op', 'list');
// Request tl_id
$tlId = Request::getInt('tl_id');
switch($op) {
    case 'list':
    default:
        $GLOBALS['xoTheme']->addScript(\WGTIMELINES_URL . '/assets/js/sortable-timelines.js');
        $start = Request::getInt('start');
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgtimelines_admin_timelines.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('timelines.php'));
        $adminObject->addItemButton(\_AM_WGTIMELINES_TIMELINE_ADD, 'timelines.php?op=new');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton());
        $timelinesCount = $timelinesHandler->getCountTimelines();
        $timelinesAll = $timelinesHandler->getAllTimelines($start, $limit);
        $GLOBALS['xoopsTpl']->assign('timelines_count', $timelinesCount);
        $GLOBALS['xoopsTpl']->assign('wgtimelines_url', \WGTIMELINES_URL);
        $GLOBALS['xoopsTpl']->assign('wgtimelines_icons_url', \WGTIMELINES_ICONS_URL);
        $GLOBALS['xoopsTpl']->assign('wgtimelines_upload_url', \WGTIMELINES_UPLOAD_URL);

        $templatesAll = $templatesHandler->getAll();
        // Table view timelines
        if($timelinesCount > 0) {
            foreach(\array_keys($timelinesAll) as $i) {
                $timeline = $timelinesAll[$i]->getValuesTimelines();
                if ($timeline['tl_sortby'] == 1) {
                    $timeline['sortby_text'] = \_AM_WGTIMELINES_TIMELINE_SORTBY_Y_DESC;
                } else if ($timeline['tl_sortby'] == 2) {
                    $timeline['sortby_text'] = \_AM_WGTIMELINES_TIMELINE_SORTBY_Y_ASC;
                } else {
                    $timeline['sortby_text'] = \_AM_WGTIMELINES_TIMELINE_SORTBY_ADMIN;
                }
                if ($timeline['tl_datetime'] == 1) {
                    $timeline['datetime_text'] = \_AM_WGTIMELINES_TIMELINE_DATETIME_ONLY_D;
                } else if ($timeline['tl_datetime'] == 2) {
                    $timeline['datetime_text'] = \_AM_WGTIMELINES_TIMELINE_DATETIME_ONLY_T;
                } else if ($timeline['tl_datetime'] == 3) {
                    $timeline['datetime_text'] = \_AM_WGTIMELINES_TIMELINE_DATETIME_BOTH;
                } else {
                    $timeline['datetime_text'] = \_AM_WGTIMELINES_TIMELINE_DATETIME_NO;
                }
                $timeline['template'] = $templatesAll[$timeline['tl_template']]->getVar('tpl_name');
                $GLOBALS['xoopsTpl']->append('timelines_list', $timeline);
                unset($timeline);
            }
            // Display Navigation
            if($timelinesCount > $limit) {
                include_once \XOOPS_ROOT_PATH .'/class/pagenav.php';
                $pagenav = new \XoopsPageNav($timelinesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_AM_WGTIMELINES_THEREARENT_TIMELINES);
        }

    break;
    case 'new':
        $templateMain = 'wgtimelines_admin_timelines.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('timelines.php'));
        $adminObject->addItemButton(\_AM_WGTIMELINES_TIMELINES_LIST, 'timelines.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton());
        // Get Form
        $timelinesObj = $timelinesHandler->create();
        $form = $timelinesObj->getFormTimelines();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        $GLOBALS['xoopsTpl']->assign('timelines_list', false);

    break;
    case 'save':
        if(isset($tlId)) {
            $timelinesObj = $timelinesHandler->get($tlId);
        } else {
            $timelinesObj = $timelinesHandler->create();
        }
        // Set Vars
        $timelinesObj->setVar('tl_name', Request::getString('tl_name'));
        //fix for avoid hiding empty paragraphs in some browsers (instead of: $timelinesObj->setVar('tl_desc', $_POST['tl_desc']);
        $timelinesObj->setVar('tl_desc', \preg_replace('/<p><\/p>/', '<p>&nbsp;</p>', Request::getString('tl_desc')));
        // Set Var tl_image
        include_once \XOOPS_ROOT_PATH .'/class/uploader.php';
        $fileName       = $_FILES['attachedfile']['name'];
        $imageMimetype  = $_FILES['attachedfile']['type'];
        $uploaderErrors = '';
        $uploader = new \XoopsMediaUploader(\WGTIMELINES_UPLOAD_IMAGE_PATH.'/timelines/',
                                            $helper->getConfig('mimetypes'),
                                            $helper->getConfig('maxsize'), null, null);
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            $extension = \preg_replace('/^.+\.([^.]+)$/sU', '', $fileName);
            $imgName   = mb_substr(\str_replace(' ', '', $_POST['tl_name']), 0, 20) . '_' . $extension;
            $uploader->setPrefix($imgName);
            $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
            if (!$uploader->upload()) {
                $uploaderErrors = $uploader->getErrors();
            } else {
                $savedFilename = $uploader->getSavedFileName();
                $timelinesObj->setVar('tl_image', $savedFilename);
                // resize image
                $maxwidth  = (int)$helper->getConfig('maxwidth_imgeditor');
                $maxheight = (int)$helper->getConfig('maxheight_imgeditor');
                $imgHandler                = new Wgtimelines\Resizer();
                $imgHandler->sourceFile    = \WGTIMELINES_UPLOAD_PATH . '/images/timelines/' . $savedFilename;
                $imgHandler->endFile       = \WGTIMELINES_UPLOAD_PATH . '/images/timelines/' . $savedFilename;
                $imgHandler->imageMimetype = $imageMimetype;
                $imgHandler->maxWidth      = $maxwidth;
                $imgHandler->maxHeight     = $maxheight;
                $result                    = $imgHandler->resizeImage();
                $timelinesObj->setVar('tl_image', $savedFilename);
            }
        } else {
            if ($fileName > '') {
                $uploaderErrors = $uploader->getErrors();
            }
            $timelinesObj->setVar('tl_image', Request::getString('tl_image'));
        }

        $timelinesObj->setVar('tl_weight',    Request::getInt('tl_weight'));
        $timelinesObj->setVar('tl_template',  Request::getInt('tl_template'));
        $timelinesObj->setVar('tl_sortby',    Request::getInt('tl_sortby'));
        $timelinesObj->setVar('tl_limit',     Request::getInt('tl_limit'));
        $timelinesObj->setVar('tl_datetime',  Request::getInt('tl_datetime'));
        $timelinesObj->setVar('tl_magnific',  Request::getInt('tl_magnific'));
        $timelinesObj->setVar('tl_expired',   Request::getInt('tl_expired', Constants::TIMELINE_EXPIRED_SHOW));
        $timelinesObj->setVar('tl_showreads', Request::getInt('tl_showreads'));
        $timelinesObj->setVar('tl_online',    Request::getInt('tl_online'));
        $timelinesObj->setVar('tl_submitter', Request::getInt('tl_submitter'));
        $timelineDate_create = date_create_from_format(_SHORTDATESTRING, $_POST['tl_date_create']);
        $timelinesObj->setVar('tl_date_create', $timelineDate_create->getTimestamp());
        // Insert Data
        if($timelinesHandler->insert($timelinesObj)) {
            $newCatId = $timelinesObj->getNewInsertedIdTimelines();
            $permId = isset($_REQUEST['tl_id']) ? $tlId : $newTlId;
            $gpermHandler = \xoops_getHandler('groupperm');
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
            \redirect_header('timelines.php?op=list', 2, \_AM_WGTIMELINES_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $timelinesObj->getHtmlErrors());
        $form = $timelinesObj->getFormTimelines();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

    break;
    case 'edit':
        $templateMain = 'wgtimelines_admin_timelines.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('timelines.php'));
        $adminObject->addItemButton(\_AM_WGTIMELINES_TIMELINE_ADD, 'timelines.php?op=new');
        $adminObject->addItemButton(\_AM_WGTIMELINES_TIMELINES_LIST, 'timelines.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton());
        // Get Form
        $timelinesObj = $timelinesHandler->get($tlId);
        $form = $timelinesObj->getFormTimelines();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        $GLOBALS['xoopsTpl']->assign('timelines_list', false);

    break;
    case 'delete':
        $timelinesObj = $timelinesHandler->get($tlId);
        if(isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if(!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('timelines.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            // delete all items first
            $crit_items = new \CriteriaCompo();
            $crit_items->add(new \Criteria('item_tl_id', $tlId));
            $itemsCount = $itemsHandler->getCount($crit_items);
            if ($itemsCount > 0) {
                if(!$itemsHandler->deleteAll($crit_items)) {
                    $GLOBALS['xoopsTpl']->assign('error', $itemsHandler->getHtmlErrors());
                    break;
                }
            }
            // if successful then delete timeline
            if($timelinesHandler->delete($timelinesObj)) {
                \redirect_header('timelines.php', 3, \_AM_WGTIMELINES_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $timelinesObj->getHtmlErrors());
            }
        } else {
            xoops_confirm(['ok' => 1, 'tl_id' => $tlId, 'op' => 'delete'], $_SERVER['REQUEST_URI'], \sprintf(\_AM_WGTIMELINES_FORM_SURE_DELETE, $timelinesObj->getVar('tl_name')));
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
                \redirect_header('timelines.php?op=list', 2, \_AM_WGTIMELINES_FORM_OK);
            }
        } else {
            echo 'invalid params';
        }
        break;

    case 'order':
        $torder = Request::getArray('torder');
        echo "torder:$echo";
        for ($i = 0, $iMax = \count($torder); $i < $iMax; $i++){
            $timelinesObj = $timelinesHandler->get($torder[$i]);
            $timelinesObj->setVar('tl_weight',$i+1);
            $timelinesHandler->insert($timelinesObj);
        }
        break;
}
include __DIR__ . '/footer.php';
