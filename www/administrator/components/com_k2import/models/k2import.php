<?php
 
/**
 * K2import Model for K2import Component
 * 
 * @package    K2import
 * @link http://www.individual-it.net
 * @license		GNU/GPL
 */ 
 

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );


class K2importModelK2import extends JModel
{

	var $_data = array();
	var $_header;
	var $_categories;
	var $_extra_fields;
	var $_k2_item_id;


function save($k2fieldlist,$field_values,$k2category,$extrafield_values,$extrafield_search_values,$tags)
{
	
	date_default_timezone_set('UTC');

	$query="INSERT INTO `#__k2_items` ( ".$k2fieldlist.",
													`catid`, 
													`created`,
													`modified`,
													`extra_fields`,
													`extra_fields_search`)
								VALUES (" .$field_values . ",".
											  $this->_db->getEscaped((int)$k2category) . 
											  ", '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."','".
											  $this->_db->getEscaped($extrafield_values). "',".
											  $this->_db->Quote($this->_db->getEscaped($extrafield_search_values)). ")";															

			
	$this->_db->setQuery($query);
	$this->_db->query();

	$this->_k2_item_id=$this->_db->insertid();
	if ($this->_k2_item_id<=0)
	{
		$jAp=& JFactory::getApplication();
		$jAp->enqueueMessage(nl2br($this->_db->getErrorMsg()),'error'); 
		return;				
				
	}

	foreach ($tags as $tag) 
	{
		if (!isset($tag->id))
		{
			$this->_db->setQuery("INSERT INTO `#__k2_tags` (`name`,`published`) 
								  VALUES ('".$this->_db->getEscaped($tag->name)."',1)");
			$this->_db->query();
			$tag->id=$this->_db->insertid();
		}
			
		$this->_db->setQuery("INSERT INTO `#__k2_tags_xref` (`tagID` ,`itemID`) 
							  VALUES (".(int)$tag->id.",".(int)$this->_k2_item_id.")");
		$this->_db->query();				
				
	}
			
	return $this->_k2_item_id;			
				
	
}


	/**
	 * Retrieves the header-line from the CSV-file
	 * @return array with the header fields
	 */
	function getHeader($file)
	{
		$mainframe = JFactory::getApplication();
		// Lets load the data if it doesn't already exist
		if (empty( $this->_header ))
		{
			$fDestName= $mainframe->getCfg('tmp_path') . DS . $file;
			if (($handle = fopen($fDestName, "r")) !== FALSE) 
			{	

					$this->_header = fgetcsv($handle, 0, ",");
			}
		}

		return $this->_header;
	}


	/**
	 * Retrieves the data from the CSV-file
	 * @return array with the data
	 */
	function getData($file,$in_charset,$out_charset)
	{
		$mainframe = JFactory::getApplication();
		
		// Lets load the data if it doesn't already exist
		if (empty( $this->_data ))
		{
			$fDestName= $mainframe->getCfg('tmp_path') . DS . $file;
			if (($handle = fopen($fDestName, "r")) !== FALSE) 
			{	
		//	echo $fDestName;
				while (($data = fgetcsv($handle, 0, ",")) !== FALSE) 
				{
				//	encode the strings with the json encoding
					$data_new=array();				
					foreach ($data as $data_item)
					{	
						if ($in_charset!=$out_charset)
							$data_item =iconv($in_charset,$out_charset.'//TRANSLIT',$data_item);						
							
						array_push($data_new, $data_item);
					}

					array_push($this->_data, $data_new);
				}
			}
			else {echo "cannot open file";}
		}
		 
		 return $this->_data;
	}

/*
	 * @return array with the all needed K2fields including all extra_fields
	 */
	function getK2fields($category)
	{	
	
		if (empty($this->_extra_fields))
		{
			$this->_extra_fields = array(array('id'=>'title','title'=>'Заголовок'),
								 array('id'=>'introtext','title'=>'Краткое описание'),
								 array('id'=>'fulltext','title'=>'Полное описание'),
								 array('id'=>'tags','title'=>'Теги (разделенные запятой)'),
								 array('id'=>'published','title'=>'Публикация (1 или 0)'),
								 array('id'=>'alias','title'=>'Alias'), 
								 array('id'=>'image','title'=>'Картинка (путь к картинке)'),
								 array('id'=>'video','title'=>'Видео (embeded code)'),								 
								 array('id'=>'ordering','title'=>'Порядок (число)'),
								 array('id'=>'featured','title'=>'Featured (1 or 0)'),
								 array('id'=>'featured_ordering','title'=>'Featured ordering (int)'),
								 array('id'=>'image_caption','title'=>'Image caption'),
								 array('id'=>'image_credits','title'=>'Image credits'),
								 array('id'=>'video_caption','title'=>'Video caption'),								 
								 array('id'=>'video_credits','title'=>'Video credits'),
								 array('id'=>'attachment','title'=>'Attachment (path to an existing file on your server) <a href="javascript:add_more_attachments()">add more</a>'),
								 array('id'=>'attachment_title','title'=>'Attachment title'),								 
								 array('id'=>'attachment_title_attribute','title'=>'Attachment title attribute'),								 
								 array('id'=>'created_by','title'=>'User ID'),
								 array('id'=>'publish_up','title'=>'Дата публикации: 2010-11-25 09:40:08'),
								 array('id'=>'k2category_name','title'=>'Категория'),
								 
								 );
			
			
			if ($category!='take_from_csv')
			{
				$query = "SELECT f.id, f.name as title, f.value, f.type, 'extra'
							FROM `#__k2_categories` AS cats, 
									#__k2_extra_fields_groups AS groups, 
									#__k2_extra_fields AS f 
							WHERE cats.extraFieldsGroup = groups.id
								AND groups.id = f.group
								AND f.published =1
								AND cats.id =".(int)$category."
							ORDER BY f.ordering";
							
							
				$this->_db->setQuery($query);		
				
				$jAp=& JFactory::getApplication();
		
		
				if (is_null($extra_fields = $this->_db->loadAssocList())) {$jAp->enqueueMessage(nl2br($this->_db->getErrorMsg()),'error'); return;}	
		
				$this->_extra_fields = array_merge($this->_extra_fields, $extra_fields);
			}
		}
		
		return $this->_extra_fields;
	}
	
	
/*
	 * @return object array with all K2 categories
	 */
	function getK2categories()
	{	
	
		if (empty( $this->_categories ))
		{
			$query = "SELECT id,name FROM `#__k2_categories` WHERE trash=0";
			$this->_categories = $this->_getList( $query );

		}
		
		
		return $this->_categories;
	}	
	
/*
 * @creates a new category with the given name and the parent id and returns the new id
 */
	function createK2category($category_name,$parent_id=0)
	{
		$this->_db->setQuery("INSERT INTO `#__k2_categories` (`name`,`published`,`parent`, `access`,`trash`) 
								  VALUES ('".$this->_db->getEscaped($category_name)."',1,'".(int)$parent_id."','1','0')");
		$this->_db->query();
		return $this->_db->insertid();
		
	}	
	
/*
	 * @return object array with all K2 tags
	 * if the tag has an id, then its already in the database, if not we have to create a new tag
	 */
	function getK2tags($csvtags)
	{	
	
		
		foreach ($csvtags as $csvtag)
		{
			if (trim($csvtag)!='')
			{
				if (strlen($search_tags)>0)
					$search_tags .= ',';					
							
				$search_tags.= "'". $this->_db->getEscaped($csvtag) ."'";
			}
		}
		if (strlen($search_tags)>0)
		{
			$query = "SELECT id,name FROM `#__k2_tags` WHERE name IN(".$search_tags.")";
			$k2tags = $this->_getList( $query );
			
		}
		
		foreach ($csvtags as $csvtag)
		{
			$found_tag=false;
			foreach ($k2tags as $k2tag)
			{
				if ($k2tag->name==$csvtag)
				{
					$found_tag=true;
					continue;
				}
			}
			
			if (!$found_tag)
			{
				$csvtag_obj=new stdClass();
				$csvtag_obj->name=$csvtag;
				array_push($k2tags, $csvtag_obj);
			}					
						
			
		}
				
		return $k2tags;
	}

	
/*
	 * @saves the K2 Attachments
	 */	
	function saveAttachments($attachments_names,$attachments_titles,$attachments_title_attributes,$item_id)
	{

		require_once (JPATH_ADMINISTRATOR .DS."components".DS."com_k2".DS.'lib'.DS.'class.upload.php');
		$image = JPATH_SITE.DS.JPath::clean($imagepath);
		
       
        $params = &JComponentHelper::getParams('com_k2');        

        if (count($attachments_names)) {

            $path = $params->get('attachmentsFolder', NULL);
            if (is_null($path)) {
                $savepath = JPATH_ROOT.DS.'media'.DS.'k2'.DS.'attachments';
            } else {
                $savepath = $path;
            }

            $counter = 0;

            foreach ($attachments_names as $file) {

					$file=JPATH_SITE.DS.JPath::clean($file);
                	$handle = new Upload($file);

                	
	                if ($handle->uploaded) {
	                    $handle->file_auto_rename = true;
	                    $handle->allowed[] = 'application/x-zip';
	                    $handle->Process($savepath);
	                    $filename = $handle->file_dst_name;
                   
	                   // $handle->Clean();
	                    $attachment = &JTable::getInstance('K2Attachment', 'Table');
	                    $attachment->itemID = $item_id;
	                    $attachment->filename = $filename;
	                    $attachment->title = ( empty($attachments_titles[$counter])) ? $filename : $attachments_titles[$counter];
	                    $attachment->titleAttribute = ( empty($attachments_title_attributes[$counter])) ? $filename : $attachments_title_attributes[$counter];
	                    $attachment->store();

	                } else {
	                    $errors.= $handle->error  . " " . $file;
	                }
               // }
                $counter++;
            }

        }
		
        
		if ($errors=='')
			$errors='no error';
			
       	return $errors;        
        
		
	}
	
	
	
	/*
	 * save the images it gets in the way K2 saves his images
	 * 
	 */ 
	function saveImage($imagepath)
	{
		require_once (JPATH_ADMINISTRATOR .DS."components".DS."com_k2".DS.'lib'.DS.'class.upload.php');
		$image = JPATH_SITE.DS.JPath::clean($imagepath);
		
		$handle = new Upload($image);
        $handle->allowed = array('image/*');
        
        $params = &JComponentHelper::getParams('com_k2');
        
        
               //Original image
                $savepath = JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'src';
                $handle->image_convert = 'jpg';
                $handle->jpeg_quality = 100;
                $handle->file_auto_rename = false;
                $handle->file_overwrite = true;
                
                $handle->file_new_name_body = md5("Image".$this->_k2_item_id);
                $handle->Process($savepath);

                $filename = $handle->file_dst_name_body;
                $savepath = JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache';

                //XLarge image
                $handle->image_resize = true;
                $handle->image_ratio_y = true;
                $handle->image_convert = 'jpg';
                $handle->jpeg_quality = $params->get('imagesQuality');
                $handle->file_auto_rename = false;
                $handle->file_overwrite = true;
                $handle->file_new_name_body = $filename.'_XL';
                if (JRequest::getInt('itemImageXL')) {
                    $imageWidth = JRequest::getInt('itemImageXL');
                } else {
                    $imageWidth = $params->get('itemImageXL', '800');
                }
                $handle->image_x = $imageWidth;
                $handle->Process($savepath);

                //Large image
                $handle->image_resize = true;
                $handle->image_ratio_y = true;
                $handle->image_convert = 'jpg';
                $handle->jpeg_quality = $params->get('imagesQuality');
                $handle->file_auto_rename = false;
                $handle->file_overwrite = true;
                $handle->file_new_name_body = $filename.'_L';
                if (JRequest::getInt('itemImageL')) {
                    $imageWidth = JRequest::getInt('itemImageL');
                } else {
                    $imageWidth = $params->get('itemImageL', '600');
                }
                $handle->image_x = $imageWidth;
                $handle->Process($savepath);

                //Medium image
                $handle->image_resize = true;
                $handle->image_ratio_y = true;
                $handle->image_convert = 'jpg';
                $handle->jpeg_quality = $params->get('imagesQuality');
                $handle->file_auto_rename = false;
                $handle->file_overwrite = true;
                $handle->file_new_name_body = $filename.'_M';
                if (JRequest::getInt('itemImageM')) {
                    $imageWidth = JRequest::getInt('itemImageM');
                } else {
                    $imageWidth = $params->get('itemImageM', '400');
                }
                $handle->image_x = $imageWidth;
                $handle->Process($savepath);

                //Small image
                $handle->image_resize = true;
                $handle->image_ratio_y = true;
                $handle->image_convert = 'jpg';
                $handle->jpeg_quality = $params->get('imagesQuality');
                $handle->file_auto_rename = false;
                $handle->file_overwrite = true;
                $handle->file_new_name_body = $filename.'_S';
                if (JRequest::getInt('itemImageS')) {
                    $imageWidth = JRequest::getInt('itemImageS');
                } else {
                    $imageWidth = $params->get('itemImageS', '200');
                }
                $handle->image_x = $imageWidth;
                $handle->Process($savepath);

                //XSmall image
                $handle->image_resize = true;
                $handle->image_ratio_y = true;
                $handle->image_convert = 'jpg';
                $handle->jpeg_quality = $params->get('imagesQuality');
                $handle->file_auto_rename = false;
                $handle->file_overwrite = true;
                $handle->file_new_name_body = $filename.'_XS';
                if (JRequest::getInt('itemImageXS')) {
                    $imageWidth = JRequest::getInt('itemImageXS');
                } else {
                    $imageWidth = $params->get('itemImageXS', '100');
                }
                $handle->image_x = $imageWidth;
                $handle->Process($savepath);

                //Generic image
                $handle->image_resize = true;
                $handle->image_ratio_y = true;
                $handle->image_convert = 'jpg';
                $handle->jpeg_quality = $params->get('imagesQuality');
                $handle->file_auto_rename = false;
                $handle->file_overwrite = true;
                $handle->file_new_name_body = $filename.'_Generic';
                $imageWidth = $params->get('itemImageGeneric', '300');
                $handle->image_x = $imageWidth;
                $handle->Process($savepath);

                
             //   $handle->clean();  
                if($handle->error =='')
                	return 'no error';
                else 
                	return $handle->error . " " .$imagepath;
                	
                	      
        
        
		
	}
	
	
	
}