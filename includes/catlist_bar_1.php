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
	while (have_posts()&&$i<8) : the_post();
	$r = fmod($i,2)+1;$i++;
	if($r==1)$cls='left';else $cls='right';
?>
<span class="s1 <?php echo $cls; ?>">
<article class="clr col-small">
	<span class="views"><?php echo get_tin_traffic( 'single' , get_the_ID() ); ?></span>
	<?php  if(!get_post_format()) { $format = 'standard'; } else { $format = get_post_format(); }?>
	<?php get_template_part('includes/thumbnail',esc_attr( $format )); ?>
	<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
	<p>
		<?php $contents = get_the_excerpt(); $excerpt = wp_trim_words($contents,ot_get_option('excerpt-length'),''); echo $excerpt.new_excerpt_more('...');?>
	</p>
</article>
</span>
<?php endwhile;?>