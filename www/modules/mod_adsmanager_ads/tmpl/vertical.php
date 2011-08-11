<?php
if ($image == 1)
{
?>
	<ul class="adsmanager_ver_list">
	<?php
	if(isset($contents[0])) {
	foreach($contents as $row) {
	?>
		<li>
		<?php	
		$linkTarget = JRoute::_("index.php?option=com_adsmanager&view=details&id=".$row->id."&catid=".$row->catid."&Itemid=".$itemid);			
		$ok = 0;$i=1;
		while(!$ok)
		{
			if ($i < $nb_images + 1)
			{
				$ext_name = chr(ord('a')+$i-1);
				$pic = JPATH_BASE."/images/com_adsmanager/ads/".$row->id.$ext_name."_t.jpg";
				if (file_exists( $pic)) 
				{
					echo "<div class='center'><noindex><a rel='nofollow' href='".$linkTarget."'><img src='".$baseurl."/images/com_adsmanager/ads/".$row->id.$ext_name."_t.jpg' alt='".htmlspecialchars($row->ad_headline)."' border='0' /></a></noindex>";
					$ok = 1;
				}
			}
			else
			{
				echo "<div class='center'><noindex><a rel='nofollow' href='".$linkTarget."'><img src='".$baseurl."/components/com_adsmanager/images/nopic.gif' alt='noimage' border='0' /></a></noindex>"; 
				$ok = 1;
			}   
			$i++;   	
		}
		echo "<br /><noindex><a rel='nofollow' href='$linkTarget'>".$row->ad_headline."</a></noindex>"; 
		$iconflag = false;
		if (($conf->show_new == true)&&(isNewContent($row->date_created,$conf->nbdays_new))) {
			echo "<div class='center'><img align='center' src='".$baseurl."/components/com_adsmanager/images/new.png' /> ";
			$iconflag = true;
		}
		if (($conf->show_hot == true)&&($row->views >= $conf->nbhits)) {
			if ($iconflag == false)
				echo "<div class='center'>";
			echo "<img align='center' src='".$baseurl."/components/com_adsmanager/images/hot.gif' />";
			$iconflag = true;
		}
		if ($iconflag == true)
			echo "</div>";
			
		if ($displaycategory == 1)
		{
			if ($iconflag == false)
				echo "<br />";
			echo "<span class=\"adsmanager_cat\">(".$row->parent." / ".$row->cat.")</span>";
		}
		if ($displaydate == 1)
		{
			if (($iconflag == false)||($displaycategory == 1))
				echo "<br />";
			echo reorderDate($row->date_created);
			$iconflag = true;
		}
		echo "</div>";
		?>
		</li>
<?php
	} }
	?>
	</ul>
	<?php
}
else
{
	?>
	<ul class="mostread">
	<?php
	if (isset($contents[0])){
	foreach($contents as $row) {
	?>
		<li class="mostread">
		<?php	
			$linkTarget = JRoute::_("index.php?option=com_adsmanager&view=details&id=".$row->id."&catid=".$row->catid."&Itemid=".$itemid);
			echo "<noindex><a rel='nofollow' href='$linkTarget'>".$row->ad_headline."</a></noindex>";
			if ($displaycategory == 1)
				echo "&nbsp;<span class=\"adsmanager_cat\">(".$row->parent." / ".$row->cat.")";
			if ($displaydate == 1)
				echo "&nbsp;".reorderDate($row->date_created)."</span>"; 
		?>
		</li>
<?php
	}}
	?>
	</ul>
	<?php
}	