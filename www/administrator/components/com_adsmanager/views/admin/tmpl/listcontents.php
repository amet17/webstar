<form action="index.php" method="post" name="adminForm" id="adminForm">
<table>
				<tr>
					<td width="100%">
					</td>
					<td nowrap="nowrap">
						<select name="catid" id="catid" onchange="document.adminForm.submit();">
							<option value="0" <?php if (!isset($this->cat)) echo "selected"; ?>><?php echo JText::_('ADSMANAGER_MENU_ALL_ADS'); ?></option>
							<?php $this->selectCategories(0,"",$this->cats,$this->cat,-1); ?>
						</select>
						<select name="filterpublish" id="filterpublish" onchange="document.adminForm.submit();">
							<option value="" <?php if ($this->filterpublish == "") echo "selected='selected'"; ?>>
								<?php echo ""; ?>
							</option>
							<option value="1" <?php if ($this->filterpublish == "1") echo "selected='selected'"; ?>>
								<?php echo JText::_('ADSMANAGER_PUBLISH'); ?>
							</option>
							<option value="0" <?php if ($this->filterpublish == "0") echo "selected='selected'"; ?>>
								<?php echo JText::_('ADSMANAGER_NO_PUBLISH'); ?>
							</option>
						</select>
						<span>
						<?php echo JText::_('ADSMANAGER_TH_USER')?>:
						</span>
						<span>
						<input type="text" name="search" value="<?php echo htmlspecialchars( $this->search );?>" class="text_area" onChange="document.adminForm.submit();" />
						</span>
					</td>
				</tr>
			</table>
<table class="adminlist">
<thead>
<tr>
	<th class="title" width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->contents); ?>);" /></th>
	
	<th class="title" width="5%"><?php echo JHTML::_('grid.sort',JText::_('Id'),'a.id',@$this->lists['order_Dir'], @$this->lists['order'] );?></th>
	<th class="title" width="20%">
		<?php echo JHTML::_('grid.sort',JText::_('ADSMANAGER_TH_TITLE'), 'a.ad_headline', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
	</th>
	<th class="title" width="5%">
		<?php echo JHTML::_('grid.sort',JText::_('ADSMANAGER_TH_PUBLISH'), 'a.published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
	</th>
	<th class="title" width="30%">
		<?php echo JText::_('ADSMANAGER_TH_IMAGE');?>
	</th>
	<th class="title" width="10%">
		<?php echo JHTML::_('grid.sort',JText::_('ADSMANAGER_TH_USER'), 'user', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
	</th>
	<th class="title" width="10%">
		<?php echo JHTML::_('grid.sort',JText::_('ADSMANAGER_TH_CATEGORY'), 'c.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
	</th>
	<th class="title" width="10%">
		<?php echo JHTML::_('grid.sort',JText::_('ADSMANAGER_TH_DATE'), 'a.date_created', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
	</th>
	<th class="title" width="10%">
		<?php echo JHTML::_('grid.sort',JText::_('ADSMANAGER_TH_EXPIRATION_DATE'), 'a.expiration_date', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
	</th>
</tr>
</thead>
<tbody>

<?php
	$k = 0;
	for($i=0; $i < count( $this->contents ); $i++) {
	$content = $this->contents[$i];

    ?>
     <tr class="row<?php echo $k; ?>">
	<td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $content->id; ?>" onclick="isChecked(this.checked);" /></td>

	<td><?php echo $content->id; ?></td>
	<td><a href="<?php echo "index.php?option=com_adsmanager&c=contents&task=edit&id=".$content->id ?>"><?php echo $content->ad_headline; ?></a></td>
	<td align='center'><?php echo JHTML::_('grid.published', $content, $i ); ?></td>
	<td>
	<?php
	for($j=1;$j < $this->conf->nb_images + 1;$j++)
	{
		$ext_name = chr(ord('a')+$j-1);
		$pic = JPATH_SITE."/images/com_adsmanager/ads/".$content->id.$ext_name."_t.jpg";
		if (file_exists($pic)) 
		{
			echo "<img src='".$this->baseurl."/images/com_adsmanager/ads/".$content->id.$ext_name."_t.jpg?time=".time()."'>";
		} 
		echo '&nbsp;';  
	}
	?>
	</td>
	<td><?php echo $content->user; ?></td>
	<td><?php echo '<a href="index.php?option=com_adsmanager&c=contents&catid='.$content->catid.'">'.$content->cat.'</a>'; ?></td>
	<td><?php echo $content->date_created; ?></td>
	<td><?php echo $content->expiration_date; ?></td>
	</tr>
<?php
	$k = !$k;
	} 

?>
</tbody>
<tfoot>
	<tr>
		<td colspan="9">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tr>
</tfoot>
</table>
<input type="hidden" name="option" value="com_adsmanager" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="c" value="contents" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>  
</form> 