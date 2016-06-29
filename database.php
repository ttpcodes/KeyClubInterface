<?php
	$ini_array = parse_ini_file("config.ini.php");
	$conn = new mysqli($ini_array['host'], $ini_array['username'], $ini_array['password'], $ini_array['database']);
	if ($conn -> connect_error) {
		exit("Connection failed: " . $conn->connect_error);
	}
?>