<?php

/**
 * SEF extension for Joomla!
 * Originally written for Mambo as 404SEF by W. H. Welch.
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2009-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: uninstall.sh404sef.php 1842 2011-03-02 19:51:18Z silianacom-svn $
 */


defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

global $mainframe;
jimport('joomla.filesystem.file');
$front_live_site = JString::rtrim(str_replace('/administrator', '', JURI::base()), '/');

// V 1.2.4.t improved upgrading
function shDeletetable( $tableName) {
  $database	= & JFactory::getDBO();
  $sql = 'DROP TABLE #__'.$tableName;
  $database->setQuery( $sql);
  $database->query();
}

function shDeleteAllSEFUrl( $kind) {

  $database	= & JFactory::getDBO();
  $sql = 'DELETE FROM #__redirection WHERE ';
  If ($kind == 'Custom')
  $where = '`dateadd` > \'0000-00-00\' and `newurl` != \'\';';
  else
  $where = '`dateadd` = \'0000-00-00\';';
  $database->setQuery($sql.$where);
  $database->query();
}

/*
 *
 * Start of running code
 *
 */

$database	= & JFactory::getDBO();
// V 1.2.4.t before uninstalling modules, save their settings, if told to do so
$sef_config_class = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'sh404sef.class.php';
// Make sure class was loaded.
if (!class_exists('shSEFConfig')) {
  if (is_readable($sef_config_class)) require_once($sef_config_class);
  else
  JError::RaiseError(500, COM_SH404SEF_NOREAD."( $sef_config_class )<br />".COM_SH404SEF_CHK_PERMS);
}
$sefConfig = new shSEFConfig();
if (!$sefConfig->shKeepStandardURLOnUpgrade && !$sefConfig->shKeepCustomURLOnUpgrade) {
  shDeleteTable('redirection');
  shDeleteTable('sh404sef_aliases');
  shDeleteTable('sh404sef_pageids');
}
elseif (!$sefConfig->shKeepStandardURLOnUpgrade)
shDeleteAllSEFUrl('Standard');
elseif (!$sefConfig->shKeepCustomURLOnUpgrade) {
  shDeleteAllSEFUrl('Custom');
  shDeleteTable('sh404sef_aliases');
  shDeleteTable('sh404sef_pageids');
}

if (!$sefConfig->shKeepMetaDataOnUpgrade)
shDeleteTable('sh404SEF_meta');

// remove admin quick icon module
shSaveDeleteModuleParams( 'mod_sh404sef_cpicon', $client = 1);

// remove system plugin
shSaveDeletePluginParams( 'shsef', 'system', $folders = null);
shSaveDeletePluginParams( 'shjlang16', 'system', $folders = array( 'shjlang16'));
shSaveDeletePluginParams( 'shmobile', 'system', $folders = array( 'shmobile'));

// remove core plugins
shSaveDeletePluginGroup( 'sh404sefcore');
shSaveDeletePluginGroup( 'sh404sefextplugins');

// delete analytics cached data, to force update
// in case this part of sh404sef has changed
$cache = & JFactory::getCache( 'sh404sef_analytics');
$cache->clean();

