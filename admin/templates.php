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
 * @version        $Id: 1.0 templates.php 13070 Sat 2016-10-01 05:42:15Z XOOPS Development Team $
 */

use Xmf\Request;

include __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getString('op', 'list');
// Request tpl_id
$tplId = Request::getInt('tpl_id');
switch ($op) {
    case 'list':
    default:
        $start = Request::getInt('start', 0);
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgtimelines_admin_templates.tpl';

        // check default template set
        $tplsetsdefaultHandler->checkTplsetsdefault();

        $templatesCount = $templatesHandler->getCountTemplates();
        $templatesAll = $templatesHandler->getAllTemplates($start, $limit);

        $GLOBALS['xoopsTpl']->assign('templates_count', $templatesCount);
        $GLOBALS['xoopsTpl']->assign('wgtimelines_url', WGTIMELINES_URL);
        $GLOBALS['xoopsTpl']->assign('wgtimelines_upload_url', WGTIMELINES_UPLOAD_URL);
        $GLOBALS['xoopsTpl']->assign('wgtimelines_icons_url', WGTIMELINES_ICONS_URL);
        // Table view templates
        if ($templatesCount > 0) {
            foreach (array_keys($templatesAll) as $i) {
                $template = $templatesAll[$i]->getValuesTemplatesAdmin();
                $obj_tplsetdefault = $tplsetsdefaultHandler->get($template['id']);
                $template['newversion'] = 0;
                $template['notsupported'] = 0;
                if (is_object($obj_tplsetdefault)) {
                    if ($template['tpl_version'] < $obj_tplsetdefault->getVar('tpl_version')) {
                        $template['newversion'] = 1;
                    }
                } else {
                    $template['notsupported'] = 1;
                }
                $template['newtemplate'] = 0;
                if ($template['tpl_date_create'] > (time()-2592000)) {
                    $template['newtemplate'] = 1;
                }
                $GLOBALS['xoopsTpl']->append('templates_list', $template);
                unset($template);
            }
            // Display Navigation
            if ($templatesCount > $limit) {
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
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('templates.php'));
        $adminObject->addItemButton(_AM_WGTIMELINES_TEMPLATES_LIST, 'templates.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton());
        // Get Form
        $templatesObj = $templatesHandler->create();
        $form = $templatesObj->getFormTemplates();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

    break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('templates.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($tplId)) {
            $templatesObj = $templatesHandler->get($tplId);
        } else {
            $templatesObj = $templatesHandler->create();
        }

        // Set Vars
        $templatesObj->setVar('tpl_name', $_POST['tpl_name']);
        $templatesObj->setVar('tpl_desc', $_POST['tpl_desc']);
        $templatesObj->setVar('tpl_file', $_POST['tpl_file']);

        $options = array();
        $options[] = array('name' => 'tabletype',
                            'valid' => isset($_POST['tabletype']) ? 1 : 0,
                            'value' => isset($_POST['tabletype']) ? $_POST['tabletype'] : '',
                            'type' => 'text');
        $options[] = array('name' => 'panel_pos',
                            'valid' => isset($_POST['panel_pos']) ? 1 : 0,
                            'value' => isset($_POST['panel_pos']) ? $_POST['panel_pos'] : '',
                            'type' => 'text');
        $options[] = array('name' => 'panel_pos_single',
                            'valid' => isset($_POST['panel_pos_single']) ? 1 : 0,
                            'value' => isset($_POST['panel_pos_single']) ? $_POST['panel_pos_single'] : 'left',
                            'type' => 'text');
        $options[] = array('name' => 'panel_imgpos',
                            'valid' => isset($_POST['panel_imgpos']) ? 1 : 0,
                            'value' => isset($_POST['panel_imgpos']) ? $_POST['panel_imgpos'] : '',
                            'type' => 'text');
        $options[] = array('name' => 'imgstyle',
                            'valid' => isset($_POST['imgstyle']) ? 1 : 0,
                            'value' => isset($_POST['imgstyle']) ? $_POST['imgstyle'] : '',
                            'type' => 'text');
        $options[] = array('name' => 'bgcolor',
                            'valid' => isset($_POST['bgcolor']) ? 1 : 0,
                            'value' => isset($_POST['bgcolor']) ? $_POST['bgcolor'] : '',
                            'type' => 'color');
        $options[] = array('name' => 'fontcolor',
                            'valid' => isset($_POST['fontcolor']) ? 1 : 0,
                            'value' => isset($_POST['fontcolor']) ? $_POST['fontcolor'] : '',
                            'type' => 'color');
        $options[] = array('name' => 'bgcolor2',
                            'valid' => isset($_POST['bgcolor2']) ? 1 : 0,
                            'value' => isset($_POST['bgcolor2']) ? $_POST['bgcolor2'] : '',
                            'type' => 'color');
        $options[] = array('name' => 'fontcolor2',
                            'valid' => isset($_POST['fontcolor2']) ? 1 : 0,
                            'value' => isset($_POST['fontcolor2']) ? $_POST['fontcolor2'] : '',
                            'type' => 'color');
        $options[] = array('name' => 'bgcolor3',
                            'valid' => isset($_POST['bgcolor3']) ? 1 : 0,
                            'value' => isset($_POST['bgcolor3']) ? $_POST['bgcolor3'] : '',
                            'type' => 'color');
        $options[] = array('name' => 'fontcolor3',
                            'valid' => isset($_POST['fontcolor3']) ? 1 : 0,
                            'value' => isset($_POST['fontcolor3']) ? $_POST['fontcolor3'] : '',
                            'type' => 'color');
        $options[] = array('name' => 'bgcolor4',
                            'valid' => isset($_POST['bgcolor4']) ? 1 : 0,
                            'value' => isset($_POST['bgcolor4']) ? $_POST['bgcolor4'] : '',
                            'type' => 'color');
        $options[] = array('name' => 'fontcolor4',
                            'valid' => isset($_POST['fontcolor4']) ? 1 : 0,
                            'value' => isset($_POST['fontcolor4']) ? $_POST['fontcolor4'] : '',
                            'type' => 'color');
        $options[] = array('name' => 'badgestyle',
                            'valid' => isset($_POST['badgestyle']) ? 1 : 0,
                            'value' => isset($_POST['badgestyle']) ? $_POST['badgestyle'] : '',
                            'type' => 'text');
        $options[] = array('name' => 'badgecontent',
                            'valid' => isset($_POST['badgecontent']) ? 1 : 0,
                            'value' => isset($_POST['badgecontent']) ? $_POST['badgecontent'] : 'none',
                            'type' => 'text');
        $options[] = array('name' => 'badgecolor',
                            'valid' => isset($_POST['badgecolor']) ? 1 : 0,
                            'value' => isset($_POST['badgecolor']) ? $_POST['badgecolor'] : '',
                            'type' => 'color');
        $options[] = array('name' => 'badgefontcolor',
                            'valid' => isset($_POST['badgefontcolor']) ? 1 : 0,
                            'value' => isset($_POST['badgefontcolor']) ? $_POST['badgefontcolor'] : '#eeeeee',
                            'type' => 'color');
        $options[] = array('name' => 'showyear',
                            'valid' => isset($_POST['showyear']) ? 1 : 0,
                            'value' => isset($_POST['showyear']) ? $_POST['showyear'] : 'none',
                            'type' => 'text');
        $options[] = array('name' => 'linecolor',
                            'valid' => isset($_POST['linecolor']) ? 1 : 0,
                            'value' => isset($_POST['linecolor']) ? $_POST['linecolor'] : '',
                            'type' => 'color');
        $options[] = array('name' => 'borderwidth',
                            'valid' => isset($_POST['borderwidth']) ? 1 : 0,
                            'value' => isset($_POST['borderwidth']) ? $_POST['borderwidth'] : '1px',
                            'type' => 'text');
        $options[] = array('name' => 'borderstyle',
                            'valid' => isset($_POST['borderstyle']) ? 1 : 0,
                            'value' => isset($_POST['borderstyle']) ? $_POST['borderstyle'] : 'solid',
                            'type' => 'text');
        $options[] = array('name' => 'bordercolor',
                            'valid' => isset($_POST['bordercolor']) ? 1 : 0,
                            'value' => isset($_POST['bordercolor']) ? $_POST['bordercolor'] : '#eeeeee',
                            'type' => 'color');
        $options[] = array('name' => 'borderradius',
                            'valid' => isset($_POST['borderradius']) ? 1 : 0,
                            'value' => isset($_POST['borderradius']) ? $_POST['borderradius'] : '5px',
                            'type' => 'text');
        $options[] = array('name' => 'boxshadow',
                            'valid' => isset($_POST['boxshadow_h']) ? 1 : 0,
                            'value' => (isset($_POST['boxshadow_h']) ? $_POST['boxshadow_h'] : '5px') . ' ' . (isset($_POST['boxshadow_v']) ? $_POST['boxshadow_v'] : '5px') . ' ' . (isset($_POST['boxshadow_blur']) ? $_POST['boxshadow_blur'] : '5px') . ' ' . (isset($_POST['boxshadow_spread']) ? $_POST['boxshadow_spread'] : '5px') . ' ' . (isset($_POST['boxshadow_color']) ? $_POST['boxshadow_color'] : '#eeeeee'),
                            'type' => 'text');
        $options[] = array('name' => 'orientation',
                            'valid' => isset($_POST['orientation']) ? 1 : 0,
                            'value' => isset($_POST['orientation']) ? $_POST['orientation'] : '',
                            'type' => 'text');
        $options[] = array('name' => 'datesspeed',
                            'valid' => isset($_POST['datesspeed']) ? 1 : 0,
                            'value' => isset($_POST['datesspeed']) ? $_POST['datesspeed'] : '',
                            'type' => 'text');
        $options[] = array('name' => 'issuesspeed',
                            'valid' => isset($_POST['issuesspeed']) ? 1 : 0,
                            'value' => isset($_POST['issuesspeed']) ? $_POST['issuesspeed'] : '',
                            'type' => 'text');
        $options[] = array('name' => 'issuestransparency',
                            'valid' => isset($_POST['issuestransparency']) ? 1 : 0,
                            'value' => isset($_POST['issuestransparency']) ? $_POST['issuestransparency'] : '',
                            'type' => 'text');
        $options[] = array('name' => 'issuestransparencyspeed',
                            'valid' => isset($_POST['issuestransparencyspeed']) ? 1 : 0,
                            'value' => isset($_POST['issuestransparencyspeed']) ? $_POST['issuestransparencyspeed'] : '',
                            'type' => 'text');
        $options[] = array('name' => 'autoplay',
                            'valid' => isset($_POST['autoplay']) ? 1 : 0,
                            'value' => (isset($_POST['autoplay']) && $_POST['autoplay'] == 1) ? 'true' : 'false',
                            'type' => 'bool');
        $options[] = array('name' => 'autoplaydirection',
                            'valid' => isset($_POST['autoplaydirection']) ? 1 : 0,
                            'value' => isset($_POST['autoplaydirection']) ? $_POST['autoplaydirection'] : '',
                            'type' => 'text');
        $options[] = array('name' => 'autoplaypause',
                            'valid' => isset($_POST['autoplaypause']) ? 1 : 0,
                            'value' => isset($_POST['autoplaypause']) ? $_POST['autoplaypause'] : '',
                            'type' => 'text');
        $options[] = array('name' => 'arrowkeys',
                            'valid' => isset($_POST['arrowkeys']) ? 1 : 0,
                            'value' => (isset($_POST['arrowkeys']) && $_POST['arrowkeys'] == 1) ? 'true' : 'false',
                            'type' => 'bool');
        $options[] = array('name' => 'startat',
                            'valid' => isset($_POST['startat']) ? 1 : 0,
                            'value' => (isset($_POST['startat']) && $_POST['startat'] > 0) ? $_POST['startat'] : '1',
                            'type' => 'text');
        $options[] = array('name' => 'fadein',
                            'valid' => isset($_POST['fadein']) ? 1 : 0,
                            'value' => isset($_POST['fadein']) ? $_POST['fadein'] : 'appear',
                            'type' => 'text');

        $templatesObj->setVar('tpl_options', serialize($options));

        // Insert Data
        if ($templatesHandler->insert($templatesObj)) {
            redirect_header('templates.php?op=list', 2, _AM_WGTIMELINES_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $templatesObj->getHtmlErrors());
        $form = $templatesObj->getFormTemplates();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

    break;
    case 'save-master':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('templates.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($tplId)) {
            $templatesObj = $templatesHandler->get($tplId);
        }
        $options = array();
        // Set Vars
        $templatesObj->setVar('tpl_name', $_POST['tpl_name']);
        $templatesObj->setVar('tpl_desc', $_POST['tpl_desc']);
        $templatesObj->setVar('tpl_file', $_POST['tpl_file']);

        for ($i = 1; $i <= $_POST['counter']; $i++) {
            if (!$_POST['name_'.$i] == '') {
                $options[] = array('name' => $_POST['name_' . $i], 'valid' => $_POST['valid_' . $i], 'value' => $_POST['value_' . $i], 'type' => $_POST['type_' . $i]);
                $templatesObj->setVar($_POST['name_' . $i], $_POST['value_' . $i]);
            }
        }
        $templatesObj->setVar('tpl_options', serialize($options));
        $templatesObj->setVar('tpl_version', $_POST['tpl_version']);
        $templatesObj->setVar('tpl_author', $_POST['tpl_author']);
        $tplDate_create = date_create_from_format(_SHORTDATESTRING, $_POST['tpl_date_create']);
        $templatesObj->setVar('tpl_date_create', $tplDate_create->getTimestamp());

        // Insert Data
        if ($templatesHandler->insert($templatesObj)) {
            if ($_POST['addopt'] > 0) {
                redirect_header('templates.php?op=edit-master&tpl_id=' . $tplId, 2, _AM_WGTIMELINES_FORM_OK);
            } else {
                redirect_header('templates.php?op=edit&tpl_id=' . $tplId, 2, _AM_WGTIMELINES_FORM_OK);
            }
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $templatesObj->getHtmlErrors());
        $form = $templatesObj->getFormTemplates();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

    break;
    case 'edit':
    case 'edit-master':
        $templateMain = 'wgtimelines_admin_templates.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('templates.php'));
        $adminObject->addItemButton(_AM_WGTIMELINES_TEMPLATES_LIST, 'templates.php', 'list');
        if ($op === 'edit-master') {
            $adminObject->addItemButton(_AM_WGTIMELINES_TEMPLATE_ADD, 'templates.php?op=new', 'add');
        }
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton());
        // Get Form
        $templatesObj = $templatesHandler->get($tplId);
        if ($op === 'edit-master') {
            $form = $templatesObj->getFormTemplatesMaster();
        } else {
            $form = $templatesObj->getFormTemplates();
        }
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

    break;
    case 'update':
    case 'reset':
        $templatesObj = $templatesHandler->get($tplId);
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('templates.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            $tplsetdefaultObj = $tplsetsdefaultHandler->get($tplId);
            // Set Vars
            $templatesObj->setVar('tpl_name', $tplsetdefaultObj->getVar('tpl_name'));
            $templatesObj->setVar('tpl_desc', $tplsetdefaultObj->getVar('tpl_desc', 'n'));
            $templatesObj->setVar('tpl_file', $tplsetdefaultObj->getVar('tpl_file'));
            $templatesObj->setVar('tpl_options', $tplsetdefaultObj->getVar('tpl_options', 'n'));
            $templatesObj->setVar('tpl_weight', $tplsetdefaultObj->getVar('tpl_weight'));
            $templatesObj->setVar('tpl_version', $tplsetdefaultObj->getVar('tpl_version'));
            $templatesObj->setVar('tpl_author', $tplsetdefaultObj->getVar('tpl_author'));
            $templatesObj->setVar('tpl_date_create', $tplsetdefaultObj->getVar('tpl_date_create'));
            // Insert Data
            if ($templatesHandler->insert($templatesObj)) {
                redirect_header('templates.php?op=list', 2, _AM_WGTIMELINES_FORM_OK);
            }
            $GLOBALS['xoopsTpl']->assign('error', $templatesObj->getHtmlErrors());
        } else {
            $info = ($op === 'update') ? _AM_WGTIMELINES_TEMPLATE_SURE_UPDATE : _AM_WGTIMELINES_TEMPLATE_SURE_RESET;
            xoops_confirm(array('ok' => 1, 'tpl_id' => $tplId, 'op' => $op), $_SERVER['REQUEST_URI'], $info);
        }

    break;
}
include __DIR__ . '/footer.php';
