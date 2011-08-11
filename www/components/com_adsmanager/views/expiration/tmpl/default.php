<?php echo sprintf(JText::_('ADSMANAGER_RENEW_AD_QUESTION'),$this->content->ad_headline,$this->content->expiration_date); 
$target = JRoute::_("index.php?option=com_adsmanager&task=renew&id=".$this->content->id."&Itemid=".$this->Itemid);
?>
<form action="<?php echo $target;?>" method="post" name="adminForm" enctype="multipart/form-data">
<table class="adsmanager_header">
   <?php
   if (function_exists("showPaidDuration")) {
		showPaidDuration($this->content->expiration_date);
   } else { ?>
  <tr>
  	<td><?php echo "&nbsp;"; ?></td>
  	<td>
    <?php 
       echo "<input type='submit' value='".JText::_('ADSMANAGER_RENEW_AD')."' />"; 
    ?>
    </td>
  </tr>
  <?php } ?>
  </table>
</form>