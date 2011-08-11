<?php header("Content-type: text/css"); ?>
<?php
$template_path = dirname( dirname( $_SERVER['REQUEST_URI'] ) );
?>
html .png,
div .png,
div.arrow,#yjsg0,#yjsg0_shadob {
azimuth: expression(
this.pngSet?this.pngSet=true:(this.nodeName == "IMG" && this.src.toLowerCase().indexOf('.png')>-1?(this.runtimeStyle.backgroundImage = "none",
this.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + this.src + "', sizingMethod='image')",
this.src = "<?php echo $template_path; ?>/images/blank.gif"):(this.origBg = this.origBg? this.origBg :this.currentStyle.backgroundImage.toString().replace('url("','').replace('")',''),
this.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + this.origBg + "', sizingMethod='crop')",
this.runtimeStyle.backgroundImage = "none")),this.pngSet=true
);
}


#horiznav a {line-height: 35px;_line-height: 35px;_margin-left:0px;_float:left;}
#horiznav li:hover,#horiznav li.sfHover,#horiznav {_position:relative;z-index:10000;}
#horiznav li ul {_top:35px;_position:absolute;margin:-2px 0 0 0px;}
#horiznav li li:hover ul,
#horiznav li.sfHover ul,
#horiznav li li.sfHover ul,
#horiznav li li li.sfHover ul
,#horiznav li li li li.sfHover ul {_left:0;}
#horiznav li ul ul {_margin: -35px 0 0 170px;}
#horiznav ul ul a {width: 170px;}
#horiznav ul li li {position:relative;margin:0 0px 0 0;}
.readon{
width:100px;
}
#yjsg0{
padding:0px 0 0 0;
}
.itemImageBlock .clr{
display:none;
}
div.itemToolbar{
padding:5px 0 0 0;
height:21px;
}
div.subCategory{
padding:5px 0 0 8px;
}
div.k2ItemsBlock ul li img.moduleItemAuthorAvatar {
display:block;
position:absolute;
right:10px;
}
.moduleItemImage img{
display:block;
float:right;
position:relative;
}
.k2ItemsBlock ul li{
border-top:4px solid #DEDECC !important;
}
.k2LatestCommentsBlock ul li.even,
.k2LatestCommentsBlock ul li.odd{
margin:0 0px 2px 0px;
padding:8px 4px 18px 4px;
}
.botmt{
margin:0 0 -5px 0;
}
.botmb{
margin:-9px 0 10px 0;
}