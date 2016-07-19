<?php
	session_start();
	$domain = "dev.tehtotalpwnage.io/projects/KeyClubInterface";
	if (!$_SESSION['username']) {
		header('Location: https://'.$domain.'/login.html');
	}
	include 'database.php';
	
	if (isset($_GET['eventid']) && isset($_SESSION['memberid'])) {
		mysqli_query($conn, "INSERT INTO signups (memberid, eventid) VALUES ('".$_SESSION['memberid']."','".$_GET['eventid']."');")
		or exit("Error occured on processing request: ".mysqli_error($conn));
	} else {
		echo "<h1>Invalid request header.</h1>";
	}
	mysqli_close($conn);
?>