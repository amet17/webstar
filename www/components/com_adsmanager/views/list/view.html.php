<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');

require_once(JPATH_SITE."/components/com_adsmanager/helpers/field.php");
require_once(JPATH_SITE."/components/com_adsmanager/helpers/general.php");

/**
 * @package		Joomla
 * @subpackage	Contacts
 */
class AdsmanagerViewList extends JView
{
	function display($tpl = null)
	{
		$app = &JFactory::getApplication();

		$user		= JFactory::getUser();
		$pathway	= & $app->getPathway();
		$document	= JFactory::getDocument();
		
		$contentmodel	= &$this->getModel( "content" );
		$catmodel		= &$this->getModel( "category" );
		$positionmodel	= &$this->getModel( "position" );
		$columnmodel	= &$this->getModel( "column" );
		$fieldmodel	    = &$this->getModel( "field" );
		$usermodel	    = &$this->getModel( "user" );
		$configurationmodel	= &$this->getModel( "configuration" );
		
		$uri =& JFactory::getURI();
		$this->requestURL =& $uri->toString();

		// Get the parameters of the active menu item
		$menus	= JSite::getMenu();
		$menu    = $menus->getActive();
		
		$conf = $configurationmodel->getConfiguration();
		
		$catid = JRequest::getInt( 'catid',	0 );
		$this->assignRef('catid',$catid);
		if ($catid != "0") {
			$category = $catmodel->getCategory($catid);
			$category->imgpath = 'images/com_adsmanager/categories/'.$catid.'cat_t.jpg';
			$category->img = $this->get('baseurl').$category->imgpath;
			if(!file_exists(JPATH_BASE.'/'.$category->imgpath))
				$category->img = $this->get('baseurl').'components/com_adsmanager/images/default.gif';
		}
		else
		{
			$category->name = JText::_("ADSMANAGER_ALL_ADS");
			$category->description = "";
			$category->img = $this->get('baseurl').'components/com_adsmanager/images/default.gif';
		}
		
		$filters = array();
		$filters['publish'] =  1;
		if ($catid != 0)
			$filters['category'] = $catid;
			
		$modeuser = 0;
			
		$listuser = JRequest::getInt( 'user',	-1 );
		if (($listuser == 0)&&($user->id != 0))
			$listuser = $user->id;
			
		if ($listuser != -1) {			
			$filters['user'] = $listuser;
			$username = $usermodel->getUserName($listuser);
			$category->name = JText::_('ADSMANAGER_LIST_USER_TEXT')." ".$username;
			$this->assignRef('listuser',$listuser);
			$modeuser = 1;
			
		}
		
		$this->assignRef('modeuser',$modeuser);
		
		$session =& JFactory::getSession();
		$list_type = $session->get('list_type','','adsmanager');
		$list_value = $session->get('list_value','','adsmanager');

		if ($listuser != -1) {	
			if (($list_type == 'user')&&($list_value == $listuser)) {
				$tsearch = JRequest::getVar( 'tsearch',	$session->get('tsearch','','adsmanager'));
				$session->set('tsearch',$tsearch,'adsmanager');
			} else {
				$session->set('list_type','user','adsmanager');
				$session->set('list_value',$listuser,'adsmanager');
				$session->set('tsearch','','adsmanager');
				$tsearch = '';
			}
		} else {
			if (($list_type == 'category')&&($list_value == $catid)) {
				$tsearch = JRequest::getVar( 'tsearch',	$session->get('tsearch','','adsmanager'));
				$session->set('tsearch',$tsearch,'adsmanager');
			} else {
				$session->set('list_type','category','adsmanager');
				$session->set('list_value',$catid,'adsmanager');
				$session->set('tsearch','','adsmanager');
				$tsearch = '';
			}
		}
		
		if ($tsearch != "")
		{
			$filters['search'] = $tsearch;
		}
		$this->assignRef('tsearch',$tsearch);

		if ($listuser == -1) {
			$subcats = $catmodel->getSubCats($catid);
			$pathlist = $catmodel->getPathList($catid,$this->get("Itemid"));
		}
		else
		{
			$subcats = array();
			$pathlist = array();
		}
		
		$orderfields = $fieldmodel->getOrderFields($catid);
		
		$this->assignRef('orders',$orderfields);
		
		$this->assignRef('subcats',$subcats);
		$this->assignRef('pathlist',$pathlist);
			
		$limitstart = JRequest::getInt("limitstart",0);
			
		$limit = $app->getUserStateFromRequest('com_adsmanager.front_ads_per_page','limit',$conf->ads_per_page, 'int');
		
		
		$order = $app->getUserStateFromRequest('com_adsmanager.front_content.order','order',0,'int');
		$contentmodel->getListOrder($order,$filter_order,$filter_order_Dir);
		$this->assignRef('order',$order);

		$this->assignRef('lists',$lists);
		
        $total = $contentmodel->getNbContents($filters);
		$contents = $contentmodel->getContents($filters,$limitstart, $limit,$filter_order,$filter_order_Dir);
		
		jimport('joomla.html.pagination');
		$pagination = new JPagination($total, $limitstart, $limit);
		$this->assignRef('pagination',$pagination);
		
		$this->assignRef('list_name',$category->name);
		$this->assignRef('list_img',$category->img);
		$this->assignRef('list_description',$category->description);
		$this->assignRef('contents',$contents);
		
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
		
		$this->assignRef('conf',$conf);
		$this->assignRef('userid',$user->id);
		
		$this->assignRef('requestURL',$requestURL);
		
		$document->setTitle( JText::_('ADSMANAGER_PAGE_TITLE'). JText::_($category->name) );
		
		$field_values = $fieldmodel->getFieldValues();
		
		$plugins = $fieldmodel->getPlugins();
		$field = new JHTMLAdsmanagerField($conf,$field_values,"2",$plugins,$this->get("Itemid"),$this->get("baseurl"));
		$this->assignRef('field',$field);
		
		//set breadcrumbs 
		$nb = count($pathlist);
		for ($i = $nb - 2 ; $i >=0;$i--)
		{
			$pathway->addItem($pathlist[$i]->text, $pathlist[$i]->link);
		}
		
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
	
	function reorderDate( $date ){
		$format = JText::_('ADSMANAGER_DATE_FORMAT_LC');
		
		if ($date && (preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2})/",$date,$regs))) {
			$date = mktime( 0, 0, 0, $regs[2], $regs[3], $regs[1] );
			$date = $date > -1 ? strftime( $format, $date) : '-';
		}
		return $date;
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
				w.document.write("<td valign=\"middle\" align=\"center\"><img src=\""+img+"\" border=0 alt=\"image\">"); 
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
				$document->addCustomTag('<script type="text/javascript">hs.graphicsDir = "'.$this->get("baseurl").'" + hs.graphicsDir;</script>'); 
				$document->addCustomTag('<link rel="stylesheet" href="'.$this->get("baseurl").'/components/com_adsmanager/highslide/css/highslide-styles.css" type="text/css" media="screen" />'); 
				break; 
			default:
				break;
		}
	}
}
