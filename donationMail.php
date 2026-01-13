<?php
require __DIR__ . '/vendor/autoload.php'; // Composer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 🔹 Get JSON data from fetch request
$data = json_decode(file_get_contents("php://input"), true);
$name = $data['name'] ?? '';
$email = $data['email'] ?? '';


$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // or your mail server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'jonashvalenciagta@gmail.com'; // customersupport email
    $mail->Password   = 'gfml buxo kvzk otxb';   // Gmail App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('jonashvalenciagta@gmail.com', 'Feedback Support');
    $mail->addAddress($email, $name);

    $mail->Subject = "Asking For Donation - $website";

    $mail->isHTML(true);

    $mail->Body = <<<EOD
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Document Accepted</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
  <p>Hello $name,</p>

  <p>Thank you for trusting our service! If you'd like to help us continue growing, please consider making a donation:</p>

  <p>
    <a href="http://localhost/WEBDEV/donation.php" 
       style="display:inline-block; padding:12px 20px; background-color:#0078D7; color:#fff; text-decoration:none; border-radius:5px; font-weight:bold;">
       💻 Support Us on Desktop
    </a>
  </p>

  <p>
    <a href="http://192.168.100.23/WEBDEV/donation.php" 
       style="display:inline-block; padding:12px 20px; background-color:#28a745; color:#fff; text-decoration:none; border-radius:5px; font-weight:bold;">
       📱 Support Us on Mobile
    </a>
  </p>

  <p>We truly appreciate your kindness!</p>
</body>
</html>
EOD;

    // Plain-text fallback
    $mail->AltBody = "Hello $name,\n\n"
        . "Your document for category '$category' has been accepted.\n\n"
        . "Details:\n$body\n\n"
        . "Thank you for trusting our service!\n\n"
        . "If you'd like to help us continue growing, please consider making a donation:\n"
        . "Desktop: http://localhost/WEBDEV/donation.php\n"
        . "Mobile: http://192.168.100.23/WEBDEV/donation.php\n\n"
        . "We truly appreciate your kindness!";

    // Send
    $mail->SMTPDebug = 3; // or 3 for more detail
    $mail->send();
} catch (Exception $e) {
    error_log("Mailer Error: {$mail->ErrorInfo}");
}