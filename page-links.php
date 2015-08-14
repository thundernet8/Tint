<?php
/*
Template Name: 友情链接
*/
?>
<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.1
 * @date      2014.12.19
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<?php get_header(); ?>
<?php get_template_part( 'includes/breadcrumbs');?>
<!-- Header Banner -->
<?php $headerad=ot_get_option('headerad');if (!empty($headerad)) {?>
<div id="header-banner">
	<div class="container">
		<?php echo ot_get_option('headerad');?>
	</div>
</div>
<?php }?>
<!-- /.Header Banner -->
<!-- Main Wrap -->
<div id="main-wrap">
	<div id="sitenews-wrap" class="container"><?php get_template_part('includes/sitenews'); ?></div>
	<div class="container pagewrapper clr">
		<aside class="pagesidebar">
			<li id="page-sort-menu-btn"><a href="#"><?php _e('菜单','tinection'); ?></a></li>
			<?php wp_nav_menu( array( 'theme_location' => 'pagebar', 'container' => '', 'menu_id' => '', 'menu_class' => 'pagesider-menu', 'depth' => '1'  ) ); ?>
		</aside>
		<!-- Content -->
		<div class="pagecontent">
		<div class="content">
		<?php while ( have_posts() ) : the_post(); ?>		
		<div class="links-page-content bg-notice hasborder contextual">
		<?php the_content(); ?>
		</div>
		<div class="page-links">
    		<ul>
        	<?php $default_ico = get_template_directory_uri().'/images/defaultfavicon.png'; //默认 ico 图片位置
        		  $bookmarks = get_bookmarks('title_li=&orderby=rating&order=asc'); //全部链接随机输出
        			//如果你要输出某个链接分类的链接，更改一下get_bookmarks参数即可
        			//如要输出链接分类ID为5的链接 title_li=&categorize=0&category=5&orderby=rand
        			if ( !empty($bookmarks) ) {
            		foreach ($bookmarks as $bookmark) {
            		echo '<li><div><img src="'. $bookmark->link_url . '/favicon.ico" onerror="javascript:this.src=\'' . $default_ico . '\'" /><a href="' . $bookmark->link_url . '" title="' . $bookmark->link_name . '" target="_blank" >' . $bookmark->link_name . '</a><p>'. $bookmark->link_description .'</p></div></li>';
            		}
        		}
        	?>
    		</ul>
		</div>

		<?php $singletopad=ot_get_option('singletopad');if (!empty($singletopad)) {?>
		<div id="singletop-banner">
			<?php echo ot_get_option('singletopad');?>
		</div>
		<?php }?>
	
		</div>
		<!-- /.Content -->
		<!-- Comments -->
		<?php if (comments_open()) comments_template( '', true ); ?>
		<!-- /.Comments -->
		<?php endwhile; ?>
		</div>
	</div>
</div>
<!--/.Main Wrap -->
<!-- Bottom Banner -->
<?php $bottomad=ot_get_option('bottomad');if (!empty($bottomad)) {?>
<div id="bottom-banner">
	<div class="container">
		<?php echo ot_get_option('bottomad');?>
	</div>
</div>
<?php }else{?>
<div style="height:50px;"></div>
<?php }?>
<!-- /.Bottom Banner -->
<?php if(ot_get_option('footer-widgets-singlerow') == 'on'){?>
<div id="ft-wg-sr">
	<div class="container">
	<?php dynamic_sidebar( 'footer-row'); ?>
	</div>
</div>
<?php }?>
<?php get_footer(); ?>