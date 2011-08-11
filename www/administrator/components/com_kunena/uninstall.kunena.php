<?php
/**
* @version $Id: uninstall.kunena.php 4336 2011-01-31 06:05:12Z severdia $
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

function com_uninstall() {
	$jversion = new JVersion ();
	if ($jversion->RELEASE != '1.5') return;
	include_once(dirname(__FILE__).'/install.script.php');
	Com_KunenaInstallerScript::uninstall ( null );
}