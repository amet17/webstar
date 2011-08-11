<?php
/**
 * Plugin Helper File
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

/**
* Plugin that cleans cache
*/
class plgSystemCacheCleanerHelper
{
	function __construct( &$params, $type = 'clean', $show_msg = 1, $show_size = 0 )
	{
		// Load language for messaging
		$lang =& JFactory::getLanguage();
		if ( $lang->getTag() != 'en-GB' ) {
			// Loads English language file as fallback (for undefined stuff in other language file)
			$lang->load( 'mod_cachecleaner', JPATH_ADMINISTRATOR, 'en-GB' );
		}
		$lang->load( 'mod_cachecleaner', JPATH_ADMINISTRATOR, null, 1 );

		if ( JRequest::getInt( 'purge' ) ) {
			list( $final_state, $msg, $error ) = $this->purgeCache();
		} else {
			list( $final_state, $msg, $error ) = $this->cleanCache( $params, $type, $show_size );
		}

		if( JRequest::getInt( 'break' ) ) {
			echo ( $final_state ? '+' : '' ).$msg;
			exit();
		} else if ( $show_msg ) {
			$mainframe =& JFactory::getApplication();
			$mainframe->enqueueMessage( $msg, ( $error ? 'error' : 'message' ) );
		}
	}

	function purgeCache()
	{
		$cache =& JFactory::getCache();
		$cache->gc();

		$msg = JText::_( 'CC_CACHE_PURGED' );

		return array( 1, $msg, 0 );
	}

	function cleanCache( &$params, $type = 'clean', $show_size = 0 )
	{
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');

		$ignore_folders = array();
		if ( !empty( $params->ignore_folders ) ) {
			$ignore_folders = explode( '\n', $params->ignore_folders );
			foreach( $ignore_folders as $i => $folder ) {
				if ( trim( $folder ) ) {
					$folder = str_replace( array( '\\', '/' ), DS, trim( $folder ) );
					$folder = str_replace( DS.DS, DS, JPATH_SITE.DS.$folder );
					$ignore_folders[$i] = $folder;
				}
			}
		}
		$final_state = 1;

		$size = 0;

		// remove all folders and files in cache folder
		$paths = array( JPATH_SITE, JPATH_ADMINISTRATOR );
		foreach ( $paths as $path ) {
			$path .= DS.'cache';
			list( $final_state, $s ) = $this->emptyFolder( $path, $show_size, $ignore_folders );
			if ( $show_size ) {
				$size += $s;
			}
		}

		// Empty cmslib cache
		if ( $params->clean_cmslib ) {
			$path = JPATH_SITE.DS.'components'.DS.'libraries'.DS.'cmslib'.DS.'cache';
			list( $final_state, $s ) = $this->emptyFolder( $path, $show_size, $ignore_folders );
			if ( $show_size ) {
				$size += $s;
			}
		}

		// Empty JRE cache db table
		if ( $params->clean_jre ) {
			$db =& JFactory::getDBO();
			$db->setQuery( 'show tables like '.$db->quote( $db->getPrefix().'jrecache_repository' ) );
			$exists = $db->loadResult();
			if ( $exists ) {
				$db->setQuery( 'TRUNCATE TABLE `#__jrecache_repository`' );
				$db->query();
			}
		}

		// Folders
		if (	$type == 'clean'
			||	( $type == 'interval' && $params->auto_interval_folders )
			||	( $type == 'save' && $params->auto_save_folders )
		) {
			// Empty tmp folder
			if ( $params->clean_tmp ) {
				$path = JPATH_SITE.DS.'tmp';
				list( $final_state, $s ) = $this->emptyFolder( $path, $show_size, $ignore_folders );
				if ( $show_size ) {
					$size += $s;
				}
			}
			// Empty custom folder
			if ( $params->clean_folders ) {
				$folders = explode( '\n', $params->clean_folders );
				foreach( $folders as $folder ) {
					if ( trim( $folder ) ) {
						$folder = str_replace( array( '\\', '/' ), DS, trim( $folder ) );
						$path = str_replace( DS.DS, DS, JPATH_SITE.DS.$folder );
						list( $final_state, $s ) = $this->emptyFolder( $path, $show_size, $ignore_folders );
						if ( $show_size ) {
							$size += $s;
						}
					}
				}
			}
		}

		// Tables
		if (	$params->clean_tables
			&&	(	$type == 'clean'
				||	( $type == 'interval' && $params->auto_interval_tables )
				||	( $type == 'save' && $params->auto_save_tables )
			)
		) {
			$tables = $params->clean_tables_selection;
			if ( !is_array( $tables ) ) {
				$db =& JFactory::getDBO();
				$tables = explode( ',', str_replace( "\n", ',', $tables ) );
				foreach ( $tables as $table ) {
					if ( trim( $table ) ) {
						$table = trim( str_replace( '#__', $db->getPrefix(), $table ) );
						$db->setQuery( 'show tables like '.$db->quote( $table ) );
						$exists = $db->loadResult();
						if ( $exists ) {
							$db->setQuery( 'TRUNCATE TABLE `'.$table.'`' );
							$db->query();
						}
					}
				}
			}
		}

		// Write current time to text file
		$file_path = str_replace( DS.DS, DS, JPATH_SITE.DS.str_replace( array( '\\', '/' ), DS, $params->log_path.DS ) );
		if ( !JFolder::exists( $file_path ) ) {
			$file_path = JPATH_PLUGINS.DS.'system'.DS.'cachecleaner'.DS;

		}
		JFile::write( $file_path.'cachecleaner_lastclean.log', time() );

		$error = 0;
		if ( !$final_state ) {
			$msg = JText::_( 'CC_NOT_ALL_CACHE_COULD_BE_REMOVED' );
			$error = 1;
		} else {
			$msg = JText::_( 'CC_CACHE_CLEANED' );
		}

		if ( $show_size && $size ) {
			if ( $size >= 1048576) {
				$size = ( round( $size / 1048576 * 100 ) / 100 ).'MB';
			} else {
				$size = ( round( $size / 1024 * 100 ) / 100 ).'KB';
			}
			$msg .= ' ('.$size.')';
		}

		return array( $final_state, $msg, $error );
	}

