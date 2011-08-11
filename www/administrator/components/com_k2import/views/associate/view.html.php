<?php
 
 /**
 * K2import View
 * 
 * @package    K2import
 * @link http://www.individual-it.net
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );



class K2importViewAssociate extends JView
{

	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'K2 Import Tool' ), 'generic.png' );
	

       // $data =& $this->get( 'Data');
 		$model =& $this->getModel();
		

		$file        = JRequest::getVar( 'file', '', 'post', string );
		$file=JFile::makeSafe($file);
		$k2category        = JRequest::getVar( 'k2category', '', 'post', string );
		$in_charset        = substr(JRequest::getVar( 'in_charset', '', 'post' ),0,20);				
		$out_charset        = substr(JRequest::getVar( 'out_charset', '', 'post' ),0,20);		
		
		$data = $model->getHeader($file);
		$k2fields = $model->getK2fields($k2category);	
		$this->assignRef( 'csv_headers', $data );
		$this->assignRef( 'k2fields', $k2fields );
		$this->assignRef( 'file', $file );		
		$this->assignRef( 'k2category', $k2category );
		$this->assignRef( 'in_charset', $in_charset );
		$this->assignRef( 'out_charset', $out_charset );
		
		
		$document = & JFactory::getDocument();
		$document->addStyleSheet('components/com_k2import/css/k2import.css');


		parent::display($tpl);
	}
}