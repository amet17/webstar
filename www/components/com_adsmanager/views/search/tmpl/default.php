<script language="JavaScript" type="text/JavaScript">
<!--
function jumpmenu(target,obj,restore){
  eval(target+".location='"+obj.options[obj.selectedIndex].value+"'");	
  obj.options[obj.selectedIndex].innerHTML="<?php echo JText::_('ADSMANAGER_WAIT');?>";	
}		
//-->
</script>
<div class="adsmanager_search_box">
<div class="adsmanager_inner_box">
	<div align="left">
		<table>
			<tr>
				<td><?php echo JText::_('ADSMANAGER_FORM_CATEGORY'); ?></td>
				<td>
					<select name='category_choose' onchange="jumpmenu('parent',this)">			
					 <option value="<?php echo JRoute::_("index.php?option=com_adsmanager&view=search&catid=0&Itemid=".$this->Itemid); ?>" <?php if ($this->catid == 0) echo 'selected="selected"'; ?>><?php echo JText::_('ADSMANAGER_MENU_ALL_ADS'); ?></option>
					<?php
					 $link = "index.php?option=com_adsmanager&Itemid=".$this->Itemid."&view=search";
					 $this->selectCategories(0,"",$this->cats,$this->catid,1,$link,0); 
					?>
					</select>
				</td>
			</tr>
		</table> 
		<?php $link = JRoute::_("index.php?option=com_adsmanager&view=result&catid=".$this->catid."&Itemid=".$this->Itemid); ?>
		<form action="<?php echo $link ?>" method="post">
		<table>
			
			<?php 
			foreach($this->searchfields as $fsearch) {
				$this->field->showFieldSearch($fsearch,$this->catid);
			}?>			
		</table> 
		<input type="hidden" value="1" name="new_search" />
		<input type="submit" value="<?php echo JText::_('ADSMANAGER_SUBMIT_BUTTON'); ?>" />
		</form>
	</div>		  
</div>
</div>