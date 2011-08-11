<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default_visits.php 1559 2010-08-23 10:01:15Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');


switch ($this->sefConfig->analyticsDashboardDataType) {
  case 'ga:visits':
    $title = JText16::_('COM_SH404SEF_ANALYTICS_DATA_VISITS_DESC_RAW');
    break;
  case 'ga:visitors':
    $title = JText16::_('COM_SH404SEF_ANALYTICS_DATA_VISITORS_DESC_RAW');
    break;
  case 'ga:pageviews':
    $title = JText16::_('COM_SH404SEF_ANALYTICS_GLOBAL_PAGEVIEWS_DESC_RAW');
    break;
  default:
    $title = '';
    break;
}

$title = Sh404sefHelperAnalytics::getDataTypeTitle() . (empty($title) ? '' : '::' . $title);

?>


  <div  class="hasAnalyticsTip" title="<?php echo $title; ?>" >

  	<fieldset>
            <?php
              echo '<legend>' . Sh404sefHelperAnalytics::getDataTypeTitle() . '</legend>';

              echo '<div class="analytics-report-image"><img src="' . $this->analytics->analyticsData->images['visits']. '" /></div>';
            ?>
    </fieldset>

  </div>
