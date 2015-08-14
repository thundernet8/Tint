<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.0.9
 * @date      2014.12.09
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<?php 
	$i=0;
	while (have_posts()&&$i<6) : the_post();
	$i++;
?>
<?php if($i==1){ ?>
<span class="col-left s2">
<article class="home-blog-entry clr">
	<?php  if(!get_post_format()) { $format = 'standard'; } else { $format = get_post_format(); }?>
	<?php get_template_part('includes/thumbnail',esc_attr( $format )); ?>
	<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
	<div class="postlist-meta">
		<span class="postlist-meta-time"><?php echo date('Y-m-j',get_the_time('U'));?></span>
		<span class="delim"></span>
		<span class="postlist-meta-views"><?php echo get_tin_traffic( 'single' , get_the_ID() ); ?>&nbsp;℃</span>
		<span class="delim"></span>
		<span class="postlist-meta-comments"><?php if ( comments_open() ): ?><i class="fa fa-comments"></i>&nbsp;<a href="<?php comments_link(); ?>"><?php comments_number( '0', '1', '%' ); ?></a><?php  endif; ?></span>
		<?php get_template_part('includes/like_collect_meta'); ?>
	</div>
	<p>
		<?php $contents = get_the_excerpt(); $excerpt = wp_trim_words($contents,ot_get_option('excerpt-length'),''); echo $excerpt.new_excerpt_more('...');?>
	</p>
</article>
</span>
<?php }else{ ?>
<?php if($i==2){echo '<span class="col-right s2">';} ?>
<article class="clr col-small">
	<?php  if(!get_post_format()) { $format = 'standard'; } else { $format = get_post_format(); }?>
	<?php get_template_part('includes/thumbnail',esc_attr( $format )); ?>
	<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
	<p>
		<?php $contents = get_the_content(); $excerpt = wp_trim_words($contents,ot_get_option('excerpt-length'),''); echo $excerpt.new_excerpt_more('...');?>
	</p>
</article>
<?php } ?>
<?php endwhile;?>
<?php if($i>1) echo '</span>'; ?>