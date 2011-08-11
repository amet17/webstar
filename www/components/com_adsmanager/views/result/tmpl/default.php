<script language="javascript" type="text/javascript">
function tableOrdering( order, dir, task )
{
        var form = document.adminForm;
 
        form.filter_order.value = order;
        form.filter_order_Dir.value = dir;
        document.adminForm.submit( task );
}
</script>
<?php
$conf= $this->conf;
?>
<h1 class="contentheading">
<?php
	echo '<img  class="imgheading" src="'.$this->list_img.'" alt="'.$this->list_img.'" />';
	echo $this->list_name;
?>
</h1>
<script language="JavaScript" type="text/JavaScript">
<!--
function jumpmenu(target,obj){
  eval(target+".location='"+obj.options[obj.selectedIndex].value+"'");	
  obj.options[obj.selectedIndex].innerHTML="<?php echo JText::_('ADSMANAGER_WAIT');?>";			
}		
//-->
</script>
<div class="adsmanager_search_box">
<div class="adsmanager_inner_box">
	<div align="left">
		<a href="<?php echo JRoute::_("index.php?option=com_adsmanager&view=search&catid=".$this->catid."&Itemid=".$this->Itemid);?>"><?php echo JText::_('ADSMANAGER_ADVANCED_SEARCH'); ?></a>
	</div>
	<?php if (isset($this->orders)) { ?>
	<?php echo JText::_('ADSMANAGER_ORDER_BY_TEXT'); ?>
	<select name="order" size="1" onchange="jumpmenu('parent',this)">
			<option value="<?php echo JRoute::_("index.php?option=com_adsmanager&view=result&Itemid=".$this->Itemid);?>" <?php if ($this->order == "0") { echo "selected='selected'"; } ?>><?php echo JText::_('ADSMANAGER_DATE'); ?></option>
		   <?php foreach($this->orders as $o)
		   {
               ?>
			<option value="<?php echo JRoute::_("index.php?option=com_adsmanager&view=result&order=".$o->fieldid."&Itemid=".$this->Itemid);?>" <?php if ($this->order == $o->fieldid) { echo "selected='selected'"; } ?>><?php echo JText::_($o->title); ?></option>
			<?php
		   }
		 ?>
	</select>	
	<?php } ?>			  
