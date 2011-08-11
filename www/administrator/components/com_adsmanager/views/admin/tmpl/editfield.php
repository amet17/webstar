<script type="text/javascript">
  function getObject(obj) {
    var strObj;
    if (document.all) {
      strObj = document.all.item(obj);
    } else if (document.getElementById) {
      strObj = document.getElementById(obj);
    }
    return strObj;
  }
  
   function showimage(preview,obj) {
		//if (!document.images) return;
		var img = getObject(preview);
		img.src = '<?php echo $this->baseurl."/images/com_adsmanager/";?>/fields/' + getSelectedValue( obj );
	}
	
	function getSelectedValue(obj) {
		i = obj.selectedIndex;
		if (i != null && i > -1) {
			return obj.options[i].value;
		} else {
			return null;
		}
	}
  
   <?php if(version_compare(JVERSION,'1.6.0','>=')){ ?>
   Joomla.submitbutton = function(pressbutton) {
   <?php } else { ?>
   function submitbutton(pressbutton) {
   <?php } ?>
    if (pressbutton == 'cancel') {
	   submitform(pressbutton);	
	   return;
    }
     if (pressbutton == 'showField') {
       document.adminForm.type.disabled=false;
       submitform(pressbutton);
       return;
     }
     var coll = document.adminForm;
     var errorMSG = '';
     var iserror=0;
     if (coll != null) {
       var elements = coll.elements;
       // loop through all input elements in form
       for (var i=0; i < elements.length; i++) {
         // check if element is mandatory; here mosReq=1
         if (elements.item(i).getAttribute('mosReq') == 1) {
           if (elements.item(i).value == '') {
             //alert(elements.item(i).getAttribute('mosLabel') + ':' + elements.item(i).getAttribute('mosReq'));
             // add up all error messages
             errorMSG += elements.item(i).getAttribute('mosLabel') + ' : <?php echo JText::_('ADSMANAGER_REGWARN_ERROR'); ?>\n';
             // notify user by changing background color, in this case to red
             elements.item(i).style.background = "red";
             iserror=1;
           }
         }
       }
     }
     if(iserror==1) {
       alert(errorMSG);
     } else {
       document.adminForm.type.disabled=false;
       submitform(pressbutton);
     }
   }

  function insertRow() {
    var oTable = getObject("fieldValuesBody");
    var oRow, oCell ,oCellCont, oInput;
    var oCell2 ,oCellCont2, oInput2;
    var i, j;
    i=document.adminForm.valueCount.value;
    i++;
    // Create and insert rows and cells into the first body.
    oRow = document.createElement("TR");
    oTable.appendChild(oRow);

    oCell = document.createElement("TD");
    oCell = document.createElement("TD");
    oInput=document.createElement("INPUT");
    oInput.name="vNames["+i+"]";
    oInput.setAttribute('mosLabel','Name');
    oInput.setAttribute('mosReq',0);
    oCell.appendChild(oInput);
    oCell2 = document.createElement("TD");
    oInput2=document.createElement("INPUT");
    oInput2.name="vValues["+i+"]";
    oInput2.setAttribute('mosLabel','Name');
    oInput2.setAttribute('mosReq',0); 
    oCell2.appendChild(oInput2);
     
    oRow.appendChild(oCell);
    oRow.appendChild(oCell2);
    oInput.focus();

    document.adminForm.valueCount.value=i;
  }
  
  function insertImageRow() {
    var oTable = getObject("ImagesfieldValuesBody");
    var oRow, oCell ,oCellCont;
    var oCell2 ,oCellCont2, oInput2,oImage,oSelect,oOption;
    var i, j,k;
    i=document.adminForm.ImagevalueCount.value;
    i++;
    // Create and insert rows and cells into the first body.
    oRow = document.createElement("tr");
    oTable.appendChild(oRow);

    oCell = document.createElement("td");
    oSelect=document.createElement("select");
    oSelect.onchange = function(){
		showimage('preview'+i,this); //Gestion de la particularite d'ie qui n'accepte pas d'ajouter un evement avec setAttribute. ie ignore la ligne au dessus, ff ignore cette ligne
	}
    oSelect.id = 'vSelectImages['+i+']';
    oSelect.name = 'vSelectImages['+i+']';
    k=0;
	oSelect.length++;
	oSelect.options[0].text= 'No Image';
	oSelect.options[0].value= 'null';
	<?php 
	if(isset($this->fieldimages)) {
	foreach($this->fieldimages as $image) {
	?>
	k++;
	oSelect.length++;
	oSelect.options[k].text= '<?php echo $image; ?>';
	oSelect.options[k].value= '<?php echo $image; ?>';
	<?php
	}
	}
	?>
	oCell.appendChild(oSelect);
	oImage = document.createElement("img");
	oImage.setAttribute('src',"");
	oImage.setAttribute('id',"preview"+i);
	oImage.setAttribute('name',"preview"+i);
	oCell.appendChild(oImage);		
    oCell2 = document.createElement("td");
    oInput2=document.createElement("input");
    oInput2.name="vImagesValues["+i+"]";
    oInput2.setAttribute('mosLabel','Value');
    oInput2.setAttribute('mosReq',0); 
    oCell2.appendChild(oInput2);
     
    oRow.appendChild(oCell);
    oRow.appendChild(oCell2);
    oSelect.focus();

    document.adminForm.ImagevalueCount.value=i;
  }


  function disableAll() {
    var elem;
	elem=getObject('divCB');
    elem.style.visibility = 'hidden';
    elem.style.display = 'none';
    elem=getObject('divValues');
    elem.style.visibility = 'hidden';
    elem.style.display = 'none';
	elem=getObject('divImagesValues');
    elem.style.visibility = 'hidden';
	elem.style.display = 'none';
    elem=getObject('divColsRows');
    elem.style.visibility = 'hidden';
    elem.style.display = 'none';
    elem=getObject('divText');
    elem.style.visibility = 'hidden';
    elem.style.display = 'none';
    if (elem=getObject('vNames[0]')) {
      elem.setAttribute('mosReq',0);
    }
    if (elem=getObject('vValues[0]')) {
      elem.setAttribute('mosReq',0);
    }
	if (elem=getObject('vImagesValues[0]')) {
      elem.setAttribute('mosReq',0);
    }
	
	elem=getObject('divLink');
    elem.style.visibility = 'hidden';
    elem.style.display = 'none';
	
	<?php
		if(isset($this->plugins))
		{
			foreach($this->plugins as $key => $plug) {
				echo $plug->getEditFieldJavaScriptDisable()."\n";
			}
		}
	?>
  }
  
  function selType(sType) {
    var elem;
    //alert(sType);
    switch (sType) {
      case 'editorta':
      case 'textarea':
        disableAll();
        elem=getObject('divText');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        elem=getObject('divColsRows');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
      break;
      
      case 'emailaddress':
      case 'number':
      case 'password':
      case 'text':
        disableAll();
        elem=getObject('divText');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
      break;
	  
	  case 'price':
		disableAll();
        elem=getObject('divText');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
		elem=getObject('divValues');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        if (elem=getObject('vNames[0]')) {
          elem.setAttribute('mosReq',1);
        }
        if (elem=getObject('vValues[0]')) {
		  elem.setAttribute('mosReq',1);
		}
		break;
	  
	  case 'url':
		disableAll();
        elem=getObject('divText');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        elem=getObject('divLink');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        break;
      
      case 'select':
      case 'multiselect':
        disableAll();
		elem=getObject('divCB');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        elem=getObject('divValues');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        if (elem=getObject('vNames[0]')) {
          elem.setAttribute('mosReq',1);
        }
        if (elem=getObject('vValues[0]')) {
		  elem.setAttribute('mosReq',1);
		}
      break;
	  
	  case 'radioimage':
      case 'multicheckboximage':
		disableAll();
        elem=getObject('divColsRows');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        elem=getObject('divImagesValues');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        if (elem=getObject('vSelectImages[0]')) {
          elem.setAttribute('mosReq',2);
        }
        if (elem=getObject('vImagesValues[0]')) {
          elem.setAttribute('mosReq',1);
        }
        break;
      
      case 'radio':
      case 'multicheckbox':
        disableAll();
		elem=getObject('divCB');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        elem=getObject('divColsRows');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        elem=getObject('divValues');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        if (elem=getObject('vNames[0]')) {
          elem.setAttribute('mosReq',1);
        }
        if (elem=getObject('vValues[0]')) {
          elem.setAttribute('mosReq',1);
        }
      break;
	  
	  <?php
		if(isset($this->plugins))
		{
			foreach($this->plugins as $key => $plug) {
				echo "case '$key':\n";
				echo $plug->getEditFieldJavaScriptActive()."\n";
				echo "break;\n";
			}
		}
	  ?>

      case 'delimiter':
      default: 
        disableAll();
    }
  }

  function prep4SQL(o){
	if(o.value!='') {
		o.value=o.value.replace('ad_','');
    		o.value='ad_' + o.value.replace(/[^a-zA-Z]+/g,'');
	}
  }

</script>
<form action="index.php?option=com_adsmanager" method="POST" name="adminForm" id="adminForm">
<table cellspacing="0" cellpadding="0" width="100%">
<tr valign="top">
	<td width="60%">
		<table class="adminform">
			<th colspan="3">
				<td>Parameters</td>
			</th>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_TYPE');?></td>
				<td width="20%"><?php echo $this->lists['type']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_NAME');?></td>
				<td align=left  width="20%"><input onchange="prep4SQL(this);" type="text" name="name" mosReq=1 mosLabel="Name" class="inputbox" value="<?php echo @$this->field->name; ?>" /></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_TITLE');?></td>
				<td width="20%" align=left><input type="text" name="title" mosReq=1 mosLabel="Title" class="inputbox" value="<?php echo @$this->field->title; ?>" /></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_DISPLAY_TITLE');?></td>
				<td width="20%"><?php echo $this->lists['display_title']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_DESCRIPTION');?></td>
				<td width="20%" align=left><input type="text" name="description" mosLabel="Description" size="40" value="<?php echo @$this->field->description; ?>" /></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_REQUIRED');?></td>
				<td width="20%"><?php echo $this->lists['required']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_COLUMN');?></td>
				<td width="20%"><?php echo $this->lists['columns']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_COLUMN_ORDER');?></td>
				<td width="20%" align=left><input type="text" name="columnorder" mosLabel="Title" class="inputbox" value="<?php echo @$this->field->columnorder; ?>" /></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_POSITION_DISPLAY');?></td>
				<td width="20%"><?php echo $this->lists['positions']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_POSITION_ORDER');?></td>
				<td width="20%" align=left><input type="text" name="posorder" mosLabel="Title" class="inputbox" value="<?php echo @$this->field->posorder; ?>" /></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_PUBLISHED');?></td>
				<td width="20%"><?php echo $this->lists['published']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_SEARCHABLE');?></td>
				<td width="20%"><?php echo $this->lists['searchable']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_EDITABLE');?></td>
				<td width="20%"><?php echo $this->lists['editable']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_PROFILE');?></td>
				<td width="20%"><?php echo $this->lists['profile']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_CB');?></td>
				<td width="20%"><?php echo $this->lists['cbfields']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_SORT_OPTION');?></td>
				<td width="20%"><?php echo $this->lists['sort']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_SORT_DIRECTION');?></td>
				<td width="20%"><?php echo $this->lists['sort_direction']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_SIZE');?></td>
				<td width="20%"><input type="text" name="size" mosLabel="Size" class="inputbox" value="<?php echo @$this->field->size; ?>" /></td>
				<td>&nbsp;</td>
			</tr>
		</table>
		<div id="divText"  class="pagetext">
			<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
				<tr>
					<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_MAX_LENGTH');?></td>
					<?php
						if (!isset($this->field->maxlength)||($this->field->maxlength ==""))
							$this->field->maxlength = 20;
					?>
					<td width="20%"><input type="text" name="maxlength" mosLabel="Max Length" class="inputbox" value="<?php echo $this->field->maxlength; ?>" /></td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</div>
		<div id="divCB"  class="pagetext">
			<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
				<tr>
					<td width="20%"><?php echo JText::_('ADSMANAGER_CBFIELDVALUES');?></td>
					<td width="20%"><?php echo $this->lists['cbfieldvalues']; ?></td>
					<td><?php echo JText::_('ADSMANAGER_CBFIELDVALUES_LONG');?></td>
				</tr>
			</table>
		</div>
		<div id="divLink" class="pagetext">
			<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
				<tr>
					<td width="20%"><?php echo JText::_('ADSMANAGER_LINK_TEXT');?></td>
					<td width="20%"><input type="text" name="link_text" mosLabel="Link Text" class="inputbox" value="<?php echo @$this->field->link_text; ?>" /></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="20%"><?php echo JText::_('ADSMANAGER_LINK_IMAGE');?></td>
					<td width="20%">
						<select id='link_image' mosLabel='Image' mosReq=0 name='link_image' onchange="showimage('previewlink',this)">
							<option value='null' selected="selected">No Image</option>
							<?php 
							if (isset($this->fieldimages))
							{
							foreach($this->fieldimages as $image) {
							?>
							<option value='<?php echo $image; ?>' <?php if (@$this->field->link_image == $image) { echo "selected"; } ?>><?php echo $image; ?></option>
							<?php
							}
							}
							?>
						</select>
					
					</td>
					<td>
						<img src="<?php echo $this->baseurl."/images/com_adsmanager/fields/".@$this->field->link_image; ?>" id='previewlink' name="previewlink" />
					</td>
				</tr>
			</table>
		</div>
		<div id="divColsRows"  class="pagetext">
			<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
				<tr>
					<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_COLS');?></td>
					<td width="20%"><input type="text" name="cols" mosLabel="Cols" class="inputbox" value="<?php echo @$this->field->cols; ?>" /></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="20%"><?php echo JText::_('ADSMANAGER_FIELD_ROWS');?></td>
					<td width="20%"><input type="text" name="rows"  mosLabel="Rows" class="inputbox" value="<?php echo @$this->field->rows; ?>" /></td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</div>
		<div id="divValues" style="text-align:left;">
			<?php echo JText::_('ADSMANAGER_FIELD_VALUES_EXPLANATION');?>
			<input type=button onclick="insertRow();" value="Add a Value" />
			<table align=left id="divFieldValues" cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform" >
				<tr>
					<th width="20%"><?php echo JText::_('ADSMANAGER_FIELD_VALUE_NAME');?></th>
					<th width="20%"><?php echo JText::_('ADSMANAGER_FIELD_VALUE_VALUE');?></th>
				</tr>
				<tbody id="fieldValuesBody">
				<tr>
					<td>&nbsp;</td><td>&nbsp;</td>
				</tr>
				<?php	
					//echo "count:".count( $fieldvalues );
					//print_r (array_values($fieldvalues));
					for ($i=0, $n=count( $this->fieldvalues ); $i < $n; $i++) {
						//print "count:".$i;
						$fieldvalue = @$this->fieldvalues[$i];
						if ($i==0) $req =1;
						else $req = 0;
						echo "<tr>\n<td width=\"20%\"><input type=text mosReq=0  mosLabel='Name' value='".htmlspecialchars(@$fieldvalue->fieldtitle)."' name=vNames[$i] /></td>\n<td width=\"20%\"><input type=text mosReq=0 mosLabel='Value' value='".htmlspecialchars(@$fieldvalue->fieldvalue)."' name=vValues[$i] /></td>\n</tr>\n";
					}
					if ($i > 0)
						$i--;
					if(count( $this->fieldvalues )< 1) {
						echo "<tr>\n<td width=\"20%\"><input type=text mosReq=0  mosLabel='Name' value='' name=vNames[0] /></td>\n<td width=\"20%\"><input type=text mosReq=0  mosLabel='Value' value='' name=vValues[0] /></td>\n</tr>\n";
						$i=0;
					}
				?>
			</tbody>
			</table>
		</div>
		<div id="divImagesValues" style="text-align:left;">
			<?php echo JText::_('ADSMANAGER_IMAGE_FIELD_VALUES_EXPLANATION');?>
			<input type=button onclick="insertImageRow();" value="Add a Value" />
			<table align=left id="divImagesFieldValues" cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform" >
				<tr>
					<th width="20%"><?php echo JText::_('ADSMANAGER_FIELD_VALUE_IMAGE');?></th>
					<th width="20%"><?php echo JText::_('ADSMANAGER_FIELD_VALUE_VALUE');?></th>
				</tr>
				<tbody id="ImagesfieldValuesBody">
				<tr>
					<td>&nbsp;</td><td>&nbsp;</td>
				</tr>
				<?php	
				for ($j=0, $n=count( $this->fieldvalues ); $j < $n; $j++) {
					$fieldvalue = @$this->fieldvalues[$j];
					if ($j==0)
						$req =1;
					else 
						$req = 0;
				?>
				<tr>
					<td width="20%">
						<select id='vSelectImages[<?php echo $j; ?>]' mosLabel='Image' mosReq=0 name='vSelectImages[<?php echo $j; ?>]' onchange="showimage('preview<?php echo $j; ?>',this)">
							<option value='null' selected="selected">No Image</option>
							<?php 
							if (isset($this->fieldimages))
							{
							foreach($this->fieldimages as $image) {
							?>
							<option value='<?php echo $image; ?>' <?php if (@$fieldvalue->fieldtitle == $image) { echo "selected"; } ?>><?php echo $image; ?></option>
							<?php
							}
							}
							?>
						</select>
						<img src="<?php echo $this->baseurl."/images/com_adsmanager/fields/".htmlspecialchars(@$fieldvalue->fieldtitle); ?>" id='preview<?php echo $j; ?>' name="preview<?php echo $j; ?>" alt="<?php echo "".@$this->field->image;?>" />
					</td>
					<td width="20%">
						<input type=text mosReq=0  mosLabel='Value' value='<?php echo htmlspecialchars(@$fieldvalue->fieldvalue); ?>' name='vImagesValues[<?php echo $j; ?>]' id='vImagesValues[<?php echo $j; ?>]' />
					</td>
				</tr>
				<?php
				}
				if ($j > 0)
					$j--;
				if(count( $this->fieldvalues )< 1) {
				?>
				<tr>
					<td width="20%">
						<select id='vSelectImages[0]' name='vSelectImages[0]' mosReq=0 mosLabel='Image'  onchange="showimage('preview0',this)">
							<option value='null' selected="selected">No Image</option>
							<?php
							if (isset($this->fieldimages))
							{
							foreach($this->fieldimages as $image) {
							?>
							<option value='<?php echo $image; ?>'><?php echo $image; ?></option>
							<?php
							}
							}
							?>
						</select>
					<img src="" id='preview0' name="preview0" />
					</td>
					<td width="20%">
						<input type=text mosReq=0  mosLabel='Value' value='' name='vImagesValues[0]' id='vImagesValues[0]' />
					</td>
				</tr>
					<?php
					$j=0;
				}
			?>
				</tbody>
			</table>
		</div>
		<?php
		if(isset($this->plugins))
			foreach($this->plugins as $key => $plug) {
				echo $plug->getEditFieldOptions(@$this->field->fieldid);
			} 
		?>
	  </td>
	  <td width="40%">
		  <table class="adminform">
				<th><?php echo JText::_('ADSMANAGER_FORM_CATEGORY'); ?></th>
				<tr><td>	
					<select name="field_catsid[]" multiple='multiple' id="field_catsid[]" size="<?php echo $this->nbcats+2;?>">
					<?php
					if (strpos(@$this->field->catsid, ",-1,") === false)
						echo "<option value='-1'>".JText::_('ADSMANAGER_MENU_ALL_ADS')."</option>";
					else
						echo "<option value='-1' selected>".JText::_('ADSMANAGER_MENU_ALL_ADS')."</option>";
					$this->selectCategories(0,"",$this->cats,-1,-1,1,@$this->field->catsid);
					?>
					</select>
				</td></tr>
		  </table>
  		</td></tr>
  </table>
  <input type="hidden" name="valueCount" value=<?php echo $i; ?> />
  <input type="hidden" name="ImagevalueCount" value=<?php echo $j; ?> />
  <input type="hidden" name="fieldid" value="<?php echo @$this->field->fieldid; ?>" />
  <input type="hidden" name="ordering" value="<?php echo @$this->field->ordering; ?>" />
  <input type="hidden" name="option" value="com_adsmanager" />
  <input type="hidden" name="c" value="fields" />
  <input type="hidden" name="task" value="" />
</form>
  
<?php 
if(@$this->field->fieldid > 0) {
	print "<script type=\"text/javascript\"> document.adminForm.name.readOnly=true; </script>";	
	/*print "<script type=\"text/javascript\"> document.adminForm.type.disabled=true; </script>";*/
}

print "<script type=\"text/javascript\"> disableAll(); </script>";
print "<script type=\"text/javascript\"> selType('".@$this->field->type."'); </script>";	