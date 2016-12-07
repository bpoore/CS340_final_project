<?php
        $conn = mysql_connect('oniddb.cws.oregonstate.edu', "pooree-db", "jweJE9PtV1AmdsA7");
		$db   = mysql_select_db("pooree-db");
 
		$sql = "SELECT brewery.name, beer.name, beer_on_tap.pintPrice, beer_on_tap.growlerPrice, beer_on_tap.id FROM brewery INNER JOIN beer ON brewery.id=beer.brewery INNER JOIN beer_on_tap ON beer.id=beer_on_tap.beer_id INNER JOIN taphouse ON taphouse.id=beer_on_tap.tap_id WHERE taphouse.id=".$_POST['taphouse_id']."";
		$res = mysql_query($sql);
		if(!$res) {
			die("invalid: ".mysql_error());
		}
		$result = array();
 
		while( $row = mysql_fetch_array($res)) {
		    array_push($result, array('brewery' => $row[0], 'beer' => $row[1], 'pint_price' => $row[2], 'growler_price' => $row[3], 'id' => $row[4]));
		}
 
		echo json_encode(array("result" => $result));
?>