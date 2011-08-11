<?php if ($this->conf->display_last == 1)
{
	$this->displayContents($this->contents,$this->Itemid,$this->nbimages); 
}
?>
<h1 class="contentheading"><?php echo JText::_('ADSMANAGER_FRONT_TITLE'); ?></h1>
<div class="adsmanager_fronttext">
	<?php echo $this->conf->fronttext; ?>
</div>
<br />
<?php $this->general->showGeneralLink() ?>
<div id="home">
	<table width="90%" border="0" cellpadding="0" cellspacing="0">
	<?php
	$this->recurseCategories( 0, 0, $this->cats,$this->Itemid);
	?>
	</table>
</div>
<?php if ($this->conf->display_last == 2)
{
	$this->displayContents($this->contents,$this->Itemid,$this->nbimages); 
} $this->general->endTemplate();
