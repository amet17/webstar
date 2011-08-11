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
class AdsmanagerModelUser extends JModel
{
	function checkAccount( $username,$password,$email,&$userid,$conf ) {
	    $app = &JFactory::getApplication();
	
		$query = 'SELECT `id`'
			. ' FROM `#__users`'
			. ' WHERE username=' . $this->_db->Quote( $username )
			;
		$this->_db->setQuery( $query );
		$user = $this->_db->loadObject();
		
		if (isset($user)) {
			$credentials = array();
			$credentials['username'] = $username;
			$credentials['password'] = $password;
			jimport( 'joomla.user.authentication');
			$authenticate = & JAuthentication::getInstance();
			$response  = $authenticate->authenticate($credentials, array());
		
			if($response->status === JAUTHENTICATE_STATUS_SUCCESS) {
				$app->login( array( 'username' => $username, 'password' => $password ), array() );
				$user = JFactory::getUser($username);
				$userid = $user->id;
				return null;
			}
			else
			{
				//Login Failed
				return "bad_password";
			}
		}
		else
		{
			$userid = $this->saveRegistration($conf->comprofiler);
			if ($userid == false) {
				return "bad_password";
			} else {	
				$app->login( array( 'username' => $username, 'password' => $password ), array() );
				$user = JFactory::getUser($username);
				$userid = $user->id;
			}
			return null;
		}
	}
	
	function saveRegistration($comprofiler) {
	
		$version = new JVersion;
        $joomla = $version->getShortVersion();
        
		// If user registration is not allowed, show 403 not authorized.
		$params = JComponentHelper::getParams('com_users');
		if ($params->get('allowUserRegistration') == '0') {
			JError::raiseError( 403, JText::_( 'Access Forbidden' ));
			return;
		}
		
		if(substr($joomla,0,3) == '1.5'){
			$authorize	=& JFactory::getACL();
		
			$user = clone(JFactory::getUser());
			
			// Initialize new usertype setting
			$newUsertype = $params->get( 'new_usertype' );
			if (!$newUsertype) {
				$newUsertype = 'Registered';
			}
			
			// Bind the post array to the user object	
			$post = JRequest::get('post');
			$post['password2'] = $post['password'];
			if (!$user->bind($post, 'usertype' )) {
				JError::raiseError( 500, $user->getError());
			}
	
			// Set some initial user values
			$user->set('id', 0);
			$user->set('usertype', $newUsertype);
			$user->set('gid', $authorize->get_group_id( '', $newUsertype, 'ARO' ));
	
			$date =& JFactory::getDate();
			$user->set('registerDate', $date->toMySQL());
	
			// If user activation is turned on, we need to set the activation information
			$useractivation = $params->get( 'useractivation' );
			if ($useractivation == '1')
			{
				jimport('joomla.user.helper');
				$user->set('activation', JUtility::getHash( JUserHelper::genRandomPassword()) );
				//$user->set('block', '1');
			}
	
			// If there was an error with registration, set the message and display form
			if ( !$user->save() )
			{
				JError::raiseWarning('', JText::_( $user->getError()));
				return false;
			}
		} else {
			// Initialise the table with JUser.
			$user = new JUser;
			$data = JRequest::get('post');
	
			// Prepare the data for the user object.
			$useractivation = $params->get('useractivation');
	
			// Check if the user needs to activate their account.
			if (($useractivation == 1) || ($useractivation == 2)) {
				jimport('joomla.user.helper');
				$data['activation'] = JUtility::getHash(JUserHelper::genRandomPassword());
				//$data['block'] = 1;
			}
			
			// Get the groups the user should be added to after registration.
			$data['groups'] = array();
			// Get the default new user group, Registered if not specified.
			$system	= $params->get('new_usertype', 2);
			$data['groups'][] = $system;
	
			// Bind the data.
			if (!$user->bind($data)) {
				$this->setError(JText::sprintf('COM_USERS_REGISTRATION_BIND_FAILED', $user->getError()));
				return false;
			}
	
			// Load the users plugin group.
			JPluginHelper::importPlugin('user');
	
			// Store the data.
			if (!$user->save()) {
				$this->setError(JText::sprintf('COM_USERS_REGISTRATION_SAVE_FAILED', $user->getError()));
				return false;
			}
		}
		
		
		$username = $post['username'];
		$this->_db->setQuery( 'SELECT `id`'
			. ' FROM `#__users`'
			. ' WHERE username=' . $this->_db->Quote( $username ));
		$userid  = (int)$this->_db->loadResult();
		
		if ($comprofiler > 0)
		{
			$lastname = $this->_db->Quote(JRequest::getVar('name', "" ));
			$firstname = $this->_db->Quote(JRequest::getVar('firstname', "" ));
			$middlename = $this->_db->Quote(JRequest::getVar('middlename', ""  ));
			
			$query = "INSERT INTO #__comprofiler (id,user_id,firstname,middlename,lastname) VALUES ('$userid' ,'$userid' ,$firstname,$middlename,$lastname)";
			$this->_db->setQuery($query);
			$this->_db->query();
		}
		
		return $userid;
	}  
	
