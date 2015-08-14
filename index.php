<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.7
 * @date      2015.3.11
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<?php get_header(); ?>
<?php //get_template_part( 'includes/breadcrumbs');?>
<?php $thelayout = the_layout(); ?>
<!-- Main Wrap -->
<div id="main-wrap">
	<div id="sitenews-wrap" class="container"><?php get_template_part('includes/sitenews'); ?></div>
	<?php if (ot_get_option('openslider')=='on') {$slider = (ot_get_option('slider_style')=='no_full') ? 'slider-nar' : 'slider'; get_template_part( 'includes/'.$slider );} ?>
<!-- Header Banner -->
<?php $headerad=ot_get_option('headerad');if (!empty($headerad)) {?>
<div id="header-banner" class="banner">
	<div class="container">
		<?php echo ot_get_option('headerad');?>
	</div>
</div>
<?php }?>
<!-- /.Header Banner -->
	<!-- CMS Layout -->
	<?php if($thelayout == 'cms'){get_template_part('includes/index-cms'); ?>
	<!-- Blocks Layout -->
	<?php }elseif($thelayout == 'blocks'){get_template_part('includes/index-blocks'); ?>
	<!-- Blog Layout -->
	<?php }else{get_template_part('includes/index-blog');} ?>
</div>
<!--/.Main Wrap -->
<!-- Bottom Banner -->
<?php $bottomad=ot_get_option('bottomad');if (!empty($bottomad)) {?>
<div id="bottom-banner" class="banner">
	<div class="container">
		<?php echo ot_get_option('bottomad');?>
	</div>
</div>
<?php }else{?>
<div style="height:20px;"></div>
<?php }?>
<!-- /.Bottom Banner -->
<?php if(ot_get_option('footer-widgets-singlerow') == 'on'){?>
<div id="ft-wg-sr">
	<div class="container">
	<?php dynamic_sidebar( 'footer-row'); ?>
	</div>
</div>
<?php }?>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>