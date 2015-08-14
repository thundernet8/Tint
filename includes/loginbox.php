<?php
/**
 * Includes of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.8
 * @date      2015.6.6
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<div id="sign" class="sign">
    <div class="part loginPart">
    <form id="login" action="<?php echo get_option('home'); ?>/wp-login.php" method="post" novalidate="novalidate">
        <?php if(get_option('users_can_register')==1){ ?><div id="register-active" class="switch"><i class="fa fa-toggle-on"></i>切换注册</div><?php } ?>
        <h3>登录<p class="status"></p></h3>
        <p>
            <label class="icon" for="username"><i class="fa fa-user"></i></label>
            <input class="input-control" id="username" type="text" placeholder="请输入用户名" name="username" required="" aria-required="true">
        </p>
        <p>
            <label class="icon" for="password"><i class="fa fa-lock"></i></label>
            <input class="input-control" id="password" type="password" placeholder="请输入密码" name="password" required="" aria-required="true">
        </p>
        <p class="safe">
            <label class="remembermetext" for="rememberme"><input name="rememberme" type="checkbox" checked="checked" id="rememberme" class="rememberme" value="forever">记住我的登录</label>
            <a class="lost" href="<?php echo get_option('home'); ?>/wp-login.php?action=lostpassword"><?php _e('忘记密码 ?','tinection'); ?></a>
        </p>
        <p>
            <input class="submit" type="submit" value="登录" name="submit">
        </p>
        <a class="close"><i class="fa fa-times"></i></a>
        <input type="hidden" id="security" name="security" value="<?php echo  wp_create_nonce( 'security_nonce' );?>">
		<input type="hidden" name="_wp_http_referer" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
	</form>
    <?php if(ot_get_option('tin_open_qq')=='on'||ot_get_option('tin_open_weibo')=='on'||ot_get_option('tin_open_weixin')=='on'){$ons = array(ot_get_option('tin_open_qq'),ot_get_option('tin_open_weibo'),ot_get_option('tin_open_weixin'));$i=0;foreach($ons as $on){if($on=='on')$i++;};$cls=$i==3?'3-col':'2-col'; ?>
    <div class="other-sign">
      <p>您也可以使用第三方帐号快捷登录</p>
	  <?php if(ot_get_option('tin_open_qq')=='on') { ?>
      <div class="<?php echo $cls; ?>"><a class="qqlogin" href="<?php echo home_url('/?connect=qq&action=login&redirect='.urlencode(tin_get_redirect_uri())) ?>"><i class="fa fa-qq"></i><span><?php _e('Q Q 登 录','tinection'); ?></span></a></div>
	  <?php } ?>
	  <?php if(ot_get_option('tin_open_weibo')=='on') { ?>
	  <div class="<?php echo $cls; ?>"><a class="weibologin" href="<?php echo home_url('/?connect=weibo&action=login&redirect='.urlencode(tin_get_redirect_uri())) ?>"><i class="fa fa-weibo"></i><span><?php _e('微 博 登 录','tinection'); ?></span></a></div>
	  <?php } ?>
      <?php if(ot_get_option('tin_open_weixin')=='on') { ?>
      <div class="<?php echo $cls; ?>"><a class="weixinlogin" href="<?php echo home_url('/?connect=weixin&action=login&redirect='.urlencode(tin_get_redirect_uri())) ?>"><i class="fa fa-weixin"></i><span><?php _e('微 信 登 录','tinection'); ?></span></a></div>
      <?php } ?>
    </div>
	<?php } ?>
    </div>
    <div class="part registerPart">
    <form id="register" action="<?php bloginfo('url'); ?>/wp-login.php?action=register" method="post" novalidate="novalidate">
        <div id="login-active" class="switch"><i class="fa fa-toggle-off"></i>切换登录</div>
        <h3>注册<p class="status"></p></h3>    
        <p>
            <label class="icon" for="user_name"><i class="fa fa-user"></i></label>
            <input class="input-control" id="user_name" type="text" name="user_name" placeholder="输入英文用户名" required="" aria-required="true">
        </p>
        <p>
            <label class="icon" for="user_email"><i class="fa fa-envelope"></i></label>
            <input class="input-control" id="user_email" type="email" name="user_email" placeholder="输入常用邮箱" required="" aria-required="true">
        </p>
        <p>
            <label class="icon" for="user_pass"><i class="fa fa-lock"></i></label>
            <input class="input-control" id="user_pass" type="password" name="user_pass" placeholder="密码最小长度为6" required="" aria-required="true">
        </p>
        <p>
            <label class="icon" for="user_pass2"><i class="fa fa-retweet"></i></label>
            <input class="input-control" type="password" id="user_pass2" name="user_pass2" placeholder="再次输入密码" required="" aria-required="true">
        </p>
        <p id="captcha_inline">
            <input class="input-control inline" type="text" id="tin_captcha" name="tin_captcha" placeholder="输入验证码" required>
            <img src="<?php echo THEME_URI.'/images/captcha-clk.png'; ?>" class="captcha_img inline" title="点击刷新验证码">
            <input class="submit inline" type="submit" value="注册" name="submit">
        </p>
        <a class="close"><i class="fa fa-times"></i></a>  
        <input type="hidden" id="user_security" name="user_security" value="<?php echo  wp_create_nonce( 'user_security_nonce' );?>"><input type="hidden" name="_wp_http_referer" value="<?php echo $_SERVER['REQUEST_URI']; ?>"> 
    </form>
    </div>
    <div class="clear"></div>
</div>