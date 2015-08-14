<?php
/**
 * Includes of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.7
 * @date      2015.3.9
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<div id="focus-us">
<?php _e('关注我们','tinection'); ?>
<div id="focus-slide" class="ie_pie">
	<div class="focus-title">关注我们</div>
	<p class="focus-content">
		<a href="http://weibo.com/<?php echo ot_get_option('tin_sinaweibo'); ?>" target="_blank" class="sinaweibo"><span><i class="fa fa-weibo"></i><?php _e('新浪微博','tinection'); ?></span></a>
		<a href="http://t.qq.com/<?php echo ot_get_option('tin_qqweibo'); ?>" target="_blank" class="sinaweibo"><span><i class="fa fa-tencent-weibo"></i><?php _e('腾讯微博','tinection'); ?></span></a>
	</p>
	<div class="focus-title">联系我们</div>
	<p class="focus-content" style="line-height: 20px;margin-bottom: 10px;">
		<a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ot_get_option('tin_qq'); ?>&site=qq&menu=yes" target="_blank" class="qq"><span><i class="fa fa-qq"></i><?php _e('QQ','tinection'); ?></span></a>
		<a href="<?php echo ot_get_option('tin_qq_mail'); ?>" target="_blank"><span><i class="fa fa-envelope"></i><?php _e('发送邮件','tinection'); ?></span></a>
		<!-- 可删除 -->
		<?php if(ot_get_option('tin_qqgroup')){ ?><a target="_blank" href="<?php echo ot_get_option('tin_qqgroup'); ?>"><i class="fa fa-users">&nbsp;&nbsp;</i>加入QQ群</a><?php } ?>
		<!-- 删除截止 -->
	</p>
	<div class="focus-title">订阅本站<i class="fa fa-rss"></i></div>
	<p class="focus-content">
		<input type="text" name="rss" class="rss" value="<?php bloginfo('rss2_url'); ?>" />
	</p>
	<p class="focus-content">订阅到： <a rel="external nofollow" target="_blank" href="http://xianguo.com/subscribe?url=<?php bloginfo('rss2_url'); ?>">鲜果</a>
		<a rel="external nofollow" target="_blank" href="http://reader.youdao.com/b.do?keyfrom=bookmarklet&amp;url=<?php bloginfo('rss2_url'); ?>">有道</a>
		<a rel="external nofollow" target="_blank" href="http://feedly.com/index.html#subscription%2Ffeed%2F<?php bloginfo('rss2_url'); ?>">Feedly</a></p>
	<form action="http://list.qq.com/cgi-bin/qf_compose_send" target="_blank" method="post">
		<input type="hidden" name="t" value="qf_booked_feedback" />
		<input type="hidden" name="id" value="<?php echo ot_get_option('tin_qqlist'); ?>" />
		<input type="email" name="to" id="to" class="focus-email" placeholder="<?php _e('输入邮箱,订阅本站','tinection'); ?>" required />
		<input type="submit" class="focus-email-submit" value="<?php _e('订阅','tinection'); ?>" />
	</form>

</div>
</div>