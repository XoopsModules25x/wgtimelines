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
defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object WgtimelinesTemplates
 */
class WgtimelinesTemplates extends XoopsObject
{
	/**
	 * Constructor 
	 *
	 * @param null
	 */
	public function __construct()
	{
		$this->initVar('tpl_id', XOBJ_DTYPE_INT);
		$this->initVar('tpl_name', XOBJ_DTYPE_TXTBOX);
        $this->initVar('tpl_desc', XOBJ_DTYPE_TXTAREA);
		$this->initVar('tpl_file', XOBJ_DTYPE_TXTBOX);
		$this->initVar('tpl_options', XOBJ_DTYPE_TXTAREA);
		$this->initVar('tpl_imgposition', XOBJ_DTYPE_TXTBOX);
		$this->initVar('tpl_imgstyle', XOBJ_DTYPE_TXTBOX);
		$this->initVar('tpl_tabletype', XOBJ_DTYPE_TXTBOX);
        $this->initVar('tpl_imgposition_p', XOBJ_DTYPE_TXTBOX);
        $this->initVar('tpl_bgcolor', XOBJ_DTYPE_TXTBOX);
        $this->initVar('tpl_fontcolor', XOBJ_DTYPE_TXTBOX);
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
	public function getNewInsertedIdTemplates()
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
	public function getFormTemplates($action = false, $master = false)
	{
		$wgtimelines = WgtimelinesHelper::getInstance();
		if($action === false) {
			$action = $_SERVER['REQUEST_URI'];
		}
		// Title
		$title = $this->isNew() ? sprintf(_AM_WGTIMELINES_TEMPLATE_ADD) : sprintf(_AM_WGTIMELINES_TEMPLATE_EDIT);
		// Get Theme Form
		xoops_load('XoopsFormLoader');
		$form = new XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Text TplName
		$form->addElement(new XoopsFormText( _AM_WGTIMELINES_TEMPLATE_NAME, 'tpl_name', 50, 255, $this->getVar('tpl_name') ), true);
        // Form Text Area TplDesc
		$editorConfigs = array();
		$editorConfigs['name'] = 'tpl_desc';
		$editorConfigs['value'] = $this->getVar('tpl_desc', 'e');
		$editorConfigs['rows'] = 5;
		$editorConfigs['cols'] = 40;
		$editorConfigs['width'] = '100%';
		$editorConfigs['height'] = '400px';
		$editorConfigs['editor'] = $wgtimelines->getConfig('wgtimelines_editor');
		$form->addElement(new XoopsFormEditor( _AM_WGTIMELINES_TEMPLATE_DESC, 'tpl_desc', $editorConfigs), true);
		// Form Text TplFile
		$form->addElement(new XoopsFormText( _AM_WGTIMELINES_TEMPLATE_FILE, 'tpl_file', 50, 255, $this->getVar('tpl_file') ), true);
		// Form Text Area TplOptions
        $tpl_options = $this->isNew() ? '1|1|1|1|1|1|1|1|1|1|1' :  $this->getVar('tpl_options');
        if ($master) {
            $form->addElement(new XoopsFormText( _AM_WGTIMELINES_TEMPLATE_OPTIONS, 'tpl_options', 50, 255, $tpl_options ), true);
        } else {
            $form->addElement(new XoopsFormHidden('tpl_options', $tpl_options));
        }
        $options = explode('|', $tpl_options);
        // Form Select
        $applicable = ($options[0] == 0) ? _AM_WGTIMELINES_TEMPLATE_NOTAPPL : '';
        $tplImgpositionSelect = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_IMGPOS . $applicable, 'tpl_imgposition', $this->getVar('tpl_imgposition'));
        $tplImgpositionSelect->addOption('none', _AM_WGTIMELINES_TEMPLATE_NONE);
        $tplImgpositionSelect->addOption('left', _AM_WGTIMELINES_TEMPLATE_IMGPOS_LEFT);
        $tplImgpositionSelect->addOption('right', _AM_WGTIMELINES_TEMPLATE_IMGPOS_RIGHT);
        $tplImgpositionSelect->addOption('alternate', _AM_WGTIMELINES_TEMPLATE_IMGPOS_ALTERNATE);
        if ($options[0] == 0) $tplImgpositionSelect->setExtra('disabled="disabled"');
        $form->addElement($tplImgpositionSelect);
        
        // Form Select
        $applicable = ($options[1] == 0) ? _AM_WGTIMELINES_TEMPLATE_NOTAPPL : '';
        $tplImgstyleSelect = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_IMGSTYLE . $applicable, 'tpl_imgstyle', $this->getVar('tpl_imgstyle'));
        $tplImgstyleSelect->addOption('none', _AM_WGTIMELINES_TEMPLATE_NONE);
        $tplImgstyleSelect->addOption('img-rounded', _AM_WGTIMELINES_TEMPLATE_IMGSTYLE_ROUNDED);
        $tplImgstyleSelect->addOption('img-circle', _AM_WGTIMELINES_TEMPLATE_IMGSTYLE_CIRCLE);
        $tplImgstyleSelect->addOption('img-thumbnail', _AM_WGTIMELINES_TEMPLATE_IMGSTYLE_THUMB);
        if ($options[1] == 0) $tplImgstyleSelect->setExtra('disabled="disabled"');
        $form->addElement($tplImgstyleSelect);

