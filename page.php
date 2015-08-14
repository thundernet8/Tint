<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.0.0
 * @date      2014.11.25
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
	<div id="single-blog-wrap" class="container two-col-container">
		<div id="main-wrap-left">
		<!-- Content -->
		<div class="content">
		<?php while ( have_posts() ) : the_post(); ?>
		<!-- Post meta -->
		<?php tin_post_meta(); ?>
		<!-- /.Post meta -->
		<?php the_tags('<div class="sg-tag"><i class="fa fa-tag"></i>&nbsp;&nbsp;',' ','</div>'); ?>
		<?php $singletopad=ot_get_option('singletopad');if (!empty($singletopad)) {?>
		<div id="singletop-banner">
			<?php echo ot_get_option('singletopad');?>
		</div>
		<?php }?>
		<div class="single-text">
		<?php the_content(); ?>
		</div>
		<!-- Single Activity -->
		<div class="sg-act">
			<?php get_template_part('includes/like_collect'); ?>
			<?php get_template_part('includes/bdshare'); ?>
		</div>
		<!-- /.Single Activity -->		

		<?php $singlebottomad=ot_get_option('singlebottomad');if (!empty($singlebottomad)) {?>
		<div id="singlebottom-banner">
			<?php echo ot_get_option('singlebottomad');?>
		</div>
		<?php }?>
		<!-- Single Author Info -->
		<?php get_template_part('includes/author-info'); ?>
		<!-- /.Single Author Info -->
		</div>
		<!-- /.Content -->
		<!-- Comments -->
		<?php if (comments_open()) comments_template( '', true ); ?>
		<!-- /.Comments -->
		<?php endwhile; ?>
		</div>
		<!-- Sidebar -->
			<?php get_sidebar(); ?>
		<!-- /.Sidebar -->
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