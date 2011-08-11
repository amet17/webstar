<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'tables');

/**
 * Content Component Controller
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class AdsManagerController extends JController
{
	function display()
	{
		 $app = JFactory::getApplication();
		$document = JFactory::getDocument();
		$user		= JFactory::getUser();
		
		if ( ! JRequest::getCmd( 'view' ) ) {
			$default	= 'front';
			JRequest::setVar('view', $default );
		}
		
		$viewName  = JRequest::getVar('view', 'front', 'default', 'cmd');
		$type	   = JRequest::getVar('format', 'html', 'default', 'cmd');
		$view      = $this->getView($viewName,$type);
		
		if ($viewName == "edit")
		{
			$this->write();
			return;
		}
		
		$uri =& JFactory::getURI();
		$baseurl = JURI::base();
		$view->assign("baseurl",$baseurl);
		$view->assignRef("baseurl",$baseurl);
		
		if (($type == "html")&&(!defined( '_ADSMANAGER_CSS' ))) {
			/** ensure that functions are declared only once */
			define( '_ADSMANAGER_CSS', 1 );
			$uri =& JFactory::getURI();
			$baseurl = JURI::base();
			
			$document =& JFactory::getDocument();
			$document->addStyleSheet($baseurl.'components/com_adsmanager/css/adsmanager.css');
		}
		
		$itemid = JRequest::getInt('Itemid', 0);
		if ($itemid == 0)
		{
			$component =& JComponentHelper::getComponent('com_adsmanager');
      	    $menus  = &JApplication::getMenu('site', array());
       		$items  = $menus->getItems('componentid', $component->id);
       		if ($items)
       		{
				$itemid = $items[0]->id;       			
       		}
		}  
		$view->assign("Itemid",$itemid);
		$view->assignRef("Itemid",$itemid);
		
		// Push a model into the view
		$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'models');
		
		$contentmodel	= &$this->getModel( "content" );
		$catmodel		= &$this->getModel( "category" );
		$positionmodel	= &$this->getModel( "position" );
		$columnmodel	= &$this->getModel( "column" );
		$fieldmodel	    = &$this->getModel( "field" );
		$usermodel		= &$this->getModel( "user" );
		$adsmanagermodel= &$this->getModel( "adsmanager" );
		$configurationmodel	= &$this->getModel( "configuration" );
		
		if (!JError::isError( $contentmodel )) {
			$view->setModel( $contentmodel, true );
		}	
		
		$view->setModel( $contentmodel);
		$view->setModel( $catmodel);
		$view->setModel( $positionmodel);
		$view->setModel( $columnmodel);
		$view->setModel( $fieldmodel);
		$view->setModel( $usermodel);
		$view->setModel( $adsmanagermodel);
		$view->setModel( $configurationmodel);
		
		if (file_exists( JPATH_BASE .'/components/com_adsmanager/cron.php' ))
			require_once( JPATH_BASE .'/components/com_adsmanager/cron.php' );
		if ($last_cron_date != "Ymd") {
			$contentmodel->manage_expiration($itemid,$fieldmodel->getPlugins(),$configurationmodel->getConfiguration());
		}
		
		if ($viewName == "details") {
			$contentid = JRequest::getInt( 'id',	0 );
			$content = $contentmodel->getContent($contentid);
			// increment views. views from ad author are not counted to prevent highclicking views of own ad
			if ( $user->id <> $content->userid || $content->userid==0) {
				$contentmodel->increaseHits($content->id);
			}
		}
		
		
		if ($user->get('id'))
		{
			parent::display(false);
		}
		else if ($viewName == "list")
		{
			$cache =& JFactory::getCache( 'com_adsmanager' );
			$method = array( $view, 'display' );
			
			$conf = $configurationmodel->getConfiguration();
			
			$tsearch = $app->getUserStateFromRequest('com_adsmanager.front_content.tsearch','tsearch',"");
			$limit   = $app->getUserStateFromRequest('global.list.limit','limit',$app->getCfg('list_limit'), 'int');
			$order   = $app->getUserStateFromRequest('com_adsmanager.front_content.order','order',0,'int');
			$mode    = $app->getUserStateFromRequest('com_adsmanager.front_content.mode','mode',$conf->display_expand);
			$url =& $uri->toString();
			
			echo $cache->call( $method, null,$url,$tsearch,$limit,$order,$mode) . "\n";
		}
		else
		{	
			parent::display(true);
		}
	}
	
	function write()
	{
		$app = JFactory::getApplication();
		
		$document = JFactory::getDocument();

		// Set the default view name from the Request
		$type = "html";
		
		$uri =& JFactory::getURI();
		$baseurl = JURI::base();
		
		if (!defined( '_ADSMANAGER_CSS' )) {
			/** ensure that functions are declared only once */
			define( '_ADSMANAGER_CSS', 1 );
			$uri =& JFactory::getURI();
			$baseurl = JURI::base();
			$document =& JFactory::getDocument();
			$document->addStyleSheet($baseurl.'components/com_adsmanager/css/adsmanager.css');
		}
		
		// Push a model into the view
		$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'models');
		$configurationmodel	= &$this->getModel( "configuration" );
		$catmodel		    = &$this->getModel( "category" );
		$contentmodel		= &$this->getModel( "content" );
		$fieldmodel			= &$this->getModel( "field" );
		$usermodel			= &$this->getModel( "user");
		
		$user = JFactory::getUser();
		$conf = $configurationmodel->getConfiguration();
		
		$itemid = JRequest::getInt('Itemid', 0);
		if ($itemid == 0)
		{
			$component =& JComponentHelper::getComponent('com_adsmanager');
      	    $menus  = &JApplication::getMenu('site', array());
       		$items  = $menus->getItems('componentid', $component->id);
       		if ($items)
       		{
				$itemid = $items[0]->id;       			
       		}
		}  
		
		
		/* submission_type = 1 -> Account needed */
	    if (($conf->submission_type == 1)&&($user->id == "0")) {	
	    	$view = $this->getView("login",'html');
	    	$view->setModel( $contentmodel, true );
	    	$view->setModel( $catmodel );
			$view->setModel( $configurationmodel );
			$view->setModel( $fieldmodel );
			$view->setModel( $usermodel );
			
			$view->assign("Itemid",$itemid);
			$view->assignRef("Itemid",$itemid);
		
	    	$view->display();
	    }
	    else
	    {
		    $contentid = JRequest::getInt( 'id', 0 );
		    $nbcontents = $contentmodel->getNbContentsOfUser($user->id);
		  
			if (($contentid == 0)&&($user->id != "0")&&($conf->nb_ads_by_user != -1)&&($nbcontents >= $conf->nb_ads_by_user))
			{
				//REDIRECT
				$redirect_text = sprintf(JText::_('ADSMANAGER_MAX_NUM_ADS_REACHED'),$conf->nb_ads_by_user);
				$app->redirect( 'index.php?option=com_adsmanager&view=list&Itemid='.$itemid, $redirect_text );
			}
			else 
			{
				$view = $this->getView("edit",'html');
				$view->setModel( $contentmodel, true );
				$view->setModel( $catmodel );
				$view->setModel( $configurationmodel );
				$view->setModel( $fieldmodel );
				$view->setModel( $usermodel );
				
				$view->assign("Itemid",$itemid);
				$view->assignRef("Itemid",$itemid);
		
				$view->display();
			}
	    }
	}

	/**
	* Saves the content item an edit form submit
	*
	* @todo
	*/
	function save()
	{	
		$app = JFactory::getApplication();
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$redirect_text = JText::_('ADSMANAGER_INSERT_SUCCESSFULL_PUBLISH');
		
		$user = JFactory::getUser();
		$content =& JTable::getInstance('content', 'AdsmanagerTable');
		
		$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'models');
		$configurationmodel	= &$this->getModel( "configuration" );
		$contentmodel		= &$this->getModel( "content" );
		$usermodel			= &$this->getModel( "user" );
		
		$itemid = JRequest::getInt('Itemid', 0);
		
		if ($itemid == 0)
		{
			$component =& JComponentHelper::getComponent('com_adsmanager');
      	    $menus  = &JApplication::getMenu('site', array());
       		$items  = $menus->getItems('componentid', $component->id);
       		if ($items)
       		{
				$itemid = $items[0]->id;       			
       		}
		}  
		
		
		$conf = $configurationmodel->getConfiguration();

		$id = JRequest::getInt( 'id', 0 );
		
		if (($id == 0)&&($user->id != "0")&&($conf->nb_ads_by_user != -1))
		{
			$nb = $contentmodel->getNbContentsOfUser($user->id);
			if ($nb >= $conf->nb_ads_by_user)
			{
				$redirect_text = sprintf(JText::_('ADSMANAGER_MAX_NUM_ADS_REACHED'),$conf->nb_ads_by_user);
				$app->redirect( 'index.php?option=com_adsmanager&view=list&Itemid='.$itemid, $redirect_text );
			}
		}
	
		// bind it to the table
		if (!$content -> bind(JRequest::get( 'post' ))) {
			return JError::raiseWarning( 500, $row->getError() );
		}
		
		if (($content->id != 0)&&($content->id != "")) {
			$isUpdateMode = 1;
			$redirect_text = JText::_('ADSMANAGER_UPDATE_SUCCESSFULL');
		}
		else
			$isUpdateMode = 0;
	
		if ($isUpdateMode == 0)
		{
			if ($conf->auto_publish == 1)
			{
				$content->published = 1;
			}
			else
			{
				$content->published = 0;
				$redirect_text = JText::_('ADSMANAGER_INSERT_SUCCESSFULL_CONFIRM');
			}
		}
		
		if ($isUpdateMode == 0)
		{
			$content->date_created = date("Y-m-d H:i:s");
			$delta = $conf->ad_duration;  
			$content->expiration_date = date("Y-m-d",mktime()+($delta*24*3600)); 
		}	
		
		//Creation of account if needed
		if (($conf->submission_type == 0)&&($user->id == 0))
		{
			$username = JRequest::getVar('username', "" );
			$password = JRequest::getVar('password', ""  );
			$email = JRequest::getVar('email', ""  );
			$errorMsg = $usermodel->checkAccount($username,$password,$email,$userid,$conf);
			if (isset($errorMsg))
			{
				$catid = JRequest::getInt('category', 0 );
				$url = JRoute::_("index.php?option=com_adsmanager&task=write&catid=$catid&Itemid=$itemid");
				echo "<form name='form' action='$url' method='post'>"; 
				foreach(JRequest::get( 'post' ) as $key=>$val) 
				{
					echo "<input type='hidden' name='$key' value='".htmlentities($val)."'>"; 
				}
				echo "<input type='hidden' name='errorMsg' value='$errorMsg'>"; 
				echo '</form>'; 
				echo '<script language="JavaScript">'; 
				echo 'document.form.submit()'; 
				echo '</script>'; 		
				return;
			}
			$user->id = $userid;
		}
		
		//Valid account or visitor are allowed to post
		if (($user->id != 0)||($conf->submission_type == 2))
		{
			$content->userid = $user->id;
		} else {
			//trying to save ad, without being registered
			return;
		}
		
		// store it in the db
		if (!$content -> store()) {
			return JError::raiseWarning( 500, $content->getError() );
		}	
		
		$model = $this->getModel("field");
		$plugins = $model->getPlugins();
		
		$content->save(JRequest::get( 'post' ),JRequest::get( 'files' ),$conf,$this->getModel("adsmanager"),$plugins,$isUpdateMode);
		
		$cache = & JFactory::getCache('com_adsmanager');
		$cache->clean();
		
		if ((($conf->send_email_on_new == 1)&&($isUpdateMode == 0))||
			(($conf->send_email_on_update == 1)&&($isUpdateMode == 1)))
		{
			$config	= &JFactory::getConfig();
			$from		= $config->getValue('mailfrom');
			$fromname	= $config->getValue('fromname');
			
			$body = JRequest::getVar("ad_text", "" );
			$body = str_replace(array("\r\n", "\n", "\r"), "<br />", $body);
			
			$subject = JRequest::getVar("ad_headline", "" );
			if( $isUpdateMode == 1)
				$subject = JText::_('ADSMANAGER_EMAIL_UPDATE')." ".$subject;
			else
				$subject = JText::_('ADSMANAGER_EMAIL_NEW')." ".$subject;
				
			// Send the e-mail to Administrator
			if (!JUtility::sendMail($from, $fromname, $from, $subject, $body))
			{
				$this->setError(JText::_('ADSMANAGER_ERROR_SENDING_MAIL'));
				return false;
			}
		}	
		
		$cache =& JFactory::getCache( 'com_adsmanager');
		$cache->clean();
	
		if ($conf->submission_type == 2)
			$app->redirect( 'index.php?option=com_adsmanager&view=list&Itemid='.$itemid, $redirect_text );	
		else if ($conf->comprofiler == 2)
			$app->redirect( 'index.php?option=com_comprofiler&task=userProfile&tab=AdsManagerTab', $redirect_text );
		else
			$app->redirect( 'index.php?option=com_adsmanager&view=list&Itemid='.$itemid, $redirect_text );
			
	}
	
	function delete()
	{
		$app = JFactory::getApplication();
		
		$itemid = JRequest::getInt('Itemid', 0);
		
		if ($itemid == 0)
		{
			$component =& JComponentHelper::getComponent('com_adsmanager');
      	    $menus  = &JApplication::getMenu('site', array());
       		$items  = $menus->getItems('componentid', $component->id);
       		if ($items)
       		{
				$itemid = $items[0]->id;       			
       		}
		}  
		
		$user = JFactory::getUser();
		$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'models');
		$configurationmodel = &$this->getModel( "configuration" );
		$fieldmodel	        = &$this->getModel( "field" );
		
		$content =& JTable::getInstance('content', 'AdsmanagerTable');
		
		$id = JRequest::getInt('id', 0);
		if ($id == 0) {
			$app->redirect( 'index.php?option=com_adsmanager&view=list&Itemid='.$itemid, "" );
		}
		
		$content->load($id);
		if (($content == null)||($content->userid != $user->id))
			$app->redirect( 'index.php?option=com_adsmanager&view=list&Itemid='.$itemid, "" );
		
		$conf = $configurationmodel->getConfiguration();
		$plugins = $fieldmodel->getPlugins();
		
		$content->delete($id,$conf,$plugins);
		
		$cache =& JFactory::getCache( 'com_adsmanager');
		$cache->clean();
		
		$app->redirect( 'index.php?option=com_adsmanager&view=list&Itemid='.$itemid, JText::_('ADSMANAGER_CONTENT_REMOVED') );
	}
	
	function sendmessage()
	{
		$app = JFactory::getApplication();
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$contentid = JRequest::getInt( 'contentid',0 );
		$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'models');
		$contentmodel = &$this->getModel( "content" );
		$content = $contentmodel->getContent($contentid);
		
		$itemid = JRequest::getInt('Itemid', 0);
		
		if ($itemid == 0)
		{
			$component =& JComponentHelper::getComponent('com_adsmanager');
      	    $menus  = &JApplication::getMenu('site', array());
       		$items  = $menus->getItems('componentid', $component->id);
       		if ($items)
       		{
				$itemid = $items[0]->id;       			
       		}
		}  
		
		if (isset($content))
		{
			$name = JRequest::getVar('name' , "" );
			$email = JRequest::getVar('email', "" );
			jimport('joomla.mail.helper');
			if (!JMailHelper::isEmailAddress($email))
			{
				$this->setError(JText::_('INVALID_EMAIL_ADDRESS'));
				$app->redirect( 'index.php?option=com_adsmanager&view=details&catid='.$content->catid.'&id='.$contentid.'&Itemid='.$itemid, 'INVALID_EMAIL_ADDRESS' );
			}
			$subject = JRequest::getVar('title', "" );
			$body = JRequest::getVar('body' , "" );
			$body = str_replace(array("\r\n", "\n", "\r"), "<br />", $body);
			
			$file = JRequest::getVar( 'attach_file',null,'FILES');
			if ($file['tmp_name'] != "")
			{
				$directory = ini_get('upload_tmp_dir')."";
				if ($directory == "")
					$directory = ini_get('session.save_path')."";
					
				$filename = $directory."/".basename($file['name']);
				rename($file['tmp_name'], $filename);
				if (!JUtility::sendMail($email,$name,$content->email,$subject,$body,1,NULL,NULL,$filename))
				{
					$this->setError(JText::_('ADSMANAGER_ERROR_SENDING_MAIL'));
					$app->redirect( 'index.php?option=com_adsmanager&view=details&catid='.$content->catid.'&id='.$contentid.'&Itemid='.$itemid, JText::_('ADSMANAGER_ERROR_SENDING_MAIL') );
				}
			}
			else {
				if (!JUtility::sendMail($email,$name,$content->email,$subject,$body,1))
				{
					$this->setError(JText::_('ADSMANAGER_ERROR_SENDING_MAIL'));
					$app->redirect( 'index.php?option=com_adsmanager&view=details&catid='.$content->catid.'&id='.$contentid.'&Itemid='.$itemid, JText::_('ADSMANAGER_ERROR_SENDING_MAIL') );
				}
			}
		}
		$app->redirect( 'index.php?option=com_adsmanager&view=details&catid='.$content->catid.'&id='.$contentid.'&Itemid='.$itemid, JText::_('ADSMANAGER_EMAIL_SENT') );
	}
	
	function saveprofile()
	{
		$app = JFactory::getApplication();
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$user  = JFactory::getUser();
		$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'models');
		$usermodel = &$this->getModel( "user" );
		
		$itemid = JRequest::getInt('Itemid', 0);
		
		if ($itemid == 0)
		{
			$component =& JComponentHelper::getComponent('com_adsmanager');
      	    $menus  = &JApplication::getMenu('site', array());
       		$items  = $menus->getItems('componentid', $component->id);
       		if ($items)
       		{
				$itemid = $items[0]->id;       			
       		}
		}  
	
		$user->orig_password = $user->password;
	
		$password   =  JRequest::getVar('password', "");
		$verifyPass = JRequest::getVar('verifyPass', "");
		if($password != "") {
			if($verifyPass == $password) {
				jimport('joomla.user.helper');
				$salt = JUserHelper::genRandomPassword(32);
				$crypt = JUserHelper::getCryptedPassword($password, $salt);
				$user->password = $crypt.':'.$salt;
			} else {
				$app->redirect( 'index.php?option=com_adsmanager&view=profile&Itemid='.$itemid, JText::_('_PASS_MATCH') );
				exit();
			}
		} else {
			// Restore 'original password'
			$user->password = $row->orig_password;
		}
	
		$user->name = JRequest::getVar('name', "");
		$user->username = JRequest::getVar('username', "");
		$user->email = JRequest::getVar('email', "");
	
		unset($user->orig_password); // prevent DB error!!
	
		if (!$user->save()) {
			$app->redirect( 'index.php?option=com_adsmanager&view=profile&Itemid='.$itemid, $user->getError() );
		}
	
		$usermodel->updateProfileFields($user->id);
		
		$app->redirect( 'index.php?option=com_adsmanager&view=profile&Itemid='.$itemid, JText::_('ADSMANAGER_PROFILE_SAVED') );
	}
	
	function renew() {
		$app = JFactory::getApplication();
		
		$itemid = JRequest::getInt('Itemid', 0);
		
		if ($itemid == 0)
		{
			$component =& JComponentHelper::getComponent('com_adsmanager');
      	    $menus  = &JApplication::getMenu('site', array());
       		$items  = $menus->getItems('componentid', $component->id);
       		if ($items)
       		{
				$itemid = $items[0]->id;       			
       		}
		}  
		$contentid = JRequest::getInt('id', 0);
		
		if (function_exists("renewPaidAd")) {
			renewPaidAd($contentid,$itemid);
			
			$cache =& JFactory::getCache( 'com_adsmanager');
			$cache->clean();
			
			$app->redirect("index.php?option=com_adsmanager&Itemid=".$itemid,JText::_('ADSMANAGER_CONTENT_RESUBMIT'));
		}
		else
		{
			$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'models');
			$contentmodel = &$this->getModel( "content" );
			
			$confmodel = &$this->getModel( "configuration" );
			$conf = $confmodel->getConfiguration();
			
			
			$contentmodel->renewContent($contentid,$conf->ad_duration);
			
			$cache =& JFactory::getCache( 'com_adsmanager');
			$cache->clean();
			
			$app->redirect("index.php?option=com_adsmanager&Itemid=".$itemid,JText::_('ADSMANAGER_CONTENT_RESUBMIT'));
		}
	}
}
