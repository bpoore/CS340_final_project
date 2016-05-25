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
        <h1>Taphouses serving <?php echo $_POST['food_type'] ?> and <?php echo $_POST['beer_type'] ?>:</h1>
        <table class="table table-striped">
          <tbody>
            <?php
              if(!($stmt = $mysqli->prepare("SELECT taphouse.name, taphouse.street_address, taphouse.city, taphouse.state, brewery.name, beer.name, food.food_type, beer.type FROM food INNER JOIN taphouse ON food.tap_id=taphouse.id INNER JOIN beer_on_tap ON taphouse.id=beer_on_tap.tap_id INNER JOIN beer ON beer.id=beer_on_tap.beer_id INNER JOIN brewery ON brewery.id=beer.brewery WHERE food_type=? AND beer.type=?"))){
                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
              }

              if(!($stmt->bind_param("ss",$_POST['food_type'],$_POST['beer_type']))){
                echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
              }

              if(!$stmt->execute()){
                echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
              }

              $stmt->store_result(); //Necessary for num_rows storage
              
              if(!$stmt->bind_result($name, $street_address, $city, $state, $brewery, $beer, $food_type, $beer_type)){
                echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
              }
            
              if($stmt->num_rows>0) {
                echo "<tr>
                        <th>Name</th>
                        <th>Street Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Brewery Name</th>
                        <th>Beer Name</th>
                      </tr>"; 
                while($stmt->fetch()){
              
                  echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n";
                  if(strlen($street_address)>1) {
                    echo $street_address . "\n</td>\n<td>\n";
                  }
                  else {
                    echo "N/A\n</td>\n<td>\n";
                  }
                  if(strlen($city)>1) {
                    echo $city . "\n</td>\n<td>"; 
                  } 
                  else {
                    echo "N/A\n</td>\n<td>\n";
                  } 
                  if(strlen($state)>1) {
                    echo $state . "\n</td>\n<td>"; 
                  }
                  else {
                    echo "N/A\n</td>\n<td>\n";
                  }
                  if(strlen($brewery)>1) {
                    echo $brewery . "\n</td>\n<td>"; 
                  }
                  else {
                    echo "N/A\n</td>\n<td>\n";
                  }
                  if(strlen($beer)>1) {
                    echo $beer . "\n</td>\n</tr>";
                  }
                  else {
                    echo "N/A\n</td>\n</tr>"; 
                  }                
                } // while
              } //if
              
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
   