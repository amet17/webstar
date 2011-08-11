<?php
/**
 * Best Alias -  plugin is designed for instant transfer of title to the alias.
 *
 * @version 1.0
 * @author Sergey Dima Kuprijanov (ageent.ua@gmail.com)
 * @copyright (C) 2010 by Dima Kuprijanov (http://www.ageent.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');

if (defined('JPATH_ROOT') && defined('JPATH_LIBRARIES')) {
    global $mainframe;
    $mainframe->registerEvent('onAfterRoute', 'plgSystemAgeent');
} 


function plgSystemAgeent()
{
        $mainframe = & JFactory::getApplication('site');
        $document = & JFactory::getDocument();
        $plugin =& JPluginHelper::getPlugin('system', 'ag.translate');
        $params = new JParameter( $plugin->params );
        
        if ($mainframe->isAdmin()) {
            $document->addScript('http://www.google.com/jsapi');
            $document->addScript(JURI::root() . 'plugins/system/jquery/jquery.js');
            $on = $params->get("on_or_off");
            if(!empty($on)) {
                $document->addScript(JURI::root() . 'plugins/system/jquery/ajax_translate.js');    
            } else {
                $document->addScript(JURI::root() . 'plugins/system/jquery/standart.js');
            }
        }
} 
?>