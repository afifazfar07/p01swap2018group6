<?php
date_default_timezone_set('Asia/Singapore');
error_reporting(0);
session_start();
$status=$_SESSION["Name"];

if ( $status == "auditor" ) {

$time = $_SERVER['REQUEST_TIME'];
$timeout_duration = 300;

if (isset($_SESSION['LAST_ACTIVITY']) && 
   ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {

    echo 'Your Session has timed out!';
    echo '<link rel="stylesheet" href="stylesheet.css" >
<div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="logout.php" > Logout </a></li>';
	
} else {

$_SESSION['LAST_ACTIVITY'] = $time;


echo'

<html>
<link rel="stylesheet" href="stylesheet.css" >
<body>
<h1 style="display:block;
    font-size:2em;
    font-weight:bold;"> Auditor Page </h1>
	
<div style="display:inline-block; width:340px; " align="center">	
<form action="auditordisplay.php" method="post">
<fieldset>
<legend> Display Audit log Data:  </legend>';


$DB_USER = 'auditor';
$DB_PASSWORD = 'auditor';
$DB_HOST = 'localhost';
$DB_NAME = 'SWAP';


$dbc = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
if ($dbc->connect_error)
  {
  die("Failed to connect to MySQL: " . $conn->connect_error);
  }

$query= "SELECT auditid,dtime,info,comments FROM audit_table";

$response = $dbc->query($query);

if($response){

	echo '<table align="left"
	cellspacing="5" cellpadding="8"
	
	<tr><th align="left"><b>Audit ID</b></th>
	<th align="left"><b>Audit Date</b></th>
	<th align="left"><b>Audit Info</b></th>
	<th align="left"><b>Audit Comments</b></th></tr>';

	while($row = mysqli_fetch_array($response)){
		$itemidd = htmlspecialchars($row['auditid']);
		$itempd = htmlspecialchars($row['dtime']);
		$itemnd = htmlspecialchars($row['info']);
		$itemc = htmlspecialchars($row['comments']);

		echo '<tr><td align="left">' .
		$itemidd . '</td><td align="left">' .
		$itempd . '</td><td align="left">' .
		$itemnd . '</td><td align="left">' .
		$itemc  ;
		
		echo '</tr>';
	}
	echo '</table>';
	
	
	}else {
		echo "Couldnt issue db query";
		echo mysqli_error($dbc);
	}
	mysqli_close($dbc);


echo '
<p style="padding: 0.2cm 1cm 0.4cm 1cm;">
Click here:
<input type="submit" />
</p>
</fieldset>
</form>
</div>

<div style=" width:400px;  " align="center">
<form action="editauditor.php" method="post">
	<fieldset style="width:700px">
	<legend>Input/Edit a Comment</legend>
    
	<p>Audit ID:
    <input type="text" name="s_i" size="30" value="" /> 
	</p>
	
	<p>New Comment:
    <input type="text" name="i_i" size="30" value="" /> 
	</p>

	
	<p>
		<input type="submit" name="submit" value="send" />
	</p>
	</fieldset>
</form>
</div>

<div style=" width:400px;  " align="center">
<form action="auddelete.php" method="post">
	<fieldset style="width:700px">
	<legend>Delete a Comment </legend>
    
	<p>Audit ID:
    <input type="text" name="st_i" size="30" value="" /> 
	</p>
	

	

	<p>
		<input type="submit" name="submit" value="send" />
	</p>
	</fieldset>
</form>
</div>


<div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="logout.php" > Logout </a></li>
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="displayuserdat.php"> User Data <a/></li>
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="changepwp.php"> Change Password <a/></li>
</ul>
</div>




</body>
</html>

';
}

} else {
 echo 'You do not have the priviledges to access this page';
}
?>
