<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm">

<table>
<tr>
<td><?php echo  JText::_( 'Main Category' ); ?></td>
<td>
<select name="k2category" size="0">
<option  value="take_from_csv" >Take from CSV</option>
<?php
foreach ($this->k2categories as $k2category)
{


		echo '<option  value="'.$k2category->id.'" >'.$k2category->name.'</option>';
		//echo $k2category->id.' '.$k2category->name;
	

}
?>

</select>
</td>
</tr>
<tr>
<td>
<?php echo  JText::_( 'File charset' ); ?>
</td>
<td>
<input type="text" name="in_charset" value="UTF-8" size=8 maxlength=20/>
<?php echo  JText::_( '<a href="http://www.php.net/manual/en/function.iconv.php">iconv()</a> will be uses to convert');?>
</td>
</tr>
<tr>
<td>
<?php echo  JText::_( 'Database charset' ); ?>
</td>
<td>
<input type="text" name="out_charset" value="UTF-8" size=8 maxlength=20/>

<?php echo  JText::_( '<a href="http://www.php.net/manual/en/function.iconv.php">iconv()</a> will be uses to convert');?>
</td>
</tr>
</table>

<br>

<input type="hidden" name="option" value="com_k2import" />
<input type="hidden" name="task" value="associate" />
<input type="hidden" name="file" value="<?php echo $this->file; ?>" />
<input type="hidden" name="controller" value="k2import" />
<button type="submit"><?php echo  JText::_( 'continue' ); ?></button>
</form>

<?php


?>