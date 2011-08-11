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
<div class="ja-twitter">
	
	<!-- ACCOUNT INFOMATION -->
	<?php if( $useDisplayAccount && !empty($accountInfo)): ?>
	<div class="ja-twitter-account">
		<?php include( JModuleHelper::getLayoutPath( 'mod_jatwitter', 'screen_name') ); ?>
	</div>
	<?php endif; ?>
	<!-- // ACCOUNT INFOMATION -->
	
	<!-- LISTING FRIENDS -->
	<?php if ( $useFriends && isset($friends) && is_array($friends) ): ?>
	<div class="ja-twitter-friends clearfix">
		<h4><?php echo  JText::_( 'MY FRIENDS' ); ?></h4>
		<?php foreach( $friends as $friend ) : ?>
			<a href="http://twitter.com/<?php echo $friend->screen_name; ?>" title="<?php echo $friend->name; ?>" target="_blank">
				<img width="<?php echo $sizeIconfriend; ?>" alt="<?php echo $friend->name; ?>" src="<?php echo $friend->profile_image_url; ?>" />	
			</a>	
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
	<!-- //LISTING FRIENDS -->
	
	<!-- LISTING TWEETS -->
	<?php if( is_array($list) && !empty($list) ) : ?>	
	<div class="ja-twitter-tweets">
	
		<?php foreach( $list as $item ) : ?>
		<div class="ja-twitter-item">
			<?php if( $showIcon ) : ?>
			<div class="ja-twitter-image">
		 		<a href="http://twitter.com/<?php echo $item->screen_name; ?>" target="_blank">
					<img src="<?php echo $item->profile_image_url; ?>" width="<?php echo $iconsize; ?>" alt="<?php echo $item->name; ?>" class="ja-twitter-avatar" />
				</a>
			</div>
			<?php endif ; ?>
			
			<?php if( $showSource ) : ?>
			<div class="ja-twitter-source">
				<?php echo JText::_( 'От' ); ?> <span><?php echo $item->source; ?></span>
			</div>
			<?php endif ; ?>
			
			<div class="ja-twitter-text">
				<?php if( $showUsername ) : ?>
			    <a href="http://twitter.com/<?php echo $item->screen_name; ?>" target="_blank"><?php echo $item->name; ?></a>
				<?php endif ; ?>
					
				<?php echo $jatHerlper->convert( $item->text ); ?>
			</div>
			<div class="ja-twitter-date" style="">
				<?php echo $jatHerlper->getDate( $item->created_at ); ?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>	
	<!-- //LISTING TWEETS -->
	
	<?php if ( $showfollowlink == "1" ){ ?>
	<center>
		<script src='http://platform.twitter.com/anywhere.js?id=<?php echo $apikey?>' type='text/javascript'></script>
		<div id="anywhere-block-follow-button-<?php echo $module->id?>"></div>
		<script type="text/javascript">
			twttr.anywhere(function(twitter) {
		  	twitter('#anywhere-block-follow-button-<?php echo $module->id?>').followButton("<?php echo $screenName?>");
				})
		</script>
	</center>
	<?php }  ?>
</div>
