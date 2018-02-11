<head>
	<link rel="stylesheet" href="stylesheet.css" >
<?php
error_reporting(0);
session_start();
$status=$_SESSION["Name"];
if ( $status == "user" ) {
date_default_timezone_set('Asia/Singapore');

$iti=$_POST['it_i'];



if ( $iti != "")
{

$DB_USER = 'user';
$DB_PASSWORD = 'user';
$DB_HOST = 'localhost';
$DB_NAME = 'SWAP';



try {

$dbc = new PDO('mysql:host=localhost; dbname=SWAP', $DB_USER,$DB_PASSWORD);

 

$query= $dbc->prepare('SELECT * FROM itemtable WHERE itemid = :itemid ');



$query->execute([ ':itemid' => $iti ]);
$response = 1;
if ($result = $query->fetch()){
	$query= $dbc->prepare("DELETE FROM itemtable WHERE itemid = :itemid ");
			$query->bindParam(':itemid', $iti);
			$query->execute();
} else {

$response = 0;


}

} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}



if($response != 0){
	echo 'Item deleted';
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
	$in = "User:";	 	
	$in .= "$lid";	
	$in .=" has deleted item ";
	$in .= "$iti";
 
	$query = "INSERT INTO audit_table (dtime,info) VALUES ('{$cdate}','{$in}') ";

	$response = $dbc->query($query);

	if($response){
		echo ' Deletion will be recorded ';
		echo ' <div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="useraccpg.php" > Return </a></li> </ul> <div> ';
		mysqli_close($dbc);
		die();
	} else {
		echo ' Error occured, Time issues encountered. ';
	}
	} else {
		echo 'Error occured, wrong/non-existant store or item id entered.';
		echo ' <div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="useraccpg.php" > Return </a></li> </ul> <div> ';
		die();
		
	}


} else {
	echo " You have entered an empty record in either the Store or Item ID fields. ";
	
}

} else {
 echo 'You do not have the priviledges to access this page';
}
?>


