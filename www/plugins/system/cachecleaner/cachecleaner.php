<?php
/**
 * Main Plugin File
 * Does all the magic!
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

// Import library dependencies
jimport( 'joomla.plugin.plugin' );

/**
* Plugin that cleans cache
*/
class plgSystemCacheCleaner extends JPlugin
{
	function __construct( &$subject, $config )
	{
		parent::__construct( $subject, $config );
	}

	function onAfterRoute()
	{
		if (	JRequest::getCmd( 'disable_cachecleaner' )
			||	JRequest::getCmd( 'format' ) == 'raw'
		) {
			return;
		}

		$document =& JFactory::getDocument();
		$docType = $document->getType();

		// only in html
		if ( $docType != 'html' ) { return; }

		// load the admin language file
		$lang =& JFactory::getLanguage();
		if ( $lang->getTag() != 'en-GB' ) {
			// Loads English language file as fallback (for undefined stuff in other language file)
			$lang->load( 'plg_'.$this->_type.'_'.$this->_name, JPATH_ADMINISTRATOR, 'en-GB' );
		}
		$lang->load( 'plg_'.$this->_type.'_'.$this->_name, JPATH_ADMINISTRATOR, null, 1 );

		$mainframe =& JFactory::getApplication();

		// return if NoNumber! Elements plugin is not installed
		jimport( 'joomla.filesystem.file' );
		if ( !JFile::exists( JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'nonumberelements.php' ) ) {
			if ( $mainframe->isAdmin() && JRequest::getCmd( 'option' ) !== 'com_login' ) {
				$msg = JText::_( 'CC_NONUMBER_ELEMENTS_PLUGIN_NOT_INSTALLED' );
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

		// return if NoNumber! Elements plugin is not enabled
		$nnep = JPluginHelper::getPlugin( 'system', 'nonumberelements' );
		if ( !isset( $nnep->name ) ) {
			if ( $mainframe->isAdmin() && JRequest::getCmd( 'option' ) !== 'com_login' ) {
				$msg = JText::_( 'CC_NONUMBER_ELEMENTS_PLUGIN_NOT_ENABLED' );
				$mq = $mainframe->getMessageQueue();
				foreach ( $mq as $m ) {
					if ( $m['message'] == $msg ) {
						$msg = '';
						break;
					}
				}
				if ( $msg ) {
					$mainframe->enqueueMessage( $msg, 'notice' );
				}
			}
			return;
		}

		// Load plugin parameters
		require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'parameters.php';
		$parameters =& NNParameters::getParameters();
		$params = $parameters->getParams( $this->params->_raw, JPATH_PLUGINS.DS.$this->_type.DS.$this->_name.'.xml' );

		$clean = 0;
		$show_msg = 0;

		if ( !$clean ) {
			$cleancache = JRequest::getVar( 'cleancache' );
			if ( $cleancache != '' ) {
				if ( $mainframe->isSite() && $cleancache != $params->frontend_secret ) {
					return;
				}
				$clean = 'clean';
				$show_msg = 1;
			}
		}

		if ( !$clean ) {
			$task = JRequest::getVar( 'task' );
			if ( $task ) {
				$tasks = array_diff( array_map( 'trim', explode( ',', $params->auto_save_tasks ) ), array( '' ) );
				if ( !empty( $tasks ) && in_array( $task, $tasks ) ) {
					if ( $mainframe->isAdmin() && $params->auto_save_admin ) {
						$clean = 'save';
						$show_msg = $params->auto_save_admin_msg;
					} else if ( $mainframe->isSite() && $params->auto_save_front ) {
						$clean = 'save';
						$show_msg = $params->auto_save_front_msg;
					}
				}
			}
		}

		if ( !$clean ) {
			if ( $mainframe->isAdmin() && $params->auto_interval_admin ) {
				$user =& JFactory::getUser();
				if ( $user->id ) {
					$clean = 'interval';
					$show_msg = $params->auto_interval_admin_msg;
					$secs = $params->auto_interval_admin_secs;
				}
			} else if ( $mainframe->isSite() && $params->auto_interval_front ) {
				$clean = 'interval';
				$show_msg = $params->auto_interval_front_msg;
				$secs = $params->auto_interval_front_secs;
			}
			if ( $clean ) {
				jimport( 'joomla.filesystem.file' );
				$file_path = str_replace( DS.DS, DS, JPATH_SITE.DS.str_replace( array( '\\', '/' ), DS, $params->log_path.DS ) );
				if ( !JFolder::exists( $file_path ) ) {
					$file_path = JPATH_PLUGINS.DS.'system'.DS.'cachecleaner'.DS;

				}
				$file = $file_path.DS.'cachecleaner_lastclean.log';
				if ( JFile::exists( $file ) ) {
					$lastclean = JFile::read( $file );
					if ( $lastclean ) {
						$inttime =  ( time() - $secs );
						if ( $lastclean > $inttime ) {
							$clean = 0;
						}
					}
				}
			}
		}

		if ( !$clean ) {
			return;
		}

		// Include the Helper
		require_once JPATH_PLUGINS.DS.$this->_type.DS.$this->_name.DS.'helper.php';
		$class = get_class( $this ).'Helper';
		$this->helper = new $class ( $params, $clean, $show_msg, $params->show_size );
	}
}