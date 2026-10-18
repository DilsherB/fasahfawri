<?php
// Include PHPMailer files if installed via Composer, or use native mail with SMTP configuration
// For Hostinger cPanel, we configure the form to send securely.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and trim input data
    $name = strip_tags(trim($_POST["name"]));
    $company = strip_tags(trim($_POST["company"]));
    $mobile = strip_tags(trim($_POST["mobile"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $service_type = strip_tags(trim($_POST["service_type"]));
    $message = trim($_POST["message"]);

    // Recipient corporate inbox
    $recipient = "customs@fasahfwri.com";
    
    $subject = "New Shipment Request: [$service_type] from $name ($company)";

    // Email body content
    $email_content = "You have received a new inquiry from your website contact form:\n\n";
    $email_content .= "---------------------------------------------------\n";
    $email_content .= "Service Division: $service_type\n";
    $email_content .= "Client Name:      $name\n";
    $email_content .= "Company Name:     $company\n";
    $email_content .= "Mobile Number:    $mobile\n";
    $email_content .= "Email Address:    $email\n";
    $email_content .= "---------------------------------------------------\n\n";
    $email_content .= "Message Details:\n$message\n";

    // Headers configuration
    // Using the user's email as reply-to, and sending from your domain server email
    $headers = "From: web-inquiry@fasahfwri.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Send email using Hostinger's mail server function
    if (mail($recipient, $subject, $email_content, $headers)) {
        // Success alert & redirect back to website
        echo "<script>alert('Your shipment request has been sent successfully! Our team will contact you shortly.'); window.location.href='index.html#contact';</script>";
    } else {
        // Error handling alert
        echo "<script>alert('Sorry, something went wrong while sending your request. Please try calling our direct desk lines.'); window.history.back();</script>";
    }
} else {
    // Direct browser access prevention
    header("Location: index.html");
}
?>