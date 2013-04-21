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
 * @author Micha³ Uchnast <djgprv@gmail.com>,
 * @copyright kreacjawww.pl
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
 
?>
<h1><?php echo __('Settings'); ?></h1>
<form action="<?php echo get_url('plugin/djg_google_xml_sitemaps/save'); ?>" method="post">
    <fieldset style="padding: 0.5em;">
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
                <td class="label"><label for="settings_header"><?php echo __('Header'); ?>: </label></td>
                <td class="field">
					<select id="settings_header" name="settings[header]">
						<option value="xml" <?php if($settings['header'] == "xml") echo 'selected="selected"' ?>><?php echo __('XML'); ?></option>
						<option value="txt" <?php if($settings['header'] == "txt") echo 'selected="selected"' ?>><?php echo __('TXT'); ?></option>
					</select>	
				</td>
				<td><?php echo __('Choose header.'); ?></td>
			</tr>
			<tr>
                <td class="label"><label for="show_home_page"><?php echo __('HOMEPAGE'); ?>: </label></td>
                <td class="field">
					<select id="show_home_page" name="settings[show_HOME_PAGE]">
						<option value="1" <?php if($settings['show_HOME_PAGE'] == "1") echo 'selected="selected"'; ?>><?php echo __('Yes'); ?></option>
						<option value="0" <?php if($settings['show_HOME_PAGE'] == "0") echo 'selected="selected"'; ?>><?php echo __('No'); ?></option>
					</select>	
				</td>
				<td><?php echo __('Add HOMEPAGE to xml tree.'); ?></td>
			</tr>
			<tr>
                <td class="label"><label for="show_status_hidden"><?php echo __('STATUS HIDDEN'); ?>: </label></td>
                <td class="field">
					<select id="show_status_hidden" name="settings[show_STATUS_HIDDEN]">
						<option value="1" <?php if($settings['show_STATUS_HIDDEN'] == "1") echo 'selected="selected"'; ?>><?php echo __('Yes'); ?></option>
						<option value="0" <?php if($settings['show_STATUS_HIDDEN'] == "0") echo 'selected="selected"'; ?>><?php echo __('No'); ?></option>
					</select>	
				</td>
				<td><?php echo __('Add HIDDEN PAGES to xml tree.'); ?></td>
			</tr>
			<tr>
                <td class="label"><label for="show_login_required"><?php echo __('LOGIN REQUIRED'); ?>: </label></td>
                <td class="field">
					<select id="show_login_required" name="settings[show_LOGIN_REQUIRED]">
						<option value="1" <?php if($settings['show_LOGIN_REQUIRED'] == "1") echo 'selected="selected"'; ?>><?php echo __('Yes'); ?></option>
						<option value="0" <?php if($settings['show_LOGIN_REQUIRED'] == "0") echo 'selected="selected"'; ?>><?php echo __('No'); ?></option>
					</select>	
				</td>
				<td><?php echo __('Add LOGIN REQUIRED PAGES to xml tree.'); ?></td>
			</tr>
			<tr>
                <td class="label"><label for="changefreq"><?php echo __('Changefreq'); ?>: </label></td>
                <td class="field">
					<?php $changefreq_array = array("always","hourly","daily","weekly","monthly","yearly","never"); ?>
					<select id="changefreq" name="settings[changefreq]">
					<?php for($i = 0; $i < sizeof($changefreq_array); ++$i): ?>				
					<option value="<?php echo $changefreq_array[$i]; ?>" <?php if($settings['changefreq'] == $changefreq_array[$i]): echo 'selected="selected"'; endif; ?>><?php echo __($changefreq_array[$i]) ; ?></option>
					<?php endfor; ?>
					</select>	
				</td>
				<td><?php echo __('Default changefreq for pages.'); ?></td>
			</tr>
			<tr>
                <td class="label"><label for="priority"><?php echo __('Priority'); ?>: </label></td>
                <td class="field">
					<select id="priority" name="settings[priority]">
						<option value="0.0" <?php if($settings['priority'] == "0.0") echo 'selected="selected"'; ?>>0.0</option>
						<?php for($i= 0.1; $i < 0.9; $i += 0.1): ?>
						<option value="<?php echo  $i; ?>" <?php if($settings['priority'] == $i): echo 'selected="selected"'; endif; ?>><?php echo $i; ?></option>
						<?php endfor;?>
						<option value="1.0" <?php if($settings['priority'] == "1.0") echo 'selected =" "' ?>>1.0</option>
					</select>	
				</td>
				<td><?php echo __('Default priority for pages.'); ?></td>
			</tr>
			<tr>
                <td class="label"><label for="priority"><?php echo __('Cache'); ?>: </label></td>
                <td class="field">
					<select id="cache" name="settings[cache]">
						<option value="1" <?php if($settings['cache'] == "1") echo 'selected="selected"'; ?>><?php echo __('Yes'); ?></option>
						<option value="0" <?php if($settings['cache'] == "0") echo 'selected="selected"'; ?>><?php echo __('No'); ?></option>
					</select>
				</td>
				<td><?php echo __('Set Yes if you want to caching sitemap file.'); ?></td>
			</tr>
			<tr>
                <td class="label"><label for="robots"><?php echo __('Robots.txt'); ?>: </label></td>
                <td class="field">
					<textarea rows="10" cols="50" name="settings[robots]"><?php echo $settings['robots']; ?></textarea>
				</td>
				<td><?php echo __('Contents of the robots.txt file.'); ?></td>
			</tr>
        </table>
    </fieldset>
    <br/>
    <p class="buttons">
        <input class="button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save'); ?>" />
    </p>
</form>

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
    });
// ]]>
</script>