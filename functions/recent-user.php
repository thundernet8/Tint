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

function tin_update_latest_login( $login ) {
	$user = get_user_by( 'login', $login );
	$latest_login = get_user_meta( $user->ID, 'tin_latest_login', true );
	$latest_ip = get_user_meta( $user->ID, 'tin_latest_ip', true );
	update_user_meta( $user->ID, 'tin_latest_login_before', $latest_login );
	update_user_meta( $user->ID, 'tin_latest_ip_before', $latest_ip );
	update_user_meta( $user->ID, 'tin_latest_login', current_time( 'mysql' ) );
	update_user_meta( $user->ID, 'tin_latest_ip', $_SERVER['REMOTE_ADDR'] );
}
add_action( 'wp_login', 'tin_update_latest_login', 10, 1 );
 
function tin_latest_login_column( $columns ) {
	$columns['tin_latest_login'] = '上次登录';
	return $columns;
}
add_filter( 'manage_users_columns', 'tin_latest_login_column' );
 
function tin_latest_login_column_callback( $value, $column_name, $user_id ) {
	if('tin_latest_login' == $column_name){
		$user = get_user_by( 'id', $user_id );
		$value = ( $user->tin_latest_login ) ? $user->tin_latest_login : $value = __('没有记录','tin');
	}
	return $value;
}
add_action( 'manage_users_custom_column', 'tin_latest_login_column_callback', 10, 3 );

function tin_get_recent_user($number=10){
	$user_query = new WP_User_Query( array ( 'orderby' => 'meta_value', 'order' => 'DESC', 'meta_key' => 'tin_latest_login', 'number' => $number ) );
	if($user_query) return $user_query->results;
	return;
}
