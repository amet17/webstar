<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'tables');

/**
 * @package		Joomla
 * @subpackage	Contact
 */
class AdsmanagerModelField extends JModel
{
	var $_plugins;
	
	function getNbFields()
    {
    	$this->_db->setQuery( "SELECT count(*) FROM #__adsmanager_fields WHERE 1 ORDER by ordering");
		$nb = $this->_db->loadResult();
		return $nb;
    }
    
    function getSearchFields()
    {
	    $this->_db->setQuery( "SELECT f.* FROM #__adsmanager_fields AS f ".
							 "WHERE f.searchable = 1 AND f.published = 1 ORDER by f.ordering" );
	
		$fields = $this->_db->loadObjectList();
		return $fields;
    }
    
    function getOrderFields($catid)
    {
    	$this->_db->setQuery( "SELECT f.title,f.fieldid,f.catsid FROM #__adsmanager_fields AS f WHERE f.sort = 1 AND f.published = 1 ORDER BY f.ordering ASC" );
		$results = $this->_db->loadObjectList();
		$orders = array();
  		foreach ($results as $r ) {
			if ($r->catsid == ",-1,")				
				$orders[] = $r;
			else 
			{	
				if ($catid != 0) {
					$find = ",".$catid.",";
					if (strstr($r->catsid, $find))
						$orders[] = $r;
				}
			}
		}
		return $orders;
    }
    
	function getFields($onlyPublished=true,$limitstart=null,$limit=null,$filter_order="fieldid",$filter_order_Dir="ASC") {
		if ($onlyPublished == true)
			$published = " f.published = 1 ";
		else
			$published = " 1 ";
			
		if (($limitstart === null)||($limit === null))
			$this->_db->setQuery( "SELECT * FROM #__adsmanager_fields as f WHERE $published ORDER by f.ordering ASC");
	    else
	   	 	$this->_db->setQuery( "SELECT * FROM #__adsmanager_fields as f WHERE $published ORDER by $filter_order $filter_order_Dir",
	    						 $limitstart,$limit );
		//f.published = 1
		$fields = $this->_db->loadObjectList();
		return $fields;
    }
    
    function getFieldsbyColumns() {
	    $this->_db->setQuery( "SELECT c.* FROM #__adsmanager_fields AS c ".
							 "WHERE c.columnid != -1 AND c.published = 1 ORDER by c.columnorder,c.fieldid" );
	
		$fields = $this->_db->loadObjectList();
		
		// establish the hierarchy of the menu
		$fColumn = array();
		// first pass - collect children
		if (isset($fields))
		{
			foreach ($fields as $f ) {
				$pt 	= $f->columnid;
				$list 	= @$fColumn[$pt] ? $fColumn[$pt] : array();
				array_push( $list, $f );
				$fColumn[$pt] = $list;
			}
		}
		return $fColumn;
    }
    
    function getFieldsbyPositions() {
	    $this->_db->setQuery( "SELECT f.* FROM #__adsmanager_fields AS f ".
							 "WHERE f.pos != -1 AND f.published = 1 ORDER by f.posorder" );
	
		$fields = $this->_db->loadObjectList();
		if ($this->_db->getErrorNum()) {
			echo $this->_db->stderr();
			return;
		}
		
		// establish the hierarchy of the menu
		$fDisplay = array();
		// first pass - collect children
		if (isset($fields))
		{
			foreach ($fields as $f ) {
				$pt 	= $f->pos;
				$list 	= @$fDisplay[$pt] ? $fDisplay[$pt] : array();
				array_push( $list, $f );
				$fDisplay[$pt] = $list;
			}
		}
		return $fDisplay;
    }
    
    function getSearchModuleFields($listfields) {
		$query = "SELECT f.* FROM #__adsmanager_fields AS f ".
							 "WHERE f.name IN ($listfields) AND f.published = 1 ORDER by f.ordering" ;
		$this->_db->setQuery( $query);
		$searchfields = $this->_db->loadObjectList("name");
		return $searchfields;
    }
    
	function getFieldValues($fieldid = null) {
    	if ($fieldid == null) {
		    $this->_db->setQuery( "SELECT * FROM #__adsmanager_field_values ORDER by ordering ");
			$fieldvalues = $this->_db->loadObjectList();
			if ($this->_db -> getErrorNum()) {
				echo $this->_db -> stderr();
				return false;
			}
			
			$field_values = array();
			// first pass - collect children
			if (isset($fieldvalues))
			{
				foreach ($fieldvalues as $v ) {
					$pt 	= $v->fieldid;
					$list 	= @$field_values[$pt] ? $field_values[$pt] : array();
					array_push( $list, $v );
					$field_values[$pt] = $list;
				}
			}	
    	}
    	else
    	{
    		$fvalues = $this->_db->setQuery( "SELECT * "
						. "\n FROM #__adsmanager_field_values"
						. "\n WHERE fieldid=".(int)$fieldid
						. "\n ORDER BY ordering" );
			$field_values = $this->_db->loadObjectList();	
    	}
    	
	    return $field_values;
    }
    
