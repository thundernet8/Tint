<?php
/*
	Tinection Widget
	
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	
	Copyright: (c) 2014 知言博客 - http://www.zhiyanblog.com
	
		@package Tinection
		@version 1.1.0
*/
class tinsubscribe extends WP_Widget {
/*  Widget
/* ------------------------------------ */
	function __construct(){
		parent::__construct(false,'Tin-邮件订阅',array( 'description' => 'Tinection-展示邮件订阅部件' ,'classname' => 'widget_tinsubscribe'));
	}

	function widget($args,$instance){
		extract($args);
	?>
		<?php echo $before_widget; ?>
        <?php if($instance['title'])echo $before_title.$instance['title']. $after_title; ?>
		<span id="subscribe-span">
			<input type="text" name="subscribe" id="subscribe" placeholder="yourname@domain.com"><button id="subscribe" class="btn btn-success"><?php _e('订阅','tinection'); ?></button>
			<p id="subscribe-msg" style="display:none;margin-top:5px;margin-left:auto;margin-right:auto;font-size:12px;color:#f00;"></p>
		</span>
		<?php echo $after_widget; ?>
	<?php }

	function update($new_instance,$old_instance){
		return $new_instance;
	}

	function form($instance){
		$title = esc_attr($instance['title']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('标题：','tinection'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
	<?php
	}
}
add_action('widgets_init',create_function('', 'return register_widget("tinsubscribe");'));?>