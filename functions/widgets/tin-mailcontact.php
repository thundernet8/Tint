<?php
/*
	Tinection Widget
	
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	
	Copyright: (c) 2014 知言博客 - http://www.zhiyanblog.com
	
		@package Tinection
		@version 1.1.0
*/
class tinmailcontact extends WP_Widget {
/*  Widget
/* ------------------------------------ */
	function __construct(){
		parent::__construct(false,'Tin-邮件联系',array( 'description' => 'Tinection-用户邮件联系博主' ,'classname' => 'widget_tinmailcontact'));
	}

	function widget($args,$instance){
		extract($args);
	?>
		<?php echo $before_widget; ?>
                  <?php if($instance['title']) echo $before_title.$instance['title'].$after_title; ?>
					<div id="mailmessage">
						<form method="post" id="mailmessage-form">
							<div class="mailmessage-box">
								<label for="t-name"><i class="fa fa-user"></i></label>
								<input name="t-name" type="text" id="t-name" class="text_input" size="24" value="" tabindex='8' placeholder="<?php _e('你的称呼','tinection'); ?>" />
							</div>
							<div class="mailmessage-box">
								<label for="t-email"><i class="fa fa-envelope"></i></label>
								<input name="t-email" type="text" id="t-email" class="text_input" size="24" value="" tabindex='9'    placeholder="<?php _e('你的邮件地址','tinection'); ?>" /><br/>
							</div>
							<div class="mailmessage-box">
								<?php $num1=rand(0,50);	$num2=rand(0,50); ?>
								<label for='math'><i class="fa fa-key"></i></label>
								<input type='text' name='sum' id='captcha2' class='math_textfield' value='' size='22' tabindex='10' placeholder="<?php echo $num1.'+'.$num2.'= ?'; ?>"/>
								<input type='hidden' id='t-num1' name='num1' value="<?php echo $num1; ?>"/>
								<input type='hidden' id='t-num2' name='num2' value="<?php echo $num2; ?>"/>
							</div>
							<div class="mailmessage-box-txt">
								<textarea name="t-comment" id="t-comment" rows="8" class="text_input long" placeholder="<?php _e('消息内容...','tinection'); ?>" tabindex='11'></textarea>
							</div>
							<p class="err"></p>
							<input id="submit-mail" name="submit" type="submit" value="<?php _e('发   送','tinection'); ?>" tabindex='12' />
						</form>
					</div>

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
add_action('widgets_init',create_function('', 'return register_widget("tinmailcontact");'));?>