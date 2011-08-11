<?php

/**
* JElementVMMultiCategories - additional element for module XML file
* @package News Show Pro GK4
* @Copyright (C) 2009-2010 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 4.0.0 $
**/
 
// access denied
defined('JPATH_BASE') or die();
 
class JElementVMShopperGroups extends JElement
{
	// name of element
	var $_name = 'VMShopperGroups';
	// Construct an array of the HTML OPTION statements.
	var $_options = array();
	// function to create an element
	function fetchElement($name, $value, &$node, $control_name) {
        // Base name of the HTML control.
        $ctrl  = $control_name .'['. $name .']';
        // creating database instance
        $db =& JFactory::getDBO();
        // generating query
		$db->setQuery("SELECT sg.shopper_group_name AS name, sg.shopper_group_id AS id FROM #__vm_shopper_group AS sg ORDER BY sg.shopper_group_name ASC");
 		// getting results
   		$results = $db->loadObjectList();
     	//
		if(count($results)){
			// iterating			
			$this->_options[] = JHTML::_('select.option', '-1', JText::_('VM_ALL_SHOPPER_GROUPS'));
			//
			foreach ($results as $item) {
                $this->_options[] = JHTML::_('select.option', $item->id, $item->name);
        	}		
			// Construct the various argument calls that are supported.
	        $attribs       = ' ';
	        if ($v = $node->attributes( 'size' )) $attribs .= 'size="'.$v.'"';
	        if ($v = $node->attributes( 'class' )) $attribs .= 'class="'.$v.'"';
	        else $attribs .= 'class="inputbox"';
	        // Render the HTML SELECT list.
	        return JHTML::_('select.genericlist', $this->_options, $ctrl, $attribs, 'value', 'text', $value, $control_name.$name );	
		} 
		else
		{
			// Render the HTML SELECT list.
	        return '<strong>VirtueMart is not installed or any VirtueMart shopper groups are available.</strong><input id="paramsvm_shopper_group" type="hidden" name="'.$control_name.$name.'" value="-1" />';	
		}
	}
 	// bind function to save
    function bind( $array, $ignore = '' )
    {
        if (key_exists( 'field-name', $array ) && is_array( $array['field-name'] )) {
        	$array['field-name'] = implode( ',', $array['field-name'] );
        }
 
        return parent::bind( $array, $ignore );
    }
}