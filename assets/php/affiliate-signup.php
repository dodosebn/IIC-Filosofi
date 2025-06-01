<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    function clean_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $name     = clean_input($_POST["author"]);
    $email    = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL); 
    $city     = clean_input($_POST["city"]);
    $phone    = clean_input($_POST["number"]);
    $whatsapp = clean_input($_POST["whatsapp"]);
    // $category = isset($_POST["category"]) ? clean_input($_POST["category"]) : ""; 

    // Validate required fields
    if (empty($name) || empty($email) || empty($city) || empty($phone) || empty($whatsapp)) {
        die("Error: All required fields must be filled.");
    }
    // if (empty($name) || empty($email) || empty($city) || empty($phone) || empty($whatsapp) || empty($category)) {
    //     die("Error: All required fields must be filled.");
    // }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Invalid email address.");
    }

    // Validate category selection
    // $valid_categories = ["Regular", "GenZ", "Influencer"];
    // if (!in_array($category, $valid_categories)) {
    //     die("Error: Invalid category selection.");
    // }

    // Email content
    $to      = "affiliate@ideaiscapital.com";
    $subject = "Affiliate Program Registration";
    $message = "Affiliate Signup Details:\n\n";
    $message .= "Full Name: $name\n";
    $message .= "Email: $email\n";
    $message .= "City: $city\n";
    $message .= "Phone: $phone\n";
    $message .= "WhatsApp: $whatsapp\n";
    // $message .= "Selected Category: $category\n";

    // Setup PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        // $mail->Host = 'smtp.hostinger.com'; 
        $mail->Host = 'smtp.yandex.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'affiliate@ideaiscapital.com'; 
        $mail->Password = 'bufbyx-nyfboxH7';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        // $mail->Port = 465;
        $mail->Port = 587;
        
        
         $mail->SMTPDebug = 3; 
         $mail->Debugoutput = 'html';

        // Email headers
        $mail->setFrom('affiliate@ideaiscapital.com', 'Affiliate Program Registration');
        $mail->addAddress($to);
        $mail->addReplyTo($email, $name);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        // Send email
        if ($mail->send()) {
            // CallMeBot WhatsApp Notification
            $phone = "2349135770064"; 
            $apiKey = "2838246"; 
            $whatsapp_message = "Affiliate Member. Check your email *affiliate@ideaiscapital.com*"; 

            // API URL
            $url = "https://api.callmebot.com/whatsapp.php?phone=$phone&text=" . urlencode($whatsapp_message) . "&apikey=$apiKey";

            // Send request using cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $response = curl_exec($ch);
            curl_close($ch);

            echo "Success: Your signup details have been sent.";
        } else {
            echo "Error: Failed to send email.";
        }
    } catch (Exception $e) {
        echo "Error: Could not send email. " . $mail->ErrorInfo;
    }
} else {
    echo "Error: Invalid request method.";
}

?>
