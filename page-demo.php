<?php
/*
Template Name: 演示页面
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
<?php wp_reset_query(); ?>
<?php if(isset($_GET['id'])):$id = $_GET['id'];else:$id = 0;endif; ?>
<?php $id_arr = explode('_',$id); $pid=$id_arr[0];$i=isset($id_arr[1])?$id_arr[1]:1; ?>
<!DOCTYPE html>
<!--[if IE 6]>
<html class="ie6 ancient-ie old-ie no-js" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html class="ie7 ancient-ie old-ie no-js" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie8 old-ie no-js" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 9]>
<html class="ie9 old-ie9 no-js" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-transform" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<title><?php if($pid!=0):echo '《'.get_the_title($pid).'》- '.sprintf(__('资源演示%1$s','tinection'),$i); else:echo trim(wp_title('',0)); endif; ?> - <?php bloginfo('name'); ?></title>
<?php if($pid!=0){
	if(get_post_field('post_excerpt',$pid)){$description=get_post_field('post_excerpt',$pid);}else{
		if(preg_match('/<p>(.*)<\/p>/iU',trim(strip_tags(get_post_field('post_content',$pid),"<p>")),$result)){
			$post_content = $result['1'];
		} else {
			$post_content_r = explode("\n",trim(strip_tags(get_post_field('post_content',$pid))));
			$post_content = $post_content_r['0'];
		}
         $description = utf8Substr($post_content,0,220);
	}
	$keywords = "";     
    $tags = wp_get_post_tags($pid);
    foreach ($tags as $tag ) {
        $keywords = $keywords . $tag->name . ",";
    }
}
?>
<meta name="description" content="<?php echo trim($description); ?>" />
<meta name="keywords" content="<?php echo rtrim($keywords,','); ?>" />
<!-- 网站图标 -->
<?php if ( ot_get_option('favicon') ): ?>
<link rel="shortcut icon" href="<?php echo ot_get_option('favicon'); ?>" />
<link rel="icon" href="<?php echo ot_get_option('favicon'); ?>" />
<?php else: ?>
<link rel="shortcut icon" href="favicon.ico" />
<?php endif; ?>
<!-- 引入主题样式表 -->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style.css"  />
<!-- 引入字体样式表-->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/fonts/font-awesome/font-awesome.css"  media="all" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<!-- IE Fix for HTML5 Tags -->
  <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/includes/js/html5.js"></script>
  <![endif]-->
<!-- 引入主题js -->
<?php wp_enqueue_script('tinection'); ?>
<?php wp_localize_script('tinection', 'tin', array('ajax_url' => admin_url('admin-ajax.php'),'tin_url' => get_bloginfo('template_directory'),'Tracker' => tin_tracker_param(),'home' => get_bloginfo('url'))); ?>
</head>
<body id="wrap" <?php body_class(); ?>>
<!-- Float Banner -->
<?php $floatad=ot_get_option('floatad');if (!empty($floatad)) {?>
	<?php echo ot_get_option('floatad');?>
<?php }?>
<!-- /.Float Banner -->
<?php $demos = get_post_meta($pid,'tin_demo',true);$demoarray = explode(',',$demos);if(isset($demoarray[$i-1])){$singledemo = $demoarray[$i-1];}else{$singledemo='';}
	$singledemoarray = explode('|', $singledemo);
	if(!empty($singledemoarray[1])){
?>
<iframe noresize="noresize" frameborder="0" src="<?php echo $singledemoarray[1]; ?>" id="barframe" style="width: 100%;height: 100%;z-index: 3;position: absolute;"></iframe>
<?php } else {echo '未找到相关演示内容，你的访问链接或许无效...';} ?>
<!--<?php if(ot_get_option('statisticcode')) echo ot_get_option('statisticcode'); ?>-->
</body>
</html>