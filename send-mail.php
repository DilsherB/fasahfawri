<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// If you installed via Composer, uncomment the line below:
// require 'vendor/autoload.php';

// If you are using manual PHPMailer files in a folder named 'phpmailer', uncomment these:
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and collect form inputs (adjust field names to match your HTML form if needed)
    $name    = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone   = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        echo "Please fill in all required fields.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings for Microsoft 365 SMTP
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.office365.com';                   
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'customs@fasahfwri.com';                
        $mail->Password   = 'Esl@20#30$40'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           
        $mail->Port       = 587;                                 // TCP port to connect to

        // Recipients
        // Send from your authenticated M365 email (Microsoft restricts 'From' headers to match the authenticated user)
        $mail->setFrom('customs@fasahfwri.com', 'Fasah Fawri Website');
        
        // Where the email should go when you hit "Reply" in Outlook (the customer's email)
        $mail->addReplyTo($email, $name);

        // Where the inquiry notification is sent
        $mail->addAddress('customs@fasahfwri.com', 'Fasah Fawri Customs'); 

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = "New Website Inquiry from: " . $name;
        
        // Email body structure
        $mail->Body    = "
            <h2>New Customs Clearance Inquiry</h2>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Phone:</strong> {$phone}</p>
            <p><strong>Message:</strong><br>{$message}</p>
        ";
        
        $mail->AltBody = "New Inquiry:\nName: {$name}\nEmail: {$email}\nPhone: {$phone}\nMessage: {$message}";

        // Send the email
        $mail->send();
        
        // Redirect back to your index page (or a thank you page)
        header("Location: index.html?status=success");
        exit();
        
        // header("Location: thank-you.html"); // Optional redirect
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    // If someone accesses this file directly via URL
    header("Location: index.html");
    exit;
}
?>