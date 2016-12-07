<?php
	//Turn on error reporting
	ini_set('display_errors', 'On');
	//Connects to the database
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","pooree-db","jweJE9PtV1AmdsA7","pooree-db");
	if($mysqli->connect_errno){
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}

	// Found on stack overflow how to deal with time formatting: http://stackoverflow.com/questions/13719116/dealing-with-time-in-php-mysql
	$open = $_POST['open'] . ':00' . $_POST['open_am_pm'];
	$otime=strtotime($open);
	$open_time=date("H:i:s", $otime);


	$close = $_POST['close'] . ':00' . $_POST['close_am_pm'];
	$ctime=strtotime($close);
	$close_time=date("H:i:s", $ctime);


	if(!($stmt1 = $mysqli->prepare("INSERT INTO taphouse(name, street_address, city, state, zip, open, close) VALUES (?,?,?,?,?,?,?)"))){
		echo "Prepare failed: "  . $stmt1->errno . " " . $stmt1->error;
	}
	if(!($stmt1->bind_param("ssssiss",$_POST['name'],$_POST['street_address'],$_POST['city'],$_POST['state'],$_POST['zip'],$open_time,$close_time))){
		echo "Bind failed: "  . $stmt1->errno . " " . $stmt1->error;
	}
	if(!$stmt1->execute()){
		echo "Execute failed: "  . $stmt1->errno . " " . $stmt1->error;
	} else {
		echo "Added " . $stmt1->affected_rows . " row to taphouse.";
	}
?> 