	function getProfileFields()
	{
		$this->_db->setQuery( "SELECT f.name,f.title FROM #__adsmanager_fields as f ".
									 "WHERE f.profile = 1 AND f.published = 1 ORDER BY f.ordering ASC");
		$fields = $this->_db->loadObjectList();
		return $fields;
	}	
	
	function getUsers() {
		$this->_db->setQuery("SELECT * FROM #__users WHERE 1"  );
		$users = $this->_db-> loadObjectList();
		return $users;
	}
	
	function getCBProfile($userid)
	{
		$this->_db->setQuery("SELECT f.name as name,c.name as cbname,c.table FROM #__comprofiler_fields as c ".
									"LEFT JOIN #__adsmanager_fields as f ON f.cb_field  = c.fieldid ".
									"WHERE f.cb_field <> 1 AND f.published = 1");
									
		$rows = $this->_db->loadObjectList();
		$sql="SELECT ";
		for($i=0,$nb=count($rows);$i<$nb;$i++)
		{
			//No need to quote internal variable
			if ($rows[$i]->table == "#__comprofiler")
				$sql .= "cb.".$rows[$i]->cbname." as ".$rows[$i]->name;
			else
				$sql .= "u.".$rows[$i]->cbname." as ".$rows[$i]->name;
				
			if ($i != $nb - 1)
				$sql .= ",";
		}				
	
		$this->_db->setQuery("$sql FROM #__comprofiler as cb, #__users as u ".
							"WHERE cb.user_id=".(int)$userid." AND u.id=".(int)$userid);
															
		$user = $this->_db->loadObject();
		return $user;	
	}
	
	function getUserName($userid)
	{
		$this->_db->setQuery( "SELECT username FROM #__users WHERE id = ".(int)$userid);
		return $this->_db->loadResult();
	}
	
	function updateProfileFields($userid)
	{
		$this->_db->setQuery( "SELECT f.name FROM #__adsmanager_fields as f ".
							 "WHERE f.profile = 1 AND f.published = 1");
		$fields = $this->_db->loadObjectList();
		
		$sql = "UPDATE #__adsmanager_profile SET ";
		
		for($i=0,$nb=count($fields);$i<$nb;$i++)
		{
			$value = JRequest::getVar($fields[$i]->name, "");
			$sql .= $fields[$i]->name." = ".$this->_db->Quote($value)." ";
			if ($i != $nb -1)
				$sql .=",";
		}
		$sql .= " WHERE userid = ".$userid;
		$this->_db->setQuery( $sql);
		// echo $sql;exit();
		$this->_db->query();
	}
	
	function getProfile($userid)
	{
		$this->_db->setQuery("SELECT p.*,u.* FROM #__adsmanager_profile as p ".
									"LEFT JOIN #__users as u ON u.id = p.userid ".
									"WHERE userid=".(int)$userid);
		$user = $this->_db->loadObject();
					
		if (!isset($user)){
			$this->_db->setQuery("INSERT INTO #__adsmanager_profile (userid) VALUES ('".(int)$userid."')");
			$this->_db->query();
			$this->_db->setQuery("SELECT p.*,u.* FROM #__adsmanager_profile as p ".
								 "LEFT JOIN #__users as u ON p.userid = u.id ".
								 "WHERE userid = ".(int)$userid);
			$user = $this->_db->loadObject();
		}
				
		return $user;		
	}
}