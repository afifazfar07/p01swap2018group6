<?php
error_reporting(0);
session_start();
$status=$_SESSION["Login"];

if ( $status != "" ) {

$time = $_SERVER['REQUEST_TIME'];
$timeout_duration = 300;

if (isset($_SESSION['LAST_ACTIVITY']) && 
   ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {

    echo 'Your Session has timed out!';
    echo '<div>
<ul style="list-style-type:none;">
<li style=" display:inline; "><a style = "border-right:solid 10px #f4f4f4;" href="logout.php" > Logout </a></li>';
	
} else {

echo'
<html>
<link rel="stylesheet" href="stylesheet.css" >
<body>
<h1 style="display:block;
    font-size:2em;
    margin-top:0.67em;
    margin-bottom:0.67em;
    margin-left:270;
    margin-right:0;
    font-weight:bold;"> Change Password Page </h1>

	<form action="changepw.php" method="post">
	<fieldset style="width:700px">
	<legend>Edit Your Password</legend>
    
	<p>Old User ID:
    <input type="password" name="s_i" size="30" value="" /> 
	</p>
	
	<p>Old Password:
    <input type="password" name="i_i" size="30" value="" /> 
	</p>
	
	<p>New Password:
    <input type="password" name="i_r" size="30" value="" /> 
	</p>

	<p>
		<input type="submit" name="submit" value="send" />
	</p>
	</fieldset>
</form>
</div>
	
<div>
<button onclick="goBack()">Go Back</button>

<script>
function goBack() {
    window.history.back();
}
</script>
</div>

</body>
</html>
';

}

} else {
 echo 'You do not have the priviledges to access this page';
}
?>
