<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008-2010 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS. Wolf CMS is licensed under the GNU GPLv3 license.
 * Please see license.txt for the full license text.
 */

/* Security measure */
if (!defined('IN_CMS')) { exit(); }

/**
 *
 * Note: to use the settings and documentation pages, you will first need to enable
 * the plugin!
 *
 * @package Plugins
 * @subpackage djg_google_xml_sitemaps
 *
 * @author Michał Uchnast <djgprv@gmail.com>,
 * @copyright kreacjawww.pl
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
?>
<h1><?php echo __('Djg Google Xml Sitemaps Documentation'); ?></h1>
<h3><?php echo __('Simple plugin to generate xml sitemap SEO compatible.'); ?></h3>
<p><?php echo __('Sitemap adress is:')?> http://www.mywebsite.com/sitemap.xml</p>
<p><?php echo __('Read about sitemaps:'); ?> <a href="http://en.wikipedia.org/wiki/Sitemap.xml">http://en.wikipedia.org/wiki/Sitemap.xml</a></p>
<p><?php echo __('Your sitemap:'); ?> <a href="<?php echo URL_PUBLIC.'sitemap.xml'; ?>"><?php echo URL_PUBLIC.'sitemap.xml'; ?></a></p>

<p><strong>History version</strong></p>
<ul style="list-style: square inside none;">
<li>1.0.0 - beta</li>
<li>1.0.1 - Added HOME PAGE to xml tree.</li>
<li>1.0.2 - Added setting page, now You can choose page to display in xml tree. There are three options, show hide HOME PAGE and by status: STATUS_HIDDEN, LOGIN_REQUIRED. Thx Fortron for suggest.</li>
<li>1.0.3 - Added xml header (thx for andrewmman) and ability to set default Changefreq and Priority for pages.</li>
<li>1.0.4 - Added "choose header" to settings, changed translation and added nl-message.php (thx for Fortron)</li>
<li>1.0.5 - Changed plugin settings view to valid XHTML, some translate changes.</li>
<li>1.0.6 - Robots.txt.</li>
<li>1.0.7 - Sitemap cacheing.</li>
<li>1.0.8 - WolfCMS ver. 0.7.7.</li>
</ul>

<p><strong>Future</strong></p>
<ul style="list-style: square inside none;">
<li>Changefreq and Priority tab to set individual values for page.</li>
</ul>

<h3>Used in plugin</h3>
<ul style="list-style: square inside none;">
<li>icons - http://www.iconfinder.com/search/?q=iconset%3Afatcow</li>
</ul>