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
defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object WgtimelinesItems
 */
class WgtimelinesItems extends XoopsObject
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
		$this->initVar('item_year', XOBJ_DTYPE_INT);
		$this->initVar('item_icon', XOBJ_DTYPE_TXTBOX);
		$this->initVar('item_weight', XOBJ_DTYPE_INT);
		$this->initVar('item_online', XOBJ_DTYPE_INT);
		$this->initVar('item_reads', XOBJ_DTYPE_INT);
		$this->initVar('item_submitter', XOBJ_DTYPE_INT);
		$this->initVar('item_date_create', XOBJ_DTYPE_INT);
	}

	/**
	 * @static function &getInstance
	 *
	 * @param null
	 */
	public static function getInstance()
	{
		static $instance = false;
		if(!$instance) {
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
     * @return XoopsThemeForm
     */
	public function getFormItems($action = false, $ui = 'admin')
	{
		$wgtimelines = WgtimelinesHelper::getInstance();
		if($action === false) {
			$action = $_SERVER['REQUEST_URI'];
		}
		// Title
		$title = $this->isNew() ? sprintf(_AM_WGTIMELINES_ITEM_ADD) : sprintf(_AM_WGTIMELINES_ITEM_EDIT);
		// Get Theme Form
		xoops_load('XoopsFormLoader');
		$form = new XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Table Items
		$timelinesHandler = $wgtimelines->getHandler('timelines');
		$itemTl_idSelect = new XoopsFormSelect( _AM_WGTIMELINES_ITEM_TL_ID, 'item_tl_id', $this->getVar('item_tl_id'));
		$itemTl_idSelect->addOption(0, _AM_WGTIMELINES_ITEM_NONE);
		$itemTl_idSelect->addOptionArray($timelinesHandler->getList());
		$form->addElement($itemTl_idSelect, true);
		// Form Text ItemTitle
		$form->addElement(new XoopsFormText( _AM_WGTIMELINES_ITEM_TITLE, 'item_title', 50, 255, $this->getVar('item_title') ));
		// Form editor ItemContent
		$editorConfigs = array();
		$editorConfigs['name'] = 'item_content';
		$editorConfigs['value'] = $this->getVar('item_content', 'e');
		$editorConfigs['rows'] = 5;
		$editorConfigs['cols'] = 40;
		$editorConfigs['width'] = '100%';
		$editorConfigs['height'] = '400px';
		$editorConfigs['editor'] = $wgtimelines->getConfig('wgtimelines_editor');
		$form->addElement(new XoopsFormEditor( _AM_WGTIMELINES_ITEM_CONTENT, 'item_content', $editorConfigs), true);
		// Form Upload Image
		$getItemImage = $this->getVar('item_image');
		$itemImage = $getItemImage ?: 'blank.gif';
		$imageDirectory = '/uploads/wgtimelines/images/items';
		$imageTray = new XoopsFormElementTray(_AM_WGTIMELINES_ITEM_IMAGE, '<br />' );
		$imageSelect = new XoopsFormSelect( sprintf(_AM_WGTIMELINES_FORM_IMAGE_PATH, ".{$imageDirectory}/"), 'item_image', $itemImage, 5);
		$imageArray = XoopsLists::getImgListAsArray( XOOPS_ROOT_PATH . $imageDirectory );
		foreach($imageArray as $image1) {
			$imageSelect->addOption("{$image1}", $image1);
		}
		$imageSelect->setExtra("onchange='showImgSelected(\"image1\", \"item_image\", \"".$imageDirectory."\", \"\", \"".XOOPS_URL."\")'");
		$imageTray->addElement($imageSelect, false);
		$imageTray->addElement(new XoopsFormLabel('', "<br /><img src='".XOOPS_URL . '/' . $imageDirectory . '/' . $itemImage . "' name='image1' id='image1' alt='' style='max-width:100px;' />"));
		// Form File
		$fileSelectTray = new XoopsFormElementTray('', '<br />' );
		$fileSelectTray->addElement(new XoopsFormFile( _AM_WGTIMELINES_FORM_UPLOAD_IMAGE, 'attachedfile', $wgtimelines->getConfig('maxsize') ));
		$fileSelectTray->addElement(new XoopsFormLabel(''));
		$imageTray->addElement($fileSelectTray);
		$form->addElement($imageTray);
		// Form Text Date Select
		$itemDate = $this->isNew() ? 0 : $this->getVar('item_date');
		$form->addElement(new XoopsFormTextDateSelect( _AM_WGTIMELINES_ITEM_DATE, 'item_date', '', $itemDate));
		// Form Text ItemYear
        if ( $this->isNew() ) {
            $itemYear = formatTimestamp(time(), 'Y');
        } else {
            $itemYear = $this->getVar('item_year');
        }
		$form->addElement(new XoopsFormText( _AM_WGTIMELINES_ITEM_YEAR . "<br><span class='font-size:70%'> " . _AM_WGTIMELINES_ITEM_YEAR_ICON_DESC . "</span>", 'item_year', 20, 255, $itemYear ));
		
		$item_icon = $this->isNew() ? 'none' : $this->getVar('item_icon');
        $item_icon = new XoopsFormRadio( _AM_WGTIMELINES_ITEM_ICON . "<br><span class='font-size:70%'> " . _AM_WGTIMELINES_ITEM_YEAR_ICON_DESC . "</span>", 'item_icon', $item_icon);
        $item_icon->addOption('none', _AM_WGTIMELINES_ITEM_NONE . '<br>');
		$this->addGlyphicons($item_icon);
        $form->addElement($item_icon);
		
		// Form Text ItemWeight
        $itemsHandler = $wgtimelines->getHandler('items');
		$itemWeight = $this->isNew() ? ($itemsHandler->getCountItems() + 1) : $this->getVar('item_weight');
        $form->addElement(new XoopsFormHidden('item_weight', $itemWeight));
		// Form Text ItemReads
		$itemReads = $this->isNew() ? 0 : $this->getVar('item_reads');
		$form->addElement(new XoopsFormText( _AM_WGTIMELINES_ITEM_READS, 'item_reads', 20, 255, $itemReads ));
		// Form Radio Yes/No
		$itemOnline = $this->isNew() ? 0 : $this->getVar('item_online');
		$form->addElement(new XoopsFormRadioYN( _AM_WGTIMELINES_ONLINE, 'item_online', $itemOnline));
		// Form Select User
		$form->addElement(new XoopsFormSelectUser( _AM_WGTIMELINES_SUBMITTER, 'item_submitter', false, $this->getVar('item_submitter') ));
		// Form Text Date Select
		$itemDate_create = $this->isNew() ? 0 : $this->getVar('item_date_create');
		$form->addElement(new XoopsFormTextDateSelect( _AM_WGTIMELINES_DATE_CREATE, 'item_date_create', '', $itemDate_create ));
		// To Save
		$form->addElement(new XoopsFormHidden('op', 'save'));
        $form->addElement(new XoopsFormHidden('ui', $ui));
		$form->addElement(new XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));
		return $form;
	}

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
	public function getValuesItems($keys = null, $format = null, $maxDepth = null)
	{
		$wgtimelines = WgtimelinesHelper::getInstance();
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id'] = $this->getVar('item_id');
        $ret['tl_id'] = $this->getVar('item_tl_id');
        $timelines = $wgtimelines->getHandler('timelines');
		$timeline_obj = $timelines->get($this->getVar('item_tl_id'));
		$ret['tl_name'] = $timeline_obj->getVar('tl_name');
		$ret['title'] = $this->getVar('item_title');
		$ret['content'] = $this->getVar('item_content', 'n');
		$content = $this->getVar('item_content', 'n');
		$tl_limit = $timeline_obj->getVar('tl_limit');
		$ret['tl_limit'] = $tl_limit;
		$ret['content_admin'] = $wgtimelines->truncateHtml($content);
		if ($tl_limit > 0 && strlen(strip_tags($content)) > $tl_limit) {
			$ret['content_summary'] = $wgtimelines->truncateHtml($content, $timeline_obj->getVar('tl_limit'));
			$ret['content_admin'] = $wgtimelines->truncateHtml($content, $timeline_obj->getVar('tl_limit'));
		}
		$ret['image'] = $this->getVar('item_image');
        if ($this->getVar('item_date') > 0) $ret['date'] = formatTimestamp($this->getVar('item_date'), 's');
        if ($this->getVar('item_year') > 0) $ret['year'] = $this->getVar('item_year');
		$ret['icon'] = $this->getVar('item_icon');
		$ret['weight'] = $this->getVar('item_weight');
		$ret['reads'] = $this->getVar('item_reads');
		$ret['online'] = $this->getVar('item_online');
		$ret['submitter'] = XoopsUser::getUnameFromId($this->getVar('item_submitter'));
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
		foreach(array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}
	
	/**
	 * Returns an form radio with all glyphicons
	 *
	 * @return array
	 */
	public function addGlyphicons($item_icon)
	{
		$item_icon->addOption('asterisk', "<i class='glyphicon glyphicon-asterisk'></i> asterisk ");
		$item_icon->addOption('plus', "<i class='glyphicon glyphicon-plus'></i> plus  ");
		$item_icon->addOption('eur', "<i class='glyphicon glyphicon-eur'></i> eur ");
		$item_icon->addOption('minus', "<i class='glyphicon glyphicon-minus'></i> minus ");
		$item_icon->addOption('cloud', "<i class='glyphicon glyphicon-cloud'></i> cloud ");
		$item_icon->addOption('envelope', "<i class='glyphicon glyphicon-envelope'></i> envelope ");
		$item_icon->addOption('pencil', "<i class='glyphicon glyphicon-pencil'></i> pencil ");
		$item_icon->addOption('glass', "<i class='glyphicon glyphicon-glass'></i> glass ");
		$item_icon->addOption('music', "<i class='glyphicon glyphicon-music'></i> music ");
		$item_icon->addOption('search', "<i class='glyphicon glyphicon-search'></i> search ");
		$item_icon->addOption('heart', "<i class='glyphicon glyphicon-heart'></i> heart <br>");
		$item_icon->addOption('star', "<i class='glyphicon glyphicon-star'></i> star ");
		$item_icon->addOption('star-empty', "<i class='glyphicon glyphicon-star-empty'></i> star-empty ");
		$item_icon->addOption('user', "<i class='glyphicon glyphicon-user'></i> user ");
		$item_icon->addOption('film', "<i class='glyphicon glyphicon-film'></i> film ");
		$item_icon->addOption('ok', "<i class='glyphicon glyphicon-ok'></i> ok ");
		$item_icon->addOption('remove', "<i class='glyphicon glyphicon-remove'></i> remove ");
		$item_icon->addOption('off', "<i class='glyphicon glyphicon-off'></i> off ");
		$item_icon->addOption('signal', "<i class='glyphicon glyphicon-signal'></i> signal ");
		$item_icon->addOption('cog', "<i class='glyphicon glyphicon-cog'></i> cog ");
		$item_icon->addOption('trash', "<i class='glyphicon glyphicon-trash'></i> trash <br>");
		$item_icon->addOption('home', "<i class='glyphicon glyphicon-home'></i> home ");
		$item_icon->addOption('time', "<i class='glyphicon glyphicon-time'></i> time ");
		$item_icon->addOption('road', "<i class='glyphicon glyphicon-road'></i> road ");
		$item_icon->addOption('download', "<i class='glyphicon glyphicon-download'></i> download ");
		$item_icon->addOption('upload', "<i class='glyphicon glyphicon-upload'></i> upload ");
		$item_icon->addOption('inbox', "<i class='glyphicon glyphicon-inbox'></i> inbox ");
		$item_icon->addOption('list-alt', "<i class='glyphicon glyphicon-list-alt'></i> list-alt ");
		$item_icon->addOption('lock', "<i class='glyphicon glyphicon-lock'></i> lock ");
		$item_icon->addOption('flag', "<i class='glyphicon glyphicon-flag'></i> flag ");
		$item_icon->addOption('headphones', "<i class='glyphicon glyphicon-headphones'></i> headphones <br>");
		$item_icon->addOption('tag', "<i class='glyphicon glyphicon-tag'></i> tag ");
		$item_icon->addOption('tags', "<i class='glyphicon glyphicon-tags'></i> tags ");
		$item_icon->addOption('book', "<i class='glyphicon glyphicon-book'></i> book ");
		$item_icon->addOption('bookmark', "<i class='glyphicon glyphicon-bookmark'></i> bookmark ");
		$item_icon->addOption('camera', "<i class='glyphicon glyphicon-camera'></i> camera ");
		$item_icon->addOption('facetime-video', "<i class='glyphicon glyphicon-facetime-video'></i> facetime-video ");
		$item_icon->addOption('picture', "<i class='glyphicon glyphicon-picture'></i> picture ");
		$item_icon->addOption('map-marker', "<i class='glyphicon glyphicon-map-marker'></i> map-marker ");
		$item_icon->addOption('adjust', "<i class='glyphicon glyphicon-adjust'></i> adjust ");
		$item_icon->addOption('tint', "<i class='glyphicon glyphicon-tint'></i> tint <br>");
		$item_icon->addOption('move', "<i class='glyphicon glyphicon-move'></i> move ");
		$item_icon->addOption('backward', "<i class='glyphicon glyphicon-backward'></i> backward ");
		$item_icon->addOption('play', "<i class='glyphicon glyphicon-play'></i> play ");
		$item_icon->addOption('pause', "<i class='glyphicon glyphicon-pause'></i> pause ");
		$item_icon->addOption('forward', "<i class='glyphicon glyphicon-forward'></i> forward ");
		$item_icon->addOption('plus-sign', "<i class='glyphicon glyphicon-plus-sign'></i> plus-sign ");
		$item_icon->addOption('minus-sign', "<i class='glyphicon glyphicon-minus-sign'></i> minus-sign ");
		$item_icon->addOption('remove-sign', "<i class='glyphicon glyphicon-remove-sign'></i> remove-sign ");
		$item_icon->addOption('ok-sign', "<i class='glyphicon glyphicon-ok-sign'></i> ok-sign ");
		$item_icon->addOption('question-sign', "<i class='glyphicon glyphicon-question-sign'></i> question-sign <br>");
		$item_icon->addOption('info-sign', "<i class='glyphicon glyphicon-info-sign'></i> info-sign ");
		$item_icon->addOption('screenshot', "<i class='glyphicon glyphicon-screenshot'></i> screenshot ");
		$item_icon->addOption('exclamation-sign', "<i class='glyphicon glyphicon-exclamation-sign'></i> exclamation-sign ");
		$item_icon->addOption('gift', "<i class='glyphicon glyphicon-gift'></i> gift ");
		$item_icon->addOption('leaf', "<i class='glyphicon glyphicon-leaf'></i> leaf ");
		$item_icon->addOption('fire', "<i class='glyphicon glyphicon-fire'></i> fire ");
		$item_icon->addOption('eye-open', "<i class='glyphicon glyphicon-eye-open'></i> eye-open ");
		$item_icon->addOption('eye-close', "<i class='glyphicon glyphicon-eye-close'></i> eye-close ");
		$item_icon->addOption('warning-sign', "<i class='glyphicon glyphicon-warning-sign'></i> warning-sign ");
		$item_icon->addOption('plane', "<i class='glyphicon glyphicon-plane'></i> plane <br>");
		$item_icon->addOption('calendar', "<i class='glyphicon glyphicon-calendar'></i> calendar ");
		$item_icon->addOption('random', "<i class='glyphicon glyphicon-random'></i> random ");
		$item_icon->addOption('comment', "<i class='glyphicon glyphicon-comment'></i> comment ");
		$item_icon->addOption('magnet', "<i class='glyphicon glyphicon-magnet'></i> magnet ");
		$item_icon->addOption('shopping-cart', "<i class='glyphicon glyphicon-shopping-cart'></i> shopping-cart ");
		$item_icon->addOption('bullhorn', "<i class='glyphicon glyphicon-bullhorn'></i> bullhorn ");
		$item_icon->addOption('bell', "<i class='glyphicon glyphicon-bell'></i> bell ");
		$item_icon->addOption('certificate', "<i class='glyphicon glyphicon-certificate'></i> certificate ");
		$item_icon->addOption('thumbs-up', "<i class='glyphicon glyphicon-thumbs-up'></i> thumbs-up ");
		$item_icon->addOption('thumbs-down', "<i class='glyphicon glyphicon-thumbs-down'></i> thumbs-down <br>");
		$item_icon->addOption('hand-right', "<i class='glyphicon glyphicon-hand-right'></i> hand-right ");
		$item_icon->addOption('hand-left', "<i class='glyphicon glyphicon-hand-left'></i> hand-left ");
		$item_icon->addOption('hand-up', "<i class='glyphicon glyphicon-hand-up'></i> hand-up ");
		$item_icon->addOption('hand-down', "<i class='glyphicon glyphicon-hand-down'></i> hand-down ");
		$item_icon->addOption('globe', "<i class='glyphicon glyphicon-globe'></i> globe ");
		$item_icon->addOption('filter', "<i class='glyphicon glyphicon-filter'></i> filter ");
		$item_icon->addOption('briefcase', "<i class='glyphicon glyphicon-briefcase'></i> briefcase ");
		$item_icon->addOption('fullscreen', "<i class='glyphicon glyphicon-fullscreen'></i> fullscreen ");
		$item_icon->addOption('dashboard', "<i class='glyphicon glyphicon-dashboard'></i> dashboard ");
		$item_icon->addOption('paperclip', "<i class='glyphicon glyphicon-paperclip'></i> paperclip <br>");
		$item_icon->addOption('heart-empty', "<i class='glyphicon glyphicon-heart-empty'></i> heart-empty ");
		$item_icon->addOption('phone', "<i class='glyphicon glyphicon-phone'></i> phone ");
		$item_icon->addOption('pushpin', "<i class='glyphicon glyphicon-pushpin'></i> pushpin ");
		$item_icon->addOption('flash', "<i class='glyphicon glyphicon-flash'></i> flash ");
		$item_icon->addOption('record', "<i class='glyphicon glyphicon-record'></i> record ");
		$item_icon->addOption('send', "<i class='glyphicon glyphicon-send'></i> send ");
		$item_icon->addOption('credit-card', "<i class='glyphicon glyphicon-credit-card'></i> credit-card ");
		$item_icon->addOption('transfer', "<i class='glyphicon glyphicon-transfer'></i> transfer ");
		$item_icon->addOption('cutlery', "<i class='glyphicon glyphicon-cutlery'></i> cutlery ");
		$item_icon->addOption('earphone', "<i class='glyphicon glyphicon-earphone'></i> earphone <br>");
		$item_icon->addOption('phone-alt', "<i class='glyphicon glyphicon-phone-alt'></i> phone-alt ");
		$item_icon->addOption('tower', "<i class='glyphicon glyphicon-tower'></i> tower ");
		$item_icon->addOption('stats', "<i class='glyphicon glyphicon-stats'></i> stats ");
		$item_icon->addOption('tree-conifer', "<i class='glyphicon glyphicon-tree-conifer'></i> tree-conifer ");
		$item_icon->addOption('tree-deciduous', "<i class='glyphicon glyphicon-tree-deciduous'></i> tree-deciduous ");
		$item_icon->addOption('cd', "<i class='glyphicon glyphicon-cd'></i> cd ");
		$item_icon->addOption('equalizer', "<i class='glyphicon glyphicon-equalizer'></i> equalizer ");
		$item_icon->addOption('king', "<i class='glyphicon glyphicon-king'></i> king ");
		$item_icon->addOption('queen', "<i class='glyphicon glyphicon-queen'></i> queen ");
		$item_icon->addOption('pawn', "<i class='glyphicon glyphicon-pawn'></i> pawn <br>");
		$item_icon->addOption('bishop', "<i class='glyphicon glyphicon-bishop'></i> bishop ");
		$item_icon->addOption('knight', "<i class='glyphicon glyphicon-knight'></i> knight ");
		$item_icon->addOption('baby-formula', "<i class='glyphicon glyphicon-baby-formula'></i> baby-formula ");
		$item_icon->addOption('tent', "<i class='glyphicon glyphicon-tent'></i> tent ");
		$item_icon->addOption('blackboard', "<i class='glyphicon glyphicon-blackboard'></i> blackboard ");
		$item_icon->addOption('bed', "<i class='glyphicon glyphicon-bed'></i> bed ");
		$item_icon->addOption('apple', "<i class='glyphicon glyphicon-apple'></i> apple ");
		$item_icon->addOption('erase', "<i class='glyphicon glyphicon-erase'></i> erase ");
		$item_icon->addOption('hourglass', "<i class='glyphicon glyphicon-hourglass'></i> hourglass ");
		$item_icon->addOption('lamp', "<i class='glyphicon glyphicon-lamp'></i> lamp <br>");
		$item_icon->addOption('piggy-bank', "<i class='glyphicon glyphicon-piggy-bank'></i> piggy-bank ");
		$item_icon->addOption('scissors', "<i class='glyphicon glyphicon-scissors'></i> scissors ");
		$item_icon->addOption('scale', "<i class='glyphicon glyphicon-scale'></i> scale ");
		$item_icon->addOption('ice-lolly', "<i class='glyphicon glyphicon-ice-lolly'></i> ice-lolly ");
		$item_icon->addOption('ice-lolly-tasted', "<i class='glyphicon glyphicon-ice-lolly-tasted'></i> ice-lolly-tasted ");
		$item_icon->addOption('education', "<i class='glyphicon glyphicon-education'></i> education ");
		$item_icon->addOption('menu-hamburger', "<i class='glyphicon glyphicon-menu-hamburger'></i> menu-hamburger ");
		$item_icon->addOption('modal-window', "<i class='glyphicon glyphicon-modal-window'></i> modal-window ");
		$item_icon->addOption('oil', "<i class='glyphicon glyphicon-oil'></i> oil ");
		$item_icon->addOption('grain', "<i class='glyphicon glyphicon-grain'></i> grain <br>");
		$item_icon->addOption('sunglasses', "<i class='glyphicon glyphicon-sunglasses'></i> sunglasses ");
		$item_icon->addOption('triangle-right', "<i class='glyphicon glyphicon-triangle-right'></i> triangle-right ");
		$item_icon->addOption('triangle-left', "<i class='glyphicon glyphicon-triangle-left'></i> triangle-left ");
		$item_icon->addOption('triangle-bottom', "<i class='glyphicon glyphicon-triangle-bottom'></i> triangle-bottom ");
		$item_icon->addOption('triangle-top', "<i class='glyphicon glyphicon-triangle-top'></i> triangle-top ");
		// $item_icon->addOption('euro', "<i class='glyphicon glyphicon-euro'></i> euro ");
		// $item_icon->addOption('th-large', "<i class='glyphicon glyphicon-th-large'></i> th-large ");
		// $item_icon->addOption('th', "<i class='glyphicon glyphicon-th'></i> th ");
		// $item_icon->addOption('th-list', "<i class='glyphicon glyphicon-th-list'></i> th-list ");
		// $item_icon->addOption('zoom-in', "<i class='glyphicon glyphicon-zoom-in'></i> zoom-in ");
		// $item_icon->addOption('zoom-out', "<i class='glyphicon glyphicon-zoom-out'></i> zoom-out ");
		// $item_icon->addOption('file', "<i class='glyphicon glyphicon-file'></i> file ");
		// $item_icon->addOption('download-alt', "<i class='glyphicon glyphicon-download-alt'></i> download-alt ");
		// $item_icon->addOption('play-circle', "<i class='glyphicon glyphicon-play-circle'></i> play-circle ");
		// $item_icon->addOption('repeat', "<i class='glyphicon glyphicon-repeat'></i> repeat ");
		// $item_icon->addOption('refresh', "<i class='glyphicon glyphicon-refresh'></i> refresh ");
		// $item_icon->addOption('volume-off', "<i class='glyphicon glyphicon-volume-off'></i> volume-off ");
		// $item_icon->addOption('volume-down', "<i class='glyphicon glyphicon-volume-down'></i> volume-down ");
		// $item_icon->addOption('volume-up', "<i class='glyphicon glyphicon-volume-up'></i> volume-up ");
		// $item_icon->addOption('qrcode', "<i class='glyphicon glyphicon-qrcode'></i> qrcode ");
		// $item_icon->addOption('barcode', "<i class='glyphicon glyphicon-barcode'></i> barcode ");
		// $item_icon->addOption('print', "<i class='glyphicon glyphicon-print'></i> print ");
		// $item_icon->addOption('font', "<i class='glyphicon glyphicon-font'></i> font ");
		// $item_icon->addOption('bold', "<i class='glyphicon glyphicon-bold'></i> bold ");
		// $item_icon->addOption('italic', "<i class='glyphicon glyphicon-italic'></i> italic ");
		// $item_icon->addOption('text-height', "<i class='glyphicon glyphicon-text-height'></i> text-height ");
		// $item_icon->addOption('text-width', "<i class='glyphicon glyphicon-text-width'></i> text-width ");
		// $item_icon->addOption('align-left', "<i class='glyphicon glyphicon-align-left'></i> align-left ");
		// $item_icon->addOption('align-center', "<i class='glyphicon glyphicon-align-center'></i> align-center ");
		// $item_icon->addOption('align-right', "<i class='glyphicon glyphicon-align-right'></i> align-right ");
		// $item_icon->addOption('align-justify', "<i class='glyphicon glyphicon-align-justify'></i> align-justify ");
		// $item_icon->addOption('list', "<i class='glyphicon glyphicon-list'></i> list ");
		// $item_icon->addOption('indent-left', "<i class='glyphicon glyphicon-indent-left'></i> indent-left ");
		// $item_icon->addOption('indent-right', "<i class='glyphicon glyphicon-indent-right'></i> indent-right ");
		// $item_icon->addOption('edit', "<i class='glyphicon glyphicon-edit'></i> edit ");
		// $item_icon->addOption('share', "<i class='glyphicon glyphicon-share'></i> share ");
		// $item_icon->addOption('check', "<i class='glyphicon glyphicon-check'></i> check ");
		// $item_icon->addOption('step-backward', "<i class='glyphicon glyphicon-step-backward'></i> step-backward ");
		// $item_icon->addOption('fast-backward', "<i class='glyphicon glyphicon-fast-backward'></i> fast-backward ");
		// $item_icon->addOption('stop', "<i class='glyphicon glyphicon-stop'></i> stop ");
		// $item_icon->addOption('fast-forward', "<i class='glyphicon glyphicon-fast-forward'></i> fast-forward ");
		// $item_icon->addOption('step-forward', "<i class='glyphicon glyphicon-step-forward'></i> step-forward ");
		// $item_icon->addOption('eject', "<i class='glyphicon glyphicon-eject'></i> eject ");
		// $item_icon->addOption('chevron-left', "<i class='glyphicon glyphicon-chevron-left'></i> chevron-left ");
		// $item_icon->addOption('chevron-right', "<i class='glyphicon glyphicon-chevron-right'></i> chevron-right ");
		// $item_icon->addOption('remove-circle', "<i class='glyphicon glyphicon-remove-circle'></i> remove-circle ");
		// $item_icon->addOption('ok-circle', "<i class='glyphicon glyphicon-ok-circle'></i> ok-circle ");
		// $item_icon->addOption('ban-circle', "<i class='glyphicon glyphicon-ban-circle'></i> ban-circle ");
		// $item_icon->addOption('arrow-left', "<i class='glyphicon glyphicon-arrow-left'></i> arrow-left ");
		// $item_icon->addOption('arrow-right', "<i class='glyphicon glyphicon-arrow-right'></i> arrow-right ");
		// $item_icon->addOption('arrow-up', "<i class='glyphicon glyphicon-arrow-up'></i> arrow-up ");
		// $item_icon->addOption('arrow-down', "<i class='glyphicon glyphicon-arrow-down'></i> arrow-down ");
		// $item_icon->addOption('share-alt', "<i class='glyphicon glyphicon-share-alt'></i> share-alt ");
		// $item_icon->addOption('resize-full', "<i class='glyphicon glyphicon-resize-full'></i> resize-full ");
		// $item_icon->addOption('resize-small', "<i class='glyphicon glyphicon-resize-small'></i> resize-small ");
		// $item_icon->addOption('chevron-up', "<i class='glyphicon glyphicon-chevron-up'></i> chevron-up ");
		// $item_icon->addOption('chevron-down', "<i class='glyphicon glyphicon-chevron-down'></i> chevron-down ");
		// $item_icon->addOption('retweet', "<i class='glyphicon glyphicon-retweet'></i> retweet ");
		// $item_icon->addOption('folder-close', "<i class='glyphicon glyphicon-folder-close'></i> folder-close ");
		// $item_icon->addOption('folder-open', "<i class='glyphicon glyphicon-folder-open'></i> folder-open ");
		// $item_icon->addOption('resize-vertical', "<i class='glyphicon glyphicon-resize-vertical'></i> resize-vertical ");
		// $item_icon->addOption('resize-horizontal', "<i class='glyphicon glyphicon-resize-horizontal'></i> resize-horizontal ");
		// $item_icon->addOption('hdd', "<i class='glyphicon glyphicon-hdd'></i> hdd ");
		// $item_icon->addOption('circle-arrow-right', "<i class='glyphicon glyphicon-circle-arrow-right'></i> circle-arrow-right ");
		// $item_icon->addOption('circle-arrow-left', "<i class='glyphicon glyphicon-circle-arrow-left'></i> circle-arrow-left ");
		// $item_icon->addOption('circle-arrow-up', "<i class='glyphicon glyphicon-circle-arrow-up'></i> circle-arrow-up ");
		// $item_icon->addOption('circle-arrow-down', "<i class='glyphicon glyphicon-circle-arrow-down'></i> circle-arrow-down ");
		// $item_icon->addOption('wrench', "<i class='glyphicon glyphicon-wrench'></i> wrench ");
		// $item_icon->addOption('tasks', "<i class='glyphicon glyphicon-tasks'></i> tasks ");
		// $item_icon->addOption('link', "<i class='glyphicon glyphicon-link'></i> link ");
		// $item_icon->addOption('usd', "<i class='glyphicon glyphicon-usd'></i> usd ");
		// $item_icon->addOption('gbp', "<i class='glyphicon glyphicon-gbp'></i> gbp ");
		// $item_icon->addOption('sort', "<i class='glyphicon glyphicon-sort'></i> sort ");
		// $item_icon->addOption('sort-by-alphabet', "<i class='glyphicon glyphicon-sort-by-alphabet'></i> sort-by-alphabet ");
		// $item_icon->addOption('sort-by-alphabet-alt', "<i class='glyphicon glyphicon-sort-by-alphabet-alt'></i> sort-by-alphabet-alt ");
		// $item_icon->addOption('sort-by-order', "<i class='glyphicon glyphicon-sort-by-order'></i> sort-by-order ");
		// $item_icon->addOption('sort-by-order-alt', "<i class='glyphicon glyphicon-sort-by-order-alt'></i> sort-by-order-alt ");
		// $item_icon->addOption('sort-by-attributes', "<i class='glyphicon glyphicon-sort-by-attributes'></i> sort-by-attributes ");
		// $item_icon->addOption('sort-by-attributes-alt', "<i class='glyphicon glyphicon-sort-by-attributes-alt'></i> sort-by-attributes-alt ");
		// $item_icon->addOption('unchecked', "<i class='glyphicon glyphicon-unchecked'></i> unchecked ");
		// $item_icon->addOption('expand', "<i class='glyphicon glyphicon-expand'></i> expand ");
		// $item_icon->addOption('collapse-down', "<i class='glyphicon glyphicon-collapse-down'></i> collapse-down ");
		// $item_icon->addOption('collapse-up', "<i class='glyphicon glyphicon-collapse-up'></i> collapse-up ");
		// $item_icon->addOption('log-in', "<i class='glyphicon glyphicon-log-in'></i> log-in ");
		// $item_icon->addOption('log-out', "<i class='glyphicon glyphicon-log-out'></i> log-out ");
		// $item_icon->addOption('new-window', "<i class='glyphicon glyphicon-new-window'></i> new-window ");
		// $item_icon->addOption('save', "<i class='glyphicon glyphicon-save'></i> save ");
		// $item_icon->addOption('open', "<i class='glyphicon glyphicon-open'></i> open ");
		// $item_icon->addOption('saved', "<i class='glyphicon glyphicon-saved'></i> saved ");
		// $item_icon->addOption('import', "<i class='glyphicon glyphicon-import'></i> import ");
		// $item_icon->addOption('export', "<i class='glyphicon glyphicon-export'></i> export ");
		// $item_icon->addOption('floppy-disk', "<i class='glyphicon glyphicon-floppy-disk'></i> floppy-disk ");
		// $item_icon->addOption('floppy-saved', "<i class='glyphicon glyphicon-floppy-saved'></i> floppy-saved ");
		// $item_icon->addOption('floppy-remove', "<i class='glyphicon glyphicon-floppy-remove'></i> floppy-remove ");
		// $item_icon->addOption('floppy-save', "<i class='glyphicon glyphicon-floppy-save'></i> floppy-save ");
		// $item_icon->addOption('floppy-open', "<i class='glyphicon glyphicon-floppy-open'></i> floppy-open ");
		// $item_icon->addOption('header', "<i class='glyphicon glyphicon-header'></i> header ");
		// $item_icon->addOption('compressed', "<i class='glyphicon glyphicon-compressed'></i> compressed ");
		// $item_icon->addOption('sd-video', "<i class='glyphicon glyphicon-sd-video'></i> sd-video ");
		// $item_icon->addOption('hd-video', "<i class='glyphicon glyphicon-hd-video'></i> hd-video ");
		// $item_icon->addOption('subtitles', "<i class='glyphicon glyphicon-subtitles'></i> subtitles ");
		// $item_icon->addOption('sound-stereo', "<i class='glyphicon glyphicon-sound-stereo'></i> sound-stereo ");
		// $item_icon->addOption('sound-dolby', "<i class='glyphicon glyphicon-sound-dolby'></i> sound-dolby ");
		// $item_icon->addOption('sound-5-1', "<i class='glyphicon glyphicon-sound-5-1'></i> sound-5-1 ");
		// $item_icon->addOption('sound-6-1', "<i class='glyphicon glyphicon-sound-6-1'></i> sound-6-1 ");
		// $item_icon->addOption('sound-7-1', "<i class='glyphicon glyphicon-sound-7-1'></i> sound-7-1 ");
		// $item_icon->addOption('copyright-mark', "<i class='glyphicon glyphicon-copyright-mark'></i> copyright-mark ");
		// $item_icon->addOption('registration-mark', "<i class='glyphicon glyphicon-registration-mark'></i> registration-mark ");
		// $item_icon->addOption('cloud-download', "<i class='glyphicon glyphicon-cloud-download'></i> cloud-download ");
		// $item_icon->addOption('cloud-upload', "<i class='glyphicon glyphicon-cloud-upload'></i> cloud-upload ");
		// $item_icon->addOption('save-file', "<i class='glyphicon glyphicon-save-file'></i> save-file ");
		// $item_icon->addOption('open-file', "<i class='glyphicon glyphicon-open-file'></i> open-file ");
		// $item_icon->addOption('level-up', "<i class='glyphicon glyphicon-level-up'></i> level-up ");
		// $item_icon->addOption('copy', "<i class='glyphicon glyphicon-copy'></i> copy ");
		// $item_icon->addOption('paste', "<i class='glyphicon glyphicon-paste'></i> paste ");
		// $item_icon->addOption('alert', "<i class='glyphicon glyphicon-alert'></i> alert ");
		// $item_icon->addOption('duplicate', "<i class='glyphicon glyphicon-duplicate'></i> duplicate ");
		// $item_icon->addOption('bitcoin', "<i class='glyphicon glyphicon-bitcoin'></i> bitcoin ");
		// $item_icon->addOption('btc', "<i class='glyphicon glyphicon-btc'></i> btc ");
		// $item_icon->addOption('xbt', "<i class='glyphicon glyphicon-xbt'></i> xbt ");
		// $item_icon->addOption('yen', "<i class='glyphicon glyphicon-yen'></i> yen ");
		// $item_icon->addOption('jpy', "<i class='glyphicon glyphicon-jpy'></i> jpy ");
		// $item_icon->addOption('ruble', "<i class='glyphicon glyphicon-ruble'></i> ruble ");
		// $item_icon->addOption('rub', "<i class='glyphicon glyphicon-rub'></i> rub ");
		// $item_icon->addOption('option-horizontal', "<i class='glyphicon glyphicon-option-horizontal'></i> option-horizontal ");
		// $item_icon->addOption('option-vertical', "<i class='glyphicon glyphicon-option-vertical'></i> option-vertical ");
		// $item_icon->addOption('text-size', "<i class='glyphicon glyphicon-text-size'></i> text-size ");
		// $item_icon->addOption('text-color', "<i class='glyphicon glyphicon-text-color'></i> text-color ");
		// $item_icon->addOption('text-background', "<i class='glyphicon glyphicon-text-background'></i> text-background ");
		// $item_icon->addOption('object-align-top', "<i class='glyphicon glyphicon-object-align-top'></i> object-align-top ");
		// $item_icon->addOption('object-align-bottom', "<i class='glyphicon glyphicon-object-align-bottom'></i> object-align-bottom ");
		// $item_icon->addOption('object-align-horizontal', "<i class='glyphicon glyphicon-object-align-horizontal'></i> object-align-horizontal ");
		// $item_icon->addOption('object-align-left', "<i class='glyphicon glyphicon-object-align-left'></i> object-align-left ");
		// $item_icon->addOption('object-align-vertical', "<i class='glyphicon glyphicon-object-align-vertical'></i> object-align-vertical ");
		// $item_icon->addOption('object-align-right', "<i class='glyphicon glyphicon-object-align-right'></i> object-align-right ");
		// $item_icon->addOption('console', "<i class='glyphicon glyphicon-console'></i> console ");
		// $item_icon->addOption('superscript', "<i class='glyphicon glyphicon-superscript'></i> superscript ");
		// $item_icon->addOption('subscript', "<i class='glyphicon glyphicon-subscript'></i> subscript ");
		// $item_icon->addOption('menu-left', "<i class='glyphicon glyphicon-menu-left'></i> menu-left ");
		// $item_icon->addOption('menu-right', "<i class='glyphicon glyphicon-menu-right'></i> menu-right ");
		// $item_icon->addOption('menu-down', "<i class='glyphicon glyphicon-menu-down'></i> menu-down ");
		// $item_icon->addOption('menu-up', "<i class='glyphicon glyphicon-menu-up'></i> menu-up ");
		return $item_icon;
	}
}

/**
 * Class Object Handler WgtimelinesItems
 */
class WgtimelinesItemsHandler extends XoopsPersistableObjectHandler
{
	/**
	 * Constructor 
	 *
	 * @param null|XoopsDatabase $db
	 */
	public function __construct(XoopsDatabase $db)
	{
		parent::__construct($db, 'wgtimelines_items', 'wgtimelinesitems', 'item_id', 'item_content');
	}

	/**
	 * @param bool $isNew
	 *
	 * @return object
	 */
	public function create($isNew = true)
	{
		return parent::create($isNew);
	}

    /**
     * retrieve a field
     *
     * @param int  $i field id
     * @param null $fields
     * @return mixed reference to the <a href='psi_element://Get'>Get</a> object
     *                object
     */
	public function get($i = null, $fields = null)
	{
		return parent::get($i, $fields);
	}

	/**
	 * get inserted id
	 *
	 * @param null
	 * @return integer reference to the {@link Get} object
	 */
	public function getInsertId()
	{
		return $this->db->getInsertId();
	}

    /**
     * Get Count Items in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
	public function getCountItems($start = 0, $limit = 0, $sort = 'item_id', $order = 'ASC')
	{
		$crCountItems = new CriteriaCompo();
		$crCountItems = $this->getItemsCriteria($crCountItems, $start, $limit, $sort, $order);
		return parent::getCount($crCountItems);
	}

    /**
     * Get Count Items per timeline in the database
     * @param int $tl_id
     * @return int
     */
	public function getCountItemsTl($tl_id = 0)
	{
		$crCountItems = new CriteriaCompo();
        $crCountItems->add(new Criteria('item_tl_id', $tl_id));
		return parent::getCount($crCountItems);
	}

    /**
     * Get All Items in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
	public function getAllItems($start = 0, $limit = 0, $sort = 'item_tl_id ASC, item_weight ASC, item_id', $order = 'ASC')
	{
		$crAllItems = new CriteriaCompo();
		$crAllItems = $this->getItemsCriteria($crAllItems, $start, $limit, $sort, $order);
		return parent::getAll($crAllItems);
	}

    /**
     * Get Criteria Items
     * @param $crItems
     * @param $start
     * @param $limit
     * @param $sort
     * @param $order
     * @return
     */
	private function getItemsCriteria($crItems, $start, $limit, $sort, $order)
	{
		$crItems->setStart( $start );
		$crItems->setLimit( $limit );
		$crItems->setSort( $sort );
		$crItems->setOrder( $order );
		return $crItems;
	}
}
