<?php
/**
 * Includes of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.3
 * @date      2015.1.8
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<?php if (!(current_user_can('level_0'))) { ?>
	<?php if(get_option('users_can_register')==1) $register = 'on'; else $register = 'off'; ?>
		<div id="login-reg">
			<span data-sign="0" id="user-login" class="user-login ie_pie <?php if($register == 'off') echo 'only-login'; ?>"><?php _e(' 登录','tinection'); ?></span>
			<?php if($register == 'on') { ?><span data-sign="1" id="user-reg" class="user-reg ie_pie"><?php _e('注册','tinection'); ?></span><?php }?>
		</div>
<?php }else{global $current_user; get_currentuserinfo();?>
			<div class="login-yet-click">
				<div class="login-yet-click-inner">
					<?php echo tin_get_avatar( $current_user->ID , '35' , tin_get_avatar_type($current_user->ID) ); ?>
					<a href="<?php bloginfo('url'); ?>/wp-admin/profile.php" title="<?php _e('用户管理','tinection'); ?>"><?php echo $current_user->display_name;?></a>
					<?php $unread = intval(get_tin_message($current_user->ID, 'count', "msg_type='unread' OR msg_type='unrepm'")); if($unread>0) { ?><a href="<?php echo tin_get_user_url('message'); ?>" title="<?php _e('新消息','tinection'); ?>" class="new-message-notify"></a><?php } ?>
				</div>
				<div class="user-tabs">
					<span><i class="fa fa-book"></i>&nbsp;<a href="<?php echo tin_get_user_url('post'); ?>" title="<?php _e('我的文章','tinection'); ?>"><?php _e('我的文章','tinection'); ?></a></span>
					<span><i class="fa fa-edit"></i>&nbsp;<a href="<?php echo tin_get_user_url('post').'&action=new'; ?>" title="<?php _e('发布文章','tinection'); ?>"><?php _e('发布文章','tinection'); ?></a></span>
					<span><i class="fa fa-heart"></i>&nbsp;<a href="<?php echo tin_get_user_url('collect'); ?>" title="<?php _e('我的收藏','tinection'); ?>"><?php _e('我的收藏','tinection'); ?></a></span>
					<span><i class="fa fa-envelope"></i>&nbsp;<a href="<?php echo tin_get_user_url('message'); ?>" title="<?php _e('站内消息','tinection'); ?>"><?php _e('站内消息','tinection'); ?><?php if($unread>0) echo '('.$unread.')'; ?></a></span>
					<span><i class="fa fa-cny"></i>&nbsp;<a href="<?php echo tin_get_user_url('credit'); ?>" title="<?php _e('我的积分','tinection'); ?>"><?php _e('积分查询','tinection'); ?></a></span>
					<span><i class="fa fa-cog"></i>&nbsp;<a href="<?php echo tin_get_user_url('profile'); ?>" title="<?php _e('编辑资料','tinection'); ?>"><?php _e('编辑资料','tinection'); ?></a></span>
					<span><i class="fa fa-sign-out"></i>&nbsp;<a href="<?php if(is_singular()){echo wp_logout_url( get_permalink() ); }else{echo wp_logout_url(get_bloginfo('url'));} ?>" title="<?php _e('注销登录','tinection'); ?>"><?php _e('注销登录','tinection'); ?></a></span>
				</div>
			</div>
<?php } ?>