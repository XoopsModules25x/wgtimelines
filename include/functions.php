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
 * @version        $Id: 1.0 functions.php 13070 Sat 2016-10-01 05:42:17Z XOOPS Development Team $
 */

/***************Blocks**************
 * @param $cats
 * @return string
 */
function wgtimelines_block_addCatSelect($cats)
{
    if (is_array($cats)) {
        $cat_sql = '('.current($cats);
        array_shift($cats);
        foreach ($cats as $cat) {
            $cat_sql .= ','.$cat;
        }
        $cat_sql .= ')';
    }
    return $cat_sql;
}

/**
 *  Get the number of templates from the sub categories of a category or sub topics of or topic
 * @param $mytree
 * @param $templates
 * @param $entries
 * @param $cid
 * @return int
 */
function wgtimelinesNumbersOfEntries($mytree, $templates, $entries, $cid)
{
    $count = 0;
    if (in_array($cid, $templates)) {
        $child = $mytree->getAllChild($cid);
        foreach (array_keys($entries) as $i) {
            if ($entries[$i]->getVar('tpl_id') == $cid) {
                $count++;
            }
            foreach (array_keys($child) as $j) {
                if ($entries[$i]->getVar('tpl_id') == $j) {
                    $count++;
                }
            }
        }
    }
    return $count;
}

function wgtimelinesMetaKeywords($content)
{
    global $xoopsTpl, $xoTheme;
    $myts = MyTextSanitizer::getInstance();
    $content= $myts->undoHtmlSpecialChars($myts->displayTarea($content));
    if (isset($xoTheme) && is_object($xoTheme)) {
        $xoTheme->addMeta('meta', 'keywords', strip_tags($content));
    } else {    // Compatibility for old Xoops versions
        $xoopsTpl->assign('xoops_meta_keywords', strip_tags($content));
    }
}

function wgtimelinesMetaDescription($content)
{
    global $xoopsTpl, $xoTheme;
    $myts = MyTextSanitizer::getInstance();
    $content = $myts->undoHtmlSpecialChars($myts->displayTarea($content));
    if (isset($xoTheme) && is_object($xoTheme)) {
        $xoTheme->addMeta('meta', 'description', strip_tags($content));
    } else {    // Compatibility for old Xoops versions
        $xoopsTpl->assign('xoops_meta_description', strip_tags($content));
    }
}

/**
 * Rewrite all url
 *
 * @String  $module  module name
 * @String  $array   array
 * @param        $module
 * @param        $array
 * @param string $type
 * @return string $type    string replacement for any blank case
 */
function wgtimelines_RewriteUrl($module, $array, $type = 'content')
{
    $comment = '';
    $wgtimelines = WgtimelinesHelper::getInstance();
    $templates = $wgtimelines->getHandler('templates');
    $lenght_id = $wgtimelines->getConfig('lenght_id');
    $rewrite_url = $wgtimelines->getConfig('rewrite_url');

    if ($lenght_id != 0) {
        $id = $array['content_id'];
        while (strlen($id) < $lenght_id) {
            $id = '0' . $id;
        }
    } else {
        $id = $array['content_id'];
    }

    if (isset($array['topic_alias']) && $array['topic_alias']) {
        $topic_name = $array['topic_alias'];
    } else {
        $topic_name = wgtimelines_Filter(xoops_getModuleOption('static_name', $module));
    }

    switch ($rewrite_url) {

        case 'none':
            if ($topic_name) {
                $topic_name = 'topic=' . $topic_name . '&amp;';
            }
            $rewrite_base = '/modules/';
            $page = 'page=' . $array['content_alias'];
            return XOOPS_URL . $rewrite_base . $module . '/' . $type . '.php?' . $topic_name . 'id=' . $id . '&amp;' . $page . $comment;
            break;

        case 'rewrite':
            if ($topic_name) {
                $topic_name .= '/';
            }
            $rewrite_base = xoops_getModuleOption('rewrite_mode', $module);
            $rewrite_ext = xoops_getModuleOption('rewrite_ext', $module);
            $module_name = '';
            if (xoops_getModuleOption('rewrite_name', $module)) {
                $module_name = xoops_getModuleOption('rewrite_name', $module) . '/';
            }
            $page = $array['content_alias'];
            $type .= '/';
            $id .= '/';
            if ($type === 'content/') {
                $type = '';
            }

            if ($type === 'comment-edit/' || $type === 'comment-reply/' || $type === 'comment-delete/') {
                return XOOPS_URL . $rewrite_base . $module_name . $type . $id . '/';
            }

            return XOOPS_URL . $rewrite_base . $module_name . $type . $topic_name  . $id . $page . $rewrite_ext;
            break;

         case 'short':
            if ($topic_name) {
                $topic_name .= '/';
            }
            $rewrite_base = xoops_getModuleOption('rewrite_mode', $module);
            $rewrite_ext = xoops_getModuleOption('rewrite_ext', $module);
            $module_name = '';
            if (xoops_getModuleOption('rewrite_name', $module)) {
                $module_name = xoops_getModuleOption('rewrite_name', $module) . '/';
            }
            $page = $array['content_alias'];
            $type .= '/';
            if ($type === 'content/') {
                $type = '';
            }

            if ($type === 'comment-edit/' || $type === 'comment-reply/' || $type === 'comment-delete/') {
                return XOOPS_URL . $rewrite_base . $module_name . $type . $id . '/';
            }

            return XOOPS_URL . $rewrite_base . $module_name . $type . $topic_name . $page . $rewrite_ext;
            break;
    }
}

/**
 * Replace all escape, character, ... for display a correct url
 *
 * @String  $url    string to transform
 * @String  $type   string replacement for any blank case
 * @param        $url
 * @param string $type
 * @param string $module
 * @return mixed|string $url
 */
function wgtimelines_Filter($url, $type = '', $module = 'wgtimelines')
{

    // Get regular expression from module setting. default setting is : `[^a-z0-9]`i
    $wgtimelines = WgtimelinesHelper::getInstance();
    $templates = $wgtimelines->getHandler('templates');
    $regular_expression = $wgtimelines->getConfig('regular_expression');

    $url = strip_tags($url);
    $url = preg_replace("`\[.*\]`U", '', $url);
    $url = preg_replace('`&(amp;)?#?[a-z0-9]+;`i', '-', $url);
    $url = htmlentities($url, ENT_COMPAT, 'utf-8');
    $url = preg_replace('`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', "\1", $url);
    $url = preg_replace(array($regular_expression,
                              '`[-]+`'
                        ), '-', $url);
    $url = ($url == '') ? $type : strtolower(trim($url, '-'));
    return $url;
}
