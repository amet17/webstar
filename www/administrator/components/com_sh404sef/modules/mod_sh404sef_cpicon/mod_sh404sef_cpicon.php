<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: mod_sh404sef_cpicon.php 1862 2011-03-11 20:28:03Z silianacom-svn $
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// define path to sh404SEF front and backend dirs
require_once JPATH_ROOT . DS. 'administrator'.DS.'components'.DS.'com_sh404sef'.DS.'defines.php';

// Ensure that user has access to this function.
$user = &JFactory::getUser();
if (!($user->usertype == 'Super Administrator' || $user->usertype == 'Administrator')) {
  // no display if not allowed
  return;
}

$lang = & JFactory::getLanguage();
$app = &JFactory::getApplication();
$document = &JFactory::getDocument();
$document->addStyleSheet( JURI::root().'administrator/modules/mod_sh404sef_cpicon/styles.css');

// load our text strings
$lang = & shjlang16Helper::getLanguage();
$lang->load('mod_sh404sef_cpicon');

// is an update available?
$versionsInfo = Sh404sefHelperUpdates::getUpdatesInfos();
$updateText = $versionsInfo->shouldUpdate ? '<br /><font color="red">' . JText16::_('COM_SH404SEF_UPDATE_REQUIRED') . '</font>' : '<br /><font color="green">' . JText16::_('COM_SH404SEF_UPDATE_NOT_REQUIRED') . '</font>';
?>

<div id="modsh404_cpanel" style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">

  <div class="icon">
    <a href="index.php?option=com_sh404sef"> 
      <img src="components/com_sh404sef/assets/images/icon-48-analytics.png"
  	   title="sh404sef & Analytics" alt="sh404sef & Analytics" /> 
  	   <span>sh404sef<?php echo $updateText; ?></span> 
    </a>
  </div>

</div>



