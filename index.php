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
    'version'     => '1.0.8',
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