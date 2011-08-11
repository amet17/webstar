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
$yjsg0 = 0;
if ($this->countModules('adv1')) $yjsg0++;
if ($this->countModules('adv2')) $yjsg0++;
if ($this->countModules('adv3')) $yjsg0++;
if ($this->countModules('adv4')) $yjsg0++;
if ($this->countModules('adv5')) $yjsg0++;
if ( $yjsg0 == 5 ) {
	$yjsg0width = '20%';}
if ( $yjsg0 == 4 ) {
	$yjsg0width = '25%';}
if ( $yjsg0 == 3 ) {
	$yjsg0width = '33.3%';}
elseif ( $yjsg0 == 2 ) {
	$yjsg0width = '50%';
} else if ($yjsg0 == 1) {
	$yjsg0width = '100%';
}

?>
<?php if (
$this->countModules('adv1') || 
$this->countModules('adv2') || 
$this->countModules('adv3') ||
$this->countModules('adv4') || 
$this->countModules('adv5')) {?>
<div id="yjsg0_shadot" style="font-size:<?php echo $css_font; ?>; width:<?php echo $css_width; ?>;"></div>
<div id="yjsg0" style="font-size:<?php echo $css_font; ?>; width:<?php echo $css_width; ?>;">
  <?php if ($this->countModules('adv1')) {?>
  <div id="adv1" class="yjsgxhtml" style="width:<?php echo $yjsg0width ?>;">
    <jdoc:include type="modules" name="adv1" style="YJsgxhtml" />
  </div>
  <?php } ?>
  <?php if ($this->countModules('adv2')) {?>
  <div id="adv2" class="yjsgxhtml" style="width:<?php echo $yjsg0width ?>;">
   <jdoc:include type="modules" name="adv2" style="YJsgxhtml" />
  </div>
  <?php } ?>
  <?php if ($this->countModules('adv3')) {?>
  <div id="adv3" class="yjsgxhtml" style="width:<?php echo $yjsg0width ?>;">
    <jdoc:include type="modules" name="adv3" style="YJsgxhtml" />
  </div>
  <?php } ?>
  <?php if ($this->countModules('adv4')) {?>
  <div id="adv4" class="yjsgxhtml" style="width:<?php echo $yjsg0width ?>;">
    <jdoc:include type="modules" name="adv4" style="YJsgxhtml" />
  </div>
  <?php } ?>
  <?php if ($this->countModules('adv5')) {?>
  <div id="adv5" class="yjsgxhtml" style="width:<?php echo $yjsg0width ?>;">
   <jdoc:include type="modules" name="adv5" style="YJsgxhtml" />
  </div>
  <?php } ?>
</div>
<div id="yjsg0_shadob" style="font-size:<?php echo $css_font; ?>; width:<?php echo $css_width; ?>;"></div>
<?php } ?>
