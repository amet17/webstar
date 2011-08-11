<?php
/**
 * @package		YJSimple Grid Joomla! Template Framework Elements
 * @author      http://www.youjoomla.com
 * @copyright	Copyright (c) Since 2006 Youjoomla LLC. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class JElementYJSGParamTitle extends JElement {
	var	$_name = 'YJSGParamTitle';
	
	function fetchElement($name, $value, &$node, $control_name){
	$document =& JFactory::getDocument();
    $yjsgtPath = JURI::root(true).'/templates/youmomentum/';
	$document->addStyleSheet($yjsgtPath."/css/yjsg_admin.css");

		// Output
		
		return '
	
		<div class="yjsg_param_title">
			<div class="yjsg_param_title_l">
			'.JText::_($value).'
			</div>
		</div>
		';
	}
	
}

?>