// preserve configuration or not ?
if (!$sefConfig->shKeepConfigOnUpgrade) {

  // main config file
  $fileName = JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_'.str_replace('/','_',str_replace('http://', '', $front_live_site)).'.php';
  if (JFile::exists( $fileName)) {
    JFile::delete( $fileName);
  }

  // user custom config file
  $fileName = JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_'.str_replace('/','_',str_replace('http://', '', $front_live_site)).'.custom.php';
  if (JFile::exists( $fileName)) {
    JFile::delete( $fileName);
  }

  // related extensions (plugins) config files folder
  if (JFolder::exists( JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf')) {
    JFolder::delete( JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf');
  }

  // log files folder
  if (JFolder::exists( JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_logs')) {
    JFolder::delete( JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_logs');
  }

  // security log files folder
  if (JFolder::exists( JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_security')) {
    JFolder::delete( JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_security');
  }

}
// must move log files out of the way, otherwise administrator/com_sh404sef/logs will not be deleted
// and next installation of com_sh404sef will fail
else { // if we keep config

  if (JFolder::exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'logs')) {
    JFolder::copy( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'logs', JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_logs', $path = '', $force = true);
  }

  if (JFolder::exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'security')) {
    JFolder::copy( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'security', JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf_security', $path = '', $force = true);
  }

}

// display results
echo '<h3>sh404SEF has been succesfully uninstalled. </h3>';
echo '<br />';
if ($sefConfig->shKeepStandardURLOnUpgrade)
echo '- automatically generated SEF url have not been deleted (table #__redirection)<br />';
else
echo '- automatically generated SEF url have been deleted<br />';
echo '<br />';
if ($sefConfig->shKeepCustomURLOnUpgrade)
echo '- custom SEF url, aliases and shURLs have not been deleted (tables #__redirection, #__sh404sef_aliases and #__sh404sef_pageids)<br />';
else
echo '- custom SEF url, aliases and shURLs have been deleted<br />';
echo '<br />';
if ($sefConfig->shKeepMetaDataOnUpgrade)
echo '- Custom Title and META data have not been deleted (table #__sh404SEF_meta)<br />';
else
echo '- Custom Title and META data have been deleted<br />';
echo '<br />';

/**
 *
 * utility functions
 *
 */
/**
 * Writes an extension parameter to a disk file, located
 * in the /media directory
 *
 * @param string $extName the extension name
 * @param array $shConfig associative array of parameters of the extension, to be written to disk
 * @param array $pub, optional, only if module, an array of the menu item id where the module is published
 * @return boolean, true if no error
 */
function shWriteExtensionConfig( $extName, $params) {

  if (empty($params)) {
    return;
  }

  // calculate target file name
  $extPath = JPATH_ROOT.DS.'media'.DS.'sh404_upgrade_conf';

  // if it does not exists, lets create it first
  if(!JFolder::exists( $extPath)) {
    JFolder::create( $extPath);
  }

  // make sure we have an index.html file in that folder
  $target = JPath::clean( $extPath . DS . 'index.html');
  if (!JFile::exists( $target)) {
    // copy one Joomla's index.html file to the backup directory
    $source = JPath::clean( JPATH_ROOT.DS.'plugins'.DS.'index.html');
    $success = JFile::copy( $source, $target);
  }

  // now build full path file name to save config
  $extFile = $extPath . DS . $extName .'_' .str_replace('/','_',str_replace('http://', '', JURI::base())).'.php';

  // remove previous if any
  if (JFile::exists( $extFile)) {
    JFile::delete( $extFile);
  }

  // prepare data for writing
  $data = '<?php // Extension params save file for sh404sef
//    
if (!defined(\'_JEXEC\')) die(\'Direct Access to this location is not allowed.\');';
  $data .= "\n";

  if (!empty( $params)) {
    foreach( $params as $key => $value) {
      $data .= '$'. $key . ' = ' . var_export($value, true) . ';';
      $data .= "\n";
    }
  }

  // write to disk
  $success = JFile::write( $extFile, $data);

  return $success !== false;
}

/**
 * Save parameters, then delete a module
 * Would not work on additional copies made by user
 *
 * @param string $moduleName, the module name, matching 'module' column in modules table
 * @param string $client (ie : site or administrator
 */
function shSaveDeleteModuleParams( $moduleName, $client) {

  $db = & JFactory::getDBO();

  // read plugin param from db
  $sql = 'SELECT * FROM `#__modules` WHERE `module`= ' . $db->Quote($moduleName) . ' and client_id=' . $db->Quote( $client);
  $db->setQuery( $sql);
  $result = $db->loadAssocList();

  if (!empty( $result)) {
    // remove module db id
    unset($result[0]['id']);

    // write everything on disk
    shWriteExtensionConfig( $moduleName, array('shConfig' => $result[0]));

    // now remove plugin details from db
    $db->setQuery( "DELETE FROM `#__modules` WHERE `module`= " . $db->Quote( $moduleName) . ' and client_id=' . $db->Quote( $client));
    $db->query();
  }

  // delete the module files
  $path = JPATH_ROOT.DS . ($client ? 'administrator' . DS : '') . 'modules'. DS . $moduleName;
  if (JFolder::exists( $path)) {
    JFolder::delete( $path);
  }

}

/**
 * Save parameters, then delete a plugin
 *
 * @param string $pluginName, the plugin name, mathcing 'element' column in plugins table
 * @param string $folder, the plugin folder (ie : 'content', 'search', 'system',...
 */
function shSaveDeletePluginParams( $pluginName, $folder, $folders = null) {

  $db = & JFactory::getDBO();

  // read plugin param from db
  $sql = 'SELECT * FROM `#__plugins` WHERE `element`= \''.$pluginName.'\' and `folder`= \''.$folder.'\'';
  $db->setQuery($sql);
  $result = $db->loadAssocList();

  if (!empty( $result)) {
    // remove plugin db id
    unset($result[0]['id']);

    // write everything on disk
    shWriteExtensionConfig( $pluginName, array('shConfig' => $result[0]));

    // now remove plugin details from db
    $db->setQuery( "DELETE FROM `#__plugins` WHERE `element`= '" . $pluginName . "' and `folder`= '".$folder."';");
    $db->query();
  }

  // delete the plugin files
  $basePath = JPATH_ROOT.DS.'plugins'. DS . $folder . DS;
  if ($folder != '' && JFile::exists($basePath . $pluginName.'.php')) {
    JFile::delete( array( $basePath . $pluginName.'.php', $basePath . $pluginName.'.xml'));
  }

  // delete plugin additional folders
  if (!empty( $folders)) {
    foreach ($folders as $aFolder) {
      if (JFolder::exists( $basePath . $aFolder)) {
        JFolder::delete( $basePath . $aFolder);
      }
    }
  }
}

/**
 * Save params, then delete plugin, for all plugins
 * in a given group
 *
 * @param $group the group to be deleted
 * @return none
 */
function shSaveDeletePluginGroup( $group) {

  $unsafe = array( 'authentication', 'content', 'editors', 'editors-xtd', 'search', 'system', 'xmlrpc');
  if (in_array( $group, $unsafe)) {
    // safety net : we don't want to delete the whole system or content folder
    return false;
  }

  // read list of plugins from db
  $db = & JFactory::getDBO();

  // read plugin param from db
  $sql = 'SELECT * FROM `#__plugins` WHERE `folder`= \''.$group.'\'';
  $db->setQuery($sql);
  $pluginList = $db->loadAssocList();

  if (empty( $pluginList)) {
    return true;
  }

  // for each plugin
  foreach( $pluginList as $plugin) {
    // remove plugin db id
    unset($plugin['id']);

    // write everything on disk
    shWriteExtensionConfig( $plugin['folder'] . '.' . $plugin['element'], array('shConfig' => $plugin));

    // now remove plugin details from db
    $db->setQuery( "DELETE FROM `#__plugins` WHERE `element`= '" . $plugin['element'] . "' and `folder`= '".$plugin['folder']."';");
    $db->query();

  }

  // now delete the files for the whole group
  if (JFolder::exists( JPATH_ROOT.DS.'plugins'. DS . $group)) {
    JFolder::delete( JPATH_ROOT.DS.'plugins'. DS . $group);
  }

}

