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
    'version'     => '1.1.1',
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
		'/sitemap.xml' => '/plugin/djg_google_xml_sitemaps/sitemap',
		'/djg_google_xml_sitemaps/sort_css_files.php' => '/plugin/djg_google_xml_sitemaps/ajax_sort_css_files',
		'/'.Plugin::getSetting('css_path','djg_google_xml_sitemaps') => '/plugin/djg_google_xml_sitemaps/screen'
));

Observer::observe('view_page_edit_plugins', 'djg_changefreq_select');
Observer::observe('view_page_edit_plugins', 'djg_priority_select');
Observer::observe('page_edit_after_save', 'auto_clear_cache');
Observer::observe('page_add_after_save', 'auto_clear_cache');
Observer::observe('page_delete', 'auto_clear_cache');
/*Observer::observe('page_edit_before_save', 'auto_changefreq');


function auto_changefreq($page) {
	if(Plugin::getSetting('auto_changefreq','djg_google_xml_sitemaps')=='1'){
		$period = strtotime(date( 'Y-m-d H:i:s'))-strtotime($page->updated_on);
		if($period > 60*60*24*365) { // > 1 year
			$freq='yearly';
		} elseif($period > 60*60*24*30) { // > 1 month
			$freq='monthly';
		} elseif($period > 60*60*24*7) { // > 1 week
			$freq='weekly';
		} elseif($period > 60*60*24) { // > 1 day
			$freq='daily';
		} elseif($period > 60*60) { // > 1 hour
			$freq='hourly';
		} else { // < 1 hour
			$freq='always';
		}
		$PDO = Record::getConnection();
		$sql = "UPDATE ".TABLE_PREFIX."page	SET changefreq='".$freq."' WHERE id=".$page->id;
		$stmt = $PDO->prepare($sql);
	}
}
*/

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
function djg_sitemap_menu($parent)
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
					$out .= '<option value="'.$child->url().'">' . str_repeat("-", (int)$child->level()) . ' ' . $child->title().'</option>';
				endif;
				$out .= djg_sitemap_menu($child);
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
function djg_select_menu() {
	?>
	<select onchange="if (this.value) window.location.href=this.value" class="djg_menu">
	<?php
	$parent = Page::find('/');
	if(Plugin::getSetting('show_HOME_PAGE','djg_google_xml_sitemaps') == '1') echo '<option value="'.$parent->url().'">' . str_repeat("-", (int)$parent->level()) . ' ' . $parent->title().'</option>';
	echo djg_sitemap_menu($parent);
	echo '</select>';
};

function djg_changefreq_select(&$page)
{
		echo '<p><label for="djg_changefreq_select">';
		echo __('Changefreq') . ': ';
		echo '</label><select id="djg_changefreq_select" name="page[changefreq]">';
		echo '<option value="always"'.($page->changefreq == 'always' ? ' selected="selected"': '').'>'.__('always').'</option>';
		echo '<option value="hourly"'.($page->changefreq == 'hourly' ? ' selected="selected"': '').'>'.__('hourly').'</option>';
		echo '<option value="daily"'.($page->changefreq == 'daily' ? ' selected="selected"': '').'>'.__('daily').'</option>';
		echo '<option value="weekly"'.($page->changefreq == 'weekly' ? ' selected="selected"': '').'>'.__('weekly').'</option>';
		echo '<option value="monthly"'.($page->changefreq == 'monthly' ? ' selected="selected"': '').'>'.__('monthly').'</option>';
		echo '<option value="yearly"'.($page->changefreq == 'yearly' ? ' selected="selected"': '').'>'.__('yearly').'</option>';
		echo '<option value="never"'.($page->changefreq == 'never' ? ' selected="selected"': '').'>'.__('never').'</option>';
		echo '</select></p>';
}
function djg_priority_select(&$page)
{
    echo '<p><label for="djg_priority_select">';
	echo __('Priority') . ': ';
	echo '</label><select id="djg_priority_select" name="page[priority]">';
	for ($x=0.0; $x<=1.0; $x+=0.1)
	  {
	  echo '<option value="'.sprintf('%0.1f',$x).'"'.($page->priority == sprintf('%0.1f',$x) ? ' selected="selected"': '').'>'.sprintf('%0.1f',$x).'</option>';
	  }	
    echo '</select></p>';

}
function auto_clear_cache()
{
	if( (Plugin::getSetting('auto_clear_cache','djg_google_xml_sitemaps')) ) unlink(CMS_ROOT.DS.'sitemap.xml');
}
