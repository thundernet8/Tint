<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.0
 * @date      2014.12.11
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com> & Dmeng <http://www.dmeng.net/>
 * @copyright Copyright (c) 2014-2015, Zhiyan & Dmeng
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

/*
 * 
 * @user_meta tin_credit 当前可用积分
 * @user_meta tin_credit_void 无效（已消费）积分
 * 
 * @user_meta tin_rec_view 访问推广数据，每天0点清空
 * @user_meta tin_rec_reg 注册推广数据，每天0点清空
 * @user_meta tin_rec_post 投稿数据，每天0点清空
 * @user_meta tin_rec_comment 评论数据，每天0点清空
 * @user_meta tin_aff 注册推广人
 * @user_meta tin_aff_users 已推广注册用户ID..
 * @user_meta tin_aff_views 总推广访问数量..
 * @user_meta tin_resource_dl_users 下载用户的ua信息，防止重复下载刷积分奖励，每天0点清空
 * 
 * @option tin_reg_credit 注册奖励积分，默认是50分
 * @option tin_rec_view_credit 访问推广一次可得积分，默认是5分
 * @option tin_rec_reg_credit 注册推广一次可得积分，默认是50分
 * @option tin_rec_post_credit 投稿一次可得积分，默认是50分
 * @option tin_rec_comment_credit 评论一次可得积分，默认是5分
 * @option tin_rec_resource_dl_credit 作者发布的资源被下载一次可得积分，默认是5分
 * 
 * @option tin_rec_view_num 每天可得积分访问推广次数，默认是50次
 * @option tin_rec_reg_num 每天可得积分注册推广次数，默认是5次
 * @option tin_rec_post_num 每天可得积分投稿次数，默认是5次
 * @option tin_rec_comment_num 每天可得积分评论次数，默认是50次
 * 
 */

/* 更新用户积分
/* ------------- */
function update_tin_credit( $user_id , $num , $method='add' , $field='tin_credit' , $msg='' ){
	 
	if( !is_numeric($user_id)  ) return;

	$field = $field=='tin_credit' ? $field : 'tin_credit_void';
	
	$credit = (int)get_user_meta( $user_id, $field, true );
	$num = (int)$num;

	if( $method=='add' ){
		
		$add = update_user_meta( $user_id , $field, ( ($credit+$num)>0 ? ($credit+$num) : 0 ) );
		if( $add ){
			add_tin_message( $user_id ,  'credit' , current_time('mysql') , ($msg ? $msg : sprintf( __('获得%s积分','tinection') , $num )) );
			return $add;
		}
	}
	
	if($method=='cut'){
		
		$cut = update_user_meta( $user_id , $field, ( ($credit-$num)>0 ? ($credit-$num) : 0 )  );
		if( $cut ){
			add_tin_message( $user_id ,  'credit' , current_time('mysql') , ($msg ? $msg : sprintf( __('消费%s积分','tinection') , $num )) );
			return $cut;
		}
	}
	
	$update = update_user_meta( $user_id , $field, $num );
	if( $update ){
		add_tin_message( $user_id ,  'credit' , current_time('mysql') , ($msg ? $msg : sprintf( __('更新积分为%s','tinection') , $num )) );
		return $update;
	}

}

/* 用户已消费积分
/* ---------------- */
function tin_credit_to_void( $user_id , $num, $msg='' ){
	if( !is_numeric($user_id) || !is_numeric($num) ) return;
	$credit = (int)get_user_meta( $user_id, 'tin_credit' , true );
	$num = (int)$num;
	if($credit<$num) return 'less';
	$cut = update_user_meta( $user_id , 'tin_credit' , ($credit-$num) );
	$credit_void = (int)get_user_meta( $user_id, 'tin_credit_void' , true );
	$add = update_user_meta( $user_id , 'tin_credit_void' , ($credit_void+$num) );
	add_tin_message( $user_id ,  'credit' , current_time('mysql') , ($msg ? $msg : sprintf( __('消费了%s积分','tinection') , $num )) );
	return 0;	
}

