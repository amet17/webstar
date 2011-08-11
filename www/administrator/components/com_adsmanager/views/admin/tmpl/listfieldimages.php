<form enctype="multipart/form-data" action="index.php" method="post" name="filename">
	<table class="adminform">
	<tr>
		<th>
		<?php echo JText::_('ADSMANAGER_UPLOAD_IMAGE_FILE'); ?>
		</th>
	</tr>
	<tr>
		<td align="left">
		<?php echo JText::_('ADSMANAGER_IMAGE_FILE')?>
		<input class="text_area" name="userfile" type="file" size="70"/>
		<input class="button" type="submit" value="<?php echo JText::_('ADSMANAGER_UPLOAD_IMAGE_FILE')?>" />
		</td>
	</tr>
	</table>

	<input type="hidden" name="task" value="upload"/>
	<input type="hidden" name="c" value="fieldimages"/>
	<input type="hidden" name="option" value="com_adsmanager"/>
	</form>
	<br />
	<form action="index.php" method="post" name="adminForm" id="adminForm">
	<table class="adminlist">
	<thead>
	<tr>
		<th>
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->fieldimages); ?>);" />
		</th>
		<th>
		<?php echo JText::_('Image')?>
		</th>
		<th>
		<?php echo JText::_('Name')?>
		</th>
	</tr>
	</thead>
	<?php
	if(isset($this->fieldimages))
	{
		$k = 0;
		$i=0;
		foreach($this->fieldimages as $fieldimage) {
		?>
		<tr class="row<?php echo $k; ?>">
		<td align="center">
			<input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $fieldimage;?>" onclick="isChecked(this.checked);" />
		</td>
		<td>
			<img src="<?php echo $this->baseurl."/images/com_adsmanager/fields/$fieldimage";?>" border="1" />
		</td>
		<td>
		<?php	echo $fieldimage; ?>
		</td>
		</tr>
		<?php
		$k = !$k;
		$i++;
		}
	}
	?>
	</table>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="c" value="fieldimages"/>
	<input type="hidden" name="option" value="com_adsmanager"/>
	<input type="hidden" name="boxchecked" value="0" />
</form>