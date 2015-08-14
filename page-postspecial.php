<?php
/**
 * Main Template of Tinection WordPress Theme
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
<?php get_header(); ?>
<?php get_template_part( 'includes/breadcrumbs');?>
<!-- Header Banner -->
<?php $headerad=ot_get_option('headerad');if (!empty($headerad)) {?>
<div id="header-banner">
	<div class="container">
		<?php echo ot_get_option('headerad');?>
	</div>
</div>
<?php }?>
<!-- /.Header Banner -->
<!-- Main Wrap -->
<div id="main-wrap">
	<div id="single-blog-wrap" class="container two-col-container">
		<div id="main-wrap-left">
		<!-- Content -->
		<div class="content">
		<?php if( is_user_logged_in() && current_user_can('edit_users') ){ ?>
			<?php if(isset($_POST['action'])&&($_POST['action']=='new')){ ?>
			<?php $post_title = !empty($_POST['post_title']) ? $_POST['post_title'] : '';
				  $post_content = !empty($_POST['post_content']) ? $_POST['post_content'] : '';
				  tin_newsletter_newspecial($post_title,$post_content);
				  $url = get_bloginfo('url').'/newsletter?special='.get_tin_meta('special_id');
			?>
			<div class="alert alert-success"><?php _e('操作成功！已推送新专刊邮件。','tinection'); ?><a href="<?php echo $url; ?>"><?php _e('点击查看','tinection'); ?></a></div>	  
			<?php } ?>
			<div class="panel-body">
				<h3 class="page-header"><?php _e('新专刊','tinection');?> <small><?php _e('NEW SPECIAL','tinection');?></small></h3>
				<form role="form" method="post">
					<div class="form-group">
						<input type="text" class="form-control" name="post_title" placeholder="<?php _e('在此输入标题','tinection');?>" value="" aria-required='true' required>
					</div>
					<div class="form-group">
						<?php wp_editor(  wpautop($post_content), 'post_content', array('media_buttons'=>true, 'quicktags'=>true, 'editor_class'=>'form-control', 'editor_css'=>'<style>.wp-editor-container{border:1px solid #ddd;}.switch-html, .switch-tmce{height:25px !important}</style>' ) ); ?>
					</div>
					<div class="form-group text-right">
						<input type="hidden" name="action" value="new">
						<button type="submit" class="btn btn-success" id="new_special"><?php _e('发表专刊','tinection');?></button>
					</div>	
				</form>
			</div>
		<?php }else{_e('你尚未登录或没有权限发表专刊！','tinection');} ?>
		</div>
		<!-- /.Content -->


		</div>
		<!-- Sidebar -->
			<?php get_sidebar(); ?>
		<!-- /.Sidebar -->
	</div>
</div>
<!--/.Main Wrap -->
<?php get_footer(); ?>