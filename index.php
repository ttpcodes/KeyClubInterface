<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.3/dt-1.10.12/datatables.min.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<style>
			.hidden {
				display: none;
			}
			.visible {
			}
		</style>
	</head>
	<body>
		<nav id="menu" class="navmenu navmenu-default navmenu-fixed-left offcanvas" role="navigation">
			<a class="navmenu-brand" href="#">Brand</a>
			<ul class="nav navmenu-nav">
				<li class="active"><a href="#">Home</a></li>
				<li style="position: absolute; bottom: 0;"><a href="logout.php">Log Out</a></li>
			</ul>
		</nav>
		<div class="navbar navbar-default navbar-fixed-top">
			<button type="button" classes="navbar-toggle" data-toggle="offcanvas" data-target="#menu" data-canvas="body">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#events">Events</a></li>
			<li><a data-toggle="tab" href="#upcoming">Upcoming</a></li>
		</ul>
		<div class="tab-content">
			<div id="events" class="tab-pane fade in active">
				<table id="eventtable">
					<thead>
						<tr>
							<th>Event Name</th>
							<th>Date</th>
							<th>Start Time</th>
							<th>End Time</th>
							<th>Hours</th>
							<th>Coordinator</th>
						</tr>
					</thead>
					<tbody>
						<?php
							session_start();
							$domain = "dev.tehtotalpwnage.io/projects/KeyClubInterface";
							if (!$_SESSION['username']) {
								header('Location: https://'.$domain.'/login.html');
							}
							$events = array();
							$conn = new mysqli();
							if ($conn -> connect_error) {
								exit("Connection failed: " . $conn->connect_error);
							}
							if ($result = mysqli_query($conn, "SELECT eventid FROM eventmembers WHERE memberid='"
								.$_SESSION['memberid']."'")) {
									while ($eventid = mysqli_fetch_assoc($result)) {
										array_push($events, $eventid['eventid']);
									}
							}
							foreach ($events as $i) {
								$query = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name, date, starttime, endtime, hours,
									coordinator FROM events WHERE eventid='".$i."'"));
								?>
								<tr>
									<td><?php echo $query['name']; ?></td>
									<td><?php echo date('F j, Y',strtotime($query['date'])); ?></td>
									<td><?php echo date('h:i A',strtotime($query['starttime'])); ?></td>
									<td><?php echo date('h:i A',strtotime($query['endtime'])); ?></td>
									<td><?php echo $query['hours']; ?></td>
									<td><?php echo $query['coordinator']; ?></td>
								</tr>
								<?php
							}
							mysqli_close($conn);
						?>
					</tbody>
				</table>
			</div>
			<div id="upcoming" class="tab-pane fade">
				<p>dank</p>
			</div>
		</div>
		<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-2.2.3/dt-1.10.12/datatables.min.js"></script>
		<script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/time.js"></script>
		<script>
			function on() {
				document.getElementById("events").className = "visible";
			}
			function off() {
				document.getElementById("events").className = "hidden";
			}
			$(function(){
				$("#eventtable").dataTable({
					"columnDefs": [
						{ "type": "date", "targets": 1 },
						{ "type": "time-uni", "targets": 2 },
						{ "type": "time-uni", "targets": 3 }
					]});
					                 
			})
		</script>
	</body>
</html>