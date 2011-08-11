<?php header("Content-type: text/css"); ?>
/*======================================================================*\
|| #################################################################### ||
|| # Copyright (C) Since 2006 Youjoomla LLC. All Rights Reserved.       ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- THIS IS NOT FREE SOFTWARE ---------------- #      ||
|| # http://www.youjoomla.com | http://www.youjoomla.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/
@import url("layout.php"); /*layout css file*/
@import url("menus.php"); /*menu css file*/
@import url("typo.php"); /*typo css file*/
body{text-align:center; padding:0; margin:0 0 0 0; font-family:Verdana,Arial,Helvetica,sans-serif; line-height:18px}

a:focus{outline:0px}
focus{outline:0px}
h1, h2, h3, h4, h5, h6, p, blockquote, form, label, ul, ol, dl, fieldset, address{margin:0.5em 0}

ul{margin:0px; padding:0px; list-style:none}
ul li{padding-left:15px}
body ol{list-style:decimal inside; margin:0; padding:0}
body ol li{margin:0px; padding:5px 3px; list-style-image:none; background:none}

body .yjsquare_in ol li{}

fieldset{padding:.5em}
body a, body a:hover{cursor:pointer}
a:link, a:visited{text-decoration:none}
a:hover{text-decoration:none}
h1, .componentheading{font-size:1.7em; line-height:1.7em}
h2, .contentheading{font-size:2.5em; line-height:1.5em}
h3{font-size:1.3em; line-height:1.3em}
h4{font-size:1.2em; line-height:1.2em}
h5{font-size:1.1em; line-height:1.1em}
h6{font-size:1em; line-height:1em; font-weight:bold}

.clr{clear:both; height:1px}
.input{border:0}
.contentdescription img{padding:5px; margin:15px}
.contentheading, 
.contentheading a:link, 
.contentheading a:visited{text-align:left; margin:5px 0 0px 0; padding:0 0 0px 0; font-size:18px; font-family:"Trebuchet MS",sans-serif}
.contentheading a:hover{text-decoration:underline}
.componentheading{letter-spacing:normal; font-size:18px; margin:0 0px 4px 0px; font-family:"Trebuchet MS",sans-serif}
.contentpaneopen{padding:0 0px; text-align:left}
.contentpane{padding:0 0px 0px 0px !important; text-align:left}
.category{margin-left:0px}
.insidem ul{margin-left:10px}
.contentpaneopen, 
.contentpane, 
table.blog{}
.contentpaneopen{border-collapse:separate; border-spacing:3px}
table.contenttoc{margin:0 0 10px 10px; padding:0; width:30%; float:right}
.toclink{padding:5px; display:block; margin:2px 0}
.article_separator{display:block; height:7px; clear:both}
.inputbox{margin-top:5px}
img a, img{border:0; padding:0}
.contentdescription img{padding:0 3px}
input#search_searchword{padding:2px}
table.searchintro{padding:10px 0; width:100%}
table.searchintro td{padding:5px!important}

.button{padding:1px 3px; border:none; margin-top:5px}
.back_button{padding:0 5px}
.readon{height:23px; line-height:23px; display:block; clear:both; float:left; padding:0 0 0 10px; margin:10px 0 0 0}
.readon span{display:block; height:23px; line-height:23px; padding:0 10px 0 0px}
a.pagenav, 
.pagenav_prev a, 
.pagenav_next a, 
.pagenavbar a, .back_button a{height:21px; text-transform:uppercase; font-weight:normal; line-height:21px; padding:0 5px}

table.pollstableborder td.sectiontableentry0, 
table.pollstableborder td.sectiontableentry1, 
table.pollstableborder td.sectiontableentry2, 
table.pollstableborder tr.sectiontableentry0 td, 
table.pollstableborder tr.sectiontableentry1 td, 
table.pollstableborder tr.sectiontableentry2 td{height:20px; padding-left:5px; text-align:left; padding-right:10px; line-height:18px; margin-bottom:5px; background:none; border:none}
tr.sectiontableentry0 td, tr.sectiontableentry1 td, tr.sectiontableentry2 td, 
td.sectiontableentry0, td.sectiontableentry1, td.sectiontableentry2{height:20px; padding:0 10px; line-height:29px}
table.pollstableborder{border:none; padding:0; width:100%; text-align:left}
table.pollstableborder img{vertical-align:baseline}
table.pollstableborder td{padding:0 5px !important}
.sectiontableheader{padding:5px; font-weight:bold}

