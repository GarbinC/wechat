<?php
	class Wechat{
		
		function __construct(){
			
		}
		
		//回复消息 
		public function responseMsg(){
			//get post data, May be due to the different environments
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
			//extract post data
			if (!empty($postStr)){					
					libxml_disable_entity_loader(true);
					$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
					$fromUsername = $postObj->FromUserName;
					$toUsername = $postObj->ToUserName;
					$keyword = trim($postObj->Content);
					$time = time();
					$textTpl = "<xml>
								<ToUserName><![CDATA[%s]]></ToUserName>
								<FromUserName><![CDATA[%s]]></FromUserName>
								<CreateTime>%s</CreateTime>
								<MsgType><![CDATA[%s]]></MsgType>
								<Content><![CDATA[%s]]></Content>
								<FuncFlag>0</FuncFlag>
								</xml>";             
					if(!empty( $keyword ))
					{
						$msgType = "text";
						$contentStr = "Welcome to wechat world!";
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						file_put_contents( 'bcd.txt' , $resultStr);
						echo $resultStr;
					}else{
						echo "Input something...";
					}

			}else {
				echo "";
				exit;
			}
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