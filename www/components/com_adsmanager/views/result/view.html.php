<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');

require_once(JPATH_BASE."/components/com_adsmanager/helpers/field.php");
require_once(JPATH_BASE."/components/com_adsmanager/helpers/general.php");

/**
 * @package		Joomla
 * @subpackage	Contacts
 */
class AdsmanagerViewResult extends JView
{
	function display($tpl = null)
	{
		$app = &JFactory::getApplication();

		$user		= JFactory::getUser();
		$pathway	= $app->getPathway();
		$document	= JFactory::getDocument();
		
		$contentmodel	= &$this->getModel( "content" );
		$catmodel	= &$this->getModel( "category" );
		$columnmodel	= &$this->getModel( "column" );
		$positionmodel	= &$this->getModel( "position" );
		$fieldmodel	    = &$this->getModel( "field" );
		$usermodel	    = &$this->getModel( "user" );
		$configurationmodel	= &$this->getModel( "configuration" );
		
		$uri =& JFactory::getURI();
		$this->requestURL =& $uri->toString();

		// Get the parameters of the active menu item
		$menus	= JSite::getMenu();
		$menu    = $menus->getActive();
		
		$conf = $configurationmodel->getConfiguration();
		
		$this->assignRef('userid',$user->id);
		
		$catid = JRequest::getInt( 'catid',	0 );
		$this->assignRef('catid',$catid);	
		
		$mode = $app->getUserStateFromRequest('com_adsmanager.front_content.mode','mode',$conf->display_expand);
		if ($mode == 2)
			$mode = 0;
		$this->assignRef('mode',$mode);
		
		if ($mode == 0) {
			$columns = $columnmodel->getColumns($catid);
			$fcolumns = $fieldmodel->getFieldsbyColumns();
			$this->assignRef('columns',$columns);	
			$this->assignRef('fColumns',$fcolumns);	
		}
		else {
			$positions = $positionmodel->getPositions();
			$fDisplay = $fieldmodel->getFieldsbyPositions();
			$this->assignRef('positions',$positions);	
			$this->assignRef('fDisplay',$fDisplay);	
		}
		
		$filters = array();
		$filters['publish'] =  1;
		if ($catid != 0)
			$filters['category'] = $catid;
			
		$tsearch = $app->getUserStateFromRequest('com_adsmanager.front_content.tsearch','tsearch',"");
		if ($tsearch != "")
		{
			$filters['search'] = $tsearch;
		}
		
		$new_search = JRequest::getInt( 'new_search',	0 );
		jimport( 'joomla.session.session' );	
		if ($new_search == 1){
			$searchfields = $fieldmodel->getSearchFields($catid);
			$filters['fields'] = $fieldmodel->getSearchFieldsSql($searchfields);
			$currentSession = JSession::getInstance('none',array());
			$currentSession->set("searchfieldssql",$filters['fields']);
			$currentSession->set("searchfields",JRequest::get( 'post' ));
		}
		else
		{
			$currentSession = JSession::getInstance('none',array());
			$filters['fields'] = $currentSession->get("searchfieldssql"," 1 ");
		}
		
		$orderfields = $fieldmodel->getOrderFields($catid);
		
		$this->assignRef('orders',$orderfields);
			
		$limit = $app->getUserStateFromRequest('com_adsmanager.front_ads_per_page','limit',$conf->ads_per_page, 'int');
		$limitstart = JRequest::getInt("limitstart",0);
		
		$order = $app->getUserStateFromRequest('com_adsmanager.front_content.order','order',0,'int');
		$contentmodel->getListOrder($order,$filter_order,$filter_order_Dir);
		$this->assignRef('order',$order);
		
        $total = $contentmodel->getNbContents($filters);
		$contents = $contentmodel->getContents($filters,$limitstart, $limit,$filter_order,$filter_order_Dir);
		
		jimport('joomla.html.pagination');
		$pagination = new JPagination($total, $limitstart, $limit);
		$this->assignRef('pagination',$pagination);
		
		$name = JText::_('ADSMANAGER_PAGE_RESULT');
		$img = "";
		$this->assignRef('list_name',$name);
		$this->assignRef('list_img',$img);
		
		$this->assignRef('contents',$contents);
		$this->assignRef('columns',$columns);	
		$this->assignRef('fColumns',$fcolumns);	
		$this->assignRef('conf',$conf);
		
		$this->assignRef('requestURL',$requestURL);
		
		$document->setTitle( JText::_('ADSMANAGER_PAGE_TITLE').  JText::_('ADSMANAGER_PAGE_RESULT') );
		
		$field_values = $fieldmodel->getFieldValues();
		
		$plugins = $fieldmodel->getPlugins();
		$field = new JHTMLAdsmanagerField($conf,$field_values,"2",$plugins,$this->get("Itemid"),$this->get("baseurl"));
		$this->assignRef('field',$field);
				
		$general = new JHTMLAdsmanagerGeneral($catid,$conf->comprofiler,$user,$this->get("Itemid"));
		$this->assignRef('general',$general);

		parent::display($tpl);
	}
	
