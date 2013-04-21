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
class DjgGoogleXmlSitemapsController extends PluginController {

    public function __construct() {
        $this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/djg_google_xml_sitemaps/views/sidebar'));
    }
	public function index() {
        $this->documentation();
    }
    public function documentation() {
        $this->display('djg_google_xml_sitemaps/views/documentation');
    }
    function settings() {
        $this->display('djg_google_xml_sitemaps/views/settings', array('settings' => Plugin::getAllSettings('djg_google_xml_sitemaps')));
    }
    function clear_cache() {
		if(unlink(CMS_ROOT.DS.'sitemap.xml')) Flash::set('success', __('Cache was cleared.'));
		redirect(get_url('plugin/djg_google_xml_sitemaps/settings'));
    }
    function save() {
		$settings = $_POST['settings'];

        $ret = Plugin::setAllSettings($settings, 'djg_google_xml_sitemaps');

        if ($ret)
            Flash::set('success', __('The settings have been updated.'));
        else
            Flash::set('error', 'An error has occurred while trying to save the settings.');

        redirect(get_url('plugin/djg_google_xml_sitemaps/settings'));
	}
	private function snippet_xml_sitemap($parent)
	{	
    $out = '';
	$settings = Plugin::getAllSettings('djg_google_xml_sitemaps');
    $childs = $parent->children(null,array(),true);
    if (count($childs) > 0)
    {
        foreach ($childs as $child)
        {
			if ( ($child->status_id == Page::STATUS_PUBLISHED) 
			or ( ($child->status_id == Page::STATUS_HIDDEN) && $settings['show_STATUS_HIDDEN'] == '1') 
			or ( ($child->getLoginNeeded() == Page::LOGIN_REQUIRED) && $settings['show_LOGIN_REQUIRED'] == '1') )  :		
				$out .= "<url>\n";
				$out .= "<loc>".$child->url()."</loc>\n";
				$out .= "<lastmod>".$child->date('%Y-%m-%d', 'updated')."</lastmod>\n";
				$out .= "<changefreq>".($child->hasContent('changefreq') ? $child->content('changefreq'): $settings['changefreq'])."</changefreq>\n";
				$out .= "<priority>".($child->hasContent('priority') ? $child->content('priority'): $settings['priority'])."</priority>\n";
				$out .= "</url>\n";
			endif;
			$out .= self::snippet_xml_sitemap($child);
        }
    }
    return $out;
}
    public function sitemap_cache() {
		$parent = Page::find('/');
		$settings = Plugin::getAllSettings('djg_google_xml_sitemaps');

		echo '<?xml version="1.0" encoding="UTF-8"?'.">\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		echo "\n";
		if(Plugin::getSetting('show_HOME_PAGE','djg_google_xml_sitemaps') == '1'):
			echo "<url>\n";
			echo "<loc>".$parent->url()."</loc>\n";
			echo "<lastmod>".$parent->date('%Y-%m-%d', 'updated')."</lastmod>\n";
			echo "<changefreq>".($parent->hasContent('changefreq') ? $parent->content('changefreq'): $settings['changefreq'])."</changefreq>\n";
			echo "<priority>".($parent->hasContent('priority') ? $parent->content('priority'): $settings['priority'])."</priority>\n";
			echo "</url>\n";
		endif;
		echo self::snippet_xml_sitemap($parent);
		echo '</urlset>';
    }
    public function robots() {
		$parent = Page::find('/');
		$settings = Plugin::getAllSettings('djg_google_xml_sitemaps');
		header("Content-Type: text/plain");
		echo Plugin::getSetting('robots','djg_google_xml_sitemaps');
    }
    public function sitemap() {
		switch (Plugin::getSetting('header','djg_google_xml_sitemaps')):
			case "xml" :
			header('Content-Type: application/xml; charset=utf-8');
			break;
			case "txt" :
			header('Content-type: text/html; charset=utf-8');
			break;
		endswitch;
		/* cache */
		$file = CMS_ROOT.DS.'sitemap.xml';
		if ( (!file_exists($file)) && (Plugin::getSetting('cache','djg_google_xml_sitemaps')=='1') ):
			$content = file_get_contents(URL_PUBLIC.'sitemap_cache');
			file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
			echo $content;
		elseif (Plugin::getSetting('cache','djg_google_xml_sitemaps')=='0'):
			echo file_get_contents(URL_PUBLIC.'sitemap_cache');
		endif;
    }
}