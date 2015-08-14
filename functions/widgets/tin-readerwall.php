<?php
/*
	Tinection Widget
	
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	
	Copyright: (c) 2014 知言博客 - http://www.zhiyanblog.com
	
		@package Tinection
		@version 1.0.0
*/
class Tinreaderwall extends WP_Widget {
/*  Widget
/* ------------------------------------ */
	function Tinreaderwall(){
		parent::__construct(false,'Tin-读者墙',array( 'description' => 'Tinection-以图片集形式展示最近网站浏览评论者记录' ,'classname' => 'widget_tinreaderwall'));
	}

	function widget($args,$instance){
		extract($args);
	?>
		<?php echo $before_widget; ?>
                  <?php if($instance['title']) echo $before_title. $instance['title']. $after_title; ?>
				<div class="wallreaders">
				<ul>
				<?php $admin_email = get_bloginfo ('admin_email');global $wpdb; $query="SELECT COUNT(comment_ID) AS cnt, comment_author, comment_author_url, comment_author_email FROM 
				(SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE comment_date > date_sub( NOW(), INTERVAL 24 MONTH ) AND comment_author_email != '".$admin_email."' AND post_password='' AND comment_approved='1' AND comment_type='') AS tempcmt GROUP BY comment_author_email ORDER BY cnt DESC LIMIT ".$instance['num']."";
				$wall = $wpdb->get_results($query);
					$output = '';
					foreach ($wall as $comment)	{
						if( $comment->comment_author_url ){
							$url = $comment->comment_author_url;
						}
						else $url="#";
					$r="rel='external nofollow'";
					$tmp = "<li><a href='".$url."' ".$r." title='".$comment->comment_author." 留下".$comment->cnt."条信息'>".get_avatar($comment->comment_author_email, 50)."</a></li>";
					$output .= $tmp;
					}
				echo $output ;
				?>
				</ul>
				</div>

				
		<?php echo $after_widget; ?>

	<?php }

	function update($new_instance,$old_instance){
		return $new_instance;
	}

	function form($instance){
		$title = esc_attr($instance['title']);
		$num = esc_attr($instance['num']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('标题：','tinection'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('数量：','tinection'); ?></label><input class="widefat" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="text"  value="<?php echo $num; ?>" /></p>
	<?php
	}
}
add_action('widgets_init',create_function('', 'return register_widget("Tinreaderwall");'));?>