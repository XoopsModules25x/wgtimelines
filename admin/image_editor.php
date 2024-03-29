<?php

declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * wgTeams module for xoops
 *
 * @copyright      module for xoops
 * @license        GPL 2.0 or later
 * @package        wgtimelines
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version        $Id: 1.0 albums.php 1 Mon 2018-03-19 10:04:50Z XOOPS Project (www.xoops.org) $
 */

use Xmf\Request;
use XoopsModules\Wgtimelines;
use XoopsModules\Wgtimelines\Constants;

include __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wgtimelines_admin_image_editor.tpl';

require_once \XOOPS_ROOT_PATH . '/header.php';

$utility = new \XoopsModules\Wgtimelines\Utility();

$op         = Request::getString('op', 'list');
$itemId     = Request::getInt('item_id');
$origin     = Request::getString('imageOrigin');
$timelineId = Request::getInt('tl_id');
$start      = Request::getInt('start');
$limit      = Request::getInt('limit', $helper->getConfig('adminpager'));

// get all objects/classes/vars needed for image editor
$imageClass = 0;
$imgCurrent = [];
if ('item_id' === $origin) {
    $itemId = Request::getInt('imageIdCrop');
}
if ('tl_id' === $origin) {
    $timelineId = Request::getInt('imageIdCrop');
}
if ( 0 < $itemId ) {
    $imageId      = $itemId;
    $imageHandler = $itemsHandler;
    $imageObj     = $itemsHandler->get($imageId);
    $imageTlId    = $itemsHandler->get($imageId)->getVar('item_tl_id');
    $imageClass   = Constants::IMAGECLASS_ITEM;
    $imageOrigin  = 'item_id';
} else {
    if ($timelineId > 0) {
        $imageId      = $timelineId;
        $imageObj     = $timelinesHandler->get($imageId);
        $imageHandler = $timelinesHandler;
        $imageClass   = Constants::IMAGECLASS_TIMELINE;
        $imageOrigin  = 'tl_id';
    } else {
        \redirect_header('index.php', 3, \_AM_WGTIMELINES_FORM_ERROR_INVALID_ID);
    }
}

if ($imageClass === Constants::IMAGECLASS_ITEM) {
    $imgName  = 'item' . $imageId . '.jpg';
    $imageDir = '/uploads/wgtimelines/images/items/';
    $imgPath  = \XOOPS_ROOT_PATH . $imageDir;
    $imgUrl   = \XOOPS_URL . $imageDir;
    $imgFinal = $imgPath . $imgName;
    $imgTemp  = \WGTIMELINES_UPLOAD_PATH . '/temp/' . $imgName;
    $redir    = "items.php?op=list&amp;item_id=$imageId&amp;tl_id=$imageTlId&amp;start=$start&amp;limit=$limit";
    $nameObj  = 'item_title';
    $fieldObj = 'item_image';
    $submObj  = 'item_submitter';
} else {
    $imgName  = 'timeline' . $imageId . '.jpg';
    $imageDir = '/uploads/wgtimelines/images/timelines/';
    $imgPath  = \XOOPS_ROOT_PATH . $imageDir;
    $imgUrl   = \XOOPS_URL . $imageDir;
    $imgFinal = $imgPath . $imgName;
    $imgTemp  = \WGTIMELINES_UPLOAD_PATH . '/temp/' . $imgName;
    $redir    = 'timelines.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit;
    $nameObj  = 'tl_name';
    $fieldObj = 'tl_image';
    $submObj  = 'tl_submitter';
}

$imgCurrent['img_name'] = $imageObj->getVar($fieldObj);
$imgCurrent['src'] = $imgUrl . $imageObj->getVar($fieldObj);
$imgCurrent['origin'] = $imageClass;
$images = [];
if ('blank.gif' !== $imageObj->getVar($fieldObj)) {
    $GLOBALS['xoopsTpl']->assign('no_blank', true);
}

$image_array = \XoopsLists::getImgListAsArray($imgPath);
$i = 0;
foreach ($image_array as $image_img) {
    if ('blank.gif' !== $image_img) {
        $i++;
        $images[$i]['id'] = 'imageSelect'.$i;
        $images[$i]['name'] = $image_img;
        $images[$i]['title'] = $image_img;
        $images[$i]['origin'] = Constants::IMAGECLASS_ITEM;
        if ($imgCurrent['img_name'] === $image_img) {
            $images[$i]['selected'] = 1;
        }     
        $images[$i]['src'] = $imgUrl . $image_img;
    }
}
// var_dump($images);
$GLOBALS['xoopsTpl']->assign('images', $images);
unset($images);
// end: get all objects/classes/vars needed for image editor

