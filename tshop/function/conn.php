<?php
	
	$host 		= 'localhost';
	$username = 'root';
	$pass 		= 'root';
	$db 			= 'db_olshop';

	$conn = mysqli_connect($host,$username,$pass,$db) or die( mysqli_connect_error() );

?>