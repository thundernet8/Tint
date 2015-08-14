<!DOCTYPE html>
<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.0.0
 * @date      2014.11.25
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
<div class="main">
    <div class="holmes-bear-wrap">&nbsp;</div>
    <div class="error-wrap">
        <div class="error-text-title-wrap clearfix"><div class="error-number">404，</div><div class="error-text-title"></div></div>
        <p class="error-text-content">您所查找的页面不存在</p>
        <ul class="handle-way-list">
            <li class="handle-way-item">1.您可以<a href="javascript:history.go(-1);">返回上一个页面</a></li>
            <li class="handle-way-item">2.您可以<a href="<?php bloginfo('url'); ?>">回到首页</a></li>
			<li class="handle-way-item">3.您可以尝试下方搜索</li>
        </ul>
    </div>
	<div class="error-search">
		<form method="get" class="searchform themeform" action="<?php echo home_url('/'); ?>">
			<input type="text" class="search" name="s" placeholder="Search.." maxlength="20" required="required" />
			<button name="submit" type="submit" id="submit">搜索</button>
		</form>
	</div>
</div>
<!--/.Main Wrap -->
<div class="footer">
<!-- Copyright -->
	<div id="footer-copyright">&copy;<?php echo date(' Y '); ?>
	<?php if(ot_get_option('copyright')) echo ot_get_option('copyright'); ?>&nbsp;|&nbsp;Theme by&nbsp;
		<a href="http://www.zhiyanblog.com/tinection.html"  target="_blank">Tinection</a>.
	</div>
<!-- /.Copyright -->
</div>
<!-- Bottom Banner -->
<?php $bottomad=ot_get_option('bottomad');if (!empty($bottomad)) {?>
<div id="bottom-banner">
	<div class="container">
		<?php echo ot_get_option('bottomad');?>
	</div>
</div>
<?php } ?>
<!-- /.Bottom Banner -->
<?php get_footer(); ?>