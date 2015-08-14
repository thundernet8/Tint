<?php
/*
	Tinection Widget
	
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	
	Copyright: (c) 2014 知言博客 - http://www.zhiyanblog.com
	
		@package Tinection
		@version 1.1.0
*/
class tinsitestatistic extends WP_Widget {
/*  Widget
/* ------------------------------------ */
	function __construct(){
		parent::__construct(false,'Tin-站点统计',array( 'description' => 'Tinection-站点统计' ,'classname' => 'widget_tinsitestatistic'));
	}

	function widget($args,$instance){
		extract($args);
	?>
		<?php echo $before_widget; ?>
        <?php if($instance['title'])echo $before_title.$instance['title']. $after_title; ?>
		<ul>
			<?php global $wpdb; ?>
			<li><?php _e('日志总数：','tinection'); ?><span><?php $count_posts = wp_count_posts();echo $published_posts = $count_posts->publish; ?></span> <?php _e(' 篇','tinection'); ?></li>
			<li><?php _e(' 评论总数：','tinection'); ?><span><?php echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments"); ?></span><?php _e(' 条','tinection'); ?></li>
			<li><?php _e('标签数量：','tinection'); ?><span><?php echo $count_tags = wp_count_terms('post_tag'); ?></span><?php _e(' 个','tinection'); ?></li>
			<li><?php _e('链接总数：','tinection'); ?><span><?php $link = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->links WHERE link_visible = 'Y'");echo $link; ?></span><?php _e(' 个','tinection'); ?></li>
			<li><?php _e('建站日期：','tinection'); ?><span><?php echo ot_get_option('sitebuild_date');?></span></li>
			<li><?php _e('运行天数：','tinection'); ?><span><?php echo floor((time()-strtotime(ot_get_option('sitebuild_date')))/86400); ?></span><?php _e(' 天','tinection'); ?></li>
			<li><?php _e('最后更新：','tinection'); ?><span><?php $last = $wpdb->get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");$last = date('Y-n-j',strtotime($last[0]->MAX_m));echo $last; ?></span></li>
		</ul>
<div class="clear"></div>		
		
		
		
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
add_action('widgets_init',create_function('', 'return register_widget("tinsitestatistic");'));?>