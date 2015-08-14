<?php
/**
 * Functions of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.7
 * @date      2015.3.6
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

/**
 *  添加面板到文章（页面）编辑页
 */
function tin_add_metabox() {

	$screens = array( 'post', 'page' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'tin_dload_metabox',
			__( '演示,普通与收费下载', 'tinection' ),
			'tin_meta_box_callback',
			$screen,
			'normal','high'
		);
		add_meta_box(
			'tin_video_url',
			__( '文章特色视频', 'tinection' ),
			'tin_video_url_callback',
			'post',
			'side','low'
		);
		add_meta_box(
			'tin_single_thumb_url',
			__( '文章内页顶部特色图跳转链接', 'tinection' ),
			'tin_single_thumb_url_callback',
			$screen,
			'side','low'
		);
		add_meta_box(
			'tin_copyright_content',
			__( '文章内容底部版权信息', 'tinection' ),
			'tin_copyright_content_callback',
			$screen,
			'normal','high'
		);
	}
		add_meta_box(
			'tin_keywords_description',
			__( '页面关键词与描述', 'tinection' ),
			'tin_keywords_description_callback',
			'page',
			'normal','high'
		);
		add_meta_box(
			'tin_product_info',
			__( '商品信息', 'tinection' ),
			'tin_product_info_callback',
			'store',
			'normal','high'
		);
		
}
add_action( 'add_meta_boxes', 'tin_add_metabox' );

/**
 * 输出面板
 * 
 * @param WP_Post $post 当前文章（页面）对象
 */
function tin_meta_box_callback( $post ) {

	// 添加安全字段验证
	wp_nonce_field( 'tin_meta_box', 'tin_meta_box_nonce' );

//普通下载资源	 
$dl = get_post_meta( $post->ID, 'tin_dload', true );
//演示资源
$dm = get_post_meta( $post->ID, 'tin_demo', true );
//是否通过邮件发送普通下载资源
$md = get_post_meta( $post->ID, 'tin_dlmail', true );
//积分下载资源
$sd = get_post_meta( $post->ID, 'tin_saledl', true );

$dload = $dl ? $dl : '';
$demo = $dm ? $dm : '';
$ifdlmail = is_numeric($md) ? (int)$md : 0;
$saledl = $sd ? $sd : '';

?>
<p><?php _e( '普通下载资源下载方式', 'tinection' );?></p>
<p>
	<select name="tin_dlmail">
		<option value="0" <?php if( $ifdlmail!==1) echo 'selected="selected"';?>><?php _e( '直接下载', 'tinection' );?></option>
		<option value="1" <?php if( $ifdlmail===1) echo 'selected="selected"';?>><?php _e( '邮件下载', 'tinection' );?></option>
	</select>
</p>
<p><?php _e( '普通下载资源，格式为 资源1名称|资源1url|下载密码,资源2名称|资源2url|下载密码 资源名称与url用|隔开，不同资源用英文逗号隔开，url请添加http://头，如提供百度网盘加密下载可以填写密码，也可以留空。如果开启邮件下载，将不显示直接下载按钮，而显示邮件输入框，用户提供邮箱，系统发送下载链接至该邮箱', 'tinection' );?></p>
<textarea name="tin_dload" rows="5" cols="50" class="large-text code"><?php echo stripcslashes(htmlspecialchars_decode($dl));?></textarea>
<p><?php _e( '演示资源链接，格式为 演示1名称|演示1url,演示2名称|演示2url 演示名称与url用|隔开，不同演示用英文逗号隔开,url请添加http://头', 'tinection' );?></p>
<textarea name="tin_demo" rows="5" cols="50" class="large-text code"><?php echo stripcslashes(htmlspecialchars_decode($dm));?></textarea>
<p><?php _e( '积分下载资源，格式为 资源1名称|资源1url|资源1价格|下载密码,资源2名称|资源2url|资源2价格|下载密码 资源名称与url以及价格、下载密码用|隔开，不同资源用英文逗号隔开', 'tinection' );?></p>
<textarea name="tin_saledl" rows="5" cols="50" class="large-text code"><?php echo stripcslashes(htmlspecialchars_decode($sd));?></textarea>

<?php
}

function tin_video_url_callback($post){
	$video = get_post_meta( $post->ID, 'tin_video_url', true );
?>
<p><?php _e( '文章特色视频,例如优酷视频的flash地址', 'tinection' );?></p>
<textarea name="tin_video_url" rows="1" class="large-text code"><?php echo stripcslashes(htmlspecialchars_decode($video));?></textarea>
<?php
}

