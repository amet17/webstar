<?php 
if (isset($this->warning_text))
	echo $this->warning_text;
if (isset($this->error_text))
	echo $this->error_text;
echo JText::_('ADSMANAGER_RULESREAD');
?>
<script type="text/javascript">
function CaracMax(text, max)
{
	if (text.value.length >= max)
	{
		text.value = text.value.substr(0, max - 1) ;
	}
}


function submitbutton(mfrm) {
	var me = mfrm.elements;
	var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
	var r_num = new RegExp("[^0-9\.,]", "i");
	var r_email = new RegExp("^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]{2,}[.][a-zA-Z]{2,3}$" ,"i");

	var errorMSG = '';
	var iserror=0;
	
	<?php 
	if (function_exists("loadEditFormCheck")){
		loadEditFormCheck();
	}
	?>
	
	<?php if ($this->nbcats > 1)
	{
	?>
		var form = document.adminForm;
		var srcList = eval( 'form.selected_cats' );
		var srcLen = srcList.length;
		if (srcLen == 0)
		{
			errorMSG += <?php echo json_encode(JText::_('ADSMANAGER_FORM_CATEGORY')); ?>+" : "+<?php echo json_encode(JText::_('ADSMANAGER_REGWARN_ERROR')); ?>+'\n';
			srcList.style.background = "red";
			iserror=1;
		}
		else
		{
			for (var i=0; i < srcLen; i++) {
				srcList.options[i].selected = true;
			}
		}
	<?php
	}
	?>
	
	if (mfrm.username && (r.exec(mfrm.username.value) || mfrm.username.value.length < 3)) {
		errorMSG += mfrm.username.getAttribute('mosLabel').replace('&nbsp;',' ') + ' : '+<?php echo json_encode(sprintf( JText::_('ADSMANAGER_VALID_AZ09'), JText::_('ADSMANAGER_PROMPT_UNAME'), 4 )); ?>+'\n';
		mfrm.username.style.background = "red";
		iserror=1;
	} 
	if (mfrm.password && r.exec(mfrm.password.value)) {
		errorMSG += mfrm.password.getAttribute('mosLabel').replace('&nbsp;',' ') + ' : '+<?php echo json_encode(sprintf( JText::_('ADSMANAGER_VALID_AZ09'), JText::_('ADSMANAGER_REGISTER_PASS'), 6 )); ?>+'\n';
		mfrm.password.style.background = "red";
		iserror=1;
	}
	
	if (mfrm.email && !r_email.exec(mfrm.email.value) && mfrm.email.getAttribute('mosReq')) {
		errorMSG += mfrm.email.getAttribute('mosLabel').replace('&nbsp;',' ') + ' : '+<?php echo json_encode(JText::_('ADSMANAGER_REGWARN_EMAIL')); ?>+'\n';
		mfrm.email.style.background = "red";
		iserror=1;
	}
				
	// loop through all input elements in form
	for (var i=0; i < me.length; i++) {
	
		if ((me[i].getAttribute('test') == 'number' ) && (r_num.exec(me[i].value))) {
			errorMSG += me[i].getAttribute('mosLabel').replace('&nbsp;',' ') + ' : '+<?php echo json_encode(JText::_('ADSMANAGER_REGWARN_NUMBER')); ?>+'\n';
			iserror=1;
		}
		
		// check if element is mandatory; here mosReq="1"
		if ((me[i].getAttribute('mosReq') == 1)&&(me[i].style.visibility != 'hidden')) {
			if (me[i].type == 'radio' || me[i].type == 'checkbox') {
				var rOptions = me[me[i].getAttribute('name')];
				var rChecked = 0;
				if(rOptions.length > 1) {
					for (var r=0; r < rOptions.length; r++) {
						if (rOptions[r].checked) {
							rChecked=1;
						}
					}
				} else {
					if (me[i].checked) {
						rChecked=1;
					}
				}
				if(rChecked==0) {
					// add up all error messages
					errorMSG += me[i].getAttribute('mosLabel').replace('&nbsp;',' ') + ' : '+<?php echo json_encode(JText::_('ADSMANAGER_REGWARN_ERROR')); ?>+'\n';
					// notify user by changing background color, in this case to red
					me[i].style.background = "red";
					iserror=1;
				} 
			}
			if (me[i].value == '') {
				// add up all error messages
				errorMSG += me[i].getAttribute('mosLabel').replace('&nbsp;',' ') + ' : '+<?php echo json_encode(JText::_('ADSMANAGER_REGWARN_ERROR')); ?>+'\n';
				// notify user by changing background color, in this case to red
				me[i].style.background = "red";
				iserror=1;
			} 
		}
	}
	
	if(iserror==1) {
		alert(errorMSG);
		return false;
	} else {
		//Little hack to be able to return the selected_cats
		<?php if ($this->nbcats > 1) { ?>
			srcList.name = "selected_cats[]"; 
		<?php } ?>
		return true;
	}
}

