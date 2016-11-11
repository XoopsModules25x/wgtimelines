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
 * @version        $Id: 1.0 admin.php 13070 Sat 2016-10-01 05:42:16Z XOOPS Development Team $
 */
// ---------------- Admin Index ----------------
define('_AM_WGTIMELINES_STATISTICS', "Statistik");
// There are
define('_AM_WGTIMELINES_THEREARE_TIMELINES', "Es gibt <span class='bold'>%s</span> Zeitreihen in der Datenbank");
define('_AM_WGTIMELINES_THEREARE_ITEMS', "Es gibt <span class='bold'>%s</span> Einträge in der Datenbank");
define('_AM_WGTIMELINES_THEREARE_TEMPLATES', "Es gibt <span class='bold'>%s</span> Vorlagen in der Datenbank");
// ---------------- Admin Files ----------------
// There aren't
define('_AM_WGTIMELINES_THEREARENT_TIMELINES', "Es gibt keine Zeitreihen");
define('_AM_WGTIMELINES_THEREARENT_ITEMS', "Es gibt keine Einträge");
define('_AM_WGTIMELINES_THEREARENT_TEMPLATES', "Es gibt keine Vorlagen");
// Save/Delete
define('_AM_WGTIMELINES_FORM_OK', "Erfolgreich gespeichert");
define('_AM_WGTIMELINES_FORM_DELETE_OK', "Erfolgreich gelöscht");
define('_AM_WGTIMELINES_FORM_SURE_DELETE', "Wollen Sie wirklich löschen: <b><span style='color : Red;'>%s </span></b>");
define('_AM_WGTIMELINES_FORM_SURE_RENEW', "Wollen Sie wirklich aktualisieren: <b><span style='color : Red;'>%s </span></b>");
define('_AM_WGTIMELINES_SUBMITTER', "Einsender");
define('_AM_WGTIMELINES_DATE_CREATE', "Erstellt am");
// Lists
define('_AM_WGTIMELINES_TIMELINES_LIST', "Liste der Zeitreihen");
define('_AM_WGTIMELINES_ITEMS_LIST', "Liste der Einräge");
define('_AM_WGTIMELINES_TEMPLATES_LIST', "Liste der Vorlagen");
// ---------------- Admin Classes ----------------
// Timeline add/edit
define('_AM_WGTIMELINES_TIMELINE_ADD', "Zeitreihe hinzufügen");
define('_AM_WGTIMELINES_TIMELINE_EDIT', "Zeitreihe bearbeiten");
// Elements of Timeline
define('_AM_WGTIMELINES_TIMELINE_ID', "Id");
define('_AM_WGTIMELINES_TIMELINE_NAME', "Name");
define('_AM_WGTIMELINES_TIMELINE_TEMPLATE', "Vorlage");
define('_AM_WGTIMELINES_TIMELINE_SORTBY', "Sortierung");
define('_AM_WGTIMELINES_TIMELINE_SORTBY_ASC', "Jahr/Datum aufsteigend");
define('_AM_WGTIMELINES_TIMELINE_SORTBY_DESC', "Jahr/Datum absteigend");
define('_AM_WGTIMELINES_TIMELINE_ONLINE', "Online");
// Item add/edit
define('_AM_WGTIMELINES_ITEM_ADD', "Eintrag hinzufügen");
define('_AM_WGTIMELINES_ITEM_EDIT', "Eintrag bearbeiten");
// Elements of Item
define('_AM_WGTIMELINES_ITEM_ID', "Id");
define('_AM_WGTIMELINES_ITEM_TL_ID', "Zeitreihe");
define('_AM_WGTIMELINES_ITEM_TITLE', "Titel");
define('_AM_WGTIMELINES_ITEM_CONTENT', "Inhalt");
define('_AM_WGTIMELINES_ITEM_IMAGE', "Bild");
define('_AM_WGTIMELINES_FORM_UPLOAD_IMAGE_ITEMS', "Bilder in ../uploads/wgtimelines/images/items");
define('_AM_WGTIMELINES_ITEM_DATE', "Datum");
define('_AM_WGTIMELINES_ITEM_YEAR', "Jahr");
// Template add/edit
define('_AM_WGTIMELINES_TEMPLATE_ADD', "Vorlage hinzufügen");
define('_AM_WGTIMELINES_TEMPLATE_EDIT', "Vorlage bearbeiten");
// Elements of Template
define('_AM_WGTIMELINES_TEMPLATE_ID', "Id");
define('_AM_WGTIMELINES_TEMPLATE_NAME', "Name");
define('_AM_WGTIMELINES_TEMPLATE_DESC', "Beschreibung");
define('_AM_WGTIMELINES_TEMPLATE_FILE', "Datei");
define('_AM_WGTIMELINES_TEMPLATE_OPTIONS', "Optionen");
define('_AM_WGTIMELINES_TEMPLATE_VALID', "Anwenden");
define('_AM_WGTIMELINES_TEMPLATE_ADDOPT', "Option nach Speichern hinzufügen");
define('_AM_WGTIMELINES_TEMPLATE_IMGPOS', "Bildposition auf Panel");
define('_AM_WGTIMELINES_TEMPLATE_IMGPOS_LEFT', "Links");
define('_AM_WGTIMELINES_TEMPLATE_IMGPOS_RIGHT', "Rechts");
define('_AM_WGTIMELINES_TEMPLATE_IMGPOS_ALTERNATE', "Abwechselnd");
define('_AM_WGTIMELINES_TEMPLATE_IMGPOS_TOP', "Oben");
define('_AM_WGTIMELINES_TEMPLATE_IMGPOS_BOTTOM', "Unten");
define('_AM_WGTIMELINES_TEMPLATE_IMGSTYLE', "Bilddarstellung");
define('_AM_WGTIMELINES_TEMPLATE_IMGSTYLE_ROUNDED', "Abgerundet");
define('_AM_WGTIMELINES_TEMPLATE_IMGSTYLE_CIRCLE', "Kreisförmig");
define('_AM_WGTIMELINES_TEMPLATE_IMGSTYLE_THUMB', "Vorschaubild");
define('_AM_WGTIMELINES_TEMPLATE_TABLETYPE', "Tabellentype");
define('_AM_WGTIMELINES_TEMPLATE_TABLEBORDERED', "Rahmen");
define('_AM_WGTIMELINES_TEMPLATE_TABLESTRIPED', "Streifen");
define('_AM_WGTIMELINES_TEMPLATE_TABLEHOVER', "Hover");
define('_AM_WGTIMELINES_TEMPLATE_TABLECONDENSED', "Kompimiert");
define('_AM_WGTIMELINES_TEMPLATE_BGCOLOR', "Hintergrundfarbe");
define('_AM_WGTIMELINES_TEMPLATE_FONTCOLOR', "Schriftfarbe");
define('_AM_WGTIMELINES_TEMPLATE_BADGECOLOR', "Knotenpunktfarbe");
define('_AM_WGTIMELINES_TEMPLATE_BADGESTYLE', "Knotenpunktart");
define('_AM_WGTIMELINES_TEMPLATE_BADGESTYLE_FULL', "Voll");
define('_AM_WGTIMELINES_TEMPLATE_BADGESTYLE_CIRCLE', "Kreis");
define('_AM_WGTIMELINES_TEMPLATE_BADGEFONTCOLOR', "Schriftfarbe Knotenpunkt");
define('_AM_WGTIMELINES_TEMPLATE_NONE', "Ohne");
define('_AM_WGTIMELINES_TEMPLATE_ORIENTATION', "Ausrichtung");
define('_AM_WGTIMELINES_TEMPLATE_ORIENTATION_V', "vertikal");
define('_AM_WGTIMELINES_TEMPLATE_ORIENTATION_H', "horizontal");
define('_AM_WGTIMELINES_TEMPLATE_DATESSPEED', "Geschwindigkeit Datumänderung");
define('_AM_WGTIMELINES_TEMPLATE_ISSUESSPEED', "Geschwindigkeit Eintragsänderung");
define('_AM_WGTIMELINES_TEMPLATE_ISSUESTRANSPARENCY', "Transparenz der Einträge");
define('_AM_WGTIMELINES_TEMPLATE_ISSUESTRANSPARENCYSPEED', "Geschwindigkeit Transparenz");
define('_AM_WGTIMELINES_TEMPLATE_AUTOPLAY', "Automatisch abspielen");
define('_AM_WGTIMELINES_TEMPLATE_AUTOPLAY_DIRECTION', "Autoplay Richtung");
define('_AM_WGTIMELINES_TEMPLATE_AUTOPLAY_DIRECTION_FW', "vorwärts");
define('_AM_WGTIMELINES_TEMPLATE_AUTOPLAY_DIRECTION_BW', "rückwärts");
define('_AM_WGTIMELINES_TEMPLATE_AUTOPLAY_PAUSE', "Autoplay Pause");
define('_AM_WGTIMELINES_TEMPLATE_ARROWKEYS', "Pfeiltasten verwenden");
define('_AM_WGTIMELINES_TEMPLATE_STARTAT', "Beginn mit Eintrag");
define('_AM_WGTIMELINES_TEMPLATE_LINECOLOR', "Linienfarbe");
define('_AM_WGTIMELINES_TEMPLATE_BORDERRADIUS', "Panel Rahmenradius");
define('_AM_WGTIMELINES_TEMPLATE_BORDERWIDTH', "Panel Rahmenbreite");
define('_AM_WGTIMELINES_TEMPLATE_BORDERSTYLE', "Panel Rahmenart");
define('_AM_WGTIMELINES_TEMPLATE_BORDERCOLOR', "Panel Rahmenfarbe");
define('_AM_WGTIMELINES_TEMPLATE_BOXSHADOW', "Schatten (Box shadow)");
define('_AM_WGTIMELINES_TEMPLATE_BOXSHADOW_H', "Horizontal");
define('_AM_WGTIMELINES_TEMPLATE_BOXSHADOW_V', "Vertikal");
define('_AM_WGTIMELINES_TEMPLATE_BOXSHADOW_BLUR', "Blur");
define('_AM_WGTIMELINES_TEMPLATE_BOXSHADOW_SPREAD', "Spread");
define('_AM_WGTIMELINES_TEMPLATE_BOXSHADOW_COLOR', "Schattenfarbe");
// General
define('_AM_WGTIMELINES_FORM_UPLOAD', "Datei hochladen");
define('_AM_WGTIMELINES_FORM_IMAGE_PATH', "Dateien in %s ");
define('_AM_WGTIMELINES_FORM_ACTION', "Aktion");
define('_AM_WGTIMELINES_FORM_EDIT', "Ändern");
define('_AM_WGTIMELINES_FORM_DELETE', "Löschen");
// ---------------- Admin Others ----------------
define('_AM_WGTIMELINES_MAINTAINEDBY', " wird unterstützt von ");
// ---------------- End ----------------