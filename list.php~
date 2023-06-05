<?php

$PAGE	  = $argv[1];
$username = "tyler.franzen@undcsmysql";
$database = "tyler_franzen";
$password = "tyler8629";
$host     = "undcsmysql.mysql.database.azure.com";
$conn     = new mysqli( $host, $username, $password, $database );

if ( $conn->connect_error )
  die( 'Could not connect: ' . $conn->connect_error );

$sql = "SELECT * FROM url LIMIT 500";
$result = $conn->query($sql);

$id = 1;
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo $id . $row["url2"];
    $id++;
  }
} else {
  echo "0 results";
}
$conn->close();


?>
