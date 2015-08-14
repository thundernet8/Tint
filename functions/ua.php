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

function getbrowser($Agent){
    if ($Agent == "")
		$Agent = $_SERVER['HTTP_USER_AGENT'];
        $browser = '';
        $browserver = '';

    if(preg_match('/Mozilla/i', $Agent) && preg_match('/Chrome/i', $Agent))
        {
            $temp = explode('(', $Agent);
            $Part = $temp[2];
            $temp = explode('/', $Part);
            $browserver = $temp[1];
            $temp = explode(' ', $browserver);
            $browserver = $temp[0];
            $browser = 'Chrome';
        }
	if(preg_match('/Mozilla/i', $Agent) && preg_match('/Firefox/i', $Agent))
        {
            $temp = explode('(', $Agent);
            $Part = $temp[1];
            $temp = explode('/', $Part);
            $browserver = $temp[2];
            $temp = explode(' ', $browserver);
            $browserver = $temp[0];
           $browser = 'Firefox';
        }
    if(preg_match('/Mozilla/i', $Agent) && preg_match('/Opera/i', $Agent)) 
        {
            $temp = explode('(', $Agent);
            $Part = $temp[1];
            $temp = explode(')', $Part);
            $browserver = $temp[1];
            $temp = explode(' ', $browserver);
            $browserver = $temp[2];
            $browser = 'Opera';
        }
	if(preg_match('/Mozilla/i', $Agent) && preg_match('/UCBrowser/i', $Agent)) 
        {
            $temp = strrchr($Agent,'/');
            $browserver = substr($temp,1);
            $browser = 'UC';
        }
    if(preg_match('/Mozilla/i', $Agent) && preg_match('/MSIE/i', $Agent))
        {
            $temp = explode('(', $Agent);
            $Part = $temp[1];
            $temp = explode(';', $Part);
            $Part = $temp[1];
            $temp = explode(' ', $Part);
            $browserver = $temp[2];
            $browser = 'Internet Explorer';
        }
    //其余浏览器按需自己增加
    if($browser != '')
        {
            $browseinfo = $browser.' '.$browserver;
        } 
        else
        {
            $browseinfo = $Agent;
        }
		
        return $browseinfo;
}

function outputbrowser($Agent){
	$ua_info = getbrowser($Agent);
	if(!empty($ua_info)){
		$br = explode(' ',$ua_info);
		switch($br[0]){
			case (stristr($br[0],'chrome')):
				$br_img = 'chrome.png';
				break;
			case (stristr($br[0],'internet')):
				$br_img = 'ie.png';
				break;
			case (stristr($br[0],'firefox')):
				$br_img = 'firefox.png';
				break;
			case (stristr($br[0],'opera')):
				$br_img = 'opera.png';
				break;
			case (stristr($br[0],'Safari')):
				$br_img = 'safari.png';
				break;
			case (stristr($br[0],'uc')):
				$br_img = 'ucweb.png';
				break;
			default:
				$br_img = '';
				break;
		}
		$br_img_output = $br_img !== '' ? '<span class="comment_author_ua tooltip-trigger" title="'.$ua_info.'"><img class="ua_img" src="'.get_bloginfo('template_directory').'/images/ua/'.$br_img.'" /></span>' : '';
		return $br_img_output;
	}
	return '';
}
	
?>