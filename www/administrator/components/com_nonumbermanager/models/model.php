<?php
/**
 * NoNumber! Extension Manager Model
 *
 * @package     NoNumber! Extension Manager
 * @version     2.4.7
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die();

// Import MODEL object class
jimport( 'joomla.application.component.model' );

/**
 * NoNumber! Extension Manager Model
 */
class NoNumberManagerModelModel extends JModel
{
	/**
	 * Extensions data
	 *
	 * @var array
	 */
	var $_extensions = null;

	/**
	 * Host
	 *
	 * @var string
	 */
	var $_host = null;

	/**
	 * Custom Constructor
	 */
	function __construct()
	{
		parent::__construct();

		$xmlfile = JPATH_COMPONENT.DS.'extensions.xml';
		$xml =& JFactory::getXMLParser( 'Simple' );
		// Load the file
		if ( !$xml || !$xml->loadFile( $xmlfile ) ) {
			return null;
		}

		$host = parse_url( JURI::root(false) );
		$this->_host = strtolower( $host['host'] );
		if ( $this->_host == '127.0.0.1' ) {
			$this->_host = 'localhost';
		}

		$this->extensions = array();

		$ext = $this->initItem();
		$ext->name = JText::_( 'NNEM_ALL_EXTENSIONS' );
		$ext->id = 'all';
		$ext->alias = 'all';
		$this->extensions[$ext->id] = $ext;

		$db =& JFactory::getDBO();
		$sql = "SELECT id FROM #__components WHERE `option` = ".$db->quote( 'com_advancedmodules' )." AND `enabled` = 1 LIMIT 1";
		$db->setQuery( $sql );
		$has_amm = $db->loadResult();

		foreach ( $xml->document->children() as $item ) {
			$item = $item->_attributes;
			$ext = $this->initItem();
			if ( isset( $item['name'] ) ) {
				$ext->name = $item['name'];
				$ext->id = isset( $item['id'] ) ? $item['id'] : preg_replace( '#[^a-z\-]#', '', str_replace( '?', '-', strtolower( $ext->name ) ) );
				$ext->alias = isset( $item['alias'] ) ? $item['alias'] : $ext->id;
				$ext->type = $item['type'];
				$ext->types = array();
				if ( isset( $item['type'] ) ) {
					$types = explode( ',', $item['type'] );
					foreach ( $types as $type ) {
						$ext->types[] = $this->getTypeData( $type, $ext->alias, $has_amm );
					}
				}

				$this->extensions[$ext->alias] = $ext;
			}
		}
	}

	/**
	 * Get the extensions data
	 */
	function getData()
	{
		$db =& JFactory::getDBO();
		$sql = "SELECT * FROM #__nonumber_licenses GROUP BY extension";
		$db->setQuery( $sql );
		$licensecodes = $db->loadObjectList( 'extension' );

		foreach ( $licensecodes as $licensecode ) {
			if ( isset( $this->extensions[$licensecode->extension] ) ) {
				$this->extensions[$licensecode->extension]->code = $licensecode->code;
			}
		}
	}

	/**
	 * Return an empty extension item
	 */
	function initItem()
	{
		$item = new stdClass();
		$item->name = '';
		$item->id = '';
		$item->alias = '';
		$item->code = '';
		return $item;
	}

	/**
	 * Get the type data
	 */
	function getTypeData( $type, $alias, $has_amm = 0 )
	{
		$db =& JFactory::getDBO();

		$ob = new stdClass();
		$ob->type = $type;
		$ob->link = '';
		list( $type, $folder ) = explode( '_', $type.'_' );

		if ( $alias == 'nonumbermanager' ) {
			return $ob;
		}

		switch( $type ) {
			case 'com';
				$sql = "SELECT id FROM #__components
					WHERE `option` = ".$db->quote( 'com_'.$alias )."
					LIMIT 1";
				$db->setQuery( $sql );
				$id = $db->loadResult();
				if ( $id ) {
					$ob->link = 'option=com_'.$alias;
				}
				break;
			case 'mod';
				$sql = "SELECT id, client_id FROM #__modules
					WHERE `module` = ".$db->quote( 'mod_'.$alias )."
					ORDER BY `published` DESC, id LIMIT 1";
				$db->setQuery( $sql );
				$module = $db->loadObject();
				if ( $module ) {
					$ob->link = 'option=com_'.( $has_amm ? 'advanced' : '' ).'modules&client='.$module->client_id.'&task=edit&cid[]='.$module->id;
				}
				break;
			case 'plg';
				$sql = "SELECT id, client_id FROM #__plugins
					WHERE `element` = ".$db->quote( $alias )."
					AND `folder` = ".$db->quote( $folder )."
					LIMIT 1";
				$db->setQuery( $sql );
				$id = $db->loadResult();
				if ( $id ) {
					$ob->link = 'option=com_plugins&view=plugin&client=site&task=edit&cid[]='.$id;
				}
				break;
		}
		return $ob;
	}

