<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default_sources.php 1600 2010-09-03 10:55:18Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');


$title = JText16::_('COM_SH404SEF_ANALYTICS_REPORT_SOURCES') . '::' . JText16::_('COM_SH404SEF_ANALYTICS_DATA_SOURCES_DESC_RAW');

?>

  <div class="hasAnalyticsTip" title="<?php echo $title; ?>">
       
       <fieldset >
        <?php
        echo '<legend>' . JText16::_('COM_SH404SEF_ANALYTICS_REPORT_SOURCES') . JText16::_( 'COM_SH404SEF_ANALYTICS_REPORT_BY_LABEL') . Sh404sefHelperAnalytics::getDataTypeTitle() . '</legend>';
        
        
        echo '<div class="analytics-report-image"><img src="' . $this->analytics->analyticsData->images['sources']. '" /></div>';
        ?>
        </fieldset>
	
	</div>