function tin_single_thumb_url_callback($post){
	$url = get_post_meta( $post->ID, 'tin_thumb_url', true );
	$url = explode('|',$url);
	$link = isset($url[0]) ? $url[0]:'';
	$title = isset($url[1]) ? $url[1]:'';
?>
<p><?php _e( '链接URL，带http://', 'tinection' );?></p>
<textarea name="tin_thumb_link" rows="1" class="large-text code"><?php echo stripcslashes(htmlspecialchars_decode($link));?></textarea>
<p><?php _e( '链接标题', 'tinection' );?></p>
<textarea name="tin_thumb_title" rows="1" class="large-text code"><?php echo stripcslashes(htmlspecialchars_decode($title));?></textarea>
<?php
}

function tin_copyright_content_callback($post){
	$cc = get_post_meta( $post->ID, 'tin_copyright_content', true );
	$cc = empty($cc) ? ot_get_option('tin_copyright_content_default') : $cc;
?>
<p><?php _e( '版权信息，其中{link}代表文章链接，{title}代表文章标题，{url}代表本站首页地址，{name}代表本站名称，文章输出后会自动替换', 'tinection' );?></p>
<textarea name="tin_copyright_content" rows="5" class="large-text code"><?php echo stripcslashes(htmlspecialchars_decode($cc));?></textarea>

<?php
}

function tin_keywords_description_callback($post){
	$keywords = get_post_meta( $post->ID, 'keywords', true );
	$description = get_post_meta($post->ID, "description", true);
?>
<p><?php _e( '页面关键词', 'tinection' );?></p>
<textarea name="tin_keywords" rows="2" class="large-text code"><?php echo stripcslashes(htmlspecialchars_decode($keywords));?></textarea>
<p><?php _e( '页面描述', 'tinection' );?></p>
<textarea name="tin_description" rows="5" class="large-text code"><?php echo stripcslashes(htmlspecialchars_decode($description));?></textarea>

<?php
}

