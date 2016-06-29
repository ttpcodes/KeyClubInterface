<?php
	session_start();
	require 'database.php';
	$response = mysqli_fetch_assoc(mysqli_query($conn, "SELECT memberid,username FROM members WHERE username='"
		.$_POST['username']."' AND password='".hash("sha256", $_POST['password'])."'"));
	mysqli_close($conn);
	if ($response['username']) {
		$_SESSION['username'] = $response['username'];
		$_SESSION['memberid'] = $response['memberid'];
	} else
		header("location: https://dev.tehtotalpwnage.io/projects/KeyClubInterface/login.html?incorrect=1");
	mysqli_close($conn);
	header('Location: https://dev.tehtotalpwnage.io/projects/KeyClubInterface');
?>