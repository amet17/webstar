<?php
/**
 * SEF module for Joomla!
 * Originally written for Mambo as 404SEF by W. H. Welch.
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: install.sh404sef.php 1900 2011-04-15 16:28:21Z silianacom-svn $
 *
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

global $mainframe;
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.path');
jimport('joomla.html.parameter');
jimport('joomla.filter.filterinput');
jimport('joomla.utilities.string');

$front_live_site = rtrim(str_replace('/administrator', '', JURI::base()), '/');
$database	= & JFactory::getDBO();

// V 1.2.4.q Copy existing config file from /media to current component. Used to recover configuration when upgrading
// V 1.2.4.s check if old file exists before deleting stub config file
$oldConfigFile = JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_'
.str_replace('/','_',str_replace('http://', '', $front_live_site)).'.php';
if (JFile::exists($oldConfigFile)) {
  // update old config files from VALID_MOS check to _JEXEC
  $config = JFile::read($oldConfigFile);
  if ($config && strpos( $config, 'VALID_MOS') !== false) {
    $config = str_replace( 'VALID_MOS', '_JEXEC', $config);
    JFile::write( $oldConfigFile, $config);  // write it back
  }
  // now get back old config
  if (JFile::exists( JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'. DS .'config' . DS . 'config.sef.php')) {
    JFile::delete(JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'. DS .'config' . DS . 'config.sef.php');
  }
  JFile::copy( $oldConfigFile, JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'.DS.'config'.DS.'config.sef.php' );
}

// restore black/white lists
$folder = JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_security';
if (JFolder::exists( $folder)) {
  $fileList = JFolder::files( $folder);
  if (!empty( $fileList)) {
    foreach( $fileList as $file) {
      if (JFile::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'security'.DS.$file)) {
        JFile::delete(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'security'.DS.$file);
      }
      JFile::copy(JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_security'.DS.$file,
      JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'security'.DS.$file);
    }
  }
}
// if upgrading rather than installing from scratch, or after an uninstall
// we must not copy back saved configuration files and log files
// as this would overwrite up to date current ones
// note that above we restored main config file and
// security data files becomes blank files come
// with the extension, so they'll be deleted in any case
// and we have to restore them
$shouldRestore = shShouldRestore();

if($shouldRestore) {
  // restore log files
  $folder = JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_logs';
  if (JFolder::exists( $folder)) {
    $fileList = JFolder::files( $folder);
    if (!empty( $fileList)) {
      foreach( $fileList as $file) {
        JFile::copy(JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_logs'.DS.$file,
        JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'logs'.DS.$file);
      }
    }
  }

  // restore customized default params
  $oldCustomConfigFile = JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_'
  .str_replace('/','_',str_replace('http://', '', $front_live_site)).'.custom.php';
  if (is_readable($oldCustomConfigFile) && filesize($oldCustomConfigFile) > 1000) {
    // update old config files from VALID_MOS check to _JEXEC
    $config = JFile::read($oldCustomConfigFile);
    if ($config && strpos( $config, 'VALID_MOS') !== false) {
      $config = str_replace( 'VALID_MOS', '_JEXEC', $config);
      JFile::write( $oldCustomConfigFile, $config);  // write it back
    }
    if (JFile::exists( JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'. DS .'custom.sef.php')) {
      JFile::delete(JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'. DS .'custom.sef.php');
    }
    $result = JFile::copy( $oldCustomConfigFile, JPATH_ADMINISTRATOR. DS.'components'.DS.'com_sh404sef'.DS.'custom.sef.php' );
  }

}


$sef_config_class = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'sh404sef.class.php';
// Make sure class was loaded.
if (!class_exists('shSEFConfig')) {
  if (is_readable($sef_config_class)) {
    include( JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'. DS . 'shSEFConfig.class.php');
    require_once($sef_config_class);
  }
  else JError::RaiseError( 500, COM_SH404SEF_NOREAD."( $sef_config_class )<br />".COM_SH404SEF_CHK_PERMS);
}
$sefConfig = new shSEFConfig();

// instal module
$source = $this->parent->getPath('source');
$status = shInstallModule( 'mod_sh404sef_cpicon', $source);

// install plugins
$status = shInstallPluginGroup( 'system');
$status = shInstallPluginGroup( 'sh404sefcore');
$status = shInstallPluginGroup( 'sh404sefextplugins');

// now we insert the 404 error page into the database
// from version 1.5.5, the default content of 404 page has been largely modified
// to make use of the similar urls plugin (and potentially others)
// so we want to make sure people will have the new version of the 404 error page
shUpdateErrorPage();

// apply various DB updates
shUpdateDBStructure();


// message
// decide on help file language
$lang =& JFactory::getLanguage();
$languageName = $lang->get('backwardlang', 'english');
$basePath = JPATH_ROOT . '/administrator/components/com_sh404sef/language/%s.postinstall.php';
// fall back to english if language readme does not exist
jimport('joomla.filesystem.file');
if(!JFile::exists( sprintf( $basePath, $languageName))) {
  $languageName = 'english';
}

include sprintf( $basePath, $languageName);



/**
 * Insert into the content database an uncategorized article
 * which serves as a basis for the 404 error page
 * Article title is __404__
 * Prior to version 1.5.5, the article displayed for 404 errors
 * was titled 404. The new name ensures users who customized
 * will keep their old design in the db. They can either reselect it
 * from the control panel, or customize as well the new __404__ page
 * @return unknown_type
 */
