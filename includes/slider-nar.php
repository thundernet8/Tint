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
<script type="text/javascript">
$(document).ready(function(){
	$('#flexslider').flexslider({
		animation: "slide",
		direction:"horizontal",
		easing:"swing",
		//pauseOnHover:true,
		slideshowSpeed: 5000,
		animationDuration:600,
		prevText: " < ",
        nextText: " > ",
        randomize:true
	});
});
</script>
<?php $thelayout = the_layout(); ?>
<?php 
	global $posts;
	$orig_posts = $posts;
	$sliderposts = explode (',' , ot_get_option('homeslider'));
	$number = count($sliderposts);
	$stickys = get_option('sticky_posts');
	$stickys_num = count($stickys);
	$args= array('post_type' => array('post','store'), 'post__in' => $sliderposts, 'post__not_in' => $stickys  );
	$featured_query = new wp_query( $args );
?>
<section id="home-featured" class="clr">
<!-- Slider -->
<div id="home-slider" class="container">
	<div id="flexslider" class="flexslider flexslider-nar">
		<?php if( $featured_query->have_posts() ) : $i=0;?>
		<ul class="slides">
		<?php while ( $featured_query->have_posts() ) : $featured_query->the_post(); $i++;?>
			<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>
			<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');?>
			<?php $img = $large_image_url[0];else:$img = catch_first_image(); endif; ?>
			<li>
				<a class="slider-img" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo tin_thumb_source($img,750,336,false); ?>" alt="<?php the_title(); ?>"/></a>
				<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<?php $format = get_post_format(); $video = catch_first_embed();if($format=='video'&&$video){?>
				<div class="slider-video"><a rel="iframes" class="" href="javascript:" data="<?php echo $video; ?>"><span></span></a></div>
				<?php } ?>
            </li>
		<?php endwhile;?>
		</ul>
		<?php wp_reset_query(); else: echo '<p style="width:100%;position:absolute;top:50%;margin-top:-10px;text-align:center;font-weight:bold;color:#f00">'.__('请在后台设置中添加要显示幻灯的文章ID','tinection').'</p>'; endif;?>
	</div>
	<div id="flexslider-right">
		<span class="slider-newest">
			<div class="slider-newest-title">
			<?php if($thelayout=='cms'){ ?>
				<h2><?php _e('最新动态','tinection'); ?>
				<a href="<?php echo get_bloginfo('url').'/articles'; ?>" target="_blank" title="<?php _e('更多动态','tinection'); ?>"><?php _e('更多','tinection'); ?></a>
				<i class="fa fa-sitemap"></i>
				</h2>
			<?php }else{ ?>
				<h2><?php _e('热门动态','tinection'); ?></h2>
			<?php } ?>
			</div>
			<div class="slider-newest-articles">
			<?php if($thelayout=='cms'){ ?>
			<?php $orderby='date';$meta_key=''; ?>
			<?php }else{ ?>
			<?php if(ot_get_option('slider_recommend_order')=='latest_reviewed'){
				$orderby = 'meta_value_num';$meta_key = 'tin_latest_reviewed';
			}elseif(ot_get_option('slider_recommend_order')=='most_viewed'){
				$orderby = 'meta_value_num';$meta_key = 'tin_post_views';		
			}else{
				$orderby = 'comment_count';$meta_key = '';
			} ?>
			<?php } ?>
			<?php
				$uncat = ot_get_option('cmsundisplaycats');
				$the_posts = new WP_Query( array(
					'post_type'				=> array( 'post' ),
					'post_status' 			=> array( 'publish' ),
					'showposts'				=> 4,
					'category__not_in'		=> $uncat,
					'ignore_sticky_posts'	=> true,
					'post__not_in' 			=> $stickys,
					'orderby' 				=> ''.$orderby.'',
					'meta_key' 				=> ''.$meta_key.'',
					'order'					=> 'desc'
				) );
			?>
			<?php while ( $the_posts->have_posts() ) : $the_posts->the_post(); ?>
				<?php
					$post_id = get_the_ID();
					$post_title = get_the_title();
					$post_url = get_permalink();
					$post_date = get_the_time('Y-m-d');
				?>
				<article class="clr">
					<a href="<?php echo $post_url; ?>" title="<?php echo $post_title; ?>" class="fancyimg">
						<div class="thumb-img">
						<?php $imgsrc = tin_thumbnail(); $imgtype = substr($imgsrc,strrpos($imgsrc,'.')); if($imgtype!='.gif'){ ?>
							<img <?php echo $lazy; ?>="<?php echo tin_thumb_source($imgsrc,98,72); ?>" alt="<?php echo $post_title; ?>">
							<span></span>
						<?php } else { ?>
							<img <?php echo $lazy; ?>="<?php echo($imgsrc);?>" alt="<?php echo $post_title; ?>" class="thumb-gif">
							<span></span>			
						<?php } ?>
						</div>
					</a>
					<h3><a href="<?php echo $post_url; ?>" title="<?php echo $post_title; ?>"><?php echo $post_title; ?></a></h3>
					<?php if(ot_get_option('slider_recommend_order')=='latest_reviewed'&&$thelayout!='cms'){ ?>
					<?php $comment = tin_get_post_latest_comment($post_id); ?>
					<span class="reviewer"><?php echo $comment->comment_author; ?></span><?php _e(' 评论于 ','tinection'); ?><span class="date"><?php echo timeago($comment->comment_date_gmt); ?></span>
					<?php }else{ ?>
					<span class="date"><?php echo $post_date; ?></span>
					<?php } ?>
				</article>			
			<?php endwhile; wp_reset_query(); ?>
			</div>
		</span>
	</div>
</div>
<!-- End Slider -->
</section>
<?php $posts = $orig_posts;  ?>