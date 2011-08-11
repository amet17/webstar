<?php
/**
 * sh404SEF support for kunena forum component.
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_kunena.php 1832 2011-02-28 15:46:33Z silianacom-svn $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG;
$sefConfig = & shRouter::shGetConfig();
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin( $lang, $shLangName, $shLangIso, $option);
if ($dosef == false) return;
// ------------------  standard plugin initialize function - don't change ---------------------------

// ------------------  load language file - adjust as needed ----------------------------------------
$shLangIso = shLoadPluginLanguage( 'com_kunena', $shLangIso, 'COM_SH404SEF_KU_SHOW_USER_PROFILE');
// ------------------  load language file - adjust as needed ----------------------------------------

$Itemid = isset($Itemid) ? $Itemid : null;

// start Kunena specific stuff
$func = isset($func) ? $func : null;
$task = isset($task) ? $task : null;
$do = isset($do) ? $do : null;
$catid = isset($catid) ? $catid : null;
$id = isset($id) ? $id : null;
$userid = isset($userid) ? $userid : null;
$page = isset($page) ? $page : null;
$sel = isset($sel) ? $sel : null;
$view = isset($view) ? $view : null;

if(!function_exists('shKUGetVersion')) {
  function shKUGetVersion() {

    static $version = null;

    if (is_null( $version)) {
      $version = '';
      $versionFile = JPATH_ROOT  .DS. 'components' .DS. 'com_kunena' .DS. 'lib' .DS. 'kunena.version.php';
      if (JFile::exists( $versionFile)) {
        require_once $versionFile;
        $version = CKunenaVersion::versionArray();
        $version = $version->version;
      }
    }

    return $version;
  }
}

if(!function_exists('shKUGetTablePrefix')) {
  function shKUGetTablePrefix() {

    static $prefix = null;

    if (is_null( $prefix)) {

      $prefix = version_compare( shKUGetVersion(), '1.6.0') == -1 ? '#__fb' : '#__kunena';
    }

    return $prefix;
  }
}

if (!function_exists('shKUCategoryName')) {
  function shKUCategoryName( $catid, $option, $shLangIso, $shLangName) {

    global $sh_LANG;

    static $cats = null;

    $sefConfig = & shRouter::shGetConfig();

    if (empty($catid) || !$sefConfig->shFbInsertCategoryName) {
      return '';
    }

    if (is_null($cats)) {
      $database =& JFactory::getDBO();
      $query  = 'SELECT id, name FROM '. shKUGetTablePrefix() . '_categories' ;
      $database->setQuery( $query);
      if (!shTranslateUrl($option, $shLangName)) {
        $cats = $database->loadObjectList( 'id', false);
      } else {
        $cats = $database->loadObjectList( 'id');
      }
    }

    $shCat = empty($cats[$catid])?  // no name available
    $sh_LANG[$shLangIso]['COM_SH404SEF_KU_CATEGORY'] . $sefConfig->replacement . $catid // put ID
    : ($sefConfig->shFbInsertCategoryId ? $catid . $sefConfig->replacement : ''); // if name, put ID only if requested
    return $shCat . (empty( $cats[$catid] ) ? '' : $cats[$catid]->name);
  }
}

if (!function_exists('shKUserDetails')) {
  function shKUserDetails( $userid, $option, $shLangIso, $shLangName) {


    static $users = array();

    $sefConfig = & shRouter::shGetConfig();

    if (empty($userid) || !$sefConfig->shFbInsertUserName) {
      return '';
    }

    if (empty($users[$userid])) {
      $database =& JFactory::getDBO();
      $query  = "SELECT id, username FROM #__users where id = " . $database->Quote( $userid) ;
      $database->setQuery( $query);
      if (!shTranslateUrl($option, $shLangName)) {
        $userDetails = $database->loadObject( false);
      } else {
        $userDetails = $database->loadObject();
      }
      if (!empty( $userDetails)) {
        $users[$userid] = $userDetails->username;
      }
    }

    // we have a user name
    $userString = empty($users[$userid])?  'u' . $sefConfig->replacement . $userid // put ID
    : ($sefConfig->shFbInsertUserId ? $userid . $sefConfig->replacement : ''); // if name, put ID only if requested

    $userString =  $userString . (empty( $users[$userid] ) ? '' : $users[$userid]);

    return $userString;
  }
}

if (!function_exists('shKUTopicName')) {
  function shKUTopicName( $topicid, $option, $shLangIso, $shLangName) {

    static $topics = array();

    $sefConfig = & shRouter::shGetConfig();

    if (empty($topicid) || !$sefConfig->shFbInsertMessageSubject) {
      return '';
    }

    if (empty($topics[$topicid])) {
      $database =& JFactory::getDBO();
      $query  = 'SELECT id, subject FROM '. shKUGetTablePrefix() . '_messages where id = ' . $database->Quote( $topicid) ;
      $database->setQuery( $query);
      if (!shTranslateUrl($option, $shLangName)) {
        $topicDetails = $database->loadObject( false);
      } else {
        $topicDetails = $database->loadObject();
      }
      if (!empty( $topicDetails)) {
        $topics[$topicid] = $topicDetails->subject;
      }
    }

    // we have a user name
    $topicstring = empty($topics[$topicid])?  't' . $sefConfig->replacement . $topicid // put ID
    : ($sefConfig->shFbInsertMessageId ? $topicid . $sefConfig->replacement : ''); // if name, put ID only if requested

    $topicstring =  $topicstring . (empty( $topics[$topicid] ) ? '' : $topics[$topicid]);

    return $topicstring;
  }
}

// shumisha : insert magazine name from menu
$shKUName = shGetComponentPrefix($option);
$shKUName = empty($shKUName) ?  getMenuTitle($option, null, $Itemid, null, $shLangName ) : $shKUName;
$shKUName = (empty($shKUName) || $shKUName == '/') ? 'Forum':$shKUName; // V 1.2.4.t

// now build sef url
switch (strtolower($func)) {

  case 'who':
  case 'json':
  case 'polls':
    $dosef = false;
    break;

  case 'thankyou':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    };
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_THANKYOU'];
    shRemoveFromGETVarsList('func');
    break;

  case 'announcement':
    $dosef = false;
    break;

  case 'stats':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    };
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_STATS'];
    shRemoveFromGETVarsList('func');
    break;

  case 'profile':
  case 'fbprofile':
    if ($sefConfig->shInsertFireboardName && !$sefConfig->shFbShortUrlToProfile)  {
      $title[] = $shKUName;
    };
    // optionnally add user name
    $shUserName = shKUserDetails( $userid, $option, $shLangIso, $shLangName);
    if (!empty( $shUserName)) {
      $title[] = $shUserName;
      shRemoveFromGETVarsList('userid');
    }
    if (!$sefConfig->shFbShortUrlToProfile) {
      $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_USER_PROFILE'];
    }
    if ($sefConfig->shFbShortUrlToProfile) {
      $title[] = '/';
    }
    shRemoveFromGETVarsList('func');
    break;

  case 'userlist':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    };
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_USER_LIST'];
    shRemoveFromGETVarsList('func');
    break;

  case 'post':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    shRemoveFromGETVarsList('func');
    // add cat and topic infos if present
    $shCat = shKUCategoryName( $catid, $option, $shLangIso, $shLangName);  // V 1.2.4.q $option was missing
    if (!empty ($shCat)) {
      $title[] = $shCat;
      shRemoveFromGETVarsList('catid');
    }
    $shTopic = shKUTopicName( $id, $option, $shLangIso, $shLangName);  // V 1.2.4.q $option was missing
    if (!empty ($shTopic)) {
      $title[] = $shTopic;
      if ($sefConfig->shFbInsertMessageId) {  // only remove post id if it was inserted in message
        shRemoveFromGETVarsList('id');
      }
    }
    switch ($do) {
      case 'reply': // do = reply id=1 catid=2
        if (empty( $id)) {
          $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_NEW_THREAD'];
          shRemoveFromGETVarsList('id');
        } else {
          $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_REPLY'];
        }
        shRemoveFromGETVarsList('do');
        break;
        // do = subscribe catid=2 id = 1 fb_thread = 1
      case 'subscribe':
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SUBSCRIBE'];
        shRemoveFromGETVarsList('do');
        break;
      case 'unsubscribe':
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_UNSUBSCRIBE'];
        shRemoveFromGETVarsList('do');
        break;
        // do = favorite catid=2 id = 1 fb_thread = 1
      case 'favorite':
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_FAVORITE'];
        shRemoveFromGETVarsList('do');
        break;
        // do=quote&replyto=1&catid=2
      case 'quote':
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_QUOTE'];
        shRemoveFromGETVarsList('do');
        break;
        // do=delete&id=1&catid=2
      case 'delete':
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_DELETE'];
        shRemoveFromGETVarsList('do');
        break;
        // do=move&id=1&catid=2&name=bestofjoomla
      case 'move':
        $dosef = false;
        break;
        // do=edit&id=1&catid=2
      case 'edit':
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_EDIT'];
        shRemoveFromGETVarsList('do');
        break;
      case 'newFromBot':  // V 1.2.4.s
      case 'newfrombot':
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_NEW_FROM_BOT'];
        // workaround for discuss bot/ FB 1.0.0 and 1.0.1 bug
        if ($do != 'newFromBot') {
          $do = 'newFromBot';
          shAddToGETVarsList('do', $do);
        }
        shRemoveFromGETVarsList('do');
        break;
        // do=sticky&id=1&catid=2
      case 'sticky':
        $dosef = false;
        break;
        // do=lock&id=1&catid=2
      case 'lock':
        $dosef = false;
        break;
      default:  // if creating new post, data is passed through POST, so other variables than func is not available
        $dosef = false;
        break;
    }

    break;

  case 'view':
    //catid= 2
    //id=1
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    shRemoveFromGETVarsList('func');
    $shCat = shKUCategoryName( $catid, $option, $shLangIso, $shLangName);  // V 1.2.4.q $option was missing !
    if (!empty ($shCat)) {
      $title[] = $shCat;
    }
    shRemoveFromGETVarsList('catid');
    $result = null;
    $shTopic = shKUTopicName( $id, $option, $shLangIso, $shLangName);  // V 1.2.4.q $option was missing
    if (!empty ($shTopic)) {
      $title[] = $shTopic;
      shRemoveFromGETVarsList('id');
    }
    break;

  case 'faq':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_FAQ'];
    shRemoveFromGETVarsList('func');
    break;

  case 'showcat':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    shRemoveFromGETVarsList('func');
    $shCat = shKUCategoryName( $catid, $option, $shLangIso, $shLangName);
    if (!empty ($shCat)) {
      $title[] = $shCat;
      shRemoveFromGETVarsList('catid');
    }
    /*    switch ($view){
     case 'threaded':
     $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_THREADED'];
     shRemoveFromGETVarsList('view');
     break;
     case 'flat':
     $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_FLAT'];
     shRemoveFromGETVarsList('view');
     break;
     }*/
    if (!empty( $view)) {
      shRemoveFromGETVarsList('view');
    }
    if (!empty($title)) {
      $title[] = '/';
    }
    break;

  case 'listcat':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_LIST_CAT'];
    $shCat = shKUCategoryName( $catid, $option, $shLangIso, $shLangName);
    if (!empty ($shCat)) {
      $title[] = $shCat;
    }
    shRemoveFromGETVarsList('func');
    shRemoveFromGETVarsList('catid');
    $title[] = '/';
    break;

  case 'subscribecat':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SUBSCRIBE'];
    $shCat = shKUCategoryName( $catid, $option, $shLangIso, $shLangName);
    if (!empty ($shCat)) {
      $title[] = $shCat;
    }
    shRemoveFromGETVarsList('func');
    shRemoveFromGETVarsList('catid');
    $title[] = '/';
    break;

  case 'unsubscribecat':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_UNSUBSCRIBE'];
    $shCat = shKUCategoryName( $catid, $option, $shLangIso, $shLangName);
    if (!empty ($shCat)) {
      $title[] = $shCat;
    }
    shRemoveFromGETVarsList('func');
    shRemoveFromGETVarsList('catid');
    $title[] = '/';
    break;

  case 'review':
    $dosef = false;
    break;

  case 'rules':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    shRemoveFromGETVarsList('func');
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_RULES'];
    break;

  case 'userprofile':
    shRemoveFromGETVarsList('func');
    switch ($do) {
      case'':
      case 'show':
        if ($sefConfig->shInsertFireboardName) {
          $title[] = $shKUName;
        }
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_USER_PROFILE'];
        shRemoveFromGETVarsList('do');
        break;
      case 'unfavorite':
        if ($sefConfig->shInsertFireboardName)  {
          $title[] = $shKUName;
        }
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_USER_UNFAVORITE'];
        shRemoveFromGETVarsList('do');
        break;
      case 'unsubscribe':
        if ($sefConfig->shInsertFireboardName)  {
          $title[] = $shKUName;
        }
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_USER_UNSUBSCRIBE'];
        shRemoveFromGETVarsList('do');
        break;
      case 'update':
        if ($sefConfig->shInsertFireboardName)  {
          $title[] = $shKUName;
        }
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_USER_UPDATE'];
        shRemoveFromGETVarsList('do');
        break;
      default:
        $dosef = false;
        break;
    }
    break;

  case 'myprofile':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    switch ($do) {
      case'':
      case 'show':
        $title[]= $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_MY_PROFILE'];
        shRemoveFromGETVarsList('func');
        shRemoveFromGETVarsList('do');
        break;
      case 'userdetails':
        $title[]= $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_MY_USERDETAILS'];
        shRemoveFromGETVarsList('func');
        shRemoveFromGETVarsList('do');
        break;
      case 'avatar':
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_MY_AVATAR'];
        shRemoveFromGETVarsList('func');
        shRemoveFromGETVarsList('do');
        break;
      case 'showset':
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_MY_SHOWSET'];
        shRemoveFromGETVarsList('func');
        shRemoveFromGETVarsList('do');
        break;
      case 'profileinfo':
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_MY_PROFILEINFO'];
        shRemoveFromGETVarsList('func');
        shRemoveFromGETVarsList('do');
        break;
      case 'showmsg':
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_MY_SHOW_MESSAGES'];
        shRemoveFromGETVarsList('func');
        shRemoveFromGETVarsList('do');
        break;
      case 'showsub':
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_MY_SHOW_SUB'];
        shRemoveFromGETVarsList('func');
        shRemoveFromGETVarsList('do');
        break;
      case 'showfav':
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_MY_SHOW_FAV'];
        shRemoveFromGETVarsList('func');
        shRemoveFromGETVarsList('do');
        break;
      default:
        $dosef = false;
        break;
    }
    break;

  case 'report':
    $dosef = false;
    break;

  case 'latest':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    if ($do == 'show' && isset($sel)) {
      $title[]= $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_LATEST_'.$sel];
    } else {
      $title[]= $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_LATEST'];
    }
    shRemoveFromGETVarsList('do');
    shRemoveFromGETVarsList('func');
    if (isset($sel)) {
      shRemoveFromGETVarsList('sel');
    }
    break;
  case 'mylatest':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    $title[]= $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_MY_LATEST'];
    shRemoveFromGETVarsList('func');
    break;

  case 'search':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    $title[]= $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SEARCH'];
    shRemoveFromGETVarsList('func');
    break;
  case 'advsearch':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    $title[]= $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SEARCH_ADVANCED'];
    shRemoveFromGETVarsList('func');
    break;

  case 'markthisread':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    $shCat = shKUCategoryName( $catid, $option, $shLangIso, $shLangName);  // V 1.2.4.q $option was missing
    if (!empty ($shCat)) {
      $title[] = $shCat;
      shRemoveFromGETVarsList('catid');
    }
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_MARK_THIS_READ'];
    shRemoveFromGETVarsList('func');
    break;

  case 'karma':
    $dosef = false;
    break;

  case 'bulkactions':
    switch ($do)
    {
      case "bulkDel":
        $dosef = false;
        break;

      case "bulkMove":
        $dosef = false;
        break;
    }

    break;

  case "templatechooser":
    $dosef = false;
    break;

  case 'credits':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_CREDITS'];
    shRemoveFromGETVarsList('func');
    shRemoveFromGETVarsList('catid');
    break;

  case 'fb_pdf':
  case 'pdf':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    $title[] = 'pdf';
    shRemoveFromGETVarsList('func');
    break;

  case 'fb_rss':
  case 'rss':
    if ($sefConfig->shInsertFireboardName)  {
      $title[] = $shKUName;
    }
    $title[] = 'rss';
    shRemoveFromGETVarsList('func');
    shRemoveFromGETVarsList('no_html');
    break;

  default:
    if ( version_compare( shKUGetVersion(), '1.6.0') == -1) {
      // pre-1.6.0
      if (empty( $title))  {
        $title[] = $shKUName;
      }
      $title[] = '/';
    }
    break;
}

