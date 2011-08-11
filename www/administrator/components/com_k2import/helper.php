<?php
/**
 * @version		$Id: helper.php 24 2009-04-11 21:47:28Z ptrnrs $
 * @package		Jix: The Import, Export & Update Utility for Joomla
 * @copyright	Copyright (C) 2008 - 2009 SunSpot Computing Pty Ltd All rights reserved.
 * @license		GNU General Public License <http://www.gnu.org/copyleft/gpl.html>
 * @link		http://www.jix.com.au
 */

class k2importToolbarHelper extends JToolbarHelper
{
	function upload()
	{
		$bar = & JToolBar::getInstance('toolbar');

    //Add the upload component:
		$bar->appendButton('Upload');
	}
}
