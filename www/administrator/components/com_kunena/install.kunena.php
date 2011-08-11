<?php
/**
* @version $Id: install.kunena.php 4336 2011-01-31 06:05:12Z severdia $
* Kunena Component
* @package Kunena
*
* @Copyright (C) 2008 - 2011 Kunena Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.kunena.org
**/

// Dont allow direct linking
defined( '_JEXEC' ) or die();

jimport ( 'joomla.version' );
$jversion = new JVersion ();
if ($jversion->RELEASE != '1.5') return;

// This isn't called because of redirect
$this->parent->copyManifest();

function com_install() {
	$jversion = new JVersion ();
	if ($jversion->RELEASE != '1.5') return;
	ignore_user_abort ( true );

	// Emulate J1.6 installer
	include_once(dirname(__FILE__).'/install.script.php');
	Com_KunenaInstallerScript::preflight( null, null );
	Com_KunenaInstallerScript::install ( null );

	// Redirect to Kunena Installer
	header ( "HTTP/1.1 303 See Other" );
	header ( "Location: " . JURI::base () . "index.php?option=com_kunena&view=install" );
}