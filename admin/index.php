<?php
	session_start();
	include '../database.php';
	if (!$_SESSION['memberid']) {
		header("Location: ".$webroot."/login.php");
	}
	$isofficer = false;
	if ($result = mysqli_query($conn, "SELECT memberid FROM officers")) {
		while ($memberid = mysqli_fetch_assoc($result)) {
			if ($memberid['memberid'] == $_SESSION['memberid']) {
				$isofficer = true;
				break;
			}
		}
	}
	if (!$isofficer) {
		header("Location: " . $webroot);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.6/dt-1.10.12/datatables.min.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.6/dt-1.10.12/datatables.min.js"></script>		<script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/time.js"></script>
		<style>
			html {
				height: 100%;
			}
			body {
				height: 100%;
				background-image: url('OTC.jpg');
			}
			.navbar-toggle {
				display: block;
				float: left;
				margin-left: 1vh;
			}
			.navbar {
				background: none;
				border: none;
			}
			.page-header {
				text-align: center;
			}
			.table tbody tr:hover td,
			.table tbody tr:hover th {
				background-color: transparent;
			}
			.tab-pane {
				background-color: rgba(192,192,192,.7);
				padding: 1vh;
			}
		</style>
	</head>
	<body>
		<div style="background-color: rgba(192,192,192,.7); height: 100%" id="dank">
		<div id="mymenu" class="navmenu navmenu-default navmenu-fixed-left offcanvas">
			<a class="navmenu-brand" href="#">AHS Key Club Dashboard</a>
			<ul class="nav navmenu-nav">
				<li class="active"><a data-toggle="pill" href="#home">Home</a></li>
				<li><a data-toggle="pill" href="#upcoming">Upcoming Events</a></li>
				<li><a data-toggle="pill" href="#past">Archived Events</a></li>
				<li style="position: absolute; bottom: 0;"><a href="logout.php">Log Out</a></li>
			</ul>
		</div>
		<div class="navbar navbar-default navbar-fixed-top">
			<button style="background-color: #FFFFFF;" type="button" class="navbar-toggle" data-toggle="offcanvas" data-target=".navmenu" data-canvas="body">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="tab-content container">
			<div id="home" class="tab-pane fade in active">
				<div class="page-header">
					<h1>Hello <?php echo $_SESSION['firstname']; ?>!</h1>
				</div>
			</div>
			<div id="upcoming" class="tab-pane fade">
				<div class="page-header">
					<h1>Upcoming Events</h1>
				</div>
				<table id="upcomingtable" class="table table-bordered">
					<thead>
						<tr>
							<th>Event Name</th>
							<th>Date</th>
							<th>Description</th>
							<th>Call Time</th>
							<th>Ride Call Time</th>
							<th>Start Time</th>
							<th>End Time</th>
							<th>Coordinator</th>
							<th>Accepting</th>
							<th>Edit Form</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if ($result = mysqli_query($conn, 
								"SELECT eventid, name, date, description, calltime, ridecalltime, starttime, endtime, 
								coordinator, accepting FROM upcoming")) {
									while ($upcoming = mysqli_fetch_assoc($result)) {
										?>
										<tr>
											<td><?php echo $upcoming['name']; ?></td>
											<td><?php echo $upcoming['date']; ?></td>
											<td><?php echo $upcoming['description']; ?></td>
											<td><?php echo $upcoming['calltime']; ?></td>
											<td><?php echo $upcoming['ridecalltime']; ?></td>
											<td><?php echo $upcoming['starttime']; ?></td>
											<td><?php echo $upcoming['endtime']; ?></td>
											<td><?php echo $upcoming['coordinator']; ?></td>
											<td><?php echo $upcoming['accepting'] ? 'Yes' : 'No'; ?></td>
											<td></td>
										</tr>
										<?php
									}
								}
						?>
					</tbody>
				</table>
				<input type="button" onclick="location.href='https://dev.tehtotalpwnage.io/projects/KeyClubInterface/admin/newform.php';" class="btn btn-primary" value="New Form"></input>
			</div>
			<div id="past" class="tab-pane fade">
				<div class="page-header">
					<h1>Archived Events</h1>
				</div>
			</div>
		</div>
		</div>
		<script>
			$(function(){
				$("#upcomingtable").dataTable();
			});
		</script>
	</body>
</html>
<?php
	mysqli_close($conn);
?>