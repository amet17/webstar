<?php
/**
 * Code Syntax Highlighting Parameter Element/Field
 * @author gabe@fijiwedesign.com
 * @link http://www.fijiwebdesign.com/
 * @copyright (c) 2010 Fiji Web Design
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access');

class JElementCode extends JElement
{

  var $_name = 'Code';

  function fetchElement($name, $value, & $node, $control_name)
  {
  
    global $mainframe;
  
    $fieldName = $control_name.'['.$name.']';
  
    $html = '
      <textarea name="' . $fieldName . '" style="width:99%;height:300px;">' . htmlentities($value, ENT_QUOTES, 'UTF-8') . '</textarea>
      
    ';
    
  
    return $html;
  }

}