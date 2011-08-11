<ul class="menu">
<li><a href="<?php echo $link_front; ?>"><span><?php echo JText::_('ADSMANAGER_MENU_HOME');?></span></a></li>
<li><a href="<?php echo $link_write_ad; ?>"><span><?php echo JText::_('ADSMANAGER_MENU_WRITE');?></span></a></li>
<li><a href="<?php echo $link_show_profile; ?>"><span><?php echo JText::_('ADSMANAGER_MENU_PROFILE');?></span></a></li>
<li><a href="<?php echo $link_show_user; ?>"><span><?php echo JText::_('ADSMANAGER_MENU_USER_ADS');?></span></a></li>
<li><a href="<?php echo $link_show_rules; ?>"><span><?php echo JText::_('ADSMANAGER_MENU_RULES');?></span></a></li>
<li><span class="separator" >- - - - - - -</span></li>
<?php
if ($displaynumads == 1)
	$all = JText::_('ADSMANAGER_MENU_ALL_ADS'). "($nbcontents)";
else
	$all = JText::_('ADSMANAGER_MENU_ALL_ADS');
?>
<li><a href="<?php echo $link_show_all; ?>"><span><?php echo $all;?></span></a></li>
<li><span class="separator" >- - - - - - -</span></li>
<?php
displayMenuCats(0, 0, $cats,$itemid,$current_list,$displaynumads);
?>
</ul>