function shUpdateErrorPage( $pageTitle = '__404__') {

  // get a db instance
  $db = & JFactory::getDBO();

  // do we already have a __404__ article?
  $query = 'select id from #__content where catid=0 and sectionid=0 and title=' . $db->quote( $pageTitle);
  $db->setQuery( $query);
  $id = $db->loadResult();

  // if required page is already there, go away
  if (!empty( $id)) {
    return;
  }

  // find about the default page content
  include_once(JPATH_ADMINISTRATOR. DS.'components'.DS.'com_sh404sef'.DS.'language/english.php');

  // now we can insert the new page content into the db
  $status = shInsertContent( $pageTitle, COM_SH404SEF_DEF_404_MSG);

  return $status;
}

/**
 * Performs update to db stucture on existing setups
 */
function shUpdateDBStructure() {

  // get a db instance
  $db = & JFactory::getDBO();

  /* Version 2.0. added 'type' and 'hits' columns to aliases table
   CREATE TABLE IF NOT EXISTS `#__sh404sef_aliases` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `newurl` varchar(255) NOT NULL DEFAULT '',
   `alias` varchar(255) NOT NULL DEFAULT '',
   `type` tinyint(3) NOT NULL DEFAULT '0',
   `hits` int(11) NOT NULL DEFAULT '0',
   PRIMARY KEY (`id`),
   KEY `newurl` (`newurl`),
   KEY `alias` (`alias`),
   KEY `type` (`type`)
   )*/

  // get list of columns
  $columns = $db->getTableFields( '#__sh404sef_aliases');

  // build required statements
  $subQueries = array();

  // check if new columns are there, add if not
  if (empty( $columns['#__sh404sef_aliases']['type'])) {
    $subQueries[]= 'add `type` tinyint(3) not null default "0"';
    $subQueries[]= 'add index `type` ( `type` )';
  }
  if (empty( $columns['#__sh404sef_aliases']['hits'])) {
    $subQueries[]= 'add `hits` int(11) NOT NULL DEFAULT "0"';
  }

  if (!empty( $subQueries)) {
    // aggregate sub-queries
    $subQueries = implode( ', ', $subQueries);

    // prepend query
    $query = 'alter table ' . $db->nameQuote( '#__sh404sef_aliases') . $subQueries;

    // run query
    $db->setQuery( $query);
    $db->query();
    $error = $db->getErrorNum();
    if (!empty( $error)) {
      global $mainframe;
      $mainframe->enqueueMessage( 'Error while upgrading the database : ' . $db->getErrorMsg(true)
      . '. Sh404SEF will probably not operate properly. Please uninstall it, then try again after checking your database server setup. Contact us in case this happens again.');
    }
  }

  // version 2.0 : added separate table for pageids
  /*
   * CREATE TABLE IF NOT EXISTS `#__sh404sef_pageids` (
   `id` int(11) NOT NULL auto_increment,
   `newurl` varchar(255) NOT NULL default '',
   `pageid` varchar(255) NOT NULL default '',
   `type` tinyint(3) NOT NULL DEFAULT '0',
   `hits` int(11) NOT NULL DEFAULT '0',
   PRIMARY KEY (`id`),
   KEY `newurl` (`newurl`),
   KEY `alias` (`pageid`),
   KEY `type` (`type`)
   ) ENGINE=MyISAM CHARACTER SET `utf8`;
   */

  $query = 'CREATE TABLE IF NOT EXISTS `#__sh404sef_pageids` (
        `id` int(11) NOT NULL auto_increment,
        `newurl` varchar(255) NOT NULL default \'\',
        `pageid` varchar(255) NOT NULL default \'\',
        `type` tinyint(3) NOT NULL DEFAULT \'0\',
        `hits` int(11) NOT NULL DEFAULT \'0\',
        PRIMARY KEY (`id`),
        KEY `newurl` (`newurl`),
        KEY `alias` (`pageid`),
        KEY `type` (`type`)
        ) ENGINE=MyISAM DEFAULT CHARACTER SET utf8;';

  // run query
  $db->setQuery( $query);
  $db->query();
  $error = $db->getErrorNum();
  if (!empty( $error)) {
    global $mainframe;
    $mainframe->enqueueMessage( 'Error while upgrading the database : ' . $db->getErrorMsg(true)
    . '. Sh404SEF will probably not operate properly. Please uninstall it, then try again after checking your database server setup. Contact us in case this happens again.');
  }

}


