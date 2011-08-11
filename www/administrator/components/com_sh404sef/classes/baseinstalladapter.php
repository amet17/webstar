<?php
/**
 * @version   $Id:plugin.php 6961 2007-03-15 16:06:53Z tcp $
 * @package   Joomla.Framework
 * @subpackage  Installer
 * @copyright Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license   GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

/**
 * Adapted for SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: baseinstalladapter.php 1971 2011-05-30 09:20:25Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');


/**
 * Extension adapter for Joomla! installer
 *
 * @author shumisha
 *
 */
class Sh404sefClassBaseinstalladapter extends JObject{

  protected $_basePath = '';

  protected $_group = 'sh404sefextplugins';
  protected $_installType = 'plugin';

  public function __construct( &$parent) {

    $this->parent = & $parent;
    $this->_basePath = JPATH_ROOT . DS . 'plugins';
  }

  /**
   * Custom install method
   *
   * @access  public
   * @return  boolean True on success
   * @since 1.5
   */
  public function install() {

    // set our target path
    $this->parent->setPath( 'extension_root', $this->_getPath());

    // Get a database connector object
    $db =& $this->parent->getDBO();

    // Get the extension manifest object
    $manifest =& $this->parent->getManifest();
    $this->manifest =& $manifest->document;
    $this->_fixManifest();

    /**
     * ---------------------------------------------------------------------------------------------
     * Manifest Document Setup Section
     * ---------------------------------------------------------------------------------------------
     */

    // Set the extensions name
    $name =& $this->manifest->getElementByPath('name');
    $name = JFilterInput::clean($name->data(), 'string');
    $this->set('name', $name);

    // Get the component description
    $description = & $this->manifest->getElementByPath('description');
    if (is_a($description, 'JSimpleXMLElement')) {
      $this->parent->set('message', $description->data());
    } else {
      $this->parent->set('message', '' );
    }

    /*
     * Backward Compatability
     * @todo Deprecate in future version
     */
    $type = $this->manifest->attributes('type');
    $pname = $this->_getElement();
    if ($type == $this->_installType && !empty( $pname)) {
      $this->parent->setPath('extension_root', JPATH_ROOT.DS.'plugins'.DS.$this->_group);
    } else {
      $this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('Invalid plugin type') . ' : ' . htmlspecialchars( $type, ENT_COMPAT, 'UTF-8'));
      return false;
    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Filesystem Processing Section
     * ---------------------------------------------------------------------------------------------
     */

    // If the plugin directory does not exist, lets create it
    $created = false;
    if (!file_exists($this->parent->getPath('extension_root'))) {
      if (!$created = JFolder::create($this->parent->getPath('extension_root'))) {
        $this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('Failed to create directory').': "'.$this->parent->getPath('extension_root').'"');
        return false;
      }
    }

    /*
     * If we created the plugin directory and will want to remove it if we
     * have to roll back the installation, lets add it to the installation
     * step stack
     */
    if ($created) {
      $this->parent->pushStep(array ('type' => 'folder', 'path' => $this->parent->getPath('extension_root')));
    }

    // Copy all necessary files
    $element =& $this->manifest->getElementByPath('files');
    if ($this->parent->parseFiles( $element, -1) === false) {
      // Install failed, roll back changes
      $this->parent->abort();
      return false;
    }

    // Parse optional tags -- media and language files for plugins go in admin app
    $this->parent->parseMedia($this->manifest->getElementByPath('media'), 1);
    $this->parent->parseLanguages($this->manifest->getElementByPath('languages'), 1);

    /**
     * ---------------------------------------------------------------------------------------------
     * Database Processing Section
     * ---------------------------------------------------------------------------------------------
     */

