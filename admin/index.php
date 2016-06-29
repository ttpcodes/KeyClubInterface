<?php
	session_start();
	if (!$_SESSION['memberid']) {
		header("Location: https://dev.tehtotalpwnage.io/projects/KeyClubInterface/login.html");
	}
	include 'database.php';
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
	mysqli_close($conn);
?>