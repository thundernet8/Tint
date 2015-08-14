<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.0.6
 * @date      2014.12.04
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<?php 
	$i=0;
	while (have_posts()&&$i<9) : the_post();
	$r = fmod($i,3)+1;$i++;
?>
<?php if($i<4){ ?>
<span class="col s5 span_1_of_3 col-<?php echo $r;?>">
<article class="home-blog-entry clr">
	<?php  if(!get_post_format()) { $format = 'standard'; } else { $format = get_post_format(); }?>
	<?php get_template_part('includes/thumbnail',esc_attr( $format )); ?>
	<div class="home-blog-entry-text contentcms-entry-text clr">
	<h3>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
	</h3>
	<p>
		<?php $contents = get_the_excerpt(); $excerpt = wp_trim_words($contents,ot_get_option('excerpt-length'),''); echo $excerpt.new_excerpt_more('...');?>
	</p>
	<div class="line"></div>
	<!-- Post meta -->
	<?php tin_post_meta('1'); ?>
	<!-- /.Post meta -->
	</div>
</article>
</span>
<?php }else{ ?>
<?php if($i==4){echo '<div class="home-small-entry-wrap">';} ?>
<span class="col s5 span_1_of_3 col-<?php echo $r;?>">
<article class="home-small-entry clr col-small">
	<?php  if(!get_post_format()) { $format = 'standard'; } else { $format = get_post_format(); }?>
	<?php get_template_part('includes/thumbnail',esc_attr( $format )); ?>
	<div class="home-small-entry-text clr">
		<h3>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</h3>
	</div>
	<div class="line"></div>
	<!-- Post meta -->
	<?php tin_post_meta('1'); ?>
	<!-- /.Post meta -->
</article>
</span>
<?php } ?>
<?php endwhile;?>
<?php if($i>3){echo '</div>';} ?>