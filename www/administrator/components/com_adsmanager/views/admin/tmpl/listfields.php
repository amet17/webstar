<form action="index.php" method="post" name="adminForm" id="adminForm">
  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
    <thead>
    <tr>
      <th width="2%" >#</td>
      <th width="3%" > <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($this->fields); ?>);" />
      </th>
      <th width="10%">
      	<?php echo JHTML::_('grid.sort',   JText::_('ADSMANAGER_TH_NAME'), 'f.name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
      </th>
      <th width="10%">
      	<?php echo JHTML::_('grid.sort',   JText::_('ADSMANAGER_TH_TITLE'), 'f.title', @$this->lists['order_Dir'], @$this->lists['order'] ); ?> 
      </th>
      <th width="10%">
      	<?php echo JHTML::_('grid.sort',   JText::_('ADSMANAGER_TH_TYPE'), 'f.type', @$this->lists['order_Dir'], @$this->lists['order'] ); ?> 
	</th>
      <th width="5%">
      	<?php echo JHTML::_('grid.sort',   JText::_('ADSMANAGER_TH_REQUIRED'), 'f.required', @$this->lists['order_Dir'], @$this->lists['order'] ); ?> 
      <th width="5%">
      	<?php echo JHTML::_('grid.sort',   'Published', 'f.published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
      </th>
      <th width="8%" nowrap="nowrap">
		<?php echo JHTML::_('grid.sort',   'Order by', 'f.ordering', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
		<?php if ($this->ordering) echo JHTML::_('grid.order',  $this->fields ); ?>
		</th>
	 </tr>
    </thead>
<?php
		$k = 0;
		for ($i=0, $n=count( $this->fields ); $i < $n; $i++) {
			$field =& $this->fields[$i];
?>
	<tbody>
    <tr class="<?php echo "row$k"; ?>">
      <td><?php echo $i+1?></td>
      <td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $field->fieldid; ?>" onClick="isChecked(this.checked);" /></td>
      <td> <a href="index.php?option=com_adsmanager&c=fields&task=edit&cid=<?php echo $field->fieldid; ?>">
        <?php echo $field->name; ?> </a> </td>
       <?php $field->title = JText::_($field->title);?>
      <td><?php echo $field->title; ?></td>
      <td><?php echo $field->type; ?></td>
      <td align='center' width="10%"><?php echo $this->displayRequired($field->required,"index.php?option=com_adsmanager&c=fields&task=required&cid[]=".$field->fieldid."&required=".!$field->required) ?></td>
      <td align='center' width="10%"><?php echo JHTML::_('grid.published', $field, $i ); ?></td> 
      <td class="order" nowrap="nowrap">
			<span><?php echo $this->pagination->orderUpIcon( $i, 1, 'orderup', 'Move Up', $this->ordering); ?></span>
			<span><?php echo $this->pagination->orderDownIcon( $i, $n, ($i != ($n-1)), 'orderdown', 'Move Down', $this->ordering ); ?></span>
			<?php $disabled = $this->ordering ?  '' : 'disabled="disabled"'; ?>
			<input type="text" name="order[]" size="5" value="<?php echo $field->ordering; ?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
		</td>
    </tr>
    <?php $k = 1 - $k; } ?>
  </tbody>
  <tfoot>
		<tr>
			<td colspan="8">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
  </table>
  <input type="hidden" name="option" value="com_adsmanager" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="c" value="fields" />
  <input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
  <input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
  <?php echo JHTML::_( 'form.token' ); ?>  
</form>