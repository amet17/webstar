<script language="javascript" type="text/javascript">
function submitbutton() {
	var form = document.mosUserForm;
	var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

	// do field validation
	if (form.name.value == "") {
		alert( "<?php echo JText::_('ADSMANAGER_REGWARN_NAME');?>" );
	} else if (form.username.value == "") {
		alert( "<?php echo JText::_('ADSMANAGER_REGWARN_UNAME');?>" );
	} else if (r.exec(form.username.value) || form.username.value.length < 3) {
		alert( "<?php printf( JText::_('ADSMANAGER_VALID_AZ09'), JText::_('ADSMANAGER_PROMPT_UNAME'), 4 );?>" );
	} else if (form.email.value == "") {
		alert( "<?php echo JText::_('ADSMANAGER_REGWARN_EMAIL');?>" );
	} else if ((form.password.value != "") && (form.password.value != form.verifyPass.value)){
		alert( "<?php echo JText::_('ADSMANAGER_REGWARN_VPASS2');?>" );
	} else if (r.exec(form.password.value)) {
		alert( "<?php printf( JText::_('ADSMANAGER_VALID_AZ09'), JText::_('ADSMANAGER_REGISTER_PASS'), 6 );?>" );
	} else {
		form.submit();
	}
}
</script>
<?php $target = JRoute::_("index.php?option=com_adsmanager&task=saveprofile&Itemid=".$this->Itemid); ?>
<form action="<?php echo $target; ?>" method="post" name="mosUserForm">
<div class="componentheading">
<?php echo "<div class=\"adsmanager_list_title\" width=\"100%\">".JText::_('ADSMANAGER_EDIT_PROFILE')."</div>"; ?>
</div>
<br />
<table cellpadding="5" cellspacing="0" border="0" width="100%">
<tr>
	<td>
		<?php echo JText::_('ADSMANAGER_UNAME'); ?>
	</td>
	<td>
		<input class="inputbox" type="text" name="username" value="<?php echo $this->user->username;?>" size="40" />
	</td>
</tr>
<?php if(function_exists("showBalance")){
    showBalance($this->user->id);
} ?>
<tr>
	<td colspan="2">
		<?php echo JText::_('ADSMANAGER_PROFILE_PASSWORD'); ?>
	</td>
</tr>
<tr>
	<td>
		<?php echo JText::_('ADSMANAGER_PASSWORD'); ?>
	</td>
	<td>
		<input class="inputbox" type="password" name="password" autocomplete="off" value="" size="40" />
	</td>
</tr>
<tr>
	<td>
		<?php echo JText::_('ADSMANAGER_VPASS'); ?>
	</td>
	<td>
		<input class="inputbox" type="password" name="verifyPass" autocomplete="off" size="40" />
	</td>
</tr>
<tr>
	<td colspan="2">
		<?php echo JText::_('ADSMANAGER_PROFILE_CONTACT'); ?>
	</td>
</tr>
<tr>
	<td width=85>
		<?php echo JText::_('ADSMANAGER_PROFILE_NAME'); ?>
	</td>
	<td>
		<input class="inputbox" type="text" name="name" value="<?php echo $this->user->name;?>" size="40" />
	</td>
</tr>
<tr>
	<td>
		<?php echo JText::_('ADSMANAGER_FORM_EMAIL'); ?>
	</td>
	<td>
		<input class="inputbox" type="text" name="email" value="<?php echo $this->user->email;?>" size="40" />
	</td>
</tr>
<?php
$user = $this->user;
if (isset($this->fields)) {
foreach($this->fields as $f)
{
	if (($f->name != "name")&&($f->name != "email")){
		$value = "\$user->".$f->name;
		eval("\$value = \"$value\";");
		$value = JText::_($value);
	?>
	<tr>
		<td>
			<?php 
				echo JText::_($f->title). "\n";
			 ?>
		</td>
		<td>
			<input class="inputbox" type="text" name="<?php echo $f->name;?>" value="<?php echo $value;?>" size="40" />
		</td>
	</tr>
	<?php }
}
}
?>
<tr>
	<td colspan="2">
		<input class="button" type="button" value="<?php echo JText::_('ADSMANAGER_FORM_SUBMIT_TEXT'); ?>" onclick="submitbutton()" />
	</td>
</tr>
</table>
<?php echo JHTML::_( 'form.token' ); ?>
</form>