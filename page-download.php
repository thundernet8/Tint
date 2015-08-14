<?php
/*
Template Name: 下载页面
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
<?php if(isset($_GET['pid'])):$pid = $_GET['pid'];else:$pid = 0;endif; ?>
<?php $uid = get_current_user_id(); ?>
<?php get_header(); ?>
<?php //get_template_part( 'includes/breadcrumbs');?>
<!-- Header Banner -->
<?php $headerad=ot_get_option('headerad');if (!empty($headerad)) {?>
<div id="header-banner" class="banner">
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
		<?php if($pid!=0){
			$post = get_post($pid);
		?>
		<div class="downtop">
			<div class="dl-article-title">
				<a href="<?php echo $post->guid; ?>" title="<?php echo $post->post_title; ?>" target="_blank"><?php echo sprintf(__('去%1$s看看关于『 %2$s 』的详细介绍文章>>','tinection'),get_bloginfo('name'),$post->post_title); ?></a>
			</div>
			<div class="declaration">
			<p><?php _e('本站所刊载内容均为网络上收集整理，包括但不限于代码、应用程序、影音资源、电子书籍资料等，并且以研究交流为目的，所有仅供大家参考、学习，不存在任何商业目的与商业用途。若您使用开源的软件代码，请遵守相应的开源许可规范和精神，若您需要使用非免费的软件或服务，您应当购买正版授权并合法使用。如果你下载此文件，表示您同意只将此文件用于参考、学习使用而非任何其他用途。','tinection'); ?>
			</p>
			</div>
		</div>
		<?php $singletopad=ot_get_option('singletopad');if (!empty($singletopad)) {?>
		<div id="singletop-banner" class="banner">
			<?php echo ot_get_option('singletopad');?>
		</div>
		<?php }?>
		<div class="downmid">
			<div class="downld">
				<div class="downld-meta">
					<a><?php _e('文件列表  ','tinection'); ?></a>
					<span class="downld-meta-hot"><?php _e('|  热度： ','tinection'); ?><?php echo get_tin_traffic( 'single' , $pid ); ?>&nbsp;℃&nbsp;&nbsp;|</span>
					<span class="downld-meta-date"><?php _e('  生产日期： ','tinection'); ?><?php echo $post->post_date; ?></span>
				</div>
				<div class="downldlinks sg-dl">
					<div class="downldlinks-inner" pid="<?php echo $pid; ?>" uid = "<?php echo $uid; ?>">
						<?php tin_dl_page_res_inner($pid,$uid); ?>
					</div>
					<p style="color:#f00;margin-top:20px;"><?php _e('如果您暂时不需或无法下载，您也可以邮件发送下载链接(收费资源除外)：','tinection'); ?></p>
					<div class="down-mail">
						<span class="dl-mail" pid="<?php echo $post->ID; ?>">
							<input type="text" class="mail-dl" placeholder="<?php _e('你的邮件地址','tinection'); ?>" />
							<button type="button" class="mail-dl-btn"><?php _e('下 载','tinection'); ?></button>
						</span>
						<div class="dl-terms">
							<p class="dl-msg"></p>
							<input type="checkbox" name="dl-terms" id="dl-terms-chk" /><?php _e('我同意','tinection'); ?>&nbsp;<a href="<?php bloginfo('url'); echo'/copyright'; ?>" title="" target="_blank"><?php _e('本站条款','tinection'); ?></a><?php _e('并愿意接收包含最新文章的订阅邮件。','tinection'); ?>
							<div class="dl-terms-des"></div>
						</div>		
					</div>
				</div>
			</div>
			<div class="downmid-ad">
				<div class="downmid-ad-top">
					<span><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ot_get_option('tin_qq');?>&site=qq&menu=yes" title="<?php _e('联系站长','tinection'); ?>"><?php _e('联系站长','tinection'); ?></a>&nbsp;&nbsp;
					<span>|&nbsp;&nbsp;<a href="<?php echo get_bloginfo('url')."/".ot_get_option('page_newsletter','newsletter').'?action=subscribe'; ?>" rel="no-follow" title="<?php _e('订阅','tinection'); ?><?php bloginfo('name'); ?><?php _e('最新文章','tinection'); ?>"><?php _e('订阅本站','tinection'); ?></a>&nbsp;&nbsp;&nbsp;|</span>
					<span>&nbsp;&nbsp;<a href="http://www.zhiyanblog.com/go/aliyun" title="<?php _e('快速、稳定阿里云主机推荐','tinection'); ?>" target="_blank"><?php _e('使用阿里云主机','tinection'); ?></a>&nbsp;&nbsp;&nbsp;|</span>
					<span>&nbsp;&nbsp;<a href="http://www.zhiyanblog.com/go/qiniu" title="<?php _e('七牛云存储加速网站','tinection'); ?>" target="_blank"><?php _e('用七牛加速网站','tinection'); ?></a></span>
				</div>
				<div class="downmid-ad-btm">
				<!-- ad 250x250 -->
				<?php $dlad1=ot_get_option('dlad1');if (!empty($dlad1)) {echo ot_get_option('dlad1');}?>
				<!-- /.ad 250x250 -->
				</div>
			</div>
			<div class="clr clear"></div>
		</div>
		<?php } else {?>
		<div class="downtop">
			<div class="dl-article-title">
				<p><?php _e('未找到相关下载资源，您访问的链接可能有误！','tinection'); ?></p>
				<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>" target="_blank"><?php echo sprintf(__('去%1$s看看最新文章或者尝试搜索功能','tinection'),get_bloginfo('name')); ?></a>
			</div>
			<div class="declaration">
			<p><?php _e('本站所刊载内容均为网络上收集整理，包括但不限于代码、应用程序、影音资源、电子书籍资料等，并且以研究交流为目的，所有仅供大家参考、学习，不存在任何商业目的与商业用途。若您使用开源的软件代码，请遵守相应的开源许可规范和精神，若您需要使用非免费的软件或服务，您应当购买正版授权并合法使用。如果你下载此文件，表示您同意只将此文件用于参考、学习使用而非任何其他用途。','tinection'); ?>
			</p>
			</div>
		</div>


		<?php } ?>
		<div id="singletop-banner" class="banner">
		<!-- Ad 760 x 90 -->
		<?php $dlad2=ot_get_option('dlad2');if (!empty($dlad2)) {echo ot_get_option('dlad2');}?>
		<!-- Ad end-->
	
		</div>
		<div class="downbtm">
			<div class="use-des">
			<p><?php _e('如果您发现本文件已经失效不能下载，请联系站长修正！','tinection'); ?></p>
			<p><?php _e('本站提供的资源多数为百度网盘下载，对于大文件，你需要安装百度云客户端才能下载！','tinection'); ?></p>
			<p><?php _e('部分文件引用的官方或者非网盘类他站下载链接，你可能需要使用迅雷、BT等下载工具下载！','tinection'); ?></p>
			<p><?php _e('本站推荐的资源均经由站长检测或者个人发布，不包含恶意软件病毒代码等，如果你发现此类问题，请向站长举报！','tinection'); ?></p>
			<p><?php _e('本站仅提供文件的免费下载服务，如果你对代码程序软件的使用有任何疑惑，请留意相关网站论坛。对于本站个人发布的资源，站长会提供有限的帮助！','tinection'); ?></p>
			</div>
			<div class="downbtm-ad">
				<div class="downbtm-ad-left banner">
				<!-- ad 250x250 -->
				<?php $dlad3=ot_get_option('dlad3');if (!empty($dlad3)) {echo ot_get_option('dlad3');}?>
				<!-- /.ad 250x250 -->
				</div>
				<div class="downbtm-ad-right banner">
				<!-- ad 250x250 -->
				<?php $dlad4=ot_get_option('dlad4');if (!empty($dlad4)) {echo ot_get_option('dlad4');}?>
				<!-- /.ad 250x250 -->
				</div>
			</div>
		</div>		
		<?php $singlebottomad=ot_get_option('singlebottompad');if (!empty($singlebottomad)) {?>
		<div id="singlebottom-banner" class="banner">
			<?php echo ot_get_option('singlebottomad');?>
		</div>
		<?php }?>
		</div>
		<!-- /.Content -->
		</div>
		<!-- Sidebar -->
		<script type="text/javascript">
			$('.site_loading').animate({'width':'55%'},50);  //第二个节点
		</script>
		<?php if(tin_is_mobile()) { ?>
		<div id="sidebar" class="clr"></div>
		<?php } else { ?>
		<div id="sidebar" class="clr">
		<?php dynamic_sidebar(ot_get_option('s1-download','primary')); ?>
			<div class="floatwidget-container">
			</div>
		</div>
		<?php } ?>
		<script type="text/javascript">
			$('.site_loading').animate({'width':'78%'},50);  //第三个节点
		</script>		
		<!-- /.Sidebar -->
	</div>
</div>
<!--/.Main Wrap -->
<!-- Bottom Banner -->
<?php $bottomad=ot_get_option('bottomad');if (!empty($bottomad)) {?>
<div id="bottom-banner">
	<div class="container">
		<?php echo ot_get_option('bottomad');?>
	</div>
</div>
<?php }else{?>
<div style="height:50px;"></div>
<?php }?>
<!-- /.Bottom Banner -->
<?php if(ot_get_option('footer-widgets-singlerow') == 'on'){?>
<div id="ft-wg-sr">
	<div class="container">
	<?php dynamic_sidebar( 'footer-row'); ?>
	</div>
</div>
<?php }?>
<div class="buy-pop-out tinalert">
	<div class="buy-pop-title alert_title"><h4><?php _e('资源购买','tinection'); ?></h4></div>
	<div class="buy-des alert_content">
		<p><?php _e('确定要购买该资源吗？','tinection'); ?></p>
		<p><?php _e('这将花费你','tinection'); ?><span class="dl-price"> </span><?php _e('积分，你当前的积分为: ','tinection'); ?><span class="all-credits"> </span></p>
		<p class="saledl-msg"></p>
	</div>
	<p class="confirm-buy alert_cancel"><button class="cancel-to-back btn btn-warning"><?php _e('取消','tinection'); ?></button></p>
	<span class="buy-close alert_close"><i class="fa fa-close"></i></span>
</div>
<?php get_footer('simple'); ?>