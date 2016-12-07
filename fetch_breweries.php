<?php
        $conn = mysql_connect('oniddb.cws.oregonstate.edu', "pooree-db", "jweJE9PtV1AmdsA7");
		$db   = mysql_select_db("pooree-db");
 
		$sql = "SELECT name, city, state FROM brewery";
		$res = mysql_query($sql);
		if(!$res) {
			die("invalid: ".mysql_error());
		}
		$result = array();
 
		while( $row = mysql_fetch_array($res)) {
			if($row[1]==NULL) {
				$row[1] = "N/A";
			}
			if ($row[2]==NULL) {
				$row[2] = "N/A";
			} 
		    array_push($result, array('name' => $row[0], 'city' => $row[1], 'state' => $row[2]));
		}
 
		echo json_encode(array("result" => $result));
?>