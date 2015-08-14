<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.3
 * @date      2015.1.7
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
<div class="container blocks">
<div class="catlist clr">
<div class="catlist-container-rand clr masonry" id="fluid_blocks">
<?php while (have_posts()) : the_post();?>
<span class="col span_1_of_4 masonry-box">
<article class="home-blog-entry clr home-blog-entry-rand">
	<?php  if(!get_post_format()) { $format = 'standard'; } else { $format = get_post_format(); }?>
	<?php get_template_part('includes/thumbnail_ut',esc_attr( $format )); ?>
	<div class="home-blog-entry-text contentcms-entry-text clr">
		<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
		<p>
			<?php $contents = get_the_excerpt(); $excerpt = wp_trim_words($contents,120,ot_get_option('readmore')); echo $excerpt;?>
		</p>
		<div class="line"></div>
		<!-- Post meta -->
		<?php tin_post_meta(1); ?>
		<!-- /.Post meta -->
	</div>
	<div class="clear"></div>
</article>
</span>
<?php endwhile;?>
</div>
<!-- pagination -->
<div class="clear">
</div>
<?php ajaxmore(); ?>
<!-- /.pagination -->
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
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/jquery.masonry.js"></script>
<script type="text/javascript">
	$(function(){
		var $container = $('#fluid_blocks'),
			$items = $('#fluid_blocks .masonry-box');
		$items.imagesLoaded(function(){
			$items.fadeIn();
			$container.masonry({
				itemSelector:'.masonry-box',
				gutterWidth:0,
				isAnimated:false
			});
		});
	});
</script>
<?php get_footer('simple'); ?>