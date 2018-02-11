<?php
date_default_timezone_set('Asia/Singapore');
error_reporting(0);
session_start();
$status=$_SESSION["Name"];

if ( $status == 'admin' ) {

$time = $_SERVER['REQUEST_TIME'];
$timeout_duration = 300;

if (isset($_SESSION['LAST_ACTIVITY']) && 
   ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {

    echo 'Your Session has timed out!';
    echo '<div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="logout.php" > Logout </a></li>';
	
} else {

$_SESSION['LAST_ACTIVITY'] = $time;


echo'

<html>
<head>
		<link rel="stylesheet" href="stylesheet.css" >
<h1 style="display:block;
    font-size:2em;
   
    font-weight:bold;"> Admin Page </h1>


<div>
NOTE: for Location section, it merely gives a brief description: 
</div>

<div  style="float:left; width:200px; " align="center">
<form action="adminpg.php" method="post">
<fieldset>
<legend> Display All Store Info:  </legend>
';


$DB_USER = 'admin';
$DB_PASSWORD = 'admin';
$DB_HOST = 'localhost';
$DB_NAME = 'SWAP';

$dbc = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
if ($dbc->connect_error)
  {
  die("Failed to connect to MySQL: " . $conn->connect_error);
  }

$query= "SELECT * FROM storetable";

$response = $dbc->query($query);

if($response){

	echo '<table align="left"
	cellspacing="5" cellpadding="8"
	
	<tr><th align="left"><b>Store ID</b></th>
	<th align="left"><b>Location</b></th>
	<th align="left"><b>Employees</b></th></tr>';

	while($row = mysqli_fetch_array($response)){
		$itemidd = htmlspecialchars($row['storeid']);
		$itempd = htmlspecialchars($row['store_address']);
		$itemnd = htmlspecialchars($row['employee_number']);

		echo '<tr><td align="left">' .
		$itemidd . '</td><td align="left">' .
		$itempd . '</td><td align="left">' .
		$itemnd ;
		
		echo '</tr>';
	}
	echo '</table>';
	
	
	}else {
		echo "Could not issue database query";
		echo mysqli_error($dbc);
	}
	mysqli_close($dbc);
  



echo'
Click here:
<input type="submit" />
</p>
</fieldset>
</form>
</div>';

echo '
<br>
<br>
<br>
<br>
<br>

<br>

<div style=" width:350px;  " align="center">
<form action="admininput.php" method="post">
	<fieldset style="width:300px">
	<legend>Add a Store record </legend>
    
	<p>Store ID:
    <input type="text" name="str_i" size="30" value="" /> 
	</p>
	
	<p>Location:
    <input type="text" name="item_i"  size="30"  maxlength="100" value="" /> 
	</p>
	
	<p>Employees:
    <input type="number" min="0" max="100" name="item_pr" size="30" value="" /> 
	</p>
	
	<p>
		<input type="submit" name="submit" value="Add" />
	</p>
	</fieldset>
</form>
</div>

<div style=" width:350px;  " align="center">
<form action="adminedit.php" method="post">
	<fieldset style="width:300px">
	<legend>Edit a store record </legend>
    
	<p>Store ID:
    <input type="text" name="s_i" size="30" value="" /> 
	</p>
	
	<p>Location:
   <input type="text" name="i_i"  size="30"  maxlength="100" value="" />
	</p>

	<p>Employees:
   <input type="number" name="4_i" min="0" max="100" name="item_pr" size="30" value="" /> 
	</p>
	
	<p>
		<input type="submit" name="submit" value="Edit" />
	</p>
	</fieldset>
</form>
</div>

<div style="display:inline-block; width:350px;  " align="center">
<form  action="admindelete.php" method="post">
	<fieldset style="width:300px">
    <legend>Delete a store record </legend>
	
    <p>Store ID:
    <input type="text" name="st_i" size="30" value="" /> 
	</p>
	
    <p>
		<input type="submit" name="submit" value="Delete" />
	</p>
	</fieldset>
</form>
</div>

<div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="logout.php" > Logout </a></li>
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="displayuserdat.php"> User Data <a/></li>
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="changepwp.php"> change password <a/></li>
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