/* 用户注册时添加推广人和奖励积分
/* --------------------------------- */
function user_register_update_tin_credit( $user_id ) {
    if( isset($_COOKIE['tin_aff']) && is_numeric($_COOKIE['tin_aff']) ){
    	//链接推广人与新注册用户(推广人meta)
		if(get_user_meta( $_COOKIE['tin_aff'], 'tin_aff_users', true)){
			$aff_users = get_user_meta( $_COOKIE['tin_aff'], 'tin_aff_users', true);
			if(empty($aff_users)){$aff_users=$user_id;}else{$aff_users .= ','.$user_id;}				
			update_user_meta( $_COOKIE['tin_aff'], 'tin_aff_users', $aff_users);
		}else{
			update_user_meta( $_COOKIE['tin_aff'], 'tin_aff_users', $user_id);
		}
    	//链接推广人与新注册用户(注册人meta)
		update_user_meta( $user_id, 'tin_aff', $_COOKIE['tin_aff'] );
		$rec_reg_num = (int)ot_get_option('tin_rec_reg_num','5');
		$rec_reg = json_decode(get_user_meta( $_COOKIE['tin_aff'], 'tin_rec_reg', true ));
		$ua = $_SERVER["REMOTE_ADDR"].'&'.$_SERVER["HTTP_USER_AGENT"];
		if(!$rec_reg){
			$rec_reg = array();
			$new_rec_reg = array($ua);
		}else{
			$new_rec_reg = $rec_reg;
			array_push($new_rec_reg , $ua);
		}
		if( (count($rec_reg) < $rec_reg_num) &&  !in_array($ua,$rec_reg) ){
			update_user_meta( $_COOKIE['tin_aff'] , 'tin_rec_reg' , json_encode( $new_rec_reg ) );

			$reg_credit = (int)ot_get_option('tin_rec_reg_credit','50');
			if($reg_credit) update_tin_credit( $_COOKIE['tin_aff'] , $reg_credit , 'add' , 'tin_credit' , sprintf(__('获得注册推广（来自%1$s的注册）奖励%2$s积分','tinection') , get_the_author_meta('display_name', $user_id) ,$reg_credit) );
		}
	}
	$credit = ot_get_option('tin_reg_credit','50');
	if($credit){
		update_tin_credit( $user_id , $credit , 'add' , 'tin_credit' , sprintf(__('获得注册奖励%s积分','tinection') , $credit) );
	}
}
add_action( 'user_register', 'user_register_update_tin_credit');

/* 访问推广检查
/* -------------- */
function hook_tin_affiliate_check_to_tracker_ajax(){
	if( isset($_COOKIE['tin_aff']) && is_numeric($_COOKIE['tin_aff']) ){
		$rec_view_num = (int)ot_get_option('tin_rec_view_num','50');
		$rec_view = json_decode(get_user_meta( $_COOKIE['tin_aff'], 'tin_rec_view', true ));
		$ua = $_SERVER["REMOTE_ADDR"].'&'.$_SERVER["HTTP_USER_AGENT"];
		if(!$rec_view){
			$rec_view = array();
			$new_rec_view = array($ua);
		}else{
			$new_rec_view = $rec_view;
			array_push($new_rec_view , $ua);
		}
		//推广人推广访问数量，不受每日有效获得积分推广次数限制，但限制同IP且同终端刷分
		if( !in_array($ua,$rec_view) ){
			$aff_views = (int)get_user_meta( $_COOKIE['tin_aff'], 'tin_aff_views', true);
			$aff_views++;
			update_user_meta( $_COOKIE['tin_aff'], 'tin_aff_views', $aff_views);
		}
		//推广奖励，受每日有效获得积分推广次数限制及同IP终端限制刷分
		if( (count($rec_view) < $rec_view_num) && !in_array($ua,$rec_view) ){
			update_user_meta( $_COOKIE['tin_aff'] , 'tin_rec_view' , json_encode( $new_rec_view ) );
			$view_credit = (int)ot_get_option('tin_rec_view_credit','5');
			if($view_credit) update_tin_credit( $_COOKIE['tin_aff'] , $view_credit , 'add' , 'tin_credit' , sprintf(__('获得访问推广奖励%1$s积分','tinection') ,$view_credit) );
		}
	}
}
add_action( 'tin_tracker_ajax_callback', 'hook_tin_affiliate_check_to_tracker_ajax');

/* 资源被下载时作者获得积分奖励
/* ----------------------------- */
function tin_resource_dl_add_credit($uid,$pid,$sid){
	$current_user = get_current_user_id() ? get_current_user_id() : 0;
	$dl_users = json_decode(get_user_meta( $uid, 'tin_resource_dl_users', true ));
	$ua = $_SERVER["REMOTE_ADDR"].'&'.$_SERVER["HTTP_USER_AGENT"].'&'.$pid.'&'.$sid;
	if(!$dl_users){
		$dl_users = array();
		$new_dl_users = array($ua);
	}else{
		$new_dl_users = $dl_users;
		array_push($new_dl_users , $ua);
	}
	if( !in_array($ua,$dl_users) && $current_user != $uid){
		update_user_meta( $uid , 'tin_resource_dl_users' , json_encode( $new_dl_users ) );
		$dl_credit = (int)ot_get_option('tin_rec_resource_dl_credit','5');
		if($dl_credit) update_tin_credit( $uid , $dl_credit , 'add' , 'tin_credit' , sprintf(__('你发布的文章《%1$s》中资源被其他用户下载，奖励%2$s积分','tinection') ,get_post_field('post_title',$pid),$dl_credit) );
	}
}

