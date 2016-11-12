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
		$this->initVar('tpl_weight', XOBJ_DTYPE_TXTBOX);
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
	public function getFormTemplates($action = false)
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
		$editorConfigs['height'] = '100px';
		$editorConfigs['editor'] = $wgtimelines->getConfig('wgtimelines_editor');
		$form->addElement(new XoopsFormEditor( _AM_WGTIMELINES_TEMPLATE_DESC, 'tpl_desc', $editorConfigs), true);
		// Form Text TplFile
		$form->addElement(new XoopsFormText( _AM_WGTIMELINES_TEMPLATE_FILE, 'tpl_file', 50, 255, $this->getVar('tpl_file') ), true);
		// Form Text Area TplOptions
        $tpl_options = $this->getVar('tpl_options', 'N');
        $options = unserialize($tpl_options);
        $eletray = array();
        $i = 0;
        foreach ($options as $option) {
            switch ($option['name']) {
                case 'panel_pos':
                    if ($option['valid'] > 0) {
                        $tplImgpositionSelect = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_IMGPOS, 'panel_pos', $option['value']);
                        $tplImgpositionSelect->addOption('none', _AM_WGTIMELINES_TEMPLATE_NONE);
                        $tplImgpositionSelect->addOption('left', _AM_WGTIMELINES_TEMPLATE_IMGPOS_LEFT);
                        $tplImgpositionSelect->addOption('right', _AM_WGTIMELINES_TEMPLATE_IMGPOS_RIGHT);
                        $tplImgpositionSelect->addOption('alternate', _AM_WGTIMELINES_TEMPLATE_IMGPOS_ALTERNATE);
                        $form->addElement($tplImgpositionSelect);
                    }
                    break;
                case 'tabletype':
                    if ($option['valid'] > 0) {
                        $tplTabletypeSelect = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_TABLETYPE , 'tabletype', $option['value']);
                        $tplTabletypeSelect->addOption('none', _AM_WGTIMELINES_TEMPLATE_NONE);
                        $tplTabletypeSelect->addOption('bordered', _AM_WGTIMELINES_TEMPLATE_TABLEBORDERED);
                        $tplTabletypeSelect->addOption('striped', _AM_WGTIMELINES_TEMPLATE_TABLESTRIPED);
                        $tplTabletypeSelect->addOption('hover', _AM_WGTIMELINES_TEMPLATE_TABLEHOVER);
                        $tplTabletypeSelect->addOption('condensed', _AM_WGTIMELINES_TEMPLATE_TABLECONDENSED);
                        $form->addElement($tplTabletypeSelect);
                    }
                    break;
                case 'imgstyle':
                    if ($option['valid'] > 0) {
                        $tplImgstyleSelect = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_IMGSTYLE, 'imgstyle', $option['value']);
                        $tplImgstyleSelect->addOption('none', _AM_WGTIMELINES_TEMPLATE_NONE);
                        $tplImgstyleSelect->addOption('img-rounded', _AM_WGTIMELINES_TEMPLATE_IMGSTYLE_ROUNDED);
                        $tplImgstyleSelect->addOption('img-circle', _AM_WGTIMELINES_TEMPLATE_IMGSTYLE_CIRCLE);
                        $tplImgstyleSelect->addOption('img-thumbnail', _AM_WGTIMELINES_TEMPLATE_IMGSTYLE_THUMB);
                        $form->addElement($tplImgstyleSelect);
                    }
                    break;
                case 'bgcolor':
                    if ($option['valid'] > 0) {
                        $form->addElement(new XoopsFormColorPicker( _AM_WGTIMELINES_TEMPLATE_BGCOLOR, 'bgcolor', $option['value']));
                    }
                    break;
                case 'panel_imgpos':
                    if ($option['valid'] > 0) {
                        $tplImgpositionSelect2 = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_IMGPOS, 'panel_imgpos', $option['value']);
                        $tplImgpositionSelect2->addOption('none', _AM_WGTIMELINES_TEMPLATE_NONE);
                        $tplImgpositionSelect2->addOption('top', _AM_WGTIMELINES_TEMPLATE_IMGPOS_TOP);
                        $tplImgpositionSelect2->addOption('bottom', _AM_WGTIMELINES_TEMPLATE_IMGPOS_BOTTOM);
                        $form->addElement($tplImgpositionSelect2);
                    }
                    break;
                case 'fontcolor':
                    if ($option['valid'] > 0) {
                        $form->addElement(new XoopsFormColorPicker( _AM_WGTIMELINES_TEMPLATE_FONTCOLOR, 'fontcolor', $option['value']));
                    }
                    break;
                case 'badgestyle':
                    if ($option['valid'] > 0) {
                        $badgestyle = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_BADGESTYLE, 'badgestyle', $option['value'], true);
                        $badgestyle->addOption('full', _AM_WGTIMELINES_TEMPLATE_BADGESTYLE_FULL);
                        $badgestyle->addOption('circle', _AM_WGTIMELINES_TEMPLATE_BADGESTYLE_CIRCLE);
                        $form->addElement($badgestyle);
                    }
                    break;
                case 'badgecolor':
                    if ($option['valid'] > 0) {
                        $form->addElement(new XoopsFormColorPicker( _AM_WGTIMELINES_TEMPLATE_BADGECOLOR, 'badgecolor', $option['value']), false);
                    }
                    break;
                case 'badgefontcolor':
                    if ($option['valid'] > 0) {
                        $form->addElement(new XoopsFormColorPicker( _AM_WGTIMELINES_TEMPLATE_BADGEFONTCOLOR, 'badgefontcolor', $option['value']));
                    }
                    break;
                case 'linecolor':
                    if ($option['valid'] > 0) {
                        $form->addElement(new XoopsFormColorPicker( _AM_WGTIMELINES_TEMPLATE_LINECOLOR, 'linecolor', $option['value']));
                    }
                    break;
                case 'borderwidth':
                    if ($option['valid'] > 0) {
                        $form->addElement(new XoopsFormText( _AM_WGTIMELINES_TEMPLATE_BORDERWIDTH, 'borderwidth', 20, 255, $option['value'] ), true);
                    }
                    break;
                case 'borderstyle':
                    if ($option['valid'] > 0) {
                        $bordertype = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_BORDERSTYLE, 'borderstyle',  $option['value'] );
                        $bordertype->addOption('solid', 'solid');
                        $bordertype->addOption('dotted', 'dotted');
                        $bordertype->addOption('double', 'double');
                        $bordertype->addOption('dashed', 'dashed');
                        $form->addElement($bordertype);
                    }
                    break;
                case 'bordercolor':
                    if ($option['valid'] > 0) {
                        $form->addElement(new XoopsFormColorPicker( _AM_WGTIMELINES_TEMPLATE_BORDERCOLOR, 'bordercolor', $option['value'] ));
                    }
                    break;
                case 'borderradius':
                    if ($option['valid'] > 0) {
                        $form->addElement(new XoopsFormText( _AM_WGTIMELINES_TEMPLATE_BORDERRADIUS, 'borderradius', 20, 255, $option['value'] ), true);
                    }
                    break;
                case 'boxshadow':
                    if ($option['valid'] > 0) {
                        $option_shadow = explode(' ', $option['value']);
                        $shadowTray = new XoopsFormElementTray(_AM_WGTIMELINES_TEMPLATE_BOXSHADOW, '&nbsp;&nbsp;&nbsp;' );
                        $shadow_h = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_BOXSHADOW_H, 'boxshadow_h', $option_shadow[0]);
                        $shadow_h->addOption('-10px', '-10px');
                        $shadow_h->addOption('-9px', '-9px');
                        $shadow_h->addOption('-8px', '-8px');
                        $shadow_h->addOption('-7px', '-7px');
                        $shadow_h->addOption('-6px', '-6px');
                        $shadow_h->addOption('-5px', '-5px');
                        $shadow_h->addOption('-4px', '-4px');
                        $shadow_h->addOption('-3px', '-3px');
                        $shadow_h->addOption('-2px', '-2px');
                        $shadow_h->addOption('-1px', '-1px');
                        $shadow_h->addOption('0px', '0px');
                        $shadow_h->addOption('1px', '1px');
                        $shadow_h->addOption('2px', '2px');
                        $shadow_h->addOption('3px', '3px');
                        $shadow_h->addOption('4px', '4px');
                        $shadow_h->addOption('5px', '5px');
                        $shadow_h->addOption('6px', '6px');
                        $shadow_h->addOption('7px', '7px');
                        $shadow_h->addOption('8px', '8px');
                        $shadow_h->addOption('9px', '9px');
                        $shadow_h->addOption('10px', '10px');
                        $shadowTray->addElement($shadow_h);
                        $shadow_v = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_BOXSHADOW_V, 'boxshadow_v', $option_shadow[1]);
                        $shadow_v->addOption('-10px', '-10px');
                        $shadow_v->addOption('-9px', '-9px');
                        $shadow_v->addOption('-8px', '-8px');
                        $shadow_v->addOption('-7px', '-7px');
                        $shadow_v->addOption('-6px', '-6px');
                        $shadow_v->addOption('-5px', '-5px');
                        $shadow_v->addOption('-4px', '-4px');
                        $shadow_v->addOption('-3px', '-3px');
                        $shadow_v->addOption('-2px', '-2px');
                        $shadow_v->addOption('-1px', '-1px');
                        $shadow_v->addOption('0px', '0px');
                        $shadow_v->addOption('1px', '1px');
                        $shadow_v->addOption('2px', '2px');
                        $shadow_v->addOption('3px', '3px');
                        $shadow_v->addOption('4px', '4px');
                        $shadow_v->addOption('5px', '5px');
                        $shadow_v->addOption('6px', '6px');
                        $shadow_v->addOption('7px', '7px');
                        $shadow_v->addOption('8px', '8px');
                        $shadow_v->addOption('9px', '9px');
                        $shadow_v->addOption('10px', '10px');
                        $shadowTray->addElement($shadow_v);
                        $shadow_blur = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_BOXSHADOW_BLUR, 'boxshadow_blur', $option_shadow[2]);
                        $shadow_blur->addOption('-10px', '-10px');
                        $shadow_blur->addOption('-9px', '-9px');
                        $shadow_blur->addOption('-8px', '-8px');
                        $shadow_blur->addOption('-7px', '-7px');
                        $shadow_blur->addOption('-6px', '-6px');
                        $shadow_blur->addOption('-5px', '-5px');
                        $shadow_blur->addOption('-4px', '-4px');
                        $shadow_blur->addOption('-3px', '-3px');
                        $shadow_blur->addOption('-2px', '-2px');
                        $shadow_blur->addOption('-1px', '-1px');
                        $shadow_blur->addOption('0px', '0px');
                        $shadow_blur->addOption('1px', '1px');
                        $shadow_blur->addOption('2px', '2px');
                        $shadow_blur->addOption('3px', '3px');
                        $shadow_blur->addOption('4px', '4px');
                        $shadow_blur->addOption('5px', '5px');
                        $shadow_blur->addOption('6px', '6px');
                        $shadow_blur->addOption('7px', '7px');
                        $shadow_blur->addOption('8px', '8px');
                        $shadow_blur->addOption('9px', '9px');
                        $shadow_blur->addOption('10px', '10px');
                        $shadowTray->addElement($shadow_blur);
                        $shadow_spread = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_BOXSHADOW_SPREAD, 'boxshadow_spread', $option_shadow[3]);
                        $shadow_spread->addOption('-10px', '-10px');
                        $shadow_spread->addOption('-9px', '-9px');
                        $shadow_spread->addOption('-8px', '-8px');
                        $shadow_spread->addOption('-7px', '-7px');
                        $shadow_spread->addOption('-6px', '-6px');
                        $shadow_spread->addOption('-5px', '-5px');
                        $shadow_spread->addOption('-4px', '-4px');
                        $shadow_spread->addOption('-3px', '-3px');
                        $shadow_spread->addOption('-2px', '-2px');
                        $shadow_spread->addOption('-1px', '-1px');
                        $shadow_spread->addOption('0px', '0px');
                        $shadow_spread->addOption('1px', '1px');
                        $shadow_spread->addOption('2px', '2px');
                        $shadow_spread->addOption('3px', '3px');
                        $shadow_spread->addOption('4px', '4px');
                        $shadow_spread->addOption('5px', '5px');
                        $shadow_spread->addOption('6px', '6px');
                        $shadow_spread->addOption('7px', '7px');
                        $shadow_spread->addOption('8px', '8px');
                        $shadow_spread->addOption('9px', '9px');
                        $shadow_spread->addOption('10px', '10px');
                        $shadowTray->addElement($shadow_spread);
                        $shadowTray->addElement(new XoopsFormColorPicker( _AM_WGTIMELINES_TEMPLATE_BOXSHADOW_COLOR, 'boxshadow_color', $option_shadow[4]));
                        $form->addElement($shadowTray);
                    }
                    break;
                case 'orientation':
                    if ($option['valid'] > 0) {
                        $tplOrientation = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_ORIENTATION, 'orientation', $option['value']);
                        $tplOrientation->addOption('vertical', _AM_WGTIMELINES_TEMPLATE_ORIENTATION_V);
                        $tplOrientation->addOption('horizontal', _AM_WGTIMELINES_TEMPLATE_ORIENTATION_H);
                        $form->addElement($tplOrientation);
                    }
                    break;
                case 'datesspeed':
                    if ($option['valid'] > 0) {
                        $datesspeed = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_DATESSPEED, 'datesspeed', $option['value']);
                        $datesspeed->addOption('100', '100');
                        $datesspeed->addOption('200', '200');
                        $datesspeed->addOption('300', '300');
                        $datesspeed->addOption('400', '400');
                        $datesspeed->addOption('500', '500');
                        $datesspeed->addOption('600', '600');
                        $datesspeed->addOption('700', '700');
                        $datesspeed->addOption('800', '800');
                        $datesspeed->addOption('900', '900');
                        $datesspeed->addOption('1000', '1000');
                        $form->addElement($datesspeed);
                    }
                    break;    
                case 'issuesspeed':
                    if ($option['valid'] > 0) {
                        $datesspeed = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_ISSUESSPEED, 'issuesspeed', $option['value']);
                        $datesspeed->addOption('100', '100');
                        $datesspeed->addOption('200', '200');
                        $datesspeed->addOption('300', '300');
                        $datesspeed->addOption('400', '400');
                        $datesspeed->addOption('500', '500');
                        $datesspeed->addOption('600', '600');
                        $datesspeed->addOption('700', '700');
                        $datesspeed->addOption('800', '800');
                        $datesspeed->addOption('900', '900');
                        $datesspeed->addOption('1000', '1000');
                        $form->addElement($datesspeed);
                    }
                    break;      
                case 'issuestransparency':
                    if ($option['valid'] > 0) {
                        $datesspeed = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_ISSUESTRANSPARENCY, 'issuestransparency', $option['value']);
                        $datesspeed->addOption('0.1', '0.1');
                        $datesspeed->addOption('0.2', '0.2');
                        $datesspeed->addOption('0.3', '0.3');
                        $datesspeed->addOption('0.4', '0.4');
                        $datesspeed->addOption('0.5', '0.5');
                        $datesspeed->addOption('0.6', '0.6');
                        $datesspeed->addOption('0.7', '0.7');
                        $datesspeed->addOption('0.8', '0.8');
                        $datesspeed->addOption('0.9', '0.9');
                        $datesspeed->addOption('1', '1');
                        $form->addElement($datesspeed);
                    }
                    break;     
                case 'issuestransparencyspeed':
                    if ($option['valid'] > 0) {
                        $datesspeed = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_ISSUESTRANSPARENCYSPEED, 'issuestransparencyspeed', $option['value']);
                        $datesspeed->addOption('100', '100');
                        $datesspeed->addOption('200', '200');
                        $datesspeed->addOption('300', '300');
                        $datesspeed->addOption('400', '400');
                        $datesspeed->addOption('500', '500');
                        $datesspeed->addOption('600', '600');
                        $datesspeed->addOption('700', '700');
                        $datesspeed->addOption('800', '800');
                        $datesspeed->addOption('900', '900');
                        $datesspeed->addOption('1000', '1000');
                        $form->addElement($datesspeed);
                    }
                    break;       
                case 'autoplay':
                    if ($option['valid'] > 0) {
                        $autoplay = $option['value'] === 'true' ? 1 : 0;
                        $form->addElement(new XoopsFormRadioYN(_AM_WGTIMELINES_TEMPLATE_AUTOPLAY, 'autoplay', $autoplay, _YES, _NO), false);
                    }
                    break;                    
                case 'autoplaydirection':
                    if ($option['valid'] > 0) {
                        $autoplaydirection = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_AUTOPLAY_DIRECTION, 'autoplaydirection', $option['value']);
                        $autoplaydirection->addOption('forward', _AM_WGTIMELINES_TEMPLATE_AUTOPLAY_DIRECTION_FW);
                        $autoplaydirection->addOption('backward', _AM_WGTIMELINES_TEMPLATE_AUTOPLAY_DIRECTION_BW);
                        $form->addElement($autoplaydirection);
                    }
                    break;
                case 'autoplaypause':
                    if ($option['valid'] > 0) {
                        $datesspeed = new XoopsFormSelect( _AM_WGTIMELINES_TEMPLATE_AUTOPLAY_PAUSE, 'autoplaypause', $option['value']);
                        $datesspeed->addOption('1000', '1000');
                        $datesspeed->addOption('2000', '2000');
                        $datesspeed->addOption('3000', '3000');
                        $datesspeed->addOption('4000', '4000');
                        $datesspeed->addOption('5000', '5000');
                        $datesspeed->addOption('6000', '6000');
                        $datesspeed->addOption('7000', '7000');
                        $datesspeed->addOption('8000', '8000');
                        $datesspeed->addOption('9000', '9000');
                        $datesspeed->addOption('10000', '10000');
                        $form->addElement($datesspeed);
                    }
                    break;           
                case 'arrowkeys':
                    if ($option['valid'] > 0) {
                        $arrowkeys = $option['value'] === 'true' ? 1 : 0;
                        $form->addElement(new XoopsFormRadioYN(_AM_WGTIMELINES_TEMPLATE_ARROWKEYS, 'arrowkeys', $arrowkeys, _YES, _NO), false);
                    }
                    break; 
                case 'startat':
                    if ($option['valid'] > 0) {
                        $form->addElement(new XoopsFormText( _AM_WGTIMELINES_TEMPLATE_STARTAT, 'startat', 20, 255, $option['value'] ));
                    }
                    break;     

                case 'default':
                default:
                    if ($option['valid'] > 0) {

                    }
                    break;
            }
        }


		// To Save
		$form->addElement(new XoopsFormHidden('op', 'save'));
        $form->addElement(new XoopsFormHidden('addopt', 0));
		$form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
		return $form;
	}

    /**
     * Get form
     *
     * @param mixed $action
     * @return XoopsThemeForm
     */
	public function getFormTemplatesMaster($action = false)
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
		$editorConfigs['height'] = '100px';
		$editorConfigs['editor'] = $wgtimelines->getConfig('wgtimelines_editor');
		$form->addElement(new XoopsFormEditor( _AM_WGTIMELINES_TEMPLATE_DESC, 'tpl_desc', $editorConfigs), true);
		// Form Text TplFile
		$form->addElement(new XoopsFormText( _AM_WGTIMELINES_TEMPLATE_FILE, 'tpl_file', 50, 255, $this->getVar('tpl_file') ), true);
        // load options
        $tpl_options = $this->getVar('tpl_options', 'N');
        $options = unserialize($tpl_options);
        $eletray = array();
        $i = 0;
        $form->addElement(new XoopsFormLabel(_AM_WGTIMELINES_TEMPLATE_OPTIONS, $this->getVar('tpl_options', 'N')));
        foreach ($options as $option) {
            $i++;
            $eletray[$i] = new XoopsFormElementTray('','&nbsp;');
            $eletray[$i]->addElement(new XoopsFormText( '', 'name_'.$i, 20, 255, $option['name'] ), true);
            $eletray[$i]->addElement(new XoopsFormRadioYN(_AM_WGTIMELINES_TEMPLATE_VALID, 'valid_'.$i, $option['valid'], _YES, _NO), false);
            $eletray[$i]->addElement(new XoopsFormText( '', 'value_'.$i, 20, 255, $option['value'] ), false);
            $eletray[$i]->addElement(new XoopsFormHidden('type_'.$i, $option['type']));
            $form->addElement($eletray[$i], false);
        }
        $i++;
        $stop = $i + 5;
        for (; $i < $stop; $i++) {
            $eletray[$i] = new XoopsFormElementTray('','&nbsp;');
            $eletray[$i]->addElement(new XoopsFormText( '', 'name_'.$i, 20, 255, '' ), false);
            $eletray[$i]->addElement(new XoopsFormRadioYN(_AM_WGTIMELINES_TEMPLATE_VALID, 'valid_'.$i, 0, _YES, _NO), false);
            $eletray[$i]->addElement(new XoopsFormText( '', 'value_'.$i, 20, 255, '' ), false);
            $form->addElement($eletray[$i], false);
        }
        
        $form->addElement(new XoopsFormRadioYN(_AM_WGTIMELINES_TEMPLATE_ADDOPT, 'addopt', 0, _YES, _NO), false);
		// To Save
        $form->addElement(new XoopsFormHidden('counter', $i));
        $form->addElement(new XoopsFormHidden('tpl_id', $this->getVar('tpl_id')));
		$form->addElement(new XoopsFormHidden('op', 'save-master'));
		$form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
		return $form;
	}

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
	public function getValuesTemplates($keys = null, $format = null, $maxDepth = null)
	{
		$wgtimelines = WgtimelinesHelper::getInstance();
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id'] = $this->getVar('tpl_id');
		$ret['name'] = $this->getVar('tpl_name');
        $ret['desc'] = $this->getVar('tpl_desc', 'n');
		$ret['file'] = $this->getVar('tpl_file');
        $tpl_options = $this->getVar('tpl_options', 'N');
        $options = unserialize($tpl_options);
        foreach ($options as $option) {
            $ret[$option['name']] = $option['value'];
        }
        $ret['options'] = $options;
		return $ret;
	}

    /**
     * Get Values for admin area
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
	public function getValuesTemplatesAdmin($keys = null, $format = null, $maxDepth = null)
	{
		$wgtimelines = WgtimelinesHelper::getInstance();
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id'] = $this->getVar('tpl_id');
		$ret['name'] = $this->getVar('tpl_name');
        $ret['desc'] = $this->getVar('tpl_desc', 'n');
		$ret['file'] = $this->getVar('tpl_file');
        $options = unserialize($this->getVar('tpl_options', 'N'));
        $ret_options = array();
        foreach ($options as $option) {
            switch ($option['name']) {
                case 'panel_pos':
                    $title = _AM_WGTIMELINES_TEMPLATE_IMGPOS;
                break;
                case 'tabletype':
                    $title = _AM_WGTIMELINES_TEMPLATE_TABLETYPE;
                break;
                case 'imgstyle':
                    $title = _AM_WGTIMELINES_TEMPLATE_IMGSTYLE;
                break;
                case 'bgcolor':
                    $title = _AM_WGTIMELINES_TEMPLATE_BGCOLOR;
                break;
                case 'fontcolor':
                    $title = _AM_WGTIMELINES_TEMPLATE_FONTCOLOR;
                break;
                case 'panel_imgpos':
                    $title = _AM_WGTIMELINES_TEMPLATE_IMGPOS;
                break;
                case 'badgecolor':
                    $title = _AM_WGTIMELINES_TEMPLATE_BADGECOLOR;
                break;
                case 'badgefontcolor':
                    $title = _AM_WGTIMELINES_TEMPLATE_BADGEFONTCOLOR;
                break;
                case 'badgestyle':
                    $title = _AM_WGTIMELINES_TEMPLATE_BADGESTYLE;
                break;
                case 'linecolor':
                    $title = _AM_WGTIMELINES_TEMPLATE_LINECOLOR;
                break;
                case 'borderwidth':
                    $title = _AM_WGTIMELINES_TEMPLATE_BORDERWIDTH;
                break;
                case 'borderstyle':
                    $title = _AM_WGTIMELINES_TEMPLATE_BORDERSTYLE;
                break;
                case 'bordercolor':
                    $title = _AM_WGTIMELINES_TEMPLATE_BORDERCOLOR;
                break;
                case 'borderradius':
                    $title = _AM_WGTIMELINES_TEMPLATE_BORDERRADIUS;
                break;
                case 'boxshadow':
                    $title = _AM_WGTIMELINES_TEMPLATE_BOXSHADOW;
                break;
                case 'orientation':
                    $title = _AM_WGTIMELINES_TEMPLATE_ORIENTATION;
                break;
                case 'datesspeed':
                    $title = _AM_WGTIMELINES_TEMPLATE_DATESSPEED;
                break;
                case 'issuesspeed':
                    $title = _AM_WGTIMELINES_TEMPLATE_ISSUESSPEED;
                break;
                case 'issuestransparency':
                    $title = _AM_WGTIMELINES_TEMPLATE_ISSUESTRANSPARENCY;
                break;case 'issuestransparencyspeed':
                    $title = _AM_WGTIMELINES_TEMPLATE_ISSUESTRANSPARENCYSPEED;
                break;
                case 'autoplay':
                    $title = _AM_WGTIMELINES_TEMPLATE_AUTOPLAY;
                break;
                case 'autoplaydirection':
                    $title = _AM_WGTIMELINES_TEMPLATE_AUTOPLAY_DIRECTION;
                break;
                case 'autoplaypause':
                    $title = _AM_WGTIMELINES_TEMPLATE_AUTOPLAY_PAUSE;
                break;
                case 'arrowkeys':
                    $title = _AM_WGTIMELINES_TEMPLATE_ARROWKEYS;
                break;
                case 'startat':
                    $title = _AM_WGTIMELINES_TEMPLATE_STARTAT;
                break;
                
                case 'else':
                default:
                    $title = $option['name'];
                break;
            }
            $ret_options[] = array('name' => $option['name'], 
                                    'valid' => $option['valid'], 
                                    'value' => $option['value'], 
                                    'title' => $title, 
                                    'type' => $option['type']);
        }
        $ret['options'] = $ret_options;
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
     * Get Count Templates in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
	public function getCountTemplates($start = 0, $limit = 0, $sort = 'tpl_id', $order = 'ASC')
	{
		$crCountTemplates = new CriteriaCompo();
		$crCountTemplates = $this->getTemplatesCriteria($crCountTemplates, $start, $limit, $sort, $order);
		return parent::getCount($crCountTemplates);
	}

    /**
     * Get All Templates in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
	public function getAllTemplates($start = 0, $limit = 0, $sort = 'tpl_weight ASC, tpl_name', $order = 'ASC')
	{
		$crAllTemplates = new CriteriaCompo();
		$crAllTemplates = $this->getTemplatesCriteria($crAllTemplates, $start, $limit, $sort, $order);
		return parent::getAll($crAllTemplates);
	}

    /**
     * Get Criteria Templates
     * @param $crTemplates
     * @param $start
     * @param $limit
     * @param $sort
     * @param $order
     * @return
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
