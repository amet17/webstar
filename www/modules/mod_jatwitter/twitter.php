<?php
/*
# ------------------------------------------------------------------------
# JA Twitter module for joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/

if (!defined ('_JEXEC')) {
	define( '_JEXEC', 1 );
	$path = dirname(dirname(dirname(__FILE__)));
	define('JPATH_BASE', $path );

	if (strpos(php_sapi_name(), 'cgi') !== false && !empty($_SERVER['REQUEST_URI'])) {
		//Apache CGI
		$_SERVER['PHP_SELF'] =  rtrim(dirname(dirname(dirname($_SERVER['PHP_SELF']))), '/\\');
	} else {
		//Others
		$_SERVER['SCRIPT_NAME'] =  rtrim(dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))), '/\\');
	}
	
	define( 'DS', DIRECTORY_SEPARATOR );
	require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
	require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
	JDEBUG ? $_PROFILER->mark( 'afterLoad' ) : null;

	/**
	 * CREATE THE APPLICATION
	 *
	 * NOTE :
	 */
	$mainframe =& JFactory::getApplication('administrator');
	
	/**
	 * INITIALISE THE APPLICATION
	 *
	 * NOTE :
	 */
	$mainframe->initialise(array(
		'language' => $mainframe->getUserState( "application.lang", 'lang' )
	));
	
	//JPluginHelper::importPlugin('system');
	
	// trigger the onAfterInitialise events
	//JDEBUG ? $_PROFILER->mark('afterInitialise') : null;
	//$mainframe->triggerEvent('onAfterInitialise');
}

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

$showIcon = isset($_POST[ 'show_icon'])?$_POST[ 'show_icon']: 1 ;
$showUsername = isset($_POST [ 'show_username'])?$_POST[ 'show_icon']: 1 ;
$showSource = isset($_POST['show_source'])?$_POST['show_source']: 1 ;
$iconsize = isset($_POST[ 'icon_size'])?$_POST[ 'icon_size']: 48 ;
$cache_time = isset($_POST[ 'cache_time'])?$_POST[ 'cache_time']: 30 ;

if(!empty($_POST)){
	$lang = JFactory::getLanguage();
	$lang->load('mod_jatwitter');
}


$jatTwitter = new ajaxTwitter( $_POST['username'], $_POST['count'], $cache_time );
$list = $jatTwitter->getListTweets();
include("tmpl/response.html.php");

class ajaxTwitter
{
	private $_format = "json";
	private $_username = "";
	private $_count = 10;
	private $_output = "";
	private $_status = null;
	private $_cache_time = 30;
	
	public function ajaxTwitter($username = "", $count = 10, $cache_time = null)
	{
		$this->_username = $username;
		$this->_count = $count;
		if(!empty($cache_time))
		{
			$this->_cache_time = $cache_time;
		}
	}
	public function setCacheTime($val = 30)
	{
		$this->_cache_time = $val;
	}
	public function getListTweets()
	{
		global $mainframe;
		$use_cache = $mainframe->getCfg("caching");
		$list = array();
		if ( $use_cache == "1") {
				$cache =& JFactory::getCache();
				$cache->setCaching( true );
				$cache->setLifeTime( $this->_cache_time *  60 );
				$list =  $cache->get( array( (new ajaxTwitter() ) , 'getLists' ), array() );
			} else {
				$list = ajaxTwitter::getLists();
			}
		return $list;
	}
    function getLists()
	{
		// marke request twitter api;
		$this->makeRequest();
		if( $this->_status == 200 ){
			return $this->__parserDataJSON();
		} else {
			return false;
		}
	}
	/**
	 * only parser json which response from api method.
	 */
	protected function __parserDataJSON(){
		include('json.php');
		if( $this->_output != '' ){
			$items = json_decode( $this->_output);		
			$out = array();		
			foreach( $items as $item ){
			    if( !isset($item->id) ) continue;
				$obj = new stdClass();
				$user = $item->user;
				$obj->id 	       = $this->getData( $item->id );
				$obj->source 	   =  $this->getData( $item->source );
				$obj->created_at   =  $this->getData( $item->created_at );
				$obj->text 		   =  $this->getData( $item->text );
				$obj->name 		   = $this->getData( $user->name );
				$obj->screen_name  = $this->getData( $user->screen_name );
				$obj->profile_image_url = $this->getData( $user->profile_image_url );
				$out[] = $obj;
			}
			return $out;	
		}
		return null;
	}
	/**
	 * get data for element's 'attribute
	 *  
	 * @param XML Attribute of XML
	 * @return string 
	 */
	protected function getData( $obj ){
		return @(string)$obj;
	}
	
	protected function makeRequest()
	{
		$curl = curl_init(); 
		curl_setopt ($curl, CURLOPT_URL, "http://twitter.com/statuses/user_timeline.json?screen_name=" . urlencode($this->_username) . "&count=".$this->_count);   
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   
		  
		$result = curl_exec ($curl);   
		curl_close ($curl);   
		  
		//header('Content-Type: application/xml; charset=ISO-8859-1');   
		$this->_status = 200;
		$this->_output = $result;
	}
	/**
	 * add hyper link......
	 *
	 * @var string $description
	 * @return string.
	 */
	function convert($description) {
		
		$description = preg_replace ( "#(^|[\n ])@([^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://www.twitter.com/\\2\" >@\\2</a>'", $description );
		$description = preg_replace ( "#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a href=\"\\2\" >\\2</a>'", $description );
		$description = preg_replace ( "#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://\\2\" >\\2</a>'", $description );
		$description = preg_replace ( "#(^|[\n ])\#([^ \"\t\n\r<:]*)#ise", "'\\1<a target=\"_blank\" href=\"http://twitter.com/search?q=#\\2\" >\\2</a>'", $description );
		$description = str_replace ( '&amp;', '&', $description );
		$description = str_replace ( '&', '&amp;', $description );
		return $description;
	}
	
	/**
	 * convert twitter's data to friendly date.
	 *
	 * @param string $createAt.
	 * @return string.
	 */
	function getDate($createdAt) {
		$now = & JFactory::getDate ();
		$createdAt = preg_replace ( "(\+\d{4}\s+)", "", $createdAt );
		
		$date = & JFactory::getDate ( strtotime ( $createdAt ) + ($now->toUnix () - time ()) );
		
		$diff = $now->toUnix () - $date->toUnix ();
		
		if ($diff < 60) {
			$createdDate = JText::_ ( 'LESS THAN A MINUTE AGO' );
		} elseif ($diff < 120) {
			$createdDate = JText::_ ( 'ABOUT A MINUTE AGO' );
		} elseif ($diff < (45 * 60)) {
			$createdDate = JText::sprintf ( 'MINUTES AGO', round ( $diff / 60 ) );
		} elseif ($diff < (90 * 60)) {
			$createdDate = JText::_ ( 'ABOUT AN HOUR AGO' );
		} elseif ($diff < (24 * 3600)) {
			$createdDate = JText::sprintf ( 'ABOUT SOME HOURS AGO', round ( $diff / 3600 ) );
		} else {
			$createdDate = JHTML::_ ( 'date', $date->toUnix (), JText::_ ( 'DATE_FORMAT_LC2' ) );
		}
		
		return $createdDate;
	}
	
	/**
	 * load css and js file.
	 *
	 * @param JParameter $params
	 * @param stdClass contain module information.
	 */
	function loadFiles($module) {
		$cssurl = 'modules/' . $module . '/assets/style.css' ;
		echo '<link rel="stylesheet" type="text/css" href="'.$cssurl.'" media="all">';
	}
	
}