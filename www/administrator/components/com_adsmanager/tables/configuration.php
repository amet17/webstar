<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

defined('_JEXEC') or die();

class TableConfiguration extends JTable
{
	var $id = null;
	var $version = null;
	var $ads_per_page = null;
	var $max_image_size = null;
	var $max_width = null; 
	var $max_height = null;
	var $max_width_t = null;
	var $max_height_t = null; 
	var $send_email_on_new = null;
	var $send_email_on_update = null;
	var $auto_publish = null;
	var $tag = null;
	var $fronttext = null;
	var $nb_images = null;
	var $show_contact = null;
	var $root_allowed = null;
	var $comprofiler = null;
	var $email_display = null;
	var $rules_text = null;
	var $display_last = null;
	var $display_expand = null;
	var $display_fullname = null;
	var $expiration = null;
	var $ad_duration = null;
	var $recall = null;
	var $recall_time = null;
	var $recall_text = null;
	var $image_display = null;
	var $cat_max_width = null;
	var $cat_max_height = null;
	var $cat_max_width_t = null;
	var $cat_max_height_t = null;
	var $submission_type = null;
	var $nb_ads_by_user = null;
	var $allow_attachement= null;
	var $allow_contact_by_pms = null;
	var $show_rss = null;
	var $nbcats = null;
	var $show_new = null;
	var $nbdays_new = null;
	var $show_hot = null;
	var $nbhits = null;
			
    function __construct(&$db)
    {
    	parent::__construct( '#__adsmanager_config', 'id', $db );
    }
}
