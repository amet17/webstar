<?php

/**
* Layout Parts class
* @package News Show Pro GK4
* @Copyright (C) 2009-2010 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 4.0.0 $
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

class NSP_GK4_Layout_Parts {
	// header generator
	function header($config, $news_id, $news_cid, $news_sid, $news_title) {
		if($config['news_content_header_pos'] != 'disabled') {
			$class = ' t'.$config['news_content_header_pos'].' f'.$config['news_content_header_float'];
			$title = NSP_GK4_Utils::cutText($news_title, $config['title_limit'], $config['title_limit_type'], '&hellip;');
			$link = JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid, $news_sid));
			//
			if($config['news_header_link'] == 1)
				return '<p class="nsp_header'.$class.'"><noindex><a rel="nofollow" href="'.$link.'" title="'.str_replace('"', '', $news_title).'">'.$title.'</a></noindex></p>';	
			else
				return '<p class="nsp_header'.$class.'" title="'.str_replace('"', '', $news_title).'">'.$title.'</p>';
		} else
			return '';		
	}
	// article text generator
	function text($config, $news_id, $news_cid, $news_sid, $news_text, $news_readmore)
	{
		if($config['news_content_text_pos'] != 'disabled') {
			if($config['clean_xhtml'] == 1) $news_text = strip_tags($news_text);
			$news_text = NSP_GK4_Utils::cutText($news_text, $config['news_limit'], $config['news_limit_type'], $config['more_text_value']);
			$link = JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid, $news_sid));
			//
			$news_text = ($config['news_text_link'] == 1) ? '<noindex><a rel="nofollow" href="'.$link.'">'.$news_text.'</a></noindex>' : $news_text; 
			$class = ' t'.$config['news_content_text_pos'].' f'.$config['news_content_text_float'];
			//
			if($config['news_content_readmore_pos'] == 'after') 
				return '<p class="nsp_text'.$class.'">'.$news_text.' '.$news_readmore.'</p>';
			else
				return '<p class="nsp_text'.$class.'">'.$news_text.'</p>';
		}
	}
	// article image generator
	function image($config, $uri, $news_id, $news_iid, $news_cid, $news_sid, $news_text, $news_title){		
		$IMG_SOURCE = '';
		$IMG_LINK = JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid, $news_sid));	
		$IMG_REL = '';
		if(preg_match('/\<img.*src=.*?\>/',$news_text)){
			$imgStartPos = JString::strpos($news_text, 'src="');
			if($imgStartPos)  $imgEndPos = JString::strpos($news_text, '"', $imgStartPos + 5);	
			if($imgStartPos > 0) $IMG_SOURCE = JString::substr($news_text, ($imgStartPos + 5), ($imgEndPos - ($imgStartPos + 5)));
			$match_res = array();
			if(preg_match('/\<img.*class="(.*?)".*?\>/',$news_text, $match_res)) {
				$IMG_REL = $match_res[1];
			}
		}
		//
		if($config['create_thumbs'] == 1 && $IMG_SOURCE != ''){
			// try to override standard image
			if(strpos($IMG_SOURCE,'http://') == FALSE) {
				if(NSP_GK4_Thumbs::createThumbnail($IMG_SOURCE, $config, false, false, $IMG_REL) !== FALSE) {
					$uri = &JURI::getInstance();
					$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($IMG_SOURCE,$config['module_id']);
				} elseif($config['create_thumbs'] == 1) {
					jimport('joomla.filesystem.file');
					if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
						$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';			
					}
				} else
					$IMG_SOURCE = '';
			}	
		} elseif($config['create_thumbs'] == 1) {
			jimport('joomla.filesystem.file');
			
			if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
				$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';			
			}
		}
		//
		if($IMG_SOURCE != '' && $config['news_content_image_pos'] != 'disabled') {
			$class = ' t'.$config['news_content_image_pos'].' f'.$config['news_content_image_float']; 
			$size = '';
			//
			if($config['img_width'] != 0 && !$config['img_keep_aspect_ratio']) $size .= 'width:'.$config['img_width'].'px;';
			if($config['img_height'] != 0 && !$config['img_keep_aspect_ratio']) $size .= 'height:'.$config['img_height'].'px;';
			if($config['img_margin'] != '') $size .= 'margin:'.$config['img_margin'].';';
			//
			if($config['news_image_link'] == 1) {
				return ($config['news_content_image_pos'] == 'center') ? '<div class="center"><noindex><a rel="nofollow" href="'.$IMG_LINK.'"  title="'.$news_title.'" class="'.$class.'"><img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" title="'.$news_title.'" style="'.$size.'"  /></a></noindex></div>' : '<noindex><a rel="nofollow" href="'.$IMG_LINK.'" class="'.$class.'" title="'.$news_title.'"><img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" title="'.$news_title.'" style="'.$size.'"  /></a></noindex>';
			} else {
				return ($config['news_content_image_pos'] == 'center') ? '<div class="center"><img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" '.$size.' title="'.$news_title.'" /></div>' : '<img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" title="'.$news_title.'" style="'.$size.'" />';
			}
		} else
			return '';
	}
	// ReadMore button generator
	function readMore($config, $news_id, $news_cid, $news_sid) {
		//
		if($config['news_content_readmore_pos'] != 'disabled') {
			$class = ' f'.$config['news_content_readmore_pos'];
			//
			if($config['news_content_readmore_pos'] == 'after') {
				return '<noindex><a rel="nofollow" class="nsp_readmore inline" href="'.JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid, $news_sid)).'">'.JText::_('NSP_READMORE').'</a></noindex>';
			} else {
				return '<noindex><a rel="nofollow" class="readon readon_class '.$class.'" href="'.JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid, $news_sid)).'">'.JText::_('NSP_READMORE').'</a></noindex>';
			}
		} else
			return '';
	}
	// article information generator
	function info($config, $news_catname, $news_cid, $news_sid, $news_author, $news_author_email, $news_date, $news_hits, $news_id, $rating_count, $rating_sum, $num = 1) {
		// %AUTHOR %COMMENTS %DATE %HITS %CATEGORY
		$news_info = '';
		//
		if($num == 1){
			if($config['news_content_info_pos'] != 'disabled') {
				$class = ' t'.$config['news_content_info_pos'].' f'.$config['news_content_info_float'];	
			}
		}else{
			if($config['news_content_info2_pos'] != 'disabled') {
				$class = ' t'.$config['news_content_info2_pos'].' f'.$config['news_content_info2_float'];
			}			
		}
		//
		if(($config['news_content_info_pos'] != 'disabled' && $num == 1) || ($config['news_content_info2_pos'] != 'disabled' && $num == 2)) {
            $news_info = '<p class="nsp_info '.$class.'">'.$config['info'.(($num == 2) ? '2' : '').'_format'].'</p>';
            //
            $info_category = ($config['category_link'] == 1) ? '<noindex><a rel="nofollow" href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($news_cid, $news_sid)).'" >'.$news_catname.'</a></noindex>' : $news_catname;
            $info_author = ($config['user_avatar'] == 1) ? '<span><img src="'. NSP_GK4_Utils::avatarURL($news_author_email, $config['avatar_size']).'" alt="'.$news_author.' - avatar" class="nsp_avatar" width="'.$config['avatar_size'].'" height="'.$config['avatar_size'].'" /> '.$news_author.'</span>' : $news_author;
            $info_date = JHTML::_('date', $news_date, $config['date_format']);			
            $info_hits = JText::_('NHITS').$news_hits;
            // JComments support
            $jcomments_count = '';	
            $jcomments_main_class = JPATH_SITE . '/components/com_jcomments/jcomments.php';
            $jcomments_content_class = JPATH_SITE . '/components/com_jcomments/helpers/content.php';
            if (file_exists($jcomments_main_class) && file_exists($jcomments_content_class)) {
                require_once($jcomments_main_class);
                require_once($jcomments_content_class);
                $finded_numbers = explode(':', $news_cid);
                if (JCommentsContentPluginHelper::checkCategory($finded_numbers[0])) {
                    $jcomments_count = JComments::getCommentsCount($news_id, 'com_content');
                }	
            }
            // end of JComments support block
            $info_comments = '';
            if($jcomments_count !== '') {
                if($config['no_comments_text'] && $jcomments_count == 0){
                    $info_comments = '<noindex><a rel="nofollow" class="nsp_comments" href="'.JRoute::_(ContentHelperRoute::getArticleRoute($news_id,$news_cid, $news_sid)).'#comments">'.JText::_('NO_COMMENTS').'</a></noindex>';
                } else {
                    $info_comments = '<noindex><a rel="nofollow" class="nsp_comments" href="'.JRoute::_(ContentHelperRoute::getArticleRoute($news_id,$news_cid, $news_sid)).'#comments">'.JText::_('COMMENTS').'('.$jcomments_count.')</a></noindex>';
                }
            }
            //
            $info_rate = ($rating_count > 0) ? '<span class="nsp_rate">' . JText::_('NSP_RATE') .' '. number_format($rating_sum / $rating_count, 2) . '</span>': '';
            // 
            $news_info = str_replace('%AUTHOR', $info_author, $news_info);
            $news_info = str_replace('%COMMENTS', $info_comments, $news_info);
            $news_info = str_replace('%DATE', $info_date, $news_info);
            $news_info = str_replace('%HITS', $info_hits, $news_info);
            $news_info = str_replace('%CATEGORY', $info_category, $news_info);
            $news_info = str_replace('%RATE', $info_rate, $news_info);
        }
		//
		return $news_info;		
	}
	// rest link list generator	
	function lists($config, $news_id, $news_cid, $news_sid, $news_title, $news_text, $odd, $num) {
		if($config['news_short_pages'] > 0) {
            $text = '';
            if($config['show_list_description']) {
                $text = NSP_GK4_Utils::cutText(strip_tags(preg_replace("/\{.+?\}/", "", $news_text)), $config['list_text_limit'], $config['list_text_limit_type'], '&hellip;');
			}
			
			if(JString::strlen($text) > 0) $text = '<p>'.$text.'</p>';
			$title = $news_title;
			$title = NSP_GK4_Utils::cutText($title, $config['list_title_limit'], $config['list_title_limit_type'], '&hellip;');
			if(JString::strlen($title) > 0) $title = '<p><noindex><a rel="nofollow" href="'.JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid, $news_sid)).'" title="'.str_replace('"', '', $news_title).'">'.$title.'</a></noindex></p>';
			// creating rest news list
			return '<li class="'.(($odd == 1) ? 'odd' : 'even').(($num >= $config['links_amount'] * $config['links_columns_amount']) ? ' unvisible' : '').'">'.$title.$text.'</li>';	
		}
	}
	
	/** K2 elements **/
	
	// header generator
	function header_k2($config, $news_id, $news_alias, $news_cat_id, $news_cat_alias, $news_title) {
		//
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		//
		if($config['news_content_header_pos'] != 'disabled') {
			$class = ' t'.$config['news_content_header_pos'].' f'.$config['news_content_header_float'];
			$title = NSP_GK4_Utils::cutText($news_title, $config['title_limit'], $config['title_limit_type'], '&hellip;');
			$link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cat_id.':'.urlencode($news_cat_alias))));
			//
			if($config['news_header_link'] == 1)
				return '<p class="nsp_header'.$class.'"><noindex><a rel="nofollow" href="'.$link.'" title="'.str_replace('"', '', $news_title).'">'.$title.'</a></noindex></p>';	
			else
				return '<p class="nsp_header'.$class.'" title="'.str_replace('"', '', $news_title).'">'.$title.'</p>';
		} else
			return '';		
	}
	// article text generator
	function text_k2($config, $news_id, $news_alias, $news_cat_id, $news_cat_alias, $news_text, $news_readmore) {
		if($config['news_content_text_pos'] != 'disabled') {
			if($config['clean_xhtml'] == 1) $news_text = strip_tags($news_text);
			$news_text = NSP_GK4_Utils::cutText($news_text, $config['news_limit'], $config['news_limit_type'], $config['more_text_value']);
			$link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cat_id.':'.urlencode($news_cat_alias))));
			//
			$news_text = ($config['news_text_link'] == 1) ? '<noindex><a rel="nofollow" href="'.$link.'">'.$news_text.'</a></noindex>' : $news_text; 
			$class = ' t'.$config['news_content_text_pos'].' f'.$config['news_content_text_float'];
			//
			if($config['news_content_readmore_pos'] == 'after') 
				return '<p class="nsp_text'.$class.'">'.$news_text.' '.$news_readmore.'</p>';
			else
				return '<p class="nsp_text'.$class.'">'.$news_text.'</p>';
		}
	}
	// article image generator
	function image_k2($config, $uri, $news_id, $news_alias, $news_cat_id, $news_cat_alias, $news_text, $news_title) {
		//
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		
		$item_image_exists = false;
		$img_src = '';
		
		if(JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$news_id).'_L.jpg')){  
			$img_src = JURI::root().'media/k2/items/cache/'.md5("Image".$news_id).'_L.jpg';
			$item_image_exists = true;
        }elseif(JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$news_id).'_S.jpg')){  
			$img_src = JURI::root().'media/k2/items/cache/'.md5("Image".$news_id).'_S.jpg';
			$item_image_exists = true;
		}
		//
		$IMG_SOURCE = '';
		$IMG_LINK = urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cat_id.':'.urlencode($news_cat_alias))));
		$IMG_REL = '';
		//
		if(preg_match('/\<img.*src=.*?\>/',$news_text)){
			$imgStartPos = JString::strpos($news_text, 'src="');
			if($imgStartPos)  $imgEndPos = JString::strpos($news_text, '"', $imgStartPos + 5);	
			if($imgStartPos > 0) $IMG_SOURCE = JString::substr($news_text, ($imgStartPos + 5), ($imgEndPos - ($imgStartPos + 5)));
			$match_res = array();
			if(preg_match('/\<img.*class="(.*?)".*?\>/',$news_text, $match_res)) {
				$IMG_REL = $match_res[1];
			}
		}
		//
		if($config['create_thumbs'] == 1 && $config['k2_thumbs'] == 1 && $item_image_exists == true){
			// try to override standard image
			if(NSP_GK4_Thumbs::createThumbnail($img_src, $config, true, false, $IMG_REL) !== FALSE) {
				$uri = &JURI::getInstance();
				$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($img_src,$config['module_id'], true);
			} elseif($config['create_thumbs'] == 1) {
				jimport('joomla.filesystem.file');
				if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
					$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';			
				}
			} else
				$IMG_SOURCE = '';	
		} elseif($config['create_thumbs'] == 1 && $IMG_SOURCE != ''){
			// try to override standard image
			if(strpos($IMG_SOURCE,'http://') == FALSE) {
				if(NSP_GK4_Thumbs::createThumbnail($IMG_SOURCE, $config) !== FALSE) {
					$uri = &JURI::getInstance();
					$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($IMG_SOURCE,$config['module_id']);
				} elseif ($item_image_exists == true) { 
					if(NSP_GK4_Thumbs::createThumbnail($img_src, $config, true) !== FALSE) {
						$uri = &JURI::getInstance();
						$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($img_src,$config['module_id'], true);
					} else {
						jimport('joomla.filesystem.file');
						if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
							$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';	
						} else {
							$IMG_SOURCE = '';
						}
					}
				} else {
					jimport('joomla.filesystem.file');
					if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
						$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';		
					} else {
						$IMG_SOURCE = '';
					}
				}
			}	
		} elseif($config['create_thumbs'] == 1) {
			jimport('joomla.filesystem.file');
			if($item_image_exists == true){
				if(NSP_GK4_Thumbs::createThumbnail($img_src, $config, true) !== FALSE) {
					$uri = &JURI::getInstance();
					$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($img_src,$config['module_id'], true);
				} else {
					jimport('joomla.filesystem.file');
					if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
						$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';		
					} else {
						$IMG_SOURCE = '';
					}
				}
			}
			elseif(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
				$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';			
			}
		}
		//
		if($IMG_SOURCE != '' && $config['news_content_image_pos'] != 'disabled') {
			$class = ' t'.$config['news_content_image_pos'].' f'.$config['news_content_image_float'];
			$size = '';
			//
			if($config['img_width'] != 0 && !$config['img_keep_aspect_ratio']) $size .= 'width:'.$config['img_width'].'px;';
			if($config['img_height'] != 0 && !$config['img_keep_aspect_ratio']) $size .= 'height:'.$config['img_height'].'px;';
			if($config['img_margin'] != '') $size .= 'margin:'.$config['img_margin'].';';
			//
			if($config['news_image_link'] == 1) {
				return ($config['news_content_image_pos'] == 'center') ? '<div class="center"><noindex><a rel="nofollow" href="'.$IMG_LINK.'" title="'.$news_title.'" class="'.$class.'"><img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" style="'.$size.'" title="'.$news_title.'" /></a></noindex></div>' : '<noindex><a rel="nofollow" href="'.$IMG_LINK.'" class="'.$class.'" title="'.$news_title.'"><img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" style="'.$size.'"  title="'.$news_title.'" /></a></noindex>';
			} else {
				return ($config['news_content_image_pos'] == 'center') ? '<div class="center"><img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" '.$size.' title="'.$news_title.'" /></div>' : '<img class="nsp_image'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" title="'.$news_title.'" style="'.$size.'" />';
			}
		} else
			return '';
	}
	// ReadMore button generator
	function readMore_k2($config, $news_id, $news_alias, $news_cat_id, $news_cat_alias) {
		//
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		//
		if($config['news_content_readmore_pos'] != 'disabled') {
			$class = ' f'.$config['news_content_readmore_pos'];
			$link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cat_id.':'.urlencode($news_cat_alias))));
			//
			if($config['news_content_readmore_pos'] != 'after') {
				return '<noindex><a rel="nofollow" class="readon readon_class '.$class.'" href="'.$link.'">'.JText::_('NSP_READMORE').'</a></noindex>';
			} else {
				return '<noindex><a rel="nofollow" class="nsp_readmore inline" href="'.$link.'">'.JText::_('NSP_READMORE').'</a></noindex>';
			}
			
			if($config['news_content_readmore_pos'] == 'after') {
				return '<noindex><a rel="nofollow" class="nsp_readmore inline" href="'.$link.'">'.JText::_('NSP_READMORE').'</a></noindex>';
			} else {
				return '<noindex><a rel="nofollow" class="readon readon_class '.$class.'" href="'.$link.'">'.JText::_('NSP_READMORE').'</a></noindex>';
			}
			
		} else
			return '';
	}
	// article information generator
	function info_k2($config, $news_catname, $news_cid, $news_cat_alias, $news_author, $news_author_id, $news_author_email, $news_date, $news_hits, $news_id, $news_alias, $comments, $rating_count, $rating_sum, $num = 1) {
		//
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'utilities.php');
        // %AUTHOR %COMMENTS %DATE %HITS %CATEGORY %RATE
		$news_info = '';
		//
		if($num == 1){
			if($config['news_content_info_pos'] != 'disabled') {
				$class = ' t'.$config['news_content_info_pos'].' f'.$config['news_content_info_float'];	
			}
		}else{
			if($config['news_content_info2_pos'] != 'disabled') {
				$class = ' t'.$config['news_content_info2_pos'].' f'.$config['news_content_info2_float'];	
			}		
		}
		//
		if(($config['news_content_info_pos'] != 'disabled' && $num == 1) || ($config['news_content_info2_pos'] != 'disabled' && $num == 2)) {
            $news_info = '<p class="nsp_info '.$class.'">'.$config['info'.(($num == 2) ? '2' : '').'_format'].'</p>';
            //
            $info_category = ($config['category_link'] == 1) ? '<noindex><a rel="nofollow" href="'.urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($news_cid.':'.urlencode($news_cat_alias)))).'" >'.$news_catname.'</a></noindex>' : $news_catname;
            $info_author = ($config['user_avatar'] == 1) ? '<span><img src="'.K2HelperUtilities::getAvatar($news_author_id, $news_author_email, $config['avatar_size']).'" alt="'.$news_author.' - avatar" class="nsp_avatar" width="'.$config['avatar_size'].'" height="'.$config['avatar_size'].'" /> '.$news_author.'</span>' : $news_author;				
            $info_date = JHTML::_('date', $news_date, $config['date_format']);			
            $info_hits = JText::_('NHITS').$news_hits;
            //
            if($config['no_comments_text'] && (!isset($comments['art'.$news_id]) || $comments['art'.$news_id] == 0)){
                $comments_amount = JText::_('NO_COMMENTS');
            } else {
                $comments_amount = JText::_('COMMENTS').' ('.(isset($comments['art'.$news_id]) ? $comments['art'.$news_id] : '0' ) . ')';
            }
            $info_comments = '<noindex><a rel="nofollow" class="nsp_comments" href="'.urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cid.':'.urlencode($news_cat_alias)))).'#itemCommentsAnchor">'.$comments_amount.'</a></noindex>';
            //
            $info_rate = ($rating_count > 0) ? '<span class="nsp_rate">' . JText::_('NSP_RATE') .' '. number_format($rating_sum / $rating_count, 2) . '</span>': '';
            // 
            $news_info = str_replace('%AUTHOR', $info_author, $news_info);
            $news_info = str_replace('%COMMENTS', $info_comments, $news_info);
            $news_info = str_replace('%DATE', $info_date, $news_info);
            $news_info = str_replace('%HITS', $info_hits, $news_info);
            $news_info = str_replace('%CATEGORY', $info_category, $news_info);
            $news_info = str_replace('%RATE', $info_rate, $news_info);
		}
        //
		return $news_info;		
	}
	// K2Store block generator
	function store_k2($config, $news_id, $plugins, $k2store_params) {
		//
		if($config['k2store_support'] == 1 && ($config['k2store_show_cart'] == 1 || $config['k2store_add_to_cart'] == 1 || $config['k2store_price'] == 1)) {
			if(strpos($plugins, 'k2storeitem_price') !== false) {
    			if(preg_match('/k2storeitem_price=(.+)/', $plugins, $item_price)) {
    				$uri = JURI::getInstance();
    				$k2store_currency = $k2store_currency_after = $k2store_currency_before = '';
    
                    if($k2store_params !== 0) {
                        $k2store_currency = '<span>' . $k2store_params->get('currency') . '</span>'; 
                        if($config['k2store_currency_place'] == 'after') {
                            $k2store_currency_after = $k2store_currency;
                            $k2store_currency_before = '';
                        } else {
                            $k2store_currency_after = '';
                            $k2store_currency_before = $k2store_currency;
                        }
                    }
    				
    				$code = '<div class="nsp_k2store"><form method="post" action="index.php?option=com_k2store&amp;view=mycart&amp;format=ajax&amp;order_code='.$news_id.'" class="cart_form">';
    				$code .= '<input type="hidden" value="com_k2store" name="option" /><input type="hidden" value="cartaction" name="task" /><input type="hidden" value="" name="Itemid" /><input type="hidden" value="'.$news_id.'" name="order_code" /><input type="hidden" value="1" name="quantity" />';
    				
    				if($config['k2store_price'] == 1 ) {
    				    $text_item_price = ($config['k2store_price_text'] == 1) ? '<strong>' . JText::_('NSP_K2STORE_ITEM_PRICE') . '</strong>' : '';
    					$code .= '<span class="nsp_k2store_price">' . $text_item_price . $k2store_currency_before . $item_price[1] . $k2store_currency_after . '</span>';
    				}
    				
    				if($config['k2store_add_to_cart'] == 1 ) {
    					$code .= '<input type="submit" value="'. JText::_('NSP_K2STORE_ADD') .'" name="submit" />';
    				}
    				
    				if($config['k2store_show_cart'] == 1 ) {
    					$code .= '<input type="button" onclick="window.location = \''. $uri->root() .'index.php?option=com_k2store&amp;view=mycart\'" value="'. JText::_('NSP_K2STORE_SHOW') .'" />';
    				}
    				
    				$code .= '</form></div>';
    				
    				return $code;
				} else {
				    return '';
				}
			} else {
				return '';
			}
		} else {
			return '';
		}
	}
	// rest link list generator	
	function lists_k2($config, $news_id, $news_alias, $news_cid, $news_cat_alias, $news_title, $news_text, $odd, $num) {
		// 
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		//
		if($config['news_short_pages'] > 0) {
			$text = '';
            if($config['show_list_description']) {
                $text = NSP_GK4_Utils::cutText(strip_tags(preg_replace("/\{.+?\}/", "", $news_text)), $config['list_text_limit'], $config['list_text_limit_type'], '&hellip;');
            }
			if(JString::strlen($text) > 0) $text = '<p>'.$text.'</p>';
			$title = $news_title;
			$title = NSP_GK4_Utils::cutText($title, $config['list_title_limit'], $config['list_title_limit_type'], '&hellip;');
			if(JString::strlen($title) > 0) $title = '<p><noindex><a rel="nofollow" href="'.urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cid.':'.urlencode($news_cat_alias)))).'" title="'.str_replace('"', '', $news_title).'">'.$title.'</a></noindex></p>';
			// creating rest news list
			return '<li class="'.(($odd == 1) ? 'odd' : 'even').(($num >= $config['links_amount'] * $config['links_columns_amount']) ? ' unvisible' : '').'">'.$title.$text.'</li>';	
		}
	}	
	
	/** VM elements **/
	
	// header generator
	function header_vm($config, $news_id, $news_cid, $news_title) {
		if($config['news_content_header_pos'] != 'disabled') {
			$class = ' t'.$config['news_content_header_pos'].' f'.$config['news_content_header_float'];
			$title = NSP_GK4_Utils::cutText($news_title, $config['title_limit'], $config['title_limit_type'], '&hellip;');
			$link = 'index.php?page=shop.product_details&amp;flypage=flypage.tpl&amp;product_id='.$news_id.'&category_id='.$news_cid.'&amp;option=com_virtuemart&amp;Itemid='.$config['vm_itemid'];
			//
			if($config['news_header_link'] == 1)
				return '<p class="nsp_header'.$class.'"><noindex><a rel="nofollow" href="'.$link.'" title="'.str_replace('"', '', $news_title).'">'.$title.'</a></noindex></p>';	
			else
				return '<p class="nsp_header'.$class.'" title="'.str_replace('"', '', $news_title).'">'.$title.'</p>';
		} else
			return '';		
	}
	// article text generator
	function text_vm($config, $news_id, $news_cid, $news_text, $news_readmore)
	{
		if($config['news_content_text_pos'] != 'disabled') {
			if($config['clean_xhtml'] == 1) $news_text = strip_tags($news_text);
			$news_text = NSP_GK4_Utils::cutText($news_text, $config['news_limit'], $config['news_limit_type'], $config['more_text_value']);
			$link = 'index.php?page=shop.product_details&amp;category_id='.$news_cid.'&amp;flypage=flypage.tpl&amp;product_id='.$news_id.'&amp;option=com_virtuemart&amp;Itemid='.$config['vm_itemid'];
			//
			$news_text = ($config['news_text_link'] == 1) ? '<noindex><a rel="nofollow" href="'.$link.'">'.$news_text.'</a></noindex>' : $news_text; 
			$class = ' t'.$config['news_content_text_pos'].' f'.$config['news_content_text_float'];
			//
			if($config['news_content_readmore_pos'] == 'after') 
				return '<p class="nsp_text'.$class.'">'.$news_text.' '.$news_readmore.'</p>';
			else
				return '<p class="nsp_text'.$class.'">'.$news_text.'</p>';
		}
	}
	// article image generator
	function image_vm($config, $news_id, $news_cid, $news_image, $news_title){		
		$SOURCE = 'components/com_virtuemart/shop_image/product/' . $news_image;
		$img_url = 'index.php?page=shop.product_details&amp;category_id='.$news_cid.'&amp;flypage=flypage.tpl&amp;product_id='.$news_id.'&amp;option=com_virtuemart&amp;Itemid='.$config['vm_itemid'];
		//
		if($config['create_thumbs'] == 1 && $SOURCE != ''){
			// try to override standard image
			if(NSP_GK4_Thumbs::createThumbnail($SOURCE, $config, false, true) !== FALSE) {
                $uri = JURI::getInstance();
				$SOURCE = $uri->root() . 'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($SOURCE,$config['module_id'], false, true);
			} elseif($config['create_thumbs'] == 1) {
                jimport('joomla.filesystem.file');
                if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
                    $SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';			
                }
			} else
                $SOURCE = '';	
		}
		//
		if($SOURCE != '' && $config['news_content_image_pos'] != 'disabled') {
			$class = ' t'.$config['news_content_image_pos'].' f'.$config['news_content_image_float']; 
			$size = '';
			//
			if($config['img_width'] != 0 && !$config['img_keep_aspect_ratio']) $size .= 'width:'.$config['img_width'].'px;';
			if($config['img_height'] != 0 && !$config['img_keep_aspect_ratio']) $size .= 'height:'.$config['img_height'].'px;';
			if($config['img_margin'] != '') $size .= 'margin:'.$config['img_margin'].';';
			//
			if($config['news_image_link'] == 1) {
				return ($config['news_content_image_pos'] == 'center') ? '<div class="center"><noindex><a rel="nofollow" href="'.$img_url.'" title="'.$news_title.'" class="'.$class.'"><img class="nsp_image'.$class.'" src="'.$SOURCE.'" title="'.$news_title.'" alt="'.$news_title.'" style="'.$size.'"  /></a></noindex></div>' : '<noindex><a rel="nofollow" href="'.$img_url.'" class="'.$class.'" title="'.$news_title.'"><img class="nsp_image'.$class.'" src="'.$SOURCE.'" title="'.$news_title.'" alt="'.$news_title.'" style="'.$size.'"  /></a></noindex>';
			} else {
				return ($config['news_content_image_pos'] == 'center') ? '<div class="center"><img class="nsp_image'.$class.'" src="'.$SOURCE.'" title="'.$news_title.'" alt="'.$news_title.'" '.$size.' /></div>' : '<img class="nsp_image'.$class.'" title="'.$news_title.'" src="'.$SOURCE.'" alt="'.$news_title.'" style="'.$size.'" />';
			}
		} else
			return '';
	}
	// ReadMore button generator
	function readMore_vm($config, $news_id, $news_cid) {
		//
		if($config['news_content_readmore_pos'] != 'disabled') {
			$class = ' f'.$config['news_content_readmore_pos'];
			//
			if($config['news_content_readmore_pos'] == 'after') {
				return '<noindex><a rel="nofollow" class="nsp_readmore inline" href="index.php?page=shop.product_details&amp;category_id='.$news_cid.'&amp;flypage=flypage.tpl&amp;product_id='.$news_id.'&amp;option=com_virtuemart&amp;Itemid='.$config['vm_itemid'].'">'.JText::_('NSP_READMORE').'</a></noindex>';
			} else {
				return '<noindex><a rel="nofollow" class="readon readon_class '.$class.'" href="index.php?page=shop.product_details&amp;category_id='.$news_cid.'&amp;flypage=flypage.tpl&amp;product_id='.$news_id.'&amp;option=com_virtuemart&amp;Itemid='.$config['vm_itemid'].'">'.JText::_('NSP_READMORE').'</a></noindex>';
			}
		} else
			return '';
	}
	// article information generator
	function info_vm($config, $news_id, $news_catname, $news_cid, $news_manufacturer, $news_date, $comments, $num = 1) {
        //
        $news_info = '';
        //
		if($num == 1){
			if($config['news_content_info_pos'] != 'disabled') {
				$class = ' t'.$config['news_content_info_pos'].' f'.$config['news_content_info_float'];	
			}
		}else{
			if($config['news_content_info2_pos'] != 'disabled') {
				$class = ' t'.$config['news_content_info2_pos'].' f'.$config['news_content_info2_float'];
			}			
		}
		//
		if(($config['news_content_info_pos'] != 'disabled' && $num == 1) || ($config['news_content_info2_pos'] != 'disabled' && $num == 2)) {	  
            $info_category = ($config['category_link'] == 1) ? '<noindex><a rel="nofollow" href="index.php?page=shop.browse&amp;category_id='.$news_cid.'&amp;option=com_virtuemart&amp;Itemid='.$config['vm_itemid'].'" >'.$news_catname.'</a></noindex>' : $news_catname;
            $info_date = JHTML::_('date', $news_date, $config['date_format']);			
            
            if($config['no_comments_text'] && (!isset($comments['product'.$news_id]) || $comments['product'.$news_id] == 0)){
                $comments_amount = JText::_('NO_COMMENTS');
            } else {
                $comments_amount = JText::_('COMMENTS').' ('.(isset($comments['product'.$news_id]) ? $comments['product'.$news_id] : '0' ) . ')';
            }
            $info_comments = '<noindex><a rel="nofollow" class="nsp_comments" href="index.php?page=shop.product_details&amp;flypage=flypage.tpl&amp;product_id='.$news_id.'&category_id='.$news_cid.'&amp;option=com_virtuemart&amp;Itemid='.$config['vm_itemid'].'">'.$comments_amount.'</a></noindex>';
            $info_manufacturer = JText::_('NMANUFACTURER').$news_manufacturer;
            // %COMMENTS %DATE %CATEGORY %MANUFACTURER
            $news_info = '<p class="nsp_info '.$class.'">'.$config['info'.(($num == 2) ? '2' : '').'_format'].'</p>';
            $news_info = str_replace('%COMMENTS', $info_comments, $news_info); //
            $news_info = str_replace('%DATE', $info_date, $news_info); //
            $news_info = str_replace('%CATEGORY', $info_category, $news_info); //
            $news_info = str_replace('%MANUFACTURER', $info_manufacturer, $news_info); //
            $news_info = str_replace('%AUTHOR', '', $news_info);
            $news_info = str_replace('%RATE', '', $news_info);
        }
		//
		return $news_info;		
	}
	// rest link list generator	
	function lists_vm($config, $news_id, $news_cid, $news_title, $news_text, $odd, $num) {
		if($config['news_short_pages'] > 0) {
            $text = '';
            if($config['show_list_description']) {
                $text = NSP_GK4_Utils::cutText(strip_tags(preg_replace("/\{.+?\}/", "", $news_text)), $config['list_text_limit'], $config['list_text_limit_type'], '&hellip;');
			}
			
			if(JString::strlen($text) > 0) $text = '<p>'.$text.'</p>';
			$title = $news_title;
			$title = NSP_GK4_Utils::cutText($title, $config['list_title_limit'], $config['list_title_limit_type'], '&hellip;');
			if(JString::strlen($title) > 0) $title = '<p><noindex><a rel="nofollow" href="index.php?page=shop.product_details&amp;category_id='.$news_cid.'&amp;flypage=flypage.tpl&amp;product_id='.$news_id.'&amp;option=com_virtuemart&amp;Itemid='.$config['vm_itemid'].'" title="'.str_replace('"', '',$news_title).'">'.$title.'</a></noindex></p>';
			// creating rest news list
			return '<li class="'.(($odd == 1) ? 'odd' : 'even').(($num >= $config['links_amount'] * $config['links_columns_amount']) ? ' unvisible' : '').'">'.$title.$text.'</li>';	
		}
	}
	// VM block generator
	function store_vm($config, $news_id, $news_cid, $news_price, $news_price_currency, $news_discount_amount, $news_discount_is_percent, $news_discount_start, $news_discount_end, $news_tax, $news_manufacturer) {        
        //
        $class_discount = '';
        //
        if($news_tax) {
            $news_price = $news_price + ($news_price * $news_tax);
        }
        //
        if($news_discount_amount != 0 && $news_discount_start != 0) {
            if($news_discount_start <= (time() + $config['time_offset'] * 3600) &&
                (($news_discount_end >= (time() + $config['time_offset'] * 3600)) || $news_discount_end == 0)) {
                $class_discount = ' nsp_discount';
                if($news_discount_is_percent == 1) {  
                    $news_price = round($news_price - ($news_price * ($news_discount_amount / 100)), 2);
                } else {
                    $news_price = $news_price - $news_discount_amount;
                }     
            }
        } 
        // round the price
        $news_price = sprintf('%.2f', $news_price); 
        //
        switch($news_price_currency) {
			case 'USD': $news_price_currency = '$';break;
			case 'EUR': $news_price_currency = '€';break;
			case 'GBP': $news_price_currency = '£';break;
			case 'JPY': $news_price_currency = '¥';break;
			case 'AUD': $news_price_currency = 'AUD $';break;
			case 'CAD': $news_price_currency = 'CAD $';break;
			case 'HKD': $news_price_currency = 'HKD $';break;
			case 'NZD': $news_price_currency = 'NZD $';break;
			case 'SGD': $news_price_currency = 'SGD $';break;
	    }
        //
		if($config['vm_add_to_cart'] == 1 || $config['vm_price'] == 1) {
            $vm_currency = $vm_currency_after = $vm_currency_before = '';
  
            $vm_currency = '<span>' . $news_price_currency . '</span>'; 
            if($config['vm_currency_place'] == 'after') {
                $vm_currency_after = $vm_currency;
                $vm_currency_before = '';
            } else {
                $vm_currency_after = '';
                $vm_currency_before = $vm_currency;
            }
			
			$code = '<div class="nsp_vm"><form action="index.php" method="post" class="cart_form">';
			$code .= '<input type="hidden" value="'.$news_id.'" name="product_id"><input type="hidden" value="'.$news_id.'" name="prod_id[]"><input type="hidden" value="1" name="quantity[]"/><input type="hidden" value="shop.flypage.tpl" name="flypage"><input type="hidden" value="shop.cart" name="page"/><input type="hidden" value="'.$news_manufacturer.'" name="manufacturer_id"/><input type="hidden" value="'.$news_cid.'" name="category_id"/><input type="hidden" value="cartAdd" name="func"/><input type="hidden" value="com_virtuemart" name="option"/><input type="hidden" value="'.$config['vm_itemid'].'" name="Itemid"/><input type="hidden" value="" name="set_price[]"/><input type="hidden" value="" name="adjust_price[]"/><input type="hidden" value="" name="master_product[]"/>';
			
			if($config['vm_price'] == 1 ) {
			    $text_item_price = ($config['vm_price_text'] == 1) ? '<strong>' . JText::_('NSP_VM_ITEM_PRICE') . '</strong>' : '';
				$code .= '<span class="nsp_vm_price'.$class_discount.'">' . $text_item_price . $vm_currency_before . $news_price . $vm_currency_after . '</span>';
			}
			
			if($config['vm_add_to_cart'] == 1 ) {
				$code .= '<input type="submit" class="gk_vm_addtocart" value="'. JText::_('NSP_VM_ADD') .'" name="submit" />';
			}
			
			$code .= '</form></div>';
			
			return $code;
		} else {
			return '';
		}
	}
}

/* eof */