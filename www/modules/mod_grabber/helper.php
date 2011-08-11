<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class ModGrabberHelper
{
	
	function grabhtml($url, $start, $end, $show, $regexp, $mestype)
	{
	global $mainframe;
		set_time_limit(0); // чтоб успело дограбить всё
		ignore_user_abort(); // грабить не смотря на ошибки клиента
	if (!function_exists("curl_init")) {
		@$file = file_get_contents( $url );
		}else{
		$agent = 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)';
		$referer = $url;
		$ch = curl_init(); 
        curl_setopt ($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_REFERER, $referer);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
        $file = curl_exec ($ch);
	    curl_close($ch);
		}
		if( $file )
		{
			if( preg_match_all($regexp, $file, $match) )
			{				
				foreach( $match[0] as $html )
		{
		if( !$show )
		{
			$html = str_replace( $start, "", $html );
			$html = str_replace( $end, "", $html );			
			return $html;
		}else{
			return $html;
			 }
      	}
			}else{
			    switch ($mestype) {
    case 1:
        return JText::_('NOTAGS');
        break;
    case 2:
		$mailfrom = $mainframe->getCfg( 'mailfrom' );
        $fromname = $mainframe->getCfg( 'fromname' );
		$title = JText::_('NOTAGS MES');
		$message = $url.': '.JText::_('NOTAGS MES');
		return JUtility::sendMail($mailfrom, $fromname, $mailfrom, $title, $message);
        break;
    case 3:
        $mailfrom = $mainframe->getCfg( 'mailfrom' );
        $fromname = $mainframe->getCfg( 'fromname' );
		$title = JText::_('NOTAGS MES');
		$message = $url.': '.JText::_('NOTAGS MES');
		JUtility::sendMail($mailfrom, $fromname, $mailfrom, $title, $message);
		return JText::_('NOTAGS');
        break;
}
				 }
		}else{
			    switch ($mestype) {
    case 1:
        return JText::_('NOSITE');
        break;
    case 2:
		$mailfrom = $mainframe->getCfg( 'mailfrom' );
        $fromname = $mainframe->getCfg( 'fromname' );
		$title = JText::_('NOSITE MES');
		$message = $url.': '.JText::_('NOSITE MES');
		return JUtility::sendMail($mailfrom, $fromname, $mailfrom, $title, $message);
        break;
    case 3:
        $mailfrom = $mainframe->getCfg( 'mailfrom' );
        $fromname = $mainframe->getCfg( 'fromname' );
		$title = JText::_('NOSITE MES');
		$message = $url.': '.JText::_('NOSITE MES');
		JUtility::sendMail($mailfrom, $fromname, $mailfrom, $title, $message);
		return JText::_('NOSITE');
        break;
}
			 }
	}
	
	function correct_charset($fromcharset, $tocharset, $html)
	{
		//(($html==JText::_('NOTAGS')) || ($html==JText::_('NOSITE'))) ? return $html : return iconv ($fromcharset, $tocharset, $html);
		if(($html==JText::_('NOTAGS')) || ($html==JText::_('NOSITE')))
{
return $html;
}else{
return iconv ($fromcharset, $tocharset, $html);
}
	}
	
	function correct_links($linksrc, $oldlinksrc, $linkhref, $oldlinkhref, $html, $atr)
	{
		$oldlink = array($oldlinksrc, $oldlinkhref);
		$newlink = array($oldlinksrc.$linksrc, $atr.' '.$oldlinkhref.$linkhref);
			return str_replace($oldlink, $newlink, $html);
	}
	
	function create_cache_file($tmpfname, $html)
	{
		if (file_exists($tmpfname)) 
		{
		unlink($tmpfname);
		$handle = fopen($tmpfname, "a+");
		fwrite($handle, $html);
		fclose($handle);
			}else{
		$handle = fopen($tmpfname, "a+");
		fwrite($handle, $html);
		fclose($handle);
			}
	}
	
		function tmpl_parser($regex, $html_from_template_path)
	{
		preg_match("#{".$regex."}(.*?){/".$regex."}#s", $html_from_template_path, $matches); 
		return $matches[1];
	}
} 
?>