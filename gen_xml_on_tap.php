<?php
require("dbinfo.php");
function parseToXML($htmlStr) 
{ 
$xmlStr=str_replace('<','&lt;',$htmlStr); 
$xmlStr=str_replace('>','&gt;',$xmlStr); 
$xmlStr=str_replace('"','&quot;',$xmlStr); 
$xmlStr=str_replace("'",'&#39;',$xmlStr); 
$xmlStr=str_replace("&",'&amp;',$xmlStr); 
return $xmlStr; 
} 
// Opens a connection to a MySQL server
$connection=mysql_connect ("oniddb.cws.oregonstate.edu", $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}
// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}
// Select all the rows in the markers table
$query = "SELECT * FROM taphouse WHERE 1";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}
header("Content-type: text/xml");
// Start XML file, echo parent node
echo '<markers>';
// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  echo '<marker>';
  echo '<name>'. parseToXML($row['name']) .'</name>';
  echo '<street_address>' . parseToXML($row['street_address']) . '</street_address>';
  echo '<lat>' . $row['lat'] . '</lat>';
  echo '<lng>' . $row['lng'] . '</lng>';
  echo '<beers>';
  $taphouse_id = $row['id'];
  $beer_query = "SELECT beer.name AS beer_name, brewery.name AS brewery_name FROM taphouse INNER JOIN beer_on_tap ON taphouse.id=beer_on_tap.tap_id INNER JOIN beer ON beer.id=beer_on_tap.beer_id INNER JOIN brewery ON beer.brewery=brewery.id WHERE taphouse.id='".$taphouse_id."'";
  $beers = mysql_query($beer_query);
  while($beer = @mysql_fetch_assoc($beers)) {
    echo '<beer>';
    echo '<brewery>' . parseToXML($beer['brewery_name']) . '</brewery>';
    echo '<beer_name>' . parseToXML($beer['beer_name']) . '</beer_name>';
    echo '</beer>';
  } 
  echo '</beers>';
  echo '</marker>';
}
// End XML file
echo '</markers>';
?>