	function getField($id) {
		$this->_db->setQuery("SELECT * FROM #__adsmanager_fields WHERE fieldid = ".(int)$id  );
		//echo "SHOW TABLES LIKE '".$mosConfig_dbprefix."comprofiler_fields'" ;
		$field = $this->_db-> loadObject();
		return $field;
	}
	
	function getSearchFieldsSql($fields)
    {
    	if (isset($this->searchSQL)&&($this->searchSQL != ""))
    		return $this->searchSQL;
    		
    	$search = "";
		foreach($fields as $fsearch)
		{
			switch($fsearch->type)
			{
				case 'multicheckbox':
				case 'multiselect':
					$value = JRequest::getVar( $fsearch->name,	array() );
					for($i = 0,$nb=count($value);$i < $nb;$i++)
					{
						if ($i == 0)
							$search .= " AND (";	
						$search .= "a.$fsearch->name = ".$this->_db->Quote(",".$value[$i].",");
						if ($i < $nb - 1)
							$search .= " OR ";
						else
							$search .= " )";	
					}
					break;
				case 'checkbox':
				case 'radio':
				case 'select':	
					$value = JRequest::getVar( $fsearch->name,	"");
					if ($value != "")
					{
						$search .= " AND a.$fsearch->name = ".$this->_db->Quote($value);
					}
					break;
					
				case 'price':
					$value = JRequest::getVar( $fsearch->name,	"");
					if ($value != "")
					{
						$pos = strpos($value, '-');
						$fieldsql = "a.$fsearch->name + 0"; // Little hack to convert in number
						if ($pos !== false)
						{
							if ($pos == 0) // $pos is = 0 for $value = -x $pos is = 1 only for this format 0-10 {
							{
								$search .= " AND $fieldsql < ".(float)substr($value,1)."";
							}
							else if ($pos == strlen($value) - 1)
							{
								$search .= " AND $fieldsql > ".(float)substr($value,0,strlen($value)-1);
							}
							else
							{
								$search .= " AND ($fieldsql >= ".(float)substr($value,0,$pos)." AND $fieldsql <= ".(float)substr($value,$pos+1).")";
							}
						}
					}
					break;
		
				case 'textarea':
				case 'number':
				case 'emailaddress':
				case 'url':
				case 'text':
					$value = JRequest::getVar( $fsearch->name,	"");
					if ($value != "")
					{
						$search .= " AND a.$fsearch->name LIKE '%".$this->_db->getEscaped($value,true)."%'";
					}
					break;
			}
		}
		
		$this->searchSQL = " 1 ".$search;
		return $this->searchSQL;
    }
    
	function getAllCbFields() {
		$config =& JFactory::getConfig();
		$dbprefix = $config->getValue('config.dbprefix');
		
		$this->_db->setQuery("SHOW TABLES LIKE '".$dbprefix."comprofiler_fields'"  );
		$tables = $this->_db-> loadObjectList();
		if (count($tables) > 0)
		{
			$this->_db->setQuery("SELECT * FROM #__comprofiler_fields WHERE 1"  );
			$cb_fields = $this->_db-> loadObjectList();
			return $cb_fields;
		}
		else
			return array();
	}
    
	function getCBFieldValues($fieldcbid)
	{
		$this->_db->setQuery( "SELECT *, fieldtitle as fieldvalue FROM #__comprofiler_field_values WHERE fieldid = ".(int)$fieldcbid."	 ORDER by ordering ");
		$cbfieldvalues = $this->_db->loadObjectList();
		return $cbfieldvalues;
	}
	
	function getPlugins()
	{
		if ($this->_plugins) {
			return $this->_plugins;
		}
		else {
			$plugins = null;
			
			if(file_exists(JPATH_SITE . "/images/com_adsmanager/plugins/")) { 
				$path = JPATH_SITE."/images/com_adsmanager/plugins/";
				$handle = opendir( $path );
				while ($file = readdir($handle)) {
					$dir = $path.'/'.$file;
					if (is_dir($dir))
					{
						if (($file != ".") && ($file != "..")) {
							if (file_exists($path.'/'.$file.'/plug.php')) {
								include_once($path.'/'.$file.'/plug.php');
							} else {
								JFolder::delete($path.'/'.$file);
							}
						}
					}
				}
			
				closedir($handle);
			}
			$this->_plugins = $plugins;
			
			return $this->_plugins;
		}
	}
}