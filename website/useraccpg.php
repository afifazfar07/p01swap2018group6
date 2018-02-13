<?php
date_default_timezone_set('Asia/Singapore');
error_reporting(0);
session_start();
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
$status=$_SESSION["Name"];

if ( $status == "user" ) {

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
<head>
	<link rel="stylesheet" href="stylesheet.css" >
<body>
<h1 style="display:block;
   
    font-weight:bold;"> User Page </h1>';

echo '

<div  style="float:left; width:200px; " align="center">
<form action="useraccpg.php" method="post">
<fieldset>
<legend> Display All Data:  </legend>
';

$DB_USER = 'user';
$DB_PASSWORD = 'user';
$DB_HOST = 'localhost';
$DB_NAME = 'SWAP';

$dbc = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
if ($dbc->connect_error)
  {
  die("Failed to connect to MySQL: " . $conn->connect_error);
  }

$query= "SELECT * FROM itemtable";

$response = $dbc->query($query);

if($response){

	echo '<table align="left"
	cellspacing="5" cellpadding="8"
	
	<tr>
	<th align="left"><b>Item ID</b></th>
	<th align="left"><b>Item Price</b></th>
	<th align="left"><b>Item Name</b></th></tr>';

	while($row = mysqli_fetch_array($response)){
		$itemidd = htmlspecialchars($row['itemid']);
		$itempd = htmlspecialchars($row['itemp']);
		$itemnd = htmlspecialchars($row['itemn']);
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



echo'
<p style="padding: 0.08cm 1cm 0.00125cm 1cm;">
Click here to refresh data:
<input type="submit" />
</p>
</fieldset>
</form>
</div>
';

echo'

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div style=" width:350px;  " >
<form action="useraccinputpg.php" method="post">
	<fieldset style="width:300px">
	<legend>Add a new item record </legend>
    
	
	<p>Item ID:
    <input type="text" name="item_i" size="30" value="" /> 
	</p>
	
	<p>Item Price ( < 10 000.00 ):
	<input type="number" step="0.01" min="0" max="10000" name="item_pr" size="30" value="Price < 10 000" />
	</p>
	
	<p>Item Name:
    <input type="text" name="item_na" size="30" value="" /> 
	</p>
	
	<p>
		<input type="submit" name="submit" value="Submit" />
	</p>
	</fieldset>
</form>
</div>

<div style=" width:350px;  " >
<form  action="useraccdelete.php" method="post">
	<fieldset style="width:300px">
    <legend>Delete a item record </legend>
	


	<p>Item ID:
    <input type="text" name="it_i" size="30" value="" /> 
	</p>
	
	
    <p>
		<input type="submit" name="submit" value="Submit" />
	</p>
	</fieldset>
</form>
</div>
<div style=" width:350px;  " >
<form action="useraccedit.php" method="post">
	<fieldset style="width:300px">
	<legend>Edit a item record </legend>
    

	
	<p>Item ID:
    <input type="text" name="i_i" size="30" value="" /> 
	</p>
	
	<p>Item Price ( < 10 000.00 ):
	<input type="number" step="0.01" min="0" max="10000" name="i_r" size="30" value="Price < 10 000" />
   
	</p>
	
	<p>Item Name:
    <input type="text" name="i_n" size="30" value="" /> 
	</p>
	
	<p>
		<input type="submit" name="submit" value="Submit" />
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
