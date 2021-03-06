<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip');?>
<?php
	// Set toolbar items for the page
	JToolBarHelper::title(   JText::_( 'Spam posts management' ), 'generic.png' );	
	JToolBarHelper::deleteList('Do you want to remove selected Messages ?', 'remove_messages',JText::_('Delete'));
	JToolBarHelper::publishList('messages_publish',JText::_('Publish'));	
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
			<th style="text-align: center;" width="5%">
				<?php echo JHTML::_('grid.sort', JText::_('User'), 'c.username', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th style="text-align: center;" width="20%">
				<?php echo JHTML::_('grid.sort', JText::_('Subject'), 'b.subject', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th>
				<?php echo JHTML::_('grid.sort', JText::_('Message'), 'b.message', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>								
			<th width="1%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',  JText::_('ID'), 'a.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="6">
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
		$row->published = $row->hold;		
		$published = JHTML::_('grid.published', $row, $i,'tick.png', 'publish_x.png', 'messages_') ;	
		?>
		
		<tr class="<?php echo "row$k"; ?>">
			<td align="center">
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td align="center">
				<?php echo $checked; ?>
			</td>	
			<td align="center">
			    <?php echo $row->username;?>
			</td>
			<td>
				<?php echo $row->subject; ?>
			</td>
			<td>
				<?php echo substr(strip_tags($row->message), 0, 200) ; ?>				
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
	<input type="hidden" name="task" value="show_messages" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>