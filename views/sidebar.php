<?php

/**
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS.
 *
 * Wolf CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Wolf CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wolf CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Wolf CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */


/**
 * The djg_google_xml_sitemaps plugin

 * @author Michał Uchnast <djgprv@gmail.com>,
 * @copyright kreacjawww.pl
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */

if (file_exists(CMS_ROOT.DS.'sitemap.xml')):
$date = date("d-m-Y H:i:s", filemtime(CMS_ROOT.'/sitemap.xml')); ?>
<p class="button"><a href="<?php echo get_url('plugin/djg_google_xml_sitemaps/clear_cache'); ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/djg_google_xml_sitemaps/images/32_cache.png" align="middle" alt="settings icon" /> <?php echo __('Clear cache (:date)',array(':date'=>$date)); ?></a></p>
<?php endif; ?>
<p class="button"><a href="<?php echo get_url('plugin/djg_google_xml_sitemaps/css_files'); ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/djg_google_xml_sitemaps/images/32_css.png" align="middle" alt="settings icon" /> <?php echo __('CSS'); ?></a></p>
<p class="button"><a href="<?php echo get_url('plugin/djg_google_xml_sitemaps/js_files'); ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/djg_google_xml_sitemaps/images/32_js.png" align="middle" alt="settings icon" /> <?php echo __('JS'); ?></a></p>
<p class="button"><a href="<?php echo get_url('plugin/djg_google_xml_sitemaps/settings'); ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/djg_google_xml_sitemaps/images/32_settings.png" align="middle" alt="settings icon" /> <?php echo __('Settings'); ?></a></p>
<p class="button"><a href="<?php echo get_url('plugin/djg_google_xml_sitemaps/documentation/'); ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/djg_google_xml_sitemaps/images/32_documentation.png" align="middle" alt="documentation icon" /> <?php echo __('Documentation'); ?></a></p>
<p class="kreacjawww"><span><a href="http://kreacjawww.pl/">&copy; Michał Uchnast - http://kreacjawww.pl/</a></span></p>