function shInstallModule( $module, $source) {

  $path = $source . DS . 'admin' . DS . 'modules' . DS .$module;

  $installer = new JInstaller;
  $result = $installer->install( $path);

  if ($result) {
    // get a db instance
    $db = & JFactory::getDBO();
    $query = "UPDATE #__modules SET position='icon', ordering=9, published=1 WHERE module=" . $db->Quote( $module);
    $db = &JFactory::getDBO();
    $db->setQuery($query);
    $db->query();

  } else {
    $app = &JFactory::getApplication();
    $app->enqueueMessage( 'Error installing sh404sef module: ' . $module);
  }
  return $result;
}

/**
 * Install all sh404sef plugins available in a given
 * group
 *
 * @param string $group name of group
 * @return boolean, true if success
 */
function shInstallPluginGroup( $group) {

  global $mainframe;

  $sourcePath = JPATH_ADMINISTRATOR. DS.'components'.DS.'com_sh404sef'.DS.'plugins'.DS.$group;

  // collect xml manifest files for all plugins in the source dir
  if (JFolder::exists( $sourcePath)) {
    $pluginList = JFolder::files( $sourcePath, '.xml$', $recurse = false, $fullpath = true);
  }

  if (empty( $pluginList)) {
    return false;
  }

  // process each plugin
  $errors = false;
  foreach( $pluginList as $pluginXMLFile) {
    // install the plugin itself
    $status = shInstallPlugin( $sourcePath, $pluginXMLFile, $group);
    // set flag if an error happened, but keep installing
    // other plugins
    $errors = $errors && $status;
    // also display status
    if (!$status) {
      $mainframe->enqueueMessage( 'Error installing sh404sef plugin from ' . $pluginXMLFile);
    }
  }

  // return true if no error at all
  return $errors == false;
}

/**
 * Install a plugin into the database, based on its xml file
 *
 * @param string $sourcePath directory where plugin files are found
 * @param $xmlFileName fullpath to xml manifest file
 * @param string $group name of group
 * @return boolean, true if success
 */
