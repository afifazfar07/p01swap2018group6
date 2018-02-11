<link rel="stylesheet" href="stylesheet.css" >
<?php
date_default_timezone_set('Asia/Singapore');
error_reporting(0);
$si=$_POST['s_i'];
$ii=$_POST['i_i'];
session_start();
$v= $_SESSION["Name"];
if ($si != "" && $ii != "" && $v == "auditor")
{


$DB_USER = 'auditor';
$DB_PASSWORD = 'auditor';
$DB_HOST = 'localhost';
$DB_NAME = 'SWAP';

try {

$dbc = new PDO('mysql:host=localhost; dbname=SWAP', $DB_USER,$DB_PASSWORD);

 

$query= $dbc->prepare('SELECT * FROM audit_table WHERE auditid = :auditid ');



$query->execute([ ':auditid' => $si ]);
$response = 1;
if ($result = $query->fetch()){
	echo 'edition begins <br />';
	$query= $dbc->prepare("UPDATE audit_table SET comments = :comm WHERE auditid = :aid ");

			$query->bindParam(':comm', $ii);
			$query->bindParam(':aid', $si);
			$query->execute();
} else {



$response = 0;
}

} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}



if($response != 0){
	
	echo 'Audit Updated'."<br>";
	mysqli_close($dbc);
	$DB_USER='auditor';
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
	$in = "Auditor:";	 	
	$in .= "$lid";	
	$in .= " has inserted/edited comment of audit log ";
 	$in .= "$si";
 
	$query = "INSERT INTO audit_table (dtime,info) VALUES ('{$cdate}','{$in}') ";

	$response = $dbc->query($query);

	if($response){
		echo ' Editing will be recorded ';
		echo ' <div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="auditordisplay.php" > Return </a></li> </ul> <div> ';
		mysqli_close($dbc);
		die();
	} else {
		echo ' Error occured,  issues encountered. ';
		echo("Error description: " . mysqli_error($dbc));
	}
} else {
	echo ' Error occured, wrong/non-existant audit id entered. ';
	echo ' <div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="auditordisplay.php" > Return </a></li> </ul> <div> ';
		
		die();
}





} else {
	echo "You have entered an empty record in one of the fields. Or you do not have permission";
}
?>