if ( version_compare( shKUGetVersion(), '1.6.0') != -1) {
  // version 1.6+ : use view instead of func for some functions
  switch ($view) {

    case 'listcat':
      if ($sefConfig->shInsertFireboardName)  {
        $title[] = $shKUName;
      }
      $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_LIST_CAT'];
      $shCat = shKUCategoryName( $catid, $option, $shLangIso, $shLangName);  // V 1.2.4.q $option was missing
      if (!empty ($shCat)) {
        $title[] = $shCat;
      }
      shRemoveFromGETVarsList('view');
      shRemoveFromGETVarsList('catid');
      $title[] = '/';
      break;

    case 'rules':
      if ($sefConfig->shInsertFireboardName)  {
        $title[] = $shKUName;
      }
      shRemoveFromGETVarsList('view');
      $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_RULES'];
      break;

    case 'latest':
      if ($sefConfig->shInsertFireboardName)  {
        $title[] = $shKUName;
      }
      switch ($do) {
        case 'show':
          if (isset($sel)) {
            $title[]= $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_LATEST_'.$sel];
          } else {
            $title[]= $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_LATEST'];
          }
          shRemoveFromGETVarsList('do');
          if (isset($sel)) {
            shRemoveFromGETVarsList('sel');
          }
          break;
        case 'noreplies':
          $title[]= $sh_LANG[$shLangIso]['COM_SH404SEF_KU_NO_REPLY'];
          shRemoveFromGETVarsList('do');
          break;
        case 'mylatest':
          $title[]= $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_MY_LATEST'];
          shRemoveFromGETVarsList('do');
          break;
        case '':
          $title[]= $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_LATEST'];
          break;
      }
      shRemoveFromGETVarsList('view');
      break;
    case 'profile':
      if ($sefConfig->shInsertFireboardName && !$sefConfig->shFbShortUrlToProfile)  {
        $title[] = $shKUName;
      };
      // optionnally add user name
      $shUserName = shKUserDetails( $userid, $option, $shLangIso, $shLangName);
      if (!empty( $shUserName)) {
        $title[] = $shUserName;
        shRemoveFromGETVarsList('userid');
      }
      if (!$sefConfig->shFbShortUrlToProfile || empty($shUserName)) {
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_USER_PROFILE'];
      }
      if ($sefConfig->shFbShortUrlToProfile) {
        $title[] = '/';
      }
      shRemoveFromGETVarsList('view');
      break;
    case 'help':
      if ($sefConfig->shInsertFireboardName)  {
        $title[] = $shKUName;
      }
      $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SHOW_FAQ'];
      shRemoveFromGETVarsList('view');
      break;
    case 'search':
      if ($sefConfig->shInsertFireboardName)  {
        $title[] = $shKUName;
      }
      $title[]= $sh_LANG[$shLangIso]['COM_SH404SEF_KU_SEARCH'];
      shRemoveFromGETVarsList('view');
      break;
    case 'entrypage':
      if (empty( $title))  {
        $title[] = $shKUName;
      }
      $title[] = '/';
      shRemoveFromGETVarsList('view');
      shRemoveFromGETVarsList('defaultmenu');
      break;
    case 'post':
      if ($sefConfig->shInsertFireboardName)  {
        $title[] = $shKUName;
      }
      switch ($do) {
        case 'new':
          $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_KU_NEW_THREAD'];
          shRemoveFromGETVarsList('do');
          shRemoveFromGETVarsList('view');
          break;
        default:
          $dosef = false;
          break;
      }
    case '':
      break;
    default:
      if (empty( $title))  {
        $title[] = $shKUName;
      }
      $title[] = '/';
      break;
  }

}


shRemoveFromGETVarsList('option');
if (!empty($lang))
shRemoveFromGETVarsList('lang');
if (!empty($Itemid))
shRemoveFromGETVarsList('Itemid');

if(!empty($limit)) {
  shRemoveFromGETVarsList('limit');
}
if(isset($limitstart)) {
  shRemoveFromGETVarsList('limitstart');
}

// ------------------  standard plugin finalize function - don't change ---------------------------
if ($dosef){
  $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString,
  (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null),
  (isset($shLangName) ? @$shLangName : null));
}
// ------------------  standard plugin finalize function - don't change ---------------------------

