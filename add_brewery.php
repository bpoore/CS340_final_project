
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
if(!($stmt = $mysqli->prepare("INSERT INTO brewery(name, city, state) VALUES (?,?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("sss",$_POST['name'],$_POST['city'],$_POST['state']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "<h2 style='color:red'>Added " . $stmt->affected_rows . " row to brewery.</h2>";
}
?>

