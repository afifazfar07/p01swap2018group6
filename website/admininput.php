<head>
		<link rel="stylesheet" href="stylesheet.css" >
<?php
date_default_timezone_set('Asia/Singapore');
error_reporting(0);
session_start();
$status=$_SESSION["Name"];

if ( $status == 'admin' ) {

$stri=$_POST['str_i'];
$itemi=$_POST['item_i'];
$itempr=$_POST['item_pr'];


if ($stri != "" && $itemi != "" && $itempr != ""  ) {

$DB_USER = 'admin';
$DB_PASSWORD = 'admin';

$DB_HOST = 'localhost';
$DB_NAME = 'SWAP';


try {

$dbc = new PDO('mysql:host=localhost; dbname=SWAP', $DB_USER,$DB_PASSWORD);

 

$query= $dbc->prepare('SELECT * FROM storetable WHERE storeid = :storeid ');



$query->execute([ ':storeid' => $stri ]);
$response = 1;
if ($result = $query->fetch()){
	$response = 0;
} else {


$query= $dbc->prepare("INSERT INTO storetable (storeid,store_address,employee_number) VALUES (:storeid,:straddr,:eno) ");
			$query->bindParam(':storeid', $stri);
			$query->bindParam(':straddr', $itemi);
			$query->bindParam(':eno', $itempr);
			$query->execute();

}

} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}



if($response != 0){
	
	echo ' Addition successful <br>';
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
	$in .= "$lid";	
	$in .= " has added store ";
	$in .= "$stri";
 
	$query = "INSERT INTO audit_table (dtime,info) VALUES ('{$cdate}','{$in}') ";

	$response = $dbc->query($query);

	if($response){
		echo ' This addition will be recorded ';
		echo ' <div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="adminpg.php" > Return </a></li> </ul> <div> ';
		mysqli_close($dbc);
		die();
	} else {
		echo ' Error occured, time issues encountered. ';
	
	}
	
	} else {
		echo ' Error occured, wrong/duplicate store id entered. ';
		echo ' <div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="adminpg.php" > Return </a></li> </ul> <div> ';
		die();
	}
} 

else {
	echo "You have entered an empty record in one of the fields.";
}

} else {
 echo 'You do not have the priviledges to access this page';
}
?>