function tin_product_info_callback($post){
	// 添加安全字段验证
	wp_nonce_field( 'tin_meta_box', 'tin_meta_box_nonce' );
	$currency = get_post_meta($post->ID,'pay_currency',true);
	$price = get_post_meta($post->ID,'product_price',true);
	$amount = get_post_meta($post->ID,'product_amount',true);
	$vip_discount = json_decode(get_post_meta($post->ID,'product_vip_discount',true),true);
	$vip_discount = empty($vip_discount)?1:$vip_discount;
	$vip_discount1 = isset($vip_discount['product_vip1_discount'])?$vip_discount['product_vip1_discount']:1;
	$vip_discount2 = isset($vip_discount['product_vip2_discount'])?$vip_discount['product_vip2_discount']:1;
	$vip_discount3 = isset($vip_discount['product_vip3_discount'])?$vip_discount['product_vip3_discount']:1;
	$promote_code_support = get_post_meta($post->ID,'product_promote_code_support',true) ? (int)get_post_meta($post->ID,'product_promote_code_support',true) : 0;
	$promote_discount = get_post_meta($post->ID,'product_promote_discount',true);
	$promote_discount = empty($promote_discount) ? 1 : $promote_discount;;
	$discount_begin_date = get_post_meta($post->ID,'product_discount_begin_date',true);
	$discount_period = get_post_meta($post->ID,'product_discount_period',true);
	$download_links = get_post_meta($post->ID,'product_download_links',true);
	$pay_content = get_post_meta($post->ID,'product_pay_content',true);
?>
<p style="clear:both;font-weight:bold;">
<?php echo sprintf(__('此商品购买按钮快捷插入短代码为[product id="%1$s"][/product]','tinection'),$post->ID); ?>
</p>
<p style="clear:both;font-weight:bold;border-bottom:1px solid #ddd;padding-bottom:8px;">
<?php _e('基本信息','tinection'); ?>
</p>
<p style="width:20%;float:left;"><?php _e( '选择支付币种', 'tinection' );?>
	<select name="pay_currency">
		<option value="0" <?php if( $currency!=1) echo 'selected="selected"';?>><?php _e( '积分', 'tinection' );?></option>
		<option value="1" <?php if( $currency==1) echo 'selected="selected"';?>><?php _e( '人民币', 'tinection' );?></option>
	</select>
</p>
<p style="width:20%;float:left;"><?php _e( '商品售价 ', 'tinection' );?>
<input name="product_price" class="small-text code" value="<?php echo sprintf('%0.2f',$price);?>" style="width:80px;height: 28px;">
</p>
<p style="width:20%;float:left;"><?php _e( '商品数量 ', 'tinection' );?>
<input name="product_amount" class="small-text code" value="<?php echo (int)$amount;?>" style="width:80px;height: 28px;">
</p>
<p style="width:40%;float:left;"><?php _e( '是否支持优惠码,仅限现金商品 ', 'tinection' );?>
	<select name="product_promote_code_support">
		<option value="0" <?php if( $promote_code_support!==1) echo 'selected="selected"';?>><?php _e( '不支持', 'tinection' );?></option>
		<option value="1" <?php if( $promote_code_support===1) echo 'selected="selected"';?>><?php _e( '支持', 'tinection' );?></option>
	</select>
</p>
<p style="clear:both;font-weight:bold;border-bottom:1px solid #ddd;padding-bottom:8px;">
<?php _e('VIP会员折扣(1.00代表原价)','tinection'); ?>
</p>
<p style="width:33%;float:left;clear:left;"><?php _e( 'VIP月费会员折扣 ', 'tinection' );?>
<input name="product_vip1_discount" class="small-text code" value="<?php echo sprintf('%0.2f',$vip_discount1);?>" style="width:80px;height: 28px;">
</p>
<p style="width:33%;float:left;"><?php _e( 'VIP季费会员折扣 ', 'tinection' );?>
<input name="product_vip2_discount" class="small-text code" value="<?php echo sprintf('%0.2f',$vip_discount2);?>" style="width:80px;height: 28px;">
</p>
<p style="width:33%;float:left;"><?php _e( 'VIP年费会员折扣 ', 'tinection' );?>
<input name="product_vip3_discount" class="small-text code" value="<?php echo sprintf('%0.2f',$vip_discount3);?>" style="width:80px;height: 28px;">
</p>
<p style="clear:both;font-weight:bold;border-bottom:1px solid #ddd;padding-bottom:8px;">
<?php _e('促销信息','tinection'); ?>
</p>
<p style="width:20%;float:left;clear:left;"><?php _e( '优惠促销折扣 ', 'tinection' );?>
<input name="product_promote_discount" class="small-text code" value="<?php echo sprintf('%0.2f',$promote_discount);?>" style="width:80px;height: 28px;">
</p>
<p style="width:35%;float:left;"><?php _e( '优惠开始日期(格式2015-01-01) ', 'tinection' );?>
<input name="product_discount_begin_date" class="small-text code" value="<?php echo $discount_begin_date;?>" style="width:100px;height:28px;">
</p>
<p style="width:40%;float:left;"><?php _e( '优惠期,为0或为空则不启用优惠 ', 'tinection' );?>
<input name="product_discount_period" class="small-text code" value="<?php echo (int)$discount_period;?>" style="width:60px;height: 28px;"><?php _e( ' 天', 'tinection' );?>
</p>
<p style="clear:both;font-weight:bold;border-bottom:1px solid #ddd;padding-bottom:8px;">
<?php _e('付费内容','tinection'); ?>
</p>
<p style="clear:both;"><?php _e( '付费查看下载链接,一行一个,每个资源格式为资源名|资源下载链接|密码', 'tinection' );?></p>
<textarea name="product_download_links" rows="5" class="large-text code"><?php echo $download_links;?></textarea>
<p style="clear:both;"><?php _e( '付费查看的内容信息', 'tinection' );?></p>
<textarea name="product_pay_content" rows="5" class="large-text code"><?php echo $pay_content;?></textarea>



<?php	
}
/**
 * 保存文章时页，保存自定义内容
 *
 * @param int $post_id 这是即将保存的文章ID
 */
