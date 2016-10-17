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
 * @version        $Id: 1.0 templates.php 13070 Sat 2016-10-01 05:42:15Z XOOPS Development Team $
 */
include __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = XoopsRequest::getString('op', 'list');
// Request tpl_id
$tplId = XoopsRequest::getInt('tpl_id');
switch($op) {
	case 'list':
	default:
		// Define Stylesheet
		$GLOBALS['xoTheme']->addStylesheet( $style, null );
		$start = XoopsRequest::getInt('start', 0);
		$limit = XoopsRequest::getInt('limit', $wgtimelines->getConfig('adminpager'));
		$templateMain = 'wgtimelines_admin_templates.tpl';
		$templatesCount = $templatesHandler->getCountTemplates();
		$templatesAll = $templatesHandler->getAllTemplates($start, $limit);
		$GLOBALS['xoopsTpl']->assign('templates_count', $templatesCount);
		$GLOBALS['xoopsTpl']->assign('wgtimelines_url', WGTIMELINES_URL);
		$GLOBALS['xoopsTpl']->assign('wgtimelines_upload_url', WGTIMELINES_UPLOAD_URL);
		// Table view templates
		if($templatesCount > 0) {
			foreach(array_keys($templatesAll) as $i) {
				$template = $templatesAll[$i]->getValuesTemplates();
				$GLOBALS['xoopsTpl']->append('templates_list', $template);
				unset($template);
			}
			// Display Navigation
			if($templatesCount > $limit) {
				include_once XOOPS_ROOT_PATH .'/class/pagenav.php';
				$pagenav = new XoopsPageNav($templatesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
		} else {
			$GLOBALS['xoopsTpl']->assign('error', _AM_WGTIMELINES_THEREARENT_TEMPLATES);
		}

	break;
	case 'new':
		$templateMain = 'wgtimelines_admin_templates.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('templates.php'));
		$adminMenu->addItemButton(_AM_WGTIMELINES_TEMPLATES_LIST, 'templates.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
		// Get Form
		$templatesObj = $templatesHandler->create();
		$form = $templatesObj->getFormTemplates();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());

	break;
	case 'save':
		// Security Check
		if(!$GLOBALS['xoopsSecurity']->check()) {
			redirect_header('templates.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		if(isset($tplId)) {
			$templatesObj = $templatesHandler->get($tplId);
		} else {
			$templatesObj = $templatesHandler->create();
		}
		// Set Vars
		$templatesObj->setVar('tpl_name', $_POST['tpl_name']);
        $templatesObj->setVar('tpl_desc', $_POST['tpl_desc']);
		$templatesObj->setVar('tpl_file', $_POST['tpl_file']);
		$templatesObj->setVar('tpl_options', $_POST['tpl_options']);
		$templatesObj->setVar('tpl_imgposition', $_POST['tpl_imgposition']);
		$templatesObj->setVar('tpl_imgstyle', $_POST['tpl_imgstyle']);
		$templatesObj->setVar('tpl_tabletype', $_POST['tpl_tabletype']);
        $templatesObj->setVar('tpl_bgcolor', $_POST['tpl_bgcolor']);
        $templatesObj->setVar('tpl_fontcolor', $_POST['tpl_fontcolor']);
        $templatesObj->setVar('tpl_imgposition_p', $_POST['tpl_imgposition_p']);
		// Insert Data
		if($templatesHandler->insert($templatesObj)) {
			redirect_header('templates.php?op=list', 2, _AM_WGTIMELINES_FORM_OK);
		}
		// Get Form
		$GLOBALS['xoopsTpl']->assign('error', $templatesObj->getHtmlErrors());
		$form = $templatesObj->getFormTemplates();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());

	break;
	case 'edit':
    case 'edit-master':
		$templateMain = 'wgtimelines_admin_templates.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('templates.php'));
		$adminMenu->addItemButton(_AM_WGTIMELINES_TEMPLATES_LIST, 'templates.php', 'list');
        if ($op == 'edit-master') $adminMenu->addItemButton(_AM_WGTIMELINES_ADD_TEMPLATE, 'templates.php?op=new', 'add');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
		// Get Form
		$templatesObj = $templatesHandler->get($tplId);
        if ($op == 'edit-master') {
            $form = $templatesObj->getFormTemplates(false, true);
        } else {
            $form = $templatesObj->getFormTemplates();
        }
		$GLOBALS['xoopsTpl']->assign('form', $form->render());

	break;
    case 'edit-master':
		$templateMain = 'wgtimelines_admin_templates.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('templates.php'));
		$adminMenu->addItemButton(_AM_WGTIMELINES_ADD_TEMPLATE, 'templates.php?op=new', 'add');
		$adminMenu->addItemButton(_AM_WGTIMELINES_TEMPLATES_LIST, 'templates.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
		// Get Form
		$templatesObj = $templatesHandler->get($tplId);
		$form = $templatesObj->getFormTemplatesMaster();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());

	break;
	case 'delete':
		$templatesObj = $templatesHandler->get($tplId);
		if(isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if(!$GLOBALS['xoopsSecurity']->check()) {
				redirect_header('templates.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if($templatesHandler->delete($templatesObj)) {
				redirect_header('templates.php', 3, _AM_WGTIMELINES_FORM_DELETE_OK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $templatesObj->getHtmlErrors());
			}
		} else {
			xoops_confirm(array('ok' => 1, 'tpl_id' => $tplId, 'op' => 'delete'), $_SERVER['REQUEST_URI'], sprintf(_AM_WGTIMELINES_FORM_SURE_DELETE, $templatesObj->getVar('tpl_name')));
		}

	break;
}
include __DIR__ . '/footer.php';
