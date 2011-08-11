<?php
/*======================================================================*\
|| #################################################################### ||
|| # Youjoomla LLC - YJ- Licence Number 3145YI543
|| # Licensed to - Siarhei Matusevich
|| # ---------------------------------------------------------------- # ||
|| # Copyright (C) Since 2006 Youjoomla LLC. All Rights Reserved.       ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- THIS IS NOT FREE SOFTWARE ---------------- #      ||
|| # http://www.youjoomla.com | http://www.youjoomla.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/

defined( '_JEXEC' ) or die( 'Restricted index access' );

define( 'TEMPLATEPATH', dirname(__FILE__) );
require( TEMPLATEPATH.DS."settings.php");



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<?php JHTML::_('behavior.mootools'); ?>
<link href="<?php echo $yj_site ?>/css/template.<?php echo $cssextens; ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $yj_site ?>/css/<?php echo $css_file; ?>.<?php echo $cssextens; ?>" rel="stylesheet" type="text/css" />

<?php if ($text_direction == 1) { ?>
	<link rel="stylesheet" href="<?php echo $yj_site ?>/css/template_rtl.<?php echo $cssextens; ?>" type="text/css" />
<?php  } ?>



<link rel="shortcut icon" href="<?php echo $yj_site ?>/favicon.ico" />
<?php require( TEMPLATEPATH.DS."head.php");?>
</head>
<body id="<?php echo $body_id ?>">
<div id="centertop" style="font-size:<?php echo $css_font; ?>; width:<?php echo $css_width; ?>;">
  <?php if ($ie6notice == 1){ ?>
  <!-- notices -->
  <!--[if lte IE 6]>
<p class="clip" style="text-align:center" >Hello visitor.You are using IE6 , an outdated version of Internet Explorer. Please consider upgrading. Click <a href="http://www.webstandards.org/action/previous-campaigns/buc/" target="_blank" >here</a> for more info .</p>
<![endif]-->
  <?php } ?>
  <?php if($nonscript == 1 ){?>
  <noscript>
  <p class="error" style="text-align:center" >This Joomla Template is equiped with JavaScript. Your browser does not support JavaScript! Please enable it for maximum experience. Thank you.</p>
  </noscript>
  <?php } ?>
  <!--end  notices -->
  <!--header-->
  <div id="header">
    <div id="logo" class="png" style="width:<?php echo $logo_width; ?>;">
      <div id="tags" style="width:<?php echo $logo_width; ?>;">
        <h1 style="width:<?php echo $logo_width; ?>;"> <a href="index.php" title="<?php echo $tags?>"><?php echo $seo ?></a> </h1>
      </div>
      <!-- end tags -->
    </div>
    <!-- end logo -->
    <!--top menu-->
    <div id="<?php echo $topmenuclass ?>" style="font-size:<?php echo $css_font; ?>; width:<?php echo $top_menu_width; ?>;">
      <div id="<?php echo $menuclass ?>"> <?php echo $topmenu; ?> </div>
    </div>
    <!-- end top menu -->
  </div>
  <!-- end header -->
</div>
<!-- end centartop-->
<?php 
if (
$this->countModules('adv1') || 
$this->countModules('adv2') || 
$this->countModules('adv3') ||
$this->countModules('adv4') || 
$this->countModules('adv5')) {
require( TEMPLATEPATH.DS."layouts/grids/yjsg0.php");
}
?>
<?php 
if (
$this->countModules('user1') || 
$this->countModules('user2') || 
$this->countModules('user3') ||
$this->countModules('user4') || 
$this->countModules('user5')) {
require( TEMPLATEPATH.DS."layouts/grids/yjsg1.php");
}
?>
<?php require( TEMPLATEPATH.DS."layouts/layout".$site_layout.".php");?>
</div>
<!-- end centerbottom-->
<?php 
if (
$this->countModules('user6') || 
$this->countModules('user7') || 
$this->countModules('user8') ||
$this->countModules('user9') || 
$this->countModules('user10')) {
require( TEMPLATEPATH.DS."layouts/grids/yjsg2.php");
}
?>

</body>
</html>
