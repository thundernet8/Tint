<?php
/*
	Tinection Widget
	
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	
	Copyright: (c) 2014 知言博客 - http://www.zhiyanblog.com
	
		@package Tinection
		@version 1.1.4
*/
class tinhotsearch extends WP_Widget {
/*  Widget
/* ------------------------------------ */
	function __construct(){
		parent::__construct(false,'Tin-热门搜索',array( 'description' => 'Tinection-显示站内热门搜索词' ,'classname' => 'widget_tinhotsearch'));
	}

	function widget($args,$instance){
		extract($args);
	?>
		<?php echo $before_widget; ?>
        <?php if($instance['title'])echo $before_title.$instance['title']. $after_title; ?>
		<?php
			$limit = $instance['search_num'];
			$hotsearchs = tin_tracker_rank('search',$limit);
			$i=0;
			echo '<div class="tinhotsearch"><ul>';
			foreach ( $hotsearchs as $hotsearch) {
				$i++;
				echo '<li class="tinhotsearch-list"><i>'.$i.'.</i><span class="search-name"><a href="'.get_bloginfo('url').'/?s='.urlencode($hotsearch->pid).'" target="_blank" title="'.$hotsearch->pid.'">'.$hotsearch->pid.'</a></span><span class="search-times">'.$hotsearch->traffic.''.__(' 次','tinection').'</span></li>';
			}
			echo '</ul></div>';
		?>
		<?php echo $after_widget; ?>

	<?php }

	function update($new,$old){
		$instance = $old;
		$instance['search_num'] = strip_tags($new['search_num']);
		return $new;
	}

	function form($instance){
		$title = esc_attr($instance['title']);
		$num = absint($instance['search_num']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('标题：','tinection'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('search_num'); ?>"><?php _e('数量：','tinection'); ?></label><input class="widefat" id="<?php echo $this->get_field_id('search_num'); ?>" name="<?php echo $this->get_field_name('search_num'); ?>" type="text"  value="<?php echo $num; ?>" /></p>
	<?php
	}
}
/*  Register widget
/* ------------------------------------ */
if ( ! function_exists( 'tin_register_widget_hotsearch' ) ) {

	function tin_register_widget_hotsearch() { 
		register_widget( 'tinhotsearch' );
	}	
}
add_action( 'widgets_init', 'tin_register_widget_hotsearch' );