<?php
	session_start();
	if (empty($_SESSION['memberid'])) {
		header("Location: https://dev.tehtotalpwnage.io/projects/KeyClubInterface/login.html");
	}
	$ini_array = parse_ini_file("../config.ini.php");
	$conn = new mysqli($ini_array['host'], $ini_array['username'], $ini_array['password'], $ini_array['database']);
	if ($conn -> connect_error) {
		exit("Connection failed: " . $conn->connect_error);
	}
	$isofficer = false;
	if ($result = mysqli_query($conn, "SELECT memberid FROM officers")) {
		while ($memberid = mysqli_fetch_assoc($result)) {
			if ($memberid['result'] == $_SESSION['memberid']) {
				$isofficer = true;
				break;
			}
		}
	}
	if (!$isofficer) {
		exit("403 UNAUTHORIZED");
	}
?>