<?php
/**
 * seoLinks
 *
 * @version 1.0.3
 * @package seoLinks
 * @author ZyX (allforjoomla.com)
 * @copyright (C) 2010 by ZyX (http://www.allforjoomla.com)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project,
 * please make a reference to allforjoomla.com someplace in your code
 * and provide a link to http://www.allforjoomla.com
 **/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class  plgSystemSeolinks extends JPlugin{

	function plgSystemSeolinks(& $subject, $params){
		parent::__construct($subject, $params);
	}
	
	function onAfterDispatch(){
		$mainframe = & JFactory::getApplication('site');
		if($mainframe->isAdmin()) return;	
		$document	=& JFactory::getDocument();
		if($document->getType()!='html') return;
		$task = JRequest::getCmd('task','');
		if($task=='edit') return;
		$body = trim($document->getBuffer('component'));
		if($body=='') return;
		$linx = $this->params->get('linx', '');
		$skipPages = trim($this->params->get('skipPages', ''));
		$linxCSS = $this->params->get('linx_class', '');
		$numRepl = (int)$this->params->get('numRepl', 1);
		if($numRepl<1) $numRepl = 1;
		$links = array();
		$tmp = explode("\n",$linx);
		if(!is_array($tmp)) return;
		$uri = &JURI::getInstance();
		$host = str_replace('http://www.','http://',$uri->toString(array('scheme', 'user', 'pass', 'host', 'port', 'path', 'query')));
		$hostW = str_replace('http://','http://www.',$host);
		$hostX = $uri->toString(array('path','query'));
		if($skipPages!=''){
			$skipPagesArray = explode("\n",$skipPages);
			foreach($skipPagesArray as $skipPage){
				$skipPage = trim($skipPage);
				if($skipPage=='') continue;
				if(substr($skipPage,0,1)=='~'){if(preg_match($skipPage,$hostX)){return;}}
				else if($skipPage==$hostX) return;
			}
		}
		$wordFormWildCards = array(
			'\\\.'	=>	'#-#',
			'\\\*'	=>	'#--#',
			'.'	=>	'[a-zа-яіїєґ]?',
			'*'	=>	'[a-zа-яіїєґ]*'
		);
		foreach($tmp as $tmp2){
			$tmp2 = trim($tmp2);
			if($tmp2==''||!preg_match('~=~',$tmp2)) continue;
			$link = explode('=',$tmp2,2);
			$words = trim($link[0]);
			$href = trim($link[1]);
			if($href==''||$words=='') continue;
			if($href==$host||$href==$hostW||$href==$hostX) continue;
			$words = str_replace(', ',',',$words);
			$words = str_replace(' ,',',',$words);
			$words = str_replace(',','|',$words);
			$links[] = array(
				'words' => str_replace(array_keys($wordFormWildCards),array_values($wordFormWildCards),addslashes($words)),
				'href' => $href
			);
		}
		if(count($links)==0) return;
		$clearRegs = array(
			'#-#'	=>	'\\.',
			'#--#'	=>	'\\*'
		);
		$body = preg_replace("/(<\!\-\-seoLinks skip\-\->)(.*?)(?=<\!\-\-\/seoLinks skip\-\->)(<\!\-\-\/seoLinks skip\-\->)/sie","'<:ZyX>'.plgSystemSeolinks::maskContent('\\2').'<:ZyX/>'",$body);
		$body = preg_replace("/(<style)(.*?)(?=<\/style>)(<\/style>)/sie","'<:ZyX>'.plgSystemSeolinks::maskContent('\\1\\2\\3').'<:ZyX/>'",$body);
		$body = preg_replace("/(<script)(.*?)(?=<\/script>)(<\/script>)/sie","'<:ZyX>'.plgSystemSeolinks::maskContent('\\1\\2\\3').'<:ZyX/>'",$body);
		$body = preg_replace("/(<h[1-6])(.*?)(?=<\/h[1-6]>)(<\/h[1-6]>)/sie","'<:ZyX>'.plgSystemSeolinks::maskContent('\\1\\2\\3').'<:ZyX/>'",$body);
		$body = preg_replace("/(<a)(.*?)(?=<\/a>)(<\/a>)/sie","'<:ZyX>'.plgSystemSeolinks::maskContent('\\1\\2\\3').'<:ZyX/>'",$body);
		$body = preg_replace("/(<[a-z])(.*?)(?=>)(>)/sie","'<:ZyX>'.plgSystemSeolinks::maskContent('\\1\\2\\3').'<:ZyX/>'",$body);
		foreach($links as $link){
			preg_match('/\{([0-9]+)\}/i',$link['href'],$mchs);
			$linkNum = (int)@$mchs[1];
			$link['href'] = preg_replace('/\{([0-9]+)\}/i','',$link['href']);
			$link['href'] = trim($link['href']);
			$replace = '<a'.($linxCSS!=''?' class="'.$linxCSS.'"':'').' href="'.$link['href'].'">\\2</a>';
			if($linxCSS!='') $replace = '<span class="'.$linxCSS.'">'.$replace.'</span>';
			$replace = '\\1'.$replace.'\\3';
			$link['words'] = str_replace(array_keys($clearRegs),array_values($clearRegs),$link['words']);
			$search = "/([\s\.\,\;\!\?\:\>\(\)\'\"\*\/])(".$link['words'].")([\*\/\'\"\(\)\<\s\.\,\;\!\?\:])/siu";
			$body = preg_replace("/(<a)(.*?)(?=<\/a>)(<\/a>)/sie","'<:ZyX>'.plgSystemSeolinks::maskContent('\\1\\2\\3').'<:ZyX/>'",$body);
			$body = preg_replace($search, $replace, $body,($linkNum>0?$linkNum:$numRepl));
			if($body=='') return;
		}
		$body = preg_replace("/<\:ZyX>(.*?)(?=<\:ZyX\/>)<\:ZyX\/>/sie",'plgSystemSeolinks::unmaskContent("\\1")',$body);
		$body = preg_replace("/<\:ZyX>(.*?)(?=<\:ZyX\/>)<\:ZyX\/>/sie",'plgSystemSeolinks::unmaskContent("\\1")',$body);
		//if(!plgSystemSeolinks::checkDomain($this->params->get('domainKey', ''))) $body.= base64_decode('PGRpdiBzdHlsZT0iYm9yZGVyLXRvcDoxcHggc29saWQgI2NjYzt0ZXh0LWFsaWduOnJpZ2h0OyI+PGEgdGFyZ2V0PSJfYmxhbmsiIHRpdGxlPSJzZW9MaW5rcyIgaHJlZj0iaHR0cDovL3d3dy5hbGxmb3Jqb29tbGEucnUiIHN0eWxlPSJ2aXNpYmlsaXR5OnZpc2libGU7ZGlzcGxheTppbmxpbmU7Y29sb3I6I2NjYzsiPnNlb0xpbmtzPC9hPjwvZGl2Pg==');
		if($body=='') return;
		$document->setBuffer( $body, 'component');
	}
		
	function checkDomain($key){
		$URI=&JURI::getInstance();$m=str_replace('www.','',$URI->getHost()).':ZyX_SL';$e=5;$n='159378341817953177';$s=5;$coded='';$max=strlen($m);$packets=ceil($max/$s);for($i=0;$i<$packets;$i++){$packet=substr($m, $i*$s, $s);$code='0';for($j=0; $j<$s; $j++){$code=@bcadd($code, bcmul(ord($packet[$j]), bcpow('256',$j)));}$code=bcpowmod($code, $e, $n);$coded.=$code.' ';}$coded=str_replace(' ','-',trim($coded));return ($key==$coded);
	}

	function maskContent($txt){
		$result = base64_encode($txt);
		return $result;
	}
	
	function unmaskContent($txt){
		$result = stripslashes(base64_decode($txt));
		return $result;
	}
}
if(!function_exists('bcpowmod')){
	function bcpowmod($m,$e,$n) {
		$r="";
		while ($e!="0") {
			$t=bcmod($e,"4096");
			$r=substr("000000000000".decbin(intval($t)),-12).$r;
			$e=bcdiv($e,"4096");
		}
		$r=preg_replace("!^0+!","",$r);
		if ($r=="") $r="0";
		$m=bcmod($m,$n);
		$erb=strrev($r);
		$q="1";
		$a[0]=$m;
		for ($i=1;$i<strlen($erb);$i++) {
			$a[$i]=bcmod(bcmul($a[$i-1],$a[$i-1]),$n);
		}
		for ($i=0;$i<strlen($erb);$i++) {
			if ($erb[$i]=="1") {
				$q=bcmod(bcmul($q,$a[$i]),$n);
			}
		}
		return($q);
	}
}