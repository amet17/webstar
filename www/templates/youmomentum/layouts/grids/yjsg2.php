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
$yjsg2 = 0;
if ($this->countModules('user6')) $yjsg2++;
if ($this->countModules('user7')) $yjsg2++;
if ($this->countModules('user8')) $yjsg2++;
if ($this->countModules('user9')) $yjsg2++;
if ($this->countModules('user10')) $yjsg2++;
if ( $yjsg2 == 5 ) {
	$yjsg2width = '20%';}
if ( $yjsg2 == 4 ) {
	$yjsg2width = '25%';}
if ( $yjsg2 == 3 ) {
	$yjsg2width = '33.3%';}
elseif ( $yjsg2 == 2 ) {
	$yjsg2width = '50%';
} else if ($yjsg2 == 1) {
	$yjsg2width = '100%';
}

?>
<?php if (
$this->countModules('user6') || 
$this->countModules('user7') || 
$this->countModules('user8') ||
$this->countModules('user9') || 
$this->countModules('user10')) {?>

<div id="yjsg2">
<div id="yjsg2_in" style="font-size:<?php echo $css_font; ?>; width:<?php echo $css_width; ?>;">
  <?php if ($this->countModules('user6')) {?>
  <div id="user6" class="yjsgxhtml" style="width:<?php echo $yjsg2width ?>;">
    <jdoc:include type="modules" name="user6" style="YJsgxhtml" />
  </div>
  <?php } ?>
  <?php if ($this->countModules('user7')) {?>
  <div id="user7" class="yjsgxhtml" style="width:<?php echo $yjsg2width ?>;">
   <jdoc:include type="modules" name="user7" style="YJsgxhtml" />
  </div>
  <?php } ?>
  <?php if ($this->countModules('user8')) {?>
  <div id="user8" class="yjsgxhtml" style="width:<?php echo $yjsg2width ?>;">
    <jdoc:include type="modules" name="user8" style="YJsgxhtml" />
  </div>
  <?php } ?>
  <?php if ($this->countModules('user9')) {?>
  <div id="user9" class="yjsgxhtml" style="width:<?php echo $yjsg2width ?>;">
    <jdoc:include type="modules" name="user9" style="YJsgxhtml" />
  </div>
  <?php } ?>
  <?php if ($this->countModules('user10')) {?>
  <div id="user10" class="yjsgxhtml" style="width:<?php echo $yjsg2width ?>;">
   <jdoc:include type="modules" name="user10" style="YJsgxhtml" />
  </div>
  <?php } ?>
</div>
</div>
<?php } ?>
