<?php
	class Wechat{
		
		function __construct(){
			
		}
		
		// 验证url
		public function valid(){
			$echoStr = $_GET["echostr"];
			if($this->checkSignature()){
				echo $echoStr;
				exit;
			}
		}
		
		private function checkSignature(){
			if (!defined("TOKEN")) {
				return false;
			}
			$signature = $_GET["signature"];
			$timestamp = $_GET["timestamp"];
			$nonce = $_GET["nonce"];	
			$token = TOKEN;
			$tmpArr = array($token, $timestamp, $nonce);
			// use SORT_STRING rule
			sort($tmpArr, SORT_STRING);
			$tmpStr = implode( $tmpArr );
			$tmpStr = sha1( $tmpStr );			
			if( $tmpStr == $signature ){
				return true;
			}else{
				return false;
			}
		}
	}
?>
