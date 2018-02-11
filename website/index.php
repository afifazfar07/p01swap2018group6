<?php 
date_default_timezone_set('Asia/Singapore');
error_reporting(0);
function RandomString($length) {
    $randstr = "";
    srand((double) microtime(TRUE) * 1000000);
    //our array add all letters and numbers if you wish
    $chars = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'p',
        'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '1', '2', '3', '4', '5',
        '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 
        'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' , '~','!','@','#','$','%','^','&' );
	


    for ($rand = 0; $rand <= $length; $rand++) {
        $random = rand(0, count($chars) - 1 );
        $randstr .= $chars[$random];
    }
    return $randstr;
}

if (time() > strtotime("09:00:00") && time() < strtotime("23:00:00") ) {

if(!empty($_POST["submit_email"])) {
$success = "";
$error_message = "";

try {

		
		
		$cdate = date('Y-m-d H:i:s');
		// generate OTP

		$otp = RandomString(5);
		// Send OTP


		$expired = 0;
		$email = $_POST["email"];
		$DB_USER = "hadmin";
		$DB_PASSWORD = "hadmin";


try {

$dbc = new PDO('mysql:host=localhost; dbname=SWAP', $DB_USER,$DB_PASSWORD);

 

$query= $dbc->prepare('SELECT * FROM usertable WHERE email = :email ');



$query->execute([ ':email' => $email ]);
$response = 1;
if ($result = $query->fetch()){
	$mail_status = mail($email,"Your OTP","$otp");
} else {

echo "email not found! </br>";

$response = 0;
}

} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}

		
		
		if($mail_status == 1) {
$DB_USER='otp';
$DB_PASSWORD = 'otp';
$conn = new PDO('mysql:host=localhost; dbname=SWAP', $DB_USER,$DB_PASSWORD);			
		
$key = random_bytes(SODIUM_CRYPTO_AEAD_AES256GCM_KEYBYTES);



if (sodium_crypto_aead_aes256gcm_is_available()) {
	echo '<p style="color:#31ab00;">OTP SENT</p>';
    $nonce = random_bytes(SODIUM_CRYPTO_AEAD_AES256GCM_NPUBBYTES);
    $ad = '';
    $ciphertext = sodium_crypto_aead_aes256gcm_encrypt(
        $otp,
        $ad,
        $nonce,
        $key
    );
    $query= $conn->prepare("INSERT INTO otp_expiry (email,otp,is_expired,create_at) VALUES ( :email, :otp, :is_expired, :date) ");
			$query->bindParam(':email', $email);
			$query->bindParam(':otp', $ciphertext);
			$query->bindParam(':is_expired', $expired);
			$query->bindParam(':date', $cdate);
			$query->execute();
	session_start();
	$_SESSION["key"] = $key;
	$_SESSION["nonce"] = $nonce;

}


			
			
		} else {
	echo "Mail sending process failed! Email Does not Exist in Database";
}
} catch (PDOException $e) {
print "Error! Something is Wrong with the DB Connection!: " . $e->getMessage() . "<br/>";
die();
	
}
	
}

echo '
<h1 style="display:block;
    font-size:2em;
   
    font-weight:bold;"> OTP Page </h1>

<link rel="stylesheet" href="stylesheet.css" >
<form name="frmUser" method="post" action="index.php">

		<div class="tableheader">Enter Your Email For OTP </div>
		<div class="tablerow"><input type="password" name="email" placeholder="Email" class="login-input" required></div>
		<div class="tableheader"><input type="submit" name="submit_email" value="Submit" class="btnSubmit"></div>
		
	</div>
</form>';

echo '
<form name="frmUser" method="post" action="index2.php">

			<div class="tblLogin">
		
		<div class="tableheader">Enter OTP</div>
		
			
		<div class="tablerow">
			<input type="password" name="otp" placeholder="One Time Password" class="login-input" required>
		</div>
		<div class="tableheader"><input type="submit" name="submit_otp" value="Submit" class="btnSubmit"></div>
		
		<div class="tableheader">--------------------------------------</div>
		<div class="tableheader">WARNING: Leaving the website or failing authentication will require a resubmission of the email address.</div>
		
		
	</div>
</form> ';

} else {
 echo "Website is shutdown, come again at 9AM!";
}
?>
