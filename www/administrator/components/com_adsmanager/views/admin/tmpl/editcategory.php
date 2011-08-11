<script type="text/javascript">
<?php if(version_compare(JVERSION,'1.6.0','>=')){ ?>
Joomla.submitbutton = function(pressbutton) {
<?php } else { ?>
function submitbutton(pressbutton) {
<?php } ?>
	   $editor=& JFactory::getEditor(); 
	   echo $editor->save( 'description' );
       submitform(pressbutton);
   }
</script>
<?php JText::_('ADSMANAGER_CATEGORY_EDITION'); ?>
<form action="index.php" method="post" name="adminForm" id="adminForm" class="adminForm" enctype="multipart/form-data">
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">

<tr>
<td><?php echo JText::_('ADSMANAGER_TH_TITLE'); ?></td>
<td><input type="text" size="50" maxsize="100" name="name" value="<?php echo @$this->row->name; ?>" /></td>
</tr>

<tr>
<td><?php echo JText::_('ADSMANAGER_TH_PARENT'); ?></td>
<td>
<select name="parent" id="parent">
<option value="0"><?php echo JText::_('ADSMANAGER_ROOT'); ?></option>
<?php $this->selectCategories(0,"Root >> ",$this->cats,@$this->row->parent,@$this->row->id); ?>
</select>
</td>
</tr>

<tr>
<td><?php echo JText::_('ADSMANAGER_TH_IMAGE'); ?></td>
<td>
<input type="file" name="cat_image"/>
<?php 
   $a_pic = JPATH_SITE."/images/com_adsmanager/categories/".@$this->row->id."cat.jpg";
   if (file_exists($a_pic)) 
   {
     echo '<img src="../images/com_adsmanager/categories/'.@$this->row->id.'cat.jpg?time='.time().'"/>';
     echo "<input type='checkbox' name='cb_image' value='delete'>".JText::_('ADSMANAGER_CONTENT_DELETE_IMAGE');
   }
?>
</td>
</tr>
<tr>
<td><?php echo JText::_('ADSMANAGER_TH_DESCRIPTION'); ?></td>
<td>
<?php
$editor =& JFactory::getEditor();
echo $editor->display('description', @$this->row->description, '100%','350', 75, 20);
?>				
</td>
<td><?php /*editorArea( 'editor1',   , 'description', '100%;', '350', '75', '20' ) ; */?></td>
</tr>
<tr>
<td><?php echo JText::_('ADSMANAGER_TH_PUBLISH'); ?></td>
<td>
<select name="published" id="published">
<option value="1" <?php if (@$this->row->published == 1) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_PUBLISH'); ?></option>
<option value="0" <?php if (@$this->row->published == 0) { echo "selected"; } ?>><?php echo JText::_('ADSMANAGER_NO_PUBLISH') ?></option>
</select>
</td>
</tr>

</table>
<input type="hidden" name="id" value="<?php echo @$this->row->id; ?>" />
<input type="hidden" name="option" value="com_adsmanager" />
<input type="hidden" name="c" value="categories" />
<input type="hidden" name="task" value="" />
</form>