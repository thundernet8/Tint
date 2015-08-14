<!DOCTYPE html>
<?php
/*
Template Name: 邮件周刊
*/
?>
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
<?php get_header('simple'); ?>
<?php 
$issue_meta = get_tin_meta('issue') ? get_tin_meta('issue') : '';
$issue_meta_array =explode(',',$issue_meta);
$length = count($issue_meta_array);
if(isset($_GET['special'])&&!empty($_GET['special'])){
	$special = $_GET['special'];
	$title = __('专刊速递(No.','tinection').$special.')';
	$content = newsletter_posts_special($special);	
}elseif(isset($_GET['issue'])&&!empty($_GET['issue'])){
	$issue = $_GET['issue'];
	$title = __('邮件周刊(No.','tinection').$issue.')';
	$content = tin_past_issues_selection();
	$content .= newsletter_posts_issue($issue);
}elseif(isset($_GET['action'])&&($_GET['action']=='unsubscribe')&&(!isset($_GET['nonce']))){
	$title = __('退订','tinection');
	$content = newsletter_unsubscribe_template();
}elseif(isset($_GET['action'])&&($_GET['action']=='unsubscribe')&&(isset($_GET['email']))&&(isset($_GET['nonce']))){
	$title = __('邮件订阅','tinection');
	$meta_key = 'unsubscribe_'.$_GET['email'];
	$nonce = get_tin_meta($meta_key) ? get_tin_meta($meta_key) : '';
	if($nonce==$_GET['nonce']){
		delete_tin_meta($meta_key);
		//删除用户邮箱
		$tin_dlusers = get_tin_meta('tin_dlusers');
		$tin_dlusers = tin_delete_string_specific_value(',',$tin_dlusers,$_GET['email']);
		update_tin_meta('tin_dlusers',$tin_dlusers);
		$tin_subscribers = get_tin_meta('tin_subscribers');
		$tin_subscribers = tin_delete_string_specific_value(',',$tin_subscribers,$_GET['email']);
		update_tin_meta('tin_subscribers',$tin_subscribers);
		$content = '<div style="min-height:300px;">'.__('退订成功!','tinection').'</div>';
	}else{$content = '<div style="min-height:300px;">'.__('退订失败，你可能已经退订，或请重新再试!','tinection').'</div>';}	
}elseif(isset($_GET['action'])&&($_GET['action']=='subscribe')){
	$title = __('邮件订阅','tinection');
	$content = newsletter_subscribe_template();
}else{
	$issue = $length;
	$title = __('邮件周刊(No.','tinection').$issue.')';
	$content = tin_past_issues_selection();
	$content .= newsletter_posts_issue($issue);
}
?>
<html>
<title><?php echo $title; ?> - <?php bloginfo('name'); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- Main Wrap -->
<div id="main-wrap" style="padding-top:20px;padding-bottom:20px;">
	<?php echo $content; ?>
</div>
<!--/.Main Wrap -->
<!-- Bottom Banner -->
<?php $singlebottomad=ot_get_option('singlebottomad');if (!empty($singlebottomad)) {?>
<div id="singlebottom-banner">
	<?php echo $singlebottomad;?>
</div>
<?php }?>
<!-- /.Bottom Banner -->
<?php get_footer('simple'); ?>