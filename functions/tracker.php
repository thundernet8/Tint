<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.0.0
 * @date      2014.11.25
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com> & Dmeng <http://www.dmeng.net/>
 * @copyright Copyright (c) 2014-2015, Zhiyan & Dmeng
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

/*
 * 添加数据库表
 * 
 * ID 自动增长主键
 * type 页面类型
 * pid 页面唯一身份
 * traffic 流量
 * 
 */
function tin_tracker_install_callback(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'tin_tracker';   
    if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) :   
		$sql = " CREATE TABLE `$table_name` (
			`ID` int NOT NULL AUTO_INCREMENT, 
			PRIMARY KEY(ID),
			INDEX type_index(type),
			INDEX pid_index(pid),
			INDEX traffic_index(traffic),
			`type` varchar(30),
			`pid` varchar(30),
			`traffic` int
		) ENGINE = MyISAM CHARSET=utf8;";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');   
			dbDelta($sql);   
    endif;
}
function tin_tracker_install(){
    global $pagenow;   
    if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
        tin_tracker_install_callback();
}
add_action( 'load-themes.php', 'tin_tracker_install' );   

/* 获取流量数据
/* ------------- */
function get_tin_traffic_all( $type='' ){
	$type = sanitize_text_field($type);
	global $wpdb;
	$table_name = $wpdb->prefix . 'tin_tracker';
	if( $type && in_array($type , array('single', 'attachment', 'cat', 'tag', 'search', 'author') ) )
		$sql = "SELECT sum(traffic) FROM $table_name WHERE type='$type'";
	else
		$sql = "SELECT sum(traffic) FROM $table_name";
	$check = $wpdb->get_var( $sql );
	if($check) return $check;
	return 0;
}
 
function get_tin_traffic( $type , $pid ){
	if( $type=='' || $pid=='' ) return;
	$type = sanitize_text_field($type);
	$pid = sanitize_text_field($pid);
	global $wpdb;
	$table_name = $wpdb->prefix . 'tin_tracker';	
	$check = $wpdb->get_var( "SELECT traffic FROM $table_name WHERE pid='$pid' AND type='$type'" );
	if(isset($check)){
		return (int)$check;		
	}else{
		return 0;		
	}
}

/* 更新流量数据
/* -------------- */
function update_tin_traffic( $type , $pid ){
	if( $type=='' || $pid=='' ) return;
	$type = sanitize_text_field($type);
	$pid = sanitize_text_field($pid);	
	global $wpdb;
	$table_name = $wpdb->prefix . 'tin_tracker';	
	$check = $wpdb->get_var( "SELECT traffic FROM $table_name WHERE pid='$pid' AND type='$type'" );
	if(isset($check)){
		$traffic = (int)$check+1;
		if($wpdb->query( "UPDATE $table_name SET traffic='$traffic' WHERE pid='$pid' AND type='$type'" ))
			return $traffic;		
	}else{
		if($wpdb->query( "INSERT INTO $table_name (type,pid,traffic) VALUES ('$type', '$pid', 1)" ))
			return 1;		
	}
}

/* 删除流量数据
/* ------------- */
function delete_tin_traffic( $type , $pid ){
	if( !$type || !$pid ) return;
	$type = sanitize_text_field($type);
	$pid = sanitize_text_field($pid);
	global $wpdb;
	$table_name = $wpdb->prefix . 'tin_tracker';
    if ( $wpdb->get_var( "SELECT traffic FROM $table_name WHERE pid='$pid' AND type='$type'" ) ) {
        return $wpdb->query( "DELETE FROM $table_name WHERE pid='$pid' AND type='$type'" );
    }
    return true;
}

function delete_tin_traffic_post( $pid ){
	delete_tin_traffic('single',$pid);
}

function delete_tin_traffic_category( $pid ){
	delete_tin_traffic('cat',$pid);
}

function delete_tin_traffic_tag( $pid ){
	delete_tin_traffic('tag',$pid);
}

function delete_tin_traffic_user( $pid ){
	delete_tin_traffic('author',$pid);
}

function delete_tin_traffic_attachment( $pid ){
	delete_tin_traffic('attachment',$pid);
}

function delete_tin_traffic_term( $term, $tt_id, $taxonomy ){
	delete_tin_traffic('tax_'.$taxonomy,$term);
}

/* 在删除文章、分类法、作者、附件等内容时同时删除相关流量数据
/* --------------------------------------------------------------- */
function tin_traffic_init(){
    add_action( 'delete_post', 'delete_tin_traffic_post', 10 );
	add_action( 'delete_category', 'delete_tin_traffic_category', 10);
	add_action( 'delete_post_tag', 'delete_tin_traffic_tag', 10);
	add_action( 'delete_user', 'delete_tin_traffic_user', 10);
	add_action( 'delete_attachment', 'delete_tin_traffic_attachment', 10);
	add_action( 'delete_term', 'delete_tin_traffic_term', 10);
}
add_action( 'admin_init', 'tin_traffic_init' );

