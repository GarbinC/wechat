<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Index extends CI_Controller{
		private $_data;
		
		function __construct(){
			parent::__construct();
			//验证消息来源
			$this->wechat->valid();
		}
				
		
		function index(){	
			//
		}
	}
?>