    // Check to see if a plugin by the same name is already installed
    $query = 'SELECT `id`' .
        ' FROM `#__plugins`' .
        ' WHERE folder = '.$db->Quote( $this->_group) .
        ' AND element = '.$db->Quote( $pname);
    $db->setQuery( $query);
    if (!$db->Query()) {
      // Install failed, roll back changes
      $this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.$db->stderr(true));
      return false;
    }
    $id = $db->loadResult();

    // Was there a module already installed with the same name?
    if ($id) {

      if (!$this->parent->getOverwrite())
      {
        // Install failed, roll back changes
        $this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('Plugin').' "'.$pname.'" '.JText::_('already exists!'));
        return false;
      }

    } else {
      $row =& JTable::getInstance('plugin');
      $row->name = $this->get('name');
      $row->ordering = 0;
      $row->folder = $this->_group;
      $row->iscore = 0;
      $row->access = 0;
      $row->client_id = 0;
      $row->element = $pname;
      $row->params = $this->parent->getParams();
      $row->published = 1;

      if (!$row->store()) {
        // Install failed, roll back changes
        $this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.$db->stderr(true));
        return false;
      }

      // Since we have created a plugin item, we add it to the installation step stack
      // so that if we have to rollback the changes we can undo it.
      $this->parent->pushStep(array ('type' => 'plugin', 'id' => $row->id));
    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Finalization and Cleanup Section
     * ---------------------------------------------------------------------------------------------
     */

    // Lastly, we will copy the manifest file to its appropriate place.
    if (!$this->parent->copyManifest(-1)) {
      // Install failed, rollback changes
      $this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('Could not copy setup file'));
      return false;
    }

    // Load plugin language file
    $lang =& JFactory::getLanguage();
    $lang->load('plg_'.$this->_group.'_'.$pname);

    return true;
  }



  /**
   * Custom uninstall method
   *
   * @access  public
   * @param int   $cid  The id of the plugin to uninstall
   * @param int   $clientId The id of the client (unused)
   * @return  boolean True on success
   * @since 1.5
   */
  public function uninstall($id, $clientId ) {

    // Initialize variables
    $row  = null;
    $retval = true;
    $db   =& $this->parent->getDBO();

    // First order of business will be to load the module object table from the database.
    // This should give us the necessary information to proceed.
    $row = & JTable::getInstance('plugin');
    if ( !$row->load((int) $id) ) {
      JError::raiseWarning(100, JText::_('ERRORUNKOWNEXTENSION'));
      return false;
    }

    // Is the plugin we are trying to uninstall a core one?
    // Because that is not a good idea...
    if ($row->iscore) {
      JError::raiseWarning(100, JText::_('Plugin').' '.JText::_('Uninstall').': '.JText::sprintf('WARNCOREPLUGIN', $row->name)."<br />".JText::_('WARNCOREPLUGIN2'));
      return false;
    }

    // Get the plugin folder so we can properly build the plugin path
    if (trim($row->folder) == '') {
      JError::raiseWarning(100, JText::_('Plugin').' '.JText::_('Uninstall').': '.JText::_('Folder field empty, cannot remove files'));
      return false;
    }

    // Set the plugin root path
    $this->parent->setPath('extension_root', JPATH_ROOT.DS.'plugins'.DS.$row->folder);

    // Because plugins don't have their own folders we cannot use the standard method of finding an installation manifest
    $manifestFile = JPATH_ROOT.DS.'plugins'.DS.$row->folder.DS.$row->element.'.xml';
    if (file_exists($manifestFile))
    {
      $xml =& JFactory::getXMLParser('Simple');

      // If we cannot load the xml file return null
      if (!$xml->loadFile($manifestFile)) {
        JError::raiseWarning(100, JText::_('Plugin').' '.JText::_('Uninstall').': '.JText::_('Could not load manifest file'));
        return false;
      }

      /*
       * Check for a valid XML root tag.
       * @todo: Remove backwards compatability in a future version
       * Should be 'install', but for backward compatability we will accept 'mosinstall'.
       */
      $root =& $xml->document;
      if ($root->name() != 'install' && $root->name() != 'mosinstall') {
        JError::raiseWarning(100, JText::_('Plugin').' '.JText::_('Uninstall').': '.JText::_('Invalid manifest file'));
        return false;
      }

      // Remove the plugin files
      $this->parent->removeFiles($root->getElementByPath('images'), -1);
      $this->parent->removeFiles($root->getElementByPath('files'), -1);
      JFile::delete($manifestFile);

      // Remove all media and languages as well
      $this->parent->removeFiles($root->getElementByPath('media'));
      $this->parent->removeFiles($root->getElementByPath('languages'), 1);
    } else {
      JError::raiseWarning(100, 'Plugin Uninstall: Manifest File invalid or not found');
      return false;
    }

    // Now we will no longer need the plugin object, so lets delete it
    $row->delete($row->id);
    unset ($row);

    // If the folder is empty, let's delete it
    $files = JFolder::files($this->parent->getPath('extension_root'));
    if (!count($files)) {
      JFolder::delete($this->parent->getPath('extension_root'));
    }

    return $retval;
    
  }

  /**
   * Get unique element id for the plugin
   *
   */
  protected function _getElement() {

    static $_element = null;

    if( is_null( $_element)) {
      // get name, should work for Joomsef, not sure for Aces, as
      // I have seen some plugin with wrong filename attribute
      // should use the "extension" field with acesef
      $element =& $this->manifest->getElementByPath('files');
      if (is_a($element, 'JSimpleXMLElement') && count($element->children())) {
        $files = $element->children();
        foreach ($files as $file) {
          if ($file->attributes($this->_installType)) {
            $_element = $file->attributes( $this->_installType);
            break;
          }
        }
      }
    }
    return $_element;

  }

  /**
   * Get sub dir of given plugin, usually based on name
   * of extension. Obtaining that name will vary based
   * on the type of plugin
   */
  protected function _getPath() {

    return $this->_basePath . DS . $this->_group;

  }

  protected function _fixManifest() {
    
  }
}