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

Plugin::setInfos(array(
    'id'          => 'djg_google_xml_sitemaps',
    'title'       => __('[djg] XML sitemaps'),
    'description' => __('Simple plugin to generate xml sitemap SEO compatible.'),
    'version'     => '1.0.9',
   	'license'     => 'GPL',
	'author'      => 'Michał Uchnast',
    'website'     => 'http://www.kreacjawww.pl/',
    'update_url'  => 'http://kreacjawww.pl/public/wolf_plugins/plugin-versions.xml',
    'require_wolf_version' => '0.7.3',
	'type'		=> 'both'
));

Plugin::addController('djg_google_xml_sitemaps', __('[djg] XML sitemaps'), true, false);

Dispatcher::addRoute(array(
		'/sitemap_cache' => '/plugin/djg_google_xml_sitemaps/sitemap_cache',
		'/robots.txt' => '/plugin/djg_google_xml_sitemaps/robots',
		'/sitemap.xml' => '/plugin/djg_google_xml_sitemaps/sitemap'
));

function djg_sitemap_tree($parent)
	{	
    $out = '';
	$settings = Plugin::getAllSettings('djg_google_xml_sitemaps');
	$childs = $parent->children(null,array(),true);
	if (count($childs) > 0)
		{
			foreach ($childs as $child)
			{
				$out .= '<ul>';
				if ( ($child->status_id == Page::STATUS_PUBLISHED) 
				or ( ($child->status_id == Page::STATUS_HIDDEN) && $settings['show_STATUS_HIDDEN'] == '1') 
				or ( ($child->getLoginNeeded() == Page::LOGIN_REQUIRED) && $settings['show_LOGIN_REQUIRED'] == '1') )  :		
					
					$out .= '<li><a href="' . $child->url() . '">' . $child->title() . '</a> <small>['. $child->date('%Y-%m-%d', 'updated') . ']</small></li>';
					
				endif;
				$out .= djg_sitemap_tree($child);
				$out .= '</ul>';
			}
		}
	return $out;
}
function djg_sitemap() {
	echo '<div class="djg_sitemap">';
	$parent = Page::find('/');
	if(Plugin::getSetting('show_HOME_PAGE','djg_google_xml_sitemaps') == '1') echo '<ul><li><a href="' . $parent->url() . '">' . $parent->title() . '</a> <small>['. $parent->date('%Y-%m-%d', 'updated') . ']</small></li>';
	echo djg_sitemap_tree($parent);
	if(Plugin::getSetting('show_HOME_PAGE','djg_google_xml_sitemaps') == '1') echo '</ul>';
	echo '</div>';
};