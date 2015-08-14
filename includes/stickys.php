<?php
/**
 * Includes of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.7
 * @date      2015.3.4
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<!-- Stickys -->
<?php $stickys = get_option('sticky_posts');$stickys_num = count($stickys);$args = array('showposts' => 4,'post__in' => $stickys); if($stickys_num!=0): $stickys_query = new wp_query( $args );?>
<?php if($stickys_num==1)$cls='stickys-one-col';else $cls='stickys-two-col'; ?>
<?php $thelayout = the_layout(); ?>
<?php if($thelayout=='cms'||$thelayout=='blog'){ ?>
<section class="stickys clr">
<?php if($thelayout=='cms'&&ot_get_option('slider_style')=='full'){ ?>
	<h2 class="home-heading clr">
		<span class="heading-text heading-text-cms active" id='.stickys-container'>
			<?php _e('置顶推荐','tinection');?>
		</span>
		<span class="heading-text heading-text-cms" id='.latest-container'>
			<?php _e('最新发布','tinection');?>
		</span>
	</h2>
<?php }else{ ?>
	<h2 class="home-heading clr">
		<span class="heading-text-blog">
			<?php _e('置顶推荐','tinection');?>
		</span>
	</h2>
<?php } ?>
	<div class="stickys-container <?php echo $cls; ?> stickys-latest-list clr">
<?php $i=1;while ($stickys_query -> have_posts()&&$i<=4) : $stickys_query -> the_post(); $i++;?>	
		<article class="clr col-small">
		<div class="inner">
			<?php get_template_part('includes/thumbnail'); ?>
			<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
			<p>
				<?php $contents = get_the_excerpt(); $excerpt = wp_trim_words($contents,ot_get_option('excerpt-length'),ot_get_option('readmore')); echo $excerpt;?>
			</p>
		</div>
		<div class="meta">
			<span class="date"><?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) ?></span>
			<span class="views"><?php echo sprintf(__('浏览: %1$s','tinection'),get_tin_traffic( 'single' , get_the_ID() )); ?></span>
			<span class="comments"><?php if ( comments_open() ): ?><?php comments_number( __('评论: 0','tinection'), __('评论: 1','tinection'), __('评论: %','tinection') ); ?><?php else:?><?php _e('评论关闭','tinection'); ?><?php endif; ?></span>
		</div>
		</article>	
<?php endwhile; ?>
	</div>
<?php wp_reset_query(); ?>
<?php if(ot_get_option('slider_style')=='full'){
	$uncat = ot_get_option('cmsundisplaycats');
	$period = ot_get_option('latest_period');
	$latest_posts = new WP_Query( array(
			'post_type'				=> array( 'post' ),
			'post_status' 			=> array( 'publish' ),
			'showposts'				=> 5,
			'category__not_in'		=> $uncat,
			'ignore_sticky_posts'	=> true,
			'post__not_in' 			=> $stickys,
			'orderby'				=> 'date',
			'order'					=> 'desc',
			'date_query' => array(
				array(
					'after' => $period,
				),
			),
		) );
?>
	<div class="latest-container stickys-latest-list clr">
	<?php $i=0;while ($latest_posts -> have_posts()) : $latest_posts -> the_post(); $i++;
		$post_title = get_the_title();
		$post_url = get_permalink();
		$post_date = timeago( get_gmt_from_date(get_the_time('Y-m-d H:i:s')) );
	?>	
		<article class="clr col-small">
			<h3>
				<span class="num"><?php echo $i; ?></span>
				<?php echo '<a href="'	.$post_url. '" title="' .$post_title.'">' .$post_title. '</a>'; ?>
				<span class="date"><?php echo $post_date ; ?></span>
				<span class="views"><?php echo sprintf(__('浏览(%1$s)','tinection'),get_tin_traffic( 'single' , get_the_ID() )); ?></span>
				<span class="comments"><?php if ( comments_open() ): ?><?php comments_number( __('评论(0)','tinection'), __('评论(1)','tinection'), __('评论(%)','tinection') ); ?><?php else:?><?php _e('评论关闭','tinection'); ?><?php endif; ?></span>
			</h3>
		</article>		
	<?php endwhile; ?>
	</div>
<?php wp_reset_query(); }?>
</section>
<?php } else{ ?>
<?php } ?>
<?php endif; ?>
<!-- /.Stickys -->