<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StartUp Talky</title>
</head>
<body>
<form id="contact" action="" method="post">
    <h4>Enter Code</h4>
    <fieldset>
      <input placeholder="Copy the code from api console of zoho" type="text" tabindex="1" name="code" required >
    </fieldset>
    <fieldset>
        <button name="submit" type="submit" id="contact-submit" >Generate Code</button>
      </fieldset>
      <?php 
      
      global $code;
      $code=$_POST['code'];
      
      
     
function generate_refresh_token()
{
	
	$post = [
	'code' => $GLOBALS['code'],
	'redirect_uri' => 'https://localhost/zoho',
	'client_id' => '1000.AKSOH7B47C6XJR9TTF9MLF2KIXCLKX',
	'client_secret' => '515abdfce337c3d2264ea0454a5dd04217d7b596b1',
	'grant_type' => 'authorization_code'
	];
	
	$ch = curl_init();
	
	curl_setopt( $ch, CURLOPT_URL, 'https://accounts.zoho.in/oauth/v2/token');
	
	curl_setopt( $ch, CURLOPT_POST,1);
	
	curl_setopt( $ch,  CURLOPT_POSTFIELDS, http_build_query($post));
	
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
	
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
	
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('content-type:application/x-www-form-urlencoded'));
	
	$response = curl_exec($ch);
	
	echo "<pre>";
	
	

	
	$response = json_decode($response);
	
	global $r1;
	$r1=$response->refresh_token;
	
	 


}





function generate_access_token()
{
	
	$post = [
	'refresh_token' =>$GLOBALS['r1'],
	'client_id' => '1000.AKSOH7B47C6XJR9TTF9MLF2KIXCLKX',
	'client_secret' => '515abdfce337c3d2264ea0454a5dd04217d7b596b1',
	'grant_type' => 'refresh_token'
	];
	
	$ch = curl_init();
	
	curl_setopt( $ch, CURLOPT_URL, 'https://accounts.zoho.in/oauth/v2/token');
	
	curl_setopt( $ch, CURLOPT_POST,1);
	
	curl_setopt( $ch,  CURLOPT_POSTFIELDS, http_build_query($post));
	
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
	
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
	
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('content-type:application/x-www-form-urlencoded'));
	
	$response = curl_exec($ch);
	
	$response = json_decode($response);
	
	echo "<pre>";
	
	
	global $a1;
	$a1=$response->access_token;
	
	
	file_put_contents("token.txt", $response->access_token);
	
	return $response->access_token;
	

}


generate_refresh_token();

generate_access_token();



echo "Copy the following Code: ".$GLOBALS['a1'];
echo "Scroll down and Click proceed";




?>


    </form>

    <form id="contact" action="Landing_Page.php" method="post">
    <button name="submit" type="submit" id="contact-submit" >Proceed</button>
</form>
</body>
</html>