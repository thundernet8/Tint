<?php
/*
	Tinection Widget
	
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	
	Copyright: (c) 2014 知言博客 - http://www.zhiyanblog.com
	
		@package Tinection
		@version 1.1.6
*/
class tincreditsrank extends WP_Widget {
/*  Widget
/* ------------------------------------ */
	function __construct(){
		parent::__construct(false,'Tin-积分排行',array( 'description' => 'Tinection-显示用户积分排行榜' ,'classname' => 'widget_tincreditsrank'));
	}

	function widget($args,$instance){
		extract($args);
	?>
		<?php echo $before_widget; ?>
        <?php if($instance['title'])echo $before_title.$instance['title']. $after_title; ?>
		<?php
			$limit = $instance['ranks_num'];
			$creditsranks = tin_credits_rank($limit);
			echo '<div class="tincreditsrank"><ul>';
			foreach ( $creditsranks as $creditsrank) {
				$user_name = get_user_meta($creditsrank->user_id,'nickname',true);
				$avatar = tin_get_avatar( $creditsrank->user_id , '40' , tin_get_avatar_type($creditsrank->user_id) );
				echo '<li class="tincreditsrank-list"><span class="rank-avatar">'.$avatar.'</span><span class="creditsrank-name"><a href="'.get_author_posts_url($creditsrank->user_id).'" target="_blank" title="'.$user_name.'">'.$user_name.'</a></span><span class="creditsrank-ranking">'.$creditsrank->meta_value.''.__(' 积分','tinection').'</span></li>';
			}
			echo '</ul></div>';
		?>
		<?php echo $after_widget; ?>

	<?php }

	function update($new,$old){
		$instance = $old;
		$instance['ranks_num'] = strip_tags($new['ranks_num']);
		return $new;
	}

	function form($instance){
		$title = esc_attr($instance['title']);
		$num = absint($instance['ranks_num']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('标题：','tinection'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('ranks_num'); ?>"><?php _e('数量：','tinection'); ?></label><input class="widefat" id="<?php echo $this->get_field_id('ranks_num'); ?>" name="<?php echo $this->get_field_name('ranks_num'); ?>" type="text"  value="<?php echo $num; ?>" /></p>
	<?php
	}
}
/*  Register widget
/* ------------------------------------ */
if ( ! function_exists( 'tin_register_widget_creditsrank' ) ) {

	function tin_register_widget_creditsrank() { 
		register_widget( 'tincreditsrank' );
	}	
}
add_action( 'widgets_init', 'tin_register_widget_creditsrank' );