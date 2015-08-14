<?php
/**
 * Includes of Tinection WordPress Theme
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
<?php
	$dlinks = get_post_meta($post->ID,'tin_dload',true);
	$dlmail = get_post_meta($post->ID,'tin_dlmail',true);
	$demos = get_post_meta($post->ID,'tin_demo',true);
	$saledl = get_post_meta($post->ID,'tin_saledl',true);
?>
<?php
	if((!empty($dlinks) || !empty($saledl)) && !empty($demos)){
        	echo '<h2 id="title-last">'.__('演示与下载','tinection').'</h2>';
        }
    if((!empty($dlinks) || !empty($saledl)) && empty($demos)){
        	echo '<h2 id="title-last">'.__('相关下载','tinection').'</h2>';
        }
    if(empty($dlinks) && empty($saledl) && !empty($demos)){
        	echo '<h2 id="title-last">'.__('相关演示','tinection').'</h2>';
  		}
?>
<?php if(!empty($dlinks)||!empty($demos)||!empty($saledl)){ ?>
<div class="sg-dl">
	<span class="sg-dl-span">
<?php } ?>
<?php
	if(!empty($demos)){ ?>
		<?php $demoarray = explode(',',$demos); $i=0; foreach($demoarray as $demo){ $i++;?>
		<span class="demo">
			<?php $singledemoarray = explode('|', $demo); ?>
			<?php $s1 = isset($singledemoarray[0]) ? $singledemoarray[0] : '';
				  $s2 = isset($singledemoarray[1]) ? $singledemoarray[1] : '';
			?>
			<?php $demosuffix = ot_get_option('page_demo','demo'); if(stripos($demosuffix,'?')===false){$demopage=get_bloginfo('url').'/'.$demosuffix.'?id='.$post->ID.'_'.$i;}else{$demopage=get_bloginfo('url').'/'.$demosuffix.'&id='.$post->ID.'_'.$i;} ?>
			<a href="<?php echo $demopage; ?>" title="<?php if(!empty($s1)){echo $s1;}else{echo __('演示','tinection');} ?>" target="_blank"><button type="button" class="btn btn-demo btn-lg"><?php if(!empty($s1)){echo $s1;}else{echo __('演示','tinection');} ?></button></a>
		</span>
		<?php }?>					
	<?php } ?>
	<?php if($dlmail==1&&!empty($dlinks)){ ?>
		<span class="dl-mail" pid="<?php echo $post->ID; ?>">
			<input type="text" class="mail-dl" placeholder="<?php _e('你的邮件地址','tinection'); ?>" />
			<button type="button" class="mail-dl-btn"><?php _e('下 载','tinection'); ?></button>
		</span>
	<?php } ?>
	<?php if($dlmail==0||empty($dlmail)||$dlmail==1&&!empty($saledl)){ ?>
		<?php if(!empty($dlinks)||!empty($saledl)): ?>
		<span class="dl-link">
			<?php $dlsuffix = ot_get_option('page_dl','dl'); if(stripos($dlsuffix,'?')===false){$dlpage=get_bloginfo('url').'/'.$dlsuffix.'?pid='.$post->ID;}else{$dlpage=get_bloginfo('url').'/'.$dlsuffix.'&pid='.$post->ID;} ?>
			<a href="<?php echo $dlpage ;?>" title="<?php _e('文件下载','tinection'); ?>" target="_blank"><button type="button" class="btn btn-download btn-lg"><?php _e('下载','tinection'); ?></button></a>
		</span>
		<?php endif; ?>
	<?php } ?>
	</span>
	<?php if($dlmail==1&&!empty($dlinks)){ ?>
	<div class="dl-terms">
		<input type="checkbox" name="dl-terms" id="dl-terms-chk" /><?php _e(' 我同意','tinection'); ?>&nbsp;<a href="<?php bloginfo('url'); echo'/copyright'; ?>" title="Copyright" target="_blank"><?php _e('本站条款','tinection'); ?></a><?php _e('并愿意接收包含最新文章的订阅邮件。','tinection'); ?>
		<p class="dl-msg"></p>
		<div class="dl-terms-des"></div>
	</div>
	<?php } ?>
<?php if(!empty($dlinks)||!empty($demos)||!empty($saledl)){ ?>
</div>
<?php } ?>