/* 发表评论时给作者添加积分
/* ------------------------- */
function tin_comment_add_credit($comment_id, $comment_object){
	
	$user_id = $comment_object->user_id;
	
	if($user_id){
		
		$rec_comment_num = (int)ot_get_option('tin_rec_comment_num','50');
		$rec_comment_credit = (int)ot_get_option('tin_rec_comment_credit','5');
		$rec_comment = (int)get_user_meta( $user_id, 'tin_rec_comment', true );
		
		if( $rec_comment<$rec_comment_num && $rec_comment_credit ){
			update_tin_credit( $user_id , $rec_comment_credit , 'add' , 'tin_credit' , sprintf(__('获得评论回复奖励%1$s积分','tinection') ,$rec_comment_credit) );
			update_user_meta( $user_id, 'tin_rec_comment', $rec_comment+1);
		}
	}
}
add_action('wp_insert_comment', 'tin_comment_add_credit' , 99, 2 );

/* 每天 00:00 清空推广数据
/* ------------------------- */
function clear_tin_rec_setup_schedule() {
	if ( ! wp_next_scheduled( 'clear_tin_rec_daily_event' ) ) {
		//~ 1193875200 是 2007/11/01 00:00 的时间戳
		wp_schedule_event( '1193875200', 'daily', 'clear_tin_rec_daily_event');
	}
}
add_action( 'wp', 'clear_tin_rec_setup_schedule' );

function clear_tin_rec_do_this_daily() {
	global $wpdb;
	$wpdb->query( " DELETE FROM $wpdb->usermeta WHERE meta_key='tin_rec_view' OR meta_key='tin_rec_reg' OR meta_key='tin_rec_post' OR meta_key='tin_rec_comment' OR meta_key='tin_resource_dl_users' " );
}
add_action( 'clear_tin_rec_daily_event', 'clear_tin_rec_do_this_daily' );

//~ 在后台用户列表中显示积分
function tin_credit_column( $columns ) {
	$columns['tin_credit'] = __('积分','tinection');
	return $columns;
}
add_filter( 'manage_users_columns', 'tin_credit_column' );
 
function tin_credit_column_callback( $value, $column_name, $user_id ) {

	if( 'tin_credit' == $column_name ){
		$credit = intval(get_user_meta($user_id,'tin_credit',true));
		$void = intval(get_user_meta($user_id,'tin_credit_void',true));
		$value = sprintf(__('总积分 %1$s 已消费 %2$s','tinection'), ($credit+$void), $void );
	}
	return $value;
}
add_action( 'manage_users_custom_column', 'tin_credit_column_callback', 10, 3 );

//~ 用户积分排行
function tin_credits_rank($limits=10){
	global $wpdb;
	$limits = (int)$limits;
	$ranks = $wpdb->get_Results( " SELECT * FROM $wpdb->usermeta WHERE meta_key='tin_credit' ORDER BY -meta_value ASC LIMIT $limits" );
	return $ranks;
}

//~ 每日签到
function tin_whether_signed($user_id){
	if(get_user_meta($user_id,'tin_daily_sign',true)){
		date_default_timezone_set ('Asia/Shanghai');
		$sign_date_meta = get_user_meta($user_id,'tin_daily_sign',true);
		$sign_date = date('Y-m-d',strtotime($sign_date_meta));
		$now_date = date('Y-m-d',time());
		if($sign_date != $now_date){
			$sign_anchor = '<a href="javascript:" id="daily_sign" title="签到送积分">'.__('签到','tinection').'</a>';
		}else{
			$sign_anchor = '<a href="javascript:" id="daily_signed" title="已于'.$sign_date_meta.'签到" style="cursor:default;">'.__('今日已签到','tinection').'</a>';
		}
	}else{
		$sign_anchor = '<a href="javascript:" id="daily_sign" title="签到送积分">'.__('签到','tinection').'</a>';
	}
	return $sign_anchor;
}

function tin_daily_sign_callback(){
	date_default_timezone_set ('Asia/Shanghai');
	$msg = '';
	$success = 0;
	$credits = 0;
	if(!is_user_logged_in()){$msg='请先登录';}else{
		$user_info = wp_get_current_user();
		$date = date('Y-m-d H:i:s',time());
		$sign_date_meta = get_user_meta($user_info->ID,'tin_daily_sign',true);
		$sign_date = date('Y-m-d',strtotime($sign_date_meta));
		$now_date = date('Y-m-d',time());
		if($sign_date != $now_date):
			update_user_meta($user_info->ID,'tin_daily_sign',$date);
			$credits = ot_get_option('tin_daily_sign_credits',10);
			$credit_msg = '每日签到赠送'.$credits.'积分';
			update_tin_credit( $user_info->ID , $credits , 'add' , 'tin_credit' , $credit_msg );
			$success = 1;
			$msg = '签到成功，获得'.$credits.'积分';
		else:
			$success = 1;
			$credits = 0;
		endif;
	}
	$return = array('msg'=>$msg,'success'=>$success,'credits'=>$credits);
	echo json_encode($return);
	exit;
}
add_action( 'wp_ajax_daily_sign', 'tin_daily_sign_callback' );
add_action( 'wp_ajax_nopriv_daily_sign', 'tin_daily_sign_callback' );