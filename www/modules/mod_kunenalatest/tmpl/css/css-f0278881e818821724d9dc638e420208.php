<?php 
ob_start ("ob_gzhandler");
header("Content-type: text/css; charset= UTF-8");
header("Cache-Control: must-revalidate");
$expires_time = 1440;
$offset = 60 * $expires_time ;
$ExpStr = "Expires: " . 
gmdate("D, d M Y H:i:s",
time() + $offset) . " GMT";
header($ExpStr);
                ?>

/*** kunenalatest.css ***/

@charset UTF-8;div.klatest ul li{background:none!important;}.klatest-items li.klatest-item{list-style:none!important;clear:both;margin:2px 0;padding:0 0 1px;}.klatest-items .knewchar{color:#090;font-weight:700;font-family:Arial, Helvetica, sans-serif;margin-left:3px;font-size:.75em;vertical-align:top;white-space:nowrap;}li.klatest-subject a{font-weight:700;font-size:12px;}li.klatest-avatar img{border:1px solid #CCC;margin:2px 2px 2px 0;padding:1px;}li.klatest-topicicon img{margin:2px 2px 2px 0;padding:1px;}li.klatest-posttime,li.klatest-cat,li.klatest-author{font-size:10px;}p.klatest-more{clear:both;margin:0;padding:0;}ul.klatest-itemdetails li.klatest-author{display:inline;}ul.klatest-itemdetails li.klatest-posttime{display:block;}.klatest-items,.klatest-items ul.klatest-itemdetails{margin:0;padding:0;}ul.klatest-itemdetails li,ul.klatest-preview-content li{margin-bottom:0!important;display:block;}li.klatest-avatar,li.klatest-topicicon{float:left;display:block;margin-right:5px;}