</div>
</div>
<?php $this->general->showGeneralLink() ?>
<?php
if ($this->pagination->total == 0 ) 
{
	echo JText::_('ADSMANAGER_NOENTRIES'); 
}
else
{
	echo $this->pagination->total;
	?>
	<?php echo $this->pagination->getResultsCounter() ?>
	<br/><br/>
	<form name="adminForm" id="adminForm" method="post" action="<?php echo $this->requestURL; ?>" >
	<input type="hidden" id="mode" name="mode" value="<?= $this->mode?>"/>
	<?php if ($this->conf->display_expand == 2) { ?>
	<script type="text/javascript">
		function changeMode(mode)
		{
			element = document.getElementById("mode");
			element.value = mode;
			form = document.getElementById("adminForm");
			form.submit();
		}
		</script>
		<div class="adsmanager_subtitle">
		<?php 
		/* Display SubTitle */
			echo '<a href="javascript:changeMode(0)">'.JText::_('ADSMANAGER_MODE_TEXT')." ".JText::_('ADSMANAGER_SHORT_TEXT').'</a>';
		    echo " / ";
		    echo '<a href="javascript:changeMode(1)">'.JText::_('ADSMANAGER_EXPAND_TEXT').'</a>';
		?>
		</div>
	<?php } ?>
	<?php if ($this->mode != 1) { ?>
	<table class="adsmanager_table">
		<tr>
		  <th><?php echo JText::_('ADSMANAGER_CONTENT'); ?></th>
		  <?php 
		  	  foreach($this->columns as $col)
			  {
				echo "<th>".JText::_($col->name)."</th>";
			  }
		  ?>
		  <th><?php echo JText::_('ADSMANAGER_DATE'); ?></th>
		</tr>
	<?php
	foreach($this->contents as $content) 
	{
		$linkTarget = JRoute::_( "index.php?option=com_adsmanager&view=details&id=".$content->id."&catid=".$content->catid."&Itemid=".$this->Itemid);
		if (function_exists('getContentClass')) 
			$classcontent = getContentClass($content);
  	    else
			$classcontent = "adsmanager_table_description";
		?>   
		<tr class="<?php echo $classcontent;?>"> 
			<td>
				<?php
				$ok = 0;$i=1;
				$nbimages = $conf->nb_images;
				if (function_exists("getMaxPaidSystemImages"))
				{
					$nbimages += getMaxPaidSystemImages();
				}
				while(!$ok)
				{
					if ($i < $nbimages + 1)
					{
						$ext_name = chr(ord('a')+$i-1);
						$pic = JPATH_BASE."/images/com_adsmanager/ads/".$content->id.$ext_name."_t.jpg";
						if (file_exists( $pic)) 
						{
							echo "<a href='".$linkTarget."'><img class='adimage' name='adimage".$content->id."' src='".$this->baseurl."/images/com_adsmanager/ads/".$content->id.$ext_name."_t.jpg' alt='".htmlspecialchars($content->ad_headline)."' /></a>";
							$ok = 1;
						}
					}
					else if ($nbimages != 0)
					{
						if ((JText::_('ADSMANAGER_NOPIC') != "")&&(file_exists(JPATH_BASE."/components/com_adsmanager/images/".JText::_('ADSMANAGER_NOPIC'))))
							echo "<a href='".$linkTarget."'><img class='adimage' src='".$this->baseurl."/components/com_adsmanager/images/".JText::_('ADSMANAGER_NOPIC')."' alt='nopic' /></a>"; 
						else
							echo "<a href='".$linkTarget."'><img class='adimage' src='".$this->baseurl."/components/com_adsmanager/images/nopic.gif' alt='nopic' /></a>"; 
						$ok = 1;
					}   
					else
					{
						$ok = 1;
					}
					$i++;   	
				}
				?>
				<div>
				<h2>
					<?php echo '<a href="'.$linkTarget.'">'.$content->ad_headline.'</a>'; ?>
					<span class="adsmanager_cat"><?php echo "(".$content->parent." / ".$content->cat.")"; ?></span>
				</h2>
				<?php 
					$content->ad_text = str_replace ('<br />'," ",$content->ad_text);
					$af_text = JString::substr($content->ad_text, 0, 100)."...";
					echo $af_text;
				?>
				</div>
				
				<?php 
				if (($this->userid == $content->userid)&&($content->userid != 0))	{
				?>
				<div>
				<?php
					$target = JRoute::_("index.php?option=com_adsmanager&task=write&catid=".$content->catid."&id=$content->id"."&Itemid=".$this->Itemid);
					echo "<a href='".$target."'>".JText::_('ADSMANAGER_CONTENT_EDIT')."</a>";
					echo "&nbsp;";
					$target = JRoute::_("index.php?option=com_adsmanager&task=delete&catid=".$content->catid."&id=$content->id"."&Itemid=".$this->Itemid);
					echo "<a href='".$target."'>".JText::_('ADSMANAGER_CONTENT_DELETE')."</a>";
				?>
				</div>
				<?php
				}
				?>			
			</td>
			<?php 
				foreach($this->columns as $col) {
					echo '<td class="center">';
					foreach($this->fColumns[$col->id] as $field)
					{
						echo $this->field->showFieldValue($content,$field); 
					}
					echo "</td>";
				}
			?>
			<td class="center">
				<?php 
				$iconflag = false;
				if (($conf->show_new == true)&&($this->isNewcontent($content->date_created,$conf->nbdays_new))) {
					echo "<div class='center'><img align='center' src='".$this->baseurl."/components/com_adsmanager/images/new.gif' /> ";
					$iconflag = true;
				}
				if (($conf->show_hot == true)&&($content->views >= $conf->nbhits)) {
					if ($iconflag == false)
						echo "<div class='center'>";
					echo "<img align='center' src='".$this->baseurl."/components/com_adsmanager/images/hot.gif' />";
					$iconflag = true;
				}
				if ($iconflag == true)
					echo "</div>";
				echo $this->reorderDate($content->date_created); 
				?>
				<br />
				<?php
				if ($content->userid != 0)
				{
				   echo JText::_('ADSMANAGER_FROM')." "; 

				   if ($conf->comprofiler == 2)
				   {
					$target = JRoute::_("index.php?option=com_comprofiler&task=userProfile&tab=adsmanagerTab&user=".$content->userid."&Itemid=".$this->Itemid);
				   }
				   else
				   {
					$target = JRoute::_("index.php?option=com_adsmanager&task=show_user&userid=".$content->userid."&Itemid=".$this->Itemid);
				   }
				   
				   echo "<a href='".$target."'>".$content->user."</a><br/>";
				}
				?>
				<?php echo sprintf(JText::_('ADSMANAGER_VIEWS'),$content->views); ?>
			</td>
		</tr>
	<?php	
	}
	?>
	</table>
	<?php } else { ?>
		<?php foreach($this->contents as $content) 
		{ 
			$this->loadScriptImage($this->conf->image_display);
		?>
			<br/>
			<div class="adsmanager_ads" align="left">
			<div class="adsmanager_top_ads">	
				<h2 class="adsmanager_ads_title">	
				<?php if (@$this->positions[0]->title) {$strtitle = JText::_($this->positions[0]->title);} ?>
				<?php echo "<b>".@$strtitle."</b>";
				if (isset($this->fDisplay[1]))
				{
					foreach($this->fDisplay[1] as $field)
					{
						echo $this->field->showFieldValue($content,$field); 
					}
				} ?>
				</h2>
				<div>
				<?php 
				if ($content->userid != 0)
				{
					echo JText::_('ADSMANAGER_SHOW_OTHERS'); 
					if ($this->conf->comprofiler == 2)
				    {
						$target = JROUTE::_("index.php?option=com_comprofiler&task=userProfile&tab=AdsManagerTab&user=".$content->userid."&Itemid=".$this->Itemid);
					}
				    else
				    {
						$target = JROUTE::_("index.php?option=com_adsmanager&view=list&user=".$content->userid."&Itemid=".$this->Itemid);
				    }
					echo "<a href='$target'><b>".$content->user."</b></a>";
					
					if ($this->userid == $content->userid)	{
					?>
					<div>
					<?php
						$target = JROUTE::_("index.php?option=com_adsmanager&Itemid=$this->Itemid&task=write&catid=".$content->catid."&id=$content->id"."&Itemid=".$this->Itemid);
						echo "<a href='".$target."'>".JText::_('ADSMANAGER_CONTENT_EDIT')."</a>";
						echo "&nbsp;";
						$target = JROUTE::_("index.php?option=com_adsmanager&Itemid=$this->Itemid&task=delete&catid=".$content->catid."&id=$content->id"."&Itemid=".$this->Itemid);
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
						echo $this->field->showFieldValue($content,$field);
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
							echo $this->field->showFieldValue($content,$field);
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
							echo $this->field->showFieldValue($content,$field);
						}
					} ?>
					</div>
					<div class="adsmanager_ads_price">
					<?php if (@$this->positions[3]->title) {$strtitle = JText::_($this->positions[3]->title); } ?>
					<?php echo "<b>".@$strtitle."</b>"; 
					if (isset($this->fDisplay[4]))
					{
						foreach($this->fDisplay[4] as $field)
						{
							echo $this->field->showFieldValue($content,$field);
						} 
					}?>
					</div>
					<div class="adsmanager_ads_contact">
					<?php if (@$this->positions[4]->title) {$strtitle = JText::_($this->positions[4]->title);} ?>
					<?php echo "<b>".@$strtitle."</b>"; 
					if (($this->userid != 0)||($conf->show_contact == 0)) {		
						if (isset($this->fDisplay[5]))
						{		
							foreach($this->fDisplay[5] as $field)
							{	
								echo $this->field->showFieldValue($content,$field);
							} 
						}
						if (($content->userid != 0)&&($this->conf->allow_contact_by_pms == 1))
						{
							$pmsText= sprintf(JText::_('ADSMANAGER_PMS_FORM'),$content->user);
							$pmsForm = JROUTE::_("index.php?option=com_uddeim&task=new&recip=".$content->userid);
							echo '&nbsp;<a href="'.$pmsForm.'">'.$pmsText.'</a><br />';
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
					$image_found =0;
					$nbimages = $this->conf->nb_images;
					if (function_exists("getMaxPaidSystemImages"))
					{
						$nbimages += getMaxPaidSystemImages();
					}
					for($i=1;$i < $nbimages + 1;$i++)
					{
						$ext_name = chr(ord('a')+$i-1);
						$pic = JPATH_BASE."/images/com_adsmanager/ads/".$content->id.$ext_name."_t.jpg";
						$piclink 	= $this->baseurl."/images/com_adsmanager/ads/".$content->id.$ext_name.".jpg";
						if (file_exists($pic)) 
						{
						    switch($this->conf->image_display)
						    {
								case 'popup':
									echo "<a href=\"javascript:popup('$piclink');\"><img src='".$this->baseurl."/images/com_adsmanager/ads/".$content->id.$ext_name."_t.jpg' alt='".htmlspecialchars($content->ad_headline)."' /></a>";
									break;
								case 'lightbox':
								case 'lytebox':
									echo "<a href='".$piclink."' rel='lytebox[roadtrip".$content->id."]'><img src='".$this->baseurl."/images/com_adsmanager/ads/".$content->id.$ext_name."_t.jpg' alt='".htmlspecialchars($content->ad_headline)."' /></a>"; 
									break;
								case 'highslide':
									echo "<a id='thumb".$content->id."' class='highslide' onclick='return hs.expand (this)' href='".$piclink."'><img src='".$this->baseurl."/images/com_adsmanager/ads/".$content->id.$ext_name."_t.jpg' alt='".htmlspecialchars($content->ad_headline)."' /></a>";
									break;
								case 'default':	
								default:
									echo "<a href='".$piclink."' target='_blank'><img src='".$this->baseurl."/images/com_adsmanager/ads/".$content->id.$ext_name."_t.jpg' alt='".htmlspecialchars($content->ad_headline)."' /></a>";
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
		<?php } ?>
	<?php } ?>
	<div class="pagelinks"><?php echo $this->pagination->getPagesLinks(); ?></div>
	</form>
<?php 
} $this->general->endTemplate();