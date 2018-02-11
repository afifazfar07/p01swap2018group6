<link rel="stylesheet" href="stylesheet.css" >
<?php
date_default_timezone_set('Asia/Singapore');
error_reporting(0);
session_start();
$si=$_POST['s_i'];
$ii=$_POST['i_i'];
$ir=$_POST['i_r'];
$status=$_SESSION["Login"];

if ($si != ""  && $ir != ""  && $status != "")
{
$DB_USER = 'hadmin';
$DB_PASSWORD = 'hadmin';
$DB_HOST = 'localhost';
$DB_NAME = 'SWAP';




try {

$dbc = new PDO('mysql:host=localhost; dbname=SWAP', $DB_USER,$DB_PASSWORD);

 

$query= $dbc->prepare('SELECT * FROM usertable WHERE userid = :userid ');



$query->execute([ ':userid' => $si ]);

while ($result = $query->fetch()){
	$pws = $result['passwd'];

	if ( $pws == $ii) {
	$response = $result['name'];
	} else {
	if(password_verify($ii,$pws)) {
	echo "Password is correct!";
	

	$response = $result['name'];

	} 
	}
}



} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}


if($response){
	echo ' user found <br />';
	
	$saltLength = 22;
	$binarySalt = random_bytes(
		$saltLength
	);


	$salt = substr(
		strtr(
			base64_encode($binarySalt),
			'+',
			'.'
			),
		0,
		$saltLength
	);

	$cost = 10;

	$bcryptSalt = '$2y$' . $cost . '$' . $salt;

	$passwordHash = crypt(
	$ir,
		$bcryptSalt
	);
	

	$query= $dbc->prepare('UPDATE usertable SET passwd = :passwd WHERE userid = :userid ');
	
	$response = $query->execute([ ':userid' => $si , ':passwd' => $passwordHash]);
	
	

	if($response){
		echo ' password updated <br />';
	
	} else {
		echo 'Error occured, wrong store or item id entered.';
		
	}

	
	
	
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
	$sid = $_SESSION["Name"];
	$in = "$sid";	
	$in .= ":"; 	
	$in .= "$lid";	
	$in .= " has edited his/her account password";
 
	$query = "INSERT INTO audit_table (dtime,info) VALUES ('{$cdate}','{$in}') ";

	$response = $dbc->query($query);

	if($response){
		echo ' Edition will be recorded <br />';
		mysqli_close($dbc);
		echo '
<button onclick="goBack()">Go Back</button>
<script>
function goBack() {
    window.history.back();
}
</script>';
	
	die();
	} else {
		echo ' Error occured, time issue encountered ';
		echo("Error description: " . mysqli_error($dbc));
	}
	
	} else {
		echo 'Error occured, wrong user id/password (old) entered. </br>';
		echo 'FAILED CHANGES WILL BE REDIRECTED TO THE OTP PAGE </br>';
;

		echo '<form action="logout.php">
	<input type="submit" value="ReturnToLoginPage" />
	</form>';
	}



	
} else {
	echo "You have entered an empty record in one of the fields. Or the a session has not been started";


}





?>

