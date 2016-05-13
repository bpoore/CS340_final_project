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
      <h1>Taphouses</h1>
        <table class="table table-striped">
          <tr>
            <th>Name</th>
            <th>Street Address</th>
            <th>City</th>
            <th>State</th>
            <th>Zipcode</th>
            <th>Open</th>
            <th>Close</th>
          </tr>
          <tbody>
            <?php
              if(!($stmt = $mysqli->prepare("SELECT taphouse.name, taphouse.street_address, taphouse.city, taphouse.state, taphouse.zip, taphouse.open, taphouse.close FROM taphouse"))){
                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
              }

              if(!$stmt->execute()){
                echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
              }
              
              if(!$stmt->bind_result($name, $street_address, $city, $state, $zip, $open, $close)){
                echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
              }
            
              while($stmt->fetch()){
            
                echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $street_address . "\n</td>\n<td>\n" . $city . "\n</td>\n<td>" . $state . "\n</td>\n<td>" . $zip . "\n</td>\n<td>" . $open . "\n</td>\n<td>" . $close . "\n</td>\n</tr>";
              }
            
              $stmt->close();
            ?>
          </tbody>
        </table>

      <form class="form-horizontal" method='POST' action='add_taphouse.php'>
        <fieldset class="form-group">
          <legend>Add A Taphouse</legend>
          <div class='form-group'>
            <label class="col-sm-2 control-label">Name:</label>
            <div class="col-sm-10">
              <input type='text' name='name'>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Street Address:</label>
            <div class="col-sm-10">
              <input type='number' name='street_address'>
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
            <label class="col-sm-2 control-label">Zip:</label>
            <div class="col-sm-10">
              <input type='number' name='zip'>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 control-label">Outdoor Seating:</label>
              <div class="col-sm-10">
                  <label><input type="radio" name="outdoor_seating" value="no" checked>No</label>
                  <label><input type="radio" name="outdoor_seating" value="yes">Yes</label>
              </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 control-label">Serves Food:</label>
              <div class="col-sm-10">
                  <label><input type="radio" name="serves_food" value="no" checked>No</label>
                  <label><input type="radio" name="serves_food" value="yes">Yes</label>
              </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 control-label">Cuisine Served:</label> 
                <div class="col-sm-10">
                  <input type="text" name="cuisine">
                </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" class="btn btn-primary">
            </div>
          </div>

        </fieldset>
      </form> 
      <a href="http://web.engr.oregonstate.edu/~pooree/CS340/final_project/final_project.php" class="btn btn-primary btn-block" role="button">Back to Beer Finder</a>
    </div>
  </body>
</html>