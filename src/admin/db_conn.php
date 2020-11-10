<?php
    //header("Access-Control-Allow-Headers: X-Requested-With, X-Prototype-Version");
    
	$servername = "localhost";
	$username = "artgg";
	$password = "dkxmrudrl2020!";
	$dbname = "artgg";

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
    }
?>
