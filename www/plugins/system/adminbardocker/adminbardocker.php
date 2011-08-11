<?php
/**
 * Main Plugin File
 * Does all the magic!
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

// Import library dependencies
jimport( 'joomla.event.plugin' );

/**
* Plugin that shows active modules in menu item edit view
*/
class plgSystemAdminBarDocker extends JPlugin
{
	function __construct( &$subject, $config )
	{
		$this->_pass = 0;
		parent::__construct( $subject, $config );
	}

	function onAfterRoute()
	{
		$this->_pass = 0;

		// return if disabled via url
		if ( JRequest::getCmd( 'disable_adminbardocker' ) ) { return; }

		$mainframe =& JFactory::getApplication();
		if( $mainframe->isSite() ) {
			return;
		}

		if( JRequest::getCmd( 'option' ) == 'com_extplorer' ) {
			return;
		}

		$document =& JFactory::getDocument();
		$docType = $document->getType();

		// only in html
		if ( $docType != 'html' ) { return; }

		$user =& JFactory::getUser();

		if ( !$user->id ) { return; }

		// load the admin language file
		$lang =& JFactory::getLanguage();
		if ( $lang->getTag() != 'en-GB' ) {
			// Loads English language file as fallback (for undefined stuff in other language file)
			$lang->load( 'plg_'.$this->_type.'_'.$this->_name, JPATH_ADMINISTRATOR, 'en-GB' );
		}
		$lang->load( 'plg_'.$this->_type.'_'.$this->_name, JPATH_ADMINISTRATOR, null, 1 );

		// return if NoNumber! Elements plugin is not installed
		jimport( 'joomla.filesystem.file' );
		if ( !JFile::exists( JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'nonumberelements.php' ) ) {
			$mainframe =& JFactory::getApplication();
			if ( $mainframe->isAdmin() && JRequest::getCmd( 'option' ) !== 'com_login' ) {
				$msg = JText::_( 'ABD_NONUMBER_ELEMENTS_PLUGIN_NOT_INSTALLED' );
				$mq = $mainframe->getMessageQueue();
				foreach ( $mq as $m ) {
					if ( $m['message'] == $msg ) {
						$msg = '';
						break;
					}
				}
				if ( $msg ) {
					$mainframe->enqueueMessage( $msg, 'error' );
				}
			}
			return;
		}

		$this->_pass = 1;

		// Load plugin parameters
		require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'parameters.php';
		$parameters =& NNParameters::getParameters();
		$params = $parameters->getParams( $this->params->_raw, JPATH_PLUGINS.DS.$this->_type.DS.$this->_name.'.xml' );

		// Include the Helper
		require_once JPATH_PLUGINS.DS.$this->_type.DS.$this->_name.DS.'helper.php';
		$class = get_class( $this ).'Helper';
		$this->helper = new $class ( $params );
	}

	function onAfterDispatch()
	{
		if ( $this->_pass ) {
			$this->helper->render();
		}
	}
}