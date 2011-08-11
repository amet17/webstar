<script type="text/javascript">
<?php if(version_compare(JVERSION,'1.6.0','>=')){ ?>
Joomla.submitbutton = function(pressbutton) {
<?php } else { ?>
function submitbutton(pressbutton) {
<?php } ?>
	   if (pressbutton == 'cancel') {
		   submitform(pressbutton);	
		   return;
	   }
	   var form = document.adminForm;
	   var iserror = 0;
	   var errorMSG = '';
		
	   <?php if ($this->nbcats > 1) { ?>
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
		<?php } ?>
		
		if(iserror==1) {
			alert(errorMSG);
		} else {
		
			<?php
			if (function_exists("loadEditFormCheck")) {
				loadEditFormCheck("admin");
			}
			else
			{
		   ?>
		   <?php if ($this->nbcats > 1) { ?>
			srcList.name = "selected_cats[]"; 
		   <?php } ?>
		   submitform(pressbutton);
		   <?php
		   }
		   ?>
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
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
<tr>
<td><?php echo JText::_('ADSMANAGER_FORM_CATEGORY');?></td>
<td>
<?php
if ($this->nbcats == 1)
{
	if ($this->catid != 0)
		$catid = $this->catid;
	else if (isset($this->content->cats[0]))
		$catid = $this->content->cats[0]->catid;
	else 
		$catid = 0;
	//$catid = intval( mosGetParam( $_GET, 'catid', $catid ) );
	$this->displaySingleCatChooser(@$this->content->id,$this->conf,"com_adsmanager",$this->cats,$catid);
	if ($catid == 0)
		return;
	?>
	<form action="index.php" method="post" name="adminForm" id="adminForm" class="adminForm" enctype="multipart/form-data">
	<?php
	echo "<input type='hidden' name='category' value='$catid' />";
	
}
else
{
	?>
	<form action="index.php" method="post" name="adminForm" id="adminForm" class="adminForm" enctype="multipart/form-data">
	<?php
	$this->displayMultipleCatsChooser(@$this->content->catsid,$this->cats,$this->conf,"com_adsmanager");
}
?>
</td>
<td>&nbsp;</td>
</tr>
<?php if (isset($this->content->userid)) { $userid = $this->content->userid; } else { $userid = $this->userid; } ?>
<tr>
<td><?php echo JText::_('ADSMANAGER_TH_USER'); ?></td>
<td>
<select name="userid" id="userid">
<option value=""></option>
<?php foreach($this->users as $user) { ?>
<option value="<?php echo $user->id;?>" <?php if ($user->id == $userid) { echo "selected"; } ?>><?php echo $user->username; ?></option>
<?php } ?>
</select>
</td>
<td>&nbsp;</td>
</tr>

<?php
foreach($this->fields as $field)
{
	echo $this->field->showFieldForm($field,$this->content,$this->default);
}
?>
<?php
for($i = 1; $i < $this->conf->nb_images + 1; $i++)
{
	$ext_name = chr(ord('a')+$i-1);
	?>
	<tr>
	<td><?php echo JText::_('ADSMANAGER_FORM_AD_PICTURE')." ".$i; ?></td>
	<td>
	<input type="file" name="ad_picture<?php echo $i;?>"/>
	<br />
	<?php 
	   $pic = JPATH_SITE."/images/com_adsmanager/ads/".@$this->content->id.$ext_name."_t.jpg";
	   if (file_exists($pic)) 
	   {
		 echo '<img src="../images/com_adsmanager/ads/'.@$this->content->id.$ext_name.'_t.jpg?time='.time().'"/>';
		 echo "<input type='checkbox' name='cb_image$i' value='delete'>".JText::_('ADSMANAGER_CONTENT_DELETE_IMAGE');
	   }
	?>
	<br />
	</td>
	<td>&nbsp;</td>
	</tr>
	<?php
}
?>

<tr>
<td><?php echo JText::_('ADSMANAGER_TH_PUBLISH'); ?></td>
<td>
<select name="published" id="published">
<option value="1" <?php if (@$this->content->published == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_PUBLISH'); ?></option>
<option value="0" <?php if (@$this->content->published == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_NO_PUBLISH'); ?></option>
</select>
</td>
<td>&nbsp;

</td>
</tr>


<?php if (isset($this->content->date_created)) { $date_created = $this->content->date_created; } else { $date_created = date("Y-m-d"); } ?>

<?php
if (function_exists("editPaidAd")){
	editPaidAd($this->content,$this->isUpdateMode,$this->conf,"admin");
}?>
</table>
<input type="hidden" name="id" value="<?php echo @$this->content->id; ?>" />
<input type="hidden" name="option" value="com_adsmanager" />
<input type="hidden" name="c" value="contents" />
<input type="hidden" name="task" value="" />
</form>
<script type="text/javascript">
updateFields();
</script>