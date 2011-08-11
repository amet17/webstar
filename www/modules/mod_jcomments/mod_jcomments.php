<?php
/**
 * JComments Latest - show latest comments or latest commented content items items
 *
 * @version 2.2.9
 * @package JComments
 * @author smart (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by smart (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 **/
 
// ensure this file is being included by a parent file
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');

// define directory separator short constant
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

global $mainframe;

$comments = $mainframe->getCfg('absolute_path') . DS . 'components' . DS . 'com_jcomments' . DS . 'jcomments.php';
if (file_exists($comments)) {
	require_once ($comments);
} else {
	return;
}

if ( !defined( '_JCOMMENTS_MODULE' ) ) {
	define( '_JCOMMENTS_MODULE', 1 );

	class modJCommentsHelper
	{
		function getList($params, $unpublished = false, $orderby = 'date')
		{
			global $mainframe, $my;

			$dbo = & JCommentsFactory::getDBO();
			$acl = & JCommentsFactory::getACL();
			$config = & JCommentsFactory::getConfig();
		
			$object_group = trim($params->get('object_group', 'com_content'));
			$object_group = preg_replace('#[^0-9A-Za-z\-\_\,\.]#is', '', $object_group);

			switch($orderby)
			{
				case 'vote':
					$orderby = '(cc.isgood-cc.ispoor) DESC';
					break;
				case 'date':
				default:
					$orderby = 'cc.date DESC';
					break;
			}

			if ( $object_group == 'com_content' ) {
			
				$sectionid = intval($params->get('sectionid'));
				$exclude_sectionid = trim($params->get('exclude_sectionid', ''));
				$exclude_sections = array();
				if ($exclude_sectionid != '') {
					$exclude_sections = explode(',', $exclude_sectionid);
				}
			
				$catid = intval($params->get('catid'));
				$exclude_catid = trim($params->get('exclude_catid', ''));
				$exclude_catids = array();
				if ($exclude_catid != '') {
					$exclude_catids = explode(',', $exclude_catid);
				}

				if (JCOMMENTS_JVERSION == '1.0') {
					$now = date('Y-m-d H:i', time());
				} else {
					$date =& JFactory::getDate();
					$now = $date->toMySQL();
				}

				$query = "SELECT cc.id, cc.userid, cc.comment, cc.name, cc.username, cc.email, cc.date, cc.object_id, cc.object_group, '' as avatar "
					. "\n FROM #__jcomments AS cc"
					. "\n LEFT JOIN #__content AS c ON c.id = cc.object_id"
					. "\n WHERE cc.published = " . ($unpublished ? '0' : '1')
					. "\n   AND c.access <= '$my->gid'"
					. "\n   AND (c.publish_up = '0000-00-00 00:00:00' OR c.publish_up <= '$now')"
					. "\n   AND (c.publish_down = '0000-00-00 00:00:00' OR c.publish_down >= '$now')"
					. "\n   AND cc.object_group = 'com_content'"
					. ((!$catid && $sectionid) ? "\n   AND (c.sectionid IN ($sectionid) )" : '')
					. (count($exclude_sections) ? "\n AND (c.sectionid NOT IN (".implode(',', $exclude_sections).") )" : '')
					. ($catid ? "\n   AND (c.catid IN ($catid) )" : '')
					. (count($exclude_catids) ? "\n AND (c.catid NOT IN (".implode(',', $exclude_catids).") )" : '')
					. (JCommentsMultilingual::isEnabled() ? "\nAND cc.lang = '" . JCommentsMultilingual::getLanguage() . "'" : "")
					. "\n ORDER BY " . $orderby
					. "\n LIMIT " . intval( $params->get( 'count' ) )
					;
			} else {

				$groups = explode( ',', $object_group );

				$query = "SELECT cc.id, cc.userid, cc.comment, cc.name, cc.username, cc.email, cc.date, cc.object_id, cc.object_group, '' as avatar "
					. "\n FROM #__jcomments AS cc"
					. "\n WHERE cc.published = " . ($unpublished ? '0' : '1')
					. (count($groups) ? "\n   AND (cc.object_group = '" . implode( "' OR cc.object_group='", $groups ) . "')" : '')
					. (JCommentsMultilingual::isEnabled() ? "\nAND cc.lang = '" . JCommentsMultilingual::getLanguage() . "'" : "")
					. "\n ORDER BY " . $orderby
					. "\n LIMIT " . intval( $params->get( 'count' ) )
					;
			}

			$dbo->setQuery( $query );
			$rows = $dbo->loadObjectList();

			return $rows;
		}

		function getContentLink(&$row)
		{
			global $mainframe, $Itemid;

			if (JCOMMENTS_JVERSION == '1.5') {
				require_once (JPATH_ROOT.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
				$link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid)) . '#comments';
			} else {
				$compat = $mainframe->getCfg('itemid_compat');
			
				if ( $compat == null ) {
					// Joomla 1.0.12 or below
					if ( $Itemid && $Itemid != 99999999 ) {
						$_Itemid = $Itemid;
					} else {
						$_Itemid = $mainframe->getItemid( $row->id );
					}
				} else if ( (int) $compat > 0 && (int) $compat <= 11) {
					// Joomla 1.0.13 or higher and Joomla 1.0.11 compability
					$_Itemid = $mainframe->getItemid( $row->id, 0, 0  );
				} else {
					// Joomla 1.0.13 or higher and new Itemid algoritm
					$_Itemid = $Itemid;
				}
			
				$link = sefRelToAbs( 'index.php?option=com_content&amp;task=view&amp;id='. $row->id .'&amp;Itemid='. $_Itemid );
			}
			return $link;
		}

		function getModuleStyles($params)
		{
			$moduleclass_sfx = $params->get('moduleclass_sfx');
			$avatar_size = intval($params->get('avatar_size', 32));
			$showgravatars = intval($params->get('avatar'));

			if ($avatar_size <= 0) {
				$avatar_size = 32;
			}

			ob_start();
			?>
ul.jclist<?php echo $moduleclass_sfx;?> { padding: 0; list-style-image: none; list-style-type: none; }
ul.jclist<?php echo $moduleclass_sfx;?> li {padding:0 5px !important;background-image: none; background: none !important; list-style: none; list-style-image: none; margin-left: 5px !important; margin-left: 0; display: block; overflow: hidden; }
<?php 
			if ($showgravatars == 1) {
?>
ul.jclist<?php echo $moduleclass_sfx;?> img { width: <?php echo $avatar_size; ?>px; height: <?php echo $avatar_size; ?>px; margin: 5px 5px 5px 0;	float: left;}
<?php 
			}
?>
ul.jclist<?php echo $moduleclass_sfx;?> span img {width: auto; height: auto; float: none;}
<?php
			$_css = ob_get_contents();
			ob_end_clean();

			global $mainframe;
			$cacheEnabled = intval($mainframe->getCfg('caching')) == 1;

			if (JCOMMENTS_JVERSION == '1.5' && !$cacheEnabled) {
				$document = & JFactory::getDocument();
				$document->addStyleDeclaration($_css);
			} else {
				echo '<style type="text/css">' . $_css . '</style>';
			}
		}
	}


	function modJCommentsLatestCommented( &$params ) {
		global $my;

		$dbo = & JCommentsFactory::getDBO();
		
		$sectionid = intval($params->get('sectionid'));
		$exclude_sectionid = trim($params->get('exclude_sectionid', ''));
		$exclude_sections = array();
		if ($exclude_sectionid != '') {
			$exclude_sections = explode(',', $exclude_sectionid);
		}
		
		$catid = intval($params->get('catid'));
		$exclude_catid = trim($params->get('exclude_catid', ''));
		$exclude_catids = array();
		if ($exclude_catid != '') {
			$exclude_catids = explode(',', $exclude_catid);
		}

		if (JCOMMENTS_JVERSION == '1.0') {
			$now = date('Y-m-d H:i', time());
		} else {
			$date =& JFactory::getDate();
			$now = $date->toMySQL();
		}

		$query = "SELECT c.id AS id, c.title AS title, c.sectionid"
			. ((JCOMMENTS_JVERSION == '1.5') ? ', CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(":", c.id, c.alias) ELSE c.id END as slug' : '')
			. ((JCOMMENTS_JVERSION == '1.5') ? ', CASE WHEN CHAR_LENGTH(ct.alias) THEN CONCAT_WS(":", ct.id, ct.alias) ELSE ct.id END as catslug' : '')
			. "\n, COUNT(cc.id) AS comments, MAX(cc.date) AS commentdate"
			. "\n FROM #__content AS c"
			. "\n LEFT JOIN #__jcomments AS cc ON c.id = cc.object_id"
			. "\n LEFT JOIN #__categories AS ct ON ct.id = c.catid"
			. "\n WHERE c.state = 1"
			. "\n   AND c.access <= '$my->gid'"
			. "\n   AND (c.publish_up = '0000-00-00 00:00:00' OR c.publish_up <= '$now')"
			. "\n   AND (c.publish_down = '0000-00-00 00:00:00' OR c.publish_down >= '$now')"
			. "\n   AND cc.published = 1"
			. "\n   AND cc.object_group = 'com_content'"
			. ((!$catid && $sectionid) ? "\n   AND (c.sectionid IN ($sectionid) )" : '')
			. (count($exclude_sections) ? "\n AND (c.sectionid NOT IN (".implode(',', $exclude_sections).") )" : '')
			. ($catid ? "\n   AND (c.catid IN ($catid) )" : '')
			. (count($exclude_catids) ? "\n AND (c.catid NOT IN (".implode(',', $exclude_catids).") )" : '')
			. "\n GROUP BY c.id, c.title, c.sectionid"
			. ((JCOMMENTS_JVERSION == '1.5') ? ", slug, catslug" : '')
			. "\n ORDER BY commentdate DESC"
			. "\n LIMIT " . intval( $params->get( 'count' ) )
			;
		$dbo->setQuery( $query );
		$rows = $dbo->loadObjectList();
		echo $dbo->getErrorMsg();

		if ( sizeof( $rows ) ) {

			modJCommentsHelper::getModuleStyles($params);

			echo '<ul class="jclist'.$params->get( 'moduleclass_sfx' ).'">'."\n";

			foreach( $rows as $row ) {

				$link = modJCommentsHelper::getContentLink($row);
				$link_title = $row->title;
				$link_text = $row->title;

				if ( $params->get( 'showcomments' ) ) { 
					$link_text .= ' (' . $row->comments . ')'; 
				}

				echo '<li><noindex><a rel="nofollow" href="'.$link.'" title="'.$link_title.'">'.$link_text.'</a></noindex></li>'."\n";
			}
			echo '</ul>'."\n";
		}
	}

	function modJCommentsMostCommented( &$params )
	{
		global $my;

		$dbo = & JCommentsFactory::getDBO();

		$sectionid = intval($params->get('sectionid'));
		$exclude_sectionid = trim($params->get('exclude_sectionid', ''));
		$exclude_sections = array();
		if ($exclude_sectionid != '') {
			$exclude_sections = explode(',', $exclude_sectionid);
		}
		
		$catid = intval($params->get('catid'));
		$exclude_catid = trim($params->get('exclude_catid', ''));
		$exclude_catids = array();
		if ($exclude_catid != '') {
			$exclude_catids = explode(',', $exclude_catid);
		}

		if (JCOMMENTS_JVERSION == '1.0') {
			$now = date('Y-m-d H:i', time());
		} else {
			$date =& JFactory::getDate();
			$now = $date->toMySQL();
		}

		$query = "SELECT c.id AS id, c.title AS title, c.sectionid"
			. ((JCOMMENTS_JVERSION == '1.5') ? ', CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(":", c.id, c.alias) ELSE c.id END as slug' : '')
			. ((JCOMMENTS_JVERSION == '1.5') ? ', CASE WHEN CHAR_LENGTH(ct.alias) THEN CONCAT_WS(":", ct.id, ct.alias) ELSE ct.id END as catslug' : '')
			. "\n, COUNT(cc.id) AS comments, MAX(cc.date) AS commentdate"
			. "\n FROM #__content AS c"
			. "\n LEFT JOIN #__categories AS ct ON ct.id = c.catid"
			. "\n LEFT JOIN #__jcomments AS cc ON c.id = cc.object_id"
			. "\n WHERE c.state = 1"
			. "\n   AND c.access <= '$my->gid'"
			. "\n   AND (c.publish_up = '0000-00-00 00:00:00' OR c.publish_up <= '$now')"
			. "\n   AND (c.publish_down = '0000-00-00 00:00:00' OR c.publish_down >= '$now')"
			. "\n   AND cc.published = 1"
			. "\n   AND cc.object_group = 'com_content'"
			. ((!$catid && $sectionid) ? "\n   AND (c.sectionid IN ($sectionid) )" : '')
			. (count($exclude_sections) ? "\n AND (c.sectionid NOT IN (".implode(',', $exclude_sections).") )" : '')
			. ($catid ? "\n   AND (c.catid IN ($catid) )" : '')
			. (count($exclude_catids) ? "\n AND (c.catid NOT IN (".implode(',', $exclude_catids).") )" : '')
			. "\n GROUP BY c.id, c.title, c.sectionid"
			. ((JCOMMENTS_JVERSION == '1.5') ? ", slug, catslug" : '')
			. "\n ORDER BY comments DESC, c.created DESC"
			. "\n LIMIT " . intval( $params->get( 'count' ) )
			;
		$dbo->setQuery( $query );
		$rows = $dbo->loadObjectList();

		if ( sizeof( $rows ) ) {

			modJCommentsHelper::getModuleStyles($params);

			echo '<ul class="jclist'.$params->get( 'moduleclass_sfx' ).'">'."\n";

			foreach( $rows as $row ) {
				
				$link = modJCommentsHelper::getContentLink($row);
				$link_title = $row->title;
				$link_text = $row->title;
				
				if ($params->get('showcomments')) {
					$link_text .= ' (' . $row->comments . ')';
				}

				echo '<li><noindex><a rel="nofollow" href="'.$link.'" title="'.$link_title.'">'.$link_text.'</a></noindex></li>'."\n";
			}
			echo '</ul>'."\n";
		}
	}

	function modJCommentsLatest( &$params, $unpublished = false, $order = 'date' ) {
		global $mainframe, $my;
		
		$dbo = & JCommentsFactory::getDBO();
		$acl = & JCommentsFactory::getACL();
		$config = & JCommentsFactory::getConfig();
		
		$rows = modJCommentsHelper::getList($params, $unpublished, $order);

		if ( sizeof( $rows ) ) {
			$show_date = intval($params->get('show_date', 0));
			$show_author = intval($params->get('show_author', 0));
			$show_object_title = intval($params->get('show_object_title', 0));
			$show_comment_text = intval($params->get('show_comment_text', 1));
			$label4more = $params->get('label4more', 'More...');
			$label4author = $params->get('label4author', '');
			$dateformat = $params->get('dateformat', '%d.%m.%y %H:%M');
			$limit_object_title = $params->get('limit_object_title', 10);
			
			$showsmiles = intval($params->get('showsmiles'));
			$showgravatars = intval($params->get('avatar'));
			$avatar_size = intval($params->get('avatar_size', 32));
			$mambots = intval($params->get('mambots'));
			
			if ($avatar_size <= 0) {
				$avatar_size = 32;
			}
			
			if ($mambots) {
				require_once (JCOMMENTS_HELPERS . DS . 'plugin.php');
				JCommentsPluginHelper::importPlugin('jcomments');
				JCommentsPluginHelper::trigger('onBeforeDisplayCommentsList', array(&$rows));

				if ($acl->check('enable_gravatar')) {
					JCommentsPluginHelper::trigger('onPrepareAvatars', array(&$rows));
				}
			}
			
			modJCommentsHelper::getModuleStyles($params);

			echo '<ul class="jclist'.$params->get( 'moduleclass_sfx' ).'">'."\n";
			
			$bbcode = & JCommentsFactory::getBBCode();
			$smiles = & JCommentsFactory::getSmiles();
			$acl = & JCommentsFactory::getACL();

			$maxlen = intval( $params->get( 'length' ));

			foreach( $rows as $row ) {

				$link  = JCommentsObjectHelper::getLink( $row->object_id, $row->object_group);
				$title = JCommentsText::censor($row->comment );
				$title = $bbcode->filter( $title, true );
				$title = JCommentsText::fixLongWords( $title, $config->getInt('word_maxlength') );

				if ($acl->check('autolinkurls')) {
					$title = preg_replace_callback( _JC_REGEXP_LINK, array('JComments', 'urlProcessor'), $title);
				}

				$title = JCommentsText::cleanText($title);
				$title = JCommentsText::substr($title, $maxlen);

				$link_title = str_replace( '"', '', $title );
				$link_text = $title;

				switch($showsmiles) {
					case 1:
						$link_text = $smiles->replace($link_text);
						break;
					case 2:
						$link_text = $smiles->strip($link_text);
						break;
				}

				echo '<li>';

				if ($showgravatars == 1) {
					if ($row->avatar == '') {
						echo '<img src="http://www.gravatar.com/avatar.php?gravatar_id='. md5( $row->email ) .'&amp;default=' . urlencode($mainframe->getCfg( 'live_site' ) . '/components/com_jcomments/images/no_avatar.png') . '&amp;size=' . $avatar_size . '"  alt="" border="0" />';
					} else {
						echo $row->avatar;
					}
				}

		    if ($show_date == 1) {
					echo '<span class="jcl_date">' . JCommentsText::formatDate( $row->date, $dateformat ) . '</span>';
				}

				if ($show_object_title == 1) {
					$title = JCommentsObjectHelper::getTitle( $row->object_id, $row->object_group );
					$title = JCommentsText::substr($title, $limit_object_title);
					$title = str_replace( '"', '', $title );

					echo '<noindex><a rel="nofollow" class="jcl_objtitle" href="'.$link.'#comment-'.$row->id.'" title="'.$title.'">'.$title.'</a></noindex>';
				}

				switch( $show_comment_text ) {
					case 0:
						echo '<span class="jcl_comment">'.$link_text.'</span>';
						break;
					case 1:
						echo '<noindex><a rel="nofollow" class="jcl_comment" href="'.$link.'#comment-'.$row->id.'" title="'.$link_title.'">'.$link_text.'</a></noindex>';
						break;
					case 2:
						echo '<span class="jcl_comment">'.$link_text.'</span> ';
						echo '<noindex><a rel="nofollow" class="jcl_readmore" href="'.$link.'#comment-'.$row->id.'">'.$label4more.'</a></noindex>';
						break;
				}

		
				switch( $show_author ) {
					case 0:
						break;
					case 1:
						echo '<br />' . ($label4author != '' ?  $label4author . ' ' : '') . $row->name;
						break;
					case 2:
						echo '<br />' . ($label4author != '' ?  $label4author . ' ' : '') . ($row->username ? $row->username : $row->name);
						break;
				}

				echo '</li>'."\n";
			}
			echo '</ul>'."\n";

			$show_full_rss = intval( $params->get( 'show_full_rss', 0 ) );
			$label4rss = $params->get( 'label4rss', '' );

			if ( $show_full_rss == 1 ) {
				if (JCOMMENTS_JVERSION == '1.5') {
					$rss_link = JoomlaTuneRoute::_('index.php?option=com_jcomments&amp;task=rss_full&amp;tmpl=component');
					$rss_icon_link = JURI::base() . 'modules/mod_jcomments/images/rss.gif';
				} else {
					$rss_link = $mainframe->getCfg( 'live_site' ) . '/index2.php?option=com_jcomments&amp;task=rss_full&amp;no_html=1';
					$rss_icon_link = $mainframe->getCfg('live_site') . '/modules/jcomments/rss.gif';
				}
?>
<div align="center"><noindex><a rel="nofollow" href="<?php echo $rss_link; ?>"><img src="<?php echo $rss_icon_link; ?>" alt="<?php echo $label4rss; ?>" border="0" /></a></noindex></div>
<?php
			}
		}
	}
}

// Set default values for all possible module parameters.
$params->def( 'moduleclass_sfx', '' );
$params->def( 'count', 5 );
$params->def( 'length', 20 );
$params->def( 'type', 1 );
$params->def( 'showcomments', 0 );

switch ( intval( $params->get( 'type' ) ) ) {
	case 1:
		modJCommentsLatest( $params );
		break;
	case 2:
		modJCommentsLatestCommented( $params );
		break;
	case 3:
		modJCommentsMostCommented( $params );
		break;
	case 4:
		modJCommentsLatest( $params, true, 'date' );
		break;
	case 5:
		modJCommentsLatest( $params, false, 'vote' );
		break;
	default:
		modJCommentsLatest( $params );
		break;
}
?>