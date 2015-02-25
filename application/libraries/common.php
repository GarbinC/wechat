<?php

	class Common{
		private $_CI;
		
		function __construct(){
			$this->_CI = &get_instance();
		}
	}