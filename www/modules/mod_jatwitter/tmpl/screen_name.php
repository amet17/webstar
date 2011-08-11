<?php
/*
# ------------------------------------------------------------------------
# JA Twitter module for joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/ 
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="ja-twitter-user">
	<div class="ja-twitter-wrapper">
	
 		<div class="ja-twitter-thumb clearfix">
		 <a href="http://twitter.com/<?php echo $accountInfo->screen_name; ?>" title="<?php echo $accountInfo->name; ?>" target="_blank">
			<img width="<?php echo $sizeIconaccount; ?>" src="<?php echo $accountInfo->profile_image_url;?>" alt="<?php echo $accountInfo->name; ?>" class="ja-twitter-avatar" />
		</a>
	   
	  <h3><a href="http://twitter.com/<?php echo $accountInfo->screen_name; ?>" target="_blank"><?php echo $accountInfo->name; ?></a></h3>
	  </div>
	    
    <ul>
		<?php if(!empty($accountInfo->location)) : ?>
    	<li><strong><?php echo JText::_( 'LOCATION' ); ?></strong> <?php echo $accountInfo->location; ?></li>
    <?php endif; ?>
	    
    <?php if( !empty($accountInfo->url) ) : ?>
    	<li><strong><?php echo JText::_( 'WEB' ); ?></strong> <a href="<?php echo $accountInfo->url; ?>"><?php echo $accountInfo->url; ?></a></li>
    <?php endif; ?>
        
		<?php if( !empty($accountInfo->description) ) : ?>
	    <li><strong><?php echo JText::_( 'BIO' ); ?></strong> <?php echo $accountInfo->description; ?></li>
    <?php endif; ?>
    </ul>
        
    <ul>
    	<li>
			<?php echo $accountInfo->friends_count; ?>
			<?php echo JText::_( 'FOLLOWING' ); ?>
		</li>
		<li>
			<?php echo $accountInfo->followers_count; ?>
			<?php echo JText::_( 'FOLLOWERS' ); ?>
		</li>
		<li>
			<?php echo $accountInfo->statuses_count; ?>
			<?php echo JText::_( 'TWEETS' ); ?>
		</li>
	</ul>
		
	</div>
</div>
