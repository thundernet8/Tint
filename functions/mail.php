<?php
/**
 * Functions of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.7
 * @date      2015.3.12
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

/* Mail content template
/* -------------- */
function tin_mail_template($type,$content){
	$blogname =  get_bloginfo('name');
	$bloghome = get_bloginfo('url');
	$logo = ot_get_option('logo-img');
	$html = '<html><head><meta http-equiv="content-type" content="text/html; charset=UTF-8" /><meta name="viewport" content="target-densitydpi=device-dpi, width=800, initial-scale=1, maximum-scale=1, user-scalable=1"><style>a:hover{text-decoration:underline !important;}</style></head><body><div style="width:800px;margin: 0 auto;"><table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#fefcfa" style="border-radius:5px; overflow:hidden; border-top:4px solid #00c3b6; border-right:1px solid #dbd1ce; border-bottom:1px solid #dbd1ce; border-left:1px solid #dbd1ce;font-family:微软雅黑;"><tbody><tr><td><table width="800" border="0" align="center" cellpadding="0" cellspacing="0" height="48"><tbody><tr><td width="74" height="35" border="0" align="center" valign="middle" style="padding-left:20px;"><a href="'.$bloghome.'" target="_blank" style="text-decoration: none;">';
	if(!empty($logo)) {$html .= '<img style="vertical-align:middle;background: #00d6ac;" src="'.$logo.'" height="35" border="0">';}else{$html .= '<span style="vertical-align:middle;font-size:20px;line-height:32px;white-space:nowrap;">'.$blogname.'</span>';}
	$html .= '</a></td><td width="703" height="48" colspan="2" align="right" valign="middle" style="color:#333; padding-right:20px;font-size:14px;font-family:微软雅黑"><a style="padding:0 10px;text-decoration:none;" target="_blank" href="'.$bloghome.'">首页</a><a style="padding:0 10px;text-decoration:none;" target="_blank" href="'.$bloghome.'/articles">文章</a>';
	if(ot_get_option('shop_system')=='on'){$html .= '<a style="padding:0 10px;text-decoration:none;" target="_blank" href="'.$bloghome.'/store">商城</a>';}
	$html .= '</td></tr></tbody></table></td></tr><tr><td><div style="padding:10px 20px;font-size:14px;color:#333333;border-top:1px solid #dbd1ce;font-family:微软雅黑">';
	$html .= $content;
	$html .= '<p style="padding:10px 0;margin-top:30px;margin-bottom:0;color:#a8979a;font-size:12px;border-top:1px dashed #dbd1ce;">此为系统邮件请勿回复<span style="float:right">&copy;&nbsp;'.date('Y').'&nbsp;'.$blogname.'</span></p></div></td></tr></tbody></table></div></body></html>';
	return $html;
}

/* Basic Mail
/* ----------- */
function tin_basic_mail($from,$to,$title,$content,$type){
	date_default_timezone_set ('Asia/Shanghai');
	$message = tin_mail_template($type,$content);
	$name = get_bloginfo('name');
	if(empty($from)){$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));}else{$wp_email=$from;}
	$fr = "From: \"" . $name . "\" <$wp_email>";
	$headers = "$fr\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
	wp_mail( $to, $title, $message, $headers );
} 

