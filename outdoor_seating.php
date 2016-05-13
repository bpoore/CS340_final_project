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
              if(!($stmt = $mysqli->prepare("SELECT taphouse.name, taphouse.street_address, taphouse.city, taphouse.state, taphouse.zip, taphouse.open, taphouse.close FROM taphouse INNER JOIN outdoor_seating on taphouse.id=outdoor_seating.tap_id"))){
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
      <a href="http://web.engr.oregonstate.edu/~pooree/CS340/final_project/final_project.php" class="btn btn-primary btn-block" role="button">Back to Beer Finder</a>
    </div>
  </body>
</html>