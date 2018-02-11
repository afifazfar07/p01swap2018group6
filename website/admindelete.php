<head>
		<link rel="stylesheet" href="stylesheet.css" >
<?php
date_default_timezone_set('Asia/Singapore');
error_reporting(0);
session_start();
$status=$_SESSION["Name"];

if ( $status == 'admin' ) {
$sti=$_POST['st_i'];

if ($sti != "" ) {

$DB_USER = 'admin';
$DB_PASSWORD = 'admin';
$DB_HOST = 'localhost';
$DB_NAME = 'SWAP';


try {

$dbc = new PDO('mysql:host=localhost; dbname=SWAP', $DB_USER,$DB_PASSWORD);

 

$query= $dbc->prepare('SELECT * FROM storetable WHERE storeid = :storeid ');



$query->execute([ ':storeid' => $sti ]);
$response = 1;
if ($result = $query->fetch()){
	$query= $dbc->prepare("DELETE FROM storetable WHERE storeid = :storeid ");
			$query->bindParam(':storeid', $sti);
			$query->execute();
} else {

$response = 0;


}

} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}

if($response != 0){
	echo 'Item deleted <br>';
	mysqli_close($dbc);
	$cdate = date('Y-m-d H:i:s');# 2017-11-22 03:42:29

	$DB_USER='auditor';
	$DB_PASSWORD = 'auditor';
	$DB_HOST = 'localhost';
	$DB_NAME = 'SWAP';
	$dbc = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
	if ($dbc->connect_error)
	{
	die("Failed to connect to MySQL: " . $conn->connect_error);
	}
	
	$lid = $_SESSION["Login"];
	$in = "Administrator:";	 	
	$in .= "$lid" ;
	$in .=" has deleted store " ;
	$in .= $sti;

 
	$query = "INSERT INTO audit_table (dtime,info) VALUES ('{$cdate}','{$in}') ";

	$response = $dbc->query($query);

	if($response){
		echo ' This deletion will be recorded ';
		echo ' <div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="adminpg.php" > Return </a></li> </ul> <div> ';
		mysqli_close($dbc);
		die();
	} 
	else {
		echo ' Error occured, Time issues encountered. ';
	}
	} 
	else {
		echo 'Error occured, wrong store or item id entered.';
		echo ' <div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="adminpg.php" > Return </a></li> </ul> <div> ';
		die();
	}


} 
else {
	echo " Empty record in Store ID or Item ID ";
	
}

} else {
 echo 'You do not have the priviledges to access this page';
}
?>