function updateFields() {
	var form = document.adminForm;
	var singlecat = 0;
	var length = 0;
	
	if ( typeof(document.adminForm.category ) != "undefined" ) {
		singlecat = 1;
		length = 1;
	}
	else
	{
		length = form.selected_cats.length;
	}
	
	<?php
	foreach($this->fields as $field)
	{ 
		if (strpos($field->catsid, ",-1,") === false)
		{
			$name = $field->name;
			if (($field->type == "multicheckbox")||($field->type == "multiselect"))
				$name .= "[]";
		?>
		var input = document.getElementById('<?php echo $name;?>');
		var trzone = document.getElementById('tr_<?php echo $field->name;?>');
		if (((singlecat == 0)&&(length == 0))||
		    ((singlecat == 1)&&(document.adminForm.category.value == 0)))
		{
			input.style.visibility = 'hidden';
			trzone.style.visibility = 'hidden';
			trzone.style.display = 'none';
		}
		else
		{
			for (var i=0; i < length; i++) {
				
				
				var field_<?php echo $field->name;?> = '<?php echo $field->catsid;?>';
				var temp;
				if (singlecat == 0)
					temp = form.selected_cats.options[i].value;
				else
					temp = document.adminForm.category.value;
					
				var test = field_<?php echo $field->name;?>.indexOf( ","+temp+",", 0 );
				if (test != -1)
				{
					input.style.visibility = 'visible';
					trzone.style.visibility = 'visible';
					trzone.style.display = '';
					break;
				}
				else
				{
					input.style.visibility = 'hidden';
					trzone.style.visibility = 'hidden';
					trzone.style.display = 'none';
				}
			}
		}
	<?php
		}
	} 
	?>
}
</script>
<div id="adsmanager_writead_header">
	<div id="writead_header1"><?php echo JText::_('ADSMANAGER_HEADER1'); ?></div>
	<div id="writead_header2"><?php echo JText::_('ADSMANAGER_HEADER2'); ?></div>
