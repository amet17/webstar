<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: analytics.php 1548 2010-08-22 09:04:40Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

Class Sh404sefControllerAnalytics extends Sh404sefClassBasecontroller {

  protected $_context = 'com_sh404sef.analytics';
  protected $_defaultModel = 'analytics';
  protected $_defaultView = 'analytics';
  protected $_defaultController = 'analytics';
  protected $_defaultTask = '';
  protected $_defaultLayout = 'default';

  protected $_returnController = 'analytics';
  protected $_returnTask = '';
  protected $_returnView = 'analytics';
  protected $_returnLayout = 'default';

}