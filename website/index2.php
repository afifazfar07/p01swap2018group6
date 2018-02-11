<?php

$DB_USER='otp';
$DB_PASSWORD = 'otp';
error_reporting(0);

if(!empty($_POST["submit_otp"])) {
session_start();


if ( $_SESSION["key"] != "" && $_SESSION["nonce"] != "") {

try {

$conn = new PDO('mysql:host=localhost; dbname=SWAP', $DB_USER,$DB_PASSWORD);

$query= $conn->prepare('SELECT otp FROM otp_expiry WHERE is_expired!=1 AND NOW() <= DATE_ADD(create_at, INTERVAL 24 HOUR) ');

$query->execute();
$key = random_bytes(SODIUM_CRYPTO_AEAD_AES256GCM_KEYBYTES);
$nonce = random_bytes(SODIUM_CRYPTO_AEAD_AES256GCM_NPUBBYTES);

$response = "";

while ($row = $query->fetch()){
	$otpv = $row['otp'];
	if (sodium_crypto_aead_aes256gcm_is_available()) {
	$otp = $_POST['otp'];
	$key = $_SESSION["key"];    	
	$nonce = $_SESSION["nonce"];

	
    	$ad = '';
	
    	$ciphertext = sodium_crypto_aead_aes256gcm_encrypt(
        $otp,
        $ad,
        $nonce,
        $key
   	 );
	}
	if ( $otpv == $ciphertext ) {
	 $response = "1";
	}	

}




	if(!empty($response)) {
		
session_destroy();
$query= $conn->prepare('UPDATE otp_expiry SET is_expired = 1 WHERE otp = :otp ');

$query->execute([ ':otp' => $_POST['otp']]);


		echo '<p style="color:#31ab00;">OTP SUCCESSFUL</p>';
echo '
<html>
<link rel="stylesheet" href="stylesheet.css" >
<body>
<h1 style="display:block;
    font-size:2em;
   
    font-weight:bold;"> Login Page </h1>

<div style="display:inline-block; width:340px; " align="center">
	<form  action="login.php" method="post">
		<fieldset>
		<legend> Login:  </legend>
    
		<p>User ID:
		<input  type="password" name="hi" size="30" value="" />
		</p> 
	
		<p>Password:
		<input  type="password" name="h_w" size="30" value="" /> 
		</p>
		
		<p>
			<input type="submit" name="submit" value="send" />
		</p>
		<div class="g-recaptcha" data-sitekey="6LdUy0MUAAAAAMmN4JrfjCqin_u1EgPMIU_sdxv4">
		</div>
		</fieldset>
		
	</form>
	<script src="https://www.google.com/recaptcha/api.js"></script> 
</div>
</body>
</html> ';



	} else {
		session_destroy();
		echo "INVALID OTP OR EXPIRED DUE TO DATE!";
	}

	

} catch (PDOException $e) {
print "Error! Something is wrong with the DB Connection!: " . $e->getMessage() . "<br/>";
die();
}

} else {

echo "OTP DATA EXPIRED";

}

} else 

{
echo "You need an OTP to access this page!";
}


?>

