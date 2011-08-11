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

?>
<!-- BOTTOM PART OF THE SITE LAYOUT -->

<div id="centerbottom" style="font-size:<?php echo $css_font; ?>; width:<?php echo $css_width; ?>;">
<?php if ($this->countModules('topout')) { ?>
<!-- topout module position -->
<div class="botmt"></div>
<div id="topout">
  <jdoc:include type="modules" name="topout" style="yjsquare" />
</div>
<div class="botmb"></div>
<!-- end topout module position -->
<?php } ?>
<!-- pathway -->
<?php if ($this->countModules('breadcrumb')) { ?>
<div id="pathway"> You are here:&nbsp;&nbsp;
  <jdoc:include type="modules" name="breadcrumb" />
</div>
<?php } ?>
<!-- end pathway -->
<!--MAIN LAYOUT HOLDER -->
<div id="holder">
  <!-- messages -->
  <jdoc:include type="message" />
  <!-- end messages -->
  <?php if ($this->countModules('left')) { ?>
  <!-- left block -->
  <div id="leftblock" style="width:<?php echo $leftblock ?>;">
    <div class="inside">
      <jdoc:include type="modules" name="left" style="yjsquare" />
    </div>
  </div>
  <!-- end left block -->
  <?php } ?>
  <!-- MID BLOCK WITH TOP AND BOTTOM MODULE POSITION -->
  <div id="midblock" style="width:<?php echo $midblock ?>;">
    <div class="insidem">
      <?php if ($this->countModules('top')) { ?>
      <!-- top module-->
      <div id="topmodule">
        <jdoc:include type="modules" name="top" style="yjsquare" />
      </div>
      <!-- end top module-->
      <?php } ?>
      <!-- component -->
      <jdoc:include type="component"  />
      <!-- end component -->
      <?php if ($this->countModules('bottom')) { ?>
      <!-- bottom module position -->
      <div id="bottommodule">
        <jdoc:include type="modules" name="bottom" style="yjsquare" />
      </div>
      <!-- end bottom module position -->
      <?php } ?>
    </div>
    <!-- end mid block insidem class -->
  </div>
  <!-- end mid block div -->
  <!-- END MID BLOCK -->
  <?php if ($this->countModules('right')) { ?>
  <!-- right block -->
  <div id="rightblock" style="width:<?php echo $rightblock ?>;">
    <div class="inside">
      <jdoc:include type="modules" name="right" style="yjsquare" />
    </div>
  </div>
  <!-- end right block -->
  <?php } ?>
</div>
<!-- end holder div -->
<!-- END BOTTOM PART OF THE SITE LAYOUT -->
<?php if ($this->countModules('bottomout')) { ?>
<!-- bottomout module position -->
<div class="botmt"></div>
<div id="bottomout">
  <jdoc:include type="modules" name="bottomout" style="yjsquare" />
</div>
<div class="botmb"></div>
<!-- end bottomout module position -->
<?php } ?>
