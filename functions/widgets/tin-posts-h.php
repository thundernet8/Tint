<?php
/*
	Tinection Widget
	
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	
	Copyright: (c) 2014 知言博客 - http://www.zhiyanblog.com
	
		@package Tinection
		@version 1.1.8
*/

class TinPostsh extends WP_Widget {

/*  Constructor
/* ------------------------------------ */
	function TinPostsh() {
		parent::__construct( false, 'Tin-分类文章-水平单栏', array('description' => 'Tinection-显示一个或多个分类的文章，水平单栏显示', 'classname' => 'widget_tin_posts') );;	
	}
	
/*  Widget
/* ------------------------------------ */
	public function widget($args, $instance) {
		extract( $args );
		$instance['title']?NULL:$instance['title']='';
		$title = apply_filters('widget_title',$instance['title']);
		$output = $before_widget."\n";
		if($title)
			$output .= $before_title.'<span>'.$title.'</span>'.$after_title;
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
	<?php if(ot_get_option('lazy_load_img')=='on')$lazy = 'class="box-hide" src="'.THEME_URI.'/images/image-pending.gif" data-original';else $lazy ='src'; ?>
	<ul class="tin-postsh group <?php if($instance['posts_thumb']) { echo 'thumbs-enabled'; } ?>">
		<?php while ($posts->have_posts()): $posts->the_post(); ?>
		<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large'); ?>
		<li>
			
			<?php if($instance['posts_thumb']) { // Thumbnails enabled? ?>
			<div class="fancyimg">
			<div class="post-item-thumbnail">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php if ( has_post_thumbnail() ): ?>
						<img <?php echo $lazy; ?>="<?php $imgsrc = $large_image_url[0]; echo tin_thumb_source($imgsrc,188,140,false); ?>" alt="<?php the_title(); ?>" />
						<span><?php the_article_icon();?></span>
					<?php else: ?>
						<img <?php echo $lazy; ?>="<?php $imgsrc = catch_first_image(); echo tin_thumb_source($imgsrc,188,140,false); ?>" alt="<?php the_title(); ?>" />
						<span><?php the_article_icon();?></span>
					<?php endif; ?>
				</a>
			</div>
			</div>
			<?php } ?>
			
			<div class="post-item-inner group">
				<p class="post-item-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></p>
			</div>
			
		</li>
		<?php endwhile; ?>
	</ul>

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
		$instance['posts_thumb'] = $new['posts_thumb']?1:0;
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
			'posts_thumb' 		=> 1,
			'posts_num' 		=> '4',
			'posts_cat_id' 		=> '0',
			'posts_orderby' 	=> 'rand',
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
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('posts_thumb'); ?>" name="<?php echo $this->get_field_name('posts_thumb'); ?>" <?php checked( (bool) $instance["posts_thumb"], true ); ?>>
			<label for="<?php echo $this->get_field_id('posts_thumb'); ?>"><?php _e('显示缩略图','tinection'); ?></label>
		</p>	
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
if ( ! function_exists( 'tin_register_widget_posts_h' ) ) {

	function tin_register_widget_posts_h() { 
		register_widget( 'TinPostsh' );
	}
	
}
add_action( 'widgets_init', 'tin_register_widget_posts_h' );