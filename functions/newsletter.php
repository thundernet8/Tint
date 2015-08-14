<?php
/**
 * Functions of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.0.2
 * @date      2014.11.27
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/


// 启动主题时清理检查任务
function tin_clear_newsletter_event(){
	global $pagenow;   
	if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ){
		wp_clear_scheduled_hook( 'tin_newsletter_weekly_hook' );
	}
}
add_action( 'load-themes.php', 'tin_clear_newsletter_event' ); 

function tin_newsletter_html_head($type){
	$blogname =  get_bloginfo('name');
	$bloghome = get_bloginfo('url');
	if(ot_get_option('logo-img')):$logo = ot_get_option('logo-img'); endif;
	$html = '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="target-densitydpi=device-dpi, width=800, initial-scale=1, maximum-scale=1, user-scalable=1"><style>
	*{margin:0;padding:0;border:0;}
	.clear{clear:both;}
	#newsletter-header{max-width:800px;height:50px;background:#2e3639;margin:auto;border:1px solid #2e3639;}
	#newsletter-footer{max-width:800px;height:30px;background:#1e2629;text-align:center;padding:5px 0;color:#fff;font-family:微软雅黑;font-size:13px;line-height:30px;margin:auto;border:1px solid #1e2629;}
	#newsletter-logo{width:auto;height:40px;float:left;margin-left:10px;margin-top:5px;}
	#newsletter-logo img{height:100%;}
	#newsletter-blogname{float:left;font-weight:bold;font-size:20px;line-height:40px;margin-left:10px;margin-top:5px;color:#fff;}
	#newsletter-type{float:right;margin-right:20px;font-size:16px;line-height:40px;font-style:italic;color:#fff;margin-top:5px;}
	#newsletter-wrap{max-width:800px;margin:auto!important;font-family: "Microsoft YaHei","微软雅黑","Open Sans",Arial,"Hiragino Sans GB","STHeiti","WenQuanYi Micro Hei",SimSun,sans-serif;font-size:13px;background:#fff;position:relative;color:#666;padding:10px 0 0;border-width:1px 1px 0 1px;border-style:solid;border-color:#ddd;margin:10px auto 0;}
	.newsletter-col{border-top:2px solid #fff;padding:5px;border-bottom:1px solid #ddd;margin-bottom:10px;}
	.newsletter-col:hover{border-top:2px solid #1cbdc5;}
	.newsletter-thumbnail{width:250px;height:156px;border:1px solid #ddd;padding:2px;float:left;position:relative;}
	.newsletter-thumbnail img{width:100%;height:100%;}
	.newsletter-entry-text{padding:0 10px 0 270px;}
	.newsletter-entry-text h3{line-height: 120%;height:40px;overflow:hidden;margin-top:5px;}
	.newsletter-entry-text h3 a{font-size:16px;font-weight:bold;color:#000;text-decoration:none;}
	.newsletter-entry-text h3 a:hover{color:#1cbdc5;}
	.newsletter-entry-text p {font-size: 14px;text-indent: 2em;}
	.newsletter-entry-meta {border-top: 1px dotted #e5e5e5;padding: 8px;overflow: hidden;margin-top:10px;}
	.newsletter-meta-list {font-style:italic;color: #aaa;font-size: 12px;}
	.newsletter-meta-list-time{float:left;}
	.newsletter-meta-list-views {float: left;text-align: center;margin-left: 20px;}
	.newsletter-meta-list-comments{float: right;}
	.newsletter-meta-list-comments a{text-decoration:none;color:#1cbdc5;}
	.newsletter-meta-list-comments a:hover{text-decoration:underline;}
	#newsletter-intro{margin:auto;max-width:800px;margin-top:-10px;border-top:0;border-bottom:1px solid #ddd;}
	#open-in-browser{padding:10px;font-size:13px;text-align:center;}
	#open-in-browser a{font-size:13px;color:#f00 !important;text-decoration:underline;}
	#open-in-browser a:hover{}
	#newsletter-intro p{padding:5px 10px 10px 10px;font-size:13px;font-style:italic;color:#aaa;}
	#newsletter-intro a{color:#1cbdc5;}
	#content{font-size:14px;color:#666;padding:0 10px 10px;border-bottom:1px solid #ddd;margin-bottom:10px;}
	#content h2,#content h3{font-size:16px;font-weight:bold;margin:10px 0;line-height:150%;}
	#content,#content p{line-height:150%;}
	#content::selection{background:#1cbdc5;color:#fff;}
	#content a{color:#1cbdc5;text-decoration:none;}
	#content a:hover{text-decoration:underline;}
	#content blockquote{font-style:italic;color:#888;font-size:13px;border-left:2px solid #e25442;padding:10px 0 10px 10px;margin-top:10px;}
	@media screen and (max-width: 500px){#newsletter-wrap h3 a{font-size:14px;};#newsletter-wrap p{font-size:12px;}}
	</style></head><body>';
	$html .= '<div id="newsletter-header">';
	if(!empty($logo)){$html .= '<span id="newsletter-logo"><a href="'.$bloghome.'" alt="'.$blogname.'" title="'.$blogname.'"><img src="'.$logo.'" /></a></span>';}
	$html .= '<a href="'.$bloghome.'" alt="'.$blogname.'" title="'.$blogname.'"><span id="newsletter-blogname">'.$blogname.'</span></a><span id="newsletter-type">'.$type.'</span></div>';
	$html .= '<div id="newsletter-wrap">';
	return $html;
}

function tin_newsletter_html_foot($type,$num){
	$blogname =  get_bloginfo('name');
	$bloghome = get_bloginfo('url');
	$newssuffix = ot_get_option('page_newsletter','newsletter'); if(stripos($newssuffix,'?')===false){$newspage=get_bloginfo('url').'/'.$newssuffix.'?';}else{$newspage=get_bloginfo('url').'/'.$newssuffix.'&';}
	$html = '<div id="newsletter-intro">';
	if(empty($num)||$num==0){$html .= '';}else{$html .= '<div id="open-in-browser">如果你无法正确查看该邮件，请尝试<a href="'.$newspage.$type.'='.$num.'" target="_blank">在浏览器中阅读</a>.&nbsp;<a href="'.$bloghome.'/guestbook" target="_blank" title="反馈建议">反馈建议?</a></div><p>—— 本邮件由系统自动发送，如果你不愿意接收此类邮件，可以<a href="'.$newspage.'action=unsubscribe" target="_blank">点击退订</a>.</p>';}
	$html .= '</div></div>';
	if(!empty($num)&&$num!=0){$html .= '<div id="newsletter-footer">&copy;'.date(' Y ').'All Rights Reserved&nbsp;|&nbsp;Powered by <a style="color:#1cbdc5;" href="'.$bloghome.'" title="'.$blogname.'" target="_blank">'.$blogname.'</a>&nbsp;&&nbsp;<a style="color:#1cbdc5;" href="http://www.zhiyanblog.com" title="Tinection主题" target="_blank">Tinection</a></div>';}
	$html .= '</body>';
	return $html;
}

function newsletter_posts_issue($issue,$show_browser_link=0){
	date_default_timezone_set ('Asia/Shanghai');
	global $wpdb;
	$issue_posts = get_tin_meta('issue');
	$issue_posts = explode(',',$issue_posts);
	$issue--;
	$the_issue_posts = isset($issue_posts[$issue]) ? $issue_posts[$issue] : '';
	$the_issue_posts_array = explode('|',$the_issue_posts);
	$the_issue_posts_str = implode(',',$the_issue_posts_array);
	$num = $issue+1;
	$para = '邮件订阅-issue#'.$num;
	$html = tin_newsletter_html_head($para);
	if (!empty($the_issue_posts)):		
	$newsletter_posts = $wpdb->get_results("SELECT DISTINCT $wpdb->posts.* FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND id IN ($the_issue_posts_str) ORDER BY post_date DESC");
	foreach($newsletter_posts as $post){
		$post_id = $post->ID;
		$post_date = get_the_date('Y-m-j h:i:s',$post);
		$post_cat = get_the_category($post);
		$post_views = get_tin_traffic( 'single' , $post_id );
		$post_comments = $post->comment_count;
		$post_title = get_the_title($post);
		$post_url = get_permalink($post);
		$post_excerpt = wp_trim_words($post->post_content,120);
		$pre_match_images = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_image = $matches [1] [0];
		$random = mt_rand(1, 25);
		if(has_post_thumbnail($post_id)){$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post_id));$thumbnail = $thumbnail[0];}elseif(!empty($first_image)){$thumbnail = $first_image;}else{$thumbnail = get_bloginfo('stylesheet_directory').'/images/random/'.$random.'.jpg';}
		$html .= newsletter_posts_loop_template($post_title,$post_url,$post_excerpt,$thumbnail,$post_date,$post_cat,$post_views,$post_comments);
	}	
	$html .= '</div>';
	else : $html .= '<div style="height:20px;margin-bottom:20px;padding:0 10px;">未找到相关内容！</div>'; endif;
	if($show_browser_link!=0){$issue_num = $num;}else{$issue_num = $show_browser_link;}
	$html .= tin_newsletter_html_foot('issue',$issue_num);
	return $html;
}

function newsletter_posts_loop_template($title,$permalink,$excerpt,$thumbnail,$time,$cat,$views,$comments){
	$content = '<article class="newsletter-col clear"><a href="'.$permalink.'" title="'.$title.'" class="newsletter-thumbnail"><img class="newsletter-thumb" src="'.$thumbnail.'"></a><div class="newsletter-entry-text"><h3><a href="'.$permalink.'" title="'.$title.'">'.$title.'</a></h3><p>'.$excerpt.'</p></div><div class="clear"></div><div class="newsletter-entry-meta"><div class="newsletter-meta-list"><div class="newsletter-meta-list-time">'.$time.'</div><div class="newsletter-meta-list-views">&nbsp;&nbsp;&nbsp;'.$cat[0]->name.'&nbsp;&nbsp;</div><div class="newsletter-meta-list-views">&nbsp;&nbsp;&nbsp;'.$views.'次浏览&nbsp;&nbsp;</div><div class="newsletter-meta-list-comments"><a href="'.$permalink.'#comments">'.$comments.'条评论</a></div></div></div><div class="clear"></div></article>';
	return $content;
}

function newsletter_posts_special($special,$show_browser_link=0){
	$special_meta = get_tin_meta('special',$special) ? get_tin_meta('special',$special) : '未找到相关内容!';
	$para = '专刊速递-special#'.$special;
	$html = tin_newsletter_html_head($para);
	$html .= '<div id="content">'.$special_meta.'</div>';
	if($show_browser_link!=0){$special_num = $special;}else{$special_num = $show_browser_link;}
	$html .= tin_newsletter_html_foot('special',$special_num);
	return $html;
}

//添加定时任务
function tin_newsletter_setup_schedule() {
	if ( ! wp_next_scheduled( 'tin_newsletter_weekly_hook' ) ) {
	// 1416621600 是 GMT+8 2014/11/22 10:00 的时间戳
		wp_schedule_event( '1416621600', 'weekly', 'tin_newsletter_weekly_hook');
	}
}
add_action( 'wp', 'tin_newsletter_setup_schedule' );

//定时更新newsletter发送文章的ID列表meta @wp_tin_meta @meta_key issue user_id=0| special user_id=special_id，然后发送最新一期newsletter
function tin_newsletter_weekly_event(){
	if (ot_get_option('newsletter')=='on'):
	global $wpdb;
	date_default_timezone_set ('Asia/Shanghai');
	$newsletter_posts = $wpdb->get_results("SELECT DISTINCT $wpdb->posts.ID FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND post_date > date_sub( NOW(), INTERVAL 1 WEEK ) ORDER BY post_date DESC");
	$arr = array();
	if(!empty($newsletter_posts)){
		foreach($newsletter_posts as $post){
			$the_post_id_array[] = $post->ID;
			$arr = $the_post_id_array;
		}
		$str = implode('|',$arr);
		$issue_meta = get_tin_meta('issue');
		$issue_meta_arr = explode(',', $issue_meta);
		if(in_array($str, $issue_meta_arr)) return;
		if(!empty($issue_meta)){
			$issue_meta .= ','.$str;
		}else{
			$issue_meta = $str;
		}
		update_tin_meta('issue',$issue_meta);
		$issue_meta = get_tin_meta('issue');
		$issue_meta_array = explode(',',$issue_meta);
		$issue_num = count($issue_meta_array);
		//获取newsletter
		$html = newsletter_posts_issue($issue_num,1);
		//获取订阅用户
		$subscribers = get_tin_meta('tin_dl_users');
		$subscribers2 = get_tin_meta('tin_subscribers');
		if(!empty($subscribers)){$subscribers.=','.$subscribers2;}else{$subscribers=$subscribers2;}
		$subscribers_array =explode(',',$subscribers);
		//循环发送
		if(!empty($subscribers_array)){
			$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
			$from = "From: \"" . $name . "\" <$wp_email>";
			$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
			$title = get_bloginfo('name').'邮件周刊(第'.$issue_num.'期)';
			foreach($subscribers_array as $subscriber){
				wp_mail( $subscriber, $title, $html, $headers );
			}	
		}else{return;}	
	}else{
		return;
	}
	else: return; endif;	
}
add_action('tin_newsletter_weekly_hook','tin_newsletter_weekly_event');

//订阅
function tin_newsletter_subscribe(){
	$email = $_POST['email'];
	$admin_email = get_option('admin_email');
	$subscribers = get_tin_meta('tin_subscribers');
	$subscribers_array = explode(',',$subscribers);
	$newssuffix = ot_get_option('page_newsletter','newsletter');$newspage=get_bloginfo('url').'/'.$newssuffix;
	if(!in_array($email,$subscribers_array)):
	if(!empty($subscribers)){$subscribers.=','.$email;}else{$subscribers=$email;}
	update_tin_meta('tin_subscribers',$subscribers);
	$title = '订阅'.get_bloginfo('name').'成功';
	$title_admin = get_bloginfo('name').'有新用户订阅';
	$type = '邮件订阅';
	$content = '<p>你已成功订阅<a href="'.get_bloginfo('url').'" target="_blank">'.get_bloginfo('name').'</a>！</p><p>我们将以周刊的形式推送最新文章到你的邮箱，欢迎你随时浏览。</p><p>你也可以现在查看往期期刊，<a href="'.$newspage.'" target="_blank" style="color:#1cbdc5;text-decoration:underline;">点击查看</a>。</p><p>感谢你对本站的支持，祝你生活愉快!</p>';
	$content_admin = '<p>您的站点<a href="'.get_bloginfo('url').'" target="_blank"> '.get_bloginfo('name').' </a>新增订阅用户：</p><p style="border-bottom:#ddd 1px solid;border-left:#ddd 1px solid;padding-bottom:20px;background-color:#eee;margin:15px 0px;padding-left:20px;padding-right:20px;border-top:#ddd 1px solid;border-right:#ddd 1px solid;padding-top:20px">'.$email.'</p>';
	tin_basic_mail('',$email,$title,$content,$type);
	tin_basic_mail('',$admin_email,$title_admin,$content_admin,$type);
	else : return; endif;
}
add_action( 'wp_ajax_nopriv_subscribe', 'tin_newsletter_subscribe' );
add_action( 'wp_ajax_subscribe', 'tin_newsletter_subscribe' );

function newsletter_subscribe_template(){
	$html = '<div style="width:100%;min-height:300px;position:relative;background:#fff;"><div style="width:300px;height:120px;position:absolute;top:30%;left:50%;margin-left:-150px;margin-top:-60px;border:1px solid #ddd;box-shadow:0 0 5px #ddd;text-align:center;"><span id="subscribe-span" style="margin-top:35px;display:block;font-size:13px;"><input type="text" name="subscribe" id="subscribe" style="height:34px;margin:5px 5px 5px 0;width:180px;border-radius:3px;padding-left:10px;vertical-align:bottom;" placeholder="Email"><button id="subscribe" class="btn btn-success">订阅</button></span><div id="subscribe-msg" style="display:none;margin-top:5px;margin-left:auto;margin-right:auto;font-size:12px;color:#f00;"></div></div></div>';
	return $html;
}

//退订
function tin_newsletter_unsubscribe(){
	$email = $_POST['email'];
	$tin_dlusers = get_tin_meta('tin_dlusers') ? get_tin_meta('tin_dlusers') : '';
	$tin_dlusers_array = explode(',',$tin_dlusers);
	$tin_dlusers_search = array_search($email,$tin_dlusers_array);
	$tin_subscribers = get_tin_meta('tin_subscribers') ? get_tin_meta('tin_subscribers') : '';
	$tin_subscribers_array = explode(',',$tin_subscribers);
	$tin_subscribers_search = array_search($email,$tin_subscribers_array);
	$newssuffix = ot_get_option('page_newsletter','newsletter'); if(stripos($newssuffix,'?')===false){$newspage=get_bloginfo('url').'/'.$newssuffix.'?action=unsubscribe';}else{$newspage=get_bloginfo('url').'/'.$newssuffix.'&action=unsubscribe';}
	if ($tin_dlusers_search!=''||$tin_subscribers_search!=''):
		$meta_key = 'unsubscribe_'.$email;
		$meta_value = md5(mt_rand(0,1000));
		update_tin_meta($meta_key,$meta_value);
		$title = get_bloginfo('name').'邮件周刊确认退订';
		$type = '邮件退订';
		$url = $newspage.'&email='.$email.'&nonce='.$meta_value;
		$content = '<p>请点击以下链接完成退订！</p><p><a href="'.$url.'" target="_blank">'.$url.'</a></p>';
		tin_basic_mail('',$email,$title,$content,$type);
		$msg = '请查收你的邮件并点击邮件内链接完成退订！';
	else : $msg = '你目前没有订阅该栏目！'; endif;
	$msg_arr = array('msg'=>$msg);
	$msg_json = json_encode($msg_arr);
	echo $msg_json;
	exit;
}
add_action( 'wp_ajax_nopriv_unsubscribe', 'tin_newsletter_unsubscribe' );
add_action( 'wp_ajax_unsubscribe', 'tin_newsletter_unsubscribe' );

function newsletter_unsubscribe_template(){
	$html = '<div style="width:100%;min-height:300px;position:relative;background:#fff;"><div style="width:300px;height:120px;position:absolute;top:30%;left:50%;margin-left:-150px;margin-top:-60px;border:1px solid #ddd;box-shadow:0 0 5px #ddd;text-align:center;"><span id="unsubscribe-span" style="margin-top:35px;display:block;font-size:13px;"><input type="text" name="unsubscribe" id="unsubscribe" style="height:34px;margin:5px 5px 5px 0;width:180px;border-radius:3px;padding-left:10px;vertical-align:bottom;" placeholder="Email"><button id="unsubscribe" class="btn btn-warning">退订</button></span><div id="unsubscribe-msg" style="display:none;margin-top:5px;margin-left:auto;margin-right:auto;font-size:12px;color:#f00;"></div></div></div>';
	return $html;
}

//新专刊邮件
function tin_newsletter_newspecial($title,$post){
	$special_id = get_tin_meta('special_id') ? (int)get_tin_meta('special_id') : 0;
	$latest = get_tin_meta('special',$special_id);
	if($post!==$latest):
	$special_id++;
	update_tin_meta('special',$post,$special_id);
	update_tin_meta('special_id',$special_id);
	$html = newsletter_posts_special($special_id,1);
	//获取订阅用户
	$subscribers = get_tin_meta('tin_dl_users');
	$subscribers2 = get_tin_meta('tin_subscribers');
	if(!empty($subscribers)){$subscribers.=','.$subscribers2;}else{$subscribers=$subscribers2;}
	$subscribers_array =explode(',',$subscribers);
	if(!empty($subscribers_array)){
		$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
		$from = "From: \"" . $name . "\" <$wp_email>";
		$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
		$title = get_bloginfo('name').'邮件专刊('.$title.')';
			foreach($subscribers_array as $subscriber){
				wp_mail( $subscriber, $title, $html, $headers );
			}	
	}else{
		return;
	} else : return; endif;
}

// @function 删除可转数组字符串的指定值
function tin_delete_string_specific_value($separator,$string,$value){
	$arr = explode($separator,$string);
	$key =array_search($value,$arr);
	array_splice($arr,$key,1);
	$str_new = implode($separator,$arr);
	return $str_new;
}
?>