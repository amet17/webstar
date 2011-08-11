<?php
/**
 * NoNumber! Extension Manager Details page
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

$ext = JRequest::getCmd( 'ext' );
$types = explode( ',', JRequest::getString( 'types' ) );

jimport( 'joomla.filesystem.file' );

$file= '';
$xml = '';
$missing = '';

if ( in_array( 'langs', $types ) ) {
	jimport( 'joomla.filesystem.folder' );
	$list = array();

	for ( $i = 0; $i <= 1; $i++ ) {
		$langs = JLanguage::getKnownLanguages( ( $i ? JPATH_SITE : JPATH_ADMINISTRATOR ) );
		foreach( $langs as $lang ) {
			$folder = ( $i ? JPATH_SITE : JPATH_ADMINISTRATOR ).DS.'language'.DS.$lang['tag'];
			if ( $lang['tag'] != 'en-GB' && JFolder::exists( $folder ) && ( !isset( $list[$lang['tag']] ) || !$list[$lang['tag']] ) ) {
				$list[$lang['tag']] = '';
				$files = JFolder::files( $folder, '[_\.]'.$ext.'\.ini' );
				if ( !empty( $files ) ) {
					$file = JFile::read( $folder.DS.$files['0'], 0, 200 );
					preg_match( '#@version\s*([a-z0-9\.]*)#si', $file, $match );
					if ( $match && isset( $match['1'] ) ) {
						$list[$lang['tag']] = $match['1'];
					}
				}
			}
		}
	}
	ksort( $list );
	foreach( $list as $tag => $version ) {
		echo '&langs['.$tag.']='.$version;
	}
	exit();
}

if ( in_array( 'com', $types ) ) {
	if ( JFile::exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_'.$ext.DS.$ext.'.xml' ) ) {
		$xml = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_'.$ext.DS.$ext.'.xml';
	} else if ( JFile::exists( JPATH_SITE.DS.'components'.DS.'com_'.$ext.DS.$ext.'.xml' ) ) {
		$xml = JPATH_SITE.DS.'components'.DS.'com_'.$ext.DS.$ext.'.xml';
	} else if ( JFile::exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_'.$ext.DS.'com_'.$ext.'.xml' ) ) {
		$xml = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_'.$ext.DS.'com_'.$ext.'.xml';
	} else if ( JFile::exists( JPATH_SITE.DS.'components'.DS.'com_'.$ext.DS.'com_'.$ext.'.xml' ) ) {
		$xml = JPATH_SITE.DS.'components'.DS.'com_'.$ext.DS.'com_'.$ext.'.xml';
	}
	if ( !$xml ) {
		$missing .= '|com';
	} else if ( !$file ) {
		$file = $xml;
	}
}

if ( in_array( 'plg_system', $types ) ) {
	if ( JFile::exists( JPATH_PLUGINS.DS.'system'.DS.$ext.DS.$ext.'.xml' ) ) {
		$xml = JPATH_PLUGINS.DS.'system'.DS.$ext.DS.$ext.'.xml';
	} else if ( JFile::exists( JPATH_PLUGINS.DS.'system'.DS.$ext.'.xml' ) ) {
		$xml = JPATH_PLUGINS.DS.'system'.DS.$ext.'.xml';
	}
	if ( !$xml ) {
		$missing .= '|plg_system';
	} else if ( !$file ) {
		$file = $xml;
	}
}
if ( in_array( 'plg_editors-xtd', $types ) ) {
	if ( JFile::exists( JPATH_PLUGINS.DS.'editors-xtd'.DS.$ext.DS.$ext.'.xml' ) ) {
		$xml = JPATH_PLUGINS.DS.'editors-xtd'.DS.$ext.DS.$ext.'.xml';
	} else if ( JFile::exists( JPATH_PLUGINS.DS.'editors-xtd'.DS.$ext.'.xml' ) ) {
		$xml = JPATH_PLUGINS.DS.'editors-xtd'.DS.$ext.'.xml';
	}
	if ( !$xml ) {
		$missing .= '|plg_editors-xtd';
	} else if ( !$file ) {
		$file = $xml;
	}
}
if ( in_array( 'mod', $types ) ) {
	if ( JFile::exists( JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_'.$ext.DS.$ext.'.xml' ) ) {
		$xml = JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_'.$ext.DS.$ext.'.xml';
	} else if ( JFile::exists( JPATH_SITE.DS.'modules'.DS.'mod_'.$ext.DS.$ext.'.xml' ) ) {
		$xml = JPATH_SITE.DS.'modules'.DS.'mod_'.$ext.DS.$ext.'.xml';
	} else if ( JFile::exists( JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_'.$ext.DS.'mod_'.$ext.'.xml' ) ) {
		$xml = JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_'.$ext.DS.'mod_'.$ext.'.xml';
	} else if ( JFile::exists( JPATH_SITE.DS.'modules'.DS.'mod_'.$ext.DS.'mod_'.$ext.'.xml' ) ) {
		$xml = JPATH_SITE.DS.'modules'.DS.'mod_'.$ext.DS.'mod_'.$ext.'.xml';
	}
	if ( !$xml ) {
		$missing .= '|mod';
	} else if ( !$file ) {
		$file = $xml;
	}
}

if ( $file ) {
	$xml = JApplicationHelper::parseXMLInstallFile( $file );
	if ( $xml && isset( $xml['version'] ) ) {
		echo $xml['version'];
		echo $missing;
	}
}
exit();