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
    <script type="text/javascript" src="now_on_tap.js" ></script>
    <script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB4K5LzsA1jeC_8krvameVyNCY9euxuvaU&v=3'></script>
  </head>
	<body onload="initMap()">
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
			<div class='jumbotron'>
				<div class='container'>
					<h1>Beer Finder</h1>
					<h3>Find where the beer you want is on tap</h3>
					<p>This crowd sourced application shows you what beer is available where in real time. You, the users, add new beers at locations and remove what's not there anymore! This system ensures the most up-to-date data possible amongst all the locations currently serving beer and filling growlers.</p>
				</div>
			</div>
			<div id="map" class="col-sm-offset-2" style="width: 750px; height: 450px"></div>
			<form class="form-horizontal" method='POST' action='now_on_tap.php'>
				<fieldset class="form-group">
					<legend>Update What's On Tap by Location:</legend>
					<div class="form-group">
						<label class="col-sm-2 control-label">Location:</label>
							<select class="col-sm-2 control-label" name="taphouse_id">
								<?php
									if(!($stmt = $mysqli->prepare("SELECT taphouse.id, taphouse.name FROM taphouse"))){
										echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
									}

									if(!$stmt->execute()){
										echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
									}
									
									if(!$stmt->bind_result($id, $name)){
										echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
									}
								
									while($stmt->fetch()){
					 			
					 					echo '<option value=" '. $id . ' "> ' . $name . '</option>\n';
									}
								
									$stmt->close();
								?>
							</select>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" class="btn btn-primary">
						</div>
					</div>
				</fieldset>
			</form>	
			<form class="form-horizontal" method='POST' action='find_beer.php'>
				<fieldset class="form-group">
					<legend>Find Where a Beer is Right Now:</legend>
					<div class="form-group">
						<label class="col-sm-2 control-label">Beer:</label>
							<select class="col-sm-2 control-label" name="beer_id">
								<?php
									if(!($stmt = $mysqli->prepare("SELECT beer.id, beer.name, brewery.name FROM beer INNER JOIN brewery ON beer.brewery=brewery.id"))){
										echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
									}

									if(!$stmt->execute()){
										echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
									}
									
									if(!$stmt->bind_result($id, $beer_name, $brewery_name)){
										echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
									}
								
									while($stmt->fetch()){
					 			
					 					echo '<option value=" '. $id . ' "> ' . $brewery_name . " - " . $beer_name . '</option>\n';
									}
								
									$stmt->close();
								?>
							</select>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" class="btn btn-primary">
						</div>
					</div>
				</fieldset>
			</form>	
			<div id="map2" class="col-sm-offset-2" style="width: 750px; height: 450px"></div>
		</div>
	</body>
</html>