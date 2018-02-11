<link rel="stylesheet" href="stylesheet.css" >
<?php

#KILLS SESSION AND ALL DATA RELATED TO LOGIN INFO
error_reporting(0);
date_default_timezone_set('Asia/Singapore');
$cdate = date('Y-m-d H:i:s');
session_start();

	$DB_USER='auditor';
	$DB_PASSWORD = 'auditor';
	$DB_HOST = 'localhost';
	$DB_NAME = 'SWAP';
	$dbc = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
	if ($dbc->connect_error)
	{
	die("Failed to connect to MySQL: " . $conn->connect_error);
	}
	$in = $_SESSION["Name"];
	$in .= " ";
	$hi = $_SESSION["Login"];
	$in .= "$hi";
	$in .= " has logged out.";
 
	$query = "INSERT INTO audit_table (dtime,info) VALUES ('{$cdate}','{$in}') ";

	$response = $dbc->query($query);

	if($response){
	echo ' Logout will be recorded '."<br>";
	mysqli_close($dbc);
	} else {
	echo ' Error occured, login issues encountered. ';
	}


session_destroy();

echo '<form action="index.php">
	<input type="submit" value="ReturnToOTPPage" />
	</form>';

?>
