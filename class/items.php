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
		$this->initVar('item_weight', XOBJ_DTYPE_INT);
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
	 */
	public function getFormItems($action = false)
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
		$itemImage = $getItemImage ? $getItemImage : 'blank.gif';
		$imageDirectory = '/uploads/wgtimelines/images/items';
		$imageTray = new XoopsFormElementTray(_OPTIONS, '<br />' );
		$imageSelect = new XoopsFormSelect( sprintf(_AM_WGTIMELINES_FORM_IMAGE_PATH, ".{$imageDirectory}/"), 'item_image', $itemImage, 5);
		$imageArray = XoopsLists::getImgListAsArray( XOOPS_ROOT_PATH . $imageDirectory );
		foreach($imageArray as $image1) {
			$imageSelect->addOption("{$image1}", $image1);
		}
		$imageSelect->setExtra("onchange='showImgSelected(\"image1\", \"item_image\", \"".$imageDirectory."\", \"\", \"".XOOPS_URL."\")'");
		$imageTray->addElement($imageSelect, false);
		$imageTray->addElement(new XoopsFormLabel('', "<br /><img src='".XOOPS_URL."/".$imageDirectory."/".$itemImage."' name='image1' id='image1' alt='' style='max-width:100px' />"));
		// Form File
		$fileSelectTray = new XoopsFormElementTray('', '<br />' );
		$fileSelectTray->addElement(new XoopsFormFile( _AM_WGTIMELINES_FORM_UPLOAD_IMAGE_ITEMS, 'attachedfile', $wgtimelines->getConfig('maxsize') ));
		$fileSelectTray->addElement(new XoopsFormLabel(''));
		$imageTray->addElement($fileSelectTray);
		$form->addElement($imageTray);
		// Form Text Date Select
		$itemDate = $this->isNew() ? 0 : $this->getVar('item_date');
		$form->addElement(new XoopsFormTextDateSelect( _AM_WGTIMELINES_ITEM_DATE, 'item_date', '', $this->getVar('item_date') ));
		// Form Text ItemYear
        if ( $this->isNew() ) {
            $itemYear = formatTimestamp(time(), 'Y');
        } else {
            $itemYear = $this->getVar('item_year');
        }
		$form->addElement(new XoopsFormText( _AM_WGTIMELINES_ITEM_YEAR, 'item_year', 50, 255, $itemYear ));
		// Form Text ItemWeight
        $itemsHandler = $wgtimelines->getHandler('items');
		$itemWeight = $this->isNew() ? ($itemsHandler->getCountItems() + 1) : $this->getVar('item_weight');
        $form->addElement(new XoopsFormHidden('item_weight', $itemWeight));
		// Form Select User
		$form->addElement(new XoopsFormSelectUser( _AM_WGTIMELINES_ITEM_SUBMITTER, 'item_submitter', false, $this->getVar('item_submitter') ));
		// Form Text Date Select
		$itemDate_create = $this->isNew() ? 0 : $this->getVar('item_date_create');
		$form->addElement(new XoopsFormTextDateSelect( _AM_WGTIMELINES_ITEM_DATE_CREATE, 'item_date_create', '', $itemDate_create ));
		// To Save
		$form->addElement(new XoopsFormHidden('op', 'save'));
		$form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
		return $form;
	}

	/**
	 * Get Values
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
		$ret['content'] = strip_tags($this->getVar('item_content', 'n'));
        $ret['content_admin'] = $this->getVar('item_content', 'e');
		$ret['image'] = $this->getVar('item_image');
        if ($this->getVar('item_date') > 0) {
            $ret['date'] = formatTimeStamp($this->getVar('item_date'), 's');
        }
		$ret['year'] = $this->getVar('item_year');
		$ret['weight'] = $this->getVar('item_weight');
		$ret['submitter'] = XoopsUser::getUnameFromId($this->getVar('item_submitter'));
		$ret['date_create'] = formatTimeStamp($this->getVar('item_date_create'), 's');
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
		$vars = $this->getVars();
		foreach(array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
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
	 * @param int $i field id
	 * @return mixed reference to the {@link Get} object
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
	 */
	public function getCountItems($start = 0, $limit = 0, $sort = 'item_id', $order = 'ASC')
	{
		$crCountItems = new CriteriaCompo();
		$crCountItems = $this->getItemsCriteria($crCountItems, $start, $limit, $sort, $order);
		return parent::getCount($crCountItems);
	}
    
    /**
	 * Get Count Items per timeline in the database
	 */
	public function getCountItemsTl($tl_id = 0)
	{
		$crCountItems = new CriteriaCompo();
        $crCountItems->add(new Criteria('item_tl_id', $tl_id));
		return parent::getCount($crCountItems);
	}

	/**
	 * Get All Items in the database
	 */
	public function getAllItems($start = 0, $limit = 0, $sort = 'item_tl_id ASC, item_weight ASC, item_id', $order = 'ASC')
	{
		$crAllItems = new CriteriaCompo();
		$crAllItems = $this->getItemsCriteria($crAllItems, $start, $limit, $sort, $order);
		return parent::getAll($crAllItems);
	}

	/**
	 * Get Criteria Items
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
