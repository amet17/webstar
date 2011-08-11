<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );
/**
 * Spam Killer system plugin
 */
class plgSystemSpamkiller extends JPlugin
{     
	/**
	 * Constructor function
	 *
	 * @param object $subject
	 * @param object $config
	 * @return plgSystemSpamkiller
	 */   
	function plgSystemSpamkiller( &$subject, $config )
    {
		parent::__construct( $subject, $config );      
    }       
    /**
     * Use this to check the spam
     *
     * @return boolean
     */
	function onAfterDispatch()
    {
    	global $mainframe;        	
      	if ($mainframe->isAdmin())
      		return ;
      	$db=JFactory::getDBO();
		$user = & JFactory::getUser() ;
		$action = JRequest::getVar('action', '') ;
		$option = JRequest::getCmd('option', '');
		$do = JRequest::getVar('do', '') ;
		require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_spamkiller'.DS.'helper'.DS.'helper.php';
		$config = SpamkillerHelper::getConfig() ;			
		$userId = $user->get('id');		
		if ($option == 'com_kunena' && ($action == 'post' || $do == 'editpostnow')) {													
			$user_special= explode(',', $config->special_user_ids);					
			JArrayHelper::toInteger($user_special);						  												
			if (in_array($userId,$user_special)) 
				return ;
			//Check if the current user is in trusted list
			$sql = 'SELECT user_id FROM #__sk_users WHERE block=0' ;
			$db->setQuery($sql) ;
			$trustedIds = $db->loadResultArray();
			if (in_array($userId, $trustedIds))
				return ;					
			$sql = "SELECT COUNT(id) FROM #__sk_users WHERE block=1 AND user_id = '$userId'";
			$db->setQuery($sql);
			$db->Query();
		    $user_block = $db->loadResult();
    		if ($user_block) {		    	  
    			if (isset($_POST['id'])) {
    				$messageId = $_POST['id'] ;	
    			} else {
    				$sql = 'SELECT MAX(id) FROM #__fb_messages WHERE userid='.$userId ;
	    	    	$db->setQuery($sql) ;
	    	    	$messageId = $db->loadResult();	
    			}	    	    
    	   		if ($messageId) {
	    	  	 	$db->setQuery("INSERT INTO #__sk_messages (message_id) VALUES ($messageId)");
		     		$db->query();
		     		$sql = 'UPDATE #__fb_messages SET hold = 1 WHERE id='.$messageId;
					$db->setQuery($sql);
					$db->query();				    		
    	   		}				 				 				    					   
	       		if($config->block_spammer == 1){ 
					$user->block = 1;
					$user->save();    
			    }				    	
    	   		return ;
			}				    				     				    
			require_once JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'spamkiller'.DS.'Akismet.class.php';
		   	$apiKey = $config->akismet_api_key;					
			$forumUrl = JURI::base().'index.php?option=com_kunena';					
			$akismet = new Akismet($forumUrl ,$apiKey);									
			$akismet->setCommentAuthor($user->get('name'));										
			$akismet->setCommentAuthorEmail($user->get('email'));					
			$url = '';	
			$akismet->setCommentAuthorURL($url);																				
			$akismet->setCommentContent(JRequest::getVar('message', '', 'post'));
			$akismet->setPermalink($forumUrl);					
			if($akismet->isCommentSpam()) {
				if (isset($_POST['id'])) {
					$messageId = $_POST['id'] ;
				} else {
					$sql = 'SELECT MAX(id) FROM #__fb_messages WHERE userid='.$userId ;
	    	   		$db->setQuery($sql) ;
	    	   		$messageId = $db->loadResult();	
				}				
				$sql = 'UPDATE #__fb_messages SET hold = 1 WHERE id='.$messageId;
				$db->setQuery($sql);
				$db->query();		
				//Add this message to list of blocked message
				$db->setQuery("INSERT INTO #__sk_messages (message_id) VALUES ($messageId)");
		     	$db->query();								
				if ($config->add_to_block_list) {
					//Check to see whether this user existed in the system
					$sql = 'SELECT COUNT(id) FROM #__sk_users WHERE user_id='.$userId ;
					$db->setQuery($sql) ;
					$total = $db->loadResult();
					if ($total) {
						$sql = 'UPDATE #__sk_users SET block=1 WHERE user_id='.$userId;						
					} else {
						$sql = "INSERT INTO #__sk_users(id, user_id, block) values (NULL, $user->id, 1)";	
					}
					$db->setQuery($sql);					
			    	$db->query();					    
				}					    							    														
                $this->_sendEmail();   						
				if($config->block_spammer == 1){ 
				 	 $user->block = 1;
				 	 $user->save();   
				 	 global $mainframe ;
				 	 $mainframe->logout() ; 
				}
			} else if($config->add_to_trusted_list){
				$db = & JFactory::getDBO() ;
				$sql = 'SELECT COUNT(id) FROM #__sk_users WHERE user_id='.$userId ;
				$db->setQuery($sql) ;
				$total = $db->loadResult();
				if ($total) {
					$sql = 'UPDATE #__sk_users SET block = 0 WHERE user_id='.$userId;						
				} else {
					$sql = "INSERT INTO #__sk_users(id, user_id, block) values (NULL, $user->id, 0)";	
				}				 									
				$db->setQuery($sql) ;		
				$db->query();									
			}
			return;        
		}			     			
	}				  
	/**
	 * Send email to user when someone 
	 *
	 */            
    function _sendEmail()
    {                
     	$cfg = new JConfig();
     	$mailfrom = $cfg->mailfrom;
     	$fromname = $cfg->fromname;     	
     	$user = & JFactory::getUser() ;
     	require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_spamkiller'.DS.'helper'.DS.'helper.php';
		$config = SpamkillerHelper::getConfig() ;
		//Send email to user
		if ($config->send_email_to_user == 1){				
			$subject = $config->user_email_subject ;			
		    $body = stripslashes($config->user_email_body);
		    $body = str_replace('[username]', $user->get('username'), $body) ;		    		    
			$email = $user->get('email') ;
			JUtility::sendMail($mailfrom, $fromname, $email, $subject, $body, 1) ;
		}			
		//Send email to administrator
		if ($config->send_email_to_administrator== 1)
		{
			$subject_admin = $config->admin_email_subject ;			
		    $body_admin = stripslashes($config->admin_email_body);
		    $body_admin = str_replace('[username]', $user->get('username'), $body_admin) ;
		    if ($config->notification_emails) {
		    	$emails = $config->notification_emails ;		    
		    } else {
		    	$emails = $mailfrom ;
		    }
		    $emails = explode(',', $emails) ;
		    for ($i = 0 , $n = count($emails) ; $i < $n; $i++) {
		    	$email = $emails[$i] ;
		    	JUtility::sendMail($mailfrom, $fromname, $email, $subject_admin, $body_admin, 1) ;
		    }
		}
    }          
}