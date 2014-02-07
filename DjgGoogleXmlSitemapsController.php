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
    function clear_cache() {
		if(unlink(CMS_ROOT.DS.'sitemap.xml')) Flash::set('success', __('Cache was cleared.'));
		redirect(get_url('plugin/djg_google_xml_sitemaps/settings'));
    }
    function css_files() {
		$PDO = Record::getConnection();
		$sql = "SELECT * FROM ".TABLE_PREFIX."djg_google_xml_sitemaps_css_files ORDER BY sort_order ASC, id DESC";
		$stmt = $PDO->prepare($sql);
		$stmt->execute();
		$db = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$db_tmp = array(); foreach($db as $row) $db_tmp[] = $row['filename']; // filename only
		$files = array();	
		$files_tmp = self::findFiles(CMS_ROOT.DS."public".DS."themes", array ("css"));
		foreach($files_tmp as $file):
			if(!in_array(str_replace(CMS_ROOT, "", $file), $db_tmp)) $files[] = str_replace(CMS_ROOT, "", $file);
		endforeach;
		
		if( (isset($_POST['add_button'])&&(isset($_POST['available_css_files']))) ):
			foreach($_POST['available_css_files'] as $row):
				$sql = "INSERT INTO ".TABLE_PREFIX."djg_google_xml_sitemaps_css_files (filename) VALUES (:filename)";
				$stmt = $PDO->prepare($sql);
				$stmt->bindParam(':filename', $row, PDO::PARAM_STR);
				$stmt->execute();
			endforeach;
			Flash::set('success', __('Successfully added file(s)'));
			redirect(get_url('plugin/djg_google_xml_sitemaps/css_files'));
		elseif( (isset($_POST['remove_button'])&&(isset($_POST['db_css_files']))) ):
			$sql = "DELETE FROM ".TABLE_PREFIX."djg_google_xml_sitemaps_css_files WHERE id IN (". implode(',',$_POST['db_css_files']).")";
			$stmt = $PDO->prepare($sql);
			$stmt->execute();
			Flash::set('success', __('Successfully removed file(s)'));
			redirect(get_url('plugin/djg_google_xml_sitemaps/css_files'));
		endif;
        $this->display('djg_google_xml_sitemaps/views/css_files', array('files' => $files, 'post' => $_POST, 'db'=>$db));
	}
    function js_files() {
		$PDO = Record::getConnection();
		$sql = "SELECT * FROM ".TABLE_PREFIX."djg_google_xml_sitemaps_js_files ORDER BY sort_order ASC, id DESC";
		$stmt = $PDO->prepare($sql);
		$stmt->execute();
		$db = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$db_tmp = array(); foreach($db as $row) $db_tmp[] = $row['filename']; // filename only
		$files = array();	
		$files_tmp = self::findFiles(CMS_ROOT.DS."public".DS."themes", array ("js"));
		foreach($files_tmp as $file):
			if(!in_array(str_replace(CMS_ROOT, "", $file), $db_tmp)) $files[] = str_replace(CMS_ROOT, "", $file);
		endforeach;
		
		if( (isset($_POST['add_button'])&&(isset($_POST['available_js_files']))) ):
			foreach($_POST['available_js_files'] as $row):
				$sql = "INSERT INTO ".TABLE_PREFIX."djg_google_xml_sitemaps_js_files (filename) VALUES (:filename)";
				$stmt = $PDO->prepare($sql);
				$stmt->bindParam(':filename', $row, PDO::PARAM_STR);
				$stmt->execute();
			endforeach;
			Flash::set('success', __('Successfully added file(s)'));
			redirect(get_url('plugin/djg_google_xml_sitemaps/js_files'));
		elseif( (isset($_POST['remove_button'])&&(isset($_POST['db_js_files']))) ):
			$sql = "DELETE FROM ".TABLE_PREFIX."djg_google_xml_sitemaps_js_files WHERE id IN (". implode(',',$_POST['db_js_files']).")";
			$stmt = $PDO->prepare($sql);
			$stmt->execute();
			Flash::set('success', __('Successfully removed file(s)'));
			redirect(get_url('plugin/djg_google_xml_sitemaps/js_files'));
		endif;
        $this->display('djg_google_xml_sitemaps/views/js_files', array('files' => $files, 'post' => $_POST, 'db'=>$db));
	}
    function settings() {
        $this->display('djg_google_xml_sitemaps/views/settings', array('settings' => Plugin::getAllSettings('djg_google_xml_sitemaps')));
    }
	public function documentation() {
		$content = Parsedown::instance()->parse(file_get_contents(PLUGINS_ROOT.DS.'djg_google_xml_sitemaps'.DS.'README.md'));
        $this->display('djg_google_xml_sitemaps/views/documentation', array('content'=>$content));
    }
	
	function findFiles($directory, $extensions = array()) {
		function glob_recursive($directory, &$directories = array()) {
			foreach(glob($directory, GLOB_ONLYDIR | GLOB_NOSORT) as $folder) {
				$directories[] = $folder;
				glob_recursive("{$folder}/*", $directories);
			}
		}
		glob_recursive($directory, $directories);
		$files = array ();
		foreach($directories as $directory) {
			foreach($extensions as $extension) {
				foreach(glob("{$directory}/*.{$extension}") as $file) {
					$files[$extension][] = $file;
				}
			}
		}
		return $files[$extension];
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
				$out .= "<changefreq>".($child->changefreq ? $child->changefreq: $settings['changefreq'])."</changefreq>\n";
				$out .= "<priority>".($child->priority ? $child->priority: $settings['priority'])."</priority>\n";
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
			echo "<changefreq>".($parent->changefreq ? $parent->changefreq: $settings['changefreq'])."</changefreq>\n";
			echo "<priority>".($parent->priority ? $parent->priority: $settings['priority'])."</priority>\n";
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
		/* cache */
		$file = CMS_ROOT.DS.'sitemap.'.Plugin::getSetting('header','djg_google_xml_sitemaps');
		if ( (!file_exists($file)) && (Plugin::getSetting('cache','djg_google_xml_sitemaps')=='1') ):
			switch (Plugin::getSetting('header','djg_google_xml_sitemaps')):
				case "xml" :
				header('Content-Type: application/xml; charset=utf-8');
				break;
				case "txt" :
				header('Content-type: text/html; charset=utf-8');
				break;
			endswitch;	
			$content = file_get_contents(URL_PUBLIC.'sitemap_cache');
			file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
			echo $content;
		elseif (Plugin::getSetting('cache','djg_google_xml_sitemaps')=='0'):
			echo file_get_contents(URL_PUBLIC.'sitemap_cache');
		endif;
    }
	
	/** CSS */
	
	function css_file(){
		$offset = 60 * 60 * 24 * 31;		
		header('Content-type: text/css; charset: UTF-8');  
		header('Cache-Control: max-age=' . $offset . ', must-revalidate');
		header('Expires: ' . gmdate ("D, d M Y H:i:s", time() + $offset) . ' GMT');
		echo self::css_min();
	}

	public static function css_min(){
		$PDO = Record::getConnection();
		$sql = "SELECT filename FROM ".TABLE_PREFIX."djg_google_xml_sitemaps_css_files ORDER BY sort_order ASC, id DESC";
		$stmt = $PDO->prepare($sql);
		$stmt->execute();
		$db = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$css = null;
		$md5 = null;
		foreach ($db as &$value):
			$file = CMS_ROOT.$value['filename'];
			if (file_exists($file)) {
				$md5 .= date (filemtime($file));
				$css .= file_get_contents(CMS_ROOT.$value['filename'],true);
			}
		endforeach;
		$name = md5($md5).'.css';
		if(file_exists(PLUGINS_ROOT.DS.'djg_google_xml_sitemaps'.DS.'cache'.DS.$name))readfile(PLUGINS_ROOT.DS.'djg_google_xml_sitemaps'.DS.'cache'.DS.$name);
		else{
			
			$css = preg_replace('#/\*.*?\*/#s', '', $css);
			$css = preg_replace('/\s*([{}|:;,])\s+/', '$1', $css);
			$css = preg_replace('/\s\s+(.*)/', '$1',$css);
			$css = str_replace(';}', '}', $css);
			$css = str_replace(' {', '{', $css);
			$css_content = $css;			
			foreach(glob(PLUGINS_ROOT.DS.'djg_google_xml_sitemaps'.DS.'cache'.DS.'*.css') as $file) unlink($file);
			file_put_contents(PLUGINS_ROOT.DS.'djg_google_xml_sitemaps'.DS.'cache'.DS.$name,$css_content);
			return $css_content;
		}
	}

	function ajax_sort_css_files()
	{
		$action 				= $_POST['action'];
		$updateRecordsArray 	= $_POST['filesArray'];
		if ($action == "updateRecordsListings"):
			$listingCounter = 0;
			foreach ($updateRecordsArray as $recordIDValue):
				$PDO = Record::getConnection();
				$sql = "UPDATE ".TABLE_PREFIX."djg_google_xml_sitemaps_css_files SET sort_order = " . $listingCounter . " WHERE id = " . $recordIDValue;
				$stmt = $PDO->prepare($sql);
				$stmt->execute();
				//$db = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$listingCounter = $listingCounter + 1;
			endforeach;
			echo '<pre>';print_r($updateRecordsArray);echo '</pre>';
		endif;
	}  // end function
	
	/** JS */
	
	function js_file(){
		$offset = 60 * 60 * 24 * 31;		
		header('Content-type: text/css; charset: UTF-8');  
		header('Cache-Control: max-age=' . $offset . ', must-revalidate');
		header('Expires: ' . gmdate ("D, d M Y H:i:s", time() + $offset) . ' GMT');
		echo self::js_min();
	}
	
	function js_min()
	{	
		$PDO = Record::getConnection();
		$sql = "SELECT filename FROM ".TABLE_PREFIX."djg_google_xml_sitemaps_js_files ORDER BY sort_order ASC, id DESC";
		$stmt = $PDO->prepare($sql);
		$stmt->execute();
		$db = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$js = null;
		$md5 = null;
		foreach ($db as &$value):
			$file = CMS_ROOT.$value['filename'];
			if (file_exists($file)) {
				$md5 .= date (filemtime($file));
				$js .= file_get_contents(CMS_ROOT.$value['filename'],true);
			}
		endforeach;
		$name = md5($md5).'.js';
		if(file_exists(PLUGINS_ROOT.DS.'djg_google_xml_sitemaps'.DS.'cache'.DS.$name))readfile(PLUGINS_ROOT.DS.'djg_google_xml_sitemaps'.DS.'cache'.DS.$name);
		else{
			$js_content = JSMin::minify($js);
			foreach(glob(PLUGINS_ROOT.DS.'djg_google_xml_sitemaps'.DS.'cache'.DS.'*.js') as $file) unlink($file);
			file_put_contents(PLUGINS_ROOT.DS.'djg_google_xml_sitemaps'.DS.'cache'.DS.$name,$js_content);
			return $js_content;
		}
	}

	function ajax_sort_js_files()
	{
		$action 				= $_POST['action'];
		$updateRecordsArray 	= $_POST['filesArray'];
		if ($action == "updateRecordsListings"):
			$listingCounter = 0;
			foreach ($updateRecordsArray as $recordIDValue):
				$PDO = Record::getConnection();
				$sql = "UPDATE ".TABLE_PREFIX."djg_google_xml_sitemaps_js_files SET sort_order = " . $listingCounter . " WHERE id = " . $recordIDValue;
				$stmt = $PDO->prepare($sql);
				$stmt->execute();
				//$db = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$listingCounter = $listingCounter + 1;
			endforeach;
			echo '<pre>';print_r($updateRecordsArray);echo '</pre>';
		endif;
	}  // end function
}