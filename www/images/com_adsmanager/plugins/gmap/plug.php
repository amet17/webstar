<?php
/**
* Field Plug for AdsManager
* Author: Thomas PAPIN
* URL:  http://www.joomprod.com
* mail: webmaster@joomprod.com
**/

class AdsManagerGmapPlugin {

	var $_db;
	
	function getListDisplay($contentid,$field)
	{
		return AdsManagerGmapPlugin::getDetailsDisplay($contentid,$field);
	}

	function getDetailsDisplay($contentid,$field)
	{
		$query = "SELECT lat,lng FROM #__adsmanager_fieldgmap ".
				 "WHERE fieldid = ".(int)$field->fieldid." AND contentid = ".(int)$contentid;
		$fieldid = $field->fieldid;
		$this->_db->setQuery($query);
		$result = $this->_db->loadObject();
		if ($result)
		{
			$lat = $result->lat;
			$lng = $result->lng;
			$this->_db->setQuery("SELECT * FROM #__adsmanager_fieldgmap_conf WHERE fieldid = ".(int)$field->fieldid);
			$conf = $this->_db->loadObject();
			$map_width = $conf->map_width;//500;
			$map_height= $conf->map_height;//300;
			$google_key = $conf->google_key;//
			$return = '<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key='.$google_key.'" type="text/javascript"></script>';
			$return .= '<script type="text/javascript">';

		    $return .= 'function initialize() {';
		    $return .= '  if (GBrowserIsCompatible()) {';
		    $return .= '    var map = new GMap2(document.getElementById("map_canvas'.$fieldid.'"));';
		    $return .= '    map.setCenter(new GLatLng('.$lat.', '.$lng.'), 13);';
			$return .= '	var center = new GLatLng('.$lat.', '.$lng.');';
			$return .= '    var marker = new GMarker(center); map.addOverlay(marker);'; 
			$return .= '	map.addControl(new GSmallMapControl());';
		    $return .= '    map.addControl(new GMapTypeControl());';	
		    $return .= '  }';
		    $return .= '}';
		    $return .= '</script>';
			$return .= '</script>';
	        $return .= '<div id="map_canvas'.$fieldid.'" style="width: '.$map_width.'px; height: '.$map_height.'px"></div>';
			$return .= '<script type="text/javascript">initialize();</script>';
			
			return $return;
		}
	}

	function getFormDisplay($contentid,$field)
	{

		$query = "SELECT lat,lng FROM #__adsmanager_fieldgmap ".
				 "WHERE fieldid = $field->fieldid AND contentid = ".(int)$contentid;
		$fieldid = $field->fieldid;
		$this->_db->setQuery($query);
		$result = $this->_db->loadObject();
		
		$this->_db->setQuery("SELECT * FROM #__adsmanager_fieldgmap_conf WHERE fieldid = $field->fieldid");
		$conf = $this->_db->loadObject();
		
		if (isset($result))
		{
			$lat = $result->lat;
			$lng = $result->lng;
		}
		else
		{
			$lat = $conf->lat;//"37.4419";
			$lng = $conf->lng;//" -122.1419";
		}
		$map_width = $conf->map_width;//500;
		$map_height= $conf->map_height;//300;
		$google_key = $conf->google_key;//ABQIAAAAbgp4ITpmNUShfIO_dNHv_BR3Tz62YPXwBIaKJWeQ0jDUesttEhTdqyqafAWvPNs2HRK7lWBo2Yemww
		
		$return = '<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key='.$google_key.'" type="text/javascript"></script>';
		$return .= '<script type="text/javascript">';

		$return .= 'var map = null;';
		$return .= 'var geocoder = null;';
		$return .= 'var marker = null;';

	    	$return .= 'function initialize() {';
	    	$return .= '  if (GBrowserIsCompatible()) {';
	    	$return .= '    map = new GMap2(document.getElementById("map_canvas'.$fieldid.'"));';
	    	$return .= '    map.setCenter(new GLatLng('.$lat.', '.$lng.'), 13);';
		$return .= '	var center = new GLatLng('.$lat.', '.$lng.');';
		$return .= '    marker = new GMarker(center, {draggable: true}); map.addOverlay(marker);'; 
		$return .= '	  GEvent.addListener(marker, "dragstart", function() {';
		$return .= '        });';
		
		$return .= '        GEvent.addListener(marker, "dragend", function() {';
		$return .= '		  document.getElementById("gmap_lat'.$fieldid.'").value = marker.getLatLng().lat();';
		$return .= '		  document.getElementById("gmap_lng'.$fieldid.'").value = marker.getLatLng().lng();';
		$return .= '        });';
		$return .= '	map.addControl(new GSmallMapControl());';
	   	$return .= '    map.addControl(new GMapTypeControl());';	
	    	$return .= '    geocoder = new GClientGeocoder();';
	    	$return .= '  }';
	    	$return .= '}';

		$return .= 'function showAddress(address) {';
		$return .= 'if (geocoder) {';
       	 	$return .= 'geocoder.getLatLng(';
        	$return .= '  address,';
        	$return .= '  function(point) {';
        	$return .= '    if (!point) {';
        	$return .= '      alert(address + " not found");';
        	$return .= '   } else {';
        	$return .= '      map.setCenter(point, 13);';
		$return .= '	  delete marker;';
		$return .= '	  map.clearOverlays();';
        	$return .= '      marker = new GMarker(point, {draggable: true});	';  
		$return .= '	  document.getElementById("gmap_lat'.$fieldid.'").value = marker.getLatLng().lat();';
		$return .= '	  document.getElementById("gmap_lng'.$fieldid.'").value = marker.getLatLng().lng();';
		$return .= '	  GEvent.addListener(marker, "dragstart", function() {';
		$return .= '        });';
		
		$return .= '        GEvent.addListener(marker, "dragend", function() {';
		$return .= '		  document.getElementById("gmap_lat'.$fieldid.'").value = marker.getLatLng().lat();';
		$return .= '		  document.getElementById("gmap_lng'.$fieldid.'").value = marker.getLatLng().lng();';
		$return .= '        });';
        	$return .= '      map.addOverlay(marker);';
       		$return .= '    }';
        	$return .= '  }';
        	$return .= ');';
		$return .= '}';
	   	 $return .= '}';
	    	$return .= '</script>';
		$return .= '</script>';
		$return .= '<div>';
       		$return .= '<input type="text" size="60" name="gmap_address'.$fieldid.'" value="Enter an address to search on the map" />';
        	$return .= '<input type="button" value="Go!" onClick="showAddress(adminForm.gmap_address'.$fieldid.'.value);" />';
		$return .= '<div id="map_canvas'.$fieldid.'" style="width: '.$map_width.'px; height: '.$map_height.'px"></div>';
		$return .= '<input type="hidden" id="gmap_lat'.$fieldid.'" name="gmap_lat'.$fieldid.'" value="'.$lat.'"/>';
		$return .= '<input type="hidden" id="gmap_lng'.$fieldid.'" name="gmap_lng'.$fieldid.'" value="'.$lng.'"/>';
		$return .= '<script type="text/javascript">initialize();</script>';
		$return .= 'If GoogleMap doesn\'t find correctly your address, you can drag the marker to the correct position';
		$return .= '</div>';

		return $return;
	}

