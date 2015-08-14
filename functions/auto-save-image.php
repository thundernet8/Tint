<?php
/**
 * Functions of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.8
 * @date      2015.6.5
 * @author    Zhiyan <chinash2010@gmail.com> && Bai Yunshan
 * @site      Zhiyanblog <www.zhiyanblog.com> && Bai Yunshan<http://www.01on.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan && Bai Yunshan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<?php
add_filter('content_save_pre', 'post_save_images');
function post_save_images( $content ){
	if( ($_POST['save'] || $_POST['publish']) && (ot_get_option('auto_save_image')==="on") ){
		set_time_limit(240);
		global $post;
		$post_id=$post->ID;
		$preg=preg_match_all('/<img.*?src="(.*?)"/',stripslashes($content),$matches);
		if($preg){
			$i = 1;
			foreach($matches[1] as $image_url){
				if(empty($image_url)) continue;
				$pos=strpos($image_url,get_bloginfo('url'));
				if($pos===false){
					$res=save_images($image_url,$post_id,$i);
					$replace=$res['url'];
					if($replace)$content=str_replace($image_url,$replace,$content);
				}
				$i++;
			}
		}
	}
	remove_filter( 'content_save_pre', array( $this, 'post_save_images' ) );
	return $content;
}
	
function save_images($image_url,$post_id,$i){
	//set_time_limit(180); //每个图片最长允许下载时间,秒
	$file=file_get_contents($image_url);
	$fileext = substr(strrchr($image_url,'.'),1);
	$fileext = strtolower($fileext);
	if($fileext==""||strlen($fileext)>4)$fileext = "jpg";
	$savefiletype = array('jpg','gif','png','bmp');
	if(!in_array($fileext, $savefiletype))$fileext = "jpg";
	$im_name = date('YmdHis',time()).$i.mt_rand(10,20).'.'.$fileext;
	$res=wp_upload_bits($im_name,'',$file);
	if(isset($res['file']))$attach_id = insert_attachment($res['file'],$post_id);else return;
	if( ot_get_option('auto_save_image_thumb')=='on' && $i==1 ){
		set_post_thumbnail( $post_id, $attach_id );
	}
	return $res;
}
	
function insert_attachment($file,$id){
	$dirs=wp_upload_dir();
	$filetype=wp_check_filetype($file);
	$attachment=array(
		'guid'=>$dirs['baseurl'].'/'._wp_relative_upload_path($file),
		'post_mime_type'=>$filetype['type'],
		'post_title'=>preg_replace('/\.[^.]+$/','',basename($file)),
		'post_content'=>'',
		'post_status'=>'inherit'
	);
	$attach_id=wp_insert_attachment($attachment,$file,$id);
	//$attach_data=wp_generate_attachment_metadata($attach_id,$file);
	//wp_update_attachment_metadata($attach_id,$attach_data);
	return $attach_id;
}

?>