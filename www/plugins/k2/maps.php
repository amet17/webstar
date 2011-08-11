<?php
/*
 // K2 Maps V1.1.1
 // Copyright (c) 2009 - 2010 Simon Wells. All rights reserved.
 // Released under the GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 // More info at http://simon.getk2.org
 // Last update: 24th May 2010
 // Change Log
 // V1.0 Initial Release
 // V1.1 Removed display instance from Category and Category View, only displays in the K2 Item page
 // V1.1.1 Updated Copyright and Support information following user and file moving to new domain
 */

// no direct access
defined('_JEXEC') or die ('Restricted access');
JLoader::register('K2Plugin', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'lib'.DS.'k2plugin.php');

/**
 * K2 Plugin to display Google map in a K2 Item.
 */

class plgK2Maps extends K2Plugin {

	// Some params
	var $pluginName = 'maps';
	var $pluginNameHumanReadable = 'Google Maps';

	function plgK2Youtube( & $subject, $params) {
	
		parent::__construct($subject, $params);
	}

	// Event to display the Map.
	function onK2AfterDisplayContent( & $item, & $params, $limitstart) {
	
		global $mainframe;
	
		$plugin = & JPluginHelper::getPlugin('k2', 'maps');
		$pluginParams = new JParameter($plugin->params);
		$view	= JRequest::getCmd('view');
	
		$plugins = new K2Parameter($item->plugins, '', $this->pluginName);
		$longitude = $plugins->get('longitude');
		$latitude = $plugins->get('latitude');
		$marker = $plugins->get('marker');
		$color = $plugins->get('color');
		$zoom = $plugins->get('zoom', 12);
		$width = $plugins->get('width', 400);
		$height = $plugins->get('height', 200);
		$type = $plugins->get('type', 'roadmap');

		if ($view == 'item')
		{
		if ($longitude=="") {
		$output ='';
		}
		else {
		$output = '<img src="http://maps.google.com/maps/api/staticmap?center='.$longitude.','.$latitude.'&zoom='.$zoom.'&size='.$width.'x'.$height.'&maptype='.$type.'
&markers=color:'.$color.'|label:'.$marker.'|'.$longitude.','.$latitude.'&sensor=false"/>';
		}
	}
		return $output;
	}
}