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
 * @author         goffy (wedega.com) - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 * @version        $Id: 1.0 rss.php 13070 Sat 2016-10-01 05:42:18Z XOOPS Development Team $
 */

$cid = wgtimelines_CleanVars($_GET, 'cid', 0);
include_once XOOPS_ROOT_PATH.'/class/template.php';
if (function_exists('mb_http_output')) {
    mb_http_output('pass');
}
//header ('Content-Type:text/xml; charset=UTF-8');
//$helper->getConfig('utf8') = false;

$tpl = new XoopsTpl();
$tpl->xoops_setCaching(2); //1 = Cache global, 2 = Cache individual (for template)
$tpl->xoops_setCacheTime($wgtimelines->geConfig('timecacherss')*60); // Time of the cache on seconds
$categories = wgtimelinesMyGetItemIds('wgtimelines_view', 'wgtimelines');
$criteria = new \CriteriaCompo();

$criteria->add(new \Criteria('cat_status', 0, '!='));
$criteria->add(new \Criteria('cid', '(' . implode(',', $categories) . ')','IN'));
if ($cid != 0){
    $criteria->add(new \Criteria('cid', $cid));
    $templates = $templatesHandler->get($cid);
    $title = $xoopsConfig['sitename'] . ' - ' . $xoopsModule->getVar('name') . ' - ' . $templates->getVar('tpl_tabletype');
}else{
    $title = $xoopsConfig['sitename'] . ' - ' . $xoopsModule->getVar('name');
}
$criteria->setLimit($wgtimelines->geConfig('perpagerss'));
$criteria->setSort('date');
$criteria->setOrder('DESC');
$templatesArr = $templatesHandler->getAll($criteria);
unset($criteria);

if (!$tpl->is_cached('db:wgtimelines_rss.tpl', $cid)) {
    $tpl->assign('channel_title', htmlspecialchars($title, ENT_QUOTES));
    $tpl->assign('channel_link', XOOPS_URL.'/');
    $tpl->assign('channel_desc', htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES));
    $tpl->assign('channel_lastbuild', formatTimestamp(time(), 'rss'));
    $tpl->assign('channel_webmaster', $xoopsConfig['adminmail']);
    $tpl->assign('channel_editor', $xoopsConfig['adminmail']);
    $tpl->assign('channel_category', 'Event');
    $tpl->assign('channel_generator', 'XOOPS - ' . htmlspecialchars($xoopsModule->getVar('tpl_tabletype'), ENT_QUOTES));
    $tpl->assign('channel_language', _LANGCODE);
    if ( _LANGCODE === 'fr' ) {
        $tpl->assign('docs', 'http://www.scriptol.fr/rss/RSS-2.0.html');
    } else {
        $tpl->assign('docs', 'http://cyber.law.harvard.edu/rss/rss.html');
    }
    $tpl->assign('image_url', XOOPS_URL . $xoopsModuleConfig['logorss']);
    $dimention = getimagesize(XOOPS_ROOT_PATH . $xoopsModuleConfig['logorss']);
    if (empty($dimention[0])) {
        $width = 88;
    } else {
       $width = ($dimention[0] > 144) ? 144 : $dimention[0];
    }
    if (empty($dimention[1])) {
        $height = 31;
    } else {
        $height = ($dimention[1] > 400) ? 400 : $dimention[1];
    }
    $tpl->assign('image_width', $width);
    $tpl->assign('image_height', $height);
    foreach (array_keys($templatesArr) as $i) {
        $description = $templatesArr[$i]->getVar('description');
        //permet d'afficher uniquement la description courte
        if (strpos($description,'[pagebreak]')==false){
            $description_short = $description;
        }else{
            $description_short = substr($description,0,strpos($description,'[pagebreak]'));
        }
        $tpl->append('items', array('title' => htmlspecialchars($templatesArr[$i]->getVar('tpl_tabletype'), ENT_QUOTES),
                                    'link' => XOOPS_URL . '/modules/wgtimelines/single.php?cid=' . $templatesArr[$i]->getVar('cid') . '&amp;tpl_id=' . $templatesArr[$i]->getVar('tpl_id'),
                                    'guid' => XOOPS_URL . '/modules/wgtimelines/single.php?cid=' . $templatesArr[$i]->getVar('cid') . '&amp;tpl_id=' . $templatesArr[$i]->getVar('tpl_id'),
                                    'pubdate' => formatTimestamp($templatesArr[$i]->getVar('date'), 'rss'),
                                    'description' => htmlspecialchars($description_short, ENT_QUOTES)));
    }
}
header('Content-Type:text/xml; charset=' . _CHARSET);
$tpl->display('db:wgtimelines_rss.tpl', $cid);