.tool-tip{float:left; background:#ffc; border:1px solid #D4D5AA; padding:5px; max-width:200px; text-align:left}
.tool-title{padding:0; margin:0; font-size:12px; font-weight:bold; margin-top:-15px; padding-top:15px; padding-bottom:5px; text-align:left; background:url(../../system/images/selector-arrow.png) no-repeat}
.tool-text{font-size:11px; margin:0; text-align:left}

input.system-openid{background:url(http://openid.net/login-bg.gif) no-repeat; background-color:#fff; background-position:0 50%; color:#000; padding-left:18px}

.system-unpublished{background:#FDFDFD; border-top:1px solid #EAEAEA; border-bottom:1px solid #EAEAEA}

#system-message{margin-bottom:10px; padding:0}
#system-message dt{font-weight:bold}
#system-message dd{margin:0; font-weight:bold; text-indent:30px; background-image:none}
#system-message dd ul{ background-color:#FDFDFD; color:#c02; margin-bottom:10px; list-style:none; padding:10px; border-top:1px solid #EAEAEA; border-bottom:1px solid #EAEAEA}

#system-message dt.message{display:none}
#system-message dd.message{}
#system-message dd.message ul li{background-image:none}

#system-message dt.error{display:none}
#system-message dd.error ul{color:#c00; background-color:#FDFDFD; border-top:1px solid #EAEAEA; border-bottom:1px solid #EAEAEA}
#system-message dd.error ul li{background-image:none}

#system-message dt.notice{display:none}
#system-message dd.notice ul{color:#c00; background:#FDFDFD; border-top:1px solid #EAEAEA; border-bottom:1px solid #EAEAEA}
#system-message dd.notice ul li{background-image:none}

#system-debug{color:#ccc; background-color:#fff; padding:10px; margin:10px}
#system-debug div{font-size:11px}

.invalid{border-color:#f00}
label.invalid{color:#f00}

#editor-xtd-buttons{padding:5px}
.button2-left, 
.button2-right, 
.button2-left div, 
.button2-right div{float:left}
.button2-left a, 
.button2-right a, 
.button2-left span, 
.button2-right span{display:block; height:22px; float:left; line-height:22px; font-size:11px; color:#666; cursor:pointer}
.button2-left span, 
.button2-right span{cursor:default; color:#999}
.button2-left .page a, 
.button2-right .page a, 
.button2-left .page span, 
.button2-right .page span{padding:0 6px}
.page span{color:#000; font-weight:bold}
.button2-left a:hover, 
.button2-right a:hover{text-decoration:none; color:#0B55C4}
.button2-left a, 
.button2-left span{padding:0 24px 0 6px}
.button2-right a, 
.button2-right span{padding:0 6px 0 24px}
.button2-left{background:url(../images/j_button2_left.png) no-repeat; float:left; margin-left:5px}
.button2-right{background:url(../images/j_button2_right.png) 100% 0 no-repeat; float:left; margin-left:5px}
.button2-left .image{background:url(../images/j_button2_image.png) 100% 0 no-repeat}
.button2-left .readmore{background:url(../images/j_button2_readmore.png) 100% 0 no-repeat}
.button2-left .pagebreak{background:url(../images/j_button2_pagebreak.png) 100% 0 no-repeat}
.button2-left .blank{background:url(../images/j_button2_blank.png) 100% 0 no-repeat}

div.tooltip{float:left; background:#ffc; border:1px solid #D4D5AA; padding:5px; max-width:200px; z-index:13000}
div.tooltip h4{padding:0; margin:0; font-size:95%; font-weight:bold; margin-top:-15px; padding-top:15px; padding-bottom:5px; background:url(../images/selector-arrow.png) no-repeat}
div.tooltip p{font-size:90%; margin:0}

.img_caption.left{float:left; margin-right:1em}
.img_caption.right{float:right; margin-left:1em}
.img_caption.left p{clear:left; text-align:center}
.img_caption.right p{clear:right; text-align:center}

a img.calendar{width:16px; height:16px; margin-left:3px; background:url(../images/calendar.png) no-repeat; cursor:pointer; vertical-align:middle}

#component-contact{padding:0 8px}