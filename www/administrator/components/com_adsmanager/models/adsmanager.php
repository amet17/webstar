<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'tables');

/**
 * @package		Joomla
 * @subpackage	Contact
 */
class AdsmanagerModelAdsmanager extends JModel
{  
	function changeState($table,$id,$field,$state,$cid)
	{
		$cids = implode( ',', $cid );
		$this->_db->setQuery("UPDATE $table SET $field = $state WHERE $id IN ($cids)");
		//echo "UPDATE $table SET $field = $state WHERE $id IN ($cids)";
		//exit();
		$this->_db->query();
	}
	
	function createImageAndThumb($src_file,$image_name,$thumb_name,
								$max_width,
							    $max_height,
								$max_width_t,
								$max_height_t,
								$tag,
								$path,
								$orig_name)
	{
		if (intval(ini_get('memory_limit')) < 64)
			ini_set('memory_limit', '64M');
		
		$src_file = urldecode($src_file);
		
		$orig_name = strtolower($orig_name);
		$findme  = '.jpg';
		$pos = strpos($orig_name, $findme);
		if ($pos === false)
		{
			$findme  = '.jpeg';
			$pos = strpos($orig_name, $findme);
			if ($pos === false)
			{
				$findme  = '.gif';
				$pos = strpos($orig_name, $findme);
				if ($pos === false)
				{
					$findme  = '.png';
					$pos = strpos($orig_name, $findme);
					if ($pos === false)
					{
						return;
					}
					else
					{
						$type = "png";
					}
				}
				else
				{
					$type = "gif";
				}
			}
			else
			{
				$type = "jpeg";
			}
		}
		else
		{
			$type = "jpeg";
		}
		
		$max_h = $max_height;
		$max_w = $max_width;
		$max_thumb_h = $max_height_t;
		$max_thumb_w = $max_width_t;
		
		if ( file_exists( "$path/$image_name")) {
			unlink( "$path/$image_name");
		}
		
		if ( file_exists( "$path/$thumb_name")) {
			unlink( "$path/$thumb_name");
		}
		
		$read = 'imagecreatefrom' . $type; 
		$write = 'image' . $type; 
		
		$src_img = $read($src_file);
		
		// height/width
		$imginfo = getimagesize($src_file);
		$src_w = $imginfo[0];
		$src_h = $imginfo[1];
		
		$zoom_h = $max_h / $src_h;
	    $zoom_w = $max_w / $src_w;
	    $zoom   = min($zoom_h, $zoom_w);
	    $dst_h  = $zoom<1 ? round($src_h*$zoom) : $src_h;
	    $dst_w  = $zoom<1 ? round($src_w*$zoom) : $src_w;
		
		$zoom_h = $max_thumb_h / $src_h;
	    $zoom_w = $max_thumb_w / $src_w;
	    $zoom   = min($zoom_h, $zoom_w);
	    $dst_thumb_h  = $zoom<1 ? round($src_h*$zoom) : $src_h;
	    $dst_thumb_w  = $zoom<1 ? round($src_w*$zoom) : $src_w;
		
		$dst_img = imagecreatetruecolor($dst_w,$dst_h);
		$white = imagecolorallocate($dst_img,255,255,255);
		imagefill($dst_img,0,0,$white);
		imagecopyresampled($dst_img,$src_img, 0,0,0,0, $dst_w,$dst_h,$src_w,$src_h);
		$textcolor = imagecolorallocate($dst_img, 255, 255, 255);
		if (isset($tag))
			imagestring($dst_img, 5, 5, 5, "$tag", $textcolor);    
		if($type == 'jpeg'){
	        $desc_img = $write($dst_img,"$path/$image_name", 75);
		}else{
	        $desc_img = $write($dst_img,"$path/$image_name", 2);
		}
		
		imagedestroy($dst_img);
		
		$dst_t_img = imagecreatetruecolor($dst_thumb_w,$dst_thumb_h);
		$white = imagecolorallocate($dst_t_img,255,255,255);
		imagefill($dst_t_img,0,0,$white);
		imagecopyresampled($dst_t_img,$src_img, 0,0,0,0, $dst_thumb_w,$dst_thumb_h,$src_w,$src_h);
		$textcolor = imagecolorallocate($dst_t_img, 255, 255, 255);
		if (isset($tag))
			imagestring($dst_t_img, 2, 2, 2, "$tag", $textcolor);
		if($type == 'jpeg'){
	        $desc_img = $write($dst_t_img,"$path/$thumb_name", 75);
		}else{
	        $desc_img = $write($dst_t_img,"$path/$thumb_name", 2);
		}
		
		imagedestroy($dst_t_img);
	}
}