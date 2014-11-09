<?php
require '.settings.php';
require 'class.phpmailer.php';
require 'class.smtp.php';


	// FIRST TIME SETUP

	// STEP 1: Create a .settings.php file with an email account's username and password for sending messages and an array of accounts you with to be notified with
	// Example: 
	// $settings = array(
	// 	'EMAIL' => 'myemail@domain.com',
	// 	'PASSWORD' => 'emailpassword',
	// 	'ACCOUNTS' => array(
	// 		'myemail@domain.com',
	// 		'xxxxxxxxxx@phoneprovider.com'
	// 	)
	// );

	// STEP 2: Create a cron job.
	// Example: (in terminal) cronjob -e 
	// 					      */5 * * * * /PATHTOPHP/php /PATHTOTHISSCRIPT/server_status_checker.php
	

$domains = ['']; // Fill with sites to test

$body = '';

foreach($domains as $domain) {
	// Perform a DNS lookup of the site
	$dns_status = dns_get_record($domain);
	$ip = $dns_status[0]['ip'];

	// access the site via HTTP GET request and verify the status code
	$site = fopen('http://' . $domain, 'r');
	$status_code = $http_response_header[0];
	
	if (!$site) {
		$body .= "$domain is down" . PHP_EOL . PHP_EOL;
	} else {
		fclose($site);
	}

	if ($status_code != 'HTTP/1.1 200 OK') {
		$body .= "$domain's status is currently $status_code" . PHP_EOL . "Site IP: $ip" . PHP_EOL . PHP_EOL;
	}
	// send an email/sms message to your cell phone if one of your sites is found down
}

if($body) {
	// Instantiate Class
	$mail = new PHPMailer();
	 
	// Set up SMTP
	$mail->IsSMTP();                // Sets up a SMTP connection
	$mail->SMTPAuth = true;         // Connection with the SMTP does require authorization
	$mail->SMTPSecure = "tls";      // Connect using a TLS connection
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587;
	$mail->Encoding = '7bit';       // SMS uses 7-bit encoding
	 
	// Authentication
	$mail->Username   = $settings['EMAIL']; // Login
	$mail->Password   = $settings['PASSWORD']; // Password
	 
	// Compose
	$mail->Body = $body;       // Body of our message
	 
	// Send To
	foreach($settings['ACCOUNTS'] as $account) {
		$mail->AddAddress($account); // Where to send it
	}
	$mail->send();      // Send!
}
// run the script/check often. Every five minutes is a good standard
// BONUS: confirm both nginx and mysql applications are running and actively listening for connections
