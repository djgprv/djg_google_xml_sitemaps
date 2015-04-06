<?php
if (!defined('IN_CMS')) { exit(); }

$PDO = Record::getConnection();
$PDO->exec('ALTER TABLE '.TABLE_PREFIX.'page DROP djg_gxs_changefreq');
$PDO->exec('ALTER TABLE '.TABLE_PREFIX.'page DROP djg_gxs_priority');
$PDO->exec('DROP TABLE IF EXISTS '.TABLE_PREFIX.'djg_google_xml_sitemaps_css_files');
$PDO->exec('DROP TABLE IF EXISTS '.TABLE_PREFIX.'djg_google_xml_sitemaps_js_files');

if (Plugin::deleteAllSettings('djg_google_xml_sitemaps') === false)
{
    Flash::set('error', __('Unable to delete plugin settings.'));
    redirect(get_url('setting'));
}

Flash::set('success', __('Successfully uninstalled plugin.'));

exit();