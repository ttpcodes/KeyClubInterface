<?php
	session_start();
	if (isset($_POST['username']) && isset($_POST['password'])) {
		require 'database.php';
		$response = mysqli_fetch_assoc(mysqli_query($conn, "SELECT memberid,firstname,username FROM members WHERE username='"
				.$_POST['username']."' AND password='".hash("sha256", $_POST['password'])."'"));
		mysqli_close($conn);
		if (isset($response['username'])) {
			$_SESSION['firstname'] = $response['firstname'];
			$_SESSION['username'] = $response['username'];
			$_SESSION['memberid'] = $response['memberid'];
			header('Location: ' . $webroot);
		} else
			header("Location: " . $webroot . "/login.php?incorrect=1");
	}
?>
<!DOCTYPE html>
<html style="height: 100%;">
	<head>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
		<script src="scripts.js"></script>
	</head>
	<body style="background-image: url('OTC.jpg'); align-items: center; height: 100%; justify-content: center; display: flex;">
		<div class="container" style="border-style: solid; border-width: 1px; padding-bottom: 1vh; min-height: 100%; width: 100%; justify-content: center; align-items: center; display: flex; background: rgba(192,192,192,0.5);">
			<form name="login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" onsubmit="return validateForm()" role="form">
				<h1>Login</h1>
				<div id="incorrect" style="display: none; border-width: 1px;" class="error">
					Incorrect Username or Password.
				</div>
				<div id="filled" style="display: none; border-width: 1px;" class="error">
					All fields must be filled out.
				</div>
				<input placeholder="Username" type="text" name="username" class="form-control"><br>
				<input placeholder="Password" type="password" name="password" class="form-control"><br>
				<input class="btn btn-primary" type="submit" value="Log In">
			</form>
		</div>
		<script>
			function validateForm() {
				if (document.forms["login"]["username"].value == (null || "" ) || document.forms["login"]["password"].value == (null || "" )) {
					document.getElementById("filled").style.display = "block";
					return false;
				}
			}
			var getUrlParameter = function getUrlParameter(sParam) {
			    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
			        sURLVariables = sPageURL.split('&'),
			        sParameterName,
			        i;

			    for (i = 0; i < sURLVariables.length; i++) {
			        sParameterName = sURLVariables[i].split('=');

			        if (sParameterName[0] === sParam) {
			            return sParameterName[1] === undefined ? true : sParameterName[1];
			        }
			    }
			};
			var password = getUrlParameter('incorrect');
			if (password == "1") {
				document.getElementById("incorrect").style.display = "block";
				document.getElementById("main").style.display = "block";
			} else{
				$(document).ready(function() {
					$('#main').fadeIn(1000);
				});
			}
		</script>
	</body>
</html>