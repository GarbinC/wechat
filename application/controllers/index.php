<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Index extends CI_Controller{
		private $_data;
		private $_uname;
		private $_password;
		private $_loginurl;

		function __construct(){
			parent::__construct();
			$this->_uname = 'qiudalea';
			$this->_password = 'wojiushiwo';
			$this->_loginurl = 'https://mp.weixin.qq.com/cgi-bin/login';
			//验证消息来源

			//$this->wechat->valid();
		}

function ihttp_response_parse($data, $chunked = false) {
	$rlt = array();
	$pos = strpos($data, "\r\n\r\n");
	$split1[0] = substr($data, 0, $pos);
	$split1[1] = substr($data, $pos + 4, strlen($data));
	
	$split2 = explode("\r\n", $split1[0], 2);
	preg_match('/^(\S+) (\S+) (\S+)$/', $split2[0], $matches);
	$rlt['code'] = $matches[2];
	$rlt['status'] = $matches[3];
	$rlt['responseline'] = $split2[0];
	$header = explode("\r\n", $split2[1]);
	$isgzip = false;
	$ischunk = false;  
	foreach ($header as $v) {
		$row = explode(':', $v);
		$key = trim($row[0]);
		$value = trim($row[1]);
		if (is_array($rlt['headers'][$key])) {
			$rlt['headers'][$key][] = $value;
		} elseif (!empty($rlt['headers'][$key])) {
			$temp = $rlt['headers'][$key];
			unset($rlt['headers'][$key]);
			$rlt['headers'][$key][] = $temp;
			$rlt['headers'][$key][] = $value;
		} else {
			$rlt['headers'][$key] = $value;
		}
		if(!$isgzip && strtolower($key) == 'content-encoding' && strtolower($value) == 'gzip') {
			$isgzip = true;
		}
		if(!$ischunk && strtolower($key) == 'transfer-encoding' && strtolower($value) == 'chunked') {
			$ischunk = true;
		}
	}
	if($chunked && $ischunk) {
		$rlt['content'] = ihttp_response_parse_unchunk($split1[1]);
	} else {
		$rlt['content'] = $split1[1];
	}
	if($isgzip && function_exists('gzdecode')) {
		$rlt['content'] = gzdecode($rlt['content']);
	}

	$rlt['meta'] = $data;
	if($rlt['code'] == '100') {
		return ihttp_response_parse($rlt['content']);
	}
	return $rlt;
}

				
		
		//test 
		function index(){	
			if( function_exists('curl_init') && function_exists('curl_exec')){
				$timeout = 60;
				$post_arr = array(
						'username' => 'qiudalea',
						'pwd' => md5( 'wojiushiwo'),
						'imgcode' => '',
						'f' => 'json'
					);
				$post_string = http_build_query($post_arr);
				$ch = curl_init();
				curl_setopt( $ch , CURLOPT_URL , $this->_loginurl);
				curl_setopt( $ch , CURLOPT_RETURNTRANSFER , 1);
				curl_setopt( $ch , CURLOPT_HEADER , 1);
				curl_setopt( $ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSLVERSION, 3);
				curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1');
				curl_setopt($ch, CURLOPT_REFERER, 'https://mp.weixin.qq.com');
				$data = curl_exec($ch);
				$status = curl_getinfo($ch);
				$errno = curl_errno($ch);
				$error = curl_error($ch);
				curl_close($ch);
				$data = explode( "\r\n\r\n" , $data);
				dump( $data);
			}
		}
	}
?>