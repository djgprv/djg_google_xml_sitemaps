<?php
$PDO = Record::getConnection();
$PDO->exec("ALTER TABLE ".TABLE_PREFIX."page ADD djg_gxs_changefreq VARCHAR( 10 ) NOT NULL DEFAULT  'weekly'");
$PDO->exec("ALTER TABLE ".TABLE_PREFIX."page ADD djg_gxs_priority VARCHAR( 3 ) NOT NULL DEFAULT '0.5'");

$robots = "User-agent: *\nAllow: /\nDisallow: /cgi-bin/\nDisallow: /wolf/\nUser-agent: wget\nDisallow: /\nSitemap: ".URL_PUBLIC."sitemap.xml";
$settings = array(
    'version' => '1.1.4',
	'header' => 'xml',
	'show_HOME_PAGE'   => '1',
    'show_STATUS_HIDDEN'   => '0',
	'show_LOGIN_REQUIRED'   => '0',
	'djg_gxs_changefreq'   => 'weekly',
	'djg_gxs_priority'   => '0.5',
	'cache'   => '0',
	'auto_clear_cache'   => '0',
	'robots'   => $robots,
	'css_path'   => 'public/themes/css/screen.css',
	'js_path'   => 'public/themes/js/script.js'
);
$createCssTable = "
CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."djg_google_xml_sitemaps_css_files` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`sort_order` smallint(4) unsigned NOT NULL DEFAULT '0',
	`filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `filename` (`filename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
$stmt = $PDO->prepare($createCssTable);
$stmt->execute();
$createCssTable = "
CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."djg_google_xml_sitemaps_js_files` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`sort_order` smallint(4) unsigned NOT NULL DEFAULT '0',
	`filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `filename` (`filename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
$stmt = $PDO->prepare($createCssTable);
$stmt->execute();


/** update 
if( (Plugin::getSetting('version', 'djg_google_xml_sitemaps') == '1.1.3') $PDO->exec("ALTER TABLE ".TABLE_PREFIX."page ADD meta_robots varchar(10) NOT NULL DEFAULT 'all'");*/

// Insert the new ones
if (Plugin::setAllSettings($settings, 'djg_google_xml_sitemaps'))
    Flash::setNow('success', __('djg_google_xml_sitemaps - plugin settings initialized.'));
else
    Flash::setNow('error', __('djg_google_xml_sitemaps - unable to store plugin settings!'));