function shInstallPlugin( $sourcePath, $xmlFileName, $group) {


  $status = false;

  // get a Joomla xml file handler
  $xml  =& JFactory::getXMLParser('Simple');

  // read content from disk
  if (!$xml->loadFile($xmlFileName)) {
    return $status;
  }

  $root =& $xml->document;

  // find name of plugin
  $pluginName = $root->getElementByPath( 'name');
  $pluginName = JFilterInput::clean($pluginName->data(), 'string');

  // if we have a valid manifest file, process it
  if (!is_object($root) || $root->name() != 'install' || $root->attributes('type') != 'plugin' || $root->attributes('group') != $group) {
    return $status;
  }

  // process parameters
  $element = $root->getElementByPath( 'params');
  $params = is_object( $element) ? $element->children() : null;

  // build up the ini version of params (to be stored in the params columns of
  // joomla plugins table and extract our information
  // Process each parameter in the $params array.
  $pluginParams = '';
  if (!empty( $params)) {
    foreach ($params as $param) {
      if (!$name = $param->attributes('name')) {
        continue;
      }

      if (!$value = $param->attributes('default')) {
        continue;
      }

      // find element
      if ($name == 'plugin_element') {
        $pluginElement = $value;
      }

      // find folder
      if ($name == 'plugin_folder') {
        $pluginFolder = $value;
      }

      // build raw param string
      $pluginParams .= $name."=".$value."\n";
    }
  }

  // create configuration array
  $shConfig = array('name'=>$pluginName, 'element' => $pluginElement, 'folder'=>$pluginFolder,
      'access'=>0, 'ordering'=>10, 'published' => 1, 'iscore' => 0, 'client_id' => 0, 'checked_out' => 0, 
      'checked_out_time' => '0000-00-00 00:00:00',  'params'=>$pluginParams);

  // search for files
  $element = $root->getElementByPath( 'files');
  $filesElements = $element->children();
  // always include xml manifest file
  $files = array( $pluginElement . '.xml');
  $folders = array( $pluginFolder);
  $foldersToCopy = array();

  // then add other files listed in the manifest
  if (!empty( $filesElements)) {
    foreach($filesElements as $fileElement) {
      if ($fileElement->name() == 'filename') {
        $file = $fileElement->data();
        $files[] = $file;
        // check for subfolders
        if (JString::strpos( $file, '/') !== false) {
          // there is a subfolder in the path, add to list of folders
          $bits = explode( '/', $file);
          // remove the file name itself
          $bits = array_pop( $bits);
          // add remaining folders to list, removing duplicates
          foreach( $bits as $bit) {
            if (!in_array( $bit, $folders)) {
              $folders[] = $bit;
            }
          }
        }
      } else if($fileElement->name() == 'folder') {
        // we should recurse through all sub folders as well!
        $foldersToCopy[] = $fileElement->data();
      }
    }
  }

  // now copy files and insert into db
  if (!empty( $pluginName) && !empty( $pluginElement) && !empty( $pluginFolder)) {
    shInsertPlugin( $sourcePath, $shConfig, $files, $folders, $foldersToCopy);
    $status = true;
  }

  return $status;
}

/**
 * Insert in the db the previously retrieved parameters for a plugin
 * including publication information. Also move files as required
 *
 * @param string $basePath , the base path to get original files from
 * @param array $shConfig an array holding the database parameters of the plugin
 * @param array $files, an array holding list of files from the plugin
 */
