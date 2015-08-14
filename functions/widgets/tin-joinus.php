<?php
/*
	Tinection Widget
	
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	
	Copyright: (c) 2014 知言博客 - http://www.zhiyanblog.com
	
		@package Tinection
		@version 1.1.0
*/
class tinjoinus extends WP_Widget {
/*  Widget
/* ------------------------------------ */
	function __construct(){
		parent::__construct(false,'Tin-加入本站',array( 'description' => 'Tinection-站点说明&加入本站' ,'classname' => 'widget_tinjoinus'));
	}

	function widget($args,$instance){
		extract($args);
	?>
		<?php echo $before_widget; ?>
        <?php if($instance['title'])echo $before_title.$instance['title']. $after_title; ?>
		<div class="joinus">如果您有不错的资源想发布至本站，您可以
		<?php if(is_user_logged_in()){ ?>
			<a href="<?php echo tin_get_user_url('post').'&action=new'; ?>" target="_blank" title="投稿">点击投稿</a>
		<?php }else{ ?>
			<a href="#" class="user-login" title="登录后投稿">点击投稿</a>
		<?php } ?>。我们强烈推荐您注册本站账户或通过QQ、新浪微博登陆本站，使用投稿功能，畅享丰富资源以及积分服务。
		</div>
		<h3><span>站务合作</span></h3>
		<div class="sitecooperate">如果您有站务合作方面的需求，请通过以下方式联系我。<br>QQ: <?php echo ot_get_option('tin_qq'); ?><br>Email: <?php $email = get_option('admin_email'); echo str_replace('@','#',$email)?>(#换成@)</div>
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
add_action('widgets_init',create_function('', 'return register_widget("tinjoinus");'));?>