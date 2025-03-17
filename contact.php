<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // If installed via Composer

header('Content-Type: application/json'); // Set JSON response header

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars($_POST["message"]);

    if (!$email) {
        echo json_encode(["status" => "error", "message" => "Invalid email format."]);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Gmail SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sriramkumarbe.77@gmail.com'; // Replace with your Gmail ID
        $mail->Password   = 'yhom btwa xdtu uzjs'; // Use App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Email Details
        $mail->setFrom($email, $name);
        $mail->addAddress('sriramkumarbe.77@gmail.com'); // Your Gmail where messages will be sent
        $mail->addReplyTo($email, $name);

        // Email Content
        $mail->isHTML(false);
        $mail->Subject = "New Work Inquiry from $name";
        $mail->Body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        $mail->send();

        // Return success response
        echo json_encode(["status" => "success", "message" => "Message sent successfully!"]);
    } catch (Exception $e) {
        // Return error response
        echo json_encode(["status" => "error", "message" => "Mail Error: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>