        // Form Select
        $applicable = ($options[2] == 0) ? _AM_WGTIMELINES_TEMPLATE_NOTAPPL : '';
        $tplTabletypeSelect = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_TABLETYPE . $applicable, 'tpl_tabletype', $this->getVar('tpl_tabletype'));
        $tplTabletypeSelect->addOption('none', _AM_WGTIMELINES_TEMPLATE_NONE);
        $tplTabletypeSelect->addOption('bordered', _AM_WGTIMELINES_TEMPLATE_TABLEBORDERED);
        $tplTabletypeSelect->addOption('striped', _AM_WGTIMELINES_TEMPLATE_TABLESTRIPED);
        $tplTabletypeSelect->addOption('hover', _AM_WGTIMELINES_TEMPLATE_TABLEHOVER);
        $tplTabletypeSelect->addOption('condensed', _AM_WGTIMELINES_TEMPLATE_TABLECONDENSED);
        if ($options[2] == 0) $tplTabletypeSelect->setExtra('disabled="disabled"');
        $form->addElement($tplTabletypeSelect);

        // Form Color Picker
        if ($options[3] == 0) {
            $tplBgColor =  new XoopsFormText( _AM_WGTIMELINES_TEMPLATE_BGCOLOR . $applicable, 'tpl_bgcolor', 10, 50, $this->getVar('tpl_bgcolor') );
            $tplBgColor->setExtra(' disabled="disabled"; ');
            $tplBgColor->setExtra(' style="background-color:' . $this->getVar('tpl_bgcolor') . ';"');
        } else {
            $tplBgColor = new XoopsFormColorPicker( _AM_WGTIMELINES_TEMPLATE_BGCOLOR, 'tpl_bgcolor', $this->getVar('tpl_bgcolor') );
        }
        $form->addElement($tplBgColor);

        // Form Color Picker
        if ($options[4] == 0) {
            $tplFontColor =  new XoopsFormText( _AM_WGTIMELINES_TEMPLATE_FONTCOLOR . $applicable, 'tpl_fontcolor', 10, 50, $this->getVar('tpl_fontcolor') );
            $tplFontColor->setExtra(' disabled="disabled"; ');
            $tplFontColor->setExtra(' style="background-color:' . $this->getVar('tpl_fontcolor') . ';"');
        } else {
            $tplFontColor = new XoopsFormColorPicker( _AM_WGTIMELINES_TEMPLATE_FONTCOLOR, 'tpl_fontcolor', $this->getVar('tpl_fontcolor') );
        }
        $form->addElement($tplFontColor);

        // Form Select
        $applicable = ($options[5] == 0) ? _AM_WGTIMELINES_TEMPLATE_NOTAPPL : '';
        $tplImgpositionSelect2 = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_IMGPOS_PANEL . $applicable, 'tpl_imgposition_p', $this->getVar('tpl_imgposition_p'));
        $tplImgpositionSelect2->addOption('none', _AM_WGTIMELINES_TEMPLATE_NONE);
        $tplImgpositionSelect2->addOption('top', _AM_WGTIMELINES_TEMPLATE_IMGPOS_TOP);
        $tplImgpositionSelect2->addOption('bottom', _AM_WGTIMELINES_TEMPLATE_IMGPOS_BOTTOM);
        if ($options[5] == 0) $tplImgpositionSelect2->setExtra('disabled="disabled"');
        $form->addElement($tplImgpositionSelect2);

		// To Save
		$form->addElement(new XoopsFormHidden('op', 'save'));
		$form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
		return $form;
	}

	/**
	 * Get Values
	 */
	public function getValuesTemplates($keys = null, $format = null, $maxDepth = null)
	{
		$wgtimelines = WgtimelinesHelper::getInstance();
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id'] = $this->getVar('tpl_id');
		$ret['name'] = $this->getVar('tpl_name');
        $ret['desc'] = $this->getVar('tpl_desc', 'n');
		$ret['file'] = $this->getVar('tpl_file');
		$ret['options'] = strip_tags($this->getVar('tpl_options'));
        $options = explode('|', $this->getVar('tpl_options'));
		$ret['imgposition'] = $this->getVar('tpl_imgposition');
        if ($options[0] == 1) $ret['imgposition_show'] = 1;
		$ret['imgstyle'] = $this->getVar('tpl_imgstyle');
        if ($options[1] == 1) $ret['imgstyle_show'] = 1;
		$ret['tabletype'] = $this->getVar('tpl_tabletype');
        if ($options[2] == 1) $ret['tabletype_show'] = 1;
        $ret['bgcolor'] = $this->getVar('tpl_bgcolor');
        if ($options[3] == 1) $ret['bgcolor_show'] = 1;
        $ret['fontcolor'] = $this->getVar('tpl_fontcolor');
        if ($options[4] == 1) $ret['fontcolor_show'] = 1;
        $ret['imgposition_p'] = $this->getVar('tpl_imgposition_p');
        if ($options[5] == 1) $ret['imgposition_p_show'] = 1;
		return $ret;
	}

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayTemplates()
	{
		$ret = array();
		$vars =& $this->getVars();
		foreach(array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}
}

