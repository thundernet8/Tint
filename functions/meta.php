<?php
/**
 * Functions of Tinection WordPress Theme
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

//添加数据表
/* meta_id
/* user_id 代表用户id或者文章id
/* meta_key
/* meta_value
/* 目前用于下载数统计与订阅用户收集
/* ------------ */
function tin_meta_install_callback(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'tin_meta';   
    if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) :   
		$sql = " CREATE TABLE `$table_name` (
			`meta_id` int NOT NULL AUTO_INCREMENT, 
			PRIMARY KEY(meta_id),
			INDEX uid_index(user_id),
			INDEX mkey_index(meta_key),
			`user_id` int,
			`meta_key` varchar(30),
			`meta_value` longtext
		) ENGINE = MyISAM CHARSET=utf8;";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');   
			dbDelta($sql);   
    endif;
}
function tin_meta_install(){
    global $pagenow;   
    if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
        tin_meta_install_callback();
}
add_action( 'load-themes.php', 'tin_meta_install' );   

//获取meta数

function get_tin_meta_count( $key, $value=0, $uid='all' ){

	if( !$key ) return;

	$key = sanitize_text_field($key);
	$value = sanitize_text_field($value);
	if($uid!=='all') $uid = intval($uid);
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'tin_meta';

	$sql = "SELECT count(meta_id) FROM $table_name WHERE meta_key='$key'";
	if($value) $sql .= " AND meta_value='$value'";
	if(is_int($uid)) $sql .= " AND user_id='$uid'";

	$check = $wpdb->get_var($sql);

	if(isset($check)){
	
		return $check;
			
	}else{

		return 0;
			
	}
}

//获取meta值
function get_tin_meta( $key , $uid=0 ){

	if( !$key ) return;

	$key = sanitize_text_field($key);
	$uid = intval($uid);
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'tin_meta';
	
	$check = $wpdb->get_var( "SELECT meta_value FROM $table_name WHERE meta_key='$key' AND user_id='$uid'" );

	if(isset($check)){
	
		return $check;
			
	}else{

		return 0;
			
	}
}

//添加meta
function add_tin_meta( $key, $value, $uid=0 ){

	if( !$key || !$value ) return;

	$key = sanitize_text_field($key);
	$value = sanitize_text_field($value);
	$uid = sanitize_text_field($uid);
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'tin_meta';

	if($wpdb->query( "INSERT INTO $table_name (user_id,meta_key,meta_value) VALUES ('$uid', '$key', '$value')" ))
		return 1;
	
	return 0;
}

//更新meta
function update_tin_meta( $key, $value, $uid=0 ){

	if( !$key || !$value ) return;

	$key = sanitize_text_field($key);
	$value = sanitize_text_field($value);
	$uid = sanitize_text_field($uid);
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'tin_meta';
	
	$check = $wpdb->get_var( "SELECT meta_id FROM $table_name WHERE user_id='$uid' AND meta_key='$key'" );

	if(isset($check)){
	
		if($wpdb->query( "UPDATE $table_name SET meta_value='$value' WHERE meta_id='$check'" ))
			return $check;

	}else{
	
		if($wpdb->query( "INSERT INTO $table_name (user_id,meta_key,meta_value) VALUES ('$uid', '$key', '$value')" ))
			return 'inserted';
			
	}
	
	return 0;
}


//删除meta
function delete_tin_meta( $key, $value=0, $uid='all' ){

	if( !$key ) return;
	
	$key = sanitize_text_field($key);
	$value = sanitize_text_field($value);
	if($uid!=='all') $uid = intval($uid);
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'tin_meta';

	$where = " WHERE meta_key='$key'";
	if($value) $where .= " AND meta_value='$value'";
	if(is_int($uid)) $where .= " AND user_id='$uid'";
	
    if ( $wpdb->get_var( "SELECT meta_id FROM $table_name".$where ) ) {
        return $wpdb->query( "DELETE FROM $table_name".$where );
    }
    
    return false;
}