</div>
<fieldset id="adsmanager_fieldset">
	<!-- titel -->
	<legend>
	<?php
	 if($this->isUpdateMode) {
	   echo JText::_('ADSMANAGER_CONTENT_EDIT');
	 }
	 else {
	   echo JText::_('ADSMANAGER_CONTENT_WRITE');
	 }
	 ?>
	</legend>
	<!-- titel -->
  <!-- form -->
   <!-- category -->
   <table border='0'>
   <tr name='category'>
	<td width="100"><?php echo JText::_('ADSMANAGER_FORM_CATEGORY'); ?></td>
	<td>
	<?php
	  $target = JROUTE::_("index.php?option=com_adsmanager&task=save&Itemid=".$this->Itemid); 
	  if ($this->nbcats == 1)
	  {
		$this->displaySingleCatChooser(@$this->content->id,$this->conf,"com_adsmanager",$this->cats,$this->catid,$this->Itemid);
		?>
		<form action="<?php echo $target;?>" method="post" name="adminForm" enctype="multipart/form-data" onsubmit="return submitbutton(this)">
		<?php
		echo "<input type='hidden' name='category' value='$this->catid' />";
	  }
	  else
	  {
		?>
		<form action="<?php echo $target;?>" method="post" name="adminForm" enctype="multipart/form-data" onsubmit="return submitbutton(this)">
		<?php
		if (!isset($this->content->catsid))
			$this->content->catsid = 0;
		$this->displayMultipleCatsChooser($this->content->catsid,$this->cats,$this->conf,"com_adsmanager",$this->Itemid);
	  }
	?>
    </td></tr>
	<!-- fields -->
	<?php
	if (($this->nbcats != 1)||(!isset($this->catid))||($this->catid != 0))
	{
		/* Submission_type == 0 -> Account Creation with ad posting */
		if ($this->account_creation == 1)
		{
			echo "<tr><td colspan='2'>".JText::_('ADSMANAGER_AUTOMATIC_ACCOUNT')."</td></tr>";
			echo "<tr><td>".JText::_('ADSMANAGER_UNAME')."</td>\n";
			if (isset($this->content->username))
			{
				$username = $this->content->username;
				$password = $this->content->password;
				$email = $this->content->email;
				$name = $this->content->name;
				$style = 'style="background-color:#ff0000"';
			}
			else
			{
				$username = "";
				$password = "";
				$email = "";
				$name =  "";
				$style = "";
			}
								
			if (isset($this->content->firstname))
				$firstname = $this->content->firstname;
			else
				$firstname = "";
			
			if (isset($this->content->middlename))
				$middlename = $this->content->middlename;
			else
				$middlename = "";
			
			if ($this->conf->comprofiler > 0)
			{
				include_once( JPATH_BASE .'/administrator/components/com_comprofiler/ue_config.php' );
				$namestyle = $ueConfig['name_style'];
			}
			else
				$namestyle = 1;
				
			echo "<td><input $style class='adsmanager_required' mosReq='1' id='username' type='text' mosLabel='".htmlspecialchars(JText::_('ADSMANAGER_UNAME'),ENT_QUOTES)."' name='username' size='20' maxlength='20' value='$username' /></td></tr>\n"; 
			
			echo "<tr><td>".JText::_('ADSMANAGER_PASSWORD')."</td>\n";
			echo "<td><input $style class='adsmanager_required' mosReq='1' id='password' type='password' mosLabel='".htmlspecialchars(JText::_('ADSMANAGER_PASS'),ENT_QUOTES)."' name='password' size='20' maxlength='20' value='$password' />\n</td></tr>"; 
			$emailField = false;
			$nameField = false;
			for($i = 0,$total = count($this->fields);$i < $total;$i++)
			{
				if (($this->fields[$i]->name == "email")&&((strpos($this->fields[$i]->catsid, ",$this->catid,") !== false)||(strpos($this->fields[$i]->catsid, ",-1,") !== false)))
				{
					$emailField = true;
					// Force required 
					$this->fields[$i]->required = 1;
				}
				else if (($this->fields[$i]->name == "name")&&((strpos($this->fields[$i]->catsid, ",$this->catid,") !== false)||(strpos($this->fields[$i]->catsid, ",-1,") !== false)))
				{
					$nameField = true;
					// Force required 
					$this->fields[$i]->required = 1;
				}
				else if (($namestyle >= 2)&&($this->fields[$i]->name == "firstname")&&((strpos($this->fields[$i]->catsid, ",$this->catid,") !== false)||(strpos($this->fields[$i]->catsid, ",-1,") !== false)))
				{
					$firstnameField = true;
					// Force required 
					$this->fields[$i]->required = 1;
				}
				else if( ($namestyle == 3)&&($this->fields[$i]->name == "middlename")&&((strpos($this->fields[$i]->catsid, ",$this->catid,") !== false)||(strpos($this->fields[$i]->catsid, ",-1,") !== false)))
				{
					$middlenameField = true;
					// Force required 
					$this->fields[$i]->required = 1;
				}			
			}
			if (($namestyle >= 2)&&($firstnameField == false))
			{
				echo "<tr><td>".JText::_('ADSMANAGER_FNAME')."</td>\n";
				echo "<td><input $style class='adsmanager_required' mosReq='1' id='firstname' type='text' mosLabel='".htmlspecialchars(JText::_('ADSMANAGER_FNAME'),ENT_QUOTES)."' name='firstname' size='20' maxlength='20' value='$firstname' /></td></tr>\n"; 
			}
			if ( ($namestyle == 3)&&($middlenameField == false))
			{
				echo "<tr><td>".JText::_('ADSMANAGER_MNAME')."</td>\n";
				echo "<td><input $style class='adsmanager_required' mosReq='1' id='middlename' type='text' mosLabel='".htmlspecialchars(JText::_('ADSMANAGER_MNAME'),ENT_QUOTES)."' name='middlename' size='20' maxlength='20' value='$middlename' /></td></tr>\n"; 
			}
			if ($nameField == false)
			{
				echo "<tr><td>".JText::_('_NAME')."</td>\n";
				echo "<td><input $style class='adsmanager_required' mosReq='1' id='name' type='text' mosLabel='".htmlspecialchars(JText::_('_NAME'),ENT_QUOTES)."' name='name' size='20' maxlength='20' value='$name' /></td></tr>\n"; 
			}
			if ($emailField == false)
			{
				echo "<tr><td>".JText::_('_EMAIL')."</td>\n";
				echo "<td><input $style class='adsmanager_required' mosReq='1' id='email' type='text' mosLabel='".htmlspecialchars(JText::_('_EMAIL'),ENT_QUOTES)."' name='email' size='20' maxlength='20' value='$email' /></td></tr>\n"; 
			}
		}
		
		/* Display Fields */
		foreach($this->fields as $field)
		{
			echo $this->field->showFieldForm($field,$this->content,$this->default);
		}	
		?>
		<!-- fields -->
		<!-- image -->
		<?php	
		if ($this->conf->nb_images > 0)
		{
			echo "<tr><td colspan='2'>".JText::_('ADSMANAGER_FORM_AD_IMAGE_TEXT'); 
			echo "</td></tr>";
		}

		for($i = 1; $i < $this->conf->nb_images + 1; $i++)
		{
			$ext_name = chr(ord('a')+$i-1);
			?>
			<tr name="ad_picture<?php echo $i;?>"><td><?php echo JText::_('ADSMANAGER_FORM_AD_PICTURE')." ".$i; ?></td>
			<td><input id="ad_picture<?php echo $i;?>" type="file" name="ad_picture<?php echo $i;?>" />
			<?php
			if ($this->isUpdateMode) {
				$pic = JPATH_BASE."/images/com_adsmanager/ads/".$this->content->id.$ext_name."_t.jpg";
				if ( file_exists( $pic)) {
					echo "<img src='".$this->baseurl."/images/com_adsmanager/ads/".$this->content->id.$ext_name."_t.jpg?time=".time()."' align='top' border='0' alt='image".$this->content->id."' />";
					echo "<input type='checkbox' name='cb_image$i' value='delete' />".JText::_('ADSMANAGER_CONTENT_DELETE_IMAGE');
				}
			}
			echo "</td></tr>";
		}
		
		if (function_exists("editPaidAd")){
			editPaidAd($this->content,$this->isUpdateMode,$this->conf);
		}
		?>
		<!-- buttons -->
		<input type="hidden" name="gflag" value="0" />
		<?php
		if (isset($this->content->date_created))
			echo "<input type='hidden' name='date_created' value='".$this->content->date_created."' />";	
			
		echo "<input type='hidden' name='isUpdateMode' value='".$this->isUpdateMode."' />";
		echo "<input type='hidden' name='id' value='".@$this->content->id."' />";
		?>
		<tr>
		<td>
		<input type="submit" value="<?php echo JText::_('ADSMANAGER_FORM_SUBMIT_TEXT'); ?>" />
		</td>
		<td>
		<input type="button" onclick='window.location="<?php echo JROUTE::_("index.php?option=com_adsmanager&view=list&Itemid=".$this->Itemid); ?>"' value="<?php echo JText::_('ADSMANAGER_FORM_CANCEL_TEXT'); ?>" />
		</td>
		</tr>
		<!-- buttons -->
	<?php
	}
	?>
  <?php echo JHTML::_( 'form.token' ); ?>
  </form>
  <!-- form -->
</table>
</fieldset>
<script type="text/javascript">
updateFields();
</script>