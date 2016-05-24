
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
<?php

$open = $_POST['open'] . ':00' . $_POST['open_am_pm'];
$otime=strtotime($open);
$open_time=date("H:i:s", $otime);


$close = $_POST['close'] . ':00' . $_POST['close_am_pm'];
$ctime=strtotime($close);
$close_time=date("H:i:s", $ctime);

//Update taphouse general info
if($mysqli->connect_errno){
  echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
  }
if(!($stmt1 = $mysqli->prepare("UPDATE taphouse SET taphouse.name=?, taphouse.street_address=?, taphouse.city=?, taphouse.state=?, taphouse.zip=?, taphouse.open=?, taphouse.close=? WHERE taphouse.id=".$_POST['taphouse_id'].""))){
  echo "Prepare failed: "  . $stmt1->errno . " " . $stmt1->error;
}

if(!($stmt1->bind_param("ssssiss",$_POST['name'],$_POST['street_address'],$_POST['city'],$_POST['state'],$_POST['zip'],$open_time,$close_time))){
  echo "Bind failed: "  . $stmt1->errno . " " . $stmt1->error;
}

if(!$stmt1->execute()){
  echo "Execute failed: "  . $stm1->errno . " " . $stmt1->error;
} else {
  echo "<h2 style='color:red'>Updated " . $stmt1->affected_rows . " rows in taphouse.</h2>";
} 

/* Update outdoor seating table info. 
Found info for retrieving a single mysql value from stack overflow. Needed this to avoid error of adding a duplicate tap_id to outdoor seating
http://stackoverflow.com/questions/11456707/single-value-mysqli */
$outdoor_was_yes = getval($mysqli, "SELECT tap_id FROM outdoor_seating WHERE tap_id=".$_POST['taphouse_id']."");

function getval($mysqli, $sql) {
    $result = $mysqli->query($sql);
    $value = $result->fetch_array(MYSQLI_NUM);
    return is_array($value) ? $value[0] : "";
}

if (($_POST['outdoor_seating'] == "yes") && ($_POST['taphouse_id'] != $outdoor_was_yes)) { 
  if(!($stmt2 = $mysqli->prepare("INSERT INTO outdoor_seating(tap_id) VALUES (". $_POST['taphouse_id'] .")"))){
    echo "Prepare failed: "  . $stmt2->errno . " " . $stmt2->error;
  }
  if(!$stmt2->execute()){
    echo "Execute failed: "  . $stmt2->errno . " " . $stmt2->error;
  } else {
    echo "<h2 style='color:red'>\nAdded " . $stmt2->affected_rows . " rows to outdoor_seating.</h2>";
  } 
} 
else if (($_POST['outdoor_seating'] != "no") && ($_POST['taphouse_id'] == $outdoor_was_yes)) { 
  echo "<h2 style='color:red'>\nNo change to rows in outdoor_seating.</h2>";
}  

if ($_POST['outdoor_seating'] == "no") { 
  if(!($stmt2 = $mysqli->prepare("DELETE FROM outdoor_seating WHERE tap_id=". $_POST['taphouse_id'] .""))){
  echo "Prepare failed: "  . $stmt2->errno . " " . $stmt2->error;
  }
  if(!$stmt2->execute()){
    echo "Execute failed: "  . $stmt2->errno . " " . $stmt2->error;
  } else {
    echo "<h2 style='color:red'>\nRemoved " . $stmt2->affected_rows . " row from outdoor_seating.</h2>";
  } 
} 

/*Update food info */

$food_was_yes = getval($mysqli, "SELECT tap_id FROM food WHERE tap_id=".$_POST['taphouse_id']."");

if (($_POST['serves_food'] == "yes") && ($_POST['taphouse_id'] != $food_was_yes)) { 
  if(!($stmt3 = $mysqli->prepare("INSERT INTO food(tap_id, food_type) VALUES (?,?)"))){
    echo "Prepare failed: "  . $stmt3->errno . " " . $stmt3->error;
  }

  if(!($stmt3->bind_param("is",$_POST['taphouse_id'],$_POST['cuisine']))){
  echo "Bind failed: "  . $stmt3->errno . " " . $stmt3->error;
  }  
  
  if(!$stmt3->execute()){
    echo "Execute failed: "  . $stmt3->errno . " " . $stmt3->error;
  } else {
    echo "<h2 style='color:red'>\nAdded " . $stmt3->affected_rows . " rows to food.</h2>";
  } 
} //if serves food is yes and wasn't already a place to serve food
else if (($_POST['serves_food'] != "no") && ($_POST['taphouse_id'] == $food_was_yes)) { 
  echo "<h2 style='color:red'>\nNo change to rows in food.</h2>";
}  

if ($_POST['serves_food'] == "no") { 
  if(!($stmt2 = $mysqli->prepare("DELETE FROM food WHERE tap_id=". $_POST['taphouse_id'] .""))){
  echo "Prepare failed: "  . $stmt2->errno . " " . $stmt2->error;
  }
  if(!$stmt2->execute()){
    echo "Execute failed: "  . $stmt2->errno . " " . $stmt2->error;
  } else {
    echo "<h2 style='color:red'>\nRemoved " . $stmt2->affected_rows . " row from food.</h2>";
  } 
} 


?>

