<link rel="stylesheet" href="stylesheet.css" >
<?php
date_default_timezone_set('Asia/Singapore');
error_reporting(0);
$sti=$_POST['st_i'];
session_start();
$status=$_SESSION["Name"];
if ($sti != "" && $status == 'auditor' )
{

$DB_USER = 'auditor';
$DB_PASSWORD = 'auditor';
$DB_HOST = 'localhost';
$DB_NAME = 'SWAP';

try {

$dbc = new PDO('mysql:host=localhost; dbname=SWAP', $DB_USER,$DB_PASSWORD);

 

$query= $dbc->prepare('SELECT * FROM audit_table WHERE auditid = :auditid ');



$query->execute([ ':auditid' => $sti ]);
$response = 1;
if ($result = $query->fetch()){
	echo 'edition begins <br />';
	$query= $dbc->prepare("UPDATE audit_table SET comments = '' WHERE auditid = :aid ");
			$query->bindParam(':aid', $sti);
			$query->execute();
} else {



$response = 0;
}

} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}




if($response != 0){
	echo 'Audit log comment deleted';
	mysqli_close($dbc);
	$cdate = date('Y-m-d H:i:s');

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
	$in = "Auditor:";	 	
	$in .= "$lid";	
	$in .= " has deleted comment of audit log ";
 	$in .= "$sti";
 
	$query = "INSERT INTO audit_table (dtime,info) VALUES ('{$cdate}','{$in}') ";

	$response = $dbc->query($query);

	if($response){
		echo ' Deletion will be recorded ';
		echo ' <div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="auditordisplay.php" > Return </a></li> </ul> <div> ';
		mysqli_close($dbc);
		die();
	} else {
		echo ' Error occured, Time issues encountered. ';
	}
	} else {
		echo 'Error occured, wrong store or item id entered.';
		echo ' <div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="auditordisplay.php" > Return </a></li> </ul> <div> ';
		
		die();
	}


} else {
	echo " You have entered an empty record in either the Store or Item ID ";
	
}
?>


