<?php
/**
 * Table class: advancedmodules
 *
 * @package     Advanced Module Manager
 * @version     1.19.0
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die();

class TableAdvancedModules extends JTable
{
	var $moduleid=null;
	var $params=null;

	function __construct( &$db )
	{
	  parent::__construct( '#__advancedmodules', 'moduleid', $db );
	}
}