<?php
/**
 * Main Function of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.3
 * @date      2015.1.5
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<?php
/* 下载页面资源列表
/* ----------------- */ 	
function tin_dl_page_res_inner($pid,$uid){
	$author = get_post_field('post_author',$pid) ? get_post_field('post_author',$pid) : -1;
	$dlinks = get_post_meta($pid,'tin_dload',true);
	$saledls = get_post_meta($pid,'tin_saledl',true);
	$dlinksarray = explode(',',$dlinks);
	$saledlsarray = explode(',', $saledls);
	$content = '';$n=1;
	if(!empty($dlinks)){
		foreach($dlinksarray as $dlinkarray){$content .= '<p>';$dlinkarraysingle = explode('|',$dlinkarray);
			$d1 = isset($dlinkarraysingle[0]) ? $dlinkarraysingle[0] : '';
			$d2 = isset($dlinkarraysingle[1]) ? $dlinkarraysingle[1] : '';
			$d3 = isset($dlinkarraysingle[2]) ? $dlinkarraysingle[2] : '';
			$metakey = 'post_ndl_'.$n.'';
			$dltimes = get_tin_meta($metakey,$pid) ? (int)get_tin_meta($metakey,$pid) : 0;
			$content .= $n.'.'.$d1.': <a href="'.$d2.'" target="_blank" class="downldlink" id="'.$metakey.'">'.__('下载地址','tinection').'</a>&nbsp;( '.$dltimes.'次下载 )';
			if(!empty($d3)){$content .= '<p>'.__('下载密码:','tinection').$d3.'</p>';}
			$content .= '</p>';
			$n++;};
	}
	if(!empty($uid)&&$uid!=0&&!empty($saledls)){
		$saletimes = get_tin_meta($metakey2,$pid) ? (int)get_tin_meta($metakey2,$pid) : 0;
		$content .= '<h4>'.__('积分下载资源','tinection').'</h4>';
		$m=1;
		foreach($saledlsarray as $saledlarray){
			$saledlsingle = explode('|', $saledlarray);
			$sd1 = isset($saledlsingle[0]) ? $saledlsingle[0] : '';
			$sd2 = isset($saledlsingle[1]) ? $saledlsingle[1] : '';
			$sd3 = isset($saledlsingle[2]) ? (int)$saledlsingle[2] : 0;
			$sd4 = isset($saledlsingle[3]) ? $saledlsingle[3] : '';
			$metakey2 = 'post_sdl_'.$m.'';
			$metakey3 = $pid.'_'.$m.'';
			$saletimes = get_tin_meta($metakey2,$pid) ? (int)get_tin_meta($metakey2,$pid) : 0;
			$buy = get_tin_meta('buy_post_sdl',$uid);
			$buyarray = explode(',', $buy);
			if(in_array($metakey3, $buyarray)){
				$content .= '<p>'.$m.'. '.$sd1.' / '.$saletimes.__('人已购买','tinection').' ( '.__('你已购买，','tinection').'<a href="'.$sd2.'" target="_blank" class="clicktodl">'.__('点击下载','tinection').'</a> ';
				if(!empty($sd4)){$content .= __('下载密码：','tinection').$sd4.'';}
				$content .= ')</p>';
			}elseif($author==$uid){
				$content .= '<p>'.$m.'. '.$sd1.' / '.$saletimes.__('人已购买','tinection').' ( '.__('你是资源发布者，','tinection').'<a href="'.$sd2.'" target="_blank" class="clicktodl">点击下载</a> ';
				if(!empty($sd4)){$content .= __('下载密码：','tinection').$sd4.'';}
				$content .= ')</p>';
			}else{
				$content .= '<p>'.$m.'. '.$sd1.' / '.$saletimes.__('人已购买','tinection').' ( <span id="'.$metakey3.'" class="buysaledl">'.__('点击购买','tinection').'</span> '.__('花费','tinection').$sd3.__('积分','tinection').' )</p>';
			}
			$m++;
		}
	}else{
		if(!empty($saledls)){
			$content .= __('<h4>以下收费资源需要<span class="dl-page-login-pop user-login">登录</span>才能下载</h4>','tinection');
			$m=1;
			foreach($saledlsarray as $saledlarray){
				$saledlsingle = explode('|', $saledlarray);
				$sd1 = isset($saledlsingle[0]) ? $saledlsingle[0] : '';
				$sd2 = isset($saledlsingle[1]) ? $saledlsingle[1] : '';
				$sd3 = isset($saledlsingle[2]) ? (int)$saledlsingle[2] : 0;
				$metakey2 = 'post_sdl_'.$m.'';
				$saletimes = get_tin_meta($metakey2,$pid) ? (int)get_tin_meta($metakey2,$pid) : 0;
				$content .= '<p>'.$m.'. '.$sd1.'&nbsp;/&nbsp;'.$saletimes.__(' 人已购买. ( 需要<span style="color:red;">','tinection').$sd3.__('积分','tinection').'</span> )</p>';
				$m++;
			}
		}
	}
	if(!empty($dlinks) || !empty($saledls)):echo $content;else:echo'<p>'.__('未找到相关的下载内容，请确认您的链接无误或搜索重试','tinection').'</p>';endif;
}

/* 资源下载计数
/* -------------- */
function tin_downld_times(){
	$key = $_POST['key'];
	$pid = $_POST['pid'];
	$uid = get_post_field('post_author',$pid);
	$value = get_tin_meta($key,$pid) ? (int)get_tin_meta($key,$pid) : 0;
	$value++;
	//更新下载数
	update_tin_meta($key,$value,$pid);
	//给资源作者添加积分
	tin_resource_dl_add_credit($uid,$pid,$key);
}
add_action( 'wp_ajax_nopriv_downldtimes', 'tin_downld_times' );
add_action( 'wp_ajax_downldtimes', 'tin_downld_times' );

