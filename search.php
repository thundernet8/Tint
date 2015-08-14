<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.0
 * @date      2014.12.11
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
	<div id="home-blog-wrap" class="container two-col-container">
		<div id="main-wrap-left">
		<div class="bloglist-container clr">
		<?php if (have_posts()&&!empty($_GET['s'])&&$_GET['s']!='.') { ?>
		<?php $i=0;while (have_posts()) : the_post(); $i++;?>
			<article class="home-blog-entry col span_1 clr">
				<?php  if(!get_post_format()) { $format = 'standard'; } else { $format = get_post_format(); }?>
				<?php get_template_part('content',esc_attr( $format )); ?>
				<div class="home-blog-entry-text clr">
					<h3>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo search_word_replace(get_the_title()); ?></a>
					</h3>
					<!-- Post meta -->
					<?php tin_post_meta(); ?>
					<!-- /.Post meta -->
					<p>
						<?php if(ot_get_option('content_or_excerpt')=='content'){the_content();}else{$contents = get_the_excerpt(); $excerpt = wp_trim_words($contents,ot_get_option('excerpt-length'),'');$excerpt = search_word_replace($excerpt); echo $excerpt.new_excerpt_more('...');}
						?>
					</p>
					</div>
				<div class="clear"></div>
			</article>
			<?php if($i==2){ ?>
			<?php if(!tin_is_mobile()){ ?>
			<div id="loopad" class="container">
			<?php echo ot_get_option('cmswithsidebar_loop_ad'); ?>
			</div>
			<?php }else{ ?>
			<div id="loopad" class="mobile-ad">
			<?php echo ot_get_option('singlead1_mobile'); ?>
			</div>
			<?php }?>
			<?php }?>
		<?php endwhile;?>
		<?php }else{ ?>
			<article class="home-blog-entry col span_1 clr">
				<div style="height:500px; padding:20px;"><p><?php _e('暂无相关搜索结果','tinection'); ?></p></div>
			</article>
		<?php } ?>
		</div>
			<!-- pagination -->
			<div class="clear"></div>
			<div class="pagination">
			<?php pagenavi(); ?>
			</div>
			<!-- /.pagination -->
		</div>
	<?php get_sidebar();?>
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