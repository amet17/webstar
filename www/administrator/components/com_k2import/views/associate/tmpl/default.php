<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post" name="adminForm" class="k2import">




<?php
foreach ($this->k2fields as $k2field)
{

	$additional_num='';
	echo '<div class="k2importfield" id="k2importfield_'.$k2field['extra']. $k2field['id'].'">
		<div class="k2importtitle">'. $k2field['title'].'</div><div class="k2importselect">';
	 if ($k2field['id']=='attachment' || 
	 	 $k2field['id']=='attachment_title' || 
	 	 $k2field['id']=='attachment_title_attribute')
	 	 {
	 		echo '<div class="k2optionscount">[0]</div>';
	 		$additional_num=0;
	 	 }
	
	echo '<select name="k2import'.$k2field['extra'].'fields['. $k2field['id'].$additional_num.']" class="k2importfield" size="0">';
	echo '<option  value="" label="empty">take standard value or leave empty</option>';	
	for ($csv_header_num=0;$csv_header_num<count($this->csv_headers);$csv_header_num++)
	{
		echo '<option  value="'.$csv_header_num.'" label="'.$this->csv_headers[$csv_header_num].'">'.$this->csv_headers[$csv_header_num].'</option>';
	}
	
	echo '</select>
	</div>
	</div>
	';
}
?>
<script type="text/javascript">
var count_attachments=1;

function add_more_attachments()
{
	add_more_fields($('k2importfield_attachment'));
	add_more_fields($('k2importfield_attachment_title'));
	add_more_fields($('k2importfield_attachment_title_attribute'));
	count_attachments++;

}

function add_more_fields(k2importfield)
{
	var k2importselect=k2importfield.getLast(); 
	var new_k2importselect=k2importselect.clone();
	new_k2importselect.getFirst().setText('['+count_attachments+']');
	new_k2importselect.getLast().setProperty('name','k2importfields['+k2importfield.getProperty('id').substr(14)+count_attachments+']');
	new_k2importselect.injectAfter(k2importselect);

}

</script>

<input type="hidden" name="option" value="com_k2import" />
<input type="hidden" name="task" value="import" />
<input type="hidden" name="file" value="<?php echo $this->file;?>" />
<input type="hidden" name="controller" value="k2import" />
<input type="hidden" name="k2category" value="<?php echo $this->k2category; ?>" />
<input type="hidden" name="in_charset" value="<?php echo $this->in_charset; ?>" />
<input type="hidden" name="out_charset" value="<?php echo $this->out_charset; ?>" />

<button type="submit"><?php echo  JText::_( 'continue' ); ?></button>

</form>

<?php
/*
		echo "<pre>";
print_r($this->k2fields);
echo "</pre>";	
*/
?>