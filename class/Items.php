<?php

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
 
defined('XOOPS_ROOT_PATH') || die('Restricted access');

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
        $this->initVar('item_id', XOBJ_DTYPE_INT);
        $this->initVar('item_tl_id', XOBJ_DTYPE_INT);
        $this->initVar('item_title', XOBJ_DTYPE_TXTBOX);
        $this->initVar('item_content', XOBJ_DTYPE_TXTAREA);
        $this->initVar('item_image', XOBJ_DTYPE_TXTBOX);
        $this->initVar('item_date', XOBJ_DTYPE_INT);
        $this->initVar('item_item', XOBJ_DTYPE_INT);
        $this->initVar('item_year', XOBJ_DTYPE_TXTBOX);
        $this->initVar('item_icon', XOBJ_DTYPE_TXTBOX);
        $this->initVar('item_weight', XOBJ_DTYPE_INT);
        $this->initVar('item_online', XOBJ_DTYPE_INT);
        $this->initVar('item_reads', XOBJ_DTYPE_INT);
        $this->initVar('item_submitter', XOBJ_DTYPE_INT);
        $this->initVar('item_date_create', XOBJ_DTYPE_INT);
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
        $title = $this->isNew() ? sprintf(_AM_WGTIMELINES_ITEM_ADD) : sprintf(_AM_WGTIMELINES_ITEM_EDIT);
        // Get Theme Form
        xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Table Items
        $timelinesHandler = $helper->getHandler('Timelines');
        $itemTl_idSelect = new \XoopsFormSelect(_AM_WGTIMELINES_ITEM_TL_ID, 'item_tl_id', $this->getVar('item_tl_id'));
        $itemTl_idSelect->addOption(0, _AM_WGTIMELINES_ITEM_NONE);
        $itemTl_idSelect->addOptionArray($timelinesHandler->getList());
        $form->addElement($itemTl_idSelect, true);
        // Form Text ItemTitle
        $form->addElement(new \XoopsFormText(_AM_WGTIMELINES_ITEM_TITLE, 'item_title', 50, 255, $this->getVar('item_title')));
        // Form editor ItemContent
        $editorConfigs = array();
        $editorConfigs['name'] = 'item_content';
        $editorConfigs['value'] = $this->getVar('item_content', 'e');
        $editorConfigs['rows'] = 5;
        $editorConfigs['cols'] = 40;
        $editorConfigs['width'] = '100%';
        $editorConfigs['height'] = '400px';
        $editorConfigs['editor'] = $helper->getConfig('wgtimelines_editor');
        $form->addElement(new \XoopsFormEditor(_AM_WGTIMELINES_ITEM_CONTENT, 'item_content', $editorConfigs), true);
        
        // Form Image
        $imageDirectory = '/uploads/wgtimelines/images/items';
        if ($this->isNew()) {
            $itemImage = 'blank.gif';
            $imageTray = new \XoopsFormElementTray(_AM_WGTIMELINES_ITEM_IMAGE, '<br>');
            $imageSelect = new \XoopsFormSelect(sprintf(_AM_WGTIMELINES_FORM_IMAGE_PATH, ".{$imageDirectory}/"), 'item_image', $itemImage, 5);
            $imageArray = \XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . $imageDirectory);
            foreach ($imageArray as $image1) {
                $imageSelect->addOption("{$image1}", $image1);
            }
            $imageSelect->setExtra("onchange='showImgSelected(\"image1\", \"item_image\", \"".$imageDirectory . '", "", "' . XOOPS_URL . "\")'");
            $imageTray->addElement($imageSelect, false);
            $imageTray->addElement(new \XoopsFormLabel('', "<br><img src='".XOOPS_URL . "$imageDirectory/$itemImage' name='image1' id='image1' alt='$itemImage' style='max-width:100px;' />"));
            // Form File
            $fileSelectTray = new \XoopsFormElementTray('', '<br>');
            $fileSelectTray->addElement(new \XoopsFormFile(_AM_WGTIMELINES_FORM_UPLOAD_IMAGE, 'attachedfile', $helper->getConfig('maxsize')));
            $fileSelectTray->addElement(new \XoopsFormLabel(''));
            $imageTray->addElement($fileSelectTray);
            $form->addElement($imageTray);
        } else {
            $itemID = $this->getVar('item_id');
            $imgButton = "<input type='button' value='...' onclick='window.location.href=\"" . XOOPS_URL . "/modules/wgtimelines/admin/image_editor.php?op=edit_item&item_id=$itemID\"'>";
            $itemImage = $this->getVar('item_image');
            
            $form->addElement(new \XoopsFormLabel(_AM_WGTIMELINES_ITEM_IMAGE,"<img src='".XOOPS_URL . "$imageDirectory/$itemImage' name='image1' id='image1' alt='$itemImage' style='max-width:100px;' />$imgButton"));
        }

        // Form Text Date Select
        $itemDate = $this->isNew() ? mktime(0, 0, 0, date("m"), date("d"), date("Y")) : $this->getVar('item_date');
        $form->addElement(new \XoopsFormDateTime(_AM_WGTIMELINES_ITEM_DATE, 'item_date', 15, $itemDate));
        // Form Text ItemYear
        if ($this->isNew()) {
            $itemYear = formatTimestamp(time(), 'Y');
        } else {
            $itemYear = $this->getVar('item_year');
        }
        $form->addElement(new \XoopsFormText(_AM_WGTIMELINES_ITEM_YEAR . "<br><span class='font-size:70%'> " . _AM_WGTIMELINES_ITEM_YEAR_ICON_DESC . '</span>', 'item_year', 20, 255, $itemYear));
        
        $item_icon = $this->isNew() ? 'none' : $this->getVar('item_icon');
        $iconsTray1 = new \XoopsFormElementTray(_AM_WGTIMELINES_ITEM_ICON . "<br><span class='font-size:70%'> " . _AM_WGTIMELINES_ITEM_YEAR_ICON_DESC . '</span>', '');
        $toggleIcon1 = '<div class="toggle-buttons">';
        $radioIcon1 = new \XoopsFormRadio('', 'item_icon', $item_icon);
        $radioIcon1->addOption('none', "<i class='glyphicon'> ". _AM_WGTIMELINES_ITEM_NONE . '</i>');
        $this->addGlyphicons($radioIcon1);
        $toggleIcon1 .= $radioIcon1->render();
        $toggleIcon1 .= '</div>';
        $iconsTray1->addElement(new \XoopsFormLabel('', $toggleIcon1));
        // $form->addElement($iconsTray1);
        
        $item_icon = $this->isNew() ? 'none' : $this->getVar('item_icon');
        $iconsTray = new \XoopsFormElementTray(_AM_WGTIMELINES_ITEM_ICON . "<br><span class='font-size:70%'> " . _AM_WGTIMELINES_ITEM_YEAR_ICON_DESC . '</span>', '');
        $toggleIcon = '<div class="toggle-buttons">';
        $toggleIcon .= "<div style='display:inline-block'><input type='radio' name='item_icon' id='item_icon-none' title='' value='none'";
        if ('none' == $item_icon) {$toggleIcon .= " checked=''";}
        $toggleIcon .= "><label name='xolb_item_icon' for='item_icon-$icon'><i class='glyphicon glyphicon-$icon'> " . _AM_WGTIMELINES_ITEM_NONE . "</i></label></div>";
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
        $form->addElement(new \XoopsFormText(_AM_WGTIMELINES_ITEM_READS, 'item_reads', 20, 255, $itemReads));
        // Form Radio Yes/No
        $itemOnline = $this->isNew() ? 0 : $this->getVar('item_online');
        $form->addElement(new \XoopsFormRadioYN(_AM_WGTIMELINES_ONLINE, 'item_online', $itemOnline));
        // Form Select User
        $form->addElement(new \XoopsFormSelectUser(_AM_WGTIMELINES_SUBMITTER, 'item_submitter', false, $this->getVar('item_submitter')));
        // Form Text Date Select
        $itemDate_create = $this->isNew() ? 0 : $this->getVar('item_date_create');
        $form->addElement(new \XoopsFormTextDateSelect(_AM_WGTIMELINES_DATE_CREATE, 'item_date_create', '', $itemDate_create));
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
        if ($tl_limit > 0 && strlen(strip_tags($content)) > $tl_limit) {
            $ret['content_summary'] = $helper->truncateHtml($content, $timeline_obj->getVar('tl_limit'));
            $ret['content_admin'] = $helper->truncateHtml($content, $timeline_obj->getVar('tl_limit'));
        }
        $ret['image'] = $this->getVar('item_image');
        if ($this->getVar('item_date') > 0) {
            $tl_datetime = $timeline_obj->getVar('tl_datetime');
            switch ($tl_datetime) {
                case 1:
                    $ret['date'] = formatTimestamp($this->getVar('item_date'), 's');
                break;
                case 2:
                    $ret['date'] = formatTimestamp($this->getVar('item_date'), 'H:i');
                break;
                case 3:
                    $ret['date'] = formatTimestamp($this->getVar('item_date'), 'm');
                break;
                case '0':
                default:
                    $ret['date'] = "";
                break;
            }
            $ret['date_admin'] = formatTimestamp($this->getVar('item_date'), 'm');
        }
        $ret['year'] = $this->getVar('item_year');
        $ret['icon'] = $this->getVar('item_icon');
        $ret['weight'] = $this->getVar('item_weight');
        $ret['reads'] = $this->getVar('item_reads');
        $ret['online'] = $this->getVar('item_online');
        $ret['submitter'] = \XoopsUser::getUnameFromId($this->getVar('item_submitter'));
        $ret['date_create'] = formatTimestamp($this->getVar('item_date_create'), 's');
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
        foreach (array_keys($vars) as $var) {
            $ret[$var] = $this->getVar('"{$var}"');
        }
        return $ret;
    }

    /**
     * Returns an form radio with all glyphicons
     *
     * @param $item_icon
     * @return array
     */
    public function addGlyphicons($item_icon)
    {
        $item_icon->addOption('asterisk', "<i class='glyphicon glyphicon-asterisk'> asterisk</i>");
        $item_icon->addOption('plus', "<i class='glyphicon glyphicon-plus'> plus</i>");
        $item_icon->addOption('eur', "<i class='glyphicon glyphicon-eur'> eur</i>");
        $item_icon->addOption('minus', "<i class='glyphicon glyphicon-minus'> minus</i>");
        $item_icon->addOption('cloud', "<i class='glyphicon glyphicon-cloud'> cloud</i>");
        $item_icon->addOption('envelope', "<i class='glyphicon glyphicon-envelope'> envelope</i>");
        $item_icon->addOption('pencil', "<i class='glyphicon glyphicon-pencil'> pencil</i>");
        $item_icon->addOption('glass', "<i class='glyphicon glyphicon-glass'> glass</i>");
        $item_icon->addOption('music', "<i class='glyphicon glyphicon-music'> music</i>");
        $item_icon->addOption('search', "<i class='glyphicon glyphicon-search'> search</i>");
        $item_icon->addOption('heart', "<i class='glyphicon glyphicon-heart'> heart</i>");
        $item_icon->addOption('star', "<i class='glyphicon glyphicon-star'> star</i>");
        $item_icon->addOption('star-empty', "<i class='glyphicon glyphicon-star-empty'> star-empty</i>");
        $item_icon->addOption('user', "<i class='glyphicon glyphicon-user'> user</i>");
        $item_icon->addOption('film', "<i class='glyphicon glyphicon-film'> film</i>");
        $item_icon->addOption('ok', "<i class='glyphicon glyphicon-ok'> ok</i>");
        $item_icon->addOption('remove', "<i class='glyphicon glyphicon-remove'> remove</i>");
        $item_icon->addOption('off', "<i class='glyphicon glyphicon-off'> off</i>");
        $item_icon->addOption('signal', "<i class='glyphicon glyphicon-signal'> signal</i>");
        $item_icon->addOption('cog', "<i class='glyphicon glyphicon-cog'> cog</i>");
        $item_icon->addOption('trash', "<i class='glyphicon glyphicon-trash'> trash</i>");
        $item_icon->addOption('home', "<i class='glyphicon glyphicon-home'> home</i>");
        $item_icon->addOption('time', "<i class='glyphicon glyphicon-time'> time</i>");
        $item_icon->addOption('road', "<i class='glyphicon glyphicon-road'> road</i>");
        $item_icon->addOption('download', "<i class='glyphicon glyphicon-download'> download</i>");
        $item_icon->addOption('upload', "<i class='glyphicon glyphicon-upload'> upload</i>");
        $item_icon->addOption('inbox', "<i class='glyphicon glyphicon-inbox'> inbox</i>");
        $item_icon->addOption('list-alt', "<i class='glyphicon glyphicon-list-alt'> list-alt</i>");
        $item_icon->addOption('lock', "<i class='glyphicon glyphicon-lock'> lock</i>");
        $item_icon->addOption('flag', "<i class='glyphicon glyphicon-flag'> flag</i>");
        $item_icon->addOption('headphones', "<i class='glyphicon glyphicon-headphones'> headphones</i>");
        $item_icon->addOption('tag', "<i class='glyphicon glyphicon-tag'> tag</i>");
        $item_icon->addOption('tags', "<i class='glyphicon glyphicon-tags'> tags</i>");
        $item_icon->addOption('book', "<i class='glyphicon glyphicon-book'> book</i>");
        $item_icon->addOption('bookmark', "<i class='glyphicon glyphicon-bookmark'> bookmark</i>");
        $item_icon->addOption('camera', "<i class='glyphicon glyphicon-camera'> camera</i>");
        $item_icon->addOption('facetime-video', "<i class='glyphicon glyphicon-facetime-video'> facetime-video</i>");
        $item_icon->addOption('picture', "<i class='glyphicon glyphicon-picture'> picture</i>");
        $item_icon->addOption('map-marker', "<i class='glyphicon glyphicon-map-marker'> map-marker</i>");
        $item_icon->addOption('adjust', "<i class='glyphicon glyphicon-adjust'> adjust</i>");
        $item_icon->addOption('tint', "<i class='glyphicon glyphicon-tint'> tint</i>");
        $item_icon->addOption('move', "<i class='glyphicon glyphicon-move'> move</i>");
        $item_icon->addOption('backward', "<i class='glyphicon glyphicon-backward'> backward</i>");
        $item_icon->addOption('play', "<i class='glyphicon glyphicon-play'> play</i>");
        $item_icon->addOption('pause', "<i class='glyphicon glyphicon-pause'> pause</i>");
        $item_icon->addOption('forward', "<i class='glyphicon glyphicon-forward'> forward</i>");
        $item_icon->addOption('plus-sign', "<i class='glyphicon glyphicon-plus-sign'> plus-sign</i>");
        $item_icon->addOption('minus-sign', "<i class='glyphicon glyphicon-minus-sign'> minus-sign</i>");
        $item_icon->addOption('remove-sign', "<i class='glyphicon glyphicon-remove-sign'> remove-sign</i>");
        $item_icon->addOption('ok-sign', "<i class='glyphicon glyphicon-ok-sign'> ok-sign</i>");
        $item_icon->addOption('question-sign', "<i class='glyphicon glyphicon-question-sign'> question-sign</i>");
        $item_icon->addOption('info-sign', "<i class='glyphicon glyphicon-info-sign'> info-sign</i>");
        $item_icon->addOption('screenshot', "<i class='glyphicon glyphicon-screenshot'> screenshot</i>");
        $item_icon->addOption('exclamation-sign', "<i class='glyphicon glyphicon-exclamation-sign'> exclamation-sign</i>");
        $item_icon->addOption('gift', "<i class='glyphicon glyphicon-gift'> gift</i>");
        $item_icon->addOption('leaf', "<i class='glyphicon glyphicon-leaf'> leaf</i>");
        $item_icon->addOption('fire', "<i class='glyphicon glyphicon-fire'> fire</i>");
        $item_icon->addOption('eye-open', "<i class='glyphicon glyphicon-eye-open'> eye-open</i>");
        $item_icon->addOption('eye-close', "<i class='glyphicon glyphicon-eye-close'> eye-close</i>");
        $item_icon->addOption('warning-sign', "<i class='glyphicon glyphicon-warning-sign'> warning-sign</i>");
        $item_icon->addOption('plane', "<i class='glyphicon glyphicon-plane'> plane</i>");
        $item_icon->addOption('calendar', "<i class='glyphicon glyphicon-calendar'> calendar</i>");
        $item_icon->addOption('random', "<i class='glyphicon glyphicon-random'> random</i>");
        $item_icon->addOption('comment', "<i class='glyphicon glyphicon-comment'> comment</i>");
        $item_icon->addOption('magnet', "<i class='glyphicon glyphicon-magnet'> magnet</i>");
        $item_icon->addOption('shopping-cart', "<i class='glyphicon glyphicon-shopping-cart'> shopping-cart</i>");
        $item_icon->addOption('bullhorn', "<i class='glyphicon glyphicon-bullhorn'> bullhorn</i>");
        $item_icon->addOption('bell', "<i class='glyphicon glyphicon-bell'> bell</i>");
        $item_icon->addOption('certificate', "<i class='glyphicon glyphicon-certificate'> certificate</i>");
        $item_icon->addOption('thumbs-up', "<i class='glyphicon glyphicon-thumbs-up'> thumbs-up</i>");
        $item_icon->addOption('thumbs-down', "<i class='glyphicon glyphicon-thumbs-down'> thumbs-down</i>");
        $item_icon->addOption('hand-right', "<i class='glyphicon glyphicon-hand-right'> hand-right</i>");
        $item_icon->addOption('hand-left', "<i class='glyphicon glyphicon-hand-left'> hand-left</i>");
        $item_icon->addOption('hand-up', "<i class='glyphicon glyphicon-hand-up'> hand-up</i>");
        $item_icon->addOption('hand-down', "<i class='glyphicon glyphicon-hand-down'> hand-down</i>");
        $item_icon->addOption('globe', "<i class='glyphicon glyphicon-globe'> globe</i>");
        $item_icon->addOption('filter', "<i class='glyphicon glyphicon-filter'> filter</i>");
        $item_icon->addOption('briefcase', "<i class='glyphicon glyphicon-briefcase'> briefcase</i>");
        $item_icon->addOption('fullscreen', "<i class='glyphicon glyphicon-fullscreen'> fullscreen</i>");
        $item_icon->addOption('dashboard', "<i class='glyphicon glyphicon-dashboard'> dashboard</i>");
        $item_icon->addOption('paperclip', "<i class='glyphicon glyphicon-paperclip'> paperclip</i>");
        $item_icon->addOption('heart-empty', "<i class='glyphicon glyphicon-heart-empty'> heart-empty</i>");
        $item_icon->addOption('phone', "<i class='glyphicon glyphicon-phone'> phone</i>");
        $item_icon->addOption('pushpin', "<i class='glyphicon glyphicon-pushpin'> pushpin</i>");
        $item_icon->addOption('flash', "<i class='glyphicon glyphicon-flash'> flash</i>");
        $item_icon->addOption('record', "<i class='glyphicon glyphicon-record'> record</i>");
        $item_icon->addOption('send', "<i class='glyphicon glyphicon-send'> send</i>");
        $item_icon->addOption('credit-card', "<i class='glyphicon glyphicon-credit-card'> credit-card</i>");
        $item_icon->addOption('transfer', "<i class='glyphicon glyphicon-transfer'> transfer</i>");
        $item_icon->addOption('cutlery', "<i class='glyphicon glyphicon-cutlery'> cutlery</i>");
        $item_icon->addOption('earphone', "<i class='glyphicon glyphicon-earphone'> earphone</i>");
        $item_icon->addOption('phone-alt', "<i class='glyphicon glyphicon-phone-alt'> phone-alt</i>");
        $item_icon->addOption('tower', "<i class='glyphicon glyphicon-tower'> tower</i>");
        $item_icon->addOption('stats', "<i class='glyphicon glyphicon-stats'> stats</i>");
        $item_icon->addOption('tree-conifer', "<i class='glyphicon glyphicon-tree-conifer'> tree-conifer</i>");
        $item_icon->addOption('tree-deciduous', "<i class='glyphicon glyphicon-tree-deciduous'> tree-deciduous</i>");
        $item_icon->addOption('cd', "<i class='glyphicon glyphicon-cd'> cd</i>");
        $item_icon->addOption('equalizer', "<i class='glyphicon glyphicon-equalizer'> equalizer</i>");
        $item_icon->addOption('king', "<i class='glyphicon glyphicon-king'> king</i>");
        $item_icon->addOption('queen', "<i class='glyphicon glyphicon-queen'> queen</i>");
        $item_icon->addOption('pawn', "<i class='glyphicon glyphicon-pawn'> pawn</i>");
        $item_icon->addOption('bishop', "<i class='glyphicon glyphicon-bishop'> bishop</i>");
        $item_icon->addOption('knight', "<i class='glyphicon glyphicon-knight'> knight</i>");
        $item_icon->addOption('baby-formula', "<i class='glyphicon glyphicon-baby-formula'> baby-formula</i>");
        $item_icon->addOption('tent', "<i class='glyphicon glyphicon-tent'> tent</i>");
        $item_icon->addOption('blackboard', "<i class='glyphicon glyphicon-blackboard'> blackboard</i>");
        $item_icon->addOption('bed', "<i class='glyphicon glyphicon-bed'> bed</i>");
        $item_icon->addOption('apple', "<i class='glyphicon glyphicon-apple'> apple</i>");
        $item_icon->addOption('erase', "<i class='glyphicon glyphicon-erase'> erase</i>");
        $item_icon->addOption('hourglass', "<i class='glyphicon glyphicon-hourglass'> hourglass</i>");
        $item_icon->addOption('lamp', "<i class='glyphicon glyphicon-lamp'> lamp</i>");
        $item_icon->addOption('piggy-bank', "<i class='glyphicon glyphicon-piggy-bank'> piggy-bank</i>");
        $item_icon->addOption('scissors', "<i class='glyphicon glyphicon-scissors'> scissors</i>");
        $item_icon->addOption('scale', "<i class='glyphicon glyphicon-scale'> scale</i>");
        $item_icon->addOption('ice-lolly', "<i class='glyphicon glyphicon-ice-lolly'> ice-lolly</i>");
        $item_icon->addOption('ice-lolly-tasted', "<i class='glyphicon glyphicon-ice-lolly-tasted'> ice-lolly-tasted</i>");
        $item_icon->addOption('education', "<i class='glyphicon glyphicon-education'> education</i>");
        $item_icon->addOption('menu-hamburger', "<i class='glyphicon glyphicon-menu-hamburger'> menu-hamburger</i>");
        $item_icon->addOption('modal-window', "<i class='glyphicon glyphicon-modal-window'> modal-window</i>");
        $item_icon->addOption('oil', "<i class='glyphicon glyphicon-oil'> oil</i>");
        $item_icon->addOption('grain', "<i class='glyphicon glyphicon-grain'> grain</i>");
        $item_icon->addOption('sunglasses', "<i class='glyphicon glyphicon-sunglasses'> sunglasses</i>");
        $item_icon->addOption('triangle-right', "<i class='glyphicon glyphicon-triangle-right'> triangle-right</i>");
        $item_icon->addOption('triangle-left', "<i class='glyphicon glyphicon-triangle-left'> triangle-left</i>");
        $item_icon->addOption('triangle-bottom', "<i class='glyphicon glyphicon-triangle-bottom'> triangle-bottom</i>");
        $item_icon->addOption('triangle-top', "<i class='glyphicon glyphicon-triangle-top'> triangle-top</i>");
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
        return $item_icon;
    }
    
    /**
     * Returns an form radio with all glyphicons
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
