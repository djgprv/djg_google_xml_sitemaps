<?php
$robots = "User-agent: *\nAllow: /\nDisallow: /cgi-bin/\nDisallow: /wolf/\nUser-agent: wget\nDisallow: /\nSitemap: ".URL_PUBLIC."sitemap.xml";
$settings = array(
    'version' => '1.1.0',
	'header' => 'xml',
	'show_HOME_PAGE'   => '1',
    'show_STATUS_HIDDEN'   => '0',
	'show_LOGIN_REQUIRED'   => '0',
	'changefreq'   => 'weekly',
	/*'auto_changefreq'   => '0',*/
	'priority'   => '0.5',
	'cache'   => '0',
	'auto_clear_cache'   => '0',
	'robots'   => $robots,
	'css_path'   => 'public/themes/css/screen.css'
);
$PDO = Record::getConnection();
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
$PDO->exec("ALTER TABLE ".TABLE_PREFIX."page ADD changefreq varchar(10) NOT NULL DEFAULT 'weekly'");
$PDO->exec("ALTER TABLE ".TABLE_PREFIX."page ADD priority varchar(3) NOT NULL DEFAULT '0.5'");
// Insert the new ones
if (Plugin::setAllSettings($settings, 'djg_google_xml_sitemaps'))
    Flash::setNow('success', __('djg_google_xml_sitemaps - plugin settings initialized.'));
else
    Flash::setNow('error', __('djg_google_xml_sitemaps - unable to store plugin settings!'));
