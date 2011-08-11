<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default_top5urls.php 1717 2011-01-13 13:30:08Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>
<fieldset>
   <legend><?php echo JText16::sprintf('COM_SH404SEF_ANALYTICS_TOP5_PAGES', $this->options['max-top-urls']); ?></legend>
        
 	<table class="adminlist" >
    <thead>
      <tr>
        <th class="title" >
          <?php echo JText::_( 'NUM' ); ?>
        </th>
        
        <?php  $t = JText16::_('COM_SH404SEF_ANALYTICS_TOP5_URL') . '::' . JText16::_('COM_SH404SEF_ANALYTICS_TT_URL_DESC'); ?>
        <th class="title hasAnalyticsTip" title="<?php echo $t;?>" >
        <?php echo JText16::_( 'COM_SH404SEF_ANALYTICS_TOP5_URL' ); ?>
        </th>
        
        <?php  $t = JText16::_('COM_SH404SEF_ANALYTICS_TOP5_PAGEVIEWS') . '::' . JText16::_('COM_SH404SEF_ANALYTICS_TT_PAGE_VIEWS_DESC'); ?>
        <th class="title hasAnalyticsTip" title="<?php echo $t;?>" >
        <?php echo JText16::_( 'COM_SH404SEF_ANALYTICS_TOP5_PAGEVIEWS' ); ?>
        </th>
        
        <?php  $t = JText16::_('COM_SH404SEF_ANALYTICS_TOP5_PAGEVIEWS_PERCENT') . '::' . JText16::_('COM_SH404SEF_ANALYTICS_TT_URL_PER_CENT_DESC'); ?>
        <th class="title hasAnalyticsTip" title="<?php echo $t;?>" >
        <?php echo JText16::_( 'COM_SH404SEF_ANALYTICS_TOP5_PAGEVIEWS_PERCENT' ); ?>
        </th>
        
        <?php  $t = JText16::_('COM_SH404SEF_ANALYTICS_TOP5_AVG_TIME_ON_PAGE') . '::' . JText16::_('COM_SH404SEF_ANALYTICS_TT_AVG_TIME_ON_PAGE_DESC'); ?>
        <th class="title hasAnalyticsTip" title="<?php echo $t;?>" >
        <?php echo JText16::_( 'COM_SH404SEF_ANALYTICS_TOP5_AVG_TIME_ON_PAGE' ); ?>
        </th>
      </tr>
    </thead>
 	      
 	      
 	 <tbody>
        <?php
          $k = 0;
          $i = 1;
          foreach($this->analytics->analyticsData->top5urls as $entry) :
        ?>    
            
        <tr class="<?php echo "row$k"; ?>">
        
          <td align="center" width="3%">
            <?php echo $i; ?>
          </td>
          
          <td width="62%">
            <?php echo $this->escape( $entry->dimension['pagePath']); ?>
          </td>
          
          <td align="center" width="15%">
            <?php echo $this->escape( $entry->pageviews); ?>
          </td>
          
          <td align="center" width="10%">
            <?php 
              echo $this->escape( sprintf( '%0.1f', $entry->pageviewsPerCent*100));
            ?>
          </td>
          
          <td align="center" width="10%">
            <?php 
              echo $this->escape( sprintf( '%0.1f', $entry->avgTimeOnPage));
            ?>
          </td>

        </tr>
        <?php
        $k = 1 - $k;
        $i++;
      endforeach;
 	      
 	    ?>     
 	      
 	  </tbody>
  </table>    
 	      
</fieldset>
	

	