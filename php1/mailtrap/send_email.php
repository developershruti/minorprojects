<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'live.smtp.mailtrap.io';   // smtp.mailtrap.io                  // Specify Mailtrap SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'api';  //your_mailtrap_username              // SMTP username
    $mail->Password   = '607b4e4e554d579a64acd5bf169bbf5c'; // your_mailtrap_password             // SMTP password
    $mail->Port       = 2525;                                   // TCP port to connect to

    // Recipients
   // $mail->setFrom('from@example.com', 'Your Name');
    $mail->setFrom('info@kezex.io', 'Kezex');
    //$mail->addAddress('recipient@example.com', 'Recipient Name');     // Add a recipient
	$mail->addAddress('aaaaaaaa@gmail.com', 'testing name');     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Test Email via Mailtrap';
    $mail->Body    = 'This is a test email sent via Mailtrap.';

    //$mail->send(); // uncomment it for testing sksjsjjs
    echo 'Email has been sent successfully!';
} catch (Exception $e) {
    echo "Email could not be sent. Error: {$mail->ErrorInfo}";
}
?>
