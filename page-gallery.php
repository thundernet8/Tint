<?php
/*
template name: 文章相册
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
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-transform" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!-- 引入页面描述和关键字模板 -->
<title>Gallery - <?php bloginfo('name'); ?></title>
<meta name="description" content="<?php bloginfo('name'); ?><?php _e('文章缩略图相册','tinection'); ?>">
<meta name="keywords" content="<?php _e('Gallery,相册,缩略图,','tinection'); ?><?php bloginfo('name'); ?>">
<!-- 网站图标 -->
<?php if ( ot_get_option('favicon') ): ?>
<link rel="shortcut icon" href="<?php echo ot_get_option('favicon'); ?>" />
<link rel="icon" href="<?php echo ot_get_option('favicon'); ?>" />
<!-- <link rel="shortcut icon" href="favicon.ico" /> -->
<?php endif; ?>
<link rel="shortcut icon" href="favicon.ico" />
<!-- 禁止浏览器初始缩放 -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!-- 引入主题样式表 -->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style.css"  />
<!-- 引入主题响应式样式表-->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/includes/css/responsive.css"  />
<!-- 引入相册样式表-->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/includes/css/sgallery.css"  />
<!-- 引入字体样式表-->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/fonts/font-awesome/font-awesome.css"  media="all" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<!-- 引入jquery -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/jquery.min.js"></script>
<!-- IE Fix for HTML5 Tags -->
  <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/includes/js/html5.js"></script>
  <![endif]-->
<?php wp_head(); ?>
</head>
<body style="background:#111;color:#fff;">
<h1 style="margin: 40px; font: 32px Microsoft Yahei; text-align: center;color:#fff;"><?php bloginfo('name'); ?> - Gallery</h1>
<?php wp_reset_query(); ?>
<?php $query1 = new WP_Query('meta_key=_thumbnail_id&showposts=-1&posts_per_page=-1&ignore_sticky_posts=1');
      $postnum = $query1->post_count;
      wp_reset_postdata();
?>
<div id="gallery-container">
	<ul class="items--small">
<?php
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $arr = array('meta_key' => '_thumbnail_id',
                'showposts' => 12,        // 显示5个特色图像
                'posts_per_page' => 2,   // 显示5个特色图像
                'paged' => $paged,
                'orderby' => 'date',     // 按发布时间先后顺序获取特色图像，可选：'title'、'rand'、'comment_count'等
                'ignore_sticky_posts' => 1,
                'order' => 'DESC');
    $slideshow = new WP_Query($arr);
    if ($slideshow->have_posts()) {
        $postCount = 0;
        while ($slideshow->have_posts()) {
            $slideshow->the_post();
?>
<?php $timthumb_src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()),'large'); ?>
		<li class="item"><a href="#"><img src="<?php bloginfo('template_url');?><?php echo '/functions/timthumb.php?src=';?><?php echo $timthumb_src[0]; ?><?php echo '&q=90&w=240&h=160&zc=1';?>" alt="" title="<?php the_title(); ?>" /></a></li>
<?php } } ?>
	</ul>

<?php if(empty($paged))$paged = 1;
    $prev = $paged - 1;   
    $next = $paged + 1;   
    $range = 2; // only edit this if you want to show more page-links
    $showitems = ($range * 2)+1; 
    $pages = ceil($postnum/$arr['showposts']); 
    if(1 != $pages){
        echo "<div class='gpagination'>";   
        echo ($paged > 2 && $paged+$range+1 > $pages && $showitems < $pages)? "<a href='".get_pagenum_link(1)."'>".__('最前','tinection')."</a>":"";   
        echo ($paged > 1 && $showitems < $pages)? "<a href='".get_pagenum_link($prev)."'>".__('上一页','tinection')."</a>":"";
            for ($i=1; $i <= $pages; $i++){   
                if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){   
                    echo ($paged == $i)? "<span class='gcurrent'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='ginactive' >".$i."</a>";   
                }   
            }   
        echo ($paged < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($next)."'>".__('下一页','tinection')."</a>" :"";   
        echo ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($pages)."'>".__('最后','tinection')."</a>":"";   
        echo "</div>\n";   
    }   
?>
	<ul class="items--big">
<?php wp_reset_postdata(); ?>
<?php 
	$slideshow = new WP_Query($arr);
	if ($slideshow->have_posts()) {
        $postCount = 0;
        while ($slideshow->have_posts()) {
            $slideshow->the_post();
?>
<?php $timthumb_src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()),'large'); ?>
		<li class="item--big">
			<figure><img src="<?php echo $timthumb_src[0]; ?>" title="<?php the_title(); ?>" alt="" />
				<a href="<?php the_permalink(); ?>"  title="<?php the_title(); ?>" target="_blank"><figcaption class="img-caption"><?php the_title(); ?></figcaption></a>
			</figure>
		</li>
<?php } } ?>
	</ul>
	<div class="controls">
		<span class="control icon-arrow-left" data-direction="previous"></span>
		<span class="control icon-arrow-right" data-direction="next"></span>
		<span class="grid icon-grid"></span>
		<span class="fs-toggle icon-fullscreen"></span>
	</div>
</div>

<?php
    wp_reset_postdata();
?>
<p class="vad">
	<a href="<?php bloginfo('url'); ?>"  target="_blank" title="返回首页"><?php _e('返回 ','tinection'); ?><?php bloginfo('name'); ?></a>
	<a href="<?php bloginfo('url'); ?>/archives" target="_blank" title="<?php _e('文章归档','tinection'); ?>"><?php _e('文章归档','tinection'); ?></a>
</p>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/sgallery-plugins.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/sgallery.js"></script>
<script>
$(function(){
	$('#gallery-container').sGallery({
		fullScreenEnabled: true
	});
});
</script>
<script type="text/javascript">
/* <![CDATA[ */
var tin = {"ajax_url":"<?php echo admin_url( '/admin-ajax.php' ); ?>","tin_url":"<?php echo get_bloginfo('template_directory'); ?>","Tracker":<?php echo json_encode(tin_tracker_param()); ?>,"home":"<?php echo get_bloginfo('url'); ?>"};
/* ]]> */
</script>
<?php get_footer('simple'); ?>