/* 积分下载资源提醒
/* ----------------- */
function tin_saledl_pop(){
	$sid = $_POST['sid'];
	$pid = $_POST['pid'];
	$current_user = wp_get_current_user();
	$uid = $current_user->ID;
	$saledl = get_post_meta($pid,'tin_saledl',true);
	$saledlarray = explode(',', $saledl);
	$sidarray = explode('_', $sid);
	$sidarray[1] = isset($sidarray[1]) ? (int)$sidarray[1] : 1;
	$sidarray[1]--;
	$saledlsinglearray = explode('|', $saledlarray[$sidarray[1]]);
	$saledlsinglearray[2] = isset($saledlsinglearray[2]) ? (int)$saledlsinglearray[2] : 0;
	$price = $saledlsinglearray[2];
	$credit = (int)get_user_meta($uid,'tin_credit',true);
	$msg = '';
	if($price>$credit) {$enough = 0; $msg = '抱歉，积分不足，<a href="'.tin_get_user_url('credit').'" target="_blank">充值积分</a>';} else {$enough = 1;}
	$return = array('enough'=>$enough,'price'=>$price,'credit'=>$credit,'sid'=>$sid, 'msg'=>$msg);
	$return = json_encode($return);
	echo $return;
	exit;
}
add_action( 'wp_ajax_nopriv_popsaledl', 'tin_saledl_pop' );
add_action( 'wp_ajax_popsaledl', 'tin_saledl_pop' );

/* 积分下载资源确认购买
/* ---------------------- */
function tin_saledl_confirm_buy(){
	$sid = $_POST['sid'];
	$pid = $_POST['pid'];
	$uid = $_POST['uid'];
	$saledl = get_post_meta($pid,'tin_saledl',true);
	$saledlarray = explode(',', $saledl);
	$sidarray = explode('_', $sid);
	$sidarray[1] = isset($sidarray[1]) ? (int)$sidarray[1] : 1;
	$key = $sidarray[1]-1;
	$saledlsinglearray = explode('|', $saledlarray[$key]);
	$saledlsinglearray[2] = isset($saledlsinglearray[2]) ? (int)$saledlsinglearray[2] : 0;
	$price = $saledlsinglearray[2];
	$credit = (int)get_user_meta($uid,'tin_credit',true);
	if($price<=$credit){
		//查看是否购买防止重扣
		$hasbuy = get_tin_meta('buy_post_sdl',$uid);
		$hasbuyarray = explode(',', $hasbuy);
		if(!in_array($sid, $hasbuyarray)){
			//扣除积分//发送站内信
			update_tin_credit( $uid , $price , 'cut' , 'tin_credit' , '下载资源消费'.$price.'积分' );
			//更新已消费积分
			if(get_user_meta($uid,'tin_credit_void',true)){
				$void = get_user_meta($uid,'tin_credit_void',true);
				$void = $void + $price;
				update_user_meta($uid,'tin_credit_void',$void);
			}else{
				add_user_meta( $uid,'tin_credit_void',$price,true );
			}
			
			//给资源发布者添加积分并更新积分消息记录
			tin_resource_dl_add_credit($uid,$pid,$sid);//默认下载奖励积分
			$author = get_post_field('post_author',$pid);
			update_tin_credit(  $author , $price , 'add' , 'tin_credit' , sprintf(__('你发布的文章《%1$s》中收费资源被其他用户下载，获得售价%2$s积分','tinection') ,get_post_field('post_title',$pid),$price) );//出售获得积分
			//添加用户已下载资源
			if(empty($hasbuy)){
				update_tin_meta('buy_post_sdl',$sid,$uid);
			}else{
				$hasbuy .= ','.$sid;
				update_tin_meta('buy_post_sdl',$hasbuy,$uid);
			}
			//更新资源购买次数
			$sourcemetakey = 'post_sdl_'.$sidarray[1];
			$sales = get_tin_meta($sourcemetakey,$pid) ? (int)get_tin_meta($sourcemetakey,$pid) : 0;
			$sales++;
			update_tin_meta($sourcemetakey,$sales,$pid);
			//发送邮件
			$user_info = get_userdata($uid);
			$to = $user_info->user_email;
			$title = '你在'.get_bloginfo('name').'购买的内容';
			$saledlsinglearray[0] = isset($saledlsinglearray[0]) ? $saledlsinglearray[0] : '';
			$saledlsinglearray[1] = isset($saledlsinglearray[1]) ? $saledlsinglearray[1] : '';
			$saledlsinglearray[3] = isset($saledlsinglearray[3]) ? $saledlsinglearray[3] : '';
			$content = '<p>你在'.get_bloginfo('name').'使用积分下载了以下内容:</p><p>'.$saledlsinglearray[0].'</p><p>下载链接：<a href="'.$saledlsinglearray[1].'" title="'.$saledlsinglearray[0].'" target="_blank">'.$saledlsinglearray[1].'</a></p><p>下载密码：'.$saledlsinglearray[3].'</p><p>感谢你的来访与支持，祝生活愉快！</p>';
			$type = '付费下载';
			tin_basic_mail('',$to,$title,$content,$type);
			$success = 1;
			$credit = $credit - $price;
		}else{$success=2;}
	} else {$success = 0;}
	$return = array('success'=>$success,'price'=>$price,'credit'=>$credit);
	$return = json_encode($return);
	echo $return;
	exit;
}
add_action( 'wp_ajax_nopriv_confirmbuy', 'tin_saledl_confirm_buy' );
add_action( 'wp_ajax_confirmbuy', 'tin_saledl_confirm_buy' );
?>