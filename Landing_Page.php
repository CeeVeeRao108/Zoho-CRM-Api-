<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StartUp Talky</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
<div class="container">  
  <form id="contact" action="" method="post">
    
    <h4>Enter Lead Information</h4>
    <fieldset>
      <input placeholder="Enter The copied code here" type="text" tabindex="1" name="pass" required >
    </fieldset>
    <fieldset>
      <input placeholder="Your first name" type="text" tabindex="1" name="firstname" required >
    </fieldset>
    <fieldset>
      <input placeholder="Your last name" type="text" tabindex="1"name="lastname" required >
    </fieldset>
    <fieldset>
      <input placeholder="Your Email Address" type="email" tabindex="2"name="email" required>
    </fieldset>
    <fieldset>
      <input placeholder="Your Phone Number " type="tel" tabindex="3"name="phonenumber" required>
    </fieldset>

    <fieldset>
      <button name="submit" type="submit" id="contact-submit" onClick="myfunc()">Submit</button>
    </fieldset>
    <?php 
    global $pass;
    $pass=$_POST['pass'];
    $Firstname=$_POST['firstname'];

    $lastname = $_POST['lastname'];
    
    $email =$_POST['email'];
    
     $phone =$_POST['phonenumber'];
     echo "Note:To insert multiple values , kindly refresh.";
     insert_record($Firstname,$lastname,$email,$phone);
     



function insert_record($firstname,$lastname,$email,$phone)
{
	
	$handle = fopen("token.txt", "r");
	
if ($handle) {
    while (($line = fgets($handle)) !== false) {
         $access_token = $line;
    }

    fclose($handle);
} else {
    
} 
	
	$postdata = [

    "data" => [
        [
            "Company" => "NA",
            "Last_Name" => $lastname,
            "First_Name" => $firstname,
            "Email" => $email,
            "Phone" => $phone
       ]
    ],
    "trigger" => [
        "approval",
        "workflow",
        "blueprint"
    ]
];
	
	$ch = curl_init();
	
	curl_setopt( $ch, CURLOPT_URL, 'https://www.zohoapis.in/crm/v2/Leads');
	
	curl_setopt( $ch, CURLOPT_POST,1);
	
	curl_setopt( $ch,  CURLOPT_POSTFIELDS, json_encode($postdata));
	
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
	
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
	
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Authorization: Zoho-oauthtoken '.$access_token,'content-type:application/x-www-form-urlencoded'));
	
	$response = curl_exec($ch);
	
	$response = json_decode($response);
	
	if(isset($response->data)){
		
				if($response->data[0]->status == 'success')
				{

				return $response->data[0];

				}
	
	}
	
	if(isset($response->code))
	{
	
		if($response->code == 'AUTHENTICATION_FAILURE')
		{
			 
			 generate_access_token();
			 
			 $result = insert_record($firstname,$lastname,$email,$phone);
			 
			  if ($result !== null) {
                return $result;
             } 
		}
	

		if($response->code == 'INVALID_TOKEN')
		{
	
		  generate_access_token();
		
		   $result = insert_record($firstname,$lastname,$email,$phone);
		  
		  if ($result !== null) {
                return $result;
            } 
		
		
		}
		
		return null;
	
	}
	
	echo "<pre>";
	print_r($response);
	
	

	

}


     
	   


		
	
		
		
	
function generate_access_token()
{
	
	$post = [
	'refresh_token' => $GLOBALS['pass'] ,
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
	
	file_put_contents("token.txt", $response->access_token);
	
	
	

}
    ?>
  </form>
</div>
</body>
</html>