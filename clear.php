<html><body>
<?php

$username = "tyler.franzen@undcsmysql";
$database = "tyler_franzen";
$password = "tyler8629";
$host     = "undcsmysql.mysql.database.azure.com";
$conn     = new mysqli( $host, $username, $password, $database );

if ( $conn->connect_error )
  die( 'Could not connect: ' . $conn->connect_error );

$sql = "DELETE FROM url;";
echo( $sql . "\n" );
if ( $conn->query( $sql ) == TRUE )
  echo "Table url_title deleted successfully";
else
  echo "Error deleting table: " . $conn->error;

$conn->close( );

?>
</body></html>
