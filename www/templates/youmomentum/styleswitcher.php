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
if(!isset($_SESSION))
{
session_start();
} 

$mystyles = array();


$mystyles['darkorange']['file'] = "darkorange";
$mystyles['darkblue']['file'] = "darkblue";
$mystyles['darkgreen']['file'] = "darkgreen";
$mystyles['bordo']['file'] = "bordo";
$mystyles['blue']['file'] = "blue"; 
$mystyles['brown']['file'] = "brown"; 
$mystyles['orange']['file'] = "orange";



if (isset($_GET['change_css']) && $_GET['change_css'] != "") {
    $_SESSION['css'] = $_GET['change_css'];
} else {
    $_SESSION['css'] = (!isset($_SESSION['css'])) ? $default_color : $_SESSION['css'];
}
switch ($_SESSION['css']) {
    case "darkorange":
    $css_file = "darkorange";
    break;
	case "darkgreen":
    $css_file = "darkgreen";
    break;
	case "darkblue":
    $css_file = "darkblue";
    break;
    case "bordo":
    $css_file = "bordo";
    break;
	case "blue":
    $css_file = "blue";
    break;
	case "brown":
    $css_file = "brown";
    break;
	case "orange":
    $css_file = "orange";
    break;
	default:
    $css_file = "bordo";

}




//FONT SWITCH

$myfont = array();


$myfont['small']['file'] = "9px";
$myfont['medium']['file'] = "11px";
$myfont['large']['file'] = "16px"; // default


$myfont['small']['label'] = '<img src="templates/'.$this->template.'/images/small.gif" alt="Small" title="Small" />&nbsp;';
$myfont['medium']['label'] = '<img src="templates/'.$this->template.'/images/medium.gif" alt="Medium" title="Medium" />&nbsp;';

$myfont['large']['label'] = '<img src="templates/'.$this->template.'/images/large.gif" alt="Large" title="Large" />&nbsp;';



if (isset($_GET['change_font']) && $_GET['change_font'] != "") {
    $_SESSION['font'] = $_GET['change_font'];
} else {
    $_SESSION['font'] = (!isset($_SESSION['font'])) ? $default_font : $_SESSION['font'];
}
switch ($_SESSION['font']) {
    case "small":
    $css_font = "9px";
    break;
    case "medium":
    $css_font = "11px";
    break;
	case "large":
    $css_font = "16px";
    break;
    default:
    $css_font = "11px";
}

// MENU
$mymenu = array();

$mymenu['dropdown']['file'] = 1;
$mymenu['sdropdown']['file'] = 2;
$mymenu['dropline']['file'] = 3;
$mymenu['sdropline']['file'] = 4;
$mymenu['split']['file'] = 5;


if (isset($_GET['change_menu']) && $_GET['change_menu'] != "") {
    $_SESSION['yjmenu'] = $_GET['change_menu'];
} else {
    $_SESSION['yjmenu'] = (!isset($_SESSION['yjmenu'])) ? $menustyle : $_SESSION['yjmenu'];
}
switch ($_SESSION['yjmenu']) {
    case "dropdown":
    $menustyle = 1;
	break;
    case "sdropdown":
    $menustyle = 2;
    break;
    case "dropline":
    $menustyle = 3;
    break;
    case "sdropline":
    $menustyle = 4;
    break;
    case "split":
    $menustyle = 5;
    break;
    default:
    $menustyle = 3;
}
// LAYOUT
if (isset($_GET['change_layout']) && $_GET['change_layout'] != "") {
    $_SESSION['yjlayout'] = $_GET['change_layout'];
} else {
    $_SESSION['yjlayout'] = (!isset($_SESSION['yjlayout'])) ? $site_layout : $_SESSION['yjlayout'];
}
switch ($_SESSION['yjlayout']) {
    case "1":
    $site_layout = 1;
	break;
    case "2":
    $site_layout = 2;
    break;
    case "3":
    $site_layout = 3;
    break;
    default:
    $site_layout = 2;
}

// DIRECTION
if (isset($_GET['change_tdirect']) && $_GET['change_tdirect'] != "") {
    $_SESSION['yjtdirect'] = $_GET['change_tdirect'];
} else {
    $_SESSION['yjtdirect'] = (!isset($_SESSION['yjtdirect'])) ? $text_direction : $_SESSION['yjtdirect'];
}
switch ($_SESSION['yjtdirect']) {
    case "1":
    $text_direction = 1;
	break;
    case "2":
    $text_direction = 2;
    break;
    default:
    $text_direction = 2;
}
?>