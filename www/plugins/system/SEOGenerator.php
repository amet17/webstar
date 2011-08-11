<?php
######################################################################
# SEO-Generator    	          	                                     #
# Copyright (C) 2011 by MCTrading - All rights reserved. 	   	   	   #
# Homepage   : http://www.suchmaschinen-optimierung-seo.org  		   	 #
# Author     : MCTrading          		   	   	   	   	   	   	   	   #
# Version    : 4.0                        	   	    	   	    	   	 #
# License    : GNU/GPL                                               #
# Line 18 to 267 are partially under the following copyright:        #
# 	@author Ryan McLaughlin - Copyright (C) 2008-2009 Dao By Design  #
# 	(www.daobydesign.com)- GNU/GPL                                   #
# 	see details in code                                              #
######################################################################



/* Line 18 to 140 @author Ryan McLaughlin - Copyright (C) 2008-2009 Dao By Design (www.daobydesign.com)- GNU/GPL*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// error_reporting set to show all errors except those for notices and coding standards warnings
// error_reporting (E_ALL ^ E_NOTICE);
// error_reporting (E_ALL ^ E_DEPRECATED);
error_reporting (0);

// Import library dependencies
jimport('joomla.plugin.plugin');





class plgSystemSEOGenerator extends JPlugin
{
  
	// Language files are loaded 
		public function __construct(& $subject, $config)
        {
 
                parent::__construct($subject, $config);
 
                $this->loadLanguage();
 
        }
	
	// Constructor
    function plgSystemSEOGenerator( &$subject, $params )
    {
		parent::__construct( $subject, $params );
    }

    function onAfterDispatch()
    {
		$app = JFactory::getApplication();
		$thebuffer;
		$document =& JFactory::getDocument();
        $docType = $document->getType();

    	// only mod site pages that are html docs (no admin, install, etc.)
      	if (!$app->isSite()) return ;
    	if ($docType != 'html') return ;

		
		$titOrder = $this->params->def('titorder', 0);
		$fptitle = html_entity_decode($this->params->def('fptitle','Home'));
		$fptitorder = $this->params->def('fptitorder', 0);
		$pageTitle = html_entity_decode($document->getTitle());
		$sitename = html_entity_decode($app->getCfg('sitename'));
		$sep = str_replace('\\','',$this->params->def('separator','|')); //Sets and removes Joomla escape char bug.
		
		if ($this->isFrontPage()):
			if ($fptitorder == 0):
				$newPageTitle = $fptitle . ' ' . $sep . ' ' . $sitename;
			elseif ($fptitorder == 1):
				$newPageTitle = $sitename . ' ' . $sep . ' ' . $fptitle;
			elseif ($fptitorder == 2):
				$newPageTitle = $fptitle;
			elseif ($fptitorder == 3):
				$newPageTitle = $sitename;
			endif;
		else:
			if ($titOrder == 0):
				$newPageTitle = $pageTitle . ' ' . $sep . ' ' . $sitename;
			elseif ($titOrder == 1):
				$newPageTitle = $sitename . ' ' . $sep . ' ' . $pageTitle;
			elseif ($titOrder == 2):
				$newPageTitle = $pageTitle;
			endif;
		endif;

		
		// Set the Title
		$document->setTitle ($newPageTitle);

	}


	function onPrepareContent( &$article, &$params, $limitstart = 0 )

	{
		$app = JFactory::getApplication();

		$document =& JFactory::getDocument();

		$blackList = $this->params->def('blacklist', 'a, able, about, above, abroad, according, accordingly, across, actually, adj, after, afterwards, again, against, ago, ahead, ain\'t, all, allow, allows, almost, alone, along, alongside, already, also, although, always, am, amid, amidst, among, amongst, an, and, another, any, anybody, anyhow, anyone, anything, anyway, anyways, anywhere, apart, appear, appreciate, appropriate, are, aren\'t, around, as, a\'s, aside, ask, asking, associated, at, available, away, awfully, b, back, backward, backwards, be, became, because, become, becomes, becoming, been, before, beforehand, begin, behind, being, believe, below, beside, besides, best, better, between, beyond, both, brief, but, by, c, came, can, cannot, cant, can\'t, caption, cause, causes, certain, certainly, changes, clearly, c\'mon, co, co\., com, come, comes, concerning, consequently, consider, considering, contain, containing, contains, corresponding, could, couldn\'t, course, c\'s, currently, d, dare, daren\'t, definitely, described, despite, did, didn\'t, different, directly, do, does, doesn\'t, doing, done, don\'t, down, downwards, during, e, each, edu, eg, eight, eighty, either, else, elsewhere, end, ending, enough, entirely, especially, et, etc, even, ever, evermore, every, everybody, everyone, everything, everywhere, ex, exactly, example, except, f, fairly, far, farther, few, fewer, fifth, first, five, followed, following, follows, for, forever, former, formerly, forth, forward, found, four, from, further, furthermore, g, get, gets, getting, given, gives, go, goes, going, gone, got, gotten, greetings, h, had, hadn\'t, half, happens, hardly, has, hasn\'t, have, haven\'t, having, he, he\'d, he\'ll, hello, help, , hence, her, here, hereafter, hereby, herein, here\'s, hereupon, hers, herself, he\'s, hi, him, himself, his, hither, hopefully, how, howbeit, however, hundred, i, i\'d, ie, if, ignored, i\'ll, i\'m, immediate, in, inasmuch, inc, inc\., indeed, indicate, indicated, indicates, inner, inside, insofar, instead, into, inward, is, isn\'t, it, it\'d, it\'ll, its, it\'s, itself, i\'ve, j, just, k, keep, keeps, kept, know, known, knows, l, last, lately, later, latter, latterly, least, less, lest, let, let\'s, like, liked, likely, likewise, little, look, looking, looks, low, lower, ltd, m, made, mainly, make, makes, many, may, maybe, mayn\'t, me, mean, meantime, meanwhile, merely, might, mightn\'t, mine, minus, miss, more, moreover, most, mostly, mr, mrs, much, must, mustn\'t, my, myself, n, name, namely, nd, near, nearly, necessary, need, needn\'t, needs, neither, never, neverf, neverless, nevertheless, new, next, nine, ninety, no, nobody, non, none, nonetheless, noone, no-one, nor, normally, not, nothing, notwithstanding, novel, now, nowhere, o, obviously, of, off, often, oh, ok, okay, old, on, once, one, ones, one\'s, only, onto, opposite, or, other, others, otherwise, ought, oughtn\'t, our, ours, ourselves, out, outside, over, overall, own, p, particular, particularly, past, per, perhaps, placed, please, plus, possible, presumably, probably, provided, provides, q, que, quite, qv, r, rather, rd, re, really, reasonably, recent, recently, regarding, regardless, regards, relatively, respectively, right, round, s, said, same, saw, say, saying, says, second, secondly, see, seeing, seem, seemed, seeming, seems, seen, self, selves, sensible, sent, serious, seriously, seven, several, shall, shan\'t, she, she\'d, she\'ll, she\'s, should, shouldn\'t, since, six, so, some, somebody, someday, somehow, someone, something, sometime, sometimes, somewhat, somewhere, soon, sorry, specified, specify, specifying, still, sub, such, sup, sure, t, take, taken, taking, tell, tends, th, than, thank, thanks, thanx, that, that\'ll, thats, that\'s, that\'ve, the, their, theirs, them, themselves, then, thence, there, thereafter, thereby, there\'d, therefore, therein, there\'ll, there\'re, theres, there\'s, thereupon, there\'ve, these, they, they\'d, they\'ll, they\'re, they\'ve, thing, things, think, third, thirty, this, thorough, thoroughly, those, though, three, through, throughout, thru, thus, till, to, together, too, took, toward, towards, tried, tries, truly, try, trying, t\'s, twice, two, u, un, under, underneath, undoing, unfortunately, unless, unlike, unlikely, until, unto, up, upon, upwards, us, use, used, useful, uses, using, usually, v, value, various, versus, very, via, viz, vs, w, want, wants, was, wasn\'t, way, we, we\'d, welcome, well, we\'ll, went, were, we\'re, weren\'t, we\'ve, what, whatever, what\'ll, what\'s, what\'ve, when, whence, whenever, where, whereafter, whereas, whereby, wherein, where\'s, whereupon, wherever, whether, which, whichever, while, whilst, whither, who, who\'d, whoever, whole, who\'ll, whom, whomever, who\'s, whose, why, will, willing, wish, with, within, without, wonder, won\'t, would, wouldn\'t, x, y, yes, yet, you, you\'d, you\'ll, your, you\'re, yours, yourself, yourselves, you\'ve, z, zero');
		$minLength = $this->params->def('lengthofword', '3' );
		$count = $this->params->def('count', '20' );
		$saveAll = $this->params->def('regenerateall',0);
		$usetitle = $this->params->def('usetitleorcontent',0);
		$thelength = $this->params->def('length', 200);
		$fpdesc = $this->params->def('fpdesc', 0);
		$credit = $this->params->def('credittag', 0);
		$robots = $this->params->def('robots', 'index, follow, noarchive, noimageindex' );
		$verificationkey = $this->params->def('verificationkey', '' );
		$statickeywords = $this->params->def('statickeywords', '' );

		// check for Joomla 1.6 - title is not everywhere available e.g. on frontpage - if it is so then use content
		if (isset($article->title)) 
		{
			$title = $article->title;
		} else {
			$title = $article->text;
		}
		
		$thecontent = $article->text;
		
		
		
		//Checks to see whether FP should use standard desc or auto-generated one.
		if ($this->isFrontPage() && $fpdesc == 0) {
			$document->setDescription($app->getCfg('MetaDesc'));
			return;
		}
		
		//Bit of code to grab only the first content item in category list.
		if ($document->getDescription() != '') {
			if ($document->getDescription() != $app->getCfg('MetaDesc')) return;
		}
		
		// Clean things up for auto-generated Meta Description tag
		$thecontent = $this->CleanText($thecontent);

		
		// Truncate the string to the length parameter - rounding to nearest word
		$thecontent = $thecontent . ' ';
		$thecontent = substr($thecontent,0,$thelength);
		$thecontent = substr($thecontent,0,strrpos($thecontent,' '));

		// Set the description
		$document->setDescription($thecontent);


		// Clean things up for auto-generated keywords
		$title = $this->CleanText($title);
		
		
    // check if title or content used for keywords
    if ($usetitle == 0):
     $keys = $title; 
    elseif ($usetitle == 1):
     $keys = $thecontent;
    elseif ($usetitle == 2):
     $keys = $title . ' ' . $thecontent;
    endif; 
    
    
    // Set the keywords
    $keywords = $this->seogeneratekeywords($keys, $blackList, $count, $minLength);
      // Set the statickeywords
      if ($statickeywords <> '') {
        $keywords = $statickeywords . ', '. $keywords;
		  }
    $document->setMetaData('keywords', $keywords);



    // save the modified keywords for all postings
		if ($saveAll == 0) {
		  	$db =& JFactory::getDBO();
				$query = "SELECT `id`, `sectionid`, `catid`, `title`, `introtext`, `fulltext`, `created_by_alias`, `created_by` FROM #__content";
				$db->setQuery($query);
				$rows =  $db->loadAssocList();
				foreach ( $rows as $row ) {
								
						// create the keywords for the article
						if ($usetitle == 0):
						 $keys = $row['title'];
						elseif ($usetitle == 1): 
						 $keys = $row['introtext'] . " " . $row['fulltext'];
						elseif ($usetitle == 2):
						 $keys = $row['title'] . " " . $row['introtext'] . " " . $row['fulltext'];
						endif;
						
						$keys = $this->CleanText($keys);
						$keywords = $this->seogeneratekeywords($keys, $blackList, $count, $minLength);
					  
						$query = "UPDATE #__content SET `metakey` = '" . $keywords . "' WHERE `id` = " . $row['id'];
						$db->setQuery($query);
						$db->query();									
				}
     }


		// Set optional Generator tag for SEOGenerator credit.
		if ($credit == 0) {
			$document->setMetaData('generator', 'SEOGenerator (http://www.suchmaschinen-optimierung-seo.org)');
		}
		
		
		// Set robots
    if ($robots <> '') {
      $document->setMetaData('robots', $robots);
		}
		
		
		// Set google webmaster verification
    if ($verificationkey <> '') {
      $document->setMetaData('google-site-verification', $verificationkey);
		}
		
		
		
	}

	
	/* cleanText function - Thx owed to eXtplorer, joomSEO and Jean-Marie Simonet */
	function cleanText( $text ) {
		$text = preg_replace( "'<script[^>]*>.*?</script>'si", '', $text );
		$text = preg_replace( '/<!--.+?-->/', '', $text );
		$text = preg_replace( '/{.+?}/', '', $text );

		// convert html entities to chars (with conditional for PHP4 users
		if(( version_compare( phpversion(), '5.0' ) < 0 )) {
			require_once(JPATH_SITE.DS.'libraries'.DS.'tcpdf'.DS.'html_entity_decode_php4.php');
			$text = html_entity_decode_php4($text,ENT_QUOTES,'UTF-8');
		}else{
			$text = html_entity_decode($text,ENT_QUOTES,'UTF-8');
		}

		$text = strip_tags( $text ); // Last check to kill tags
		$text = str_replace('"', '\'', $text); //Make sure all quotes play nice with meta.
        $text = str_replace(array("\r\n", "\r", "\n", "\t"), " ", $text); //Change spaces to spaces

        // remove any extra spaces
		while (strchr($text,"  ")) {
			$text = str_replace("  ", " ",$text);
		}
		
		// general sentence tidyup
		for ($cnt = 1; $cnt < JString::strlen($text); $cnt++) {
			// add a space after any full stops or comma's for readability
			// added as strip_tags was often leaving no spaces
			if ( ($text{$cnt} == '.') || (($text{$cnt} == ',') && !(is_numeric($text{$cnt+1})))) {
				if ($text{$cnt+1} != ' ') {
					$text = substr_replace($text, ' ', $cnt + 1, 0);
				}
			}
		}
			
		return $text;
	}	

	
	function isFrontPage()
	{
		$app = JFactory::getApplication(); if (!$app->isSite()) return;
		$menu = & JSite::getMenu();
		if ($menu->getActive() == $menu->getDefault()) {
			return true;
		}
		return false;
	}

	function killTitleinBuffer ($buff, $tit)
	{
		$cleanTitle = $buff;
		if (substr($buff, 0, strlen($tit)) == $tit) {
			$cleanTitle = substr($buff, strlen($tit) + 1);
		} 
		return $cleanTitle;
	}

  // generate keywords
  function seogeneratekeywords($keys, $blackList, $count, $minLength) {
		
		$keywords ='';
	  
	  $keys = preg_replace('/<[^>]*>/', ' ', $keys);	
	  $keys = preg_replace('/[\.;:!?|\'|\"|\`|\,|\(|\)|\-]/', ' ', $keys);	
	  $keysArray = explode(" ", $keys);
	  $keysArray = array_count_values(array_map('utf8_strtolower', $keysArray));
	
  	$blackArray = explode(",", $blackList);
	
	  foreach($blackArray as $blackWord){
		  if(isset($keysArray[trim($blackWord)]))
			  unset($keysArray[trim($blackWord)]);
	  }
	
	  arsort($keysArray);
	
	  $i = 1;
	
	  foreach($keysArray as $word=>$instances){
		  if($i > $count)
			  break;
		  if(strlen(trim($word)) >= $minLength ) {
			  $keywords .= $word . ", ";
			  $i++;
		  }
	  }
	
	  $keywords = rtrim($keywords, ", ");
	  return($keywords);
  }	
	


