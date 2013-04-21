<?php
$robots = "User-agent: *\nAllow: /\nDisallow: /cgi-bin/\nDisallow: /wolf/\nUser-agent: wget\nDisallow: /\nSitemap: ".URL_PUBLIC."sitemap.xml";
$settings = array(
    'version' => '1.0.7',
	'header' => 'xml',
	'show_HOME_PAGE'   => '1',
    'show_STATUS_HIDDEN'   => '0',
	'show_LOGIN_REQUIRED'   => '0',
	'changefreq'   => 'weekly',
	'priority'   => '0.5',
	'cache'   => '0',
	'robots'   => $robots
);
// Insert the new ones
if (Plugin::setAllSettings($settings, 'djg_google_xml_sitemaps'))
    Flash::setNow('success', __('djg_google_xml_sitemaps - plugin settings initialized.'));
else
    Flash::setNow('error', __('djg_google_xml_sitemaps - unable to store plugin settings!'));
