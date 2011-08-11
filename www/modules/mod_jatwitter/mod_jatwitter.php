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

require_once (dirname ( __FILE__ ) . DS . 'jatwitter.php');
require_once (dirname ( __FILE__ ) . DS . 'helper.php');

// get params.
$taccount = $params->get ( 'taccount' );
$show_limit = $params->get ( 'show_limit' );
$headingtext = $params->get ( 'headingtext' );
$showfollowlink = $params->get ( 'showfollowlink' );
$showtextheading = $params->get ( 'showtextheading' );
$displayitem = $params->get ( 'displayitem', 1 );
$showIcon = $params->get ( 'show_icon', 1 );
$showUsername = $params->get ( 'show_username', 1 );
$showSource = $params->get ( 'show_source', 1 );
/*$username = $params->get( 'username' );
$password = $params->get( 'password'); */
$apikey = $params->get ( 'apikey' );
$screenName = $params->get ( 'taccount' , 'joomlart');
$useDisplayAccount = $params->get ( 'use_display_taccount', 0 );
$useFriends = $params->get ( 'use_friends', 0 );
$iconsize = $params->get ( 'icon_size', 48 );
$sizeIconaccount = $params->get ( 'size_iconaccount', 48 );
$sizeIconfriend = $params->get ( 'size_iconfriend', 24 );
$twitter_layout = $params->get('layout', '');
$fix_oldversion = $params->get('fix_oldversion',1);
$cache_time	=	$params->get ( 'cache_time', 30 );

$jatHelper = new modJaTwitterHelper ();
$jatHelper->loadFiles ( $params, $module->module );
// render layout 

// enable or disable using cache data
$jatHelper->setCache ( $params->get ( 'enable_cache' ), $params->get ( 'cache_time' ) );
// if show account information
if ($useDisplayAccount) {
	$accountInfo = $jatHelper->getTwitter ( 'show', $screenName );
}
if ($useFriends) {
	$friends = $jatHelper->getTwitter ( 'friends', $screenName, $params->get ( 'max_friends', 10 ) );
}
$list = array ();
$twitters = array ();
if ($params->get ( 'show_tweet','1' ) == '1') {
	$list = $jatHelper->getTwitter ( "user_timeline", $screenName, $show_limit, ( int ) $params->get ( 'tweets_cachetime', 30 ) );
	if($fix_oldversion == 1)
	{
		$twitters = $jatHelper->convertObject($list);
	}
}

//$layout = 'default.ajax';
$layout = "default";
if($twitter_layout == "ajax")
{
  $layout = 'default.ajax';
}
include (JModuleHelper::getLayoutPath ( 'mod_jatwitter', $layout ));
?>