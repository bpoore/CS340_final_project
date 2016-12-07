<?php
        $conn = mysql_connect('oniddb.cws.oregonstate.edu', "pooree-db", "jweJE9PtV1AmdsA7");
		$db   = mysql_select_db("pooree-db");
 
		$sql = "SELECT beer.name, type, alc_bv, brewery.name FROM beer INNER JOIN brewery ON beer.brewery=brewery.id";
		$res = mysql_query($sql);
		if(!$res) {
			die("invalid: ".mysql_error());
		}
		$result = array();
 
		while( $row = mysql_fetch_array($res)) {
			if($row[1]==NULL) {
				$row[1] = "N/A";
			}
			if (!($row[2] >0)) {
				$row[2] = "N/A";
			} 
		    array_push($result, array('name' => $row[0], 'type' => $row[1], 'abv' => $row[2], 'brewery' => $row[3]));
		}
 
		echo json_encode(array("result" => $result));
?>