<?php 

	$conn = new mysqli("localhost", "root", "","team");
	
	if($conn->connect_error){
		die("Connection Failed! ".$conn->connect_error);
	}

?>