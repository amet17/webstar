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
<div id="ja_twitter_div" class="content">
	<?php if( $params->get('showtextheading') ) : ?>
	<h4><?php echo $params->get('headingtext'); ?></h4>
	<?php endif; ?>
	
	<!-- ACCOUNT INFOMATION -->
	<?php if( $useDisplayAccount && !empty($accountInfo)): ?>
	<div class="ja-twitter-account">
		<?php include( JModuleHelper::getLayoutPath( 'mod_jatwitter', 'screen_name') ); ?>
	</div>
	<?php endif; ?>
	<!-- // ACCOUNT INFOMATION -->
	
	<!-- LISTING TWEETS -->
	<?php if($displayitem) { ?>
	<div id="twitter_update_list">
		<img src="<?php echo JURI::base();?>modules/mod_jatwitter/assets/images/mootree_loader.gif" alt="Loader" />
	</div>
	<?php } ?>
	<!-- //LISTING TWEETS -->
	
	<!-- LISTING FRIENDS -->
	<?php if ( $useFriends && isset($friends) && is_array($friends) ): ?>
	<div class="ja-twitter-friends clearfix">
		<h4><?php echo  JText::_( 'MY FRIENDS' ); ?></h4>
		<?php foreach( $friends as $friend ) : ?>
		   <?php if(!empty($friend)): ?>
			<a href="http://twitter.com/<?php echo $friend->screen_name; ?>" title="<?php echo $friend->name; ?>" target="_blank">
				<img width="<?php echo $sizeIconfriend; ?>" alt="<?php echo $friend->name; ?>" src="<?php echo $friend->profile_image_url; ?>" />	
			</a>	
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
	<!-- //LISTING FRIENDS -->
	<?php if ( $showfollowlink == "1" ){ 
			echo $jatHelper->getFollowButton($params);
		 }  ?>
</div>
<?php if($displayitem) { ?>
<script type="text/javascript">
/* <![CDATA[ */
	var timer;
	window.addEvent('domready', function() {
		getTweets();	  
	}); 
	function getTweets()   
	{
		clearTimeout(timer);   
		var myVerticalSlide = new Fx.Slide('twitter_update_list');
		var myAjax = new Ajax( '<?php echo JURI::base();?>modules/mod_jatwitter/twitter.php',
							 { method: 'post',
							   data: {username:'<?php echo $taccount;?>',count:<?php echo $show_limit;?>, modid: '<?php echo $module->id;?>',show_icon:'<?php echo $showIcon?>',show_username:'<?php echo $showUsername?>',show_source:'<?php echo $showSource;?>',icon_size:'<?php echo $iconsize;?>', cache_time:<?php echo $cache_time;?>},
							 //  update:  $('twitter_update_list'),
							   onComplete:function( html ){
								   $('twitter_update_list').setHTML("");
								   $('twitter_update_list').setHTML(html);
							   
					}
		}).request();
		timer = setTimeout('getTweets()', 30000);  
	}
/* ]]> */	
</script>
<?php } ?>
