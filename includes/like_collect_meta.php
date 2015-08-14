<?php
/**
 * Includes of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.0
 * @date      2014.12.11
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<?php $tinlikes=get_post_meta($post->ID,'tin_post_likes',true); $tincollects=get_post_meta($post->ID,'tin_post_collects',true); if(empty($tinlikes)):$tinlikes=0; endif;if(empty($tincollects)):$tincollects=0; endif;?>
	<div class="postlist-meta-like item like-btn" style="float:right;" pid="<?php echo $post->ID ; ?>" title="<?php _e('点击喜欢','tinection'); ?>"><i class="fa fa-heart"></i>&nbsp;<span><?php echo $tinlikes; ?></span>&nbsp;</div>
	<?php $uid = get_current_user_id(); if(!empty($uid)&&$uid!=0){ ?>		
		<?php $mycollects = get_user_meta($uid,'tin_collect',true);
			$mycollects = explode(',',$mycollects);
		?>
		<?php global $curauth; ?>
		<?php if (!in_array($post->ID,$mycollects)){ ?>
		<div class="postlist-meta-collect item collect collect-no" style="float:right;" pid="<?php echo $post->ID ; ?>" uid="<?php echo get_current_user_id(); ?>" title="<?php _e('点击收藏','tinection'); ?>"><i class="fa fa-star"></i>&nbsp;<span><?php echo $tincollects; ?></span>&nbsp;</div>
		<?php }elseif(isset($curauth->ID)&&$curauth->ID==$uid){ ?>
		<div class="postlist-meta-collect item collect collect-yes remove-collect" style="float:right;cursor:pointer;" pid="<?php echo $post->ID ; ?>" uid="<?php echo get_current_user_id(); ?>" title="<?php _e('取消收藏','tinection'); ?>"><i class="fa fa-star"></i>&nbsp;<span><?php _e('取消收藏','tinection'); ?></span>&nbsp;</div>
		<?php }else{ ?>
		<div class="postlist-meta-collect item collect collect-yes" style="float:right;cursor:default;" uid="<?php echo get_current_user_id(); ?>" title="<?php _e('你已收藏','tinection'); ?>"><i class="fa fa-star"></i>&nbsp;<span><?php _e('已收藏','tinection'); ?></span>&nbsp;</div>
		<?php } ?>
		<?php }else{ ?>
		<div class="postlist-meta-collect item collect collect-no" style="float:right;cursor:default;" title="<?php _e('必须登录才能收藏','tinection'); ?>"><i class="fa fa-star"></i>&nbsp;<span><?php echo $tincollects; ?></span>&nbsp;</div>
	<?php } ?>