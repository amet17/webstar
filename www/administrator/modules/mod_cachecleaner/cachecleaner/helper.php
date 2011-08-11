<?php
/**
 * Module Helper File
 *
 * @package     Cache Cleaner
 * @version     1.9.4
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die();

class modCacheCleaner
{
	function render( $params )
	{
		JHTML::_( 'behavior.mootools' );

		require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'versions.php';
		$version = NoNumberVersions::getXMLVersion( 'cachecleaner', 'module', 1, 1 );

		$document =& JFactory::getDocument();
		$script = "
			var cachecleaner_root = '".JURI::base( true )."';
			var cachecleaner_msg = '".str_replace( "'", "\'", JText::_( 'CC_CLEANING_CACHE' ) )."';
			var cachecleaner_msg_inactive = '".str_replace( "'", "\'", JText::_( 'CC_SYSTEM_PLUGIN_NOT_ENABLED' ) )."';
			var cachecleaner_msg_success = '".str_replace( "'", "\'", JText::_( 'CC_CACHE_CLEANED' ) )."';
			var cachecleaner_msg_failure = '".str_replace( "'", "\'", JText::_( 'CC_CACHE_COULD_NOT_BE_CLEANED' ) )."';";
		$document->addScriptDeclaration( $script );
		$document->addScript( JURI::base( true ).'/modules/mod_cachecleaner/cachecleaner/js/script.js'.$version );
		$document->addStyleSheet( JURI::base( true ).'/modules/mod_cachecleaner/cachecleaner/css/style.css'.$version );

		$text = JText::_( $params->get( 'icon_text', 'CC_CLEAN_CACHE' ) );
		$title = $text;
		$class = '';
		if ( $params->get( 'display_link', 'both' ) == 'text' ) {
			$class = 'no_icon';
		} else if ( $params->get( 'display_link', 'both' ) == 'icon' ) {
			$text = '&nbsp;';
			$class = 'no_text';
		}
		if ( $params->get( 'display_tooltip', 1 ) ) {
			JHTML::_( 'behavior.tooltip' );
			$class .= ' hasTip';
			$title = JText::_( 'CACHE_CLEANER' ).'::'.JText::_( 'CC_CLEAN_YOUR_CACHE' ).'<br /><br /><em>'.JText::_( 'CC_PURGE_YOUR_CACHE' ).'</em>';
		}

		echo '<a href="javascript://" onclick="return false;" class="'.trim( $class ).'" id="cachecleaner" title="'.$title.'"><span>'.$text.'</span></a>';
	}
}