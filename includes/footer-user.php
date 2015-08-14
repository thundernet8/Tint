<?php
/**
 * Includes of Tinection WordPress Theme
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
<!--  links -->
<div id="footer-links-icons">
	<span class="footer-wordpress-link">
		<a href="http://wordpress.org" target="_blank" class="wordpress">
			<span class="tinicon-wordpress"><i class="fa fa-wordpress"></i></span>
			<br>WordPress
		</a>
	</span>
	<span class="footer-aliyun-link">
		<a href="http://www.zhiyanblog.com/go/aliyun" target="_blank" class="aliyun">
			<span class="tinicon-aliyun"><i class="fa fa-cloud"></i></span>
			<br>Aliyun
		</a>
	</span>
	<!--span class="footer-qiniu-link">
		<a href="http://www.zhiyanblog.com/go/qiniu" target="_blank" class="qiniu">
			<span class="tinicon-qiniu"></span>
			<br>Qiniu
		</a>
	</span-->
	<?php if(ot_get_option('tin_sinaweibo')){ ?>
	<span class="footer-sinaweibo-link">
		<a href="http://weibo.com/<?php echo ot_get_option('tin_sinaweibo'); ?>" target="_blank" class="sinaweibo">
			<span class="tinicon-sinaweibo"><i class="fa fa-weibo"></i></span>
			<br>Weibo
		</a>
	</span>
	<?php } ?> 
	<?php if(ot_get_option('tin_qq')){ ?>
	<span class="footer-qq-link">
		<a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ot_get_option('tin_qq'); ?>&site=qq&menu=yes" target="_blank" class="qq">
			<span class="tinicon-qq"><i class="fa fa-qq"></i></span>
			<br>QQ
		</a>
	</span>
	<?php } ?> 
	<span class="footer-rss-link">
		<a href="<?php bloginfo('rss2_url'); ?>" target="_blank" class="rss">
			<span class="tinicon-rss"><i class="fa fa-rss"></i></span>
			<br>RSS
		</a>
	</span>
	<?php if(ot_get_option('page_newsletter')&&ot_get_option('newsletter')=='on'){ ?>
	<span class="footer-newsletter-link">
		<a href="<?php echo get_bloginfo('url').'/'.ot_get_option('page_newsletter','newsletter'); ?>" target="_blank" class="newsletter">
			<span class="tinicon-newsletter"><i class="fa fa-envelope"></i></span>
			<br>Newsletter
		</a>
	</span>
	<?php } ?> 
</div>
<!-- /.links -->
<div class="clear clr"></div>