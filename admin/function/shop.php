<?php

	function error_snap($keterangan){

		$error = 
		'
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>Oh snap!</strong> '.$keterangan.'
			</div>
		';
		echo $error;

	}

	function success_snap($keterangan){

		$error = 
		'
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>Well done!</strong> '.$keterangan.'.
			</div>
		';
		echo $error;

	}

?>