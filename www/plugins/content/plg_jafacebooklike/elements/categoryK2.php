<?php 
/*
# ------------------------------------------------------------------------
# JA Facebook Like for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/ 

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JElementCategoryK2 extends JElement
{
	/*
	 * Category name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'CategoryK2';
	
	var $_controlName = '';
	/**
	 * fetch Element 
	 */
	function fetchElement($name, $value, &$node, $control_name){
		$this->_controlName = $name;
		$categories = JElementCategoryK2::_fetchElement(0, '', array());
        //print_r($categories);

        $mitems 	= array();
		$mitems[] 	= JHTML::_('select.option',  '', JText::_( 'All Categories' ) );

		foreach ( $categories as $item ) {
			$mitems[] = JHTML::_('select.option',  $item->id, '&nbsp;&nbsp;&nbsp;'. $item->treename );
		}
		$out = JHTML::_('select.genericlist',  $mitems, ''.$control_name.'['.$name.'][]', 'class="inputbox" style="width:95%;" multiple="multiple" size="10"', 'value', 'text', $value );
        return $out;
	}

    function fetchChild($parent) {
        $db = &JFactory::getDBO();
        $query = "SELECT * FROM #__k2_categories WHERE parent = '{$parent}' AND published=1";
		$db->setQuery( $query );
		$cats = $db->loadObjectList();

        return $cats;
    }

    function _fetchElement( $id, $indent, $list, $maxlevel=9999, $level=0, $type=1 )
	{
        $children = JElementCategoryK2::fetchChild($id);

		if (@$children && $level <= $maxlevel)
		{
			foreach ($children as $v)
			{
				$id = $v->id;

				if ( $type ) {
					$pre 	= '<sup>|_</sup>&nbsp;';
					$spacer = '.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				} else {
					$pre 	= '- ';
					$spacer = '&nbsp;&nbsp;';
				}

				if ($v->parent == 0) {
					$txt 	= $v->name;
				} else {
					$txt 	= $pre . $v->name;
				}
				$pt = $v->parent;
				$list[$id] = $v;
				$list[$id]->treename = "{$indent}{$txt}";
				$list[$id]->children = count( @$children);
				$list = JElementCategoryK2::_fetchElement( $id, $indent . $spacer, $list, $maxlevel, $level+1, $type );
			}
		}
		return $list;
	}
}
?>