<?php
/**
 * Plugin K2JComments
 * @version 1.1
 * @package JComments
 * @subpackage Plugins
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 **/

// no direct access
defined('_JEXEC') or die ('Restricted access');

jimport('joomla.plugin.plugin');

class plgK2JComments extends JPlugin {
	
	function plgK2JComments( & $subject, $params)
	{
		parent::__construct($subject, $params);
	}

	function onK2CommentsBlock( &$item, &$params, $limitstart )
	{
		$result = '';

		if ($params->get('itemComments')) {
	        	$comments = JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
		 	if (is_file($comments)) {
		 		require_once($comments);
	 			$result = JComments::show($item->id, 'com_k2', $item->title);
		 	}
		}
		return $result;
	}

	function onK2CommentsCounter( &$item, &$params, $limitstart )
	{
		$result = '';

		if ($params->get('itemComments')) {
		        $comments = JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
		 	if (is_file($comments)) {
	 			require_once($comments);
	 			$count = JComments::getCommentsCount($item->id, 'com_k2');
		 		if ($count == 0) {
		 			$link = $item->link.'#addcomments';
		 			$text = JText::_('Add comment');
	 			} else {
		 			$link = $item->link.'#comments';
		 			$text = JText::sprintf('Read comments', $count);
		 		}
		 		$result = '<a href="'.$link.'" title="'.$text.'">'.$text.'</a>';
		 	}
		}
		return $result;
	}
}