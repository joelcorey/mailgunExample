<?php 

// Do composer.phar stuff
require '../vendor/autoload.php';
use Mailgun\Mailgun;
use Http\Adapter\Guzzle6\Client;

if ($_POST && isset($_POST['name'], $_POST['email'], $_POST['message'])) {

	// Get rid of silly extra stuff people type in to things
	$adminEmail = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
	$name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
	$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
	$message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS));

	if ($name == "" || $email == "" || $message == "") {
		// More error handling code here
		exit;
	}
}
$subject = 'Hello ' . $name . '!';
// You might wish to take out the admin email form entry, in which case just use the variable here
//$adminEmail = 'me@something.com'; 
$domain = "mg.example.com";

// Instantiate the client.
$client = new Client(); 
$mailgun = new Mailgun('key-goeshere', $client);

// Make the call to the client.
$result = $mailgun->sendMessage("$domain", array(
	'from'    => 'Example <mailgun@mg' . $domain . '>',
    'to'      => $name . ' <' . $email . '>',
    'subject' => $subject,
    'text'    => "The team at Example.com would like to thank you " . $name . ", \n You are truly awesome! We will get back to you as soon as possible!"
    ));

// Rather than batch send or use a mailing list we will use the following
$admins = $mailgun->sendMessage("$domain", array(
	'from'    => 'Example <mailgun@' . $domain . '>',
    'to'      => $adminEmail,
    'subject' => $name . ' has contacted you',
    'text'    => "Name: " . $name . "\nEmail: " . $email . "\nHas contacted you with the following message:\n----\n" . $message
    ));