	function isNewContent($date,$nbdays) {
		$time = strtotime($date);
		if ($time >= (mktime()-($nbdays*24*3600)))
			return true;
		else
			return false;
	}
	
	function loadScriptImage($image_display)
	{
		$document =& JFactory::getDocument();
		
		switch($image_display)
		{
			case 'popup':
				$document->addCustomTag('
				<script language="JavaScript" type="text/javascript">
				<!--
				function popup(img) {
				titre="Popup Image";
				titre="Agrandissement"; 
				w=open("","image","width=400,height=400,toolbar=no,scrollbars=no,resizable=no"); 
				w.document.write("<html><head><title>"+titre+"</title></head>"); 
				w.document.write("<script language=\"javascript\">function checksize() { if	(document.images[0].complete) {	window.resizeTo(document.images[0].width+10,document.images[0].height+50); window.focus();} else { setTimeout(\'checksize()\',250) }}</"+"script>"); 
				w.document.write("<body onload=\"checksize()\" leftMargin=0 topMargin=0 marginwidth=0 marginheight=0>");
				w.document.write("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=\"100%\"><tr>");
				w.document.write("<td valign=\"middle\" align=\"center\"><img src=\""+img+"\" border=0 alt=\"Mon image\">"); 
				w.document.write("</td></tr></table>");
				w.document.write("</body></html>"); 
				w.document.close(); 
				} 
				
				-->
				</script>');
				break;
			case 'lightbox':
			case 'lytebox': 
 				$document->addCustomTag('<script type="text/javascript" src="'.$this->get("baseurl").'/components/com_adsmanager/lytebox/js/lytebox_322cmod1.3.js"></script>'); 
 				$document->addCustomTag('<link rel="stylesheet" href="'.$this->get("baseurl").'/components/com_adsmanager/lytebox/css/lytebox_322cmod1.3.css" type="text/css" media="screen" />'); 
 			break; 
			case 'highslide': 
				$document->addCustomTag('<script type="text/javascript" src="'.$this->get("baseurl").'/components/com_adsmanager/highslide/js/highslide-full.js"></script>'); 
				$document->addCustomTag('<link rel="stylesheet" href="'.$this->get("baseurl").'/components/com_adsmanager/highslide/css/highslide-styles.css" type="text/css" media="screen" />'); 
			break; 
			default:
				break;
		}
	}
	
	function reorderDate( $date ){
		$format = JText::_('ADSMANAGER_DATE_FORMAT_LC');
		
		if ($date && (preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2})/",$date,$regs))) {
			$date = mktime( 0, 0, 0, $regs[2], $regs[3], $regs[1] );
			$date = $date > -1 ? strftime( $format, $date) : '-';
		}
		return $date;
	}
}
