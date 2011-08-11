<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default_filters.php 1548 2010-08-22 09:04:40Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>
  	<tr>
       <td>
         <?php 
           if (!empty( $this->analytics->filters)) {
             foreach( $this->analytics->filters as $filter) {
               echo $filter;
             }
           }
         ?>
       </td>
    </tr>
    
