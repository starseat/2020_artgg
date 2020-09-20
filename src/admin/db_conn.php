<?php
    //header("Access-Control-Allow-Headers: X-Requested-With, X-Prototype-Version");
    
	$servername = "127.0.0.1";
	$username = "artgg_user";
	$password = "artgg_pw";
    $dbname = "artggdb";
    $dbport = 3307;

	$conn = mysqli_connect($servername, $username, $password, $dbname, $dbport);

	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
    }
?>
