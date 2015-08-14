<?php
/*
	Tinection Widget
	
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	
	Copyright: (c) 2014 知言博客 - http://www.zhiyanblog.com
	
		@package Tinection
		@version 1.1.7
*/

class TinSlider extends WP_Widget {

/*  Constructor
/* ------------------------------------ */
	function TinSlider() {
		parent::__construct( false, 'Tin-图片幻灯', array('description' => 'Tinection-幻灯形式显示一个或多个分类的文章', 'classname' => 'widget_tin_slider') );;	
	}
	
/*  Widget
/* ------------------------------------ */
	public function widget($args, $instance) {
		extract( $args );
		$instance['title']?NULL:$instance['title']='';
		$title = apply_filters('widget_title',$instance['title']);
		$output = $before_widget."\n";
		if($title)
			$output .= $before_title.$title.$after_title;
		ob_start();
	
?>

	<?php
		$posts = new WP_Query( array(
			'post_type'				=> array( 'post' ),
			'showposts'				=> $instance['posts_num'],
			'cat'					=> $instance['posts_cat_id'],
			'ignore_sticky_posts'	=> true,
			'orderby'				=> $instance['posts_orderby'],
			'order'					=> 'dsc',
			'date_query' => array(
				array(
					'after' => $instance['posts_time'],
				),
			),
		) );
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.tin-slider').flexslider({
				animation: "fade",
				direction:"horizontal",
				easing:"swing",
				pauseOnHover:true,
				slideshowSpeed: 5000,
				animationDuration:600,
				prevText: "",
				nextText: "",
				directionNav:false,
				randomize:true
			});
		});
	</script>
	<div class="tin-slider">
	<ul class="slides">
		<?php while ($posts->have_posts()): $posts->the_post(); ?>
		<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large'); ?>		
		<li>	
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php if ( has_post_thumbnail() ): ?>
			<img src="<?php $imgsrc = $large_image_url[0]; echo tin_thumb_source($imgsrc,350,250,false); ?>" alt="<?php the_title(); ?>" style="width:350px;height:250px;" />
			<?php else: ?>
			<img src="<?php $imgsrc = catch_first_image(); echo tin_thumb_source($imgsrc,350,250,false); ?>" alt="<?php the_title(); ?>" style="width:350px;height:250px;" />
			<?php endif; ?>
			</a>
			<div class="widget-slider-title trans">
				<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
			</div>
		</li>
		<?php endwhile; wp_reset_query(); ?>
	</ul>
	</div>
<?php
		$output .= ob_get_clean();
		$output .= $after_widget."\n";
		echo $output;
	}
	
/*  Widget update
/* ------------------------------------ */
	public function update($new,$old) {
		$instance = $old;
		$instance['title'] = strip_tags($new['title']);
	// Posts
		$instance['posts_num'] = strip_tags($new['posts_num']);
		$instance['posts_cat_id'] = strip_tags($new['posts_cat_id']);
		$instance['posts_orderby'] = strip_tags($new['posts_orderby']);
		$instance['posts_time'] = strip_tags($new['posts_time']);
		return $instance;
	}

/*  Widget form
/* ------------------------------------ */
	public function form($instance) {
		// Default widget settings
		$defaults = array(
			'title' 			=> '',
		// Posts
			'posts_num' 		=> '4',
			'posts_cat_id' 		=> '0',
			'posts_orderby' 	=> 'date',
			'posts_time' 		=> '0',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
?>

	<style>
	.widget .widget-inside .tin-options-posts .postform { width: 100%; }
	.widget .widget-inside .tin-options-posts p { margin: 3px 0; }
	.widget .widget-inside .tin-options-posts hr { margin: 20px 0 10px; }
	.widget .widget-inside .tin-options-posts h4 { margin-bottom: 10px; }
	</style>
	
	<div class="tin-options-posts">
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('标题：','tinection'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
		</p>
		
		<h4><?php _e('文章列表','tinection'); ?></h4>
		<p>
			<label style="width: 55%; display: inline-block;" for="<?php echo $this->get_field_id("posts_num"); ?>"><?php _e('显示的条目数量','tinection'); ?></label>
			<input style="width:20%;" id="<?php echo $this->get_field_id("posts_num"); ?>" name="<?php echo $this->get_field_name("posts_num"); ?>" type="text" value="<?php echo absint($instance["posts_num"]); ?>" size='3' />
		</p>
		<p>
			<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("posts_cat_id"); ?>"><?php _e('分类：','tinection'); ?></label>
			<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("posts_cat_id"), 'selected' => $instance["posts_cat_id"], 'show_option_all' => 'All', 'show_count' => true ) ); ?>		
		</p>
		<p style="padding-top: 0.3em;">
			<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("posts_orderby"); ?>"><?php _e('排序：','tinection'); ?></label>
			<select style="width: 100%;" id="<?php echo $this->get_field_id("posts_orderby"); ?>" name="<?php echo $this->get_field_name("posts_orderby"); ?>">
			  <option value="date"<?php selected( $instance["posts_orderby"], "date" ); ?>><?php _e('日期最新','tinection'); ?></option>
			  <option value="comment_count"<?php selected( $instance["posts_orderby"], "comment_count" ); ?>><?php _e('最多评论','tinection'); ?></option>
			  <option value="rand"<?php selected( $instance["posts_orderby"], "rand" ); ?>><?php _e('随机排序','tinection'); ?></option>
			</select>	
		</p>
		<p style="padding-top: 0.3em;">
			<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("posts_time"); ?>"><?php _e('文章来自：','tinection'); ?></label>
			<select style="width: 100%;" id="<?php echo $this->get_field_id("posts_time"); ?>" name="<?php echo $this->get_field_name("posts_time"); ?>">
			  <option value="0"<?php selected( $instance["posts_time"], "0" ); ?>><?php _e('所有时间','tinection'); ?></option>
			  <option value="1 year ago"<?php selected( $instance["posts_time"], "1 year ago" ); ?>><?php _e('今年','tinection'); ?></option>
			  <option value="1 month ago"<?php selected( $instance["posts_time"], "1 month ago" ); ?>><?php _e('本月','tinection'); ?></option>
			  <option value="1 week ago"<?php selected( $instance["posts_time"], "1 week ago" ); ?>><?php _e('本周','tinection'); ?></option>
			  <option value="1 day ago"<?php selected( $instance["posts_time"], "1 day ago" ); ?>><?php _e('过去24小时','tinection'); ?></option>
			</select>	
		</p>
		
		<hr>

	</div>
<?php

}

}

/*  Register widget
/* ------------------------------------ */
if ( ! function_exists( 'tin_register_widget_slider' ) ) {

	function tin_register_widget_slider() { 
		register_widget( 'TinSlider' );
	}
	
}
add_action( 'widgets_init', 'tin_register_widget_slider' );