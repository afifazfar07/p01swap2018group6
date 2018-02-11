<link rel="stylesheet" href="stylesheet.css" >
<?php
date_default_timezone_set('Asia/Singapore');
error_reporting(0);
session_start();
$si=$_POST['s_i'];
$ei=$_POST['e_i'];
$ir=$_POST['i_r'];
$status=$_SESSION["Name"];

if ($si != ""  && $ir != ""  && $status == "hadmin")
{
$DB_USER = 'hadmin';
$DB_PASSWORD = 'hadmin';
$DB_HOST = 'localhost';
$DB_NAME = 'SWAP';

try {

$dbc = new PDO('mysql:host=localhost; dbname=SWAP', $DB_USER,$DB_PASSWORD);

 

$query= $dbc->prepare('SELECT * FROM usertable WHERE userid = :userid ');



$query->execute([ ':userid' => $si ]);
$response = 1;
if ($result = $query->fetch()){
	$response = 0;
} else {


$query= $dbc->prepare("INSERT INTO usertable (userid,passwd,name,email) VALUES (:userid,'',:name,:email) ");
			$query->bindParam(':userid', $si);
			$query->bindParam(':email', $ei);
			$query->bindParam(':name', $ir);
			$query->execute();

}

} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}

if($response != 0){
	echo ' User Added Into Database <br />';

	
	$DB_USER = 'auditor';
	$DB_PASSWORD = 'auditor';
	$DB_HOST = 'localhost';
	$DB_NAME = 'SWAP';

	$dbc = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
	if ($dbc->connect_error)
	{
	die("Failed to connect to MySQL: " . $conn->connect_error);
	}
	$cdate = date('Y-m-d H:i:s');# 2017-11-22 03:42:29

	$lid = $_SESSION["Login"];
	$in = "Higher Administrator:";	 	
	$in .= "$lid";	
	$in .= " has added account ";
	$in .= "$si";
 
	$query = "INSERT INTO audit_table (dtime,info) VALUES ('{$cdate}','{$in}') ";

	$response = $dbc->query($query);

	if($response){
		echo ' Addition will be recorded <br />';
		echo ' <div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="hauserdat.php" > Return </a></li> </ul> <div> ';
		mysqli_close($dbc);
		die();
	} else {
		echo ' Error occured, time issue encountered ';
		echo("Error description: " . mysqli_error($dbc));
	}
	
	} else {
		echo 'Error occured, wrong/duplicate user id entered ';
		echo ' <div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="hauserdat.php" > Return </a></li> </ul> <div> ';
		die();
		
	}





	
} else {
	echo "You have entered an empty record in one of the fields. Or the a session has not been started/given permission to you";
}





?>



