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
 * @version        $Id: 1.0 items.php 13070 Sat 2016-10-01 05:42:14Z XOOPS Development Team $
 */
 
use XoopsModules\Wgtimelines;
 
\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object WgtimelinesItems
 */
class Items extends \XoopsObject
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('item_id', \XOBJ_DTYPE_INT);
        $this->initVar('item_tl_id', \XOBJ_DTYPE_INT);
        $this->initVar('item_title', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('item_content', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('item_image', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('item_date', \XOBJ_DTYPE_INT);
        $this->initVar('item_item', \XOBJ_DTYPE_INT);
        $this->initVar('item_year', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('item_icon', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('item_weight', \XOBJ_DTYPE_INT);
        $this->initVar('item_online', \XOBJ_DTYPE_INT);
        $this->initVar('item_reads', \XOBJ_DTYPE_INT);
        $this->initVar('item_submitter', \XOBJ_DTYPE_INT);
        $this->initVar('item_date_create', \XOBJ_DTYPE_INT);
        $this->initVar('dohtml', \XOBJ_DTYPE_INT, 1, false);
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
    public function getNewInsertedIdItems()
    {
        $newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
        return $newInsertedId;
    }

    /**
     * Get form
     *
     * @param mixed $action
     * @param string $ui
     * @return \XoopsThemeForm
     */
    public function getFormItems($action = false, $ui = 'admin')
    {
        $helper = \XoopsModules\Wgtimelines\Helper::getInstance();
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Title
        $title = $this->isNew() ? \sprintf(\_AM_WGTIMELINES_ITEM_ADD) : \sprintf(\_AM_WGTIMELINES_ITEM_EDIT);
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Table Items
        $timelinesHandler = $helper->getHandler('Timelines');
        $itemTl_idSelect = new \XoopsFormSelect(\_AM_WGTIMELINES_ITEM_TL_ID, 'item_tl_id', $this->getVar('item_tl_id'));
        $itemTl_idSelect->addOption(0, \_AM_WGTIMELINES_ITEM_NONE);
        $itemTl_idSelect->addOptionArray($timelinesHandler->getList());
        $form->addElement($itemTl_idSelect, true);
        // Form Text ItemTitle
        $form->addElement(new \XoopsFormText(\_AM_WGTIMELINES_ITEM_TITLE, 'item_title', 50, 255, $this->getVar('item_title')));
        // Form editor ItemContent
        $editorConfigs = array();
        $editorConfigs['name'] = 'item_content';
        $editorConfigs['value'] = $this->getVar('item_content', 'e');
        $editorConfigs['rows'] = 5;
        $editorConfigs['cols'] = 40;
        $editorConfigs['width'] = '100%';
        $editorConfigs['height'] = '400px';
        $editorConfigs['editor'] = $helper->getConfig('wgtimelines_editor');
        $form->addElement(new \XoopsFormEditor(\_AM_WGTIMELINES_ITEM_CONTENT, 'item_content', $editorConfigs), true);
        
        // Form Image
        $imageDirectory = '/uploads/wgtimelines/images/items';
        if ($this->isNew()) {
            $itemImage = 'blank.gif';
            $imageTray = new \XoopsFormElementTray(\_AM_WGTIMELINES_ITEM_IMAGE, '<br>');
            $imageSelect = new \XoopsFormSelect(\sprintf(\_AM_WGTIMELINES_FORM_IMAGE_PATH, ".{$imageDirectory}/"), 'item_image', $itemImage, 5);
            $imageArray = \XoopsLists::getImgListAsArray(\XOOPS_ROOT_PATH . $imageDirectory);
            foreach ($imageArray as $image1) {
                $imageSelect->addOption("{$image1}", $image1);
            }
            $imageSelect->setExtra("onchange='showImgSelected(\"image1\", \"item_image\", \"".$imageDirectory . '", "", "' . \XOOPS_URL . "\")'");
            $imageTray->addElement($imageSelect, false);
            $imageTray->addElement(new \XoopsFormLabel('', "<br><img src='".\XOOPS_URL . "$imageDirectory/$itemImage' name='image1' id='image1' alt='$itemImage' style='max-width:100px;' />"));
            // Form File
            $fileSelectTray = new \XoopsFormElementTray('', '<br>');
            $fileSelectTray->addElement(new \XoopsFormFile(\_AM_WGTIMELINES_FORM_UPLOAD_IMAGE, 'attachedfile', $helper->getConfig('maxsize')));
            $fileSelectTray->addElement(new \XoopsFormLabel(''));
            $imageTray->addElement($fileSelectTray);
            $form->addElement($imageTray);
        } else {
            $itemID = $this->getVar('item_id');
            $imgButton = "<input type='button' value='...' onclick='window.location.href=\"" . \XOOPS_URL . "/modules/wgtimelines/admin/image_editor.php?op=edit_item&item_id=$itemID\"'>";
            $itemImage = $this->getVar('item_image');
            
            $form->addElement(new \XoopsFormLabel(\_AM_WGTIMELINES_ITEM_IMAGE,"<img src='".\XOOPS_URL . "$imageDirectory/$itemImage' name='image1' id='image1' alt='$itemImage' style='max-width:100px;' />$imgButton"));
        }

        // Form Text Date Select
        $itemDate = $this->isNew() ? \mktime(0, 0, 0, (int)date("m"), (int)date("d"), (int)date("Y")) : $this->getVar('item_date');
        $form->addElement(new \XoopsFormDateTime(\_AM_WGTIMELINES_ITEM_DATE, 'item_date', 15, $itemDate));
        // Form Text ItemYear
        if ($this->isNew()) {
            $itemYear = \formatTimestamp(\time(), 'Y');
        } else {
            $itemYear = $this->getVar('item_year');
        }
        $form->addElement(new \XoopsFormText(\_AM_WGTIMELINES_ITEM_YEAR . "<br><span class='font-size:70%'> " . \_AM_WGTIMELINES_ITEM_YEAR_ICON_DESC . '</span>', 'item_year', 20, 255, $itemYear));
        
        // Form Select Badge Icon
        $item_icon = $this->isNew() ? 'none' : $this->getVar('item_icon');
        $iconsTray = new \XoopsFormElementTray(\_AM_WGTIMELINES_ITEM_ICON . "<br><span class='font-size:70%'> " . \_AM_WGTIMELINES_ITEM_YEAR_ICON_DESC . '</span>', '');
        $toggleIcon = '<div class="toggle-buttons">';
        $toggleIcon .= "<div style='display:inline-block'><input type='radio' name='item_icon' id='item_icon-none' title='' value='none'";
        if ('none' == $item_icon) {$toggleIcon .= " checked=''";}
        $toggleIcon .= "><label name='xolb_item_icon' for='item_icon-'><i class='glyphicon glyphicon-'> " . \_AM_WGTIMELINES_ITEM_NONE . "</i></label></div>";
        $arrIcons = $this->arrGlyphicons();
        foreach ($arrIcons as $icon) {
            $toggleIcon .= "<div style='display:inline-block'><input type='radio' name='item_icon' id='item_icon-$icon' title='' value='$icon'";
            if ($icon == $item_icon) {$toggleIcon .= " checked=''";}
            $toggleIcon .= "><label name='xolb_item_icon' for='item_icon-$icon'><i class='glyphicon glyphicon-$icon'> $icon</i></label></div>";
        }
        $toggleIcon .= '</div>';
        $iconsTray->addElement(new \XoopsFormLabel('', $toggleIcon));
        $form->addElement($iconsTray);

        // Form Text ItemWeight
        $itemsHandler = $helper->getHandler('Items');
        $itemWeight = $this->isNew() ? ($itemsHandler->getCountItems() + 1) : $this->getVar('item_weight');
        $form->addElement(new \XoopsFormHidden('item_weight', $itemWeight));
        // Form Text ItemReads
        $itemReads = $this->isNew() ? 0 : $this->getVar('item_reads');
        $form->addElement(new \XoopsFormText(\_AM_WGTIMELINES_ITEM_READS, 'item_reads', 20, 255, $itemReads));
        // Form Radio Yes/No
        $itemOnline = $this->isNew() ? 0 : $this->getVar('item_online');
        $form->addElement(new \XoopsFormRadioYN(\_AM_WGTIMELINES_ONLINE, 'item_online', $itemOnline));
        // Form Select User
        $form->addElement(new \XoopsFormSelectUser(\_AM_WGTIMELINES_SUBMITTER, 'item_submitter', false, $this->getVar('item_submitter')));
        // Form Text Date Select
        $itemDate_create = $this->isNew() ? 0 : $this->getVar('item_date_create');
        $form->addElement(new \XoopsFormTextDateSelect(\_AM_WGTIMELINES_DATE_CREATE, 'item_date_create', '', $itemDate_create));
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormHidden('ui', $ui));
        $form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
     * Get Values
     * @param $timeline_obj
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesItems($timeline_obj, $keys = null, $format = null, $maxDepth = null)
    {
        $helper = \XoopsModules\Wgtimelines\Helper::getInstance();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id'] = $this->getVar('item_id');
        $ret['tl_id'] = $this->getVar('item_tl_id');
        $ret['tl_name'] = $timeline_obj->getVar('tl_name');
        $ret['title'] = $this->getVar('item_title');
        $ret['content'] = $this->getVar('item_content', 'show');
        $content = $this->getVar('item_content', 'show'); //show wichtig bei tl_limit>0
        $tl_limit = $timeline_obj->getVar('tl_limit');
        $ret['tl_limit'] = $tl_limit;
        $ret['content_admin'] = $helper->truncateHtml($content);
        $ret['content_summary'] = '';
        if ($tl_limit > 0 && \strlen(\strip_tags($content)) > $tl_limit) {
            $ret['content_summary'] = $helper->truncateHtml($content, $timeline_obj->getVar('tl_limit'));
            $ret['content_admin'] = $helper->truncateHtml($content, $timeline_obj->getVar('tl_limit'));
        }
        $ret['image'] = $this->getVar('item_image');
        if ($this->getVar('item_date') > 0) {
            $tl_datetime = $timeline_obj->getVar('tl_datetime');
            switch ($tl_datetime) {
                case 1:
                    $ret['date'] = \formatTimestamp($this->getVar('item_date'), 's');
                break;
                case 2:
                    $ret['date'] = \formatTimestamp($this->getVar('item_date'), 'H:i');
                break;
                case 3:
                    $ret['date'] = \formatTimestamp($this->getVar('item_date'), 'm');
                break;
                case '0':
                default:
                    $ret['date'] = "";
                break;
            }
            $ret['date_admin'] = \formatTimestamp($this->getVar('item_date'), 'm');
        }
        $ret['year'] = $this->getVar('item_year');
        $ret['icon'] = $this->getVar('item_icon');
        $ret['weight'] = $this->getVar('item_weight');
        $ret['reads'] = $this->getVar('item_reads');
        $ret['online'] = $this->getVar('item_online');
        $ret['submitter'] = \XoopsUser::getUnameFromId($this->getVar('item_submitter'));
        $ret['date_create'] = \formatTimestamp($this->getVar('item_date_create'), 's');
        return $ret;
      }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayItems()
    {
        $ret = array();
        $vars =& $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar('"{$var}"');
        }
        return $ret;
    }
    
    /**
     * Returns an array with all glyphicons
     *
     * @param $item_icon
     * @return array
     */
    public function arrGlyphicons()
    {
        $arrIcons[] = 'asterisk';
        $arrIcons[] = 'plus';
        $arrIcons[] = 'eur';
        $arrIcons[] = 'minus';
        $arrIcons[] = 'cloud';
        $arrIcons[] = 'envelope';
        $arrIcons[] = 'pencil';
        $arrIcons[] = 'glass';
        $arrIcons[] = 'music';
        $arrIcons[] = 'search';
        $arrIcons[] = 'heart';
        $arrIcons[] = 'star';
        $arrIcons[] = 'star-empty';
        $arrIcons[] = 'user';
        $arrIcons[] = 'film';
        $arrIcons[] = 'ok';
        $arrIcons[] = 'remove';
        $arrIcons[] = 'off';
        $arrIcons[] = 'signal';
        $arrIcons[] = 'cog';
        $arrIcons[] = 'trash';
        $arrIcons[] = 'home';
        $arrIcons[] = 'time';
        $arrIcons[] = 'road';
        $arrIcons[] = 'download';
        $arrIcons[] = 'upload';
        $arrIcons[] = 'inbox';
        $arrIcons[] = 'list-alt';
        $arrIcons[] = 'lock';
        $arrIcons[] = 'flag';
        $arrIcons[] = 'headphones';
        $arrIcons[] = 'tag';
        $arrIcons[] = 'tags';
        $arrIcons[] = 'book';
        $arrIcons[] = 'bookmark';
        $arrIcons[] = 'camera';
        $arrIcons[] = 'facetime-video';
        $arrIcons[] = 'picture';
        $arrIcons[] = 'map-marker';
        $arrIcons[] = 'adjust';
        $arrIcons[] = 'tint';
        $arrIcons[] = 'move';
        $arrIcons[] = 'backward';
        $arrIcons[] = 'play';
        $arrIcons[] = 'pause';
        $arrIcons[] = 'forward';
        $arrIcons[] = 'plus-sign';
        $arrIcons[] = 'minus-sign';
        $arrIcons[] = 'remove-sign';
        $arrIcons[] = 'ok-sign';
        $arrIcons[] = 'question-sign';
        $arrIcons[] = 'info-sign';
        $arrIcons[] = 'screenshot';
        $arrIcons[] = 'exclamation-sign';
        $arrIcons[] = 'gift';
        $arrIcons[] = 'leaf';
        $arrIcons[] = 'fire';
        $arrIcons[] = 'eye-open';
        $arrIcons[] = 'eye-close';
        $arrIcons[] = 'warning-sign';
        $arrIcons[] = 'plane';
        $arrIcons[] = 'calendar';
        $arrIcons[] = 'random';
        $arrIcons[] = 'comment';
        $arrIcons[] = 'magnet';
        $arrIcons[] = 'shopping-cart';
        $arrIcons[] = 'bullhorn';
        $arrIcons[] = 'bell';
        $arrIcons[] = 'certificate';
        $arrIcons[] = 'thumbs-up';
        $arrIcons[] = 'thumbs-down';
        $arrIcons[] = 'hand-right';
        $arrIcons[] = 'hand-left';
        $arrIcons[] = 'hand-up';
        $arrIcons[] = 'hand-down';
        $arrIcons[] = 'globe';
        $arrIcons[] = 'filter';
        $arrIcons[] = 'briefcase';
        $arrIcons[] = 'fullscreen';
        $arrIcons[] = 'dashboard';
        $arrIcons[] = 'paperclip';
        $arrIcons[] = 'heart-empty';
        $arrIcons[] = 'phone';
        $arrIcons[] = 'pushpin';
        $arrIcons[] = 'flash';
        $arrIcons[] = 'record';
        $arrIcons[] = 'send';
        $arrIcons[] = 'credit-card';
        $arrIcons[] = 'transfer';
        $arrIcons[] = 'cutlery';
        $arrIcons[] = 'earphone';
        $arrIcons[] = 'phone-alt';
        $arrIcons[] = 'tower';
        $arrIcons[] = 'stats';
        $arrIcons[] = 'tree-conifer';
        $arrIcons[] = 'tree-deciduous';
        $arrIcons[] = 'cd';
        $arrIcons[] = 'equalizer';
        $arrIcons[] = 'king';
        $arrIcons[] = 'queen';
        $arrIcons[] = 'pawn';
        $arrIcons[] = 'bishop';
        $arrIcons[] = 'knight';
        $arrIcons[] = 'baby-formula';
        $arrIcons[] = 'tent';
        $arrIcons[] = 'blackboard';
        $arrIcons[] = 'bed';
        $arrIcons[] = 'apple';
        $arrIcons[] = 'erase';
        $arrIcons[] = 'hourglass';
        $arrIcons[] = 'lamp';
        $arrIcons[] = 'piggy-bank';
        $arrIcons[] = 'scissors';
        $arrIcons[] = 'scale';
        $arrIcons[] = 'ice-lolly';
        $arrIcons[] = 'ice-lolly-tasted';
        $arrIcons[] = 'education';
        $arrIcons[] = 'menu-hamburger';
        $arrIcons[] = 'modal-window';
        $arrIcons[] = 'oil';
        $arrIcons[] = 'grain';
        $arrIcons[] = 'sunglasses';
        $arrIcons[] = 'triangle-right';
        $arrIcons[] = 'triangle-left';
        $arrIcons[] = 'triangle-bottom';
        $arrIcons[] = 'triangle-top';
        
        
        
        // $item_icon->addOption('euro', "<i class='glyphicon glyphicon-euro'> euro</i>");
        // $item_icon->addOption('th-large', "<i class='glyphicon glyphicon-th-large'> th-large</i>");
        // $item_icon->addOption('th', "<i class='glyphicon glyphicon-th'> th</i>");
        // $item_icon->addOption('th-list', "<i class='glyphicon glyphicon-th-list'> th-list</i>");
        // $item_icon->addOption('zoom-in', "<i class='glyphicon glyphicon-zoom-in'> zoom-in</i>");
        // $item_icon->addOption('zoom-out', "<i class='glyphicon glyphicon-zoom-out'> zoom-out</i>");
        // $item_icon->addOption('file', "<i class='glyphicon glyphicon-file'> file</i>");
        // $item_icon->addOption('download-alt', "<i class='glyphicon glyphicon-download-alt'> download-alt</i>");
        // $item_icon->addOption('play-circle', "<i class='glyphicon glyphicon-play-circle'> play-circle</i>");
        // $item_icon->addOption('repeat', "<i class='glyphicon glyphicon-repeat'> repeat</i>");
        // $item_icon->addOption('refresh', "<i class='glyphicon glyphicon-refresh'> refresh</i>");
        // $item_icon->addOption('volume-off', "<i class='glyphicon glyphicon-volume-off'> volume-off</i>");
        // $item_icon->addOption('volume-down', "<i class='glyphicon glyphicon-volume-down'> volume-down</i>");
        // $item_icon->addOption('volume-up', "<i class='glyphicon glyphicon-volume-up'> volume-up</i>");
        // $item_icon->addOption('qrcode', "<i class='glyphicon glyphicon-qrcode'> qrcode</i>");
        // $item_icon->addOption('barcode', "<i class='glyphicon glyphicon-barcode'> barcode</i>");
        // $item_icon->addOption('print', "<i class='glyphicon glyphicon-print'> print</i>");
        // $item_icon->addOption('font', "<i class='glyphicon glyphicon-font'> font</i>");
        // $item_icon->addOption('bold', "<i class='glyphicon glyphicon-bold'> bold</i>");
        // $item_icon->addOption('italic', "<i class='glyphicon glyphicon-italic'> italic</i>");
        // $item_icon->addOption('text-height', "<i class='glyphicon glyphicon-text-height'> text-height</i>");
        // $item_icon->addOption('text-width', "<i class='glyphicon glyphicon-text-width'> text-width</i>");
        // $item_icon->addOption('align-left', "<i class='glyphicon glyphicon-align-left'> align-left</i>");
        // $item_icon->addOption('align-center', "<i class='glyphicon glyphicon-align-center'> align-center</i>");
        // $item_icon->addOption('align-right', "<i class='glyphicon glyphicon-align-right'> align-right</i>");
        // $item_icon->addOption('align-justify', "<i class='glyphicon glyphicon-align-justify'> align-justify</i>");
        // $item_icon->addOption('list', "<i class='glyphicon glyphicon-list'> list</i>");
        // $item_icon->addOption('indent-left', "<i class='glyphicon glyphicon-indent-left'> indent-left</i>");
        // $item_icon->addOption('indent-right', "<i class='glyphicon glyphicon-indent-right'> indent-right</i>");
        // $item_icon->addOption('edit', "<i class='glyphicon glyphicon-edit'> edit</i>");
        // $item_icon->addOption('share', "<i class='glyphicon glyphicon-share'> share</i>");
        // $item_icon->addOption('check', "<i class='glyphicon glyphicon-check'> check</i>");
        // $item_icon->addOption('step-backward', "<i class='glyphicon glyphicon-step-backward'> step-backward</i>");
        // $item_icon->addOption('fast-backward', "<i class='glyphicon glyphicon-fast-backward'> fast-backward</i>");
        // $item_icon->addOption('stop', "<i class='glyphicon glyphicon-stop'> stop</i>");
        // $item_icon->addOption('fast-forward', "<i class='glyphicon glyphicon-fast-forward'> fast-forward</i>");
        // $item_icon->addOption('step-forward', "<i class='glyphicon glyphicon-step-forward'> step-forward</i>");
        // $item_icon->addOption('eject', "<i class='glyphicon glyphicon-eject'> eject</i>");
        // $item_icon->addOption('chevron-left', "<i class='glyphicon glyphicon-chevron-left'> chevron-left</i>");
        // $item_icon->addOption('chevron-right', "<i class='glyphicon glyphicon-chevron-right'> chevron-right</i>");
        // $item_icon->addOption('remove-circle', "<i class='glyphicon glyphicon-remove-circle'> remove-circle</i>");
        // $item_icon->addOption('ok-circle', "<i class='glyphicon glyphicon-ok-circle'> ok-circle</i>");
        // $item_icon->addOption('ban-circle', "<i class='glyphicon glyphicon-ban-circle'> ban-circle</i>");
        // $item_icon->addOption('arrow-left', "<i class='glyphicon glyphicon-arrow-left'> arrow-left</i>");
        // $item_icon->addOption('arrow-right', "<i class='glyphicon glyphicon-arrow-right'> arrow-right</i>");
        // $item_icon->addOption('arrow-up', "<i class='glyphicon glyphicon-arrow-up'> arrow-up</i>");
        // $item_icon->addOption('arrow-down', "<i class='glyphicon glyphicon-arrow-down'> arrow-down</i>");
        // $item_icon->addOption('share-alt', "<i class='glyphicon glyphicon-share-alt'> share-alt</i>");
        // $item_icon->addOption('resize-full', "<i class='glyphicon glyphicon-resize-full'> resize-full</i>");
        // $item_icon->addOption('resize-small', "<i class='glyphicon glyphicon-resize-small'> resize-small</i>");
        // $item_icon->addOption('chevron-up', "<i class='glyphicon glyphicon-chevron-up'> chevron-up</i>");
        // $item_icon->addOption('chevron-down', "<i class='glyphicon glyphicon-chevron-down'> chevron-down</i>");
        // $item_icon->addOption('retweet', "<i class='glyphicon glyphicon-retweet'> retweet</i>");
        // $item_icon->addOption('folder-close', "<i class='glyphicon glyphicon-folder-close'> folder-close</i>");
        // $item_icon->addOption('folder-open', "<i class='glyphicon glyphicon-folder-open'> folder-open</i>");
        // $item_icon->addOption('resize-vertical', "<i class='glyphicon glyphicon-resize-vertical'> resize-vertical</i>");
        // $item_icon->addOption('resize-horizontal', "<i class='glyphicon glyphicon-resize-horizontal'> resize-horizontal</i>");
        // $item_icon->addOption('hdd', "<i class='glyphicon glyphicon-hdd'> hdd</i>");
        // $item_icon->addOption('circle-arrow-right', "<i class='glyphicon glyphicon-circle-arrow-right'> circle-arrow-right</i>");
        // $item_icon->addOption('circle-arrow-left', "<i class='glyphicon glyphicon-circle-arrow-left'> circle-arrow-left</i>");
        // $item_icon->addOption('circle-arrow-up', "<i class='glyphicon glyphicon-circle-arrow-up'> circle-arrow-up</i>");
        // $item_icon->addOption('circle-arrow-down', "<i class='glyphicon glyphicon-circle-arrow-down'> circle-arrow-down</i>");
        // $item_icon->addOption('wrench', "<i class='glyphicon glyphicon-wrench'> wrench</i>");
        // $item_icon->addOption('tasks', "<i class='glyphicon glyphicon-tasks'> tasks</i>");
        // $item_icon->addOption('link', "<i class='glyphicon glyphicon-link'> link</i>");
        // $item_icon->addOption('usd', "<i class='glyphicon glyphicon-usd'> usd</i>");
        // $item_icon->addOption('gbp', "<i class='glyphicon glyphicon-gbp'> gbp</i>");
        // $item_icon->addOption('sort', "<i class='glyphicon glyphicon-sort'> sort</i>");
        // $item_icon->addOption('sort-by-alphabet', "<i class='glyphicon glyphicon-sort-by-alphabet'> sort-by-alphabet</i>");
        // $item_icon->addOption('sort-by-alphabet-alt', "<i class='glyphicon glyphicon-sort-by-alphabet-alt'> sort-by-alphabet-alt</i>");
        // $item_icon->addOption('sort-by-order', "<i class='glyphicon glyphicon-sort-by-order'> sort-by-order</i>");
        // $item_icon->addOption('sort-by-order-alt', "<i class='glyphicon glyphicon-sort-by-order-alt'> sort-by-order-alt</i>");
        // $item_icon->addOption('sort-by-attributes', "<i class='glyphicon glyphicon-sort-by-attributes'> sort-by-attributes</i>");
        // $item_icon->addOption('sort-by-attributes-alt', "<i class='glyphicon glyphicon-sort-by-attributes-alt'> sort-by-attributes-alt</i>");
        // $item_icon->addOption('unchecked', "<i class='glyphicon glyphicon-unchecked'> unchecked</i>");
        // $item_icon->addOption('expand', "<i class='glyphicon glyphicon-expand'> expand</i>");
        // $item_icon->addOption('collapse-down', "<i class='glyphicon glyphicon-collapse-down'> collapse-down</i>");
        // $item_icon->addOption('collapse-up', "<i class='glyphicon glyphicon-collapse-up'> collapse-up</i>");
        // $item_icon->addOption('log-in', "<i class='glyphicon glyphicon-log-in'> log-in</i>");
        // $item_icon->addOption('log-out', "<i class='glyphicon glyphicon-log-out'> log-out</i>");
        // $item_icon->addOption('new-window', "<i class='glyphicon glyphicon-new-window'> new-window</i>");
        // $item_icon->addOption('save', "<i class='glyphicon glyphicon-save'> save</i>");
        // $item_icon->addOption('open', "<i class='glyphicon glyphicon-open'> open</i>");
        // $item_icon->addOption('saved', "<i class='glyphicon glyphicon-saved'> saved</i>");
        // $item_icon->addOption('import', "<i class='glyphicon glyphicon-import'> import</i>");
        // $item_icon->addOption('export', "<i class='glyphicon glyphicon-export'> export</i>");
        // $item_icon->addOption('floppy-disk', "<i class='glyphicon glyphicon-floppy-disk'> floppy-disk</i>");
        // $item_icon->addOption('floppy-saved', "<i class='glyphicon glyphicon-floppy-saved'> floppy-saved</i>");
        // $item_icon->addOption('floppy-remove', "<i class='glyphicon glyphicon-floppy-remove'> floppy-remove</i>");
        // $item_icon->addOption('floppy-save', "<i class='glyphicon glyphicon-floppy-save'> floppy-save</i>");
        // $item_icon->addOption('floppy-open', "<i class='glyphicon glyphicon-floppy-open'> floppy-open</i>");
        // $item_icon->addOption('header', "<i class='glyphicon glyphicon-header'> header</i>");
        // $item_icon->addOption('compressed', "<i class='glyphicon glyphicon-compressed'> compressed</i>");
        // $item_icon->addOption('sd-video', "<i class='glyphicon glyphicon-sd-video'> sd-video</i>");
        // $item_icon->addOption('hd-video', "<i class='glyphicon glyphicon-hd-video'> hd-video</i>");
        // $item_icon->addOption('subtitles', "<i class='glyphicon glyphicon-subtitles'> subtitles</i>");
        // $item_icon->addOption('sound-stereo', "<i class='glyphicon glyphicon-sound-stereo'> sound-stereo</i>");
        // $item_icon->addOption('sound-dolby', "<i class='glyphicon glyphicon-sound-dolby'> sound-dolby</i>");
        // $item_icon->addOption('sound-5-1', "<i class='glyphicon glyphicon-sound-5-1'> sound-5-1</i>");
        // $item_icon->addOption('sound-6-1', "<i class='glyphicon glyphicon-sound-6-1'> sound-6-1</i>");
        // $item_icon->addOption('sound-7-1', "<i class='glyphicon glyphicon-sound-7-1'> sound-7-1</i>");
        // $item_icon->addOption('copyright-mark', "<i class='glyphicon glyphicon-copyright-mark'> copyright-mark</i>");
        // $item_icon->addOption('registration-mark', "<i class='glyphicon glyphicon-registration-mark'> registration-mark</i>");
        // $item_icon->addOption('cloud-download', "<i class='glyphicon glyphicon-cloud-download'> cloud-download</i>");
        // $item_icon->addOption('cloud-upload', "<i class='glyphicon glyphicon-cloud-upload'> cloud-upload</i>");
        // $item_icon->addOption('save-file', "<i class='glyphicon glyphicon-save-file'> save-file</i>");
        // $item_icon->addOption('open-file', "<i class='glyphicon glyphicon-open-file'> open-file</i>");
        // $item_icon->addOption('level-up', "<i class='glyphicon glyphicon-level-up'> level-up</i>");
        // $item_icon->addOption('copy', "<i class='glyphicon glyphicon-copy'> copy</i>");
        // $item_icon->addOption('paste', "<i class='glyphicon glyphicon-paste'> paste</i>");
        // $item_icon->addOption('alert', "<i class='glyphicon glyphicon-alert'> alert</i>");
        // $item_icon->addOption('duplicate', "<i class='glyphicon glyphicon-duplicate'> duplicate</i>");
        // $item_icon->addOption('bitcoin', "<i class='glyphicon glyphicon-bitcoin'> bitcoin</i>");
        // $item_icon->addOption('btc', "<i class='glyphicon glyphicon-btc'> btc</i>");
        // $item_icon->addOption('xbt', "<i class='glyphicon glyphicon-xbt'> xbt</i>");
        // $item_icon->addOption('yen', "<i class='glyphicon glyphicon-yen'> yen</i>");
        // $item_icon->addOption('jpy', "<i class='glyphicon glyphicon-jpy'> jpy</i>");
        // $item_icon->addOption('ruble', "<i class='glyphicon glyphicon-ruble'> ruble</i>");
        // $item_icon->addOption('rub', "<i class='glyphicon glyphicon-rub'> rub</i>");
        // $item_icon->addOption('option-horizontal', "<i class='glyphicon glyphicon-option-horizontal'> option-horizontal</i>");
        // $item_icon->addOption('option-vertical', "<i class='glyphicon glyphicon-option-vertical'> option-vertical</i>");
        // $item_icon->addOption('text-size', "<i class='glyphicon glyphicon-text-size'> text-size</i>");
        // $item_icon->addOption('text-color', "<i class='glyphicon glyphicon-text-color'> text-color</i>");
        // $item_icon->addOption('text-background', "<i class='glyphicon glyphicon-text-background'> text-background</i>");
        // $item_icon->addOption('object-align-top', "<i class='glyphicon glyphicon-object-align-top'> object-align-top</i>");
        // $item_icon->addOption('object-align-bottom', "<i class='glyphicon glyphicon-object-align-bottom'> object-align-bottom</i>");
        // $item_icon->addOption('object-align-horizontal', "<i class='glyphicon glyphicon-object-align-horizontal'> object-align-horizontal</i>");
        // $item_icon->addOption('object-align-left', "<i class='glyphicon glyphicon-object-align-left'> object-align-left</i>");
        // $item_icon->addOption('object-align-vertical', "<i class='glyphicon glyphicon-object-align-vertical'> object-align-vertical</i>");
        // $item_icon->addOption('object-align-right', "<i class='glyphicon glyphicon-object-align-right'> object-align-right</i>");
        // $item_icon->addOption('console', "<i class='glyphicon glyphicon-console'> console</i>");
        // $item_icon->addOption('superscript', "<i class='glyphicon glyphicon-superscript'> superscript</i>");
        // $item_icon->addOption('subscript', "<i class='glyphicon glyphicon-subscript'> subscript</i>");
        // $item_icon->addOption('menu-left', "<i class='glyphicon glyphicon-menu-left'> menu-left</i>");
        // $item_icon->addOption('menu-right', "<i class='glyphicon glyphicon-menu-right'> menu-right</i>");
        // $item_icon->addOption('menu-down', "<i class='glyphicon glyphicon-menu-down'> menu-down</i>");
        // $item_icon->addOption('menu-up', "<i class='glyphicon glyphicon-menu-up'> menu-up</i>");
        return $arrIcons;
    }
}
