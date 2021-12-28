<?php

declare(strict_types=1);

namespace XoopsModules\Wgtimelines;

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

defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Timelines
 */
class Timelines extends \XoopsObject
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('tl_id', XOBJ_DTYPE_INT);
        $this->initVar('tl_name', XOBJ_DTYPE_TXTBOX);
        $this->initVar('tl_desc', XOBJ_DTYPE_TXTAREA);
        $this->initVar('tl_image', XOBJ_DTYPE_TXTBOX);
        $this->initVar('tl_weight', XOBJ_DTYPE_INT);
        $this->initVar('tl_template', XOBJ_DTYPE_INT);
        $this->initVar('tl_sortby', XOBJ_DTYPE_INT);
        $this->initVar('tl_limit', XOBJ_DTYPE_INT);
        $this->initVar('tl_datetime', XOBJ_DTYPE_INT);
        $this->initVar('tl_magnific', XOBJ_DTYPE_INT);
		$this->initVar('tl_expired', XOBJ_DTYPE_INT);
        $this->initVar('tl_online', XOBJ_DTYPE_INT);
        $this->initVar('tl_submitter', XOBJ_DTYPE_INT);
        $this->initVar('tl_date_create', XOBJ_DTYPE_INT);
        $this->initVar('dohtml', XOBJ_DTYPE_INT, 1, false);
    }

    /**
     * @static function &getInstance
     *
     * @param null
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
    }

    /**
     * The new inserted $Id
     */
    public function getNewInsertedIdTimelines()
    {
        $newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
        return $newInsertedId;
    }

    /**
     * Get form
     *
     * @param mixed $action
     * @return \XoopsThemeForm
     */
    public function getFormTimelines($action = false)
    {
        $helper = \XoopsModules\Wgtimelines\Helper::getInstance();
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Title
        $title = $this->isNew() ? sprintf(_AM_WGTIMELINES_TIMELINE_ADD) : sprintf(_AM_WGTIMELINES_TIMELINE_EDIT);
        // Get Theme Form
        xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Text TlName
        $form->addElement(new \XoopsFormText(_AM_WGTIMELINES_TIMELINE_NAME, 'tl_name', 50, 255, $this->getVar('tl_name')), true);
        // Form editor tl_desc
        $editorConfigs = array();
        $editorConfigs['name'] = 'tl_desc';
        $editorConfigs['value'] = $this->getVar('tl_desc', 'e');
        $editorConfigs['rows'] = 5;
        $editorConfigs['cols'] = 40;
        $editorConfigs['width'] = '100%';
        $editorConfigs['height'] = '200px';
        $editorConfigs['editor'] = $helper->getConfig('wgtimelines_editor');
        $form->addElement(new \XoopsFormEditor(_AM_WGTIMELINES_TIMELINE_DESC, 'tl_desc', $editorConfigs), false);
        // Form Image
        $imageDirectory = '/uploads/wgtimelines/images/timelines';
        if ($this->isNew()) {
            $tlImage = 'blank.gif';
            $imageTray = new \XoopsFormElementTray(_AM_WGTIMELINES_TIMELINE_IMAGE, '<br>');
            $imageSelect = new \XoopsFormSelect(sprintf(_AM_WGTIMELINES_FORM_IMAGE_PATH, ".{$imageDirectory}/"), 'tl_image', $tlImage, 5);
            $imageArray = \XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . $imageDirectory);
            foreach ($imageArray as $image1) {
                $imageSelect->addOption("{$image1}", $image1);
            }
            $imageSelect->setExtra("onchange='showImgSelected(\"image1\", \"tl_image\", \"".$imageDirectory . '", "", "' . XOOPS_URL . "\")'");
            $imageTray->addElement($imageSelect, false);
            $imageTray->addElement(new \XoopsFormLabel('', "<br><img src='".XOOPS_URL . "$imageDirectory/$tlImage' name='image1' id='image1' alt='$tlImage' style='max-width:100px;' />"));
            // Form File
            $fileSelectTray = new \XoopsFormElementTray('', '<br>');
            $fileSelectTray->addElement(new \XoopsFormFile(_AM_WGTIMELINES_FORM_UPLOAD_IMAGE, 'attachedfile', $helper->getConfig('maxsize')));
            $fileSelectTray->addElement(new \XoopsFormLabel(''));
            $imageTray->addElement($fileSelectTray);
            $form->addElement($imageTray);
        } else {
            $timelineID = $this->getVar('tl_id');
            $imgButton = "<input type='button' value='...' onclick='window.location.href=\"" . XOOPS_URL . "/modules/wgtimelines/admin/image_editor.php?op=edit_timeline&tl_id=$timelineID\"'>";
            $tlImage = $this->getVar('tl_image');
            $form->addElement(new \XoopsFormLabel(_AM_WGTIMELINES_TIMELINE_IMAGE,"<img src='".XOOPS_URL . "$imageDirectory/$tlImage' name='image1' id='image1' alt='$tlImage' style='max-width:100px;' />$imgButton"));
        } 
        // Form Table Templates
        $templatesHandler = $helper->getHandler('Templates');
        $cat_templateSelect = new \XoopsFormSelect(_AM_WGTIMELINES_TIMELINE_TEMPLATE, 'tl_template', $this->getVar('tl_template'));
        $cat_templateSelect->addOptionArray($templatesHandler->getList());
        $form->addElement($cat_templateSelect, true);
        // Form Text tlSortBy
        $tlSortBy = $this->isNew() ? 0 : $this->getVar('tl_sortby');
        $tlSortBySelect = new \XoopsFormSelect(_AM_WGTIMELINES_TIMELINE_SORTBY, 'tl_sortby', $tlSortBy);
        $tlSortBySelect->addOption(0, _AM_WGTIMELINES_TIMELINE_SORTBY_ADMIN);
        $tlSortBySelect->addOption(1, _AM_WGTIMELINES_TIMELINE_SORTBY_Y_DESC);
        $tlSortBySelect->addOption(2, _AM_WGTIMELINES_TIMELINE_SORTBY_Y_ASC);
        $form->addElement($tlSortBySelect, true);
        // Form Text TlLimit
        $tlLimit = $this->isNew() ? 0 : $this->getVar('tl_limit');
        $form->addElement(new \XoopsFormText(_AM_WGTIMELINES_TIMELINE_LIMIT . '<br>' . _AM_WGTIMELINES_TIMELINE_LIMIT_DESC, 'tl_limit', 20, 255, $tlLimit), true);
        // Form Text tlDateTime
        $tlDateTime = $this->isNew() ? 1 : $this->getVar('tl_datetime');
        $tlDateTimeSelect = new \XoopsFormSelect(_AM_WGTIMELINES_TIMELINE_DATETIME . _AM_WGTIMELINES_TIMELINE_DATETIME_DESC, 'tl_datetime', $tlDateTime);
        $tlDateTimeSelect->addOption(0, _AM_WGTIMELINES_TIMELINE_DATETIME_NO);
        $tlDateTimeSelect->addOption(1, _AM_WGTIMELINES_TIMELINE_DATETIME_ONLY_D);
        $tlDateTimeSelect->addOption(2, _AM_WGTIMELINES_TIMELINE_DATETIME_ONLY_T);
        $tlDateTimeSelect->addOption(3, _AM_WGTIMELINES_TIMELINE_DATETIME_BOTH);
        $form->addElement($tlDateTimeSelect, true);
        // Form Radio Yes/No tl_magnific
        $tlMagnific = $this->isNew() ? 0 : $this->getVar('tl_magnific');
        $form->addElement(new \XoopsFormRadioYN(_AM_WGTIMELINES_TIMELINE_MAGNIFIC . '<br>' . _AM_WGTIMELINES_TIMELINE_MAGNIFIC_DESC, 'tl_magnific', $tlMagnific));
        // Form Text tlExpired
        $tlExpired = $this->isNew() ? 0 : $this->getVar('tl_expired');
        $tlExpiredSelect = new \XoopsFormSelect(_CO_WGTIMELINES_TIMELINE_EXPIRED, 'tl_expired', $tlExpired);
        $tlExpiredSelect->addOption(Constants::WGTIMELINES_TIMELINE_EXPIRED_SHOW, _CO_WGTIMELINES_TIMELINE_EXPIRED_SHOW);
        $tlExpiredSelect->addOption(Constants::WGTIMELINES_TIMELINE_EXPIRED_HIDE, _CO_WGTIMELINES_TIMELINE_EXPIRED_HIDE);
        $form->addElement($tlExpiredSelect, true);
		// Form Text TlWeight
        $timelinesHandler = $helper->getHandler('Timelines');
        $tlWeight = $this->isNew() ? ($timelinesHandler->getCountTimelines() + 1) : $this->getVar('tl_weight');
        $form->addElement(new \XoopsFormHidden('tl_weight', $tlWeight));
        // Form Radio Yes/No
        $tlOnline = $this->isNew() ? 0 : $this->getVar('tl_online');
        $form->addElement(new \XoopsFormRadioYN(_AM_WGTIMELINES_ONLINE, 'tl_online', $tlOnline));
        // Form Select User
        $form->addElement(new \XoopsFormSelectUser(_AM_WGTIMELINES_SUBMITTER, 'tl_submitter', false, $this->getVar('tl_submitter')));
        // Form Text Date Select
        $tlDate_create = $this->isNew() ? 0 : $this->getVar('tl_date_create');
        $form->addElement(new \XoopsFormTextDateSelect(_AM_WGTIMELINES_DATE_CREATE, 'tl_date_create', '', $tlDate_create), true);
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesTimelines($keys = null, $format = null, $maxDepth = null)
    {
        $helper = \XoopsModules\Wgtimelines\Helper::getInstance();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id'] = $this->getVar('tl_id');
        $ret['name'] = $this->getVar('tl_name');
        $ret['desc'] = $this->getVar('tl_desc', 'show');
        $ret['desc_admin'] = $helper->truncateHtml($this->getVar('tl_desc', 'n'));
        $ret['image'] = $this->getVar('tl_image');
        $ret['weight'] = $this->getVar('tl_weight');
        $ret['sortby'] = $this->getVar('tl_sortby');
        $ret['limit'] = $this->getVar('tl_limit');
        $ret['datetime'] = $this->getVar('tl_datetime');
        $ret['magnific'] = $this->getVar('tl_magnific');
		$ret['expired'] = $this->getVar('tl_expired');
		switch ( $this->getVar('tl_expired') ) {
			case Constants::WGTIMELINES_TIMELINE_EXPIRED_HIDE:
				$ret['expired_text'] = _CO_WGTIMELINES_TIMELINE_EXPIRED_HIDE;
			break;
			case Constants::WGTIMELINES_TIMELINE_EXPIRED_SHOW:
			default:
				$ret['expired_text'] = _CO_WGTIMELINES_TIMELINE_EXPIRED_SHOW;
			break;
		}
        $ret['online'] = $this->getVar('tl_online');
        $ret['submitter'] = \XoopsUser::getUnameFromId($this->getVar('tl_submitter'));
        $ret['date_create'] = formatTimestamp($this->getVar('tl_date_create'), 's');
        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayTimelines()
    {
        $ret = array();
        $vars =& $this->getVars();
        foreach (array_keys($vars) as $var) {
            $ret[$var] = $this->getVar('"{$var}"');
        }
        return $ret;
    }
}
