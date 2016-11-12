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
 * @version        $Id: 1.0 items.php 13070 Sat 2016-10-01 05:42:14Z XOOPS Development Team $
 */
include __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = XoopsRequest::getString('op', 'list');
// Request item_id
$itemId = XoopsRequest::getInt('item_id');
switch($op) {
	case 'list':
	default:
		$GLOBALS['xoTheme']->addScript(WGTIMELINES_URL . '/assets/js/sortable-items.js');
		$start = XoopsRequest::getInt('start', 0);
		$limit = XoopsRequest::getInt('limit', $wgtimelines->getConfig('adminpager'));
		$templateMain = 'wgtimelines_admin_items.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('items.php'));
		$adminMenu->addItemButton(_AM_WGTIMELINES_ADD_ITEM, 'items.php?op=new', 'add');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
		$itemsCount = $itemsHandler->getCountItems();
		$itemsAll = $itemsHandler->getAllItems($start, $limit);
		$GLOBALS['xoopsTpl']->assign('items_count', $itemsCount);
		$GLOBALS['xoopsTpl']->assign('wgtimelines_url', WGTIMELINES_URL);
        $GLOBALS['xoopsTpl']->assign('wgtimelines_icons_url', WGTIMELINES_ICONS_URL);
		$GLOBALS['xoopsTpl']->assign('wgtimelines_upload_url', WGTIMELINES_UPLOAD_URL);
		// Table view items
		if($itemsCount > 0) {
            $nb_items_tl = 0;
            $timeline_id_prev = 0;
			foreach(array_keys($itemsAll) as $i) {
				$item = $itemsAll[$i]->getValuesItems(); 
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
				include_once XOOPS_ROOT_PATH .'/class/pagenav.php';
				$pagenav = new XoopsPageNav($itemsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
		} else {
			$GLOBALS['xoopsTpl']->assign('error', _AM_WGTIMELINES_THEREARENT_ITEMS);
		}

	break;
	case 'new':
		$templateMain = 'wgtimelines_admin_items.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('items.php'));
		$adminMenu->addItemButton(_AM_WGTIMELINES_ITEMS_LIST, 'items.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
		// Get Form
		$itemsObj = $itemsHandler->create();
		$form = $itemsObj->getFormItems();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());

	break;
	case 'save':
		// Security Check
		if(!$GLOBALS['xoopsSecurity']->check()) {
			redirect_header('items.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		if(isset($itemId)) {
			$itemsObj = $itemsHandler->get($itemId);
		} else {
			$itemsObj = $itemsHandler->create();
		}
		// Set Vars
		$itemsObj->setVar('item_tl_id', isset($_POST['item_tl_id']) ? $_POST['item_tl_id'] : 0);
		$itemsObj->setVar('item_title', $_POST['item_title']);
		$itemsObj->setVar('item_content', $_POST['item_content']);
		// Set Var item_image
		include_once XOOPS_ROOT_PATH .'/class/uploader.php';
		$uploader = new XoopsMediaUploader(WGTIMELINES_UPLOAD_IMAGE_PATH.'/items/', 
													$wgtimelines->getConfig('mimetypes'), 
													$wgtimelines->getConfig('maxsize'), null, null);
		if($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
			$extension = preg_replace('/^.+\.([^.]+)$/sU', '', $_FILES['attachedfile']['name']);
			$imgName = str_replace(' ', '', $_POST['item_name']).'.'.$extension;
			$uploader->setPrefix($imgName);
			$uploader->fetchMedia($_POST['xoops_upload_file'][0]);
			if(!$uploader->upload()) {
				$errors = $uploader->getErrors();
				redirect_header('javascript:history.go(-1).php', 3, $errors);
			} else {
				$itemsObj->setVar('item_image', $uploader->getSavedFileName());
			}
		} else {
			$itemsObj->setVar('item_image', $_POST['item_image']);
		}
		$itemDate = date_create_from_format(_SHORTDATESTRING, $_POST['item_date']);
        if ($itemDate) {
            $itemsObj->setVar('item_date', $itemDate->getTimestamp());
        } else {
            $itemsObj->setVar('item_date', 0);
        }
		$itemsObj->setVar('item_year', isset($_POST['item_year']) ? $_POST['item_year'] : 0);
		$itemsObj->setVar('item_weight', isset($_POST['item_weight']) ? $_POST['item_weight'] : 0);
		$itemsObj->setVar('item_submitter', isset($_POST['item_submitter']) ? $_POST['item_submitter'] : 0);
        $itemDate_create = date_create_from_format(_SHORTDATESTRING, $_POST['item_date_create']);
        $itemsObj->setVar('item_date_create', $itemDate_create->getTimestamp());
		// Insert Data
		if($itemsHandler->insert($itemsObj)) {
			redirect_header('items.php?op=list', 2, _AM_WGTIMELINES_FORM_OK);
		}
		// Get Form
		$GLOBALS['xoopsTpl']->assign('error', $itemsObj->getHtmlErrors());
		$form = $itemsObj->getFormItems();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());

	break;
	case 'edit':
		$templateMain = 'wgtimelines_admin_items.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('items.php'));
		$adminMenu->addItemButton(_AM_WGTIMELINES_ADD_ITEM, 'items.php?op=new', 'add');
		$adminMenu->addItemButton(_AM_WGTIMELINES_ITEMS_LIST, 'items.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
		// Get Form
		$itemsObj = $itemsHandler->get($itemId);
		$form = $itemsObj->getFormItems();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());

	break;
	case 'delete':
		$itemsObj = $itemsHandler->get($itemId);
		if(isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if(!$GLOBALS['xoopsSecurity']->check()) {
				redirect_header('items.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if($itemsHandler->delete($itemsObj)) {
				redirect_header('items.php', 3, _AM_WGTIMELINES_FORM_DELETE_OK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $itemsObj->getHtmlErrors());
			}
		} else {
			xoops_confirm(array('ok' => 1, 'item_id' => $itemId, 'op' => 'delete'), $_SERVER['REQUEST_URI'], sprintf(_AM_WGTIMELINES_FORM_SURE_DELETE, $itemsObj->getVar('item_content')));
		}

	break;
            
    case 'order':
        $iorder = $_POST['iorder'];
        for ($i = 0, $iMax = count($iorder); $i < $iMax; $i++){
            $itemsObj = $itemsHandler->get($iorder[$i]);
            $itemsObj->setVar('item_weight',$i+1);
            $itemsHandler->insert($itemsObj);
        }
        break;
}
include __DIR__ . '/footer.php';
