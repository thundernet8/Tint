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
<?php if($i<2){ ?>
<span class="col-up s0">
<article class="home-blog-entry clr">
	<?php  if(!get_post_format()) { $format = 'standard'; } else { $format = get_post_format(); }?>
	<?php get_template_part('includes/thumbnail',esc_attr( $format )); ?>
	<div class="home-blog-entry-text clr">
	<h3>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
	</h3>
	<p>
		<?php $contents = get_the_excerpt(); $excerpt = wp_trim_words($contents,75,''); echo $excerpt.new_excerpt_more('...');?>
	</p>
	</div>
</article>
</span>
<?php }else{ ?>
<span class="col-down s0">
<article class="home-smalllist-entry clr">
	<div class="home-smalllist-entry-text clr">
		<h3>
			<i class="fa fa-pencil-square"></i>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a><span class="postlist-meta-time"><?php echo date('Y-m-j',get_the_time('U'));?></span>
		</h3>
	</div>
</article>
</span>
<?php } ?>
<?php endwhile;?>