	function onFormSave($contentid,$fieldid,$update)
	{
		$lat = JRequest::getVar("gmap_lat$fieldid",0);
		$lng = JRequest::getVar("gmap_lng$fieldid",0);
		
		if ($update == 1)
		{
			$query = "DELETE FROM #__adsmanager_fieldgmap WHERE fieldid = ".(int)$fieldid." AND contentid = ".(int)$contentid;
			$this->_db->setQuery($query);
			$this->_db->query();
			$query = "INSERT INTO #__adsmanager_fieldgmap (`fieldid`,`contentid`,`lat`,`lng`) VALUES ".
				 "($fieldid,$contentid,'$lat','$lng')";	 
			$this->_db->setQuery($query);
			$this->_db->query();
		}
		else
		{
			$query = "INSERT INTO #__adsmanager_fieldgmap (`fieldid`,`contentid`,`lat`,`lng`) VALUES ".
				     "($fieldid,$contentid,'$lat','$lng')";
			$this->_db->setQuery($query);
			$this->_db->query();
		}
	}
	
	function onDelete($directory,$contentid = -1)
	{
		if ($contentid == -1)
			$query = "DELETE FROM #__adsmanager_fieldgmap ".
					"WHERE 1";
		else
			$query = "DELETE FROM #__adsmanager_fieldgmap ".
					"WHERE contentid = ".(int)$contentid;
		$this->_db->setQuery($query);
		$this->_db->query();
	}
	
	function getEditFieldJavaScriptDisable()
	{
		$return = "elem=getObject('divGMapOptions');";
       		$return .= "elem.style.visibility = 'hidden';";
		$return .= "elem.style.display = 'none';";
		$return .= "elem=getObject('gmap_map_width');";
		$return .= "elem.setAttribute('mosReq',0);";
		$return .= "elem=getObject('gmap_map_height');";
		$return .= "elem.setAttribute('mosReq',0);";
		$return .= "elem=getObject('gmap_lat');";
		$return .= "elem.setAttribute('mosReq',0);";
		$return .= "elem=getObject('gmap_lng');";
		$return .= "elem.setAttribute('mosReq',0);";
		$return .= "elem=getObject('gmap_google_key');";
		$return .= "elem.setAttribute('mosReq',0);";
		return $return;
	}
	
	function getEditFieldJavaScriptActive()
	{
       		$return = "disableAll();";
		$return .= "elem=getObject('divGMapOptions');";
		$return .= "elem.style.visibility = 'visible';";
		$return .= "elem.style.display = 'block';";
		$return .= "elem=getObject('gmap_map_width');";
		$return .= "elem.setAttribute('mosReq',1);";
		$return .= "elem=getObject('gmap_map_height');";
		$return .= "elem.setAttribute('mosReq',1);";
		$return .= "elem=getObject('gmap_lat');";
		$return .= "elem.setAttribute('mosReq',1);";
		$return .= "elem=getObject('gmap_lng');";
		$return .= "elem.setAttribute('mosReq',1);";
		$return .= "elem=getObject('gmap_google_key');";
		$return .= "elem.setAttribute('mosReq',1);";
		return $return; 
	}

