<?php
/**
 * Includes of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.7
 * @date      2015.3.10
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<?php $thelayout = the_layout(); ?>
<?php if(ot_get_option('lazy_load_img')=='on'&&($thelayout!='blocks'||($thelayout=='blocks'&&ot_get_option('blocks_style')!='fluid_blocks')))$lazy = 'class="box-hide" src="'.THEME_URI.'/images/image-pending.gif" data-original';else $lazy ='src'; ?>
<?php if ( has_post_thumbnail() ) { ?>
	<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');?>
	<?php $imgsrc = $large_image_url[0]; ?>
		<?php $format = get_post_format(); $video = catch_first_embed();if($format=='video'&&$video){?>
		<a href="<?php echo $video.'?iframe=true&width=960&height=640'; ?>" title="<?php the_title(); ?>" class="fancyimg home-blog-entry-thumb" rel="prettyPhoto[iframe]">
		<?php }else{ ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="fancyimg home-blog-entry-thumb">
		<?php } ?>
			<div class="thumb-img">
			<img <?php echo $lazy; ?>="<?php echo tin_thumb_source($imgsrc); ?>" alt="<?php the_title(); ?>">
			<span><?php the_article_icon();?></span>
			</div>
		</a>
<?php }?>
	<?php if ( !has_post_thumbnail() ) {  ?>
	<?php $imgsrc = catch_first_image(); ?>
		<?php $format = get_post_format(); $video = catch_first_embed();if($format=='video'&&$video){?>
		<a href="<?php echo $video.'?iframe=true&width=960&height=640'; ?>" title="<?php the_title(); ?>" class="fancyimg home-blog-entry-thumb" rel="prettyPhoto[iframe]">
		<?php }else{ ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="fancyimg home-blog-entry-thumb">
		<?php } ?>
			<div class="thumb-img">
			<img src="<?php echo tin_thumb_source($imgsrc);?>" alt="<?php the_title(); ?>">
			<span><?php the_article_icon();?></span>			
			</div>
		</a>
<?php }?>