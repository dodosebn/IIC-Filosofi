<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Enable error reporting for debugging (REMOVE in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    function clean_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Collect and clean form data
    $name            = clean_input($_POST["name"] ?? '');
    $surname         = clean_input($_POST["surname"] ?? '');
    $city            = clean_input($_POST["city"] ?? '');
    $gender          = clean_input($_POST["gender"] ?? '');
    $age             = clean_input($_POST["age"] ?? '');
    $mobile          = clean_input($_POST["mobile"] ?? '');
    $email           = filter_var($_POST["email"] ?? '', FILTER_SANITIZE_EMAIL);
    $program         = clean_input($_POST["program"] ?? '');
    $time_preference = clean_input($_POST["time_preference"] ?? '');
    $acting_experience = clean_input($_POST["acting_experience"] ?? '');
    $payment_method  = clean_input($_POST["payment_method"] ?? '');

    // Validate required fields
    if (empty($name) || empty($surname) || empty($city) || empty($gender) || empty($age) || empty($mobile) ||
        empty($email) || empty($program) || empty($time_preference) || empty($acting_experience) || empty($payment_method)) {
        echo "error"; // Return error if required fields are missing
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "error"; // Return error if email format is invalid
        exit;
    }

    // Prepare email content
    $to = "registration@ideaiscapital.com";
    $subject = "Enrollment Request";
    $message = "You have received a new enrollment submission from your landing page:<br><br>";
    $message .= "Name: $name $surname<br>";
    $message .= "City: $city<br>";
    $message .= "Gender: $gender<br>";
    $message .= "Age: $age<br>";
    $message .= "Mobile: $mobile<br>";
    $message .= "Email: $email<br>";
    $message .= "Program: $program<br>";
    $message .= "Time Preference: $time_preference<br>";
    $message .= "Acting Experience: $acting_experience<br>";
    $message .= "Payment Method: $payment_method<br>";

    // Setup PHPMailer
    $mail = new PHPMailer(true);
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.yandex.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'registration@ideaiscapital.com'; 
        $mail->Password   = 'bufbyx-nyfboxH7';  // Replace with actual SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Set up email headers
        $mail->setFrom('registration@ideaiscapital.com', 'Filosofi Registration');
        $mail->addAddress($to);
        $mail->addReplyTo($email, "$name $surname");
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body    = $message;
        $mail->AltBody = strip_tags($message);

        // Send email
        $mail->send();

        // WhatsApp API Call
        $phone = "2349135770064";
        $apiKey = "2838246";
        $whatsapp_message = "Registration On Landing page. Check your email *registration@ideaiscapital.com*";

        $url = "https://api.callmebot.com/whatsapp.php?phone=$phone&text=" . urlencode($whatsapp_message) . "&apikey=$apiKey";

        // Initialize cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // Execute cURL request
        $response = curl_exec($ch);

        // Check if the response was successful
        if ($response === false) {
            throw new Exception("WhatsApp API request failed: " . curl_error($ch));
        }

        curl_close($ch);

        // Redirect to thank-you page
        header("Location: /thank-you.html");
        exit();
    } catch (Exception $e) {
        // Log the error and return a friendly message
        error_log("Error sending email or WhatsApp notification: " . $e->getMessage());
        echo "error";
    }
} else {
    echo "Invalid Request";
}

?>
