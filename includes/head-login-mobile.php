<?php
/**
 * Includes of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.6
 * @date      2015.2.2
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<div id="login-box-mobile">
<?php if (!(current_user_can('level_0'))) { ?>
	<div class="login-box-mobile-form">
		<button data-sign="0" class="btn btn-primary user-login"><?php _e('登录','tinection'); ?></button>
		<?php if(get_option('users_can_register')==1){ ?><button data-sign="1" class="btn btn-success user-reg"><?php _e('注册','tinection'); ?></button><?php } ?>
	</div>
<?php } else { ?>
	<div class="login-yet-mobile">
<?php global $current_user; get_currentuserinfo();?>
		<div class="login-yet-mobile-avatar">
			<?php echo tin_get_avatar( $current_user->ID , '60' , tin_get_avatar_type($current_user->ID) ); ?>
		</div>
		<div class="login-yet-mobile-manageinfo">
		<a href="<?php bloginfo('url'); ?>" class="title"><?php bloginfo('name');?></a>
		<a href="<?php echo tin_get_user_url('profile'); ?>" class="name">@&nbsp;<?php echo $current_user->display_name;?></a>
		<?php $unread = intval(get_tin_message($current_user->ID, 'count', "msg_type='unread' OR msg_type='unrepm'")); if($unread>0) { ?><a href="<?php echo tin_get_user_url('message'); ?>" title="<?php _e('新消息','tinection'); ?>" class="new-message-notify"></a><?php } ?>
		</div>
		<div class="clr"></div>
	</div>
<?php }?>
</div>