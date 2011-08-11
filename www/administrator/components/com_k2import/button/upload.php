<?php
/**

 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a standard HTML upload control in the toolbar
 *
 * @package 	Joomla.Framework
 * @subpackage		HTML
 * @since		1.5
 */
class JButtonUpload extends JButton
{
	/**
	 * Button type
	 *
	 * @access	protected
	 * @var		string
	 */
	var $_name = 'Upload';

	function render( &$definition )
	{
    //$TableSuffix = JRequest::getVar('table_suffix');
    $TableSuffix = $definition[1];

    $fNameShort = basename($definition[2]);

    //Construct the form action string:
    $Action = JURI::base().'index.php?option=com_k2import&amp;task=upload&amp;';

    return
     '<td>
       <form name="upload" method="post" enctype="multipart/form-data"
        action="'.$Action.'">
         <input type="file" name="file_upload">&nbsp;&nbsp;
         <input type="submit" value="Upload">
       </form>
  	 </td>';
	}
}
