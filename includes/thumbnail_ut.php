<?php
/**
 * Includes of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.8
 * @date      2015.6.6
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<?php if ( has_post_thumbnail() ) { ?>
	<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');?>
	<?php $imgsrc = $large_image_url[0]; ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="fancyimg home-blog-entry-thumb">
			<div class="thumb-img">
			<img src="<?php echo $imgsrc; ?>" alt="<?php the_title(); ?>">
			<span><?php the_article_icon();?></span>
			</div>
		</a>
<?php }?>
	<?php if ( !has_post_thumbnail() ) {  ?>
	<?php $imgsrc = catch_first_image(); ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="fancyimg home-blog-entry-thumb">
			<div class="thumb-img">
			<img src="<?php echo $imgsrc;?>" alt="<?php the_title(); ?>">
			<span><?php the_article_icon();?></span>			
			</div>
		</a>
<?php }?>