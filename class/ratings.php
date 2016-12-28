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
 * @author         TDM XOOPS - Email:<info@email.com> - Website:<http://xoops.org>
 * @version        $Id: 1.0 ratings.php 13070 Wed 2016-12-14 22:22:34Z XOOPS Development Team $
 */
defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object WgtimelinesRatings
 */
class WgtimelinesRatings extends XoopsObject
{
	/**
	 * Constructor 
	 *
	 * @param null
	 */
	public function __construct()
	{
		$this->initVar('rate_id', XOBJ_DTYPE_INT);
		$this->initVar('rate_itemid', XOBJ_DTYPE_INT);
		$this->initVar('rate_value', XOBJ_DTYPE_INT);
		$this->initVar('rate_uid', XOBJ_DTYPE_INT);
		$this->initVar('rate_ip', XOBJ_DTYPE_TXTBOX);
		$this->initVar('rate_date', XOBJ_DTYPE_INT);
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
	public function getNewInsertedIdRatings()
	{
		$newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
		return $newInsertedId;
	}

	/**
	 * Get form
	 *
	 * @param mixed $action
	 */
	public function getFormRatings($action = false)
	{
		$wgtimelines = WgtimelinesHelper::getInstance();
		if($action === false) {
			$action = $_SERVER['REQUEST_URI'];
		}
		// Permissions for uploader
		$gpermHandler = xoops_gethandler('groupperm');
		$groups = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : XOOPS_GROUP_ANONYMOUS;
		if($GLOBALS['xoopsUser']) {
			if(!$GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid())) {
				$permissionUpload = $gpermHandler->checkRight('', 32, $groups, $GLOBALS['xoopsModule']->getVar('mid')) ? true : false;
			} else {
				$permissionUpload = true;
			}
		} else {
				$permissionUpload = $gpermHandler->checkRight('', 32, $groups, $GLOBALS['xoopsModule']->getVar('mid')) ? true : false;
		}
		// Title
		$title = $this->isNew() ? sprintf(_AM_WGTIMELINES_RATING_ADD) : sprintf(_AM_WGTIMELINES_RATING_EDIT);
		// Get Theme Form
		xoops_load('XoopsFormLoader');
		$form = new XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Text RateItemid
		$rateItemid = $this->isNew() ? '0' : $this->getVar('rate_itemid');
		$form->addElement(new XoopsFormText( _AM_WGTIMELINES_RATING_ITEMID, 'rate_itemid', 20, 150, $rateItemid ), true);
		// Form Text RateValue
		$rateValue = $this->isNew() ? '0' : $this->getVar('rate_value');
		$form->addElement(new XoopsFormText( _AM_WGTIMELINES_RATING_VALUE, 'rate_value', 20, 150, $rateValue ), true);
		// Form Select User
		$form->addElement(new XoopsFormSelectUser( _AM_WGTIMELINES_RATING_UID, 'rate_uid', false, $this->getVar('rate_uid') ), true);
		// Form Text RateIp
		$form->addElement(new XoopsFormText( _AM_WGTIMELINES_RATING_IP, 'rate_ip', 50, 255, $this->getVar('rate_ip') ), true);
		// Form Text Date Select
		$rateDate = $this->isNew() ? 0 : $this->getVar('rate_date');
		$form->addElement(new XoopsFormTextDateSelect( _AM_WGTIMELINES_RATING_DATE, 'rate_date', '', $this->getVar('rate_date') ));
		// To Save
		$form->addElement(new XoopsFormHidden('op', 'save'));
		$form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
		return $form;
	}

	/**
	 * Get Values
	 */
	public function getValuesRatings($keys = null, $format = null, $maxDepth = null)
	{
		$wgtimelines = WgtimelinesHelper::getInstance();
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id'] = $this->getVar('rate_id');
		$ret['itemid'] = $this->getVar('rate_itemid');
		$ret['value'] = $this->getVar('rate_value');
		$ret['uid'] = XoopsUser::getUnameFromId($this->getVar('rate_uid'));
		$ret['ip'] = $this->getVar('rate_ip');
		$ret['date'] = formatTimeStamp($this->getVar('rate_date'), 's');
		return $ret;
	}

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayRatings()
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
 * Class Object Handler WgtimelinesRatings
 */
class WgtimelinesRatingsHandler extends XoopsPersistableObjectHandler
{
	/**
	 * Constructor 
	 *
	 * @param null|XoopsDatabase $db
	 */
	public function __construct(XoopsDatabase $db)
	{
		parent::__construct($db, 'wgtimelines_ratings', 'wgtimelinesratings', 'rate_id', 'rate_itemid');
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
	 * Get Rating per item in the database
	 * @param rate_itemid
	 * @return array
	 */
	public function getItemRating($rate_itemid = 0)
	{
		$ItemRating = array();
		$ItemRating['nb_ratings'] = 0;
		$ItemRating['avg_rate_value'] = 0;
		$ItemRating['size'] = 0;
		
		$rating_unitwidth = 25;
		$max_units = 5;
		
		$criteria   = new Criteria('rate_itemid', $rate_itemid);
		$wgtimelines = WgtimelinesHelper::getInstance();
		$ratingObjs = $wgtimelines->getHandler('ratings')->getObjects($criteria);

		$uid            = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0;
		$count          = count($ratingObjs);
		$current_rating = 0;
		$voted          = false;
		$ip             = getenv('REMOTE_ADDR');

		foreach ($ratingObjs as $ratingObj) {
			$current_rating += $ratingObj->getVar('rate_value');
			if ($ratingObj->getVar('rate_ip') == $ip || ($uid > 0 && $uid == $ratingObj->getVar('rate_uid'))) {
				$voted = true;
			}
		}
		unset($ratingObj);
		
		$ItemRating['uid']            = $uid;
		$ItemRating['nb_ratings']     = $count;
		$ItemRating['avg_rate_value'] = number_format($current_rating / $count, 2);
		$text = str_replace('%c', $ItemRating['avg_rate_value'], _MA_WGTIMELINES_RATING_CURRENT);
		$text = str_replace('%m', $max_units, $text);
		$text = str_replace('%t', $ItemRating['nb_ratings'], $text);
		$ItemRating['text']    = $text;
		$ItemRating['size']    = ($ItemRating['avg_rate_value'] * $rating_unitwidth) . 'px';
		$ItemRating['maxsize'] = ($max_units * $rating_unitwidth) . 'px';
		$ItemRating['voted']   = $voted;
		$ItemRating['ip']      = $ip;
		
		return $ItemRating;
	}

	/**
	 * Get Criteria Ratings
	 */
	private function getRatingsCriteria($crRatings, $start, $limit, $sort, $order)
	{
		$crRatings->setStart( $start );
		$crRatings->setLimit( $limit );
		$crRatings->setSort( $sort );
		$crRatings->setOrder( $order );
		return $crRatings;
	}
}
