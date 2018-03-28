<?php
require 'vendor/autoload.php';
require 'conf.php';
use Mailgun\Mailgun;
$email = $_POST['email'];
$message = $_POST['message'];
$mgClient = new Mailgun($key);
$result = $mgClient->sendMessage($domain, array(
    'from'    => $email,
    'to'      => $to,
    'subject' => $subject,
    'text'    => $message
));
header('Location: index.html');