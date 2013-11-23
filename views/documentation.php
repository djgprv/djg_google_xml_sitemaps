<?php
if (!defined('IN_CMS')) { exit(); }
?>
<h1><?php echo __('Documentation'); ?></h1>
<?php
	$description = file_get_contents(PLUGINS_ROOT.DS.'djg_google_xml_sitemaps'.DS.'README.md'); 
	$description = preg_replace("/\r\n|\r|\n/",'<br/>',$description);
	echo '<p>'.$description.'</p>';
?>
