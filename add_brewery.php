<?php
	if(!($stmt = $mysqli->prepare("INSERT INTO brewery(name, city, state) VALUES (?,?,?)"))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if(!($stmt->bind_param("sss",$_POST['name'],$_POST['city'],$_POST['state']))){
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if(!$stmt->execute()){
		echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
	} else {
		echo "Added " . $stmt->affected_rows . " row to brewery.";
	}
?>





