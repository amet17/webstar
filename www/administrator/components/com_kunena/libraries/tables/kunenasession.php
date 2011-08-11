<?php
/**
* @version $Id: kunenasession.php 4336 2011-01-31 06:05:12Z severdia $
* Kunena Component
* @package Kunena
*
* @Copyright (C) 2008 - 2011 Kunena Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.kunena.org
*
**/
// Dont allow direct linking
defined( '_JEXEC' ) or die();

require_once(dirname(__FILE__).DS.'kunena.php');

class TableKunenaSession extends KunenaTable
{
	var $userid = 0;
	var $allowed = 'na';
	var $allowedcats = null;
	var $lasttime = 0;
	var $readtopics = 0;
	var $currvisit = 0;
	protected $_exists = false;

	function __construct($db) {
		parent::__construct('#__kunena_sessions', 'userid', $db);
	}

	function load($oid = null) {
		if (!$oid) return false;
		return parent::load($oid);
	}
}