// @Postmeta
/* 添加文章喜欢meta
/* -------------------------------------- */
function add_tin_likes_fields($post_ID) {
	global $wpdb;
	if(!wp_is_post_revision($post_ID)) {
		add_post_meta($post_ID, 'tin_post_likes', 0, true);
	}
}
add_action('publish_post', 'add_tin_likes_fields');
add_action('publish_page', 'add_tin_likes_fields');

/* 添加文章投票meta
/* ------------------- */
function add_tin_rating_fields($post_ID) {
	global $wpdb;
	if(!wp_is_post_revision($post_ID)) {
		add_post_meta($post_ID, 'tin_rating', '0,0,0,0,0', true);
		add_post_meta($post_ID, 'tin_rating_average', '0', true);
	}
}
add_action('publish_post', 'add_tin_rating_fields');
add_action('publish_page', 'add_tin_rating_fields');

/* 添加文章收藏meta
/* ------------------ */
function add_tin_collect_fields($post_ID) {
	global $wpdb;
	if(!wp_is_post_revision($post_ID)) {
		add_post_meta($post_ID, 'tin_post_collects', 0, true);
	}
}
add_action('publish_post', 'add_tin_collect_fields');
add_action('publish_page', 'add_tin_collect_fields');

/* 添加文章浏览meta
/* ------------------ */
function add_tin_view_fields($post_ID) {
	global $wpdb;
	if(!wp_is_post_revision($post_ID)) {
		add_post_meta($post_ID, 'tin_post_views', 0, true);
	}
}
add_action('publish_post', 'add_tin_view_fields');
add_action('publish_page', 'add_tin_view_fields');

/* 删除文章时删除自添加meta
/* ------------------------ */
function delete_tin_meta_fields($post_ID) {
	global $wpdb;
	if(!wp_is_post_revision($post_ID)) {
		delete_post_meta($post_ID, 'tin_post_collects');
		delete_post_meta($post_ID, 'tin_rating');
		delete_post_meta($post_ID, 'tin_rating_average');
		delete_post_meta($post_ID, 'tin_post_likes');
		delete_post_meta($post_ID, 'tin_post_views');
		delete_post_meta($post_ID, 'tin_latest_reviewed');
	}
}
add_action('delete_post', 'delete_tin_meta_fields');

/* 下载及演示相关meta
/* ---------------- */
function add_tin_dload_fields($post_ID) {
	global $wpdb;
	if(!wp_is_post_revision($post_ID)) {
		add_post_meta($post_ID, 'tin_dload', '', true);
	}
}
//add_action('publish_post', 'add_tin_dload_fields');
//add_action('publish_page', 'add_tin_dload_fields');

function add_tin_saledl_fields($post_ID) {
	global $wpdb;
	if(!wp_is_post_revision($post_ID)) {
		add_post_meta($post_ID, 'tin_saledl', '', true);
	}
}
//add_action('publish_post', 'add_tin_saledl_fields');
//add_action('publish_page', 'add_tin_saledl_fields');

function add_tin_demo_fields($post_ID) {
	global $wpdb;
	if(!wp_is_post_revision($post_ID)) {
		add_post_meta($post_ID, 'tin_demo', '', true);
	}
}
//add_action('publish_post', 'add_tin_demo_fields');
//add_action('publish_page', 'add_tin_demo_fields');

function add_tin_dlmail_fields($post_ID) {
	global $wpdb;
	if(!wp_is_post_revision($post_ID)) {
		add_post_meta($post_ID, 'tin_dlmail', 0, true);
	}
}
//add_action('publish_post', 'add_tin_dlmail_fields');
//add_action('publish_page', 'add_tin_dlmail_fields');

/* 删除文章时删除下载及演示相关meta
/* ------------------------ */
function delete_tin_dload_fields($post_ID) {
	global $wpdb;
	if(!wp_is_post_revision($post_ID)) {
		delete_post_meta($post_ID, 'tin_dload');
		delete_post_meta($post_ID, 'tin_saledl');
		delete_post_meta($post_ID, 'tin_demo');
		delete_post_meta($post_ID, 'tin_dlmail');
	}
}
add_action('delete_post', 'delete_tin_dload_fields');
?>