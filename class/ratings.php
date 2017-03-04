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
        if (!$instance) {
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
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
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
        $ret['date'] = formatTimestamp($this->getVar('rate_date'), 's');
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
        foreach (array_keys($vars) as $var) {
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
     * @return XoopsObject
     */
    public function create($isNew = true)
    {
        return parent::create($isNew);
    }

    /**
     * retrieve a field
     *
     * @param int $i field id
     * @param null $fields
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
     * @param int $rate_itemid
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
        $ItemRating['avg_rate_value'] = 0;
        if ($count > 0) {
            $ItemRating['avg_rate_value'] = number_format($current_rating / $count, 2);
        }
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
     * @param $crRatings
     * @param $start
     * @param $limit
     * @param $sort
     * @param $order
     * @return
     */
    private function getRatingsCriteria($crRatings, $start, $limit, $sort, $order)
    {
        $crRatings->setStart($start);
        $crRatings->setLimit($limit);
        $crRatings->setSort($sort);
        $crRatings->setOrder($order);
        return $crRatings;
    }
}
