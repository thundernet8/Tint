<!DOCTYPE HTML>
<html lang="zh-CN">
<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.8
 * @date      2015.6.1
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-transform" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!-- 引入页面描述和关键字模板 -->
<?php get_template_part( 'includes/seo');?>
<!-- 网站图标 -->
<?php if ( ot_get_option('favicon') ): ?>
<link rel="shortcut icon" href="<?php echo ot_get_option('favicon'); ?>" />
<link rel="icon" href="<?php echo ot_get_option('favicon'); ?>" />
<?php else: ?>
<link rel="shortcut icon" href="favicon.ico" />
<?php endif; ?>
<!-- 禁止浏览器初始缩放 -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
<!-- 引入主题样式表 -->
<link rel="stylesheet" type="text/css" href="<?php echo THEME_URI.'/style.css'; ?>"  />
<!-- 引入主题响应式样式表-->
<link rel="stylesheet" type="text/css" href="<?php echo THEME_URI.'/includes/css/responsive.css'; ?>"  />
<!-- 引入自定义样式表 -->
<link rel="stylesheet" type="text/css" href="<?php echo THEME_URI.'/includes/css/customcss.php'; ?>"  />
<!-- 引入字体样式表-->
<link rel="stylesheet" type="text/css" href="<?php echo THEME_URI.'/fonts/font-awesome/font-awesome.css'; ?>"  media="all" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<!-- 引入用户自定义代码 -->
<?php if(ot_get_option('headercode')) echo ot_get_option('headercode'); ?>
<?php wp_head(); ?>
<!-- IE Fix for HTML5 Tags -->
<!--[if lt IE 9]>
<script src="<?php echo THEME_URI.'/includes/js/html5.js'; ?>"></script>
<script src="<?php echo THEME_URI.'/includes/js/css3-mediaqueries.js'; ?>"></script>
<script src="<?php echo THEME_URI.'/includes/js/PIE_IE678.js'; ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo THEME_URI.'/includes/css/iefix.css'; ?>"  media="all" />
<![endif]-->
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="<?php echo THEME_URI.'/fonts/font-awesome/font-awesome-ie7.min.css'; ?>"  media="all" />
<![endif]-->
<!--[if IE 6]>
<script src="<?php echo THEME_URI.'/includes/js/kill-IE6.js'; ?>"></script>
<![endif]-->
</head>
<?php $bgtype = ot_get_option('bkgdimg_style','cover'); if($bgtype=='cover'){$repeat=='no-repeat';$cover='cover';}else{$repeat=='repeat';$cover='initial';} ?>
<body id="wrap" <?php body_class(); ?> style="background:<?php if(ot_get_option('bkgdcolor')) echo ot_get_option('bkgdcolor');?>; <?php $bgimg = ot_get_option('bkgdimg'); if(!empty($bgimg)){?>background:url(<?php if(ot_get_option('bkgdimgeffect')=='on') echo THEME_URI.'/images/pix.png'; ?>) top left repeat,url(<?php echo $bgimg; ?>) top center <?php echo $repeat; ?>; background-attachment: fixed; background-size: 2px 2px,<?php echo $cover; ?>;<?php }?>">
<!-- Nav -->
<!-- Moblie nav-->
<div id="body-container">
<aside id="navmenu-mobile">
<div id="navmenu-mobile-wraper">
	<div class="mobile-login-field">
	<?php get_template_part('includes/head-login-mobile'); ?>
	</div>
	<?php wp_nav_menu( array( 'theme_location' => 'topbar', 'container' => '', 'menu_id' => 'menu-mobile', 'menu_class' => 'menu-mobile', 'depth' => '2'  ) ); ?>
</div>
</aside>
<!-- /.Moblie nav -->
<section id="content-container">
<header class="header-wrap" id="nav-scroll">
	<div class="nav-wrap">
 			<?php if ((ot_get_option('logo-status') == 'on') && (ot_get_option('logo-img'))) { ?>
			<div class="logo">
				<a href="<?php bloginfo('url');?>" alt="<?php bloginfo('name');?>" title="<?php bloginfo('name');?>" id="logo" >
					<img src="<?php echo ot_get_option('logo-img');?>">
				</a>
			</div>
			<?php } else {?>
			<div class="logo-title">
				<a href="<?php bloginfo('url');?>" alt="<?php bloginfo('name');?>" title="<?php bloginfo('name');?>">
					<?php echo bloginfo('name');?>
				</a>
			</div>
			<?php } ?>
			<!-- Toggle menu -->
			<div class="toggle-menu">
				<i class="fa fa-bars"></i>
			</div>	
			<!-- /.Toggle menu -->
			<!-- Search button -->
			<div class="search-btn-click">
				<i class="fa fa-search"></i>
			</div>	
			<!-- /.Search button -->
			<!-- Login status -->
			<?php get_template_part('includes/head-login'); ?>
			<!-- /.Login status -->
			<!-- Focus us -->
			<?php get_template_part('includes/focus'); ?>
			<!-- /.Focus us -->			
			<!-- Menu Items Begin -->
			<nav id="pri-nav" class="site-navigation pri-nav <?php if(ot_get_option('double_lan_menu')=='on')echo 'elan_menu'; ?>" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'topbar', 'menu_class' => 'nav-menu', 'depth' => '2'  ) ); ?>
			</nav>
			<!-- Menu Items End -->
	</div>
	<div class="clr"></div>
	<div class="site_loading"></div>
	<!-- Search Form -->
	<div class="header-search-slide" style="display: none;">
		<form method="get" id="searchform-slide" class="searchform" action="<?php bloginfo('url'); ?>" role="search">
			<input type="search" class="field" name="s" value="" placeholder="输入关键词并回车" required>
			<button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
		</form>
	</div>
	<!-- Search Form End -->
</header>
<div class="hidefixnav"></div>
<!-- End Nav -->
<script type="text/javascript">
	$('.site_loading').animate({'width':'33%'},50);  //第一个进度节点
</script>