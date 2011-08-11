<form action="index.php" method="post" name="adminForm" id="adminForm">
<table class="adminlist">
<thead>
<tr>
<th width="2%"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->list); ?>);" /></th>
<th width="2%"><?php echo JText::_('Id') ?></th>
<th width="30%"><?php echo JText::_('ADSMANAGER_TH_CATEGORY'); ?></th>
<th width="5%"><?php echo JText::_('ADSMANAGER_TH_IMAGE');?></th>
<th width="5%"><?php echo JText::_('ADSMANAGER_TH_ADS');?></th>
<th width="8%" nowrap="nowrap">
<?php echo JText::_('ADSMANAGER_ORDER_BY_TEXT'); ?>
<?php if ($this->ordering) echo JHTML::_('grid.order',  $this->list ); ?>
</th>
<th width="40%">
<?php echo JText::_('ADSMANAGER_TH_PUBLISH'); ?>
</th>
</tr>
</thead>
<tbody>
<?php
$num = 0;
foreach ($this->list as $key => $row) {
	 ?>
	 <tr class="row<?php echo ($num & 1); ?>">
	 <td><input type="checkbox" id="cb<?php echo $num;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>

	<td><?php echo $row->id; ?></td>
	<td>
		<a href="<?php echo "index.php?option=com_adsmanager&c=categories&task=edit&id=".$row->id ?>"><?php echo $row->treename ?></a>
	</td>
	<td>
	<?php 
		$pict = JPATH_SITE."/images/com_adsmanager/categories/".$row->id."cat_t.jpg";
		if (file_exists($pict)) 
		{
		  echo '<img src="../images/com_adsmanager/categories/'.$row->id.'cat_t.jpg?time='.time().'"/>';
		}
		else
		{
		  echo '<img src="../components/com_adsmanager/images/default.gif"/>';
		}
	?>
	</td>
	<td align='center'>
		<a href="<?php echo "index.php?option=com_adsmanager&c=contents&catid=".$row->id;?>">
			<img src="../includes/js/ThemeOffice/mainmenu.png"/>
		</a>
	</td>
	<td class="order" nowrap="nowrap" align='center'>
	<span><?php echo $this->pagination->orderUpIcon( $num, $row->parent == 0 || $row->parent == @$this->list[$key-1]->parent, 'orderup', 'Move Up', $this->ordering); ?></span>
	<span><?php echo $this->pagination->orderDownIcon( $num, $this->total, $row->parent == 0 || $row->parent == @$this->list[$key+1]->parent, 'orderdown', 'Move Down', $this->ordering ); ?></span>
	<?php $disabled = $this->ordering ?  '' : 'disabled="disabled"'; ?>
	<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
	</td>
	<td align='center'><?php echo JHTML::_('grid.published', $row, $num ); ?></td>
	</tr>
	<?php
	$num++;
}
?>
</tbody>
<tfoot>
		<tr>
			<td colspan="7">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
</table>

<input type="hidden" name="option" value="com_adsmanager" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="c" value="categories" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form> 