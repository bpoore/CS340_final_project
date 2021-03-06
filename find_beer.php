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
      <script type="text/javascript" src="find_beer.js" ></script>
      <script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB4K5LzsA1jeC_8krvameVyNCY9euxuvaU&v=3'></script>
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
      <h1><?php
          if(!($stmt = $mysqli->prepare("SELECT brewery.name, beer.name FROM beer INNER JOIN brewery ON beer.brewery=brewery.id WHERE beer.id=". $_POST['beer_id'].""))){
            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
          }
          if(!$stmt->bind_result($brewery_name, $beer_name)){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }

        if(!$stmt->execute()){
              echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }

          while($stmt->fetch()){ 
              echo $brewery_name . " - " . $beer_name;
          } 
            
            $stmt->close();
        ?> is now at:
      </h1>
      <body onload="initMap()">
    	<div class="container">
        <table class="table table-striped">
              <?php
                if(!($stmt = $mysqli->prepare("SELECT taphouse.name, taphouse.city, taphouse.state FROM taphouse INNER JOIN beer_on_tap ON taphouse.id=beer_on_tap.tap_id INNER JOIN beer ON beer.id=beer_on_tap.beer_id WHERE beer.id=". $_POST['beer_id'] .""))){
                  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }
                if(!$stmt->bind_result($name, $city, $state)){
                  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }

                if(!$stmt->execute()){
                  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }

                $stmt->store_result(); //Necessary for num_rows storage
          
                if($stmt->num_rows>0) {     
                  echo "<tr>
                          <th>Name</th>
                          <th>City</th>
                          <th>State</th>
                        </tr>
                      <tbody>";            
                  while($stmt->fetch()){ 
                    echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $city . "\n</td>\n<td>\n" . $state ."\n</td>\n</tr>";
                  }
                }
                else {
                  echo "<h3 style='color:red'>No results</h3>";
                }

              
                $stmt->close();
              ?>
            </tbody>
          </table>
      </div>
    </body>
</html>  