	function emptyFolder( $path, $show_size = 0, $ignore_folders = array() )
	{
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');

		$succes = 1;
		$size = 0;

		if ( JFolder::exists( $path ) ) {
			if ( $show_size ) {
				$size = $this->getFolderSize( $path );
			}
			// remove folders
			$folders = JFolder::folders( $path );
			foreach ( $folders as $folder ) {
				if ( !in_array( $path.DS.$folder, $ignore_folders ) ) {
					$succes = JFolder::delete( $path.DS.$folder );
				}
			}
			// remove files
			$files = JFolder::files( $path );
			foreach ( $files as $file ) {
				if ( $file != 'index.html' && !in_array( $path.DS.$file, $ignore_folders ) ) {
					$succes = JFile::delete( $path.DS.$file );
				}
			}
			if ( $show_size ) {
				$size -= $this->getFolderSize( $path );
			}
		}

		return array( $succes, $size );
	}

	function getFolderSize( $path )
	{
		jimport('joomla.filesystem.file');

		if( JFile::exists( $path ) ) {
			return @filesize( $path );
		}

		jimport('joomla.filesystem.folder');
		if( !JFolder::exists( $path ) ) {
			return 0;
		}

		$size = 0;
		foreach( JFolder::files( $path ) as $file ) {
			$size += @filesize( $path.DS.$file );
		}
		foreach( JFolder::folders( $path ) as $folder ) {
			$size += $this->getFolderSize( $path.DS.$folder );
		}

		return $size;
	}
}