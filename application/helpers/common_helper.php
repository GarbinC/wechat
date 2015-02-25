<?php
	//Common Functions 
	
	function dump( $param , $if_exit = true){
		echo '<pre>';
		var_dump( $param);
		echo '</pre>';
		if( $if_exit)
			exit();
	}
?>