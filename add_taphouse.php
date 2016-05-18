
<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","pooree-db","jweJE9PtV1AmdsA7","pooree-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Beer Finder</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href='style.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src='app.js'></script>
  </head>
  <body>
  	<div class="container">
		<nav class="navbar navbar-default">
	    	<div class="container-fluid">
	      		<div class="navbar-header">
	        		<a class="navbar-brand" href="final_project.php">Beer Finder</a>
	      		</div>
	      			<ul class="nav navbar-nav">
			        	<li class="active"><a href="final_project.php">Home</a></li>
			        	<li><a href="view_taphouses.php">View and Add Taphouses</a></li> 
			        	<li><a href="view_beers.php">View and Add Beers</a></li> 
			        	<li><a href="view_breweries.php">View and Add Breweries</a></li> 
	    	</div>
		</nav>
<?php

// Found on stack overflow how to deal with time formatting: http://stackoverflow.com/questions/13719116/dealing-with-time-in-php-mysql
$open = $_POST['open'] . ':00' . $_POST['open_am_pm'];
$otime=strtotime($open);
$open_time=date("H:i:s", $otime);


$close = $_POST['close'] . ':00' . $_POST['close_am_pm'];
$ctime=strtotime($close);
$close_time=date("H:i:s", $ctime);


if(!($stmt1 = $mysqli->prepare("INSERT INTO taphouse(name, street_address, city, state, zip, open, close) VALUES (?,?,?,?,?,?,?)"))){
	echo "Prepare failed: "  . $stmt1->errno . " " . $stmt1->error;
}
if(!($stmt1->bind_param("ssssiss",$_POST['name'],$_POST['street_address'],$_POST['city'],$_POST['state'],$_POST['zip'],$open_time,$close_time))){
	echo "Bind failed: "  . $stmt1->errno . " " . $stmt1->error;
}
if(!$stmt1->execute()){
	echo "Execute failed: "  . $stmt1->errno . " " . $stmt1->error;
} else {
	echo "<h2 style='color:red'>Added " . $stmt1->affected_rows . " row to taphouse.</h2>";
}

if ($_POST['outdoor_seating'] == "yes") { 
	if(!($stmt2 = $mysqli->prepare("INSERT INTO outdoor_seating(tap_id) VALUES (".$stmt1->insert_id.")"))){
	echo "Prepare failed: "  . $stmt2->errno . " " . $stmt2->error;
	}
	if(!$stmt2->execute()){
		echo "Execute failed: "  . $stmt2->errno . " " . $stmt2->error;
	} else {
		echo "<h2 style='color:red'>\nAdded " . $stmt2->affected_rows . " row to outdoor_seating.</h2>";
	} 
} 

?> 

