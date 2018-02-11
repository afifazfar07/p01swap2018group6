<link rel="stylesheet" href="stylesheet.css" >
<?php
date_default_timezone_set('Asia/Singapore');
error_reporting(0);
session_start();
$status=$_SESSION["Name"];

if ( $status == "user" ) {

date_default_timezone_set('Asia/Singapore');

$itemi=$_POST['item_i'];
$itempr=$_POST['item_pr'];
$itemna=$_POST['item_na'];

if ( $itemi != "" && $itempr != "" && $itemna != "" )
{
# DESIGN TO ENSURE USER LOGIN DATA IS BASED ON SESSION

$DB_USER = 'user';
$DB_PASSWORD = 'user';

$DB_HOST = 'localhost';
$DB_NAME = 'SWAP';



try {

$dbc = new PDO('mysql:host=localhost; dbname=SWAP', $DB_USER,$DB_PASSWORD);

 

$query= $dbc->prepare('SELECT * FROM itemtable WHERE itemid = :itemid ');



$query->execute([ ':itemid' => $itemi ]);
$response = 1;
if ($result = $query->fetch()){
	$response = 0;
} else {


$query= $dbc->prepare("INSERT INTO itemtable (itemid,itemp,itemn) VALUES (:itemid,:itemp,:itemn) ");
			$query->bindParam(':itemid', $itemi);
			$query->bindParam(':itemp', $itempr);
			$query->bindParam(':itemn', $itemna);
			$query->execute();

}

} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}


if($response != 0){
	
	echo ' Addition successful ';
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
	$in .= " has added item ";
	$in .= "$itemi";
 
	$query = "INSERT INTO audit_table (dtime,info) VALUES ('{$cdate}','{$in}') ";

	$response = $dbc->query($query);

	if($response){
		echo ' Addition will be recorded ';
		echo ' <div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="useraccpg.php" > Return </a></li> </ul> <div> ';
		mysqli_close($dbc);
		die();
	} else {
		echo ' Error occured, time issues encountered. ';
	
	}
	
	} else {
		echo ' Error occured, wrong/non-existant/duplicate item id entered.  ';
		echo ' <div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="useraccpg.php" > Return </a></li> </ul> <div> ';
		die();
		
	}
} else {
	echo "You have entered an empty/wrong record in one of the fields.";
}

} else {
 echo 'You do not have the priviledges to access this page';
}
?>