function shInsertPlugin( $basePath, $shConfig, $files, $folders, $foldersToCopy) {

  // check data
  if (empty( $files)) {
    return;
  }

  // move the files to target location
  $result = array();
  $resultFolders = array();
  $success = true;
  // create folders as needed
  if (!empty( $folders)) {
    foreach( $folders as $folder) {
      $success = $success && JFolder::create( JPATH_ROOT.DS.'plugins'.DS. $folder);
    }
  }

  // copy raw folders as needed
  if (!empty( $foldersToCopy)) {
    foreach( $foldersToCopy as $folder) {
      $success = $success && JFolder::copy(
      JPATH_ADMINISTRATOR. DS.'components'.DS.'com_sh404sef'.DS.'plugins'. DS . $shConfig['folder'] . DS . $folder,
      JPATH_ROOT.DS.'plugins'.DS. $shConfig['folder'] . DS . $folder, $path = '', $forced = true);
      $result[$folder] = $success;
    }
  }

  // now move files across
  if ($success) {
    foreach( $files as $pluginFile) {

      $target = JPath::clean( JPATH_ROOT.DS.'plugins'.DS.$shConfig['folder'].DS.$pluginFile);
      $source = JPath::clean( $basePath.DS.$pluginFile);
      $success = $success && true === JFile::copy( $source, $target);
      $resultFolders[$pluginFile] = $success;
    }

    // check and add an index.html file if it does not exists
    $target = JPath::clean( JPATH_ROOT.DS.'plugins'.DS.$shConfig['folder'].DS.'index.html');
    if (!JFile::exists( $target)) {
      $source = JPath::clean( JPATH_ROOT.DS.'plugins'.DS.'index.html');
      $success = $success && true === JFile::copy( $source, $target);
    }
  }
  // if files moved to destination, setup plugin in Joomla database
  if ($success) {

    $shouldRestore = shShouldRestore();

    if ($shouldRestore) {

      // read stored params from disk
      shGetExtensionSavedParams( $shConfig['folder'] . '.' . $shConfig['element'], $shConfig);

    }

    // insert elements in db, but only if it does not exist
    // we can't use insert ignore, as the record may have been modified by user (unpublished, order change)
    $db = &JFactory::getDBO();
    $sql = 'select count(id) from `#__plugins` where '
    . ' `element` = ' . $db->Quote($shConfig['element'])
    . ' and `folder` = ' . $db->Quote($shConfig['folder']);

    $db->setQuery( $sql);
    $alreadyInstalled = $db->loadResult();

    if (empty( $alreadyInstalled)) {
      $sql="INSERT INTO `#__plugins` ( `name`, `element`, `folder`, `access`, `ordering`, `published`,"
      . " `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`)"
      . " VALUES ('{$shConfig['name']}', '{$shConfig['element']}', '{$shConfig['folder']}', '{$shConfig['access']}', '{$shConfig['ordering']}',"
      . " '{$shConfig['published']}', '{$shConfig['iscore']}', '{$shConfig['client_id']}', '{$shConfig['checked_out']}',"
      . " '{$shConfig['checked_out_time']}', '{$shConfig['params']}');";
      $db->setQuery( $sql);
      $db->query();
      if (!empty($db->getErrorNum)) {
        echo $db->getErrorMsg() . '<br />';
      }
    }

  } else {  // failure while copying files

    // don't leave anything behind
    foreach( $files as $pluginFile) {
      if (!empty($result[$pluginFile])) {
        // if file was copied, try to delete it
        JFile::delete( JPATH_ROOT.DS.'plugins' . DS . $shConfig['folder'] . DS . $pluginFile);
      }
    }
    // also delete folders
    if (!empty( $resultFolders)) {
      foreach( $resultFolders as $folder) {
        if ($resultFolders[$folder]) {
          // if file was copied, try to delete it
          JFolder::delete( JPATH_ROOT.DS.'plugins' . DS . $shConfig['folder'] . DS . $folder);
        }
      }
    }
    JError::RaiseWarning( 500, JText::_('Could not install plugin'));
  }

  return $success;
}

/**
 * Retrieves stored params of a given extension (module or plugin)
 * (as saved upon uninstall)
 *
 * @param string $extName the module name, including mod_ if a module
 * @param array $shConfig an array holding the database columns of the extension
 * @param array $shPub, an array holding the publication information of the module (only for modules)
 * @return boolean, true if any stored parameters were found for this extension
 */
function shGetExtensionSavedParams( $extName, &$shConfig, &$shPub = null, $useId = false) {

  static $fileList = array();

  // prepare default return value
  $status = false;

  // read all file names in /media/sh404_upgrade_conf dir, for easier processing
  $baseFolder = JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf';
  if (JFolder::exists( $baseFolder) && (empty( $fileList) || !isset($fileList[$extName]))) {
    $baseName = $extName . ($useId ? '_[0-9]{1,10}':'').'_'.str_replace('/','_',str_replace('http://', '', JURI::base())).'.php';
    $fileList[$extName] = JFolder::files( $baseFolder, $baseName);
  }

  // extract filename from list we've established previously
  $extFile = isset($fileList[$extName]) && $fileList[$extName] !== false ? array_shift( $fileList[$extName]) : '';
  if (empty( $fileList[$extName])) {
    // prevent infinite loop
    $fileList[$extName] = false;
  }

  if (!empty( $extFile) && JFile::exists( $baseFolder . DS . $extFile)) {
    $status = true; // operation was successful
    include( $baseFolder . DS . $extFile);
  }

  return $status;
}

/**
 * Decide whether backed up params should be restore (and
 * plugins reinstalled).
 * This should happen only when the extension is NOT already
 * installed. Most of times, as we are using updagre install
 * that should not happen and we jst overwrite
 * but if user uninstalled the extension, we must restore
 * data saved when he uninstalled
 *
 */
function shShouldRestore() {

  // IMPORTANT: the check is done once, and only once
  // as for later calls, the system plugin will have been installed
  // and thus the test will not be valid anymore
  static $restore = null;

  if (is_null( $restore)) {

    // search for base xml file to decide if already installed
    $restore = !JFile::exists( JPATH_ROOT. DS .'plugins'.DS.'system'. DS . 'shsef.xml');
  }

  return $restore;
}