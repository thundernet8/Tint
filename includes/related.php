<?php
/**
 * Includes of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.8
 * @date      2015.6.5
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<?php if(ot_get_option('lazy_load_img')=='on')$lazy = 'class="box-hide" src="'.THEME_URI.'/images/image-pending.gif" data-original';else $lazy ='src'; ?>
<div class="relpost">
<?php 
	$backup = $post;
	$tags = wp_get_post_tags($post->ID);
	$tagIDs = array();
	if ($tags) {
?>
		<?php 
			$tagcount = count($tags);
			for ($i = 0;$i <$tagcount;$i++) {
			$tagIDs[$i] = $tags[$i]->term_id;
			}
			$args=array(
				'tag__in'=>$tagIDs,
				'post__not_in'=>array($post->ID),
				'showposts'=>4,
				'orderby'=>'rand',
				'ignore_sticky_posts'=>1
			);
			$my_query = new WP_Query($args);
				if( $my_query->have_posts() ) {
			?>
			<!--h3 class="multi-border-hl"><span><?php _e('相关文章','tinection'); ?></span></h3-->
			<ul>
			<?php 
					while ($my_query->have_posts()) : $my_query->the_post();
		?>
			<li>
				<div class="relpost-inner">
					<div class="relpost-inner-pic">
					<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');?><?php if ( has_post_thumbnail() ) { ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="">
							<div class="thumb-img">
								<img <?php echo $lazy; ?>="<?php $imgsrc = $large_image_url[0]; echo tin_thumb_source($imgsrc,175,126,false); ?>" alt="<?php the_title(); ?>">
								<span><?php the_article_icon();?></span>
							</div>
						</a>
					<?php }?>
					<?php if ( !has_post_thumbnail() ) {  ?>	
						<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="">
							<div class="thumb-img">
								<img <?php echo $lazy; ?>="<?php $imgsrc = catch_first_image(); echo tin_thumb_source($imgsrc,175,126,false); ?>">
								<span><?php the_article_icon();?></span>
							</div>
						</a>
						<?php }?>
					</div>
					<div class="relpost-inner-text">
						<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php echo cut_str($post->post_title,46);; ?>
						</a>
					</div>
				</div>
				<div class="clear"></div>
			</li>
			<?php endwhile;?>
		</ul>
		<?php } else {?>
		<!--h3 class="multi-border-hl"><span><?php _e('推荐文章','tinection'); ?></span></h3-->
		<ul>
		<?php query_posts(array('orderby'=>'rand','showposts'=>4,'ignore_sticky_posts'=>1));
		if (have_posts()) :
			while (have_posts()) : the_post();
		?>
			<li>
				<div class="relpost-inner">
					<div class="relpost-inner-pic">
					<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');?><?php if ( has_post_thumbnail()) { ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="">
							<div class="thumb-img">
								<img <?php echo $lazy; ?>="<?php $imgsrc = $large_image_url[0]; echo tin_thumb_source($imgsrc,175,126,false); ?>" alt="<?php the_title(); ?>">
								<span><?php the_article_icon();?></span>
							</div>
						</a>
					<?php }?>
					<?php if ( !has_post_thumbnail() ) {  ?>	
						<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="">
							<div class="thumb-img">
								<img <?php echo $lazy; ?>="<?php $imgsrc = catch_first_image(); echo tin_thumb_source($imgsrc,175,126,false); ?>">
								<span><?php the_article_icon();?></span>
							</div>
						</a>
						<?php }?>
					</div>
					<div class="relpost-inner-text">
						<a href="<?php the_permalink(); ?>" rel="bookmark" title='Permanent Link to "<?php the_title(); ?>"'><?php echo cut_str($post->post_title,46);; ?>
						</a>
					</div>
				</div>
				<div class="clear"></div>
			</li>
		<?php endwhile; ?>
		<?php endif; ?>
		</ul>
		<?php }}else { ?>
<!-- 没有相关文章显示随机文章 -->
		<!--h3 class="multi-border-hl"><span><?php _e('推荐文章','tinection'); ?></span></h3-->
		<ul>
		<?php 
			query_posts(array('orderby'=>'rand','showposts'=>4,'ignore_sticky_posts'=>1));
			if (have_posts()) :
				while (have_posts()) : the_post();
		?>
			<li>
				<div class="relpost-inner">
					<div class="relpost-inner-pic">
					<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');?><?php if ( has_post_thumbnail()) { ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="">
							<div class="thumb-img">
								<img <?php echo $lazy; ?>="<?php $imgsrc = $large_image_url[0]; echo tin_thumb_source($imgsrc,175,126,false); ?>" alt="<?php the_title(); ?>">
								<span><?php the_article_icon();?></span>
							</div>
						</a>
					<?php }?>
					<?php if ( !has_post_thumbnail() ) {  ?>	
						<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="">
							<div class="thumb-img">
								<img <?php echo $lazy; ?>="<?php $imgsrc = catch_first_image(); echo tin_thumb_source($imgsrc,175,126,false); ?>">
								<span><?php the_article_icon();?></span>
							</div>
						</a>
						<?php }?>
					</div>
					<div class="relpost-inner-text">
						<a href="<?php the_permalink(); ?>" rel="bookmark" title='Permanent Link to "<?php the_title(); ?>"'><?php echo cut_str($post->post_title,46);; ?>
						</a>
					</div>
				</div>
				<div class="clear"></div>
			</li>
		<?php endwhile; ?>
		<?php endif; ?>
		</ul>
		<?php }
	$post = $backup;
	wp_reset_query();
?>
</div>