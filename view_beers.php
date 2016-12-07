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
    <script src='view_beers.js'></script>
    <script src='add_beer.js'></script>
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
	  	<h1>Beers</h1>
			<table class="table table-striped">
				<tr>
					<th>Name</th>
					<th>Type</th>
					<th>% Alcohol</th>
					<th>Brewery</th>
				</tr>
				<tbody id='beer_list'></tbody>
			</table>
			<form class="form-horizontal" method='POST' action="add_beer.php" id='add_beer'>
				<fieldset class="form-group">
					<legend>Add A Beer</legend>
					<div class='form-group'>
						<label class="col-sm-2 control-label">Name:</label>
						<div class="col-sm-10">
							<input type='text' name='name'>
						</div>
					</div>
					<div class='form-group'>
						<label class="col-sm-2 control-label">Type:</label>
						<div class="col-sm-10">
							<input type='text' name='type'>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">% Alcohol by Volume:</label>
						<div class="col-sm-10">
							<input type='number' name='alc_bv'>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Brewery:</label>
							<select class="col-sm-2 control-label" name="brewery">
								<?php
									if(!($stmt = $mysqli->prepare("SELECT brewery.id, brewery.name FROM brewery"))){
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
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button class="btn btn-primary" id='sub'>Submit</button>
						</div>
					</div>
					<div class='form-group'>
						<label class="col-sm-2 control-label">Brewery not listed? </label>
							<div class="col-sm-10">
								<a href='http://web.engr.oregonstate.edu/~pooree/CS340/final_project/view_breweries.php' class='btn btn-info' role='button'>Add Brewery Here</a>
							</div>
					</div>
				</fieldset>
			</form>	
			<span id="result"></span>
		</div>
	</body>
</html>	
