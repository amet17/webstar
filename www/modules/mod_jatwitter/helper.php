<?php
/*
# ------------------------------------------------------------------------
# JA Twitter module for joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2009 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: J.O.O.M Solutions Co., Ltd
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# This file may not be redistributed in whole or significant part.
# ------------------------------------------------------------------------
*/
// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );
/**
 * modJaTwitterHelper  class.
 */
class modJaTwitterHelper {
	
	/**
	 * @var JATwitter $jaTwitter
	 *
	 * @access public.
	 */
	var $jaTwitter = null;
	
	/**
	 * @var boolean $isCache
	 *
	 * @access public.
	 */
	var $isCache = false;
	
	/**
	 * @var integer $cacheTimeLife
	 *
	 * @access public.
	 */
	
	var $cacheTimeLife = 30;
	
	/**
	 * constructor
	 */
	function modJaTwitterHelper($username = '', $password = '') {
		$this->jaTwitter = new JATwitter ();
		// set username and password using for oAuth
	//$this->jaTwitter = $this->jaTwitter->setAuth( $username, $password );		
	}
	
	/**
	 * set options using for cache data
	 *
	 * @param boolean enable $use equal true
	 */
	function setCache($use = true, $timeLife = 30) {
		$this->isCache = $use;
		$this->cacheTimeLife = $timeLife;
	}
	
	/**
	 * get twitter's data base on method call, and process get and store data in  cache file
	 *
	 * @param string $twitterMethod api twitter method (@see http://apiwiki.twitter.com/Twitter-API-Documentation)
	 * @param string $screenName
	 * @param integer $count
	 * @param integer $overrideCacheTime
	 * @return array.
	 */
	function getTwitter($twitterMethod = 'show', $screenName, $count = 10, $overrideCacheTime = false) {
		// check data valid 
		if ($screenName == '') {
			return false;
		}
		
		$this->jaTwitter->setScreenName ( $screenName );
		// if enable cache data
		if ($this->isCache) {
			$cache = & JFactory::getCache ();
			$cache->setCaching ( true );
			if ($overrideCacheTime) {
				$cache->setLifeTime ( $overrideCacheTime * 60 );
			} else {
				$cache->setLifeTime ( $this->cacheTimeLife * 60 );
			}
			$data = $cache->get ( array ($this->jaTwitter, 'getTweets' ), array ($twitterMethod, $count ) );
		
		} else {
			$data = $this->jaTwitter->getTweets ( $twitterMethod, $count );
		}
		return $data;
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
	function loadFiles($params, $module) {
		//if( $params->get('load_css_file') ) {
		global $mainframe;
		JHTML::stylesheet ( 'style.css', 'modules/' . $module . '/assets/' );
		if (is_file ( JPATH_SITE . DS . 'templates' . DS . $mainframe->getTemplate () . DS . 'css' . DS . $module . ".css" ))
			JHTML::stylesheet ( $module . ".css", 'templates/' . $mainframe->getTemplate () . '/css/' );
		//}
	}
	
	/**
	 * get list from RSS resouce, it's legacy help to run old version
	 *
	 * @params JParam $params
	 * @return Object xml. or boolean 
	 */
	function getList($params) {
		
		if (trim ( $params->get ( 'taccount' ) ) == '') {
			return false;
		}
		$rssUrl = "http://twitter.com/statuses/user_timeline/" . $params->get ( 'taccount' ) . ".rss?count=" . $params->get ( 'show_limit' );
		
		//  get RSS parsed object
		$options = array ();
		$options ['rssUrl'] = $rssUrl;
		if ($params->get ( 'enable_cache' )) {
			$options ['cache_time'] = $params->get ( 'cache_time' );
			$options ['cache_time'] *= 60;
		} else {
			$options ['cache_time'] = null;
		}
		
		$rssDoc = & JFactory::getXMLparser ( 'RSS', $options );
		
		if ($rssDoc != false) {
			$items = $rssDoc->get_items ();
			return $items;
		} else {
			return false;
		}
	}
	
	function getFollowButton($params)
	{
		$typeOfFollow = $params->get('typefollowbutton','apiconnect');
		$apikey =  $params->get ( 'apikey' );
		$screenName = $params->get ( 'taccount' );
		$stylebutton = $params->get("style_of_follow_button");
		$followbutton = "";
	    if($typeOfFollow == "simple")
		{
			$image = "";
			if($stylebutton == "none")
			{
			   $image = JText::_("Follow me!");
			}
			else
			{
			   $image = '<img src="http://twitter-badges.s3.amazonaws.com/'.$stylebutton.'" alt="Follow '.$screenName.' on Twitter"/>';
			}
			$followbutton ='
			<center>
				<form target="hidden_frame" id="form_follow" action="http://api.twitter.com/1/friendships/create.xml?screen_name='.$screenName.'&follow=true" method="POST">
					<a href="javascript:;" onclick="clickFollow();">'.$image.'</a>
				</form>
				<div style="display:none;visible:hidden;">
					<iframe src="" height="1" width="1" border="0" scrolling="no" name="hidden_frame" id="hidden_frame"></iframe>
				</div>
				 <script type="text/javascript">
					/* <![CDATA[ */
				   function clickFollow()
				   {
					  $("form_follow").submit();
					  return true;
				   }
				   /* ]]> */
				 </script>
			</center>
			';
			
		}
		else
		{
		    $followbutton ='
				<center>
				<script src="http://platform.twitter.com/anywhere.js?id='.$apikey.'&amp;v=1" type="text/javascript"></script>
				  <div id="anywhere-block-follow-button"></div>
				  <script type="text/javascript">
				  /* <![CDATA[ */
				  twttr.anywhere(function (twitter) {
						  twitter("#anywhere-block-follow-button").followButton("'.$screenName.'");
					  });
					/* ]]> */
				  </script>
				</center>
				';
		}
		return $followbutton;
	}
	function convertObject($list = array())
	{
		$result = array();
		if(!empty($list))
		{
		   foreach($list as $item)
		   {
			 $tmp_obj = new twitter_item();
			 $tmp_obj->screen_name = $item->screen_name;
			 $tmp_obj->profile_image_url = $item->profile_image_url;
			 $tmp_obj->date = $item->created_at;
			 $tmp_obj->description = $item->text;
			 $result[] = $tmp_obj;
		   }
		}
		return $result;
	}
}
class twitter_item
{
	public $link = "";
	public $date;
	public $screen_name;
	public $profile_image_url;
	public $name;
	public $description;
	public $source;
	
	public function get_screen_name()
	{
		return $this->screen_name;
	}
	public function get_link()
	{	
		return $this->link;
	}
	public function get_date($format)
	{	
		return date('D, j M Y',strtotime($this->date));
	}
	public function get_description()
	{	
		return $this->description;
	}
}
?>