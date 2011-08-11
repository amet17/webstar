<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default_redirect.php 1762 2011-02-01 12:59:44Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>
  <table class="adminlist">
  <tbody>
    <tr>
      <td width="10%" class="key">
        <label for="newurl">
          <?php echo JText16::_('COM_SH404SEF_NOT_FOUND_ENTER_REDIRECT_LABEL'); ?>&nbsp;
        </label>
      </td>
      <td width="60%">
        <input class="text_area" type="text" name="newurl" id="newurl" size="120" value="<?php echo $this->escape($this->url->get('newurl')); ?>" />
      </td>  
      <td width="30%" style="vertical-align: top;">
        <span ><?php echo JHTML::_('tooltip', JText16::_( 'COM_SH404SEF_TT_ENTER_REDIRECT')); ?></span>
      </td>
    </tr>
  </tbody>  
  </table>
