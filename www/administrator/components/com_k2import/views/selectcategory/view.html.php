<?php
/**
 * Hellos View for Hello World Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );



class K2importViewSelectcategory extends JView
{
	/**
	 * Hellos view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'K2 Import Tool' ) . ' - ' . JText::_( 'select a category' ), 'generic.png' );
	

       // $data =& $this->get( 'Data');
 		$model =& $this->getModel();
		

		$file= JRequest::getVar( 'file', '', 'get', string );
		$file=JFile::makeSafe($file);
		
		
		$k2categories = $model->getK2categories();	
		$this->assignRef( 'k2categories', $k2categories );
		$this->assignRef( 'file', $file );		
		$document = & JFactory::getDocument();
		$document->addStyleSheet('components/com_k2import/css/k2import.css');


		parent::display($tpl);
	}
}