function tin_tracker_param(){	
	global $wp_query;
	$object = $wp_query->get_queried_object();
	$tracker = array( 'type' => 'unknown' , 'pid' => 1 );
	switch(TRUE){		
			case $wp_query->is_home() : $tracker['type'] = 'home';
			break;
			
			case $wp_query->is_front_page() : $tracker = array( 'type' => 'single' , 'pid' => get_option('page_on_front') );
			break;
			
			case $wp_query->is_single() : case $wp_query->is_page() : $tracker = array( 'type' => $wp_query->is_attachment() ? 'attachment' : 'single' , 'pid' => $object->ID );
			break;
			
			case $wp_query->is_category() : $tracker = array( 'type' => 'cat' , 'pid' => $object->term_id );
			break;
			
			case $wp_query->is_tag() : $tracker = array( 'type' => 'tag' , 'pid' => $object->term_id );
			break;
			
			case $wp_query->is_search() : $tracker = array( 'type' => 'search' , 'pid' => $wp_query->get('s') );
			break;
			
			case $wp_query->is_author() : $tracker = array( 'type' => 'author' , 'pid' => $object->ID );
			break;

			case $wp_query->is_date() : $tracker['type'] = 'date';

				switch(TRUE){
							
					case $wp_query->is_year() :
						$tracker['type'] .= '_year';
						$tracker['pid'] = $wp_query->get('m') ? $wp_query->get('m') : $wp_query->get('year');
					break;
							
					case $wp_query->is_month() :
						$tracker['type'] .= '_month';
						$tracker['pid'] = $wp_query->get('m') ? $wp_query->get('m') : $wp_query->get('year') . sprintf ( "%02d", $wp_query->get('monthnum'));
					break;
							
					case $wp_query->is_day() :
						$tracker['type'] .= '_day';
						$tracker['pid'] = $wp_query->get('m') ? $wp_query->get('m') : $wp_query->get('year') . sprintf ( "%02d", $wp_query->get('monthnum')) . sprintf ( "%02d", $wp_query->get('day'));
					break;
	
				}
						
			break;  //~ date end

			case $wp_query->is_post_type_archive() : $tracker['type'] = 'post_type_'.$wp_query->get('post_type');
			break;
					
			case $wp_query->is_tax() : $tracker = array( 'type' => 'tax_'.$object->taxonomy , 'pid' => $object->term_id );
			break;
			
			case $wp_query->is_archive() : $tracker['type'] = 'archive';
			break;

			case $wp_query->is_404() : $tracker['type'] = '404';
			break;
		
	}
	return $tracker;
}

/* 流量排行
/* ----------- */
function tin_tracker_rank($type='single',$limit=10){	 
	global $wpdb;	
	$table_tracker = $wpdb->prefix . 'tin_tracker';
	$results = array();
	if( $type=='search' ){	
		$results = $wpdb->get_results( "SELECT pid,traffic FROM $table_tracker WHERE type = 'search' ORDER BY traffic DESC LIMIT $limit ");	
	}
	if( $type=='single' ){	
		$table_posts = $wpdb->posts;
		$results = $wpdb->get_results( "SELECT $table_tracker.pid AS pid,$table_tracker.traffic AS traffic FROM $table_tracker where exists(select 1 from  $table_posts where $table_posts.ID = $table_tracker.pid and $table_posts.post_status = 'publish') AND $table_tracker.type = '$type'  ORDER BY traffic DESC LIMIT $limit");
	}
	return $results;
}

/* 更新流量数据AJAX
/* ------------------ */
function tin_tracker_ajax_callback(){
	if ( ! wp_verify_nonce( trim($_POST['wp_nonce']), 'check-nonce' ) ){
		echo 'NonceIsInvalid';
		die();
	}
	if( $_POST['type']=='' || $_POST['pid']=='' ) return;
	$type = sanitize_text_field($_POST['type']);
	$pid = sanitize_text_field($_POST['pid']);
	if($type=='single'&&!empty($pid)){
		$views = get_post_meta($pid,'tin_post_views',true)?(int)get_post_meta($pid,'tin_post_views',true):0;
		$views++;
		update_post_meta($pid,'tin_post_views',$views);
	}
	echo update_tin_traffic($type,$pid);
	do_action( 'tin_tracker_ajax_callback', $type, $pid ); 
	die();
}
add_action( 'wp_ajax_tin_tracker_ajax', 'tin_tracker_ajax_callback' );
add_action( 'wp_ajax_nopriv_tin_tracker_ajax', 'tin_tracker_ajax_callback' );
?>