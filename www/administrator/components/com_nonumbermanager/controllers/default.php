<?php
/**
 * NoNumber! Controller
 *
 * @package     NoNumber! Extension Manager
 * @version     2.4.7
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die();

// Import CONTROLLER object class
jimport( 'joomla.application.component.controller' );

/**
 * NoNumber! Licenses Controller
 */
class NoNumberManagerController extends JController
{
	/**
	 * admin_url - url of the main component administrator
	 *
	 * @var string
	 */
	var $_admin_url = null;

	/**
	 * Custom Constructor
	 */
	function __construct( $default = array() )
	{
		parent::__construct( $default );

		// initialize class property
		$this->_admin_url = 'index.php?option=com_nonumbermanager';
	}

	/**
	 * Display Method
	 * Call the method and display the requested view
	 */
	function display()
	{
		$document =& JFactory::getDocument();

		$view =& $this->getView( 'default', $document->getType() );

		// Get/Create the model
		$model =& $this->getModel( 'model' );
		if ( $model ) {
			// Push the model into the view ( as default )
			$view->setModel( $model, true );
		}

		$view->setLayout( 'default' );
		$view->display();
	}

	/**
	 * Save Method
	 */
	function save()
	{
		$model =& $this->getModel( 'model' );
		$model->save();
	}

	/**
	 * Install Method
	 */
	function install()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$_REQUEST['tmpl'] = 'component';

		$model =& $this->getModel( 'model' );
		$model->install();
	}
}