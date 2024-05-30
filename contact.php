<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "PHPMailer/Exception.php";
require "PHPMailer/PHPMailer.php";
require "PHPMailer/SMTP.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
    //Create a new PHPMailer instance
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  echo "Must be post request";
  return;
}
$mail = new PHPMailer();
$mail->SMTPDebug = 3;
//Send using SMTP to localhost (faster and safer than using mail()) – requires a local mail server
//See other examples for how to use a remote server such as gmail
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.ionos.com';
$mail->Port = 587;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Username = 'contactform@adammobarek.com';
$mail->Password = 'evanmadeacontactform';
$mail->setFrom('contactform@adammobarek.com', 'User Inquiry');
$mail->addAddress('marlena.bennett03@gmail.com');
$mail->Subject = "New Inquiry from {$_POST['name']}";
$mail->isHTML(false);
$mail->CharSet = 'UTF-8';
$mail->Encoding = 'base64';
$recording = '';
if (isset($_POST['recording-service'])) {
    $recording = "Recording";
}
$production = '';
if (isset($_POST['production-service'])) {
    $production = "Post-Production";
}
$mixing = '';
if (isset($_POST['mixing-service'])) {
    $mixing = "Mixing";
}
$mail->Body =<<<EOT
You have an inquiry from {$_POST['name']} ({$_POST['email']}), based in {$_POST['location']}.

They are interested in:
$recording,$production,$mixing

Their project details are:
{$_POST['message']}

Their budget-per-track is: {$_POST['budget']}

Contact info:
Email: {$_POST['email']}
Phone: {$_POST['phone']}
Referred through: {$_POST['source']}
EOT;
if (!$mail->send()) {
  echo "Something went wrong";
} else {
 echo 'Success!'; 
}
?>