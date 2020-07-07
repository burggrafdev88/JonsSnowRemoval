<?php
//require("phpsqlajax_dbinfo.php");

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

require("connection.php");

//Establish connection object
$connection=mysqli_connect($servername, $username, $password);
if (!$connection) {
  die('Not connected : ' . mysqli_error());
}

// Set the active MySQL database
$db_selected = mysqli_select_db($connection, $dbname);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysqli_error());
}

// Select all the rows in the requests table
$query = "SELECT * FROM request WHERE status=1";
$result = mysqli_query($connection, $query);
if (!$result) {
  die('Invalid query: ' . mysqli_error());
} 

header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<markers>';
$ind=0;
/*Iterate through the rows, printing XML nodes for each. Send info through the parseToXML function - function removes
any special characters.*/
while ($row = @mysqli_fetch_assoc($result)){
  // Add to XML document node
  echo '<marker ';
  echo 'email="' . $row['email'] . '" ';
  echo 'name="' . parseToXML($row['first_name']) . '" ';
  echo 'phone="' . parseToXML($row['phone']) . '" ';
  echo 'street="' . parseToXML($row['street']) . '" ';
  echo 'city="' . parseToXML($row['city']) . '" ';
  echo 'state="' . parseToXML($row['state']) . '" ';
  echo 'zip="' . parseToXML($row['zip']) . '" ';
  echo 'lat="' . $row['lat'] . '" ';
  echo 'lng="' . $row['lng'] . '" '; 
  echo 'requested_completion_date="' . $row['requested_completion_date'] . '" '; 
  echo 'requestId="' . $row['idRequests'] . '" '; 
  echo '/>';
  $ind = $ind + 1;
}

// End XML file
echo '</markers>';

?>  
