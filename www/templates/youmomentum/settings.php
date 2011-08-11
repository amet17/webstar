<?php
/*======================================================================*\
|| #################################################################### ||
|| # Youjoomla LLC - YJ- Licence Number 3145YI583
|| # Licensed to - Siarhei Matusevich
|| # ---------------------------------------------------------------- # ||
|| # Copyright (C) Since 2006 Youjoomla LLC. All Rights Reserved.       ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- THIS IS NOT FREE SOFTWARE ---------------- #      ||
|| # http://www.youjoomla.com | http://www.youjoomla.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/
defined( '_JEXEC' ) or die( 'Restricted index access' );
$yj_site = JURI::base()."templates/".$this->template;
$yj_base = JURI::base();

require( TEMPLATEPATH.DS."links.php");


$default_color = $this->params->get("defaultcolor", "blue"); // set the default lime | cyan | purple 
$default_font  = $this->params->get("fontsize", "medium"); // SMALL | MEDIUM | BIG
$css_width = $this->params->get("css_width");

$text_direction = $this->params->get("text_direction",1);

//TOOLS CONTROL
$showfont = $this->params->get("showfont", "1"); // SHOW FONT SWITCH = 1 | HIDE FONT SWITCH = 0
$showcolor = $this->params->get("showcolor", "1");// SHOW COLOR SWITCH = 1 | HIDE COLOR SWITCH = 0
$showwidth = $this->params->get("showwidth", "0"); // SHOW WIDTH SWITCH = 1 | HIDE WIDTH SWITCH = 0

// LAYOUT
$site_layout = $this->params->get("site_layout");
$logo_width  = $this->params->get("logo_width");
$top_menu_width = $this->params->get("top_menu_width");

// SUCKERFISH  MENU SWITCH // 
$menu_name = $this->params->get("menuName", "mainmenu");// mainmenu by default, can be any Joomla! menu name

//MENU STYLE SWITCH//
$menustyle = $this->params->get("menustyle", "2");  //  1 = Standard Dropdown (Suckerfish)  | 2  = SMooth Dropdown | 3 = Dropline Menu | 4 = SmoothDropline menu |  5  = Split Menu 



// USE SERVER SIDE SCRIPT AND CSS COMPRESSION FOR FASTER PAGE LOAD 
// mod_gzip module  MUST BE ENABELED IN PHP.INI
// IF YOU ARE NOT SUER WHAT THIS IS LEAVE THIS SETTING 0
$compress = $this->params->get("compress", "0");	 // 1 = TURN COMPRESSION ON  |  0 = TURN COMPRESSION OFF 
// SEO SECTION //
$seo                    = $this->params->get ("seo", "Joomla 1.5 Template By Youjoomla.com");                      # JUST FOLOW THE TEXT
$tags                   = $this->params->get ("tags", "Joomla Templates by Youjoomla, Joomla Template Club, Youjoomla");# JUST FOLOW THE TEXT
$ie6notice  = $this->params->get("ie6notice", "0"); // 1 = ON | 0 = OFF   
// ADVISE VISITORS THAT THIR JAVASCRIPT IS DISABLED
$nonscript  = $this->params->get("nonscript", "0"); // 1 = ON | 0 = OFF 
#DO NOT EDIT BELOW THIS LINE//////////////////////////////////////////////////////////////////////////


require( TEMPLATEPATH.DS."styleswitcher.php");



// widths 
$leftcolumn                    = $this->params->get ("leftcolumn");
$rightcolumn                   = $this->params->get ("rightcolumn"); 
$maincolumn                    = $this->params->get ("maincolumn"); 
$widthdefined                  = $this->params->get ("widthdefined");



$leftcolumn_itmid                    = $this->params->get ("leftcolumn_itmid");
$rightcolumn_itmid                   = $this->params->get ("rightcolumn_itmid"); 
$maincolumn_itmid                    = $this->params->get ("maincolumn_itmid"); 
$widthdefined_itmid                  = $this->params->get ("widthdefined_itmid");



//START COLLAPSING THAT MODULE:)
$left = $this->countModules( 'left' );
$right = $this->countModules( 'right' );
if ( $left  &&  $right  ) {
	
	$leftblock  = $leftcolumn.$widthdefined;
	$midblock = $maincolumn.$widthdefined;
	$rightblock  = $rightcolumn.$widthdefined;
	$wrap    = 'wrap';
    $insidewrap='insidewrap';
	
	}elseif ( $left) {
	$midblock = $maincolumn + $leftcolumn.$widthdefined;
	$leftblock  = $leftcolumn.$widthdefined ;
	$wrap    = 'wrapblank';
	$insidewrap='insidewrapblank';
	
	}elseif ( $right) {
	$midblock = $maincolumn + $rightcolumn.$widthdefined;
	$rightblock  = $rightcolumn.$widthdefined ;
	$wrap    = 'wrap';
	$insidewrap='insidewrapblank';

	} else {
    $midblock = $leftcolumn + $rightcolumn + $maincolumn.$widthdefined;
	$wrap    = 'wrapblank';
	$insidewrap='insidewrapblank';
	}
	
	
$itemid = JRequest::getVar('Itemid');
$define_itemid = $this->params->get ("define_itemid");
	
	
$countitems = count( $define_itemid );
if ($countitems > 1){
//echo "vise od 1";


if( in_array($itemid,$define_itemid)){
$left = $this->countModules( 'left' );
$right = $this->countModules( 'right' );
if ( $left  &&  $right  ) {
	
	$leftblock  = $leftcolumn_itmid.$widthdefined_itmid;
	$midblock = $maincolumn_itmid.$widthdefined_itmid;
	$rightblock  = $rightcolumn_itmid.$widthdefined_itmid;
	$wrap    = 'wrap';
    $insidewrap='insidewrap';
	
	}elseif ( $left) {
	$midblock = $maincolumn_itmid + $leftcolumn_itmid.$widthdefined_itmid;
	$leftblock  = $leftcolumn_itmid.$widthdefined_itmid ;
	$wrap    = 'wrapblank';
	$insidewrap='insidewrapblank';
	
	}elseif ( $right) {
	$midblock = $maincolumn_itmid + $rightcolumn_itmid.$widthdefined_itmid;
	$rightblock  = $rightcolumn_itmid.$widthdefined_itmid ;
	$wrap    = 'wrap';
	$insidewrap='insidewrapblank';

	} else {
    $midblock = $leftcolumn_itmid + $rightcolumn_itmid + $maincolumn_itmid.$widthdefined_itmid;
	$wrap    = 'wrapblank';
	$insidewrap='insidewrapblank';
	}
}
}elseif ($countitems < 2) {
//echo "manje od 1";
$items = explode('|',$define_itemid);
if( in_array($itemid, $items) ){
$left = $this->countModules( 'left' );
$right = $this->countModules( 'right' );
if ( $left  &&  $right  ) {
	
	$leftblock  = $leftcolumn_itmid.$widthdefined_itmid;
	$midblock = $maincolumn_itmid.$widthdefined_itmid;
	$rightblock  = $rightcolumn_itmid.$widthdefined_itmid;
	$wrap    = 'wrap';
    $insidewrap='insidewrap';
	
	}elseif ( $left) {
	$midblock = $maincolumn_itmid + $leftcolumn_itmid.$widthdefined_itmid;
	$leftblock  = $leftcolumn_itmid.$widthdefined_itmid ;
	$wrap    = 'wrapblank';
	$insidewrap='insidewrapblank';
	
	}elseif ( $right) {
	$midblock = $maincolumn_itmid + $rightcolumn_itmid.$widthdefined_itmid;
	$rightblock  = $rightcolumn_itmid.$widthdefined_itmid ;
	$wrap    = 'wrap';
	$insidewrap='insidewrapblank';

	} else {
    $midblock = $leftcolumn_itmid + $rightcolumn_itmid + $maincolumn_itmid.$widthdefined_itmid;
	$wrap    = 'wrapblank';
	$insidewrap='insidewrapblank';
	}
	}
}


if ($compress == 1){
$jsextens ='php';
$cssextens ='php';
}else{
$jsextens ='js';
$cssextens ='css';
}

if (
$this->countModules('adv1') || 
$this->countModules('adv2') || 
$this->countModules('adv3') ||
$this->countModules('adv4') || 
$this->countModules('adv5')) {

$body_id = 'color';
}else{
$body_id = 'color2';
}


// menu code
	$document	= &JFactory::getDocument();
	$renderer	= $document->loadRenderer( 'module' );
	$options	 = array( 'style' => "raw" );
	$module	 = JModuleHelper::getModule( 'mod_mainmenu' );
	$topmenu = false; $subnav = false; $sidenav = false;
	

	// SPLIT MENU  NO SUBS

		
// SUCKERFISH OR MOO
	if ($menustyle == 1 or $menustyle== 2) :
		$module->params	= "menutype=$menu_name\nshowAllChildren=1\nclass_sfx=nav";
		$topmenu = $renderer->render( $module, $options );
		$menuclass = 'horiznav';
		$topmenuclass ='top_menu';

		
		
		elseif ($menustyle == 5) :
		$module->params	= "menutype=$menu_name\nstartLevel=0\nendLevel=1\nclass_sfx=split";
		$topmenu = $renderer->render( $module, $options );
		$menuclass = 'horiznav';
		$topmenuclass ='top_menu';
		
	endif;



?>
