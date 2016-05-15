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
		   <h1>Now on tap at 
          <?php
          if(!($stmt = $mysqli->prepare("SELECT name FROM taphouse WHERE taphouse.id=". $_POST['taphouse_id'].""))){
            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
          }
          if(!$stmt->bind_result($name)){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }

        if(!$stmt->execute()){
              echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
                          
          while($stmt->fetch()){ 
              echo $name;
          } 
            
            $stmt->close();
        ?>
      </h1>
      <table class="table table-striped">
        <tr>
          <th>Brewery</th>
          <th>Beer</th>
          <th>Pint Price</th>
          <th>Grower Price</th>
          <th>Remove From Location</th> 
        </tr>
        <tbody>
          <?php
            if(!($stmt = $mysqli->prepare("SELECT brewery.name, beer.name, beer_on_tap.pintPrice, beer_on_tap.growlerPrice, beer_on_tap.id FROM brewery INNER JOIN beer ON brewery.id=beer.brewery INNER JOIN beer_on_tap ON beer.id=beer_on_tap.beer_id INNER JOIN taphouse ON taphouse.id=beer_on_tap.tap_id WHERE taphouse.id=". $_POST['taphouse_id'].""))){
              echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }

            if(!$stmt->execute()){
              echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            
            if(!$stmt->bind_result($brewery, $beer, $pint, $growler, $id)){
              echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
          
            while($stmt->fetch()){
            
                echo "<tr>\n<td>\n" . $brewery . "\n</td>\n<td>\n" . $beer . "\n</td>\n<td>" . $pint . "\n</td>\n<td>" . $growler . 
                "\n</td>\n<td>\n 
                <form method='post' action='delete_beer_at_location.php'>
                <input type='hidden' name='beer_on_tap_id' value='". $id . "'>  
                <input type='submit' value='Remove' class='btn btn-danger'>
                </form>
                \n</td>\n</tr>"; 
            }
          
            $stmt->close();
          ?>
        </tbody>
      </table>

     <form class="form-horizontal" method='POST' action='add_beer_to_location.php'>
        <fieldset class="form-group">
          <legend>Add a beer to this location</legend>
          <div class="form-group">
            <label class="col-sm-2 control-label">Beer:</label>
              <select class="col-sm-2 control-label" name="beer_id">
                <?php
                  if(!($stmt = $mysqli->prepare("SELECT beer.id, beer.name FROM beer"))){
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
            <label class="col-sm-2 control-label">Pint Price: </label>
            <div class="col-sm-10">
                <input type='number' name="pintPrice">
            </div>
          </div>
          
          <div class="form-group">
              <label class="col-sm-2 control-label">Growler Price: </label>
              <div class="col-sm-10">
                <input type='number' name="growlerPrice">
              </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <input type="hidden" name="taphouse_id" value="<?php echo $_POST['taphouse_id']; ?>">
              <input type="submit" class="btn btn-primary">
            </div>
          </div> 
          <div class='form-group'>
            <label class="col-sm-2 control-label">Beer not available in list? </label>
              <div class="col-sm-10">
                <a href='http://web.engr.oregonstate.edu/~pooree/CS340/final_project/view_beers.php' class='btn btn-info' role='button'>Add Beer Here</a>
              </div>
          </div>
          </fieldset>
      </form>
  </body>
</html> 
