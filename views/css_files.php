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
//echo '<pre>'; print_r($files);  echo '</pre>';
?>
<div id="djg_google_xml_sitemaps">
<h1><?php echo __('CSS files'); ?></h1>
<form action="<?php echo get_url('plugin/djg_google_xml_sitemaps/css_files'); ?>" method="post">
    <fieldset style="padding: 0.5em;">
		<h3><?php echo __('List css files from public/themes directory'); ?></h3>
		<?php
		if(empty($files)) echo '<p class="red">'.__('All available files are in use').'<p>';
		echo '<ul id="available_css_files">';
		foreach($files as $file):
			echo '<li><input type="checkbox" name="available_css_files[]" value="'. str_replace(CMS_ROOT, "", $file).'">'. str_replace(CMS_ROOT, "", $file).'</li>';
		endforeach;
		echo '</ul>';
		?>
		<input class="button add_button" name="add_button" type="submit" accesskey="s" value="<?php echo __('add selected'); ?>" />
		<h3><?php echo __('Files in use'); ?></h3>
		<?php
		if(empty($db)) echo '<p class="red">'.__('No files').'<p>';
		echo '<ul id="db_css_files">';
		foreach($db as $file):
			echo '<li style="cursor: move;" id="filesArray_'.$file["id"].'"><input type="checkbox" name="db_css_files[]" value="'. $file['id'].'">'. $file['filename'].'</li>';
		endforeach;
		echo '</ul>';
		?>
        <input class="button remove_button" name="remove_button" type="submit" accesskey="s" value="<?php echo __('remove selected'); ?>" />
    </fieldset>
	<p><?php echo __('Copy and paste bellow code to your theme') ?></p>
	<p>&lt;link rel="stylesheet" href="&lt;?php echo URL_PUBLIC; ?&gt;<?php echo Plugin::getSetting('css_path','djg_google_xml_sitemaps'); ?>" media="screen" type="text/css" /&gt;</p>
	<a href="<?php echo URL_PUBLIC.plugin::getSetting('css_path','djg_google_xml_sitemaps'); ?>" target="_blank"><?php echo __('Show css content'); ?></a>
</form>
</div>
<script type="text/javascript">
// <![CDATA[
    function setConfirmUnload(on, msg) {
        window.onbeforeunload = (on) ? unloadMessage : null;
        return true;
    }

    function unloadMessage() {
        return '<?php echo __('You have modified this page.  If you navigate away from this page without first saving your data, the changes will be lost.'); ?>';
    }

    $(document).ready(function() {
        // Prevent accidentally navigating away
        $(':input').bind('change', function() { setConfirmUnload(true); });
        $('form').submit(function() { setConfirmUnload(false); return true; });
		/* sort files */
		$("#db_css_files").sortable({ 
			update : function () { 
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings';
				$.post("<?php echo URL_PUBLIC.'djg_google_xml_sitemaps/sort_css_files.php';?>", order, function(theResponse){
					$("#ajax_debug").html("<?php echo __('Updated file list'); ?>"+theResponse);
				});
			} 
		}); 
    });
// ]]>
</script>


