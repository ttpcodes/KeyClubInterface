<?php
	session_start();
	if (!$_SESSION['username']) {
		header('Location: https://'.$webroot.'/login.php');
	}
	include 'database.php';
	$events = array();
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
		<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.js"></script>
		<script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/time.js"></script>
		
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
				<li><a data-toggle="pill" href="#events">Events</a></li>
				<li><a data-toggle="pill" href="#upcoming">Upcoming Events</a></li>
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
			<div id="events" class="tab-pane fade">
				<div class="page-header">
					<h1>Events</h1>
				</div>
				<table id="eventtable" class="table table-bordered">
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
							$hours = 0;
							if ($result = mysqli_query($conn, "SELECT eventid FROM eventmembers WHERE memberid='".$_SESSION['memberid']."'")) {
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
								$hours = $hours + $query['hours'];
							}
						?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="4">Total</th>
							<td colspan="2"><?php echo $hours; ?></td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div id="upcoming" class="tab-pane fade">
				<div class="page-header">
					<h1>Upcoming</h1>
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
							<th>Sign Up!</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if ($result = mysqli_query($conn, 
								"SELECT eventid, name, date, description, calltime, ridecalltime, starttime, endtime, 
								coordinator FROM upcoming WHERE accepting='1'")) {
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
											<td><?php echo "<a href='https://dev.tehtotalpwnage.io/projects/KeyClubInterface/signup.php?eventid=".$upcoming['eventid']."'>Sign Up</a>"; ?></td>
										</tr>
										<?php
									}
								}
						?>
					</tbody>
				</table>
			</div>
		</div>
		</div>
		<script>
			$(function(){
				$("#eventtable").dataTable({
					"columnDefs": [
						{ "type": "date", "targets": 1 },
						{ "type": "time-uni", "targets": 2 },
						{ "type": "time-uni", "targets": 3 }
					]});
			});
			$(function(){
				$("#upcomingtable").dataTable();
			});
		</script>
	</body>
</html>
<?php
	mysqli_close($conn);
?>