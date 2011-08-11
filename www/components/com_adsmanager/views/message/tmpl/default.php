<script language="javascript" type="text/javascript">
function submitbutton() {
	var form = document.forms["adminForm"];
	var r = new RegExp("[^0-9\.,]", "i");

	// do field validation
	if (form.email.value == "") {
		alert( "<?php echo JText::_('ADSMANAGER_REGWARN_EMAIL');?>" );
	} else {
		form.submit();
	}
}
</script>
<fieldset id="adsmanager_fieldset">
	<!-- titel -->
	<legend>
	<?php  echo JText::_('ADSMANAGER_FORM_MESSAGE_WRITE'); ?>
	</legend>
	<!-- titel -->
<!-- form -->
<?php $target = JRoute::_("index.php?option=com_adsmanager&task=sendmessage&Itemid=".$this->Itemid);?>
<form action="<?php echo $target;?>" method="post" name="adminForm" enctype="multipart/form-data">
		<!-- name -->
			<label for="name"><?php echo JText::_('ADSMANAGER_FORM_NAME'); ?></label>
			<?php echo "<input class='adsmanager_required' id='name' type='text' name='name' maxlength='50' value='".$this->user->name."' />"; ?>
		<!-- name -->
		<br />
		<!-- email -->
			<label for="email"><?php echo JText::_('ADSMANAGER_FORM_EMAIL'); ?></label>
			<?php echo "<input class='adsmanager_required' id='email' type='text' name='email' maxlength='50' value='".$this->user->email."' />"; ?>
		<!-- email -->
		<br />
		<!-- title -->
			<label for="title"><?php echo JText::_('ADSMANAGER_FORM_MESSAGE_TITLE'); ?></label>
			<?php echo "<input class='adsmanager_required' id='title' type='text' name='title' maxlength='50' value=\"".JText::_('ADSMANAGER_EMAIL_TITLE').htmlspecialchars(@$this->content->ad_headline)."\" />"; ?>
		<!-- title -->

		<br />
		<!-- body -->
			<label for="body"><?php echo JText::_('ADSMANAGER_FORM_MESSAGE_BODY'); ?></label>
			<?php  echo "<textarea class='adsmanager_required' id='body' name='body' cols='40' rows='10' wrap='VIRTUAL'></textarea>"; ?>
		<!-- body -->
		<br />
		<?php if ($this->conf->allow_attachement == 1) { ?>
		<!-- Attach -->
			<label for="body"><?php echo JText::_('ADSMANAGER_ATTACH_FILE'); ?></label>
			<input id="attach_file" type="file" name="attach_file" />
		<br />
		<?php } ?>
		<!-- buttons -->
			<label for="adid"></label>
			<input type="hidden" name="gflag" value="0">
			<?php
			echo "<input type='hidden' name='contentid' value='".@$this->content->id."' />";
			?>
			<input type="button" value=<?php echo JText::_('ADSMANAGER_SEND_EMAIL_BUTTON'); ?> onclick="submitbutton()" />
		<!-- buttons -->
	  <?php echo JHTML::_( 'form.token' ); ?>
	  </form>
	  <!-- form -->
</fieldset>