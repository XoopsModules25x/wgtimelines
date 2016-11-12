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
 * @version        $Id: 1.0 modinfo.php 13070 Sat 2016-10-01 05:42:16Z XOOPS Development Team $
 */
// ---------------- Admin Main ----------------
define('_MI_WGTIMELINES_NAME', 'wgTimelines');
define('_MI_WGTIMELINES_DESC', 'Dieses Modul ermöglicht das Erstellen von Chroniken/Zeitreihen und die Anzeige in verschiedenen Varianten.');
// ---------------- Admin Menu ----------------
define('_MI_WGTIMELINES_ADMENU1', 'Dashboard');
define('_MI_WGTIMELINES_ADMENU2', 'Zeitreihen');
define('_MI_WGTIMELINES_ADMENU3', 'Einträge');
define('_MI_WGTIMELINES_ADMENU4', 'Vorlagen');
define('_MI_WGTIMELINES_ABOUT', 'Über');
// Blocks
define('_MI_WGTIMELINES_TIMELINES_BLOCK_TIMELINE', 'Block Zeitreihen');
define('_MI_WGTIMELINES_TIMELINES_BLOCK_TIMELINE_DESC', 'Anzeige einer Liste der Zeitreihen');
// Config
define('_MI_WGTIMELINES_ADMIN_PAGER', 'Admin Listenzeilen');
define('_MI_WGTIMELINES_ADMIN_PAGER_DESC', 'Anzahl der Zeilen für Listen im Admin-Bereich');
define('_MI_WGTIMELINES_USER_PAGER', 'User Listenzeilen');
define('_MI_WGTIMELINES_USER_PAGER_DESC', 'Anzahl der Zeilen für Listen auf Userseite');
define('_MI_WGTIMELINES_KEYWORDS', 'Schlüsselwörter');
define('_MI_WGTIMELINES_KEYWORDS_DESC', 'Bitte Ihre Schlüsselwörter eingeben (getrennt durch Beistrich)');
define('_MI_WGTIMELINES_EDITOR', 'Editor');
define('_MI_WGTIMELINES_EDITOR_DESC', 'Bitte Editor für die Eingabefelder wählen');
define('_MI_WGTIMELINES_MAXSIZE', 'Maximale Größe');
define('_MI_WGTIMELINES_MAXSIZE_DESC', 'Definieren Sie bitte die maximale Größe für einen Dateiupload in byte');
define('_MI_WGTIMELINES_MIMETYPES', 'Mime Types');
define('_MI_WGTIMELINES_MIMETYPES_DESC', 'Definieren Sie bitte die zulässigen Dateitypen');
define('_MI_WGTIMELINES_BREADCRUMBS', 'Breadcrumb-Navigation anzeigen');
define('_MI_WGTIMELINES_BREADCRUMBS_DESC', 'Definieren Sie bitte, ob eine Breadcrumb-Navigation angezeigt werden soll');
define('_MI_WGTIMELINES_BOOKMARKS', 'Social Bookmarks');
define('_MI_WGTIMELINES_BOOKMARKS_DESC', 'Social Bookmarks in den Seiten anzeigen');
define('_MI_WGTIMELINES_FACEBOOK_COMMENTS', 'Facebook-Kommentare');
define('_MI_WGTIMELINES_FACEBOOK_COMMENTS_DESC', 'Facebook-Kommentare in den Seiten zulassen');
define('_MI_WGTIMELINES_DISQUS_COMMENTS', 'Disqus-Kommentare');
define('_MI_WGTIMELINES_DISQUS_COMMENTS_DESC', 'Disqus-Kommentare in den Seiten zulassen');
define('_MI_WGTIMELINES_WELCOME', 'Willkommensnachricht');
define('_MI_WGTIMELINES_WELCOME_DESC', 'Diese Willkommensnachricht wird vor Ihrer Zeitreihe/Chronik angezeigt');
define('_MI_WGTIMELINES_WELCOME_DEFAULT', 'Willkommen bei der Zeitreihe auf ' . $xoopsConfig['sitename']);
define('_MI_WGTIMELINES_TIMELINE_NAME', 'Name Zeitreihe anzeigen');
define('_MI_WGTIMELINES_TIMELINE_NAME_DESC', 'Bitte wählen Sie, ob der Name der Zeitreiche auf der Userseite angezeigt werden soll');
// ---------------- End ----------------
