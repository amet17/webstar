<?php

/**
 * K2import default controller
 * 
 * @package    K2import
 * @link http://www.individual-it.net
 * @license		GNU/GPL
 */

jimport('joomla.application.component.controller');

/**
 * K2import Component Controller
 *
 * @package		K2import
 */
class K2importController extends JController
{
	/**
	 * Method to display the view
	 *
	 * @access	public
	 */
	function display()
	{
		parent::display();
	}

	function import() 
	{
		
		$db =& JFactory::getDBO();
		$file        = JRequest::getVar( 'file', '', 'post', string );
		$file=JFile::makeSafe($file);
		$k2category        = JRequest::getVar( 'k2category', '', 'post', int );
		$k2importfields        = JRequest::getVar( 'k2importfields', '', 'post' );
		$k2importextrafields        = JRequest::getVar( 'k2importextrafields', '', 'post' );						
		$in_charset        = substr(JRequest::getVar( 'in_charset', '', 'post' ),0,20);				
		$out_charset        = substr(JRequest::getVar( 'out_charset', '', 'post' ),0,20);						
		
		
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'../com_k2'.DS.'lib'.DS.'JSON.php');
		$json=new Services_JSON;
		$sql_error_message='';
		$error_message='';
		
		$model=$this->getModel( 'k2import' );
		$csv_data=$model->getData($file,$in_charset,$out_charset);
		//$data =& $this->get( 'Data');

		$k2fields=$model->getK2fields($k2category);


		//create a list of all k2fields we like to import
		$k2fieldlist='';
		

		
		foreach ($k2importfields as $name=>$value)
		{
			//we have to import some fields in a different way
			if ($name!='tags' && 
			    $name!='image' &&
				substr($name,0,10)!='attachment' &&
				$name != 'k2category_name')
				
			{
				if (strlen($k2fieldlist)>0)
					$k2fieldlist .= ',';	
				
				$k2fieldlist .= "`".$db->getEscaped($name) . "`";
			}	
		}		



		
		for($csv_row_num=1; $csv_row_num<count($csv_data);$csv_row_num++) 
		{
			$attachments_names=array();
			$attachments_titles=array();
			$attachments_title_attributes=array();
			//add the imported values
			$field_values='';
			foreach ($k2importfields as $name=>$column_num)
			{
				if ($name=='tags')
				{
					$tags=split(',',$csv_data[$csv_row_num][$column_num]);
					array_walk($tags , create_function('&$temp', '$temp = trim($temp);'));
					$tags=$model->getK2tags($tags);
				}		
	
				elseif ($name =='image')
				{
					$image_name=$csv_data[$csv_row_num][$column_num];
				}
				elseif (substr($name,0,26) =='attachment_title_attribute')
				{
					array_push($attachments_title_attributes, $csv_data[$csv_row_num][$column_num]);
				}				
				elseif (substr($name,0,16) =='attachment_title')
				{
					array_push($attachments_titles, $csv_data[$csv_row_num][$column_num]);
				}				
				elseif (substr($name,0,10) =='attachment')
				{
					array_push($attachments_names, $csv_data[$csv_row_num][$column_num]);
				}
												
				elseif ($name =='created_by')
				{
					if (strlen($field_values)>0)
						$field_values .= ',';
					$user =& JFactory::getUser();
	
					if ($csv_data[$csv_row_num][$column_num]!='')
					{
						//check if there is such a user in the DB
						$db =& JFactory::getDBO();
							
						$db->setQuery("SELECT count(id) from `#__users` WHERE id='".(int)$csv_data[$csv_row_num][$column_num]."'");
						$user_count = $db->loadResult();
						
						if ($user_count==1)
							$field_values.= "'".(int)$csv_data[$csv_row_num][$column_num]."'";
						else
						{
							$field_values.= "'".(int)$user->id."'";
							$error_message.='there is no user with the ID: ' . (int)$csv_data[$csv_row_num][$column_num]. " I'm using the ID:".(int)$user->id;
						} 
					}
					else
						$field_values.= "'".(int)$user->id."'";
						
				}
				elseif ($name =='k2category_name')
				{
					//check if there is a category with this name, if yes get the id
					if ($k2category!='take_from_csv')
						$parent_cat_sql=' AND parent="'.(int)$k2category.'" ';
					else 
						$parent_cat_sql='';
						
					$db->setQuery("SELECT id from `#__k2_categories` WHERE name='".$db->getEscaped($csv_data[$csv_row_num][$column_num])."'" . $parent_cat_sql . " LIMIT 1");
					$k2_sub_category = $db->loadResult();
					if ($k2_sub_category == null)
					{
						//create a new category
						if ($k2category=='take_from_csv')
							$k2_sub_category =$model->createK2category($csv_data[$csv_row_num][$column_num]);
						else 
							$k2_sub_category =$model->createK2category($csv_data[$csv_row_num][$column_num],(int)$k2category);
					}

				}
				else
				{	
					if (strlen($field_values)>0)
						$field_values .= ',';					
						
					$field_values.= "'".$db->getEscaped($csv_data[$csv_row_num][$column_num]) ."'";
				}	
			}													
		
			
			$extrafield_values=array();
			$extrafield_search_values='';
			foreach ($k2fields as $k2field)
			{
												
				if ($k2field['extra']=='extra')
					{
						$k2field['value']=$json->decode($k2field['value']);
						
						$column_num=$k2importextrafields[$k2field['id']];
						if ($column_num!='')
						{
							switch($k2field['type']) 
							{
								case 'link':								
									array_push($extrafield_values, array('id'=>$k2field['id'], 'value'=>array($k2field['value'][0]->name,$csv_data[$csv_row_num][$column_num], $k2field['value'][0]->target)));
																	
									break;
								case 'select':
								case 'radio':
									$select_error=true;
									//$select_values=explode("},{",$k2field['value']);
									$select_error=true;
									foreach ( $k2field['value'] as $select_k2field)
									{							
										if ($select_k2field->name == trim($csv_data[$csv_row_num][$column_num]))
										{
											array_push($extrafield_values,array('id'=>$k2field['id'],'value'=>$select_k2field->value) );
											$select_error=false;
										}
	
									}
							
									
									if ($select_error)
										$error_message.='no association found for ' .  $k2field['title']  . ' in row ' . $csv_row_num . "<br>";
									break;
									
								case 'multipleSelect':
									$select_error=true;
									$multipleSelect_csv_data=explode (",",$csv_data[$csv_row_num][$column_num]);
									$multipleSelect_values=array();

									//trim all values inside the array
									array_walk($multipleSelect_csv_data , create_function('&$temp', '$temp = trim($temp);'));
								
									foreach ( $k2field['value'] as $select_k2field)
									{				

										if (in_array($select_k2field->name,$multipleSelect_csv_data))
										{
										   array_push($multipleSelect_values,$select_k2field->value );
											$select_error=false;
										}
									

	
									}
									if (sizeof($multipleSelect_values)>0)
										array_push($extrafield_values,array('id'=>$k2field['id'],'value'=>$multipleSelect_values) );			

									if ($select_error)
										$error_message.='no association found for ' .  $k2field['title']  . ' in row ' . $csv_row_num . "<br>";
									break;																	
								default:
	
	
									if (strlen($csv_data[$csv_row_num][$column_num])<=0)
										$csv_data[$csv_row_num][$column_num]=$k2field['value']['value'];
									if (strlen($csv_data[$csv_row_num][$column_num])<=0)
										$csv_data[$csv_row_num][$column_num]="";
																			
									array_push($extrafield_values,array('id'=>$k2field['id'],'value'=>$csv_data[$csv_row_num][$column_num] ));
									break; 	
																
							}
							$extrafield_search_values.= " " . $csv_data[$csv_row_num][$column_num];								
							
						}
						

					}
				
			}													
			//die();
			
			//so what category should we use for importing?
			//if there is still no category create a new one
			if ($k2category=='take_from_csv' && (!isset($k2_sub_category) || !is_int($k2_sub_category)))
				$k2_sub_category =$model->createK2category("imported data ". date('Y-m-d H:i:s'));
			elseif (is_int($k2category) && (!isset($k2_sub_category) || !is_int($k2_sub_category)))
				$k2_sub_category=$k2category;
				
				
			$item_id=$model->save($k2fieldlist,$field_values,$k2_sub_category,$json->encode($extrafield_values),$extrafield_search_values,$tags);
			
			if (isset($image_name))
			{
				$return_image=$model->saveImage($image_name);

				if ($return_image!='no error')
				{
					if ($error_message!='')
						$error_message.="<br>";
					
					$error_message.=$return_image;
				}
			}	

		
			if ($attachments_names[0]!='')
			{
				$return_attachments=$model->saveAttachments($attachments_names,$attachments_titles,$attachments_title_attributes,$item_id);
				if ($return_attachments!='no error')
				{
					if ($error_message!='')
						$error_message.="<br>";
					
					$error_message.=$return_attachments;
				}				
			}
			


		}


