<?php 

/**
* @version   $Id: random_rss.php 1.0 2009-08-13 CobusTaljaard $
* @package   Joomla 1.5
* @copyright Copyright (C) 2009 Cobus C H Taljaard. All rights reserved.
* @license   GNU/GPL, see gpl.txt
*            Parse XML feeds and displays a single random feed post from all posts in the slected feed
*/        

// no direct access
defined('_JEXEC') or die('Restricted access');

        //include Simple Pie processor class
        if(!class_exists('SimplePie')){
                require_once (JPATH_SITE.DS.'libraries'.DS.'simplepie'.DS.'simplepie.php');
        }

        // check if cache directory exists and is writeable
        $cacheDir =  JPATH_BASE.DS.'cache';        
        if ( !is_writable( $cacheDir ) ) {        
                $slick_rss['error'][] = 'Cache folder is unwriteable. Solution: chmod 777 '.$cacheDir;
                $cache_exists = false;
        }else{
                $cache_exists = true;
        }

        //get module parameters
        $linkTarget               = $params->get( 'linkTarget', 1 );                    // open link in new window or not
        $noFollow                 = $params->get( 'noFollow', 1 );                      // allow spiders to crawl link or not
        $myRSSurl                 = $params->get( 'myRSSurl', NULL );                   // feed url
        $myRSScache               = $params->get( 'myRSScache', 3600 );                 // seconds before refreshing feed cache
        $myRSStitle               = $params->get( 'myRSStitle', 1 );                    // display feed title or not
        $myRSSdescription         = $params->get( 'myRSSdescription', 1 );              // display feed description or not
        $myRSSitem_nos            = $params->get( 'myRSSitem_nos', 1 );                 // number of feed items to use for selecting a single random one from
        $myRSSitem_title          = $params->get( 'myRSSitem_title', 1 );               // display feed item title or not
        $myRSSitem_content        = $params->get( 'myRSSitem_content', 1 );             // display feed item content or not
        $myRSSitem_date           = $params->get( 'myRSSitem_date', 1 );                // display feed item publish date or not
        $myRSSformat              = $params->get( 'myRSSformat', 1 );                   // how to format feed item

        //get feed and set item details
        $feed = new SimplePie(); // create a new simplepie instance
        $feed->set_feed_url($myRSSurl); // specify feed url

        //what html tags to strip from content
        switch($myRSSformat){
                case 0:
                        $feed->strip_htmltags(array('IMG', 'br', 'p', 'div', 'span'));  // strip images, line breaks and other text formatting
                        break;
                case 1:
                        $feed->strip_htmltags(array('IMG'));                            // strip onyl images
                        break;
                case 2:
                        $feed->strip_htmltags(array('br', 'p', 'div', 'span'));         // strip line breaks and other text formatting
                        break;
                case 3:
                        break;
                default:
                        $feed->strip_htmltags(array('IMG','br', 'p', 'div', 'span'));   // strip line breaks and other text formatting
                        break;
        }
        
        //check and set caching
        if($cache_exists) {
                $feed->set_cache_location($cacheDir);
                $feed->enable_cache();
                $cache_time = (intval($myRSScache));
                $feed->set_cache_duration($cache_time);
        }
        else {
                $feed->enable_cache('false');
        }
        
        $feed->handle_content_type();                                                   // text/html utf-8 character encoding

        $check = $feed->init();                                                         // script initialization check

        $max = $feed->get_item_quantity();                                              // get number of items in feed
        $max = ($max - 1);                                                              // first feed item is 0
        $myRSSitem_nos = ($myRSSitem_nos - 1);

        switch($myRSSitem_nos){                                                         //determines how many feed items to use when selecting a single random feed item
                case 0:
                        $RandomPostno = rand(0, $max);
                        break;
                case ($myRSSitem_nos > 0 and $myRSSitem_nos < $max):
                        $RandomPostno = rand(0, $myRSSitem_nos);
                        break;
                case ($myRSSitem_nos >= $max):
                        $RandomPostno = rand(0, $max);
                        break;
                default:
                        $RandomPostno = rand(0, $max);
                        break;
        }

        switch($linkTarget){                                                            //opens link in parent or new window
                case 1:
                        $linkTarget = ' target="_blank"';
                        break;
                case 0:
                        $linkTarget = '';
                        break;
                default:
                        $linkTarget = ' target="_blank"';
                        break;
        }

        switch($noFollow){                                                              //allows spiders to crawl link or not
                case 1:
                        $noFollow = ' rel="nofollow"';
                        break;
                case 0:
                        $noFollow = '';
                        break;
                default:
                        $noFollow = ' rel="nofollow"';
                        break;
        }

?>

<?php if ($check) : ?>
        <?php if ( $myRSStitle == 1 ) : ?>
                <a href="<?php echo $feed->get_permalink(); ?>"<?php echo $noFollow, $linkTarget; ?>><?php echo $feed->get_title(); ?></a><br />
        <?php endif; ?>
        <?php if ( $myRSSdescription == 1 )  : ?>
                <?php echo $feed->get_description(); ?><br /><br />
        <?php endif; ?>
        <?php $item = $feed->get_item($RandomPostno); ?>
        <?php if ( $myRSSitem_title == 1 )  : ?>
                <a href="<?php echo $item->get_permalink(); ?>"<?php echo $noFollow, $linkTarget; ?>><?php echo $item->get_title(); ?></a><br /><br />
        <?php endif; ?>
        <?php if ( $myRSSitem_content == 1 )  : ?>
                <?php echo $item->get_content(); ?><br />
        <?php endif; ?>
        <?php if ( $myRSSitem_date == 1 )  : ?>
                <small>Posted on <?php echo $item->get_date('j F Y @ g:i a'); ?></small>
        <?php endif; ?>
<?php else : ?>
        <h2>RSS feed currently not available</h2>
        <br>Please try again later
<?php endif; ?>
 

