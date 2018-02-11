<head>
	<link rel="stylesheet" href="stylesheet.css" >
<?php
error_reporting(0);
session_start();
$status=$_SESSION["Name"];

if ( $status == "user" ) {

date_default_timezone_set('Asia/Singapore');

$ii=$_POST['i_i'];
$ir=$_POST['i_r'];
$ia=$_POST['i_n'];
if ( $ii != "" && $ir != "" && $ia != "")
{

$DB_USER = 'user';
$DB_PASSWORD = 'user';
$DB_HOST = 'localhost';
$DB_NAME = 'SWAP';




try {

$dbc = new PDO('mysql:host=localhost; dbname=SWAP', $DB_USER,$DB_PASSWORD);

 

$query= $dbc->prepare('SELECT * FROM itemtable WHERE itemid = :itemid ');



$query->execute([ ':itemid' => $ii ]);
$response = 1;
if ($result = $query->fetch()){
	$query= $dbc->prepare("UPDATE itemtable SET itemp=:itemp,itemn=:itemn WHERE  itemid=:itemid ");
			$query->bindParam(':itemid', $ii);
			$query->bindParam(':itemp', $ir);
			$query->bindParam(':itemn', $ia);
			$query->execute();
} else {

$response = 0;


}

} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}


if($response != 0){
	
	echo 'Stritems Updated'."<br>";
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
	$in .=" has edited item ";
	$in .= "$ii";
 
	$query = "INSERT INTO audit_table (dtime,info) VALUES ('{$cdate}','{$in}') ";

	$response = $dbc->query($query);

	if($response){
		echo ' Editing will be recorded ';
		echo ' <div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="useraccpg.php" > Return </a></li> </ul> <div> ';
		mysqli_close($dbc);
		die();;
	} else {
		echo ' Error occured,  issues encountered. ';
		echo("Error description: " . mysqli_error($dbc));
	}
} else {
	echo ' Error occured, wrong/non-existant item id entered. ';
	echo ' <div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="useraccpg.php" > Return </a></li> </ul> <div> ';
		die();
}





} else {
	echo "You have entered an empty record in one of the fields.";
}

} else {
 echo 'You do not have the priviledges to access this page';
}

?>