/* 评论回复邮件
/* -------------- */
function comment_mail_notify($comment_id,$comment_object) {
	if( $comment_object->comment_approved != 1 || !empty($comment_object->comment_type) ) return;
	date_default_timezone_set ('Asia/Shanghai');
	$admin_notify = '1'; // admin 要不要收回复通知 ( '1'=要 ; '0'=不要 )
	$admin_email = get_bloginfo ('admin_email'); // $admin_email 可改为你指定的 e-mail.
	$comment = get_comment($comment_id);
	$comment_author = trim($comment->comment_author);
	$comment_date = trim($comment->comment_date);
	$comment_link = htmlspecialchars(get_comment_link($comment_id));
	$comment_content = nl2br($comment->comment_content);
	$comment_author_email = trim($comment->comment_author_email);
	$parent_id = $comment->comment_parent ? $comment->comment_parent : '';
	$parent_email = trim(get_comment($parent_id)->comment_author_email);
	$post = get_post($comment_object->comment_post_ID);
	$post_author_email = get_user_by( 'id' , $post->post_author)->user_email;
	$wp_email = 'no-reply@' . preg_replace('#^www.#', '', strtolower($_SERVER['SERVER_NAME'])); // e-mail 发出点, no-reply 可改为可用的 e-mail.
	$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
	$blogname = get_option("name");
	$bloghome = get_option("home");
	$send_email = array();
	global $wpdb;
	if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") == '')
		$wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
	if (isset($_POST['comment_mail_notify']))
		$wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='$comment_id'");
		$notify = $parent_id ? get_comment($parent_id)->comment_mail_notify : '0';
		$spam_confirmed = $comment->comment_approved;
	//给父级评论提醒
	if ($parent_id != '' && $spam_confirmed != 'spam' && $notify == '1' && $parent_email != $comment_author_email) {
		$parent_author = trim(get_comment($parent_id)->comment_author);
		$parent_comment_date = trim(get_comment($parent_id)->comment_date);
		$parent_comment_content = nl2br(get_comment($parent_id)->comment_content);
		$send_email[] = array(
				'address' => $parent_email,
				'uid' => $comment_object->comment_parent,
				'title' => sprintf( __('%1$s在%2$s中回复你','tinection'), $comment_object->comment_author, $post->post_title ),
				'type' => sprintf( __('评论提醒','tinection') ),
				'content'  => sprintf( __('<style>img{max-width:100%;}</style><p>%1$s，您好!</p><p>您于%2$s在文章《%3$s》上发表评论: </p><p style="border-bottom:#ddd 1px solid;border-left:#ddd 1px solid;padding-bottom:20px;background-color:#eee;margin:15px 0px;padding-left:20px;padding-right:20px;border-top:#ddd 1px solid;border-right:#ddd 1px solid;padding-top:20px">%4$s</p>
<p>%5$s 于%6$s 给您的回复如下: </p><p style="border-bottom:#ddd 1px solid;border-left:#ddd 1px solid;padding-bottom:20px;background-color:#eee;margin:15px 0px;padding-left:20px;padding-right:20px;border-top:#ddd 1px solid;border-right:#ddd 1px solid;padding-top:20px">%7$s</p>
<p>您可以点击 <a style="color:#00bbff;text-decoration:none" href="%8$s" target="_blank">查看回复的完整內容</a></p>','tinection'),$parent_author,$parent_comment_date,$post->post_title,$parent_comment_content,$comment_author,$comment_date,$comment_content,$comment_link),
		);
	}
	
	//给文章作者的通知
	if($post_author_email != $comment_author_email && $post_author_email != $parent_email){
		$send_email[] = array(
			'address' => $post_author_email,
			'uid' => $post->post_author,
			'title' => sprintf( __('%1$s在%2$s中回复你','tinection'), $comment_object->comment_author, $post->post_title ),
			'type' => sprintf( __('文章评论','tinection') ),
			'content' => sprintf( __('<style>img{max-width:100%;}</style>%1$s在文章<a href="%2$s" target="_blank">%3$s</a>中发表了回复，快去看看吧：<br><p style="padding:10px 0;background-color:#eee;margin-top:10px;"> %4$s </p>','tinection'), $comment_object->comment_author, htmlspecialchars( get_comment_link( $comment_id ) ), $post->post_title, $comment_object->comment_content )
		);
	}
	
	//给管理员通知
	if($post_author_email != $admin_email && $parent_id != $admin_email && $admin_notify = '1'){
		$send_email[] = array(
			'address' => $admin_email,
			'uid' => 0,
			'title' => sprintf( __('%1$s上的文章有了新的回复','tinection'), get_bloginfo('name') ),
			'type' => sprintf( __('站点管理','tinection') ),
			'content' => sprintf( __('<style>img{max-width:100%;}</style>%1$s回复了文章<a href="%2$s" target="_blank">%3$s</a>，快去看看吧：<br> %4$s','tinection'), $comment_object->comment_author, htmlspecialchars( get_comment_link( $comment_id ) ), $post->post_title, $comment_object->comment_content )
		);
	}
	
	if( $send_email ){
	
		foreach ( $send_email as $email ){
			$content = tin_mail_template($email['type'],$email['content']);
			// 添加消息通知
			if(intval($email['uid'])>0){
				 add_tin_message($email['uid'], 'unread', current_time('mysql'), $email['title'], $email['content']);
			}
			
			// 如果有设置邮箱就发送邮件通知
			if(filter_var( $email['address'], FILTER_VALIDATE_EMAIL)){
				wp_mail( $email['address'], $email['title'], $content, $headers );
			}
		}		
	}
}
//add_action('comment_post', 'comment_mail_notify');
add_action('wp_insert_comment', 'comment_mail_notify' , 99, 2 );
 
/* 自动加勾选栏
/* -------------- */
function add_checkbox() {
  echo '<span class="mail-notify-check"><input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked" style="vertical-align:middle;" /><label for="comment_mail_notify" style="vertical-align:middle;">'.__('有人回复时邮件通知我','tinection').'</label></span>';
}
add_action('comment_form', 'add_checkbox');

/* 投稿文章发表时给作者添加积分和发送邮件通知
/* --------------------------------------------- */
function tin_pending_to_publish( $post ) {
	$rec_post_num = (int)ot_get_option('tin_rec_post_num','5');
	$rec_post_credit = (int)ot_get_option('tin_rec_post_credit','50');
	$rec_post = (int)get_user_meta( $post->post_author, 'tin_rec_post', true );
	if( $rec_post<$rec_post_num && $rec_post_credit ){
		//添加积分
		update_tin_credit( $post->post_author , $rec_post_credit , 'add' , 'tin_credit' , sprintf(__('获得文章投稿奖励%1$s积分','tinection') ,$rec_post_credit) );
		//发送邮件
		$user_email = get_user_by( 'id', $post->post_author )->user_email;
		if( filter_var( $user_email , FILTER_VALIDATE_EMAIL)){
			$email_title = sprintf(__('你在%1$s上有新的文章发表','tinection'),get_bloginfo('name'));
			$email_content = sprintf(__('<h3>%1$s，你好！</h3><p>你的文章%2$s已经发表，快去看看吧！</p>','tinection'), get_user_by( 'id', $post->post_author )->display_name, '<a href="'.get_permalink($post->ID).'" target="_blank">'.$post->post_title.'</a>');
			$message = tin_mail_template('投稿成功',$email_content);
			//~ wp_schedule_single_event( time() + 10, 'tin_send_email_event', array( $user_email , $email_title, $email_content ) );
			$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
			$from = "From: \"" . $name . "\" <$wp_email>";
			$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
			wp_mail( $user_email, $email_title, $message, $headers );
		}
	}	
	update_user_meta( $post->post_author, 'tin_rec_post', $rec_post+1);
}
add_action( 'pending_to_publish',  'tin_pending_to_publish', 10, 1 );

/* WP登录以及登录错误提醒 
/* ------------------------ */
function wp_login_notify()
{
	if(ot_get_option('login_success_notify')=='on'){
    	date_default_timezone_set ('Asia/Shanghai');
    	$admin_email = get_bloginfo ('admin_email');
    	$to = $admin_email;
		$log = !empty($_POST['log'])?$_POST['log']:$_POST['username'];
		$subject = '你的博客空间登录提醒';
		$message = '<p>你好！你的博客空间(' . get_option("blogname") . ')有登录！</p>' . 
		'<p>请确定是您自己的登录，以防别人攻击！登录信息如下：</p>' . 
		'<p>登录名：' . $log . '<p>' .
		'<p>登录密码：****** <p>' .
		'<p>登录时间：' . date("Y-m-d H:i:s") .  '<p>' .
		'<p>登录IP：' . $_SERVER['REMOTE_ADDR'] . '&nbsp;['.convertip($_SERVER['REMOTE_ADDR']).']<p>';
		$msg = tin_mail_template('站点管理',$message);
		$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
		$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
		$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
		wp_mail( $to, $subject, $msg, $headers );
	}else{return;}
}
add_action('wp_login', 'wp_login_notify');

function wp_login_failed_notify()
{
	if(ot_get_option('login_failed_notify')=='on'){
   		date_default_timezone_set ('Asia/Shanghai');
    	$admin_email = get_bloginfo ('admin_email');
    	$to = $admin_email;
		$subject = '你的博客空间登录错误警告';
		$message = '<p>你好！你的博客空间(' . get_option("blogname") . ')有登录错误！</p>' . 
		'<p>请确定是您自己的登录失误，以防别人攻击！登录信息如下：</p>' . 
		'<p>登录名：' . $_POST['log'] . '<p>' .
		'<p>登录密码：' . $_POST['pwd'] .  '<p>' .
		'<p>登录时间：' . date("Y-m-d H:i:s") .  '<p>' .
		'<p>登录IP：' . $_SERVER['REMOTE_ADDR'] . '&nbsp;['.convertip($_SERVER['REMOTE_ADDR']).']<p>';
		$msg = tin_mail_template('站点管理',$message);
		$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
		$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
		$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
		wp_mail( $to, $subject, $msg, $headers );
	}else{return;}
}
add_action('wp_login_failed', 'wp_login_failed_notify');

/* 邮件消息边栏函数
/* ------------------- */
function tin_message_widget(){
	date_default_timezone_set ('Asia/Shanghai');
	$mail = $_POST['tm'];
	$name = $_POST['tn'];
	$content = $_POST['tc'];
	$admin_email = get_bloginfo ('admin_email');
	$to = $admin_email;
	$subject = '来自['.$name.']的邮件消息';
	$message = '<p>'.$content.'</p>';
	$message = tin_mail_template('邮件消息',$message);
	$wp_email = $mail;
	$from = "From: \"" . $name . "\" <$wp_email>";
	$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
	wp_mail( $to, $subject, $message, $headers );
}
add_action( 'wp_ajax_nopriv_message', 'tin_message_widget' );
add_action( 'wp_ajax_message', 'tin_message_widget' );

/* 发送文件下载链接
/* ------------------- */
function tin_mail_dlinks(){
	date_default_timezone_set ('Asia/Shanghai');
	$mail = $_POST['mail'];
	$pid = $_POST['pid'];
	$name = get_bloginfo('name');
	$title = get_the_title($pid);
	$tlink = get_permalink($pid);
	$dlinks = get_post_meta($pid,'tin_dload',true);
	$dlinksarray = explode(',',$dlinks);
	$content = '<p style="font-size:14px; font-family:Microsoft YaHei,微软雅黑,Arial;">您在博文<a href='.$tlink.'>《'.$title.'》</a>中找到了有用的内容，其下载链接如下：</p>';
	$n=1;
		foreach($dlinksarray as $dlinkarray){$content .= '<p style="font-size:14px; font-family:Microsoft YaHei,微软雅黑,Arial">';$dl_single_arr = explode('|',$dlinkarray);$i=0;
			foreach($dl_single_arr as $dl){if($i==0){$content .= $n.'.'.$dl.': ';$i++;}else if($i==1){$content .= '<a href="'.$dl.'" style="color:#1cbdc5;font-size:14px; font-family:Microsoft YaHei,微软雅黑,Arial">'.$dl.'</a>';$i++;}else{$content .= ' 下载密码: '.$dl;}} 
			$content .= '</p>';
			$n++;
		};
	$admin_email = get_bloginfo ('admin_email');
	$to = $mail;
	$subject = '您在'.$name.'索取的文件下载链接';
	$message = $content.'<p style="font-size:14px; font-family:Microsoft YaHei,微软雅黑,Arial;">感谢您的来访，祝您生活愉快！</p>';
	$message .= tin_mail_relatedpost($pid);
	$message = tin_mail_template('文件下载',$message);
	//$wp_email = $admin_mail;
	$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
	$from = "From: \"" . $name . "\" <$wp_email>";
	$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n"."Bcc: " . $admin_email ."\n";
	wp_mail( $to, $subject, $message, $headers );

	//Download times
	$num = count($dlinksarray);
	$i = 0;
	while ($i<$num) {
		$i++;
		$key = 'post_ndl_'.$i;
		$value = get_tin_meta($key,$pid) ? (int)get_tin_meta($key,$pid) : 0;
		$value++;
		update_tin_meta($key,$value,$pid);
	}
}
add_action( 'wp_ajax_nopriv_maildownload', 'tin_mail_dlinks' );
add_action( 'wp_ajax_maildownload', 'tin_mail_dlinks' );

/* 发送用户下载信息至管理员
/* --------------------------- */
function tin_mail_dlusers(){
	date_default_timezone_set ('Asia/Shanghai');
	$mail = $_POST['mail'];
	$pid = $_POST['pid'];
	$name = get_bloginfo('name');
	$title = get_the_title($pid);
	$tlink = get_permalink($pid);
	$dlusers = get_tin_meta( 'tin_dlusers' , 0 );
	if(!empty($dlusers)){
		$dlusersarray = explode(',',$dlusers);
		$hasmatch = 0;
		foreach ($dlusersarray as $dluser){
			if($dluser==$mail) $hasmatch++;
		}
		if ($hasmatch==0){$dlusers .= ','.$mail;}
	}else{$dlusers = $mail;}
	update_tin_meta('tin_dlusers',$dlusers,$uid=0);
	$content = '<p style="font-size:14px; font-family:Microsoft YaHei,微软雅黑,Arial;">您的博文<a style="font-size:14px; font-family:Microsoft YaHei,微软雅黑,Arial;" href='.$tlink.'>《'.$title.'》</a>中有新用户下载了内容，其邮件地址为：</p>';
	$content .= '<p style="font-size:14px; font-family:Microsoft YaHei,微软雅黑,Arial;">'.$mail.'</p>';
	$content .= '<p style="font-size:14px; font-family:Microsoft YaHei,微软雅黑,Arial;">目前已记录的用户Email如下：</p><p style="font-size:14px; font-family:Microsoft YaHei,微软雅黑,Arial;word-wrap:break-word; word-break:break-all;">'.$dlusers.'</p>';
	$admin_email = get_bloginfo ('admin_email');
	$to = $admin_email;
	$subject = $name.'中有新用户下载了内容';
	$message = tin_mail_template('下载记录',$content);
	//$wp_email = $admin_mail;
	$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
	$from = "From: \"" . $name . "\" <$wp_email>";
	$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
	wp_mail( $to, $subject, $message, $headers );
}
add_action( 'wp_ajax_nopriv_whodownload', 'tin_mail_dlusers' );
add_action( 'wp_ajax_whodownload', 'tin_mail_dlusers' );

/* SMTP发信
/* ---------- */
function tin_phpmailer( $mail ) {
	$smtp_switch = ot_get_option('smtp_switch');
	if($smtp_switch=='on'){
		$mail->IsSMTP();
		$mail->SMTPAuth = true; 
		$mail->isHTML(true);
		$mail->Host = sanitize_text_field(ot_get_option('smtp_host'));
		$mail->Port = intval(ot_get_option('smtp_port'));
		$mail->Username = sanitize_text_field(ot_get_option('smtp_user'));
		$mail->Password = sanitize_text_field(ot_get_option('smtp_pass'));
		if(ot_get_option('smtp_ssl')=='on') $mail->SMTPSecure = 'ssl';
		$mail->From = sanitize_text_field(ot_get_option('smtp_user'));
		$mail->FromName = sanitize_text_field(ot_get_option('smtp_name'));
	}
}
add_action( 'phpmailer_init', 'tin_phpmailer' );

/* 更改WordPress系统邮件默认用户名和邮件地址
/* ------------------------------------------ */
function tin_new_from_name($email){
	$name = get_bloginfo('name');
	return $name;
}
function tin_new_from_email($email){
	$email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
	return $email;
}
add_filter('wp_email_from_name','tin_new_from_name');
add_filter('wp_email_from','tin_new_from_email');

/* 找回密码链接
/* -------------- */
function tin_reset_password_message( $message, $key ) {
	if ( strpos($_POST['user_login'], '@') ) {
		$user_data = get_user_by('email', trim($_POST['user_login']));
	} else {
		$login = trim($_POST['user_login']);
		$user_data = get_user_by('login', $login);
	}
	$user_login = $user_data->user_login;
	$msg = __('有人要求重设如下帐号的密码：'). "\r\n\r\n";
	$msg .= network_site_url() . "\r\n\r\n";
	$msg .= sprintf(__('用户名：%s'), $user_login) . "\r\n\r\n";
	$msg .= __('若这不是您本人要求的，请忽略本邮件，一切如常。') . "\r\n\r\n";
	$msg .= __('要重置您的密码，请打开下面的链接：'). "\r\n\r\n";
	$msg .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') ;
	return $msg;
}
add_filter('retrieve_password_message', 'tin_reset_password_message', null, 2);

?>