	/**
	 * Save the license code
	 */
	function save()
	{
		$extension = JRequest::getCmd( 'extension', '' );
		$code = JRequest::getCmd( 'code', '' );

		if ( $extension ) {
			$db =& JFactory::getDBO();
			$sql = "REPLACE INTO #__nonumber_licenses
				( `extension`, `code` )
				VALUES ( ".$db->quote($extension).", ".$db->quote($code)." );
			";
			$db->setQuery( $sql );
			$db->query();
			$msg = JText::_( 'NNEM_CODE_SAVED' );
		} else {
			$msg = JText::_( 'NNEM_SAVING_CODE_FAILED' );
		}

		echo $msg;
		exit();
	}

	/**
	 * Download and install
	 */
	function install()
	{
		$config =& JFactory::getConfig();
		$mainframe =& JFactory::getApplication();

		// Get the URL of the package to install
		$url = JRequest::getString( 'url' );

		if ( !is_string( $url ) ) {
			JError::raiseWarning( 101, JText::_( 'NNEM_ERROR_NO_VALID_URL' ).' (101)' );
			return;
		}

		$parts = explode( '/', $url );
		$target = $config->getValue( 'config.tmp_path' ).DS.$parts[count( $parts )-1];

		jimport( 'joomla.filesystem.file' );

		if ( !function_exists( 'curl_version' ) && !ini_get( 'allow_url_fopen' ) ) {
			JError::raiseWarning( 106, JText::_( 'NNEM_ERROR_CANNOT_DOWNLOAD_FILE' ).' (106)' );
			return;
		} else if ( function_exists( 'curl_version' ) ) {
			/* USE CURL */
			$ch = curl_init();
			$options = array (
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 30
			);
			$params =& JComponentHelper::getParams( 'com_nonumbermanager' );
			if ( $params->get( 'use_proxy' ) && $params->get( 'proxy_host' ) ) {
				$options[CURLOPT_PROXY] = $params->get( 'proxy_host' ).( $params->get( 'proxy_port' ) ? ':'.$params->get( 'proxy_port' ) : '' );
				$options[CURLOPT_PROXYUSERPWD] = $params->get( 'proxy_login' ).':'.$params->get( 'proxy_password' );
			}
			curl_setopt_array( $ch, $options );
			$content = curl_exec( $ch );
			curl_close( $ch );
		} else {
			/* USE FOPEN */
			if( FALSE === ( $handle = @fopen( $url, 'r' ) ) ) {
				// load the com_installer language file
				$lang =& JFactory::getLanguage();
				$lang->load( 'com_installer', JPATH_ADMINISTRATOR );
				JError::raiseWarning( 103, JText::_( 'SERVER_CONNECT_FAILED' ).' (103)' );
				return;
			}

			$content = '';
			while ( !feof( $handle ) ) {
				$content .= fread( $handle, 4096 );
				if ( $content == false) {
					JError::raiseWarning( 104, JText::_( 'NNEM_ERROR_FAILED_READING_FILE' ).' (104)' );
					return false;
				}
			}
			fclose( $handle );
		}

		if ( empty( $content ) ) {
			JError::raiseWarning( 105, JText::_( 'NNEM_ERROR_CANNOT_DOWNLOAD_FILE' ).' (105)' );
			return;
		}

		// Write buffer to file
		JFile::write( $target, $content );

		jimport( 'joomla.installer.installer' );
		JPlugin::loadLanguage( 'com_installer', JPATH_ADMINISTRATOR );
		jimport( 'joomla.installer.helper' );
		// Unpack the package
		$package = JInstallerHelper::unpack( $target );

		// Get an installer instance
		$installer =& JInstaller::getInstance();

		// Install the package
		if ( !$installer->install( $package['dir'] ) ) {
			// There was an error installing the package
			$msg = JText::sprintf( 'INSTALLEXT', JText::_( $package['type'] ), JText::_( 'Error' ) );
		} else {
			// Package installed successfully
			$msg = JText::sprintf( 'INSTALLEXT', JText::_( $package['type'] ), JText::_( 'Success' ) );
		}

		$mainframe->enqueueMessage( $msg );

		JInstallerHelper::cleanupInstall( $package['packagefile'], $package['extractdir'] );
		return;
	}
}