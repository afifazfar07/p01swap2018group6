<html>
<link rel="stylesheet" href="stylesheet.css" >
<body>
<?php
error_reporting(0);
$secretkey = "6LdUy0MUAAAAAAsZ7Joa_GCchNpIkLhcN2aLEpnR";
$responsekey = $_POST['g-recaptcha-response'];
$userIP = $_SERVER['REMOTE_ADDR'];
$url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$responsekey&remoteip=$userIP";

$response = file_get_contents($url);
$response = json_decode($response);

if ($response->success) {

echo "Verification completed!";

date_default_timezone_set('Asia/Singapore');
$h_i=$_POST['hi'];
$hwd=$_POST['h_w'];
if ($h_i != ""  )
{



$DB_USER='dbreader';
$DB_PASSWORD = 'dbpw';

try {

$dbc = new PDO('mysql:host=localhost; dbname=SWAP', $DB_USER,$DB_PASSWORD);

 

$query= $dbc->prepare('SELECT * FROM usertable WHERE userid = :userid ');



$query->execute([ ':userid' => $_POST['hi']]);

while ($result = $query->fetch()){
	$pws = $result['passwd'];

	if ( $pws == $hwd) {
	$response = $result['name'];
	} else {
	if(password_verify($hwd,$pws)) {
	echo "Password is correct!";
	

	$response = $result['name'];
	
	} 
	}
}



} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}
$cdate = date('Y-m-d H:i:s');# 2017-11-22 03:42:29
$pwc=$response;

if(is_string($pwc) ){


	if($pwc == 'auditor'){
	#AUDITOR SECTION
	echo 'Correct Auditor Password entered'."<br>";
	$dbc = null;
	# SENDS LOGIN DATA INTO SESSION
	session_start();
	$_SESSION["Login"] = $h_i;
	$_SESSION["Pass"] = $hwd;
	$_SESSION["Name"] = $pwc;
	echo '<form action="auditordisplay.php" method="GET">
	
	<input type="submit" value="EnterRead" />
	</form>';
	$DB_USER='auditor';
	$DB_PASSWORD = 'auditor';
	$DB_HOST = 'localhost';
	$DB_NAME = 'SWAP';
	$dbc = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
	if ($dbc->connect_error)
	{
	die("Failed to connect to MySQL: " . $conn->connect_error);
	}
 
	$in="Auditor "; 
	$in .= "$h_i";
	$in .= " has logged in.";
 
	$query = "INSERT INTO audit_table (dtime,info) VALUES ('{$cdate}','{$in}') ";

	$response = $dbc->query($query);

	if($response){
	echo ' Login will be recorded '."<br>";
	mysqli_close($dbc);
	} else {
	echo ' Error occured, login issues encountered. ';
	}
	#AUDITOR SECTION ENDS
	}


	else if ($pwc == 'hadmin') {
	echo 'Correct Higher Admin Password entered'."<br>";
	$dbc = null;
	#HADMIN SECTION BEGINS
	
	# SENDS LOGIN DATA INTO SESSION
	session_start();
	$_SESSION["Login"] = $h_i;
	$_SESSION["Pass"] = $hwd;
	$_SESSION["Name"] = $pwc;
	echo '<form action="hauserdat.php" method="GET">

	<input type="submit" value="EnterRead" />
	</form>';
	$DB_USER='auditor';
	$DB_PASSWORD = 'auditor';
	$DB_HOST = 'localhost';
	$DB_NAME = 'SWAP';
	$dbc = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
	if ($dbc->connect_error)
	{
	die("Failed to connect to MySQL: " . $conn->connect_error);
	}
 
	$in="Higher Administrator "; 
	$in .= "$h_i";
	$in .= " has logged in.";
 
	$query = "INSERT INTO audit_table (dtime,info) VALUES ('{$cdate}','{$in}') ";

	$response = $dbc->query($query);

	if($response){
	echo ' Login will be recorded '."<br>";
	mysqli_close($dbc);
	} else {
	echo ' Error occured, login issues encountered. ';
	}
	#HADMINSECTION ENDS
	}
	
	
	else if ($pwc == 'admin') {
	#ADMIN SECTION
	echo 'Correct Admin Password entered'."<br>";
	$dbc = null;
	
	# SENDS LOGIN DATA INTO SESSION
	session_start();
	$_SESSION["Login"] = $h_i;
	$_SESSION["Pass"] = $hwd;
	$_SESSION["Name"] = $pwc;
	echo '<form action="adminpg.php" method="GET">

	<input type="submit" value="EnterRead" />
	</form>';
	$DB_USER='auditor';
	$DB_PASSWORD = 'auditor';
	$DB_HOST = 'localhost';
	$DB_NAME = 'SWAP';
	$dbc = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
	if ($dbc->connect_error)
	{
	die("Failed to connect to MySQL: " . $conn->connect_error);
	}
 
	$in="Administrator "; 
	$in .= "$h_i";
	$in .= " has logged in.";
 
	$query = "INSERT INTO audit_table (dtime,info) VALUES ('{$cdate}','{$in}') ";

	$response = $dbc->query($query);

	if($response){
	echo ' Login will be recorded '."<br>";
	mysqli_close($dbc);
	} else {
	echo ' Error occured, login issues encountered. ';
	}
	#END OF ADMIN SECTION
	} 
	
	else {
	#USER SECTION BEGINS
	echo 'Correct User Password entered'."<br>";
	$dbc = null;
	
	# SENDS LOGIN DATA INTO SESSION
	session_start();
	$_SESSION["Login"] = $h_i;
	$_SESSION["Pass"] = $hwd;
	$_SESSION["Name"] = $pwc;
	echo '<form action="useraccpg.php" method="GET">

	<input type="submit" value="EnterRead" />
	</form>';
	$DB_USER='auditor';
	$DB_PASSWORD = 'auditor';
	$DB_HOST = 'localhost';
	$DB_NAME = 'SWAP';
	$dbc = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
	if ($dbc->connect_error)
	{
	die("Failed to connect to MySQL: " . $conn->connect_error);
	}
 
	$in="User "; 
	$in .= "$h_i";
	$in .= " has logged in.";
 
	$query = "INSERT INTO audit_table (dtime,info) VALUES ('{$cdate}','{$in}') ";

	$response = $dbc->query($query);

	if($response){
	echo ' Login will be recorded '."<br>";
	mysqli_close($dbc);
	} else {
	echo ' Error occured, login issues encountered. ';
	}
	
	#USER SECTION END
	}
	
	
} else {
	echo 'Error occured, wrong password or no password entered.'."<br>";
	$dbc = null;
	echo '<form action="index.php">
	<input type="submit" value="Return" />
	</form>';
}
} else {
echo "Password or User Field is emtpy";
echo '<form action="index.php">
	<input type="submit" value="Return" />
	</form>';
}

} else {

echo "Verification failed!";

} 

?>

</body>
</html>