/**
 * Class Object Handler WgtimelinesTemplates
 */
class WgtimelinesTemplatesHandler extends XoopsPersistableObjectHandler
{
	/**
	 * Constructor 
	 *
	 * @param null|XoopsDatabase $db
	 */
	public function __construct(XoopsDatabase $db)
	{
		parent::__construct($db, 'wgtimelines_templates', 'wgtimelinestemplates', 'tpl_id', 'tpl_name');
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
	 * Get Count Templates in the database
	 */
	public function getCountTemplates($start = 0, $limit = 0, $sort = 'tpl_id ASC, tpl_name', $order = 'ASC')
	{
		$crCountTemplates = new CriteriaCompo();
		$crCountTemplates = $this->getTemplatesCriteria($crCountTemplates, $start, $limit, $sort, $order);
		return parent::getCount($crCountTemplates);
	}

	/**
	 * Get All Templates in the database
	 */
	public function getAllTemplates($start = 0, $limit = 0, $sort = 'tpl_id ASC, tpl_name', $order = 'ASC')
	{
		$crAllTemplates = new CriteriaCompo();
		$crAllTemplates = $this->getTemplatesCriteria($crAllTemplates, $start, $limit, $sort, $order);
		return parent::getAll($crAllTemplates);
	}

	/**
	 * Get Criteria Templates
	 */
	private function getTemplatesCriteria($crTemplates, $start, $limit, $sort, $order)
	{
		$crTemplates->setStart( $start );
		$crTemplates->setLimit( $limit );
		$crTemplates->setSort( $sort );
		$crTemplates->setOrder( $order );
		return $crTemplates;
	}
}
