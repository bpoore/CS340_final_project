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
      <script src='add_brewery.js'></script>
      <script src='view_breweries.js'></script>
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
      <h1>Breweries</h1>
      <table class="table table-striped">
        <tr>
          <th>Name</th>
          <th>City</th>
          <th>State</th>
        </tr>
        <tbody id='brewery_list'></tbody>
      </table>
      <form class="form-horizontal" method='POST' action='add_brewery.php' id="add_brewery">
        <fieldset class="form-group">
          <legend>Add A Brewery</legend>
          <div class='form-group'>
            <label class="col-sm-2 control-label">Name:</label>
            <div class="col-sm-10">
              <input type='text' name='name'>
            </div>
          </div>
          <div class='form-group'>
            <label class="col-sm-2 control-label">City:</label>
            <div class="col-sm-10">
              <input type='text' name='city'>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">State:</label>
            <div class="col-sm-10">
              <input type='text' name='state'>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button class="btn btn-primary" id="sub">Submit</button>
            </div>
          </div>
        </fieldset>
      </form> 
    </div>
  </body>
</html>  