// saved keywords and description by writing an article

		public function onBeforeContentSave( &$article, $isNew)
        {
          $app = JFactory::getApplication();
    			
    			$blackList = $this->params->get('blacklist');
					$minLength = $this->params->get('lengthofword');
					$count = $this->params->get('count');
			    $thelength = $this->params->get('length');
			    $savedbywriting = $this->params->get('savedbywriting');
		      $usetitle = $this->params->get('usetitleorcontent');
          $title = $article->title;
   				$thecontent = $article->introtext.$article->fulltext;
    			$metakey = $article->metakey;
    			$metadesc = $article->metadesc;
    
    
    			if ($savedbywriting == 0) {
      
				    // Clean things up and prepare auto-generated Meta Description tag.
						$thecontent = $this->CleanText($thecontent);
					
						// check if title or content used for keywords
				    if ($usetitle == 0):
				     $keys = $title; 
				    elseif ($usetitle == 1):
				     $keys = $thecontent;
				    elseif ($usetitle == 2):
				     $keys = $title . ' ' . $thecontent;
				    endif; 
				    
				      // work on the article
							$keywords = $this->seogeneratekeywords($keys, $blackList, $count, $minLength);
										
							
				      if(strlen($metakey) == 0)
				      $metakey = $keywords;
				      if(strlen($metadesc) == 0)
				      $metadesc = substr(trim($thecontent), 0, $thelength);
				      
				      $article->metakey = $metakey;
							$article->metadesc = $metadesc;
				      
		
					} else {


    
    		  }
    			
    			
            return true;
        }


}



?>