function tin_save_meta_box_data( $post_id ) {
	// 检查安全字段验证
	if ( ! isset( $_POST['tin_meta_box_nonce'] ) ) {
		return;
	}
	// 检查安全字段的值
	if ( ! wp_verify_nonce( $_POST['tin_meta_box_nonce'], 'tin_meta_box' ) ) {
		return;
	}
	// 检查是否自动保存，自动保存则跳出
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// 检查用户权限
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	// 检查和更新字段
	if ( isset( $_POST['tin_dlmail'] )&&!empty($_POST['tin_dlmail']) ) update_post_meta( $post_id, 'tin_dlmail', (int)$_POST['tin_dlmail'] );
	
	if ( isset( $_POST['tin_dload'] )&&($_POST['tin_dload']!=get_post_meta($post_id,'tin_dload',true)) ) update_post_meta( $post_id, 'tin_dload', htmlspecialchars($_POST['tin_dload']) );

	if ( isset( $_POST['tin_demo'] )&&($_POST['tin_demo']!=get_post_meta($post_id,'tin_demo',true)) ) update_post_meta( $post_id, 'tin_demo', htmlspecialchars($_POST['tin_demo']) );

	if ( isset( $_POST['tin_saledl'] )&&($_POST['tin_saledl']!=get_post_meta($post_id,'tin_saledl',true)) ) update_post_meta( $post_id, 'tin_saledl', htmlspecialchars($_POST['tin_saledl']) );

	if ( isset( $_POST['tin_video_url'] )&&($_POST['tin_video_url']!=get_post_meta($post_id,'tin_video_url',true)) ) update_post_meta( $post_id, 'tin_video_url', htmlspecialchars($_POST['tin_video_url']) );
	
	if ( isset( $_POST['tin_thumb_link'] ) && isset( $_POST['tin_thumb_title'] )&&!empty($_POST['tin_thumb_link'])&&!empty($_POST['tin_thumb_title']) ) {$newurl = $_POST['tin_thumb_link'].'|'.$_POST['tin_thumb_title']; update_post_meta( $post_id, 'tin_thumb_url', htmlspecialchars($newurl) );}

	if ( isset( $_POST['tin_copyright_content'] ) ) update_post_meta( $post_id, 'tin_copyright_content', htmlspecialchars($_POST['tin_copyright_content']) );
	
	if ( isset( $_POST['tin_keywords'] ) ) update_post_meta( $post_id, 'keywords', htmlspecialchars($_POST['tin_keywords']) );

	if ( isset( $_POST['tin_description'] ) ) update_post_meta( $post_id, 'description', htmlspecialchars($_POST['tin_description']) );
	
	if ( isset( $_POST['pay_currency'] ) ) update_post_meta( $post_id, 'pay_currency', $_POST['pay_currency'] );

	if ( isset( $_POST['product_price'] ) ) update_post_meta( $post_id, 'product_price', $_POST['product_price'] );
	
	if ( isset( $_POST['product_amount'] ) ) update_post_meta( $post_id, 'product_amount', $_POST['product_amount'] );
	
	if ( isset( $_POST['product_vip1_discount'] )||isset( $_POST['product_vip2_discount'] )||isset( $_POST['product_vip3_discount'] ) ) {$vip1_discount=isset( $_POST['product_vip1_discount'] )?$_POST['product_vip1_discount']:1;$vip2_discount=isset( $_POST['product_vip2_discount'] )?$_POST['product_vip2_discount']:1;$vip3_discount=isset( $_POST['product_vip3_discount'] )?$_POST['product_vip3_discount']:1;$vip_discount=json_encode(array('product_vip1_discount'=>$vip1_discount,'product_vip2_discount'=>$vip2_discount,'product_vip3_discount'=>$vip3_discount));update_post_meta( $post_id, 'product_vip_discount', $vip_discount );}
	
	if ( isset( $_POST['product_promote_code_support'] ) ) update_post_meta( $post_id, 'product_promote_code_support', $_POST['product_promote_code_support'] );
	
	if ( isset( $_POST['product_promote_discount'] ) ) update_post_meta( $post_id, 'product_promote_discount', $_POST['product_promote_discount'] );
	
	if ( isset( $_POST['product_discount_begin_date'] ) ) update_post_meta( $post_id, 'product_discount_begin_date', $_POST['product_discount_begin_date'] );
	
	if ( isset( $_POST['product_discount_period'] ) ) update_post_meta( $post_id, 'product_discount_period', $_POST['product_discount_period'] );
	
	if ( isset( $_POST['product_download_links'] ) ) update_post_meta( $post_id, 'product_download_links', $_POST['product_download_links'] );
	
	if ( isset( $_POST['product_pay_content'] ) ) update_post_meta( $post_id, 'product_pay_content', $_POST['product_pay_content'] );
	
}
add_action( 'save_post', 'tin_save_meta_box_data' );