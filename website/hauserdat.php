<?php
date_default_timezone_set('Asia/Singapore');
error_reporting(0);
session_start();


$status=$_SESSION["Name"];

if ( $status == 'hadmin' ) {

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

echo '<h1 style="display:block;
    font-size:2em;
    margin-top:0.67em;
    margin-bottom:0.67em;
    margin-left:270;
    margin-right:0;
    font-weight:bold;"> Higher Level Admin Page </h1>';

echo'
<div>
NOTE: for name section, it only refers to roles of users: 
</div>

<div  style="float:left; " align="center">
<form action="hauserdat.php" method="post">
<fieldset>
<legend> Display All User Info:  </legend>
';

$DB_USER = 'hadmin';
$DB_PASSWORD = 'hadmin';
$DB_HOST = 'localhost';
$DB_NAME = 'SWAP';

$dbc = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
if ($dbc->connect_error)
  {
  die("Failed to connect to MySQL: " . $conn->connect_error);
  }

$query= "SELECT userid,name,email FROM usertable";

$response = $dbc->query($query);

if($response){

	echo '<table align="left"
	cellspacing="5" cellpadding="8"
	
	<tr><th align="left"><b>User ID</b></th>
	<th align="left"><b>Role</b></th>
	<th align="left"><b>Email</b></th></tr>';

	while($row = mysqli_fetch_array($response)){
		$itemidd = htmlspecialchars($row['userid']);
		$itempd = htmlspecialchars($row['name']);
		$itemnd = htmlspecialchars($row['email']);

		
		echo '<tr><td align="left">' .
		$itemidd . '</td><td align="left">' .
		$itempd . '</td><td align="left">' .
		$itemnd ;
		
		echo '</tr>';
	}
	echo '</table>';
	
	
	}else {
		echo "Couldnt issue db query";
		echo mysqli_error($dbc);
	}
	mysqli_close($dbc);
  
echo '
<p style="padding: 0.08cm 1cm 0.00125cm 1cm;">
Click to Refresh
<input type="submit" />
</p>
</fieldset>
</form>
</div> ';


echo'
<html>
<link rel="stylesheet" href="stylesheet.css" >
<body>

    


<div style=" width:400px;  " align="center">
<form action="userdbinputpg.php" method="post">
	<fieldset style="width:700px">
	<legend>Add a new User (specify name specifically as "auditor" to signal auditor account.)</legend>
    
	<p>User ID:
    <input type="text" name="s_i" size="30" value="" /> 
	</p>
	
	<p>Email:
    <input type="email" name="e_i" size="30" value="" /> 
	</p>

	<p>Name:
		<select name="i_r" size="4" multiple>
			<option value="user">user</option>
			<option value="hadmin">higher level admin</option>
			<option value="admin">admin</option>
			<option value="auditor">auditor</option>
		</select> 
	</p>

	<p>
		<input type="submit" name="submit" value="send" />
	</p>
	</fieldset>
</form>
</div>

<form action="userdbeditpg.php" method="post">
	<fieldset style="width:700px">
	<legend>Edit a User (Enter the name "auditor" for auditor account)</legend>
    
	<p>User ID:
    <input type="text" name="s_i" size="30" value="" /> 
	</p>
	
	<p>Email:
    <input type="email" name="e_i" size="30" value="" /> 
	</p>
	
	<p>New Name:
    <select name="i_r" size="4" multiple>
			<option value="user">user</option>
			<option value="hadmin">higher level admin</option>
			<option value="admin">admin</option>
			<option value="auditor">auditor</option>
		</select>
	</p>

	<p>
		<input type="submit" name="submit" value="send" />
	</p>
	</fieldset>
</form>
</div>

<form action="userdbdelpg.php" method="post">
	<fieldset style="width:700px">
	<legend>Delete a User </legend>
    
	<p>User ID:
    <input type="text" name="s_i" size="30" value="" /> 
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
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="changepwp.php"> change password <a/></li>
</ul>
</div>	



</body>
</html>
';

}

} else {
 echo 'You do not have the priviledges to access this page Or you have not started a session';
}
?>
