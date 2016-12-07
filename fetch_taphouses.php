<?php
        $conn = mysql_connect('oniddb.cws.oregonstate.edu', "pooree-db", "jweJE9PtV1AmdsA7");
		$db   = mysql_select_db("pooree-db");
 
		$sql = "SELECT name, street_address, city, state, open, close, id FROM taphouse";
		$res = mysql_query($sql);
		if(!$res) {
			die("invalid: ".mysql_error());
		}
		$result = array();
 
		while( $row = mysql_fetch_array($res)) {
			$open_time=strtotime($row[4]); 
            $format_open=date("g:i A", $open_time);
              
            $close_time=strtotime($row[5]);
            $format_close=date("g:i A", $close_time);

		    array_push($result, array('name' => $row[0], 'street_address' => $row[1], 'city' => $row[2], 'state' => $row[3], 'open' => $format_open, 'close' => $format_close, 'id' => $row[6]));
		}
 
		echo json_encode(array("result" => $result));
?>