<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
require_once(dirname(__FILE__).DS.'helper.php');
$template	  = $params->get('template');
if ($template)
{
$template_name = $params->get('template_name');
$name         = strtolower(array_shift(explode(".", $template_name)));
$template_path     = JPATH_SITE."/modules/mod_grabber/templates/$template_name"; 
$html_from_template_path     = file_get_contents($template_path);

$url 			= ModGrabberHelper::tmpl_parser('url', $html_from_template_path);
$start 			= ModGrabberHelper::tmpl_parser('start_tag', $html_from_template_path);
$end 			= ModGrabberHelper::tmpl_parser('end_tag', $html_from_template_path);
$show 			= ModGrabberHelper::tmpl_parser('show_tags', $html_from_template_path);
$starttext 		= ModGrabberHelper::tmpl_parser('starttext', $html_from_template_path);
$endtext 		= ModGrabberHelper::tmpl_parser('endtext', $html_from_template_path);
$usecache 		= ModGrabberHelper::tmpl_parser('usecache', $html_from_template_path);
$fromcharset 	= ModGrabberHelper::tmpl_parser('fromcharset', $html_from_template_path);
$tocharset 		= ModGrabberHelper::tmpl_parser('tocharset', $html_from_template_path);
$linkhref 		= ModGrabberHelper::tmpl_parser('linkhref', $html_from_template_path);
$linksrc 		= ModGrabberHelper::tmpl_parser('linksrc', $html_from_template_path);
$oldlinksrc 	= ModGrabberHelper::tmpl_parser('oldlinksrc', $html_from_template_path);
$oldlinkhref 	= ModGrabberHelper::tmpl_parser('oldlinkhref', $html_from_template_path);
$howlong 		= ModGrabberHelper::tmpl_parser('howlong', $html_from_template_path);
$regexp 		= ModGrabberHelper::tmpl_parser('regexp', $html_from_template_path);
$regexp 		= str_replace('$start', $start, $regexp);
$regexp 		= str_replace('$end', $end, $regexp);
$mestype 	    = ModGrabberHelper::tmpl_parser('mestype', $html_from_template_path);

if($usecache){
@$tmpfname     = JPATH_SITE."/modules/mod_grabber/content/$name/$name.html";
if ((!file_exists($tmpfname))) {
mkdir(JPATH_SITE."/modules/mod_grabber/content/$name", 0755);
$handle = fopen($tmpfname, "a+");
fclose($handle);	
}
$fsize        = filesize($tmpfname);
$html_from_file     = file_get_contents($tmpfname);
}

}else{
$url          = $params->get('url');
$start        = $params->get('start_tag');
$end          = $params->get('end_tag');
$show         = $params->get('show_tags');
$starttext    = $params->get('starttext');
$endtext      = $params->get('endtext');
$usecache     = $params->get('usecache');
$fromcharset  = $params->get('fromcharset');
$tocharset    = $params->get('tocharset');
$atr    	  = $params->get('atr');
$linkhref     = $params->get('linkhref');
$linksrc      = $params->get('linksrc');
$oldlinksrc   = JText::_($params->get('oldlinksrc'));
$oldlinkhref  = JText::_($params->get('oldlinkhref'));
$howlong      = $params->get('howlong');
$regexp 	  = $params->get('regexp','#$start(.*?)$end#s');
$regexp 	  = str_replace('$start', $start, $regexp);
$regexp 	  = str_replace('$end', $end, $regexp);
$mestype 	  = $params->get('mestype');

if($usecache){
$tmpfname     = JPATH_SITE."/modules/mod_grabber/content/mod_grabber.html"; 
$fsize        = filesize($tmpfname);
$html_from_file     = file_get_contents($tmpfname);
}
	}

if($usecache){
// высчитываем время сброса кэша
$filetimech = filemtime($tmpfname);
$howlong = $howlong*3600;
$now = time ();
$reload = $filetimech+$howlong;
$go = $reload < $now;
}

// если время кэширования истекло или кэш не используется или кэш-файл пустой - грабим с сайта-донора
if (($go) || (!$usecache)) {
$html = ModGrabberHelper::grabhtml($url, $start, $end, $show, $regexp, $mestype);
	// если есть параметры для перекодирования - меняем кодировку
	if (($fromcharset<>'') AND ($tocharset<>'')) $html = ModGrabberHelper::correct_charset($fromcharset, $tocharset, $html);
		// если нужно исправлять ссылки - исправляем
		if (($linksrc<>'') || ($linkhref<>'')) $html = ModGrabberHelper::correct_links($linksrc, $oldlinksrc, $linkhref, $oldlinkhref, $html, $atr);
} 

// если включен кэш, а кэш-файл пустой или включен кэш, но время его хранения кончилось - грабим с сайта-донора
if ((($usecache) AND ($fsize==0)) || (($usecache) AND ($go))) { 
$html = ModGrabberHelper::grabhtml($url, $start, $end, $show, $regexp, $mestype);
	// если есть параметры для перекодирования - меняем кодировку
	if (($fromcharset<>'') AND ($tocharset<>'') AND $html) $html = ModGrabberHelper::correct_charset($fromcharset, $tocharset, $html);
		// если нужно исправлять ссылки - исправляем
		if (($linksrc<>'') || ($linkhref<>'')) $html = ModGrabberHelper::correct_links($linksrc, $oldlinksrc, $linkhref, $oldlinkhref, $html, $atr);
ModGrabberHelper::create_cache_file($tmpfname, $html);
}
if (($usecache) AND (!$go) AND ($fsize>0)) $html = $html_from_file;

require(JModuleHelper::getLayoutPath('mod_grabber'));
?>