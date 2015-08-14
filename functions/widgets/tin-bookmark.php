<?php
/*
	Tinection Widget
	
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	
	Copyright: (c) 2014 知言博客 - http://www.zhiyanblog.com
	
		@package Tinection
		@version 1.1.8
*/
class tinbookmark extends WP_Widget {
/*  Widget
/* ------------------------------------ */
	function __construct(){
		parent::__construct(false,'Tin-友情链接',array( 'description' => 'Tinection-双栏显示友情链接，替代默认单栏书签' ,'classname' => 'widget_tinbookmark'));
	}

	function widget($args,$instance){
		extract($args);
	?>
		<?php echo $before_widget; ?>
        <?php if($instance['title'])echo $before_title.$instance['title']. $after_title; ?>
		<?php
			global $wpdb;
			$limit = $instance['links_num'];
			$orderby = $instance['links_orderby'];
			$rating_limit = (int)$instance['rating_limit'];
			if($orderby=='rand'){$bookmarks = $wpdb -> get_results("SELECT * FROM $wpdb->links WHERE link_rating>=$rating_limit AND link_visible='Y' ORDER BY RAND() LIMIT $limit");}else
			{$bookmarks = $wpdb -> get_results("SELECT * FROM $wpdb->links WHERE link_rating>=$rating_limit AND link_visible='Y' ORDER BY $orderby DESC LIMIT $limit");}
			$i = 0;
			echo '<div class="tinbookmark"><ul>';
			foreach ( $bookmarks as $bookmark) {
				$r = fmod($i,2);$i++;
				if($r==0){
				echo '<li class="tinbookmark-list list-left"><i class="fa fa-angle-right"></i><a href="'.$bookmark->link_url.'" title="'.$bookmark->link_name.'" target="_blank">'.$bookmark->link_name.'</a></li>';}
				else{
				echo '<li class="tinbookmark-list list-right"><i class="fa fa-angle-right"></i><a href="'.$bookmark->link_url.'" title="'.$bookmark->link_name.'" target="_blank">'.$bookmark->link_name.'</a></li>';}
			}
			echo '</ul></div>';
		?>
		<?php echo $after_widget; ?>

	<?php }

	function update($new,$old){
		$instance = $old;
		$instance['link_num'] = strip_tags($new['link_num']);
		$instance['links_orderby'] = strip_tags($new['links_orderby']);
		$instance['rating_limit'] = strip_tags($new['rating_limit']);
		return $new;
	}

	function form($instance){
		$title = esc_attr($instance['title']);
		$num = absint($instance['links_num']);
		$rating_limit = absint($instance['rating_limit']);
		// Default widget settings
		$defaults = array(
		// Links
			'links_orderby' 	=> 'link_id',
			'links_num'			=>	20,
			'rating_limit'		=>	0
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('标题：','tinection'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('links_num'); ?>"><?php _e('数量：','tinection'); ?></label><input class="widefat" id="<?php echo $this->get_field_id('links_num'); ?>" name="<?php echo $this->get_field_name('links_num'); ?>" type="text"  value="<?php echo $num; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('rating_limit'); ?>"><?php _e('评分不低于：','tinection'); ?></label><input class="widefat" id="<?php echo $this->get_field_id('rating_limit'); ?>" name="<?php echo $this->get_field_name('rating_limit'); ?>" type="text"  value="<?php echo $rating_limit; ?>" /></p>
		<p style="padding-top: 0.3em;">
			<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("links_orderby"); ?>"><?php _e('排序：','tinection'); ?></label>
			<select style="width: 100%;" id="<?php echo $this->get_field_id("links_orderby"); ?>" name="<?php echo $this->get_field_name("links_orderby"); ?>">
			  <option value="link_id"<?php selected( $instance["links_orderby"], "link_id" ); ?>>ID</option>
			  <option value="link_name"<?php selected( $instance["links_orderby"], "link_name" ); ?>><?php _e('名称','tinection'); ?></option>
			  <option value="link_rating"<?php selected( $instance["links_orderby"], "link_rating" ); ?>><?php _e('评分','tinection'); ?></option>
			  <option value="rand"<?php selected( $instance["links_orderby"], "rand" ); ?>><?php _e('随机','tinection'); ?></option>
			</select>	
		</p>
	<?php
	}
}
/*  Register widget
/* ------------------------------------ */
if ( ! function_exists( 'tin_register_widget_bookmarks' ) ) {

	function tin_register_widget_bookmarks() { 
		register_widget( 'tinbookmark' );
	}	
}
add_action( 'widgets_init', 'tin_register_widget_bookmarks' );