<link rel="stylesheet" href="stylesheet.css" >
<?php
error_reporting(0);
session_start();

$status=$_SESSION["Login"];

if ( $status != "" ) {
$li  = $_SESSION["Login"];
$pi  = $_SESSION["Pass"];
$DB_USER  = 'dbreader';       
$DB_PASSWORD = 'dbpw';        
$DB_HOST = 'localhost';
$DB_NAME = 'SWAP';

$dbc = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
if ($dbc->connect_error)
  {
  die("Failed to connect to MySQL: " . $conn->connect_error);
  }

$query= "SELECT * FROM usertable WHERE userid='{$li}' ";

$response = $dbc->query($query);

if($response){

	echo '<table align="left"
	cellspacing="5" cellpadding="8"
	
	<tr><th align="left"><b>User ID</b></th>
	
	<th align="left"><b>Role</b></th></tr>';

	while($row = mysqli_fetch_array($response)){
		$id = htmlspecialchars($row['userid']);
		$nd = htmlspecialchars($row['name']);

		
		echo '<tr><td align="left">' .
		$id . '</td><td align="left">' .
		
		$nd ;
		
		echo '</tr>';
	}
	echo '</table>';
	
	
	}else {
		echo "Couldnt issue db query";
		echo mysqli_error($dbc);
	}
	mysqli_close($dbc);


} else {
echo "you do not have permission for this page";
}  
?>