	function getEditFieldOptions($fieldid)
	{
		$this->_db->setQuery("SELECT * FROM #__adsmanager_fieldgmap_conf WHERE fieldid = '$fieldid'");
		$row = $this->_db->loadObject();
		
		$return = "<div id='divGMapOptions'>";
		$return .= "<table class='adminform'>";
		$return .= "<tr>";
		$return .= "<td width='20%'>Map Width</td>";
		$return .= "<td width='20%' align=left><input type='text' id='gmap_map_width' name='gmap_map_width' mosReq=1 mosLabel='Map Width' class='inputbox' value='".@$row->map_width."' /></td>";
		$return .= "<td>&nbsp;</td>";
		$return .= "</tr>";
		$return .= "<tr>";
		$return .= "<td width='20%'>Map Height</td>";
		$return .= "<td width='20%' align=left><input type='text' id='gmap_map_height' name='gmap_map_height' mosReq=1 mosLabel='Map Height' class='inputbox' value='".@$row->map_height."' /></td>";
		$return .= "<td>&nbsp;</td>";
		$return .= "</tr>";
		$return .= "<tr>";
		$return .= "<td width='20%'>Default Lat</td>";
		$return .= "<td width='20%' align=left><input type='text' id='gmap_lat' name='gmap_lat' mosReq=1 mosLabel='Default Lat' class='inputbox' value='".@$row->lat."' /></td>";
		$return .= "<td>&nbsp;</td>";
		$return .= "</tr>";
		$return .= "<tr>";
		$return .= "<td width='20%'>Default Lng</td>";
		$return .= "<td width='20%' align=left><input type='text' id='gmap_lng' name='gmap_lng' mosReq=1 mosLabel='Default Lng' class='inputbox' value='".@$row->lng."' /></td>";
		$return .= "<td>&nbsp;</td>";
		$return .= "</tr>";
		$return .= "<tr>";
		$return .= "<td width='20%'>Google Key</td>";
		$return .= "<td width='20%' align=left><input type='text' id='gmap_google_key' name='gmap_google_key' mosReq=1 mosLabel='Google Key' class='inputbox' value='".@$row->google_key."' /></td>";
		$return .= "<td>&nbsp;</td>";
		$return .= "</tr>";
		$return .= "</table>";
		$return .= "</div>";
		return $return;
	}

	function saveFieldOptions($fieldid)
	{
		$this->install();
		$gmap_map_width = JRequest::getInt("gmap_map_width",400);
		$gmap_map_height =JRequest::getInt("gmap_map_height",300);
		$gmap_lat = JRequest::getInt("gmap_lat",20);
		$gmap_lng = JRequest::getInt("gmap_lng",20);
		$gmap_google_key = JRequest::getVar("gmap_google_key",0);
		$this->_db->setQuery("DELETE FROM #__adsmanager_fieldgmap_conf WHERE fieldid = ".(int)$fieldid);
		$this->_db->query();
		$this->_db->setQuery("INSERT INTO #__adsmanager_fieldgmap_conf VALUES ($fieldid,$gmap_map_width,$gmap_map_height,$gmap_lat,$gmap_lng,'$gmap_google_key')");
		$this->_db->query();
		return;
	}
	
	function getFieldName()
	{
		return "GMap";
	}
	
	function install()
	{
		$query = "CREATE TABLE IF NOT EXISTS `#__adsmanager_fieldgmap` ( ".
			  "`id` int(10) unsigned NOT NULL auto_increment, ".
			  "`fieldid` int(10) unsigned default NULL, ".
			  "`contentid` int(10) unsigned default NULL, ".
			  "`lat` TEXT default NULL, ".
			  "`lng` TEXT default NULL, ".
			  "PRIMARY KEY  (`id`) ".
			  "); ";
		$this->_db->setQuery($query);
		$this->_db->query();
		
		$query = "CREATE TABLE IF NOT EXISTS `#__adsmanager_fieldgmap_conf` ( ".
			  "`fieldid` int(10) unsigned default NULL, ".
			  "`map_width` int(10) unsigned default '500', ".
			  "`map_height` int(10) unsigned default '300', ".
			  "`lat` VARCHAR( 255 ) default '37.4419', ".
			  "`lng` VARCHAR( 255 ) default '-122.1419', ".
			  "`google_key` TEXT default NULL, ".
			  "PRIMARY KEY  (`fieldid`) ".
			  "); ";
		$this->_db->setQuery($query);
		$this->_db->query();
	}
	
	function uninstall()
	{	
		$query = "DROP TABLE `#__adsmanager_fieldgmap`";
		$this->_db->setQuery($query);
		$this->_db->query();
		
		$query = "DROP TABLE `#__adsmanager_fieldgmap_conf`";
		$this->_db->setQuery($query);
		$this->_db->query();
	}
	
	function __construct($db)
	{
		$this->_db = $db;
	}
}

$plugins["gmap"] = new AdsManagerGmapPlugin($this->_db);
?>
