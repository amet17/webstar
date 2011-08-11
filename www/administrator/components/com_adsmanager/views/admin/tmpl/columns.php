<br />
<form action="index.php" method="post" name="adminForm" id="adminForm">
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
<tr>
<?php
for($i=0,$nb=count($this->columns);$i < $nb ;$i++) {
?>
	<td>
	<table>
		<tr>
			<td>
			<?php $name = $this->columns[$i]->name; if (isset($name)) { $name = JText::_($name); } ?>
			<a href="index.php?option=com_adsmanager&c=columns&task=edit&cid[]=<?php echo $this->columns[$i]->id; ?>"><?php echo $name;?></a>
			</td>
			<td>
			<input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $this->columns[$i]->id; ?>" onclick="isChecked(this.checked);" />
			</td>
		</tr>
		<tr>
		<td>
			<select multiple='multiple'>
			<?php	
			if (isset($this->fColumns[$this->columns[$i]->id])) {
			foreach($this->fColumns[$this->columns[$i]->id] as $field)
			{
				echo '<option value="'.$field->fieldid.'">'.$field->name.'</option>';
			}
			}
			?>
			</select>
		</td>
		</tr>
	</table>
	</td>
<?php
}
?>
</tr>
</table>

<input type="hidden" name="option" value="com_adsmanager" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="c" value="columns" />
<input type="hidden" name="boxchecked" value="0" />
</form> 