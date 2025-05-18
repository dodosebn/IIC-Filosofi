<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function clean_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Collect and clean form data
    $name    = clean_input($_POST["name"] ?? '');  
    $email   = filter_var($_POST["email"] ?? '', FILTER_SANITIZE_EMAIL);
    $message = clean_input($_POST["message"] ?? '');

    // Validate required fields
    if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "error";
        exit;
    }

    $to    = "connect@ideaiscapital.com";
    $body  = "You have received a new message from your website contact form:\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Message:\n$message\n";

    $mail = new PHPMailer(true);
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.yandex.com';  
        $mail->SMTPAuth   = true;
        $mail->Username   = 'connect@ideaiscapital.com'; 
        $mail->Password   = 'bufbyx-nyfboxH7'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Set up email headers
        $mail->setFrom('connect@ideaiscapital.com', 'Website Contact Form');
        $mail->addAddress($to);
        $mail->addReplyTo($email, $name);
        $mail->Subject = "New Contact Form Submission"; 
        $mail->isHTML(false);
        $mail->Body    = $body;

        $mail->send();
        echo "success";
    } catch (Exception $e) {
        error_log("Error sending email: " . $e->getMessage());
        echo "error";
    }
} else {
    echo "error";
}

?>
