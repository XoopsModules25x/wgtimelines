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
 * @version        $Id: 1.0 items.php 13070 Sat 2016-10-01 05:42:14Z XOOPS Development Team $
 */

use Xmf\Request;
use XoopsModules\Wgtimelines;

include __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op     = Request::getString('op', 'list');
$ui     = Request::getString('ui', 'admin');
$itemId = Request::getInt('item_id');
$tl_id  = Request::getInt('tl_id');
    
$GLOBALS['xoTheme']->addStylesheet(\WGTIMELINES_URL . '/assets/css/admin/glyphicons.css');

switch($op) {
    case 'list':
    default:
        $templateMain = 'wgtimelines_admin_items.tpl';
        // create form for selection of available timelines
        $timelinesCount = $timelinesHandler->getCountTimelines();
        include_once(\XOOPS_ROOT_PATH."/class/xoopsformloader.php");    

        $action = "";
        $action = $_SERVER["REQUEST_URI"];

        $form_select = new \XoopsThemeForm(\_AM_WGTIMELINES_TIMELINES_LIST, "form_filter", $action, "post", true);
        $form_select->setExtra('enctype="multipart/form-data"');
        $timeline_select = new \XoopsFormSelect(\_AM_WGTIMELINES_TIMELINE_SELECT, "tl_id", $tl_id);
        $timeline_select->addOption(0, \_AM_WGTIMELINES_ITEM_NONE);
        $crit_tl = new \CriteriaCompo();
        $crit_tl->setSort('tl_weight ASC, tl_id');
        $crit_tl->setOrder('ASC');
        $timeline_select->addOptionArray($timelinesHandler->getList($crit_tl));
        $timeline_select->setextra('onchange="document.forms.form_filter.submit()"');
        $form_select->addElement($timeline_select);
        $GLOBALS['xoopsTpl']->assign('form_select', $form_select->render());
        
        // show details of selected timeline
        $GLOBALS['xoTheme']->addScript(\WGTIMELINES_URL . '/assets/js/sortable-items.js');
        $start = Request::getInt('start');
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('items.php'));
        $adminObject->addItemButton(\_AM_WGTIMELINES_ITEM_ADD, 'items.php?op=new&amp;tl_id=' . $tl_id);
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton());
        $timeline_obj = $timelinesHandler->get($tl_id);
        $critItems = new \CriteriaCompo();
        $critItems->add(new \Criteria('item_tl_id', $tl_id));
        $itemsCount = $itemsHandler->getCount($critItems);
        $critItems->setStart($start);
        $critItems->setLimit($limit);
        $critItems->setSort('item_weight ASC, item_id');
        $critItems->setOrder('ASC');
        $itemsAll = $itemsHandler->getAll($critItems);
        $GLOBALS['xoopsTpl']->assign('items_count', $itemsCount);
        $GLOBALS['xoopsTpl']->assign('wgtimelines_url', \WGTIMELINES_URL);
        $GLOBALS['xoopsTpl']->assign('wgtimelines_icons_url', \WGTIMELINES_ICONS_URL);
        $GLOBALS['xoopsTpl']->assign('wgtimelines_upload_url', \WGTIMELINES_UPLOAD_URL);
        
        // Table view items
        if($itemsCount > 0) {
            $nb_items_tl = 0;
            $timeline_id_prev = 0;
            foreach(\array_keys($itemsAll) as $i) {
                $item = $itemsAll[$i]->getValuesItems($timeline_obj);
                // vars for sortable
                if ($timeline_id_prev == $item['item_tl_id']) {
                    $item['new_timeline'] = 0;
                    $item['nb_items_tl'] = $nb_items_tl;
                } else {
                    $item['new_timeline'] = 1;
                    $nb_items_tl = $itemsHandler->getCountItemsTl($item['item_tl_id']);
                    $item['nb_items_tl'] = $nb_items_tl;
                    $timeline_id_prev = $item['item_tl_id'];
                }
                $GLOBALS['xoopsTpl']->append('items_list', $item);
                unset($item);
            }
            // Display Navigation
            if($itemsCount > $limit) {
                include_once \XOOPS_ROOT_PATH .'/class/pagenav.php';
                $pagenav = new \XoopsPageNav($itemsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        } else {
            if ($tl_id > 0) {
                $currentTl = ($tl_id == 0) ? \_AM_WGTIMELINES_ITEM_NONE : $timelinesHandler->get($tl_id)->getVar('tl_name');
                $GLOBALS['xoopsTpl']->assign('error', \_AM_WGTIMELINES_THEREARENT_ITEMS . $currentTl);
            }
        }
        
    break;
    case 'new':
        $templateMain = 'wgtimelines_admin_items.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('items.php'));
        $adminObject->addItemButton(\_AM_WGTIMELINES_ITEMS_LIST, 'items.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton());
        // Get Form
        $itemsObj = $itemsHandler->create();
        if ($tl_id > 0) {
            $itemsObj->setVar('item_tl_id', $tl_id);
        }
        $form = $itemsObj->getFormItems();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
    break;
    case 'editcopy':
        $templateMain = 'wgtimelines_admin_items.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('items.php'));
        $adminObject->addItemButton(\_AM_WGTIMELINES_ITEMS_LIST, 'items.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton());
        // Get Form
        $itemsObj = $itemsHandler->create();
        $itemsObjOld = $itemsHandler->get($itemId);
        $itemsObj->unsetNew();
        $itemsObj->setVar('item_tl_id',   $itemsObjOld->getVar('item_tl_id'));
        $itemsObj->setVar('item_title',   $itemsObjOld->getVar('item_title'));
        $itemsObj->setVar('item_content', $itemsObjOld->getVar('item_content'));
        $itemsObj->setVar('item_image',   $itemsObjOld->getVar('item_image'));
        $itemsObj->setVar('item_date',    $itemsObjOld->getVar('item_date'));
        $itemsObj->setVar('item_year',    $itemsObjOld->getVar('item_year'));
        $itemsObj->setVar('item_icon',    $itemsObjOld->getVar('item_icon'));
        $itemsObj->setVar('item_weight',  $itemsObjOld->getVar('item_weight'));
        $itemsObj->setVar('item_reads',   0);
        $itemsObj->setVar('item_online',  0);
        unset($itemsObjOld);
        $form = $itemsObj->getFormItems('items.php?op=save_copy');
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
    break;
    case 'save':
    case 'save_copy':
        // Security Check
        if(isset($itemId)) {
            $itemsObj = $itemsHandler->get($itemId);
        } else {
            $itemsObj = $itemsHandler->create();
        }
        // Set Vars
        $item_tl_id = Request::getInt('item_tl_id');
        $itemsObj->setVar('item_tl_id', $item_tl_id);
        $itemsObj->setVar('item_title', Request::getString('item_title'));
        //fix for avoid hiding empty paragraphs in some browsers (instead of: $itemsObj->setVar('item_content', $_POST['item_content']);
        $itemsObj->setVar('item_content', \preg_replace('/<p><\/p>/', '<p>&nbsp;</p>', Request::getString('item_content')));
       
        // Set Var item_image
        include_once \XOOPS_ROOT_PATH .'/class/uploader.php';
        $fileName       = $_FILES['attachedfile']['name'];
        $imageMimetype  = $_FILES['attachedfile']['type'];
        $uploaderErrors = '';
        $uploader = new \XoopsMediaUploader(\WGTIMELINES_UPLOAD_IMAGE_PATH.'/items/',
                                            $helper->getConfig('mimetypes'),
                                            $helper->getConfig('maxsize'), null, null);
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            $extension = \preg_replace('/^.+\.([^.]+)$/sU', '', $fileName);
            $imgName   = mb_substr(\str_replace(' ', '', $_POST['item_title']), 0, 20) . '_' . $extension;
            $uploader->setPrefix($imgName);
            $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
            if (!$uploader->upload()) {
                $uploaderErrors = $uploader->getErrors();
            } else {
                $savedFilename = $uploader->getSavedFileName();
                $itemsObj->setVar('item_image', $savedFilename);
                // resize image
                $maxwidth  = (int)$helper->getConfig('maxwidth_imgeditor');
                $maxheight = (int)$helper->getConfig('maxheight_imgeditor');
                $imgHandler                = new Wgtimelines\Resizer();
                $imgHandler->sourceFile    = \WGTIMELINES_UPLOAD_PATH . '/images/items/' . $savedFilename;
                $imgHandler->endFile       = \WGTIMELINES_UPLOAD_PATH . '/images/items/' . $savedFilename;
                $imgHandler->imageMimetype = $imageMimetype;
                $imgHandler->maxWidth      = $maxwidth;
                $imgHandler->maxHeight     = $maxheight;
                $result                    = $imgHandler->resizeImage();
                $itemsObj->setVar('item_image', $savedFilename);
            }
        } else {
            if ($fileName > '') {
                $uploaderErrors = $uploader->getErrors();
            }
            $itemsObj->setVar('item_image', Request::getString('item_image'));
        }

        $itemsObj->setVar('item_date',      \strtotime($_POST['item_date']['date']) + \intval($_POST['item_date']['time']));
        $itemsObj->setVar('item_year',      Request::getString('item_year'));
        $itemsObj->setVar('item_icon',      Request::getString('item_icon', 'none'));
        $itemsObj->setVar('item_weight',    Request::getInt('item_weight'));
        $itemsObj->setVar('item_reads',     Request::getInt('item_reads'));
        $itemsObj->setVar('item_online',    Request::getInt('item_online'));
        $itemsObj->setVar('item_submitter', Request::getInt('item_submitter'));
        $itemDate_create = date_create_from_format(_SHORTDATESTRING, $_POST['item_date_create']);
        $itemsObj->setVar('item_date_create', $itemDate_create->getTimestamp());
        // Insert Data
        if($itemsHandler->insert($itemsObj)) {
            if ($ui === 'user') {
                \redirect_header('../index.php?op=list&tl_id=' . $item_tl_id . '#item' . $itemId, 2, \_AM_WGTIMELINES_FORM_OK);
            } else {
                \redirect_header('items.php?op=list&tl_id=' . $item_tl_id . '#iorder_' .  $itemId, 2, \_AM_WGTIMELINES_FORM_OK);
            }
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $itemsObj->getHtmlErrors());
        $form = $itemsObj->getFormItems();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

    break;
    case 'edit':
        $templateMain = 'wgtimelines_admin_items.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('items.php'));
        $adminObject->addItemButton(\_AM_WGTIMELINES_ITEM_ADD, 'items.php?op=new');
        $adminObject->addItemButton(\_AM_WGTIMELINES_ITEMS_LIST, 'items.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton());
        // Get Form
        $itemsObj = $itemsHandler->get($itemId);
        $form = $itemsObj->getFormItems(false, $ui);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

    break;
    case 'delete':
        $itemsObj = $itemsHandler->get($itemId);
        if(isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if(!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('items.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            $item_tl_id = $itemsObj->getVar('item_tl_id');
            if($itemsHandler->delete($itemsObj)) {
                if ($ui === 'user') {
                    \redirect_header('../index.php?op=list&tl_id=' . $item_tl_id, 3, \_AM_WGTIMELINES_FORM_DELETE_OK);
                } else {
                    \redirect_header('items.php?op=list&tl_id=' . $item_tl_id . '#timeline' . $item_tl_id, 2, \_AM_WGTIMELINES_FORM_DELETE_OK);
                }
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $itemsObj->getHtmlErrors());
            }
        } else {
            xoops_confirm(['ok' => 1, 'item_id' => $itemId, 'item_tl_id' => $itemsObj->getVar('item_tl_id'), 'op' => 'delete', 'ui' => $ui], $_SERVER['REQUEST_URI'], \sprintf(\_AM_WGTIMELINES_FORM_SURE_DELETE, $itemsObj->getVar('item_title')));
        }

    break;
    case 'set_onoff':
        if ($itemId > 0) {
            $itemsObj = $itemsHandler->get($itemId);
            // get Var team_online
            $item_online = ($itemsObj->getVar('item_online') == 1) ? '0' : '1';
            // Set Var team_online
            $itemsObj->setVar('item_online', $item_online);
            if ($itemsHandler->insert($itemsObj, true)) {
                \redirect_header('items.php?op=list&tl_id='.$itemsObj->getVar('item_tl_id'), 2, \_AM_WGTIMELINES_FORM_OK);
            }
        } else {
            echo 'invalid params';
        }
        break;

    case 'order':
        $iorder = Request::getInt('iorder');
        for ($i = 0, $iMax = \count($iorder); $i < $iMax; $i++){
            $itemsObj = $itemsHandler->get($iorder[$i]);
            $itemsObj->setVar('item_weight',$i+1);
            $itemsHandler->insert($itemsObj);
        }
        break;
}
include __DIR__ . '/footer.php';
