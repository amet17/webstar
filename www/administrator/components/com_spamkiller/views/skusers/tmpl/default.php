<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<?php
	// Set toolbar items for the page
	JToolBarHelper::title(   JText::_( 'Spammers Management' ), 'generic.png' );		
	JToolBarHelper::deleteList('Do you want to remove selected spammers ?', 'remove_skusers',JText::_('Delete'));
	JToolBarHelper::publishList('skusers_publish',JText::_('Enable'));	
	JToolBarHelper::cancel('cancel', JText::_('Cancel'));		
?>
<form action="index.php" method="post" name="adminForm">
<table>
<tr>
	<td align="left" width="100%">
		<?php echo JText::_( 'Filter' ); ?>:
		<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />		
		<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
		<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>		
	</td>	
</tr>
</table>
<div id="editcell">
	<table class="adminlist">
	<thead>
		<tr>
			<th width="1%">
				<?php echo JText::_( 'NUM' ); ?>
			</th>
			<th width="1%">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			<th style="text-align: left;">
				<?php echo JHTML::_('grid.sort', JText::_('User'), 'b.username', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>								
			<th width="3%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',  JText::_('ID'), 'a.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="4">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
		$checked 	= JHTML::_('grid.id',   $i, $row->id );							
		?>
		
		<tr class="<?php echo "row$k"; ?>">
			<td align="center">
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td align="center">
				<?php echo $checked; ?>
			</td>	
			<td align="left">
				<?php echo $row->username; ?>
			</td>			
			<td align="center">			
				<?php echo $row->id; ?>
			</td>
		</tr>
			<?php
		$k = 1 - $k;
	}
	?>	   
	</tbody>
	</table>
	</div>
	<input type="hidden" name="option" value="com_spamkiller" />
	<input type="hidden" name="task" value="show_skusers" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>