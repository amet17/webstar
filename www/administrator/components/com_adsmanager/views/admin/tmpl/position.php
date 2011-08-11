<link rel="stylesheet" href="../components/com_adsmanager/css/adsmanager.css" type="text/css" />
<div class="adsmanager_ads" align="left">
	<div class="adsmanager_top_ads">	
		<h2 class="adsmanager_ads_title">	
		<?php echo "<b>". JText::_($this->positions[0]->title)."</b>"; 
		if (isset($this->fDisplay[1]))
		{
			foreach($this->fDisplay[1] as $field)
			{
				echo JText::_($field->title);
				echo "<br />";
			}
		} ?>
		</h2>
		<div>
		<?php echo JText::_('ADSMANAGER_SHOW_OTHERS')."<b>USER</b>";?>	
		</div>
		<div class="adsmanager_ads_kindof">
		<?php echo "<b>".JText::_($this->positions[1]->title)."</b>"; 
		if (isset($this->fDisplay[2]))
		{
			foreach($this->fDisplay[2] as $field)
			{
				echo JText::_($field->title);
				echo "<br />";		
			}
		}
		?>
		</div>
		</div>
	<div class="adsmanager_ads_main">
		<div class="adsmanager_ads_body">
			<div class="adsmanager_ads_desc">
			<?php echo "<b>".JText::_($this->positions[2]->title)."</b>"; 
			if (isset($this->fDisplay[3]))
			{	
				foreach($this->fDisplay[3] as $field)
				{
					echo JText::_($field->title);
					echo "<br />";
				}
			} ?>
			</div>
			<div class="adsmanager_ads_price">
			<?php echo "<b>".JText::_($this->positions[3]->title)."</b>"; 
			if (isset($this->fDisplay[4]))
			{
				 foreach($this->fDisplay[4] as $field)
				{
					echo JText::_($field->title);
					echo "<br />";
				} 
			}?>
			</div>
			<div class="adsmanager_ads_contact">
			<?php echo "<b>".JText::_($this->positions[4]->title)."</b>"; 
			if (isset($this->fDisplay[5]))
			{		
				foreach($this->fDisplay[5] as $field)
				{	
					JText::_($field->title);
					echo "<br />";
				} 
			}?>
			</div>
		</div>
		<div class="adsmanager_ads_image">
			<img align="center" src="../components/com_adsmanager/images/nopic.gif">				</div>
		<div class="adsmanager_spacer"></div>
	</div>
</div>