$uid = $xoopsUser instanceof \XoopsUser ? $xoopsUser->id() : 0;

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet(\WGTIMELINES_URL . '/assets/css/style.css');
$GLOBALS['xoTheme']->addStylesheet(\WGTIMELINES_URL . '/assets/css/imageeditor.css');

// add scripts
$GLOBALS['xoTheme']->addScript(\XOOPS_URL . '/modules/wgtimelines/assets/js/admin.js');

// assign vars
$GLOBALS['xoopsTpl']->assign('wgtimelines_url', \WGTIMELINES_URL);
$GLOBALS['xoopsTpl']->assign('wgtimelines_icon_url_16', \WGTIMELINES_ICONS_URL . '/16');
$GLOBALS['xoopsTpl']->assign('wgtimelines_icon_url_32', \WGTIMELINES_ICONS_URL . '/32');
$GLOBALS['xoopsTpl']->assign('wgtimelines_upload_url', \WGTIMELINES_UPLOAD_URL);
$GLOBALS['xoopsTpl']->assign('wgtimelines_upload_path', \WGTIMELINES_UPLOAD_PATH);
$GLOBALS['xoopsTpl']->assign('wgtimelines_upload_image_url', $imgUrl);
$GLOBALS['xoopsTpl']->assign('gridtarget', $imgName);
$GLOBALS['xoopsTpl']->assign('imgCurrent', $imgCurrent);
$GLOBALS['xoopsTpl']->assign('imageId', $imageId);
$GLOBALS['xoopsTpl']->assign('imageOrigin', $imageOrigin);
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);

// Breadcrumbs
$GLOBALS['xoopsTpl']->assign('show_breadcrumbs', $helper->getConfig('show_breadcrumbs'));
$xoBreadcrumbs[] = ['title' => \_AM_WGTIMELINES_IMG_EDITOR];

// get config for images
$maxwidth  = $helper->getConfig('maxwidth_imgeditor');
$maxheight = $helper->getConfig('maxheight_imgeditor');
$maxsize   = $helper->getConfig('maxsize');
$mimetypes = $helper->getConfig('mimetypes');

