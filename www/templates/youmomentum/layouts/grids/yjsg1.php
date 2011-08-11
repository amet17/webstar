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
$yjsg1 = 0;
if ($this->countModules('user1')) $yjsg1++;
if ($this->countModules('user2')) $yjsg1++;
if ($this->countModules('user3')) $yjsg1++;
if ($this->countModules('user4')) $yjsg1++;
if ($this->countModules('user5')) $yjsg1++;
if ( $yjsg1 == 5 ) {
	$yjsg1width = '20%';}
if ( $yjsg1 == 4 ) {
	$yjsg1width = '25%';}
if ( $yjsg1 == 3 ) {
	$yjsg1width = '33.3%';}
elseif ( $yjsg1 == 2 ) {
	$yjsg1width = '50%';
} else if ($yjsg1 == 1) {
	$yjsg1width = '100%';
}

?>
<?php if (
$this->countModules('user1') || 
$this->countModules('user2') || 
$this->countModules('user3') ||
$this->countModules('user4') || 
$this->countModules('user5')) {?>

<div id="yjsg1" style="font-size:<?php echo $css_font; ?>; width:<?php echo $css_width; ?>;">
  <?php if ($this->countModules('user1')) {?>
  <div id="user1" class="yjsgxhtml" style="width:<?php echo $yjsg1width ?>;">
    <jdoc:include type="modules" name="user1" style="YJsgxhtml" />
  </div>
  <?php } ?>
  <?php if ($this->countModules('user2')) {?>
  <div id="user2" class="yjsgxhtml" style="width:<?php echo $yjsg1width ?>;">
   <jdoc:include type="modules" name="user2" style="YJsgxhtml" />
  </div>
  <?php } ?>
  <?php if ($this->countModules('user3')) {?>
  <div id="user3" class="yjsgxhtml" style="width:<?php echo $yjsg1width ?>;">
    <jdoc:include type="modules" name="user3" style="YJsgxhtml" />
  </div>
  <?php } ?>
  <?php if ($this->countModules('user4')) {?>
  <div id="user4" class="yjsgxhtml" style="width:<?php echo $yjsg1width ?>;">
    <jdoc:include type="modules" name="user4" style="YJsgxhtml" />
  </div>
  <?php } ?>
  <?php if ($this->countModules('user5')) {?>
  <div id="user5" class="yjsgxhtml" style="width:<?php echo $yjsg1width ?>;">
   <jdoc:include type="modules" name="user5" style="YJsgxhtml" />
  </div>
  <?php } ?>
</div>
<?php } ?>
