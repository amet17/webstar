<?php
/**
 * Plugin Helper File
 *
 * @package     AdminBar Docker
 * @version     1.4.7
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
* Plugin that docks the admin toolbars
*/
class plgSystemAdminBarDockerHelper
{
	function __construct( &$params )
	{
		$this->params = $params;
	}

	/*
	 * Place scripts and styles and load language
	 */
	function render()
	{
		JHTML::_('behavior.mootools');

		$this->template = JAdministrator::getTemplate();
		if ( !file_exists( JPATH_PLUGINS.DS.'system'.DS.'adminbardocker'.DS.'templates'.DS.$this->template.DS.'script.js' ) ) {
			// if template folder does not exist, fall back on default template khepri
			$this->template = 'khepri';
		}

		$ignorecookie = 0;
		if ( $this->params->showonpopups != 1 ) {
			$tmpl = JRequest::getCmd( 'tmpl', 'index' );
			if ( !in_array( $tmpl, array( 'index', 'cpanel' ) ) ) {
				if ( $this->params->showonpopups == 2 ) {
					$this->params->dock_state = 'docked';
					$ignorecookie = 1;
				} else {
					return;
				}
			}
		}

		$document =& JFactory::getDocument();
		$document->addScript( JURI::root( true ).'/plugins/system/adminbardocker/templates/'.$this->template.'/script.js' );
		$document->addScript( JURI::root( true ).'/plugins/system/adminbardocker/js/script.js' );
		$document->addStyleSheet( JURI::root( true ).'/plugins/system/adminbardocker/css/style.css' );
		$document->addStyleSheet( JURI::root( true ).'/plugins/system/adminbardocker/templates/'.$this->template.'/style.css' );

		$icon_set = preg_replace( '#^icons([0-9])#', 'iconset_0\1', $this->params->icon_set );
		if ( !JFile::exists( JPATH_SITE.DS.'plugins'.DS.'system'.DS.'adminbardocker'.DS.'images'.DS.$icon_set ) ) {
			$icon_set = 'iconset_11.png';
		}
		$css = '
			div.abd_icon div {
				background-image: url('.JURI::root( true ).'/plugins/system/adminbardocker/images/'.$icon_set.');
			}
		';
		$document->addStyleDeclaration( $css );

		$set_cookies = array();
		if ( $this->params->dock_state == 'undocked' ) {
			$set_cookies[] = 'ABD_setCookie( \'abd_dock_state\', \'undocked\' );';
		}
		if ( $this->params->dock_pos == 'bottom' ) {
			$set_cookies[] = 'ABD_setCookie( \'abd_dock_pos\', \'bottom\' );';
		}
		if ( $this->params->autohide ) {
			$set_cookies[] = 'ABD_setCookie( \'abd_autohide\', 1 );';
		}
		$user = JFactory::getUser();
		$settings_url = '';
		if ( $user->usertype == 'Super Administrator' || $user->usertype == 'Administrator' ) {
			$db =& JFactory::getDBO();
			$query = 'SELECT id
				FROM #__plugins
				WHERE element = '.$db->quote( 'adminbardocker' ).'
				AND folder = '.$db->quote( 'system' ).'
				LIMIT 1';
			$db->setQuery( $query );
			$pluginid = (int) $db->loadResult();
			if ( $pluginid ) {
				$settings_url = JURI::base().'index.php?option=com_plugins&view=plugin&client=site&task=edit&cid[]='.$pluginid;
			} else {
				$settings_url = JURI::base().'index.php?option=com_plugins&client=site&search=system%20-%20adminbar%20docker';
			}
		}
		$script = "
			var abd_top = new Array();
			var abd_toggle_top = new Array();
			var abd_toggle_bottom = new Array();
			var abd_bottom = new Array();
			var abd_settings_url = '".$settings_url."';
			window.addEvent( 'domready', function() {"
				.implode( "\n\t\t\t\t", $set_cookies )."
				new AdminBarDocker( '".$this->template."', [ '".JTEXT::_( 'ABD_UNDOCK' )."', '".JText::_( 'ABD_DOCK' )."', '".JText::_( 'ABD_RELOAD' )."', '".JText::_( 'ABD_TO_TOP' )."', '".JText::_( 'ABD_TO_BOTTOM' )."', '".JText::_( 'ABD_UNDOCK_TO_TOP' )."', '".JText::_( 'ABD_UNDOCK_TO_BOTTOM' )."', '".JText::_( 'ABD_AUTO_HIDE' )."', '".JText::_( 'ABD_NO_AUTO_HIDE' )."', '".JText::_( 'ABD_SETTINGS' )."' ], ".$this->params->hidetopbar.", ".$ignorecookie." );
			});
		";
		$document->addScriptDeclaration( $script );
	}
}