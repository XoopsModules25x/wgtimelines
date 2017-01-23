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
 * @version        $Id: 1.0 rate.php 13070 Wed 2016-12-14 22:22:38Z XOOPS Development Team $
 */
include __DIR__ . '/header.php';
$op     = XoopsRequest::getString('op', 'default');
 
switch ($op) {
    case 'save-index':
    case 'save-item':
        // Security Check
        if ($GLOBALS['xoopsSecurity']->check()) {
            redirect_header('index.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }

        $itemid       = XoopsRequest::getInt('item_id');
        $rating       = XoopsRequest::getInt('rating');
        $tl_id        = XoopsRequest::getInt('tl_id', 0);

        $groups       = (isset($GLOBALS['xoopsUser']) && is_object($GLOBALS['xoopsUser'])) ? $GLOBALS['xoopsUser']->getGroups() : XOOPS_GROUP_ANONYMOUS;
        // Checking permissions
        $rate_allowed = false;
        if ($wgtimelines->getConfig('ratingbars')) {
            foreach ($groups as $group) {
                if (XOOPS_GROUP_ADMIN == $group || in_array($group, $wgtimelines->getConfig('ratingbar_groups'))) {
                    $rate_allowed = true;
                    break;
                }
            }
        }

        if (!$rate_allowed) {
            redirect_header(WGTIMELINES_URL . '/index.php?tl_id=' . $tl_id . '#item' . $itemid, 2, _MA_WGTIMELINES_RATING_NOPERM);
        }

        $redir = $_SERVER['HTTP_REFERER'];
        if ($op === 'save-index') {
            $redir = $_SERVER['HTTP_REFERER'] . '#item' . $itemid;
        }
        
        if ($rating > 5 || $rating < 1) {
            redirect_header($redir, 2, _MA_WGTIMELINES_RATING_VOTE_BAD);
            exit();
        }
        
        $itemrating = $ratingsHandler->getItemRating($itemid);
        
        if ($itemrating['voted']) {
            redirect_header($redir, 2, _MA_WGTIMELINES_RATING_VOTE_ALREADY);
        }

        $ratingsObj = $ratingsHandler->create();
        $ratingsObj->setVar('rate_itemid', $itemid);
        $ratingsObj->setVar('rate_value', $rating);
        $ratingsObj->setVar('rate_uid', $itemrating['uid']);
        $ratingsObj->setVar('rate_ip', $itemrating['ip']);
        $ratingsObj->setVar('rate_date', time());
        // Insert Data
        if ($ratingsHandler->insert($ratingsObj)) {
            redirect_header($redir, 2, _MA_WGTIMELINES_RATING_VOTE_THANKS);
        }
        echo '<br>error:' . $ratingsObj->getHtmlErrors();

        break;
    
    case 'default':
    default:
        echo _MA_WGTIMELINES_RATING_VOTE_BAD . ' (invalid parameter)';
        break;
}
