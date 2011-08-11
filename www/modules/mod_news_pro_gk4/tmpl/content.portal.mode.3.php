<?php

/**
* Default template
* @package Gavick News Show Pro GK4
* @Copyright (C) 2009-2011 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 4.3.0.0 $
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

$news_amount = $this->parent->config['news_portal_mode_3_amount'];

?>

<?php if($news_amount > 0) : ?>
<div class="nsp_main_portal_mode3 nsp_fs<?php echo $this->parent->config['module_font_size']; ?>" id="nsp-<?php echo $this->parent->config['module_id']; ?>">
	<?php if($this->parent->config['news_portal_mode_3_amount'] > 0) : ?>
	<div class="nsp_titles">
		<?php for($i = 0; $i < count($news_title_tab); $i++) : ?>
		<div class="nsp_title_block">	
			<?php 
				echo $news_title_tab[$i];
				echo $news_content_tab[$i];
			?>
		</div>
		<?php endfor; ?>	
	</div>
	<?php endif; ?>
</div>
<?php else : ?>
<p><?php echo JText::_('NSP_ERROR'); ?></p>
<?php endif; ?>