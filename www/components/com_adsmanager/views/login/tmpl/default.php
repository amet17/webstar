<form action="<?php echo $this->link_login; ?>" method="post" name="login" id="login">
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" class="contentpane">
<tr>
	<td colspan="2">
	<div class="componentheading">
	<?php echo JText::_('ADSMANAGER_LOGIN'); ?>
	</div>
	<div>
	<?php if(isset($this->image)){ // check if the image variable is set
		echo '<img src="'. $this->image  .'" align="right" hspace="10" alt="" />';
	} ?>
	<?php echo JText::_('ADSMANAGER_LOGIN_DESCRIPTION'); ?>
	<br /><br />
	</div>
	</td>
</tr>
<tr>
	<td align="center" width="50%">
		<br />
		<table>
		<tr>
			<td align="center">
			<?php echo JText::_('ADSMANAGER_USERNAME'); ?>
			<br />
			</td>
			<td align="center">
			<?php echo JText::_('ADSMANAGER_PASSWORD'); ?>
			<br />
			</td>
		</tr>
		<tr>
			<td align="center">
			<input name="username" type="text" class="inputbox" size="20" />
			</td>
			<td align="center">
			<?php if(substr($this->version,0,3) != '1.6'){ ?>
			<input name="passwd" type="password" class="inputbox" size="20" />
			<?php } else { ?>
			<input name="password" type="password" class="inputbox" size="20" />
			<?php } ?>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
			<br />
			<?php echo JText::_('ADSMANAGER_REMEMBER_ME'); ?>
			<input type="checkbox" name="remember" class="inputbox" value="yes" />
			<br />
			<a href="<?php echo $this->link_lostpassword; ?>">
			<?php echo JText::_('ADSMANAGER_LOST_PASSWORD'); ?>
			</a>
			<br />
			<?php echo JText::_('ADSMANAGER_NO_ACCOUNT'); ?>
			<a href="<?php echo $this->link_create; ?>">
			<?php echo JText::_('ADSMANAGER_CREATE_ACCOUNT');?>
			</a>
			<br /><br /><br />
			</td>
		</tr>
		</table>
	</td>
	<td>
	<div align="center">
	<input type="submit" name="submit" class="button" value="<?php echo JText::_('ADSMANAGER_BUTTON_LOGIN'); ?>" />
	</div>

	</td>
</tr>
<tr>
	<td colspan="2">
	<noscript>
	<?php echo JText::_('ADSMANAGER_CMN_JAVASCRIPT'); ?>
	</noscript>
	</td>
</tr>
</table>
<input type="hidden" name="op2" value="login" />
<?php echo $this->validate; ?>
<input type="hidden" name="message" value="0" />
<input type="hidden" name="force_session" value="1" />
<input type="hidden" name="return" value="<?php echo $this->return; ?>" />
<?php if(isset($this->special)) echo $this->special; ?>
</form>