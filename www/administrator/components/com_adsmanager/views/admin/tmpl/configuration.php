<script type="text/javascript">
<?php if(version_compare(JVERSION,'1.6.0','>=')){ ?>
Joomla.submitbutton = function(pressbutton) {
<?php } else { ?>
function submitbutton(pressbutton) {
<?php } ?>
		<?php 
		$editor	=& JFactory::getEditor(); 
		echo $editor->save( 'fronttext' );
		echo $editor->save( 'rules_text' );
		echo $editor->save( 'recall_text' );
		?>
       submitform(pressbutton);
   }
</script>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<?php 
$tabs	=& JPane::getInstance('tabs');
echo $tabs->startPane('config');
echo $tabs->startPanel(JText::_('ADSMANAGER_TAB_GENERAL'), "general-page");
?>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
	<tr>
		<td><?php echo JText::_('ADSMANAGER_ADS_PER_PAGE');?></td>
		<td><input type="text" name="ads_per_page" value=<?php echo $this->conf->ads_per_page; ?> /></td>
		<td><?php echo JText::_('ADSMANAGER_ADS_PER_PAGE_LONG');?></td>
	</tr>	
	<tr>
		<td><?php echo JText::_('ADSMANAGER_AUTO_PUBLISH'); ?></td>
		<td>
		 <select id='auto_publish' name='auto_publish'>
			<option value='1' <?php if ($this->conf->auto_publish == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_YES'); ?></option>
			<option value='0' <?php if ($this->conf->auto_publish == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_NO'); ?></option>
		  </select>
		</td>
		<td><?php echo JText::_('ADSMANAGER_AUTO_PUBLISH_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_SUBMISSION_TYPE'); ?></td>
		<td>
		<select id='submission_type' name='submission_type'>
			<option value='0' <?php if ($this->conf->submission_type == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_SUBMISION_WITH_ACCOUNT_CREATION'); ?></option>
			<option value='1' <?php if ($this->conf->submission_type == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_SUBMISSION_ALLOWED_ONLY_FOR_REGISTERS'); ?></option>
			<option value='2' <?php if ($this->conf->submission_type == 2) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_SUBMISSION_ALLOWED_FOR_VISITORS'); ?></option>
		</select>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_ROOT_SUBMIT'); ?></td>
		<td>
		<select id='root_allowed' name='root_allowed'>
			<option value='1' <?php if ($this->conf->root_allowed == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_ROOT_SUBMIT_ALLOWED'); ?></option>
			<option value='0' <?php if ($this->conf->root_allowed == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_ROOT_SUBMIT_NOT_ALLOWED'); ?></option>
		</select>
		</td>
		<td><?php echo JText::_('ADSMANAGER_ROOT_SUBMIT_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_NB_ADS_BY_USER'); ?></td>
		<td><input type="text" name="nb_ads_by_user" value=<?php echo $this->conf->nb_ads_by_user; ?> /></td>
		<td><?php echo JText::_('ADSMANAGER_NB_ADS_BY_USER_LONG'); ?></td>
	</tr>
	<tr>
	<td><?php echo JText::_('ADSMANAGER_EMAIL_ON_NEW'); ?></td>
	<td>
	 <select id='send_email_on_new' name='send_email_on_new'>
		<option value='1' <?php if ($this->conf->send_email_on_new == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_YES'); ?></option>
		<option value='0' <?php if ($this->conf->send_email_on_new == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_NO'); ?></option>
	  </select>
	</td>
	<td><?php echo JText::_('ADSMANAGER_EMAIL_ON_NEW_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_EMAIL_ON_UPDATE'); ?></td>
		<td>
		 <select id='send_email_on_update' name='send_email_on_update'>
			<option value='1' <?php if ($this->conf->send_email_on_update == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_YES'); ?></option>
			<option value='0' <?php if ($this->conf->send_email_on_update == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_NO'); ?></option>
		  </select>
		</td>
		<td><?php echo JText::_('ADSMANAGER_EMAIL_ON_UPDATE_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_COMMUNITY_BUILDER'); ?></td>
		<td>
		<select id='comprofiler' name='comprofiler'>
			<option value='2' <?php if ($this->conf->comprofiler == 2) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_FULL'); ?></option>
			<option value='1' <?php if ($this->conf->comprofiler == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_PROFILE'); ?></option>
			<option value='0' <?php if ($this->conf->comprofiler == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_NO'); ?></option>
		</select>
		</td>
		<td><?php echo JText::_('ADSMANAGER_COMMUNITY_BUILDER_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_DISPLAY_MODE'); ?></td>
		<td>
		<select id='display_expand' name='display_expand'>
			<option value='2' <?php if ($this->conf->display_expand == 2) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_SHORT_AND_EXPAND_MODE'); ?></option>
			<option value='1' <?php if ($this->conf->display_expand == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_EXPAND_MODE'); ?></option>
			<option value='0' <?php if ($this->conf->display_expand == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_SHORT_MODE'); ?></option>
		</select>
		</td>
		<td><?php echo JText::_('ADSMANAGER_DISPLAY_MODE_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_LAST_ADS'); ?></td>
		<td>
		<select id='display_last' name='display_last'>
			<option value='2' <?php if ($this->conf->display_last == 2) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_LAST_BOTTOM');?></option>
			<option value='1' <?php if ($this->conf->display_last == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_LAST_TOP');  ?></option>
			<option value='0' <?php if ($this->conf->display_last == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_LAST_NONE'); ?></option>
		</select>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
	<td><?php echo JText::_('ADSMANAGER_SHOW_RSS'); ?></td>
	<td>
	 <select id='show_rss' name='show_rss'>
		<option value='1' <?php if ($this->conf->show_rss == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_YES'); ?></option>
		<option value='0' <?php if ($this->conf->show_rss == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_NO'); ?></option>
	  </select>
	</td>
	<td>&nbsp;<?php echo JText::_('ADSMANAGER_SHOW_RSS_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_NBCATS'); ?></td>
		<td><input type="text" name="nbcats" value=<?php echo $this->conf->nbcats; ?> /></td>
		<td><?php echo JText::_('ADSMANAGER_NBCATS_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_SHOW_NEW'); ?></td>
		<td>
		 <select id='show_new' name='show_new'>
			<option value='1' <?php if ($this->conf->show_new == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_YES'); ?></option>
			<option value='0' <?php if ($this->conf->show_new == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_NO'); ?></option>
		</select>
		</td>
		<td><?php echo JText::_('ADSMANAGER_SHOW_NEW_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_NBDAYS_NEW'); ?></td>
		<td><input type="text" name="nbdays_new" value=<?php echo $this->conf->nbdays_new; ?> /></td>
		<td><?php echo JText::_('ADSMANAGER_NBDAYS_NEW_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_SHOW_HOT'); ?></td>
		<td>
		 <select id='show_hot' name='show_hot'>
			<option value='1' <?php if ($this->conf->show_hot == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_YES'); ?></option>
			<option value='0' <?php if ($this->conf->show_hot == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_NO'); ?></option>
		</select>
		</td>
		<td><?php echo JText::_('ADSMANAGER_SHOW_HOT_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_NBHITS'); ?></td>
		<td><input type="text" name="nbhits" value=<?php echo $this->conf->nbhits; ?> /></td>
		<td><?php echo JText::_('ADSMANAGER_NBHITS_LONG'); ?></td>
	</tr>
</table>
<?php   
echo $tabs->endPanel();
echo $tabs->startPanel(JText::_('ADSMANAGER_TAB_CONTACT'), "contact-page");
?>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
	<tr>
		<td><?php echo JText::_('ADSMANAGER_SHOW_CONTACT'); ?></td>
		<td>
		<select id='show_contact' name='show_contact'>
			<option value='1' <?php if ($this->conf->show_contact == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_SHOW_CONTACT_LOGGED_ONLY'); ?></option>
			<option value='0' <?php if ($this->conf->show_contact == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_SHOW_CONTACT_ALL'); ?></option>
		</select>
		</td>
		<td><?php echo JText::_('ADSMANAGER_SHOW_CONTACT_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_DISPLAY_FULLNAME'); ?></td>
		<td>
		<select id='display_fullname' name='display_fullname'>
			<option value='1' <?php if ($this->conf->display_fullname == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_YES'); ?></option>
			<option value='0' <?php if ($this->conf->display_fullname == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_NO'); ?></option>
		</select>
		</td>
		<td><?php echo JText::_('ADSMANAGER_DISPLAY_FULLNAME_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_ALLOW_ATTACHMENT'); ?></td>
		<td>
		<select id='allow_attachement' name='allow_attachement'>
			<option value='1' <?php if ($this->conf->allow_attachement == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_YES'); ?></option>
			<option value='0' <?php if ($this->conf->allow_attachement == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_NO'); ?></option>
		</select>
		</td>
		<td><?php echo JText::_('ADSMANAGER_ALLOW_ATTACHMENT_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_CONTACT_BY_PMS'); ?></td>
		<td>
		<select id='allow_contact_by_pms' name='allow_contact_by_pms'>
			<option value='1' <?php if ($this->conf->allow_contact_by_pms == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_YES'); ?></option>
			<option value='0' <?php if ($this->conf->allow_contact_by_pms == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_NO'); ?></option>
		</select>
		</td>
		<td><?php echo JText::_('ADSMANAGER_CONTACT_BY_PMS_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_EMAIL_DISPLAY'); ?></td>
		<td>
		<select id='email_display' name='email_display'>
			<option value='2' <?php if ($this->conf->email_display == 2) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_EMAIL_DISPLAY_FORM');?></option>
			<option value='1' <?php if ($this->conf->email_display == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_EMAIL_DISPLAY_IMAGE');?></option>
			<option value='0' <?php if ($this->conf->email_display == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_EMAIL_DISPLAY_LINK');?></option>
		</select>
		</td>
		<td><?php echo JText::_('ADSMANAGER_EMAIL_DISPLAY_LONG'); ?></td>
	</tr>
</table>
<?php   
echo $tabs->endPanel();
echo $tabs->startPanel(JText::_('ADSMANAGER_TAB_IMAGE'), "image-page");
?>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
	<tr>
		<td><?php echo JText::_('ADSMANAGER_NB_IMAGES'); ?></td>
		<td><input type="text" name="nb_images" value=<?php echo $this->conf->nb_images; ?> /></td>
		<td><?php echo JText::_('ADSMANAGER_NB_IMAGES_LONG'); ?></td>
	</tr>
	<tr>
	  <td><?php echo JText::_('ADSMANAGER_MAX_IMAGE_SIZE');?></td>
	  <td><input type="text" name="max_image_size" value=<?php echo $this->conf->max_image_size; ?> /></td>
	  <td><?php echo JText::_('ADSMANAGER_MAX_IMAGE_SIZE_LONG');?></td>
    </tr>
    <tr>
	  <td><?php echo JText::_('ADSMANAGER_MAX_IMAGE_WIDTH');?></td>
	  <td><input type="text" name="max_width" value=<?php echo $this->conf->max_width; ?> /></td>
	  <td><?php echo JText::_('ADSMANAGER_MAX_IMAGE_WIDTH_LONG');?></td>
    </tr>
    <tr>
	  <td><?php echo JText::_('ADSMANAGER_MAX_IMAGE_HEIGHT');?></td>
	  <td><input type="text" name="max_height" value=<?php echo $this->conf->max_height; ?> /></td>
	  <td><?php echo JText::_('ADSMANAGER_MAX_IMAGE_HEIGHT_LONG');?></td>
    </tr>
    <tr>
	  <td><?php echo JText::_('ADSMANAGER_MAX_THUMBNAIL_WIDTH');?></td>
	  <td><input type="text" name="max_width_t" value=<?php echo $this->conf->max_width_t; ?> /></td>
	  <td><?php echo JText::_('ADSMANAGER_MAX_THUMBNAIL_WIDTH_LONG');?></td>
    </tr>
    <tr>
	  <td><?php echo JText::_('ADSMANAGER_MAX_THUMBNAIL_HEIGHT');?></td>
	  <td><input type="text" name="max_height_t" value=<?php echo $this->conf->max_height_t; ?> /></td>
	  <td><?php echo JText::_('ADSMANAGER_MAX_THUMBNAIL_HEIGHT_LONG');?></td>
    </tr>
    <tr>
		<td><?php echo JText::_('ADSMANAGER_IMAGE_TAG'); ?></td>
		<td><input type="text" name="tag" value="<?php echo $this->conf->tag; ?>" /></td>
		<td><?php echo JText::_('ADSMANAGER_IMAGE_TAG_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_IMAGE_DISPLAY'); ?></td>
		<td>
		<select id='image_display' name='image_display'>
			<option value='default' <?php if ($this->conf->image_display == 'default') { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_IMAGE_DISPLAY_DEFAULT'); ?></option>
			<option value='lytebox' <?php if ($this->conf->image_display == 'lytebox') { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_IMAGE_DISPLAY_LYTEBOX'); ?></option>
			<option value='highslide' <?php if ($this->conf->image_display == 'highslide') { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_IMAGE_DISPLAY_HIGHSLIDE'); ?></option>
			<option value='popup' <?php if ($this->conf->image_display == 'popup') { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_IMAGE_DISPLAY_POPUP'); ?></option>
		</select>
		</td>
		<td><?php echo JText::_('ADSMANAGER_IMAGE_DISPLAY_LONG'); ?></td>
	</tr>
	<tr>
	  <td><?php echo JText::_('ADSMANAGER_MAX_CATIMAGE_WIDTH');?></td>
	  <td><input type="text" name="cat_max_width" value=<?php echo $this->conf->cat_max_width; ?> /></td>
	  <td><?php echo JText::_('ADSMANAGER_MAX_CATIMAGE_WIDTH_LONG');?></td>
    </tr>
    <tr>
	  <td><?php echo JText::_('ADSMANAGER_MAX_CATIMAGE_HEIGHT');?></td>
	  <td><input type="text" name="cat_max_height" value=<?php echo $this->conf->cat_max_height; ?> /></td>
	  <td><?php echo JText::_('ADSMANAGER_MAX_CATIMAGE_HEIGHT_LONG');?></td>
    </tr>
    <tr>
	  <td><?php echo JText::_('ADSMANAGER_MAX_CATTHUMBNAIL_WIDTH');?></td>
	  <td><input type="text" name="cat_max_width_t" value=<?php echo $this->conf->cat_max_width_t; ?> /></td>
	  <td><?php echo JText::_('ADSMANAGER_MAX_CATTHUMBNAIL_WIDTH_LONG');?></td>
    </tr>
    <tr>
	  <td><?php echo JText::_('ADSMANAGER_MAX_CATTHUMBNAIL_HEIGHT');?></td>
	  <td><input type="text" name="cat_max_height_t" value=<?php echo $this->conf->cat_max_height_t; ?> /></td>
	  <td><?php echo JText::_('ADSMANAGER_MAX_CATTHUMBNAIL_HEIGHT_LONG');?></td>
    </tr>	
</table>
<?php   
echo $tabs->endPanel();
echo $tabs->startPanel(JText::_('ADSMANAGER_TAB_TEXT'), "text-page");
?>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
	<tr>
		<td><?php echo JText::_('ADSMANAGER_FRONTPAGE'); ?></td>
		<td><?php echo $editor->display( 'fronttext',  $this->conf->fronttext, '100%', '350', '75', '20' ); ?></td>
		<td><?php echo JText::_('ADSMANAGER_FRONTPAGE_LONG'); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_RULES'); ?></td>
		<td><?php echo $editor->display( 'rules_text', $this->conf->rules_text , '100%', '350', '75', '20' ) ; ?></td>
		<td>&nbsp;</td>
	</tr>
</table>

<?php   
echo $tabs->endPanel();
echo $tabs->startPanel(JText::_('ADSMANAGER_TAB_EXPIRATION'), "Expiration-page");
?>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
<tr>
		<td><?php echo JText::_('ADSMANAGER_EXPIRATION'); ?></td>
		<td>
		<select id='expiration' name='expiration'>
			<option value='1' <?php if ($this->conf->expiration == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_YES'); ?></option>
			<option value='0' <?php if ($this->conf->expiration == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_NO'); ?></option>
		</select>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_AD_DURATION'); ?></td>
		<td><input type="text" name="ad_duration" value="<?php echo $this->conf->ad_duration; ?>" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_RECALL'); ?></td>
		<td>
		<select id='recall' name='recall'>
			<option value='1' <?php if ($this->conf->recall == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_YES'); ?></option>
			<option value='0' <?php if ($this->conf->recall == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_NO'); ?></option>
		</select>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_RECALL_TIME'); ?></td>
		<td><input type="text" name="recall_time" value="<?php echo $this->conf->recall_time; ?>" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><?php echo JText::_('ADSMANAGER_RECALL_TEXT'); ?></td>
		<td><?php echo $editor->display( 'recall_text', $this->conf->recall_text , '100%', '350', '75', '20' ) ; ?></td>
		<td>&nbsp;</td>
	</tr>
</table>   
<?php
echo $tabs->endPanel();
echo $tabs->endPane();
?>

<input type="hidden" name="option" value="com_adsmanager" />

<input type="hidden" name="task" value="" />

<input type="hidden" name="id" value=<?php echo $this->conf->id ?> />

<input type="hidden" name="c" value="configuration" />
</form> 