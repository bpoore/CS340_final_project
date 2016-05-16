<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","pooree-db","jweJE9PtV1AmdsA7","pooree-db");

$open = $_POST['open'] . ':00' . $_POST['open_am_pm'];
$otime=strtotime($open);
$open_time=date("H:i:s", $otime);


$close = $_POST['close'] . ':00' . $_POST['close_am_pm'];
$ctime=strtotime($close);
$close_time=date("H:i:s", $ctime);


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
  echo "Updated " . $stmt1->affected_rows . " rows in taphouse.";
} 

if ($_POST['outdoor_seating'] == "yes") { 
  if(!($stmt2 = $mysqli->prepare("INSERT INTO outdoor_seating(tap_id) VALUES (". $_POST['taphouse_id'] .")"))){
  echo "Prepare failed: "  . $stmt2->errno . " " . $stmt2->error;
  }
  if(!$stmt2->execute()){
    echo "Execute failed: "  . $stmt2->errno . " " . $stmt2->error;
  } else {
    echo "Added " . $stmt2->affected_rows . " rows to outdoor_seating.";
  } 
} 

if ($_POST['outdoor_seating'] == "no") { 
  if(!($stmt2 = $mysqli->prepare("DELETE FROM outdoor_seating WHERE tap_id=". $_POST['taphouse_id'] .""))){
  echo "Prepare failed: "  . $stmt2->errno . " " . $stmt2->error;
  }
  if(!$stmt2->execute()){
    echo "Execute failed: "  . $stmt2->errno . " " . $stmt2->error;
  } else {
    echo "Removed " . $stmt2->affected_rows . " rows to outdoor_seating.";
  } 
} 


?>
