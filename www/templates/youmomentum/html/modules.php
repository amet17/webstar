<?php
/**
 * @version		$Id: modules.php 10822 2008-08-27 17:16:00Z tcp $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * This is a file to add template specific chrome to module rendering.  To use it you would
 * set the style attribute for the given module(s) include in your template to use the style
 * for each given modChrome function.
 *
 * eg.  To render a module mod_test in the sliders style, you would use the following include:
 * <jdoc:include type="module" name="test" style="slider" />
 *
 * This gives template designers ultimate control over how modules are rendered.
 *
 * NOTICE: All chrome wrapping methods should be named: modChrome_{STYLE} and take the same
 * two arguments.
 */



/*
 * Module chrome for rounded corners
 */
 
function modChrome_yjround($module, &$params, &$attribs){
 ?>

<div class="yjround<?php echo $params->get('moduleclass_sfx'); ?>">
  <div>
    <div>
      <div>
        <?php if ($module->showtitle) : ?>
        <h3>
          <?php
					$title = $module->title;
					$title = split(' ', $title);
					$title[0] = '<span>'.$title[0].'</span>';
					$title= join(' ', $title);
					echo $title; 
				?>
        </h3>
        <?php endif; ?>
        <div class="yjround_in"><?php echo $module->content; ?></div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php /*
 * Module chrome for square modules
 */
function modChrome_yjsquare($module, &$params, &$attribs){ ?>
<div class="yjsquare<?php echo $params->get('moduleclass_sfx'); ?>">
  <?php if ($module->showtitle) : ?>
  <h3>
    <?php
					$title = $module->title;
					$title = split(' ', $title);
					$title[0] = '<span>'.$title[0].'</span>';
					$title= join(' ', $title);
					echo $title; 
				?>
  </h3>
  <?php endif; ?>
  <div class="yjsquare_in"><?php echo $module->content; ?></div>
</div>
<?php } ?>
<?php /* Module chrome for shelf  */
function modChrome_YJsgxhtml($module, &$params, &$attribs){
?>
<div class="yjsquare<?php echo $params->get('moduleclass_sfx'); ?>">
  <?php if ($module->showtitle) : ?>
  <h3>
    <?php
					$title = $module->title;
					$title = split(' ', $title);
					$title[0] = '<span>'.$title[0].'</span>';
					$title= join(' ', $title);
					echo $title; 
				?>
  </h3>
  <?php endif; ?>
  <div class="yjsquare_in"><?php echo $module->content; ?></div>
</div>
<?php } ?>
