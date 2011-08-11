<?php 
/*======================================================================*\
|| #################################################################### ||
|| # Youjoomla LLC - YJ- Licence Number 3145YI543
|| # Licensed to - Siarhei Matusevich
|| # ---------------------------------------------------------------- # ||
|| # Copyright (C) Since 2006 Youjoomla LLC. All Rights Reserved.       ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- THIS IS NOT FREE SOFTWARE ---------------- #      ||
|| # http://www.youjoomla.com | http://www.youjoomla.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/
defined( '_JEXEC' ) or die( 'Restricted index access' ); 
$who = strtolower($_SERVER['HTTP_USER_AGENT']);
?>
<script type="text/javascript">
window.addEvent('domready', function() {
new SmoothScroll({duration: 500});	
});
</script>

<?php 
if (preg_match( "/msie/",$who)){
if (preg_match("/msie 7/",$who) || preg_match("/msie 8/",$who)) {
echo '';
}else{echo 
'<link href="'.$yj_site.'/css/ifie.php" rel="stylesheet" type="text/css" />
<style type="text/css">
#horiznav_d ul li ul{
width:'.$css_width.';
}
</style>';
}
} ?>

<?php 
if (preg_match("/msie 7/",$who)) {
echo 
'<style type="text/css">
.botmb{
margin:-3px 0 10px 0;
}
.botmt{
margin:0 0 1px 0;
}
</style>';
}
?>


<?php if ( $menustyle == 1 || $menustyle == 2 || $menustyle == 5) {?>
<?php if (preg_match( "/msie/",$who)) { ?>

		<script type="text/javascript">
		sfHover = function() {
			var sfEls = document.getElementById("horiznav").getElementsByTagName("LI");
			for (var i=0; i<sfEls.length; i++) {
				sfEls[i].onmouseover=function() {
					this.className+=" sfHover";
				}
				sfEls[i].onmouseout=function() {
					this.className=this.className.replace(new RegExp(" sfHover\\b"), "");
				}
			}
		}
		if (window.attachEvent) window.attachEvent("onload", sfHover);
		</script>
<?php }?>
<?php }?>
 <?php if ( $menustyle == 3 || $menustyle == 4) {?>

<?php if (preg_match( "/msie/",$who)) { ?>
		<script type="text/javascript">
		sfHover = function() {
			var sfEls = document.getElementById("horiznav_d").getElementsByTagName("LI");
			for (var i=0; i<sfEls.length; i++) {
				sfEls[i].onmouseover=function() {
					this.className+=" sfHover";
				}
				sfEls[i].onmouseout=function() {
					this.className=this.className.replace(new RegExp(" sfHover\\b"), "");
				}
			}
		}
		if (window.attachEvent) window.attachEvent("onload", sfHover);
		</script>
<?php }?>
<?php }?>
<?php if ( $menustyle == 2 ) {
echo '<script type="text/javascript" src="'.$yj_site.'/src/mouseover.js"></script>';
}?>
<?php if ($text_direction == 1) { ?>
<style type="text/css">
a.sublevel {
background: url(<?php echo $yj_site ?>/images/<?php echo $css_file ?>/bodyli_rtl.gif) no-repeat 98% 9px;
}
body li{
background: url(<?php echo $yj_site ?>/images/<?php echo $css_file ?>/bodyli_rtl.gif) no-repeat right 6px;
}
</style>

<?php 
if (preg_match( "/msie/",$who)){
if (preg_match("/msie 7/",$who) || preg_match("/msie 8/",$who)) {
echo '';
}else{echo 
'
<style type="text/css">
#horiznav li ul ul {_margin: -35px 0 0 -170px;}
</style>';
}
} ?>
<?php  } ?>