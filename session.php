<?php
	session_start();
	$ini_array = parse_ini_file("config.ini.php");
	if (!isset($_POST['username']) || !isset($_POST['password']))
		exit("Username or password not filled in.");
	$conn = new mysqli($ini_array['host'], $ini_array['username'], $ini_array['password'], $ini_array['database']);
	if ($conn -> connect_error) {
		exit("Connection failed: " . $conn->connect_error);
	}
	$response = mysqli_fetch_assoc(mysqli_query($conn, "SELECT memberid,username FROM members WHERE username='"
		.$_POST['username']."' AND password='".hash("sha256", $_POST['password'])."'"));
	if ($response['username']) {
		$_SESSION['username'] = $response['username'];
		$_SESSION['memberid'] = $response['memberid'];
	} else
		exit("Incorrect username or password.");
	mysqli_close($conn);
	header('Location: https://dev.tehtotalpwnage.io/projects/KeyClubInterface');
?>