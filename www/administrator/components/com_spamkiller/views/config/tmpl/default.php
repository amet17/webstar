<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
	JToolBarHelper::title(   JText::_( 'Configuration' ), 'generic.png' );
	JToolBarHelper::save('save_config');	
	JToolBarHelper::cancel('cancel_spamkiller');	
	$editor = & JFactory::getEditor() ;
?>
<form action="index.php" method="post" name="adminForm">	
	<table class="admintable" style="width:100%;">
		<tr>
			<td class="key" width="18%">
				<?php echo JText::_('Special user IDs'); ?>
			</td>
			<td>
				<input type="text" class="inputbox" name="special_user_ids" value="<?php echo $this->config->special_user_ids; ?>" size="50" />
			</td>
			<td>
				Enter ids of users which you don't need the system to check for spam (for example, site administrator....). Multple users is possible, comma seperated. 
			</td>
		</tr>
		<tr>
			<td class="key" width="18%">
				<?php echo JText::_('Akismet API key'); ?>
			</td>
			<td>
				<input type="text" class="inputbox" name="akismet_api_key" value="<?php echo $this->config->akismet_api_key; ?>" size="50" />
			</td>
			<td>
				Akismet API key. You can register for a free API Key at <a href="http://akismet.com/personal" target="_blank">http://akismet.com/personal</a>.	 
			</td>
		</tr>
		<tr>
			<td class="key" width="18%">
				<?php echo JText::_('Notification emails:'); ?>
			</td>
			<td>
				<input type="text" class="inputbox" name="notification_emails" value="<?php echo $this->config->notification_emails; ?>" size="70" />
			</td>
			<td>
				Enter emails of users which you want to receive notification when someone post a spam message. Multiple email is possible, comma seperated. 
			</td>
		</tr>					
		<tr>
			<td  class="key" style="width:18%">
				<?php echo JText::_('Send email to user'); ?>
			</td>
			<td width="50%">
				<?php echo $this->lists['send_email_to_user'] ; ?>
			</td>
			<td>
				If set to Yes, an email will be sent to user when the system detect that he is spaming forum. 
			</td>
		</tr>						
		<tr>
			<td class="key" width="18%">
				<?php echo JText::_('Send email to administrator'); ?>
			</td>
			<td>
				<?php echo $this->lists['send_email_to_administrator']; ?>
			</td>
			<td>
				If set to Yes, an email will be sent to administrator when a new spam message posted.
			</td>
		</tr>
		<tr>
			<td class="key" width="18%">
				<?php echo JText::_('Administrator email subject'); ?>
			</td>
			<td>
				<input type="text" class="inputbox" name="admin_email_subject" value="<?php echo $this->config->admin_email_subject; ?>" size="80" />
			</td>
			<td>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td class="key" width="18%">
				<?php echo JText::_('Admin email body'); ?>
			</td>
			<td>
				<?php echo $editor->display( 'admin_email_body',  $this->config->admin_email_body , '100%', '250', '75', '8' ) ;?>
			</td>
			<td>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td class="key" width="18%">
				<?php echo JText::_('User email subject'); ?>
			</td>
			<td>
				<input type="text" class="inputbox" name="user_email_subject" value="<?php echo $this->config->user_email_subject; ?>" size="80" />
			</td>
			<td>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('User email body'); ?>														
			</td>
			<td>			
				<?php echo $editor->display( 'user_email_body',  $this->config->user_email_body , '100%', '250', '75', '8' ) ;?>							
			</td>
			<td>
				<strong>The message displayed to users when the user receives</strong>
			</td>
		</tr>		
		<tr>
			<td class="key">
				<?php echo JText::_('Added to trusted when no spam detected'); ?>												
			</td>
			<td>
				<?php echo $this->lists['add_to_trusted_list']; ?>					
			</td>
			<td>
				<strong>If set to yes, when a user makes a forum post and there is no spam detected, he will be added to trusted user list. Later, when he makes new forum post, no checking is require.</strong>
			</td>
		</tr>	
		<tr>
			<td class="key">
				<?php echo JText::_('Add user to block list when spam detected'); ?>												
			</td>
			<td>
				<?php echo $this->lists['add_to_block_list']; ?>					
			</td>
			<td>
				<strong>If set to yes, when a user makes a forum post and there is no spam detected, he will be added to trusted user list. Later, when he makes new forum post, no checking is require.</strong>
			</td>
		</tr>	
		<tr>
			<td class="key">
				<?php echo JText::_('Block user when spam detected'); ?>												
			</td>
			<td>
				<?php echo $this->lists['block_spammer']; ?>					
			</td>
			<td>
				<strong>If set to yes, when a user makes a forum post and spam is detected, his account will be blocked and later they cannot login to make any new forum posts</strong>
			</td>
		</tr>								
	</table>	
	<input type="hidden" name="option" value="com_spamkiller" />
	<input type="hidden" name="task" value="" />	
</form>