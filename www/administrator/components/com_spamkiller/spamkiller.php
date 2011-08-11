<?php
/**
 * @version		1.0
 * @package		Joomla
 * @subpackage	Spam Killer
 * @author  Tuan Pham Ngoc
 * @copyright	Copyright (C) 2010 Ossolution Team
 * @license		GNU/GPL, see LICENSE.php
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');
//require the helper file
require_once JPATH_COMPONENT.DS.'helper'.DS.'helper.php';
//Init the controller
$controller = new SpamkillerController();
// Perform the Request task
$controller->execute(JRequest::getCmd('task'));
// Redirect if set by the controller
$controller->redirect();
?>