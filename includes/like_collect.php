<?php
/**
 * Includes of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.7
 * @date      2015.3.10
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<?php $tinlikes=get_post_meta($post->ID,'tin_post_likes',true); $tincollects=get_post_meta($post->ID,'tin_post_collects',true); if(empty($tinlikes)):$tinlikes=0; endif;if(empty($tincollects)):$tincollects=0; endif;?>
<?php $c_name = 'tin_post_like_'.$post->ID;$cookie = isset($_COOKIE[$c_name])?$_COOKIE[$c_name]:'';?>
	<div class="mark-like-btn tinlike clr">
		<a class="share-btn like-btn <?php if($cookie==1)echo 'love-yes'; ?>" pid="<?php echo $post->ID ; ?>" href="javascript:;" title="<?php _e('点击喜欢','tinection'); ?>">
			<i class="fa fa-heart"></i>
			<?php echo '<span>'.$tinlikes.'</span>'.__('人喜欢 ','tinection'); ?>
		</a>
		<?php $uid = get_current_user_id(); if(!empty($uid)&&$uid!=0){ ?>
		
		<?php $mycollects = get_user_meta($uid,'tin_collect',true);
			$mycollects = explode(',',$mycollects);
			$match = 0;
			foreach ($mycollects as $mycollect){
				if ($mycollect == $post->ID):$match++;endif;
			}		
		?>
		
		<?php if ($match==0){ ?>
		<a class="share-btn collect collect-no" pid="<?php echo $post->ID ; ?>" href="javascript:;" uid="<?php echo get_current_user_id(); ?>" title="<?php _e('点击收藏','tinection'); ?>">
			<i class="fa fa-star"></i>
			<span><?php echo $tincollects; ?><?php _e('人收藏 ','tinection'); ?></span>
		</a>
		<?php }else{ ?>
		<a class="share-btn collect collect-yes" style="cursor:default;" title="<?php _e('你已收藏','tinection'); ?>">
			<i class="fa fa-star"></i>
			<?php _e('你已收藏','tinection'); ?>
		</a>
		<?php } ?>
		<?php }else{ ?>
		<a class="share-btn collect collect-no" style="cursor:default;" title="<?php _e('你必须注册并登录才能收藏','tinection'); ?>">
			<i class="fa fa-star"></i>
			<span><?php echo $tincollects; ?><?php _e('人收藏 ','tinection'); ?></span>
		</a>				
		<?php } ?>
	</div>