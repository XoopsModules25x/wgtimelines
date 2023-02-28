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
 * @version        $Id: 1.0 modinfo.php 13070 Sat 2016-10-01 05:42:16Z XOOPS Development Team $
 */

require_once __DIR__ . '/common.php';

// ---------------- Admin Main ----------------
\define('_MI_WGTIMELINES_NAME', 'wgTimelines');
\define('_MI_WGTIMELINES_DESC', 'Dieses Modul ermöglicht das Erstellen von Chroniken/Zeitreihen und die Anzeige in verschiedenen Varianten.');
// ---------------- Admin Menu ----------------
\define('_MI_WGTIMELINES_ADMENU1', 'Dashboard');
\define('_MI_WGTIMELINES_ADMENU2', 'Zeitreihen');
\define('_MI_WGTIMELINES_ADMENU3', 'Einträge');
\define('_MI_WGTIMELINES_ADMENU4', 'Vorlagen');
\define('_MI_WGTIMELINES_FEEDBACK', 'Feedback');
\define('_MI_WGTIMELINES_ABOUT', 'Über');
// Blocks
\define('_MI_WGTIMELINES_TIMELINES_BLOCK_TIMELINE', 'Block Zeitreihen');
\define('_MI_WGTIMELINES_TIMELINES_BLOCK_TIMELINE_DESC', 'Anzeige einer Liste der Zeitreihen');
\define('_MI_WGTIMELINES_ITEMS_BLOCK_ITEM', 'Block Einträge');
\define('_MI_WGTIMELINES_ITEMS_BLOCK_ITEM_DESC', 'Anzeige einer Liste von Einträgen');
// Config
\define('_MI_WGTIMELINES_ADMIN_PAGER', 'Admin Listenzeilen');
\define('_MI_WGTIMELINES_ADMIN_PAGER_DESC', 'Anzahl der Zeilen für Listen im Admin-Bereich');
\define('_MI_WGTIMELINES_USER_PAGER', 'User Listenzeilen');
\define('_MI_WGTIMELINES_USER_PAGER_DESC', 'Anzahl der Zeilen für Listen auf Userseite');
\define('_MI_WGTIMELINES_KEYWORDS', 'Schlüsselwörter');
\define('_MI_WGTIMELINES_KEYWORDS_DESC', 'Bitte Ihre Schlüsselwörter eingeben (getrennt durch Beistrich)');
\define('_MI_WGTIMELINES_KEYWORDS_DEFAULT', 'wgtimelines, Zeitreihe, Chronik, Einträge, vorlagenbasiert, bootstrap, XOOPS');
\define('_MI_WGTIMELINES_EDITOR', 'Editor');
\define('_MI_WGTIMELINES_EDITOR_DESC', 'Bitte Editor für die Eingabefelder wählen');
\define('_MI_WGTIMELINES_MAXSIZE', 'Maximale Größe');
\define('_MI_WGTIMELINES_MAXSIZE_DESC', 'Definieren Sie bitte die maximale Größe für einen Dateiupload');
\define('_MI_WGTIMELINES_SIZE_MB', 'MB');
\define('_MI_WGTIMELINES_MIMETYPES', 'Mime Types');
\define('_MI_WGTIMELINES_MIMETYPES_DESC', 'Definieren Sie bitte die zulässigen Dateitypen');
\define('_MI_WGTIMELINES_MAXWIDTH', 'Maximale Breite für Bilder');
\define('_MI_WGTIMELINES_MAXWIDTH_DESC', 'Definieren Sie die maximale Breite, auf die die hochgeladenen Bilder automatisch verkleinert werden sollen (in pixel)<br>0 bedeutet, dass Bilder die Originalgröße behalten. <br>Sofern das Originalbild kleiner sein sollte, so wird dieses nicht vergrößert.');
\define('_MI_WGTIMELINES_MAXHEIGHT', 'Maximale Höhe für Bilder');
\define('_MI_WGTIMELINES_MAXHEIGHT_DESC', 'Definieren Sie die maximale Höhe, auf die die hochgeladenen Bilder automatisch verkleinert werden sollen (in pixel)<br>0 bedeutet, dass Bilder die Originalgröße behalten. <br>Sofern das Originalbild kleiner sein sollte, so wird dieses nicht vergrößert.');
\define('_MI_WGTIMELINES_MAXWIDTH_IMGEDITOR', 'Maximale Breite für bearbeitete Bilder');
\define('_MI_WGTIMELINES_MAXWIDTH_IMGEDITOR_DESC', 'Definieren Sie die maximale Breite, auf die die im Bildeditor bearbeiteten Bilder automatisch verkleinert werden sollen (in pixel)<br>0 bedeutet, dass Bilder die Originalgröße behalten. <br>Sofern das Originalbild kleiner sein sollte, so wird dieses nicht vergrößert.');
\define('_MI_WGTIMELINES_MAXHEIGHT_IMGEDITOR', 'Maximale Höhe für bearbeitete Bilder');
\define('_MI_WGTIMELINES_MAXHEIGHT_IMGEDITOR_DESC', 'Definieren Sie die maximale Höhe, auf die die  im Bildeditor bearbeiteten Bilder automatisch verkleinert werden sollen (in pixel)<br>0 bedeutet, dass Bilder die Originalgröße behalten. <br>Sofern das Originalbild kleiner sein sollte, so wird dieses nicht vergrößert.');
\define('_MI_WGTIMELINES_BREADCRUMBS', 'Breadcrumb-Navigation anzeigen');
\define('_MI_WGTIMELINES_BREADCRUMBS_DESC', 'Definieren Sie bitte, ob eine Breadcrumb-Navigation angezeigt werden soll');
\define('_MI_WGTIMELINES_WELCOME', 'Willkommensnachricht');
\define('_MI_WGTIMELINES_WELCOME_DESC', 'Diese Willkommensnachricht wird vor Ihrer Zeitreihe/Chronik angezeigt');
\define('_MI_WGTIMELINES_WELCOME_DEFAULT', 'Willkommen bei der Zeitreihe auf ' . $xoopsConfig['sitename']);
\define('_MI_WGTIMELINES_TIMELINE_NAME', 'Name Zeitreihe anzeigen');
\define('_MI_WGTIMELINES_TIMELINE_NAME_DESC', 'Bitte wählen Sie, ob der Name der Zeitreiche auf der Userseite angezeigt werden soll');
\define('_MI_WGTIMELINES_STARTPAGE', 'Startseite');
\define('_MI_WGTIMELINES_STARTPAGE_DESC', 'Definieren Sie bitte, welche Informationen beim Modulaufruf (index.php) angezeigt werden sollen');
\define('_MI_WGTIMELINES_STARTPAGE_LIST', 'Eine Übersichtsliste mit allen Zeitreihen (ohne Einträge)');
\define('_MI_WGTIMELINES_STARTPAGE_ALL', 'Alle Zeitreihen mit allen Einträgen');
\define('_MI_WGTIMELINES_STARTPAGE_FIRST', 'Die erste Zeitreihe');
\define('_MI_WGTIMELINES_TLDESC', 'Beschreibung Zeitreihe');
\define('_MI_WGTIMELINES_TLDESC_DESC', 'Definieren Sie bitte, ob und wo die Beschreibung angezeigt werden soll');
\define('_MI_WGTIMELINES_TLDESC_NONE', 'Niemals');
\define('_MI_WGTIMELINES_TLDESC_ONLYLIST', 'Nur auf der Übersichtsliste');
\define('_MI_WGTIMELINES_TLDESC_ALL', 'Auf der Übersichtsliste und bei der Zeitreihe');
\define('_MI_WGTIMELINES_RATINGBARS', 'Bewertung anzeigen');
\define('_MI_WGTIMELINES_RATINGBARS_DESC', 'Definieren Sie bitte, ob eine Bewertung der Einträge möglich sein und angezeigt werden soll');
\define('_MI_WGTIMELINES_RATINGBAR_GROUPS', 'Gruppen mit der Berechtigung zum Bewerten');
\define('_MI_WGTIMELINES_RATINGBAR_GROUPS_DESC', 'Bestimmen Sie bitte die Gruppen, die Zeitreiheneinträge bewerten dürfen');
\define('_MI_WGTIMELINES_JSEXPANDER', 'Verwende JS expander');
\define('_MI_WGTIMELINES_JSEXPANDER_DESC', 'Bestimmen Sie bitte, ob Sie das JS expander Feature für "Mehr lesen" verwenden. Wenn nein, dann zeigt "Mehr lesen" die Details auf einen neuen Tab');
// ---------------- End ----------------
//Help
\define('_MI_WGTIMELINES_DIRNAME', \basename(\dirname(__DIR__, 2)));
\define('_MI_WGTIMELINES_HELP_HEADER', __DIR__.'/help/helpheader.html');
\define('_MI_WGTIMELINES_BACK_2_ADMIN', 'Zurück zur Administration von ');
\define('_MI_WGTIMELINES_OVERVIEW', 'Übersicht');
//help multi-page
\define('_MI_WGTIMELINES_DISCLAIMER', 'Haftungsausschluss');
\define('_MI_WGTIMELINES_LICENSE', 'Lizenz');
\define('_MI_WGTIMELINES_SUPPORT', 'Support');
