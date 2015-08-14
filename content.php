<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.2
 * @date      2014.12.27
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<?php get_template_part('includes/thumbnail'); ?>
<?php if(!is_search()): ?>
<div class="home-blog-entry-text clr">
<h3>
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
</h3>
<!-- Post meta -->
<?php tin_post_meta(); ?>
<!-- /.Post meta -->
<p>
<?php if(ot_get_option('content_or_excerpt')=='content'){the_content();}
	else{$contents = get_the_excerpt(); $excerpt = wp_trim_words($contents,ot_get_option('excerpt-length'),''); echo $excerpt.' '.new_excerpt_more('...');}
?>
</p>
</div>
<?php endif; ?>