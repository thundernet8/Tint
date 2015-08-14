<?php
/**
 * Includes of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.4
 * @date      2015.1.21
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<div class="floatbtn">

<!-- Comment -->
<?php if ( is_singular()&&comments_open() ){ ?>
<span class="commentbtn mobile-hide"><i class="fa fa-comments"></i></span>
<?php } ?>
<!-- /.Comment -->

<!-- Share -->
<span id="bdshare" class="bdshare_t mobile-hide"><a class="bds_more" href="#" data-cmd="more"></a></span>
<!-- /.Share -->

<!-- QR -->
<span id="qr" class="mobile-hide"><i class="fa fa-qrcode"></i>
	<div id="floatbtn-qr">
		<div id="floatbtn-qr-msg"><?php _e('扫一扫二维码分享','tinection'); ?></div>
	</div>
</span>
<!-- /.QR -->

<!-- Simplified or Traditional -->
<span id="zh-cn-tw" class="mobile-hide"><i><a id="StranLink"><?php _e('繁','tinection'); ?></a></i></span>
<!-- /.Simplified or Traditional -->

<!-- Layout Switch -->
<?php $layout=the_layout(); if(is_home()&&$layout=='blog'){?>
<span id="layoutswt" class="mobile-hide">
		<i class="fa fa-th is_blog" src="<?php echo get_bloginfo('url'); ?>"></i>
</span>
<?php } elseif(is_home()&&$layout=='cms'){?>
<span id="layoutswt" class="mobile-hide">
		<i class="fa fa-th-large is_cms" src="<?php echo get_bloginfo('url'); ?>"></i>
</span>
<?php } elseif(is_home()){?>
<span id="layoutswt" class="mobile-hide">
		<i class="fa fa-th-list is_blocks" src="<?php echo get_bloginfo('url'); ?>"></i>
</span>
<?php }?>
<!-- /.Layout Switch -->

<!-- Back to Home -->
<?php if(!is_home()){ ?>
<span id="back-to-home" class="mobile-hide">
		<a href="<?php echo get_bloginfo('url'); ?>"><i class="fa fa-home"></i></a>
</span>
<?php } ?>
<!-- /.Back to Home -->
<!-- Scroll Top -->
<span id="back-to-top"><i class="fa fa-arrow-up"></i></span>
<!-- /.Scroll Top -->

</div>