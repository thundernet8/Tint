<?php
/**
 * Functions of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.2
 * @date      2015.1.1
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

if(ot_get_option('remove_category_links_letters')=='on'){
	category_action_filter();
	add_action('wp_loaded','remove_category_url_refresh_rules');
}else{
	add_action('wp_loaded','remove_category_url_deactivate');
}

function category_action_filter(){
	add_action('created_category',  'remove_category_url_refresh_rules');
	add_action('delete_category',   'remove_category_url_refresh_rules');
	add_action('edited_category',   'remove_category_url_refresh_rules');
	add_action('init',              'remove_category_url_permastruct');
	add_filter('category_rewrite_rules', 'remove_category_url_rewrite_rules');
	add_filter('query_vars',             'remove_category_url_query_vars');    // Adds 'category_redirect' query variable
	add_filter('request',                'remove_category_url_request');       // Redirects if 'category_redirect' is set
}

function remove_category_url_refresh_rules(){
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

function remove_category_url_deactivate(){
	add_filter('request',                'back_category_url_request');       // Redirects if 'category_redirect' is set
	remove_filter('category_rewrite_rules', 'remove_category_url_rewrite_rules'); // We don't want to insert our custom rules again
	remove_category_url_refresh_rules();
}

function remove_category_url_permastruct(){
  global $wp_rewrite;
  global $wp_version;
  if ($wp_version >= 3.4) {
	  $wp_rewrite->extra_permastructs['category']['struct'] = '%category%';
  } else {
    $wp_rewrite->extra_permastructs['category'][0] = '%category%';
  }
}

function remove_category_url_rewrite_rules($category_rewrite){
  $category_rewrite=array();
  if (class_exists('Sitepress')) {
    global $sitepress;
    remove_filter('terms_clauses', array($sitepress, 'terms_clauses'));
    $categories = get_categories(array('hide_empty' => false));
    add_filter('terms_clauses', array($sitepress, 'terms_clauses'));
  } else {
    $categories = get_categories(array('hide_empty' => false));
  }
	foreach($categories as $category) {
		$category_nicename = $category->slug;
		if ( $category->parent == $category->cat_ID ) {
			$category->parent = 0;
    } elseif ($category->parent != 0 ) {
      $category_nicename = get_category_parents( $category->parent, false, '/', true ) . $category_nicename;
    }
		$category_rewrite['('.$category_nicename.')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
		$category_rewrite['('.$category_nicename.')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
		$category_rewrite['('.$category_nicename.')/?$'] = 'index.php?category_name=$matches[1]';
	}
	global $wp_rewrite;
	$old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
	$old_category_base = trim($old_category_base, '/');
	$category_rewrite[$old_category_base.'/(.*)$'] = 'index.php?category_redirect=$matches[1]';
	return $category_rewrite;
}

function remove_category_url_query_vars($public_query_vars){
	$public_query_vars[] = 'category_redirect';
	return $public_query_vars;
}

function remove_category_url_request($query_vars){
	if(isset($query_vars['category_redirect'])) {
		$catlink = trailingslashit(get_option( 'home' )) . user_trailingslashit( $query_vars['category_redirect'], 'category' );
		status_header(301);
		header("Location: $catlink");
		exit();
	}
	return $query_vars;
}

function back_category_url_request($query_vars){
	if(isset($query_vars['category_redirect']))$query_vars['category_redirect']=='';
	return $query_vars;
}
