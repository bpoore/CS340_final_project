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
			<div class='jumbotron'>
				<div class='container'>
					<h1>Beer Finder</h1>
					<h3>Find where your favorite beers are at right now!</h3>
					<p>This crowd sourced application shows you what beer is available where in real time. You, the users, add new beers at locations and remove what's not there anymore! This system ensures the most up-to-date data possible amongst all the locations currently serving beer and filling growlers.</p>
				</div>
			</div>
			<form class="form-horizontal" method='POST' action='find_beer.php'>
				<fieldset class="form-group">
					<legend>Find Where Your Favorite Beer is Right Now:</legend>
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
			
			<form class="form-horizontal" method='POST' action='now_on_tap.php'>
				<fieldset class="form-group">
					<legend>See What's On Tap by Location:</legend>
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


			
			<span>
				<a href='http://web.engr.oregonstate.edu/~pooree/CS340/final_project/view_taphouses.php' class='btn btn-info' role='button'>View & Add Taphouses</a>
				<a href='http://web.engr.oregonstate.edu/~pooree/CS340/final_project/view_beers.php' class='btn btn-info' role='button'>View  &  Add Beers</a>
				<a href='http://web.engr.oregonstate.edu/~pooree/CS340/final_project/view_breweries.php' class='btn btn-info' role='button'>View & Add Breweries</a>
			</span>
		</div>
	</body>
</html>