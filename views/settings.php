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
<<<<<<< HEAD
 * @author Michał Uchnast <djgprv@gmail.com>,
=======
 * @author Michał Uchnast <djgprv@gmail.com>,
>>>>>>> f9f33414db3ce73bceb34ebebcae2c94a738fb87
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
                <td class="label"><label for="djg_gxs_changefreq"><?php echo __('Changefreq'); ?>: </label></td>
                <td class="field">
					<select id="djg_gxs_changefreq" name="settings[djg_gxs_changefreq]">
					<option value="always" <?php if($settings['djg_gxs_changefreq'] == 'always'): echo 'selected="selected"'; endif; ?>><?php echo __('always') ; ?></option>
					<option value="hourly" <?php if($settings['djg_gxs_changefreq'] == 'hourly'): echo 'selected="selected"'; endif; ?>><?php echo __('hourly') ; ?></option>
					<option value="daily" <?php if($settings['djg_gxs_changefreq'] == 'daily'): echo 'selected="selected"'; endif; ?>><?php echo __('daily') ; ?></option>
					<option value="weekly" <?php if($settings['djg_gxs_changefreq'] == 'weekly'): echo 'selected="selected"'; endif; ?>><?php echo __('weekly') ; ?></option>
					<option value="monthly" <?php if($settings['djg_gxs_changefreq'] == 'monthly'): echo 'selected="selected"'; endif; ?>><?php echo __('monthly') ; ?></option>
					<option value="yearly" <?php if($settings['djg_gxs_changefreq'] == 'yearly'): echo 'selected="selected"'; endif; ?>><?php echo __('yearly') ; ?></option>
					<option value="never" <?php if($settings['djg_gxs_changefreq'] == 'never'): echo 'selected="selected"'; endif; ?>><?php echo __('never') ; ?></option>
					</select>
				</td>
				<td><?php echo __('Default djg_gxs_changefreq for pages.'); ?></td>
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
                <td class="label"><label for="cache"><?php echo __('Cache'); ?>: </label></td>
                <td class="field">
					<select id="cache" name="settings[cache]">
						<option value="1" <?php if($settings['cache'] == "1") echo 'selected="selected"'; ?>><?php echo __('Yes'); ?></option>
						<option value="0" <?php if($settings['cache'] == "0") echo 'selected="selected"'; ?>><?php echo __('No'); ?></option>
					</select>
				</td>
				<td><?php echo __('Set Yes if you want to caching sitemap file.'); ?></td>
			</tr>
			<tr>
                <td class="label"><label for="auto_clear_cache"><?php echo __('Auto clean cache after page update'); ?>: </label></td>
                <td class="field">
					<select id="auto_clear_cache" name="settings[auto_clear_cache]">
						<option value="1" <?php if($settings['auto_clear_cache'] == "1") echo 'selected="selected"'; ?>><?php echo __('Yes'); ?></option>
						<option value="0" <?php if($settings['auto_clear_cache'] == "0") echo 'selected="selected"'; ?>><?php echo __('No'); ?></option>
					</select>
				</td>
				<td><?php echo __('Set Yes if you want to caching sitemap file.'); ?></td>
			</tr>
			<tr>
                <td class="label"><label for="robots"><?php echo __('Robots.txt'); ?>: </label></td>
                <td class="field">
					<textarea id="robots" rows="10" cols="50" name="settings[robots]"><?php echo $settings['robots']; ?></textarea>
				</td>
				<td><?php echo __('Contents of the robots.txt file.'); ?></td>
			</tr>
			<tr>
                <td class="label"><label for="css_path"><?php echo __('Virtual css path'); ?>: </label></td>
                <td class="field">
					<input type="text" class="textbox" name="settings[css_path]" value="<?php echo $settings['css_path']; ?>" />
				</td>
				<td><a href="<?php echo URL_PUBLIC.$settings['css_path']; ?>" target="_blank"><?php echo __('Show css content'); ?></a></td>
			</tr>
			<tr>
                <td class="label"><label for="js_path"><?php echo __('Virtual js path'); ?>: </label></td>
                <td class="field">
					<input type="text" class="textbox" name="settings[js_path]" value="<?php echo $settings['js_path']; ?>" />
				</td>
				<td><a href="<?php echo URL_PUBLIC.$settings['js_path']; ?>" target="_blank"><?php echo __('Show js content'); ?></a></td>
			</tr>
        </table>
    </fieldset>
    <br/>
    <p class="buttons">
        <input class="button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save'); ?>" /> | 
		<a href="<?php echo URL_PUBLIC.'sitemap.xml'; ?>" target="_blank"><?php echo __('Show sitemap.xml file'); ?></a> | 
		<a href="<?php echo URL_PUBLIC.'robots.txt'; ?>" target="_blank"><?php echo __('Show robots.txt file'); ?></a>
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
