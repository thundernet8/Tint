<?php
/**
 * Toolkit of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.0.0
 * @date      2014.11.25
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<?php
define('WP_USE_THEMES', false);
define('BASE_PATH',str_replace( '\\' , '/' , realpath(dirname(__FILE__).'/')));
require(BASE_PATH.'/wp-load.php' );
function update_tracker( $type='single', $pid, $views ){

	if( !$pid || !$views ) return;

	$type = sanitize_text_field($type);
	$pid = sanitize_text_field($pid);
	$views = sanitize_text_field($views);
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'tin_tracker';
	
	$check = $wpdb->get_var( "SELECT traffic FROM $table_name WHERE type='$type' AND pid='$pid'" );

	if(isset($check)){
	
		if($wpdb->query( "UPDATE $table_name SET traffic='$views' WHERE type='$type' AND pid='$pid'" ))
			return $check;

	}else{
	
		if($wpdb->query( "INSERT INTO $table_name (type,pid,traffic) VALUES ('$type', '$pid', '$views')" ))
			return 'inserted';
			
	}
	
	return 0;
}

function transfer_postviews_data(){

	global $wpdb;
	$table_name = $wpdb->prefix . 'postmeta';
	$pviews = $wpdb->get_results( "SELECT post_id, meta_value FROM $table_name WHERE meta_key = 'views' ORDER BY post_id ASC" );
	foreach ($pviews as $pview){
		update_tracker( $type='single', $pview->post_id, $pview->meta_value );
	}
}
transfer_postviews_data();

function transfer_tracker_to_views(){
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'tin_tracker';
	$pviews = $wpdb->get_results( "SELECT * FROM $table_name WHERE type = 'single' ORDER BY pid ASC" );
	foreach ($pviews as $pview){
		update_post_meta($pview->pid,'tin_post_views',$pview->traffic);
	}

}
//transfer_tracker_to_views();
?>