		$returnURL = JURI::base().'index.php?option=com_k2import';

		if (strlen($error_message)>0)
			$this->setRedirect($returnURL,JText::_( 'items were imported, but with some problems') . '<br><br>' . $error_message ,'warning');
		else 		
			$this->setRedirect($returnURL,JText::_( 'items were successful imported'));
		
	}
	function associate() 
	{

		$view = & $this->getView( 'associate', 'html' );
		$view->setModel( $this->getModel( 'k2import' ), true );
		$view->display();


	}
	
	function selectcategory() 
	{

		$view = & $this->getView( 'selectcategory', 'html' );
		$view->setModel( $this->getModel( 'k2import' ), true );
		$view->display();


	}	
	
	function upload()
	{

		$mainframe = JFactory::getApplication();


		//Retrieve file details from uploaded file, sent from upload form:
		$file = JRequest::getVar('file_upload', null, 'files', 'array');
		
		//Import filesystem libraries:
		jimport('joomla.filesystem.file');
		
		//Clean up filename to get rid of strange characters like spaces etc

		$fDestName= $mainframe->getCfg('tmp_path') . DS . JFile::makeSafe($file['name']) ;
		$returnURL = JURI::base().'index.php?option=com_k2import&task=selectcategory&file='.JFile::makeSafe($file['name']);
		//Set up the source and destination of the file
		$fNameTmp = $file['tmp_name'];
	
		if ( JFile::upload($fNameTmp, $fDestName))
		{
			$this->setRedirect($returnURL,'The file was successful uploaded');
		
		}
		else
		{
			//Display the back button:
			JToolBarHelper::back();
	
			$this->setError( 'The file could not be uploaded.');
		}
		
	}



}
?>