switch ($op) {

    case 'creategrid':
        // create an image grid based on given sources
        $type   = Request::getInt('type', 4);
        $src[1] = Request::getString('src1');
        $src[2] = Request::getString('src2');
        $src[3] = Request::getString('src3');
        $src[4] = Request::getString('src4');
        $src[5] = Request::getString('src5');
        $src[6] = Request::getString('src6');
        $target = Request::getString('target');
        // replace thumbs dir by dir for medium images, only for wggallery
        // $src[1] = \str_replace('/thumbs/', '/medium/', $src[1]);
        // $src[2] = \str_replace('/thumbs/', '/medium/', $src[2]);
        // $src[3] = \str_replace('/thumbs/', '/medium/', $src[3]);
        // $src[4] = \str_replace('/thumbs/', '/medium/', $src[4]);
        // $src[5] = \str_replace('/thumbs/', '/medium/', $src[5]);
        // $src[6] = \str_replace('/thumbs/', '/medium/', $src[6]);
        
        $images = [];
        for ($i = 1; $i <= 6; $i++) {
            if ('' !== $src[$i]) {
                $file       = \str_replace(\XOOPS_URL, \XOOPS_ROOT_PATH, $src[$i]);
                $images[$i] = ['file' => $file, 'mimetype' => \mime_content_type($file)];
            }
        }

        // create basic image
        $tmp   = \imagecreatetruecolor($maxwidth, $maxheight);
        $imgBg = imagecolorallocate($tmp, 0, 0, 0);
        imagefilledrectangle($tmp, 0, 0, $maxwidth, $maxheight, $imgBg);

        $final = XOOPS_UPLOAD_PATH . '/wgtimelines/temp/' . $target;
        \unlink($final);
        \imagejpeg($tmp, $final);
        \imagedestroy($tmp);

        $imgTemp = XOOPS_UPLOAD_PATH . '/wgtimelines/temp/' . $uid . 'imgTemp';

        $imgHandler = new Wgtimelines\Resizer();
        if (4 === $type) {
            for ($i = 1; $i <= 4; $i++) {
                \unlink($imgTemp . $i . '.jpg');
                $imgHandler->sourceFile    = $images[$i]['file'];
                $imgHandler->endFile       = $imgTemp . $i . '.jpg';
                $imgHandler->imageMimetype = $images[$i]['mimetype'];
                $imgHandler->maxWidth      = (int)\round($maxwidth / 2 - 1);
                $imgHandler->maxHeight     = (int)\round($maxheight / 2 - 1);
                $imgHandler->jpgQuality    = 90;
                $imgHandler->resizeAndCrop();
            }
            $imgHandler->mergeType = 4;
            $imgHandler->endFile   = $final;
            $imgHandler->maxWidth  = $maxwidth;
            $imgHandler->maxHeight = $maxheight;
            for ($i = 1; $i <= 4; $i++) {
                $imgHandler->sourceFile = $imgTemp . $i . '.jpg';
                $imgHandler->mergePos   = $i;
                $imgHandler->mergeImage();
                \unlink($imgTemp . $i . '.jpg');
            }
        }
        if (6 === $type) {
            for ($i = 1; $i <= 6; $i++) {
                $imgHandler->sourceFile    = $images[$i]['file'];
                $imgHandler->endFile       = $imgTemp . $i . '.jpg';
                $imgHandler->imageMimetype = $images[$i]['mimetype'];
                $imgHandler->maxWidth      = (int)\round($maxwidth / 3 - 1);
                $imgHandler->maxHeight     = (int)\round($maxheight / 2 - 1);
                $imgHandler->resizeAndCrop();
            }
            $imgHandler->mergeType = 6;
            $imgHandler->endFile   = $final;
            $imgHandler->maxWidth  = $maxwidth;
            $imgHandler->maxHeight = $maxheight;
            for ($i = 1; $i <= 6; $i++) {
                $imgHandler->sourceFile = $imgTemp . $i . '.jpg';
                $imgHandler->mergePos   = $i;
                $imgHandler->mergeImage();
                \unlink($imgTemp . $i . '.jpg');
            }
        }

        break; 

    case 'cropimage':
        // save base64_image and resize to maxwidth/maxheight
        $base64_image_content = Request::getString('croppedImage');
        if (\preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            \file_put_contents($imgTemp, base64_decode(\str_replace($result[1], '', $base64_image_content), true));
        }

        $imgHandler                = new Wgtimelines\Resizer();
        $imgHandler->sourceFile    = $imgTemp;
        $imgHandler->endFile       = $imgTemp;
        $imgHandler->imageMimetype = 'image/jpeg';
        $imgHandler->maxWidth      = $maxwidth;
        $imgHandler->maxHeight     = $maxheight;
        $ret                       = $imgHandler->resizeImage();

        \unlink($imgFinal);
        break;
    case 'saveImageSelected':
        // save image selected from list of available images in upload folder
        // Set Vars
        $image_id = Request::getString('image_id');
        // remove '_image' from id
        $image_id = \substr($image_id, 0, -6);
        $imageObj->setVar($fieldObj, $image_id);
        $imageObj->setVar($submObj, $uid);
        // Insert Data
        if ($imageHandler->insert($imageObj)) {  
            \redirect_header($redir, 2, \_AM_WGTIMELINES_FORM_OK);
        }
        $GLOBALS['xoopsTpl']->assign('error', $imageObj->getHtmlErrors());
        break;
        
    case 'saveGrid':
        // save before created grid image
        $imgTempGrid = Request::getString('gridImgFinal');
        $ret = \rename($imgTempGrid, $imgFinal);
        // Set Vars
        $imageObj->setVar($fieldObj, $imgName);
        $imageObj->setVar($submObj, $uid);
        // Insert Data
        if ($imageHandler->insert($imageObj)) {
            \redirect_header($redir, 2, \_AM_WGTIMELINES_FORM_OK);
        }
        $GLOBALS['xoopsTpl']->assign('error', $imageObj->getHtmlErrors());

        break;
    case 'saveCrop':
        // save before created grid image
        $ret = \rename($imgTemp, $imgFinal);
        // Set Vars
        $imageObj->setVar($fieldObj, $imgName);
        $imageObj->setVar($submObj, $uid);
        // Insert Data
        if ($imageHandler->insert($imageObj, true)) {
            \redirect_header($redir, 2, \_AM_WGTIMELINES_FORM_OK);
        }
        $GLOBALS['xoopsTpl']->assign('error', $imageObj->getHtmlErrors());

        break;
    case 'uploadImage':
        // Set Vars
        require_once \XOOPS_ROOT_PATH . '/class/uploader.php';
        $fileName       = $_FILES['attachedfile']['name'];
        $imageMimetype  = $_FILES['attachedfile']['type'];
        $uploaderErrors = '';
        $uploader       = new \XoopsMediaUploader($imgPath, $mimetypes, $maxsize, null, null);
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            $extension = \preg_replace('/^.+\.([^.]+)$/sU', '', $fileName);
            $imgName   = 'image_' . $itemId . '.' . $extension;
            $uploader->setPrefix($imgName);
            $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
            if (!$uploader->upload()) {
                $uploaderErrors = $uploader->getErrors();
            } else {
                $savedFilename = $uploader->getSavedFileName();
                $imageObj->setVar($fieldObj, $savedFilename);
                // resize image
                $maxwidth  = $helper->getConfig('maxwidth_imgeditor');
                $maxheight = $helper->getConfig('maxheight_imgeditor');
                $imgHandler                = new Wgtimelines\Resizer();
                $imgHandler->sourceFile    = $imgPath . $savedFilename;
                $imgHandler->endFile       = $imgPath . $savedFilename;
                $imgHandler->imageMimetype = $imageMimetype;
                $imgHandler->maxWidth      = $maxwidth;
                $imgHandler->maxHeight     = $maxheight;
                $result                    = $imgHandler->resizeImage();

                $imageObj->setVar($fieldObj, $savedFilename);
                $imageObj->setVar($submObj, $uid);
            }
        } else {
            if ($fileName > '') {
                $uploaderErrors = $uploader->getErrors();
            }
        }
        if ('' !== $uploaderErrors) {
            \redirect_header($redir, $uploaderErrors);
        }
        // Insert Data
        if ($imageHandler->insert($imageObj)) {
            \redirect_header($redir, 2, \_AM_WGTIMELINES_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $imageObj->getHtmlErrors());
        $form = $imageObj->getFormUploadImage($imageOrigin, $imageId);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
        
    case 'imghandler':
    default:
        $GLOBALS['xoTheme']->addStylesheet(\WGTIMELINES_URL . '/assets/css/cropper.min.css');
        $GLOBALS['xoTheme']->addScript(\WGTIMELINES_URL . '/assets/js/cropper.min.js');
        $GLOBALS['xoTheme']->addScript(\WGTIMELINES_URL . '/assets/js/cropper-main.js');

        $GLOBALS['xoopsTpl']->assign('nbModals', [1, 2, 3, 4, 5, 6]);
        
        // get form for upload album image
        $currImage   = $imageObj->getVar($fieldObj);
        if ('' == $currImage) {
            $currImage = 'blank.gif';
        }
        $image_path = $imgPath . $currImage;
        // get size of current album image
        list($width, $height, $type, $attr) = \getimagesize($image_path);
        $GLOBALS['xoopsTpl']->assign('image_path', $image_path);
        $GLOBALS['xoopsTpl']->assign('albimage_width', $width);
        $GLOBALS['xoopsTpl']->assign('albimage_height', $height);
        
        $form = getFormUploadImage($imageOrigin, $imageId);
        $GLOBALS['xoopsTpl']->assign('form_uploadimage', $form->render());

        $GLOBALS['xoopsTpl']->assign('btn_style', 'btn-default');

        break;
}

$GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));

// Description
// $utility::getMetaDescription(\_AM_WGTIMELINES_ALBUMS);

include __DIR__ . '/footer.php';

/**
 * @public function getFormUploadAlbumimage:
 * provide form for uploading a new album image
 * @param $imageOrigin
 * @param $imageId
 * @return \XoopsThemeForm
 */
function getFormUploadImage($imageOrigin, $imageId)
{
    $helper = \XoopsModules\Wgtimelines\Helper::getInstance();
    // Get Theme Form
    \xoops_load('XoopsFormLoader');
    $form = new \XoopsThemeForm('', 'formuploadimmage', 'image_editor.php', 'post', true);
    $form->setExtra('enctype="multipart/form-data"');
    // upload new image
    $imageTray3      = new \XoopsFormElementTray(\_AM_WGTIMELINES_FORM_UPLOAD_IMG, '<br>');
    $imageFileSelect = new \XoopsFormFile('', 'attachedfile', $helper->getConfig('maxsize'));
    $imageTray3->addElement($imageFileSelect);
    $form->addElement($imageTray3);

    $form->addElement(new \XoopsFormHidden($imageOrigin, $imageId));
    $form->addElement(new \XoopsFormHidden('op', 'uploadImage'));
    $form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));

    return $form;
}
