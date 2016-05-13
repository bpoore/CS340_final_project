<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","pooree-db","jweJE9PtV1AmdsA7","pooree-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
if(!($stmt1 = $mysqli->prepare("INSERT INTO taphouse(name, street_address, city, state, zip) VALUES (?,?,?,?,?)"))){
	echo "Prepare failed: "  . $stmt1->errno . " " . $stmt1->error;
}
if(!($stmt1->bind_param("sissi",$_POST['name'],$_POST['street_address'],$_POST['city'],$_POST['state'],$_POST['zip']))){
	echo "Bind failed: "  . $stmt1->errno . " " . $stmt1->error;
}
if(!$stmt1->execute()){
	echo "Execute failed: "  . $stmt1->errno . " " . $stmt1->error;
} else {
	echo "Added " . $stmt1->affected_rows . " rows to taphouse.";
	echo 'The ID is: '.$stmt1->insert_id;
}

if ($_POST['outdoor_seating'] == "yes") { 
	if(!($stmt2 = $mysqli->prepare("INSERT INTO outdoor_seating(tap_id) VALUES (".$stmt1->insert_id.")"))){
	echo "Prepare failed: "  . $stmt2->errno . " " . $stmt2->error;
	}
	if(!$stmt2->execute()){
		echo "Execute failed: "  . $stmt2->errno . " " . $stmt2->error;
	} else {
		echo "Added " . $stmt2->affected_rows . " rows to outdoor_seating.";
	} 
}

?> 

