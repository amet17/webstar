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
?>
 <?php if( is_array($list) && !empty($list) ) : ?>	
		<div class="ja-twitter">
		
			<?php foreach( $list as $item ) : ?>
			<div class="ja-twitter-item clearfix">
				<?php if( $showIcon ) : ?>
				<div class="ja-twitter-image">
			 		<a href="http://twitter.com/<?php echo $item->screen_name; ?>" target="_blank">
						<img src="<?php echo $item->profile_image_url; ?>" width="<?php echo $iconsize; ?>" alt="<?php echo $item->name; ?>" class="ja-twitter-avatar" />
					</a>
				</div>
				<?php endif ; ?>
				<?php if( $showSource || $showUsername ) : ?>
						<span class="ja-twitter-bubble-arrow">&nbsp;</span>
						<div class="ja-twwitter-desc">
							<?php if( $showSource ) : ?>
							<div class="ja-twitter-source">
								<?php echo JText::_('FROM'); ?> <span><?php echo $item->source; ?></span>
							</div>
							<?php endif ; ?>
							
							<div class="ja-twitter-text">
								<?php if( $showUsername ) : ?>
								<a href="http://twitter.com/<?php echo $item->screen_name; ?>" target="_blank"><?php echo $item->name; ?></a>
								<?php endif ; ?>
									
								<?php echo $jatTwitter->convert( $item->text ); ?>
							</div>
							<div class="ja-twitter-date" style="">
								<?php echo $jatTwitter->getDate( $item->created_at ); ?>
							</div>
						</div>
			<?php endif; ?>	
			</div>
			<?php endforeach; ?>
		</div>
<?php endif; ?>