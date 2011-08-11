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

if (	JRequest::getCmd( 'disable_cachecleaner' )
	||	JRequest::getCmd( 'format' ) == 'raw'
) {
	return;
}

require_once dirname( __FILE__ ).DS.'cachecleaner'.DS.'cachecleaner.php';