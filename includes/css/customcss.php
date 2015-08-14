<?php
/**
 * Customize Stylesheet of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.3
 * @date      2015.1.7
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/
?>
<?php
error_reporting(0);
define( 'ABSPATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/' );
require_once(ABSPATH.'/wp-load.php');
//浏览器滚动条颜色
$browser_scroll_color = ot_get_option('browser_scroll_color','#00d6ac');
//Body背景色
$bkgdcolor = ot_get_option('bkgdcolor');
//Body主字体颜色
$main_body_color = ot_get_option('main_body_color','#666');
//Body主字体超链接颜色
$main_body_a_color = ot_get_option('main_body_a_color','#428bca');
//Body主字体超链接鼠标悬停颜色
$main_body_a_hover_color = ot_get_option('main_body_a_hover_color','#51ADED');
//文章标题颜色
$title_a_color = ot_get_option('title_a_color','#000');
//文章标题鼠标悬停颜色
$title_a_hover_color = ot_get_option('title_a_hover_color','#51ADED');
//块标题底边色
$block_border_color = ot_get_option('block_border_color','#f98181');
//Selection选取背景色
$selection_bg_color = ot_get_option('selection_bg_color','#51aded');
//Selection选取文字颜色
$selection_color = ot_get_option('selection_color','#fff');
//导航条背景色
$nav_bg_color = ot_get_option('nav_bg_color','#fff');
//菜单文字颜色
$menu_color = ot_get_option('menu_color','#333');
//菜单悬停背景色
$menu_hover_bg_color = ot_get_option('menu_hover_bg_color','#f5f5f5');
//菜单悬停文字颜色
$menu_hover_color = ot_get_option('menu_hover_color','#51ADED');
//Logo字体颜色
$logo_color = ot_get_option('logo_color','#888888');
//移动端标题字体大小
$mobile_title_font_size = ot_get_option('mobile_title_font_size','13px');
//移动端内容字体大小
$mobile_content_font_size = ot_get_option('mobile_content_font_size','11px');

//缓存过期时间
$expires_offset = 24*3600;
header('Content-Type: text/css; charset=UTF-8');
header('Expires: ' . gmdate( "D, d M Y H:i:s", time() + $expires_offset ) . ' GMT');
header("Cache-Control: public, max-age=$expires_offset");

?>
::-webkit-scrollbar-thumb,.nicescroll-rails div{background-color:<?php echo $browser_scroll_color; ?> !important;}
::selection{background:<?php echo $selection_bg_color; ?>;color:<?php echo $selection_color; ?>}
body,.cms-bar .col-right.s4 .col-small p:before{color:<?php echo $main_body_color; ?>}
body a,.bg-sitenews i.fa-volume-up,.tab-item-comment i,.tab-item-comment i:before,.catlist_1_of_2 .home-heading a,.widget_tinsitestatistic ul li span,.comment-login-pop-click,.comment-info span.cmt-vote i.voted{color:<?php echo $main_body_a_color; ?>}
.tin-tabs-nav li.active a{border-bottom-color:<?php echo $main_body_a_color; ?>}
.home-heading a,#sidebar #submit-mail:hover{background: <?php echo $main_body_a_color; ?>}
body a:hover{color:<?php echo $main_body_a_hover_color; ?>}
article h3,article h3 a,.tab-item-title a,.slider-text h2 a{color:<?php echo $title_a_color; ?>}
article h3 a:hover,.tab-item-title a:hover,.more-link,.slider-text h2 a:hover,.slider-newest-articles h3 a:hover{color:<?php echo $title_a_hover_color; ?>}
.header-wrap,.pri-nav ul,.pri-nav ul ul,.pri-nav ul ul ul,.user-tabs{background-color:<?php echo $nav_bg_color; ?>}
.logo-title a{color:<?php echo $logo_color; ?>}
.pri-nav li > a,.pri-nav li.current-menu-item a,#focus-us,.focus-content a,.user-tabs span a,.user-tabs span i{color:<?php echo $menu_color; ?>}
.pri-nav li a:hover, .user-tabs span:hover, #focus-us:hover, #focus-us:focus, #focus-slide{background:<?php echo $menu_hover_bg_color; ?>}
.pri-nav li > a:hover,.pri-nav li:hover > a, .pri-nav li.focus > a,.user-tabs span:hover a,.user-tabs span:hover i,#focus-us:hover, #focus-us:focus,.user-tabs span:hover,.user-tabs span:hover i,.login-yet-click a,.login-yet-click a:hover,.focus-content a:hover,.logo-title a:hover{color:<?php echo $menu_hover_color; ?>}
.pri-nav ul ul,.pri-nav a:hover,.pri-nav li.current-menu-item a{border-bottom-color:<?php echo $menu_hover_color; ?>}
.logo a img{background-color:<?php echo $menu_hover_color; ?>}
#sidebar .widget > h3 span, .floatwidget h3 span, .multi-border-hl span,.tin-tabs-nav li.active a,.cms-bar .heading-text, .heading-text-blog,.cms-bar .stickys .heading-text-cms.active,span#comments.active, span#comments_quote.active,#ft-wg-sr .widget > h3 span{border-bottom-color:<?php echo $block_border_color; ?>}
.tin-tabs-nav li a:hover{color:<?php echo $block_border_color; ?>}
@media screen and (max-width: 860px) and (min-width:641px){
	#flexslider-right{background:<?php echo $bkgdcolor; ?>}
}
@media screen and (max-width: 480px){
	h3,h3 a{font-size:<?php echo $mobile_title_font_size;?> !important;}
	article p,.content,.content a,.content li,single-content,single-text,single-content a,single-text a,.sg-cp p,.widget,.widget a{font-size:<?php echo $mobile_content_font_size;?> !important;}
}