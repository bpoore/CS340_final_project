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
      <h1>Taphouses</h1>
      <table class="table table-striped">
        <tr>
          <th>Name</th>
          <th>Street Address</th>
          <th>City</th>
          <th>State</th>
          <th>Open</th>
          <th>Close</th>
          <th>Update</th>
        </tr>
        <tbody>
          <?php
            if(!($stmt = $mysqli->prepare("SELECT taphouse.name, taphouse.street_address, taphouse.city, taphouse.state, taphouse.open, taphouse.close, taphouse.id FROM taphouse"))){
              echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }

            if(!$stmt->execute()){
              echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            
            if(!$stmt->bind_result($name, $street_address, $city, $state, $open, $close, $id)){
              echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
          
            while($stmt->fetch()){
          
              echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n";
              if(strlen($street_address)>1) {
                echo $street_address . "\n</td>\n<td>\n";
              }
              else {
                $street_address;
                echo "N/A\n</td>\n<td>\n";
              }
              if(strlen($city)>1) {
                echo $city . "\n</td>\n<td>"; 
              } 
              else {
                $city;
                echo "N/A\n</td>\n<td>\n";
              } 
              if(strlen($state)>1) {
                echo $state . "\n</td>\n<td>";
              }
              else {
                $state;
                echo "N/A\n</td>\n<td>\n";
              }
              // Found how to deal with time on stack overflow: http://stackoverflow.com/questions/13719116/dealing-with-time-in-php-mysql
              $open_time=strtotime($open); 
              $data_print=date("g:i A", $open_time);
              echo $data_print . "\n</td>\n<td>";

              $close_time=strtotime($close);
              $data_print=date("g:i A", $close_time);
              echo $data_print . "\n</td>\n</td>";
              echo "\n</td>\n<td>\n 
              <form method='post' action='taphouse_data.php'>
              <input type='hidden' name='taphouse_id' value='". $id . "'>  
              <input type='submit' value='update' class='btn btn-info'>
              </form>
              \n</td>\n</tr>"; 
            }        
            $stmt->close();
          ?>
        </tbody>
      </table>
      <a href="http://web.engr.oregonstate.edu/~pooree/CS340/final_project/outdoor_seating.php" class="btn btn-info btn-block" role="button">See Taphouses with Outdoor Seating</a>
      <a href="http://web.engr.oregonstate.edu/~pooree/CS340/final_project/serves_food.php" class="btn btn-info btn-block" role="button">See Taphouses Serving Food</a>
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
              <input type='text' name='street_address'>
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
          <div class="form-group">
            <label class="col-sm-2 control-label">Open:</label>
              <select class="col-sm-2 control-label" name="open">
                <option value="1">1:00</label>
                <option value="2">2:00</label>
                <option value="3">3:00</label>
                <option value="4">4:00</label>
                <option value="5">5:00</label>
                <option value="6">6:00</label>
                <option value="7">7:00</label>
                <option value="8">8:00</label>
                <option value="9">9:00</label>
                <option value="10">10:00</label>
                <option value="11">11:00</label>
                <option value="12">12:00</label>
              </select>
              <label class="col-sm-2 control-label">
                <div class="col-sm-10">
                  <label><input type="radio" name="open_am_pm" value="AM" checked>AM</label>
                  <label><input type="radio" name="open_am_pm" value="PM">PM</label>
                </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Close:</label>
              <select class="col-sm-2 control-label" name="close">
                <option value="1">1:00</label>
                <option value="2">2:00</label>
                <option value="3">3:00</label>
                <option value="4">4:00</label>
                <option value="5">5:00</label>
                <option value="6">6:00</label>
                <option value="7">7:00</label>
                <option value="8">8:00</label>
                <option value="9">9:00</label>
                <option value="10">10:00</label>
                <option value="11">11:00</label>
                <option value="12">12:00</label>
              </select>
              <label class="col-sm-2 control-label">
                <div class="col-sm-10">
                  <label><input type="radio" name="close_am_pm" value="AM" checked>AM</label>
                  <label><input type="radio" name="close_am_pm" value="PM">PM</label>
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
    </div>
  </body>
</html>