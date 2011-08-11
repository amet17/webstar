<?php
$conf= $this->conf;
?>
	<h1 class="adsmanager_ads_title">	
		<?php if (@$this->positions[0]->title) {$strtitle = JText::_($this->positions[0]->title);} ?>
		<?php echo "<b>".@$strtitle."</b>";
		if (isset($this->fDisplay[1]))
		{
			foreach($this->fDisplay[1] as $field)
			{
				echo $this->field->showFieldValue($this->content,$field); 
			}
		} ?>
		</h1>
<div class="<?php echo $classcontent;?> adsmanager_ads" align="left">
	<div class="adsmanager_top_ads">	
		<div>
		<?php 
		if ($this->content->userid != 0)
		{
			echo JText::_('ADSMANAGER_SHOW_OTHERS'); 
			if ($conf->comprofiler == 2)
		    {
				$target = JRoute::_("index.php?option=com_comprofiler&task=userProfile&tab=AdsManagerTab&user=".$this->content->userid."&Itemid=".$this->Itemid);
			}
		    else
		    {
				$target = JRoute::_("index.php?option=com_adsmanager&view=list&user=".$this->content->userid."&Itemid=".$this->Itemid);
		    }
			echo "<a href='$target'> <b>".$this->content->user."</b></a>";
			
			if ($this->userid == $this->content->userid)	{
			?>
			<div>
			<?php
				$target = JRoute::_("index.php?option=com_adsmanager&Itemid=".$this->Itemid."&task=write&catid=".$this->content->category."&id=".$this->content->id."&Itemid=".$this->Itemid);
				echo "<a href='".$target."'>".JText::_('ADSMANAGER_CONTENT_EDIT')."</a>";
				echo "&nbsp;";
				$target = JRoute::_("index.php?option=com_adsmanager&Itemid=$this->Itemid&task=delete&catid=".$this->content->category."&id=".$this->content->id."&Itemid=".$this->Itemid);
				echo "<a href='".$target."'>".JText::_('ADSMANAGER_CONTENT_DELETE')."</a>";
			?>
			</div>
			<?php
			}
		}
		?>
		</div>
		<div class="adsmanager_ads_kindof">
		<?php if (@$this->positions[1]->title) {$strtitle = JText::_($this->positions[1]->title);} ?>
		<?php echo "<b>".@$strtitle."</b>"; 
		if (isset($this->fDisplay[2]))
		{
			foreach($this->fDisplay[2] as $field)
			{
				echo $this->field->showFieldValue($this->content,$field);
			}
		}
		?>
		</div>
	</div>
	<div class="adsmanager_ads_main">
		<div class="adsmanager_ads_body">
			<div class="adsmanager_ads_desc">
			<?php if (@$this->positions[2]->title) {$strtitle = JText::_($this->positions[2]->title);} ?>
			<?php echo "<b>".@$strtitle."</b>"; 
			if (isset($this->fDisplay[3]))
			{	
				foreach($this->fDisplay[3] as $field)
				{
					echo $this->field->showFieldValue($this->content,$field);
				}
			} ?>
			</div>
			<div class="adsmanager_ads_desc">
			<?php if (@$this->positions[5]->title) {$strtitle = JText::_($this->positions[5]->title);} ?>
			<?php echo "<b>".@$strtitle."</b>"; 
			if (isset($this->fDisplay[6]))
			{	
				foreach($this->fDisplay[6] as $field)
				{
					echo $this->field->showFieldValue($this->content,$field);
				}
			} ?>
			</div>
			<div class="adsmanager_ads_price">
			<?php if (@$this->positions[3]->title) {$strtitle = JText::_($this->positions[3]->title); } ?>
			<?php echo "<b>".@$strtitle." </b>"; 
			if (isset($this->fDisplay[4]))
			{
				foreach($this->fDisplay[4] as $field)
				{
					echo $this->field->showFieldValue($this->content,$field);
				} 
			}?>
			</div>
			<div class="adsmanager_ads_contact">
			<?php if (@$this->positions[4]->title) {$strtitle = JText::_($this->positions[4]->title);} ?>
			<?php echo "<b>".@$strtitle."</b> "; 
			if (($this->userid != 0)||($conf->show_contact == 0)) {		
				if (isset($this->fDisplay[5]))
				{		
					foreach($this->fDisplay[5] as $field)
					{	
						echo $this->field->showFieldValue($this->content,$field);
					} 
				}
				if (($this->content->userid != 0)&&($conf->allow_contact_by_pms == 1))
				{
					$pmsText= sprintf(JText::_('ADSMANAGER_PMS_FORM'),$this->content->user);
					$pmsForm = JRoute::_("index.php?option=com_uddeim&task=new&recip=".$this->content->userid);
					echo '<a href="'.$pmsForm.'">'.$pmsText.'</a><br />';
				}
			}
			else
			{
				echo JText::_('ADSMANAGER_CONTACT_NOT_LOGGED');
			}
			?>
			</div>
	    </div>
		<div class="adsmanager_ads_image">
			<?php
			$this->loadScriptImage($this->conf->image_display);
			$image_found =0;
			$nbimages = $this->conf->nb_images;
			if (function_exists("getMaxPaidSystemImages"))
			{
				$nbimages += getMaxPaidSystemImages();
			}
			for($i=1;$i < $nbimages + 1;$i++)
			{
				$ext_name = chr(ord('a')+$i-1);
				$pic = JPATH_BASE."/images/com_adsmanager/ads/".$this->content->id.$ext_name."_t.jpg";
				$piclink 	= $this->baseurl."/images/com_adsmanager/ads/".$this->content->id.$ext_name.".jpg";
				if (file_exists($pic)) 
				{
				    switch($this->conf->image_display)
				    {
						case 'popup':
							echo "<a href=\"javascript:popup('$piclink');\"><img src='".$this->baseurl."/images/com_adsmanager/ads/".$this->content->id.$ext_name."_t.jpg' alt='".htmlspecialchars($this->content->ad_headline)."' /></a>";
							break;
						case 'lightbox':
						case 'lytebox':
							echo "<a href='".$piclink."' rel='lytebox[roadtrip".$this->content->id."]'><img src='".$this->baseurl."/images/com_adsmanager/ads/".$this->content->id.$ext_name."_t.jpg' alt='".htmlspecialchars($this->content->ad_headline)."' /></a>"; 
							break;
						case 'highslide':
							echo "<a id='thumb".$this->content->id."' class='highslide' onclick='return hs.expand (this)' href='".$piclink."'><img src='".$this->baseurl."/images/com_adsmanager/ads/".$this->content->id.$ext_name."_t.jpg' alt='".htmlspecialchars($this->content->ad_headline)."' /></a>";
							break;
						case 'default':	
						default:
							echo "<a href='".$piclink."' target='_blank'><img src='".$this->baseurl."/images/com_adsmanager/ads/".$this->content->id.$ext_name."_t.jpg' alt='".htmlspecialchars($this->content->ad_headline)."' /></a>";
							break;
					}
					$image_found = 1;
				}   
			}
			if (($image_found == 0)&&($conf->nb_images >  0))
			{
				if ((JText::_('ADSMANAGER_NOPIC') != "")&&(file_exists(JPATH_BASE."/components/com_adsmanager/images/".JText::_('ADSMANAGER_NOPIC'))))
					echo '<img align="center" src="'.$this->baseurl.'/components/com_adsmanager/images/'.JText::_('ADSMANAGER_NOPIC').'" alt="nopic" /></a>'; 
				else
					echo '<img align="center" src="'.$this->baseurl.'/components/com_adsmanager/images/nopic.gif" alt="nopic" />'; 
			}
			?>
		</div>
		<div class="adsmanager_spacer"></div>
	</div>
</div>
<div class="back_button">
<a href='javascript:history.go(-1)'>
<?php echo JText::_('ADSMANAGER_BACK_TEXT'); ?>
</a>
</div>